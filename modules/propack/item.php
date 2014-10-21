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

if (Configuration::get($name_module.'newson') != 1)
	Tools::redirect('index.php');

if(version_compare(_PS_VERSION_, '1.6', '>')){
$_http_host = Tools::getShopDomainSsl(true, true).__PS_BASE_URI__; 
} else {
$_http_host = _PS_BASE_URL_.__PS_BASE_URI__;
}	
	
include_once(dirname(__FILE__).'/classes/blocknewshelp.class.php');
$obj_blocknewshelp = new blocknewshelp();

$post_id = Tools::getValue('item_id');
if(!is_numeric($post_id) && Configuration::get($name_module.'urlrewrite_on')==1)
	$post_id = $obj_blocknewshelp->getTransformSEOURLtoIDItem(array('id'=>$post_id));

// if disable url rewrite and url not modified
if(!is_numeric($post_id) && Configuration::get($name_module.'urlrewrite_on')==0){
	$post_id = $obj_blocknewshelp->getTransformSEOURLtoIDItem(array('id'=>$post_id));
	header("HTTP/1.1 301 Moved Permanently");
	Header('Location: '.$_http_host.'modules/'.$name_module.'/item.php?item_id='.$post_id);
}
	
$_info_cat = $obj_blocknewshelp->getItem(array('id' => $post_id,'site'=>1));

$title = isset($_info_cat['item'][0]['title'])?$_info_cat['item'][0]['title']:'';
$seo_description = isset($_info_cat['item'][0]['seo_description'])?$_info_cat['item'][0]['seo_description']:'';
$seo_keywords = isset($_info_cat['item'][0]['seo_keywords'])?$_info_cat['item'][0]['seo_keywords']:''; 

$smarty->assign('meta_title' , $title);
$smarty->assign('meta_description' , $seo_description);
$smarty->assign('meta_keywords' , $seo_keywords);

$smarty->assign($name_module.'urlrewrite_on', Configuration::get($name_module.'urlrewrite_on'));

if(version_compare(_PS_VERSION_, '1.6', '>')){
 	$smarty->assign($name_module.'is16' , 1);
} else {
 	$smarty->assign($name_module.'is16' , 0);
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
				$oController->setMedia();
				@$oController->displayHeader();
			}
			else {
				if(version_compare(_PS_VERSION_, '1.5', '<'))
					include_once(dirname(__FILE__).'/../../header.php');
			}



$step = Configuration::get($name_module.'perpage_posts');

				
$smarty->assign(array('posts' => $_info_cat['item']));

include_once(dirname(__FILE__).'/propack.php');
$obj_propack = new propack();

if(version_compare(_PS_VERSION_, '1.5', '>')){
	if(version_compare(_PS_VERSION_, '1.6', '>')){
					
		$obj_front_c = new ModuleFrontController();
		$obj_front_c->module->name = 'propack';
		$obj_front_c->setTemplate('item.tpl');
		
		$obj_front_c->setMedia();
		
		$obj_front_c->initHeader();
		$obj_front_c->initFooter();
		
		$obj_front_c->initContent();
		
		
		
		$obj_front_c->display();
		
	} else {
		echo $obj_propack->renderTplItemNews();
	}
} else {
	echo Module::display(dirname(__FILE__).'/propack.php', 'item.tpl');
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