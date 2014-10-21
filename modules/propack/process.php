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

@ini_set('display_errors', 'on');
@error_reporting(E_ALL | E_STRICT);

include(dirname(__FILE__).'/propack.php');
include(dirname(__FILE__).'/classes/fourreferralsModule.php');

$obj = new propack();


$name_module = "propack";

if (version_compare(_PS_VERSION_, '1.5', '>')){
	$context = Context::getContext();
	$cookie = $context->cookie;
} else {
    global $cookie;
}

$ref = isset($cookie->id_customer)?$cookie->id_customer:0;
	  


$data_type = Tools::getValue('type');
$id_product = 0; //Tools::getValue('id_product');

if(version_compare(_PS_VERSION_, '1.6', '>')){
	$_http_host = Tools::getShopDomainSsl(true, true).__PS_BASE_URI__; 
} else {
	$_http_host = _PS_BASE_URL_.__PS_BASE_URI__;
}

	$type = 0;
	if($data_type == 'facebook'){
		// facebook
		$type = 1;
		$refnum =  Configuration::get($name_module.'frefnum');
		
	} elseif($data_type == 'twitter'){
		$type=2;
		$refnum =  Configuration::get($name_module.'trefnum');
		
	} elseif($data_type == 'google'){
		$type=4;
		$refnum =  Configuration::get($name_module.'grefnum');
		
	} elseif($data_type == 'linkedin'){
		$refnum =  Configuration::get($name_module.'lrefnum');
		
		$type=3;
	}
	
	
		// check for discount
		$fbrefnum =  Configuration::get($name_module.'frefnum');
		
		
		$return_data = fourreferralsModule::checkfordiscount(
											array('ref' => $ref,
											 	  'refnum' => $refnum,
												  'type' => $type, 
		 										  'ip' => $_SERVER['REMOTE_ADDR'],
												  'data_type'=>$data_type,
												  'id_currency' => (int)$cookie->id_currency,
												  'id_product'=>$id_product
												  )
											  				);
	
		$data_translate = $obj->translateText(); 
		
		$is_get_voucher = $return_data['is_get_voucher'];
		if($is_get_voucher==0)
		{
				
			echo '<h4>';
			echo '<img src="'.$_http_host.'modules/'.$name_module.'/img/promo_'.$data_type.'.png"/>&nbsp;';
					$_html = '';
					$_html .= $data_translate['share_text']. ' ';
					$id_product = (int)Tools::getValue('id_product');
					if($id_product){ 
					$_html .=	
						 $return_data['need_referrals_for_discount'] . ' ' . 
						 $obj->number_ending($return_data['need_referrals_for_discount'], $data_translate['products'], $data_translate['product'], $data_translate['products']) .' ';
					} 
					$_html .= 	$data_translate['share_text_two'];
					echo $_html;
			echo '</h4>';
			
			echo $return_data['have_referrals']." / ".$return_data['need_referrals_for_discount'];
			
		} else {
			echo '<h4>';
			echo '<img src="'.$_http_host.'modules/'.$name_module.'/img/promo_'.$data_type.'.png"/>&nbsp;';
			echo $data_translate['firsttext'].' '.$data_translate['discountvalue'];
			
			echo '</h4>';
			echo '<br/>';
			echo '<div class="block-data-voucher">'.$data_translate['secondtext'].': &nbsp;<b>'.$return_data['voucher_code'].'</b></div>';
			echo '<br/>';
			echo '<div class="block-data-voucher">'.$data_translate['threetext'].': &nbsp;<b>'.$return_data['date_until'].'</b></div>';
			
		}
		
		

	exit;