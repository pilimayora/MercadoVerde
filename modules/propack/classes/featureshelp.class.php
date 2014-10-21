<?php
/**
 * StorePrestaModules SPM LLC.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://storeprestamodules.com/LICENSE.txt
 *
 /*
 * 
 * @author    StorePrestaModules SPM <kykyryzopresto@gmail.com>
 * @category others
 * @package propack
 * @copyright Copyright (c) 2011 - 2014 SPM LLC. (http://storeprestamodules.com)
 * @license   http://storeprestamodules.com/LICENSE.txt
*/

class featureshelp {
	
	private $_name = 'propack';
	
	public function __construct(){
		$this->initContext();
	}
	
	private function initContext()
	{
	  if (version_compare(_PS_VERSION_, '1.5', '>'))
	    $this->context = Context::getContext();
	  else
	  {
	    global $smarty, $cookie;
	    $this->context = new StdClass();
	    $this->context->smarty = $smarty;
	    $this->context->cookie = $cookie;
	  }
	}
	
	public function saveOrder($data=null){
		$id_shop = $data['id_shop'];
		$data_product = $data['data']; 
		$customer_id = $data['customer_id'];
		$order_id = $data['order_id'];
		
		$sql = 'INSERT INTO `'._DB_PREFIX_.'reviewsnippets_data_order` 
			(id_shop, order_id, date_add, status, customer_id, data) 
			VALUES("' . $id_shop . '", 
				  "' . pSQL($order_id) . '", NOW(), "0", 
				  "' . pSQL($customer_id) . '", "' . pSQL(serialize($data_product)) . '")';

		return (
			Db::getInstance()->Execute($sql)
		);
	}

	public function isDataExist($data)
	{
		$id_shop = $data['id_shop'];
		$order_id = $data['order_id'];
		
		$sql = 'SELECT count(*) as count FROM `'._DB_PREFIX_.'reviewsnippets_data_order` 
						WHERE id_shop = ' . $id_shop . ' AND order_id = ' . $order_id;

		$count = Db::getInstance()->ExecuteS($sql);

		return (!empty($count[0]['count'])? true : false);
	}
	
	public function getStatus($data)
	{
		$id_shop = $data['id_shop'];
		$customer_id = $data['customer_id'];
		
		$sql = 'SELECT status FROM `'._DB_PREFIX_.'reviewsnippets_customer`  
					WHERE id_shop = ' . $id_shop . ' AND customer_id = ' . pSQL($customer_id);

		$result = 	Db::getInstance()->ExecuteS($sql);

		return (
			isset($result[0]['status'])? $result[0]['status'] : false
		);
	}
	
	public function addStatus($data)
	{
		$id_shop = $data['id_shop'];
		$customer_id = $data['customer_id'];
		$status = $data['status'];
		
		$sql = 'INSERT INTO `'._DB_PREFIX_.'reviewsnippets_customer` (id_shop, customer_id, status) 
				   VALUES(' . pSQL($id_shop) . ','. pSQL($customer_id) . ', "' . pSQL($status) . '")'
			.   ' ON DUPLICATE KEY UPDATE status = "' . pSQL($status) . '"';

		return (Db::getInstance()->Execute($sql));
	}
	
	public function getProductsInOrder($data)
	{
		$id_lang = $data['id_lang'];
		$order_id = $data['order_id'];
		
		$sql = 'SELECT p.*, pa.id_product_attribute,pl.*, i.*, il.*, m.name AS manufacturer_name, s.name AS supplier_name'
			.   ' FROM ' . _DB_PREFIX_ . 'order_detail as od '
			.	' LEFT JOIN ' . _DB_PREFIX_ . 'product as p ON p.id_product = od.product_id'
			.	' LEFT JOIN ' . _DB_PREFIX_ . 'product_attribute as pa ON (p.id_product = pa.id_product AND default_on = 1)'
			.   ' LEFT JOIN ' . _DB_PREFIX_ . 'product_lang as pl ON (p.id_product = pl.id_product AND pl.id_lang = ' . intval($id_lang) . ')'
			.	' LEFT JOIN ' . _DB_PREFIX_ . 'image as i ON (i.id_product = p.id_product AND i.cover = 1)'
			.	' LEFT JOIN ' . _DB_PREFIX_ . 'image_lang as il ON (i.id_image = il.id_image AND il.id_lang = ' . intval($id_lang) . ')'
			.   ' LEFT JOIN ' . _DB_PREFIX_ . 'manufacturer as m ON m.id_manufacturer = p.id_manufacturer'
			.   ' LEFT JOIN ' . _DB_PREFIX_ . 'supplier as s ON s.id_supplier = p.id_supplier'
			.   ' WHERE od.id_order = ' . $order_id;

		$data_products = Db::getInstance()->ExecuteS($sql);

		return $data_products;
	}
	
	public function deleteCronTasks($data)
	{
		$id_shop = $data['id_shop'];
		$delay = $data['delay'];
		$time = $data['time'];
		
		$sql = 'DELETE FROM `'._DB_PREFIX_.'reviewsnippets_data_order` 
					WHERE id_shop = ' . $id_shop . ' 
					AND ' . $time . ' >= (UNIX_TIMESTAMP(date_add) + ' . $delay . ')';

		unset($time);

		return (Db::getInstance()->Execute($sql));
	}
	
	public function getCronTasks($data)
	{
		$id_shop = $data['id_shop'];
		$delay = $data['delay'];
		$time = $data['time'];
		
		$sql = 'SELECT rdo.order_id, rdo.id_shop, rdo.data, c.email as email 
					FROM `'._DB_PREFIX_.'reviewsnippets_data_order` as rdo 
					LEFT JOIN `'._DB_PREFIX_.'reviewsnippets_customer` as rc 
					ON (rc.customer_id = rdo.customer_id and rc.status = "1")
					LEFT JOIN ' . _DB_PREFIX_ . 'customer as c ON c.id_customer = rdo.customer_id
					WHERE rdo.id_shop = ' . $id_shop . ' AND ' . $time . ' >= (UNIX_TIMESTAMP(rdo.date_add) + ' . $delay . ')
					ORDER BY rdo.order_id DESC';
		
		$data_cron = Db::getInstance()->ExecuteS($sql);

		unset($time);

		return $data_cron;
	}
	
	public function sendCronTab(){
		
		include_once(dirname(__FILE__).'/../propack.php');
		$obj = new propack();
		$data_translate = $obj->translateCustom();
			
		if(Configuration::get($this->_name.'reminder')==0)
			die($data_translate['review_reminder']);	
		
		$cookie = $this->context->cookie;
		$id_lang = (int)$cookie->id_lang;
		
		if(version_compare(_PS_VERSION_, '1.5', '>')){
			$id_shop = Context::getContext()->shop->id;
		} else {
			$id_shop = 0;
		}
		
		
		$time = time();

		$data_tasks = $this->getCronTasks( 
											array('id_shop'=>$id_shop,
												  'delay'=>Configuration::get($this->_name.'delay') * 86400,
												  'time' => $time
												 )
										 );
		//echo "<pre>"; var_dump($data_tasks); exit;
		if (!empty($data_tasks)) {
			
			
			$subject = Configuration::get($this->_name.'emailreminder_'.$id_lang);

			foreach ($data_tasks as $task) {
				$data_task = unserialize($task['data']);
				
				if (!empty($data_task) && is_array($data_task)) {
					
					$text = '';
					foreach ($data_task as $product ) {
					  $text .= $data_translate['category'] . ' : <strong>' . $product['category'] . '</strong><br/>'
							.  $data_translate['product'] . ' : <strong>' . $product['title'] . '</strong><br/><br/>'
							.  $data_translate['rate_post']  . ' <a href="' . $product['link'] . '" style="color:#DB3484; font-weight:bold; text-decoration:none;">' . $product['link'] . '</a>'  . '<br/><br/>' ;
					}
			
					
					$param = array(
						'subject'   => $subject,
						'email'     => $task['email'],
						'order_id'  => $task['order_id'],
						'id_shop'   => $task['id_shop'],
						'vars' => array(
										'{products_text}' 	=> $text,
										'{orderid}' => $task['order_id']
										) 
					);
					//echo "<pre>"; var_dump($param); echo "<br><hr><br>";
					$data_notification = array_merge($data_task, $param);

					unset($param);
					
					// send email
					$this->sendNotification($data_notification);

				}
			}
			
			echo $data_translate['sent_cron_items'].": ".sizeof($data_tasks)."\n\n";
			
			unset($data_tasks);
			
			// delete tasks
			
			 $this->deleteCronTasks( array('id_shop'=>$id_shop,
										  'delay'=>Configuration::get($this->_name.'delay') * 86400,
										  'time' => $time
										 )
									);

			echo $data_translate['delete_cron_items'].": ".Db::getInstance()->Affected_Rows()."\n\n";
			
		}
		else {
			echo $data_translate['no_sent_items']." \n\n";
		}

		
	}
	
	public function sendNotification($data){
			
			include_once(dirname(__FILE__).'/../propack.php');
			$obj = new propack();
			$data_translate = $obj->translateCustom();
			
			
			####
			$cookie = $this->context->cookie;
			
			$id_lang = intval($cookie->id_lang);	
			
			$iso_lng = Language::getIsoById(intval($id_lang));
			
			$dir_mails = _PS_MODULE_DIR_ . '/' . $this->_name . '/' . 'mails/';
			
			if (is_dir($dir_mails . $iso_lng . '/')) {
				$id_lang_current = $id_lang;
			}
			else {
				$id_lang_current = Language::getIdByIso('en');
			}
			####
			
			
			/* Email sending */
			Mail::Send($id_lang_current, 'customer-reminder', $data['subject'], $data['vars'], 
				 $data['email'], NULL, NULL, NULL, NULL, NULL, $dir_mails);
	}
}