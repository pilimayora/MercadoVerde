<?php
	class feedback extends AdminController {
		public function __construct() {
			$this->table       = 'customer_message';
			$this->className   = 'feedback';
			$this->lang        = false;
			$this->list_no_link = true;
		    $this->context     = Context::getContext();
			$lang_id = $this->context->language->id;
			$id_customer = $this->context->cookie->id_customer;
			/*$this->_select = 'a.`id_message` as id_message,a.`message` as message,cus.`firstname` as firstname,a.`date_add` as date_add,ordd.`product_name` as product_name,ordd.`product_quantity` as quantity';
			$this->_join .= 'LEFT JOIN `'._DB_PREFIX_.'customer` cus ON (cus.`id_customer` = a.`id_customer`)';
			$this->_join .= 'LEFT JOIN `'._DB_PREFIX_.'orders` ord ON (ord.`id_cart` = a.`id_cart`)';
			$this->_join .= 'LEFT JOIN `'._DB_PREFIX_.'order_detail` ordd ON (ordd.`id_order` = ord.`id_order`)';
			$this->_where = 'AND a.`id_customer` = 12';*/
			
			$this->_select = 'a.`id_customer_message` as id_message,a.`message` as message,cus.`firstname` as firstname,a.`date_add` as date_add,ordd.`product_name` as product_name,ordd.`product_quantity` as quantity';
			$this->_join .= 'LEFT JOIN `'._DB_PREFIX_.'customer_thread` custh ON (custh.`id_customer_thread` = a.`id_customer_thread`)';
			$this->_join .= 'LEFT JOIN `'._DB_PREFIX_.'customer` cus ON (cus.`id_customer` = custh.`id_customer`)';
			//$this->_join .= 'LEFT JOIN `'._DB_PREFIX_.'orders` ord ON (ord.`id_order` = custh.`id_order`)';
			$this->_join .= 'LEFT JOIN `'._DB_PREFIX_.'order_detail` ordd ON (ordd.`id_order` = custh.`id_order`)';
			//$this->_where = 'AND custh.`id_customer` = 12';
			

			$this->fields_list = array(
				'id_message' => array(
					'title' => $this->l('Id'),
					'align' => 'center',
					'width' => 25
				),
				'firstname' => array(
					'title' => $this->l('Customer Name'),
					'align' => 'center',
					'width' => 75
				),
				
				'product_name' => array(
					'title' => $this->l('Product Name'),
					'align' => 'center',
					'width' => 100
				),
				'quantity' => array(
					'title' => $this->l('Product Quantity'),
					'align' => 'center',
					'width' => 25
				),
				'message' => array(
					'title' => $this->l('Customer Feedback'),
					'align' => 'center',
					'width' => 300
				),
				'date_add' => array(
					'title' => $this->l('Date Add'),
					'align' => 'center',
					'width' => 100
				)
			);
			$this->identifier  = 'id_customer_message';
			parent::__construct();
		}
		
		public function initToolbar() {
		}	
		
		public function postProcess() {
			if (!($obj = $this->loadObject(true)))
				return;
			parent::postProcess();
		}
	
	}
?>