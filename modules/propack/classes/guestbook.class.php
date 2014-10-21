<?php
/**
 * StorePrestaModules SPM LLC.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://storeprestamodules.com/LICENSE.txt
 *
 /*
 * 
 * @author    StorePrestaModules SPM <kykyryzopresto@gmail.com>
 * @category others
 * @package propack
 * @copyright Copyright (c) 2011 - 2014 SPM LLC. (http://storeprestamodules.com)
 * @license   http://storeprestamodules.com/LICENSE.txt
 */

class guestbook extends Module{
	
	private $_name;
	
	public function __construct(){
		$this->_name = "propack";
		
		$this->initContext();
	}
	
	private function initContext()
	{
	  if (version_compare(_PS_VERSION_, '1.5', '>'))
	    $this->context = Context::getContext();
	  else
	  {
	    global $cookie;
	    $this->context = new StdClass();
	    $this->context->cookie = $cookie;
	  }
	}
	
	public function saveItem($_data){
		
		$cookie = $this->context->cookie;
		$id_lang = intval($cookie->id_lang);
		
		
		$name = $_data['name'];
		$email = $_data['email'];
		$ip = $_SERVER['REMOTE_ADDR'];
		$text_review =  $_data['text_review'];
		
		$sql = 'INSERT into `'._DB_PREFIX_.'blockguestbook` SET
							   `name` = \''.pSQL($name).'\',
							   `email` = \''.pSQL($email).'\',
							   `ip` = \''.pSQL($ip).'\',
							   `message` = \''.pSQL($text_review).'\',
							    `id_shop` = \''.$this->getIdShop().'\',
							   `id_lang` = \''.$id_lang.'\',
							   `date_add` = NULL
							   ';
		$result = Db::getInstance()->Execute($sql);

		if(Configuration::get($this->_name.'gnoti') == 1){
		$cookie = $this->context->cookie;
		
		include_once(dirname(__FILE__).'/../propack.php');
		$obj_propack = new propack();
		$_data_translate = $obj_propack->translateItems();
		$subject = $_data_translate['subject_guestbook'];	
		
		
		/* Email generation */
		$templateVars = array(
			'{email}' => $email,
			'{name}' => $name,
			'{message}' => stripslashes($text_review)
		);
		$id_lang = intval($cookie->id_lang);				
		/* Email sending */
		Mail::Send($id_lang, 'guestbook', $subject, $templateVars, 
			Configuration::get($this->_name.'gmail'), 'Guestbook Form', $email, $name,
			NULL, NULL, dirname(__FILE__).'/../mails/');
		}
		
		
	}
	
	public function getIdShop(){
		$id_shop = 0;
		if(version_compare(_PS_VERSION_, '1.5', '>'))
			$id_shop = Context::getContext()->shop->id;
		return $id_shop;
	} 
	
	
	public function getItems($_data){
		
		$start = $_data['start'];
		$step = $_data['step'];;
		$admin = isset($_data['admin'])?$_data['admin']:null;
		$cookie = $this->context->cookie;
		$id_lang = intval($cookie->id_lang);
		
		if($admin){
			$reviews = Db::getInstance()->ExecuteS('
			SELECT pc.*
			FROM `'._DB_PREFIX_.'blockguestbook` pc
			WHERE pc.`is_deleted` = 0
			ORDER BY pc.`date_add` DESC LIMIT '.$start.' ,'.$step.'');
			
			$data_count_reviews = Db::getInstance()->getRow('
			SELECT COUNT(`id`) AS "count"
			FROM `'._DB_PREFIX_.'blockguestbook` 
			WHERE is_deleted = 0
			');
		}else{
			$reviews = Db::getInstance()->ExecuteS('
			SELECT pc.*
			FROM `'._DB_PREFIX_.'blockguestbook` pc
			WHERE pc.active = 1 AND pc.`is_deleted` = 0 AND
			`id_shop` = \''.$this->getIdShop().'\' AND `id_lang` = \''.$id_lang.'\'
			ORDER BY pc.`date_add` DESC LIMIT '.$start.' ,'.$step.'');
			
			$i=0;
			foreach($reviews as $_item_tmp){
				$date_add = date("d-m-Y H:i:s",strtotime($_item_tmp['date_add']));
				$reviews[$i]['date_add'] = $date_add;
				$i++;
			}
			
			$data_count_reviews = Db::getInstance()->getRow('
			SELECT COUNT(`id`) AS "count"
			FROM `'._DB_PREFIX_.'blockguestbook` 
			WHERE active = 1 AND is_deleted = 0 AND
			`id_shop` = \''.$this->getIdShop().'\' AND `id_lang` = \''.$id_lang.'\'
			');
		}
		 return array('reviews' => $reviews, 'count_all_reviews' => $data_count_reviews['count'] );
	}
	
	public function publish($data){
		$id = $data['id'];
		$sql = 'UPDATE `'._DB_PREFIX_.'blockguestbook` 
	    						SET
						   		active = 1
						   		WHERE id = '.$id.' 
						   ';
		$result = Db::getInstance()->Execute($sql);
	}
	
	public function unpublish($data){
		$id = $data['id'];
		$sql = 'UPDATE `'._DB_PREFIX_.'blockguestbook` 
	    						SET
						   		active = 0
						   		WHERE id = '.$id.' 
						   ';
		$result = Db::getInstance()->Execute($sql);
	}
	
	public function delete($data){
		$id = $data['id'];
		$sql = 'UPDATE `'._DB_PREFIX_.'blockguestbook` 
	    						SET
						   		is_deleted = 1
						   		WHERE id = '.$id.''; 
		$result = Db::getInstance()->Execute($sql);
	}
	
	public function updateItem($data){
		$name = $data['name'];
		$email = $data['email'];
		$message = $data['message'];
		$publish = $data['publish'];
		$id = $data['id'];
		
		$sql = 'UPDATE `'._DB_PREFIX_.'blockguestbook` 
	    						SET `name` = "'.$name.'",
						   			`email` = "'.$email.'",
						   			`message` = "'.$message.'",
									`active` = '.$publish.'			   			 
						   		WHERE id = '.$id.''; 
		Db::getInstance()->Execute($sql);
	}
	
	public function getItem($_data){
		$id = $_data['id'];
		
			$reviews = Db::getInstance()->ExecuteS('
			SELECT pc.*
			FROM `'._DB_PREFIX_.'blockguestbook` pc
			WHERE pc.`is_deleted` = 0 AND pc.`id` = '.$id.'');
			
			
	   return array('reviews' => $reviews);
	}
	
	public function PageNav($start,$count,$step, $_data =null )
	{
		$_admin = isset($_data['admin'])?$_data['admin']:null;
		$page_translate = isset($_data['page'])?$_data['page']:$this->l('Page');
		
		$res = '';
		$product_count = $count;
		$res .= '<div class="pages">';
		$res .= '<span>'.$page_translate.': </span>';
		$res .= '<span class="nums">';
		
		$start1 = $start;
			for ($start1 = ($start - $step*4 >= 0 ? $start - $step*4 : 0); $start1 < ($start + $step*5 < $product_count ? $start + $step*5 : $product_count); $start1 += $step)
				{
					$par = (int)($start1 / $step) + 1;
					if ($start1 == $start)
						{
						
						$res .= '<b>'. $par .'</b>';
						}
					else
						{
							if($_admin){
								$token = $_data['token'];
								$currentIndex = $_data['currentIndex'];
								$token = $_data['token'];
								$res .= '<a href="'.$currentIndex.'&page_g='.($start1 ? $start1 : 0).'&configure='.$this->_name.'&token='.$token.'" >'.$par.'</a>';
							} else {
								$res .= '<a href="javascript:void(0)" onclick="go_page_guestbook( '.($start1 ? $start1 : 0).' )">'.$par.'</a>';
							}
						}
				}
		
		$res .= '</span>';
		$res .= '</div>';
		
		
		return $res;
	}
	
public function getLangISO(){
    	$cookie = $this->context->cookie;
		$id_lang = (int)$cookie->id_lang;
		if($this->isURLRewriting())
			$iso_lang = Language::getIsoById(intval($id_lang))."/";
		else
			$iso_lang = '';
			
    	return $iso_lang;
    	
    }
    
    public function isURLRewriting(){
    	$_is_rewriting_settings = 0;
    	if(Configuration::get('PS_REWRITING_SETTINGS') && Configuration::get($this->_name.'urlrewrite_on') == 1){
			$_is_rewriting_settings = 1;
		} 
		return $_is_rewriting_settings;
    }
	
	
}