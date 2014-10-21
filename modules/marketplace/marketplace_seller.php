<?php
	class marketplace_seller {
		//@id_customer is id from ps_customer
		public function getMarketPlaceSellerIdByCustomerId($id_customer) {
			$isseller = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `" . _DB_PREFIX_ . "marketplace_customer` where id_customer =".$id_customer);
			if(!empty($isseller)) {
				return $isseller;
			} else {
				return false;
			}
		}
		
		public function getmarketPlaceSellerInfo($marketplace_sellerid) {
			$marketplace_sellerinfo = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `". _DB_PREFIX_."marketplace_seller_info` where id =". $marketplace_sellerid);
			
			if(!empty($marketplace_sellerinfo)) {
				return $marketplace_sellerinfo;
			} else {
				return false;
			}
		}
	}
?>