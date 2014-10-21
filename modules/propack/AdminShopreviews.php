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
class AdminShopreviews extends AdminTab{

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
		
		$tab = 'AdminShopreviews';
		
		$token = $this->token;
		
		
		include_once(dirname(__FILE__).'/classes/shopreviews.class.php');
		$obj_shopreviews = new shopreviews();
		
	    
       // publish
	   if (Tools::isSubmit("published_t")) {
			if (Validate::isInt(Tools::getValue("id"))){
				$obj_shopreviews->setPublsh(array('id'=>Tools::getValue("id"), 'active'=>1));
				Tools::redirectAdmin($currentIndex.'&tab='.$tab.'&configure='.$this->module.'&token='.$token.'');
			} 
		}
		
		//unpublish
		if (Tools::isSubmit("unpublished_t")) {
			if (Validate::isInt(Tools::getValue("id"))){
					$obj_shopreviews->setPublsh(array('id'=>Tools::getValue("id"), 'active'=>0));
					Tools::redirectAdmin($currentIndex.'&tab='.$tab.'&configure='.$this->module.'&token='.$token.'');
			} 
		}
		
    	// delete item
		if (Tools::isSubmit("delete_item_t")) {
			if (Validate::isInt(Tools::getValue("id"))) {
				$obj_shopreviews->deteleItem(array('id'=>Tools::getValue("id")));
				Tools::redirectAdmin($currentIndex.'&tab='.$tab.'&configure='.$this->module.'&token='.$token.'');
			}
			
		}
		
		if (Tools::isSubmit('submit_item_t'))
        {
        	$name = (strlen(Tools::getValue("name"))==0?Tools::getValue("name"):Tools::getValue("name"));
        	$email = (strlen(Tools::getValue("email"))==0?Tools::getValue("email"):Tools::getValue("email"));
        	$web = Tools::getValue("web");
        	$company = Tools::getValue("company");
        	$address = Tools::getValue("address");
        	
        	$message = (strlen(Tools::getValue("message"))==0?Tools::getValue("message"):Tools::getValue("message"));
        	$publish = (int)Tools::getValue("publish");
        	
        	
        	$obj_shopreviews->updateItem(array('name'=>$name,
        									   'email'=>$email,
        									   'web' =>$web,
        									   'message'=>$message,
        									   'publish'=>$publish,
        									   'address'=>$address,
        									   'company'=>$company,
        									   'id' =>Tools::getValue("id")
        									   )
        								);
        	
        	Tools::redirectAdmin($currentIndex.'&tab='.$tab.'&configure='.$this->module.'&token='.$token.'');
		}
       
		if (Tools::isSubmit('cancel_item_t'))
        {
        	Tools::redirectAdmin($currentIndex.'&tab='.$tab.'&configure='.$this->module.'&token='.$token.'');
		}
		
		echo $obj_main->_jsandcss();
		echo $obj_main->_drawTestImonials(array('currentindex'=>$currentIndex,'controller'=>$tab));
		
				
	}
		

}

?>

