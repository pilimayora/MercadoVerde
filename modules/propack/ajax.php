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

session_start();
include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/../../init.php');
ob_start();
$status = 'success';
$message = '';

include_once(dirname(__FILE__).'/classes/blog.class.php');
$obj_blog = new bloghelp();

include_once(dirname(__FILE__).'/classes/reviewshelp.class.php');
$obj_reviewshelp = new reviewshelp();

include_once(dirname(__FILE__).'/propack.php');
$obj_propack = new propack();
			

$action = Tools::getValue('action');

$_is_friendly_url = $obj_blog->isURLRewriting();
$_iso_lng = $obj_blog->getLangISO();

$name_module = "propack"; 


if(version_compare(_PS_VERSION_, '1.6', '>')){
 	 $_is16 = 1;
} else {
	$_is16 = 0;
}
$smarty->assign($name_module.'is16', $_is16);





switch ($action){
	case 'addreview':
		$codeCaptcha = strlen(Tools::getValue('captcha'))>0?Tools::getValue('captcha'):'';
		$code = $_SESSION['secure_code'];
		
		$error_type = 0;
		
		$ok_captcha = 1;
		$is_captcha = Configuration::get($name_module.'is_captcha');
		if($is_captcha == 1){
			if($code == $codeCaptcha)
				$ok_captcha = 1;
			else
				$ok_captcha = 0;
		}
		
		$reviews_left = '';
		$reviews_right = '';
		
		if($ok_captcha == 1){
		$link = Tools::getValue('link');
		$rating = Tools::getValue('rating');
		$subject = Tools::getValue('subject');
		$text_review = Tools::getValue('text_review');
		$id_product = Tools::getValue('id_product');
		$id_customer = Tools::getValue('id_customer');
		$recommended_product = Tools::getValue('recommended_product');
		$email = trim(Tools::getValue('email'));
		$name = trim(Tools::getValue('name'));
		
		
		// get info about customer
		
		$info_customer_data = $obj_reviewshelp->getInfoAboutCustomer(array('id_customer'=>$id_customer));
		$customer_name = $info_customer_data['customer_name'];
		if($customer_name == "Guest"){
			$customer_name = $name;
		} else {
			$email = $info_customer_data['email'];
		}
		
		if(!preg_match("/[0-9a-z-_]+@[0-9a-z-_^\.]+\.[a-z]{2,4}/i", $email)) {
		    $error_type = 2;
			$status = 'error';
		 }
		
		 
		if($error_type == 0){
		
		//insert review
		
		$obj_reviewshelp->saveReview(array('id_product'=>$id_product,
										   'id_customer' => $id_customer,
										   'subject' => $subject,
										   'text_review' => $text_review,
										   'customer_name' => $customer_name,
										   'recommended_product'=>$recommended_product,
										   'rating' => $rating,
										   'email' => $email
										   )
									);
		
		
		$obj_reviewshelp->sendNotification(array('subject' => $subject,
												 'review' => $text_review
												 )
										   );
		
		}
		
		$info_reviews = $obj_reviewshelp->getReviews(array('id_product'=>$id_product,
														   'start' => 0
														   )
													 );
		$data = $info_reviews['reviews'];
		$data_count_reviews = $info_reviews['count_all_reviews'];
		
		
		$avg_rating = $obj_reviewshelp->getAvgReview(array('id_product' => $id_product));
		
		$smarty->assign($name_module.'subjecton', Configuration::get($name_module.'subjecton'));
		$smarty->assign($name_module.'recommendedon', Configuration::get($name_module.'recommendedon'));
    	$smarty->assign($name_module.'ipon', Configuration::get($name_module.'ipon'));
    	
    	$smarty->assign(array('reviews' => $data));
		
		
		ob_start();
		if(defined('_MYSQL_ENGINE_')){
			echo $obj_propack->renderTpl(array('name'=>'list_reviews','data' => $data));
		} else {
			echo Module::display(dirname(__FILE__).'/propack.php', 'list_reviews.tpl');
		}
		$_html = ob_get_clean();
		
		$_html_page_nav = $obj_reviewshelp->PageNavSite(0,
														$data_count_reviews,
														(int)Configuration::get($name_module.'revperpage'),
														$id_product
														);
														
		$position_reviews_left_right = Configuration::get($name_module.'position');
		
		} else {
			$_html_page_nav = '';
			$_html = '';
			$data_count_reviews = null;
			$avg_rating = null;
			
			// invalid security code (captcha)
			$error_type = 3;
			$status = 'error';
		}
	break;
	case 'pagenavsite':
		$start = (int) Tools::getValue('page');
		$id_product = (int) Tools::getValue('id_product');
		
		
		$data_reviews = $obj_reviewshelp->getReviews(array('id_product'=>$id_product,
														   'start' => $start
														   )
									 				);
		
		$count_all_reviews = $data_reviews['count_all_reviews'];
		$data = $data_reviews['reviews'];
		
		##################
		$_html_page_nav = $obj_reviewshelp->PageNavSite($start,$count_all_reviews,(int)Configuration::get($name_module.'revperpage'),$id_product);
		
		$smarty->assign($name_module.'subjecton', Configuration::get($name_module.'subjecton'));
		$smarty->assign($name_module.'recommendedon', Configuration::get($name_module.'recommendedon'));
    	$smarty->assign($name_module.'ipon', Configuration::get($name_module.'ipon'));
    	
    	$smarty->assign(array('reviews' => $data));
		#################
		
		
		ob_start();
		if(defined('_MYSQL_ENGINE_')){
		echo $obj_propack->renderTpl(array('name'=>'list_reviews','data' => $data));
		} else {
		echo Module::display(dirname(__FILE__).'/propack.php', 'list_reviews.tpl');	
		}
		$_html = ob_get_clean();
	break;
	case 'navallmy':
		$start = (int) Tools::getValue('page');
		
		global $cookie;
		$id_customer = isset($cookie->id_customer)?$cookie->id_customer:0;
		
	    $reviews_data = $obj_reviewshelp->getMyReviews(array('id_customer'=>$id_customer,'start'=>$start));
	    						 	
		$data = $reviews_data['reviews'];
		$count_reviews = $reviews_data['count_all'];
		
		$data_translate = $obj_propack->translateCustom();
		
		$_html_page_nav = $obj_reviewshelp->paging(array('start'=>$start,
						   'step'=> $obj_reviewshelp->getStepForMyReviewsAll(),
						   'count' => $count_reviews,
						   'page' => $data_translate['page'],
						   'all_my' => 1
						   )
					);
					
		
		
		$smarty->assign(array($name_module.'my_reviews' => $data,
							  $name_module.'paging' => $paging,
							  )
					    );
		$smarty->assign($name_module.'subjecton', Configuration::get($name_module.'subjecton'));
		$smarty->assign($name_module.'recommendedon', Configuration::get($name_module.'recommendedon'));
					    
		
    	ob_start();
		if(defined('_MYSQL_ENGINE_')){
			echo $obj_propack->renderListReviewsAllMy();
		} else {
			echo Module::display(dirname(__FILE__).'/propack.php', 'list_reviews_all_my.tpl');	
		}
		$_html = ob_get_clean();
		
	break;
	
	case 'pagenavblogcat':
		
		$page = (int) Tools::getValue('page');
		$_html_page_nav = '';
		$_html = '';
		
		$name_module = 'propack';
		
		$step = Configuration::get($name_module.'perpage_catblog');
		$_data = $obj_blog->getCategories(array('start'=>$page,'step'=>$step));
		
		$paging = $obj_blog->PageNav($page,$_data['count_all'],$step,array('category'=>1));
		
		$_html_page_nav = $paging;
		
		$smarty->assign(array('categories' => $_data['categories'], 
							  'count_all' => $_data['count_all'],
							  'paging' => $paging
							  )
						);
		$smarty->assign($name_module.'urlrewrite_on', Configuration::get($name_module.'urlrewrite_on'));
		$smarty->assign($name_module.'c_list_display_date', Configuration::get($name_module.'c_list_display_date'));

		if($_is_friendly_url){
			$smarty->assign($name_module.'iso_lng', $_iso_lng);
		} else {
			$smarty->assign($name_module.'iso_lng', '');
		}
		
		ob_start();
		if(version_compare(_PS_VERSION_, '1.5', '>')){
			include_once(dirname(__FILE__).'/propack.php');
			$obj_propack = new propack();
			echo $obj_propack->renderTplListCat_list();
		} else {
			echo Module::display(dirname(__FILE__).'/propack.php', 'list_blogcat.tpl');
		}
		$_html = ob_get_clean();

		
	break;
	case 'pagenav':
		$page = (int) Tools::getValue('page');
		$category_id = (int) Tools::getValue('item_id');
		$_html_page_nav = '';
		$_html = '';
		
		$name_module = 'propack';
		
		$step = Configuration::get($name_module.'perpage_posts');
		$_data = $obj_blog->getPosts(array('start'=>$page,'step'=>$step,'id'=>$category_id));
		
		// strip tags for content
		foreach($_data['posts'] as $_k => $_item){
			$_data['posts'][$_k]['content'] = strip_tags($_item['content']);
		}
		
		$paging = $obj_blog->PageNav($page,$_data['count_all'],$step,array('category_id'=>$category_id));
		
		$_html_page_nav = $paging;
		
		$smarty->assign(array('posts' => $_data['posts'], 
							  'count_all' => $_data['count_all'],
							  'paging' => $paging
							  )
						);
		$smarty->assign($name_module.'urlrewrite_on', Configuration::get($name_module.'urlrewrite_on'));
		$smarty->assign($name_module.'p_list_displ_date', Configuration::get($name_module.'p_list_displ_date'));
						
		if($_is_friendly_url){
			$smarty->assign($name_module.'iso_lng', $_iso_lng);
		} else {
			$smarty->assign($name_module.'iso_lng', '');
		}
		
		ob_start();
		if(version_compare(_PS_VERSION_, '1.5', '>')){
			echo $obj_propack->renderTplList_list();
		} else {
			echo Module::display(dirname(__FILE__).'/propack.php', 'list.tpl');
		}
		$_html = ob_get_clean();
		
		
	break;
	case 'pagenavall':
		$page = (int) Tools::getValue('page');
		$_html_page_nav = '';
		$_html = '';
		
		$name_module = 'propack';
		
		$step = Configuration::get($name_module.'perpage_posts');
		$_data = $obj_blog->getAllPosts(array('start'=>$page,'step'=>$step));
		
		// strip tags for content
		foreach($_data['posts'] as $_k => $_item){
			$_data['posts'][$_k]['content'] = strip_tags($_item['content']);
		}
		
		$paging = $obj_blog->PageNav($page,$_data['count_all'],$step,array('all_posts'=>1));
		
		$_html_page_nav = $paging;
		
		$smarty->assign(array('posts' => $_data['posts'], 
							  'count_all' => $_data['count_all'],
							  'paging' => $paging
							  )
						);
		$smarty->assign($name_module.'urlrewrite_on', Configuration::get($name_module.'urlrewrite_on'));
		$smarty->assign($name_module.'p_list_displ_date', Configuration::get($name_module.'p_list_displ_date'));
		
		if($_is_friendly_url){
			$smarty->assign($name_module.'iso_lng', $_iso_lng);
		} else {
			$smarty->assign($name_module.'iso_lng', '');
		}
						
		ob_start();
		if(version_compare(_PS_VERSION_, '1.5', '>')){
			echo $obj_propack->renderTplList_list();
		} else {
			echo Module::display(dirname(__FILE__).'/propack.php', 'list.tpl');
		}
		$_html = ob_get_clean();
		
		
	break;
	case 'pagenavcomments':
		$page = (int) Tools::getValue('page');
		$post_id = (int) Tools::getValue('item_id');
		$_html_page_nav = '';
		$_html = '';
		
		$name_module = 'propack';
		$step = Configuration::get($name_module.'perpage_posts');
		$_data = $obj_blog->getComments(array('start'=>$page,'step'=>$step,'id'=>$post_id));
		
		$paging = $obj_blog->PageNav($page,$_data['count_all'],$step,array('post_id'=>$post_id));
		
		$_html_page_nav = $paging;
		
		$smarty->assign(array('comments' => $_data['comments'], 
							  'count_all' => $_data['count_all'],
							  'paging' => $paging
							  )
						);
						
		ob_start();
		if(version_compare(_PS_VERSION_, '1.5', '>')){
			echo $obj_propack->renderTplList_comments();
		} else {
			echo Module::display(dirname(__FILE__).'/propack.php', 'list_comments.tpl');
		}
		$_html = ob_get_clean();
		
	break;
	case 'addcomment':
		$_html = '';
		$error_type = 0;
		
		$codeCaptcha = strlen(Tools::getValue('captcha'))>0?Tools::getValue('captcha'):'';
		$code = $_SESSION['secure_code'];
		
		
		$id_post = (int) Tools::getValue('id_post');
		$name = strip_tags(trim(htmlspecialchars(Tools::getValue('name'))));
		$email = trim(Tools::getValue('email'));
		$text_review = strip_tags(trim(htmlspecialchars(Tools::getValue('text_review'))));
		
		if(!preg_match("/[0-9a-z-_]+@[0-9a-z-_^\.]+\.[a-z]{2,4}/i", $email)) {
		    $error_type = 2;
			$status = 'error';
		 }
		 
		 if($error_type == 0 && strlen($name)==0){
			$error_type = 1;
			$status = 'error';
		 }
		 		 
		 if($error_type == 0 && strlen($text_review)==0){
			$error_type = 3;
			$status = 'error';
		 }
		 
		 if($code != $codeCaptcha){
			$error_type = 4;
			$status = 'error';
		}
		
		
		 if($error_type == 0){
			//insert review
			$_data = array('name' => $name,
						   'email' => $email,
						   'text_review' => $text_review,
						   'id_post' => $id_post
						   );
			$obj_blog->saveComment($_data);
			
		 }
		
		
	break;
	case 'deleteimg':
		$item_id = Tools::getValue('item_id');
		$obj_blog->deleteImg(array('id'=>$item_id));
	break;
	case 'addreviewtestim':
		include_once(dirname(__FILE__).'/classes/shopreviews.class.php');
		$obj_shopreviews = new shopreviews();
		
		$_html = '';
		$error_type = 0;
		$codeCaptcha = strlen(Tools::getValue('captcha'))>0?Tools::getValue('captcha'):'';
		$code = $_SESSION['secure_code'];
		
		
		$ok_captcha = 1;
		$is_captcha = Configuration::get($name_module.'tis_captcha');
		if($is_captcha == 1){
			if($code == $codeCaptcha)
				$ok_captcha = 1;
			else
				$ok_captcha = 0;
		}
		
		if($ok_captcha == 1){
		$name = strip_tags(trim(htmlspecialchars(Tools::getValue('name'))));
		$email = trim(Tools::getValue('email'));
		$web = strip_tags(str_replace("http://","",trim(Tools::getValue('web'))));
		$text_review = strip_tags(trim(htmlspecialchars(Tools::getValue('text_review'))));
		$company = strip_tags(trim(htmlspecialchars(Tools::getValue('company_review'))));
		$address = strip_tags(trim(htmlspecialchars(Tools::getValue('address_review'))));
		
		if(!preg_match("/[0-9a-z-_]+@[0-9a-z-_^\.]+\.[a-z]{2,4}/i", $email)) {
		    $error_type = 2;
			$status = 'error';
		 }
		 
		 if($error_type == 0 && strlen($name)==0){
			$error_type = 1;
			$status = 'error';
		 }
		 		 
		 if($error_type == 0 && strlen($text_review)==0){
			$error_type = 3;
			$status = 'error';
		 }
		
		 if($error_type == 0){
			//insert review
			$_data = array('name' => $name,
						   'email' => $email,
						   'web' => $web,
						   'text_review' => $text_review,
						   'company' => $company,
						   'address' => $address
						   );
						   
			$obj_shopreviews->saveTestimonial($_data);
		
		 }
		 
		} else {
			$_html = '';
			
			// invalid security code (captcha)
			$error_type = 4;
			$status = 'error';
		}
		
		
	break;
	case 'pagenavtestim':
		
		$page = (int) Tools::getValue('page');
		
		$_html_page_nav = '';
		$_html = '';
		
		include_once(dirname(__FILE__).'/classes/shopreviews.class.php');
		$obj_shopreviews = new shopreviews();
		
		
		$step = Configuration::get($name_module.'tperpage');
		$_data = $obj_shopreviews->getTestimonials(array('start'=>$page,'step'=>$step));
		
		$paging = $obj_shopreviews->PageNav($page,$_data['count_all_reviews'],$step);
		
		$_html_page_nav = $paging;
		
		$smarty->assign(array('reviews' => $_data['reviews']
							 )
						);
		$smarty->assign($name_module.'tis_web', Configuration::get($name_module.'tis_web'));
		$smarty->assign($name_module.'tis_company', Configuration::get($name_module.'tis_company'));
		$smarty->assign($name_module.'tis_addr', Configuration::get($name_module.'tis_addr'));
		
		
		ob_start();
		if(version_compare(_PS_VERSION_, '1.5', '>')){
			echo $obj_propack->renderTplListTestIm();
		} else {
			echo Module::display(dirname(__FILE__).'/propack.php', 'list_testim.tpl');
		}
		$_html = ob_get_clean();
						
		
		
	break;
	case 'addreviewguestbook':
		include_once(dirname(__FILE__).'/classes/guestbook.class.php');
		$obj_guestbook = new guestbook();
		$_html = '';
		$error_type = 0;
		$codeCaptcha = strlen(Tools::getValue('captcha'))>0?Tools::getValue('captcha'):'';
		$code = $_SESSION['secure_code'];
		
		$ok_captcha = 1;
		$is_captcha = Configuration::get($name_module.'gis_captcha');
		if($is_captcha == 1){
			if($code == $codeCaptcha)
				$ok_captcha = 1;
			else
				$ok_captcha = 0;
		}
		
		if($ok_captcha == 1){
		
		$name = strip_tags(trim(Tools::getValue('name')));
		$email = trim(Tools::getValue('email'));
		$text_review = strip_tags(trim(htmlspecialchars(Tools::getValue('text_review'))));
		
		if(!preg_match("/[0-9a-z-_]+@[0-9a-z-_^\.]+\.[a-z]{2,4}/i", $email)) {
		    $error_type = 2;
			$status = 'error';
		 }
		 
		 if($error_type == 0 && strlen($name)==0){
			$error_type = 1;
			$status = 'error';
		 }
		 		 
		 if($error_type == 0 && strlen($text_review)==0){
			$error_type = 3;
			$status = 'error';
		 }
		
		 if($error_type == 0){
			//insert item
			$_data = array('name' => $name,
						   'email' => $email,
						   'text_review' => $text_review
						   );
			$obj_guestbook->saveItem($_data);
			
		 }
		
		} else {
			$_html = '';
			
			// invalid security code (captcha)
			$error_type = 4;
			$status = 'error';
		}
		
	break;
	case 'pagenavguestbook':
		$page = (int) Tools::getValue('page');
		
		$_html_page_nav = '';
		$_html = '';
		
		include_once(dirname(__FILE__).'/classes/guestbook.class.php');
		$obj_guestbook = new guestbook();
		
		$step = Configuration::get($name_module.'gperpage');
		$_data = $obj_guestbook->getItems(array('start'=>$page,'step'=>$step));
		
		$paging = $obj_guestbook->PageNav($page,$_data['count_all_reviews'],$step);
		
		$_html_page_nav = $paging;
		
		$smarty->assign(array('reviews' => $_data['reviews']
							 )
						);
		
		ob_start();
		if(version_compare(_PS_VERSION_, '1.5', '>')){
			include_once(dirname(__FILE__).'/propack.php');
			$obj_propack = new propack();
			echo $obj_propack->renderTplListGuestbook();
		} else {
			echo Module::display(dirname(__FILE__).'/propack.php', 'list_guestbook.tpl');
		}
		$_html = ob_get_clean();
	
		
	break;
	case 'deleteimgnews':
		include_once(dirname(__FILE__).'/classes/blocknewshelp.class.php');
		$obj_blocknewshelp = new blocknewshelp();
		$item_id = Tools::getValue('item_id');
		$obj_blocknewshelp->deleteImg(array('id'=>$item_id));
	break;
	case 'pagenavnews':
		include_once(dirname(__FILE__).'/classes/blocknewshelp.class.php');
		$obj_blocknewshelp = new blocknewshelp();
		
		$page = (int) Tools::getValue('page');
		$_html_page_nav = '';
		$_html = '';
		
		$name_module = 'propack';
		
		$step = Configuration::get($name_module.'nperpage_posts');
		$_data = $obj_blocknewshelp->getItems(array('start'=>$page,'step'=>$step));
		
		// strip tags for content
		foreach($_data['items'] as $_k => $_item){
			$_data['items'][$_k]['content'] = strip_tags($_item['content']);
		}
		
		$paging = $obj_blocknewshelp->PageNav($page,$_data['count_all'],$step);
		
		$_html_page_nav = $paging;
		
		$smarty->assign($name_module.'urlrewrite_on', Configuration::get($name_module.'urlrewrite_on'));
		
		$is_friendly_url = $obj_blocknewshelp->isURLRewriting();
		$_is_friendly_url = $is_friendly_url;
		$_iso_lng = $obj_blocknewshelp->getLangISO();
		if($_is_friendly_url){
			$smarty->assign($name_module.'iso_lng', $_iso_lng);
		} else {
			$smarty->assign($name_module.'iso_lng', '');
		}
		
		$smarty->assign(array('posts' => $_data['items'], 
							  'count_all' => $_data['count_all'],
							  'paging' => $paging
							  )
						);
					
		ob_start();
		if(defined('_MYSQL_ENGINE_')){
			include_once(dirname(__FILE__).'/propack.php');
			$obj_propack = new propack();
			echo $obj_propack->renderTplListNews();
		} else {
			echo Module::display(dirname(__FILE__).'/propack.php', 'list_news.tpl');
		}
		$_html = ob_get_clean();
		
	break;
	case 'addquestion':
		$_html = '';
		$error_type = 0;
		$name_module = 'propack';


		include_once(dirname(__FILE__).'/classes/prodquestionshelp.class.php');
		$obj_prodquestionshelp = new prodquestionshelp();

		$name = htmlspecialchars(Tools::getValue('name'));
		$email = htmlspecialchars(Tools::getValue('email'));
		$text = htmlspecialchars(Tools::getValue('text_question'));
		$id_product = Tools::getValue('id_product');
		
		$codeCaptcha = strlen(Tools::getValue('captcha'))>0?Tools::getValue('captcha'):'';
		$code = $_SESSION['secure_code'];
		
		$ok_captcha = 1;
		$is_captcha = Configuration::get($name_module.'qis_captcha');
		if($is_captcha == 1){
			if($code == $codeCaptcha)
				$ok_captcha = 1;
			else
				$ok_captcha = 0;
		}
		
		if($ok_captcha == 1){
		if(!preg_match("/[0-9a-z-_]+@[0-9a-z-_^\.]+\.[a-z]{2,4}/i", $email)) {
		    $error_type = 2;
			$status = 'error';
		 }
		
		 if($error_type == 0){
		//insert item
		$obj_prodquestionshelp->saveItem(array('id_product'=>$id_product,
										   		'name' => $name,
												'email' => $email,
										   		'text' => $text
										   )
									);
		
		
		$obj_prodquestionshelp->sendNotification(array('name' => $name,
												 		'text' => $text
												 )
										   );
		 }
		} else {
			$_html = '';
			// invalid security code (captcha)
			$error_type = 3;
			$status = 'error';
		}
	break;
	case 'pagenavsitepq':
		$start = (int) Tools::getValue('page');
		$id_product = (int) Tools::getValue('id_product');
		
		include_once(dirname(__FILE__).'/classes/prodquestionshelp.class.php');
		$obj_prodquestionshelp = new prodquestionshelp();
		
		
		$info_items = $obj_prodquestionshelp->getItems(array('id_product'=>$id_product,
														     'start' => $start
														   )
													 );

		$data_count_items = $info_items['count_all_items'];
		
		$smarty->assign(array('items' => $info_items['items']
							 )
						);

		ob_start();
		if(version_compare(_PS_VERSION_, '1.5', '>')){
			include_once(dirname(__FILE__).'/propack.php');
			$obj_propack = new propack();
			echo $obj_propack->renderTplListProductQuestions();
		} else {
			echo Module::display(dirname(__FILE__).'/propack.php', 'list_questions.tpl');
		}
		$_html = ob_get_clean();
		
		$_html_page_nav = $obj_prodquestionshelp->PageNav($start,
														  $data_count_items,
														  Configuration::get($name_module.'qperpage_q'),
														  $id_product);
		
	break;
	case 'addfaqquestion':
		$error_type = 0;
		$_html = '';
		include_once(dirname(__FILE__).'/classes/blockfaqhelp.class.php');
		$obj_blockfaqhelp = new blockfaqhelp();
		
		$name = htmlspecialchars(Tools::getValue('name'));
		$email = htmlspecialchars(Tools::getValue('email'));
		$text = htmlspecialchars(Tools::getValue('text_question'));
		$category = Tools::getValue('category');
		
		$codeCaptcha = strlen(Tools::getValue('captcha'))>0?Tools::getValue('captcha'):'';
		$code = $_SESSION['secure_code'];
		
		$ok_captcha = 1;
		$is_captcha = Configuration::get($name_module.'faqis_captcha');
		if($is_captcha == 1){
			if($code == $codeCaptcha)
				$ok_captcha = 1;
			else
				$ok_captcha = 0;
		}
		
		if($ok_captcha == 1){
		if(!preg_match("/[0-9a-z-_]+@[0-9a-z-_^\.]+\.[a-z]{2,4}/i", $email)) {
		    $error_type = 2;
			$status = 'error';
		 }
		
		 if($error_type == 0){
		 	
		 	$data = array('category'=>$category,
						  'name' => $name,
					  	  'email' => $email,
						  'text' => $text
		 				 );
		 	$obj_blockfaqhelp->saveItemFAQ($data);
			
		 }
		} else {
			$_html = '';
			// invalid security code (captcha)
			$error_type = 3;
			$status = 'error';
		}
	break;
	case 'login':
		include(dirname(__FILE__).'/lib/Facebook/Exception.php');
		include(dirname(__FILE__).'/lib/Facebook/Api.php');
		
		$secret = $_REQUEST['secret'];
		$appid = $_REQUEST['appid'];
		$facebook = new Facebook_Api(array(
		  'appId'  => $appid,
		  'secret' => $secret,
		  'cookie' => true,
		));
		
		$fb_session = $facebook->getSession();
		
		// 	Session based API call.
		if ($fb_session) {
		  try {
		    $uid = $facebook->getUser();
		    $me = $facebook->api('/me');
		  } catch (Facebook_Exception $e) {
		    $status = 'error';
			$message = $e;
		  }
		}
		
		if(version_compare(_PS_VERSION_, '1.5', '>')){
        	$id_shop = Context::getContext()->shop->id;
        } else {
        	$id_shop = 0;
        }
        
        if(empty($me['email'])){
        	$status = 'error';
			$message = 'You don\'t have primary email in your Facebook Account. Go to Facebook -> Settings -> General -> Email and set Primary email!';
        } else {
		
		if (is_array($me)) {
			$sql= 'SELECT `customer_id`
					FROM `'._DB_PREFIX_.'fb_customer`
					WHERE `fb_id` = '.$me['id'].' AND `id_shop` = '.$id_shop.'
					LIMIT 1';
			$result = Db::getInstance()->ExecuteS($sql);
			
			if(sizeof($result)>0)
				$customer_id = $result[0]['customer_id'];
			else
				$customer_id = 0;
		}
		
		$exists_mail = 0;
		//chek for dublicate
		if(!empty($me['email'])){
			if(version_compare(_PS_VERSION_, '1.5', '>')){
			$sql = 'SELECT * FROM `'._DB_PREFIX_   .'customer` 
		        	WHERE `active` = 1 AND `email` = \''.pSQL($me['email']).'\'  
		        	AND `deleted` = 0 '.(defined('_MYSQL_ENGINE_')?"AND `is_guest` = 0":"").' AND `id_shop` = '.$id_shop.'';
			} else {
			$sql = 'SELECT * FROM `'._DB_PREFIX_   .'customer` 
		        	WHERE `active` = 1 AND `email` = \''.pSQL($me['email']).'\'  
		        	AND `deleted` = 0 '.(defined('_MYSQL_ENGINE_')?"AND `is_guest` = 0":"").'';
			}
			$result_exists_mail = Db::getInstance()->GetRow($sql);
			if($result_exists_mail)
				$exists_mail = 1;
		}
		
		$auth = 0;
		if($customer_id && $exists_mail){
			$auth = 1;
		}

		if(empty($customer_id) &&  $exists_mail){
			// insert record into customerXfacebook table
			$sql = 'INSERT into `'._DB_PREFIX_.'fb_customer` SET
						   customer_id = '.$result_exists_mail['id_customer'].', 
						   fb_id = '.$me['id'].',
						   id_shop = '.$id_shop.' ';
			Db::getInstance()->Execute($sql);
			
			$auth = 1;
		}
		
		
		
		if($auth){
			global $cookie;
			
			// authentication
			if(version_compare(_PS_VERSION_, '1.5', '>')){
			$sql = 'SELECT * FROM `'._DB_PREFIX_   .'customer` 
		        	WHERE `active` = 1 AND `email` = \''.pSQL($me['email']).'\'  
		        	AND `deleted` = 0 '.(defined('_MYSQL_ENGINE_')?"AND `is_guest` = 0":"").' AND `id_shop` = '.$id_shop.'
		        	'; 	
			} else {
			$sql = 'SELECT * FROM `'._DB_PREFIX_   .'customer` 
		        	WHERE `active` = 1 AND `email` = \''.pSQL($me['email']).'\'  
		        	AND `deleted` = 0 '.(defined('_MYSQL_ENGINE_')?"AND `is_guest` = 0":"").'
		        	'; 
			}
			$result = Db::getInstance()->GetRow($sql);
			
			if ($result){
			    $customer = new Customer();
			    
			    $customer->id = $result['id_customer'];
		        foreach ($result AS $key => $value)
		            if (key_exists($key, $customer))
		                $customer->{$key} = $value;
	        }
	        
	        $cookie->id_customer = intval($customer->id);
	        $cookie->customer_lastname = $customer->lastname;
	        $cookie->customer_firstname = $customer->firstname;
	        $cookie->logged = 1;
	        $cookie->passwd = $customer->passwd;
	        $cookie->email = $customer->email;
	        if (Configuration::get('PS_CART_FOLLOWING') AND (empty($cookie->id_cart) 
	        	OR Cart::getNbProducts($cookie->id_cart) == 0))
	            $cookie->id_cart = intval(Cart::lastNoneOrderedCart(intval($customer->id)));
			if(version_compare(_PS_VERSION_, '1.5', '>')){
				Hook::exec('authentication');
			} else {
			       	Module::hookExec('authentication');
			}
	        
	   	
		} else {
			$fb_id = $me['id'];
		
			//// create new user ////
			$gender = ($me['gender'] == 'male')?1:2;
			$id_default_group = 1;
			$firstname = pSQL($me['first_name']);
			$lastname = pSQL($me['last_name']);
			$email = $me['email'];

			// generate passwd
			srand((double)microtime()*1000000);
			$passwd = substr(uniqid(rand()),0,12);
			$real_passwd = $passwd; 
			$passwd = md5(pSQL(_COOKIE_KEY_.$passwd)); 
			
			$last_passwd_gen = date('Y-m-d H:i:s', strtotime('-'.Configuration::get('PS_PASSWD_TIME_FRONT').'minutes'));
			$secure_key = md5(uniqid(rand(), true));
			$active = 1;
			$date_add = date('Y-m-d H:i:s'); //'2011-04-04 18:29:15';
			$date_upd = $date_add;
			
			if(strlen($me['first_name'])==0 || strlen($me['last_name']) == 0){
				$status = 'error';
				$message = 'Empty First Name and Last Name!';
				exit;
			}
			$birthday = '';
			if(strlen($me['birthday'])>0){
				$birthday = strtotime($me['birthday']);
				$birthday = date("Ymd",$birthday);
				$birthday = 'birthday = \''.$birthday.'\',';
			}


			if(version_compare(_PS_VERSION_, '1.5', '>')){
				
				$id_shop_group = Context::getContext()->shop->id_shop_group;
				
				$sql = 'insert into `'._DB_PREFIX_.'customer` SET 
						   id_shop = '.$id_shop.', id_shop_group = '.$id_shop_group.',
						   id_gender = '.$gender.', id_default_group = '.$id_default_group.',
						   firstname = \''.$firstname.'\', lastname = \''.$lastname.'\',
						   email = \''.$email.'\', passwd = \''.$passwd.'\',
						   '.$birthday.'
						   last_passwd_gen = \''.$last_passwd_gen.'\',
						   secure_key = \''.$secure_key.'\', active = '.$active.',
						   date_add = \''.$date_add.'\', date_upd = \''.$date_upd.'\' ';
			
			} else {

			$sql = 'insert into `'._DB_PREFIX_.'customer` SET 
						   id_gender = '.$gender.', id_default_group = '.$id_default_group.',
						   firstname = \''.$firstname.'\', lastname = \''.$lastname.'\',
						   email = \''.$email.'\', passwd = \''.$passwd.'\',
						   '.$birthday.'
						   last_passwd_gen = \''.$last_passwd_gen.'\',
						   secure_key = \''.$secure_key.'\', active = '.$active.',
						   date_add = \''.$date_add.'\', date_upd = \''.$date_upd.'\' ';
			
			}
			
			Db::getInstance()->Execute($sql);
			
			$insert_id = Db::getInstance()->Insert_ID();
				
			
			
			// insert record in customer group
			$id_group = 1;
			$sql = 'INSERT into `'._DB_PREFIX_.'customer_group` SET 
						   id_customer = '.$insert_id.', id_group = '.$id_group.' ';
			Db::getInstance()->Execute($sql);
			
			
			
			
			// insert record into customerXfacebook table
			$sql_exists= 'SELECT `customer_id`
					FROM `'._DB_PREFIX_.'fb_customer`
					WHERE `fb_id` = '.$me['id'].' AND `id_shop` = '.$id_shop.'
					LIMIT 1';
			$result_exists = Db::getInstance()->ExecuteS($sql_exists);
			if(sizeof($result_exists)>0)
				$customer_id = $result_exists[0]['customer_id'];
			else
				$customer_id = 0;
				
			if($customer_id){
				$sql_del = 'DELETE FROM `'._DB_PREFIX_.'fb_customer` WHERE `customer_id` = '.$customer_id.' AND `id_shop` = '.$id_shop.'';
				Db::getInstance()->Execute($sql_del);
				
			}
			
				$sql = 'INSERT into `'._DB_PREFIX_.'fb_customer` SET
							   customer_id = '.$insert_id.', fb_id = '.$fb_id.', id_shop = '.$id_shop.' ';
				Db::getInstance()->Execute($sql);
			
			//// end create new user ///
			
			
			// auth customer
			global $cookie;
			$customer = new Customer();
	        $authentication = $customer->getByEmail(trim($email), trim($real_passwd));
	        if (!$authentication OR !$customer->id) {
	        	$status = 'error';
				$message = 'authentication failed!';
	        }
	        else
	        {
	            $cookie->id_customer = intval($customer->id);
	            $cookie->customer_lastname = $customer->lastname;
	            $cookie->customer_firstname = $customer->firstname;
	            $cookie->logged = 1;
	            $cookie->passwd = $customer->passwd;
	            $cookie->email = $customer->email;
	            if (Configuration::get('PS_CART_FOLLOWING') AND (empty($cookie->id_cart) OR Cart::getNbProducts($cookie->id_cart) == 0))
	                $cookie->id_cart = intval(Cart::lastNoneOrderedCart(intval($customer->id)));
		        if(version_compare(_PS_VERSION_, '1.5', '>')){
					Hook::exec('authentication');
				} else {
				       	Module::hookExec('authentication');
				}
	        }
			
			
			Mail::Send(intval($cookie->id_lang), 'account', 'Welcome!', 
    						array('{firstname}' => $customer->firstname, 
    							  '{lastname}' => $customer->lastname, 
    							  '{email}' => $customer->email, 
    							  '{passwd}' => $real_passwd), 
    							  $customer->email,
    							  $customer->firstname.' '.$customer->lastname);
			
		}
		
        }
		
	break;
	case 'logout':
	break;
	default:
		$status = 'error';
		$message = 'Unknown parameters!';
	break;
}


$response = new stdClass();
$content = ob_get_clean();
$response->status = $status;
$response->message = $message;	
if($action == "addreview") {
	$response->params = array('content' => $_html,'paging' => $_html_page_nav,
							  'count_reviews'=>$data_count_reviews,'avg_rating'=>$avg_rating,
							  'error_type' => $error_type
							  );
} elseif($action == "addcomment" || $action == "addreviewtestim" || $action == "addreviewguestbook"
			|| $action == "addquestion" || $action == 'addfaqquestion'){
	$response->params = array('content' => $_html,
							  'error_type' => $error_type
							  );
} elseif($action == "pagenav" || $action == "pagenavall" || $action == "pagenavsite" 
    	  || $action == "pagenavcomments" || $action == "pagenavblogcat" || $action == "navallmy" 
    	  || $action == "pagenavtestim" || $action == "pagenavguestbook" || $action == "pagenavnews"
    	  || $action == "pagenavsitepq")
	$response->params = array('content' => $_html, 'page_nav' => $_html_page_nav , 'paging' => $_html_page_nav);
else
	$response->params = array('content' => $content);
echo json_encode($response);

?>