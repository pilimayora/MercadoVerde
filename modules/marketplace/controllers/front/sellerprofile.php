<?php
if (!defined('_PS_VERSION_'))
	exit;
include_once 'modules/marketplace/get_info.php';
	class marketplaceSellerprofileModuleFrontController extends ModuleFrontController	{

		public function initContent() {

			global $cookie;

			global $smarty;
					
			if(Tools::isSubmit('submit_feedback'))
			{
			  $id_customer = $this->context->cookie->id_customer;
			  
			  $seller_id = Tools::getValue('seller_id');
			  $feedback = Tools::getValue('feedback');
			  $rating = Tools::getValue('rating_image');
			  $obj = new get_info();
			  $cust_info = $obj->getCustomerInfo($id_customer);
			  $insert = $obj->insert_feedback($seller_id,$id_customer,$cust_info['email'],$rating,$feedback);
			}

			$id_product = Tools::getValue('id');

			$link = new link();

			if($id_product!='') {

				$seller_shop_detail = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select `id_shop`,`marketplace_seller_id_product` from `"._DB_PREFIX_."marketplace_shop_product` where id_product =".$id_product." ");

				if($seller_shop_detail) {

					

					$id_shop = $seller_shop_detail['id_shop'];

					

					$market_place_seller_id_product = $seller_shop_detail['marketplace_seller_id_product'];

					

					$marketplace_sellr_product_info = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `"._DB_PREFIX_."marketplace_seller_product` where `id` =".$market_place_seller_id_product." ");

					

					$seller_id = $marketplace_sellr_product_info['id_seller'];

				

					$marketplace_shop = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select `shop_name`,`id_customer` from `"._DB_PREFIX_."marketplace_shop` where `id` =".$id_shop." ");

					$shop_name = $marketplace_shop['shop_name'];

					

					$id_customer = $marketplace_shop['id_customer'];

					

					$market_place_seller_info = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `"._DB_PREFIX_."marketplace_seller_info` where `id` =".$seller_id." ");

					$business_email = $market_place_seller_info['business_email'];

					$phone = $market_place_seller_info['phone'];

					$fax = $market_place_seller_info['fax'];

					$customer_info = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `"._DB_PREFIX_."customer` where `id_customer` =".$id_customer." ");

					

					

					///For lates product

					$product_detail = Db::getInstance()->executeS("select * from `"._DB_PREFIX_."marketplace_shop_product` mpsp join `"._DB_PREFIX_."product` p on (p.`id_product`=mpsp.`id_product`) join `"._DB_PREFIX_."product_lang` pl on (p.`id_product`=pl.`id_product`) join `"._DB_PREFIX_."image` i on (i.`id_product`=mpsp.`id_product`) where mpsp.`id_shop`=$id_shop and pl.`id_lang`=".$this->context->cookie->id_lang." and i.`cover`=1 order by p.`date_add` limit 10");

					$i=0;

					foreach($product_detail as $product_detail1) {

						$all_product_id[$i] = $product_detail1['id_product'];

						$product_link[$i] = $link->getImageLink($product_detail1['link_rewrite'],$product_detail1['id_product'].'-'.$product_detail1['id_image']);

						$all_product_price[$i] = number_format($product_detail1['price'],2,'.','');
						
						$all_product_name[$i] = $product_detail1['name'];
						$i++;

					}

					if(isset($all_product_id)) {
						if(is_array($all_product_id))
						{
						$count_latest_pro = count($all_product_id);
						}
					}
					else {
						$count_latest_pro = 0;
						$all_product_id="";
						$product_link="";
						$all_product_name="";
						$all_product_price="";
					}

					
                    						
											
					$reviews_info =Db::getInstance()->executeS("select * from `"._DB_PREFIX_."seller_reviews` where `id_seller`=".$seller_id." and `active`=1 order by `timestamp` desc limit 2");
					if($reviews_info)
					{
					 $reviews_details = array();
					 $i = 0;
					 foreach($reviews_info as $reviews)
					 {
					   $customer_info =Db::getInstance()->getRow("select * from `"._DB_PREFIX_."customer` where `id_customer`=".$reviews['id_customer']."");
					   if($customer_info)
					   {
						$reviews_details[$i]['customer_name'] = $customer_info['firstname']." ".$customer_info['lastname'];
						$reviews_details[$i]['customer_email'] = $customer_info['email'];
					   }
					   else
					   {
					    $reviews_details[$i]['customer_name'] = "Not Available";
						$reviews_details[$i]['customer_email'] = "Not Available";
					   }
					   
					   $reviews_details[$i]['rating'] = $reviews['rating'];
					   $reviews_details[$i]['review'] = $reviews['review'];
					   $reviews_details[$i]['time'] = $reviews['timestamp'];
					   
					   $i++;
					 }
					
					 $reviews_count = count($reviews_info);
					  $smarty->assign("reviews_count", $reviews_count);
					  $smarty->assign("reviews_details", $reviews_details);
					}
					else
					 $smarty->assign("reviews_count",0);
					///

					$link_store = $link->getModuleLink('marketplace','shopstore');

					$link_collection = $link->getModuleLink('marketplace','shopcollection');

					$seller_profile = $link->getModuleLink('marketplace','sellerprofile');

					$link_contact = $link->getModuleLink('marketplace','contact');

					

					$prof_size =  Configuration::get('prof-size');

					$prof_color =  Configuration::get('prof-color');

					$prof_font_family =  Configuration::get('prof-font-family');

					

					$shop_heading_size =  Configuration::get('shop-heading-size');

					$shop_heading_color =  Configuration::get('shop-heading-color');

					$shop_heading_font_family =  Configuration::get('shop-heading-font-family');

													

					$smarty->assign("shop_heading_size",$shop_heading_size);

					$smarty->assign("shop_heading_color",$shop_heading_color);

					$smarty->assign("shop_heading_font_family",$shop_heading_font_family);

												

					$smarty->assign("prof_size",$prof_size);

					$smarty->assign("prof_color",$prof_color);

				    $smarty->assign("prof_font_family",$prof_font_family);

					

					$smarty->assign("phone",$phone);

					$smarty->assign("fax",$fax);

					$smarty->assign("business_email",$business_email);
					////
					$smarty->assign("count_latest_pro",$count_latest_pro);

					$smarty->assign("all_product_id",$all_product_id);

					$smarty->assign("product_link",$product_link);

					$smarty->assign("all_product_price",$all_product_price);

					$smarty->assign("all_product_name",$all_product_name);

					$smarty->assign("customer_info",$customer_info);

					$smarty->assign("module_path",_MODULE_DIR_);

											
					///

					$smarty->assign("id_product",$id_product);

					$smarty->assign("link_contact",$link_contact);

					$smarty->assign("link_store",$link_store);

					$smarty->assign("link_collection",$link_collection);

					$smarty->assign("seller_profile",$seller_profile);

					

					$smarty->assign("id_shop",$id_shop);

					$smarty->assign("seller_id",$seller_id);

					$smarty->assign("shop_name",$shop_name);

					$smarty->assign("id_customer",$id_customer);

					

					$smarty->assign("market_place_seller_info",$market_place_seller_info);

					$smarty->assign("customer_info",$customer_info);

					$smarty->assign("module_path",_MODULE_DIR_);

					$this->setTemplate('seller-profile.tpl');	

				} else {

					Tools::redirect(__PS_BASE_URI__.'pagenotfound');

				}

			} 
			else {

				$id_shop = Tools::getValue('shop');
				$id_product =0;
				

				if(!$id_shop) {

					$id_shop = Tools::getValue('id_shop');

				}
				

				if($id_shop!='') {
					
					if(isset($_GET['all_reviews']))
					{
					  $seller_id = Tools::getValue('seller_id');
	                  $link = new link();
					  $reviews_info = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("select * from `"._DB_PREFIX_."seller_reviews` where `id_seller` =".$seller_id." order by timestamp desc");
	                  if($reviews_info)
	                  {
	                    $reviews_details1 = array();
                        $i = 0;
		                foreach($reviews_info as $reviews)
		                {
			             $customer_info =Db::getInstance()->getRow("select * from `"._DB_PREFIX_."customer` where `id_customer`=".$reviews['id_customer']."");
				         if($customer_info)
				         {
					       $reviews_details1[$i]['customer_name'] = $customer_info['firstname']." ".$customer_info['lastname'];
					       $reviews_details1[$i]['customer_email'] = $customer_info['email'];
				         }
			            else
                         {
					       $reviews_details1[$i]['customer_name'] = "Not Available";
				           $reviews_details1[$i]['customer_email'] = "Not Available";
			             }
					   
				        $reviews_details1[$i]['rating'] = $reviews['rating'];
			            $reviews_details1[$i]['review'] = $reviews['review'];
			            $reviews_details1[$i]['time'] = $reviews['timestamp'];
					   
				        $i++;
		               }
		               $reviews_count = count($reviews_info);
		               $smarty->assign("reviews_count", $reviews_count);
		               $smarty->assign("reviews_details1", $reviews_details1);
					   $smarty->assign("all_reviews",1);
	                 }
					}
					else
	                 $smarty->assign("reviews_count", 0);

						$marketplace_shop = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select `shop_name`,`id_customer` from `"._DB_PREFIX_."marketplace_shop` where `id` =".$id_shop." ");

						if($marketplace_shop) {

							$shop_name = $marketplace_shop['shop_name'];

							$id_customer = $marketplace_shop['id_customer'];

							

							//if($id_customer==$this->context->cookie->id_customer) {

								$marketplace_seller_id_info = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select `marketplace_seller_id`,`is_seller` from `"._DB_PREFIX_."marketplace_customer` where `id_customer` =".$id_customer." ");

								

								if($marketplace_seller_id_info) {

									$is_seller_active = $marketplace_seller_id_info['is_seller'];

									$marketplace_seller_id = $marketplace_seller_id_info['marketplace_seller_id'];

								

									if($is_seller_active==1) {

										$market_place_seller_info = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `"._DB_PREFIX_."marketplace_seller_info` where `id` =".$marketplace_seller_id." ");

										if($market_place_seller_info) {

											$business_email = $market_place_seller_info['business_email'];

											$phone = $market_place_seller_info['phone'];

											$fax = $market_place_seller_info['fax'];

											$customer_info = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `"._DB_PREFIX_."customer` where `id_customer` =".$id_customer." ");

											

											$product_detail = Db::getInstance()->executeS("select * from `"._DB_PREFIX_."marketplace_shop_product` mpsp join `"._DB_PREFIX_."product` p on (p.`id_product`=mpsp.`id_product`) join `"._DB_PREFIX_."product_lang` pl on (p.`id_product`=pl.`id_product`) join `"._DB_PREFIX_."image` i on (i.`id_product`=mpsp.`id_product`) where mpsp.`id_shop`=$id_shop and pl.`id_lang`=".$this->context->cookie->id_lang." and i.`cover`=1 order by p.`date_add` limit 10");

											$i=0;
											
											foreach($product_detail as $product_detail1) {

												$all_product_id[$i] = $product_detail1['id_product'];

												$all_product_price[$i] = number_format($product_detail1['price'],2,'.','');

												$all_product_name[$i] = $product_detail1['name'];

												$product_link[$i] = $link->getImageLink($product_detail1['link_rewrite'],$product_detail1['id_product'].'-'.$product_detail1['id_image']);

												$i++;

											}

											if(isset($all_product_id))
											{
												if(is_array($all_product_id))
												{
												$count_latest_pro = count($all_product_id);
												}
											}
											else
											{
											$count_latest_pro = 0;
											$all_product_id="";
											$product_link="";
											$all_product_name="";
											$all_product_price="";
											}
											
											
					$reviews_info =Db::getInstance()->executeS("select * from `"._DB_PREFIX_."seller_reviews` where `id_seller`=".$marketplace_seller_id." and `active`=1 order by `timestamp` desc");
					if($reviews_info)
					{
					 $reviews_details = array();
					 $i = 0;
					 $rating = 0;
					 foreach($reviews_info as $reviews)
					 {
					    if($i < 2)
						{
					   $customer_info =Db::getInstance()->getRow("select * from `"._DB_PREFIX_."customer` where `id_customer`=".$reviews['id_customer']."");
					   if($customer_info)
					   {
						$reviews_details[$i]['customer_name'] = $customer_info['firstname']." ".$customer_info['lastname'];
						$reviews_details[$i]['customer_email'] = $customer_info['email'];
					   }
					   else
					   {
					    $reviews_details[$i]['customer_name'] = "Not Available";
						$reviews_details[$i]['customer_email'] = "Not Available";
					   }
					   
					  
					   $reviews_details[$i]['rating'] = $reviews['rating'];
					   $reviews_details[$i]['review'] = $reviews['review'];
					   $reviews_details[$i]['time'] = $reviews['timestamp'];
					   }
					   $rating = $rating + $reviews['rating'];
					   $i++;
					 }
					 
					  $avg_rating = (double)($rating/$i);
					  $reviews_count = count($reviews_info);
					  $smarty->assign("reviews_count", $reviews_count);
					  $smarty->assign("avg_rating", $avg_rating);
					  $smarty->assign("reviews_details", $reviews_details);
					  
					}
					else {
					 $smarty->assign("reviews_count",0);
					 $smarty->assign("avg_rating", 0);
					}
					$param = array('shop'=>$id_shop);					

					$link_collection = $link->getModuleLink('marketplace','shopcollection',$param);

					$seller_profile = $link->getModuleLink('marketplace','sellerprofile',$param);

					$link_store = $link->getModuleLink('marketplace','shopstore',$param);

					$link_contact = $link->getModuleLink('marketplace','contact',$param);
					
					$param1 = array('flag'=>'1','all_reviews'=>'1','shop'=>$id_shop);
					$all_reviews_links = $link->getModuleLink('marketplace','allreviews',$param1);
                    $logo_path = 'modules/marketplace/img/seller_img/'.$marketplace_seller_id_info['marketplace_seller_id'].'.jpg';
				
					if (file_exists($logo_path)){
					  $path = _MODULE_DIR_ . 'marketplace/img/seller_img/'.$marketplace_seller_id_info['marketplace_seller_id'].'.jpg';
                    }
                    else
                    {
				
					  $path = _MODULE_DIR_ . 'marketplace/img/default-seller.jpg';
                    }					
                                             $smarty->assign('path',$path);
											$shop_heading_size =  Configuration::get('shop-heading-size');

										    $shop_heading_color =  Configuration::get('shop-heading-color');

											$shop_heading_font_family =  Configuration::get('shop-heading-font-family');

													
											$smarty->assign("id_product",$id_product);
											$smarty->assign("shop_heading_size",$shop_heading_size);

											$smarty->assign("shop_heading_color",$shop_heading_color);

											$smarty->assign("shop_heading_font_family",$shop_heading_font_family);

											$prof_size =  Configuration::get('prof-size');

										    $prof_color =  Configuration::get('prof-color');

										    $prof_font_family =  Configuration::get('prof-font-family');

												

											$smarty->assign("prof_size",$prof_size);

											$smarty->assign("prof_color",$prof_color);

											$smarty->assign("prof_font_family",$prof_font_family);

											

											$smarty->assign("phone",$phone);

											$smarty->assign("fax",$fax);

											$smarty->assign("business_email",$business_email);

											

											$smarty->assign("count_latest_pro",$count_latest_pro);

											$smarty->assign("all_product_id",$all_product_id);

											$smarty->assign("product_link",$product_link);

											$smarty->assign("all_product_price",$all_product_price);

											$smarty->assign("all_product_name",$all_product_name);

											

											$smarty->assign("id_shop",$id_shop);

											$smarty->assign("seller_id",$marketplace_seller_id);

											$smarty->assign("shop_name",$shop_name);

											$smarty->assign("id_customer",$id_customer);

											$smarty->assign("market_place_seller_info",$market_place_seller_info);

											$smarty->assign("customer_info",$customer_info);

											$smarty->assign("module_path",_MODULE_DIR_);

											

											$smarty->assign("link_contact",$link_contact);

											$smarty->assign("link_store",$link_store);

											$smarty->assign("link_collection",$link_collection);

											$smarty->assign("seller_profile",$seller_profile);
											$smarty->assign("all_reviews_links",$all_reviews_links);

											

											$this->setTemplate('seller-profile.tpl');
											
											

										} else {

											Tools::redirect(__PS_BASE_URI__.'pagenotfound');

										}

									} else {

										// seller is deactivated by admin

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

			}
			

			parent::initContent();

		}

		public function setMedia() {
			parent::setMedia();
			$this->addCSS(_MODULE_DIR_.'marketplace/css/shop_store.css');

			$this->addJS(_PS_JS_DIR_.'tiny_mce/tiny_mce.js');

			$this->addJS(_PS_JS_DIR_.'tinymce.inc.js');
			$this->addJS(_MODULE_DIR_.'marketplace/rateit/lib/jquery.raty.min.js');
			//$this->addJS(_MODULE_DIR_.'marketplace/js/jQuerySlider/themes/1/jquery-slider.js');
            $this->addCSS(_MODULE_DIR_.'marketplace/js/microfiche/vendor/prettify.css');
		    $this->addCSS(_MODULE_DIR_.'marketplace/js/microfiche/microfiche.css');
            $this->addCSS(_MODULE_DIR_.'marketplace/js/microfiche/microfiche.css');
			$this->addJS(_MODULE_DIR_.'marketplace/js/microfiche/vendor/prettify.js');
			$this->addJS(_MODULE_DIR_.'marketplace/js/microfiche/microfiche.js');
		}

	}

?>