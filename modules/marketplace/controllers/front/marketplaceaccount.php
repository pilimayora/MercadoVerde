<?php
include_once 'modules/marketplace/classes/MarketplaceClassInclude.php';
class marketplaceMarketplaceaccountModuleFrontController extends ModuleFrontController 
{
	
	public function initContent() {
        global $smarty;
        parent::initContent();
        $link     = new link();
		if(isset($_GET['orderby'])) {
			$orderby  = $_GET['orderby'];
        }
		else {
			$orderby  = 'product_name';
		}
		
		if(isset($_GET['orderway'])) {
			$orderway  = $_GET['orderway'];
        }
		else {
			$orderway  = 'asc';
		}
		
		if ($orderby == 'name') {
            $orderby = 'product_name';
        } elseif ($orderby == '') {
            $orderby = 'product_name';
        }
        if ($orderway == '') {
            $orderway = 'asc';
        }
		$page_no = Tools::getValue('p');
		if(isset($page_no)){
			$page_no = $page_no;
		}else{
			$page_no = 1;
		}
		 $id_lang     = $this->context->cookie->id_lang;
		 
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false) 
		    { 
				$smarty->assign("browser", "ie");
			}
		else
			{
				$smarty->assign("browser", "notie");
			} 
		 
        $new_link = $link->getModuleLink('marketplace', 'sellerrequest');
        $smarty->assign("new_link", $new_link);
		/////////
		$recent_color   = Configuration::get('recent-color');
				
		if($recent_color == "" ) {
			$recent_color = '#E65505';
		}
		else {
			$recent_color   = Configuration::get('recent-color');
		}
						
		$smarty->assign("recent_color", $recent_color);
				 
		$color             = Configuration::get('color');
				 
		if($color == "" ) {
			$color = '#6C702F';
		} else {
			$color   = Configuration::get('color');
		}
						
		$smarty->assign("color", $color);
				 

		$smarty->assign("id_lang", $id_lang);		 
		
		//////////
        if (isset($this->context->cookie->id_customer)) {
            //current customer id whose login at tha time
            $customer_id     = $this->context->cookie->id_customer;
            //check whether request has been sent or not..........
			$obj_mp_customer = new MarketplaceCustomer();
			$obj_mp_seller = new SellerInfoDetail();
			$obj_mp_shop = new MarketplaceShop();
			$obj_mp_seller_product = new SellerProductDetail();
			
            $already_request = $obj_mp_customer->findMarketPlaceCustomer($customer_id);
            if ($already_request) {
                //is_seller set to -1 when customer not request for market place yet 
                //@is_seller = 0 customer send requset for market place but admin not approve yet
                //@is_seller =1 admin approve market place seller request 
                $is_seller = $already_request['is_seller'];
                if ($is_seller == 1) {
                    $marketplace_seller_id   = $already_request['marketplace_seller_id'];
					
					$marketplace_seller_info = $obj_mp_seller->sellerDetail($marketplace_seller_id);
					
					$market_place_shop = $obj_mp_shop->getMarketPlaceShopInfoByCustomerId($customer_id);
                   
                    if ($market_place_shop) {
                        $is_active = $market_place_shop['is_active'];
                        $id_shop   = $market_place_shop['id'];
                        $obj_ps_shop = new MarketplaceShop($id_shop);
						$name_shop = $obj_ps_shop->link_rewrite;
                        
						//shop link
						$param = array('shop'=>$id_shop);
						$payment_detail     = $link->getModuleLink('marketplace', 'customerPaymentDetail',$param);
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
						$smarty->assign("account_dashboard", $account_dashboard);
                        $smarty->assign("link_store", $link_store);
                        $smarty->assign("seller_profile", $seller_profile);
                        $smarty->assign("link_collection", $link_collection);
                        $smarty->assign("add_product", $add_product);
                        $smarty->assign("is_seller", $is_seller);
                        $smarty->assign("edit_profile", $edit_profile);
                        $smarty->assign("product_list", $product_list);
                        $smarty->assign("my_order", $my_order);
                        $smarty->assign("payment_details", $payment_details);
						
                        
                        
                        if (isset($_GET['l']) && $_GET['l'] != '') {
                            $logic = $_GET['l'];
                        } else {
                            $logic = 1;
                        }
						
						$smarty->assign("payment_detail", $payment_detail);
						$smarty->assign("customer_id", $customer_id);
						$smarty->assign("id_shop", $id_shop);
						$smarty->assign("logic", $logic);
						
                        $even_row_color = Configuration::get('even_row_color');
                        $odd_row_color  = Configuration::get('odd_row_color');
                        $heading_color  = Configuration::get('heading_color');
						$recent_size    = Configuration::get('recent-size');
						$font_size1        = Configuration::get('font-size1');
                        $font_family2      = Configuration::get('font-family2');
						
                        $smarty->assign("even_row_color", $even_row_color);
                        $smarty->assign("odd_row_color", $odd_row_color);
                        $smarty->assign("heading_color", $heading_color);
                        
						$smarty->assign("recent_size", $recent_size);
                        $smarty->assign("font_size1", $font_size1);
                        $smarty->assign("font_family2", $font_family2);
                      
                        
                        $smarty->assign("seller_name", $marketplace_seller_info['seller_name']);
                       
                        if ($logic == 1) {
                            				
							$dashboard      = Db::getInstance()->executeS("SELECT ordd.`product_price` as total_price,ordd.`product_quantity` as qty, ordd.`id_order` as id_order,ord.`id_customer` as order_by_cus,ord.`payment` as payment_mode,cus.`firstname` as name,ord.`date_add`,ords.`name`as order_status,ord.`id_currency` as id_currency from `" . _DB_PREFIX_ . "marketplace_shop_product` msp join `" . _DB_PREFIX_ . "order_detail` ordd on (ordd.`product_id`=msp.`id_product`) join `"._DB_PREFIX_."orders` ord on (ordd.`id_order`=ord.`id_order`) join `"._DB_PREFIX_."marketplace_seller_product` msep on (msep.`id` = msp.`marketplace_seller_id_product`) join `"._DB_PREFIX_."marketplace_customer` mkc on (mkc.`marketplace_seller_id` = msep.`id_seller`) join `" . _DB_PREFIX_ . "customer` cus on (mkc.`id_customer`=cus.`id_customer`) join `" . _DB_PREFIX_ . "order_state_lang` ords on (ord.`current_state`=ords.`id_order_state`) where ords.id_lang=".$id_lang." and cus.`id_customer`=" . $customer_id . "  order by ordd.`id_order` desc limit 5");
							
							$a=0;
							foreach($dashboard as $dashboard1)
							{
								$currency_detail = Currency::getCurrency($dashboard1['id_currency']);
								$order_currency[] = $currency_detail['sign'];
								$a++;
							}
							if(isset($order_currency)) {
								$smarty->assign("order_currency", $order_currency);
							}
                            $main_heading_color   = Configuration::get('main-heading-color');
                            $main_heading_family  = Configuration::get('main-heading-family');
                            $main_heading_size    = Configuration::get('main-heading-size');
                            $count                = count($dashboard);
                            $even_row_color       = Configuration::get('even_row_color');
                            $odd_row_color        = Configuration::get('odd_row_color');
                            $heading_color        = Configuration::get('heading_color');
                           
							
							
						
                            $recent_size          = Configuration::get('recent-size');
                            $order_heading_size   = Configuration::get('order-heading-size');
                            $order_heading_family = Configuration::get('order-heading-family');
                            $order_row_size       = Configuration::get('order-row-size');
                            $order_row_family     = Configuration::get('order-row-family');
							
							//// for statics - Asia/Kolkata - Time Zone Information - Daylight ...
							date_default_timezone_set('Asia/Calcutta');
							if(isset($_GET['from_date']) && isset($_GET['to_date']))
							   {
								   if($_GET['from_date']=='' || $_GET['to_date']=='')
									 {
										$time_stamp=time();
										$dat = getdate($time_stamp);
										$j=29;
									 }
								   else
									 {
									   
										$end_date = $_GET['to_date'];
										$from_date = strtotime($_GET['from_date']);
										//echo $end_date;
										
										$todate = strtotime($end_date);
										if($todate<$from_date)
										  {
											 $error = "To date must be greater than From date";
											// echo $error;
											$smarty->assign("error", $error);
											 $time_stamp=time();
											 $dat = getdate($time_stamp);
											 $j=29;
										  }
										else
										  {
											
											// echo "<br />".$todate;
											$time_stamp=$todate;
											$dat = getdate($time_stamp);
											 $total_difffernce_btwn_date = ($todate-$from_date)/86400;
											 $j = intval($total_difffernce_btwn_date);
																			 
										  }
									 }
							   }
							else
							   {
								  $time_stamp=time()+86400;
								  $dat = getdate($time_stamp);
								  $j=29;
							   }
													
							$dat1 = $dat['mday'].'-'.$dat['mon'].'-'.$dat['year'];
							
							$newdate =array();
							$time_stamp_date = array();
							for($i=$j;$i>=0;$i--)
								{
									$time_stamp_date[$i] = $time_stamp-$i*86400;
									$dat = getdate($time_stamp-$i*86400);
									$newdate[$i] = $dat['year'].'-'.$dat['mon'].'-'.$dat['mday'];
								}
							$todate = $newdate[0];
							$from_date = $newdate[$j];
							$l= $j;
							
							$smarty->assign("newdate", $newdate);
							for($i=$l;$i>0;$i--) {
								$prev= $newdate[$i];
								$j = $i-1;
								$next = $newdate[$j];
								
							
								$total_price = Db::getInstance()->executeS("SELECT IFNULL(SUM(ordd.`product_price`),0) as total_price,ordd.`product_quantity` as qty, ordd.`id_order` as id_order,ord.`id_customer` as order_by_cus,ord.`payment` as payment_mode,cus.`firstname` as name,ord.`date_add`,ords.`name`as order_status from `" . _DB_PREFIX_ . "marketplace_shop_product` msp join `" . _DB_PREFIX_ . "order_detail` ordd on (ordd.`product_id`=msp.`id_product`) join `"._DB_PREFIX_."orders` ord on (ordd.`id_order`=ord.`id_order`) join `"._DB_PREFIX_."marketplace_seller_product` msep on (msep.`id` = msp.`marketplace_seller_id_product`) join `"._DB_PREFIX_."marketplace_customer` mkc on (mkc.`marketplace_seller_id` = msep.`id_seller`) join `" . _DB_PREFIX_ . "customer` cus on (mkc.`id_customer`=cus.`id_customer`) join `" . _DB_PREFIX_ . "order_state_lang` ords on (ord.`current_state`=ords.`id_order_state`) where ords.id_lang=".$id_lang." and cus.`id_customer`=" . $customer_id . " and ord.`date_add` between '".$prev."' and '".$next."'"); 
							
								$count_order = Db::getInstance()->executeS("SELECT IFNULL(count(ord.`id_order`),0) as total_order from `" . _DB_PREFIX_ . "marketplace_shop_product` msp join `" . _DB_PREFIX_ . "order_detail` ordd on (ordd.`product_id`=msp.`id_product`) join `"._DB_PREFIX_."orders` ord on (ordd.`id_order`=ord.`id_order`) join `"._DB_PREFIX_."marketplace_seller_product` msep on (msep.`id` = msp.`marketplace_seller_id_product`) join `"._DB_PREFIX_."marketplace_customer` mkc on (mkc.`marketplace_seller_id` = msep.`id_seller`) join `" . _DB_PREFIX_ . "customer` cus on (mkc.`id_customer`=cus.`id_customer`) join `" . _DB_PREFIX_ . "order_state_lang` ords on (ord.`current_state`=ords.`id_order_state`) where ords.id_lang=".$id_lang." and cus.`id_customer`=" . $customer_id . " and ord.`date_add` between '".$prev."' and '".$next."'"); 
								
								$product_price_detail[$i] = Tools::ps_round($total_price[0]['total_price'],2);
								$count_order_detail[$i] = $count_order[0]['total_order'];
							}
							
							
							
							$smarty->assign("product_price_detail", $product_price_detail);
							$smarty->assign("count_order_detail", $count_order_detail);
							
							$smarty->assign("loop_exe", $l);
							
							$smarty->assign("to_date", $todate);
							$smarty->assign("from_date", $from_date);
							
                            $smarty->assign("order_heading_size", $order_heading_size);
                            $smarty->assign("order_heading_family", $order_heading_family);
                            $smarty->assign("order_row_size", $order_row_size);
                            $smarty->assign("order_row_family", $order_row_family);
                            $smarty->assign("even_row_color", $even_row_color);
                            $smarty->assign("odd_row_color", $odd_row_color);
                            $smarty->assign("heading_color", $heading_color);
                           
                            $smarty->assign("recent_size", $recent_size);
                            $smarty->assign("main_heading_size", $main_heading_size);
                            $smarty->assign("main_heading_family", $main_heading_family);
                            $smarty->assign("main_heading_color", $main_heading_color);
                            $smarty->assign("dashboard", $dashboard);
                            $smarty->assign("count", $count);
                            $this->setTemplate('marketplace_account1.tpl');
                        } 
						elseif ($logic == 2) 
						{
                            if (isset($_GET['edit-profile'])) 
							{
                                $smarty->assign("edit", 1);
                                $editprofile       = $link->getModuleLink('marketplace', 'editProfile',$param);
                                $even_row_color    = Configuration::get('even_row_color');
                                $odd_row_color     = Configuration::get('odd_row_color');
                                $heading_color     = Configuration::get('heading_color');
                               
						
						
                                $recent_size       = Configuration::get('recent-size');
                                $edit_size         = Configuration::get('edit-size');
                                $edit_color        = Configuration::get('edit-color');
                                $edit_back_color   = Configuration::get('edit-back-color');
                                $edit_font_family  = Configuration::get('edit-font-family');
                                $edit_border_color = Configuration::get('edit-border-color');
                                $smarty->assign("edit_size", $edit_size);
                                $smarty->assign("edit_color", $edit_color);
                                $smarty->assign("edit_font_family", $edit_font_family);
                                $smarty->assign("edit_back_color", $edit_back_color);
                                $smarty->assign("edit_border_color", $edit_border_color);
                                $smarty->assign("even_row_color", $even_row_color);
                                $smarty->assign("odd_row_color", $odd_row_color);
                                $smarty->assign("heading_color", $heading_color);
                               
                                $smarty->assign("recent_size", $recent_size);
								if(isset($_GET['img_shop'])) {
									$smarty->assign("shop_img_size_error",1);
								} else {
									$smarty->assign("shop_img_size_error",0);
								}
								
								if(isset($_GET['img_seller'])) {
									$smarty->assign("seller_img_size_error",1);
								} else {
									$smarty->assign("seller_img_size_error",0);
								}
								
								
                                $smarty->assign("editprofile", $editprofile);
                            } 
							  else
							  {
                                $smarty->assign("edit", 0);
                                if (isset($_GET['update']) && $_GET['update'] != '' && $_GET['update'] != 0) {
                                    $even_row_color = Configuration::get('even_row_color');
                                    $odd_row_color  = Configuration::get('odd_row_color');
                                    $heading_color  = Configuration::get('heading_color');
                                    
						
						
                                    $recent_size    = Configuration::get('recent-size');
                                    $smarty->assign("even_row_color", $even_row_color);
                                    $smarty->assign("odd_row_color", $odd_row_color);
                                    $smarty->assign("heading_color", $heading_color);
                                   
                                    $smarty->assign("recent_size", $recent_size);
                                    $smarty->assign("update", $_GET['update']);
                                } else {
									$smarty->assign("update",3);
								}
							}
                           
                            $propage_back_color       = Configuration::get('propage-back-color');
                            $propage_border_color     = Configuration::get('propage-border-color');
                            $propage_head_color       = Configuration::get('propage-head-color');
                            $propage_head_size        = Configuration::get('propage-head-size');
                            $propage_head_font_family = Configuration::get('propage-head-font-family');
                            $propage_color            = Configuration::get('propage-color');
                            $propage_size             = Configuration::get('propage-size');
                            $propage_font_family      = Configuration::get('propage-font-family');
                            $smarty->assign("edit_back_color", $propage_back_color);
                            $smarty->assign("edit_border_color", $propage_border_color);
                            $smarty->assign("edit_color", $propage_head_color);
                            $smarty->assign("edit_font_family", $propage_head_size);
                            $smarty->assign("edit_font_family", $propage_head_font_family);
                            $smarty->assign("propage_color", $propage_color);
                            $smarty->assign("propage_size", $propage_size);
                            $smarty->assign("propage_font_family", $propage_font_family);
                            $even_row_color = Configuration::get('even_row_color');
                            $odd_row_color  = Configuration::get('odd_row_color');
                            $heading_color  = Configuration::get('heading_color');
                          
						
						
                            $recent_size    = Configuration::get('recent-size');
                            $smarty->assign("even_row_color", $even_row_color);
                            $smarty->assign("odd_row_color", $odd_row_color);
                            $smarty->assign("heading_color", $heading_color);
                           
                            $smarty->assign("recent_size", $recent_size);
                            $logo_path = _MODULE_DIR_ . 'marketplace/img/shop_img/'.$marketplace_seller_id . '-' . $marketplace_seller_info['shop_name'] . '.jpg';
                            $smarty->assign("logo_path", $logo_path);
                            $smarty->assign("marketplace_address", trim($marketplace_seller_info['address']));
                            $smarty->assign("marketplace_seller_info", $marketplace_seller_info);
                            $smarty->assign("market_place_shop", $market_place_shop);
                            $this->setTemplate('marketplace_account1.tpl');
                        } elseif ($logic == 3) {
							if(isset($_GET['del']))
							{
								$is_deleted   = $_GET['del'];
							}
							else
							{
							$is_deleted=0;
							}
						
							if(isset($_GET['edit']))
							{
							   $is_edited    = $_GET['edit'];
							}
							else
							{
								$is_edited=0;
							}
							
                            
                            $link         = new link();
							$param = array('flag'=>1);
                            $pro_upd_link = $link->getModuleLink('marketplace', 'productupdate',$param);
							$proimageeditlink = $link->getModuleLink('marketplace', 'productimageedit',$param);
							
							
                            $smarty->assign("pro_upd_link", $pro_upd_link);
                            $smarty->assign("proimageeditlink", $proimageeditlink);
                            $product_info         = Db::getInstance()->ExecuteS("SELECT * from`" . _DB_PREFIX_ . "marketplace_seller_product` where id_seller=" . $marketplace_seller_id);
                            //var_dump($product_info);
                            $pro_color            = Configuration::get('pro_color');
                            $color5               = Configuration::get('color5');
                            $color6               = Configuration::get('color6');
                            $pro_head_font_size   = Configuration::get('pro-head-font-size');
                            $row_font_size        = Configuration::get('row-font-size');
                            $pro_head_font_family = Configuration::get('pro-head-font-family');
                            $row_font_family      = Configuration::get('row-font-family');
                            $even_row_color       = Configuration::get('even_row_color');
                            $odd_row_color        = Configuration::get('odd_row_color');
                            $heading_color        = Configuration::get('heading_color');
                           
						
						
                            $recent_size          = Configuration::get('recent-size');
                            $smarty->assign("pro_color", $pro_color);
                            $smarty->assign("color5", $color5);
                            $smarty->assign("color6", $color6);
                            $smarty->assign("pro_head_font_size", $pro_head_font_size);
                            $smarty->assign("row_font_size", $row_font_size);
                            $smarty->assign("pro_head_font_family", $pro_head_font_family);
                            $smarty->assign("row_font_family", $row_font_family);
                            $smarty->assign("even_row_color", $even_row_color);
                            $smarty->assign("odd_row_color", $odd_row_color);
                            $smarty->assign("heading_color", $heading_color);
                         
                            $smarty->assign("recent_size", $recent_size);
                            $count = count($product_info);
                            $smarty->assign("product_info", $product_info);
                           $smarty->assign("count", $count);
                            $smarty->assign("is_deleted", $is_deleted);
                            $smarty->assign("is_edited", $is_edited);
							
							//Link
							
							$product_details_link = $link->getModuleLink('marketplace', 'productdetails',$param);
							$smarty->assign("product_details_link", $product_details_link);
							
							//Pagination
							$NoOfProduct = count($product_info);
							//echo 'count=='.$NoOfProduct;
							$this->pagination($NoOfProduct);
							
							
							$productList = $obj_mp_seller_product->getProductList($marketplace_seller_id,$orderby,$orderway,$this->p, $this->n);
							if(!$productList) {
								$productList = 0;
							}
							$param = array('l'=>$logic);
							$smarty->assign('param',$param);
							$sortingLink = $link->getModuleLink('marketplace', 'marketplaceaccount',array('shop'=>$id_shop,'l'=>$logic,'p'=>$page_no));
							$smarty->assign("sorting_link", $sortingLink);
							$paginationLink = $link->getModuleLink('marketplace', 'marketplaceaccount',array('shop'=>$id_shop,'l'=>$logic,'orderby'=>$orderby,'orderway'=>$orderway));
							$smarty->assign("pagination_link", $paginationLink);
							$smarty->assign("page_no", $page_no);
							$this->context->smarty->assign(array(
															'pages_nb' => ceil($NoOfProduct / (int)$this->n),
															'nbProducts' => $NoOfProduct,
															'recordperpage' => (int)$this->n,
															'mediumSize' => Image::getSize(ImageType::getFormatedName('medium')),
															'product_lists' => $productList,
															));
							$imageediturl = $link->getModuleLink('marketplace','productimageedit');	
							$smarty->assign('imageediturl',$imageediturl);
                            $this->setTemplate('marketplace_account1.tpl');
                        } elseif ($logic == 4) {
						
                            $customer_id    = $this->context->customer->id;
							
                            $dashboard      = Db::getInstance()->executeS("SELECT ordd.`id_order_detail` as `id_order_detail`,ordd.`product_name` as `ordered_product_name`,ordd.`product_price` as total_price,ordd.`product_quantity` as qty, ordd.`id_order` as id_order,ord.`id_customer` as order_by_cus,ord.`payment` as payment_mode,cus.`firstname` as name,ord.`date_add`,ords.`name`as order_status,ord.`id_currency` as `id_currency` from `" . _DB_PREFIX_ . "marketplace_shop_product` msp join `" . _DB_PREFIX_ . "order_detail` ordd on (ordd.`product_id`=msp.`id_product`) join `"._DB_PREFIX_."orders` ord on (ordd.`id_order`=ord.`id_order`) join `"._DB_PREFIX_."marketplace_seller_product` msep on (msep.`id` = msp.`marketplace_seller_id_product`) join `"._DB_PREFIX_."marketplace_customer` mkc on (mkc.`marketplace_seller_id` = msep.`id_seller`) join `" . _DB_PREFIX_ . "customer` cus on (mkc.`id_customer`=cus.`id_customer`) join `" . _DB_PREFIX_ . "order_state_lang` ords on (ord.`current_state`=ords.`id_order_state`) where ords.id_lang=".$id_lang." and cus.`id_customer`=" . $customer_id . "  GROUP BY ordd.`id_order` order by ordd.`id_order` desc");
							
							/*SELECT SUM(ordd.`product_price`) as total_price,ordd.`id_order` as id_order,ord.`id_customer` as order_by_cus,ord.`payment` as payment_mode,cus.`firstname` as name,ord.`date_add`,ords.`name`as order_status from `ps_marketplace_shop_product` msp join `ps_order_detail` ordd on (ordd.`product_id`=msp.`id_product`) join `ps_orders` ord on (ordd.`id_order`=ord.`id_order`) join `ps_marketplace_seller_product` msep on (msep.`id` = msp.`marketplace_seller_id_product`) join `ps_marketplace_customer` mkc on (mkc.`marketplace_seller_id` = msep.`id_seller`) join `ps_customer` cus on (mkc.`id_customer`=cus.`id_customer`) join `ps_order_state_lang` ords on (ord.`current_state`=ords.`id_order_state`) where cus.`id_customer`=4 group by ordd.`id_order` order by ordd.`id_order` desc
							*/
							$message = Db::getInstance()->executeS("SELECT ordd.`product_name` as product_name,cusmsg.`message` as message,cus.`firstname` as firstname,cusmsg.`date_add` as date_add,ord.`id_currency` as `id_currency` FROM `"._DB_PREFIX_."marketplace_shop_product` msp JOIN `"._DB_PREFIX_."marketplace_seller_product` mspro ON (mspro.`id` = msp.`marketplace_seller_id_product`) JOIN `"._DB_PREFIX_."marketplace_customer` mkc ON (mkc.`marketplace_seller_id` = mspro.`id_seller`) JOIN  `"._DB_PREFIX_."order_detail` ordd ON ( ordd.`product_id` = msp.`id_product`) JOIN  `"._DB_PREFIX_."orders` ord ON ( ordd.`id_order` = ord.`id_order`) JOIN `"._DB_PREFIX_."customer_thread` custh ON (custh.`id_order` = ord.`id_order`) join `"._DB_PREFIX_."customer_message` cusmsg ON (custh.`id_customer_thread` = cusmsg.`id_customer_thread`) join `"._DB_PREFIX_."customer` cus ON (cus.`id_customer` = custh.`id_customer`) where mkc.`id_customer` =".$customer_id);
					
							$count_msg =count($message);
							 							 
							$a=0;
							foreach($dashboard as $dashboard1)
							{
								$order_by_cus[]= Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("SELECT * from `"._DB_PREFIX_."customer` where id_customer=".$dashboard1['order_by_cus']);
								$currency_detail = Currency::getCurrency($dashboard1['id_currency']);
								$order_currency[] = $currency_detail['sign'];
								$a++;
							}
							 
								if(isset($order_by_cus))
								{
								if(is_array($order_by_cus))
									{
									$smarty->assign("order_by_cus", $order_by_cus);
									$smarty->assign("order_currency", $order_currency);
									}
								}
							
							 $link     = new link();
                              $param = array('flag'=>'1');
									$order_view_link = $link->getModuleLink('marketplace', 'marketplaceaccount',$param);
							$smarty->assign("order_view_link", $order_view_link);
		
		
                            $count          = count($dashboard);
                            $even_row_color = Configuration::get('even_row_color');
                            $odd_row_color  = Configuration::get('odd_row_color');
                            $heading_color  = Configuration::get('heading_color');
                           	 $smarty->assign("id_customer", $customer_id);
							 $smarty->assign("id_shop", $id_shop);
                            $recent_size    = Configuration::get('recent-size');
                            $smarty->assign("even_row_color", $even_row_color);
                            $smarty->assign("odd_row_color", $odd_row_color);
                            $smarty->assign("heading_color", $heading_color);
                          
                            $smarty->assign("recent_size", $recent_size);
                            $main_heading_color   = Configuration::get('main-heading-color');
                            $main_heading_family  = Configuration::get('main-heading-family');
                            $main_heading_size    = Configuration::get('main-heading-size');
                            $order_heading_size   = Configuration::get('order-heading-size');
                            $order_heading_family = Configuration::get('order-heading-family');
                            $order_row_size       = Configuration::get('order-row-size');
                            $order_row_family     = Configuration::get('order-row-family');
                            $smarty->assign("order_heading_size", $order_heading_size);
                            $smarty->assign("order_heading_family", $order_heading_family);
                            $smarty->assign("order_row_size", $order_row_size);
                            $smarty->assign("order_row_family", $order_row_family);
                            $smarty->assign("main_heading_size", $main_heading_size);
                            $smarty->assign("main_heading_family", $main_heading_family);
                            $smarty->assign("main_heading_color", $main_heading_color);
                            $smarty->assign("dashboard", $dashboard);
							$smarty->assign("message", $message);
							$smarty->assign("count_msg",$count_msg);
							
                            $smarty->assign("count", $count);
                            $this->setTemplate('marketplace_account1.tpl');
                        }
						
						elseif($logic == 5)						
						{
						$link = new link();
						$param = array('flag'=>'1');
						$payPro_link = $link->getModuleLink('marketplace','paymentprocess',$param);
						$pay_mode = Db::getInstance()->ExecuteS("SELECT * from `"._DB_PREFIX_."marketplace_payment_mode`");
						
						$check = Db::getInstance()->getRow("SELECT * from `"._DB_PREFIX_."marketplace_customer_payment_detail` where `id_customer`=".$customer_id."");
						if($check)
						{
							$payment_mode = Db::getInstance()->getRow("SELECT * from `"._DB_PREFIX_."marketplace_payment_mode` where `id`=".$check['payment_mode_id']."");
							
							$smarty->assign('payment_mode',$payment_mode['payment_mode']);
							$smarty->assign('payment_mode_details',$check['payment_detail']);
							$smarty->assign('payment_detail_exist',1);
						}	
						else
						{
							$smarty->assign('payment_detail_exist',0);
						}
						
						$smarty->assign("customer_id",$customer_id);
						$smarty->assign("pay_mode",$pay_mode);
						$smarty->assign("payPro_link",$payPro_link);
						$this->setTemplate('marketplace_account1.tpl');
						
						}
						
						elseif($logic ==6)
						{
							$id_order = $_GET['id_order'];
							$ord_obj = new Order($id_order);
							//	$id_order_detail = $_GET['id_order_detail'];
							$currency_detail = Currency::getCurrency($ord_obj->id_currency);
							
							$smarty->assign("order_currency", $currency_detail['sign']);
							$dashboard   = Db::getInstance()->executeS("SELECT cntry.`name` as `country`,stat.`name` as `state`,ads.`postcode` as `postcode`,ads.`city` as `city`,ads.`phone` as `phone`,ads.`phone_mobile` as `mobile`,ordd.`id_order_detail` as `id_order_detail`,ordd.`product_name` as `ordered_product_name`,ordd.`product_price` as total_price,ordd.`product_quantity` as qty, ordd.`id_order` as id_order,ord.`id_customer` as order_by_cus,ord.`payment` as payment_mode,ord.`current_state` as current_state,cus.`firstname` as name,cus.`lastname` as lastname,ord.`date_add` as `date`,ords.`name`as order_status,ads.`address1` as `address1`,ads.`address2` as `address2` from  `"._DB_PREFIX_."order_detail` ordd join `"._DB_PREFIX_."orders` ord ON (ord.`id_order` = ordd.`id_order`) join `"._DB_PREFIX_."customer` cus on (cus.`id_customer`= ord.`id_customer`) join `"._DB_PREFIX_."order_state_lang` ords on (ord.`current_state`= ords.`id_order_state`) join `"._DB_PREFIX_."address` ads on (ads.`id_customer`= cus.`id_customer`) join `"._DB_PREFIX_."state` stat on (stat.`id_state`= ads.`id_state`) join `"._DB_PREFIX_."country_lang` cntry on (cntry.`id_country`= ads.`id_country`) where ordd.`id_order`=".$id_order." and cntry.`id_lang`=".$id_lang);  
						
							if(empty($dashboard)) {
								$dashboard   = Db::getInstance()->executeS("SELECT cntry.`name` as `country`,ads.`postcode` as `postcode`,ads.`city` as `city`,ads.`phone` as `phone`,ads.`phone_mobile` as `mobile`,ordd.`id_order_detail` as `id_order_detail`,ordd.`product_name` as `ordered_product_name`,ordd.`product_price` as total_price,ordd.`product_quantity` as qty, ordd.`id_order` as id_order,ord.`id_customer` as order_by_cus,ord.`payment` as payment_mode,ord.`current_state` as current_state,cus.`firstname` as name,cus.`lastname` as lastname,ord.`date_add` as `date`,ords.`name`as order_status,ads.`address1` as `address1`,ads.`address2` as `address2` from  `"._DB_PREFIX_."order_detail` ordd join `"._DB_PREFIX_."orders` ord ON (ord.`id_order` = ordd.`id_order`) join `"._DB_PREFIX_."customer` cus on (cus.`id_customer`= ord.`id_customer`) join `"._DB_PREFIX_."order_state_lang` ords on (ord.`current_state`= ords.`id_order_state`) join `"._DB_PREFIX_."address` ads on (ads.`id_customer`= cus.`id_customer`) join `"._DB_PREFIX_."country_lang` cntry on (cntry.`id_country`= ads.`id_country`) where ordd.`id_order`=".$id_order." and cntry.`id_lang`=".$id_lang);  
								
								$dashboard_state = "N/A";
							} else {
								$dashboard_state = $dashboard[0]['state'];
							}
							$a=0;
							foreach($dashboard as $dashboard1)
							{
							$dash_price[] = number_format($dashboard1['total_price'], 2, '.', '');
							$a++;
							}
							$param = array('flag'=>$_GET['flag'],'shop'=>$_GET['shop'],'l'=>$_GET['l'],'id_order'=>$_GET['id_order']);
						
							$shipping_link = $link->getModuleLink('finalshipping','shippingdetails',$param);
						
							$current_state = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("SELECT `current_state` from `"._DB_PREFIX_."orders` where id_order=".$id_order);
							
							
							$order_info = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT * FROM `'._DB_PREFIX_.'order_detail` od JOIN `'._DB_PREFIX_.'product` p ON (p.id_product = od.product_id) JOIN `'._DB_PREFIX_.'product_shop` ps ON (ps.id_product = p.id_product AND ps.id_shop = od.id_shop) join `'._DB_PREFIX_.'marketplace_shop_product` msp ON (msp.`id_product`=p.`id_product`) WHERE od.`id_order` = '.$id_order);
							
							$smarty->assign("order_info",$order_info);
							
							//$smarty->assign("current_state",$current_state['current_state']);
							$count_dashboard = count($dashboard);
							$smarty->assign("shipping_link",$shipping_link); 
							$smarty->assign("dash_price",$dash_price);
							$smarty->assign("count_dashboard",$count_dashboard);
							$smarty->assign("dashboard",$dashboard);
							$smarty->assign("dashboard_state",$dashboard_state);
							$this->setTemplate('marketplace_account1.tpl');  
					}
						
			
						
                    }
                } elseif ($is_seller == 0) {
                    $smarty->assign("is_seller", $is_seller);
                    $even_row_color = Configuration::get('even_row_color');
                    $odd_row_color  = Configuration::get('odd_row_color');
                    $heading_color  = Configuration::get('heading_color');
                    
						
						
                    $recent_size    = Configuration::get('recent-size');
                    $smarty->assign("even_row_color", $even_row_color);
                    $smarty->assign("odd_row_color", $odd_row_color);
                    $smarty->assign("heading_color", $heading_color);
                  
                    $smarty->assign("recent_size", $recent_size);
                    $this->setTemplate('marketplace_account1.tpl');
                } // end of is_seller =2
            } else {
                //is_seller set to -1 when customer not request for market place yet 
                //@is_seller = 0 customer send requset for market place but admin not approve yet
                //@is_seller =1 admin approve market place seller request 
                $smarty->assign("is_seller", -1);
                $even_row_color = Configuration::get('even_row_color');
                $odd_row_color  = Configuration::get('odd_row_color');
                $heading_color  = Configuration::get('heading_color');
             
						
						
                $recent_size    = Configuration::get('recent-size');
                $smarty->assign("even_row_color", $even_row_color);
                $smarty->assign("odd_row_color", $odd_row_color);
                $smarty->assign("heading_color", $heading_color);
              
                $smarty->assign("recent_size", $recent_size);
                $this->setTemplate('marketplace_account1.tpl');
            }
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
		$this->addCSS(_MODULE_DIR_.'marketplace/css/my_request.css');
		$this->addJS(_PS_JS_DIR_.'tiny_mce/tiny_mce.js');
		//$this->addCSS(_MODULE_DIR_.'marketplace/js/jquerydatepicker/jquery-ui.css');
		$this->addJS(_MODULE_DIR_.'marketplace/js/jquerydatepicker/jquery-ui.js');
		$this->addJS(_MODULE_DIR_.'marketplace/js/jquerydatepicker/jquery-ui-sliderAccess.js');
		$this->addJS(_MODULE_DIR_.'marketplace/js/jquerydatepicker/jquery-ui-timepicker-addon.js');
		$this->addCSS(_MODULE_DIR_.'marketplace/js/jquerydatepicker/jquery-ui-timepicker-addon.css');
		
		

    }
}
?>