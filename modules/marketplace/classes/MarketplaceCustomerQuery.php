<?php
	class MarketplaceCustomerQuery extends ObjectModel {
		
		public $id;
		public $id_product;
		public $title;
		public $id_customer;
		public $id_customer_to;
		public $description;
		public $cust_email;
		public $status;
		public $timestamp;
		
		public static $definition = array(
			'table' => 'customer_query',
			'primary' => 'id',
			'fields' => array(
				'id_product' =>		array('type' => self::TYPE_INT, 'validate' => 'isInt'),
				'title' => array('type' => self::TYPE_STRING),
				'id_customer' =>		array('type' => self::TYPE_INT, 'validate' => 'isInt'),
				'id_customer_to' =>		array('type' => self::TYPE_INT, 'validate' => 'isInt'),
				'description' => array('type' => self::TYPE_STRING),
				'cust_email' => array('type' => self::TYPE_STRING, 'validate' => 'isEmail', 'required' => true, 'size' => 128),
				'status' => array('type' => self::TYPE_BOOL,'validate' => 'isBool'),
				'timestamp' => array('type' => self::TYPE_STRING),				
			),
		);
	}
?>