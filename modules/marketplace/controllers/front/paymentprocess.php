<?php
	if (!defined('_PS_VERSION_'))
		exit();
	
	class marketplacePaymentprocessModuleFrontController extends ModuleFrontController {
		public function initContent() {
			parent::initContent();
			global $smarty;	
			global $cookie;
			$link = new link();
			$customer_id     = $this->context->cookie->id_customer;
			$redirect_link = $link->getModuleLink('marketplace','marketplaceaccount');
			if(Tools::getValue('edit_payment_details'))
			{
				$update = Db::getInstance()->execute("update `"._DB_PREFIX_."marketplace_customer_payment_detail` set `payment_mode_id` =".$_POST['payment_mode']." , `payment_detail`='".pSQL($_POST['payment_detail'])."' where `id_customer`=".$customer_id."");
				
				if($update)
					Tools::redirect($redirect_link);
			}
			else
			{
			
			$result = Db::getInstance()->insert('marketplace_customer_payment_detail', array(
						'id_customer' => $_POST['customer_id'],
						'payment_mode_id' => $_POST['payment_mode'],
						'payment_detail' => pSQL($_POST['payment_detail'])
						));
			if ($result)
            Tools::redirect($redirect_link);
			}
		}
	}
?>