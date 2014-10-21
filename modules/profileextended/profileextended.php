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

if (!defined('_PS_VERSION_'))
	exit;

if (file_exists(dirname(__FILE__) . '/api.php'))
require_once dirname(__FILE__) . '/api.php';
if (file_exists(dirname(__FILE__) . '/BelvgProfileExtended.php'))	
require_once dirname(__FILE__) . '/BelvgProfileExtended.php';

class ProfileExtended extends Module
{

	public function __construct()
	{
		$this->name = 'profileextended';
		$this->tab = 'front_office_features';
		$this->version = '1.0';
		$this->author = 'BelVG';
		$this->need_instance = 0;
		$this->module_key = 'cf9cbcec6dbf9db81c57a6f7117e0db8';

		parent::__construct();
		$this->displayName = $this->l('Profile Extended');
		$this->description = $this->l('User Profile extended grants customers fully functional profiles within Prestashop stores.');
		$this->url = '?tab=AdminModules&configure=profileextended&token='.(isset($_GET['token']) ? $_GET['token'] : '');
	}
	
	public function install()
	{
		$upload_dir = dirname(dirname(dirname(__FILE__))) . '/upload/profile_extended';
			@mkdir($upload_dir, 0777);
		$upload_dir = dirname(dirname(dirname(__FILE__))) . '/upload/profile_extended/avatar';
			if (@mkdir($upload_dir, 0777)){	
				$f = fopen($upload_dir . '/index.php', 'w');
				fclose($f);	
			}
		$upload_dir = dirname(dirname(dirname(__FILE__))) . '/upload/profile_extended/messages';
			if (@mkdir($upload_dir, 0777)){	
				$f = fopen($upload_dir . '/index.php', 'w');
				fclose($f);	
			} 

		Db::getInstance()->Execute("
			CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."belvg_customerprofile_attributes_groups` (
			  `group_id` int(11) NOT NULL AUTO_INCREMENT,
			  `title` varchar(250) NOT NULL,
			  `sort_order` int(11) NOT NULL,
			  `enable` int(11) NOT NULL,
			  PRIMARY KEY (`group_id`)
			) ENGINE="._MYSQL_ENGINE_." DEFAULT CHARSET=utf8;");
		Db::getInstance()->Execute("	
			INSERT INTO `"._DB_PREFIX_."belvg_customerprofile_attributes_groups` (`group_id`, `title`, `sort_order`) VALUES
			(1, 'Avatar', 1);");		
		Db::getInstance()->Execute("
			CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."belvg_customerprofile_attributes` (
			  `attribute_id` int(11) NOT NULL AUTO_INCREMENT,
			  `title` varchar(250) NOT NULL,
			  `type` varchar(200) NOT NULL,
			  `group_id` int(11) NOT NULL,
			  `system` varchar(255) NOT NULL,
			  `sort_order` int(11) NOT NULL,
			  `enable` int(11) NOT NULL,
			  PRIMARY KEY (`attribute_id`)
			) ENGINE="._MYSQL_ENGINE_." DEFAULT CHARSET=utf8;");
		Db::getInstance()->Execute("
			INSERT INTO `"._DB_PREFIX_."belvg_customerprofile_attributes` (`attribute_id`, `title`, `type`, `group_id`, `system`, `sort_order`) VALUES
			(1, 'Avatar', 'image', 1, 'avatar', 1);");
		Db::getInstance()->Execute("
			CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."belvg_customerprofile_entity` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `attribute_id` int(11) NOT NULL,
			  `customer_id` int(11) NOT NULL,
			  `value` varchar(255) NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE="._MYSQL_ENGINE_." DEFAULT CHARSET=utf8;");
		Db::getInstance()->Execute("
			CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."belvg_customerprofile_attributes_values` (
			  `value_id` int(11) NOT NULL AUTO_INCREMENT,
			  `attribute_id` int(11) NOT NULL,
			  `value` varchar(255) NOT NULL,
			  PRIMARY KEY (`value_id`)
			) ENGINE="._MYSQL_ENGINE_." DEFAULT CHARSET=utf8;");			
		Db::getInstance()->Execute("
			CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."belvg_customerprofile_messages` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `customer_id` int(11) NOT NULL,
			  `date` date NOT NULL,
			  `title` varchar(255) NOT NULL,
			  `message` text NOT NULL,
			  `status` int(11) NOT NULL,
			  `type` int(11) NOT NULL,
			  `enable` int(11) NOT NULL,
			  `file` varchar(255) NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE="._MYSQL_ENGINE_." DEFAULT CHARSET=utf8;");	
			
		  $messages_tab = new Tab();
		  $messages_tab->class_name = 'AdminBelvgMessages';
		  $messages_tab->id_parent = Tab::getIdFromClassName('AdminCustomers');
		  $messages_tab->module = $this->name;
		  $languages = Language::getLanguages();
		  foreach ($languages as $language)
			$messages_tab->name[$language['id_lang']] = 'Messages';
		  $messages_tab->add();

		return (parent::install() AND $this->registerHook('customerAccount') AND $this->registerHook('myAccountBlock') AND $this->registerHook('adminCustomers') AND $this->registerHook('header'));
	}
	
	public function uninstall()
	{		

		$idTab = Tab::getIdFromClassName('AdminBelvgMessages');
		if ($idTab)
		{
			$tab = new Tab($idTab);
			$tab->delete();
		}

		Db::getInstance()->Execute("
			DROP TABLE `"._DB_PREFIX_."belvg_customerprofile_attributes`, 
					   `"._DB_PREFIX_."belvg_customerprofile_attributes_groups`, 
					   `"._DB_PREFIX_."belvg_customerprofile_entity`,
					   `"._DB_PREFIX_."belvg_customerprofile_values`,
					   `"._DB_PREFIX_."belvg_customerprofile_messages`;");
			
			return (parent::uninstall() AND $this->unregisterHook('customerAccount') AND $this->unregisterHook('myAccountBlock') AND $this->unregisterHook('adminCustomers') AND $this->unregisterHook('header'));
	}

	public function hookHeader($params)
	{
		Tools::addJS(__PS_BASE_URI__.'modules/profileextended/belvg.attribute.js');
	}
	
	public function hookCustomerAccount($params)
	{ 
		if (!isset($_GET['action'])) $_GET['action'] = '';
		if (!isset($_GET['id'])) $_GET['id'] = '';
		global $smarty, $cookie;
		if ($_GET['action'] == 'read' && (int)$_GET['id'] > 0)
			 Db::getInstance()->Execute('UPDATE '._DB_PREFIX_.'belvg_customerprofile_messages SET status = 0 WHERE id = ' . (int)$_GET['id'] . ' AND type = 1 AND customer_id = ' . $cookie->id_customer);
		$count_new_messages = Db::getInstance()->getValue('SELECT COUNT(*) FROM '._DB_PREFIX_.'belvg_customerprofile_messages WHERE status = 1 AND type = 1 AND customer_id = ' . $cookie->id_customer);
		$smarty->assign('count_new_messages', $count_new_messages);
		return $this->display(__FILE__, 'links.tpl');
	}
	
	public function hookMyAccountBlock($params)
	{
		return $this->hookCustomerAccount($params);
	}	
	
	public function hookAdminCustomers($params)
	{
		$url = '?tab=AdminCustomers&id_customer='.$_GET['id_customer'].'&viewcustomer&token='.$_GET['token'].'&';
		if (!isset($_GET['action'])) $_GET['action'] = '';
		if (!isset($_POST['action'])) $_POST['action'] = '';
		if (!isset($_GET['id'])) $_GET['id'] = '';
		if (!isset($_GET['err'])) $_GET['err'] = '';
		
		if ($_GET['action'] == 'attr_del' && (int)$_GET['id'] > 0)
		{	
			Belvg::deleteAttributeValues((int)$_GET['id'], (int)$_GET['customer']);
			header('Location: '.$url.'&err=no');
		}		
		
		if ($_POST['action'] == 'save' && $_POST['id'])
		{ 
			$error = Belvg::saveAttributeValues($_POST, $_FILES, (int)$_POST['id']);
			if ((int)$error > 0)
				header('Location: '.$url.'err='.$error);
			elseif ($error == '0')
				header('Location: '.$url.'err=no');
		}	

		$output = '<hr><h2>Profile Extended</h2>';
		
			if ((int)$_GET['err'] > 0)
				$output .= '
					<div class="error">
						<img src="../img/admin/error2.png">
						'.(int)$_GET['err'].' error(s)
						<ol>
							<li>File(s) is not valid!</li>
						</ol>
					</div>			
				';
			if ($_GET['err'] == 'no')
				$output .= '
					<div class="conf">
						<img alt="" src="../img/admin/ok2.png">
						Update successful
					</div>			
				';			
		
		$output .= Belvg::getAttributeValuesForm((int)$_GET['id_customer'], $url , __PS_BASE_URI__ . 'img/admin/', false);
		$output .= '<hr>';
		return $output; 
	}	
	
	public function getContent()
	{
		if (!isset($_GET['action'])) $_GET['action'] = '';
		
		if (isset($_POST['edit_group']))
		{
				Belvg::editGroup();
				header('Location: '.$this->url);
		}
		
		if (isset($_POST['edit_attribute']))
		{
				Belvg::editAttribute($this->url);
				header('Location: '.$this->url.'&action=list_attr&id_group='.$_POST['id_group']);
		}
		
		if (isset($_GET['attr_id']) && $_GET['action'] == 'delete_attr' && (int)$_GET['attr_id'] > 0)
		{
				Belvg::deleteAttribute($_GET['attr_id']);
				header('Location: '.$this->url.'&action=list_attr&id_group=' . $_GET['id_group']);
		}
		
		$output = '<h2>Profile Extended</h2>';
		
		if ($_GET['action'] == 'new' || $_GET['action'] == 'edit')
		{
				$output .= Belvg::getEditGroupForm($this->url);
		}
			elseif (isset($_GET['id_group']) && $_GET['action'] == 'delete' && (int)$_GET['id_group'] > 0)
		{
				Belvg::deleteGroup((int)$_GET['id_group']);
				header('Location: '.$this->url);
		}
			elseif (isset($_GET['id_group']) && $_GET['action'] == 'list_attr' && (int)$_GET['id_group'] > 0)
		{
				$output .= Belvg::getAttributeList((int)$_GET['id_group'], $this->url);
		}
			elseif($_GET['action'] == 'attr_edit' || $_GET['action'] == 'attr_new')
		{
				$output .= Belvg::getAttributeForm($_GET['id_attribute'], $_GET['id_group'], $this->url);
		}
			else
		{
				$output .= Belvg::getGroupList($this->url);
		}
		
		return $output;
	}	
	
}
