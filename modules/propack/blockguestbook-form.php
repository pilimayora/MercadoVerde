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

$name_module = 'propack';
if (Configuration::get($name_module.'guon') != 1)
	Tools::redirect('index.php');

	
	
if(version_compare(_PS_VERSION_, '1.6', '>')){
 	$smarty->assign($name_module.'is16' , 1);
} else {
 	$smarty->assign($name_module.'is16' , 0);
}
	
include_once(dirname(__FILE__).'/propack.php');
$obj_propack = new propack();
$_data_translate = $obj_propack->translateItems();


$smarty->assign('meta_title' , $_data_translate['meta_title_guestbook']);
$smarty->assign('meta_description' , $_data_translate['meta_description_guestbook']);
$smarty->assign('meta_keywords' , $_data_translate['meta_keywords_guestbook']);


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


include_once(dirname(__FILE__).'/classes/guestbook.class.php');
$obj_guestbook = new guestbook();



$smarty->assign($name_module.'gis_captcha', Configuration::get($name_module.'gis_captcha'));


$step = Configuration::get($name_module.'gperpage');
$_data = $obj_guestbook->getItems(array('start'=>0,'step'=>$step));


$page_translate = $_data_translate['page']; 

$paging = $obj_guestbook->PageNav(0,$_data['count_all_reviews'],$step,array('page'=>$page_translate));


$smarty->assign(array('reviews' => $_data['reviews'], 
					  'count_all_reviews' => $_data['count_all_reviews'],
					  'paging' => $paging
					  )
				);


if(version_compare(_PS_VERSION_, '1.5', '>')){
	
if(version_compare(_PS_VERSION_, '1.6', '>')){
					
		$obj_front_c = new ModuleFrontController();
		$obj_front_c->module->name = 'propack';
		$obj_front_c->setTemplate('blockguestbook.tpl');
		
		$obj_front_c->setMedia();
		
		$obj_front_c->initHeader();
		$obj_front_c->initFooter();
		
		$obj_front_c->initContent();
		
		
		
		$obj_front_c->display();
		
	} else {
		echo $obj_propack->renderTplGuestbook();
	}
} else {
	echo Module::display(dirname(__FILE__).'/propack.php', 'blockguestbook.tpl');
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

?>