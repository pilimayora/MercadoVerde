<?php
	class MarketplaceCustomer extends ObjectModel {
		public $id;	
		public $marketplace_seller_id;
			
		public $id_customer;
		
		public $is_seller;
				
		/**
	 * @see ObjectModel::$definition
	 */
		public static $definition = array(
			'table' => 'marketplace_customer',
			'primary' => 'id',
			'fields' => array(
				'marketplace_seller_id' =>		array('type' => self::TYPE_INT, 'validate' => 'isInt'),
				'id_customer' =>		array('type' => self::TYPE_INT, 'validate' => 'isInt'),
				'is_seller' =>		array('type' => self::TYPE_INT, 'validate' => 'isInt')
			),
		);
		
		public function insertMarketplaceCustomer($marketplace_seller_id,$id_customer) {
			$is_insert = Db::getInstance()->insert('marketplace_customer', array(
														'marketplace_seller_id' => (int) $marketplace_seller_id,
														'id_customer' => (int) $id_customer)
												);
			if($is_insert) {
				return true;
			} else {
				return false;
			}
		}
		public function insertActiveMarketplaceCustomer($marketplace_seller_id,$id_customer) {
			$is_insert = Db::getInstance()->insert('marketplace_customer', array(
														'marketplace_seller_id' => (int) $marketplace_seller_id,
														'id_customer' => (int) $id_customer,
														'is_seller' => 1)
												);
			if($is_insert) {
				return true;
			} else {
				return false;
			}
		}
		public function findMarketPlaceCustomer($id_customer) {
			$mp_customer_info = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `" . _DB_PREFIX_ . "marketplace_customer` where id_customer =".$id_customer ."");
			if(empty($mp_customer_info)) {
				return false;
			} else {
				return $mp_customer_info;
			}
		}
		
		public function findIsallCustomerSeller() {
			$customer_info = Db::getInstance()->executeS("SELECT cus.`id_customer`,cus.`email` FROM `"._DB_PREFIX_."customer` cus INNER JOIN `"._DB_PREFIX_."marketplace_customer` mcus ON ( cus.id_customer = mcus.id_customer )");
			if(empty($customer_info)) {
				return false;
			} else {
				return $customer_info;
			}
		}
		
	}
?>