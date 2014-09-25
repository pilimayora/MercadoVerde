<?php
	class MarketplaceShop extends ObjectModel {
		public $id;
		public $id_customer;
		public $shop_name;
		public $link_rewrite;
		public $about_us;
		public $is_active;
		
		public static $definition = array(
			'table' => 'marketplace_shop',
			'primary' => 'id',
			'fields' => array(
				'id_customer' =>		array('type' => self::TYPE_INT, 'validate' => 'isInt'),
				'shop_name' => array('type' => self::TYPE_STRING),
				'link_rewrite' => array('type' => self::TYPE_STRING, 'validate' => 'isLinkRewrite', 'required' => true, 'size' => 128),
				'about_us' => array('type' => self::TYPE_STRING),
				'is_active' => array('type' => self::TYPE_BOOL,'validate' => 'isBool')
			),
		);
		
		public static function findMpSellerIdByShopId($id) {
			$mp_seller_id = Db::getInstance()->executeS("select  mc.`marketplace_seller_id` from "._DB_PREFIX_."marketplace_shop as ms LEFT JOIN "._DB_PREFIX_."marketplace_customer as mc ON (ms.`id_customer`=mc.`id_customer`)where ms.`id`=".$id);
			
			if(empty($mp_seller_id)) {
				return false;
			} else {
				return $mp_seller_id[0]['marketplace_seller_id'];
			}
		}
		
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