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

include_once(dirname(__FILE__).'/classes/blocknewshelp.class.php');
$obj_blocknewshelp = new blocknewshelp();
$_data = $obj_blocknewshelp->getItems();

$step = Configuration::get($name_module.'nperpage_posts');
//var_dump($step);exit;
$paging = $obj_blocknewshelp->PageNav(0,$_data['count_all'],$step);

// strip tags for content
foreach($_data['items'] as $_k => $_item){
	$_data['items'][$_k]['content'] = strip_tags($_item['content']);
}

$smarty->assign(array('posts' => $_data['items'], 
					  'count_all' => $_data['count_all'],
					  'paging' => $paging
					  )
				);

$seo_text_data = $obj_blocknewshelp->getTranslateText();
$seo_text = $seo_text_data['seo_text'];
$smarty->assign('meta_title' , $seo_text);
$smarty->assign('meta_description' , $seo_text);
$smarty->assign('meta_keywords' , $seo_text);
				
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


include_once(dirname(__FILE__).'/propack.php');
$obj_propack = new propack();

if(version_compare(_PS_VERSION_, '1.5', '>')){
	if(version_compare(_PS_VERSION_, '1.6', '>')){
					
		$obj_front_c = new ModuleFrontController();
		$obj_front_c->module->name = 'propack';
		$obj_front_c->setTemplate('items.tpl');
		
		$obj_front_c->setMedia();
		
		$obj_front_c->initHeader();
		$obj_front_c->initFooter();
		
		$obj_front_c->initContent();
		
		
		
		$obj_front_c->display();
		
	} else {
		echo $obj_propack->renderTplItemsNews();
	}
} else {
	echo Module::display(dirname(__FILE__).'/propack.php', 'items.tpl');
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