<?php
/*
* 2007-2012 PrestaShop 
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
*         DISCLAIMER   *
* *************************************** */
/* Do not edit or add to this file if you wish to upgrade Prestashop to newer
* versions in the future.
* ****************************************************
* @category   Belvg
* @package    Belvg_UserProfileExtended
* @copyright  Copyright (c) 2010 - 2012 BelVG LLC. (http://www.belvg.com)
* @license    http://store.belvg.com/BelVG-LICENSE-COMMUNITY.txt
*/
//error_reporting(E_ALL | E_STRICT);
include_once(PS_ADMIN_DIR.'/../classes/AdminTab.php');

require_once dirname(__FILE__) . '/BelvgProfileExtended.php';

class AdminBelvgMessages extends AdminTab
{
	public function __construct()
	{
		global $cookie;
		parent::__construct();
		$this->url = '?tab=AdminBelvgMessages&token='.$this->token;
		$admin_uri = explode('/', str_replace('\\', '/', PS_ADMIN_DIR));
		$this->admin_dir = __PS_BASE_URI__ . $admin_uri[count($admin_uri)-1];

		if (isset($_GET['action']) && $_GET['action'] == 'outbox')
		{
			if (isset($_GET['customer'])){
				$cookie->belvg_outbox_customer = (int)$_GET['customer'];
				$cookie->belvg_outbox_page = 0;
			}
			if (isset($_GET['page']) && (int)$_GET['page'] > 0) $cookie->belvg_outbox_page = (int)$_GET['page'];
		}
		elseif (isset($_GET['action']) && $_GET['action'] == 'inbox')
		{
			if (isset($_GET['customer'])){
				$cookie->belvg_inbox_customer = (int)$_GET['customer'];
				$cookie->belvg_inbox_page = 0;
			}
			if (isset($_GET['page']) && (int)$_GET['page'] > 0) $cookie->belvg_inbox_page = (int)$_GET['page'];
		}	
	}

	public function display()
	{		
		$this->renderAction();
	}

	public function menu()
	{
		$output = '
			<ul id="submenu" class="withLeftBorder clearfix">
				<li><a href="'.$this->url.'&action=inbox">'.$this->l('Inbox').'</a></li>
				<li><a href="'.$this->url.'&action=outbox">'.$this->l('Outbox').'</a></li>
				<li><a href="'.$this->url.'&action=new"'.$this->l('>New Message').'</a></li>
			</ul><br>
		';
		$messages = Db::getInstance()->ExecuteS('SELECT * FROM '._DB_PREFIX_.'belvg_customerprofile_messages, '._DB_PREFIX_.'customer 
												 WHERE type = 0 AND status = 1 AND type = 0 AND customer_id = id_customer ORDER BY id DESC');
		if (count($messages)){
			$output .= '
				<h2>'.$this->l('New Inbox Messages').'</h2>
				<table class="table" cellspacing="0" cellpadding="0">
					<thead>
						<th width="50">'.$this->l('ID').'</th>
						<th width="320">'.$this->l('Title').'</th>
						<th width="210">'.$this->l('Customer').'</th>
						<th width="110">'.$this->l('Status').'</th>
						<th width="100">'.$this->l('Date').'</th>
						<th>'.$this->l('Action').'</th>
					</thead>
					<tbody>';
					foreach ($messages as $mess){
						$output .= '
							<tr>
								<td>'.$mess['id'].'</td>
								<td><a href="'.$this->url.'&action=edit&id='.$mess['id'].'&p=">'.$mess['title'].'</a></td>
								<td>'.$mess['firstname'].' '.$mess['lastname'].'</td>
								<td>'.($mess['status'] == '1' ? '<font color="red">'.$this->l('Not read').'</font>' : '<font color="green">'.$this->l('Readed').'</font>').'</td>
								<td>'.$mess['date'].'</td>
								<td>
									<a href="'.$this->url.'&action=new&customer_id='.$mess['id_customer'].'&title='.$mess['title'].'"><img title="Reply" alt="Reply" src="../img/admin/export.gif"></a>
									<a href="'.$this->url.'&action=edit&id='.$mess['id'].'&p="><img title="Read Message" alt="Read Message" src="../img/admin/details.gif"></a>
									<a onclick="if (!confirm(\''.$this->l('Are you sure?').'\')) return false;" href="'.$this->url.'&action=del_mess&id='.$mess['id'].'&customer_id='.$mess['id_customer'].'&p="><img title="Delete Message" alt="Delete Message" src="../img/admin/delete.gif"></a>
								</td>
							</tr>					
						';
					}

				$output .= '</tbody>
				</table>	
			';	
		} else $output .= '<b>'.$this->l('You have no new messages!').'</b>';
		echo $output;
	}
	
	public function renderAction()
	{
		if (!isset($_POST['action'])) $_POST['action'] = '';
		if (!isset($_GET['action'])) $_GET['action'] = '';
		if (!isset($_POST['id'])) $_POST['id'] = '';
		
		if ($_POST['action'] == 'send'){
			Belvg::sendMessage((int)$_POST['customer'], $_POST['title'], $_POST['message'], '1');
			header('Location: '.$this->url.'&err=no&action='.$_POST['p']);
		}
		
		if (isset($_GET['err']) && $_GET['err'] == 'no'){
			echo '<div class="conf">
					<img alt="" src="../img/admin/ok2.png">
					'.$this->l('Update successful').'
				  </div>';
		}
		
		if (isset($_GET['customer_id']) && $_GET['action'] == 'del_mess' && (int)$_GET['id'] > 0 && (int)$_GET['customer_id'] > 0){
			Belvg::deleteMessage((int)$_GET['id'], (int)$_GET['customer_id']);
			header('Location: '.$this->url.'&err=no&action='.$_GET['p']);
		}
		
			switch ($_GET['action']){
				
				case 'new': $this->newMessage(); break;
				case 'edit': if ((int)$_GET['id'] > 0) $this->newMessage(); break;
				case 'inbox': $this->inboxMessage(); break;
				case 'outbox': $this->outboxMessage(); break;
				default: $this->menu(); break;
				
			}
	}
	
	public function newMessage()
	{
		if (!isset($_GET['action'])) $_GET['action'] = '';
		if (!isset($_GET['id'])) $_GET['id'] = '';
		$output = '
			<ul id="submenu" class="withLeftBorder clearfix">
				<li><a href="'.$this->url.'&action=inbox">'.$this->l('Inbox').'</a></li>
				<li><a href="'.$this->url.'&action=outbox">'.$this->l('Outbox').'</a></li>
				<li><a href="'.$this->url.'&action=new"'.$this->l('>New Message').'</a></li>
			</ul><br>
		';
		$customers = Belvg::getCustomers(0);
		if ((int)$_GET['id'] > 0 && $_GET['action'] == 'edit'){
			$message = Db::getInstance()->getRow('SELECT * FROM '._DB_PREFIX_.'belvg_customerprofile_messages, '._DB_PREFIX_.'customer 
												 WHERE customer_id = id_customer AND id = ' . (int)$_GET['id']);
			if ($message['status'] == '1') 
				Db::getInstance()->Execute('UPDATE '._DB_PREFIX_.'belvg_customerprofile_messages SET status = 0 WHERE type = 0 AND id = ' . (int)$_GET['id']);
		}
												 
		if ($_GET['action'] != 'edit') $message['type'] = '1';
		$output .= '
		
			<form autocomplete="off" method="post" action="" onsubmit="if ($(\'#customer\').val() == 0 || $(\'#title\').val() == \'\') return false;">
				<input type="hidden" name="action" value="send">
				<input type="hidden" name="id" value="'.(isset($_GET['id']) && $_GET['action'] == 'edit' ? $message['id'] : 'new').'">
				<input type="hidden" name="p" value="'.(isset($_GET['p']) ? $_GET['p'] : '' ).'">
				<fieldset>
					<legend>
						<img src="../img/admin/tab-customers.gif">
						'.($_GET['action'] != 'edit' ? $this->l('Edit') : $this->l('New')).' '.$this->l('Message').'
					</legend>
					<label>'.$this->l('Title').': '.($_GET['action'] != 'edit' ? '<span style="color:red;">*</span>' : '').' </label>
					<div class="margin-form">
						'.($_GET['action'] != 'edit' ? '<input id="title" type="text" value="'.(isset($message['title']) ? $message['title'] : (isset($_GET['customer_id']) ? ('Re: '.$_GET['title']) : '')).'" name="title" size="50">' : $message['title']).'
					</div>
					<label>'.$this->l('Customer').': '.($_GET['action'] != 'edit' ? '<span style="color:red;">*</span>' : '').' </label>
					<div class="margin-form">';
					if ($_GET['action'] != 'edit'){
						$output .= '<select id="customer" name="customer" style="width:280px">
							<option value="0">'.$this->l('Please select customer...').'</option>';
						foreach ($customers as $customer){
							$output .= '<option '.(isset($message['id_customer'], $_GET['customer_id']) && $customer['id_customer'] == $message['id_customer'] || isset($_GET['customer_id']) && $customer['id_customer'] == $_GET['customer_id'] ? 'selected' : '').' value="'.$customer['id_customer'].'">'.$customer['firstname'].' '.$customer['lastname'].'</option>';
						}
						$output .='	</select>';
					} else {
						$cust = Belvg::getCustomers($message['id_customer']);
						$output .= $cust['firstname']. ' ' .$cust['lastname'];
					}
					$output .= '</div>';						
					$output .= '<label>'.$this->l('Message:').'</label>
					<div class="margin-form">
						'.($_GET['action'] != 'edit' ? '<textarea class="rte" cols="100" rows="10" id="message" name="message">'.(isset($message['message']) ? stripslashes($message['message']) : '').'</textarea>' : (isset($message['message']) ? stripslashes($message['message']) : '')).'
					</div>';
				if (isset($message['file']))
					$output .= '<label>'.$this->l('File:').'</label>
					<div class="margin-form">
						<a href="'.__PS_BASE_URI__.'/upload/profile_extended/messages/'.$message['file'].'">Attachment</a>
					</div>';					
					$output .= '<div class="margin-form space">
						<input class="button" type="button" onclick="location.href=\''.$this->url.'&action='.(isset($_GET['p']) ? $_GET['p'] : '').'\'" name="submitAddcms" value=" '.$this->l('Back').' ">
						'.($_GET['action'] != 'edit' ? '<input class="button" type="submit" name="submitAddcms" value=" '.$this->l('Submit').' ">' : '').'
						
					</div>
				</fieldset>
			</form>
			
			
			<br>
			<script type="text/javascript">	
				var iso = "en" ;
				var pathCSS = "'.__PS_BASE_URI__.'themes/prestashop/css/" ;
				var ad = "'.$this->admin_dir.'" ;
			</script>			
			<script type="text/javascript" src="'.__PS_BASE_URI__.'js/tiny_mce/tiny_mce.js"></script>
			<script type="text/javascript" src="'.__PS_BASE_URI__.'js/tinymce.inc.js"></script>
		';	
		echo $output;
	}
	
	public function inboxMessage()
	{
		$output = '
			<ul id="submenu" class="withLeftBorder clearfix">
				<li><a href="'.$this->url.'&action=inbox">'.$this->l('Inbox').'</a></li>
				<li><a href="'.$this->url.'&action=outbox">'.$this->l('Outbox').'</a></li>
				<li><a href="'.$this->url.'&action=new"'.$this->l('>New Message').'</a></li>
			</ul><br>
		';
		global $cookie;
		
		$order = ' id DESC ';
		if (isset($_GET['sort'], $_GET['sort_type']))
		{
			$cookie->belvg_messages_sort = pSQL($_GET['sort']);
			$cookie->belvg_messages_sort_type = pSQL($_GET['sort_type']);
		}
		if (isset($cookie->belvg_messages_sort, $cookie->belvg_messages_sort_type))
		{
			$order = $cookie->belvg_messages_sort . ' ' . $cookie->belvg_messages_sort_type;
		}		
		
		$count_mess = Db::getInstance()->getValue('SELECT COUNT(*) FROM '._DB_PREFIX_.'belvg_customerprofile_messages, '._DB_PREFIX_.'customer 
												 WHERE type = 0 AND customer_id = id_customer '.
												 ($cookie->belvg_inbox_customer ? ' AND id_customer = '.(int)$cookie->belvg_inbox_customer : ''));

		$count_page = ceil($count_mess / 10);
		$curr_page =((int)$cookie->belvg_inbox_page ? (int)$cookie->belvg_inbox_page : 1);
		
		$select_page = $curr_page * 10 - 10;
		
		$messages = Db::getInstance()->ExecuteS('SELECT * FROM '._DB_PREFIX_.'belvg_customerprofile_messages, '._DB_PREFIX_.'customer 
												 WHERE type = 0 AND customer_id = id_customer '.
												 ($cookie->belvg_inbox_customer ? ' AND id_customer = '.(int)$cookie->belvg_inbox_customer : '').
												 ' ORDER BY '.$order.' LIMIT ' .$select_page. ', 10');
			$output .= '
				<h2>'.$this->l('Inbox Messages').'</h2>
				<select onchange="location.href=\''.$this->url.'&action=inbox&customer=\'+this.value">
					<option value="0">'.$this->l('Select customer...').'</option>';
					foreach (Belvg::getCustomers(0) as $customer){
						$output .= '<option '.($cookie->belvg_inbox_customer==$customer['id_customer'] ? 'selected' : '').' value="'.$customer['id_customer'].'">'.$customer['firstname'].' '.$customer['lastname'].'</option>';
					}
					$output .= '
						</select>
					<br><br>';
			if (count($messages)){
					$output .= '<table class="table" cellspacing="0" cellpadding="0">
						<thead>
							<th width="50">'.$this->l('ID').'</th>
									<th width="320">'.$this->l('Title').'
									<br>
									<a href="'.$this->url.'&action=outbox&sort=title&sort_type=desc">
										<img border="0" src="../img/admin/down.gif"></a>
									<a href="'.$this->url.'&action=outbox&sort=title&sort_type=asc">
										<img border="0" src="../img/admin/up.gif">
									</a>						
								</th>
									<th width="210">'.$this->l('Customer').'
									<br>
									<a href="'.$this->url.'&action=outbox&sort=lastname&sort_type=desc">
										<img border="0" src="../img/admin/down.gif"></a>
									<a href="'.$this->url.'&action=outbox&sort=lastname&sort_type=asc">
										<img border="0" src="../img/admin/up.gif">
									</a>						
								</th>
									<th width="110">'.$this->l('Status').'
									<br>
									<a href="'.$this->url.'&action=outbox&sort=status&sort_type=asc">
										<img border="0" src="../img/admin/down.gif"></a>
									<a href="'.$this->url.'&action=outbox&sort=status&sort_type=desc">
										<img border="0" src="../img/admin/up.gif">
									</a>						
								</th>
									<th width="100">'.$this->l('Date').'
									<br>
									<a href="'.$this->url.'&action=outbox&sort=date&sort_type=desc">
										<img border="0" src="../img/admin/down.gif"></a>
									<a href="'.$this->url.'&action=outbox&sort=date&sort_type=asc">
										<img border="0" src="../img/admin/up.gif">
									</a>						
								</th>
							<th>'.$this->l('Action').'</th>
						</thead>
						<tbody>';
						foreach ($messages as $mess){
							$output .= '
								<tr>
									<td>'.$mess['id'].'</td>
									<td><a href="'.$this->url.'&action=edit&id='.$mess['id'].'&p=inbox">'.$mess['title'].'</a></td>
									<td>'.$mess['lastname'].' '.$mess['firstname'].'</td>
									<td>'.($mess['status'] == '1' ? '<font color="red">'.$this->l('Not read').'</font>' : '<font color="green">'.$this->l('Readed').'</font>').'</td>
									<td>'.$mess['date'].'</td>
									<td>
										<a href="'.$this->url.'&action=new&customer_id='.$mess['id_customer'].'&title='.$mess['title'].'"><img title="Reply" alt="Reply" src="../img/admin/export.gif"></a>
										<a href="'.$this->url.'&action=edit&id='.$mess['id'].'&p=inbox"><img title="Read Message" alt="Read Message" width="16" src="../img/admin/details.gif"></a>
										<a onclick="if (!confirm(\''.$this->l('Are you sure?').'\')) return false;" href="'.$this->url.'&action=del_mess&id='.$mess['id'].'&customer_id='.$mess['id_customer'].'&p=inbox"><img title="Delete Message" alt="Delete Message" src="../img/admin/delete.gif"></a>
									</td>
								</tr>					
							';
						}

					$output .= '</tbody>
					</table><br>
				<b>'.$this->l('Select page').': </b><select onchange="location.href=\''.$this->url.'&action=inbox&page=\'+this.value">';
					for ($i=0;$i<$count_page;$i++)
						$output .= '<option '.($i+1 == $cookie->belvg_inbox_page ? 'selected' : '').' value="'.($i+1).'">'.($i+1).'</option>';
				$output .= '</select>';
			} else $output .= '<h3>No messages</h3>';
			$output .= '<br><br><a href="?tab=AdminBelvgMessages&token='.$this->token.'">
				<img src="../img/admin/arrow2.gif">
				'.$this->l('Back').'
			</a>';
		echo $output;
	}

	public function outboxMessage()
	{ 	
		$output = '
			<ul id="submenu" class="withLeftBorder clearfix">
				<li><a href="'.$this->url.'&action=inbox">'.$this->l('Inbox').'</a></li>
				<li><a href="'.$this->url.'&action=outbox">'.$this->l('Outbox').'</a></li>
				<li><a href="'.$this->url.'&action=new"'.$this->l('>New Message').'</a></li>
			</ul><br>
		';	
		global $cookie;
		
		$order = ' id DESC ';
		if (isset($_GET['sort'], $_GET['sort_type']))
		{
			$cookie->belvg_messages_sort = pSQL($_GET['sort']);
			$cookie->belvg_messages_sort_type = pSQL($_GET['sort_type']);
		}
		if (isset($cookie->belvg_messages_sort, $cookie->belvg_messages_sort_type))
		{
			$order = $cookie->belvg_messages_sort . ' ' . $cookie->belvg_messages_sort_type;
		}
		
		$count_mess = Db::getInstance()->getValue('SELECT COUNT(*) FROM '._DB_PREFIX_.'belvg_customerprofile_messages, '._DB_PREFIX_.'customer 
												 WHERE type = 1 AND customer_id = id_customer '.
												 ($cookie->belvg_outbox_customer ? ' AND id_customer = '.(int)$cookie->belvg_outbox_customer : ''));

		$count_page = ceil($count_mess / 10);
		$curr_page =((int)$cookie->belvg_outbox_page ? (int)$cookie->belvg_outbox_page : 1);
		
		$select_page = $curr_page * 10 - 10;
		
		$messages = Db::getInstance()->ExecuteS('SELECT * FROM '._DB_PREFIX_.'belvg_customerprofile_messages, '._DB_PREFIX_.'customer 
												 WHERE type = 1 AND customer_id = id_customer '.
												 ($cookie->belvg_outbox_customer ? ' AND id_customer = '.(int)$cookie->belvg_outbox_customer : '').
												 ' ORDER BY '.$order.' LIMIT ' .$select_page. ', 10');
		$output .= '
			<h2>'.$this->l('Outbox Messages').'</h2>
				<select onchange="location.href=\''.$this->url.'&action=outbox&customer=\'+this.value">
					<option value="0">Select customer...</option>';
			foreach (Belvg::getCustomers(0) as $customer){
				$output .= '<option '.($cookie->belvg_outbox_customer==$customer['id_customer'] ? 'selected' : '').' value="'.$customer['id_customer'].'">'.$customer['firstname'].' '.$customer['lastname'].'</option>';
			}
			$output .= '
				</select>
			<br><br>
			';
			if (count($messages)){
					$output .= '<table class="table" cellspacing="0" cellpadding="0">
				<thead>
					<th width="50">'.$this->l('ID').'</th>
							<th width="320">'.$this->l('Title').'
							<br>
							<a href="'.$this->url.'&action=outbox&sort=title&sort_type=desc">
								<img border="0" src="../img/admin/down.gif"></a>
							<a href="'.$this->url.'&action=outbox&sort=title&sort_type=asc">
								<img border="0" src="../img/admin/up.gif">
							</a>						
						</th>
							<th width="210">'.$this->l('Customer').'
							<br>
							<a href="'.$this->url.'&action=outbox&sort=lastname&sort_type=desc">
								<img border="0" src="../img/admin/down.gif"></a>
							<a href="'.$this->url.'&action=outbox&sort=lastname&sort_type=asc">
								<img border="0" src="../img/admin/up.gif">
							</a>						
						</th>
							<th width="110">'.$this->l('Status').'
							<br>
							<a href="'.$this->url.'&action=outbox&sort=status&sort_type=asc">
								<img border="0" src="../img/admin/down.gif"></a>
							<a href="'.$this->url.'&action=outbox&sort=status&sort_type=desc">
								<img border="0" src="../img/admin/up.gif">
							</a>						
						</th>
							<th width="100">'.$this->l('Date').'
							<br>
							<a href="'.$this->url.'&action=outbox&sort=date&sort_type=desc">
								<img border="0" src="../img/admin/down.gif"></a>
							<a href="'.$this->url.'&action=outbox&sort=date&sort_type=asc">
								<img border="0" src="../img/admin/up.gif">
							</a>						
						</th>
					<th>'.$this->l('Action').'</th>
				</thead>
				<tbody>';
					foreach ($messages as $mess){
						$output .= '
							<tr>
								<td>'.$mess['id'].'</td>
								<td><a href="'.$this->url.'&action=edit&id='.$mess['id'].'&p=outbox">'.$mess['title'].'</a></td>
								<td>'.$mess['lastname'].' '.$mess['firstname'].'</td>
								<td>'.($mess['status'] == '1' ? '<font color="red">'.$this->l('Not read').'</font>' : '<font color="green">'.$this->l('Readed').'</font>').'</td>
								<td>'.$mess['date'].'</td>
								<td>
									<a href="'.$this->url.'&action=edit&id='.$mess['id'].'&p=outbox"><img title="Read Message" alt="Read Message" src="../img/admin/details.gif"></a>
									<a onclick="if (!confirm(\''.$this->l('Are you sure?').'\')) return false;" href="'.$this->url.'&action=del_mess&id='.$mess['id'].'&customer_id='.$mess['id_customer'].'&p=outbox"><img title="Delete Message" alt="Delete Message" src="../img/admin/delete.gif"></a>
								</td>
							</tr>					
						';
					}

			$output .= '</tbody>
			</table><br>
			<b>'.$this->l('Select page').': </b><select onchange="location.href=\''.$this->url.'&action=outbox&page=\'+this.value">';
				for ($i=0;$i<$count_page;$i++)
					$output .= '<option '.($i+1 == $cookie->belvg_outbox_page ? 'selected' : '').' value="'.($i+1).'">'.($i+1).'</option>';
			$output .= '</select>
			';
			} else $output .= '<h3>No messages</h3>';
			$output .= '<br><br><a href="?tab=AdminBelvgMessages&token='.$this->token.'">
				<img src="../img/admin/arrow2.gif">
				'.$this->l('Back').'
			</a>		
		';	
		echo $output;
	}	
}

