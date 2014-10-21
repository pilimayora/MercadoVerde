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

session_start();
include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/../../init.php');

$status = 'success';
$message = '';
$action = isset($_REQUEST['action'])?$_REQUEST['action']:'';
$http_referer = urldecode($_REQUEST['http_referer']);

$name_module = 'propack';

include(dirname(__FILE__).'/lib/twitteroauth/twitteroauth.php');
include(dirname(__FILE__).'/classes/twitter.class.php');

$consumer_key = Configuration::get($name_module.'twitterconskey');
$consumer_secret = Configuration::get($name_module.'twitterconssecret');
$callback = "";

$obj_twitter = new twitter(array('key'=>$consumer_key,
								 'secret' =>$consumer_secret,
								 'callback' => $callback,
								 'http_referer'=>$http_referer )
						   );

switch($action){
	case 'callback':
		$obj_twitter->callback();
	break;
	case 'connect':
		$obj_twitter->connect();
	break;
	case 'login':
		$obj_twitter->login();
	break;
	default:
		$obj_twitter->login();
		if(version_compare(_PS_VERSION_, '1.6', '>')){
			$_http_host = Tools::getShopDomainSsl(true, true).__PS_BASE_URI__; 
		} else {
			$_http_host = _PS_BASE_URL_.__PS_BASE_URI__;
		}
	
	break;
}						   
						   

        
?>