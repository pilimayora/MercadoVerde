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

class facebookhelp extends Module{
	
	private $_width = 400;
	private $_height = 400;
	private $_name = 'propack';
	
	
    
    public function __construct(){
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
    
	
	public function getImages($data = null){
			$admin = isset($data['admin'])?$data['admin']:0;
			
			// facebook
			$data_facebook = $this->_getImages(array('type_standart'=>1,'type_small'=>4,
													 'type_social' => 'facebook',
													 'admin' => $admin
											  		 )
											  );
			$facebook = $data_facebook['standart'];
			$img_facebook = $data_facebook['standart_block'];
			$facebooksmall = $data_facebook['small'];
			$img_facebooksmall = $data_facebook['small_block'];
			// facebook
			
			
			// paypal
			$data_paypal = $this->_getImages(array('type_standart'=>3,'type_small'=>6,
													 'type_social' => 'paypal',
													 'admin' => $admin
											  		 )
											  );
			$paypal = $data_paypal['standart'];
			$img_paypal = $data_paypal['standart_block'];
			$paypalsmall = $data_paypal['small'];
			$img_paypalsmall = $data_paypal['small_block'];
			// paypal
			
		
			
			// google
			$data_google = $this->_getImages(array('type_standart'=>2,'type_small'=>5,
													 'type_social' => 'google',
													 'admin' => $admin
											  		 )
											  );
			$google = $data_google['standart'];
			$img_google = $data_google['standart_block'];
			$googlesmall = $data_google['small'];
			$img_googlesmall = $data_google['small_block'];
			// google
			
			
			
			
			// twitter
			$data_twitter = $this->_getImages(array('type_standart'=>7,'type_small'=>8,
													 'type_social' => 'twitter',
													 'admin' => $admin
											  		 )
											  );
			$twitter = $data_twitter['standart'];
			$img_twitter = $data_twitter['standart_block'];
			$twittersmall = $data_twitter['small'];
			$img_twittersmall = $data_twitter['small_block'];
			// twitter
			
			// yahoo
			$data_yahoo = $this->_getImages(array('type_standart'=>9,'type_small'=>10,
													 'type_social' => 'yahoo',
													 'admin' => $admin
											  		 )
											  );
			$yahoo = $data_yahoo['standart'];
			$img_yahoo = $data_yahoo['standart_block'];
			$yahoosmall = $data_yahoo['small'];
			$img_yahoosmall = $data_yahoo['small_block'];
			// yahoo
			
			
			// linkedin
			$data_linkedin = $this->_getImages(array('type_standart'=>11,'type_small'=>12,
													 'type_social' => 'linkedin',
													 'admin' => $admin
											  		 )
											  );
			$linkedin = $data_linkedin['standart'];
			$img_linkedin = $data_linkedin['standart_block'];
			$linkedinsmall = $data_linkedin['small'];
			$img_linkedinsmall = $data_linkedin['small_block'];
			// linkedin
			
			
			// livejournal
			$data_livejournal  = $this->_getImages(array('type_standart'=>13,'type_small'=>14,
													 	'type_social' => 'livejournal',
													 	'admin' => $admin
											  		 )
											  );
			$livejournal = $data_livejournal['standart'];
			$img_livejournal = $data_livejournal['standart_block'];
			$livejournalsmall = $data_livejournal['small'];
			$img_livejournalsmall = $data_livejournal['small_block'];
			// livejournal
			
			// microsoft
			$data_microsoft  = $this->_getImages(array('type_standart'=>15,'type_small'=>16,
													 	'type_social' => 'microsoft',
													 	'admin' => $admin
											  		 )
											  );
			$microsoft = $data_microsoft['standart'];
			$img_microsoft = $data_microsoft['standart_block'];
			$microsoftsmall = $data_microsoft['small'];
			$img_microsoftsmall = $data_microsoft['small_block'];
			// microsoft
			
			// openid
			$data_openid  = $this->_getImages(array('type_standart'=>17,'type_small'=>18,
													 	'type_social' => 'openid',
													 	'admin' => $admin
											  		 )
											  );
			$openid = $data_openid['standart'];
			$img_openid = $data_openid['standart_block'];
			$openidsmall = $data_openid['small'];
			$img_openidsmall = $data_openid['small_block'];
			// openid
			
			// clavid
			$data_clavid  = $this->_getImages(array('type_standart'=>19,'type_small'=>20,
													 	'type_social' => 'clavid',
													 	'admin' => $admin
											  		 )
											  );
			$clavid = $data_clavid['standart'];
			$img_clavid = $data_clavid['standart_block'];
			$clavidsmall = $data_clavid['small'];
			$img_clavidsmall = $data_clavid['small_block'];
			// clavid
			
			// flickr
			$data_flickr  = $this->_getImages(array('type_standart'=>21,'type_small'=>22,
													 	'type_social' => 'flickr',
													 	'admin' => $admin
											  		 )
											  );
			$flickr = $data_flickr['standart'];
			$img_flickr = $data_flickr['standart_block'];
			$flickrsmall = $data_flickr['small'];
			$img_flickrsmall = $data_flickr['small_block'];
			// flickr
			
			// wordpress
			$data_wordpress  = $this->_getImages(array('type_standart'=>23,'type_small'=>24,
													 	'type_social' => 'wordpress',
													 	'admin' => $admin
											  		 )
											  );
			$wordpress = $data_wordpress['standart'];
			$img_wordpress = $data_wordpress['standart_block'];
			$wordpresssmall = $data_wordpress['small'];
			$img_wordpresssmall = $data_wordpress['small_block'];
			// wordpress
			
			// aol
			$data_aol  = $this->_getImages(array('type_standart'=>25,'type_small'=>26,
													 	'type_social' => 'aol',
													 	'admin' => $admin
											  		 )
											  );
			$aol = $data_aol['standart'];
			$img_aol = $data_aol['standart_block'];
			$aolsmall = $data_aol['small'];
			$img_aolsmall = $data_aol['small_block'];
			// aol
			
			
			return array('facebook'=>$facebook,'facebook_block'=> $img_facebook, 
						 'facebooksmall'=>$facebooksmall, 'facebook_blocksmall' => $img_facebooksmall,
						 'paypal'=>$paypal, 'paypal_block' => $img_paypal,
						 'paypalsmall'=>$paypalsmall, 'paypal_blocksmall' => $img_paypalsmall,
						 'google' => $google, 'google_block' => $img_google,
						 'googlesmall' => $googlesmall, 'google_blocksmall' => $img_googlesmall ,
						 'twitter' => $twitter, 'twitter_block' => $img_twitter,
						 'twittersmall' => $twittersmall, 'twitter_blocksmall' => $img_twittersmall, 
						 'yahoo' => $yahoo, 'yahoo_block' => $img_yahoo,
						 'yahoosmall' => $yahoosmall, 'yahoo_blocksmall' => $img_yahoosmall,
						 'linkedin' => $linkedin, 'linkedin_block' => $img_linkedin,
						 'linkedinsmall' => $linkedinsmall, 'linkedin_blocksmall' => $img_linkedinsmall ,
						 'livejournal' => $livejournal, 'livejournal_block' => $img_livejournal,
						 'livejournalsmall' => $livejournalsmall, 'livejournal_blocksmall' => $img_livejournalsmall,
						 'microsoft' => $microsoft, 'microsoft_block' => $img_microsoft,
						 'microsoftsmall' => $microsoftsmall, 'microsoft_blocksmall' => $img_microsoftsmall,    
						 'openid' => $openid, 'openid_block' => $img_openid,
						 'openidsmall' => $openidsmall, 'openid_blocksmall' => $img_openidsmall,    
						 'clavid' => $clavid, 'clavid_block' => $img_clavid,
						 'clavidsmall' => $clavidsmall, 'clavid_blocksmall' => $img_clavidsmall,    
						 'flickr' => $flickr, 'flickr_block' => $img_flickr,
						 'flickrsmall' => $flickrsmall, 'flickr_blocksmall' => $img_flickrsmall,    
						 'wordpress' => $wordpress, 'wordpress_block' => $img_wordpress,
						 'wordpresssmall' => $wordpresssmall, 'wordpress_blocksmall' => $img_wordpresssmall,    
						 'aol' => $aol, 'aol_block' => $img_aol,
						 'aolsmall' => $aolsmall, 'aol_blocksmall' => $img_aolsmall,    
						 
						 );
			}
	
	
	private function _getImages($data){
			$type_standart = isset($data['type_standart'])?$data['type_standart']:0;
			$type_small = isset($data['type_small'])?$data['type_small']:0;
			$type_social = isset($data['type_social'])?$data['type_social']:'facebook';
			$admin = $data['admin'];
			
			if(version_compare(_PS_VERSION_, '1.5', '>')){
	        	$id_shop = Context::getContext()->shop->id;
	         } else {
	        	$id_shop = 0;
	         }
		
	        $cookie = $this->context->cookie;
	        $smarty = $this->context->smarty;
			if(!$admin){
	         
	         $_http_host = '';
	         if(defined('_MYSQL_ENGINE_')){
				$_http_host = isset($smarty->tpl_vars['base_dir_ssl']->value)?$smarty->tpl_vars['base_dir_ssl']->value:$smarty->tpl_vars['base_dir']->value;
			 } else {
			    $_http_host = isset($smarty->_tpl_vars['base_dir_ssl'])?$smarty->_tpl_vars['base_dir_ssl']:$smarty->_tpl_vars['base_dir'];
			 }
		
			if($_http_host == 'http://' || $_http_host == 'http:///'
	    	   || $_http_host == 'https://' || $_http_host == 'https:///'){
	    	   	if (Configuration::get('PS_SSL_ENABLED') == 1)
					$type_url = "https://";
				else
					$type_url = "http://";
	    	   $_http_host = $type_url.$_SERVER['HTTP_HOST']."/";
	    	   }
        
	         } else {
	         	$_http_host = "../";
	         }
	         
			// social connect image
			
			$sql = 'SELECT * FROM `'._DB_PREFIX_   .$this->_name.'_img` 
		        	WHERE `type` = '.$type_standart.' AND `id_shop` = '.$id_shop.'';
			$data_social = Db::getInstance()->GetRow($sql);
			$img_social = (isset($data_social['img'])?$data_social['img']:'');
			$img_block_social = dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."upload".DIRECTORY_SEPARATOR.$this->_name.DIRECTORY_SEPARATOR.$img_social;
			
			$uploaded_social = 0;
			if(strlen($img_social)>0){
				if(@filesize($img_block_social)>0){
					$uploaded_social = 1;
				}
			}
			if($uploaded_social){
				$social = $_http_host."upload/".$this->_name."/".$img_social;
			} else {
				$social = $_http_host.'modules/'.$this->_name.'/i/'.$type_social.'.png';
			}
			
			// social connect small image
			
			$sql = 'SELECT * FROM `'._DB_PREFIX_   .$this->_name.'_img` 
		        	WHERE `type` = '.$type_small.' AND `id_shop` = '.$id_shop.'';
			$data_socialsmall = Db::getInstance()->GetRow($sql);
			$img_socialsmall = (isset($data_socialsmall['img'])?$data_socialsmall['img']:'');
			$img_block_socialsmall = dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."upload".DIRECTORY_SEPARATOR.$this->_name.DIRECTORY_SEPARATOR.$img_socialsmall;
			
			$uploaded_socialsmall = 0;
			if(strlen($img_socialsmall)>0){
				if(@filesize($img_block_socialsmall)>0){
					$uploaded_socialsmall = 1;
				}
			}
			if($uploaded_socialsmall){
				$socialsmall = $_http_host."upload/".$this->_name."/".$img_socialsmall;
			} else {
				$socialsmall = $_http_host.'modules/'.$this->_name.'/i/'.$type_social.'-small.png';
			}
			
			return array('standart'=>$social, 'standart_block' => $img_social,
						'small'=>$socialsmall, 'small_block'=>$img_socialsmall);
	}
			
	public function saveImage($data = null){
		
		$error = 0;
		$error_text = '';
		$custom_type_img = $data['type'];
		
		$files = $_FILES['post_image_'.$custom_type_img];
		
		############### files ###############################
		if(!empty($files['name']))
			{
		      if(!$files['error'])
		      {
				  $type_one = $files['type'];
				  $ext = explode("/",$type_one);
				  
				  if(strpos('_'.$type_one,'image')<1)
				  {
				  	$error_text = $this->l('Invalid file type, please try again!');
				  	$error = 1;

				  }elseif(!in_array($ext[1],array('png','x-png','gif','jpg','jpeg','pjpeg'))){
				  	$error_text = $this->l('Wrong file format, please try again!');
				  	$error = 1;
				  	
				  } else {
				  	
				  		
				  		
				  		$data_img = $this->getImages(array('admin'=>1));
				  		if($custom_type_img == "facebook"){
				  			$type_page = 1;
				  			$img_old_del = $data_img['facebook_block']; 
				  					
				  		} elseif($custom_type_img == "google"){
				  			$type_page = 2;
				  			$img_old_del = $data_img['google_block']; 		
				  		} elseif($custom_type_img == "paypal"){
				  			$type_page = 3;
				  			$img_old_del = $data_img['paypal_block']; 		
				  		} elseif($custom_type_img == "facebooksmall"){
				  			$type_page = 4;
				  			$img_old_del = $data_img['facebook_blocksmall']; 		
				  		} elseif($custom_type_img == "linkedin"){
				  			$type_page = 11;
				  			$img_old_del = $data_img['linkedin_block']; 		
				  		} elseif($custom_type_img == "googlesmall"){
				  			$type_page = 5;
				  			$img_old_del = $data_img['google_blocksmall']; 		
				  		} elseif($custom_type_img == "paypalsmall"){
				  			$type_page = 6;
				  			$img_old_del = $data_img['paypal_blocksmall']; 		
				  		} elseif($custom_type_img == "twitter"){
				  			$type_page = 7;
				  			$img_old_del = $data_img['twitter_block']; 		
				  		} elseif($custom_type_img == "twittersmall"){
				  			$type_page = 8;
				  			$img_old_del = $data_img['twitter_blocksmall']; 		
				  		} elseif($custom_type_img == "yahoo"){
				  			$type_page = 9;
				  			$img_old_del = $data_img['yahoo_block']; 		
				  		} elseif($custom_type_img == "yahoosmall"){
				  			$type_page = 10;
				  			$img_old_del = $data_img['yahoo_blocksmall']; 		
				  		} elseif($custom_type_img == "linkedinsmall"){
				  			$type_page = 12;
				  			$img_old_del = $data_img['linkedin_blocksmall']; 		
				  		} elseif($custom_type_img == "livejournal"){
				  			$type_page = 13;
				  			$img_old_del = $data_img['livejournal_block']; 		
				  		} elseif($custom_type_img == "livejournalsmall"){
				  			$type_page = 14;
				  			$img_old_del = $data_img['livejournal_blocksmall']; 		
				  		} elseif($custom_type_img == "microsoft"){
				  			$type_page = 15;
				  			$img_old_del = $data_img['microsoft_block']; 		
				  		} elseif($custom_type_img == "microsoftsmall"){
				  			$type_page = 16;
				  			$img_old_del = $data_img['microsoft_blocksmall']; 		
				  		} elseif($custom_type_img == "openid"){
				  			$type_page = 17;
				  			$img_old_del = $data_img['openid_block']; 		
				  		} elseif($custom_type_img == "openidsmall"){
				  			$type_page = 18;
				  			$img_old_del = $data_img['openid_blocksmall']; 		
				  		} elseif($custom_type_img == "clavid"){
				  			$type_page = 19;
				  			$img_old_del = $data_img['clavid_block']; 		
				  		} elseif($custom_type_img == "clavidsmall"){
				  			$type_page = 20;
				  			$img_old_del = $data_img['clavid_blocksmall']; 		
				  		} elseif($custom_type_img == "flickr"){
				  			$type_page = 21;
				  			$img_old_del = $data_img['flickr_block']; 		
				  		} elseif($custom_type_img == "flickrsmall"){
				  			$type_page = 22;
				  			$img_old_del = $data_img['flickr_blocksmall']; 		
				  		} elseif($custom_type_img == "wordpress"){
				  			$type_page = 23;
				  			$img_old_del = $data_img['wordpress_block']; 		
				  		} elseif($custom_type_img == "wordpresssmall"){
				  			$type_page = 24;
				  			$img_old_del = $data_img['wordpress_blocksmall']; 		
				  		}elseif($custom_type_img == "aol"){
				  			$type_page = 25;
				  			$img_old_del = $data_img['aol_block']; 		
				  		} elseif($custom_type_img == "aolsmall"){
				  			$type_page = 26;
				  			$img_old_del = $data_img['aol_blocksmall']; 		
				  		}
				  		
    					
    					
				  		if(strlen($img_old_del)>0){
				  			// delete old img
				  			$name_thumb = current(explode(".",$img_old_del));
				  			unlink(dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."upload".DIRECTORY_SEPARATOR.$this->_name.DIRECTORY_SEPARATOR.$img_old_del);
				  		} 
					
				  			
					  	srand((double)microtime()*1000000);
					 	$uniq_name_image = uniqid(rand());
					 	$type_one = substr($type_one,6,strlen($type_one)-6);
					 	$filename = $uniq_name_image.'.'.$type_one; 
					 	
						move_uploaded_file($files['tmp_name'], dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."upload".DIRECTORY_SEPARATOR.$this->_name.DIRECTORY_SEPARATOR.$filename);
						
						/*$this->copyImage(array('dir_without_ext'=>dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."upload".DIRECTORY_SEPARATOR.$this->_name.DIRECTORY_SEPARATOR.$uniq_name_image,
												'name'=>dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."upload".DIRECTORY_SEPARATOR.$this->_name.DIRECTORY_SEPARATOR.$filename)
										);*/
						
						
						$img_return = $uniq_name_image.'.jpg';
						$img_return = $filename;
			  		
				  		$this->_updateImgDB(array('type_page' => $type_page,
				  								  'img' => $img_return
				  							     )
				  							);

				  }
				}
				
			}  
			
		return array('error' => $error,
					 'error_text' => $error_text);
	
	
	}
	
	private function _updateImgDB($data = null){
		
		$type_page = $data['type_page'];
		$img = $data['img'];
		
		if(version_compare(_PS_VERSION_, '1.5', '>')){
	       	$id_shop = Context::getContext()->shop->id;
	    } else {
	      	$id_shop = 0;
	    }
	         
		
		$sql = 'SELECT count(*) as count FROM `'._DB_PREFIX_   .$this->_name.'_img` 
		        	WHERE `type` = '.$type_page.' AND `id_shop` = '.$id_shop.'';
		$data_exists = Db::getInstance()->GetRow($sql);
		
		if($data_exists['count']){
			// delete and insert
			$sql = 'DELETE FROM `'._DB_PREFIX_.$this->_name.'_img` 
						   WHERE `type` = '.$type_page.' 
						   AND `id_shop` = '.$id_shop.'';
				Db::getInstance()->Execute($sql);
			
		} else {
			// only insert new
		}
		// insert
		$sql = 'INSERT INTO `'._DB_PREFIX_.$this->_name.'_img` 
						   SET `type` = '.$type_page.', 
						       `id_shop` = '.$id_shop.',
						       `img` = \''.pSQL($img).'\'
						       ';
		
			Db::getInstance()->Execute($sql);
		
	}
	
	public function deleteImage($data){
		$type = $data['type'];
		
		if(version_compare(_PS_VERSION_, '1.5', '>')){
		       	$id_shop = Context::getContext()->shop->id;
		    } else {
		      	$id_shop = 0;
		    }
	    
		$sql = 'SELECT * FROM `'._DB_PREFIX_   .$this->_name.'_img` 
		        	WHERE `type` = '.$type.' AND `id_shop` = '.$id_shop.'';
		$data = Db::getInstance()->GetRow($sql);
		$img_delete = (isset($data['img'])?$data['img']:'');
			
		    
		   $sql = 'DELETE FROM `'._DB_PREFIX_.$this->_name.'_img` 
						   WHERE `type` = '.$type.' 
						   AND `id_shop` = '.$id_shop.'';
				Db::getInstance()->Execute($sql);
			
		
		@unlink(dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."upload".DIRECTORY_SEPARATOR.$this->_name.DIRECTORY_SEPARATOR.$img_delete);
				  		
	}
	
	
	
	
	
}