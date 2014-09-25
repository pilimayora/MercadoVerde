<?php
	class marketplace_product {
		//@id_shop is the marketplace shop id
		public function getLatestProductByShopId($id_shop) {
			
		}
		
		//@id_product is the id_product from ps_product table
		public function getMarketPlaceIdShopByIdProduct($id_product) {
			
		}
		
		//@id_product is the id_product from ps_product table
		public function getMarketPlaceShopProductDetail($id_product) {
			$marketplaceshopdetail = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `" . _DB_PREFIX_ . "marketplace_shop_product` where id_product =" . $id_product . " ");
			if(!empty($marketplaceshopdetail)) {
				return $marketplaceshopdetail;
			} else {
				return false;
			}
			
		}
		
		//@id is the id from marketplace seller product table
		public function getMarketPlaceShopProductDetailBYmspid($id) {
			$marketplaceshopdetail = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `" . _DB_PREFIX_ . "marketplace_shop_product` where marketplace_seller_id_product =" . $id . " ");
			if(!empty($marketplaceshopdetail)) {
				return $marketplaceshopdetail;
			} else {
				return false;
			}
			
		}
		
		//@id is marketplace product id
		public function getMarketPlaceProductInfo($id) {
			$marketplaceproductinfo = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `" . _DB_PREFIX_ ."marketplace_seller_product` where id =".$id);
			
			if(!empty($marketplaceproductinfo)) {
				return $marketplaceproductinfo;
			} else {
				return false;
			}
		}
		
		//where $id_shop is marketplace shop id
		public function getMarketPlaceShopDetail($id_shop) {
			$marketplaceshopdetail = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `" . _DB_PREFIX_ . "marketplace_shop` where id =".$id_shop);
			
			if(!empty($marketplaceshopdetail)) {
				return $marketplaceshopdetail;
			} else {
				return false;
			}
		}
		
		//join marketplace shop product
		
		public function findAllProductInMarketPlaceShop($id_shop,$orderby=false,$orderway=false) {
			if(!$orderby) {
				$orderby = 'product_name';
			}
			if(!$orderway) {
				$orderway = 'asc';
			}
			$marketplace_shop_product = Db::getInstance()->ExecuteS("SELECT * FROM `" . _DB_PREFIX_ . "marketplace_shop_product` msp join `" . _DB_PREFIX_ . "marketplace_seller_product` mslp on (msp.`marketplace_seller_id_product` = mslp.`id`) join `" . _DB_PREFIX_ . "product` p on (msp.`id_product`=p.`id_product`) where msp.`id_shop` =" . $id_shop . " order by mslp.`" . $orderby . "` " . $orderway . " ");
			
			if(!empty($marketplace_shop_product)) {
				return $marketplace_shop_product;
			} else {
				return false;
			}
		}
		
		public function unactiveImage($id) {
			 $unactive_image = Db::getInstance()->ExecuteS("select * from `"._DB_PREFIX_."marketplace_product_image` where seller_product_id=".$id." and active=0");
			 if(!empty($unactive_image)) {
				return $unactive_image;
			 } else {
				return false;
			 }
		}
		
		public function getProductsByOrderId($id_order)
		{
		   $product_list = Db::getInstance()->ExecuteS("select `product_id`,`product_quantity`  from `"._DB_PREFIX_."order_detail` where id_order=".$id_order."");
		   
		   if($product_list)
		    return $product_list;
		   else
             return false;		   
		}
		
		public function checkProduct($id_product)
		{
		  $check_product = Db::getInstance()->getRow("select `marketplace_seller_id_product`  from `"._DB_PREFIX_."marketplace_shop_product` where id_product=".$id_product."");
		  if($check_product)
		   return $check_product['marketplace_seller_id_product'];
		  else
           return false;		  
		}
		
		public function getSellerIdByProduct($mkt_product_id)
		{
		  $seller = Db::getInstance()->getRow("select *  from `"._DB_PREFIX_."marketplace_seller_product` where id=".$mkt_product_id."");
		  if($seller)
		   return $seller['id_seller'];
		  else
           return false;
		}
		
		public function getCustomerDetails()
		{
		  $customer = Db::getInstance()->getRow("select *  from `"._DB_PREFIX_."customer` where id=".$mkt_product_id."");
		}
		
		public function getCustomerIdBySellerId($id)
		{
		  $customer_id = Db::getInstance()->getRow("select `id_customer`  from `"._DB_PREFIX_."marketplace_customer` where `marketplace_seller_id`=".$id."");
		  if($customer_id)
		   return $customer_id['id_customer'];
          else
           return false;		  
		}
		
		public function getSellerInfo($id)
		{
		  $customer_info = Db::getInstance()->getRow("select `firstname`,`lastname`,`email`  from `"._DB_PREFIX_."customer` where `id_customer`=".$id."");
		  if($customer_info)
		   return $customer_info;
		  else
           return false;		  
		  
		}
		public function getProductInfo($id)
		{
		 $product_info = Db::getInstance()->getRow("select `name`  from `"._DB_PREFIX_."product_lang` where `id_product`=".$id." and `id_lang`=1");
		 if($product_info)
		  return $product_info;
		 else
          return false;		 
		}
		
		public function getCustomerInfo($id)
		{
		  $customer_info = Db::getInstance()->getRow("select *  from `"._DB_PREFIX_."customer` where `id_customer`=".$id."");
		  return $customer_info;
		}
		
		public function getDeliverAddress($id)
        {
		  $delivery_address = Db::getInstance()->getRow("select `id_address_delivery`  from `"._DB_PREFIX_."orders` where `id_order`=".$id."");
		  return $delivery_address['id_address_delivery'];
        }	

       public function getShippingInfo($id)
       {
	     $address = Db::getInstance()->getRow(" select * from `" . _DB_PREFIX_ . "address` where `id_address`=".$id."");
		 return $address;
       }	
       public function getState($id) 
       {
	     $state = Db::getInstance()->getRow(" select `name` from `" . _DB_PREFIX_ . "state` where `id_state`=".$id."");
		 return $state['name'];
       }
       public function getCountry($id) 
       {
	     $country = Db::getInstance()->getRow(" select `name` from `" . _DB_PREFIX_ . "country_lang` where `id_country`=".$id." and `id_lang`=1 ");
		 return $country['name'];
       }	   
	}
?>