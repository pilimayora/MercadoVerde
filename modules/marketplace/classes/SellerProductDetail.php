<?php
/*
* 2007-2013 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2013 PrestaShop SA
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class SellerProductDetail extends ObjectModel
{
	public $id;
	public $id_seller;
	public $price;
	public $quantity;
	public $product_name;
	public $id_category;
	public $short_description;
	public $description;
	public $active;
	public $id_shop;
	public $ps_id_shop;
	public $date_add;
	public $date_upd;

	/**
	 * @see ObjectModel::$definition
	 */
	public static $definition = array(
		'table' => 'marketplace_seller_product',
		'primary' => 'id',
		'fields' => array(
			'id_seller' => array('type' => self::TYPE_INT,'required' => true),
			'price' => 	array('type' => self::TYPE_FLOAT,'validate' => 'isPrice', 'required' => true),
			
			'quantity' => 		array('type' => self::TYPE_INT),
			'product_name' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true),
			'id_category' => array('type' => self::TYPE_INT),	
			'short_description' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml'),
			'description' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml'),
			'active' => array('type' => self::TYPE_INT),	
			'id_shop' => array('type' => self::TYPE_INT),				
			'ps_id_shop' => array('type' => self::TYPE_INT),				
			'date_add' => 	array('type' => self::TYPE_DATE, 'validate' => 'isDateFormat', 'required' => false),
			'date_upd' => array('type' => self::TYPE_DATE, 'validate' => 'isDateFormat', 'required' => false),
		),
	);
	
	public function add($autodate = true, $null_values = false)
	{
		if (!parent::add($autodate, $null_values))
			return false;
		return Db::getInstance()->Insert_ID();
	}
	
	//@id_shop is the marketplace shop id
		public function getLatestProductByShopId($id_shop) {
			
		}
		
		//@id_product is the id_product from ps_product table
		public function getMarketPlaceIdShopByIdProduct($id_product) {
			$mp_shop_id = Db::getInstance()->getValue('Select `id_shop` from `'._DB_PREFIX_.'marketplace_seller_product` where `id` = '.$id_product.'');
		if(empty($mp_shop_id)) {
				return false;
			} else {
				return $mp_shop_id;
			}
		}
		
		
		/*@mp_product_id is the id_product from marketplace product table
		  @image_dir  is marketplace image directory		
		*/
		public function createPsProductByMarketplaceProduct($mp_product_id, $image_dir, $active) {
			$count = 0;
			$product_info = $this->getMarketPlaceProductInfo($mp_product_id);
			$quantity = (int)$product_info['quantity'];
			$category_id = (int)$product_info['id_category'];
			// Add Product
			$product = new Product();
			$product->name = array();
			$product->description = array();
			$product->description_short = array();
			$product->link_rewrite = array();
			foreach (Language::getLanguages(true) as $lang){
				$product->name[$lang['id_lang']] = $product_info['product_name'];
				$product->description[$lang['id_lang']] = $product_info['description'];
				$product->description_short[$lang['id_lang']] = $product_info['short_description'];
				$product->link_rewrite[$lang['id_lang']] = Tools::link_rewrite($product_info['product_name']);
			}
			$product->id_category_default = $category_id;
			$product->price = $product_info['price'];
			$product->active = $active;
			$product->indexed = 1;
			$product->condition = 'new';
			$product->save();
			$ps_product_id = $product->id;
			Search::indexation(Tools::link_rewrite($product_info['product_name']),$ps_product_id);
			if($ps_product_id > 0){
				if($category_id > 0){
					$category_ids = $this->getMultipleCategories($mp_product_id);
					$product->addToCategories($category_ids);
				}
				if($quantity > 0){
					StockAvailable::updateQuantity($ps_product_id, null, $quantity);
				}
				$image_list = $this->unactiveImage($mp_product_id);
				if($image_list){
					foreach($image_list as $image){
						$old_path = $image_dir.'/'.$image['seller_product_image_id'].'.jpg';
						$position = $count + 1;
						$image_obj = new Image();
						$image_obj->id_product = $ps_product_id;
						$image_obj->position = $position;
						if($count == 0)
							$image_obj->cover = true;
						else
							$image_obj->cover = false;
						$image_obj->add();
						$image_id = $image_obj->id;				
						$new_path = $image_obj->getPathForCreation();
						$manipulator = new ImageManipulator($old_path);
						$imagesTypes = ImageType::getImagesTypes('products');
						
						foreach ($imagesTypes as $k => $image_type){
							//$newImage = $manipulator->resample($image_type['height'],$image_type['width'],true);
							//$manipulator->save($new_path.'-'.$image_type['name'].'.jpg');
							ImageManager::resize($old_path, $new_path.'-'.$image_type['name'].'.jpg', $image_type['width'],$image_type['height']);
						}
						//$width =  $manipulator->getWidth();
						//$height = $manipulator->getHeight();
						//$manipulator->resample($height,$width,true);
						//$manipulator->save($new_path.'.jpg');
						
						ImageManager::resize($old_path,$new_path.'.jpg');
						Hook::exec('actionWatermark', array('id_image' => $image_id, 'id_product' => $ps_product_id));
						//updating mp_product_image status ...
						Db::getInstance()->update('marketplace_product_image', array('active' =>1),'seller_product_image_id ="'.$image['seller_product_image_id'].'" ');
						$count = $count + 1;
					}
				}
				
				return $ps_product_id;
			}
			return false;
		}
		
		public function getMultipleCategories($mp_product_id){
			$mcategory = Db::getInstance()->executeS("SELECT `id_category` FROM `"._DB_PREFIX_."marketplace_seller_product_category` WHERE `id_seller_product` =".$mp_product_id);
			 
			if(empty($mcategory))
				return false;
			
			foreach($mcategory as $cat){
				$mcat[] = $cat['id_category'];
			}
			return 	$mcat;
		}
		
		public function updatePsProductByMarketplaceProduct($mp_product_id, $image_dir, $active,$main_product_id) {
			$count = 0;
			$product_info = $this->getMarketPlaceProductInfo($mp_product_id);
			$quantity = (int)$product_info['quantity'];
			$category_id = (int)$product_info['id_category'];
			$ps_id_shop = (int)$product_info['ps_id_shop'];
			// Add Product
			$product = new Product($main_product_id);
			$product->name = array();
			$product->description = array();
			$product->description_short = array();
			$product->link_rewrite = array();
			foreach (Language::getLanguages(true) as $lang){
				$product->name[$lang['id_lang']] = $product_info['product_name'];
				$product->description[$lang['id_lang']] = $product_info['description'];
				$product->description_short[$lang['id_lang']] = $product_info['short_description'];
				$product->link_rewrite[$lang['id_lang']] = Tools::link_rewrite($product_info['product_name']);
			}
			$product->id_category_default = $category_id;
			$product->price = $product_info['price'];
			$product->active = $active;
			$product->indexed = 1;
			$product->condition = 'new';
			$product->save();
			$ps_product_id = $product->id;
			Search::indexation(Tools::link_rewrite($product_info['product_name']),$ps_product_id);
			if($ps_product_id > 0){
				if($category_id > 0){
					$category_ids = $this->getMultipleCategories($mp_product_id);
					Db::getInstance()->delete('category_product','id_product = '.$main_product_id);
					$product->addToCategories($category_ids);
				}
				if($quantity > 0){
					StockAvailable::setQuantity($ps_product_id, 0, $quantity, $ps_id_shop);
					//StockAvailable::updateQuantity($ps_product_id, null, $quantity);
				}
				$image_list = $this->unactiveImage($mp_product_id);
				if($image_list){
					foreach($image_list as $image){
						$old_path = $image_dir.'/'.$image['seller_product_image_id'].'.jpg';
						$position = $count + 1;
						$image_obj = new Image();
						$image_obj->id_product = $ps_product_id;
						$image_obj->position = $position;
						if($count == 0)
							$image_obj->cover = false;
						else
							$image_obj->cover = false;
						$image_obj->add();
						$image_id = $image_obj->id;				
						$new_path = $image_obj->getPathForCreation();
						$manipulator = new ImageManipulator($old_path);
						$imagesTypes = ImageType::getImagesTypes('products');
						
						foreach ($imagesTypes as $k => $image_type){
							//$newImage = $manipulator->resample($image_type['height'],$image_type['width'],true);
							//$manipulator->save($new_path.'-'.$image_type['name'].'.jpg');
							
							ImageManager::resize($old_path, $new_path.'-'.$image_type['name'].'.jpg', $image_type['width'],$image_type['height']);
						}
						//$width =  $manipulator->getWidth();
						//$height = $manipulator->getHeight();
					//	$manipulator->resample($height,$width,true);
						//$manipulator->save($new_path.'.jpg');
						ImageManager::resize($old_path,$new_path.'.jpg');
						Hook::exec('actionWatermark', array('id_image' => $image_id, 'id_product' => $ps_product_id));
						//updating mp_product_image status ...
						Db::getInstance()->update('marketplace_product_image', array('active' =>1),'seller_product_image_id ="'.$image['seller_product_image_id'].'" ');
						$count = $count + 1;
					}
				}
				return $ps_product_id;
			}
			return false;
		}
		
		//@id_order get marketplace product details of seller shop
		public function getMarketPlaceProductDetailOfSellerShop($id_order){
			$order_info = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT * FROM `'._DB_PREFIX_.'order_detail` od JOIN `'._DB_PREFIX_.'product` p ON (p.id_product = od.product_id) JOIN `'._DB_PREFIX_.'product_shop` ps ON (ps.id_product = p.id_product AND ps.id_shop = od.id_shop) join `'._DB_PREFIX_.'marketplace_shop_product` msp ON (msp.`id_product`=p.`id_product`) WHERE od.`id_order` = '.$id_order.' ORDER BY p.`id_product`');
			if(!empty($order_info)) {
				return $order_info;
			} else {
				return false;
			}
		}
		
		//@id_product is the id_product from ps_product table
		public function getMarketPlaceShopProductDetail($id_product) {
			$marketplaceshopdetail = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `" . _DB_PREFIX_ . "marketplace_shop_product` where id_product =" . $id_product . " ");
			if(!empty($marketplaceshopdetail)) {
				return $marketplaceshopdetail;
			} else {
				return false;
			}
			
		}
		
		//@id is the id from marketplace seller product table
		public function getMarketPlaceShopProductDetailBYmspid($id) {
			$marketplaceshopdetail = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `" . _DB_PREFIX_ . "marketplace_shop_product` where marketplace_seller_id_product =" . $id . " ");
			if(!empty($marketplaceshopdetail)) {
				return $marketplaceshopdetail;
			} else {
				return false;
			}
			
		}
		
		//@id is marketplace product id
		public function getMarketPlaceProductInfo($id) {
			$marketplaceproductinfo = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `" . _DB_PREFIX_ ."marketplace_seller_product` where id =".$id);
			
			if(!empty($marketplaceproductinfo)) {
				return $marketplaceproductinfo;
			} else {
				return false;
			}
		}
		
		//@id is marketplace product id
		public function getMarketPlaceProductCategories($id){
			$seller_product_categories = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("SELECT `id_category` FROM `" . _DB_PREFIX_ ."marketplace_seller_product_category` where id_seller_product =".$id);
			
			if(!empty($seller_product_categories)) {
				return $seller_product_categories;
			} else {
				return false;
			}
		}
		
		//where $id_shop is marketplace shop id
		public function getMarketPlaceShopDetail($id_shop) {
			$marketplaceshopdetail = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `" . _DB_PREFIX_ . "marketplace_shop` where id =".$id_shop);
			
			if(!empty($marketplaceshopdetail)) {
				return $marketplaceshopdetail;
			} else {
				return false;
			}
		}
		
		//join marketplace shop product
		
		public function findAllProductInMarketPlaceShop($id_shop,$orderby=false,$orderway=false) {
			if(!$orderby) {
				$orderby = 'product_name';
			}
			if(!$orderway) {
				$orderway = 'asc';
			}
			$marketplace_shop_product = Db::getInstance()->ExecuteS("SELECT * FROM `" . _DB_PREFIX_ . "marketplace_shop_product` msp join `" . _DB_PREFIX_ . "marketplace_seller_product` mslp on (msp.`marketplace_seller_id_product` = mslp.`id`) where msp.`id_shop` =" . $id_shop . " order by mslp.`" . $orderby . "` " . $orderway . " ");
			
			if(!empty($marketplace_shop_product)) {
				return $marketplace_shop_product;
			} else {
				return false;
			}
		}
		
		public function unactiveImage($id) {
			 $unactive_image = Db::getInstance()->ExecuteS("select * from `"._DB_PREFIX_."marketplace_product_image` where seller_product_id=".$id." and active=0");
			 if(!empty($unactive_image)) {
				return $unactive_image;
			 } else {
				return false;
			 }
		}
		
		public function getProductsByOrderId($id_order)
		{
		   $product_list = Db::getInstance()->ExecuteS("select `product_id`,`product_quantity`  from `"._DB_PREFIX_."order_detail` where id_order=".$id_order."");
		   
		   if($product_list)
		    return $product_list;
		   else
             return false;		   
		}
		
		public function checkProduct($id_product)
		{
		  $check_product = Db::getInstance()->getRow("select `marketplace_seller_id_product`  from `"._DB_PREFIX_."marketplace_shop_product` where id_product=".$id_product."");
		  if($check_product)
		   return $check_product['marketplace_seller_id_product'];
		  else
           return false;		  
		}
		
		public function getSellerIdByProduct($mkt_product_id)
		{
		  $seller = Db::getInstance()->getRow("select *  from `"._DB_PREFIX_."marketplace_seller_product` where id=".$mkt_product_id."");
		  if($seller)
		   return $seller['id_seller'];
		  else
           return false;
		}
		
		public function getCustomerDetails()
		{
		  $customer = Db::getInstance()->getRow("select *  from `"._DB_PREFIX_."customer` where id=".$mkt_product_id."");
		}
		
		public function getCustomerIdBySellerId($id)
		{
		  $customer_id = Db::getInstance()->getRow("select `id_customer`  from `"._DB_PREFIX_."marketplace_customer` where `marketplace_seller_id`=".$id."");
		  if($customer_id)
		   return $customer_id['id_customer'];
          else
           return false;		  
		}
		
		public function getSellerInfo($id)
		{
		  $customer_info = Db::getInstance()->getRow("select `firstname`,`lastname`,`email`  from `"._DB_PREFIX_."customer` where `id_customer`=".$id."");
		  if($customer_info)
		   return $customer_info;
		  else
           return false;		  
		  
		}
		public function getProductInfo($id)
		{
		 $product_info = Db::getInstance()->getRow("select `name`  from `"._DB_PREFIX_."product_lang` where `id_product`=".$id." and `id_lang`=1");
		 if($product_info)
		  return $product_info;
		 else
          return false;		 
		}
		public function getProductStatus($id)
		{
		  $product_status = Db::getInstance()->getValue("select `active`  from `"._DB_PREFIX_."marketplace_seller_product` where `id`=".$id."");
		  return $product_status;
		}
		public function getCustomerInfo($id)
		{
		  $customer_info = Db::getInstance()->getRow("select *  from `"._DB_PREFIX_."customer` where `id_customer`=".$id."");
		  return $customer_info;
		}
		
		public function getDeliverAddress($id)
        {
		  $delivery_address = Db::getInstance()->getRow("select `id_address_delivery`  from `"._DB_PREFIX_."orders` where `id_order`=".$id."");
		  return $delivery_address['id_address_delivery'];
        }	

       public function getShippingInfo($id)
       {
	     $address = Db::getInstance()->getRow(" select * from `" . _DB_PREFIX_ . "address` where `id_address`=".$id."");
		 return $address;
       }	
       public function getState($id) 
       {
	     $state = Db::getInstance()->getRow(" select `name` from `" . _DB_PREFIX_ . "state` where `id_state`=".$id."");
		 return $state['name'];
       }
       public function getCountry($id) 
       {
	     $country = Db::getInstance()->getRow(" select `name` from `" . _DB_PREFIX_ . "country_lang` where `id_country`=".$id." and `id_lang`=1 ");
		 return $country['name'];
       }
	
	public function deleteMarketPlaceSellerProduct($id) {
		$is_delete = Db::getInstance()->Execute("DELETE from`"._DB_PREFIX_."marketplace_seller_product` where id=".$id);
		
		if($is_delete) {
			return true;
		} else {
			return false;
		}
	}

	public function findAllActiveSellerProductByLimit($start_point=0,$limit_point=8,$order_by='desc') {
		$seller_product = Db::getInstance()->executeS("select mpsp.*,msp.`id_product` as main_id_product from `". _DB_PREFIX_."marketplace_seller_product` mpsp join `". _DB_PREFIX_."marketplace_shop_product` msp on (mpsp.`id`=msp.`marketplace_seller_id_product`) join `" . _DB_PREFIX_ . "product` p on (msp.`id_product`=p.`id_product`) where mpsp.`active`=1 order by mpsp.`id` ".$order_by." limit ".$start_point.",".$limit_point);
			if(empty($seller_product)) {
				return false;
			} else {
				return $seller_product;
			}
	}
	//@mail_for = 1 active product
	// mail_for = 2 deactive product
	// mail_for = 3 delete product
	public function callMailFunction($mp_product_id,$sub,$mail_for=false,$reply_to=false) {	
		if($mail_for==1) {
			$mail_reason = 'Active';
		} else if($mail_for==2){
			$mail_reason = 'Deactive';
		} else if($mail_for==3) {
			$mail_reason = 'Delete';
		} else {
			$mail_reason = 'Active';
		}
		$obj_seller_product = new SellerProductDetail($mp_product_id);
		$product_name = $obj_seller_product->product_name;
		$id_category = $obj_seller_product->id_category;
		$short_description = $obj_seller_product->short_description;
		$ps_id_shop	 = $obj_seller_product->ps_id_shop;
		$mp_id_shop	 = $obj_seller_product->id_shop;
		$mp_id_seller	 = $obj_seller_product->id_seller;
		$quantity	 = $obj_seller_product->quantity;
		
		$obj_category = new Category($id_category);
		$category_name = $obj_category->name['1'];
		$obj_seller = new SellerInfoDetail($mp_id_seller);
		$mp_seller_name = $obj_seller->seller_name;
		$shop_name = $obj_seller->shop_name;
		$business_email = $obj_seller->business_email;
		if($business_email==' ') {
			$id_customer = $this->getCustomerIdBySellerId($mp_id_seller);
			$obj_cus = new Customer($id_customer);
			$business_email = $obj_cus->email;
		}
		$obj_mp_shop = new MarketplaceShop($mp_id_shop);
		$mp_shop_name = $obj_mp_shop->shop_name;
		
		$obj_shop = new Shop($ps_id_shop);
		$ps_shop_name = $obj_shop->name;
		if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) {
			$secure_connection = "https://";
		} else {
			$secure_connection = "http://";
		}
		
		$shop_url = $secure_connection.$obj_shop->domain.$obj_shop->physical_uri.$obj_shop->virtual_uri;
		$message ="Hello ".$mp_seller_name."<br /><br />";
		$message .="Your request for <b>".$product_name."</b> for your shop <b>".$mp_shop_name." </b> has been ".$mail_reason." by admin<br /><br />";
		$message .="Your Product detail as bellow<br /><br />";
		$message .="<table style='width:100%;margin-bottom:10px' border='1' cellspacing='2' cellpadding='0'>
					<tr>
						<th>Product name</th>
						<th>Category name</th>
						<th>Quantity</th>
						<th>Main shop name</th>
						<th>Your shop name</th>
					</tr>
					<tr>
						<td>"
						.$product_name.
						"</td>
						<td>"
						.$category_name.
						"</td>
						<td>"
						.$quantity.
						"</td>
						<td>"
						.$ps_shop_name.
						"</td>
						<td>"
						.$mp_shop_name.
						"</td>
					</tr>
					</table>";
		$message .=	"<br/><br />";		
		$message .=	"Go to your shop by clicking on link bellow<br /><br />";		
		$message .=	$shop_url;		
		$message .="<br/><br />Thanks"."<br/>";
		
		//admin email id
		if($reply_to==false)
			$reply_to = 'pratik@webkul.com';
		$mail_sent = SellerProductDetail::sendMail($business_email,$message,$sub,$reply_to,$ps_shop_name);
		return true;
	}
	
	public static function sendMail($reciver_email,$message,$subject,$reply_to=false,$email_from=false) {
		if(!$reply_to) {
			$reply_to = "pratik@webkul.com";
		}
		if(!$email_from) {
			$email_from = "Marketplace";
		}
		$header = "";
		$uid = md5(uniqid(time()));
		$header .= "Reply-To: ".$reply_to."\r\n";
		$header .= "From: ".$email_from." <".$reply_to.">"." \r\n";
		$header.= "MIME-Version: 1.0"."\r\n";
		$header.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$header.='X-Mailer: PHP/' . phpversion()."\r\n";
		$mail_result = mail($reciver_email,$subject,$message,$header);
		if($mail_result) {
			return true;
		} else {
			return false;
		}
	}
	// For pagination
	public static function getProductList($id_seller, $orderby=false,$orderway=false,$p, $n)
	{	
		if(!$orderby) {
				$orderby = 'product_name';
			}
		if(!$orderway) {
				$orderway = 'asc';
			}
		
		
		$product_list = Db::getInstance()->ExecuteS("SELECT * from`" . _DB_PREFIX_ . "marketplace_seller_product` mslp where mslp.id_seller=" . $id_seller." order by mslp.`" . $orderby . "` " . $orderway . " limit ".(((int)$p - 1) * (int)$n).",".(int)$n);
		   
		   if($product_list)
		    return $product_list;
		   else
             return false;
		}

}
?>