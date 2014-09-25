<?php
if (!defined('_PS_VERSION_'))
    exit;
include_once 'modules/marketplace/classes/MarketplaceClassInclude.php';
class marketplaceRegistrationprocessModuleFrontController extends ModuleFrontController {
    public function initContent() {
        global $cookie;
        $date1   = date("y-m-d");
		if(isset($_FILES['upload_logo'])) {
			list($width, $height) = getimagesize($_FILES['upload_logo']['tmp_name']);
			if($width ==0 ||  $height == 0) {
				$flag=1;
			} else if($width == 200 || $height == 200) {
				$flag=1;
			} else {
				$flag=-1;
			}
		} else {
			$falg==1;
		}
		
		if($flag==1) {
			if(isset($_POST['business_email_id'])) {
				$bussiness_email = $_POST['business_email_id'];
			}
			else {
				$bussiness_email = NULL;
			}
		
			if(isset($_POST['fb_id'])) {
				$fb_id = $_POST['fb_id'];
			}
			else {
				$fb_id = NULL;
			}
		
			if(isset($_POST['tw_id'])) {
				$tw_id = $_POST['tw_id'];
			}
			else {
				$tw_id = NULL;
			}
		
			if(isset($_POST['fax'])) {
				$fax = $_POST['fax'];
			}
			else {
				$fax = NULL;
			}
		
			if(isset($_POST['about_business'])) {
				$about_business = $_POST['about_business'];
			}
			else {
				$about_business = NULL;
			}
		
			if(isset($_POST['address'])) {
				$address = $_POST['address'];
			}
			else {
				$address = NULL;
			}
			$obj_seller_detail = new SellerInfoDetail();
			$marketplace_seller_id = $obj_seller_detail->insertSellerDetail($date1,$bussiness_email,$_POST['shop_name'],$_POST['person_name'],$_POST['phone'],$address,$about_business,$fax,$fb_id,$tw_id);
			
			$customer_id = $this->context->cookie->id_customer;

			//for checking
			
			$obj_marketplace_cus = new MarketplaceCustomer();
			$approve_type = Configuration::getGlobalValue('SELLER_APPROVE');
			if($approve_type == 'admin'){
				$is_mpcustomer_insert = $obj_marketplace_cus->insertMarketplaceCustomer($marketplace_seller_id,$customer_id);
			}else{
				// creating seller shop when admin setting is default
				$is_mpcustomer_insert = $obj_marketplace_cus->insertActiveMarketplaceCustomer($marketplace_seller_id,$customer_id);
					if($is_mpcustomer_insert){
						$obj_seller_detail->make_seller_patner($marketplace_seller_id);
					}
			}
			
			
		
			if(isset($_POST['upload_logo'])) {
				$seller_shop_image     = $_POST['upload_logo'];
			}
			else {
				$seller_shop_image     = NULL;
			}
			
			$image_name            = $_POST['shop_name'] . ".jpg";
       
			$filename              = $_FILES["upload_logo"]["tmp_name"];
			if ($_FILES['upload_logo']['error'] > 0) {
				//error
			} else {
				$validExtensions = array(
					'.jpg',
					'.jpeg',
					'.gif',
					'.png'
				);
				$fileExtension   = strrchr($_FILES['upload_logo']['name'], ".");
				if (in_array($fileExtension, $validExtensions)) {
					$newNamePrefix = time() . '_';
					$manipulator   = new ImageManipulator($_FILES['upload_logo']['tmp_name']);
					$newImage      = $manipulator->resample(200, 200);
					$manipulator->save('modules/marketplace/img/shop_img/' . $marketplace_seller_id . '-' . $image_name);
				}
			}
			Hook::exec('actionAddshopExtrafield', array('marketplace_seller_id' => $marketplace_seller_id));
			
			$link          = new link();
			$redirect_link = $link->getModuleLink('marketplace','sellerrequest');
			
			if ($result && $result1) {
				Tools::redirect($redirect_link);
			} else {
				Tools::redirect($redirect_link);
			}	
		}
		else {
			$link          = new link();
			$param = array('img_size_error'=>1);
			$redirect_link = $link->getModuleLink('marketplace','sellerrequest',$param);
			Tools::redirect($redirect_link);
		}  	
    }
}
?>