<?php
if (!defined('_PS_VERSION_'))
    exit;
include_once dirname(__FILE__).'/../../classes/MarketplaceClassInclude.php';
class marketplaceAddproductprocessModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        global $cookie;
		$link = new link();
		$customer_id          = $this->context->cookie->id_customer;
        $obj_seller_product = new SellerProductDetail();
        $obj_mpshop = new MarketplaceShop();
		$obj_mp_customer = new MarketplaceCustomer();
		
		$marketplace_shop = $obj_mpshop->getMarketPlaceShopInfoByCustomerId($customer_id);
      	$mp_id_shop              = $marketplace_shop['id'];
		
		$marketplace_customer = $obj_mp_customer->findMarketPlaceCustomer($customer_id);
       
        $id_seller = $marketplace_customer['marketplace_seller_id'];
        
		$product_name = Tools::getValue('product_name');
		$short_description = Tools::getValue('short_description');
		$product_description = Tools::getValue('product_description');
		$product_price = Tools::getValue('product_price');
		$product_quantity = Tools::getValue('product_quantity');
		$product_category = Tools::getValue('product_category');		
		if($product_name) {
			
			if($product_name=='') {
				$add_product_link = $link->getModuleLink('marketplace','addproduct',array('shop'=>$mp_id_shop,'is_main_er'=>1));
					Tools::redirect($add_product_link);
			} else {
				$is_generic_name = Validate::isGenericName($product_name);
				if(!$is_generic_name) {
					$add_product_link = $link->getModuleLink('marketplace','addproduct',array('shop'=>$mp_id_shop,'is_main_er'=>2));
					Tools::redirect($add_product_link);
				}
			}
			
			if($short_description) {
				$is_celan_short_desc = Validate::isCleanHtml($short_description);
				if(!$is_celan_short_desc) {
					$add_product_link = $link->getModuleLink('marketplace','addproduct',array('shop'=>$mp_id_shop,'is_main_er'=>3));
					Tools::redirect($add_product_link);
				}
			} 
			
			if($product_description) {
				$is_celan_pro_desc = Validate::isCleanHtml($product_description);
				if(!$is_celan_pro_desc) {
					$add_product_link = $link->getModuleLink('marketplace','addproduct',array('shop'=>$mp_id_shop,'is_main_er'=>4));
					Tools::redirect($add_product_link);
				}
			}
			
			if($product_price!='') {
				$is_product_price = Validate::isPrice($product_price);
				if(!$is_product_price) {
					$add_product_link = $link->getModuleLink('marketplace','addproduct',array('shop'=>$mp_id_shop,'is_main_er'=>5));
					Tools::redirect($add_product_link);
				}
			} else {
				$product_price =0;
			}
			
			if($product_quantity!='') {
				$is_product_quantity = Validate::isUnsignedInt($product_quantity);
				if(!$is_product_quantity) {
					$add_product_link = $link->getModuleLink('marketplace','addproduct',array('shop'=>$mp_id_shop,'is_main_er'=>6));
					Tools::redirect($add_product_link);
				}
			} else {
				$add_product_link = $link->getModuleLink('marketplace','addproduct',array('shop'=>$mp_id_shop,'is_main_er'=>6));
					Tools::redirect($add_product_link);
			}
			
			if($product_category == false){
				$add_product_link = $link->getModuleLink('marketplace','addproduct',array('shop'=>$mp_id_shop,'is_main_er'=>7));
				Tools::redirect($add_product_link);
			}
			Hook::exec('actionBeforeAddproduct', array('mp_seller_id' => $id_seller));
			$approve_type = Configuration::getGlobalValue('PRODUCT_APPROVE');
			
			$obj_seller_product->id_seller = $id_seller;
			$obj_seller_product->price = $product_price;
			$obj_seller_product->quantity = $product_quantity;
			$obj_seller_product->product_name = $product_name;
			$obj_seller_product->description = $product_description;
			$obj_seller_product->short_description = $short_description;
			$obj_seller_product->id_category = $product_category[0];
			$obj_seller_product->ps_id_shop = $this->context->shop->id;
			$obj_seller_product->id_shop = $mp_id_shop;
			if($approve_type == 'admin'){
					$obj_seller_product->active = 0;
			}else{
				$active = true;
					$obj_seller_product->active = 1;
			}
			$obj_seller_product->save();	
			
			$seller_product_id = $obj_seller_product->id;
			
			//Add into category table
			$obj_seller_product_category = new SellerProductCategory();
			$obj_seller_product_category->id_seller_product = $seller_product_id;
			$obj_seller_product_category->is_default = 1;
			$i=0;
			foreach($product_category as $p_category){
				$obj_seller_product_category->id_category = $p_category;
				if($i != 0)
					$obj_seller_product_category->is_default = 0;
				$obj_seller_product_category->add();
				$i++;
			}
			//Close
			
			$address    = "modules/marketplace/img/product_img/";
			
			if(isset($_FILES["product_image"])) {
				if($_FILES["product_image"]['size']>0) {
					$length     = 6;
					$characters = "0123456789abcdefghijklmnopqrstuvwxyz";
					$u_id       = "";
					for ($p = 0; $p < $length; $p++) {
						$u_id .= $characters[mt_rand(0, strlen($characters))];
					}
					
					$result1    = Db::getInstance()->insert('marketplace_product_image', 
											array(
													'seller_product_id' => (int) $seller_product_id,
													'seller_product_image_id' => pSQL($u_id)
											));
					$image_name = $u_id . ".jpg";
					move_uploaded_file($_FILES["product_image"]["tmp_name"], $address . $image_name);
				}
			}
						
			if (isset($_FILES['images'])) {
				$other_images = $_FILES["images"]['tmp_name'];
				$count = count($other_images);
			} else {
				$count = 0;
			}
			
			
			for ($i = 0; $i < $count; $i++) {
				$length     = 6;
				$characters = "0123456789abcdefghijklmnopqrstuvwxyz";
				$u_other_id = "";
				for ($p = 0; $p < $length; $p++) {
					$u_other_id .= $characters[mt_rand(0, strlen($characters))];
				}
				$result2    = Db::getInstance()->insert('marketplace_product_image', array(
					'seller_product_id' => (int) $seller_product_id,
					'seller_product_image_id' => pSQL($u_other_id)
				));
				$image_name = $u_other_id . ".jpg";
				$address    = "modules/marketplace/img/product_img/";
				move_uploaded_file($other_images[$i], $address . $image_name);
			}
			if($seller_product_id){
						// if active, then entry of a product in ps_product table...
				if($active){
					$obj_seller_product = new SellerProductDetail();
					$image_dir = "modules/marketplace/img/product_img";
					// creating ps_product when admin setting is default
					$ps_product_id = $obj_seller_product->createPsProductByMarketplaceProduct($seller_product_id,$image_dir, $active);
					if($ps_product_id){
						// mapping of ps_product and mp_product id
						$mps_product_obj = new MarketplaceShopProduct();
						$mps_product_obj->id_shop = $mp_id_shop;
						$mps_product_obj->marketplace_seller_id_product = $seller_product_id;
						$mps_product_obj->id_product = $ps_product_id;
						$mps_product_obj->add();
					}
				}
						
			}
			Hook::exec('actionAddproductExtrafield', array('marketplace_product_id' => $seller_product_id));
			
			$param  = array('su' => 1,'shop' => $mp_id_shop);
			$redirect_link = $link->getModuleLink('marketplace', 'addproduct', $param);
			Tools::redirect($redirect_link);		
			} else {
				
				$add_product_link = $link->getModuleLink('marketplace','addproduct',array('shop'=>$mp_id_shop,'is_main_er'=>1));
						Tools::redirect($add_product_link);
			}
    }
}
?>