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
 * @package contentpack
 * @copyright Copyright (c) 2011 - 2014 SPM LLC. (http://storeprestamodules.com)
 * @license   http://storeprestamodules.com/LICENSE.txt
*/

class importhelp {
	
	private $_name = 'contentpack';
	private $_id_shop;
	
	public function __construct(){
		if(version_compare(_PS_VERSION_, '1.5', '>')){
			$this->_id_shop = Context::getContext()->shop->id;
		} else {
			$this->_id_shop = 0;
		}
		
		$this->initContext();
	}
	
	private function initContext()
	{
	  if (version_compare(_PS_VERSION_, '1.5', '>'))
	    $this->context = Context::getContext();
	  else
	  {
	    global $smarty, $cookie;
	    $this->context = new StdClass();
	    $this->context->smarty = $smarty;
	    $this->context->cookie = $cookie;
	  }
	}
	
	public function ifExsitsTableProductcomments(){
		$sql = 'SHOW TABLES LIKE "'._DB_PREFIX_.'product_comment"';
		$result = 	Db::getInstance()->ExecuteS($sql);
		$result = isset($result[0])?$result[0]:0;
		$is_table_exists = sizeof($result)>0? $result : 0;
		return $is_table_exists;
		//var_dump($is_table_exists);exit;
	}
	
	public function importComments(){
		
		
		#### 0. get exists comments ####
		$condition = '';
		if(version_compare(_PS_VERSION_, '1.4', '>')){
			$condition = ' where deleted = 0';
		}
		
		
		$sql = 'SELECT *  FROM `'._DB_PREFIX_.'product_comment` '.$condition;
		$comments = Db::getInstance()->ExecuteS($sql);
		
		$cookie = $this->context->cookie;
		$id_lang = intval($cookie->id_lang);
				
		foreach($comments as $comment){
			
			if(version_compare(_PS_VERSION_, '1.4', '>')){
				$id_product = $comment['id_product'];
				$id_customer = $comment['id_customer'];
				$title =$comment['title'];
				$content = $comment['content'];
				$customer_name = $comment['customer_name'];
				####
				include_once(dirname(__FILE__).'/reviewshelp.class.php');
				$obj = new reviewshelp();
				$customer_data = $obj->getInfoAboutCustomer(array('id_customer'=>$id_customer));
				####
					
				if(strlen($customer_name)==0){
					$customer_name = $customer_data['customer_name'];
				}
				$email = $customer_data['email'];
				
				$rating = $comment['grade'];
				$active = $comment['validate'];
			} else {
				$id_product = $comment['id_product'];
				$id_customer = $comment['id_customer'];
				$title = mb_substr($comment['content'],0,64,'utf-8');
				$content = $comment['content'];
				
				####
				include_once(dirname(__FILE__).'/reviewshelp.class.php');
				$obj = new reviewshelp();
				$customer_data = $obj->getInfoAboutCustomer(array('id_customer'=>$id_customer));
				####
				$customer_name = $customer_data['customer_name'];
				$email = $customer_data['email'];
				
				$rating = $comment['grade'];
				$active = $comment['validate'];
			}
			
			
			$data = array(
							'id_product'=>$id_product,
							'id_customer' =>$id_customer,
							'title'=>$title,
							'content'=>$content,
							'customer_name'=>$customer_name,
							'rating'=>$rating,
							'email'=>$email,
							'active'=>$active
							
						  );
						  
			//echo "<pre>"; var_dump($data); exit;			  
			#### 0. get exists comments ####
						  
						  
			#### 1. if exists comment ####
			$sql_exists = 'SELECT count(*) as count  
								  FROM `'._DB_PREFIX_.'reviewsnippets` 
								  WHERE id_product = '.$id_product.'
								  AND id_customer = '.$id_customer.'
								  AND customer_name = "'.pSQL($customer_name).'"
								  AND subject = "'.pSQL($title).'"
								  AND text_review = "'.pSQL($content).'"
								  AND email = "'.pSQL($email).'"
								  AND rating = "'.$rating.'"
								  AND id_lang = '.$id_lang.'
								  AND is_import = 1';
			$result_exists_comments = Db::getInstance()->ExecuteS($sql_exists);
			$if_exists_comments = isset($result_exists_comments[0]['count'])? $result_exists_comments[0]['count'] : 0;
			#### 1. if exists comment ####

			#### 2. insert new comment ####
			if(!$if_exists_comments){
				$sql_insert = 'INSERT INTO `'._DB_PREFIX_.'reviewsnippets`
									  SET 
									  id_product= '.$id_product.',
									  id_customer = '.$id_customer.',
									  customer_name = "'.pSQL($customer_name).'",
									  subject = "'.pSQL($title).'",
									  text_review = "'.pSQL($content).'",
									  rating = "'.$rating.'",
									  id_shop = "'.$this->_id_shop.'",
									  email = "'.pSQL($email).'",
									  active = '.$active.',
									  id_lang = '.$id_lang.',
									  is_import = 1
									  ';
				//var_dump($sql_insert);exit;
				Db::getInstance()->Execute($sql_insert);
			}
			#### 2. insert new comment ####
		}
		
		
	}
	
	public function getCountComments()
	{
		$condition = '';
		if(version_compare(_PS_VERSION_, '1.4', '>')){
			$condition = ' where deleted = 0';
		}
		
		$sql = 'SELECT count(*) as count  FROM `'._DB_PREFIX_.'product_comment` '.$condition;
		$result = 	Db::getInstance()->ExecuteS($sql);
		$is_comments = isset($result[0]['count'])? $result[0]['count'] : 0;
		
		
		$sql = 'SELECT count(*) as count  FROM `'._DB_PREFIX_.'reviewsnippets` 
					WHERE is_import = 1 
					';
		$result = 	Db::getInstance()->ExecuteS($sql);
		$is_import_comments = isset($result[0]['count'])? $result[0]['count'] : 0;
		
		
		
		$is_count_comments = 0;
		
		if($is_comments && ($is_import_comments != $is_comments)){
			$is_count_comments = 1;
		}
			
			
			
			
		return array('comments'=>$is_comments , 'is_count_comments'=>$is_count_comments);
	}
	
	
}