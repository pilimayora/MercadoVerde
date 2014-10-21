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
if (Configuration::get($name_module.'blogon') != 1)
	Tools::redirect('index.php');

$category_id = isset($_REQUEST['category_id'])?(int)$_REQUEST['category_id']:0;

include_once(dirname(__FILE__).'/classes/blog.class.php');
$obj_blog = new bloghelp();

$category_id = $obj_blog->getTransformSEOURLtoID(array('id'=>$category_id));

include_once(dirname(__FILE__).'/propack.php');
$obj_propack = new propack();
$_data_translate = $obj_propack->translateItems();


$smarty->assign('meta_title' , $_data_translate['meta_title_categories']);
$smarty->assign('meta_description' , $_data_translate['meta_description_categories']);
$smarty->assign('meta_keywords' , $_data_translate['meta_keywords_categories']);


if(version_compare(_PS_VERSION_, '1.6', '>')){
 	$smarty->assign($name_module.'is16' , 1);
} else {
 	$smarty->assign($name_module.'is16' , 0);
}

$smarty->assign($name_module.'urlrewrite_on', Configuration::get($name_module.'urlrewrite_on'));
$smarty->assign($name_module.'c_list_display_date', Configuration::get($name_module.'c_list_display_date'));

if (version_compare(_PS_VERSION_, '1.5', '>')  && version_compare(_PS_VERSION_, '1.6', '<')) {
				if (isset(Context::getContext()->controller)) {
					$oController = Context::getContext()->controller;
					
				}
				else {
					$oController = new FrontController();
					$oController->init();
				}
				if(Configuration::get($name_module.'urlrewrite_on') == 1){
					$smarty->assign('page_name' , "blockblog-categories");
				} else {
					$page_name = str_replace(array('.php', '/'), array('', '-'),$_SERVER['REQUEST_URI']);
					$page_name = 'module'.$page_name;
				}
				// header
				$oController->setMedia();
				@$oController->displayHeader();
			}
			else {
				if(version_compare(_PS_VERSION_, '1.5', '<'))
					include_once(dirname(__FILE__).'/../../header.php');
			}


$step = Configuration::get($name_module.'perpage_catblog');
$_data = $obj_blog->getCategories(array('start'=>0,'step'=>$step));




$page_translate = $_data_translate['page']; 

$paging = $obj_blog->PageNav(0,$_data['count_all'],$step,array('category'=>1,'page'=>$page_translate));



$smarty->assign(array('categories' => $_data['categories'], 
					  'count_all' => $_data['count_all'],
					  'paging' => $paging
					  )
				);


if(version_compare(_PS_VERSION_, '1.5', '>')){
	
if(version_compare(_PS_VERSION_, '1.6', '>')){
					
		$obj_front_c = new ModuleFrontController();
		$obj_front_c->module->name = 'propack';
		$obj_front_c->setTemplate('categories.tpl');
		
		$obj_front_c->setMedia();
		
		$obj_front_c->initHeader();
		$obj_front_c->initFooter();
		
		$obj_front_c->initContent();
		
		
		
		$obj_front_c->display();
		
	} else {
		echo $obj_propack->renderTplCategories();
	}
} else {
	echo Module::display(dirname(__FILE__).'/propack.php', 'categories.tpl');
}

	if (version_compare(_PS_VERSION_, '1.5', '>')  && version_compare(_PS_VERSION_, '1.6', '<')) {
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