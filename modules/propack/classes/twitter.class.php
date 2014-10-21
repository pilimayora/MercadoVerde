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

class twitter {
	 private $consumer_key;
    private $consumer_secret;
    private $oauth_callback;
    private $_http_host;
    private $_http_referer;
    private $_name;
    
    
	
	public function __construct($data){
		$this->consumer_key = $data['key'];
		$this->consumer_secret = $data['secret'];
		$this->oauth_callback = $data['callback'];
		$this->_http_referer = $data['http_referer'];

		$this->_name = "propack";
		
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
	    global $cookie;
	    $this->context = new StdClass();
	    $this->context->cookie = $cookie;
	  }
	}
	
	function translite($str){
	
	static $tbl= array(
		' '=>"",'('=>'',')'=>'',','=>'','.'=>'','-'=>'','_'=>'',
		'+'=>'','&'=>'',1=>'',2=>'',3=>'',4=>'',5=>'',6=>'',7=>'',8=>'',9=>''
	);

    return strtr($str, $tbl);
	}
	
	 private function deldigit($str){
    	$arr_out = array('');
		$arr_in = array(0,1,2,3,4,5,6,7,8,9);

		$textout = str_replace($arr_in,$arr_out,$str);
		
		return $textout;
    
    }
    
	
	function createTwitterUser($_data){
				
			$twitter_id = $_data->id;
			
			//// create new user ////
			$gender = 2;
			if(version_compare(_PS_VERSION_, '1.5', '>')){
				$id_default_group = 3;
 			} else {
				$id_default_group = 1;
 			}
 			
			$firstname = $this->deldigit(pSQL($this->translite($_data->name)));
			$lastname = $this->deldigit(pSQL($this->translite($_data->name)));
			#### show popup for twitter customer which not changed email address  #####
			$email = strtolower($this->translite($_data->name))."@twitter.com";
			#### show popup for twitter customer which not changed email address  #####

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
			
			$result = Db::getInstance()->Execute($sql);
			
			$insert_id = Db::getInstance()->Insert_ID();
			
			// insert record in customer group
			if(version_compare(_PS_VERSION_, '1.5', '>')){
				$id_group = 3; // customer
			} else {
				$id_group = 1;
			}
			
			$sql = 'INSERT into `'._DB_PREFIX_.'customer_group` SET 
						   id_customer = '.$insert_id.', id_group = '.$id_group.' ';
			$result = Db::getInstance()->Execute($sql);
			
			
			// insert record into customerXfacebook table
			$sql_exists= 'SELECT `user_id`
					FROM `'._DB_PREFIX_.'tw_customer`
					WHERE `twitter_id` = '.$twitter_id.' AND id_shop = '.$this->getIdShop().'
					LIMIT 1';
			$result_exists = Db::getInstance()->ExecuteS($sql_exists);
			if($result_exists[0]['user_id']){
				$sql_del = 'DELETE FROM `'._DB_PREFIX_.'tw_customer` WHERE `user_id` = '.$result_exists[0]['user_id'].' 
							AND id_shop = '.$this->getIdShop().'';
				Db::getInstance()->Execute($sql_del);
			}
			
			$sql = 'INSERT into `'._DB_PREFIX_.'tw_customer` SET
						   user_id = '.$insert_id.', twitter_id = '.$twitter_id.' , id_shop = '.$this->getIdShop().'';
			$result = Db::getInstance()->Execute($sql);
			//// end create new user ///
			
			
			
			// auth customer
			$cookie = $this->context->cookie;
			$customer = new Customer();
	        $authentication = $customer->getByEmail(trim($email), trim($real_passwd));
	        if (!$authentication OR !$customer->id) {
	        	//$status = 'error';
				echo 'authentication failed!';
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
					Hook::exec('actionAuthentication');
				} else {
				    Module::hookExec('authentication');
				}
	        }
			
			
	}
	
	function loginTwitterUser($_data){

			
			$twitter_id = $_data->id;
			$cookie = $this->context->cookie;
			// authentication
			
			if(version_compare(_PS_VERSION_, '1.5', '>')){
			$sql = '
	        	SELECT c.* FROM `'._DB_PREFIX_   .'customer` c 
	        		left join '._DB_PREFIX_.'tw_customer tc
	        		on(tc.user_id = c.id_customer)
		        WHERE c.`active` = 1 AND tc.`twitter_id` = '.$twitter_id.'  AND c.id_shop = '.$this->getIdShop().'
		        AND tc.id_shop = '.$this->getIdShop().'
		        AND c.`deleted` = 0 '.(defined('_MYSQL_ENGINE_')?'AND c.`is_guest` = 0':'').'
		        ';
			} else {
				$sql = '
	        	SELECT c.* FROM `'._DB_PREFIX_   .'customer` c 
	        		left join '._DB_PREFIX_.'tw_customer tc
	        		on(tc.user_id = c.id_customer)
		        WHERE c.`active` = 1 AND tc.`twitter_id` = '.$twitter_id.'
		        AND c.`deleted` = 0 '.(defined('_MYSQL_ENGINE_')?'AND c.`is_guest` = 0':'').'
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
				Hook::exec('actionAuthentication');
			} else {
			       	Module::hookExec('authentication');
			}
	}
	
	public function connect(){
		
        if ($this->consumer_key === '' || $this->consumer_secret === '') {
          echo 'You need a consumer key and secret to test the sample code. Get one from <a href="https://twitter.com/apps">https://twitter.com/apps</a>';
          exit;
        }
        
        $connection = new TwitterOAuth($this->consumer_key, $this->consumer_secret);

        /* Get temporary credentials. */
        $request_token = $connection->getRequestToken();        
        /* Save temporary credentials to session. */
        $_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
        $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

        /* If last connection failed don't display authorization link. */
        switch ($connection->http_code) {
          case 200:
            /* Build authorize URL and redirect user to Twitter. */
            $url = $connection->getAuthorizeURL($token);
            //var_dump($url);
            header('Location: '.$url);
            break;
          default:
            /* Show notification if something went wrong. */
            echo 'Could not connect to Twitter. Refresh the page or try again later.';
        }
	}
	
	public function callback(){
		
	 	if (isset($_REQUEST['oauth_token']) && $_SESSION['oauth_token'] !== $_REQUEST['oauth_token']) {
          $_SESSION['oauth_status'] = 'oldtoken';
	 	  if(defined('_MYSQL_ENGINE_')){
          	header('Location: '.$this->_http_host.'modules/'.$this->_name.'/twitter.php?action=connect');
          } else {
          	header('Location: '.$this->_http_host.'twitter.php?action=connect');
          }
          
        }

        /* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
        $connection = new TwitterOAuth($this->consumer_key, $this->consumer_secret,
        							 $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

        /* Request access tokens from twitter */
        $access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

        /* Save the access tokens. Normally these would be saved in a database for future use. */
        $_SESSION['access_token'] = $access_token;

        /* Remove no longer needed request tokens */
        unset($_SESSION['oauth_token']);
        unset($_SESSION['oauth_token_secret']);

        /* If HTTP response is 200 continue otherwise send to connect page to retry */
        if (200 == $connection->http_code) {
          /* The user has been verified and the access tokens can be saved for future use */
          $_SESSION['status'] = 'verified';
          if(defined('_MYSQL_ENGINE_')){
          	 header('Location: '.$this->_http_host.'modules/'.$this->_name.'/twitter.php?action=login');
          } else {
          	header('Location: '.$this->_http_host.'twitter.php?action=login');
          }
         
        } else {
          /* Save HTTP status for error dialog on connnect page.*/
            if(defined('_MYSQL_ENGINE_')){
          		header('Location: '.$this->_http_host.'modules/'.$this->_name.'/twitter.php?action=connect');
        	 } else {
        	 	header('Location: '.$this->_http_host.'twitter.php?action=connect');
        	 }
          
        }
		
	}
	
	public function login(){
		
		if (empty($_SESSION['access_token']) 
				|| empty($_SESSION['access_token']['oauth_token'])
				|| empty($_SESSION['access_token']['oauth_token_secret'])
				) 
				{
			     	$this->connect();
			    }
			    
			 /* Get user access tokens out of the session. */
			 $access_token = $_SESSION['access_token'];
			
			 /* Create a TwitterOauth object with consumer/user tokens. */
			 $connection = new TwitterOAuth($this->consumer_key,$this->consumer_secret, 
			   								$access_token['oauth_token'], 
			   								$access_token['oauth_token_secret']);
			      								
			  /* If method is set change API call made. Test is called by default. */
			  $content = $connection->get('account/verify_credentials'); 
			  
	  if ($content->id){
			  		
			  	$result = $this->checkExist($content->id);
			         
			  	$result_dublicate = $this->checkForDublicate(
			    	array(//'email'=>strtolower($this->translite($content->name))."@twitter.com"
			    		 'id_customer'=>$result)
			    );
			    $exists_mail = $result_dublicate['exists_mail'];
			        
			    $auth = 0;
				if($result && $exists_mail){
					$auth = 1;
				}
				
			    if(!$result && $exists_mail){
			    	// insert record into customerXtwitter table
					$sql = 'INSERT into `'._DB_PREFIX_.'tw_customer` SET
								   user_id = '.$result_dublicate['user_id'].', 
								   twitter_id = '.$content->id.', 
								   id_shop = '.$this->getIdShop().'';
					Db::getInstance()->Execute($sql);
					$auth = 1;
			
				}
				
				  if ($auth == 0){
			         $this->createTwitterUser($content);
			      } else {
			          $this->loginTwitterUser($content);
			      }
			      
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
			    	
			    	$link = new Link();
					$my_account = $link->getPageLink("my-account", true, $id_lang);
	    	
	    			if(Configuration::get('PS_REWRITING_SETTINGS')){
	    				$uri = str_replace($this->_http_host,'',$my_account);
			    	} else { 
			    		$uri = 'index.php?controller=my-account&id_lang='.$id_lang;
			    	}
			    	
			        if($data == 'controller=order' || $data_url_rewrite_on == 'order'){
			    		if($data == 'controller=order')
			    			$uri = 'index.php?controller=order&step=1&id_lang='.$id_lang;
			    		elseif($data_url_rewrite_on == 'order')
			    		 	$uri = $iso_lang.'order?step=1';
			    	}
			    } else {
			    	$data = explode("/",$this->_http_referer);
			    	$data  = end($data);
			    	
			    	if(Configuration::get('PS_REWRITING_SETTINGS') && version_compare(_PS_VERSION_, '1.4', '>')){
			    		$uri = $iso_lang.'my-account';
			    	} else { 
			    		$uri = 'my-account.php?id_lang='.$id_lang;
			    	}
			    	
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
	}
	
	 public function checkExist($id){
	 	
	 	$result = Db::getInstance()->ExecuteS('SELECT `user_id`
					FROM `'._DB_PREFIX_.'tw_customer`
					WHERE `twitter_id` = '.$id.' AND id_shop = '.$this->getIdShop().'
					LIMIT 1');
			$customer_id = isset($result[0]['user_id'])?(int)$result[0]['user_id']:0;
		return $customer_id;
	 }
	
	
public function checkForDublicate($data){
		//chek for dublicate
	
			if(version_compare(_PS_VERSION_, '1.5', '>')){
				$sql = '
		        	SELECT * FROM `'._DB_PREFIX_   .'customer` 
			        WHERE `active` = 1 AND `id_customer` = \''.pSQL($data['id_customer']).'\' 
			        AND id_shop = '.$this->getIdShop().' 
			        AND `deleted` = 0 '.(@defined(_MYSQL_ENGINE_)?"AND `is_guest` = 0":"").'
			        ';
			} else {
				$sql = '
		        	SELECT * FROM `'._DB_PREFIX_   .'customer` 
			        WHERE `active` = 1 AND `id_customer` = \''.pSQL($data['id_customer']).'\'  
			        AND `deleted` = 0 '.(@defined(_MYSQL_ENGINE_)?"AND `is_guest` = 0":"").'
			        ';
			}
			$result_exists_mail = Db::getInstance()->GetRow($sql);
			if($result_exists_mail)
				return array('exists_mail' => 1, 'user_id' => $result_exists_mail['id_customer']);
			else
				return array('exists_mail' => 0, 'user_id' =>0);
		
	}
	
private function getIdShop(){
    	if(version_compare(_PS_VERSION_, '1.5', '>')){
        	$id_shop = Context::getContext()->shop->id;
        } else {
        	$id_shop = 0;
        }
        return $id_shop;
    }
}