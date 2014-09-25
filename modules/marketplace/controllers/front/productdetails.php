<?php
include_once 'modules/marketplace/classes/MarketplaceClassInclude.php';
//include_once('modules/marketplace/ImageManipulator.php');
class marketplaceproductdetailsModuleFrontController extends ModuleFrontController
{
	public function initContent()
    {
		global $smarty;
        parent::initContent();
		$link     = new link();
		$smarty->assign("is_seller", 1);
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)  { 
			$smarty->assign("browser", "ie");
		} else {
			$smarty->assign("browser", "notie");
		}
		$param = array('flag'=>'1');
		$product_details_link = $link->getModuleLink('marketplace', 'productdetails',$param);
		$smarty->assign("product_details_link", $product_details_link);
		
		$customer_id     = $this->context->cookie->id_customer;
		$obj_mp_shop = new MarketplaceShop();
		$obj_mp_sellerproduct = new SellerProductDetail();
		$obj_mp_shopproduct = new MarketplaceShopProduct();
		if($customer_id) {
			$market_place_shop = $obj_mp_shop->getMarketPlaceShopInfoByCustomerId($customer_id);
			
			$id_shop   = $market_place_shop['id'];
			$smarty->assign("id_shop", $id_shop);
			
			$param = array('shop'=>$id_shop);
			$account_dashboard = $link->getModuleLink('marketplace', 'marketplaceaccount',$param);
			$smarty->assign("account_dashboard", $account_dashboard);
			
			$seller_profile    = $link->getModuleLink('marketplace', 'sellerprofile',$param);
			$smarty->assign("seller_profile", $seller_profile);

			$link_store        = $link->getModuleLink('marketplace', 'shopstore',$param);
			$smarty->assign("link_store", $link_store);

			$link_collection   = $link->getModuleLink('marketplace', 'shopcollection',$param);
			$smarty->assign("link_collection", $link_collection);

			$add_product       = $link->getModuleLink('marketplace', 'addproduct',$param);		
			$smarty->assign("add_product", $add_product);
				
			$id = Tools::getValue('id');
			
			$product_info = $obj_mp_sellerproduct->getMarketPlaceProductInfo($id);
			
			if($product_info) {
				$id_product_info = $obj_mp_shopproduct->findMainProductIdByMppId($id);
				
				$i = 0;
				$img_info = array();
				if($id_product_info)
				{
					$link = new Link();
					$id_product = $id_product_info['id_product'];
					
					$product = new Product($id_product);
					$id_lang = $this->context->language->id;
					$id_image_detail = $product->getImages($id_lang);
					$product_link_rewrite = Db::getInstance()->getRow("select * from `". _DB_PREFIX_."product_lang` where `id_product`=".$id_product." and `id_lang`=1");
					$name = $product_link_rewrite['link_rewrite'];
					
					
					
					if(!empty($id_image_detail))
					{
					  foreach($id_image_detail as $id_image_info)
					  {
						$img_info[$i]['id_image'] = $id_image_info['id_image'];
						$ids = $id_product.'-'.$id_image_info['id_image'];
						$img_info[$i]['image_link'] = $link->getImageLink($name,$ids);
						$img_info[$i]['cover'] = $id_image_info['cover'];
						$img_info[$i]['position'] = $id_image_info['position'];
						
						$i++;
						
					  }
					}
					
					$img = Product::getCover($id_product);
					$ids = $id_product.'-'.$img['id_image'];
					$image_id = $link->getImageLink($name,$ids);
					$count = count($img_info);
					$smarty->assign("img_info", $img_info);
					$smarty->assign("count", $count);
					$smarty->assign("id", $id);
					$smarty->assign("id_product", $id_product);
										
					$smarty->assign("image_id", $image_id);
					$smarty->assign("root_dir", _PS_ROOT_DIR_);
					$smarty->assign("is_approve",1);
					
				} else {
					//product not approved yet
					$smarty->assign("is_approve",0);
					$obj_mp_pro_image = new MarketplaceProductImage();
					$mp_pro_image = $obj_mp_pro_image->findProductImageByMpProId(Tools::getValue('id'));
					if($mp_pro_image) {
						$smarty->assign("mp_pro_image",$mp_pro_image);
						$cover_img = $mp_pro_image['0']['seller_product_image_id'];
						$smarty->assign("cover_img",$cover_img);
					} else {
						$smarty->assign("mp_pro_image",'0');
					}
				}
				
				$smarty->assign("name", $product_info['product_name']);
				$smarty->assign("description", $product_info['description']);
				$smarty->assign("price", $product_info['price']);
				$smarty->assign("quantity", $product_info['quantity']);
				$smarty->assign("status", $product_info['active']);
				$smarty->assign("logic",'999');
				$this->setTemplate('product_details.tpl');
			}
		
		} else {
			 $redirect_link = $link->getPageLink('authentication');
              Tools::redirect($redirect_link);
		}
		
		if(isset($_POST['add_image']))
		{
			if(isset($_FILES['product_image']) && $_FILES['product_image']["tmp_name"]!='') {
						
			  $seller_product_image=$_FILES['product_image'];
						$length = 6;
						$characters = "0123456789abcdefghijklmnopqrstuvwxyz";
						$u_id = ""; 

						

						for ($p =0;$p<$length;$p++)  {
							$u_id .= $characters[mt_rand(0, strlen($characters))];
						}

						$image_name =$u_id.".jpg";

						$address = "modules/marketplace/img/product_img/";

						if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $address.$image_name)) {
							$insert = Db::getInstance()->insert('marketplace_product_image', array(

															'seller_product_id' =>(int)$id,

															'seller_product_image_id' =>pSQL($u_id),

															'active' =>1,

															)

														);	
							$marketplace_image_id = Db::getInstance()->Insert_ID();
						////

							$dir = opendir("modules/marketplace/img/product_img/");
							while(($file = readdir($dir)) !== false) {
								if($file == $image_name) {
											
									$res =  Db::getInstance()->executeS("SELECT MAX(`position`) as `position` from `"._DB_PREFIX_."image` where id_product=".$id_product_info['id_product']);
									
									if(!empty($res)) {
										$count = $res[0]['position'];
									} else {
										$count = 0;
									}
									
									$position = $count+1;
									
									if($count == 0) {
										$insert_into_image = Db::getInstance()->insert('image', array(

																		'id_product' =>(int)$id_product_info['id_product'],

																		'position' =>(int)$position,

																		'cover' =>1,

																	)

																);
										$id_image1 = Db::getInstance()->Insert_ID();

																

										$insert_into_image_shop = Db::getInstance()->insert('image_shop', array(

												'id_image' =>(int)$id_image1,

												'id_shop' =>1,

												'cover' =>1,

											)

										);

									} else {
										$insert_into_image = Db::getInstance()->insert('image', array(

																'id_product' =>(int)$id_product_info['id_product'],

																'position' =>(int)$position,

																'cover' =>0,
															)
														);
										$id_image1 = Db::getInstance()->Insert_ID();
										$insert_into_image_shop = Db::getInstance()->insert('image_shop', array(

																		'id_image' =>(int)$id_image1,

																		'id_shop' =>1,

																		'cover' =>0,

																		)

																	);
										
									}
									
									$lang_available =Db::getInstance()->executeS("SELECT `id_lang` from`"._DB_PREFIX_."lang` order by `id_lang`");
									
									foreach($lang_available as $lang) {

												$insert_into_image_lang = Db::getInstance()->insert('image_lang', array(

														'id_image' =>(int)$id_image1,

														'id_lang' =>(int)$lang['id_lang'],

														'legend' =>pSQL($product_info['product_name']),

													)

												);

									}
									
																	
									$main_address = "img/p/";
									$id_image = $id_image1;
									$id_img_array = str_split($id_image);
									
									foreach($id_img_array as $id_img_array1) {

										$main_address.="/".$id_img_array1;

										if (!is_dir($main_address)) {

											mkdir($main_address,0775);

										}

									}
									
									
									$image_name11="/".$id_image."-";
									
									$image_type1 =  Db::getInstance()->executeS("SELECT * from`"._DB_PREFIX_."image_type` where products=1");
									
									$filename =	$address.$image_name;
									
									foreach($image_type1 as $image_type) {
										
										if ($filename > 0) {
											
										} else {
											
											// array of valid extensions

											$validExtensions = array('.jpg', '.jpeg', '.gif', '.png');

											// get extension of the uploaded file

											$fileExtension = strrchr($filename, ".");
											
											if (in_array($fileExtension, $validExtensions)) {
												
												$newNamePrefix = time() . '_';

												$manipulator = new ImageManipulator($filename);
												$newImage = $manipulator->resample($image_type['height'],$image_type['width'],false);

												$manipulator->save($main_address.$image_name11.$image_type['name'].'.jpg');

											} 

										}

									}
									
									$filename =	$address.$image_name;
									
									if ($filename > 0) {

									} else {

										// array of valid extensions

										$validExtensions = array('.jpg', '.jpeg', '.gif', '.png');

										// get extension of the uploaded file

										$fileExtension = strrchr($filename, ".");

										if (in_array($fileExtension, $validExtensions)) {

											$newNamePrefix = time() . '_';

											$manipulator = new ImageManipulator($filename);   

											$width =  $manipulator->getWidth();

											$height = $manipulator->getHeight();
											$newImage = $manipulator->resample($height,$width,false);
											$manipulator->save($main_address."/".$id_image.'.jpg');

										} 

											
									}
								}
							}
							closedir($dir);
						}
					}
			unset($_POST['add_image']);
			 Tools::redirect($product_details_link."&id=".Tools::getValue('id'));
		}
		
		

	}
	
	    public function setMedia()
    {
        parent::setMedia();
		$this->addJS(_MODULE_DIR_.'marketplace/tinymce/jscripts/tiny_mce/tiny_mce.js');
        $this->addCSS(_MODULE_DIR_.'marketplace/css/marketplace_account.css');
        $this->addJS(_PS_JS_DIR_.'tiny_mce/tiny_mce.js');
        $this->addJS(_PS_JS_DIR_.'tinymce.inc.js');
		$this->addJqueryUI(array('ui.datepicker'));
		$this->addJqueryPlugin(array('fancybox','tablednd'));
    }
}
?>