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

ob_start();
	/*@ini_set('display_errors', 'on');	
	define('_PS_DEBUG_SQL_', true);
	define('_PS_DISPLAY_COMPATIBILITY_WARNING_', true);
	error_reporting(E_ALL|E_STRICT);
	*/
class AdminNews extends AdminTab{

	private $_is15;
	public function __construct()

	{
		$this->module = 'propack';
		
		if(version_compare(_PS_VERSION_, '1.5', '>')){
			$this->multishop_context = Shop::CONTEXT_ALL;
			$this->_is15 = 1;
		} else {
			$this->_is15 = 0;
		}
		
		
		parent::__construct();
		
	}
	
	public function addJS(){
		
	}
	
public function addCss(){
		
	}
	
	public function display()
	{
		echo '<style type="text/css">.warn{display:none!important}
									 #maintab20{display:none!important}
									 
		</style>';
		
		global $currentIndex,$cookie;
		// include main class
		require_once(dirname(__FILE__) .  '/propack.php');
		// instantiate
		$obj_main = new propack();
		
		$tab = 'AdminNews';
		
		$token = $this->token;
		
		include_once(dirname(__FILE__).'/classes/blocknewshelp.class.php');
		$obj_blocknews = new blocknewshelp();
		
		
		if (Tools::isSubmit('submit_item_n'))
        {
	        if($this->_is15){
		    		$cat_shop_association = Tools::getValue("cat_shop_association");
		    } else{
		    		$cat_shop_association = array(0=>0);
		    }
        	$seo_url = Tools::getValue("seo_url");
    		$languages = Language::getLanguages(false);
	    	$data_title_content_lang = array();
	    	foreach ($languages as $language){
	    		$id_lang = $language['id_lang'];
	    		$title = Tools::getValue("titlenews_".$id_lang);
	    		$content = Tools::getValue("contentnews_".$id_lang);
	    		$post_seokeywords = Tools::getValue("post_seokeywordsnews_".$id_lang);
	    		$post_seodescription = Tools::getValue("post_seodescriptionnews_".$id_lang);
	    		
	    		
	    		if(strlen($title)>0 && strlen($content)>0 && !empty($cat_shop_association))
	    		{
	    			$data_title_content_lang[$id_lang] = array('title' => $title,
	    									 				    'content' => $content,
	    														'post_seodescription' => $post_seodescription,
	    													    'post_seokeywords' => $post_seokeywords,
	    			 										    'seo_url' => $seo_url
	    													    
	    													    );		
	    		}
	    	}
	    	
        	$item_status = Tools::getValue("item_status");
        	
        	$data = array( 'data_title_content_lang'=>$data_title_content_lang,
         				 	'item_status' => $item_status,
        				  'cat_shop_association' => $cat_shop_association,
         				
         				  );
         	if(sizeof($data_title_content_lang)>0)
         		$obj_blocknews->saveItem($data);
        		
			Tools::redirectAdmin($currentIndex.'&tab='.$tab.'&configure='.$this->module.'&token='.$token);
		
		}
		
    	if (Tools::isSubmit("delete_item_n")) {
			if (Validate::isInt(Tools::getValue("id"))) {
				
				$data = array('id' => Tools::getValue("id"));
				$obj_blocknews->deleteItem($data);
				
				$page = Tools::getValue("pageitems_n");
				Tools::redirectAdmin($currentIndex.'&tab='.$tab.'&configure='.$this->module.'&token='.$token.'&pageitems_n='.$page);
		
			}
			
		}
		
	if (Tools::isSubmit('cancel_item_n'))
        {
        	$page = Tools::getValue("pageitems_n");
        	Tools::redirectAdmin($currentIndex.'&tab='.$tab.'&configure='.$this->module.'&token='.$token.'&pageitems_n='.$page);
		
		}
		
		if (Tools::isSubmit('update_item_n'))
        {
        	$id = Tools::getValue("id");
     		$seo_url = Tools::getValue("seo_url");
    		
        	if($this->_is15){
		    		$cat_shop_association = Tools::getValue("cat_shop_association");
		    } else{
		    		$cat_shop_association = array(0=>0);
		    }
     		
        	$languages = Language::getLanguages(false);
	    	$data_title_content_lang = array();
	    	foreach ($languages as $language){
	    		$id_lang = $language['id_lang'];
	    		$title = Tools::getValue("titlenews_".$id_lang);
	    		$content = Tools::getValue("contentnews_".$id_lang);
	    		$post_seokeywords = Tools::getValue("post_seokeywordsnews_".$id_lang);
	    		$post_seodescription = Tools::getValue("post_seodescriptionnews_".$id_lang);
	    		
	    		
	    		if(strlen($title)>0 && strlen($content)>0 && !empty($cat_shop_association))
	    		{
	    			$data_title_content_lang[$id_lang] = array('title' => $title,
	    									 				    'content' => $content,
	    			 											'post_seokeywords' => $post_seokeywords,
	    			 										  	'post_seodescription' => $post_seodescription,
	    													  	'seo_url'=>$seo_url
	    													    );		
	    		}
	    	}
        	
         	$item_status = Tools::getValue("item_status");
        	$post_images = Tools::getValue("post_images");
        	
         	$data = array('data_title_content_lang'=>$data_title_content_lang,
        				  'id' => $id,
         				  'item_status' => $item_status,
         				  'post_images' => $post_images,
         				  'cat_shop_association' => $cat_shop_association,
         				 );
         	if(sizeof($data_title_content_lang)>0)
         		$obj_blocknews->updateItem($data);
         		
         	$page = Tools::getValue("pageitems_n");
         	Tools::redirectAdmin($currentIndex.'&tab='.$tab.'&configure='.$this->module.'&token='.$token.'&pageitems_n='.$page);
		
        }
		
		
		echo $obj_main->_jsandcss();
		echo $obj_main->drawNews(array('currentindex'=>$currentIndex,'controller'=>$tab));
		
				
	}
		

}

?>

