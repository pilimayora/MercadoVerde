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
	
    //include_once 'oAuth/config.php';
    include_once dirname(__FILE__).'/lib/oAuth/linkedinoAuth.php';
    include_once dirname(__FILE__).'/classes/linkedinhelp.class.php';
    
    $name_module = "propack";
	$http_referer = isset($_REQUEST['http_referer'])?$_REQUEST['http_referer']:'';
	
	$data = array(
				  'access' => Configuration::get($name_module.'lapikey'),
				  'secret' => Configuration::get($name_module.'lsecret') 
				);
				
	//var_dump($data); exit;			
	$linkedinhelp = new linkedinhelp();			
    $_http_host = $linkedinhelp->getBaseUrlCustom();
				
				
	$config = $data;
	
	if(strlen($config['access'])==0 || strlen($config['secret'])==0)
	 die("Error: Please fill LinkedIn API Key and LinkedIn Secret Key in the settings of the module.");
	
    # First step is to initialize with your consumer key and secret. We'll use an out-of-band oauth_callback
    $linkedin = new LinkedIn($config['access'], $config['secret'], $_http_host . 'modules/'.$name_module.'/linkedinauth.php' );
	//    $linkedin->debug = true;

    # Now we retrieve a request token. It will be set as $linkedin->request_token
    $linkedin->getRequestToken();
    $_SESSION['requestToken'] = serialize($linkedin->request_token);
  
    # With a request token in hand, we can generate an authorization URL, which we'll direct the user to
   ## echo "Authorization URL: " . $linkedin->generateAuthorizeUrl() . "\n\n";
    header("Location: " . $linkedin->generateAuthorizeUrl());
?>
