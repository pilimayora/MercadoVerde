<?php
//include_once 'marketplace_sellerproduct_image.php';
//include_once('modules/marketplace/ImageManipulator.php');
include_once dirname(__FILE__).'/../../classes/MarketplaceClassInclude.php';
class marketplaceProductupdateModuleFrontController extends ModuleFrontController	{

	public function initContent() {

		global $smarty;	
		global $currentIndex;
		global $exclude;  						//Variable for recursive category tree
		global $depth;  						//Variable for recursive category tree
		parent::initContent();		

		$id = $_GET['id'];		

		$link = new link();
		$edit_pro_link = $link->getModuleLink('marketplace','productupdate',array('edited'=>1));
		$mkt_acc_link = $link->getModuleLink('marketplace','marketplaceaccount');
		$obj_marketplace_product = new SellerProductDetail();
		$pro_info = $obj_marketplace_product->getMarketPlaceProductInfo($id);
		$checked_product_cat = $obj_marketplace_product->getMarketPlaceProductCategories($id);
		$obj_seller_product_category = new SellerProductCategory();
		$defaultcatid = $obj_seller_product_category->getMpDefaultCategory($id);
		if(isset($_GET['deleteproduct']) == 1) {
			$obj_seller_product = new SellerProductDetail();
			$prod_detail = $obj_seller_product->getMarketPlaceProductInfo($id);
			$active = $prod_detail['active'];
			if($active == 1){
				$obj_mpshop_pro = new MarketplaceShopProduct();
				$product_deatil = $obj_mpshop_pro->findMainProductIdByMppId($id);
				$main_product_id = $product_deatil['id_product'];
				$obj_ps_prod = new Product($main_product_id);
				$obj_ps_prod->delete();
				}
			$is_delete = $obj_seller_product->deleteMarketPlaceSellerProduct($id);
			$mkt_acc_link = $link->getModuleLink('marketplace','marketplaceaccount',array('del'=>1));
			if($is_delete)
				Tools::redirect($mkt_acc_link.'&l=3');
			else {
				//error occurs
				Tools::redirect($mkt_acc_link.'&l=3');
			}
		}
		elseif(isset($_GET['editproduct']) == 1) {
			global $cookie;
			$id_lang = $this->context->cookie->id_lang;

			$id = Tools::getValue('id');
			
			$is_main_er = Tools::getValue('is_main_er');
			if($is_main_er) {
				$smarty->assign("is_main_er",$is_main_er);
			} else {
				$smarty->assign("is_main_er",'0');
			}
			$smarty->assign("id",$id);

			$smarty->assign("edit_pro_link", $edit_pro_link);

			$editpro_size =  Configuration::get('editpro-size');

			$editpro_color =  Configuration::get('editpro-color');

			$editpro_font_family =  Configuration::get('editpro-font-family');

			//Prepair Category Tree 
			$root = Category::getRootCategory();
			$category =  Db::getInstance()->ExecuteS("SELECT a.`id_category`,l.`name` from `"._DB_PREFIX_."category` a LEFT  JOIN `"._DB_PREFIX_."category_lang` l  ON (a.`id_category`=l.`id_category`) where a.id_parent=".$root->id." and l.id_lang=".$id_lang." and l.`id_shop`=1 order by a.`id_category`");
				
			$tree = "<ul id='tree1'>";
			$tree .= "<li><input type='checkbox'";
			if($checked_product_cat){     					//For old products which have uploded
				foreach($checked_product_cat as $product_cat){
					if($product_cat['id_category'] == $root->id)
						$tree .= "checked";
				}
			}
			else{
				if($defaultcatid == $root->id)
					$tree .= "checked";
			}
			$tree .= " name='product_category[]' value='".$root->id."'><label>".$root->name."</label>";
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
					$tree .= "<li><input type='checkbox'";
					if($checked_product_cat){       					//For old products which have uploded
						foreach($checked_product_cat as $product_cat){
							if($product_cat['id_category'] == $cat['id_category'])
								$tree .= "checked";
						}
					}
					else{
						if($defaultcatid == $cat['id_category'])
							$tree .= "checked";
					}
					$tree .= " name='product_category[]' value='".$cat['id_category']."'><label>".$cat['name']."</label>";  
					
					array_push($exclude, $cat['id_category']);          
						/*if ( $cat['id_category'] < 6 )
						{ $top_level_on = $cat['id_category']; } */
					$tree .= $obj_seller_product_category->buildChildCategoryRecursive($cat['id_category'],$id_lang,$checked_product_cat);        
				 }
				 $tree .= "</ul>";
			}
			$smarty->assign("categoryTree",$tree);
			//Prepair Category Tree Closed
			
			$this->setTemplate('addproduct.tpl');
			
			

			$smarty->assign("editpro_size",$editpro_size);	
			$smarty->assign("editpro_color",$editpro_color);
			$smarty->assign("editpro_font_family",$editpro_font_family);	
			$smarty->assign("pro_info",$pro_info);				
			$this->setTemplate('edituser.tpl');

		}

		else if(isset($_GET['edited']) == 1) {
			$id = Tools::getValue('id');
			$product_name = Tools::getValue('product_name');
			$short_description = Tools::getValue('short_description');
			$product_description = Tools::getValue('product_description');
			$product_price = Tools::getValue('product_price');
			$product_quantity = Tools::getValue('product_quantity');
			$product_category = Tools::getValue('product_category');
			if($product_name) {
				if($product_name=='') {
				$upd_product_link = $link->getModuleLink('marketplace','productupdate',array('id'=>$id,'editproduct'=>1));
					Tools::redirect($upd_product_link."&is_main_er=1");
				} else {
					$is_generic_name = Validate::isGenericName($product_name);
					if(!$is_generic_name) {
						$upd_product_link = $link->getModuleLink('marketplace','productupdate',array('id'=>$id,'editproduct'=>1));
						Tools::redirect($upd_product_link."&is_main_er=2");
					}
				}
				
				if($short_description) {
					$is_celan_short_desc = Validate::isCleanHtml($short_description);
					if(!$is_celan_short_desc) {
						$upd_product_link = $link->getModuleLink('marketplace','productupdate',array('id'=>$id,'editproduct'=>1));
						Tools::redirect($upd_product_link."&is_main_er=3");
					}
				} 
				
				if($product_description) {
					$is_celan_pro_desc = Validate::isCleanHtml($product_description);
					if(!$is_celan_pro_desc) {
						$upd_product_link = $link->getModuleLink('marketplace','productupdate',array('id'=>$id,'editproduct'=>1));
						Tools::redirect($upd_product_link."&is_main_er=4");
					}
				}
				
				if($product_price!='') {
					$is_product_price = Validate::isPrice($product_price);
					if(!$is_product_price) {
						$upd_product_link = $link->getModuleLink('marketplace','productupdate',array('id'=>$id,'editproduct'=>1));
						Tools::redirect($upd_product_link."&is_main_er=5");
					}
				} else {
					$product_price =0;
				}
				
				if($product_quantity!='') {
					$is_product_quantity = Validate::isUnsignedInt($product_quantity);
					if(!$is_product_quantity) {
						$upd_product_link = $link->getModuleLink('marketplace','productupdate',array('id'=>$id,'editproduct'=>1));
						Tools::redirect($upd_product_link."&is_main_er=6");
					}
				} else {
					$upd_product_link = $link->getModuleLink('marketplace','productupdate',array('id'=>$id,'editproduct'=>1));
						Tools::redirect($upd_product_link."&is_main_er=6");
				}
				
				if($product_category == false){
					$upd_product_link = $link->getModuleLink('marketplace','productupdate',array('id'=>$id,'editproduct'=>1));
					Tools::redirect($upd_product_link."&is_main_er=7");
				}
				Hook::exec('actionBeforeUpdateproduct');
				
				$obj_seller_product = new SellerProductDetail($id);
						
				$obj_seller_product->price = $product_price;
				$obj_seller_product->quantity = $product_quantity;
				$obj_seller_product->product_name = $product_name;
				$obj_seller_product->description = $product_description;
				$obj_seller_product->short_description = $short_description;
				$obj_seller_product->id_category = $product_category[0];
				
				$obj_seller_product->save();					 
				
				//Update new categories
				Db::getInstance()->delete('marketplace_seller_product_category','id_seller_product = '.$id);  //Delete previous
				//Add new category into table
				$obj_seller_product_category = new SellerProductCategory();
				$obj_seller_product_category->id_seller_product = $id;
				$obj_seller_product_category->is_default = 1;
				$i=0;
				foreach($product_category as $p_category){
					$obj_seller_product_category->id_category = $p_category;
					if($i != 0)
						$obj_seller_product_category->is_default = 0;
					$obj_seller_product_category->add();
					$i++;
				}
				//Update Close
				
				$is_active = $obj_seller_product->active;

				
				
				if($is_active == 1) {
					$obj_mpshop_pro = new MarketplaceShopProduct();
					$product_deatil = $obj_mpshop_pro->findMainProductIdByMppId($id);
					$main_product_id = $product_deatil['id_product'];
					
					if(isset($_FILES['product_image']) && $_FILES['product_image']["tmp_name"]!='') {
					
						
						$length = 6;
						$characters = "0123456789abcdefghijklmnopqrstuvwxyz";
						$u_id = ""; 
						for ($p =0;$p<$length;$p++)  {
							$u_id .= $characters[mt_rand(0, strlen($characters))];
						}
						$image_name =$u_id.".jpg";
						$address = "modules/marketplace/img/product_img/";
						
						if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $address.$image_name)) {
							$insert = Db::getInstance()->insert('marketplace_product_image', 
														array(
															'seller_product_id' =>(int)$id,
															'seller_product_image_id' =>pSQL($u_id),
															'active' =>0,
														)
													);	
													
						}
					}
					$image_dir = 'modules/marketplace/img/product_img';
					
					$is_update = $obj_seller_product->updatePsProductByMarketplaceProduct($id, $image_dir,1,$main_product_id);
				}
				else if($is_active == 0) {
						
					if(isset($_FILES['product_image']) && $_FILES['product_image']["tmp_name"]!='') {
					
						
						$length = 6;
						$characters = "0123456789abcdefghijklmnopqrstuvwxyz";
						$u_id = ""; 
						

						for ($p =0;$p<$length;$p++)  {
								$u_id .= $characters[mt_rand(0, strlen($characters))];
						}

						$image_name =$u_id.".jpg";
						$address = "modules/marketplace/img/product_img/";
						
						$result1=Db::getInstance()->insert('marketplace_product_image', array(
																	'seller_product_id' =>(int)$id,
																	'seller_product_image_id' =>pSQL($u_id)
															));
															
						$is_upload = move_uploaded_file($_FILES["product_image"]["tmp_name"],$address.$image_name);
						
					}
				}			
				Hook::exec('actionUpdateproductExtrafield', array('marketplace_product_id' =>Tools::getValue('id')));
				$mkt_acc_link = $link->getModuleLink('marketplace','marketplaceaccount',array('edit'=>1));
				Tools::redirectAdmin($mkt_acc_link.'&id_shop=1&l=3');	
			} else {
				
			}
		}

	}

		
	public function setMedia() {

		parent::setMedia();
		$this->addCSS(_MODULE_DIR_.'marketplace/css/add_product.css');
		$this->addJS(_PS_JS_DIR_.'tiny_mce/tiny_mce.js');
		$this->addJS(_PS_JS_DIR_.'tinymce.inc.js');
		
		//Category tree
		$this->addJS(_MODULE_DIR_.'marketplace/views/js/categorytree/jquery-ui-1.8.12.custom/js/jquery-ui-1.8.12.custom.min.js');
		$this->addCSS(_MODULE_DIR_.'marketplace/views/js/categorytree/jquery-ui-1.8.12.custom/css/smoothness/jquery-ui-1.8.12.custom.css');
		$this->addJS(_MODULE_DIR_.'marketplace/views/js/categorytree/jquery.checkboxtree.js');
		$this->addCSS(_MODULE_DIR_.'marketplace/views/js/categorytree/jquery.checkboxtree.css');

	}

}//class ends	
?>