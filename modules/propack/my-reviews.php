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

$module_name = 'propack';

$_GET['controller'] = 'all'; 
$_GET['fc'] = 'module';
$_GET['module'] = $module_name;
require_once(dirname(__FILE__).'/../../config/config.inc.php');
require_once(dirname(__FILE__).'/../../init.php');

include_once(dirname(__FILE__).'/propack.php');
$obj = new propack();

if(version_compare(_PS_VERSION_, '1.6', '>')){
 	$smarty->assign($module_name.'is16' , 1);
} else {
 	$smarty->assign($module_name.'is16' , 1);
}


$id_customer = isset($cookie->id_customer)?$cookie->id_customer:0;
if (!$id_customer)
	Tools::redirect('authentication.php');
	

$smarty->assign('meta_title' , "Reviews");
$smarty->assign('meta_description' , "Reviews");
$smarty->assign('meta_keywords' , "Reviews");

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
	} else {
		if(version_compare(_PS_VERSION_, '1.5', '<'))
			include(dirname(__FILE__).'/../../header.php');
	}
	
include_once(dirname(__FILE__).'/classes/reviewshelp.class.php');
$obj_help = new reviewshelp();



$data_my_reviews = $obj_help->getMyReviews(array('id_customer'=>$id_customer,'start'=>0));

$data_translate = $obj->translateCustom();

$data = $data_my_reviews['reviews'];
$count_reviews = $data_my_reviews['count_all'];

$paging = $obj_help->paging(array('start'=>0,
						   'step'=> $obj_help->getStepForMyReviewsAll(),
						   'count' => $count_reviews,
						   'page' => $data_translate['page'],
						   'all_my' => 1
						   )
					);



$smarty->assign($module_name.'subjecton', Configuration::get($module_name.'subjecton'));
$smarty->assign($module_name.'recommendedon', Configuration::get($module_name.'recommendedon'));
		

$smarty->assign(array(
	$module_name.'my_reviews' => $data_my_reviews['reviews']
	));	
	
$smarty->assign($module_name.'paging', $paging);


if(version_compare(_PS_VERSION_, '1.5', '>')){
	if(version_compare(_PS_VERSION_, '1.6', '>')){
					
		$obj_front_c = new ModuleFrontController();
		$obj_front_c->module->name = 'propack';
		$obj_front_c->setTemplate('my-reviews.tpl');
		
		$obj_front_c->setMedia();
		
		$obj_front_c->initHeader();
		$obj_front_c->initFooter();
		
		$obj_front_c->initContent();
		
		
		
		$obj_front_c->display();
		
	} else {
		echo $obj->renderMyReviews();
	}
} else {
	echo Module::display(dirname(__FILE__).'/propack.php', 'my-reviews.tpl');
}
	
	
if (version_compare(_PS_VERSION_, '1.5', '>') && version_compare(_PS_VERSION_, '1.6', '<')) {
	if (isset(Context::getContext()->controller)) {
		$oController = Context::getContext()->controller;
	}
	else {
		$oController = new FrontController();
		$oController->init();
	}
	// header
		@$oController->displayFooter();
	} else {
		if(version_compare(_PS_VERSION_, '1.5', '<'))
			include(dirname(__FILE__).'/../../footer.php');
	}