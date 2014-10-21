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
$post_id = isset($_REQUEST['post_id'])?$_REQUEST['post_id']:0;


if (Configuration::get($name_module.'blogon') != 1)
	Tools::redirect('index.php');

include_once(dirname(__FILE__).'/classes/blog.class.php');
$obj_blog = new bloghelp();


$_is_friendly_url = $obj_blog->isURLRewriting();
$_iso_lng = $obj_blog->getLangISO();

if(Configuration::get($name_module.'urlrewrite_on') == 1 && is_numeric($post_id)){
	// redirect to seo url
	$seo_url_post = $obj_blog->getSEOURLForPost(array('id'=>$post_id));
	header("HTTP/1.1 301 Moved Permanently");
	Header('Location: '._PS_BASE_URL_.__PS_BASE_URI__.$_iso_lng.'blog/post/'.$seo_url_post.'');
}

$post_id = $obj_blog->getTransformSEOURLtoIDPost(array('id'=>$post_id));


$_info_cat = $obj_blog->getPostItem(array('id' => $post_id,'site'=>1));

if(version_compare(_PS_VERSION_, '1.6', '>')){
	$_http_host = Tools::getShopDomainSsl(true, true).__PS_BASE_URI__; 
} else {
	$_http_host = _PS_BASE_URL_.__PS_BASE_URI__;
}

if(empty($_info_cat['post'][0]['id'])){
	header("HTTP/1.1 301 Moved Permanently");
	if(Configuration::get($name_module.'urlrewrite_on') == 1){
		Header('Location: '.$_http_host.$_iso_lng.'blog/');
	} else {
		Header('Location: '.$_http_host.'modules/'.$name_module.'/blockblog-all-posts.php');
	}
}

$title = isset($_info_cat['post'][0]['title'])?$_info_cat['post'][0]['title']:'';
$seo_description = isset($_info_cat['post'][0]['seo_description'])?$_info_cat['post'][0]['seo_description']:'';
$seo_keywords = isset($_info_cat['post'][0]['seo_keywords'])?$_info_cat['post'][0]['seo_keywords']:''; 

$smarty->assign('meta_title' , $title);
$smarty->assign('meta_description' , $seo_description);
$smarty->assign('meta_keywords' , $seo_keywords);

if(version_compare(_PS_VERSION_, '1.6', '>')){
 	$smarty->assign($name_module.'is16' , 1);
} else {
 	$smarty->assign($name_module.'is16' , 0);
}


$smarty->assign($name_module.'urlrewrite_on', Configuration::get($name_module.'urlrewrite_on'));
$smarty->assign($name_module.'post_display_date', Configuration::get($name_module.'post_display_date'));
$smarty->assign($name_module.'is_soc_buttons', Configuration::get($name_module.'is_soc_buttons'));



if (version_compare(_PS_VERSION_, '1.5', '>') && version_compare(_PS_VERSION_, '1.6', '<')) {
				if (isset(Context::getContext()->controller)) {
					$oController = Context::getContext()->controller;
				}
				else {
					$oController = new FrontController();
					$oController->init();
				}
				if(Configuration::get($name_module.'urlrewrite_on') == 1){
					$smarty->assign('page_name' , "blockblog-post");
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

########### category info ##################
$ids_cat = $_info_cat['post'][0]['category_ids'];
$category_data = array();
foreach($ids_cat as $k => $cat_id){
	$_info_ids = $obj_blog->getCategoryItem(array('id' => $cat_id));
	
	$is_active = 1;
	if(empty($_info_ids['category'][0]['title']))
		$is_active = 0;	
	$category_data[] = @$_info_ids['category'][0];
}
//var_dump($category_data);
########## end category info ###############


$step = Configuration::get($name_module.'perpage_posts');
$_data = $obj_blog->getComments(array('start'=>0,'step'=>$step,'id'=>$post_id));

include_once(dirname(__FILE__).'/propack.php');
$obj_propack = new propack();

$_data_translate = $obj_propack->translateItems();
$page_translate = $_data_translate['page']; 

$paging = $obj_blog->PageNav(0,$_data['count_all'],$step,array('post_id'=>$post_id,'page'=>$page_translate));


$smarty->assign(array('comments' => $_data['comments'], 
					  'count_all' => $_data['count_all'],
					  'paging' => $paging
					  )
				);

				
$smarty->assign(array('posts' => $_info_cat['post'],
					  'category_data' => $category_data,
					  'is_active' => $is_active
					  )
				);


if(version_compare(_PS_VERSION_, '1.5', '>')){
	
if(version_compare(_PS_VERSION_, '1.6', '>')){
					
		$obj_front_c = new ModuleFrontController();
		$obj_front_c->module->name = 'propack';
		$obj_front_c->setTemplate('post.tpl');
		
		$obj_front_c->setMedia();
		
		$obj_front_c->initHeader();
		$obj_front_c->initFooter();
		
		$obj_front_c->initContent();
		
		
		
		$obj_front_c->display();
		
	} else {
		echo $obj_propack->renderTplPost();
	}
} else {
	echo Module::display(dirname(__FILE__).'/propack.php', 'post.tpl');
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