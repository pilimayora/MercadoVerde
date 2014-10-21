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

include(dirname(__FILE__).'/../../../config/config.inc.php');
include(dirname(__FILE__).'/../../../init.php');
ob_start(); 
$status = 'success';
$message = '';

include_once(dirname(__FILE__).'/../classes/facebookhelp.class.php');
$obj_facebookhelp = new facebookhelp();

$action = $_REQUEST['action'];

switch ($action){
	case 'returnimage':
		$type = Tools::getValue('type');
		if($type == "facebook"){
			$obj_facebookhelp->deleteImage(array('type'=>1));
		} elseif($type == "google"){
			$obj_facebookhelp->deleteImage(array('type'=>2));
		} elseif($type == "paypal"){
			$obj_facebookhelp->deleteImage(array('type'=>3));
		} elseif($type == "facebooksmall"){
			$obj_facebookhelp->deleteImage(array('type'=>4));
		} elseif($type == "googlesmall"){
			$obj_facebookhelp->deleteImage(array('type'=>5));
		} elseif($type == "paypalsmall"){
			$obj_facebookhelp->deleteImage(array('type'=>6));
		} elseif($type == "twitter"){
			$obj_facebookhelp->deleteImage(array('type'=>7));
		} elseif($type == "twittersmall"){
			$obj_facebookhelp->deleteImage(array('type'=>8));
		} elseif($type == "yahoo"){
			$obj_facebookhelp->deleteImage(array('type'=>9));
		} elseif($type == "yahoosmall"){
			$obj_facebookhelp->deleteImage(array('type'=>10));
		} elseif($type == "linkedin"){
			$obj_facebookhelp->deleteImage(array('type'=>11));
		} elseif($type == "linkedinsmall"){
			$obj_facebookhelp->deleteImage(array('type'=>12));
		} elseif($type == "livejournal"){
			$obj_facebookhelp->deleteImage(array('type'=>13));
		} elseif($type == "livejournalsmall"){
			$obj_facebookhelp->deleteImage(array('type'=>14));
		} elseif($type == "microsoft"){
			$obj_facebookhelp->deleteImage(array('type'=>15));
		} elseif($type == "microsoftsmall"){
			$obj_facebookhelp->deleteImage(array('type'=>16));
		} /*elseif($type == "openid"){
			$obj_facebookhelp->deleteImage(array('type'=>17));
		} elseif($type == "openidsmall"){
			$obj_facebookhelp->deleteImage(array('type'=>18));
		}*/ elseif($type == "clavid"){
			$obj_facebookhelp->deleteImage(array('type'=>19));
		} elseif($type == "clavidsmall"){
			$obj_facebookhelp->deleteImage(array('type'=>20));
		} elseif($type == "flickr"){
			$obj_facebookhelp->deleteImage(array('type'=>21));
		} elseif($type == "flickrsmall"){
			$obj_facebookhelp->deleteImage(array('type'=>22));
		} elseif($type == "wordpress"){
			$obj_facebookhelp->deleteImage(array('type'=>23));
		} elseif($type == "wordpresssmall"){
			$obj_facebookhelp->deleteImage(array('type'=>24));
		} elseif($type == "aol"){
			$obj_facebookhelp->deleteImage(array('type'=>25));
		} elseif($type == "aolsmall"){
			$obj_facebookhelp->deleteImage(array('type'=>26));
		} 
	break;
	default:
		$status = 'error';
		$message = 'Unknown parameters!';
	break;
}


$response = new stdClass();
$content = ob_get_clean();
$response->status = $status;
$response->message = $message;	
$response->params = array('content' => $content);

echo json_encode($response);

?>