<?php
/**
 * StorePrestaModules SPM LLC.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://storeprestamodules.com/LICENSE.txt
 *
 /*
 * 
 * @author    StorePrestaModules SPM <kykyryzopresto@gmail.com>
 * @category others
 * @package propack
 * @copyright Copyright (c) 2011 - 2014 SPM LLC. (http://storeprestamodules.com)
 * @license   http://storeprestamodules.com/LICENSE.txt
*/

class fourreferralsModule extends ObjectModel
{
	
    
    public static function getCustomerReferralsMyAccount($data){
    	$customer_id = (int)$data['customer_id'];
    	$id_product = $data['id_product'];
    	
    	$sql = '
	        	SELECT count(*) as count FROM `'._DB_PREFIX_.'four_referral` 
		        WHERE `user_id` = '.$customer_id.' 
		        AND `coupon_id` = 0 
		        AND ip = "'.$_SERVER['REMOTE_ADDR'].'"
		        and `type` =  1
		        AND id_product = '.$id_product;
    	
    	$result = Db::getInstance()->GetRow($sql);
    	$count_refferals_facebook = $result['count'];
    	
    	$sql = '
	        	SELECT count(*) as count FROM `'._DB_PREFIX_.'four_referral` 
		        WHERE `user_id` = '.$customer_id.' 
		        AND `coupon_id` = 0 
		        AND ip = "'.$_SERVER['REMOTE_ADDR'].'"
		        and `type` =  2
		        AND id_product = '.$id_product;
    	
    	$result = Db::getInstance()->GetRow($sql);
    	$count_refferals_twitter = $result['count'];
    	
    	$sql = '
	        	SELECT count(*) as count FROM `'._DB_PREFIX_.'four_referral` 
		        WHERE `user_id` = '.$customer_id.' 
		        AND `coupon_id` = 0 
		        AND ip = "'.$_SERVER['REMOTE_ADDR'].'"
		        and `type` =  4
		        AND id_product = '.$id_product;
    	
    	$result = Db::getInstance()->GetRow($sql);
    	$count_refferals_google = $result['count'];
    	
    	
    	$sql = '
	        	SELECT count(*) as count FROM `'._DB_PREFIX_.'four_referral` 
		        WHERE `user_id` = '.$customer_id.' 
		        AND `coupon_id` = 0 
		        AND ip = "'.$_SERVER['REMOTE_ADDR'].'"
		        and `type` = 3
		        AND id_product = '.$id_product;
    	
    	$result = Db::getInstance()->GetRow($sql);
    	$count_refferals_linkedin = $result['count'];
    	 
    	return array('facebook'=>$count_refferals_facebook,
    				 'twitter'=>$count_refferals_twitter,
    				 'google'=>$count_refferals_google,
    				 'linkedin'=>$count_refferals_linkedin
    				);
    	
    }
    
   
    
public static function checkfordiscount($data){
    	$fbrefnum = $data['refnum'];
    	$id_ref_user = $data['ref'];
    	$id_currency = $data['id_currency'];
    	$ip = $data['ip'];
    	
    	$id_product = $data['id_product'];
    	
    	$type = $data['type'];
    	$data_type = $data['data_type'];
    	
    	
    	$name_module = "propack";
    	$code_module = strtoupper($data_type)."-REF";
    	
    	
			$type = 0;
			if($data_type == 'facebook'){
				// facebook
				$type = 1;
				$refnum =  Configuration::get($name_module.'frefnum');
				
			} elseif($data_type == 'twitter'){
				$type=2;
				$refnum =  Configuration::get($name_module.'trefnum');
				
			} elseif($data_type == 'google'){
				$type=4;
				$refnum =  Configuration::get($name_module.'grefnum');
				
			} elseif($data_type == 'linkedin'){
				$refnum =  Configuration::get($name_module.'lrefnum');
				
				$type=3;
			}
			
			$type_social_referral = $type;
    	
			if(version_compare(_PS_VERSION_, '1.5', '>')){
				$id_shop = Context::getContext()->shop->id;
	 		} else {
				$id_shop = 0;
	 		}	
    	$query = 'INSERT INTO '._DB_PREFIX_.'four_referral (user_id, id_product, coupon_id, ip, id_shop, `type`, date) 
                                            VALUES ('.$id_ref_user.', '.$id_product.', 0, "'.$ip.'", '.$id_shop.' , "'.$type.'", "'. date("Y-m-d H:i:s") .'") ';
			
		Db::getInstance()->Execute($query);  
			
		
		
		if($id_ref_user!=0){
			$condition_sql = 'and user_id = "'.$id_ref_user.'"';
		}	else {
			$condition_sql = 'and user_id = "'.$id_ref_user.'" and ip = "'.$ip.'"';
		}
			
    	$sql = 'SELECT count(*)  as count
                       FROM '._DB_PREFIX_.'four_referral  
                       WHERE coupon_id = 0 '.$condition_sql.'
                       and `type` = '.$type.' and id_product='.$id_product;
    	
    	$return_check_value = Db::getInstance()->GetRow($sql);
    	$count_ref = $return_check_value['count'];
    	
    	if( ($count_ref == $fbrefnum) || ($count_ref > $refnum) || ($refnum == 1)){
    		// set discount
    		
	    	switch (Configuration::get($name_module.'discount_type'))
			{
				case 1:
					// percent
					$id_discount_type = 1;
					$value = Configuration::get($name_module.'percentage_val');
					break;
				case 2:
					// currency
					$id_discount_type = 2;
					$value = Configuration::get('fbrefamount_'.(int)$id_currency);
				break;
				default:
					$id_discount_type = 2;
					$value = Configuration::get('fbrefamount_'.(int)$id_currency);
			}
			
	      if (version_compare(_PS_VERSION_, '1.5', '>')){
		    $context = Context::getContext();
		    $cookie = $context->cookie;
    	  } else {
		    global $cookie;
		  }
	  
			$current_language = (int)$cookie->id_lang;
			
	    	$coupon = (version_compare(_PS_VERSION_, '1.5.0') != -1)? new CartRule() : new Discount();
    		
	    	$gen_pass = strtoupper(Tools::passwdGen(8));
	    	
	    	if(version_compare(_PS_VERSION_, '1.5', '>')){
		       	foreach (Language::getLanguages() AS $language){
		       		$coupon->name[(int)$language['id_lang']] = $code_module.'-'.$gen_pass;
		       	}
		       	$coupon->description = Configuration::get($name_module.'coupondesc_'.$current_language);
		       	
	    	} else {
	    		
	    		foreach (Language::getLanguages() AS $language){
	    			$coupon->description[(int)$language['id_lang']] = Configuration::get($name_module.'coupondesc_'.(int)$language['id_lang']);
	    		}
	    	}
	    	
	    	$codename = $code_module.'-'.$gen_pass;
	    	$category = explode(",",Configuration::get($name_module.'catbox'));
    		
	    	if (version_compare(_PS_VERSION_, '1.5', '>')) {
				$coupon->code = $codename;
				$type = $id_discount_type == 2? 'reduction_amount' : 'reduction_percent';

				$coupon->$type = floatval($value);

				$coupon->reduction_currency = intval($id_currency);
				if(Configuration::get($name_module.'isminamount') == true || 
				   Configuration::get($name_module.'isminamount') == 1){
					$coupon->minimum_amount = intval(Configuration::get('fbrefminamount_'.(int)$id_currency));
					$coupon->minimum_amount_currency = intval($id_currency);
				}

				if (sizeof($category)>0) {
						$coupon->product_restriction = 1;
				}
					
					
			} else {
					$coupon->name = $codename;
					$coupon->id_discount_type = $id_discount_type == 2? 2 : 1;

					if (version_compare(_PS_VERSION_ , '1.3.0.4') != -1) {
						$coupon->id_currency = intval($id_currency);
					}
					
					$coupon->cart_display = 0;
					
					// fo ps 1.3 - 1.4
		    		if(Configuration::get($name_module.'isminamount') == true || 
		    		   Configuration::get($name_module.'isminamount') == 1){
							if(!$id_currency) $id_currency = 1;
							$coupon->minimal = Configuration::get('fbrefminamount_'.(int)$id_currency);
					}
				}
			
	    	
			// shared data
			$coupon->value = floatval($value);
			$coupon->id_customer = $id_ref_user;
			$coupon->quantity = 1;
			$coupon->quantity_per_user = 1;
			
			// for ps 1.5.6.0
			if (version_compare(_PS_VERSION_, '1.5', '>')) 
	        	$coupon->cart_rule_restriction = ((Configuration::get($name_module.'cumulativeother'))==0?1:0);
	        	 
			$coupon->cumulable = intval(Configuration::get($name_module.'cumulativeother'));
			
			$coupon->cumulable_reduction = intval(Configuration::get($name_module.'cumulativereduc'));
			
			$coupon->active = 1;
			$coupon->date_from = self::dateCommand('DATE_START');
			$coupon->date_to = self::dateCommand('DATE_END');

			Db::getInstance()->Execute('BEGIN');
			
	        $is_voucher_create = false;
	        if (version_compare(_PS_VERSION_, '1.5', '>')) {
	        	
	        	$is_voucher_create = $coupon->add(true, false);
	        	
	        	if ($is_voucher_create && sizeof($category)>0) 
	        	{
					// add a cart rule
					$is_voucher_create = self::addProductRule($coupon->id, 1, 'categories', $category);
				}
	        } else {
	        	// create voucher and add a cart rule (if exists)
	        	$is_voucher_create = $coupon->add(true, false, (sizeof($category)>0?$category:null));
	        }
	        
	        
	        if($is_voucher_create)
	        	Db::getInstance()->Execute('COMMIT');
	        else 
	        	Db::getInstance()->Execute('ROLLBACK');
	        
	        $coupon_id = (int)$coupon->id;
	        
    		if(version_compare(_PS_VERSION_, '1.5', '>')){
				$id_shop = Context::getContext()->shop->id;
	 		} else {
				$id_shop = 0;
	 		}
	 		
	        $query = 'UPDATE '._DB_PREFIX_.'four_referral SET coupon_id = "'.$coupon_id.'"
	        				 WHERE user_id = "'.$id_ref_user.'" and type="'.$type_social_referral.'" 
	        				 	AND coupon_id = "0" AND id_shop='.$id_shop.' and id_product='.$id_product;
	        Db::getInstance()->Execute($query);
	        
	        ### send notifications when user get Voucher for Discount ###
	        if($id_ref_user!=0 && $is_voucher_create){
	        	$data_voucher = array('voucher_code'=>$codename,'date_until' => self::dateCommand('DATE_END'));
	        	
	        	$customer_data = self::getInfoAboutCustomer(array('id_customer'=>$id_ref_user));
				
	        	self::sendNotificationCreatedVoucher(
    												array(
    													  'email_customer'=>$customer_data['email'],
    													  'data_voucher'=>$data_voucher
    													  )
    												  );
	        }
			### send notifications when user get Voucher for Discount ###
	        
	        
			return array('voucher_code'=>$codename,'date_until' => self::dateCommand('DATE_END'),
	        			 'is_get_voucher'=>1);
			
    	} else {
    		
    		
    		$type = 0;
			if($data_type == 'facebook'){
				// facebook
				$type = 1;
				$refnum =  Configuration::get($name_module.'frefnum');
				
			} elseif($data_type == 'twitter'){
				$type=2;
				$refnum =  Configuration::get($name_module.'trefnum');
				
			} elseif($data_type == 'google'){
				$type=4;
				$refnum =  Configuration::get($name_module.'grefnum');
				
			} elseif($data_type == 'linkedin'){
				$refnum =  Configuration::get($name_module.'lrefnum');
				
				$type=3;
			}
			
			
			
			
    		return array('need_referrals_for_discount'=>$refnum,
    					 'have_referrals' => $count_ref,
	        			 'is_get_voucher'=>0);
		}
    	
    	
    }
    
    
public static function sendNotificationCreatedVoucher($data = null){
		
			include_once(dirname(__FILE__).'/../propack.php');
			$obj = new propack();
			$data_translate = $obj->translateText();
			
			$email_customer = $data['email_customer'];
			
			$firsttext = $data_translate['firsttext'];
			$discountvalue = $data_translate['discountvalue'];
			
			$secondtext = $data_translate['secondtext'];
			$threetext = $data_translate['threetext'];
			$voucher_code = $data['data_voucher']['voucher_code'];
			$date_until = $data['data_voucher']['date_until'];
			
		  if (version_compare(_PS_VERSION_, '1.5', '>')){
		    $context = Context::getContext();
		    $cookie = $context->cookie;
    	  } else {
		    global $cookie;
		  }
			
			/* Email generation */
			$templateVars = array(
				'{firsttext}' => $firsttext,
				'{discountvalue}' => $discountvalue,
				'{secondtext}' => $secondtext,
				'{threetext}' => $threetext,
				'{voucher_code}' => $voucher_code,
				'{date_until}' => $date_until
			);
			$id_lang = intval($cookie->id_lang);	

			// get iso lang
			$iso_code = Language::getIsoById($id_lang);

			
			if (is_dir(_PS_MODULE_DIR_ . 'propack/mails/' . $iso_code . '/') && !empty($iso_code)) {
				
				$id_lang_mail = $id_lang;
				
			} else {
				// get default language
				$id_lang_mail = Configuration::get('PS_LANG_DEFAULT');
			}
			
			
			/* Email sending */
			@Mail::Send($id_lang_mail, 'voucher', $data_translate['get_voucher'], $templateVars, 
				$email_customer, 'Reviews Form', NULL, NULL,
				NULL, NULL, dirname(__FILE__).'/../mails/');
		
		
	}
	
	
public static function getInfoAboutCustomer($data=null){
		$id_customer = (int) $data['id_customer'];
		//get info about customer
		if(version_compare(_PS_VERSION_, '1.5', '>')){
			$id_shop = Context::getContext()->shop->id;
		$sql = '
	        	SELECT * FROM `'._DB_PREFIX_.'customer` 
		        WHERE `active` = 1 AND `id_customer` = \''.$id_customer.'\'  
		        AND `deleted` = 0 AND id_shop = '.$id_shop.'  '.(defined(_MYSQL_ENGINE_)?"AND `is_guest` = 0":"").'
		        ';
		} else {
		$sql = '
	        	SELECT * FROM `'._DB_PREFIX_.'customer` 
		        WHERE `active` = 1 AND `id_customer` = \''.$id_customer.'\'  
		        AND `deleted` = 0 '.(defined(_MYSQL_ENGINE_)?"AND `is_guest` = 0":"").'
		        ';
		}
		$result = Db::getInstance()->GetRow($sql);
		$email = $result['email'];
		
		return array('email'=>$email);
	}
    
    
  public static function addProductRule($iCartRuleId, $iQuantity, $sType, array $aIds)
	{
		$bInsert = false;

		// set transaction
		Db::getInstance()->Execute('BEGIN');

		$sQuery = 'INSERT INTO ' . _DB_PREFIX_ . 'cart_rule_product_rule_group (id_cart_rule, quantity) VALUES('
			. $iCartRuleId . ', ' . $iQuantity . ')';

		// only if group rule is added
		if (Db::getInstance()->Execute($sQuery)) {

			$sQuery = 'INSERT INTO ' . _DB_PREFIX_ . 'cart_rule_product_rule (id_product_rule_group, type) VALUES('
				. Db::getInstance()->Insert_ID() . ', "' . $sType . '")';

			// only if product rule is added
			if (Db::getInstance()->Execute($sQuery)) {

				if (!empty($aIds)) {
					$bInsert = true;

					$iLastInsertId = Db::getInstance()->Insert_ID();

					foreach ($aIds as $iId) {
						$sQuery = 'INSERT INTO ' . _DB_PREFIX_ . 'cart_rule_product_rule_value (id_product_rule, id_item) VALUES('
							. $iLastInsertId . ', ' . $iId . ')';

						if (!Db::getInstance()->Execute($sQuery)) {
							$bInsert = false;
						}
					}
				}
			}
		}
		// commit or rollback transaction
		$bInsert = ($bInsert)? Db::getInstance()->Execute('COMMIT') : Db::getInstance()->Execute('ROLLBACK');

		return $bInsert;
	}
    
 	public static function dateCommand($key)
        {
        	$datepickerFrom = strtotime(date('Y-m-d H:i:s'));
        	
        	$datepickerTo = strtotime(date('Y-m-d H:i:s')) + Configuration::get('propacktvalid')*60*60;
        	
            $date = array(
                'DATE_START' => date('Y-m-d H:i:s',$datepickerFrom),
                'DATE_END' => date('Y-m-d H:i:s',$datepickerTo),
                );
            return $date[$key];
        }
	
}