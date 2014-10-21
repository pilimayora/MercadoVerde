<?php
class MarketplaceCommisionCalc extends ObjectModel
{
	public $id;
	public $product_id;
	public $customer_id;
	public $customer_name;
	public $product_name;
	public $price;
	public $quantity;
	public $commision;	
	public $id_order;
	public $date_add;
	
	/**
	 * @see ObjectModel::$definition
	 */
	public static $definition = array(
		'table' => 'marketplace_commision_calc',
		'primary' => 'id',
		'fields' => array(
			'product_id' => array('type' => self::TYPE_INT,'required' => true),
			'customer_id' => array('type' => self::TYPE_INT,'required' => true),
			'customer_name' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true),
			'product_name' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true),
			'price' => 	array('type' => self::TYPE_FLOAT,'validate' => 'isPrice', 'required' => true),
			'quantity' => array('type' => self::TYPE_INT,'required' => true),
			'commision' => 	array('type' => self::TYPE_FLOAT,'validate' => 'isPrice', 'required' => true),
			'id_order' => array('type' => self::TYPE_INT,'required' => true),
			'date_add' => array('type' => self::TYPE_DATE,'validate' => 'isDateFormat'),
		),
	);
}