<?php
include_once dirname(__FILE__).'/../../classes/MarketplaceCommision.php';
include_once dirname(__FILE__).'/../../classes/MarketPaymentMode.php';

class AdminPaymentModeController extends ModuleAdminController
{
	public function __construct()
    {
      	$this->table     = 'marketplace_payment_mode';
        $this->className = 'MarketPaymentMode';
       
        $this->fields_list = array(
            'id' => array(
                'title' => $this->l('Id'),
                'align' => 'center',
                'width' => 25
            ),
            'payment_mode' => array(
                'title' => $this->l('Payment Mode'),
                'width' => 175
            )
          
        );
        $this->identifier  = 'id';
        parent::__construct();

	}
	
	public function renderList(){
		
			$this->addRowAction('edit');
			$this->addRowAction('delete');
			return parent::renderList();
	}	
	
	public function renderForm(){
		
			$this->fields_form = array(
			
			  'legend' => array(       
				'title' => $this->l('Edit Payment Mode')        
			  ), 
			  
			  'input' => array(       
				array(           
				  'type' => 'text',
				  'name' => 'payment_mode',
				  'label' => $this->l('Payment Mode'),
				  'required' => true
				 ),
			  ),
			  
			  'submit' => array(
					'title' => $this->l('Save'),
					'class' => 'button'
				)
			);
			
			return parent::renderForm();
	}
	
}