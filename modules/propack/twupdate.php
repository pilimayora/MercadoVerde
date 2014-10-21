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

include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/../../init.php');
ob_start();
$status = 'success';
$message = '';
$content = '';


@ini_set('display_errors', 'on');
@error_reporting(E_ALL | E_STRICT);

$customer_id = Tools::getValue('cid');

global $cookie;

include(dirname(__FILE__).'/propack.php');
$obj = new propack();

$tw_translate = $obj->twTranslate();

if($cookie->id_customer == $customer_id){
	$email = trim(Tools::getValue('email'));
	
	if (!Validate::isEmail($email)){
		$status = 'error';
		$message = $tw_translate['valid_email'];
	} elseif ($cookie->email != $email && Customer::customerExists($email, true)){
		$status = 'error';
		$message = $tw_translate['exists_customer'];
	}
	
	if($status!='error'){
		
		include(dirname(__FILE__).'/classes/twupdate.class.php');
		$twupdate = new twupdate();
		$twupdate->updateItem(array('email'=>$email,'id_customer'=> $customer_id));
		$content = $tw_translate['send_email'].' '.$email;
	}
	
} else {
	$status = 'error';
	$message = $tw_translate['log_in'];
}

	 
$response = new stdClass();
ob_get_clean();
//$content = ob_get_clean();
$response->status = $status;
$response->message = $message;	
$response->params = array('content' => $content);
echo json_encode($response);
