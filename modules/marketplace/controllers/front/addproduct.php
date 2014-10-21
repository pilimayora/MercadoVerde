<?php

if (!defined('_PS_VERSION_'))
	exit;
include_once dirname(__FILE__).'/../../classes/MarketplaceClassInclude.php';
class marketplaceAddproductModuleFrontController extends ModuleFrontController
{
	public $ssl = true; 
	
	public function initContent() {

		global $smarty;	
		global $cookie;
		global $exclude;  //Variable for recursive category tree
		global $depth;  //Variable for recursive category tree
		parent::initContent();

		  if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false) 
						 { 
						   $smarty->assign("browser", "ie");
						 }
						 else
						 {
						   $smarty->assign("browser", "notie");
						 }
		$id_lang = $this->context->cookie->id_lang;
		
		$link = new link();
		
		if(isset($this->context->cookie->id_customer)) {
			if(isset($this->context->cookie->id_customer)) {

				$id_cutomer = $this->context->cookie->id_customer;

				$login = 1;

			} else {

				$login = 0;

			}
			$is_main_er = Tools::getValue('is_main_er');
			if($is_main_er) {
				$smarty->assign("is_main_er",$is_main_er);
			} else {
				$smarty->assign("is_main_er",'0');
			}
			if(isset($_GET['su']) && $_GET['su']!='') {
				$smarty->assign("product_upload",$_GET['su']);
			} 
			else
			{
			$smarty->assign("product_upload",'0');
			}
		
			

			

			$smarty->assign("login",$login);

			

			$add_size =  Configuration::get('add-size');

			$add_color =  Configuration::get('add-color');

			$add_border_color =  Configuration::get('add-border-color');

			$add_font_family =  Configuration::get('add-font-family');

			
			
			$smarty->assign("add_size",$add_size);

			$smarty->assign("add_color",$add_color);

			$smarty->assign("add_border_color",$add_border_color);

			$smarty->assign("add_font_family",$add_font_family);

			$smarty->assign("is_seller",1);	
			
			
			$customer_id     = $this->context->cookie->id_customer;
			 $market_place_shop       = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select `id`,`is_active` ,`about_us` from `" . _DB_PREFIX_ . "marketplace_shop` where id_customer =" . $customer_id . " ");
			 
				$id_shop   = $market_place_shop['id'];
			  
				$smarty->assign("id_shop", $id_shop);
				$obj_ps_shop = new MarketplaceShop($id_shop);
				$name_shop = $obj_ps_shop->link_rewrite;
				$param = array('shop'=>$id_shop);
				
				$new_link4 = $link->getModuleLink('marketplace','addproductprocess',$param);
				$smarty->assign("new_link4",$new_link4);
				$payment_detail    = $link->getModuleLink('marketplace', 'customerPaymentDetail',$param);
				$link_store        = $link->getModuleLink('marketplace', 'shopstore',array('shop'=>$id_shop,'shop_name'=>$name_shop));
				$link_collection   = $link->getModuleLink('marketplace', 'shopcollection',array('shop'=>$id_shop,'shop_name'=>$name_shop));
				$link_profile      = $link->getModuleLink('marketplace', 'shopprofile',$param);
				$add_product       = $link->getModuleLink('marketplace', 'addproduct',$param);
				$account_dashboard = $link->getModuleLink('marketplace', 'marketplaceaccount',$param);
				$seller_profile    = $link->getModuleLink('marketplace', 'sellerprofile',$param);
				$edit_profile    = $link->getModuleLink('marketplace', 'marketplaceaccount',array('shop'=>$id_shop,'l'=>2,'edit-profile'=>1));
				$product_list    = $link->getModuleLink('marketplace', 'marketplaceaccount',array('shop'=>$id_shop,'l'=>3));
				$my_order    = $link->getModuleLink('marketplace', 'marketplaceaccount',array('shop'=>$id_shop,'l'=>4));
				$payment_details    = $link->getModuleLink('marketplace', 'marketplaceaccount',array('shop'=>$id_shop,'id_cus'=>$customer_id,'l'=>5));
				
				$smarty->assign("id_shop", $id_shop);
				$smarty->assign("id_customer", $customer_id);
				$smarty->assign("payment_detail", $payment_detail);
				$smarty->assign("link_store", $link_store);
				$smarty->assign("link_collection", $link_collection);
				$smarty->assign("link_profile", $link_profile);
				$smarty->assign("add_product", $add_product);
				$smarty->assign("account_dashboard", $account_dashboard);
				$smarty->assign("seller_profile", $seller_profile);
				$smarty->assign("edit_profile", $edit_profile);
				$smarty->assign("product_list", $product_list);
				$smarty->assign("my_order", $my_order);
				$smarty->assign("payment_details", $payment_details);
				 
				 $recent_color   = Configuration::get('recent-color');
					if(!$recent_color) {
						$recent_color = '#E65505';
					} else {
						$recent_color   = Configuration::get('recent-color');
					}
				$smarty->assign("recent_color", $recent_color);
				$smarty->assign("logic",'add_product');
				
				//Prepair Category Tree Array
				$root = Category::getRootCategory();
				$obj_seller_product_category = new SellerProductCategory();
				$category =  Db::getInstance()->ExecuteS("SELECT a.`id_category`,l.`name` from `"._DB_PREFIX_."category` a LEFT  JOIN `"._DB_PREFIX_."category_lang` l  ON (a.`id_category`=l.`id_category`) where a.id_parent=".$root->id." and l.id_lang=".$id_lang." and l.`id_shop`=1 order by a.`id_category`");
				
				//Recursive Category Tree Closed		
				$tree = "<ul id='tree1'>";
				$tree .= "<li><input type='checkbox' name='product_category[]' value='".$root->id."'><label>".$root->name."</label>";
				$depth = 1;
				$top_level_on = 1;
				$exclude = array();
				array_push($exclude, 0);
				
				foreach($category as $cat) {
					$goOn = 1;             
					$tree .= "<ul>" ;
					 for($x = 0; $x < count($exclude); $x++ )   
					 {
						  if ( $exclude[$x] == $cat['id_category'] )
						  {
							   $goOn = 0;
							   break;                   
						  }
					 }
					 if ( $goOn == 1 )
					 {
						  $tree .= "<li><input id='check' type='checkbox' name='product_category[]' value='".$cat['id_category']."'><label>".$cat['name']."</label>";                  
						  array_push($exclude, $cat['id_category']);          
							/*if ( $cat['id_category'] < 6 )
							{ $top_level_on = $cat['id_category']; } */
						  $tree .= $obj_seller_product_category->buildChildCategoryRecursive($cat['id_category'],$id_lang);        
					 }
					 $tree .= "</ul>";
				}
				$smarty->assign("categoryTree",$tree);
				//Recursive Category Tree Closed
				$this->setTemplate('addproduct.tpl');
		} else {
			$my_account_link = $link->getPageLink('my-account');
			Tools::redirect($my_account_link);
		}
			
	}
	
	public function setMedia() {

		parent::setMedia();

		$this->addCSS(_MODULE_DIR_.'marketplace/css/add_product.css');
		$this->addCSS(_MODULE_DIR_.'marketplace/css/marketplace_account.css');
		
		$this->addJS(_PS_JS_DIR_.'tiny_mce/tiny_mce.js');

		$this->addJS(_PS_JS_DIR_.'tinymce.inc.js');
	
		//Category tree
		
		$this->addJS(_MODULE_DIR_.'marketplace/views/js/categorytree/jquery-ui-1.8.12.custom/js/jquery-ui-1.8.12.custom.min.js');
		
		$this->addCSS(_MODULE_DIR_.'marketplace/views/js/categorytree/jquery-ui-1.8.12.custom/css/smoothness/jquery-ui-1.8.12.custom.css');
		
		$this->addJS(_MODULE_DIR_.'marketplace/views/js/categorytree/jquery.checkboxtree.js');
		
		$this->addCSS(_MODULE_DIR_.'marketplace/views/js/categorytree/jquery.checkboxtree.css');
		
		
	}



}

?>