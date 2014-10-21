<?php
class MarketplaceCommision extends ObjectModel
{
	public $id;
	public $commision;
	public $customer_id;
	public $customer_name;
	
	/**
	 * @see ObjectModel::$definition
	 */
	public static $definition = array(
		'table' => 'marketplace_commision',
		'primary' => 'id',
		'fields' => array(
			'commision' => array('type' => self::TYPE_INT,'required' => true),
			'customer_id' => array('type' => self::TYPE_INT,'required' => true),
			'seller_name' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true),
			'customer_name' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true),
			
		),
	);
	
	public function findGlobalcomm() {
		$globlacomm = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('select * from `' . _DB_PREFIX_ . 'marketplace_commision` where customer_id='.$this->customer_id);
		if(empty($globlacomm)) {
			return false;
		} else {
			return $globlacomm['commision'];
		}
	}
	
	public function findAllCustomerInfo() {
		$customer_info  = Db::getInstance()->executeS('select * from `' . _DB_PREFIX_ . 'customer` where `id_customer`='.$this->customer_id);
		if(empty($customer_info)) {
			return false;
		} else {
			return $customer_info;
		}
	}
}