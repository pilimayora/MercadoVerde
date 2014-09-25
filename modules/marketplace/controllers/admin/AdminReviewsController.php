<?php
include_once dirname(__FILE__).'/../../classes/Reviews.php';
class AdminReviewsController extends ModuleAdminController 
{

	public function __construct()
    {
	  $this->table = 'seller_reviews';
	  $this->className   = 'Reviews';
        //$this->list_no_link = true;
		$this->_defaultOrderBy = 'id_review';
			$this->addRowAction('view');
		$this->fields_list = array(
		    'id_review' => array(
				'title' => $this->l('Id'),
				'width' => 140
			),
			'id_customer' => array(
				'title' => $this->l('Customer'),
				'width' => 140
			),
			'customer_email' => array(
				'title' => $this->l('Customer Email'),
			    'width' => 140
			),
			
			'rating' => array(
				'title' => $this->l('Rating'),
				'width' => 25,
			),
			
			'review' => array(
				'title' => $this->l('Review'),
				'width' => 25,
			)
			
			

		);
		
		$this->identifier          = 'id_review';
        parent::__construct();
	}
	
	public function postProcess() {
		if($this->display == 'view')
		{
		  global $smarty;
		  $review_detail =  Db::getInstance()->getRow("SELECT * from `" . _DB_PREFIX_ . "seller_reviews` where id_review=" . $_GET["id_review"] . "");
		  
		  $customer_detail =  Db::getInstance()->getRow("SELECT * from `" . _DB_PREFIX_ . "customer` where id_customer=" . $review_detail["id_customer"] . "");
		  $customer_name = $customer_detail['firstname'].' '.$customer_detail['lastname'];
		  $smarty->assign('review_detail',$review_detail);
		  $smarty->assign('customer_name',$customer_name);
		}
		return parent::postProcess();
	}
	public function initToolbar() {
		
	}
}
?>