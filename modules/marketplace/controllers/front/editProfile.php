<?php
if (!defined('_PS_VERSION_'))
    exit;
include_once 'modules/marketplace/classes/MarketplaceClassInclude.php';
class marketplaceEditProfileModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        if (Tools::getValue('update_profile'))
            global $cookie;
        $customer_id      = $this->context->cookie->id_customer;
        $market_seller_id = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select `marketplace_seller_id` from `" . _DB_PREFIX_ . "marketplace_customer` where id_customer =" . $customer_id . "");

        if (isset($_POST['update_seller_name'])) {
            $seller_name = $_POST['update_seller_name'];
        }
        if (isset($_POST['update_shop_name'])) {
            $shop_name = $_POST['update_shop_name'];
        }
        if (isset($_POST['update_business_email'])) {
            $business_email = $_POST['update_business_email'];
        }
        if (isset($_POST['update_phone'])) {
            $phone = $_POST['update_phone'];
        }
        if (isset($_POST['update_fax'])) {
            $fax = $_POST['update_fax'];
        }
        if (isset($_POST['update_address'])) {
            $address = $_POST['update_address'];
        }
        if (isset($_POST['update_about_shop'])) {
            $about_us = trim($_POST['update_about_shop']);
        }
        if (isset($_POST['update_twitter_id'])) {
            $twitter_id = trim($_POST['update_twitter_id']);
        }
        if (isset($_POST['update_facbook_id'])) {
            $facebook_id = trim($_POST['update_facbook_id']);
        }
        if (isset($_POST['update_shop_logo'])) {
            $shop_logo = $_FILES['update_shop_logo']["tmp_name"];
        }
		$market_place_seller_info = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `" . _DB_PREFIX_ . "marketplace_seller_info` where id =" . $market_seller_id['marketplace_seller_id'] . "");
		if ($_FILES['update_shop_logo']["size"] != 0)
		{
		list($shop_width, $shop_height) = getimagesize($_FILES['update_shop_logo']['tmp_name']);
			if($shop_width != 200 || $shop_height != 200 )
			{
			 $link          = new link();
			 $param = array('shop'=>$id_shop);
			 $redirect_link = $link->getModuleLink('marketplace', 'marketplaceaccount',$param);
			  Tools::redirect($redirect_link.'&l=2&edit-profile&img_shop=1');
			}
		}
		if ($_FILES['update_seller_logo']["size"] != 0)
		{
		list($seller_width, $seller_height) = getimagesize($_FILES['update_seller_logo']['tmp_name']);
			if($seller_width != 200 || $seller_height != 200)
			{
			  $id_shop = $_POST['update_id_shop'];
			  $link          = new link();
			  $param = array('shop'=>$id_shop);
			 
			  $redirect_link = $link->getModuleLink('marketplace', 'marketplaceaccount',$param);
			  Tools::redirect($redirect_link.'&l=2&edit-profile&img_seller=1');
			}
            else 
            {
			  if ($_FILES['update_seller_logo']['error'] == 0) {
                $validExtensions1 = array(
                    '.jpg',
                    '.jpeg',
                    '.gif',
                    '.png'
                );
				
                $fileExtension1   = strrchr($_FILES['update_seller_logo']['name'], ".");
                if (in_array($fileExtension1, $validExtensions1)) {
                    $manipulator1        = new ImageManipulator($_FILES['update_seller_logo']['tmp_name']);
                    $newSellerImage           = $manipulator1->resample(200, 200);
                    $seller_new_logo_name = $market_seller_id['marketplace_seller_id'] . ".jpg";
                    $manipulator1->save('modules/marketplace/img/seller_img/' . $seller_new_logo_name);
                }
            }
            }			
		}
		
		
		
        
        $market_place_shop_name   = $market_place_seller_info['shop_name'];
        if ($_FILES['update_shop_logo']["size"] == 0) {
            if ($market_place_shop_name!=$shop_name) {
                $shop_prev_logo_name=$market_seller_id['marketplace_seller_id']."-".$market_place_shop_name;
                $shop_prev_logo_name1=glob('modules/marketplace/img/shop_img/'.$shop_prev_logo_name.'.*');
                $shop_image_path='modules/marketplace/img/shop_img/';
                $is_shop_image_exist=$shop_prev_logo_name1[0];
                if (file_exists($is_shop_image_exist)) {
                    $shop_new_logo_name = $market_seller_id['marketplace_seller_id']."-".$shop_name.".jpg";
                    rename($shop_image_path.$shop_prev_logo_name.'.jpg',$shop_image_path.$shop_new_logo_name);
                }
            }
        } else {
		    
			
			
            $shop_image_path      = 'modules/marketplace/img/shop_img/';
            $shop_prev_logo_name  = $market_seller_id['marketplace_seller_id']."-".$market_place_shop_name;
            $shop_prev_logo_name1 = glob($shop_image_path . $shop_prev_logo_name.'.*');
            $is_shop_image_exist  = $shop_prev_logo_name1[0];
            if (file_exists($is_shop_image_exist)) {
                unlink($shop_prev_logo_name1[0]);
            }
            if ($_FILES['update_shop_logo']['error'] == 0) {
                $validExtensions = array(
                    '.jpg',
                    '.jpeg',
                    '.gif',
                    '.png'
                );
                $fileExtension   = strrchr($_FILES['update_shop_logo']['name'], ".");
                if (in_array($fileExtension, $validExtensions)) {
                    $newNamePrefix      = time() . '_';
                    $manipulator        = new ImageManipulator($_FILES['update_shop_logo']['tmp_name']);
                    $newImage           = $manipulator->resample(200, 200);
                    $shop_new_logo_name = $market_seller_id['marketplace_seller_id'] . "-" . $shop_name . ".jpg";
                    $manipulator->save('modules/marketplace/img/shop_img/' . $shop_new_logo_name);
                }
            }
        }

        $obj_seller = new SellerInfoDetail($market_seller_id['marketplace_seller_id']);

        // var_dump(Tools::getValue('update_phone'));
        // die();
        $obj_seller->business_email = $business_email;
        $obj_seller->seller_name = $seller_name;
        $obj_seller->shop_name = $shop_name;
        $obj_seller->phone = Tools::getValue('update_phone');
        $obj_seller->fax = $fax;
        $obj_seller->address = $address;
        $obj_seller->facebook_id = $facebook_id;
        $obj_seller->twitter_id = $twitter_id;
        $obj_seller->save();


        $is_update     = Db::getInstance()->update('marketplace_shop', array(
            'shop_name' => $shop_name,
            'about_us' => $about_us
        ), 'id_customer=' . $customer_id);
        $link          = new link();
		$id_shop = $_POST['update_id_shop'];
		$param = array('shop'=>$id_shop);
		
		Hook::exec('actionUpdateshopExtrafield', array('marketplace_seller_id' => $market_seller_id['marketplace_seller_id']));
		$redirect_link1 = $link->getModuleLink('marketplace', 'marketplaceaccount',array('shop'=>$id_shop,'l'=>2,'update'=>1));
        $redirect_link2 = $link->getModuleLink('marketplace', 'marketplaceaccount',array('shop'=>$id_shop,'l'=>2,'update'=>0));
       
        if ($is_update) {
            Tools::redirect($redirect_link1);
        } else {
            Tools::redirect($redirect_link2);
        }
    }
    public function setMedia()
    {
        parent::setMedia();
        $this->addJS(_PS_JS_DIR_ . 'tiny_mce/tiny_mce.js');
        $this->addJS(_PS_JS_DIR_ . 'tinymce.inc.js');
    }
}
?>