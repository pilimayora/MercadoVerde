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
$category_id = isset($_REQUEST['category_id'])?$_REQUEST['category_id']:0;

if (Configuration::get($name_module.'blogon') != 1)
	Tools::redirect('index.php');
	
	
include_once(dirname(__FILE__).'/classes/blog.class.php');
$obj_blog = new bloghelp();

$_is_friendly_url = $obj_blog->isURLRewriting();
$_iso_lng = $obj_blog->getLangISO();

if(version_compare(_PS_VERSION_, '1.6', '>')){
	$_http_host = Tools::getShopDomainSsl(true, true).__PS_BASE_URI__; 
} else {
	$_http_host = _PS_BASE_URL_.__PS_BASE_URI__;
}

if(Configuration::get($name_module.'urlrewrite_on') == 1 && is_numeric($category_id)){
	// redirect to seo url
	$seo_url_cat = $obj_blog->getSEOURLForCategory(array('id'=>$category_id));
	header("HTTP/1.1 301 Moved Permanently");
	Header('Location: '.$_http_host.$_iso_lng.'blog/category/'.$seo_url_cat.'');
}

$category_id = $obj_blog->getTransformSEOURLtoID(array('id'=>$category_id));

$_info_cat = $obj_blog->getCategoryItem(array('id' => $category_id));
$title = isset($_info_cat['category'][0]['title'])?$_info_cat['category'][0]['title']:'';
$seo_description = isset($_info_cat['category'][0]['seo_description'])?$_info_cat['category'][0]['seo_description']:'';
$seo_keywords = isset($_info_cat['category'][0]['seo_keywords'])?$_info_cat['category'][0]['seo_keywords']:''; 

$smarty->assign('meta_title' , $title);
$smarty->assign('meta_description' , $seo_description);
$smarty->assign('meta_keywords' , $seo_keywords);

if(version_compare(_PS_VERSION_, '1.6', '>')){
 	$smarty->assign($name_module.'is16' , 1);
} else {
 	$smarty->assign($name_module.'is16' , 0);
}

$smarty->assign($name_module.'urlrewrite_on', Configuration::get($name_module.'urlrewrite_on'));
$smarty->assign($name_module.'p_list_displ_date', Configuration::get($name_module.'p_list_displ_date'));
$smarty->assign($name_module.'rsson', Configuration::get($name_module.'rsson'));
		

if (version_compare(_PS_VERSION_, '1.5', '>')  && version_compare(_PS_VERSION_, '1.6', '<')) {
				if (isset(Context::getContext()->controller)) {
					$oController = Context::getContext()->controller;
				}
				else {
					$oController = new FrontController();
					$oController->init();
				}
				if(Configuration::get($name_module.'urlrewrite_on') == 1){
					$smarty->assign('page_name' , "blockblog-posts");
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



$step = Configuration::get($name_module.'perpage_posts');
$_data = $obj_blog->getPosts(array('start'=>0,'step'=>$step,'id'=>$category_id));


include_once(dirname(__FILE__).'/propack.php');
$obj_propack = new propack();

$_data_translate = $obj_propack->translateItems();
$page_translate = $_data_translate['page']; 
$paging = $obj_blog->PageNav(0,$_data['count_all'],$step,array('category_id'=>$category_id,'page'=>$page_translate));

// strip tags for content
foreach($_data['posts'] as $_k => $_item){
	$_data['posts'][$_k]['content'] = strip_tags($_item['content']);
	
}

$smarty->assign(array('posts' => $_data['posts'], 
					  'count_all' => $_data['count_all'],
					  'paging' => $paging
					  )
				);


if(version_compare(_PS_VERSION_, '1.5', '>')){
	
if(version_compare(_PS_VERSION_, '1.6', '>')){
					
		$obj_front_c = new ModuleFrontController();
		$obj_front_c->module->name = 'propack';
		$obj_front_c->setTemplate('category.tpl');
		
		$obj_front_c->setMedia();
		
		$obj_front_c->initHeader();
		$obj_front_c->initFooter();
		
		$obj_front_c->initContent();
		
		
		
		$obj_front_c->display();
		
	} else {
		echo $obj_propack->renderTplCategory();
	}
} else {
	echo Module::display(dirname(__FILE__).'/propack.php', 'category.tpl');
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