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

class login {
	
	private $_action;
	private $_http_host;
	private $_http_referer;
	private $_name;
	
	public function __construct($data){
		
		$this->_name =  'propack'; 
		
		$this->_action = $data['p'];
		$this->_http_referer = $data['http_referer'];
		
		
		if(version_compare(_PS_VERSION_, '1.6', '>')){
			$this->_http_host = Tools::getShopDomainSsl(true, true).__PS_BASE_URI__; 
		} else {
			$this->_http_host = _PS_BASE_URL_.__PS_BASE_URI__;
		}
		$this->initContext();
    }
    
	
	private function initContext()
	{
	  if (version_compare(_PS_VERSION_, '1.5', '>'))
	    $this->context = Context::getContext();
	  else
	  {
	    global $smarty, $cookie;
	    $this->context = new StdClass();
	    $this->context->smarty = $smarty;
	    $this->context->cookie = $cookie;
	  }
	}
	
 	public function mainAction(){
 		
 		$request = $this->_action;
 		
 		if ( $request == 'google')
 			$this->loginpro(array('pro'=>'1'));
 		else{	
 			header('Location: '.$this->_http_host.'modules/'.$this->_name.'/template/services/'.$request.'.php?host='.$this->_http_host);
 		}
      
 		
  	}
  	
  	
 	private function userLog($_data){				
		$_email = ($_data['contact/email']) ? $_data['contact/email'] : '';	
		
		$openid_identifier = isset($_SESSION['openid_identifier'])?$_SESSION['openid_identifier']:null;
		
		if ($openid_identifier && $_email == '')
			$_email = $openid_identifier;
			
		
		
		$_data_user =  $this->checkExist($_email);
        $_customer_id 	= (int) $_data_user['customer_id'];
        $_result = $_data_user['result'];	
        
        if (!$_customer_id)
            $this->createUser($_data,$_email);
        else
            $this->loginUser($_customer_id,$_result);
            
       $cookie = $this->context->cookie;
		$id_lang = (int)$cookie->id_lang;
		
 		$iso_lang = '';
		if(version_compare(_PS_VERSION_, '1.6', '>')){
			if(sizeof(Language::getLanguages())>1){
				$iso_lang = Language::getIsoById(intval($id_lang))."/";   
			} else {
				$iso_lang = "";
			}
		} else {
			// for ps 1.3
			if(version_compare(_PS_VERSION_, '1.4', '>'))
				$iso_lang = Language::getIsoById(intval($id_lang))."/";   
		}
		
        // if order page    
        if(version_compare(_PS_VERSION_, '1.5', '>')){
	        $data = explode("?",$this->_http_referer);
	    	$data  = end($data);
	    	$data_url_rewrite_on = explode("/",$this->_http_referer);
	    	$data_url_rewrite_on = end($data_url_rewrite_on);
	    	
	    	if(Configuration::get('PS_REWRITING_SETTINGS'))
	    		$uri = $iso_lang.'my-account';
	    	else 
	    		$uri = 'index.php?controller=my-account&id_lang='.$id_lang;
	    	
	        if($data == 'controller=order' || $data_url_rewrite_on == 'order'){
	    		if($data == 'controller=order')
	    			$uri = 'index.php?controller=order&step=1&id_lang='.$id_lang;
	    		elseif($data_url_rewrite_on == 'order')
	    		 	$uri = $iso_lang.'order?step=1';
	    	}
	    } else {
	    	$data = explode("/",$this->_http_referer);
	    	$data  = end($data);
	    	
	    	if(Configuration::get('PS_REWRITING_SETTINGS') && version_compare(_PS_VERSION_, '1.4', '>'))
	    		$uri = $iso_lang.'my-account';
	    	else 
	    		$uri = 'my-account.php?id_lang='.$id_lang;
	    	
	    	if($data == 'order.php' 
	    	|| $data == 'order'
	    	){
	    		if($data == 'order.php')
	    			$uri = 'order.php?step=1&id_lang='.$id_lang;
	    		elseif($data == 'order')
	    		 	$uri = $iso_lang.'order?step=1';
	    	}
	    }
    	// if order page    
        
	      
		echo '<script>
				 window.opener.location.href = \''.$this->_http_host.$uri.'\';
				 window.opener.focus();
			     window.close();
				</script>';
    }
    
    private function loginUser($_customer, $result){
    	$cookie = $this->context->cookie;
		// authentication
		if ($result){
		    $customer = new Customer();
		    
		    $customer->id = $_customer;
		    unset($result['id_customer']);
		    foreach ($result AS $key => $value)
		       if (key_exists($key, $customer))
		             $customer->{$key} = $value;
	     }
	        
	    $cookie->id_customer = intval($customer->id);
	    $cookie->customer_lastname = $customer->lastname;
	    $cookie->customer_firstname = $customer->firstname;
	    $cookie->logged = 1;
	    $cookie->passwd = $customer->passwd;
	    $cookie->email = $customer->email;
	    if (Configuration::get('PS_CART_FOLLOWING') AND (empty($cookie->id_cart) 
	     	OR Cart::getNbProducts($cookie->id_cart) == 0))
	    $cookie->id_cart = intval(Cart::lastNoneOrderedCart(intval($customer->id)));
	    if(version_compare(_PS_VERSION_, '1.5', '>')){
			Hook::exec('authentication');
		} else {
		       	Module::hookExec('authentication');
		}
    }
    
    private function deldigit($str){
    	$arr_out = array('');
		$arr_in = array(0,1,2,3,4,5,6,7,8,9,'_','(',')',',','.','-','+','&');

		$textout = str_replace($arr_in,$arr_out,$str);
		
		return $textout;
    
    }


    
    private function createUser($_data,$_email){
    		
		
			//// create new user ////
			//$gender = 1;
			$gender = ((isset($_data['person/gender']) && $_data['person/gender'] == 'M') || !isset($_data['person/gender']))?1:2;
			
    	
    	
    		if(version_compare(_PS_VERSION_, '1.5', '>')){
				$id_default_group = 3;
 			} else {
				$id_default_group = 1;
 			}
			
			if(isset($_data['namePerson/first']) && isset($_data['namePerson/last'])){
				$firstname = $this->deldigit(pSQL($_data['namePerson/first']));
				$lastname = $this->deldigit(pSQL($_data['namePerson/last']));
			}elseif(isset($_data['namePerson'])){
				$pattern = ("|^(.+?) (.*)$|su");
				preg_match($pattern, $_data['namePerson'], $arg);
				
				if(sizeof($arg)>0){
				$firstname = $this->deldigit(pSQL($arg[1]));
				$lastname = $this->deldigit(pSQL($arg[2]));
				} else {
					$firstname = $this->deldigit(pSQL($_data['namePerson']));
					$lastname = $this->deldigit(pSQL($_data['namePerson']));
				}
			}else{
				$firstname = $this->deldigit(pSQL($_data['namePerson/friendly']));
				$lastname = $this->deldigit(pSQL($_data['namePerson/friendly']));
			}
			
			
			$email = $_data['contact/email'];

			// generate passwd
			srand((double)microtime()*1000000);
			$passwd = substr(uniqid(rand()),0,12);
			$real_passwd = $passwd; 
			$passwd = md5(pSQL(_COOKIE_KEY_.$passwd)); 
			
			$last_passwd_gen = date('Y-m-d H:i:s', strtotime('-'.Configuration::get('PS_PASSWD_TIME_FRONT').'minutes'));
			$secure_key = md5(uniqid(rand(), true));
			$active = 1;
			$date_add = date('Y-m-d H:i:s'); //'2011-04-04 18:29:15';
			$date_upd = $date_add;
			
			if(strlen($firstname)==0 || strlen($lastname) == 0){
				
				$pattern = ("|(.*)@.*|U");
				preg_match_all($pattern, $_email, $arg, PREG_SET_ORDER);
				$out  =  isset($arg[0][1])?$arg[0][1]:null;
				$firstname = $out;
				$lastname = $out;
				
				// openID fixed
				if(empty($out) && strlen($_email)>0){
					$email = $_email."@gmail.com";
					$firstname = $this->deldigit($_email);
					$lastname = $this->deldigit($_email);
					
					$_data_user =  $this->checkExist($email);
        			$_customer_id 	= (int) $_data_user['customer_id'];
        			// livejournal
        			if($_customer_id){
        				$_random_digit = rand(1,80);
        				$email = $_email.$_random_digit."@gmail.com";
        			}
        		} 
        		
        		
        		if(strlen($firstname)==0 || strlen($lastname)==0) {
					$status = 'error';
					echo 'Empty First Name and Last Name!';
					break;
				}
				
				
			}
			
			$_data_user_exist =  $this->checkExist($email);
			$_customer_id_exits = (int) $_data_user_exist['customer_id'];
			if($_customer_id_exits){
				
				$cookie = $this->context->cookie;
				// authentication
				if(version_compare(_PS_VERSION_, '1.5', '>')){
				$sql = 'SELECT * FROM `'._DB_PREFIX_   .'customer` 
			        	WHERE `active` = 1 AND `email` = \''.pSQL($email).'\'  
			        	AND `deleted` = 0 '.(defined('_MYSQL_ENGINE_')?"AND `is_guest` = 0":"").' 
			        	AND `id_shop` = '.$this->getIdShop().'
			        	'; 	
				} else {
				$sql = 'SELECT * FROM `'._DB_PREFIX_   .'customer` 
			        	WHERE `active` = 1 AND `email` = \''.pSQL($email).'\'  
			        	AND `deleted` = 0 '.(defined('_MYSQL_ENGINE_')?"AND `is_guest` = 0":"").'
			        	'; 
				}
				$result = Db::getInstance()->GetRow($sql);
				
				if ($result){
				    $customer = new Customer();
				    
				    $customer->id = $result['id_customer'];
			        foreach ($result AS $key => $value)
			            if (key_exists($key, $customer))
			                $customer->{$key} = $value;
		        }
		        
		        $cookie->id_customer = intval($customer->id);
		        $cookie->customer_lastname = $customer->lastname;
		        $cookie->customer_firstname = $customer->firstname;
		        $cookie->logged = 1;
		        $cookie->passwd = $customer->passwd;
		        $cookie->email = $customer->email;
		        if (Configuration::get('PS_CART_FOLLOWING') AND (empty($cookie->id_cart) 
		        	OR Cart::getNbProducts($cookie->id_cart) == 0))
		            $cookie->id_cart = intval(Cart::lastNoneOrderedCart(intval($customer->id)));
				if(version_compare(_PS_VERSION_, '1.5', '>')){
					Hook::exec('authentication');
				} else {
				       	Module::hookExec('authentication');
				}
	        
			} else {
			
			if(version_compare(_PS_VERSION_, '1.5', '>')){
				
			$id_shop_group = Context::getContext()->shop->id_shop_group;
				
			$sql = 'insert into `'._DB_PREFIX_.'customer` SET 
					   id_shop = '.$this->getIdShop().', id_shop_group = '.$id_shop_group.',
					   id_gender = '.$gender.', id_default_group = '.$id_default_group.',
					   firstname = \''.$firstname.'\', lastname = \''.$lastname.'\',
					   email = \''.$email.'\', passwd = \''.$passwd.'\',
					   last_passwd_gen = \''.$last_passwd_gen.'\',
					   secure_key = \''.$secure_key.'\', active = '.$active.',
					   date_add = \''.$date_add.'\', date_upd = \''.$date_upd.'\' ';
			
			} else {

			$sql = 'insert into `'._DB_PREFIX_.'customer` SET 
						   id_gender = '.$gender.', id_default_group = '.$id_default_group.',
						   firstname = \''.$firstname.'\', lastname = \''.$lastname.'\',
						   email = \''.$email.'\', passwd = \''.$passwd.'\',
						   last_passwd_gen = \''.$last_passwd_gen.'\',
						   secure_key = \''.$secure_key.'\', active = '.$active.',
						   date_add = \''.$date_add.'\', date_upd = \''.$date_upd.'\' ';
			
			}
			
		
			Db::getInstance()->Execute($sql);
			$insert_id = Db::getInstance()->Insert_ID();
			
			
			
			// insert record in customer group
			if(version_compare(_PS_VERSION_, '1.5', '>')){
				$id_group = 3; // customer
			} else {
				$id_group = 1;
			}
			
			$sql = 'INSERT into `'._DB_PREFIX_.'customer_group` SET 
						   id_customer = '.$insert_id.', id_group = '.$id_group.' ';
			Db::getInstance()->Execute($sql);
			
			// auth customer
			$cookie = $this->context->cookie;
			$customer = new Customer();
	        $authentication = $customer->getByEmail(trim($email), trim($real_passwd));
	        if (!$authentication OR !$customer->id) {
	        	$status = 'error';
				echo 'Authentication failed!';
	        }
	        else
	        {
	            $cookie->id_customer = intval($customer->id);
	            $cookie->customer_lastname = $customer->lastname;
	            $cookie->customer_firstname = $customer->firstname;
	            $cookie->logged = 1;
	            $cookie->passwd = $customer->passwd;
	            $cookie->email = $customer->email;
	            if (Configuration::get('PS_CART_FOLLOWING') AND (empty($cookie->id_cart) OR Cart::getNbProducts($cookie->id_cart) == 0))
	                $cookie->id_cart = intval(Cart::lastNoneOrderedCart(intval($customer->id)));
	        
				if(version_compare(_PS_VERSION_, '1.5', '>')){
					Hook::exec('authentication');
				} else {
				       	Module::hookExec('authentication');
				}
	        }
			
			
			Mail::Send(intval($cookie->id_lang), 'account', 'Welcome!', 
    						array('{firstname}' => $customer->firstname, 
    							  '{lastname}' => $customer->lastname, 
    							  '{email}' => $customer->email, 
    							  '{passwd}' => $real_passwd), 
    							  $customer->email,
    							  $customer->firstname.' '.$customer->lastname);
			}
    }
    
    private function getIdShop(){
    	if(version_compare(_PS_VERSION_, '1.5', '>')){
        	$id_shop = Context::getContext()->shop->id;
        } else {
        	$id_shop = 0;
        }
        return $id_shop;
    }
    
	private function checkExist($email){        
		
		if(version_compare(_PS_VERSION_, '1.5', '>')){
			$sql = 'SELECT * FROM `'._DB_PREFIX_   .'customer` 
		        	WHERE `active` = 1 AND `email` = \''.pSQL($email).'\'  
		        	AND `deleted` = 0 '.(defined('_MYSQL_ENGINE_')?"AND `is_guest` = 0":"").' 
		        	AND `id_shop` = '.$this->getIdShop().'
		        	'; 	
		} else {
			$sql = 'SELECT * FROM `'._DB_PREFIX_   .'customer` 
		        	WHERE `active` = 1 AND `email` = \''.pSQL($email).'\'  
		        	AND `deleted` = 0 '.(defined('_MYSQL_ENGINE_')?"AND `is_guest` = 0":"").'
		        	'; 
		}
		
		$result = Db::getInstance()->GetRow($sql);
		
		$_customer = $result['id_customer'];
		
		return array('customer_id' => $_customer, 'result' => $result);
    }
    
	public function loginpro($data){
		$pro = $data['pro'];
        try {
            $openid = new LightOpenID($this->_http_host);
            if(!$openid->mode) {
                if($pro) {
                    $openid->required = array('namePerson/friendly', 'contact/email', 'namePerson/first', 'namePerson/last','person/gender', 'namePerson');
                    $openid->identity = 'https://www.google.com/accounts/o8/id';    
                    header('Location: '.$openid->authUrl());                
                   
                }
            } elseif($openid->mode == 'cancel') {
                echo 'User has canceled authentication!';
            } else {
                echo 'User ' . ($openid->validate() ? $openid->identity . ' has ' : 'has not ') . 'logged in.';                
				$this->userLog($openid->getAttributes());
            }
        } catch(ErrorException $e) {
            echo $e->getMessage();
        }
    }
    
	public function loginYahoo(){		
		try {
            $openid = new LightOpenID($this->_http_host);
            
            if(!$openid->mode) {
                //if(isset($_POST['openid_identifier'])) {
					$_SESSION['openid_identifier'] = 'me.yahoo.com/';
					
                    //$service_url = $_POST['service_url'];
                    $openid->required = array('contact/email');
           			$openid->optional = array('namePerson', 'namePerson/friendly');
                                        
                    //$openid->identity = $service_url.$_POST['openid_identifier'];
                      
                    $openid->identity = 'me.yahoo.com/';
                    
                    header('Location: '.$openid->authUrl());
                   
                //}
            } elseif($openid->mode == 'cancel') {
                echo 'User has canceled authentication!';
            } else {
                echo 'User ' . ($openid->validate() ? $openid->identity . ' has ' : 'has not ') . 'logged in.';                		
				$this->userLog($openid->getAttributes());
            }
        } catch(ErrorException $e) {
            echo $e->getMessage();
        }
  }
  
  public function loginCustom(){		
		try {
            $openid = new LightOpenID($this->_http_host);
            
            if(!$openid->mode) {
                if(isset($_POST['openid_identifier'])) {
					$_SESSION['openid_identifier'] = $_POST['openid_identifier'];
					
                    $service_url = $_POST['service_url'];
                    $openid->required = array('contact/email');
           			$openid->optional = array('namePerson', 'namePerson/friendly');
                                        
                   if ($service_url == 'clavid.com' || $service_url == 'wordpress.com' 
                   		|| $service_url == 'blogspot.com' || $service_url == 'myid.net'
                    	 || $service_url == 'livejournal.com' || $service_url == 'myopenid.com')
                        $openid->identity = $_POST['openid_identifier'].'.'.$service_url;
                   else
                        $openid->identity = $service_url.$_POST['openid_identifier'];
                      
                    header('Location: '.$openid->authUrl());
                   
                }
            } elseif($openid->mode == 'cancel') {
                echo 'User has canceled authentication!';
            } else {
                echo 'User ' . ($openid->validate() ? $openid->identity . ' has ' : 'has not ') . 'logged in.';                		
				$this->userLog($openid->getAttributes());
            }
        } catch(ErrorException $e) {
            echo $e->getMessage();
        }
  }
    
    
    
	
    
}

?>