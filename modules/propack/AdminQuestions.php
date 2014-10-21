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
class AdminQuestions extends AdminTab{

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
		
		$tab = 'AdminQuestions';
		
		$token = $this->token;
		
		
		include_once(dirname(__FILE__).'/classes/prodquestionshelp.class.php');
		$obj_prodquestionshelp = new prodquestionshelp();
		
		
	 	// delete item
		if (Tools::isSubmit("delete_item_pq")) {
			if (Validate::isInt(Tools::getValue("id"))) {
				
				
				$obj_prodquestionshelp->delete(array('id'=>Tools::getValue("id")));
				$page = Tools::getValue("page_q");
				Tools::redirectAdmin($currentIndex.'&tab='.$tab.'&configure='.$this->module.'&token='.$token.'&page='.$page);
			}
		}
		
    	if (Tools::isSubmit('cancel_item_pq'))
        {
        	$page = Tools::getValue("page_q");
        	Tools::redirectAdmin($currentIndex.'&tab='.$tab.'&configure='.$this->module.'&token='.$token.'&page_q='.$page);
		}
		
     	if (Tools::isSubmit('submit_item_pq'))
        {
        	
        	$name = (strlen(Tools::getValue("name"))==0?Tools::getValue("name"):Tools::getValue("name"));
        	$question = Tools::getValue("question");
        	$response = Tools::getValue("response");
        	$publish = (int)Tools::getValue("publish");
        	$id = Tools::getValue("id");
     		
         	$data = array('name' => $name,
         				  'question' => $question,
         				  'id' => $id,
         				  'response' => $response,
         				  'publish' => $publish
         				 );
         	if(strlen($name)>0) {
         		$obj_prodquestionshelp->updateItem($data);
         		if($publish)
         			$obj_prodquestionshelp->sendNotificationResponse(array('id'=>$id));	
         	}
        	$page = Tools::getValue("page_q");
			Tools::redirectAdmin($currentIndex.'&tab='.$tab.'&configure='.$this->module.'&token='.$token.'&page_q='.$page);
		}
		
		
		
		echo $obj_main->_jsandcss();
		echo $obj_main->ModerateQuestions(array('currentindex'=>$currentIndex,'controller'=>$tab));
		
				
	}
		

}

?>

