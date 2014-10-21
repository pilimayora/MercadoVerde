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

include_once(dirname(__FILE__).'/classes/blog.class.php');
$obj_blog = new bloghelp();

include_once(dirname(__FILE__).'/propack.php');
$obj_propack = new propack();
$_data_translate = $obj_propack->translateItems();

$smarty->assign('meta_title' , $_data_translate['meta_title_all_posts']);
$smarty->assign('meta_description' , $_data_translate['meta_description_all_posts']);
$smarty->assign('meta_keywords' , $_data_translate['meta_keywords_all_posts']);



$smarty->assign($name_module.'urlrewrite_on', Configuration::get($name_module.'urlrewrite_on'));
$smarty->assign($name_module.'p_list_displ_date', Configuration::get($name_module.'p_list_displ_date'));
$smarty->assign($name_module.'rsson', Configuration::get($name_module.'rsson'));
		
		
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
				if(Configuration::get($name_module.'urlrewrite_on') == 1){
					$smarty->assign('page_name' , "blockblog-all-posts");
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

$start = 0;
$search = Tools::getValue("search");
$is_search = 0;

### search ###
if(strlen($search)>0){
$is_search = 1;
$start = (int)Tools::getValue("start");
}

### archives ####
$year = (int)Tools::getValue("y");
$month = (int)Tools::getValue("m");
$is_arch = 0;
if($year!=0 && $month!=0){
	$is_arch = 1;
	$start = (int)Tools::getValue("start");
}


$_data = $obj_blog->getAllPosts(array('start'=>$start,'step'=>$step,
									  'is_search'=>$is_search,'search'=>$search,
									  'is_arch'=>$is_arch,'month'=>$month,'year'=>$year
									  )
								);


include_once(dirname(__FILE__).'/propack.php');
$obj_propack = new propack();

$_data_translate = $obj_propack->translateItems();
$page_translate = $_data_translate['page']; 
$paging = $obj_blog->PageNav($start,$_data['count_all'],$step,
						     array('all_posts'=>1,'page'=>$page_translate,
						     	   'is_search'=>$is_search,'search'=>$search,
						     	   'is_arch'=>$is_arch,'month'=>$month,'year'=>$year
						     	   )
						     );

// strip tags for content
foreach($_data['posts'] as $_k => $_item){
	$_data['posts'][$_k]['content'] = strip_tags($_item['content']);
	
}

$smarty->assign(array('posts' => $_data['posts'], 
					  'count_all' => $_data['count_all'],
					  'paging' => $paging,
					  $name_module.'is_search' => $is_search,
					  $name_module.'search' => $search
					  )
				);


if(version_compare(_PS_VERSION_, '1.5', '>')){
	
if(version_compare(_PS_VERSION_, '1.6', '>')){
					
		$obj_front_c = new ModuleFrontController();
		$obj_front_c->module->name = 'propack';
		$obj_front_c->setTemplate('all-posts.tpl');
		
		$obj_front_c->setMedia();
		
		$obj_front_c->initHeader();
		$obj_front_c->initFooter();
		
		$obj_front_c->initContent();
		
		
		
		$obj_front_c->display();
		
	} else {
		echo $obj_propack->renderTplAllPosts();
	}
} else {
	echo Module::display(dirname(__FILE__).'/propack.php', 'all-posts.tpl');
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