<?php
	class MarketplaceProductImage extends ObjectModel{
		public $id;	
		public $seller_product_id;
			
		public $seller_product_image_id;
		
		public $active;
				
		/**
	 * @see ObjectModel::$definition
	 */
		public static $definition = array(
			'table' => 'marketplace_product_image',
			'primary' => 'id',
			'fields' => array(
				'seller_product_id' =>		array('type' => self::TYPE_INT, 'validate' => 'isInt'),
				'seller_product_image_id' => array('type' => self::TYPE_STRING),
				'active' => array('type' => self::TYPE_BOOL,'validate' => 'isBool')
			),
		);
		
		public function add($autodate = false, $null_values = false)
		{
			if (!parent::add($autodate, $null_values))
				return false;
			
		}
		public function findProductImageByMpProId($id) {
			$product_image = Db::getInstance()->executeS("select  * from "._DB_PREFIX_."marketplace_product_image where seller_product_id=".$id);
			if(!empty($product_image)) {
				return $product_image;
			} else {
				return false;
			}
		}
	}
?>