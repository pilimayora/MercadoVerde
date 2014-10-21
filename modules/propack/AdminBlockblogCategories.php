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
class AdminBlockblogCategories extends AdminTab{

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
		
		$tab = 'AdminBlockblogCategories';
		
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
			<span>'.$data_translate['title_categories'].'</span>
			
			</h3>
			
			<a class="add_new_button"
					 href="'.$currentIndex.'&tab='.$tab.'&add_item_category=1&configure='.$this->module.'&token='.$token.'"
					 >'.$data_translate['add_new'].'</a>
			<div class="clear_both"></div>';
		
		
		 ################# category ##########################
		 
		$add_item_category = Tools::getValue("add_item_category");
    	if (strlen($add_item_category)>0) {
    		echo $obj_main->_drawAddCategoryForm(array('currentindex'=>$currentIndex,'controller'=>$tab
        											   )
		        							     );
        } 
		
        // list category
       $page_cat = Tools::getValue("pagecategories");
       $list_categories = Tools::getValue("list_categories");
        if (strlen($page_cat)>0 || strlen($list_categories)>0) {
        	echo $top_menu_buttons;
        	echo $obj_main->_drawCategories(array('currentindex'=>$currentIndex,'controller'=>$tab));
		
        }
        
        
        $edit_item_category = Tools::getValue("edit_item_category");
    	if (strlen($edit_item_category)>0) {
    		echo $obj_main->_drawAddCategoryForm(array('action'=>'edit',
		        							  		   'id'=>Tools::getValue("id_category"),
        										       'currentindex'=>$currentIndex,'controller'=>$tab
        											   )
		        							     );
        }

        
        // add category
        if (Tools::isSubmit("submit_addcategory")) {
        	$seo_url = Tools::getValue("seo_url");
        	$languages = Language::getLanguages(false);
	    	$data_title_content_lang = array();
	    	
	    	if($this->_is15){
	    		$cat_shop_association = Tools::getValue("cat_shop_association");
	    	} else{
	    		$cat_shop_association = array(0=>1);
	    	}
	    	
	    	
	    	
	    	foreach ($languages as $language){
	    		$id_lang = $language['id_lang'];
	    		$category_title = Tools::getValue("category_title_".$id_lang);
	    		$category_seokeywords = Tools::getValue("category_seokeywords_".$id_lang);
	    		$category_seodescription = Tools::getValue("category_seodescription_".$id_lang);
	    		
	    		if(strlen($category_title)>0 && !empty($cat_shop_association))
	    		{
	    			$data_title_content_lang[$id_lang] = array('category_title' => $category_title,
	    									 				   'category_seokeywords' => $category_seokeywords,
	    			 										   'category_seodescription' => $category_seodescription,
	    													   'seo_url' =>$seo_url
	    														
	    													    );		
	    		}
	    	}
	    	
        	$data = array( 'data_title_content_lang'=>$data_title_content_lang,
        					'cat_shop_association' => $cat_shop_association
         				  );
         	
         		
        	
         	if(sizeof($data_title_content_lang)>0)
        		$obj_blog->saveCategory($data);
         	
         	Tools::redirectAdmin($currentIndex.'&tab='.$tab.'&list_categories=1&configure='.$this->module.'&token='.$token.'');
			 
         }
        // delete category
        $delete_item_category = Tools::getValue("delete_item_category");
        if (strlen($delete_item_category)>0) {
			if (Validate::isInt(Tools::getValue("id_category"))) {
				$obj_blog->deleteCategory(array('id'=>Tools::getValue("id_category")));
				Tools::redirectAdmin($currentIndex.'&tab='.$tab.'&list_categories=1&configure='.$this->module.'&token='.$token.'');
			}
		}
		// cancel edit category 
    	if (Tools::isSubmit('cancel_editcategory'))
        {
     	  	Tools::redirectAdmin($currentIndex.'&tab='.$tab.'&list_categories=1&configure='.$this->module.'&token='.$token.'');
		}
		//edit category
     	if (Tools::isSubmit("submit_editcategory")) {
     		$seo_url = Tools::getValue("seo_url");
     		$languages = Language::getLanguages(false);
	    	$data_title_content_lang = array();
	    	
     		if($this->_is15){
	    		$cat_shop_association = Tools::getValue("cat_shop_association");
	    	} else{
	    		$cat_shop_association = array(0=>1);
	    	}
	    	
	    	foreach ($languages as $language){
	    		$id_lang = $language['id_lang'];
	    		$category_title = Tools::getValue("category_title_".$id_lang);
	    		$category_seokeywords = Tools::getValue("category_seokeywords_".$id_lang);
	    		$category_seodescription = Tools::getValue("category_seodescription_".$id_lang);
	    		
	    		if(strlen($category_title)>0 && !empty($cat_shop_association))
	    		{
	    			$data_title_content_lang[$id_lang] = array('category_title' => $category_title,
	    									 				   'category_seokeywords' => $category_seokeywords,
	    													   'category_seodescription' => $category_seodescription,
	    													   'seo_url' =>$seo_url
	    													    );		
	    		}
	    	}
        	
     		
         	$id_editcategory = Tools::getValue("id_editcategory");
         	$data = array('data_title_content_lang'=>$data_title_content_lang,
        				  'id_editcategory' => $id_editcategory,
         				  'cat_shop_association' => $cat_shop_association
         				 );
         	
         	if(sizeof($data_title_content_lang)>0)
         		$obj_blog->updateCategory($data);
         	Tools::redirectAdmin($currentIndex.'&tab='.$tab.'&list_categories=1&configure='.$this->module.'&token='.$token.'');
			
         }
		 ################# category ##########################
		 /*var_dump(strlen($page_cat));
		 var_dump(strlen($list_categories));
		 var_dump(strlen($edit_item_category));
		 var_dump(!Tools::isSubmit("submit_addcategory"));
		 var_dump(strlen($delete_item_category));
		 var_dump(!Tools::isSubmit('cancel_editcategory'));*/
		 
		if (strlen($page_cat)==0 && strlen($list_categories)==0
			&& strlen($edit_item_category)==0 && !Tools::isSubmit("submit_addcategory")
			&& strlen($delete_item_category)==0 && !Tools::isSubmit('cancel_editcategory')
			&& !Tools::isSubmit("submit_editcategory") && strlen($add_item_category)==0
			){
			
			echo $top_menu_buttons;
				
			echo $obj_main->_drawCategories(array('currentindex'=>$currentIndex,'controller'=>$tab));
		}
		
		
	}
		

}

?>

