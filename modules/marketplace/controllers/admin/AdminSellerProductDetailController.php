<?php
	include_once dirname(__FILE__).'/../../classes/MarketplaceClassInclude.php';
	class AdminSellerProductDetailController extends ModuleAdminController {

		public function __construct() {

			$this->table       = 'marketplace_seller_product';

			$this->className   = 'SellerProductDetail';

			$this->lang        = false;
		
		    $this->context     = Context::getContext();
			$i=0;
			$lang_id = $this->context->language->id;
			
			$this->addRowAction('edit');
			$this->addRowAction('delete');
			$this->addRowAction('view');
			
			$this->_join .= 'LEFT JOIN `'._DB_PREFIX_.'marketplace_shop` mps ON (mps.`id` = a.`id_shop`)';

			$this->_join .= 'LEFT JOIN `'._DB_PREFIX_.'marketplace_seller_info` mpsin ON (mpsin.`id` = a.`id_seller`)';

			$this->_select = 'mps.`shop_name`,mpsin.`seller_name`';
			
			$this->fields_list = array();
			$this->fields_list['id'] = array(
				'title' => $this->l('ID'),
				'align' => 'center',
				'width' => 25
			);
			
			$this->fields_list['seller_name'] = array(
				'title' => $this->l('Seller Name'),
				'align' => 'center',
				'width' => 25
			);
			
			$this->fields_list['product_name'] = array(
				'title' => $this->l('Product Name'),
				'align' => 'center',
				'width' => 25
			);
			
			$this->fields_list['shop_name'] = array(
				'title' => $this->l('Shop Name'),
				'align' => 'center',
				'width' => 25
			);
			
			$hook_column = Hook::exec('addColumnInSellerProductTable', array('flase' => 1));
			
			if($hook_column){
				$column = explode('-',$hook_column);
				$num_colums = count($column);
				for($i=0; $i<$num_colums;$i = $i+2) {
					$this->fields_list[$column[$i]] = array(
						'title' => $this->l($column[$i+1]),
						'width' => 30,
						'align' => 'center'
					);
					
				}
			}
				
			$this->fields_list['active'] = array(
				'title' => $this->l('Status'),
				'active' => 'status',
				'align' => 'center',
				'type' => 'bool',
				'width' => 70,
				'orderby' => false
			);	
			
			$this->identifier  = 'id';

			$this->bulk_actions = array('delete' => array('text' => $this->l('Delete selected'), 'confirm' => $this->l('Delete selected items?')));

			parent::__construct();

		}

		// public function renderList() {

			// $this->addRowAction('edit');
			// $this->addRowAction('delete');
			// return parent::renderList();

		// }
	
		public function initToolbar() {
			$obj_mp_cutomer = new MarketplaceCustomer();
			$all_customer_is_seller = $obj_mp_cutomer->findIsallCustomerSeller();
			
			if($all_customer_is_seller)
				parent::initToolbar();
			unset($obj_mp_cutomer);
			unset($all_customer_is_seller);
		}	
		
		public function postProcess(){
			
			if (!($obj = $this->loadObject(true)))
				return;
			
			global $currentIndex;
			$currentindex = $currentIndex;
			$token = $this->token;
			
			$this->addJqueryPlugin(array('fancybox','tablednd'));
			$this->addCSS(_MODULE_DIR_.'marketplace/css/add_product.css');			
			$this->addJS(_PS_JS_DIR_ . 'tiny_mce/tiny_mce.js');
			$this->addJS(_PS_JS_DIR_ . 'tinymce.inc.js');
			//For Category tree
			$this->addJS(_MODULE_DIR_.'marketplace/views/js/categorytree/jquery-ui-1.8.12.custom/js/jquery-ui-1.8.12.custom.min.js');
			$this->addCSS(_MODULE_DIR_.'marketplace/views/js/categorytree/jquery-ui-1.8.12.custom/css/smoothness/jquery-ui-1.8.12.custom.css');
			$this->addJS(_MODULE_DIR_.'marketplace/views/js/categorytree/jquery.checkboxtree.js');
			$this->addCSS(_MODULE_DIR_.'marketplace/views/js/categorytree/jquery.checkboxtree.css');
			
			if (Tools::isSubmit('statusmarketplace_seller_product')) {
				$this->active_seller_product();
			} 
			
			if($this->display == 'view') {
				
				global $smarty;
				global $currentIndex;
				$this->context       = Context::getContext();
				$id_lang             = $this->context->employee->id_lang;
				$id                  = Tools::getValue('id');
				$currentindex        = $currentIndex;
				$smarty->assign('set','0');
				$id = Tools::getValue('id');
				
				$obj_marketplace_product = new SellerProductDetail();
				$pro_info = $obj_marketplace_product->getMarketPlaceProductInfo($id);
				
				$smarty->assign('pro_info',$pro_info);
				///Is product activate one time
				$is_product_onetime_activate = $obj_marketplace_product->getMarketPlaceShopProductDetailBYmspid($id);
				if($is_product_onetime_activate) {
					$smarty->assign('is_product_onetime_activate',1);
					$link = new Link();
					$id_product = $is_product_onetime_activate['id_product'];
					
					$product = new Product($id_product);
					$id_image_detail = $product->getImages($id_lang);
					
					$product_link_rewrite = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `". _DB_PREFIX_."product_lang` where id_product=".$id_product." and id_lang=".$id_lang);
					$name = $product_link_rewrite['link_rewrite'];
					if(!empty($id_image_detail)) {
						foreach($id_image_detail as $id_image_info) {
							$id_image[] = $id_image_info['id_image'];
							$ids = $id_product.'-'.$id_image_info['id_image'];
							$image_link[] = $link->getImageLink($name,$ids);
							$is_cover[] = $id_image_info['cover'];
							$position[] = $id_image_info['position'];
						}
						$smarty->assign('is_image_found',1);
						$smarty->assign('id_image',$id_image);
						$smarty->assign('image_link',$image_link);
						$smarty->assign('is_cover',$is_cover);
						$smarty->assign('position',$position);
						$smarty->assign('id_product',$id_product);
						
					} else {
						$smarty->assign('is_image_found',0);
					}
					
				} else {
					$smarty->assign('is_product_onetime_activate',0);
				}
				
				$unactive_image = $obj_marketplace_product->unactiveImage($pro_info['id']);
				if($unactive_image) {
					$smarty->assign('is_unactive_image',1);
					$smarty->assign('unactive_image',$unactive_image);
					
				}else {
					$smarty->assign('is_unactive_image',0);
				}
			}
			parent::postProcess();	
		}
		
		public function renderForm() {
			global $exclude; 
			global $depth;
			
			$add_size =  Configuration::get('add-size');
			$add_color =  Configuration::get('add-color');
			$add_border_color =  Configuration::get('add-border-color');
			$add_font_family =  Configuration::get('add-font-family');
			
			$this->context->smarty->assign("add_size",$add_size);
			$this->context->smarty->assign("add_color",$add_color);
			$this->context->smarty->assign("add_border_color",$add_border_color);
			$this->context->smarty->assign("add_font_family",$add_font_family);
			
			$id_lang = $this->context->cookie->id_lang;
			$id = Tools::getValue('id');
			$obj_marketplace_product = new SellerProductDetail();
			$obj_marketplace_product_category = new SellerProductCategory();
			$root = Category::getRootCategory();
			if($this->display == 'add')	{
				//Prepair Category Tree 
				$root = Category::getRootCategory();
				$category =  Db::getInstance()->ExecuteS("SELECT a.`id_category`,l.`name` from `"._DB_PREFIX_."category` a LEFT  JOIN `"._DB_PREFIX_."category_lang` l  ON (a.`id_category`=l.`id_category`) where a.id_parent=".$root->id." and l.id_lang=".$id_lang." and l.`id_shop`=1 order by a.`id_category`");
					
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
						$tree .= "<li><input type='checkbox' name='product_category[]' value='".$cat['id_category']."'><label>".$cat['name']."</label>";  
						
						array_push($exclude, $cat['id_category']);          
							if ( $cat['id_category'] < 6 )
							{ $top_level_on = $cat['id_category']; }
						$tree .= $obj_marketplace_product_category->buildChildCategoryRecursive($cat['id_category'],$id_lang);       
					 }
					 $tree .= "</ul>";
				}
				$this->context->smarty->assign("categoryTree",$tree);
				
				//Category tree close
				
				$customer_info =Db::getInstance()->executeS("SELECT cus.`id_customer`,cus.`email` FROM `"._DB_PREFIX_."customer` cus INNER JOIN `"._DB_PREFIX_."marketplace_customer` mcus ON ( cus.id_customer = mcus.id_customer )");
				$this->context->smarty->assign('set','1');
				if(empty($customer_info)) {
					$this->context->smarty->assign('customer_info',-1);
				} else {
					$this->context->smarty->assign('customer_info',$customer_info);
				}
				
				$this->fields_form = array(
					'submit' => array(
					'title' => $this->l('Save'),
					'class' => 'button'
					)
				);
				
			} 
			else if($this->display == 'edit') {
				
				$this->context->smarty->assign('set','0');
				$id = Tools::getValue('id');
				$pro_info = $obj_marketplace_product->getMarketPlaceProductInfo($id);
				$checked_product_cat = $obj_marketplace_product->getMarketPlaceProductCategories($id);
				$defaultcatid = $obj_marketplace_product_category->getMpDefaultCategory($id);
				$this->context->smarty->assign('pro_info',$pro_info);
				
				//Prepair Category Tree 
				
				$category =  Db::getInstance()->ExecuteS("SELECT a.`id_category`,l.`name` from `"._DB_PREFIX_."category` a LEFT  JOIN `"._DB_PREFIX_."category_lang` l  ON (a.`id_category`=l.`id_category`) where a.id_parent=".$root->id." and l.id_lang=".$id_lang." and l.`id_shop`=1 order by a.`id_category`");
					
				$tree = "<ul id='tree1'>";
				$tree .= "<li><input type='checkbox'";
				if($checked_product_cat){       					//For old products which have uploded
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
						if($checked_product_cat){        					//For old products which have uploded
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
							if ( $cat['id_category'] < 6 )
							{ $top_level_on = $cat['id_category']; }
						$tree .= $obj_marketplace_product_category->buildChildCategoryRecursive($cat['id_category'],$id_lang,$checked_product_cat);        
					 }
					 $tree .= "</ul>";
				}
				$this->context->smarty->assign("categoryTree",$tree);
				
				//Category tree close
				
				//Is product activate one time
				$is_product_onetime_activate = $obj_marketplace_product->getMarketPlaceShopProductDetailBYmspid($id);
				if($is_product_onetime_activate) {
					$this->context->smarty->assign('is_product_onetime_activate',1);
					$link = new Link();
					$id_product = $is_product_onetime_activate['id_product'];
					$product = new Product($id_product);
					$id_image_detail = $product->getImages($id_lang);
					
					$product_link_rewrite = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `". _DB_PREFIX_."product_lang` where id_product=".$id_product." and id_lang=".$id_lang);
					$name = $product_link_rewrite['link_rewrite'];
					if(!empty($id_image_detail)) {
						foreach($id_image_detail as $id_image_info) {
							$id_image[] = $id_image_info['id_image'];
							$ids = $id_product.'-'.$id_image_info['id_image'];
							$image_link[] = $link->getImageLink($name,$ids);
							$is_cover[] = $id_image_info['cover'];
							$position[] = $id_image_info['position'];
						}
						$this->context->smarty->assign('is_image_found',1);
						$this->context->smarty->assign('id_image',$id_image);
						$this->context->smarty->assign('image_link',$image_link);
						$this->context->smarty->assign('is_cover',$is_cover);
						$this->context->smarty->assign('position',$position);
						$this->context->smarty->assign('id_product',$id_product);
						
					} else {
						$this->context->smarty->assign('is_image_found',0);
					}
					
				} else {
					$this->context->smarty->assign('is_product_onetime_activate',0);
				}
				
				$unactive_image = $obj_marketplace_product->unactiveImage($pro_info['id']);
				if($unactive_image) {
					$this->context->smarty->assign('is_unactive_image',1);
					$this->context->smarty->assign('unactive_image',$unactive_image);
					
				} else {
					$this->context->smarty->assign('is_unactive_image',0);
				}
				
				$this->fields_form = array(
					'legend' => array(
						'title' =>	$this->l('Edit Shop'),
						),
					
					'submit' => array(
						'title' => $this->l('Save'),
						'class' => 'button'
					)
				);
				
				
			} else if($this->display == 'view') {
				
				global $smarty;
				global $currentIndex;
				$this->context       = Context::getContext();
				$id_lang             = $this->context->employee->id_lang;
				$id                  = Tools::getValue('id');
				$currentindex        = $currentIndex;
				$smarty->assign('set','0');
				$id = Tools::getValue('id');
				
				$obj_marketplace_product = new SellerProductDetail();
				$pro_info = $obj_marketplace_product->getMarketPlaceProductInfo($id);
				
				$smarty->assign('pro_info',$pro_info);
				///Is product activate one time
				$is_product_onetime_activate = $obj_marketplace_product->getMarketPlaceShopProductDetailBYmspid($id);
				if($is_product_onetime_activate) {
					$smarty->assign('is_product_onetime_activate',1);
					$link = new Link();
					$id_product = $is_product_onetime_activate['id_product'];
					$product = new Product($id_product);
					$id_image_detail = $product->getImages($id_lang);
					
					$product_link_rewrite = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `". _DB_PREFIX_."product_lang` where id_product=".$id_product." and id_lang=".$id_lang);
					$name = $product_link_rewrite['link_rewrite'];
					if(!empty($id_image_detail)) {
						foreach($id_image_detail as $id_image_info) {
							$id_image[] = $id_image_info['id_image'];
							$ids = $id_product.'-'.$id_image_info['id_image'];
							$image_link[] = $link->getImageLink($name,$ids);
							$is_cover[] = $id_image_info['cover'];
							$position[] = $id_image_info['position'];
						}
						$smarty->assign('is_image_found',1);
						$smarty->assign('id_image',$id_image);
						$smarty->assign('image_link',$image_link);
						$smarty->assign('is_cover',$is_cover);
						$smarty->assign('position',$position);
						$smarty->assign('id_product',$id_product);
						
					} else {
						$smarty->assign('is_image_found',0);
					}
					
				} else {
					$smarty->assign('is_product_onetime_activate',0);
				}
				
				$unactive_image = $obj_marketplace_product->unactiveImage($pro_info['id']);
				if($unactive_image) {
					$smarty->assign('is_unactive_image',1);
					$smarty->assign('unactive_image',$unactive_image);
					
				} else {
					$smarty->assign('is_unactive_image',0);
				}
			}
			return parent::renderForm();
		}
	
		
		public function processSave() {
			//set==1 for add new
			//set == 0 for edit existing product
			//when produc has been added then by deafult its not active
			global $currentIndex;
			$currentindex = $currentIndex;
			
			$is_proceess = Tools::getValue('set');
			
			$product_name = Tools::getValue('product_name');
			$product_price = Tools::getValue('product_price');
			$product_quantity = Tools::getValue('product_quantity');
			$product_description = Tools::getValue('product_description');
			$product_category = Tools::getValue('product_category');
			$short_description = Tools::getValue('short_description');
			
			if($product_name=='') {
				$this->errors[] = Tools::displayError('Product name is requried field.');
			} else {
				$is_valid_name = Validate::isGenericName($product_name);
				if(!$is_valid_name) {
					$this->errors[] = Tools::displayError($this->l('Product name must not have Invalid characters <>;=#{}'));
				}
			}
			if($product_price=='') {
				$this->errors[] = Tools::displayError('Product price is requried field.');
			} else {
				if(!is_numeric($product_price)) {
					$this->errors[] = Tools::displayError('Product price is should be numeric.');
				} else if($product_price<=0) {
					$this->errors[] = Tools::displayError('Product price is should be greater than 0.');
				}
					
			}
			if($product_quantity=='') {
				$this->errors[] = Tools::displayError('Product quantity  requried field.');
			} else {
				$product_quantity = (int)$product_quantity;
				if(!is_int($product_quantity)) {
					$this->errors[] = Tools::displayError('Product quantity  should be integer.'.$product_quantity);
				} else if($product_quantity<=0) {
					$this->errors[] = Tools::displayError('Product quantity  should be greater than 0.');
				}
			}
			
			if($product_category == false){
				$this->errors[] = Tools::displayError('Please select atleast one category.');
			}
			
			if($is_proceess==1) {
				if (empty($this->errors)) {
					$customer_id = Tools::getValue('shop_customer');
					$obj_seller_product = new SellerProductDetail();
					$obj_mp_shop = new MarketplaceShop();
					$marketplace_shop = $obj_mp_shop->getMarketPlaceShopInfoByCustomerId($customer_id);
					
					$id_shop  = $marketplace_shop['id'];
					$id_seller = MarketplaceShop::findMpSellerIdByShopId($id_shop);
					
					$obj_seller_product->id_seller = $id_seller;
					$obj_seller_product->price = $product_price;
					$obj_seller_product->quantity = $product_quantity;
					$obj_seller_product->product_name = $product_name;
					$obj_seller_product->description = $product_description;
					$obj_seller_product->short_description = $short_description;
					$obj_seller_product->id_category = $product_category[0];
					$obj_seller_product->ps_id_shop = $this->context->shop->id;
					$obj_seller_product->id_shop = $id_shop;
					$obj_seller_product->save();					 
					
					$seller_product_id    = $obj_seller_product->id;
					
					//Add into category table
					$obj_seller_product_category = new SellerProductCategory();
					$obj_seller_product_category->id_seller_product = $seller_product_id;
					$obj_seller_product_category->is_default = 1;
					$i=0;
					foreach($product_category as $p_category){
						$obj_seller_product_category->id_category = $p_category;
						if($i != 0)
							$obj_seller_product_category->is_default = 0;
						$obj_seller_product_category->add();
						$i++;
					}
					//Close
					
					$address    = "../modules/marketplace/img/product_img/";
					
					if(isset($_FILES['product_image'])) {
						$length = 6;
						$characters= "0123456789abcdefghijklmnopqrstuvwxyz";
						$u_id= "";
						
						for ($p=0;$p<$length;$p++) {
							$u_id= $u_id.$characters[mt_rand(0, strlen($characters))];
						}
						if($_FILES['product_image']['size']>0) {
							$result1   = Db::getInstance()->insert(
												'marketplace_product_image', array(
												'seller_product_id' => (int) $seller_product_id,
												'seller_product_image_id' => pSQL($u_id)
										));
							$image_name = $u_id . ".jpg";
							
							move_uploaded_file($_FILES["product_image"]["tmp_name"],$address.$image_name);
						}
						
					}
					if(isset($_FILES['images'])) {
						$other_images  = $_FILES["images"]['tmp_name'];
						$count = count($other_images);
						
					} else {
						$count = 0;
					}		
					
					for ($i = 0; $i < $count; $i++) {
						$length     = 6;
						$characters = "0123456789abcdefghijklmnopqrstuvwxyz";
						$u_other_id = "";
						for ($p = 0; $p < $length; $p++) {
							$u_other_id .= $characters[mt_rand(0, strlen($characters))];
						}
						
						$result2    = Db::getInstance()->insert('marketplace_product_image', array(
							'seller_product_id' => (int) $seller_product_id,
							'seller_product_image_id' => pSQL($u_other_id)
						));
						$image_name = $u_other_id . ".jpg";
						$address    = "../modules/marketplace/img/product_img/";
						move_uploaded_file($other_images[$i], $address . $image_name);
					}
					Hook::exec('actionAddproductExtrafield', array('marketplace_product_id' => $seller_product_id));
					Tools::redirectAdmin($currentIndex.'&conf=4&token='.$this->token);
				} else {
					$this->display = 'add';
				}
			}
			else {
				if (empty($this->errors)) {
					$id = Tools::getValue('market_place_product_id');
					$obj_seller_product = new SellerProductDetail($id);
					
					$obj_seller_product->price = $product_price;
					$obj_seller_product->quantity = $product_quantity;
					$obj_seller_product->product_name = $product_name;
					$obj_seller_product->description = $product_description;
					$obj_seller_product->short_description = $short_description;
					$obj_seller_product->id_category = $product_category[0];
					//save category
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
					
					if($is_active == 1){
						$obj_mpshop_pro = new MarketplaceShopProduct();
						$product_deatil = $obj_mpshop_pro->findMainProductIdByMppId($id);
						$main_product_id = $product_deatil['id_product'];
						if(isset($_FILES['product_image']) && $_FILES['product_image']["tmp_name"]!='') {
							$seller_product_image=$_FILES['product_image'];
							$length = 6;
							$characters = "0123456789abcdefghijklmnopqrstuvwxyz";
							$u_id = ""; 
							for ($p =0;$p<$length;$p++)  {
								$u_id .= $characters[mt_rand(0, strlen($characters))];
							}
							$image_name =$u_id.".jpg";
							$address = "../modules/marketplace/img/product_img/";
							
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
						$image_dir = '../modules/marketplace/img/product_img';
						
						$is_update = $obj_seller_product->updatePsProductByMarketplaceProduct($id, $image_dir,1,$main_product_id);
					}
					else if($is_active == 0) {
							
						if(isset($_FILES['product_image']) && $_FILES['product_image']["tmp_name"]!='') {
						
							$seller_product_image=$_FILES['product_image'];
							$length = 6;
							$characters = "0123456789abcdefghijklmnopqrstuvwxyz";
							$u_id = ""; 
							

							for ($p =0;$p<$length;$p++)  {
									$u_id .= $characters[mt_rand(0, strlen($characters))];
							}

							$image_name =$u_id.".jpg";
							$address = "../modules/marketplace/img/product_img/";
							
							$result1=Db::getInstance()->insert('marketplace_product_image', array(
																		'seller_product_id' =>(int)$id,
																		'seller_product_image_id' =>pSQL($u_id)
																));
																
							move_uploaded_file($_FILES["product_image"]["tmp_name"],$address.$image_name);
						}
					}
					Hook::exec('actionUpdateproductExtrafield', array('marketplace_product_id' =>Tools::getValue('market_place_product_id')));
					Tools::redirectAdmin($currentIndex.'&conf=4&token='.$this->token);
				} else {
					$this->display = 'edit';
				}
			}
		}
		
		public function active_seller_product() {
			global $currentIndex;
			$currentindex = $currentIndex;
			$mp_product_id = Tools::getValue('id');
			
			$obj_sellerproduct_detail = new SellerProductDetail($mp_product_id);
			$mp_id_shop = $obj_sellerproduct_detail->id_shop;
			if($obj_sellerproduct_detail->active==0) {
				$obj_sellerproduct_detail->active=1;
					$obj_sellerproduct_detail->save();
				$obj_mpshop_produt = new MarketplaceShopProduct();
				$main_product_info = $obj_mpshop_produt->findMainProductIdByMppId($mp_product_id);
				$image_dir = '../modules/marketplace/img/product_img';
				if($main_product_info) {
					//product created but dactivated right now need to active 
					$main_product_id = $main_product_info['id_product'];
					$is_update = $obj_sellerproduct_detail->updatePsProductByMarketplaceProduct($mp_product_id, $image_dir,1,$main_product_id);
				} else {
					//not yet product created
					
					$main_product_id = $obj_sellerproduct_detail->createPsProductByMarketplaceProduct($mp_product_id, $image_dir,1);
					
					if($main_product_id){
						$mps_product_obj = new MarketplaceShopProduct();
						$mps_product_obj->id_shop = $mp_id_shop;
						$mps_product_obj->marketplace_seller_id_product = $mp_product_id;
						$mps_product_obj->id_product = $main_product_id;
						$mps_product_obj->add();
					}
					Hook::exec('actionToogleProductStatus', array('main_product_id' => $main_product_id,'active'=>1));
					$obj_sellerproduct_detail->callMailFunction($mp_product_id,'Activation detail',1,$this->context->employee->email);
				}
			} else {
				//product created but deactive now
				$obj_sellerproduct_detail->active = 0;
				$is_save = $obj_sellerproduct_detail->save();
				
				$obj_mpshop_produt = new MarketplaceShopProduct();
				$main_product_info = $obj_mpshop_produt->findMainProductIdByMppId($mp_product_id);
				if($main_product_info) {
					$main_product_id = $main_product_info['id_product'];
					$product = new Product($main_product_id);
					$product->active = 0;
					$product->save();
				}
				$obj_sellerproduct_detail->callMailFunction($mp_product_id,'Deactivate Product',2,$this->context->employee->email);
			}
		
			Tools::redirectAdmin($currentIndex.'&conf=4&token='.$this->token);
		}

		public function processDelete($id=true) {
			global $currentIndex;
			if($id==true) {
				$marketplace_seller_product_id = (int)Tools::getValue('id');
			} else {
				$marketplace_seller_product_id = $id;
			}
			$marketplace_shop_product = 	Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("SELECT * from`"._DB_PREFIX_."marketplace_shop_product` where `marketplace_seller_id_product`=".$marketplace_seller_product_id);
			$marketplace_seller_product_detail = 	Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("SELECT * from`"._DB_PREFIX_."marketplace_seller_product` where `id`=".$marketplace_seller_product_id);		
			$marketplace_shop_id = $marketplace_seller_product_detail['id_shop'];
			$delete_row_from_marketplace_seller_product = Db::getInstance()->delete('marketplace_seller_product','id='.$marketplace_seller_product_id);
			$delete_row_from_marketplace_shop_product = Db::getInstance()->delete('marketplace_shop_product','marketplace_seller_id_product='.$marketplace_seller_product_id);
			
					

			$main_id_product = $marketplace_shop_product['id_product'];

			$obj_product = new Product($main_id_product);
			$obj_product->delete();

		if($delete_row_from_marketplace_seller_product)
			$redirect = self::$currentIndex.'&conf=1&token='.$this->token;
			
		$this->redirect_after = $redirect;
		
		/*$marketplace_shop_product = 	Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("SELECT * from`"._DB_PREFIX_."marketplace_shop_product` where `marketplace_seller_id_product`=".$marketplace_seller_product_id);		

			$main_id_product = $marketplace_shop_product['id_product'];

			$delete_row_from_marketplace_shop_product = Db::getInstance()->delete('marketplace_shop_product','marketplace_seller_id_product='.$marketplace_seller_product_id);

			

			$marketplace_product_image =  Db::getInstance()->executeS("SELECT * from`"._DB_PREFIX_."marketplace_product_image` where seller_product_id=".$marketplace_seller_product_id);

			if($marketplace_product_image) {

				foreach($marketplace_product_image as $pro_image) {

					unlink('../modules/marketplace/img/product_img/'.$pro_image['seller_product_image_id'].'.jpg');

				}

			}

			$delete_row_from_marketplace_product_image = Db::getInstance()->delete('marketplace_product_image','seller_product_id='.$marketplace_seller_product_id);

			

			$delete_row_from_product = Db::getInstance()->delete('product','id_product='.$total_product_detail1['id_product']);

			

			$delete_row_from_product_attachment = Db::getInstance()->delete('product_attachment','id_product='.$main_id_product);

			$delete_row_from_product_attribute = Db::getInstance()->delete('product_attribute','id_product='.$main_id_product);

			$delete_row_from_product_carrier = Db::getInstance()->delete('product_carrier','id_product='.$main_id_product);

			$delete_row_from_product_country_tax = Db::getInstance()->delete('product_country_tax','id_product='.$main_id_product);

			$delete_row_from_product_download = Db::getInstance()->delete('product_download','id_product='.$main_id_product);

			$product_group_reduction_cache = Db::getInstance()->delete('product_group_reduction_cache','id_product='.$main_id_product);

			$delete_row_from_product_lang = Db::getInstance()->delete('product_lang','id_product='.$main_id_product);

			$delete_row_from_product_sale = Db::getInstance()->delete('product_sale','id_product='.$main_id_product);

			$delete_row_from_product_shop = Db::getInstance()->delete('product_shop','id_product='.$main_id_product);

			$delete_row_from_product_supplier = Db::getInstance()->delete('product_supplier','id_product='.$main_id_product);

			$delete_row_from_product_tag = Db::getInstance()->delete('product_tag','id_product='.$main_id_product);

			$delete_row_from_category_product = Db::getInstance()->delete('category_product','id_product='.$main_id_product);

			$delete_row_from_stock_available = Db::getInstance()->delete('stock_available','id_product='.$main_id_product);

			$delete_row_from_image_lang = "DELETE FROM t2 USING `"._DB_PREFIX_."image`  t1 INNER JOIN `"._DB_PREFIX_."image_lang` t2 WHERE t1.`id_product`=".$main_id_product." AND t1.`id_image`=t2.`id_image`";

			$delete = Db::getInstance()->Execute($delete_row_from_image_lang);	

		

			$delete_row_from_category_product = Db::getInstance()->delete('image','id_product='.$main_id_product);

		*/
	}

}

?>