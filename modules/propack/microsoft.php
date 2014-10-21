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
	
    include_once dirname(__FILE__).'/lib/microsoft/http.php';
    include_once dirname(__FILE__).'/lib/microsoft/oauth_client.php';
    include_once dirname(__FILE__).'/classes/microsofthelp.class.php';
    $microsofthelp = new microsofthelp();		
   
    
    $name_module = "propack";
	$http_referer = isset($_REQUEST['http_referer'])?$_REQUEST['http_referer']:'';
	
	if(version_compare(_PS_VERSION_, '1.6', '>')){
		$_http_host = Tools::getShopDomainSsl(true, true).__PS_BASE_URI__; 
	} else {
		$_http_host = _PS_BASE_URL_.__PS_BASE_URI__;
	}
	
    $client = new oauth_client_class();
    $client->server = 'Microsoft';
    $client->redirect_uri = $_http_host.'modules/'.$name_module.'/microsoft.php';
    
    
    $client->client_id = Configuration::get($name_module.'mclientid'); 
    $application_line = __LINE__;
    $client->client_secret = Configuration::get($name_module.'mclientsecret'); 

    if(strlen($client->client_id) == 0
    || strlen($client->client_secret) == 0)
        die('Please go to Microsoft Live Connect Developer Center page '.
            'https://manage.dev.live.com/AddApplication.aspx and create a new'.
            'application, and in the line '.$application_line.
            ' set the client_id to Client ID and client_secret with Client secret. '.
            'The callback URL must be '.$client->redirect_uri.' but make sure '.
            'the domain is valid and can be resolved by a public DNS.');

    /* API permissions
     */
    $client->scope = 'wl.basic wl.emails wl.birthday';
    if(($success = $client->Initialize()))
    {
        if(($success = $client->Process()))
        {
            if(strlen($client->authorization_error))
            {
                $client->error = $client->authorization_error;
                $success = false;
            }
            elseif(strlen($client->access_token))
            {
                $success = $client->CallAPI(
                    'https://apis.live.net/v5.0/me',
                    'GET', array(), array('FailOnAccessError'=>true), $user);
            }
        }
        $success = $client->Finalize($success);
    }
    if($client->exit)
        exit;
    if($success)
    {
    	
    	$last_name = $user->last_name;
    	$first_name = $user->first_name;
    	$email_address = isset($user->emails->preferred)?$user->emails->preferred:$user->emails->account;
    	
    	$data_profile = array('first_name'=>$first_name,
    					  'last_name'=>$last_name,
    					  'email'=>$email_address
    					 );
    
    	$microsofthelp->userLog(
    					 array('data'=>$data_profile, 
    						   'http_referer_custom'=>$http_referer 
							  )
					     );
        
    }
    else
    {
      echo 'Error:'.HtmlSpecialChars($client->error); 
    }