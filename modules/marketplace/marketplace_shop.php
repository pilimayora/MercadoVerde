<?php
	class marketplace_shop {
		//where $id_shop is marketplace shop id
		public function getMarketPlaceShopDetail($id_shop) {
			$marketplaceshopdetail = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `" . _DB_PREFIX_ . "marketplace_shop` where id =".$id_shop);
			
			if(!empty($marketplaceshopdetail)) {
				return $marketplaceshopdetail;
			} else {
				return false;
			}
		}
		
		public function getMarketPlaceShopInfoByCustomerId($id_customer) {
			$shop_info = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `" . _DB_PREFIX_ . "marketplace_shop` where id_customer =".$id_customer);
			if(!empty($shop_info)) {
				return $shop_info;
			} else {
				return false;
			}
		}
	}
?>