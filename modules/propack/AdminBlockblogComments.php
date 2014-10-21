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
class AdminBlockblogComments extends AdminTab{

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
		
		$tab = 'AdminBlockblogComments';
		
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
			<span>'.$data_translate['title_comments'].'</span>
			
			</h3>
			
			<div class="clear_both"></div>';
		
		 ################# comments ##########################
		
		
        // delete comments
        $delete_item_comments = Tools::getValue("delete_item_comments");
        
        if (strlen($delete_item_comments)>0) {
        	if (Validate::isInt(Tools::getValue("id_comments"))) {
				$obj_blog->deleteComment(array('id'=>Tools::getValue("id_comments")));
				Tools::redirectAdmin($currentIndex.'&tab='.$tab.'&list_comments=1&configure='.$this->module.'&token='.$token.'');
			}
		}
    	 //list comments
        $page_comments = Tools::getValue("pagecomments");
        $list_comments = Tools::getValue("list_comments");
        if (strlen($page_comments)>0 || strlen($list_comments)>0) {
        	echo $top_menu_buttons;
        	echo $obj_main->_drawComments(array('edit'=>2,'currentindex'=>$currentIndex,'controller'=>$tab));
        }
   	    $edit_item_comments = Tools::getValue("edit_item_comments");
    	if (strlen($edit_item_comments)>0) {
        	echo $obj_main->_drawEditComments(array('action'=>'edit',
		        						   			'id'=>Tools::getValue("id_comments"),
        											'currentindex'=>$currentIndex,'controller'=>$tab
        											)
		        						);
        }
    	// cancel edit comments 
    	if (Tools::isSubmit('cancel_editcomments'))
        {
       	Tools::redirectAdmin($currentIndex.'&tab='.$tab.'&list_comments=1&configure='.$this->module.'&token='.$token.'');
		}
     	//edit comments
     	if (Tools::isSubmit("submit_editcomments")) {
     		
     		$id_editcomments = Tools::getValue("id_editcomments");
     		
         	$comments_name = Tools::getValue("comments_name");
        	$comments_email = Tools::getValue("comments_email");
        	$comments_comment = Tools::getValue("comments_comment");
        	$comments_status = Tools::getValue("comments_status");
        	
         	$data = array('comments_name' => $comments_name,
         				  'comments_email' => $comments_email,
         				  'comments_comment' => $comments_comment,
         				  'comments_status' => $comments_status,
         	 			  'id_editcomments' => $id_editcomments
         				 );
         	if(strlen($comments_name)>0 && strlen($comments_comment)>0)
         		$obj_blog->updateComment($data);
         	Tools::redirectAdmin($currentIndex.'&tab='.$tab.'&list_comments=1&configure='.$this->module.'&token='.$token.'');
		 }
        ################# comments ##########################
		
		if (strlen($delete_item_comments)==0 && strlen($page_comments)==0 
			&& strlen($list_comments)==0 && strlen($edit_item_comments)==0
			&& !Tools::isSubmit('cancel_editcomments') && !Tools::isSubmit("submit_editcomments")
			){
			
			echo $top_menu_buttons;
				
			echo $obj_main->_drawComments(array('edit'=>2,'currentindex'=>$currentIndex,'controller'=>$tab));
		}
		
		 
		
	}
		

}

?>

