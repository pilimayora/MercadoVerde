<?php
if (!defined('_PS_VERSION_'))
    exit;
class marketplacecontactModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        global $cookie;
        global $smarty;
        $id_product = Tools::getValue('id');
        $link       = new link();
        if ($id_product != '') {
            $seller_shop_detail = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select `id_shop`,`marketplace_seller_id_product` from `" . _DB_PREFIX_ . "marketplace_shop_product` where id_product =" . $id_product . " ");
            if ($seller_shop_detail) {
                $id_shop                        = $seller_shop_detail['id_shop'];
                $market_place_seller_id_product = $seller_shop_detail['marketplace_seller_id_product'];
                $marketplace_sellr_product_info = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `" . _DB_PREFIX_ . "marketplace_seller_product` where `id` =" . $market_place_seller_id_product . " ");
                $seller_id                      = $marketplace_sellr_product_info['id_seller'];
                $marketplace_shop               = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select `shop_name`,`id_customer`,`about_us` from `" . _DB_PREFIX_ . "marketplace_shop` where `id` =" . $id_shop . " ");
                $shop_name                      = $marketplace_shop['shop_name'];
                $id_customer                    = $marketplace_shop['id_customer'];
                $about_us                       = $marketplace_shop['about_us'];
                $market_place_seller_info       = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `" . _DB_PREFIX_ . "marketplace_seller_info` where `id` =" . $seller_id . " ");
                $business_email                 = $market_place_seller_info['business_email'];
                $phone                          = $market_place_seller_info['phone'];
                $fax                            = $market_place_seller_info['fax'];
                $address                        = $market_place_seller_info['address'];
                $facebook_id                    = $market_place_seller_info['facebook_id'];
                $twitter_id                     = $market_place_seller_info['twitter_id'];
                $customer_info                  = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `" . _DB_PREFIX_ . "customer` where `id_customer` =" . $id_customer . " ");
				
				$param = array('id'=>$id_product);
                $link_store                     = $link->getModuleLink('marketplace', 'shopstore',$param);
                $link_collection                = $link->getModuleLink('marketplace', 'shopcollection',$param);
                $Seller_profile                 = $link->getModuleLink('marketplace', 'sellerprofile',$param);
                $link_conatct                   = $link->getModuleLink('marketplace', 'contact',$param);
                $cont_head_info_size            = Configuration::get('cont-head-info-size');
                $cont_head_info_color           = Configuration::get('cont-head-info-color');
                $cont_head_info_font_family     = Configuration::get('cont-head-info-font-family');
                $cont_border_color              = Configuration::get('cont-border-color');
                $smarty->assign("cont_border_color", $cont_border_color);
                $smarty->assign("cont_head_info_size", $cont_head_info_size);
                $smarty->assign("cont_head_info_color", $cont_head_info_color);
                $smarty->assign("cont_head_info_font_family", $cont_head_info_font_family);
                $cont_heading_size        = Configuration::get('cont-heading-size');
                $cont_heading_color       = Configuration::get('cont-heading-color');
                $cont_heading_font_family = Configuration::get('cont-heading-font-family');
                $smarty->assign("cont_heading_size", $cont_heading_size);
                $smarty->assign("cont_heading_color", $cont_heading_color);
                $smarty->assign("cont_heading_font_family", $cont_heading_font_family);
                $cont_size             = Configuration::get('cont-size');
                $cont_color            = Configuration::get('cont-color');
                $cont_font_family      = Configuration::get('cont-font-family');
                $cont_head_size        = Configuration::get('cont-head-size');
                $cont_head_color       = Configuration::get('cont-head-color');
                $cont_head_font_family = Configuration::get('cont-head-font-family');
                $smarty->assign("cont_head_size", $cont_head_size);
                $smarty->assign("cont_head_color", $cont_head_color);
                $smarty->assign("cont_head_font_family", $cont_head_font_family);
                $smarty->assign("cont_size", $cont_size);
                $smarty->assign("cont_color", $cont_color);
                $smarty->assign("cont_font_family", $cont_font_family);
                $smarty->assign("phone", $phone);
                $smarty->assign("facebook_id", $facebook_id);
                $smarty->assign("twitter_id", $twitter_id);
                $smarty->assign("fax", $fax);
                $smarty->assign("address", $address);
                $smarty->assign("business_email", $business_email);
                $smarty->assign("id_product", $id_product);
                $smarty->assign("link_conatct", $link_conatct);
                $smarty->assign("link_store", $link_store);
                $smarty->assign("link_collection", $link_collection);
                $smarty->assign("Seller_profile", $Seller_profile);
                $smarty->assign("id_shop", $id_shop);
                $smarty->assign("seller_id", $seller_id);
                $smarty->assign("shop_name", $shop_name);
                $smarty->assign("id_customer", $id_customer);
                $smarty->assign("market_place_seller_info", $market_place_seller_info);
                $smarty->assign("customer_info", $customer_info);
                $smarty->assign("about_us", $about_us);
                $smarty->assign("module_path", _MODULE_DIR_);
                $this->setTemplate('contact.tpl');
            } else {
                Tools::redirect(__PS_BASE_URI__ . 'pagenotfound');
            }
        } else {
            $id_shop = Tools::getValue('shop');
            if (!$id_shop) {
                $id_shop = Tools::getValue('id_shop');
            }
            if ($id_shop != '') {
                //if(isset($this->context->cookie->id_customer)) {
                $marketplace_shop = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select `shop_name`,`id_customer`,`about_us` from `" . _DB_PREFIX_ . "marketplace_shop` where `id` =" . $id_shop . " ");
                if ($marketplace_shop) {
                    $shop_name                  = $marketplace_shop['shop_name'];
                    $id_customer                = $marketplace_shop['id_customer'];
                    $about_us                   = $marketplace_shop['about_us'];
                    //	if($id_customer==$this->context->cookie->id_customer) {
                    $marketplace_seller_id_info = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select `marketplace_seller_id`,`is_seller` from `" . _DB_PREFIX_ . "marketplace_customer` where `id_customer` =" . $id_customer . " ");
                    if ($marketplace_seller_id_info) {
                        $is_seller_active      = $marketplace_seller_id_info['is_seller'];
                        $marketplace_seller_id = $marketplace_seller_id_info['marketplace_seller_id'];
                        if ($is_seller_active == 1) {
                            $market_place_seller_info = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `" . _DB_PREFIX_ . "marketplace_seller_info` where `id` =" . $marketplace_seller_id . " ");
                            if ($market_place_seller_info) {
                                $business_email    = $market_place_seller_info['business_email'];
                                $phone             = $market_place_seller_info['phone'];
                                $fax               = $market_place_seller_info['fax'];
                                $address           = $market_place_seller_info['address'];
                                $facebook_id       = $market_place_seller_info['facebook_id'];
                                $twitter_id        = $market_place_seller_info['twitter_id'];
                                $customer_info     = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `" . _DB_PREFIX_ . "customer` where `id_customer` =" . $id_customer . " ");
								
								$param = array('shop'=>$id_shop);
								
                                $link_collection   = $link->getModuleLink('marketplace', 'shopcollection',$param);
                                $link_store        = $link->getModuleLink('marketplace', 'shopstore',$param);
                                $Seller_profile    = $link->getModuleLink('marketplace', 'sellerprofile',$param);
                                $link_contact      = $link->getModuleLink('marketplace', 'contact',$param);
                                $cont_border_color = Configuration::get('cont-border-color');
                                $smarty->assign("cont_border_color", $cont_border_color);
                                $cont_head_info_size        = Configuration::get('cont-head-info-size');
                                $cont_head_info_color       = Configuration::get('cont-head-info-color');
                                $cont_head_info_font_family = Configuration::get('cont-head-info-font-family');
                                $smarty->assign("cont_head_info_size", $cont_head_info_size);
                                $smarty->assign("cont_head_info_color", $cont_head_info_color);
                                $smarty->assign("cont_head_info_font_family", $cont_head_info_font_family);
                                $cont_heading_size        = Configuration::get('cont-heading-size');
                                $cont_heading_color       = Configuration::get('cont-heading-color');
                                $cont_heading_font_family = Configuration::get('cont-heading-font-family');
                                $smarty->assign("cont_heading_size", $cont_heading_size);
                                $smarty->assign("cont_heading_color", $cont_heading_color);
                                $smarty->assign("cont_heading_font_family", $cont_heading_font_family);
                                $cont_size        = Configuration::get('cont-size');
                                $cont_color       = Configuration::get('cont-color');
                                $cont_font_family = Configuration::get('cont-font-family');
                                $smarty->assign("cont_size", $cont_size);
                                $smarty->assign("cont_color", $cont_color);
                                $smarty->assign("cont_font_family", $cont_font_family);
                                $cont_head_size        = Configuration::get('cont-head-size');
                                $cont_head_color       = Configuration::get('cont-head-color');
                                $cont_head_font_family = Configuration::get('cont-head-font-family');
                                $smarty->assign("cont_head_size", $cont_head_size);
                                $smarty->assign("cont_head_color", $cont_head_color);
                                $smarty->assign("cont_head_font_family", $cont_head_font_family);
                                $smarty->assign("phone", $phone);
                                $smarty->assign("fax", $fax);
                                $smarty->assign("business_email", $business_email);
                                $smarty->assign("address", $address);
                                $smarty->assign("facebook_id", $facebook_id);
                                $smarty->assign("twitter_id", $twitter_id);
                                $smarty->assign("id_shop", $id_shop);
                                $smarty->assign("seller_id", $marketplace_seller_id);
                                $smarty->assign("shop_name", $shop_name);
                                $smarty->assign("id_customer", $id_customer);
                                $smarty->assign("market_place_seller_info", $market_place_seller_info);
                                $smarty->assign("customer_info", $customer_info);
                                $smarty->assign("module_path", _MODULE_DIR_);
                                $smarty->assign("link_contact", $link_contact);
                                $smarty->assign("link_store", $link_store);
                                $smarty->assign("link_collection", $link_collection);
                                $smarty->assign("Seller_profile", $Seller_profile);
                                $smarty->assign("about_us", $about_us);
								$id_product=0;
								 $smarty->assign("id_product", $id_product);
                                $this->setTemplate('contact.tpl');
                            } else {
                                Tools::redirect(__PS_BASE_URI__ . 'pagenotfound');
                            }
                        } else {
                            // seller is deactivated by admin
                        }
                    } else {
                        Tools::redirect(__PS_BASE_URI__ . 'pagenotfound');
                    }
                    //} else {
                    //Tools::redirect(__PS_BASE_URI__.'pagenotfound');
                    //}
                } else {
                    Tools::redirect(__PS_BASE_URI__ . 'pagenotfound');
                }
                // } else {
                // Tools::redirect(__PS_BASE_URI__.'pagenotfound');
                // }					
            } else {
                Tools::redirect(__PS_BASE_URI__ . 'pagenotfound');
            }
        }
        parent::initContent();
    }
    public function setMedia()
    {
        parent::setMedia();
        $this->addCSS(_MODULE_DIR_ . 'marketplace/css/contact.css');
    }
}
?>