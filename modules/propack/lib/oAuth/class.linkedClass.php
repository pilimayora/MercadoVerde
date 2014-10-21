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

class linkedClass {
    private $config  =   array();

    public function __construct($data = null)
    {
        //include_once "config.php";
        //global $config;
        
        $this->config   =  $data;
       
    }

    public function linkedinGetUserInfo( $requestToken='', $oauthVerifier='', $accessToken=''){
        include_once (dirname(__FILE__).'/linkedinoAuth.php');

        $linkedin = new LinkedIn($this->config['access'], $this->config['secret']);
        $linkedin->request_token    =   unserialize($requestToken); //as data is passed here serialized form
        $linkedin->oauth_verifier   =   $oauthVerifier;
        $linkedin->access_token     =   unserialize($accessToken);

        try{
            $xml_response = $linkedin->getProfile("~:(id,first-name,last-name,interests,publications,patents,languages,skills,date-of-birth,email-address,phone-numbers,im-accounts,main-address,twitter-accounts,headline,picture-url,public-profile-url)");
        }
        catch (Exception $o){
            print_r($o);
        }
        return $xml_response;
    }
}
?>
