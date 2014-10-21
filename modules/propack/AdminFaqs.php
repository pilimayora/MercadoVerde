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
class AdminFaqs extends AdminTab{

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
		
		$tab = 'AdminFaqs';
		
		$token = $this->token;
		
		include_once(dirname(__FILE__).'/classes/blockfaqhelp.class.php');
		$obj_blockfaq = new blockfaqhelp();
		
		
		$id_self = (int)Tools::getValue('id');
		$order_self = Tools::getValue('order_self');
    	if($order_self){
				$obj_blockfaq->update_order($id_self, $order_self, Tools::getValue('id_change'), Tools::getValue('order_change'));
			}

			
    	$id_self = (int)Tools::getValue('id_faqcat');
		$order_self = Tools::getValue('order_self_faqcat');
		if($order_self){
				$obj_blockfaq->update_order_faqcat($id_self, $order_self, Tools::getValue('id_change_faqcat'), 
											 Tools::getValue('order_change_faqcat'));
			}
			
		if(Tools::isSubmit('submit_item_faq_cat')){
			
			
			$languages = Language::getLanguages(false);
	    	$data_title_content_lang = array();
	    	
        	if($this->_is15){
	    		$faq_shop_association = Tools::getValue("faq_shop_association");
	    	} else{
	    		$faq_shop_association = array(0=>0);
	    	}
	    	$cat_status = Tools::getValue("faq_cat_status");
	    	$faq_questions_association = Tools::getValue("faq_questions_association");
	    	
	    	foreach ($languages as $language){
	    		$id_lang = $language['id_lang'];
	    		$title = Tools::getValue("titlecat_".$id_lang);
	    		
	    		if(strlen($title)>0 && !empty($faq_shop_association))
	    		{
	    			$data_title_content_lang[$id_lang] = array('title' => $title,
	    									 				    );		
	    		}
	    	}
	    	
        	$data = array( 'data_title_content_lang'=>$data_title_content_lang,
        				   'item_status' => $cat_status,
        				   'faq_shop_association' => $faq_shop_association,
        				   'faq_questions_association'=>$faq_questions_association
         				  );
         				  
         	if(sizeof($data_title_content_lang)>0)
         		$obj_blockfaq->saveItemCategory($data);
        		
			Tools::redirectAdmin($currentIndex.'&tab='.$tab.'&configure='.$this->module.'&token='.$token.'');
		}	
		
		
		if(Tools::isSubmit('update_item_faq_cat')){
        	
        	
        	$id = Tools::getValue("id");
     		
        	$languages = Language::getLanguages(false);
	    	$data_title_content_lang = array();
        	if($this->_is15){
	    		$faq_shop_association = Tools::getValue("faq_shop_association");
	    	} else{
	    		$faq_shop_association = array(0=>0);
	    	}
	    	
	    	foreach ($languages as $language){
	    		$id_lang = $language['id_lang'];
	    		$title = Tools::getValue("titlecat_".$id_lang);
	    		
	    		if(strlen($title)>0 && !empty($faq_shop_association))
	    		{
	    			$data_title_content_lang[$id_lang] = array('title' => $title
	    									 				    );		
	    		}
	    	}
        	
         	$cat_status = Tools::getValue("faq_cat_status");
         	$faq_questions_association = Tools::getValue("faq_questions_association");
	    	
         	$data = array('data_title_content_lang'=>$data_title_content_lang,
        				  'id' => $id,
         				  'item_status' => $cat_status,
         				  'faq_shop_association' => $faq_shop_association,
         				  'faq_questions_association' => $faq_questions_association
         				  );
         	if(sizeof($data_title_content_lang)>0)
         		$obj_blockfaq->updateItemCategory($data);
        	
          	Tools::redirectAdmin($currentIndex.'&tab='.$tab.'&configure='.$this->module.'&token='.$token.'');
        }
        
   		 if (Tools::isSubmit("delete_item_faqcat")) {
			if (Validate::isInt(Tools::getValue("id"))) {
				
				$data = array('id' => Tools::getValue("id"));
				$obj_blockfaq->deleteItemCategory($data);
				
			Tools::redirectAdmin($currentIndex.'&tab='.$tab.'&configure='.$this->module.'&token='.$token.'');
			}
			
		}
		
    	if (Tools::isSubmit('cancel_item_faq_cat'))
        {
        Tools::redirectAdmin($currentIndex.'&tab='.$tab.'&configure='.$this->module.'&token='.$token.'');
        }
		
		if (Tools::isSubmit('submit_item_q'))
        {
        	
        	$languages = Language::getLanguages(false);
	    	$data_title_content_lang = array();
	    	
        	if($this->_is15){
	    		$faq_shop_association = Tools::getValue("faq_shop_association");
	    	} else{
	    		$faq_shop_association = array(0=>0);
	    	}
	    	
	    	$faq_item_status = Tools::getValue("faq_item_status");
	    	$is_by_customer = Tools::getValue("is_by_customer");
	    	$faq_customer_email = Tools::getValue("faq_customer_email");
	    	$faq_customer_name = Tools::getValue("faq_customer_name");
	    	$faq_category_association = Tools::getValue("faq_category_association");
	    	
	    	foreach ($languages as $language){
	    		$id_lang = $language['id_lang'];
	    		$title = Tools::getValue("titlefaq_".$id_lang);
	    		$content = Tools::getValue("contentfaq_".$id_lang);
	    		
	    		if(strlen($title)>0 && strlen($content)>0 && !empty($faq_shop_association))
	    		{
	    			$data_title_content_lang[$id_lang] = array('title' => $title,
	    									 				    'content' => $content
	    													    );		
	    		}
	    	}
	    	
        	$data = array( 'data_title_content_lang'=>$data_title_content_lang,
        				   'item_status' => 1,
        				   'faq_shop_association' => $faq_shop_association,
        				   'is_by_customer' => $is_by_customer,
        				   'faq_customer_name' => $faq_customer_name,
        				   'faq_customer_email'=>$faq_customer_email,
        				   'faq_category_association'=>$faq_category_association
         				  );
         	if(sizeof($data_title_content_lang)>0)
         		$obj_blockfaq->saveItem($data);
        	
         	Tools::redirectAdmin($currentIndex.'&tab='.$tab.'&configure='.$this->module.'&token='.$token.'');
		
		}
		
    	if (Tools::isSubmit("delete_item_q")) {
			if (Validate::isInt(Tools::getValue("id"))) {
				
				$data = array('id' => Tools::getValue("id"));
				$obj_blockfaq->deleteItem($data);
				
				Tools::redirectAdmin($currentIndex.'&tab='.$tab.'&configure='.$this->module.'&token='.$token.'');
			}
			
		}
		
		if (Tools::isSubmit('cancel_item_q'))
        {
        	Tools::redirectAdmin($currentIndex.'&tab='.$tab.'&configure='.$this->module.'&token='.$token.'');
		}
		
		if (Tools::isSubmit('update_item_q'))
        {
        	
        	$id = Tools::getValue("id");
     		
        	$languages = Language::getLanguages(false);
	    	$data_title_content_lang = array();
        	if($this->_is15){
	    		$faq_shop_association = Tools::getValue("faq_shop_association");
	    	} else{
	    		$faq_shop_association = array(0=>0);
	    	}
	    	
	    	$faq_item_status = Tools::getValue("faq_item_status");
	    	$is_by_customer = Tools::getValue("is_by_customer");
	    	$faq_customer_email = Tools::getValue("faq_customer_email");
	    	$faq_customer_name = Tools::getValue("faq_customer_name");
	    	$faq_category_association = Tools::getValue("faq_category_association");
	    	
	    	foreach ($languages as $language){
	    		$id_lang = $language['id_lang'];
	    		$title = Tools::getValue("titlefaq_".$id_lang);
	    		$content = Tools::getValue("contentfaq_".$id_lang);
	    		
	    		if(strlen($title)>0 && strlen($content)>0 && !empty($faq_shop_association))
	    		{
	    			$data_title_content_lang[$id_lang] = array('title' => $title,
	    									 				    'content' => $content
	    													    );		
	    		}
	    	}
        	
         	$data = array('data_title_content_lang'=>$data_title_content_lang,
        				  'id' => $id,
         				  'item_status' => $faq_item_status,
         				  'faq_shop_association' => $faq_shop_association,
         				  'is_by_customer' => $is_by_customer,
        				  'faq_customer_name' => $faq_customer_name,
        				  'faq_customer_email'=>$faq_customer_email,
        				  'faq_category_association'=>$faq_category_association,
         				  'is_add_by_customer' => $is_add_by_customer	
         				  );
         	if(sizeof($data_title_content_lang)>0)
         		$obj_blockfaq->updateItem($data);
         		
        	
         	Tools::redirectAdmin($currentIndex.'&tab='.$tab.'&configure='.$this->module.'&token='.$token.'');
         	
        }
		
		
		echo $obj_main->_jsandcss();
		echo $obj_main->drawFAQCategories(array('currentindex'=>$currentIndex,'controller'=>$tab));
     	echo '<br/>';
		echo $obj_main->drawFaqItems(array('currentindex'=>$currentIndex,'controller'=>$tab));
		
				
	}
		

}

?>

