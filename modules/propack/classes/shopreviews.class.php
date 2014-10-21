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

class shopreviews extends Module{
	
	private $_name;
	private $_http_host;
	
	public function __construct(){
		$this->_name = "propack";
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
	
	
	
	public function saveTestimonial($_data){
		
		$cookie = $this->context->cookie;
		$id_lang = intval($cookie->id_lang);
		
		$name = $_data['name'];
		$email = $_data['email'];
		$web = $_data['web'];
		$text_review =  $_data['text_review'];
		$company = $_data['company'];
	    $address = $_data['address'];
		
		$sql = 'INSERT into `'._DB_PREFIX_.'blockshopreviews` SET
							   `name` = \''.pSQL($name).'\',
							   `email` = \''.pSQL($email).'\',
							   `web` = \''.pSQL($web).'\',
							   `message` = \''.pSQL($text_review).'\',
							   `company` = \''.pSQL($company).'\',
							   `address` = \''.pSQL($address).'\',
							   `id_shop` = \''.$this->getIdShop().'\',
							   `id_lang` = \''.$id_lang.'\',
							   `date_add` = NULL
							   ';
		Db::getInstance()->Execute($sql);
		
		if(Configuration::get($this->_name.'tnoti') == 1){
			
		include_once(dirname(__FILE__).'/../propack.php');
		$obj_propack = new propack();
		$_data_translate = $obj_propack->translateItems();
		$subject = $_data_translate['subject_testimonials'];	
			
		
		/* Email generation */
		$templateVars = array(
			'{email}' => $email,
			'{name}' => $name,
			'{url}' => $web,
			'{message}' => stripslashes($text_review)
		);
					
		/* Email sending */
		Mail::Send($id_lang, 'testimony', $subject, $templateVars, 
			Configuration::get($this->_name.'tmail'), 'Testimonial Form', $email, $name,
			NULL, NULL, dirname(__FILE__).'/../mails/');
		}
		
		
	}
	
	public function getTestimonials($_data){
		
		$start = $_data['start'];
		$step = $_data['step'];;
		$admin = isset($_data['admin'])?$_data['admin']:null;
		
		$cookie = $this->context->cookie;
		$id_lang = intval($cookie->id_lang);
		
		if($admin){
			$reviews = Db::getInstance()->ExecuteS('
			SELECT pc.*
			FROM `'._DB_PREFIX_.'blockshopreviews` pc
			WHERE pc.`is_deleted` = 0
			ORDER BY pc.`date_add` DESC LIMIT '.$start.' ,'.$step.'');
			
			$data_count_reviews = Db::getInstance()->getRow('
			SELECT COUNT(`id`) AS "count"
			FROM `'._DB_PREFIX_.'blockshopreviews` 
			WHERE is_deleted = 0
			');
		}else{
			$reviews = Db::getInstance()->ExecuteS('
			SELECT pc.*
			FROM `'._DB_PREFIX_.'blockshopreviews` pc
			WHERE pc.active = 1 AND pc.`is_deleted` = 0 AND
			`id_shop` = \''.$this->getIdShop().'\' AND `id_lang` = \''.$id_lang.'\'
			ORDER BY pc.`date_add` DESC LIMIT '.$start.' ,'.$step.'');
			
			$data_count_reviews = Db::getInstance()->getRow('
			SELECT COUNT(`id`) AS "count"
			FROM `'._DB_PREFIX_.'blockshopreviews` 
			WHERE active = 1 AND is_deleted = 0 AND
			`id_shop` = \''.$this->getIdShop().'\' AND `id_lang` = \''.$id_lang.'\'
			');
		}
		 return array('reviews' => $reviews, 'count_all_reviews' => $data_count_reviews['count'] );
	}
	
	public function getItem($_data){
		$id = $_data['id'];
		
			$reviews = Db::getInstance()->ExecuteS('
			SELECT pc.*
			FROM `'._DB_PREFIX_.'blockshopreviews` pc
			WHERE pc.`is_deleted` = 0 AND pc.`id` = '.$id.'');
			
			
	   return array('reviews' => $reviews);
	}
	
	public function setPublsh($data){
		$id = $data['id'];
		$active = $data['active'];
		
		$sql = 'UPDATE `'._DB_PREFIX_.'blockshopreviews` 
	    				SET
				   		active = '.$active.'
				   		WHERE id = '.$id.' 
						   ';
			Db::getInstance()->Execute($sql);
	}
	
	public function deteleItem($data){
		$id = $data['id'];
		$sql = 'UPDATE `'._DB_PREFIX_.'blockshopreviews` 
	    						SET
						   		is_deleted = 1
						   		WHERE id = '.$id.''; 
		Db::getInstance()->Execute($sql);
	}
	
	public function getIdShop(){
		$id_shop = 0;
		if(version_compare(_PS_VERSION_, '1.5', '>'))
			$id_shop = Context::getContext()->shop->id;
		return $id_shop;
	} 
	
	public function updateItem($data){
		$name = $data['name'];
		$email = $data['email'];
		$web = $data['web'];
		$message = $data['message'];
		$publish = $data['publish'];
		$id = $data['id'];
		$company = $data['company'];
		$address = $data['address'];
		
		$sql_condition_web = '';
		if(Configuration::get($this->_name.'tis_web') == 1){
			$sql_condition_web = '`web` = "'.$web.'",';
		}
		
		$sql_condition_company = '';
		if(Configuration::get($this->_name.'tis_company') == 1){
			$sql_condition_company = '`company` = "'.$company.'",';
		}
		
		$sql_condition_address = '';
		if(Configuration::get($this->_name.'tis_addr') == 1){
			$sql_condition_address = '`address` = "'.$address.'",';
		}
		
		$sql = 'UPDATE `'._DB_PREFIX_.'blockshopreviews` 
	    						SET `name` = "'.$name.'",
						   			`email` = "'.$email.'",
						   			'.$sql_condition_web.'
						   			`message` = "'.$message.'",
						   			'.$sql_condition_company.'
									'.$sql_condition_address.'
									`active` = '.$publish.'			   			 
						   		WHERE id = '.$id.''; 
        Db::getInstance()->Execute($sql);
			
	}
	
	public function PageNav($start,$count,$step, $_data =null )
	{
		$_admin = isset($_data['admin'])?$_data['admin']:null;
		
		$res = '';
		$product_count = $count;
		include_once(dirname(__FILE__).'/../propack.php');
		$obj_propack = new propack();
		$_data_translate = $obj_propack->translateItems();
		$page_translate = $_data_translate['page']; 
		
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
								$currentIndex = $_data['currentIndex'];
								$token = $_data['token'];
								$res .= '<a href="'.$currentIndex.'&page_t='.($start1 ? $start1 : 0).'&configure='.$this->_name.'&token='.$token.'" >'.$par.'</a>';
							} else {
								$res .= '<a href="javascript:void(0)" onclick="go_page( '.($start1 ? $start1 : 0).' )">'.$par.'</a>';
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
    
	public function createRSSFile($post_title,$post_description,$post_link,$post_pubdate)
	{
		
		
		$returnITEM = "<item>\n";
		# this will return the Title of the Article.
		$returnITEM .= "<title><![CDATA[".$post_title."]]></title>\n";
		# this will return the Description of the Article.
		$returnITEM .= "<description><![CDATA[".$post_description."]]></description>\n";
		# this will return the URL to the post.
		$returnITEM .= "<link>".$post_link."</link>\n";
		
		$returnITEM .= "<pubDate>".$post_pubdate."</pubDate>\n";
		$returnITEM .= "</item>\n";
		return $returnITEM;
	}
	
	public function getItemsForRSS(){
			
			$step = Configuration::get($this->_name.'tn_rssitemst');
			
			
			
			$cookie = $this->context->cookie;
			$current_language = (int)$cookie->id_lang;
			
			$_is_friendly_url = $this->isURLRewriting();
			if($_is_friendly_url)
				$_iso_lng = Language::getIsoById(intval($current_language))."/";
			else
				$_iso_lng = '';
			
			 
			
			$sql  = '
			SELECT pc.*
			FROM `'._DB_PREFIX_.'blockshopreviews` pc
			WHERE pc.active = 1 AND pc.`is_deleted` = 0 AND
			`id_shop` = \''.$this->getIdShop().'\' AND `id_lang` = \''.$current_language.'\'
			ORDER BY pc.`date_add` DESC LIMIT '.$step;
			
			$items = Db::getInstance()->ExecuteS($sql);	
			
			foreach($items as $k1=>$_item){
					
		    		if($current_language == $_item['id_lang']){
		    			$items[$k1]['title'] = $_item['name'];
		    			$items[$k1]['seo_description'] = htmlspecialchars(strip_tags($_item['message']));
		    			$items[$k1]['pubdate'] = date('D, d M Y H:i:s +0000',strtotime($_item['date_add']));
		    			
		    			if(Configuration::get($this->_name.'urlrewrite_on') == 1){
		    			$items[$k1]['page'] = $this->_http_host.$_iso_lng."testimonials";
		    			} else {
		    			$items[$k1]['page'] = $this->_http_host."modules/propack/blockshopreviews-form.php";
		    			}
		    			
		    		} 
		    	
				
			}
			
			
			return array('items' => $items);
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