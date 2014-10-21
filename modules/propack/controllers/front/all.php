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

class PropackAllModuleFrontController extends ModuleFrontController
{
	
	public function init()
	{
		if(version_compare(_PS_VERSION_, '1.6', '>')){
			$_http_host = Tools::getShopDomainSsl(true, true).__PS_BASE_URI__; 
		} else {
			$_http_host = _PS_BASE_URL_.__PS_BASE_URI__;
		}
		
		$http_referrer = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';
		
		// only for blog
		if(preg_match('/\/blog\//i',$http_referrer)){
			
		
			include_once(dirname(__FILE__).'../../../classes/blog.class.php');
			$obj = new bloghelp();
			$is_friendly_url = $obj->isURLRewriting();
			
			if($is_friendly_url){
				
				
			if(strlen($http_referrer)>0){
				
			
				$lang_iso_redirect = Language::getIsoById(intval(Tools::getValue("id_lang")));
			
				$languages = Language::getLanguages(false);
				$iso_code = '';
				foreach ($languages as $language){
					$iso_array = Language::getIsoById(intval($language['id_lang']));
					if(preg_match('/\/'.$iso_array.'\//i',$http_referrer)){
						$iso_code = $iso_array;
						break;
					}
				}
				
				$seo_friendly_url = '';
				$item_seo_url = '';
				#### for change language ###
				$post_seo_url = Tools::getValue('post_id');
				if($post_seo_url){
				$id_post = $obj->getIdPostifFriendlyURLEnable(array('seo_url'=>$post_seo_url,
																	'id_lang'=>Language::getIdByIso($iso_code))
															  );
				$seo_friendly_url = $obj->getSEOFriendlyURLifFriendlyURLEnable(array('id_post'=>$id_post,
																					 'id_lang'=>Language::getIdByIso($lang_iso_redirect)
																					 )
																		   );
				if(empty($seo_friendly_url)) $seo_friendly_url = $post_seo_url;
				$item_seo_url = $post_seo_url;
				}
				#### for change language ###
				
																			   
				#### for change language ###
				$cat_seo_url = Tools::getValue('category_id');
				if($cat_seo_url){
				$id_cat = $obj->getIdCatifFriendlyURLEnable(array('seo_url'=>$cat_seo_url,
																	'id_lang'=>Language::getIdByIso($iso_code))
															  );
				$seo_friendly_url = $obj->getSEOFriendlyURLifFriendlyURLEnableCat(array('id_cat'=>$id_cat,
																					 'id_lang'=>Language::getIdByIso($lang_iso_redirect)
																					 )
																			   );
				if(empty($seo_friendly_url)) $seo_friendly_url = $cat_seo_url;
				$item_seo_url = $cat_seo_url;
				}
			
				
				
				$to = '/'.$iso_code.'/';
				$from = '/'.$lang_iso_redirect.'/';
				$http_referrer = str_replace($to,$from,$http_referrer);
				
				$to = $item_seo_url;
				$from = $seo_friendly_url;
				$http_referrer = str_replace($to,$from,$http_referrer);
			
			} else {
				
				$request_uri = isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:'';
				$query_string = isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'';
				
				if (Configuration::get('PS_SSL_ENABLED') == 1)
					$url = "https://";
				else
					$url = "http://";
				
				//http://localhost:97/it/module/blockblog/all?y=2014&m=1 - archives
				//http://localhost:97/en/blog?y=2014&m=1
				$y_seo_url = Tools::getValue('y');
				$m_seo_url = Tools::getValue('m');
				if($y_seo_url && $m_seo_url){
					$explode_request_url = explode("/",$request_uri);
					$lang_iso = isset($explode_request_url[1])?"/".$explode_request_url[1]:"";
					$http_referrer = $_http_host.$lang_iso."/blog?".$query_string;
				}
					
				//http://host.com/en/blog?search=post
				$search_seo_url = Tools::getValue('search');
				if($search_seo_url){
					$explode_request_url = explode("/",$request_uri);
					$lang_iso = isset($explode_request_url[1])?"/".$explode_request_url[1]:"";
					$http_referrer = $_http_host.$lang_iso."/blog?".$query_string;
				}
				
				//http://host.com/es/module/blockblog/all - categories
				//http://host.com/en/blog/categories
				if(strlen($query_string)==0){
					$explode_request_url = explode("/",$request_uri);
					$lang_iso = isset($explode_request_url[1])?"/".$explode_request_url[1]:"";
					$http_referrer = $_http_host.$lang_iso."/blog/categories";
				}
					
				//http://host.com/fr/module/blockblog/all?post_id=pravila-uhoda-za-ukrasheniyami-iz-dereva - post	
				//http://host.com/en/blog/post/pravila-uhoda-za-ukrasheniyami-iz-dereva
				$post_seo_url = Tools::getValue('post_id');
				if($post_seo_url){
					$explode_request_url = explode("/",$request_uri);
					$lang_iso = isset($explode_request_url[1])?"/".$explode_request_url[1]:"";
					$http_referrer = $_http_host.$lang_iso."/blog/post/".$post_seo_url;
				}
				
				//http://host.com/es/module/blockblog/all?category_id=category-en - category
				//http://host.com/fr/blog/category/category-en
				$cat_seo_url = Tools::getValue('category_id');
				if($cat_seo_url){
					$explode_request_url = explode("/",$request_uri);
					$lang_iso = isset($explode_request_url[1])?"/".$explode_request_url[1]:"";
					$http_referrer = $_http_host.$lang_iso."/blog/category/".$cat_seo_url;
				}
				
				if(strlen($http_referrer)==0){
					$explode_request_url = explode("/",$request_uri);
					$lang_iso = isset($explode_request_url[1])?$explode_request_url[1]:"";
					$http_referrer = $_http_host.$lang_iso."/blog";
				}
				
			}
			
			}
		
		}
		
		// only for news
		
		// news
		if(preg_match('/\/news/i',$http_referrer)){
			
		
		include_once(dirname(__FILE__).'../../../classes/blocknewshelp.class.php');
		$obj = new blocknewshelp();
		$is_friendly_url = $obj->isURLRewriting();
		
		if($is_friendly_url){
			
			
		if(strlen($http_referrer)>0){
				
			$lang_iso_redirect = Language::getIsoById(intval(Tools::getValue("id_lang")));
		
			$languages = Language::getLanguages(false);
			foreach ($languages as $language){
				$iso_array = Language::getIsoById(intval($language['id_lang']));
				if(preg_match('/\/'.$iso_array.'\//i',$http_referrer)){
					$iso_code = $iso_array;
					break;
				}
			}
			$seo_friendly_url = '';
			$item_seo_url = '';
			#### for change language ###
			$post_seo_url = Tools::getValue('item_id');
			if($post_seo_url){
			$id_post = $obj->getIdItemifFriendlyURLEnable(array('seo_url'=>$post_seo_url,
																'id_lang'=>Language::getIdByIso($iso_code))
														  );
			$seo_friendly_url = $obj->getSEOFriendlyURLifFriendlyURLEnable(array('id_post'=>$id_post,
																				 'id_lang'=>Language::getIdByIso($lang_iso_redirect)
																				 )
																	   );
			if(empty($seo_friendly_url)) $seo_friendly_url = $post_seo_url;
			$item_seo_url = $post_seo_url;
			}
			#### for change language ###
			
																		   
			
			
				$to = '/'.$iso_code.'/';
				$from = '/'.$lang_iso_redirect.'/';
				$http_referrer = str_replace($to,$from,$http_referrer);
				
				$to = $item_seo_url;
				$from = $seo_friendly_url;
				$http_referrer = str_replace($to,$from,$http_referrer);
				
			
		} else {
			
			if(version_compare(_PS_VERSION_, '1.6', '>')){
			$_http_host = Tools::getShopDomainSsl(true, true).__PS_BASE_URI__; 
			} else {
			$_http_host = _PS_BASE_URL_.__PS_BASE_URI__;
			}

			$request_uri = isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:'';
			$query_string = isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'';
			
			
			if(strlen($query_string)==0){
				$explode_request_url = explode("/",$request_uri);
				$lang_iso = isset($explode_request_url[1])?"/".$explode_request_url[1]:"";
				$http_referrer = $_http_host.$lang_iso."/news";
			}
				
			$post_seo_url = Tools::getValue('item_id');
			if($post_seo_url){
				$explode_request_url = explode("/",$request_uri);
				$lang_iso = isset($explode_request_url[1])?"/".$explode_request_url[1]:"";
				$http_referrer = $_http_host.$lang_iso."/news/".$post_seo_url;
			}
			
			
				
		}
		
		}
		
		}
		// only for news
		
		
		// only for testimonials
		
		// faq
		if(preg_match('/\/testimonials/i',$http_referrer)){
		
		include_once(dirname(__FILE__).'../../../classes/shopreviews.class.php');
		$obj = new shopreviews();
		$is_friendly_url = $obj->isURLRewriting();
		
		if($is_friendly_url){
			
		if(strlen($http_referrer)>0){
				
			$lang_iso_redirect = Language::getIsoById(intval(Tools::getValue("id_lang")));
		
			$languages = Language::getLanguages(false);
			foreach ($languages as $language){
				$iso_array = Language::getIsoById(intval($language['id_lang']));
				if(preg_match('/\/'.$iso_array.'\//i',$http_referrer)){
					$iso_code = $iso_array;
					break;
				}
			}
			$seo_friendly_url = '';
			$item_seo_url = '';
			
			
				$to = '/'.$iso_code.'/';
				$from = '/'.$lang_iso_redirect.'/';
				$http_referrer = str_replace($to,$from,$http_referrer);
				
				$to = $item_seo_url;
				$from = $seo_friendly_url;
				$http_referrer = str_replace($to,$from,$http_referrer);
				
			
		}
		
		}
		
		}
		
		// only for testimonials
		
		
		// only for faq
		// faq
		if(preg_match('/\/faq/i',$http_referrer)){
		
		include_once(dirname(__FILE__).'../../../classes/blockfaqhelp.class.php');
		$obj = new blockfaqhelp();
		$is_friendly_url = $obj->isURLRewriting();
		
		if($is_friendly_url){
			
		if(strlen($http_referrer)>0){
				
			$lang_iso_redirect = Language::getIsoById(intval(Tools::getValue("id_lang")));
		
			$languages = Language::getLanguages(false);
			foreach ($languages as $language){
				$iso_array = Language::getIsoById(intval($language['id_lang']));
				if(preg_match('/\/'.$iso_array.'\//i',$http_referrer)){
					$iso_code = $iso_array;
					break;
				}
			}
			$seo_friendly_url = '';
			$item_seo_url = '';
			
			
				$to = '/'.$iso_code.'/';
				$from = '/'.$lang_iso_redirect.'/';
				$http_referrer = str_replace($to,$from,$http_referrer);
				
				$to = $item_seo_url;
				$from = $seo_friendly_url;
				$http_referrer = str_replace($to,$from,$http_referrer);
				
			
		}
		
		}
		
		}
		
		// only for faq
		
		
		// only for guestbook
		
		// guestbook
		if(preg_match('/\/guestbook/i',$http_referrer)){
		
		include_once(dirname(__FILE__).'../../../classes/guestbook.class.php');
		$obj = new guestbook();
		$is_friendly_url = $obj->isURLRewriting();
		
		if($is_friendly_url){
			
		if(strlen($http_referrer)>0){
				
			$lang_iso_redirect = Language::getIsoById(intval(Tools::getValue("id_lang")));
		
			$languages = Language::getLanguages(false);
			foreach ($languages as $language){
				$iso_array = Language::getIsoById(intval($language['id_lang']));
				if(preg_match('/\/'.$iso_array.'\//i',$http_referrer)){
					$iso_code = $iso_array;
					break;
				}
			}
			$seo_friendly_url = '';
			$item_seo_url = '';
			
			
				$to = '/'.$iso_code.'/';
				$from = '/'.$lang_iso_redirect.'/';
				$http_referrer = str_replace($to,$from,$http_referrer);
				
				$to = $item_seo_url;
				$from = $seo_friendly_url;
				$http_referrer = str_replace($to,$from,$http_referrer);
				
			
		}
		
		}
		
		}
		
		// only for guestbook
		
		if(strlen($http_referrer)==0)
			$http_referrer = $_http_host;
		
		header("HTTP/1.1 301 Moved Permanently");
		header('Location: '.$http_referrer);
		parent::init();
	}
	
	public function setMedia()
	{
		parent::setMedia();
	}

	
	/**
	 * @see FrontController::initContent()
	 */
	public function initContent()
	{
		
		parent::initContent();
		
		$this->setTemplate('all.tpl');
		
	}
}