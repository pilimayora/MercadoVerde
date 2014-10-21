<?php
class SellerInfoDetail extends ObjectModel
{
	public $id;
	public $business_email;
	public $seller_name;
	public $shop_name;
	public $phone;
	public $fax;
	public $address;
	public $about_shop;
	public $facebook_id;
	public $twitter_id;
	
	public $date_add;
	public $dateupdate;

	public $active;
	/**
	 * @see ObjectModel::$definition
	 */
	public static $definition = array(
		'table' => 'marketplace_seller_info',
		'primary' => 'id',
		'fields' => array(
			'business_email' => array('type' => self::TYPE_STRING, 'validate' => 'isEmail'),
			'seller_name' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true),
			'shop_name' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true),
			'phone' => 		array('type' => self::TYPE_STRING,'required' => true),
			'fax' => 		array('type' => self::TYPE_STRING),
			'address' => array('type' => self::TYPE_STRING),
			'about_shop' => array('type' => self::TYPE_STRING),
			'facebook_id' => array('type' => self::TYPE_STRING),
			'twitter_id' => array('type' => self::TYPE_STRING),
			'date_add' => 			array('type' => self::TYPE_DATE, 'validate' => 'isDateFormat', 'required' => false),
			'dateupdate' => 			array('type' => self::TYPE_DATE, 'validate' => 'isDateFormat', 'required' => false),
		),
	);
	
	public function add($autodate = true, $null_values = false)
	{
		if (!parent::add($autodate, $null_values))
			return false;
		return Db::getInstance()->Insert_ID();
	}
	
	public function update($null_values = false)
	{
		Cache::clean('getContextualValue_'.$this->id.'_*');
		$success = parent::update($null_values);
		return $success;
	}
	public function delete()
	{
		return parent::delete();
	}
	
	public function insertSellerDetail($date_add,$bussiness_email,$shop_name,$seller_name,$phone,$address,$about_business,$fax,$fb_id,$tw_id) {
		$result  = Db::getInstance()->insert('marketplace_seller_info', array(
            'date_add' => pSQL($date_add),
            'business_email' => pSQL($bussiness_email),
            'shop_name' => pSQL($shop_name),
            'seller_name' => pSQL($seller_name),
            'phone' => (int)$phone,
            'address' => pSQL($address),
            'about_shop' => pSQL(trim($about_business)),
            'fax' => $fax,
            'facebook_id' => pSQL($fb_id),
            'twitter_id' => pSQL($tw_id)
        ));
		
		if($result) {
			 return Db::getInstance()->Insert_ID();
		} else {
			return false;
		}
	}
	public function sellerDetail($seller_id) {
		$seller_info = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `"._DB_PREFIX_."marketplace_seller_info` where `id`=".$seller_id);
		if(!empty($seller_info)) {
			return $seller_info;
		} else {
			return false;
		}
	}
	public function getMarketPlaceSellerIdByCustomerId($id_customer) {
			$isseller = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `" . _DB_PREFIX_ . "marketplace_customer` where id_customer =".$id_customer);
			if(!empty($isseller)) {
				return $isseller;
			} else {
				return false;
			}
	}
	
	public function isShopNameExist($name){
		$name = addslashes($name);
		$name = Db::getInstance()->getRow("SELECT * FROM `" ._DB_PREFIX_ ."marketplace_seller_info` WHERE shop_name ='$name'");
		if(empty($name))
			return false;
		return true;	
	}
		
	public function getmarketPlaceSellerInfo($marketplace_sellerid) {
		$marketplace_sellerinfo = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `". _DB_PREFIX_."marketplace_seller_info` where id =". $marketplace_sellerid);
		
		if(!empty($marketplace_sellerinfo)) {
			return $marketplace_sellerinfo;
		} else {
			return false;
		}
	}
		public function findAllActiveSeller() {
			$seller_info = Db::getInstance()->executeS("select mpsi.* from `". _DB_PREFIX_."marketplace_seller_info` mpsi left join `". _DB_PREFIX_."marketplace_customer` mpc on (mpsi.`id`=mpc.`marketplace_seller_id`) where is_seller =1");
			if(empty($seller_info)) {
				return false;
			} else {
				return $seller_info;
			}
		}
		
		public function findAllActiveSellerInfoByLimit($start_point=0,$limit_point=7,$like=false,$all=false,$like_word='a') {
			if($like==false && $all==false) { 
				$seller_info = Db::getInstance()->executeS("select mpsi.*,mpc.`id_customer`,ms.`id` as mp_shop_id from `". _DB_PREFIX_."marketplace_seller_info` mpsi left join `". _DB_PREFIX_."marketplace_customer` mpc on (mpsi.`id`=mpc.`marketplace_seller_id`) left join `". _DB_PREFIX_."marketplace_shop` ms on (ms.`id_customer`=mpc.`id_customer`) where is_seller =1 limit ".$start_point.",".$limit_point);
			} else if($like==false && $all==true) {
				$seller_info = Db::getInstance()->executeS("select mpsi.*,mpc.`id_customer`,ms.`id` as mp_shop_id from `". _DB_PREFIX_."marketplace_seller_info` mpsi left join `". _DB_PREFIX_."marketplace_customer` mpc on (mpsi.`id`=mpc.`marketplace_seller_id`) left join `". _DB_PREFIX_."marketplace_shop` ms on (ms.`id_customer`=mpc.`id_customer`) where is_seller =1");
			} else if($like==true && $all==false) {
				//no limit
				$seller_info = Db::getInstance()->executeS("select mpsi.*,mpc.`id_customer`,ms.`id` as mp_shop_id from `". _DB_PREFIX_."marketplace_seller_info` mpsi left join `". _DB_PREFIX_."marketplace_customer` mpc on (mpsi.`id`=mpc.`marketplace_seller_id`) left join `". _DB_PREFIX_."marketplace_shop` ms on (ms.`id_customer`=mpc.`id_customer`) where is_seller =1 and LOWER( ms.`shop_name`) like '".$like_word."%'");
			} else if($like==true && $all==true) {
				$seller_info = Db::getInstance()->executeS("select mpsi.*,mpc.`id_customer`,ms.`id` as mp_shop_id from `". _DB_PREFIX_."marketplace_seller_info` mpsi left join `". _DB_PREFIX_."marketplace_customer` mpc on (mpsi.`id`=mpc.`marketplace_seller_id`) left join `". _DB_PREFIX_."marketplace_shop` ms on (ms.`id_customer`=mpc.`id_customer`) where is_seller =1 and LOWER( ms.`shop_name`) like '%".$like_word."%'");
			}
			if(empty($seller_info)) {
				return false;
			} else {
				return $seller_info;
			}
		}
		
		public function callMailFunction($mp_id_seller,$sub,$mail_for=false,$reply_to=false,$main_shop_id=1) {	
			if($mail_for==1) {
				$mail_reason = 'Active';
			} else if($mail_for==2){
				$mail_reason = 'Deactive';
			} else if($mail_for==3) {
				$mail_reason = 'Delete';
			} else {
				$mail_reason = 'Active';
			}
			
			$obj_seller = new SellerInfoDetail($mp_id_seller);
			$mp_seller_name = $obj_seller->seller_name;
			$shop_name = $obj_seller->shop_name;
			$business_email = $obj_seller->business_email;
			$mp_shop_name = $obj_seller->shop_name;
			$mp_shop_name = $obj_seller->shop_name;
			$phone = $obj_seller->phone;
			//$business_email = 'pratik@webkul.com';
			if($business_email==' ') {
				$id_customer = $this->getCustomerIdBySellerId($mp_id_seller);
				$obj_cus = new Customer($id_customer);
				$business_email = $obj_cus->email;
			}
			
		
			$obj_shop = new Shop($main_shop_id);
			$ps_shop_name = $obj_shop->name;
			if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) {
				$secure_connection = "https://";
			} else {
				$secure_connection = "http://";
			}
			$shop_url = $secure_connection.$obj_shop->domain.$obj_shop->physical_uri.$obj_shop->virtual_uri;
			$message ="Hello ".$mp_seller_name."<br /><br />";
			$message .="Your request for Marketplace seller <b>".$mp_shop_name."</b> has been ".$mail_reason." by admin<br /><br />";
			$message .="Your Shop detail as bellow<br /><br />";
			$message .="<table style='width:100%;margin-bottom:10px' border='1' cellspacing='2' cellpadding='0'>
					<tr>
						<th>Seller name</th>
						<th>Your Shop name</th>
						<th>Phone</th>
						<th>Email</th>
						<th>Main shop name</th>
					</tr>
					<tr>
						<td>"
						.$mp_seller_name.
						"</td>
						<td>"
						.$mp_shop_name.
						"</td>
						<td>"
						.$phone.
						"</td>
						<td>"
						.$business_email.
						"</td>
						<td>"
						.$ps_shop_name.
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
	public static function make_seller_patner($id) {
					$is_update = Db::getInstance()->update('marketplace_customer', array('is_seller' =>1),'marketplace_seller_id='.$id);

					$market_place_customer = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("SELECT * from`"._DB_PREFIX_."marketplace_customer` where `marketplace_seller_id`=".$id);

					$market_place_cutomer_id = $market_place_customer['id_customer'];

					$market_place_seller_info = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("SELECT * from`"._DB_PREFIX_."marketplace_seller_info` where `id`=".$id);

						$shop_name = $market_place_seller_info['shop_name'];
						$shop_rewrite = Tools::link_rewrite($shop_name);

						$is_shop_created = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("SELECT * from`"._DB_PREFIX_."marketplace_shop` where `id_customer`=".$market_place_cutomer_id);

						if($is_shop_created) {

							//enable shop

							$is_inserted_shop_name = Db::getInstance()->update('marketplace_shop', array('is_active' =>1),'id_customer='.$market_place_cutomer_id);

							//fetch product for seller

							$market_place_shop_id = $is_shop_created['id'];

							$is_inserted_shop_name = Db::getInstance()->update('marketplace_seller_product', array('active' =>1),'id_shop='.$market_place_shop_id);

							

							$total_product_detail = Db::getInstance()->executeS("select `id_product` from `"._DB_PREFIX_."marketplace_shop_product` where `id_shop`=$market_place_shop_id");

							if($total_product_detail) {

								foreach($total_product_detail as $total_product_detail1) {

									$is_product_present = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("SELECT * from`"._DB_PREFIX_."product` where `id_product`=".$total_product_detail1['id_product']);

									if($is_product_present) {

										$is_inserted_shop_name = Db::getInstance()->update('product', array('active' =>1),'id_product='.$total_product_detail1['id_product']);

									}

								}

							}
							$obj_seller_info = new SellerInfoDetail();
							$obj_seller_info->callMailFunction(Tools::getValue('id'),'Approve seller request',1,$this->context->employee->email,$this->context->shop->id);
							
							$redirect = self::$currentIndex.'&conf=5&token='.$this->token;

							$this->redirect_after = $redirect;

						} else {

							$is_inserted_shop_name = Db::getInstance()->insert('marketplace_shop', array(

									'shop_name' =>pSQL($shop_name),
									'link_rewrite' => pSQL($shop_rewrite),
									'id_customer' =>(int)$market_place_cutomer_id,

									'about_us' =>pSQL(trim($market_place_seller_info['about_shop'])),

									'is_active'=>1,

								));

							/*if($is_inserted_shop_name)	{

								Hook::exec('actionActiveSellerPlan', array('mp_id_seller' => Tools::getValue('id')));
								
								$obj_seller_info = new SellerInfoDetail();
								$obj_seller_info->callMailFunction(Tools::getValue('id'),'Approve seller request',1,$this->context->employee->email,$this->context->shop->id);
								$redirect = self::$currentIndex.'&conf=5&token='.$this->token;

								$this->redirect_after = $redirect;

							} else {

								$is_update = Db::getInstance()->update('marketplace_customer', array('is_seller' =>0),'marketplace_seller_id='.$id);

								Tools::displayError($this->l('Some error occurs'));

							}*/

						}
				}
}