<?php
class MarketPaymentMode extends ObjectModel
{
	public $id;
	public $payment_mode;
		
	public static $definition = array(
		'table' => 'marketplace_payment_mode',
		'primary' => 'id',
		'fields' => array(
			'payment_mode' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true),
			
		),
	);
}