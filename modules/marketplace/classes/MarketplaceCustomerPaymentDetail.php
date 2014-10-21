<?php
	class MarketplaceCustomerPaymentDetail extends ObjectModel{
		public $id;	
		public $id_customer;
			
		public $payment_mode_id;
		
		public $payment_detail;
				
		/**
	 * @see ObjectModel::$definition
	 */
		public static $definition = array(
			'table' => 'marketplace_customer_payment_detail',
			'primary' => 'id',
			'fields' => array(
				'id_customer' =>		array('type' => self::TYPE_INT, 'validate' => 'isInt'),
				'payment_mode_id' =>		array('type' => self::TYPE_INT, 'validate' => 'isInt'),
				'payment_detail' => array('type' => self::TYPE_STRING)
			),
		);
	}
?>