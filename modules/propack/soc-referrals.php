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

$_GET['controller'] = 'all'; 
$_GET['fc'] = 'module';
$_GET['module'] = 'propack';
require_once(dirname(__FILE__).'/../../config/config.inc.php');
require_once(dirname(__FILE__).'/../../init.php');

include_once(dirname(__FILE__).'/classes/fourreferralsModule.php');

$_name_module = "propack";

if(version_compare(_PS_VERSION_, '1.6', '>')){
 	$smarty->assign($_name_module.'is16' , 1);
} else {
 	$smarty->assign($_name_module.'is16' , 1);
}

########### if module off ##############
if(version_compare(_PS_VERSION_, '1.6', '>')){
	$_http_host = Tools::getShopDomainSsl(true, true).__PS_BASE_URI__; 
} else {
	$_http_host = _PS_BASE_URL_.__PS_BASE_URI__;
}

$_fbrefon = (int)Configuration::get($_name_module.'fbrefon');
$_twrefon = (int)Configuration::get($_name_module.'twrefon');
$_grefon = (int)Configuration::get($_name_module.'grefon');
$_lrefon = (int)Configuration::get($_name_module.'lrefon');
if(!$_fbrefon && !$_twrefon && !$_grefon && !$_lrefon){
	Tools::redirect($_http_host);
}
########## end if module off ###########
	
include_once(dirname(__FILE__).'/propack.php');
$obj_propack = new propack();


global $cookie;
$current_language = (int)$cookie->id_lang;

foreach(array("f","g","l","t") as $type_ref){
	$smarty->assign($_name_module.$type_ref.'defaulttext', Configuration::get($_name_module.$type_ref.'defaulttext_'.$current_language));
		
}


$is_l = $obj_propack->is_l();

$frefnum =  Configuration::get($_name_module.'frefnum');
$trefnum =  Configuration::get($_name_module.'trefnum');
$grefnum =  Configuration::get($_name_module.'grefnum');
$lrefnum =  Configuration::get($_name_module.'lrefnum');

$smarty->assign(array(
	$_name_module.'frefnum' => $frefnum,
	$_name_module.'trefnum' => $trefnum,
	$_name_module.'grefnum' => $grefnum,
	$_name_module.'lrefnum' => $lrefnum,
	$_name_module.'is_l' => $is_l,
));	



$_data = array(
				'name'=>Configuration::get('PS_SHOP_NAME'),
				'description'=>Configuration::get('PS_SHOP_NAME'),
				'url'=>$_http_host
				);
$picture = 	$_http_host.'img/logo.jpg';

$smarty->assign($_name_module.'name', isset($_data['name'])?$_data['name']:'');
$smarty->assign($_name_module.'description', isset($_data['description'])?$_data['description']:'');
$smarty->assign($_name_module.'img', isset($picture)?$picture:'');
$smarty->assign($_name_module.'url', isset($_data['url'])?str_replace('&','&amp;', $_data['url']):'');
    	
	
			
$smarty->assign(array(
	$_name_module.'fbrefon' => (int)Configuration::get($_name_module.'fbrefon'),
	$_name_module.'twrefon' => (int)Configuration::get($_name_module.'twrefon'),
	$_name_module.'grefon' => (int)Configuration::get($_name_module.'grefon'),
	$_name_module.'lrefon' => (int)Configuration::get($_name_module.'lrefon'),
	
	$_name_module.'storename' => Configuration::get($_name_module.'storename_'.$current_language),
	$_name_module.'storedesc' => Configuration::get($_name_module.'storedesc_'.$current_language),
	));	

$is_logged = isset($cookie->id_customer)?$cookie->id_customer:0;
if (!$is_logged){
	Tools::redirect($_http_host);
}
	

$id_product = (int)Tools::getValue('id_product');
$data_exists_referrals = fourreferralsModule::getCustomerReferralsMyAccount(array('customer_id'=>$is_logged,'id_product'=>$id_product));


$smarty->assign($_name_module.'fe', $data_exists_referrals['facebook']);
$smarty->assign($_name_module.'te', $data_exists_referrals['twitter']);
$smarty->assign($_name_module.'ge', $data_exists_referrals['google']);
$smarty->assign($_name_module.'le', $data_exists_referrals['linkedin']);

$smarty->assign($_name_module.'gsize', Configuration::get($_name_module.'gsize'));
$smarty->assign($_name_module.'lsize', Configuration::get($_name_module.'lsize'));


if (version_compare(_PS_VERSION_, '1.5', '>') && version_compare(_PS_VERSION_, '1.6', '<')) {
				if (isset(Context::getContext()->controller)) {
					$oController = Context::getContext()->controller;
				}
				else {
					$oController = new FrontController();
					$oController->init();
				}
				// header
				$oController->setMedia();
				@$oController->displayHeader();
			}
			else {
				if(version_compare(_PS_VERSION_, '1.5', '<'))
					include_once(dirname(__FILE__).'/../../header.php');
			}

/* Discounts */

$discounts1 = Discount::getCustomerDiscounts((int)($cookie->id_lang), 
											(int)($cookie->id_customer), true, false);
		$nbDiscounts = 0;
		$discounts = array();
		foreach ($discounts1 AS $discount) {
			// delete used coupons
			if($discount['quantity'] == 0)
				continue;
			// get only FBREF coupons
			if ((stripos($discount['name'], 'FOUR-REF') !== FALSE) ||
				(stripos($discount['name'], 'FACEBOOK-REF') !== FALSE) ||
				(stripos($discount['name'], 'TWITTER-REF') !== FALSE) ||
				(stripos($discount['name'], 'GOOGLE-REF') !== FALSE) ||
				(stripos($discount['name'], 'LINKEDIN-REF') !== FALSE)
				) {
				$discounts[] = $discount;
				
				if ($discount['quantity_for_user'])
					$nbDiscounts++;
				
			}
			
			
		}

$smarty->assign(array('nbDiscounts' => (int)($nbDiscounts), 'discount' => $discounts));

if(version_compare(_PS_VERSION_, '1.5', '>')){
	
	if(version_compare(_PS_VERSION_, '1.6', '>')){
					
		$obj_front_c = new ModuleFrontController();
		$obj_front_c->module->name = 'propack';
		$obj_front_c->setTemplate('socreferrals.tpl');
		
		$obj_front_c->setMedia();
		
		$obj_front_c->initHeader();
		$obj_front_c->initFooter();
		
		$obj_front_c->initContent();
		
		
		
		$obj_front_c->display();
		
	} else {
		echo $obj_propack->renderTplfourreferrals();
	}
} else {
	echo Module::display(dirname(__FILE__).'/propack.php', 'socreferrals.tpl');
}


	if (version_compare(_PS_VERSION_, '1.5', '>') && version_compare(_PS_VERSION_, '1.6', '<')) {
				if (isset(Context::getContext()->controller)) {
					$oController = Context::getContext()->controller;
				}
				else {
					$oController = new FrontController();
					$oController->init();
				}
				// footer
				@$oController->displayFooter();
			}
			else {
				if(version_compare(_PS_VERSION_, '1.5', '<'))
					include_once(dirname(__FILE__).'/../../footer.php');
			}