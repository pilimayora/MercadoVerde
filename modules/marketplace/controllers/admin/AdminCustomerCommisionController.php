<?php
include_once dirname(__FILE__).'/../../classes/MarketplaceCommision.php';
class AdminCustomerCommisionController extends ModuleAdminController
{
    public function __construct()
    {
        $this->table     = 'marketplace_commision';
        $this->className = 'MarketplaceCommision';
        $this->addRowAction('edit');
        $this->addRowAction('add');
        $this->addRowAction('delete');
        $this->fields_list = array(
            'id' => array(
                'title' => $this->l('Id'),
                'align' => 'center',
                'width' => 25
            ),
            'customer_name' => array(
                'title' => $this->l('Customer Name'),
                'width' => 175
            ),
            'commision' => array(
                'title' => $this->l('Customer Commision'),
                'width' => 175
            )
        );
        $this->identifier  = 'id';
        parent::__construct();
    }
    public function postProcess()
    {
        global $cookie, $employee;
        if (!($obj = $this->loadObject(true)))
            return;
        elseif (Tools::isSubmit('submitupdatecommision')) {
            $this->submitupdatecommision($token);
        } elseif ($this->tabAccess['delete'] === '1' && Tools::isSubmit('deletemarketplace_commision')) {
            $this->deletecustomer();
        }
        return parent::postProcess();
    }
    public function deletecustomer()
    {
        global $currentIndex;
        $id  = Tools::getValue('id');
        $get = Db::getInstance()->Execute("DELETE from`" . _DB_PREFIX_ . "marketplace_commision` where id=" . $id);
        if ($get)
            Tools::redirectAdmin($currentIndex . '&conf=1&token=' . $this->token);
    }
    public function renderForm()
    {
        if ($this->display == 'add') {
            $customer_info = Db::getInstance()->executeS('SELECT (id_customer) FROM `' . _DB_PREFIX_ . 'customer` WHERE (id_customer NOT IN (SELECT customer_id FROM `' . _DB_PREFIX_ . 'marketplace_commision`))');
            $a             = 0;
            foreach ($customer_info as $customer_info1) {
                $customer_id[]   = $customer_info1['id_customer'];
             //   $customer_name[] = $customer_info1['firstname'];
                $a++;
            }
            $cust_name_count = count($customer_id);
            for ($i = 0; $i < $cust_name_count; $i++) {
                $cust_name[] = Db::getInstance()->getRow('SELECT * from ' . _DB_PREFIX_ . 'customer where id_customer=' . $customer_id[$i]);
            }
            $this->fields_form = array(
                'legend' => array(
                    'title' => $this->l('Enter Customer Commsion')
                ),
                'input' => array(
                    array(
                        'label' => $this->l('Select Customer'),
                        'name' => 'customer_name',
                        'type' => 'select',
                        'identifier' => 'id',
                        'options' => array(
                            'query' => $cust_name,
                            'id' => 'id_customer',
                            'name' => 'firstname'
                        )
                    ),
                    array(
                        'label' => $this->l('Commision'),
                        'name' => 'add',
                        'type' => 'hidden',
                        'value' => '1'
                    ),
                    array(
                        'label' => $this->l('Enter Customer Commision'),
                        'name' => 'new_Commision',
                        'type' => 'text',
                        'default' => '10',
                        'suffix' => $this->l('%')
                    )
                ),
                
                'submit' => array(
                    'title' => $this->l('   Save   '),
                    'class' => 'button'
                )
            );
			
			$this->fields_value = array(
                    'new_Commision' => '10',
                    'add' => '1'
                );
        } else if ($this->display == 'edit') {
            $id                = Tools::getValue('id');
            $com_data          = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("SELECT * from `" . _DB_PREFIX_ . "marketplace_commision` where id=" . $id);
            $cust_com          = $com_data['commision'];
            $cust_id           = $com_data['customer_id'];
            $cust_name         = Db::getInstance()->getRow('SELECT `firstname` from ' . _DB_PREFIX_ . 'customer where id_customer=' . $cust_id);
            $cust_name1        = $cust_name[0]['firstname'];
            $id                = Tools::getValue('id');
            $this->fields_form = array(
                'legend' => array(
                    'title' => $this->l('Edit Customer Commsion')
                ),
                'input' => array(
                    array(
                        'label' => $this->l('Customer Name'),
                        'name' => 'customer_name',
                        'type' => 'text'
                    ),
                    array(
                        'label' => $this->l(' Commision'),
                        'name' => 'edit',
                        'type' => 'hidden'
                    ),
                    array(
                        'label' => $this->l(' Commision'),
                        'name' => 'id_new',
                        'type' => 'hidden'
                    ),
                    array(
                        'label' => $this->l('Enter Customer Commision'),
                        'name' => 'customer_Commision',
                        'type' => 'text',
                        'suffix' => $this->l('%')
                    )
                ),
                
                'submit' => array(
                    'title' => $this->l('   Save   '),
                    'class' => 'button'
                )
            );
			$this->fields_value = array(
                    'customer_name' => $cust_name1,
                    'customer_Commision' => $cust_com,
                    'edit' => '1',
                    'id_new' => $id
                );
        }
        return parent::renderForm();
    }
    public function processSave()
    {
        global $currentIndex;
        $currentindex = $currentIndex;
		
		if (isset($_POST['add']))		{
        if ($_POST['add'] == "1") {
		
            if ($_POST['new_Commision'] == "") {
                $this->_errors[] = Tools::displayError('Fields Should not be Empty');
				
            } 
			elseif(!is_numeric($_POST['new_Commision']))

			{

			 $this->errors[] = Tools::displayError('Commision should be in Integer');

			 $this->display = 'add';

			}
			else {
                $cust_name1 = Db::getInstance()->getRow('SELECT `firstname` from ' . _DB_PREFIX_ . 'customer where id_customer=' . $_POST['customer_name']);
                $cust1_name = $cust_name1['firstname'];
                $insert1    = Db::getInstance()->insert('marketplace_commision', array(
                    'id' => 'null',
                    'customer_id' => (int) $_POST['customer_name'],
                    'commision' => (int) $_POST['new_Commision'],
                    'customer_name' => pSQL($cust1_name)
                ));
                if ($insert1)
                    Tools::redirectAdmin($currentIndex . '&conf=4&token=' . $this->token);
            }
        }
		
    }	elseif (isset($_POST['edit']))
	{
	if ($_POST['edit'] == "1") {
            if ($_POST['customer_Commision'] == "") {
                $this->_errors[] = Tools::displayError('Fields Should not be Empty');
            
			}
			elseif(!is_numeric($_POST['customer_Commision']))

			{

			

			 $this->errors[] = Tools::displayError('Commision should be in Integer');

			

			

			}
			else {
                $id     = Tools::getValue('id_new');
                $result = Db::getInstance()->update('marketplace_commision', array(
                    'commision' => $_POST['customer_Commision']
                ), 'id =' . $id);
                if ($result)
                    Tools::redirectAdmin($currentIndex . '&conf=4&token=' . $this->token);
            }
        }
		}
    }
} //class ends
?>