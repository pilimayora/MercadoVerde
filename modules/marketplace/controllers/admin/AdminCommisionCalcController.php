<?php
include_once dirname(__FILE__).'/../../classes/MarketplaceCommision.php';
class AdminCommisionCalcController extends ModuleAdminController
{
    public function __construct()
    {
        $this->table       = 'marketplace_commision_calc';
        $this->className   = 'MarketplaceCommision';
		//$id_customer = $this->context->cookie->id_customer;
		 $this->_select   = 'pm.`payment_mode` as `payment_mode`';
		$this->_join .= 'LEFT JOIN `'._DB_PREFIX_.'marketplace_customer_payment_detail` cpd ON (cpd.`id_customer` = a.`customer_id`) ';
 		$this->_join .= 'LEFT JOIN `'._DB_PREFIX_.'marketplace_payment_mode` pm ON (cpd.`payment_mode_id` = pm.`id`) ';
    	//$this->_where .='AND cpd.`id` =a.`id`';
	
        $this->fields_list = array(
            'id' => array(
                'title' => $this->l('Id'),
                'align' => 'center',
                'width' => 25
            ),
			'product_name' => array(
                'title' => $this->l('Product Name'),
                'width' => 125
            ),
			
			 'customer_name' => array(
                'title' => $this->l('Seller Name'),
                'width' => 125
            ),
			    'price' => array(
                'title' => $this->l('Product Price'),
                'width' => 120
            ),
			
			 'commision' => array(
                'title' => $this->l('Product Commission'),
                'width' => 120
            ),
			  'payment_mode' => array(
                'title' => $this->l('Seller Payment Mode'),
                'width' => 125
            ),
			
        );
		
		$this->list_no_link = true;
        $this->identifier  = 'id';
        parent::__construct();
    }
	
    public function postProcess()
    {
        global $cookie, $employee;
        // if (!($obj = $this->loadObject(true)))
            // return;
        return parent::postProcess();
    }
	
	 public function initToolbar()
	{
	}
} //class ends
?>