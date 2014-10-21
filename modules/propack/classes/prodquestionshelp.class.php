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

class prodquestionshelp extends Module{
	
	private $_is15;
	private $_id_shop;
	private $_name = 'propack';
	private $_id_lang;
	
	public function __construct(){
		if(version_compare(_PS_VERSION_, '1.5', '>')){
			$this->_id_shop = Context::getContext()->shop->id;
			$this->_is15 = 1;
		} else {
			$this->_id_shop = 0;
			$this->_is15 = 0;
		}
		
		$this->initContext();
		
		$cookie = $this->context->cookie;
		$current_language = (int)$cookie->id_lang;
		$this->_id_lang = 	$current_language;
		
	
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
	
	public function countItems($data){
	
		$id_product = $data['id_product'];
		
		if (!Validate::isUnsignedId($id_product))
			die(Tools::displayError());
		
		if (($result = Db::getInstance()->getRow('
		SELECT COUNT(`id`) AS "count"
		FROM `'._DB_PREFIX_.'prodquestions` pc
		WHERE `id_product` = '.(int)($id_product).' AND is_active = 1 
		AND  id_shop = '.$this->_id_shop.' AND id_lang = '.$this->_id_lang.' ' 
		)) === false)
			return false;
		return (int)($result['count']);
	}
	
	public function sendNotification($data = null){
		
		if(Configuration::get($this->_name.'qnoti') == 1){
			$name = $data['name'];
			$text = $data['text'];
			$cookie = $this->context->cookie;
			/* Email generation */
			$templateVars = array(
				'{name}' => $name,
				'{text}' => stripslashes($text)
			);
			$id_lang = intval($cookie->id_lang);	
			/* Email sending */
			
			include_once(dirname(__FILE__).'/../propack.php');
			$obj_propack = new propack();
			$_data_translate = $obj_propack->translateItems();
			$notification_new_q = $_data_translate['notification_new_q']; 
			
			Mail::Send($id_lang, 'question', $notification_new_q, $templateVars, 
				Configuration::get($this->_name.'qmail'), 'Questions Form', NULL, NULL,
				NULL, NULL, dirname(__FILE__).'/../mails/');
		}
		
	}
	
	public function sendNotificationResponse($data = null){
		
		if(Configuration::get($this->_name.'qnoti') == 1){
			$id = $data['id'];
			
			$_data_item_tmp = $this->getItem(array('id'=>$id));
			
			$_data = $_data_item_tmp['items'][0];
			
			$_product_info = $this->getProduct(array('id'=>$_data['id_product']));
			
			$link_obj = new Link();
			$cookie = $this->context->cookie;
			$product_obj = new Product($_data['id_product'],true,$cookie->id_lang);
			$link_product = $link_obj->getProductLink($_data['id_product'],$product_obj->link_rewrite);
			
			//echo "<pre>"; var_dump($link_product); exit;
			
			$name = $_data['name'];
			$question = $_data['question'];
			$response = $_data['response'];
			$email = $_data['email']; 
			foreach($_product_info['product'] as $_item_product){
				$name_product = isset($_item_product['name'])?$_item_product['name']:'';
				
    			//$link_product = isset($_item_product['link'])?$_item_product['link']:'';
			}
			
			$cookie = $this->context->cookie;
			/* Email generation */
			$templateVars = array(
				'{name}' => $name,
				'{question}' => stripslashes($question),
				'{response}' => stripslashes($response),
				'{name_product}' => $name_product,
			    '{link_product}' => $link_product
			);
			
			//echo "<pre>"; var_dump($templateVars); var_dump($email);exit;
					
			/* Email sending */
			include_once(dirname(__FILE__).'/../propack.php');
			$obj_propack = new propack();
			$_data_translate = $obj_propack->translateItems();
			$response_for_q = $_data_translate['response_for_q'];
			
			$id_lang = isset($_data['id_lang'])?$_data['id_lang']:intval($cookie->id_lang);
			
			Mail::Send($id_lang, 'response', $response_for_q, $templateVars, 
				$email, 'Response Form', NULL, NULL,
				NULL, NULL, dirname(__FILE__).'/../mails/');
				
		}
		
	}
	
	public function getInfoAboutCustomer($data=null){
		$id_customer = (int) $data['id_customer'];
		//get info about customer
		$result = Db::getInstance()->GetRow('
	        	SELECT * FROM `'._DB_PREFIX_   .'customer` 
		        WHERE `active` = 1 AND `id_customer` = \''.$id_customer.'\'  
		        AND `deleted` = 0 '.(defined(_MYSQL_ENGINE_)?"AND `is_guest` = 0":"").'
		        ');
		if($result){
		$lastname = $result['lastname'];
		$firstname = $result['firstname'];
		$customer_name = $lastname. " ". $firstname;
		} else {
			include_once(dirname(__FILE__).'/../propack.php');
			$obj_propack = new propack();
			$_data_translate = $obj_propack->translateItems();
			$guest_translate = $_data_translate['guest']; 
		
			$customer_name = $guest_translate;
		}

		return array('customer_name' => $customer_name);
	}
	
	
	public function saveItem($data=null){
		
		$id_product = $data['id_product'];
		$name = $data['name'];
		$email = $data['email'];
		$text = $data['text'];
		
		//insert item
		$sql = 'INSERT into `'._DB_PREFIX_.'prodquestions` SET
						   name = \''.pSQL($name).'\',
						   email = \''.pSQL($email).'\',
						   question = \''.pSQL($text).'\',
						   id_product = '.$id_product.',
						   id_shop = '.$this->_id_shop.',
						   id_lang = '.$this->_id_lang.' 
						   ';
		$result = Db::getInstance()->Execute($sql);
		
	}
	
	public function delete($data){
		$id = $data['id'];
		$sql = 'delete FROM `'._DB_PREFIX_.'prodquestions` 
	    						WHERE id = '.$id.' 
						   ';
	    Db::getInstance()->Execute($sql);
			
	}
	
	public function getItem($_data){
			$id = $_data['id'];
		
			$items = Db::getInstance()->ExecuteS('
			SELECT pc.*
			FROM `'._DB_PREFIX_.'prodquestions` pc
			WHERE pc.`id` = '.$id.'');
			
			
	   return array('items' => $items);
	}
	
	public function updateItem($data){
		
		$id = $data['id'];
		
		$name = $data['name'];
		$question = $data['question'];
		$response = $data['response'];
		$publish = $data['publish'];
		
		// update
		$sql = 'UPDATE `'._DB_PREFIX_.'prodquestions` SET
							   `name` = \''.pSQL($name).'\',
							   `question` = "'.mysql_escape_string($question).'",
							   `response` = "'.mysql_escape_string($response).'",
							   `is_active` = \''.pSQL($publish).'\'
							   WHERE id = '.$id.'
							   ';
		Db::getInstance()->Execute($sql);
		
	}
	
	
	
	public function getItems($data){
		$id_product = isset($data['id_product'])?$data['id_product']:0;
		$start = $data['start'];
		$step = (int)Configuration::get($this->_name.'qperpage_q');
		$admin = isset($data['admin'])?$data['admin']:null;
		$all_products = array();
		if($admin){
			$step = $data['step'];
			$_id_selected_product = isset($data['id_selected_product'])?$data['id_selected_product']:0;
			$sql_condition = '';
			if($_id_selected_product!=0)
			$sql_condition = 'WHERE pc.id_product = '.$_id_selected_product;
			
			$items = Db::getInstance()->ExecuteS('
			SELECT pc.*
			FROM `'._DB_PREFIX_.'prodquestions` pc
			'.$sql_condition.'
			ORDER BY pc.`time_add` DESC LIMIT '.$start.' ,'.$step.'');
			
			$_data_count_items = Db::getInstance()->getRow('
			SELECT COUNT(`id`) AS "count"
			FROM `'._DB_PREFIX_.'prodquestions`   pc
			'.$sql_condition.'
			
			');
			$data_count_items = $_data_count_items['count'];
			
			$result = Db::getInstance()->ExecuteS('
				SELECT DISTINCT `id_product`
				FROM `'._DB_PREFIX_.'prodquestions` pc
				'); 
			$all_products = $result;
			
		} else {
			$items = Db::getInstance()->ExecuteS('
			SELECT pc.*
			FROM `'._DB_PREFIX_.'prodquestions` pc
			WHERE pc.`id_product` = '.(int)($id_product).'
			AND pc.is_active = 1 AND  id_shop = '.$this->_id_shop.' AND id_lang = '.$this->_id_lang.'
			ORDER BY pc.`time_add` DESC LIMIT '.$start.' ,'.$step.'');
			
			$data_count_items = $this->countItems(array('id_product'=>$id_product));
			
				
		}
		 return array('items' => $items, 'count_all_items' => $data_count_items, 'all_products'=>$all_products );
	}
	
	
	public function PageNav($start,$count,$step,$id_product,$_data =null)
	{
		include_once(dirname(__FILE__).'/../propack.php');
		$obj_propack = new propack();
		$_data_translate = $obj_propack->translateItems();
		$page_translate = $_data_translate['page']; 
		
		
		$_admin = isset($_data['admin'])?$_data['admin']:null;
		$res = '';
		$product_count = $count;
		$res .= '<div class="pages" style="margin-top:10px;">';
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
								$currentIndex = $_data['currentIndex'];
								$token = $_data['token'];
								$res .= '<a href="'.$currentIndex.'&configure='.$this->_name.'&page_q='.($start1 ? $start1 : 0).'&token='.$token.'" >'.$par.'</a>';
							} else {
								$res .= '<a href="javascript:void(0)" onclick="go_page_question( '.($start1 ? $start1 : 0).','.$id_product.' )">'.$par.'</a>';
							}
						
						}
				}
		
		$res .= '</span>';
		$res .= '</div>';
		
		return $res;
	}
	
private function getProduct($data){
		
		$id = (int) $data['id'];
		$cookie = $this->context->cookie;
		
		$id_lang = intval($cookie->id_lang);
		$result = Db::getInstance()->ExecuteS('
	            SELECT p.id_product, pl.`link_rewrite`, pl.`name`
	            FROM `'._DB_PREFIX_.'product` p
	            LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (p.`id_product` = pl.`id_product` AND pl.`id_lang` = '.intval($id_lang).')
	            WHERE p.`active` = 1 AND p.`id_product` = '.$id);
		
	    $data_all[] = array();
		foreach($result as $products){
			
			$id_product= isset($products['id_product'])?$products['id_product']:'';
			$link_rewrite= isset($products['link_rewrite'])?$products['link_rewrite']:'';
			$_category= isset($products['category'])?$products['category']:'';
			$_category = htmlspecialchars($_category); 
			//$_ean13= isset($products['ean13'])?$products['ean13']:'';
			$link = new Link();
			$_url = $link->getProductLink($id_product, 
										  $link_rewrite, 
										  $_category 
										  //$_ean13
										  );
		
			
			$_name = isset($products['name'])?$products['name']:'';
			$_name = addslashes($_name);
			$_url = isset($_url)?$_url:'';
			
			$data_all[] = array('link' => $_url, 'name' => $_name);
		
		}
		
		
		
		return array('product' => $data_all);
	}
}