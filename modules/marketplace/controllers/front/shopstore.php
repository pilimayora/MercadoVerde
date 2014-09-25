<?php
	if (!defined('_PS_VERSION_'))
		exit;
		
	class marketplaceShopstoreModuleFrontController extends ModuleFrontController	
	{
		public $ssl = true;
		
		public function initContent()
		{
			global $cookie;
			global $smarty;
            $id_lang = $this->context->cookie->id_lang;
			parent::initContent();

			$id_product = Tools::getValue('id');
			$link = new link();
			$id_shop = Tools::getValue('shop');
			if(!$id_shop) {
				$id_shop = Tools::getValue('id_shop');
			}
			if($id_shop!='') {
				$marketplace_shop = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select `shop_name`,`id_customer`,`about_us` from `"._DB_PREFIX_."marketplace_shop` where `id` =".$id_shop." ");
				if($marketplace_shop) {
					$shop_name = $marketplace_shop['shop_name'];
					$id_customer = $marketplace_shop['id_customer'];
					$about_us = $marketplace_shop['about_us'];
					
					$marketplace_seller_id_info = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select `marketplace_seller_id`,`is_seller` from `"._DB_PREFIX_."marketplace_customer` where `id_customer` =".$id_customer." ");
				
					if($marketplace_seller_id_info) {
						$is_seller_active = $marketplace_seller_id_info['is_seller'];
						$marketplace_seller_id = $marketplace_seller_id_info['marketplace_seller_id'];
						if($is_seller_active==1) {
							 $reviews_info = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("select * from `"._DB_PREFIX_."seller_reviews` where `id_seller` =".$marketplace_seller_id." and `active`=1");
							
							$rating = 0;
							$i = 0;
							foreach($reviews_info as $reviews) {
								$rating = $rating + $reviews['rating'];
								$i++;
							}
							if($rating != 0)
							{
							$avg_rating = (double)($rating/$i);
							}
							else
							{
							 $avg_rating = 0;
							}
							$smarty->assign("avg_rating", $avg_rating);
						
							$market_place_seller_info = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `"._DB_PREFIX_."marketplace_seller_info` where `id` =".$marketplace_seller_id." ");

							if($market_place_seller_info) {
								$business_email = $market_place_seller_info['business_email'];
								$phone = $market_place_seller_info['phone'];

								$fax = $market_place_seller_info['fax'];

								$customer_info = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `"._DB_PREFIX_."customer` where `id_customer` =".$id_customer." ");
	
								$param1 = array('flag'=>'1','all_reviews'=>'1','shop'=>$id_shop,'seller_id'=>$marketplace_seller_id);
								
								$all_reviews_links = $link->getModuleLink('marketplace','allreviews',$param1);
								
								$smarty->assign("id_shop1", $id_shop);
								$smarty->assign("all_reviews", $all_reviews_links);

																
								
								$marketplace_shop_product = Db::getInstance()->ExecuteS("SELECT msp.*,mslp.* FROM `" . _DB_PREFIX_ . "marketplace_shop_product` msp join `" . _DB_PREFIX_ . "marketplace_seller_product` mslp on (msp.`marketplace_seller_id_product` = mslp.`id`) join `" . _DB_PREFIX_ . "product` p on (msp.`id_product`=p.`id_product`) where msp.`id_shop` =" . $id_shop . " order by `product_name` asc limit 15");

										   

								$shop_size =  Configuration::get('shop-size');

								$shop_color =  Configuration::get('shop-color');

								$shop_font_family =  Configuration::get('shop-font-family');

											

								$shop_head_size =  Configuration::get('shop-head-size');

								$shop_head_color =  Configuration::get('shop-head-color');

								$shop_head_font_family =  Configuration::get('shop-head-font-family');
																			
								$smarty->assign("shop_arg",array('shop'=>$id_shop));
								$smarty->assign("shop_head_size",$shop_head_size);
								$smarty->assign("shop_head_color",$shop_head_color);

								$smarty->assign("shop_head_font_family",$shop_head_font_family);

								$smarty->assign("shop_size",$shop_size);

								$smarty->assign("shop_color",$shop_color);

								$smarty->assign("shop_font_family",$shop_font_family);   

											
								$smarty->assign("seller_name",$market_place_seller_info['seller_name']);
								$smarty->assign("phone",$phone);

								$smarty->assign("fax",$fax);

								$smarty->assign("business_email",$business_email);

								$smarty->assign("id_shop",$id_shop);

								$smarty->assign("seller_id",$marketplace_seller_id);

								$smarty->assign("shop_name",$shop_name);

								$smarty->assign("id_customer",$id_customer);

								$smarty->assign("market_place_seller_info",$market_place_seller_info);

								$smarty->assign("customer_info",$customer_info);

								$smarty->assign("module_path",_MODULE_DIR_);
								$smarty->assign("id_product",$id_product);
								
								

							} else {

								Tools::redirect(__PS_BASE_URI__.'pagenotfound');

							}

						} else {
						
						}

					} else {

						Tools::redirect(__PS_BASE_URI__.'pagenotfound');

					}

				} else {

					Tools::redirect(__PS_BASE_URI__.'pagenotfound');

				}

			} else {

				Tools::redirect(__PS_BASE_URI__.'pagenotfound');

			}
			if ($marketplace_shop_product) {

				$a = 0;

				foreach ($marketplace_shop_product as $marketplace_shop_product1) {
					$marketplace_product_id[] = $marketplace_shop_product1['id_product'];
					$marketplace_seller_id    = $marketplace_shop_product1['id_seller'];
					$a++;
				}
				
				$count = count($marketplace_product_id);
				
				for ($i = 0; $i < $count; $i++) {
					$product[] = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `" . _DB_PREFIX_ . "product` where id_product =" . $marketplace_product_id[$i] . " ");
				}

				$a = 0;
				foreach ($product as $product1) {
					$product_id[] = $product1['id_product'];
					$a++;
				}

				$count_product = count($product_id);
				for ($i = 0; $i < $count_product; $i++) {
					$image[]        = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `" . _DB_PREFIX_ . "image` where id_product =" . $product_id[$i] . " and cover = 1");
					$image_id        = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `" . _DB_PREFIX_ . "image` where id_product =" . $product_id[$i] . " and cover = 1");
					
					$product_lang[] = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `" . _DB_PREFIX_ . "product_lang` where id_product =" . $product_id[$i] . " and id_lang=".$id_lang);
					
					$link_rewrite_info =  Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `" . _DB_PREFIX_ . "product_lang` where id_product =" . $product_id[$i] . " and id_lang=".$id_lang);
					
					$name = $link_rewrite_info['link_rewrite'];
					$ids = $product_id[$i].'-'.$image_id['id_image'];
					$product_obj = new Product($product_id[$i]);
					$cover_image_id = Product::getCover($product_obj->id);	
					if($cover_image_id) {
						$ids = $product_obj->id.'-'.$cover_image_id['id_image'];
						$prduct_img_link = "http://".$link->getImageLink($product_obj->link_rewrite,$ids);
						$image_link[] = $prduct_img_link;
					} else {
						$image_link[] = _MODULE_DIR_.'marketplace/img/defaultproduct.jpg';
					}
				}

				$total_products = count($product_lang);
				$a = 0;
				
				foreach ($product_lang as $product_lang1) {
					$product_name[] = $product_lang1['name'];
					$product_desc[] = $product_lang1['description'];
					$a++;
				}
				$a = 0;
				
				foreach ($product as $product1) {
					$product_price[]    = number_format($product1['price'],2,'.','');
					$product_id[]       = $product1['id_product'];
					$product_quantity[] = $product1['quantity'];
					$a++;
				}

				$a = 0;
				$i = 0;
			

				$mkt_shop  = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `" . _DB_PREFIX_ . "marketplace_seller_info` where id =" . $marketplace_seller_id . " ");

				$shop_name = $mkt_shop['shop_name'];

												
				
				
				$param = array('seller_id'=>$marketplace_seller_id);
				
				
				$all_reviews = $link->getModuleLink('marketplace','allreviews',$param);
				
				$smarty->assign("all_reviews",$all_reviews);

				
				

				$shop_size =  Configuration::get('shop-size');

				$shop_color =  Configuration::get('shop-color');

				$shop_font_family =  Configuration::get('shop-font-family');

				$smarty->assign("shop_size",$shop_size);

				$smarty->assign("shop_color",$shop_color);

				$smarty->assign("shop_font_family",$shop_font_family);

				$shop_head_size =  Configuration::get('shop-head-size');

				$shop_head_color =  Configuration::get('shop-head-color');

				$shop_head_font_family =  Configuration::get('shop-head-font-family');

																				

				$smarty->assign("shop_head_size",$shop_head_size);

				$smarty->assign("shop_head_color",$shop_head_color);

				$smarty->assign("shop_head_font_family",$shop_head_font_family);	

				$count_product = count($product_quantity);

				

				$smarty->assign("shop_name", $shop_name);

				$smarty->assign("seller_id", $marketplace_seller_id);

				$smarty->assign("product_quantity", $product_quantity);

				$smarty->assign("product_price", $product_price);

				$smarty->assign("product_id", $product_id);

				

		

				$smarty->assign("product_desc", $product_desc);

				$smarty->assign("product_name", $product_name);

				$smarty->assign("count_product", $count_product);
				$smarty->assign("image_link", $image_link);

			} else {
				$smarty->assign("count_product", 0);
			}
			$param = array('shop'=>$id_shop);
			$link_collection = $link->getModuleLink('marketplace','shopcollection',$param);

			$link_store = $link->getModuleLink('marketplace','shopstore',$param);

			$link_conatct = $link->getModuleLink('marketplace','contact',$param);

			$Seller_profile = $link->getModuleLink('marketplace','sellerprofile',$param);
			
			$smarty->assign("link_store",$link_store);

			$smarty->assign("link_collection",$link_collection);

			$smarty->assign("Seller_profile",$Seller_profile);

			$smarty->assign("link_conatct",$link_conatct);
			$smarty->assign("about_us",$about_us);
			$this->setTemplate('shop-store.tpl');									
		}

		public function setMedia()
		{
			parent::setMedia();
			$this->addCSS(_MODULE_DIR_.'marketplace/css/shop_store.css');
			$this->addJS(_MODULE_DIR_.'marketplace/rateit/lib/jquery.raty.min.js');
		    $this->addCSS(_MODULE_DIR_.'marketplace/js/microfiche/vendor/prettify.css');
		    $this->addCSS(_MODULE_DIR_.'marketplace/js/microfiche/microfiche.css');
            $this->addCSS(_MODULE_DIR_.'marketplace/js/microfiche/microfiche.css');
			$this->addJS(_MODULE_DIR_.'marketplace/js/microfiche/vendor/prettify.js');
			$this->addJS(_MODULE_DIR_.'marketplace/js/microfiche/microfiche.js');
		}

	}

?>