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
class AdminReviews extends AdminTab{

	
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
		
		$tab = 'AdminReviews';
		$token = $this->token;

		// instantiate
		$obj_main = new propack();

		
		
		if(Tools::isSubmit('submit_item_rev')){
	    	require_once(_PS_MODULE_DIR_.'propack/classes/reviewshelp.class.php');
			
			$obj_reviewshelp = new reviewshelp();
			
			$action = Tools::getValue('submit_item_rev');
	    	$id = (int)Tools::getValue('id');
	    	
	    	switch($action){
	    		case 'Publish':
	    			$obj_reviewshelp->publish(array('id'=>$id));
					
	    		break;
	    		case 'Unpublish':
	    			$obj_reviewshelp->unpublish(array('id'=>$id));
	    		break;
	    		case 'delete':
	    			$obj_reviewshelp->delete(array('id'=>$id));
	    		break;
	    	}
	    	$page = Tools::getValue("page_rev");
	    	Tools::redirectAdmin($currentIndex.'&tab='.$tab.'&configure='.$this->name.'&token='.$token.'&page_rev='.$page);
	    }
	    
   		if (Tools::isSubmit('cancel_item_rev'))
        {
        	$page = Tools::getValue("page_rev");
        	Tools::redirectAdmin($currentIndex.'&tab='.$tab.'&configure='.$this->name.'&token='.$token.'&page_rev='.$page);
		}
		
    	if (Tools::isSubmit('save_item_rev'))
        {
        	require_once(_PS_MODULE_DIR_.'propack/classes/reviewshelp.class.php');
        	
			$obj_reviewshelp = new reviewshelp();
			
        	$name = Tools::getValue("name");
        	$email = Tools::getValue("email");
        	$subject = Tools::getValue("subject");
        	$text_review = Tools::getValue("text_review");
        	$publish = (int)Tools::getValue("publish");
        	$page = Tools::getValue("page");
        	$id = Tools::getValue("id");
        	$rating = Tools::getValue("rating");
        	$date_add = Tools::getValue("date_add");
        	$date_add_old = Tools::getValue("date_add_old");
        	
        	$obj_reviewshelp->updateReview(array('subject' => $subject,
        										 'text_review' => $text_review,
        										 'publish' => $publish,
        										 'id' => $id,
        										 'name' => $name,
        										 'email' => $email,
        										 'rating' => $rating,
        										 'date_add' => $date_add,
        										 'date_add_old' => $date_add_old
         										 )
        								   );
        	Tools::redirectAdmin($currentIndex.'&tab='.$tab.'&configure='.$this->name.'&token='.$token.'&page_rev='.Tools::getValue("page_rev"));
		}
		
		echo $obj_main->_jsandcss();
		
		echo $obj_main->_drawProductReviews(array('currentindex'=>$currentIndex,'controller'=>$tab));
		
		
	}
	
	
	
}





?>

