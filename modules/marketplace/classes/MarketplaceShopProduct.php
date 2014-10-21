<?php
	class MarketplaceShopProduct extends ObjectModel {
		public $id;	
		public $id_shop;
			
		public $id_product;
		
		public $marketplace_seller_id_product;
				
		/**
	 * @see ObjectModel::$definition
	 */
		public static $definition = array(
			'table' => 'marketplace_shop_product',
			'primary' => 'id',
			'fields' => array(
				'id_shop' =>		array('type' => self::TYPE_INT, 'validate' => 'isInt'),
				'id_product' =>		array('type' => self::TYPE_INT, 'validate' => 'isInt'),
				'marketplace_seller_id_product' =>		array('type' => self::TYPE_INT, 'validate' => 'isInt')
			),
		);
		
		public function add($autodate = true, $null_values = false)
		{
			if (!parent::add($autodate, $null_values))
				return false;
			return Db::getInstance()->Insert_ID();
		}
		
		public function update($null_values = false)
		{
			Cache::clean('getContextualValue_'.$this->id.'_*');
			$success = parent::update($null_values);
			return $success;
		}
		
		public function delete()
		{
			Db::getInstance()->execute('DELETE FROM `'._DB_PREFIX_ .'marketplace_shop_product` WHERE `id` = '.(int)$this->id);
			return parent::delete();
		}
		
		//shop id
		public function findShopIdByMpsid($marketplace_seller_id_product) {
			$shop_id = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select `id_shop` from "._DB_PREFIX_."marketplace_shop_product where marketplace_seller_id_product=".$marketplace_seller_id_product);
			if(empty($shop_id)) {
				return false;
			} else {
				return $shop_id['id_shop'];
			}
		}
		
		public function findMainProductIdByMppId($marketplace_seller_id_product) {
			$product_in = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from "._DB_PREFIX_."marketplace_shop_product where marketplace_seller_id_product=".$marketplace_seller_id_product);
			if(empty($product_in)) {
				return false;
			} else {
				return $product_in;
			}
		}		
	}
?>