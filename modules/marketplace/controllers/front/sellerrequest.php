<?php
if (!defined('_PS_VERSION_'))
    exit;
	
include_once 'modules/marketplace/classes/MarketplaceClassInclude.php';

class marketplaceSellerrequestModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        global $cookie;
        global $smarty;
		if(isset($_GET['img_size_error']))
		{
		  if($_GET['img_size_error'] == 1)
		  {
		    $smarty->assign('img_size_error',1);
		    $this->setTemplate('registration.tpl');
		  }
		}else{
			$smarty->assign('img_size_error',0); // added by ravi
		}
        if (isset($this->context->cookie->id_customer)) {
            $customer_id     = $this->context->cookie->id_customer;
			$obj_marketplace_cus = new MarketplaceCustomer();
			$already_request = $obj_marketplace_cus->findMarketPlaceCustomer($customer_id);
            if ($already_request) {
                $is_seller = $already_request['is_seller'];
                $link      = new link();
                $new_link3 = $link->getModuleLink('marketplace','addproduct');
                $smarty->assign("new_link3", $new_link3);
                $smarty->assign("login", "1");
                $smarty->assign("is_seller", $is_seller);
                $this->setTemplate('already_registration.tpl');
            } else {
                $req_border_color        = Configuration::get('req-border-color');
                $req_heading_font_family = Configuration::get('req-heading-font-family');
                $req_heading_color       = Configuration::get('req-heading-color');
                $req_heading_size        = Configuration::get('req-heading-size');
                $req_text_font_family    = Configuration::get('req-text-font-family');
                $req_text_color          = Configuration::get('req-text-color');
                $req_text_size           = Configuration::get('req-text-size');
                $smarty->assign("req_border_color", $req_border_color);
                $smarty->assign("req_heading_font_family", $req_heading_font_family);
                $smarty->assign("req_heading_color", $req_heading_color);
                $smarty->assign("req_heading_size", $req_heading_size);
                $smarty->assign("req_text_font_family", $req_text_font_family);
                $smarty->assign("req_text_color", $req_text_color);
                $smarty->assign("req_text_size", $req_text_size);
                $link      = new link();
                $new_link2 = $link->getModuleLink('marketplace', 'registrationprocess');
                $smarty->assign("new_link2", $new_link2);
                $smarty->assign("login", "1");
                $this->setTemplate('registration.tpl');
            }
        } else {
            $smarty->assign("login", "0");
            $this->setTemplate('already_registration.tpl');
        }
		
        parent::initContent();
    }
    public function setMedia()
    {
        parent::setMedia();
        $this->addCSS(_MODULE_DIR_ . 'marketplace/css/registration.css');
        $this->addJS(_PS_JS_DIR_ . 'tiny_mce/tiny_mce.js');
        $this->addJS(_PS_JS_DIR_ . 'tinymce.inc.js');
    }
}
?>