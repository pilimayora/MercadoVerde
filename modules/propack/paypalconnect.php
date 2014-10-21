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

require_once(dirname(__FILE__).'/lib/paypal/auth.php');
require_once(dirname(__FILE__).'/classes/paypalhelp.class.php');

$paypalhelp = new paypalhelp();

$name_module = "propack";
$http_referer = $_REQUEST['http_referer'];

$data = array(
			  'key' => Configuration::get($name_module.'clientid'),
			  'secret' => Configuration::get($name_module.'psecret'), 
			  'scopes' => 'openid profile email address',
			  'return_url' => Configuration::get($name_module.'pcallback')
			);
$ppaccess = new PayPalAccess($data);

//if the code parameter is available, the user has gone through the auth process
if (isset($_GET['code'])){
	
	$token = $ppaccess->get_access_token();
		
	//use access token to get user profile
    $profile = $ppaccess->get_profile();
    
    $paypalhelp->userLog(
    					 array('data'=>$profile, 
    						   'http_referer_custom'=>$http_referer 
							  )
					     );
    
    //log the user out
    $ppaccess->end_session();
//if the code parameter is not available, the user should be pushed to auth
} else {
    //handle case where there was an error during auth (e.g. the user didn't log in / refused permissions / invalid_scope)
    if (isset($_GET['error_uri'])){
        echo "Error";
    //this is the first time the user has come to log in
    } else {
        //get auth url and redirect user browser to PayPal to log in
        $url = $ppaccess->get_auth_url();
        header("Location: $url");
    }
}