<?php
	include_once dirname(__FILE__).'/../../classes/MarketplaceCommision.php';
	class AdminCommisionSettingController extends ModuleAdminController {
    public function __construct()
    {
        $this->className = 'MarketplaceCommision';
        parent::__construct();
		
		$obj_comm = new MarketplaceCommision();
		$obj_comm->customer_id = 0;
		$glob_com = $obj_comm->findGlobalcomm();        
		if(!$glob_com) {
			$glob_com  = 10 ;
		}
		$customer_info = Customer::getCustomers();		
		
        $a           = 0;
        foreach ($customer_info as $cust1) {
            $cust11[] = array(
                'id' => $cust1['id_customer'],
                'name' => $cust1['firstname']
            );
            $a++;
        }
        $this->fields_options = array(
            'general' => array(
			
                'title' => $this->l('Global Commision'),
				'image' => _MODULE_DIR_.'marketplace/img/commision_setting.gif',
                'fields' => array(
                    'PS_CP_GLOBAL_COMMISION' => array(
                        'title' => $this->l('Enter Global Commision'),
                        'name' => 'PS_COMMISION_BOX',
                        'validation' => 'isInt',
                        'cast' => 'intval',
                        'type' => 'text',
                        'default' => '10',
                        'suffix' => $this->l('%')
                    )
                )
            ),
            'general1' => array(
                'title' => $this->l('Customer Commision '),
				'image' => _MODULE_DIR_.'marketplace/img/commision_setting.gif',
                'fields' => array(
                    'PS_COMMISION_CUSTOMER_BOX' => array(
                        'title' => $this->l('Select Customer'),
                        'validation' => 'isInt',
                        'cast' => 'intval',
                        'type' => 'select',
                        'list' => $cust11,
                        'identifier' => 'id'
                    ),
                    'PS_ENTER_CUSTOMER_BOX' => array(
                        'title' => $this->l('Enter Commision'),
                        'type' => 'text',
                        'name' => 'PS_COMMISION_CUST_BOX',
                        'suffix' => $this->l('%')
                    )
                ),
                'submit' => array(
                    'title' => $this->l('   Save   '),
                    'name' => 'submit_commision'
                )
            )
        );
    }
    public function postProcess()
    {
        global $cookie, $employee;
        if (!($obj = $this->loadObject(true)))
            return;
        if (Tools::isSubmit('submit_commision'))
            $this->add_commision();
        return parent::postProcess();
    }
    public function add_commision()
    {
        $global_com = $_POST['PS_CP_GLOBAL_COMMISION'];
        $cust_id    = $_POST['PS_COMMISION_CUSTOMER_BOX'];
        $cust_com   = $_POST['PS_ENTER_CUSTOMER_BOX'];
		$obj_comm = new MarketplaceCommision();
		$obj_comm->customer_id = $cust_id;
		$cust_name = $obj_comm->findAllCustomerInfo();
		
        $cust_name1 = $cust_name['firstname'];
        if (($cust_com != "") && ($global_com == "")) {
            $messages_cust = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('select `customer_id` from `' . _DB_PREFIX_ . 'marketplace_commision` where customer_id=' . $cust_id);
            if ($messages_cust == "") {
                $insert1 = Db::getInstance()->insert('marketplace_commision', array(
                    'id' => 'null',
                    'customer_id' => (int) $cust_id,
                    'commision' => (int) $cust_com,
                    'customer_name' => pSQL($cust_name1)
                ));
            } else {
                $message_cust_id = $messages_cust['customer_id'];
                $update1         = Db::getInstance()->update('marketplace_commision', array(
                    'commision' => $cust_com
                ), 'customer_id =' . $message_cust_id);
            }
        } elseif (($cust_com == "") && ($global_com != "")) {
            $messages = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('select * from `' . _DB_PREFIX_ . 'marketplace_commision` where customer_id=0');
            if ($messages == "") {
                $insert1     = Db::getInstance()->insert('marketplace_commision', array(
                    'id' => 'null',
                    'customer_id' => '0',
                    'commision' => (int) $global_com,
                    'customer_name' => 'global'
                ));
                $update_cong = Db::getInstance()->update('configuration', array(
                    'value' => $global_com
                ), 'name="PS_CP_GLOBAL_COMMISION"');
            } else {
                $update1     = Db::getInstance()->update('marketplace_commision', array(
                    'commision' => $global_com
                ), 'customer_id =0');
                $update_cong = Db::getInstance()->update('configuration', array(
                    'value' => $global_com
                ), 'name="PS_CP_GLOBAL_COMMISION"');
            }
        } elseif (($cust_com != "") && ($global_com != "")) {
            $messages_cust = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('select * from `' . _DB_PREFIX_ . 'marketplace_commision` where customer_id=' . $cust_id);
            //echo $messages_cust;
            if ($messages_cust == "") {
                $insert1 = Db::getInstance()->insert('marketplace_commision', array(
                    'id' => 'null',
                    'customer_id' => (int) $cust_id,
                    'commision' => (int) $cust_com,
                    'customer_name' => pSQL($cust_name1)
                ));
            } else {
                $message_cust_id = $messages_cust['customer_id'];
                $update_cong     = Db::getInstance()->update('marketplace_commision', array(
                    'commision' => $cust_com
                ), 'customer_id =' . $message_cust_id);
            }
            $messages = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('select * from `' . _DB_PREFIX_ . 'marketplace_commision` where customer_id=0');
            if ($messages == "") {
                $insert1     = Db::getInstance()->insert('marketplace_commision', array(
                    'id' => 'null',
                    'customer_id' => '0',
                    'commision' => (int) $global_com,
                    'customer_name' => 'global'
                ));
                $update_cong = Db::getInstance()->update('configuration', array(
                    'value' => $global_com
                ), 'name ="PS_CP_GLOBAL_COMMISION"');
            } else {
                $update1     = Db::getInstance()->update('marketplace_commision', array(
                    'commision' => $global_com
                ), 'customer_id =0');
                $update_cong = Db::getInstance()->update('configuration', array(
                    'value' => $global_com
                ), 'name ="PS_CP_GLOBAL_COMMISION"');
            }
        }
        $link = $this->context->link->getAdminLink('AdminCommisionSetting');
        Tools::redirectAdmin("$link");
    }
} //class ends
?>