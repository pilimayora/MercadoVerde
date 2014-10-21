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

ob_start();
	/*@ini_set('display_errors', 'on');	
	define('_PS_DEBUG_SQL_', true);
	define('_PS_DISPLAY_COMPATIBILITY_WARNING_', true);
	error_reporting(E_ALL|E_STRICT);
	*/
class AdminBlockblogPosts extends AdminTab{

	private $_is15;
	public function __construct()

	{
		$this->module = 'propack';
		
		if(version_compare(_PS_VERSION_, '1.5', '>')){
			$this->multishop_context = Shop::CONTEXT_ALL;
			$this->_is15 = 1;
		} else {
			$this->_is15 = 0;
		}
		
		
		parent::__construct();
		
	}
	
	public function addJS(){
		
	}
	
public function addCss(){
		
	}
	
	public function display()
	{
		echo '<style type="text/css">.warn{display:none!important}
									 #maintab20{display:none!important}
									 .add_new_button{border: 1px solid #DEDEDE; padding: 10px; margin-bottom: 10px; width:10%; display: block; font-size: 16px; color: maroon; text-align: center; font-weight: bold; text-decoration: underline;float:right}
  .title_breadcrumbs{border: 1px solid #DEDEDE;
    				color: #000000;
				    display: block;
				    font-size: 16px;
				    font-weight: bold;
				    margin: 0 0 10px 0;
				    padding: 10px;
				    text-align: left;
				    text-decoration: none;
				    width: auto;float:left}
	.clear_both{clear:both}
		</style>';
		
		global $currentIndex,$cookie;
		// include main class
		require_once(dirname(__FILE__) .  '/propack.php');
		// instantiate
		$obj_main = new propack();
		
		$tab = 'AdminBlockblogPosts';
		
		$token = $this->token;
		
		
		
		include_once(dirname(__FILE__).'/classes/blog.class.php');
		$obj_blog = new bloghelp();
		
		echo $obj_main->_jsandcss();
		
		$data_translate = $obj_main->translateItems();
		
		$top_menu_buttons = 
			'
			<h3 class="title_breadcrumbs">
			<span>'.$data_translate['title_home'].'</span>
			>
			<span>'.$data_translate['title_posts'].'</span>
			
			</h3>
			
			<a class="add_new_button"
					 href="'.$currentIndex.'&tab='.$tab.'&add_item_post=1&configure='.$this->module.'&token='.$token.'"
					 >'.$data_translate['add_new'].'</a>
			<div class="clear_both"></div>';
		
		
		  ################# posts ##########################
		$add_item_post = Tools::getValue("add_item_post");
    	if (strlen($add_item_post)>0) {
    		echo $obj_main->_drawAddPostForm(array('currentindex'=>$currentIndex,'controller'=>$tab
        											   )
		        							     );
        }   
		
        // add post
    	if (Tools::isSubmit("submit_addpost")) {
         	$seo_url = Tools::getValue("seo_url");
    		$languages = Language::getLanguages(false);
	    	$data_title_content_lang = array();
	    	
	    	$time_add = Tools::getValue("time_add");
	    	
    		if($this->_is15){
	    		$cat_shop_association = Tools::getValue("cat_shop_association");
	    	} else{
	    		$cat_shop_association = array(0=>1);
	    	}
	    	
	    	foreach ($languages as $language){
	    		$id_lang = $language['id_lang'];
	    		$post_title = Tools::getValue("post_title_".$id_lang);
	    		$post_seokeywords = Tools::getValue("post_seokeywords_".$id_lang);
	    		$post_seodescription = Tools::getValue("post_seodescription_".$id_lang);
	    		$post_content = Tools::getValue("content_".$id_lang);
	    		
	    		if(strlen($post_title)>0 && !empty($cat_shop_association))
	    		{
	    			$data_title_content_lang[$id_lang] = array('post_title' => $post_title,
	    									 				   'post_seokeywords' => $post_seokeywords,
	    			 										   'post_seodescription' => $post_seodescription,
	    													   'post_content' => $post_content,
	    														'seo_url' => $seo_url
	    													    );		
	    		}
	    	}
	    	
        	
         	$ids_categories = Tools::getValue("ids_categories");
        	$post_status = Tools::getValue("post_status");
        	$post_iscomments = Tools::getValue("post_iscomments");
        	
         	$data = array('data_title_content_lang'=>$data_title_content_lang,
         				  'ids_categories' => $ids_categories,
         				  'post_status' => $post_status,
         				  'post_iscomments' => $post_iscomments,
         				  'cat_shop_association' => $cat_shop_association,
         				  'time_add' => $time_add
         				 );
         				 
			
         				 
         	if(sizeof($data_title_content_lang)>0 && sizeof($ids_categories)>0)
         		$obj_blog->savePost($data);
         	Tools::redirectAdmin($currentIndex.'&tab='.$tab.'&list_posts=1&configure='.$this->module.'&token='.$token.'');
			
         }
        //list posts
        $page_cat = Tools::getValue("pageposts");
        $list_posts = Tools::getValue("list_posts");
        if (strlen($page_cat)>0 || strlen($list_posts)>0) {
        	echo $top_menu_buttons;
        	echo $obj_main->_drawPosts(array('edit'=>2,'currentindex'=>$currentIndex,'controller'=>$tab));
        }
    	$edit_item_posts = Tools::getValue("edit_item_posts");
    	if (strlen($edit_item_posts)>0) {
        	echo $obj_main->_drawAddPostForm(array('action'=>'edit',
		        						  'id'=>Tools::getValue("id_posts"),
        									'currentindex'=>$currentIndex,'controller'=>$tab)
										);
	     }
    	// delete posts
        $delete_item_posts = Tools::getValue("delete_item_posts");
        if (strlen($delete_item_posts)>0) {
			if (Validate::isInt(Tools::getValue("id_posts"))) {
				$obj_blog->deletePost(array('id'=>Tools::getValue("id_posts")));
				Tools::redirectAdmin($currentIndex.'&tab='.$tab.'&list_posts=1&configure='.$this->module.'&token='.$token.'');
			}
		}
    	// cancel edit posts 
    	if (Tools::isSubmit('cancel_editposts'))
        {
       	Tools::redirectAdmin($currentIndex.'&tab='.$tab.'&list_posts=1&configure='.$this->module.'&token='.$token.'');
		}
   		 //edit posts
     	if (Tools::isSubmit("submit_editposts")) {
     		$seo_url = Tools::getValue("seo_url");
     		$languages = Language::getLanguages(false);
	    	$data_title_content_lang = array();
	    	
	    	$time_add = Tools::getValue("time_add");
	    	
	    	if($this->_is15){
	    		$cat_shop_association = Tools::getValue("cat_shop_association");
	    	} else{
	    		$cat_shop_association = array(0=>1);
	    	}
	    	
	    	
	    	foreach ($languages as $language){
	    		$id_lang = $language['id_lang'];
	    		$post_title = Tools::getValue("post_title_".$id_lang);
	    		$post_seokeywords = Tools::getValue("post_seokeywords_".$id_lang);
	    		$post_seodescription = Tools::getValue("post_seodescription_".$id_lang);
	    		$post_content = Tools::getValue("content_".$id_lang);
	    		
	    		if(strlen($post_title)>0 && !empty($cat_shop_association))
	    		{
	    			$data_title_content_lang[$id_lang] = array('post_title' => $post_title,
	    									 				   'post_seokeywords' => $post_seokeywords,
	    			 										   'post_seodescription' => $post_seodescription,
	    													   'post_content' => $post_content,
	    														'seo_url'=>$seo_url
	    													    );		
	    		}
	    	}
     		
     		$id_editposts = Tools::getValue("id_editposts");
     		
         	$ids_categories = Tools::getValue("ids_categories");
        	$post_status = Tools::getValue("post_status");
        	$post_iscomments = Tools::getValue("post_iscomments");
        	$post_images = Tools::getValue("post_images");
        	
         	$data = array('data_title_content_lang'=>$data_title_content_lang,
         				  'ids_categories' => $ids_categories,
         				  'post_status' => $post_status,
         				  'post_iscomments' => $post_iscomments,
         				  'id_editposts' => $id_editposts,
         				  'post_images' => $post_images,
         				  'cat_shop_association' => $cat_shop_association,
         				  'time_add' => $time_add
         				 );
         	if(sizeof($data_title_content_lang)>0 && sizeof($ids_categories)>0)
         		$obj_blog->updatePost($data);
         	Tools::redirectAdmin($currentIndex.'&tab='.$tab.'&list_posts=1&configure='.$this->module.'&token='.$token.'');
		 }
         ################# posts ##########################
		
		if (!Tools::isSubmit("submit_addpost") && strlen($page_cat)==0 && 
			strlen($list_posts)==0 && strlen($edit_item_posts)==0 
			&& strlen($delete_item_posts)==0 && !Tools::isSubmit('cancel_editposts')
			&& !Tools::isSubmit("submit_editposts") && strlen($add_item_post) == 0
			){
			
			echo $top_menu_buttons;
				
			echo $obj_main->_drawPosts(array('edit'=>2,'currentindex'=>$currentIndex,'controller'=>$tab));
		}
		
	}
		

}

?>

