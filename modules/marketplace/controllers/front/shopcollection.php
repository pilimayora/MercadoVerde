<?php
if (!defined('_PS_VERSION_'))
    exit;
include_once 'modules/marketplace/marketplace_product.php';
include_once 'modules/marketplace/marketplace_seller.php';
include_once 'modules/marketplace/marketplace_shop.php';

class marketplaceshopcollectionModuleFrontController extends ModuleFrontController {
    public function initContent() {
        global $cookie;
        global $smarty;
		 $link            = new link();
		
		if(isset($_GET['orderby'])) {
			$orderby  = $_GET['orderby'];
        }
		else {
			$orderby  = 'product_name';
		}
		
		if(isset($_GET['orderway'])) {
			$orderway  = $_GET['orderway'];
        }
		else {
			$orderway  = 'asc';
		}
		
		if ($orderby == 'name') {
            $orderby = 'product_name';
        } elseif ($orderby == '') {
            $orderby = 'product_name';
        }
        if ($orderway == '') {
            $orderway = 'asc';
        }
		
        $id_product = Tools::getValue('id');
        
		$obj_marketplace_product = new marketplace_product();
		$obj_marketplace_seller = new marketplace_seller();
		$obj_marketplace_shop = new marketplace_shop();
		if ($id_product != '') {
			$marketplace_shop_id = $obj_marketplace_product->getMarketPlaceShopProductDetail($id_product);
          
            $marketplace_id_shop = $marketplace_shop_id['id_shop'];
            $smarty->assign("id_product1", $id_product);
			
			$marketplace_shop_product = $obj_marketplace_product->findAllProductInMarketPlaceShop($marketplace_id_shop,$orderby,$orderway);
           
        } else {
            $id_shop = Tools::getValue('shop');
            if (!$id_shop) {
			
                $id_shop = Tools::getValue('id_shop');
            }
            if ($id_shop != '') {
				$id_product =0;
				$smarty->assign("id_product1", $id_product);
                $smarty->assign("id_shop1", $id_shop);
				
				$marketplace_shop_product = $obj_marketplace_product->findAllProductInMarketPlaceShop($id_shop,$orderby,$orderway);
            } else {
                Tools::redirect(__PS_BASE_URI__ . 'pagenotfound');
                return;
            }
        }
        if ($marketplace_shop_product) {
            $a = 0;
            foreach ($marketplace_shop_product as $marketplace_shop_product1) {
                $marketplace_product_id[] = $marketplace_shop_product1['id_product'];
                $marketplace_seller_id    = $marketplace_shop_product1['id_seller'];
                $a++;
            }
            $count = count($marketplace_product_id);
            for ($i = 0; $i < $count; $i++) {
                $product[] = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `" . _DB_PREFIX_ . "product` where id_product =" . $marketplace_product_id[$i] . " ");
				
				
				
            }
            $a = 0;
			$category_id = array();
			$category_name = array();
			$category_qty = array();
            foreach ($product as $product1) {
			    $cat_list = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `" . _DB_PREFIX_ . "category_lang` where `id_category` =" .$product1['id_category_default']. " and `id_lang`=1 ");
				if(!in_array($product1['id_category_default'],$category_id))
				{
				  $category_id[] = $product1['id_category_default'];
				  $category_name[] = $cat_list['name'];
				  $category_qty[] = 1;
				  
				}
				else
                {
				  $key = array_search($product1['id_category_default'],$category_id);
				  $category_qty[$key] = $category_qty[$key] + 1;
                }				
				
                $product_id[] = $product1['id_product'];
                $a++;
            }
			
			//according to cat
			if(isset($_GET['cat_id'])) {
				 $count = count($marketplace_product_id);
				 unset($product_id);
				for ($i = 0; $i < $count; $i++) {
					$product_id1 = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `" . _DB_PREFIX_ . "product` where id_product =".$marketplace_product_id[$i] ." and `id_category_default`=".$_GET['cat_id']);
					
					if($product_id1) {
						$product_id[] = $product_id1['id_product'];
					}
				}
				unset($product);
				foreach($product_id as $product_id1) {
					
					$product[] = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `" . _DB_PREFIX_ . "product` where id_product =".$product_id1);
					
				}
				 //var_dump($product_id);
				// $a=0;
				// foreach ($product as $product1) {
					// $product_id[$a] = $product1['id_product'];
					// $a++;
				
				// }
				
				$smarty->assign("cat_id",$_GET['cat_id']);
			} else {
				$smarty->assign("cat_id",0);
			}
			$smarty->assign("count_category",count($category_id) );
		    $smarty->assign("category_id",$category_id );
			$smarty->assign("category_name",$category_name );
			$smarty->assign("category_qty",$category_qty );
			
            $count_product = count($product_id);
            for ($i = 0; $i < $count_product; $i++) {
                $image[]        = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `" . _DB_PREFIX_ . "image` where id_product =" . $product_id[$i] . " and cover = 1");
				
				$image_id        = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `" . _DB_PREFIX_ . "image` where id_product =" . $product_id[$i] . " and cover = 1");
				
				
                $product_lang[] = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `" . _DB_PREFIX_ . "product_lang` where id_product =" . $product_id[$i] . " and id_lang=1");
				
				$link_rewrite_info =  Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `" . _DB_PREFIX_ . "product_lang` where id_product =" . $product_id[$i] . " and id_lang=1");
					
					
				$name = $link_rewrite_info['link_rewrite'];
				$ids = $product_id[$i].'-'.$image_id['id_image'];
				$product_obj = new Product($product_id[$i]);
				$cover_image_id = Product::getCover($product_obj->id);	
				if($cover_image_id) {
					$ids = $product_obj->id.'-'.$cover_image_id['id_image'];
					$prduct_img_link = "http://".$link->getImageLink($product_obj->link_rewrite,$ids);
					$image_link[] = $prduct_img_link;
				} else {
					$image_link[] = _MODULE_DIR_.'marketplace/img/defaultproduct.jpg';
				}
				//$image_link[] = $link->getImageLink($name,$ids);
				
            }
			
			
            $total_products = count($product_lang);
            $a              = 0;
            foreach ($product_lang as $product_lang1) {
                $product_name[] = $product_lang1['name'];
                $product_desc[] = $product_lang1['description'];
                $a++;
            }
            $a = 0;
		//	print_r($product);
            foreach ($product as $product1) {
            //  $product_price[]    = number_format($product1['price'], 2, '.', '');
			$product_price[] =  $product_obj->getPriceStatic($product1['id_product'],true);
                $product_id[]       = $product1['id_product'];
                $product_quantity[] = $product1['quantity'];
                $a++;
            }
            $a = 0;
            $i = 0;
            foreach ($image as $image1) {
                $image_id[$a]     = $image1['id_image'];
                $main_address[$i] = 'img/p/';
                $array            = str_split($image_id[$a]);
                foreach ($array as $array1) {
                    $main_address[$i] = $main_address[$i] . $array1 . "/";
                }
                $a++;
                $i++;
            }
			
           
	
			$mkt_shop = $obj_marketplace_seller->getmarketPlaceSellerInfo($marketplace_seller_id);
			$fake = array('fake'=>1);
            $shop_name       = $mkt_shop['shop_name'];
           
            $link_store      = $link->getModuleLink('marketplace', 'shopstore',$fake);
            $link_collection = $link->getModuleLink('marketplace', 'shopcollection',$fake);
            $Seller_profile  = $link->getModuleLink('marketplace', 'sellerprofile',$fake);
            $link_contact    = $link->getModuleLink('marketplace', 'contact',$fake);
            $col_size        = Configuration::get('col-size');
            $col_color       = Configuration::get('col-color');
            $col_font_family = Configuration::get('col-font-family');
			
            $count_product   = count($product_quantity);
			
            $smarty->assign("ff", '15');
            $smarty->assign("image_id", $image_id);
            $smarty->assign("main_address", $main_address);
            $smarty->assign("Seller_profile", $Seller_profile);
            $smarty->assign("link_contact", $link_contact);
            $smarty->assign("link_collection", $link_collection);
            $smarty->assign("link_store", $link_store);
            $smarty->assign("shop_name", $shop_name);
            $smarty->assign("seller_id", $marketplace_seller_id);
            $smarty->assign("product_quantity", $product_quantity);
            $smarty->assign("product_price", $product_price);
            $smarty->assign("product_id", $product_id);
            $smarty->assign("product_desc", $product_desc);
            $smarty->assign("product_name", $product_name);
            $smarty->assign("count_product", $count_product);
          //  $smarty->assign("token", $this->token);
            $smarty->assign("col_size", $col_size);
            $smarty->assign("col_color", $col_color);
            $smarty->assign("col_font_family", $col_font_family);
            $smarty->assign("image_link", $image_link);
            $this->setTemplate('shop_collection.tpl');
        } 
		else {
            
			$marketplace_shop = $obj_marketplace_shop->getMarketPlaceShopDetail($id_shop);
		   
			$shop_name                  = $marketplace_shop['shop_name'];
            $id_customer                = $marketplace_shop['id_customer'];
			
			$marketplace_seller_id_info = $obj_marketplace_seller->getMarketPlaceSellerIdByCustomerId($id_customer);
            
            $marketplace_seller_id      = $marketplace_seller_id_info['marketplace_seller_id'];
			
            $col_size                   = Configuration::get('col-size');
            $col_color                  = Configuration::get('col-color');
            $col_font_family            = Configuration::get('col-font-family');
			
            $smarty->assign("col_size", $col_size);
            $smarty->assign("col_color", $col_color);
            $smarty->assign("col_font_family", $col_font_family);
			
			$fake = array('fake'=>1);
            $link            = new link();
            $link_store      = $link->getModuleLink('marketplace', 'shopstore',$fake);
            $link_collection = $link->getModuleLink('marketplace', 'shopcollection',$fake);
            $Seller_profile  = $link->getModuleLink('marketplace', 'sellerprofile',$fake);
            $link_contact    = $link->getModuleLink('marketplace', 'contact',$fake);
			$smarty->assign("count_category",0);
            $smarty->assign("ff", '15');
            $smarty->assign("Seller_profile", $Seller_profile);
            $smarty->assign("shop_name", $shop_name);
            $smarty->assign("seller_id", $marketplace_seller_id);
            $smarty->assign("link_contact", $link_contact);
            $smarty->assign("link_collection", $link_collection);
            $smarty->assign("link_store", $link_store);
            $smarty->assign("count_product", 0);
			$smarty->assign("cat_id",0);
          //  $smarty->assign("token", $this->token);
            $this->setTemplate('shop_collection.tpl');
        }
        parent::initContent();
    }
    public function setMedia()
    {
         parent::setMedia();
       // if ($this->context->getMobileDevice() == false) {
          
            $this->addCSS(array(
				_THEME_CSS_DIR_ . 'scenes.css' => 'all',
				_THEME_CSS_DIR_ . 'category.css' => 'all',
				_THEME_CSS_DIR_ . 'product_list.css' => 'all',
               // _MODULE_DIR_ . 'marketplace/css/shop_collection.css',
                _MODULE_DIR_ . 'marketplace/css/header.css'
            ));
            if (Configuration::get('PS_COMPARATOR_MAX_ITEM') > 0)
                $this->addJS(_THEME_JS_DIR_ . 'products-comparison.js');
        // }
    }
}
?>