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

class reviewshelp extends Module{
	
	private $_name_module;
	private $_table_name_product_reviews;
	
	public function getStepForMyReviewsAll(){
		return 5;
	}
	
	public function getStepForAdminReviewsAll(){
		return 10;
	}
	
	public function __construct(){
		$this->_name_module = "propack";
		$this->_table_name_product_reviews = "reviewsnippets";
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
	
	public function l_custom($text){
		return $this->l($text);
	}
	
	
	
	public function sendNotification($data = null){
		
		if(Configuration::get($this->_name_module.'noti_snip') == 1){
			$review = $data['review'];
			$subject = $data['subject'];
			$cookie = $this->context->cookie;
			/* Email generation */
			$templateVars = array(
				'{subject}' => $subject,
				'{review}' => stripslashes($review)
			);
					
			include_once(dirname(__FILE__).'/../propack.php');
			$obj_propack = new propack();
			$data_translate = $obj_propack->translateCustom();
			$id_lang = intval($cookie->id_lang);
			/* Email sending */
			Mail::Send($id_lang, 'review', $data_translate['new_review'], $templateVars, 
				Configuration::get($this->_name_module.'mail_snip'), 'Reviews Form', NULL, NULL,
				NULL, NULL, dirname(__FILE__).'/../mails/');
		}
		
	}
	
	public function getInfoAboutCustomer($data=null){
		$id_customer = (int) $data['id_customer'];
		//get info about customer
		$result = Db::getInstance()->GetRow('
	        	SELECT * FROM `'._DB_PREFIX_.'customer` 
		        WHERE `active` = 1 AND `id_customer` = \''.$id_customer.'\'  
		        AND `deleted` = 0 '.(defined(_MYSQL_ENGINE_)?"AND `is_guest` = 0":"").'
		        ');
		$email = '';
		if($result){
		$lastname = $result['lastname'];
		$firstname = $result['firstname'];
		$customer_name = $lastname. " ". $firstname;
		$email = $result['email'];
		} else {
			$customer_name = "Guest";
		}

		return array('customer_name' => $customer_name,'email'=>$email);
	}
	
	public function getItem($_data){
		$id = $_data['id'];
		
			$reviews = Db::getInstance()->ExecuteS('
			SELECT pc.*
			FROM `'._DB_PREFIX_.$this->_table_name_product_reviews.'` pc
			WHERE pc.`id` = '.$id.'');
			
			
	   return array('reviews' => $reviews);
	}
	
	public function saveReview($data=null){
		
		$id_product = $data['id_product'];
		$id_customer = $data['id_customer'];
		$subject = $data['subject'];
		$text_review = $data['text_review'];
		$customer_name = $data['customer_name'];
		$recommended_product = $data['recommended_product'];
		$rating = $data['rating'];
		$email = $data['email'];
		
			
		
		if(Configuration::get($this->_name_module.'switch_lng') == 1){
			$cookie = $this->context->cookie;
			$id_lang = intval($cookie->id_lang);	
		} else {
			$id_lang = 0;
		}
		
		
		//insert review
		$sql = 'INSERT into `'._DB_PREFIX_.$this->_table_name_product_reviews.'` SET
						   id_product = '.$id_product.', 
						   id_customer = '.$id_customer.',
						   subject = \''.pSQL($subject).'\',
						   text_review = \''.pSQL($text_review).'\',
						   customer_name = \''.pSQL($customer_name).'\',
						   recommended_product = '.$recommended_product.',
						   rating = '.$rating.',
						   ip = \''.$_SERVER['REMOTE_ADDR'].'\',
						   id_shop = \''.$this->getIdShop().'\',
						   id_lang = \''.$id_lang.'\',
						   email = \''.$email.'\'
						   ';
		$result = Db::getInstance()->Execute($sql);
		
	}
	
	public function getIdShop(){
		$id_shop = 0;
		if(version_compare(_PS_VERSION_, '1.5', '>'))
			$id_shop = Context::getContext()->shop->id;
		return $id_shop;
	} 
	
	public function updateReview($data){
			$subject = $data['subject'];
			$text_review = $data['text_review'];
			$publish = $data['publish'];
			$id = $data['id'];
			$name = $data['name'];
			$email = $data['email'];
			$rating = (int)$data['rating'];
			$rating ==0?$rating =1:$rating = $rating;
			if($rating > 5)
				$rating = 5;
			$date_add = $data['date_add'];
			$date_add_old = $data['date_add_old'];
			
			$sql = 'UPDATE `'._DB_PREFIX_.$this->_table_name_product_reviews.'` 
	    						SET `subject` = "'.pSQL($subject).'",
						   			`text_review` = "'.pSQL($text_review).'",
									`active` = '.$publish.',
									`customer_name` = "'.pSQL($name).'",
						   			`email` = "'.$email.'",
						   			`id_shop` = \''.$this->getIdShop().'\',
						   			`date_add` = "'.pSQL($date_add).'",
						   			`rating` = "'.$rating.'"			   			 
						   		WHERE id = '.$id.''; 
		//echo $sql; exit;
			$result = Db::getInstance()->Execute($sql);
			
	}
	
   
	
	public function getCountReviews($data){
		$id_product = $data['id_product'];
		
		if (!Validate::isUnsignedId($id_product))
			die(Tools::displayError());
		
		$id_shop = $this->getIdShop();
		$sql_condition = '';
		if(Configuration::get($this->_name_module.'switch_lng') == 1){
			$cookie = $this->context->cookie;
			$id_lang = intval($cookie->id_lang);
			$sql_condition = ' AND id_lang = '.$id_lang.' AND id_shop = '.$id_shop.'';	
		} else {
			$sql_condition = ' AND id_shop = '.$id_shop.'';	
		}
			
		if (($result = Db::getInstance()->getRow('
		SELECT COUNT(`id`) AS "count"
		FROM `'._DB_PREFIX_.$this->_table_name_product_reviews.'` pc
		WHERE `id_product` = '.(int)($id_product).' AND active = 1 AND deleted = 0 
		'.$sql_condition 
		)) === false)
			return false;
		return (int)($result['count']);
	}
	
	public function getAvgReview($data){
		$id_product = $data['id_product'];
		
		if (!Validate::isUnsignedId($id_product))
			die(Tools::displayError());
		
		$id_shop = $this->getIdShop();
		$sql_condition = '';
		if(Configuration::get($this->_name_module.'switch_lng') == 1){
			$cookie = $this->context->cookie;
			$id_lang = intval($cookie->id_lang);
			$sql_condition = ' AND id_lang = '.$id_lang.' AND id_shop = '.$id_shop.'';	
		} else {
			$sql_condition = ' AND id_shop = '.$id_shop.'';	
		}
		
		if (($result = Db::getInstance()->getRow('
		SELECT AVG(`rating`) AS "avg_rating"
		FROM `'._DB_PREFIX_.$this->_table_name_product_reviews.'` pc
		WHERE `id_product` = '.(int)($id_product).' AND active = 1 AND deleted = 0'.$sql_condition
		)) === false)
			return false;
		return (int)($result['avg_rating']);
	}
	
	
	
	public function getAllReviews($data){
		$start = $data['start'];
		$step = $this->getStepForAdminReviewsAll();
		$cookie = $this->context->cookie;
		$id_lang = intval($cookie->id_lang);
		
		$id_shop = $this->getIdShop();
		
		
		$sql_condition = 'id_shop = '.$id_shop.'';
		
		$reviews = Db::getInstance()->ExecuteS('
		SELECT pc.*
		FROM `'._DB_PREFIX_.$this->_table_name_product_reviews.'` pc WHERE '.$sql_condition.' 
		ORDER BY pc.`date_add` DESC LIMIT '.$start.' ,'.$step.'');
		
		$reviews_tmp = $reviews;
		
		foreach($reviews_tmp as $k => $_item){
		$product_id = $_item['id_product'];
		
		$product_obj = new Product($product_id);
		$name_product = $product_obj->name[$id_lang];
		$reviews[$k]['product_name'] = $name_product; 
		
		// link to product
			$product_obj = new Product($product_id);
			$link_obj = new Link();
			
			$name_page = $product_obj->name[$id_lang];
			$description = $product_obj->description_short[$id_lang];
			
			foreach($product_obj->getImages($id_lang) as $item_img){
	    		$id_img = (int) isset($item_img['id_image'])?$item_img['id_image']:0;
	    		break;
	    	}
	    	
			if(version_compare(_PS_VERSION_, '1.5', '>')){
	    			$picture = $link_obj->getImageLink($product_id."-".$id_img."-small",$product_id."-".$id_img."-small","medium_default");
		    	}else{
	    			$picture = $link_obj->getImageLink($product_id."-".$id_img,$product_id."-".$id_img,"medium");
		    	}
	    	
			
	    	
	    	if (Configuration::get('PS_SSL_ENABLED') == 1)
				$url = "https://";
			else
				$url = "http://";
				
			if(substr(_PS_VERSION_,0,3) != '1.3')
				$picture = $url.str_replace($url,"",$picture);
				
			$reviews[$k]['product_image'] = $picture;
			
	    	$reviews[$k]['product_link'] = $link_obj->getProductLink($product_id,current($product_obj->link_rewrite));
	    //link to product
		
		}
		
		$data_count_reviews = Db::getInstance()->getRow('
		SELECT COUNT(`id`) AS "count"
		FROM `'._DB_PREFIX_.$this->_table_name_product_reviews.'` WHERE '.$sql_condition.'
		');
		
		return array('reviews' => $reviews, 'count_all_reviews' => $data_count_reviews['count'] );
	}
	
	public function getReviews($data){
		$id_product = $data['id_product'];
		$start = $data['start'];
		$step = (int)Configuration::get($this->_name_module.'revperpage');
		
		$id_shop = $this->getIdShop();
		$sql_condition = '';
		if(Configuration::get($this->_name_module.'switch_lng') == 1){
			$cookie = $this->context->cookie;
			$id_lang = intval($cookie->id_lang);
			$sql_condition = ' AND id_lang = '.$id_lang.' AND id_shop = '.$id_shop.'';	
		} else {
			$sql_condition = ' AND id_shop = '.$id_shop.'';	
		}
		
		$reviews = Db::getInstance()->ExecuteS('
		SELECT pc.*
		FROM `'._DB_PREFIX_.$this->_table_name_product_reviews.'` pc
		WHERE pc.`id_product` = '.(int)($id_product).'
		AND pc.active = 1 AND pc.deleted = 0 '.$sql_condition.'
		ORDER BY pc.`date_add` DESC LIMIT '.$start.' ,'.$step.'');
		
		$data_count_reviews = Db::getInstance()->getRow('
		SELECT COUNT(`id`) AS "count"
		FROM `'._DB_PREFIX_.$this->_table_name_product_reviews.'` 
		WHERE `id_product` = '.(int)($id_product).'
		AND active = 1 AND deleted = 0 '.$sql_condition.'
		');
		
		 return array('reviews' => $reviews, 'count_all_reviews' => $data_count_reviews['count'] );
	}
	
public function getMyReviews($data){
		$cookie = $this->context->cookie;
		$id_lang = intval($cookie->id_lang);
		$id_customer = $data['id_customer'];
		$start = $data['start'];
		$step = $this->getStepForMyReviewsAll();
		
		$id_shop = $this->getIdShop();
		$sql_condition = '';
		if(Configuration::get($this->_name_module.'switch_lng') == 1){
			$cookie = $this->context->cookie;
			$id_lang = intval($cookie->id_lang);
			$sql_condition = ' AND id_lang = '.$id_lang.' AND id_shop = '.$id_shop.'';	
		} else {
			$sql_condition = ' AND id_shop = '.$id_shop.'';	
		}
		
		$sql = '
		SELECT pc.*
		FROM `'._DB_PREFIX_.'reviewsnippets` pc
		where id_customer = '.$id_customer.' '.$sql_condition.'
		ORDER BY pc.`date_add` DESC LIMIT '.$start.', '.$step;
		
		$reviews = Db::getInstance()->ExecuteS($sql);
		
		$i=0;
		foreach($reviews as $_item){
			$product_id = $_item['id_product'];
			
			$product_obj = new Product($product_id);
			$link_obj = new Link();
			
			$name_page = $product_obj->name[$id_lang];
			$description = $product_obj->description_short[$id_lang];
			
			foreach($product_obj->getImages($id_lang) as $item_img){
	    		$id_img = (int) isset($item_img['id_image'])?$item_img['id_image']:0;
	    		break;
	    	}
	    	
	    	if(version_compare(_PS_VERSION_, '1.5', '>'))
	    		$picture = $link_obj->getImageLink($product_id."-".$id_img."-small",$product_id."-".$id_img."-small","medium_default");
	    	else
	    		$picture = $link_obj->getImageLink($product_id."-".$id_img,$product_id."-".$id_img,"medium");
	    	
	    	
			if(substr(_PS_VERSION_,0,3) == '1.3'){
				$smarty = $this->context->smarty;
	    		$_http_host = $smarty->_tpl_vars['base_dir_ssl'];
	    		$picture = $_http_host.$picture;
	    	}
	    	
	    	if (Configuration::get('PS_SSL_ENABLED') == 1){
	    		$picture = str_replace("http://","",$picture);
				$url = "https://";
	    	} else
				$url = "http://";
			
	    	$reviews[$i]['product_link'] = $link_obj->getProductLink($product_id,current($product_obj->link_rewrite));
	    	
	    	$reviews[$i]['product_img'] = $url.str_replace($url,"",$picture); 
	    	$reviews[$i]['product_name'] = $name_page;
	    $i++;
		}
		
		
		$result = Db::getInstance()->getRow('
					SELECT COUNT(`id`) AS "count"
					FROM `'._DB_PREFIX_.$this->_table_name_product_reviews.'` pc
					where id_customer = '.$id_customer.' '.$sql_condition);
		
		return array('reviews' => $reviews, 'count_all' => (int)$result['count']);
	}
	
	public function getLastReviews($data){
		$step = (int) $data['step'];
		$cookie = $this->context->cookie;
				
		$id_lang = intval($cookie->id_lang);
		
		$id_shop = $this->getIdShop();
		$sql_condition = '';
		if(Configuration::get($this->_name_module.'switch_lng') == 1){
			$sql_condition = ' AND id_lang = '.$id_lang.' AND id_shop = '.$id_shop.'';	
		} else {
			$sql_condition = ' AND id_shop = '.$id_shop.'';	
		}
		
		$reviews = Db::getInstance()->ExecuteS('
		SELECT pc.*
		FROM `'._DB_PREFIX_.$this->_table_name_product_reviews.'` pc
		where pc.active = 1 AND pc.deleted = 0 '.$sql_condition.'
		ORDER BY pc.`date_add` DESC LIMIT '.$step);
		
		include_once(dirname(__FILE__).'/../propack.php');
		$obj_propack = new propack();
		$data_translate = $obj_propack->translateCustom();
		
		
		$i=0;
		foreach($reviews as $_item){
			$product_id = $_item['id_product'];
			
			$product_obj = new Product($product_id);
			$link_obj = new Link();
			
			$name_page = $product_obj->name[$id_lang];
			$description = $product_obj->description_short[$id_lang];
			
			foreach($product_obj->getImages($id_lang) as $item_img){
	    		$id_img = (int) isset($item_img['id_image'])?$item_img['id_image']:0;
	    		break;
	    	}
	    	if(version_compare(_PS_VERSION_, '1.5', '>'))
	    		$picture = $link_obj->getImageLink($product_id."-".$id_img."-small",$product_id."-".$id_img."-small","medium_default");
	    	else
	    		$picture = $link_obj->getImageLink($product_id."-".$id_img,$product_id."-".$id_img,"medium");
	    		
	    	
	    	
	    	if (Configuration::get('PS_SSL_ENABLED') == 1)
				$url = "https://";
			else
				$url = "http://";
				
			if(substr(_PS_VERSION_,0,3) != '1.3')
				$picture = $url.str_replace($url,"",$picture);
	    	
	    	$reviews[$i]['product_link'] = $link_obj->getProductLink($product_id,current($product_obj->link_rewrite));
	    	$reviews[$i]['product_img'] = $picture; 
	    	$reviews[$i]['product_name'] = $name_page;
	    	
	    	$result = Db::getInstance()->getRow('
					SELECT COUNT(`id`) AS "count"
					FROM `'._DB_PREFIX_.$this->_table_name_product_reviews.'` pc
					where pc.id_product = '.$product_id.' 
					AND pc.active = 1 AND pc.deleted = 0 '.$sql_condition);
	    	
	    	$reviews[$i]['count_reviews'] = $result['count']." ".$this->number_ending($result['count'], 
	    																			  $data_translate["reviews"], 
	    																			  $data_translate["review"], 
	    																			  $data_translate["reviews"]);
	    	
	    $i++;
		}
		
		
		
		return array('reviews' => $reviews);
	}
	
	
	public function publish($data){
		$id = $data['id'];
		
		$sql = 'UPDATE `'._DB_PREFIX_.$this->_table_name_product_reviews.'` 
	    							SET
						   			active = 1
						   			WHERE id = '.$id.' 
						   ';
		$result = Db::getInstance()->Execute($sql);
			
	}
	
	public function unpublish($data){
		$id = $data['id'];
		$sql = 'UPDATE `'._DB_PREFIX_.$this->_table_name_product_reviews.'` 
	    							SET
						   			active = 0
						   			WHERE id = '.$id.' 
						   ';
		$result = Db::getInstance()->Execute($sql);
			
	}
	
	public function delete($data){
			$id = $data['id'];
			$sql = 'delete FROM `'._DB_PREFIX_.$this->_table_name_product_reviews.'` 
	    							WHERE id = '.$id.' 
						   ';
	    	$result = Db::getInstance()->Execute($sql);
			
	}
	
 	/*
	  * *  echo $n." ".number_ending($n, "reviews", "review", "reviews"); 
	 */
	public function number_ending($number, $ending0, $ending1, $ending2) {
		$num100 = $number % 100;
		$num10 = $number % 10;
		if ($num100 >= 5 && $num100 <= 20) {
			return $ending0;
		} else if ($num10 == 0) {
			return $ending0;
		} else if ($num10 == 1) {
			return $ending1;
		} else if ($num10 >= 2 && $num10 <= 4) {
			return $ending2;
		} else if ($num10 >= 5 && $num10 <= 9) {
			return $ending0;
		} else {
			return $ending2;
		}
	}
	
	function PageNavSiteOrig($start,$count,$step,$id_product)
	{
		
		$res = '';
		$product_count = $count;
		
		include_once(dirname(__FILE__).'/../propack.php');
		$obj_propack = new propack();
		$page_translate = $obj_propack->translateCustom();
		
		$res .= '<div class="pages" style="margin-top:10px;">';
		$res .= '<span>'.$page_translate['page'].':</span>';
		
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
						$res .= '<a href="javascript:void(0)" onclick="PageNav( '.($start1 ? $start1 : 0).','.$id_product.' )">'.$par.'</a>';
						}
				}
		
		$res .= '</span>';
		$res .= '</div>';
		
		$res .= $this->_scriptSiteOrig();
		
		return $res;
	}
	
	public function _scriptSiteOrig(){
		$_html = '';
		ob_start(); 
		$smarty = $this->context->smarty;
						
		$tpl_vars = @$smarty->tpl_vars;
    	$base_dir_tmp = $tpl_vars['base_dir'];
    	$base_dir = @$base_dir_tmp->value;
		include(dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."panavjssite.phtml");
		$_html = ob_get_clean();
		return $_html;
	}
	
 public function PageNavSite($start,$count,$step,$id_product)
	{
		
		$res = '';
		$product_count = $count;
		
		include_once(dirname(__FILE__).'/../propack.php');
		$obj_propack = new propack();
		$page_translate = $obj_propack->translateCustom();
		
		$res .= '<div class="pages" style="margin-top:10px;">';
		$res .= '<span>'.$page_translate['page'].':</span>';
		
		
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
						$res .= '<a href="javascript:void(0)" onclick="PageNav( '.($start1 ? $start1 : 0).','.$id_product.' )">'.$par.'</a>';
						}
				}
		
		$res .= '</span>';
		$res .= '</div>';
		
		$res .= $this->_scriptSite();
		
		return $res;
	}
	
	public function _scriptSite(){
		$smarty = $this->context->smarty;
		
		
		$_html = '';
		ob_start(); 
		$base_dir = '';
		
		if(defined('_MYSQL_ENGINE_')){
			$base_dir = $smarty->tpl_vars['base_dir']->value;
		} else {
			$base_dir = "http://".$_SERVER['HTTP_HOST']."/";
		}
		
		include(dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."panavjssite.phtml");
		$_html = ob_get_clean();
		return $_html;
	}
	
	
	public function PageNavAdmin($start,$count,$step, $_data =null )
	{
		$_admin = isset($_data['admin'])?$_data['admin']:null;
		
		$res = '';
		$product_count = $count;
		
		include_once(dirname(__FILE__).'/../propack.php');
		$obj_propack = new propack();
		$page_translate = $obj_propack->translateCustom();
		
		$res .= '<div class="pages" >';
		$res .= '<span>'.$page_translate['page'].':</span>';
		
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
								$res .= '<a href="'.$currentIndex.'&page_rev='.($start1 ? $start1 : 0).$token.'" >'.$par.'</a>';
							} else {
								$res .= '<a href="javascript:void(0)" onclick="go_page( '.($start1 ? $start1 : 0).' )">'.$par.'</a>';
							}
						}
				}
		
		$res .= '</span>';
		$res .= '</div>';
		
		return $res;
	}
	
	public function checkProductBought($data)
	{
		$id_customer = $data['id_customer'];
		$id_product = $data['id_product'];
		if(version_compare(_PS_VERSION_, '1.5', '>')){
		$sql = 'SELECT count(o.id_order) as count FROM ' . _DB_PREFIX_ .'orders as o 
					   LEFT JOIN ' . _DB_PREFIX_ . 'order_detail as od ON(o.id_order = od.id_order)
					   WHERE o.id_customer = ' . pSQL($id_customer) . ' AND od.product_id = ' . pSQL($id_product).'
					   AND o.id_shop = '.$this->getIdShop().' AND od.id_shop = '.$this->getIdShop();
		} else {
			$sql = 'SELECT count(o.id_order) as count FROM ' . _DB_PREFIX_ .'orders as o 
					   LEFT JOIN ' . _DB_PREFIX_ . 'order_detail as od ON(o.id_order = od.id_order)
					   WHERE o.id_customer = ' . pSQL($id_customer) . ' AND od.product_id = ' . pSQL($id_product).'
					  ';
		}
		$result = Db::getInstance()->ExecuteS($sql);
		return (!empty($result[0]['count'])? 1 : 0);
	}
	
	public function checkIsUserAlreadyAddReview($data){
		$id_customer = $data['id_customer'];
		$id_product = $data['id_product'];
		
		$id_shop = $this->getIdShop();
		$sql_condition = '';
		if(Configuration::get($this->_name_module.'switch_lng') == 1){
			$cookie = $this->context->cookie;
		
			$id_lang = intval($cookie->id_lang);
			$sql_condition = ' AND id_lang = '.$id_lang.' AND id_shop = '.$id_shop.'';	
		} else {
			$sql_condition = ' AND id_shop = '.$id_shop.'';	
		}
		
		if($id_customer == 0){
			// guest
			$sql = 'select count(*) as count from `'._DB_PREFIX_.'reviewsnippets` where
				id_product = '.$id_product.' AND ip = \''.$_SERVER['REMOTE_ADDR'].'\' '.$sql_condition;
			
		}  else {
		
		$sql = 'select count(*) as count from `'._DB_PREFIX_.'reviewsnippets` where
				id_product = '.$id_product.' AND id_customer = '.$id_customer.' '.$sql_condition;
		}
		$result = Db::getInstance()->ExecuteS($sql);
		

		return (!empty($result[0]['count'])? 1 : 0);
	}
	
	
	
	public function createRSSFile($post_title,$post_description,$post_link, $img)
	{
		$returnITEM = "<item>\n";
		# this will return the Title of the Article.
		$returnITEM .= "<title><![CDATA[".$post_title."]]></title>\n";
		# this will return the Description of the Article.
		$returnITEM .= "<description><![CDATA[".((strlen($img)>0)?"<img src=\"".$img."\" title=\"".$post_title."\" alt=\"thumb\" />":"").$post_description."]]></description>\n";
		# this will return the URL to the post.
		$returnITEM .= "<link>".str_replace('&','&amp;', $post_link)."</link>\n";
		$returnITEM .= "</item>\n";
		return $returnITEM;
	}
	
	public function getItemsForRSS(){
			$id_shop = $this->getIdShop();
		
			$step = Configuration::get($this->_name_module.'n_rss_snip');
			
			$cookie = $this->context->cookie;
			$id_lang = intval($cookie->id_lang);
			
			$id_shop = $this->getIdShop();
			$sql_condition = '';
			if(Configuration::get($this->_name_module.'switch_lng') == 1){
				$sql_condition = ' id_lang = '.$id_lang.' AND id_shop = '.$id_shop.'';	
			} else {
				$sql_condition = ' id_shop = '.$id_shop.'';	
			}
			
			
			$sql = '
			SELECT pc.*
			FROM `'._DB_PREFIX_.'reviewsnippets` pc
			where '.$sql_condition.'
			ORDER BY pc.`date_add` DESC LIMIT 0, '.$step;
			
			$reviews = Db::getInstance()->ExecuteS($sql);
			
			
			$i=0;
			foreach($reviews as $_item){
				$product_id = $_item['id_product'];
				
				$product_obj = new Product($product_id);
				$link_obj = new Link();
				
				$reviews[$i]['page'] = $link_obj->getProductLink($product_id,current($product_obj->link_rewrite));
		    	$reviews[$i]['title'] = $reviews[$i]['subject'];
		    	$reviews[$i]['seo_description'] = strip_tags($reviews[$i]['text_review']);
		    	
		    	### image ###
				$id_img = 0;
		    	foreach($product_obj->getImages($id_lang) as $_item_img){
		    		$id_img = (int) isset($_item_img['id_image'])?$_item_img['id_image']:0;
		    		break;
		    	}
    	
		    	if(version_compare(_PS_VERSION_, '1.5', '>'))
	    			$picture = $link_obj->getImageLink($product_id."-".$id_img."-small",$product_id."-".$id_img."-small","medium_default");
	    		else
	    			$picture = $link_obj->getImageLink($product_id."-".$id_img,$product_id."-".$id_img,"medium");
	    	
   
    	
		    	if(substr(_PS_VERSION_,0,3) == '1.3'){
						$smarty = $this->context->smarty;
		
			    		$_http_host = $smarty->_tpl_vars['base_dir_ssl'];
			    		$picture = $_http_host.$picture;
			    	}
			    	
			    if (Configuration::get('PS_SSL_ENABLED') == 1)
					$url = "https://";
				else
					$url = "http://";
		    	
		    	if($url == "https://"){
			    	$picture = $url.str_replace("http://","",$picture);
			    }else{
			    	$picture = $url.str_replace($url,"",$picture);
			    }
			    $reviews[$i]['img'] = isset($picture)?$picture:''; 
				### image ####
		    	
		    $i++;
			}
		
			return array('items' => $reviews);
	}
	
	
public function paging($data)
	{
		$start = $data['start'];
		$count = $data['count'];
		$step = $data['step'];
		$id_product = isset($data['id_product'])?$data['id_product']:0;
		$page_text = $data['page'];
		$all = isset($data['all'])?$data['all']:0;
		$all_my = isset($data['all_my'])?$data['all_my']:0;
		$_admin = isset($data['admin'])?$data['admin']:0;
		
		$res = '';
		$res .= '<div class="pages" style="margin-top:10px;">';
		$res .= '<span>'.$page_text.': </span>';
		$res .= '<span class="nums">';
		
		$start1 = $start;
			for ($start1 = ($start - $step*4 >= 0 ? $start - $step*4 : 0); $start1 < ($start + $step*5 < $count ? $start + $step*5 : $count); $start1 += $step)
				{
					$par = (int)($start1 / $step) + 1;
					if ($start1 == $start)
						{
						
						$res .= '<b>'. $par .'</b>';
						}
					else
						{
							if($all){
								$res .= '<a href="javascript:void(0)" onclick="paging_reviewsnippets_all( '.($start1 ? $start1 : 0).' )">'.$par.'</a>';
							} elseif($all_my){ 
								$res .= '<a href="javascript:void(0)" onclick="paging_reviewsnippets_all_my( '.($start1 ? $start1 : 0).' )">'.$par.'</a>';
							} elseif($_admin){
								$currentIndex = $data['currentIndex'];
								$token = $data['token'];
								$res .= '<a href="'.$currentIndex.'&page_rev='.($start1 ? $start1 : 0).$token.'" >'.$par.'</a>';
							}else {
								$res .= '<a href="javascript:void(0)" onclick="paging_reviewsnippets( '.($start1 ? $start1 : 0).','.$id_product.' )">'.$par.'</a>';
							}
						}
				}
		
		$res .= '</span>';
		$res .= '</div>';
		
		return $res;
	}
	
public function getfacebooklocale()
	{
		$locales = array();

		if (($xml=simplexml_load_file(_PS_MODULE_DIR_ . $this->_name_module."/lib/facebook_locales.xml")) === false)
			return $locales;
			
		$result = $xml->xpath('/locales/locale/codes/code/standard/representation');

		foreach ($result as $locale)
		{
			list($k, $node) = each($locale);
			$locales[] = $node;
		}
			
		return $locales;
	}
	
 	public function getfacebooklib($id_lang){
    	
    	$lang = new Language((int)$id_lang);
		
    	$lng_code = isset($lang->language_code)?$lang->language_code:$lang->iso_code;
    	if(strstr($lng_code, '-')){
			$res = explode('-', $lng_code);
			$language_iso = strtolower($res[0]).'_'.strtoupper($res[1]);
			$rss_language_iso = strtolower($res[0]);
		} else {
			$language_iso = strtolower($lng_code).'_'.strtoupper($lng_code);
			$rss_language_iso = $lng_code;
		}
			
			
		if (!in_array($language_iso, $this->getfacebooklocale()))
			$language_iso = "en_US";
		
		if (Configuration::get('PS_SSL_ENABLED') == 1)
			$url = "https://";
		else
			$url = "http://";
		
		
		
		return array('url'=>$url . 'connect.facebook.net/'.$language_iso.'/all.js#xfbml=1',
					  'lng_iso' => $language_iso, 'rss_language_iso' => $rss_language_iso);
    }
	
}