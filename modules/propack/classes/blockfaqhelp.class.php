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

class blockfaqhelp extends Module{
	
	private $_id_shop;
	private $_is15;
	private $_name = 'propack';
	private $_http_host;
	
	public function __construct(){
		if(version_compare(_PS_VERSION_, '1.5', '>')){
			$this->_id_shop = Context::getContext()->shop->id;
			$this->_is15 = 1;
		} else {
			$this->_id_shop = 0;
			$this->_is15 = 0;
		}
		
		if(version_compare(_PS_VERSION_, '1.6', '>')){
			$this->_http_host = Tools::getShopDomainSsl(true, true).__PS_BASE_URI__; 
		} else {
			$this->_http_host = _PS_BASE_URL_.__PS_BASE_URI__;
		}
		
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
	
	public function saveItemFAQ($data=null){
		$cookie = $this->context->cookie;
		$current_language = (int)$cookie->id_lang;
			
			
		$category_id = $data['category'];
		$name = $data['name'];
		$email = $data['email'];
		$text = $data['text'];
		
		#### faq item ####
		
		$sql = 'INSERT into `'._DB_PREFIX_.'faq_item` SET
								`is_by_customer` = 1,
								`is_add_by_customer` = 1,
								`customer_name` = \''.pSQL($name).'\',
								`customer_email` = \''.pSQL($email).'\',
							   `status` = 0,
							   `ids_shops` = \''.$this->_id_shop.'\'
							   ';
		
		Db::getInstance()->Execute($sql);
		
		$insert_id = Db::getInstance()->Insert_ID();
		
		Db::getInstance()->Execute('UPDATE ' . _DB_PREFIX_ . 'faq_item 
							SET order_by = '. $insert_id .' WHERE id = ' . $insert_id);
		
		
		$faq_id = $insert_id;
		
		
		$sql = 'INSERT into `'._DB_PREFIX_.'faq_item_data` SET
							   `id_item` = \''.pSQL($faq_id).'\',
							   `id_lang` = \''.pSQL($current_language).'\',
							   `title` = \''.pSQL($text).'\'
							   ';
		
		$result = Db::getInstance()->Execute($sql);
		
		$sql = 'INSERT into `'._DB_PREFIX_.'faq_category2item` SET
						   `category_id` = \''.pSQL($category_id).'\',
						   `faq_id` = \''.pSQL($faq_id).'\'
						   ';
		Db::getInstance()->Execute($sql);
		
		#### faq item ####
		
		$this->sendNotification(array('name'=>$name, 'text'=>$text));
		
		
	}
	
	
	public function sendNotification($data = null){
		if(Configuration::get($this->_name.'notifaq') == 1){
		
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
				Configuration::get($this->_name.'mailfaq'), 'Questions Form', NULL, NULL,
				NULL, NULL, dirname(__FILE__).'/../mails/');
		}
		
	}
	
	
public function sendNotificationResponse($data = null){
		
	if(Configuration::get($this->_name.'notifaq') == 1){
			$id = $data['id'];
			
			$_data_item_tmp = $this->getItem(array('id'=>$id));
			
			//echo "<pre>"; var_dump($_data_item_tmp['item']);
			$_data = $_data_item_tmp['item'][0];
			
			$data_custom = isset($_data_item_tmp['item']['data'])?$_data_item_tmp['item']['data']:array();
			foreach($data_custom as $_custom){
				
				$name = $_custom['customer_name'];
				$question = $_custom['title'];
				$response = $_custom['content'];
				$email = $_custom['customer_email']; 
				
			}
			$id = $_data['id'];
			
			
			$cookie = $this->context->cookie;

			$_http_host = $this->_http_host;
				
			if(Configuration::get($this->_name.'urlrewrite_on')){
				
				$current_language = (int)$cookie->id_lang;
				$_is_friendly_url = $this->isURLRewriting();
				
				if($_is_friendly_url)
					$_iso_lng = Language::getIsoById(intval($current_language))."/";
				else
					$_iso_lng = '';
					
				$link_question = $_http_host.$_iso_lng.'faq#faq_'.$id;
				
			} else {
				$link_question = $_http_host.'modules/propack/faq.php#faq_'.$id;
			}
			
			
			/* Email generation */
			$templateVars = array(
				'{name}' => $name,
				'{question}' => stripslashes($question),
				'{response}' => stripslashes($response),
				'{link_question}' => $link_question
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
	
	public function getItemsSite($_data = null){
			
			$is_search = isset($_data['is_search'])?$_data['is_search']:0;
			$search = isset($_data['search'])?$_data['search']:'';
			
			$sql_condition = '';
			if($is_search == 1){
				$sql_condition = "AND (
	    		   LOWER(pc_d.title) LIKE BINARY LOWER('%".pSQL(trim($search))."%')
	    		   OR
	    		   LOWER(pc_d.content) LIKE BINARY LOWER('%".pSQL(trim($search))."%')
	    		   ) ";
			}
			
			$_id_selected_category = isset($_data['id_category'])?$_data['id_category']:0;
			$sql_condition_cat = '';
			$sql_condition_cat_where = '';
			if($_id_selected_category!=0){
			$sql_condition_cat = 'left join `'._DB_PREFIX_.'faq_category2item` fc2i 
								ON(fc2i.faq_id = pc.id) ';
			$sql_condition_cat_where = 'fc2i.category_id  = '.$_id_selected_category.' and ';
			}
			
			$cookie = $this->context->cookie;
			$current_language = (int)$cookie->id_lang;
			
			$sql = '
			SELECT pc.*
			FROM `'._DB_PREFIX_.'faq_item` pc 
			LEFT JOIN `'._DB_PREFIX_.'faq_item_data` pc_d
			on(pc.id = pc_d.id_item)
			'.$sql_condition_cat.'
			WHERE '.$sql_condition_cat_where.' pc.status = 1 and pc_d.id_lang = '.$current_language.' AND
			FIND_IN_SET('.$this->_id_shop.',pc.ids_shops) '.$sql_condition.'
			ORDER BY pc.`order_by` DESC';
			
			$items_tmp = Db::getInstance()->ExecuteS($sql);
			
			$items = array();
			
			foreach($items_tmp as $k => $_item){
				
				$items_data = Db::getInstance()->ExecuteS('
				SELECT pc.*
				FROM `'._DB_PREFIX_.'faq_item_data` pc
				WHERE pc.id_item = '.$_item['id'].'
				');
				
				
				
				foreach ($items_data as $item_data){
		    		
		    		if($current_language == $item_data['id_lang']){
		    			$items[$k]['title'] = $item_data['title'];
		    			$items[$k]['content'] = $item_data['content'];
		    			$items[$k]['is_by_customer'] = $_item['is_by_customer'];
		    			$items[$k]['customer_name'] = $_item['customer_name'];
		    			$items[$k]['id'] = $_item['id'];
		    			$items[$k]['time_add'] = $_item['time_add'];
		    			
		    			
		    			$sql = '
						SELECT pc.category_id, fcd.title
						FROM `'._DB_PREFIX_.'faq_category2item` pc
						LEFT JOIN `'._DB_PREFIX_.'faq_category` fc
						on(fc.id = pc.category_id)
						left join `'._DB_PREFIX_.'faq_category_data` fcd
						on(fcd.id_item = fc.id)
						WHERE pc.`faq_id` = '.$_item['id'].' and fcd.id_lang = '.$current_language;
		    			
		    			$data_category_for_questions = Db::getInstance()->ExecuteS($sql);
		    			
		    			$items[$k]['categories'] = $data_category_for_questions;
		    			
		    		} 
		    	}
		    }
		    
		   // echo "<pre>"; var_Dump($items);
		    return array('items' => $items);
	}
	
	public function getItems($_data = null){
		
		$_id_selected_category = isset($_data['id_category'])?$_data['id_category']:0;
			$sql_condition = '';
			if($_id_selected_category!=0)
			$sql_condition = 'left join `'._DB_PREFIX_.'faq_category2item` fc2i 
								ON(fc2i.faq_id = pc.id) where fc2i.category_id  = '.$_id_selected_category;
		
		$sql = '
			SELECT pc.*
			FROM `'._DB_PREFIX_.'faq_item` pc
			'.$sql_condition.'
			ORDER BY pc.`order_by` DESC';
		
		//echo $sql;
		$items = Db::getInstance()->ExecuteS($sql);
			
			foreach($items as $k => $_item){
				
				$items_data = Db::getInstance()->ExecuteS('
				SELECT pc.*
				FROM `'._DB_PREFIX_.'faq_item_data` pc
				WHERE pc.id_item = '.$_item['id'].'
				');
				
				$cookie = $this->context->cookie;
				$defaultLanguage =  $cookie->id_lang;
				
				$tmp_title = '';
				$tmp_link = '';
				// languages
				$languages_tmp_array = array();
			
				foreach ($items_data as $item_data){
		    		
					$languages_tmp_array[] = $item_data['id_lang'];
		    		
					
		    		$title = isset($item_data['title'])?$item_data['title']:'';
		    		if(strlen($tmp_title)==0){
		    			if(strlen($title)>0)
		    					$tmp_title = $title; 
		    		}
		    		
		    		
		    		if($defaultLanguage == $item_data['id_lang']){
		    			$items[$k]['title'] = $item_data['title'];
		    		} 
		    	}
		    	
		    	if(@strlen($items[$k]['title'])==0)
		    		$items[$k]['title'] = $tmp_title;
		    		
		    	// languages
		    	$items[$k]['ids_lng'] = $languages_tmp_array;
		    	
		    	
		    	$questions_ids = Db::getInstance()->ExecuteS('
				SELECT pc.category_id, pc.faq_id
				FROM `'._DB_PREFIX_.'faq_category2item` pc
				WHERE pc.`faq_id` = '.$_item['id'].'');
				$data_questions_ids = array();
				foreach($questions_ids as $k1 => $v1){
					$data_questions_ids[] = $v1['category_id'];
				}
				$items[$k]['faq_category_ids'] = implode(",",$data_questions_ids);
		    	
				
			}
			
//echo "<pre>"; var_dump($items); exit;
		return array('items' => $items);
	}
	
	
	public function getCategoryItem($_data){
		$id = $_data['id'];
		$admin = isset($_data['admin'])?$_data['admin']:0;
		
		if($admin == 1){
				$sql = '
					SELECT pc.*
					FROM `'._DB_PREFIX_.'faq_category` pc
					WHERE id = '.$id.'';
			$item = Db::getInstance()->ExecuteS($sql);
			
			foreach($item as $k => $_item){
				
				$items_data = Db::getInstance()->ExecuteS('
				SELECT pc.*
				FROM `'._DB_PREFIX_.'faq_category_data` pc
				WHERE pc.id_item = '.$_item['id'].'
				');
				
				foreach ($items_data as $item_data){
		    			$item['data'][$item_data['id_lang']]['title'] = $item_data['title'];
		    			
		    	}
		    	
			}
			
			$questions_ids = Db::getInstance()->ExecuteS('
			SELECT pc.category_id, pc.faq_id
			FROM `'._DB_PREFIX_.'faq_category2item` pc
			WHERE pc.`category_id` = '.$id.'');
			$data_questions_ids = array();
			foreach($questions_ids as $k => $v){
				$data_questions_ids[] = $v['faq_id'];
			}
			
			$item[0]['faq_questions_ids'] = $data_questions_ids;
			
		} else {
			$cookie = $this->context->cookie;
			$current_language = (int)$cookie->id_lang;
			
			
				$sql = '
					SELECT pc.*
					FROM `'._DB_PREFIX_.'faq_category` pc
					LEFT JOIN `'._DB_PREFIX_.'faq_category_data` pc1
					ON(pc1.id_item = pc.id)
					WHERE pc.`id` = '.$id.' AND pc1.id_lang = '.$current_language;
			
			$item = Db::getInstance()->ExecuteS($sql);
			
			foreach($item as $k => $_item){
				
				$items_data = Db::getInstance()->ExecuteS('
				SELECT pc.*
				FROM `'._DB_PREFIX_.'faq_category_data` pc
				WHERE pc.id_item = '.$_item['id'].'
				');
				
				foreach ($items_data as $item_data){
		    		
		    		if($current_language == $item_data['id_lang']){
		    			$item[$k]['title'] = $item_data['title'];
		    			
		    		}
		    	}
		    }
			
		}
		
	   return array('item' => $item);
	}
	
	public function saveItem($data){
	
		$ids_shops = implode(",",$data['faq_shop_association']);
		
		$item_status = $data['item_status'];
		
		$is_by_customer = $data['is_by_customer'];
		$faq_customer_name = $data['faq_customer_name'];
		$faq_customer_email = $data['faq_customer_email'];
		
		$sql = 'INSERT into `'._DB_PREFIX_.'faq_item` SET
								`is_by_customer` = \''.pSQL($is_by_customer).'\',
								`customer_name` = \''.pSQL($faq_customer_name).'\',
								`customer_email` = \''.pSQL($faq_customer_email).'\',
							   `status` = \''.pSQL($item_status).'\',
							   `ids_shops` = \''.$ids_shops.'\'
							   ';
		$result = Db::getInstance()->Execute($sql);
		
		$insert_id = Db::getInstance()->Insert_ID();
		
		Db::getInstance()->Execute('UPDATE ' . _DB_PREFIX_ . 'faq_item 
							SET order_by = '. $insert_id .' WHERE id = ' . $insert_id);
		
		
		$post_id = $insert_id;
		
		foreach($data['data_title_content_lang'] as $language => $item){
		
		$title = $item['title'];
		$content = $item['content'];
		
		$sql = 'INSERT into `'._DB_PREFIX_.'faq_item_data` SET
							   `id_item` = \''.pSQL($post_id).'\',
							   `id_lang` = \''.pSQL($language).'\',
							   `title` = \''.pSQL($title).'\',
							   `content` = "'.mysql_escape_string($content).'"
							   ';
		
		$result = Db::getInstance()->Execute($sql);
		}
		
		$faq_category_association = sizeof($data['faq_category_association'])>0?$data['faq_category_association']:array();
		
		foreach($faq_category_association as $id_cat){
			if($id_cat!=0){
			$sql = 'INSERT into `'._DB_PREFIX_.'faq_category2item` SET
							   `category_id` = \''.pSQL($id_cat).'\',
							   `faq_id` = \''.pSQL($post_id).'\'
							   ';
			Db::getInstance()->Execute($sql);
			}
		}
		
		
		
		
		
	}
	
	
	public function saveItemCategory($data){
	
		$ids_shops = implode(",",$data['faq_shop_association']);
		
		$item_status = $data['item_status'];
		
		
		$sql = 'INSERT into `'._DB_PREFIX_.'faq_category` SET
							   `status` = \''.pSQL($item_status).'\',
							   `ids_shops` = \''.$ids_shops.'\'
							   ';
		$result = Db::getInstance()->Execute($sql);
		
		$insert_id = Db::getInstance()->Insert_ID();
		
		Db::getInstance()->Execute('UPDATE ' . _DB_PREFIX_ . 'faq_category 
							SET order_by = '. $insert_id .' WHERE id = ' . $insert_id);
		
		
		$faq_cat_id = $insert_id;
		foreach($data['data_title_content_lang'] as $language => $item){
		
		$title = $item['title'];
		
		$sql = 'INSERT into `'._DB_PREFIX_.'faq_category_data` SET
							   `id_item` = \''.pSQL($faq_cat_id).'\',
							   `id_lang` = \''.pSQL($language).'\',
							   `title` = \''.pSQL($title).'\'
							   ';
		$result = Db::getInstance()->Execute($sql);
		}
		
		$faq_questions_association = sizeof($data['faq_questions_association'])>0?$data['faq_questions_association']:array();
		
		foreach($faq_questions_association as $id_cat){
			if($id_cat!=0){
			$sql = 'INSERT into `'._DB_PREFIX_.'faq_category2item` SET
							   `category_id` = \''.pSQL($insert_id).'\',
							   `faq_id` = \''.pSQL($id_cat).'\'
							   ';
			Db::getInstance()->Execute($sql);
			}
		}
		
		
		
	}
	
	public function deleteItem($data){
		
	
		$id = $data['id'];
		$sql = 'DELETE FROM `'._DB_PREFIX_.'faq_item`
					   WHERE id ='.$id.'';
		$result = Db::getInstance()->Execute($sql);
		
		$sql = 'DELETE FROM `'._DB_PREFIX_.'faq_item_data`
					   WHERE id_item ='.$id.'';
		$result = Db::getInstance()->Execute($sql);
		
		$sql = 'DELETE FROM `'._DB_PREFIX_.'faq_category2item`
					   WHERE faq_id ='.$id.'';
		$result = Db::getInstance()->Execute($sql);
		
			
	}
	
	public function deleteItemCategory($data){
		$id = $data['id'];
		
		$sql = 'DELETE FROM `'._DB_PREFIX_.'faq_category`
					   WHERE id ='.$id.'';
		$result = Db::getInstance()->Execute($sql);
		
		$sql = 'DELETE FROM `'._DB_PREFIX_.'faq_category_data`
					   WHERE id_item ='.$id.'';
		$result = Db::getInstance()->Execute($sql);
		
		$sql = 'DELETE FROM `'._DB_PREFIX_.'faq_category2item`
					   WHERE category_id ='.$id.'';
		$result = Db::getInstance()->Execute($sql);
	}
	
	public function getItem($_data){
		$id = $_data['id'];
		
		
		$sql = '
			SELECT pc.*
			FROM `'._DB_PREFIX_.'faq_item` pc
			WHERE id = '.$id;
			
			$item = Db::getInstance()->ExecuteS($sql);
			
			foreach($item as $k => $_item){
				
				$items_data = Db::getInstance()->ExecuteS('
				SELECT pc.*
				FROM `'._DB_PREFIX_.'faq_item_data` pc
				WHERE pc.id_item = '.$_item['id'].'
				');
				
				foreach ($items_data as $item_data){
		    			$item['data'][$item_data['id_lang']]['title'] = $item_data['title'];
		    			$item['data'][$item_data['id_lang']]['content'] = $item_data['content'];
		    			$item['data'][$item_data['id_lang']]['customer_name'] = $_item['customer_name'];
		    			$item['data'][$item_data['id_lang']]['customer_email'] = $_item['customer_email'];
		    	}
		    	
		    	
			}
			
			$post_category_id = 0;
			$category_ids = Db::getInstance()->ExecuteS('
			SELECT pc.category_id, pc.faq_id
			FROM `'._DB_PREFIX_.'faq_category2item` pc
			WHERE pc.`faq_id` = '.$id.'');
			$data_category_ids = array();
			foreach($category_ids as $k => $v){
				$data_category_ids[] = $v['category_id'];
			}
			
			$item[0]['faq_category_ids'] = $data_category_ids;
			
			//echo "<pre>"; var_dump($item); exit;
	   return array('item' => $item);
	}
	
	
public function getItemsCategory($_data = null){
		$admin = isset($_data['admin'])?$_data['admin']:null;
		$items = array();
		if($admin){
			
			$cookie = $this->context->cookie;
			$current_language = (int)$cookie->id_lang;
			
			
				$sql = '
				SELECT pc.*,
				(select count(*) as count from `'._DB_PREFIX_.'faq_category2item` c2p
				    WHERE c2p.category_id = pc.id ) as count_faq
				FROM `'._DB_PREFIX_.'faq_category` pc
				ORDER BY pc.`order_by` DESC';
				
			$categories = Db::getInstance()->ExecuteS($sql);
			
			
			foreach($categories as $k => $_item){
				$items_data = Db::getInstance()->ExecuteS('
				SELECT pc.*
				FROM `'._DB_PREFIX_.'faq_category_data` pc
				WHERE pc.id_item = '.$_item['id'].'
				');
				
				
				$cookie = $this->context->cookie;
				$defaultLanguage =  $cookie->id_lang;
				
				$tmp_title = '';
				$tmp_id = '';
				$tmp_link = '';
				$tmp_time_add = '';

				// languages
				$languages_tmp_array = array();
				
				foreach ($items_data as $item_data){
					$languages_tmp_array[] = $item_data['id_lang'];
		    		
		    		$title = isset($item_data['title'])?$item_data['title']:'';
		    		$id = isset($item_data['id_item'])?$item_data['id_item']:'';
		    		$time_add = isset($categories[$k]['time_add'])?$categories[$k]['time_add']:'';
		    		
		    		if(strlen($tmp_title)==0){
		    			if(strlen($title)>0)
		    					$tmp_title = $title; 
		    		}
		    		
					if(strlen($tmp_id)==0){
		    			if(strlen($id)>0)
		    					$tmp_id = $id; 
		    		}
		    		
					if(strlen($tmp_time_add)==0){
		    			if(strlen($time_add)>0)
		    					$tmp_time_add = $time_add; 
		    		}
		    		
		    		if($defaultLanguage == $item_data['id_lang']){
		    			$items[$k]['title'] = $item_data['title'];
		    			$items[$k]['id'] = $id;
		    			$items[$k]['time_add'] = $time_add;
		    		}
		    		
		    	}
		    	
		    	if(@strlen($items[$k]['title'])==0)
		    		$items[$k]['title'] = $tmp_title;
		    		
		    	if(@strlen($items[$k]['id'])==0)
		    		$items[$k]['id'] = $tmp_id;
		    		
		    	if(@strlen($items[$k]['time_add'])==0)
		    		$items[$k]['time_add'] = $tmp_time_add;
		    	
		    	$items[$k]['count_faq'] = $categories[$k]['count_faq'];
		    	$items[$k]['order_by'] = $categories[$k]['order_by'];
		    	$items[$k]['status'] = $categories[$k]['status'];
		    	
		    	$items[$k]['ids_shops'] = $categories[$k]['ids_shops'];
		    	// languages
		    	$items[$k]['ids_lng'] = $languages_tmp_array;
		    	
		    	
			}
			
			$data_count_categories = Db::getInstance()->getRow('
			SELECT COUNT(`id`) AS "count"
			FROM `'._DB_PREFIX_.'faq_category` 
			');
			
		} else{
			
			
			$cookie = $this->context->cookie;
			$current_language = (int)$cookie->id_lang;
			
			$items_tmp = Db::getInstance()->ExecuteS('
			SELECT pc.*,
				   (select count(*) as count from `'._DB_PREFIX_.'faq_item` pc1 
				    LEFT JOIN `'._DB_PREFIX_.'faq_category2item` c2p
				    ON(pc1.id = c2p.faq_id)
				    LEFT JOIN `'._DB_PREFIX_.'faq_item_data` bpd
				    ON(bpd.id_item = pc1.id)
					WHERE c2p.category_id = pc.id AND bpd.id_lang = '.$current_language.'
					AND pc1.status = 1 AND FIND_IN_SET('.$this->_id_shop.',pc1.ids_shops)) as count_faq
			FROM `'._DB_PREFIX_.'faq_category` pc
			LEFT JOIN `'._DB_PREFIX_.'faq_category_data` pc_d
			on(pc.id = pc_d.id_item)
			WHERE pc_d.id_lang = '.$current_language.'  AND FIND_IN_SET('.$this->_id_shop.',pc.ids_shops)
			ORDER BY pc.`time_add` DESC');	
			
			$items = array();
			
			foreach($items_tmp as $k => $_item){
				
				$items_data = Db::getInstance()->ExecuteS('
				SELECT pc.*
				FROM `'._DB_PREFIX_.'faq_category_data` pc
				WHERE pc.id_item = '.$_item['id'].'
				');
				
				
				
				foreach ($items_data as $item_data){
		    		
		    		if($current_language == $item_data['id_lang']){
		    			$items[$k]['title'] = $item_data['title'];
		    			$items[$k]['count_faq'] = $_item['count_faq'];
		    			$items[$k]['id'] = $_item['id'];
		    			$items[$k]['time_add'] = $_item['time_add'];
		    		} 
		    	}
		    }
			
			$data_count_categories = Db::getInstance()->getRow('
			SELECT COUNT(pc.`id`) AS "count"
			FROM `'._DB_PREFIX_.'faq_category` pc LEFT JOIN `'._DB_PREFIX_.'faq_category_data` pc_d
			on(pc.id = pc_d.id_item)
			WHERE pc_d.id_lang = '.$current_language.'  AND FIND_IN_SET('.$this->_id_shop.',pc.ids_shops)
			');
		}	
		return array('items' => $items, 'count_all' => $data_count_categories['count'] );
	}
	
	
	public function updateItem($data){
		
		
		$id = $data['id'];
		$ids_shops = implode(",",$data['faq_shop_association']);
		
		$item_status = $data['item_status'];
		
		$is_add_by_customer = $data['is_add_by_customer'];
		
		$is_by_customer = $data['is_by_customer'];
		$faq_customer_name = $data['faq_customer_name'];
		$faq_customer_email = $data['faq_customer_email'];
		
		
		// update
		$sql = 'UPDATE `'._DB_PREFIX_.'faq_item` SET
								`is_by_customer` = \''.pSQL($is_by_customer).'\',
								`customer_name` = \''.pSQL($faq_customer_name).'\',
								`customer_email` = \''.pSQL($faq_customer_email).'\',
							   `status` = \''.pSQL($item_status).'\',
							   `ids_shops` = \''.$ids_shops.'\'
							   WHERE id = '.$id.'
							   ';
		$result = Db::getInstance()->Execute($sql);
		
		/// delete tabs data
		$sql = 'DELETE FROM `'._DB_PREFIX_.'faq_item_data` WHERE id_item = '.$id.'';
		$result = Db::getInstance()->Execute($sql);
		
		foreach($data['data_title_content_lang'] as $language => $item){
		
		$title = $item['title'];
		$content = $item['content'];
		
		$sql = 'INSERT into `'._DB_PREFIX_.'faq_item_data` SET
							   `id_item` = \''.pSQL($id).'\',
							   `id_lang` = \''.pSQL($language).'\',
							   `title` = \''.pSQL($title).'\',
							   `content` = "'.mysql_escape_string($content).'"
							   ';
		$result = Db::getInstance()->Execute($sql);
		}
		
		$sql = 'DELETE FROM `'._DB_PREFIX_.'faq_category2item`
					   WHERE `faq_id` = \''.pSQL($id).'\'';
		Db::getInstance()->Execute($sql);
		
		$faq_category_association = sizeof($data['faq_category_association'])>0?$data['faq_category_association']:array();
		
		if(!empty($faq_category_association)){
			foreach($faq_category_association as $id_cat){
				if($id_cat!=0){
				$sql = 'INSERT into `'._DB_PREFIX_.'faq_category2item` SET
								   `category_id` = \''.pSQL($id_cat).'\',
								   `faq_id` = \''.pSQL($id).'\'
								   ';
				Db::getInstance()->Execute($sql);
				}
			}
		}
		if($is_add_by_customer == 1 && $item_status == 1){
			$this->sendNotificationResponse(array('id'=>$id));
		}
		
	}
	
	public function updateItemCategory($data){
		$id = $data['id'];
		$ids_shops = implode(",",$data['faq_shop_association']);
		
		$item_status = $data['item_status'];
		
		// update
		$sql = 'UPDATE `'._DB_PREFIX_.'faq_category` SET
							   `status` = \''.pSQL($item_status).'\',
							   `ids_shops` = \''.$ids_shops.'\'
							   WHERE id = '.$id.'
							   ';
		$result = Db::getInstance()->Execute($sql);
		
		/// delete tabs data
		$sql = 'DELETE FROM `'._DB_PREFIX_.'faq_category_data` WHERE id_item = '.$id.'';
		$result = Db::getInstance()->Execute($sql);
		
		foreach($data['data_title_content_lang'] as $language => $item){
		
		$title = $item['title'];
		
		$sql = 'INSERT into `'._DB_PREFIX_.'faq_category_data` SET
							   `id_item` = \''.pSQL($id).'\',
							   `id_lang` = \''.pSQL($language).'\',
							   `title` = \''.pSQL($title).'\'
							   ';
		$result = Db::getInstance()->Execute($sql);
		}
		
		$sql = 'DELETE FROM `'._DB_PREFIX_.'faq_category2item`
					   WHERE `category_id` = \''.pSQL($id).'\'';
		Db::getInstance()->Execute($sql);
		
		$faq_questions_association = sizeof($data['faq_questions_association'])>0?$data['faq_questions_association']:array();
		
		foreach($faq_questions_association as $id_cat){
			if($id_cat!=0){
			$sql = 'INSERT into `'._DB_PREFIX_.'faq_category2item` SET
							   `category_id` = \''.pSQL($id).'\',
							   `faq_id` = \''.pSQL($id_cat).'\'
							   ';
			Db::getInstance()->Execute($sql);
			}
		}
	}
	
	public function getItemsBlock(){
		
		$cookie = $this->context->cookie;
			$current_language = (int)$cookie->id_lang;
			
			$limit  = Configuration::get($this->_name.'faq_blc');
			$sql = '
			SELECT pc.*
			FROM `'._DB_PREFIX_.'faq_item` pc 
			LEFT JOIN `'._DB_PREFIX_.'faq_item_data` pc_d
			ON(pc.id = pc_d.id_item) 
			WHERE pc.status = 1 AND
			FIND_IN_SET('.$this->_id_shop.',pc.ids_shops) 
			and pc_d.id_lang = '.$current_language.' ORDER BY pc.`order_by` DESC LIMIT '.$limit;
			
			$items = Db::getInstance()->ExecuteS($sql);
			$items_tmp = array();
			foreach($items as $k => $_item){
				$items_data = Db::getInstance()->ExecuteS('
				SELECT pc.*
				FROM `'._DB_PREFIX_.'faq_item_data` pc
				WHERE pc.id_item = '.$_item['id'].'
				');
				
				
				
				foreach ($items_data as $item_data){
		    		if($current_language == $item_data['id_lang']){
		    			$items_tmp[$k]['data'][$item_data['id_lang']]['title'] = $item_data['title'];
		    			$items_tmp[$k]['data'][$item_data['id_lang']]['content'] = $item_data['content'];
		    			//$items_tmp[$k]['data'][$item_data['id_lang']]['time_add'] = $_item['time_add'];
		    			$items_tmp[$k]['data'][$item_data['id_lang']]['id'] = $_item['id'];
		    		}
		    	}
		    	
			}
		return array('items' => $items_tmp );
			
			
	
	}
	
	
	public function update_order($id, $order, $id_change, $order_change){
		
		$db = Db::getInstance();

		$db->Execute('UPDATE ' . _DB_PREFIX_ . 'faq_item SET order_by = '. $order_change .' WHERE id = ' . $id);
		$db->Execute('UPDATE ' . _DB_PREFIX_ . 'faq_item SET order_by = '. $order .' WHERE id = ' . $id_change);

		
	}
	
	public function update_order_faqcat($id, $order, $id_change, $order_change){
		
		$db = Db::getInstance();

		$db->Execute('UPDATE ' . _DB_PREFIX_ . 'faq_category SET order_by = '. $order_change .' WHERE id = ' . $id);
		$db->Execute('UPDATE ' . _DB_PREFIX_ . 'faq_category SET order_by = '. $order .' WHERE id = ' . $id_change);

		
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