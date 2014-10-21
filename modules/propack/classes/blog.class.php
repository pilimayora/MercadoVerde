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

class bloghelp extends Module{
	
	private $_width = 400;
	private $_height = 400;
	private $_name = 'propack';
	private $_id_shop;
	private $_is15;
	private $_is_rewriting_settings;
	private $_lang_iso;
	private $_http_host;
	
	public function __construct(){
		if(version_compare(_PS_VERSION_, '1.5', '>')){
			$this->_id_shop = Context::getContext()->shop->id;
			$this->_is15 = 1;
		} else {
			$this->_id_shop = 1;
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
	    global $smarty, $cookie;
	    $this->context = new StdClass();
	    $this->context->smarty = $smarty;
	    $this->context->cookie = $cookie;
	  }
	}
	
	public function saveCategory($data){
		
		
		$ids_shops = implode(",",$data['cat_shop_association']);
		
		$sql = 'INSERT into `'._DB_PREFIX_.'blog_category` SET
							   `ids_shops` = "'.$ids_shops.'",
							   `time_add` = NULL
							   ';
		
		$result = Db::getInstance()->Execute($sql);
		
		$post_id = Db::getInstance()->Insert_ID();
		
		foreach($data['data_title_content_lang'] as $language => $item){
		
		$category_title = $item['category_title'];
		$category_seokeywords = $item['category_seokeywords'];
		$category_seodescription = $item['category_seodescription'];
		
		$seo_url_pre = strlen($item['seo_url'])>0?$item['seo_url']:$category_title;
	    $seo_url = $this->_translit($seo_url_pre);
		
	    /*$sql = 'SELECT count(*) as count
				FROM `'._DB_PREFIX_.'blog_category_data` pc
				WHERE seo_url = "'.$seo_url.'"';
		$data_seo_url = Db::getInstance()->GetRow($sql);
		if($data_seo_url['count']!=0)
			$seo_url = "category".strtolower(Tools::passwdGen(6));*/
		
		$sql = 'INSERT into `'._DB_PREFIX_.'blog_category_data` SET
							   `id_item` = \''.pSQL($post_id).'\',
							   `id_lang` = \''.pSQL($language).'\',
							   `title` = \''.pSQL($category_title).'\',
							   `seo_keywords` = \''.pSQL($category_seokeywords).'\',
							   `seo_description` = \''.pSQL($category_seodescription).'\',
							   `seo_url` = \''.pSQL($seo_url).'\'
							   ';
		
		$result = Db::getInstance()->Execute($sql);
		
		}
		
		
	}
	
	public function updateCategory($data){
		
		$id = (int)$data['id_editcategory'];
		
		$ids_shops = implode(",",$data['cat_shop_association']);
		
		$sql_update = 'UPDATE `'._DB_PREFIX_.'blog_category` SET 
						`ids_shops` = "'.$ids_shops.'" 
						WHERE id ='.$id;
		Db::getInstance()->Execute($sql_update);
		
		/// delete tabs data
		$sql = 'DELETE FROM `'._DB_PREFIX_.'blog_category_data` WHERE id_item = '.$id.'';
		$result = Db::getInstance()->Execute($sql);
		
		foreach($data['data_title_content_lang'] as $language => $item){
		
		$category_title = $item['category_title'];
		$category_seokeywords = $item['category_seokeywords'];
		$category_seodescription = $item['category_seodescription'];
		
		$seo_url_pre = strlen($item['seo_url'])>0?$item['seo_url']:$category_title;
	    $seo_url = $this->_translit($seo_url_pre);
		
		/*$sql = 'SELECT count(*) as count
				FROM `'._DB_PREFIX_.'blog_category_data` pc
				WHERE seo_url = "'.$seo_url.'"';
		$data_seo_url = Db::getInstance()->GetRow($sql);
		if($data_seo_url['count']!=0)
			$seo_url = "category".strtolower(Tools::passwdGen(6));*/
			
		$sql = 'INSERT into `'._DB_PREFIX_.'blog_category_data` SET
							   `id_item` = \''.pSQL($id).'\',
							   `id_lang` = \''.pSQL($language).'\',
							   `title` = \''.pSQL($category_title).'\',
							   `seo_keywords` = \''.pSQL($category_seokeywords).'\',
							   `seo_description` = \''.pSQL($category_seodescription).'\',
							   `seo_url` = \''.pSQL($seo_url).'\'
							   
							   ';
		$result = Db::getInstance()->Execute($sql);
		
		}
		
	}
	
	
private function  _translit( $str )
	{
    $str  = str_replace(array("®","'",'"','`','?','!','.','=',':','&','+',',','’', ')', '(', '$', '{', '}'), array(''), $str );
		
	$arrru = array ("А","а","Б","б","В","в","Г","г","Д","д","Е","е","Ё","ё","Ж","ж","З","з","И","и","Й","й","К","к","Л","л","М","м","Н","н", "О","о","П","п","Р","р","С","с","Т","т","У","у","Ф","ф","Х","х","Ц","ц","Ч","ч","Ш","ш","Щ","щ","Ъ","ъ","Ы","ы","Ь", "ь","Э","э","Ю","ю","Я","я",
    " ","-",",","«","»","+","/","(",")",".");

    $arren = array ("a","a","b","b","v","v","g","g","d","d","e","e","e","e","zh","zh","z","z","i","i","y","y","k","k","l","l","m","m","n","n", "o","o","p","p","r","r","s","s","t","t","u","u","ph","f","h","h","c","c","ch","ch","sh","sh","sh","sh","","","i","i","","","e", "e","yu","yu","ya","ya",
    "-","-","","","","","","","","");

	$textout = '';
    $textout = str_replace($arrru,$arren,$str);
    
    $textout = str_replace("--","-",$textout);
    
    $separator = "-";
    $accents_regex = '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i';
    $special_cases = array( '&' => 'and');
    $textout = mb_strtolower( trim( $textout ), 'UTF-8' );
    $textout = str_replace( array_keys($special_cases), array_values( $special_cases), $textout );
    $textout = preg_replace( $accents_regex, '$1', htmlentities( $textout, ENT_QUOTES, 'UTF-8' ) );
    $textout = preg_replace("/[^a-z0-9]/u", "$separator", $textout);
    $textout = preg_replace("/[$separator]+/u", "$separator", $textout);
    
    if(strlen($textout)==0)
    	$textout = strtolower(Tools::passwdGen(6));
    	
     return strtolower($textout);
	}
	
	public function deleteCategory($data){
		
		$id = $data['id'];
		
		$sql = 'DELETE FROM `'._DB_PREFIX_.'blog_category`
							   WHERE id ='.$id.'';
		$result = Db::getInstance()->Execute($sql);
		
		$sql = 'DELETE FROM `'._DB_PREFIX_.'blog_category_data`
							   WHERE id_item ='.$id.'';
		$result = Db::getInstance()->Execute($sql);
		
		// get all posts_id for category //
		$sql = '
			SELECT post_id 
			FROM  `'._DB_PREFIX_.'blog_category2post` c2p
			WHERE c2p.category_id = '.$id.'';
		$posts_ids = Db::getInstance()->ExecuteS($sql);
		
		// delete post_id x category_id
		$tmp_array_posts_ids = array();
		foreach($posts_ids as $k1=>$_item){
				$id_post = $_item['post_id'];
				$tmp_array_posts_ids[] = $id_post;
				
					$sql = 'DELETE FROM `'._DB_PREFIX_.'blog_category2post`
								   WHERE post_id = '.$id_post.' AND 
								   category_id = '.$id.'';
					
				    Db::getInstance()->Execute($sql);
		}

		// delete empty posts
		foreach($tmp_array_posts_ids as $item){
			$data_count = Db::getInstance()->getRow('
			SELECT COUNT(*) AS "count"
			FROM `'._DB_PREFIX_.'blog_category2post` c2p
			WHERE c2p.post_id = '.$item.' 
			');
			
			if($data_count['count'] == 0){
				$sql = 'DELETE FROM `'._DB_PREFIX_.'blog_post`
							   WHERE id ='.$item.'';
				Db::getInstance()->Execute($sql);
					
				$sql = 'DELETE FROM `'._DB_PREFIX_.'blog_post_data`
							   WHERE id_item ='.$item.'';
				Db::getInstance()->Execute($sql);
				
			}
		}
		
	}
	
	public function getTransformSEOURLtoID($_data){
		
	if(Configuration::get($this->_name.'urlrewrite_on') == 1 && !is_numeric($_data['id'])){
			$id = $_data['id'];
			$sql = '
					SELECT pc.id_item as id
					FROM `'._DB_PREFIX_.'blog_category_data` pc
					WHERE seo_url = "'.$id.'"';
			$data_id = Db::getInstance()->GetRow($sql);
			$id = $data_id['id'];
		} else {
			$id = (int)$_data['id'];
		}
		
		return $id;
	}
	
	public function getSEOURLForCategory($_data){
		
			$id = $_data['id'];
			$sql = '
					SELECT pc.seo_url
					FROM `'._DB_PREFIX_.'blog_category_data` pc
					WHERE id_item = "'.$id.'"';
			$data_id = Db::getInstance()->GetRow($sql);
			$id = $data_id['seo_url'];
		return $id;
	}
	
	public function getTransformSEOURLtoIDPost($_data){
		//var_dump(is_numeric($_data['id']));
	if(Configuration::get($this->_name.'urlrewrite_on') == 1 && !is_numeric($_data['id'])){
			$id = $_data['id'];
			$sql = '
					SELECT pc.id_item as id
					FROM `'._DB_PREFIX_.'blog_post_data` pc
					WHERE seo_url = "'.$id.'"';
			$data_id = Db::getInstance()->GetRow($sql);
			$id = $data_id['id'];
		} else {
			$id = (int)$_data['id'];
		}
		
		return $id;
	}
	
	public function getSEOURLForPost($_data){
			$id = $_data['id'];
			$sql = '
					SELECT pc.seo_url
					FROM `'._DB_PREFIX_.'blog_post_data` pc
					WHERE id_item = "'.$id.'"';
			$data_id = Db::getInstance()->GetRow($sql);
			$id = $data_id['seo_url'];
		
		return $id;
	}
	
	
public function getIdPostifFriendlyURLEnable($data){
			$seo_url = $data['seo_url'];
		    $id_lang = $data['id_lang'];
			$sql = '
					SELECT pc.id_item as id_post
					FROM `'._DB_PREFIX_.'blog_post_data` pc
					WHERE pc.seo_url = "'.$seo_url.'" and pc.id_lang = '.$id_lang;
			//echo $sql;
			$data_id = Db::getInstance()->GetRow($sql);
			$id_post = $data_id['id_post'];
			
			return $id_post;
	}
	
	public function getSEOFriendlyURLifFriendlyURLEnable($data){
			$id_post = $data['id_post'];
		    $id_lang = $data['id_lang'];
			$sql = '
					SELECT pc.seo_url
					FROM `'._DB_PREFIX_.'blog_post_data` pc
					WHERE pc.id_item = "'.$id_post.'" and pc.id_lang = '.$id_lang;
			//echo $sql;exit;
			$data_id = Db::getInstance()->GetRow($sql);
			$seo_url = $data_id['seo_url'];
			
			return $seo_url;
	}
	
	public function getIdCatifFriendlyURLEnable($data){
			$seo_url = $data['seo_url'];
		    $id_lang = $data['id_lang'];
			$sql = '
					SELECT pc.id_item as id_cat
					FROM `'._DB_PREFIX_.'blog_category_data` pc
					WHERE pc.seo_url = "'.$seo_url.'" and pc.id_lang = '.$id_lang;
			//echo $sql;
			$data_id = Db::getInstance()->GetRow($sql);
			$id_post = $data_id['id_cat'];
			
			return $id_post;
	}
	
	public function getSEOFriendlyURLifFriendlyURLEnableCat($data){
			$id_post = $data['id_cat'];
		    $id_lang = $data['id_lang'];
			$sql = '
					SELECT pc.seo_url
					FROM `'._DB_PREFIX_.'blog_category_data` pc
					WHERE pc.id_item = "'.$id_post.'" and pc.id_lang = '.$id_lang;
			//echo $sql;exit;
			$data_id = Db::getInstance()->GetRow($sql);
			$seo_url = $data_id['seo_url'];
			
			return $seo_url;
	}
	
	public function getCategoryItem($_data){
		$id = $_data['id'];
		$admin = isset($_data['admin'])?$_data['admin']:0;
		
		if($admin == 1){
				$sql = '
					SELECT pc.*
					FROM `'._DB_PREFIX_.'blog_category` pc
					WHERE id = '.$id;
			$item = Db::getInstance()->ExecuteS($sql);
			
			foreach($item as $k => $_item){
				
				$items_data = Db::getInstance()->ExecuteS('
				SELECT pc.*
				FROM `'._DB_PREFIX_.'blog_category_data` pc
				WHERE pc.id_item = '.$_item['id'].'
				');
				
				foreach ($items_data as $item_data){
		    			$item['data'][$item_data['id_lang']]['title'] = $item_data['title'];
		    			$item['data'][$item_data['id_lang']]['seo_description'] = $item_data['seo_description'];
		    			$item['data'][$item_data['id_lang']]['seo_keywords'] = $item_data['seo_keywords'];
		    			$item['data'][$item_data['id_lang']]['seo_url'] = $item_data['seo_url'];
		    	}
		    	
			}
		} else {
			$cookie = $this->context->cookie;
			$current_language = (int)$cookie->id_lang;
			
			
				$sql = '
					SELECT pc.*
					FROM `'._DB_PREFIX_.'blog_category` pc
					LEFT JOIN `'._DB_PREFIX_.'blog_category_data` pc1
					ON(pc1.id_item = pc.id)
					WHERE pc.`id` = '.$id.' AND pc1.id_lang = '.$current_language;
			
			$item = Db::getInstance()->ExecuteS($sql);
			
			foreach($item as $k => $_item){
				
				$items_data = Db::getInstance()->ExecuteS('
				SELECT pc.*
				FROM `'._DB_PREFIX_.'blog_category_data` pc
				WHERE pc.id_item = '.$_item['id'].'
				');
				
				foreach ($items_data as $item_data){
		    		
		    		if($current_language == $item_data['id_lang']){
		    			$item[$k]['title'] = $item_data['title'];
		    			$item[$k]['seo_description'] = $item_data['seo_description'];
		    			$item[$k]['seo_keywords'] = $item_data['seo_keywords'];
		    			$item[$k]['seo_url'] = $item_data['seo_url'];
		    			
		    		}
		    	}
		    }
			
		}
		//var_dump($item);
	   return array('category' => $item);
	}
	
public function getCategories($_data){
		$admin = isset($_data['admin'])?$_data['admin']:null;
		$items = array();
		if($admin){
			$start = isset($_data['start'])?$_data['start']:'';
			$step = isset($_data['step'])?$_data['step']:'';
			
			$cookie = $this->context->cookie;
			$current_language = (int)$cookie->id_lang;
			
			
			if(strlen($start)>0 && strlen($step)>0){
				$sql = '
				SELECT pc.*,
				(select count(*) as count from `'._DB_PREFIX_.'blog_post` pc1 
				    LEFT JOIN `'._DB_PREFIX_.'blog_category2post` c2p
				    ON(pc1.id = c2p.post_id)
				    WHERE c2p.category_id = pc.id ) as count_posts
				FROM `'._DB_PREFIX_.'blog_category` pc
				ORDER BY pc.`id` DESC LIMIT '.$start.' ,'.$step.'';
			//	echo $sql;
			} else {
				$sql = '
				SELECT pc.*,
				(select count(*) as count from `'._DB_PREFIX_.'blog_post` pc1 
				    LEFT JOIN `'._DB_PREFIX_.'blog_category2post` c2p
				    ON(pc1.id = c2p.post_id)
				    WHERE c2p.category_id = pc.id ) as count_posts
				FROM `'._DB_PREFIX_.'blog_category` pc
				ORDER BY pc.`id` DESC';
			}
			$categories = Db::getInstance()->ExecuteS($sql);
			
			
			foreach($categories as $k => $_item){
				$items_data = Db::getInstance()->ExecuteS('
				SELECT pc.*
				FROM `'._DB_PREFIX_.'blog_category_data` pc
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
		    	
		    	$items[$k]['count_posts'] = $categories[$k]['count_posts'];
		    	
		    	// languages
		    	$items[$k]['ids_lng'] = $languages_tmp_array;
			}
			
			$data_count_categories = Db::getInstance()->getRow('
			SELECT COUNT(`id`) AS "count"
			FROM `'._DB_PREFIX_.'blog_category` 
			');
			
		} else{
			
			$start = $_data['start'];
			$step = (int)$_data['step'];
			
			$cookie = $this->context->cookie;
			$current_language = (int)$cookie->id_lang;
			
			$items_tmp = Db::getInstance()->ExecuteS('
			SELECT pc.*,
				   (select count(*) as count from `'._DB_PREFIX_.'blog_post` pc1 
				    LEFT JOIN `'._DB_PREFIX_.'blog_category2post` c2p
				    ON(pc1.id = c2p.post_id)
				    LEFT JOIN `'._DB_PREFIX_.'blog_post_data` bpd
				    ON(bpd.id_item = pc1.id)
					WHERE c2p.category_id = pc.id AND bpd.id_lang = '.$current_language.'
					AND pc1.status = 1 AND FIND_IN_SET('.$this->_id_shop.',pc1.ids_shops)) as count_posts
			FROM `'._DB_PREFIX_.'blog_category` pc
			LEFT JOIN `'._DB_PREFIX_.'blog_category_data` pc_d
			on(pc.id = pc_d.id_item)
			WHERE pc_d.id_lang = '.$current_language.'  AND FIND_IN_SET('.$this->_id_shop.',pc.ids_shops)
			ORDER BY pc.`time_add` DESC LIMIT '.$start.' ,'.$step.'');	
			
			$items = array();
			
			foreach($items_tmp as $k => $_item){
				
				$items_data = Db::getInstance()->ExecuteS('
				SELECT pc.*
				FROM `'._DB_PREFIX_.'blog_category_data` pc
				WHERE pc.id_item = '.$_item['id'].'
				');
				
				
				
				foreach ($items_data as $item_data){
		    		
		    		if($current_language == $item_data['id_lang']){
		    			$items[$k]['title'] = $item_data['title'];
		    			$items[$k]['seo_description'] = $item_data['seo_description'];
		    			$items[$k]['seo_keywords'] = $item_data['seo_keywords'];
		    			$items[$k]['count_posts'] = $_item['count_posts'];
		    			$items[$k]['id'] = $_item['id'];
		    			$items[$k]['time_add'] = $_item['time_add'];
		    			$items[$k]['seo_url'] = $item_data['seo_url'];
		    		} 
		    	}
		    }
			
			$data_count_categories = Db::getInstance()->getRow('
			SELECT COUNT(pc.`id`) AS "count"
			FROM `'._DB_PREFIX_.'blog_category` pc LEFT JOIN `'._DB_PREFIX_.'blog_category_data` pc_d
			on(pc.id = pc_d.id_item)
			WHERE pc_d.id_lang = '.$current_language.'  AND FIND_IN_SET('.$this->_id_shop.',pc.ids_shops)
			');
		}	
		return array('categories' => $items, 'count_all' => $data_count_categories['count'] );
	}
	
	public function  getPosts($_data){
		$admin = isset($_data['admin'])?$_data['admin']:null;
		
		$id = isset($_data['id'])?$_data['id']:0;
		
		if($admin == 1){
			$sql = '
			SELECT pc.*,
			(select count(*) as count from `'._DB_PREFIX_.'blog_comments` pc1 
				    WHERE pc1.id_post = pc.id) as count_comments
			FROM `'._DB_PREFIX_.'blog_post` pc LEFT JOIN `'._DB_PREFIX_.'blog_category2post` c2p
			ON(pc.id = c2p.post_id)
			WHERE c2p.category_id = '.$id.' 
			ORDER BY pc.`id` DESC';
			$items = Db::getInstance()->ExecuteS($sql);
			
			foreach($items as $k => $_item){
				
				$items_data = Db::getInstance()->ExecuteS('
				SELECT pc.*
				FROM `'._DB_PREFIX_.'blog_post_data` pc
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
		    	
		    	// languages
		    	$items[$k]['ids_lng'] = $languages_tmp_array;
		    	
		    	if(@strlen($items[$k]['title'])==0)
		    		$items[$k]['title'] = $tmp_title;
		    	
				}
			
			
			$data_count_posts = Db::getInstance()->getRow('
			SELECT COUNT(`id`) AS "count"
			FROM `'._DB_PREFIX_.'blog_post`  as pc LEFT JOIN `'._DB_PREFIX_.'blog_category2post` c2p
			ON(pc.id = c2p.post_id)
			WHERE c2p.category_id = '.$id.'
			');
			
		} elseif($admin == 2){
			$start = $_data['start'];
			$step = $_data['step'];
			
			$items = Db::getInstance()->ExecuteS('
			SELECT pc.*,
			(select count(*) as count from `'._DB_PREFIX_.'blog_comments` pc1 
				    WHERE pc1.id_post = pc.id) as count_comments
			FROM `'._DB_PREFIX_.'blog_post` pc 
			ORDER BY pc.`id` DESC  LIMIT '.$start.' ,'.$step.'');
			
			
			foreach($items as $k => $_item){
				
				$items_data = Db::getInstance()->ExecuteS('
				SELECT pc.*
				FROM `'._DB_PREFIX_.'blog_post_data` pc
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
		    	
		    	
				}
			
			$data_count_posts = Db::getInstance()->getRow('
			SELECT COUNT(`id`) AS "count"
			FROM `'._DB_PREFIX_.'blog_post`  as pc
			');
		} else{
			$start = $_data['start'];
			$step = $_data['step'];
			
			$cookie = $this->context->cookie;
			$current_language = (int)$cookie->id_lang;
			
			
			$sql = '
			SELECT pc.* ,
				(select count(*) as count from `'._DB_PREFIX_.'blog_comments` c2pc 
				 where c2pc.id_post = pc.id and c2pc.status = 1 and c2pc.id_shop = '.$this->_id_shop.' 
				 and c2pc.id_lang = '.$current_language.' ) 
				 as count_comments
			FROM `'._DB_PREFIX_.'blog_post` pc LEFT JOIN `'._DB_PREFIX_.'blog_category2post` c2p
			ON(pc.id = c2p.post_id)
			LEFT JOIN `'._DB_PREFIX_.'blog_post_data` pc_d
			on(pc.id = pc_d.id_item)
			WHERE pc.status = 1 and pc_d.id_lang = '.$current_language.' AND c2p.category_id = '.$id.' 
			AND FIND_IN_SET('.$this->_id_shop.',pc.ids_shops)
			ORDER BY pc.`time_add` DESC LIMIT '.$start.' ,'.$step.'';
			
			
			$items = Db::getInstance()->ExecuteS($sql);	
			
			foreach($items as $k1=>$_item){
				$id_post = $_item['id'];
				
				if(strlen($_item['img'])>0){
					$this->generateThumbImages(array('img'=>$_item['img'], 
		    												 'width'=>Configuration::get($this->_name.'lists_img_width'),
		    												 'height'=>Configuration::get($this->_name.'lists_img_width') 
		    												)
		    											);
		    		$img = substr($_item['img'],0,-4)."-".Configuration::get($this->_name.'lists_img_width')."x".Configuration::get($this->_name.'lists_img_width').".jpg";
		    	} else {
		    		$img = $_item['img'];
				}
		    		
		    	$items[$k1]['img'] = $img;
				
				$category_ids = Db::getInstance()->ExecuteS('
				SELECT pc.category_id
				FROM `'._DB_PREFIX_.'blog_category2post` pc
				WHERE pc.`post_id` = '.$id_post.'');
				$data_category_ids = array();
				foreach($category_ids as $k => $v){
					$_info_ids = $this->getCategoryItem(array('id' => $v['category_id']));
					$ids_item = sizeof(@$_info_ids['category'][0])>0?$_info_ids['category'][0]:array();
					//var_dump($ids_item); echo "<br><hr><br>";
					if(sizeof($ids_item)>0){
					$data_category_ids[] = $ids_item;
					}
				}
				
				$items[$k1]['category_ids'] = $data_category_ids;
				
				$items_data = Db::getInstance()->ExecuteS('
				SELECT pc.*
				FROM `'._DB_PREFIX_.'blog_post_data` pc
				WHERE pc.id_item = '.$_item['id'].'
				');
				
				foreach ($items_data as $item_data){
		    		
		    		if($current_language == $item_data['id_lang']){
		    			$items[$k1]['title'] = $item_data['title'];
		    			$items[$k1]['seo_description'] = $item_data['seo_description'];
		    			$items[$k1]['seo_keywords'] = $item_data['seo_keywords'];
		    			$items[$k1]['content'] = $item_data['content'];
		    			$items[$k1]['id'] = $_item['id'];
		    			$items[$k1]['time_add'] = $_item['time_add'];
		    			$items[$k1]['seo_url'] = $item_data['seo_url'];
		    		} 
		    	}
				
			}
			
			$sql = '
			SELECT COUNT(`id`) AS "count"
			FROM `'._DB_PREFIX_.'blog_post` pc LEFT JOIN `'._DB_PREFIX_.'blog_category2post` c2p
			ON(pc.id = c2p.post_id)
			LEFT JOIN `'._DB_PREFIX_.'blog_post_data` pc_d
			on(pc.id = pc_d.id_item )
			WHERE c2p.category_id = '.$id.' and pc_d.id_lang = '.$current_language.' 
			AND pc.status = 1 AND FIND_IN_SET('.$this->_id_shop.',pc.ids_shops)
			';
			
			$data_count_posts = Db::getInstance()->getRow($sql);
		}	
		return array('posts' => $items, 'count_all' => $data_count_posts['count'] );
	}
	
	
	public function  getAllPosts($_data){
		
			$start = $_data['start'];
			$step = $_data['step'];
			$is_search = isset($_data['is_search'])?$_data['is_search']:0;
			$search = isset($_data['search'])?$_data['search']:'';
			$is_arch = isset($_data['is_arch'])?$_data['is_arch']:0;
			$month = isset($_data['month'])?$_data['month']:0;
			$year = isset($_data['year'])?$_data['year']:0;

			$sql_condition = '';
			if($is_search == 1){
				$sql_condition = "AND (
	    		   LOWER(pc_d.title) LIKE BINARY LOWER('%".pSQL(trim($search))."%')
	    		   OR
	    		   LOWER(pc_d.content) LIKE BINARY LOWER('%".pSQL(trim($search))."%')
	    		   ) ";
			}
			
			if($is_arch == 1){
				$sql_condition = 'AND YEAR(pc.time_add) = "'.$year.'" AND
    							  MONTH(pc.time_add) = "'.$month.'"';
			}
			
			$cookie = $this->context->cookie;
			$current_language = (int)$cookie->id_lang;
			
			
			$sql = '
			SELECT pc.* ,
				(select count(*) as count from `'._DB_PREFIX_.'blog_comments` c2pc 
				 where c2pc.id_post = pc.id and c2pc.status = 1 and c2pc.id_shop = '.$this->_id_shop.' 
				 and c2pc.id_lang = '.$current_language.' ) 
				 as count_comments
			FROM `'._DB_PREFIX_.'blog_post` pc 
			LEFT JOIN `'._DB_PREFIX_.'blog_post_data` pc_d
			on(pc.id = pc_d.id_item)
			WHERE pc.status = 1 and pc_d.id_lang = '.$current_language.'
			AND FIND_IN_SET('.$this->_id_shop.',pc.ids_shops) '.$sql_condition.'
			ORDER BY pc.`time_add` DESC LIMIT '.$start.' ,'.$step.'';
			
			$items = Db::getInstance()->ExecuteS($sql);	
			
			foreach($items as $k1=>$_item){
				$id_post = $_item['id'];
				
				if(strlen($_item['img'])>0){
					$this->generateThumbImages(array('img'=>$_item['img'], 
		    												 'width'=>Configuration::get($this->_name.'lists_img_width'),
		    												 'height'=>Configuration::get($this->_name.'lists_img_width') 
		    												)
		    											);
		    		$img = substr($_item['img'],0,-4)."-".Configuration::get($this->_name.'lists_img_width')."x".Configuration::get($this->_name.'lists_img_width').".jpg";
		    	} else {
		    		$img = $_item['img'];
				}
		    		
		    	$items[$k1]['img'] = $img;
				
				$category_ids = Db::getInstance()->ExecuteS('
				SELECT pc.category_id
				FROM `'._DB_PREFIX_.'blog_category2post` pc
				WHERE pc.`post_id` = '.$id_post.'');
				$data_category_ids = array();
				foreach($category_ids as $k => $v){
					$_info_ids = $this->getCategoryItem(array('id' => $v['category_id']));
					$ids_item = sizeof(@$_info_ids['category'][0])>0?$_info_ids['category'][0]:array();
					
					if(sizeof($ids_item)>0){
					$data_category_ids[] = $ids_item;
					}
				}
				
				$items[$k1]['category_ids'] = $data_category_ids;
				
				$items_data = Db::getInstance()->ExecuteS('
				SELECT pc.*
				FROM `'._DB_PREFIX_.'blog_post_data` pc
				WHERE pc.id_item = '.$_item['id'].'
				');
				
				foreach ($items_data as $item_data){
		    		
		    		if($current_language == $item_data['id_lang']){
		    			$items[$k1]['title'] = $item_data['title'];
		    			$items[$k1]['seo_description'] = $item_data['seo_description'];
		    			$items[$k1]['seo_keywords'] = $item_data['seo_keywords'];
		    			$items[$k1]['content'] = $item_data['content'];
		    			$items[$k1]['id'] = $_item['id'];
		    			$items[$k1]['time_add'] = $_item['time_add'];
		    			$items[$k1]['seo_url'] = $item_data['seo_url'];
		    		} 
		    	}
				
			}
			
			$sql = '
			SELECT COUNT(`id`) AS "count"
			FROM `'._DB_PREFIX_.'blog_post` pc 
			LEFT JOIN `'._DB_PREFIX_.'blog_post_data` pc_d
			on(pc.id = pc_d.id_item )
			WHERE  pc_d.id_lang = '.$current_language.' 
			AND pc.status = 1 AND FIND_IN_SET('.$this->_id_shop.',pc.ids_shops) '.$sql_condition.'
			';
			
			$data_count_posts = Db::getInstance()->getRow($sql);
		
		return array('posts' => $items, 'count_all' => $data_count_posts['count'] );
	}
	
	
	public function savePost($data){

		$ids_shops = implode(",",$data['cat_shop_association']);
		
		$time_add = date('Y-m-d',strtotime($data['time_add']));
		
		$ids_categories = sizeof($data['ids_categories'])>0?$data['ids_categories']:array();
		$post_status = $data['post_status'];
		$post_iscomments = $data['post_iscomments'];
		
		$sql = 'INSERT into `'._DB_PREFIX_.'blog_post` SET
							   `status` = \''.pSQL($post_status).'\',
							   `is_comments` = \''.pSQL($post_iscomments).'\',
							   `ids_shops` = "'.$ids_shops.'",
							   `time_add` = "'.$time_add.'"
							   ';
		Db::getInstance()->Execute($sql);
		
		$post_id = Db::getInstance()->Insert_ID();
		
		foreach($data['data_title_content_lang'] as $language => $item){
		
		$post_title = $item['post_title'];
		$post_seokeywords = $item['post_seokeywords'];
		$post_seodescription = $item['post_seodescription'];
		$post_content = $item['post_content'];
		
		$seo_url_pre = strlen($item['seo_url'])>0?$item['seo_url']:$post_title;
	    $seo_url = $this->_translit($seo_url_pre);
		
		
		/*$sql = 'SELECT count(*) as count
				FROM `'._DB_PREFIX_.'blog_post_data` pc
				WHERE seo_url = "'.mysql_escape_string($seo_url).'"';
		$data_seo_url = Db::getInstance()->GetRow($sql);
		
		if($data_seo_url['count'] != 0)
			$seo_url = "post".strtolower(Tools::passwdGen(6));*/
		
		$sql = 'INSERT into `'._DB_PREFIX_.'blog_post_data` SET
							   `id_item` = \''.pSQL($post_id).'\',
							   `id_lang` = \''.pSQL($language).'\',
							   `title` = \''.pSQL($post_title).'\',
							   `seo_keywords` = \''.pSQL($post_seokeywords).'\',
							   `seo_description` = \''.pSQL($post_seodescription).'\',
							   `content` = "'.mysql_escape_string($post_content).'",
							   `seo_url` = "'.pSQL($seo_url).'"
							   ';
		
		
		Db::getInstance()->Execute($sql);
		
		}
		
		
		$this->saveImage(array('post_id' => $post_id));
		
		foreach($ids_categories as $id_cat){
			$sql = 'INSERT into `'._DB_PREFIX_.'blog_category2post` SET
							   `category_id` = \''.pSQL($id_cat).'\',
							   `post_id` = \''.pSQL($post_id).'\'
							   ';
			Db::getInstance()->Execute($sql);
			
		}
		
	}
	
	public function updatePost($data){
		$ids_shops = implode(",",$data['cat_shop_association']);
		
		$time_add = date('Y-m-d',strtotime($data['time_add']));
		
		$id_editposts = $data['id_editposts'];
		
		$ids_categories = $data['ids_categories'];
		$post_status = $data['post_status'];
		$post_iscomments = $data['post_iscomments'];
		$post_images = $data['post_images'];
		
		// update
		$sql = 'UPDATE `'._DB_PREFIX_.'blog_post` SET
							  `status` = \''.pSQL($post_status).'\',
							   `is_comments` = \''.pSQL($post_iscomments).'\',
							   `ids_shops` = "'.$ids_shops.'",
							   `time_add` = "'.$time_add.'"
							    WHERE id = '.$id_editposts.'
							   ';
	
	 	Db::getInstance()->Execute($sql);
		
		/// delete tabs data
		$sql = 'DELETE FROM `'._DB_PREFIX_.'blog_post_data` WHERE id_item = '.$id_editposts.'';
		Db::getInstance()->Execute($sql);
		
		foreach($data['data_title_content_lang'] as $language => $item){
		
		$post_title = $item['post_title'];
		$post_seokeywords = $item['post_seokeywords'];
		$post_seodescription = $item['post_seodescription'];
		$post_content = $item['post_content'];
		
		$seo_url_pre = strlen($item['seo_url'])>0?$item['seo_url']:$post_title;
	    $seo_url = $this->_translit($seo_url_pre);
		
		/*$sql = 'SELECT count(*) as count
				FROM `'._DB_PREFIX_.'blog_post_data` pc
				WHERE seo_url = "'.$seo_url.'"';
		$data_seo_url = Db::getInstance()->GetRow($sql);
		if($data_seo_url['count']!=0)
			$seo_url = "post".strtolower(Tools::passwdGen(6));*/
		
		$sql = 'INSERT into `'._DB_PREFIX_.'blog_post_data` SET
							   `id_item` = \''.pSQL($id_editposts).'\',
							   `id_lang` = \''.pSQL($language).'\',
							   `title` = \''.pSQL($post_title).'\',
							   `seo_keywords` = \''.pSQL($post_seokeywords).'\',
							   `seo_description` = \''.pSQL($post_seodescription).'\',
							   `content` = "'.mysql_escape_string($post_content).'",
							   `seo_url` = \''.pSQL($seo_url).'\'
							   ';
			$result = Db::getInstance()->Execute($sql);
		
		}
		
		
		$this->saveImage(array('post_id' => $id_editposts,'post_images' => $post_images ));
		
		$sql = 'DELETE FROM `'._DB_PREFIX_.'blog_category2post`
					   WHERE `post_id` = \''.pSQL($id_editposts).'\'';
		Db::getInstance()->Execute($sql);
		
		foreach($ids_categories as $id_cat){
			$sql = 'INSERT into `'._DB_PREFIX_.'blog_category2post` SET
							   `category_id` = \''.pSQL($id_cat).'\',
							   `post_id` = \''.pSQL($id_editposts).'\'
							   ';
			Db::getInstance()->Execute($sql);
		
		}
		
	}
	
	
	public function saveImage($data = null){
		
		$error = 0;
		$error_text = '';
		
		$post_id = $data['post_id'];
		$post_images = isset($data['post_images'])?$data['post_images']:'';
		
		$files = $_FILES['post_image'];
		
		############### files ###############################
		if(!empty($files['name']))
			{
		      if(!$files['error'])
		      {
				  $type_one = $files['type'];
				  $ext = explode("/",$type_one);
				  
				  if(strpos('_'.$type_one,'image')<1)
				  {
				  	$error_text = $this->l('Invalid file type, please try again!');
				  	$error = 1;

				  }elseif(!in_array($ext[1],array('png','x-png','gif','jpg','jpeg','pjpeg'))){
				  	$error_text = $this->l('Wrong file format, please try again!');
				  	$error = 1;
				  	
				  } else {
				  	
				  	
				  		$info_post = $this->getPostItem(array('id'=>$post_id));
				  		$post_item = $info_post['post'][0];
				  		$img_post = $post_item['img'];
				  		
				  		
				  		if(strlen($img_post)>0){
				  			// delete old avatars
				  			$name_thumb = current(explode(".",$img_post));
				  			unlink(dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."upload".DIRECTORY_SEPARATOR."blockblog".DIRECTORY_SEPARATOR.$name_thumb.".jpg");
				  			
				  			$posts_block_img = dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."upload".DIRECTORY_SEPARATOR."blockblog".DIRECTORY_SEPARATOR.$name_thumb.'-'.Configuration::get($this->_name.'p_block_img_width').'x'.Configuration::get($this->_name.'p_block_img_width').'.jpg';
							@unlink($posts_block_img);
						
							$lists_img = dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."upload".DIRECTORY_SEPARATOR."blockblog".DIRECTORY_SEPARATOR.$name_thumb.'-'.Configuration::get($this->_name.'lists_img_width').'x'.Configuration::get($this->_name.'lists_img_width').'.jpg';
							@unlink($lists_img);
						
							$post_img = dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."upload".DIRECTORY_SEPARATOR."blockblog".DIRECTORY_SEPARATOR.$name_thumb.'-'.Configuration::get($this->_name.'post_img_width').'x'.Configuration::get($this->_name.'post_img_width').'.jpg';
							@unlink($post_img);
						
				  			
				  		} 
							
					  	srand((double)microtime()*1000000);
					 	$uniq_name_image = uniqid(rand());
					 	$type_one = substr($type_one,6,strlen($type_one)-6);
					 	$filename = $uniq_name_image.'.'.$type_one; 
					 	
						move_uploaded_file($files['tmp_name'], dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."upload".DIRECTORY_SEPARATOR."blockblog".DIRECTORY_SEPARATOR.$filename);
						
						
						$name_img = dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."upload".DIRECTORY_SEPARATOR."blockblog".DIRECTORY_SEPARATOR.$filename;
						$dir_without_ext = dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."upload".DIRECTORY_SEPARATOR."blockblog".DIRECTORY_SEPARATOR.$uniq_name_image;
						
						$this->copyImage(array('dir_without_ext'=>$dir_without_ext,
												'name'=>$name_img)
										);

										
						//Image in the block "Blog Posts recents"				
						$this->copyImage(array('dir_without_ext'=>$dir_without_ext,
											   'name'=>$name_img,
											   'width'=>Configuration::get($this->_name.'p_block_img_width'),
											   'height'=>Configuration::get($this->_name.'p_block_img_width')
											   )
										);
						// Image in the block "Blog Posts recents"
						
						// Image in lists posts				
						$this->copyImage(array('dir_without_ext'=>$dir_without_ext,
											   'name'=>$name_img,
											   'width'=>Configuration::get($this->_name.'lists_img_width'),
											   'height'=>Configuration::get($this->_name.'lists_img_width')
											   )
										);
						// Image in lists posts					
										
						// Image on post page			
						$this->copyImage(array('dir_without_ext'=>$dir_without_ext,
											   'name'=>$name_img,
											   'width'=>Configuration::get($this->_name.'post_img_width'),
											   'height'=>Configuration::get($this->_name.'post_img_width')
											   )
										);
						// Image on post page					
						
						// delete original image				
						@unlink(dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."upload".DIRECTORY_SEPARATOR."blockblog".DIRECTORY_SEPARATOR.$uniq_name_image.".".$ext[1]);
						
						
						
						$img_return = $uniq_name_image.'.jpg';
			  		
				  		$this->_updateImgToPost(array('post_id' => $post_id,
				  									  'img' =>  $img_return
				  									  )
				  								);

				  }
				}
				else
					{
					### check  for errors ####
			      	switch($files['error'])
						{
							case '1':
								$error_text = $this->l('The size of the uploaded file exceeds the').ini_get('upload_max_filesize').'b';
								break;
							case '2':
								$error_text = $this->l('The size of  the uploaded file exceeds the specified parameter  MAX_FILE_SIZE in HTML form.');
								break;
							case '3':
								$error_text = $this->l('Loaded only a portion of the file');
								break;
							case '4':
								$error_text = $this->l('The file was not loaded (in the form user pointed the wrong path  to the file). ');
								break;
							case '6':
								$error_text = $this->l('Invalid  temporary directory.');
								break;
							case '7':
								$error_text = $this->l('Error writing file to disk');
								break;
							case '8':
								$error_text = $this->l('File download aborted');
								break;
							case '999':
							default:
								$error_text = $this->l('Unknown error code!');
							break;
						}
						$error = 1;
			      	########
					   
					}
			}  else {
				//var_dump($post_images); exit;
				if($post_images != "on"){
				$this->_updateImgToPost(array('post_id' => $post_id,
				  							  'img' =>  ""
				  							  )
				  						);
				}
			}
			
		return array('error' => $error,
					 'error_text' => $error_text);
	
	
	}
	
	public function deleteImg($data = null){
		$id = $data['id'];
		$_data = $this->getPostItem(array('id'=>$id));
		$img = $_data['post'][0]['img'];
		
		$this->_updateImgToPost(array('post_id' => $id,
				  					  'img' =>  ""
				  					 )
				  				);
				  				
		@unlink(dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."upload".DIRECTORY_SEPARATOR."blockblog".DIRECTORY_SEPARATOR.$img);
		
		$name_thumb = current(explode(".",$img));
		
		$posts_block_img = dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."upload".DIRECTORY_SEPARATOR."blockblog".DIRECTORY_SEPARATOR.$name_thumb.'-'.Configuration::get($this->_name.'p_block_img_width').'x'.Configuration::get($this->_name.'p_block_img_width').'.jpg';
		@unlink($posts_block_img);
						
		$lists_img = dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."upload".DIRECTORY_SEPARATOR."blockblog".DIRECTORY_SEPARATOR.$name_thumb.'-'.Configuration::get($this->_name.'lists_img_width').'x'.Configuration::get($this->_name.'lists_img_width').'.jpg';
		@unlink($lists_img);
						
		$post_img = dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."upload".DIRECTORY_SEPARATOR."blockblog".DIRECTORY_SEPARATOR.$name_thumb.'-'.Configuration::get($this->_name.'post_img_width').'x'.Configuration::get($this->_name.'post_img_width').'.jpg';
		@unlink($post_img);
	}
	
	private function _updateImgToPost($data = null){
		
		$post_id = $data['post_id'];
		$img = $data['img'];
			
		// update
		$sql = 'UPDATE `'._DB_PREFIX_.'blog_post` SET
							   `img` = \''.pSQL($img).'\'
							   WHERE id = '.$post_id.'
							   ';
		Db::getInstance()->Execute($sql);
		
	}
	
	public function getHttp(){
		$smarty = $this->context->smarty;
		$http = null;
		if(defined('_MYSQL_ENGINE_')){
				$http = @$smarty->tpl_vars['base_dir']->value;
		} else {
				$http = @$smarty->_tpl_vars['base_dir'];
		}
		if(empty($http)) $http = $_SERVER['HTTP_HOST'];
		return $http;
	}
	
	public function getAllImg(){
			
			$path = $_SERVER['DOCUMENT_ROOT']."/upload/".$this->_name."/";
			
			$d = @opendir($path);
         	
         	$data = array();
         	
			if(!$d) return;
			
			while(($e=readdir($d)) !== false)
			{
				if($e =='.' || $e=='..') continue;
				$data[] = $e;	
			}
			return array('data'=>$data);
	}
	
	public function copyImage($data){
	
		$filename = $data['name'];
		$dir_without_ext = $data['dir_without_ext'];
		
		$is_height_width = 0;
		if(isset($data['width']) && isset($data['height'])){
			$is_height_width = 1;
		}
			
		
		$width = isset($data['width'])?$data['width']:$this->_width;
		$height = isset($data['height'])?$data['height']:$this->_height;
		
		$width_orig_custom = $width;
		$height_orig_custom = $height;
		
		if (!$width){ $width = 85;}
		if (!$height){ $height = 85;}
		// Content type
		$size_img = getimagesize($filename);
		// Get new dimensions
		list($width_orig, $height_orig) = getimagesize($filename);
		$ratio_orig = $width_orig/$height_orig;
		
		if($width_orig>$height_orig){
		$height =  $width/$ratio_orig;
		}else{ 
		$width = $height*$ratio_orig;
		}
		if($width_orig<$width){
			$width = $width_orig;
			$height = $height_orig;
		}
	
		$image_p = imagecreatetruecolor($width, $height);
		$bgcolor=ImageColorAllocate($image_p, 255, 255, 255);
		//   
		imageFill($image_p, 5, 5, $bgcolor);
	
		if ($size_img[2]==2){ $image = imagecreatefromjpeg($filename);}                         
		else if ($size_img[2]==1){  $image = imagecreatefromgif($filename);}                         
		else if ($size_img[2]==3) { $image = imagecreatefrompng($filename); }
	
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
		// Output
		
		if ($is_height_width)
			$users_img = $dir_without_ext.'-'.$width_orig_custom.'x'.$height_orig_custom.'.jpg';
		else
		 	$users_img = $dir_without_ext.'.jpg';
		
		if ($size_img[2]==2)  imagejpeg($image_p, $users_img, 100);                         
		else if ($size_img[2]==1)  imagejpeg($image_p, $users_img, 100);                        
		else if ($size_img[2]==3)  imagejpeg($image_p, $users_img, 100);
		imageDestroy($image_p);
		imageDestroy($image);
		//unlink($filename);

	}
	
	
	public function deletePost($data){
		
		$id = $data['id'];
		$sql = 'DELETE FROM `'._DB_PREFIX_.'blog_post`
							   WHERE id ='.$id.'';
		$result = Db::getInstance()->Execute($sql);
		
		$sql = 'DELETE FROM `'._DB_PREFIX_.'blog_post_data`
							   WHERE id_item ='.$id.'';

		$result = Db::getInstance()->Execute($sql);
		
		$sql = 'DELETE FROM `'._DB_PREFIX_.'blog_category2post`
							   WHERE post_id ='.$id.'';
		$result = Db::getInstance()->Execute($sql);
		
		// delete comments
		$sql = 'DELETE FROM `'._DB_PREFIX_.'blog_comments`
							   WHERE id_post ='.$id.'';
		$result = Db::getInstance()->Execute($sql);
				
	}
	
	public function getPostItem($_data){
			$id = $_data['id'];
			$site = isset($_data['site'])?$_data['site']:'';
		
			if($site==1){
			$cookie = $this->context->cookie;
			$current_language = (int)$cookie->id_lang;
				$sql = '
			SELECT pc.*
			FROM `'._DB_PREFIX_.'blog_post` pc LEFT JOIN `'._DB_PREFIX_.'blog_post_data` pc1
			ON(pc1.id_item = pc.id)
			WHERE pc.`id` = '.$id.' AND pc1.id_lang = '.$current_language.' 
			AND FIND_IN_SET('.$this->_id_shop.',pc.ids_shops)';
				
			$item = Db::getInstance()->ExecuteS($sql);
			
			foreach($item as $k => $_item){
				
				if(strlen($_item['img'])>0){
					$this->generateThumbImages(array('img'=>$_item['img'], 
		    												 'width'=>Configuration::get($this->_name.'post_img_width'),
		    												 'height'=>Configuration::get($this->_name.'post_img_width') 
		    												)
		    											);
		    		$img = substr($_item['img'],0,-4)."-".Configuration::get($this->_name.'post_img_width')."x".Configuration::get($this->_name.'post_img_width').".jpg";
				} else {
		    		$img = $_item['img'];
				}
		    	
		    	$item[$k]['img'] = $img;
				
				$items_data = Db::getInstance()->ExecuteS('
				SELECT pc.*
				FROM `'._DB_PREFIX_.'blog_post_data` pc
				WHERE pc.id_item = '.$_item['id'].'
				');
				
				foreach ($items_data as $item_data){
					if($current_language == $item_data['id_lang']){
		    			$item[$k]['title'] = $item_data['title'];
		    			$item[$k]['content'] = $item_data['content'];
		    			$item[$k]['seo_keywords'] = $item_data['seo_keywords'];
		    			$item[$k]['seo_description'] = $item_data['seo_description'];
		    			$item[$k]['seo_url'] = $item_data['seo_url'];
					}
		    		
		    	}
		    	
			}
			
			
			$post_category_id = 0;
			$sql = '
			SELECT pc.category_id, pc.post_id
			FROM `'._DB_PREFIX_.'blog_category2post` pc
			WHERE pc.`post_id` = '.$id.'';
			
			$category_ids = Db::getInstance()->ExecuteS($sql);
			$data_category_ids = array();
			foreach($category_ids as $k => $v){
				$data_category_ids[] = $v['category_id'];
			}
			
			$item[0]['category_ids'] = $data_category_ids;
			
			
			} else {
			
			$item = Db::getInstance()->ExecuteS('
			SELECT pc.*
			FROM `'._DB_PREFIX_.'blog_post` pc
			WHERE pc.`id` = '.$id.'');
			
			foreach($item as $k => $_item){
				
				$items_data = Db::getInstance()->ExecuteS('
				SELECT pc.*
				FROM `'._DB_PREFIX_.'blog_post_data` pc
				WHERE pc.id_item = '.$_item['id'].'
				');
				
				foreach ($items_data as $item_data){
		    			$item['data'][$item_data['id_lang']]['title'] = $item_data['title'];
		    			$item['data'][$item_data['id_lang']]['content'] = $item_data['content'];
		    			$item['data'][$item_data['id_lang']]['seo_keywords'] = $item_data['seo_keywords'];
		    			$item['data'][$item_data['id_lang']]['seo_description'] = $item_data['seo_description'];
		    			$item['data'][$item_data['id_lang']]['seo_url'] = $item_data['seo_url'];
		    	}
		    	
			}
			
			
			$post_category_id = 0;
			$category_ids = Db::getInstance()->ExecuteS('
			SELECT pc.category_id, pc.post_id
			FROM `'._DB_PREFIX_.'blog_category2post` pc
			WHERE pc.`post_id` = '.$id.'');
			$data_category_ids = array();
			foreach($category_ids as $k => $v){
				$data_category_ids[] = $v['category_id'];
			}
			
			$item[0]['category_ids'] = $data_category_ids;
			}
			
	   return array('post' => $item);
	}
	
	public function  getComments($_data){
		$admin = isset($_data['admin'])?$_data['admin']:null;
		$id = isset($_data['id'])?$_data['id']:0;
		
		if($admin == 1){
			
			$posts = Db::getInstance()->ExecuteS('
			SELECT pc.*
			FROM `'._DB_PREFIX_.'blog_comments` pc
			WHERE pc.id_post = '.$id.'
			ORDER BY pc.`time_add` DESC');
			
			$data_count_posts = Db::getInstance()->getRow('
			SELECT COUNT(`id`) AS "count"
			FROM `'._DB_PREFIX_.'blog_comments`  as pc
			WHERE pc.id_post = '.$id.'
			');
			
		} elseif($admin == 2){
			$start = $_data['start'];
			$step = $_data['step'];
			
			$posts = Db::getInstance()->ExecuteS('
			SELECT pc.*
			FROM `'._DB_PREFIX_.'blog_comments` pc
			ORDER BY pc.`time_add` DESC  LIMIT '.$start.' ,'.$step.'');
			
			$data_count_posts = Db::getInstance()->getRow('
			SELECT COUNT(`id`) AS "count"
			FROM `'._DB_PREFIX_.'blog_comments`  as pc
			');
		} else{
			$cookie = $this->context->cookie;
			$current_language = (int)$cookie->id_lang;
			
			$start = $_data['start'];
			$step = $_data['step'];
			
			$posts = Db::getInstance()->ExecuteS('
			SELECT pc.*
			FROM `'._DB_PREFIX_.'blog_comments` pc
			WHERE pc.`id_post` = '.$id.' and status = 1 and id_lang = '.$current_language.' 
			and pc.id_shop = '.$this->_id_shop.'
			ORDER BY pc.`time_add` DESC LIMIT '.$start.' ,'.$step.'');	
			
			$data_count_posts = Db::getInstance()->getRow('
			SELECT COUNT(*) AS "count"
			FROM `'._DB_PREFIX_.'blog_comments` pc
			WHERE pc.id_post = '.$id.' and status = 1 and id_lang = '.$current_language.'
			and pc.id_shop = '.$this->_id_shop.'
			');
		}	
		return array('comments' => $posts, 'count_all' => $data_count_posts['count'] );
	}
	
	public function deleteComment($data){
		
		$id = $data['id'];
		// delete comments
		$sql = 'DELETE FROM `'._DB_PREFIX_.'blog_comments`
							   WHERE id ='.$id.'';
		Db::getInstance()->Execute($sql);
				
	}
	
	public function getCommentItem($_data){
			$id = $_data['id'];
		
			$category = Db::getInstance()->ExecuteS('
			SELECT pc.*
			FROM `'._DB_PREFIX_.'blog_comments` pc
			WHERE pc.`id` = '.$id.'');
	   return array('comments' => $category);
	}
	
	public function updateComment($data){
	
		$id_editcomments = $data['id_editcomments'];
		
		$comments_name = $data['comments_name'];
		$comments_email = $data['comments_email'];
		$comments_comment = $data['comments_comment'];
		$comments_status = $data['comments_status'];
			
		// update
		$sql = 'UPDATE `'._DB_PREFIX_.'blog_comments` SET
							   `name` = \''.pSQL($comments_name).'\',
							   `email` = \''.pSQL($comments_email).'\',
							   `comment` = \''.pSQL($comments_comment).'\',
							   `status` = \''.pSQL($comments_status).'\'
							   WHERE id = '.$id_editcomments.'
							   ';
		$result = Db::getInstance()->Execute($sql);
		
	}
	
	public function saveComment($_data){
		$name = $_data['name'];
		$email = $_data['email'];
		$text_review =  $_data['text_review'];
		$id_post = $_data['id_post'];
		
		$cookie = $this->context->cookie;
		$current_language = (int)$cookie->id_lang;
		
		$sql = 'INSERT into `'._DB_PREFIX_.'blog_comments` SET
							   `id_lang` = \''.pSQL($current_language).'\',
							   `name` = \''.pSQL($name).'\',
							   `email` = \''.pSQL($email).'\',
							   `comment` = \''.pSQL($text_review).'\',
							   `id_post` = \''.pSQL($id_post).'\',
							   `id_shop` = \''.pSQL($this->_id_shop).'\',
							   `time_add` = NULL
							   ';
		$result = Db::getInstance()->Execute($sql);
		
		if(Configuration::get($this->_name.'noti') == 1){

			include_once(dirname(__FILE__).'/../propack.php');
			$obj = new propack();
			$_data_translate = $obj->translateItems();
			$subject = $_data_translate['email_subject'];
		
		$cookie = $this->context->cookie;
		/* Email generation */
		$templateVars = array(
			'{email}' => $email,
			'{name}' => $name,
			'{message}' => stripslashes($text_review)
		);
		$id_lang = intval($cookie->id_lang);		
		/* Email sending */
		Mail::Send($id_lang, 'comment', $subject, $templateVars, 
			Configuration::get($this->_name.'mail'), 'Blog Comment Form', $email, $name,
			NULL, NULL, dirname(__FILE__).'/../mails/');
		}
	}
	
	public function PageNav($start,$count,$step, $_data =null )
	{
		$_admin = isset($_data['admin'])?$_data['admin']:null;
		$category_id = isset($_data['category_id'])?$_data['category_id']:0;
		
		
		$post_id = isset($_data['post_id'])?$_data['post_id']:0;
		$is_category = isset($_data['category'])?$_data['category']:0;
		
		$all_posts = isset($_data['all_posts'])?$_data['all_posts']:'';
		$is_search = isset($_data['is_search'])?$_data['is_search']:0;
		
		$is_arch = isset($_data['is_arch'])?$_data['is_arch']:0;
		$month = isset($_data['month'])?$_data['month']:0;
		$year = isset($_data['year'])?$_data['year']:0;
		
		
		include_once(dirname(__FILE__).'/../propack.php');
		$obj = new propack();
		$_data_translate = $obj->translateItems();
		$page_translate = $_data_translate['page'];
			
		$res = '';
		$product_count = $count;
		$res .= '<div class="pages">';
		$res .= '<span>'.$page_translate.':</span>';
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
								$item = $_data['item'];
								$res .= '<a href="'.$currentIndex.'&page'.$item.'='.($start1 ? $start1 : 0).$token.'" >'.$par.'</a>';
							} else {
								if($is_category == 1){
									$res .= '<a href="javascript:void(0)" onclick="go_page_blog_cat( '.($start1 ? $start1 : 0).' )">'.$par.'</a>';
									
								} else {
									
									if($category_id != 0){
									$res .= '<a href="javascript:void(0)" onclick="go_page_blog( '.($start1 ? $start1 : 0).', '.$category_id.' )">'.$par.'</a>';
									}else{	
										if(strlen($all_posts)>0){
											
											if($is_search == 1){
												$search = isset($_data['search'])?$_data['search']:'';
												$res .= '<a href="?search='.$search.($start1 ? '&start='.$start1 : '').'" >'.$par.'</a>';
											} elseif($is_arch == 1){
												$res .= '<a href="?y='.$year.'&m='.$month.($start1 ? '&start='.$start1 : '').'" >'.$par.'</a>';
											
											}else {
												$res .= '<a href="javascript:void(0)" onclick="go_page_all( '.($start1 ? $start1 : 0).' )">'.$par.'</a>';
											}
									
										} else{
											$res .= '<a href="javascript:void(0)" onclick="go_page_blog_comments( '.($start1 ? $start1 : 0).', '.$post_id.' )">'.$par.'</a>';
										}
									}
								}		
							}
						}
				}
		
		$res .= '</span>';
		$res .= '</div>';
		
		
		return $res;
	}
	
	public function getCategoriesBlock(){
		$limit  = (int)Configuration::get($this->_name.'blog_bcat');
		
		
			$cookie = $this->context->cookie;
			$current_language = (int)$cookie->id_lang;
			
			$sql = '
			SELECT pc.*
			FROM `'._DB_PREFIX_.'blog_category` pc 
			LEFT JOIN `'._DB_PREFIX_.'blog_category_data` pc_d
			ON(pc.id = pc_d.id_item) 
			WHERE pc_d.id_lang = '.$current_language.' AND FIND_IN_SET('.$this->_id_shop.',pc.ids_shops)
			 ORDER BY pc.`id` DESC LIMIT '.$limit;
			
			$items = Db::getInstance()->ExecuteS($sql);
			$items_tmp = array();
			foreach($items as $k => $_item){
				$items_data = Db::getInstance()->ExecuteS('
				SELECT pc.*
				FROM `'._DB_PREFIX_.'blog_category_data` pc
				WHERE pc.id_item = '.$_item['id'].'
				');
				
				foreach ($items_data as $item_data){
		    		if($current_language == $item_data['id_lang']){
		    			$items_tmp[$k]['data'][$item_data['id_lang']]['title'] = $item_data['title'];
		    			$items_tmp[$k]['data'][$item_data['id_lang']]['seo_description'] = $item_data['seo_description'];
		    			$items_tmp[$k]['data'][$item_data['id_lang']]['seo_keywords'] = $item_data['seo_keywords'];
		    			$items_tmp[$k]['data'][$item_data['id_lang']]['time_add'] = $_item['time_add'];
		    			$items_tmp[$k]['data'][$item_data['id_lang']]['id'] = $_item['id'];
		    			$items_tmp[$k]['data'][$item_data['id_lang']]['seo_url'] = $item_data['seo_url'];
		    		}
		    	}
		    	
			}
			
			
		return array('categories' => $items_tmp );
	}
	
	public function getRecentsPosts(){
		$limit  =(int) Configuration::get($this->_name.'blog_bposts');
		
		
		$cookie = $this->context->cookie;
			$current_language = (int)$cookie->id_lang;
			
			$sql = '
			SELECT pc.*
			FROM `'._DB_PREFIX_.'blog_post` pc 
			LEFT JOIN `'._DB_PREFIX_.'blog_post_data` pc_d
			ON(pc.id = pc_d.id_item) 
			WHERE pc.status = 1 AND FIND_IN_SET('.$this->_id_shop.',pc.ids_shops)
			AND pc_d.id_lang = '.$current_language.' ORDER BY pc.`id` DESC LIMIT '.$limit;
			
			$items = Db::getInstance()->ExecuteS($sql);
			$items_tmp = array();
			foreach($items as $k => $_item){
				$items_data = Db::getInstance()->ExecuteS('
				SELECT pc.*
				FROM `'._DB_PREFIX_.'blog_post_data` pc
				WHERE pc.id_item = '.$_item['id'].'
				');
				
				foreach ($items_data as $item_data){
		    		if($current_language == $item_data['id_lang']){
		    			$items_tmp[$k]['data'][$item_data['id_lang']]['title'] = $item_data['title'];
		    			$items_tmp[$k]['data'][$item_data['id_lang']]['seo_description'] = $item_data['seo_description'];
		    			$items_tmp[$k]['data'][$item_data['id_lang']]['seo_keywords'] = $item_data['seo_keywords'];
		    			$items_tmp[$k]['data'][$item_data['id_lang']]['content'] = $item_data['content'];
		    			
		    			
		    			
		    			
		    			if(strlen($_item['img'])>0){
		    				$this->generateThumbImages(array('img'=>$_item['img'], 
		    												 'width'=>Configuration::get($this->_name.'p_block_img_width'),
		    												 'height'=>Configuration::get($this->_name.'p_block_img_width') 
		    												)
		    											);
		    				$img = substr($_item['img'],0,-4)."-".Configuration::get($this->_name.'p_block_img_width')."x".Configuration::get($this->_name.'p_block_img_width').".jpg";
		    			} else {
		    				$img = $_item['img'];
		    			}
		    			
		    			$items_tmp[$k]['data'][$item_data['id_lang']]['img'] = $img;
		    			$items_tmp[$k]['data'][$item_data['id_lang']]['status'] = $_item['status'];
		    			$items_tmp[$k]['data'][$item_data['id_lang']]['is_comments'] = $_item['is_comments'];
		    			$items_tmp[$k]['data'][$item_data['id_lang']]['time_add'] = $_item['time_add'];	
		    			$items_tmp[$k]['data'][$item_data['id_lang']]['id'] = $_item['id'];
		    			$items_tmp[$k]['data'][$item_data['id_lang']]['seo_url'] = $item_data['seo_url'];
		    		}
		    	}
		    	
			}
			//exit;
			
			
		return array('posts' => $items_tmp );
	} 
	
	
	public function getArchives(){
		
			$cookie = $this->context->cookie;
			$current_language = (int)$cookie->id_lang;
			
			$sql = 'SELECT 
						    YEAR(`time_add`) AS YEAR, 
						    MONTH(`time_add`) AS MONTH,
						    COUNT(*) AS TOTAL ,
						    time_add
						FROM  `'._DB_PREFIX_.'blog_post` pc
						LEFT JOIN `'._DB_PREFIX_.'blog_post_data` pc_d
						ON(pc.id = pc_d.id_item)
						WHERE pc.status = 1 AND FIND_IN_SET('.$this->_id_shop.',pc.ids_shops)
						AND pc_d.id_lang = '.$current_language.'
						GROUP BY YEAR desc, MONTH';
			
			$items = Db::getInstance()->ExecuteS($sql);
			$items_tmp = array();
			$tmp_years = array();
			
			
			foreach($items as $k => $_item){
				$year = $_item['YEAR'];
				$month = $_item['MONTH'];
				$total = $_item['TOTAL'];
				$time_add = $_item['time_add'];
			
					
				$items_tmp[$year][] = array('year'=>$year,
									 'month'=>$month,
									 'total' =>$total,
									 'time_add' => $time_add
									);
				
			}
			
		return array('posts' => $items_tmp );
	} 
	
	public function generateThumbImages($data){
		
		$filename = $data['img'];
		$orig_name_img= $data['img'];
		$width = $data['width'];
		$height = $data['height'];
		
		$filename = substr($filename,0,-4)."-".$width."x".$height.".jpg";
		
		$name_img = dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."upload".DIRECTORY_SEPARATOR."blockblog".DIRECTORY_SEPARATOR.$filename;
		
		
		if(@filesize($name_img)==0){
		
		$uniq_name_image_without_ext = current(explode(".",$orig_name_img));
		
		$dir_without_ext = dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."upload".DIRECTORY_SEPARATOR."blockblog".DIRECTORY_SEPARATOR.$uniq_name_image_without_ext;
						
		$this->copyImage(
			array('dir_without_ext'=>$dir_without_ext,
			      'name'=>dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."upload".DIRECTORY_SEPARATOR."blockblog".DIRECTORY_SEPARATOR.$orig_name_img,
				  'width'=>$width,
				  'height'=>$height
				  )
				    );	
		}
		
		
						
	}
	
	public function createRSSFile($post_title,$post_description,$post_link,$post_pubdate,$img)
	{
		
		
		if(Configuration::get($this->_name.'urlrewrite_on') == 1){
			
			$cookie = $this->context->cookie;
			$current_language = (int)$cookie->id_lang;
			
		    $_is_friendly_url = $this->isURLRewriting();
			if($_is_friendly_url)
				$_iso_lng = Language::getIsoById(intval($current_language))."/";
			else
				$_iso_lng = '';
			
			$post_link = $this->_http_host.$_iso_lng."blog/post/".$post_link;
		} else {
			$post_link = $this->_http_host
								."modules/propack/blockblog-post.php?post_id=".$post_link;
		}
		
		$returnITEM = "<item>\n";
		# this will return the Title of the Article.
		$returnITEM .= "<title><![CDATA[".$post_title."]]></title>\n";
		# this will return the Description of the Article.
		$returnITEM .= "<description><![CDATA[".((strlen($img)>0)?"<img src=\"".$img."\" title=\"".$post_title."\" alt=\"thumb\" />":"").$post_description."]]></description>\n";
		# this will return the URL to the post.
		$returnITEM .= "<link>".str_replace('&','&amp;', $post_link)."</link>\n";
		
		$returnITEM .= "<pubDate>".$post_pubdate."</pubDate>\n";
		$returnITEM .= "</item>\n";
		return $returnITEM;
	}
	
	public function getItemsForRSS(){
			
			$step = Configuration::get($this->_name.'number_rssitems');
			
			$cookie = $this->context->cookie;
			$current_language = (int)$cookie->id_lang;
			
			
			$sql = '
			SELECT pc.* 
			FROM `'._DB_PREFIX_.'blog_post` pc 
			LEFT JOIN `'._DB_PREFIX_.'blog_post_data` pc_d
			on(pc.id = pc_d.id_item)
			WHERE pc.status = 1 and pc_d.id_lang = '.$current_language.'  
			AND FIND_IN_SET('.$this->_id_shop.',pc.ids_shops)
			ORDER BY pc.`id` DESC LIMIT '.$step.'';
			
			$items = Db::getInstance()->ExecuteS($sql);	
			
			foreach($items as $k1=>$_item){
				$id_post = $_item['id'];
				
				if(strlen($_item['img'])>0){
					$this->generateThumbImages(array('img'=>$_item['img'], 
		    												 'width'=>Configuration::get($this->_name.'lists_img_width'),
		    												 'height'=>Configuration::get($this->_name.'lists_img_width') 
		    												)
		    											);
		    		$img = substr($_item['img'],0,-4)."-".Configuration::get($this->_name.'lists_img_width')."x".Configuration::get($this->_name.'lists_img_width').".jpg";
		    	} else {
		    		$img = $_item['img'];
				}
		    		
		    	$items[$k1]['img'] = $img;
				
				
				$items_data = Db::getInstance()->ExecuteS('
				SELECT pc.*
				FROM `'._DB_PREFIX_.'blog_post_data` pc
				WHERE pc.id_item = '.$_item['id'].'
				');
				
				foreach ($items_data as $item_data){
		    		
		    		if($current_language == $item_data['id_lang']){
		    			$items[$k1]['title'] = $item_data['title'];
		    			$items[$k1]['seo_description'] = htmlspecialchars(strip_tags($item_data['content']));
		    			$items[$k1]['pubdate'] = date('D, d M Y H:i:s +0000',strtotime($_item['time_add']));
		    			if(Configuration::get($this->_name.'urlrewrite_on') == 1){
		    			$items[$k1]['page'] = $item_data['seo_url'];
		    			} else {
		    			$items[$k1]['page'] = $item_data['id_item'];
		    				
		    			}
		    			
		    		} 
		    	}
				
			}
			
			
			
		
			return array('items' => $items);
	}
	
	public function getfacebooklocale()
	{
		$locales = array();

		if (($xml=simplexml_load_file(_PS_MODULE_DIR_ . $this->_name."/lib/facebook_locales.xml")) === false)
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
    
    private function _getCategoriesForSitemap(){
    		$cookie = $this->context->cookie;
			$current_language = (int)$cookie->id_lang;
			
			$sql = '
			SELECT pc.*
			FROM `'._DB_PREFIX_.'blog_category` pc 
			WHERE  FIND_IN_SET('.$this->_id_shop.',pc.ids_shops)
			 ORDER BY pc.`id` DESC ';
			
			$items = Db::getInstance()->ExecuteS($sql);
			$items_tmp = array();
			foreach($items as $k => $_item){
				$items_data = Db::getInstance()->ExecuteS('
				SELECT pc.*
				FROM `'._DB_PREFIX_.'blog_category_data` pc
				WHERE pc.id_item = '.$_item['id'].'
				');
				
				foreach ($items_data as $k1=>$item_data){
					//var_Dump($item_data['id_lang']); 
		    		//if($current_language == $item_data['id_lang']){
		    			if (Configuration::get('PS_REWRITING_SETTINGS')) {
		    				
						$_is_friendly_url = $this->isURLRewriting();
						if($_is_friendly_url)
							$_iso_lng = Language::getIsoById(intval($item_data['id_lang']))."/";
						else
							$_iso_lng = '';
		    				
		    				$url = $this->_http_host.$_iso_lng.'blog/category/'.$item_data['seo_url'];
		    				$items_tmp[]['data'][$item_data['id_lang']]['url'] = $url;
		    			} else {
		    				$url = $this->_http_host.'modules/'.$this->_name.'/blockblog-category.php?category_id='.$_item['id'];
		    				$items_tmp[]['data'][$item_data['id_lang']]['url'] = $url;
		    			}
		    		//}
		    	}
		    	
			}
			
			return array('all_categories'=>$items_tmp);
    }
    
    private function _getPostsForSitemap(){
		
		
		$cookie = $this->context->cookie;
			$current_language = (int)$cookie->id_lang;
			
			$sql = '
			SELECT pc.*
			FROM `'._DB_PREFIX_.'blog_post` pc 
			WHERE pc.status = 1 AND FIND_IN_SET('.$this->_id_shop.',pc.ids_shops)
			 ORDER BY pc.`id` DESC';
			
			$items = Db::getInstance()->ExecuteS($sql);
			$items_tmp = array();
			foreach($items as $k => $_item){
				$items_data = Db::getInstance()->ExecuteS('
				SELECT pc.*
				FROM `'._DB_PREFIX_.'blog_post_data` pc
				WHERE pc.id_item = '.$_item['id'].'
				');
				foreach ($items_data as $k1=>$item_data){
		    			
		    			if (Configuration::get('PS_REWRITING_SETTINGS')) {
		    				$_is_friendly_url = $this->isURLRewriting();
							if($_is_friendly_url)
								$_iso_lng = Language::getIsoById(intval($item_data['id_lang']))."/";
							else
								$_iso_lng = '';
								
		    				$url = $this->_http_host.$_iso_lng.'blog/post/'.$item_data['seo_url'];
		    				$items_tmp[]['data'][$item_data['id_lang']]['url'] = $url;
		    			} else {
		    				$url = $this->_http_host.'modules/'.$this->_name.'/blockblog-post.php?post_id='.$_item['id'];
		    				$items_tmp[]['data'][$item_data['id_lang']]['url'] = $url;
		    			}
		    			
		    	}
		    	
			}
			
		return array('all_posts' => $items_tmp );
	} 
	
    
    public function generateSitemap(){
               
        $filename = dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."upload".DIRECTORY_SEPARATOR."blockblog".DIRECTORY_SEPARATOR."blog.xml";
                
                //if(@filesize($filename)==0){
                	$new_sitemap = '<?xml version="1.0" encoding="UTF-8"?>
									<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

									</urlset>';
                	file_put_contents($filename,$new_sitemap);
                //}
                $xml = simplexml_load_file($filename);
                unset($xml->url);
                $sxe = new SimpleXMLElement($xml->asXML());
                
                    $all_posts_data = $this->_getPostsForSitemap();
                    $all_posts = $all_posts_data['all_posts'];
                    //echo "<pre>"; var_dump($all_posts); exit;
                    foreach($all_posts as $post){
                    	
                    	foreach($post['data'] as $item_post){
                    	$postlink = $item_post['url'];
                        $postlink = str_replace('&','&amp;', $postlink);
                        
                        $url = $sxe->addChild('url');
                        $url->addChild('loc', $postlink);
                        $url->addChild('priority','0.6');
                        $url->addChild('changefreq','monthly');
                    	}
                    }
                    
                    $all_categories_data = $this->_getCategoriesForSitemap();
                    $all_categories = $all_categories_data['all_categories'];
                   
                    foreach($all_categories as $cat){
                    	
                    	foreach($cat['data'] as $item_cat){
                        $catlink = $item_cat['url'];
                        $catlink = str_replace('&','&amp;', $catlink);
                        $url = $sxe->addChild('url');
                        $url->addChild('loc', $catlink);
                        $url->addChild('priority','0.6');
                        $url->addChild('changefreq','monthly');
                    	}
                    }
                    
                    $sxe->asXML($filename); 
             
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