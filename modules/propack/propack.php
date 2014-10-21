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

class propack extends Module
{
	private $_step = 10;
	private $_is_friendly_url;
	private $_iso_lng;
	private $_id_shop; 
	private $_admin_email;
	
	private $_hooks_avaiable = array(1 => 'rightColumn',  //ok
									 2 => 'leftColumn', // ok
									 5 => 'extraRight', // ok
									 6 => 'productfooter', // ok
									 7 => 'footer', //ok
									 8 => 'productActions', // ok
									 9 => 'extraLeft' // ok
									 );
	
									 
	private $_html;
	private $_prefix_position_connects;
	private $_prefix_connects_image;
	private $_http_referer;
	
	private $step = 10;
	private $stepref = 100;
	
	private $_is15;
	private $_is16;
	private $_translations;
	private $_multiple_lang;
	
	private $is_l = 0; // callback function in linkedin API currently not working https://developer.linkedin.com/thread/2805
	
	public function is_l(){
		return $this->is_l;
	}
	
	function __construct()
	{
		$this->name = 'propack';
		$this->tab = 'others';
		$this->version = '1.3.1';
		$this->author = 'storeprestamodules.com';
 	 	$this->module_key = 'd7903a6ad2d94e17ab11416a1b1c1aec';
 	 	
		parent::__construct(); // The parent construct is required for translations
		
		$this->_http_referer = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';
		
		if(version_compare(_PS_VERSION_, '1.5', '>')){
			$this->_is15 = 1;
			$this->_id_shop = Context::getContext()->shop->id;
		}else{
			$this->_is15 = 0;
			$this->_id_shop = 0;
		}
			
		if(version_compare(_PS_VERSION_, '1.6', '>'))
			$this->_is16 = 1;
		else
			$this->_is16 = 0;
		
		if(version_compare(_PS_VERSION_, '1.6', '>')){
			if(sizeof(Language::getLanguages())>1){
				$this->_multiple_lang = 1;
			} else {
				$this->_multiple_lang = 0;
			}
		} else {
			
			// ps 1.3
			if(version_compare(_PS_VERSION_, '1.4', '<'))
				$this->_multiple_lang = 0;
			else
				$this->_multiple_lang = 1;
				
		}

		$this->page = basename(__FILE__, '.php');
		$this->displayName = $this->l('Pro Pack (36 in 1)');
		$this->description = $this->l('Add Pro Pack (36 in 1)');
		$this->confirmUninstall = $this->l('Are you sure you want to remove it ? Be careful, all your configuration and your data will be lost');
		
		$this->_prefix_position_connects = array($this->l('Position Facebook Connect Button')=>'f',
											     $this->l('Position Twitter Connect Button')=>'t',
											     $this->l('Position Google Connect Button')=>'g',
											     $this->l('Position Yahoo Connect Button')=>'y',
											     $this->l('Position Paypal Connect Button')=>'p',
											     $this->l('Position LinkedIn Connect Button')=>'l',
											     $this->l('Position Livejournal Connect Button')=>'live',
											     $this->l('Position Microsoft Connect Button')=>'m',
											     //$this->l('Position OpenID Connect Button')=>'o',
											     $this->l('Position ClavID Connect Button')=>'c',
											     $this->l('Position Flickr Connect Button')=>'fl',
											     $this->l('Position Wordpress Connect Button')=>'w',
											     $this->l('Position Aol Connect Button')=>'a',
											     );
											     
		$this->_prefix_connects_image = 
			array('facebook'=> array('translate_image'=>$this->l('Facebook Connect Image'),
    		 						 'translate_small_image'=>$this->l('Facebook Connect Small Image'),
    							     'prefix' => 'f',
    								),
    			  'twitter'=> array('translate_image'=>$this->l('Twitter Connect Image'),
    		 						 'translate_small_image'=>$this->l('Twitter Connect Small Image'),
    							     'prefix' => 't',
    								),
    			  'google'=> array('translate_image'=>$this->l('Google Connect Image'),
    		 						 'translate_small_image'=>$this->l('Google Connect Small Image'),
    							     'prefix' => 'g',
    								),
    			  'yahoo'=> array('translate_image'=>$this->l('Yahoo Connect Image'),
    		 						 'translate_small_image'=>$this->l('Yahoo Connect Small Image'),
    							     'prefix' => 'y',
    								),
    			  'paypal'=> array('translate_image'=>$this->l('Paypal Connect Image'),
    		 						 'translate_small_image'=>$this->l('Paypal Connect Small Image'),
    							     'prefix' => 'p',
    								),
    			  'linkedin'=> array('translate_image'=>$this->l('LinkedIn Connect Image'),
    		 						 'translate_small_image'=>$this->l('LinkedIn Connect Small Image'),
    							     'prefix' => 'l',
    								),
    			   'livejournal'=> array('translate_image'=>$this->l('Livejournal Connect Image'),
    		 						 'translate_small_image'=>$this->l('Livejournal Connect Small Image'),
    							     'prefix' => 'live',
    								),
    				'microsoft'=> array('translate_image'=>$this->l('Microsoft Connect Image'),
    		 						 'translate_small_image'=>$this->l('Microsoft Connect Small Image'),
    							     'prefix' => 'm',
    								),
    				/*'openid'=> array('translate_image'=>$this->l('OpenID Connect Image'),
    		 						 'translate_small_image'=>$this->l('OpenID Connect Small Image'),
    							     'prefix' => 'o',
    								),*/
    				'clavid'=> array('translate_image'=>$this->l('ClavID Connect Image'),
    		 						 'translate_small_image'=>$this->l('ClavID Connect Small Image'),
    							     'prefix' => 'c',
    								),
    				'flickr'=> array('translate_image'=>$this->l('Flickr Connect Image'),
    		 						 'translate_small_image'=>$this->l('Flickr Connect Small Image'),
    							     'prefix' => 'fl',
    								),
    				'wordpress'=> array('translate_image'=>$this->l('Wordpress Connect Image'),
    		 						 'translate_small_image'=>$this->l('Wordpress Connect Small Image'),
    							     'prefix' => 'w',
    								),
    				'aol'=> array('translate_image'=>$this->l('Aol Connect Image'),
    		 						 'translate_small_image'=>$this->l('Aol Connect Small Image'),
    							     'prefix' => 'a',
    								),
    				
    			 );
    			 
    	$this->_translations = array('facebook'=>$this->l('Error: Please fill Facebook App Id and Facebook Secret Key in the module settings'),
									 'twitter'=>$this->l('Error: Please fill Consumer key and Consumer secret in the module settings'),
									 'linkedin'=>$this->l('Error: Please fill LinkedIn API Key and LinkedIn Secret Key in the module settings'),
									 'microsoft'=>$this->l('Error: Please fill Microsoft Live Client ID and Microsoft Live Client Secret in the module settings'),
									 'paypal'=>$this->l('Error: Please fill Paypal Client ID, Paypal Secret, Callback URL in the module settings!')
									 );
    			 
		$this->_admin_email = @Configuration::get('PS_SHOP_EMAIL');
		
		$this->_setblogvariables();
		
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
	
private function _setblogvariables(){
		include_once(_PS_MODULE_DIR_.$this->name.'/classes/blog.class.php');
		
		$obj = new bloghelp();
		$is_friendly_url = $obj->isURLRewriting();
		$this->_is_friendly_url = $is_friendly_url;
		$this->_iso_lng = $obj->getLangISO();
	}

	function install()
	{
		
		### Product questions ###	
		Configuration::updateValue($this->name.'pqon', 1);
		Configuration::updateValue($this->name.'qsettings', 'all');
		Configuration::updateValue($this->name.'qnoti', 1);	
		Configuration::updateValue($this->name.'qmail', @Configuration::get('PS_SHOP_EMAIL'));
		Configuration::updateValue($this->name.'qperpage_q', 5);
		Configuration::updateValue($this->name.'qis_captcha', 1);
		Configuration::updateValue($this->name.'position_ask_q', 'extraright');
		### Product questions ###	
			
		### News ###
		Configuration::updateValue($this->name.'newson', 1);
		
		if($this->_is16 == 1){
			Configuration::updateValue($this->name.'news_home', 1);
			Configuration::updateValue($this->name.'news_footer', 1);
		
		}
		Configuration::updateValue($this->name.'news_left', 1);
		
		
		Configuration::updateValue($this->name.'nfaq_blc', 5);
		Configuration::updateValue($this->name.'nperpage_posts', 5);
		### News ###
			
		### GuestBook ###
		
		Configuration::updateValue($this->name.'guon', 1);
		
		
		if($this->_is16 == 1){
			Configuration::updateValue($this->name.'g_home', 1);
			Configuration::updateValue($this->name.'g_footer', 1);
		
		}	
		Configuration::updateValue($this->name.'g_left', 1);
		
		Configuration::updateValue($this->name.'gperpage', 5);	
		Configuration::updateValue($this->name.'gnoti', 1);	
		Configuration::updateValue($this->name.'gmail', @Configuration::get('PS_SHOP_EMAIL'));
		Configuration::updateValue($this->name.'gbook_blc', 5);
		
		Configuration::updateValue($this->name.'gis_captcha', 1);
			
			
		### Guestbook ###	
			
		
		### FAQ ###
		Configuration::updateValue($this->name.'faqon', 1);
		
		if($this->_is16 == 1){
			Configuration::updateValue($this->name.'faq_home', 1);
			Configuration::updateValue($this->name.'faq_footer', 1);
		
		}	
		
		Configuration::updateValue($this->name.'faq_left', 1);
			
		Configuration::updateValue($this->name.'faq_blc', 5);
		
		Configuration::updateValue($this->name.'faqis_captcha', 1);
		
		Configuration::updateValue($this->name.'faqis_askform', 1);
		
		Configuration::updateValue($this->name.'notifaq', 1);	
		Configuration::updateValue($this->name.'mailfaq', @Configuration::get('PS_SHOP_EMAIL'));
		### FAQ ###

		##### Testimonials #####
		Configuration::updateValue($this->name.'testimon', 1);
			
			
		Configuration::updateValue($this->name.'tlast', 5);	
		//Configuration::updateValue($this->name.'tposition', 'right');
		if($this->_is16 == 1){
			Configuration::updateValue($this->name.'t_home', 1);
			Configuration::updateValue($this->name.'t_footer', 1);
		
		}	
		Configuration::updateValue($this->name.'t_left', 1);
		
		Configuration::updateValue($this->name.'tperpage', 5);	
		
		
		Configuration::updateValue($this->name.'tis_captcha', 1);
		Configuration::updateValue($this->name.'tis_web', 1);
		Configuration::updateValue($this->name.'tis_company', 1);
		Configuration::updateValue($this->name.'tis_addr', 1);
			
		
		Configuration::updateValue($this->name.'tnoti', 1);	
		Configuration::updateValue($this->name.'tmail', @Configuration::get('PS_SHOP_EMAIL'));
		
		Configuration::updateValue($this->name.'tn_rssitemst', 10);
		Configuration::updateValue($this->name.'trssontestim', 1);
		
		##### Testimonials #####	
			
			
		#### Product reviews + Google Snippets, Breadcrumb, Rich Pin ####	
		Configuration::updateValue($this->name.'reviewson', 1);
		
		Configuration::updateValue($this->name.'starscat', 1);
		
		
		$languages = Language::getLanguages(false);
    	foreach ($languages as $language){
    		$i = $language['id_lang'];
    		Configuration::updateValue($this->name.'emailreminder_'.$i, $this->l('Are you satisfied with our products'));
		}
		
		Configuration::updateValue($this->name.'delay', 7);
			
		// pinterest
		Configuration::updateValue($this->name.'pinvis_on', 1);
		Configuration::updateValue($this->name.'pinbutton_on', 1);
		Configuration::updateValue($this->name.'pbuttons', 'threeon');
		Configuration::updateValue($this->name.'_extraRight', 'extraRight');
		// pinterest	
			
		// breadcrambs
		Configuration::updateValue($this->name.'breadvis_on', 1);
		// breadcrambs
		
		// google snippets settings
		Configuration::updateValue($this->name.'gsnipblock', 1);
	 	Configuration::updateValue($this->name.'gsnipblock_width', 'auto');
	 	Configuration::updateValue($this->name.'gsnipblocklogo', 1);
	 	if($this->_is16==1)
	 		Configuration::updateValue($this->name.'id_hook_gsnipblock', 8);
		else
			Configuration::updateValue($this->name.'id_hook_gsnipblock', 1);
		// google snippets settings
			
		Configuration::updateValue($this->name.'settings', 'all');
		Configuration::updateValue($this->name.'x_reviews', 1);
		Configuration::updateValue($this->name.'is_onereview', 1);
		Configuration::updateValue($this->name.'position', 'left');
		Configuration::updateValue($this->name.'is_captcha', 1);
		Configuration::updateValue($this->name.'switch_lng', 1);
		Configuration::updateValue($this->name.'homeon', 1);	
		Configuration::updateValue($this->name.'noti_snip', 1);	
		Configuration::updateValue($this->name.'mail_snip', @Configuration::get('PS_SHOP_EMAIL'));
		Configuration::updateValue($this->name.'revlast', 5);
		Configuration::updateValue($this->name.'subjecton', 1);
		Configuration::updateValue($this->name.'recommendedon', 1);
		Configuration::updateValue($this->name.'ipon', 1);
		Configuration::updateValue($this->name.'revperpage', 10);
		
		Configuration::updateValue($this->name.'rsson_snip', 1);
		Configuration::updateValue($this->name.'n_rss_snip', 10);
		
		
		
		$languages = Language::getLanguages(false);
    	foreach ($languages as $language){
    		$i = $language['id_lang'];
    		$iso = strtoupper(Language::getIsoById($i));
    		
    		$rssname = Configuration::get('PS_SHOP_NAME');
    		Configuration::updateValue($this->name.'rssname_snip_'.$i, $rssname);
			$rssdesc = Configuration::get('PS_SHOP_NAME');
			Configuration::updateValue($this->name.'rssdesc_snip_'.$i, $rssdesc);
		}
		#### Product reviews + Google Snippets, Breadcrumb, Rich Pin ####	
		
			
		##### blog ########
	 	Configuration::updateValue($this->name.'blogon', 1);	 		
	 		
		// left 	
		Configuration::updateValue($this->name.'cat_left', 1);	
		Configuration::updateValue($this->name.'posts_left', 1);
		// left 
		
		
		if($this->_is16 == 1){
			Configuration::updateValue($this->name.'search_left', 1);	
			Configuration::updateValue($this->name.'arch_left', 1);
			
			Configuration::updateValue($this->name.'cat_footer', 1);	
			Configuration::updateValue($this->name.'posts_footer', 1);
			Configuration::updateValue($this->name.'search_footer', 1);	
			Configuration::updateValue($this->name.'arch_footer', 1);
			
		}
		
		
		// right 	
		if($this->_is16 == 0){
		Configuration::updateValue($this->name.'search_right', 1);	
		Configuration::updateValue($this->name.'arch_right', 1);
		}
		// right 
		
		Configuration::updateValue($this->name.'urlrewrite_on', 0);
		Configuration::updateValue($this->name.'c_list_display_date', 1);	
		
		
		Configuration::updateValue($this->name.'perpage_catblog', 10);
		
		
		Configuration::updateValue($this->name.'perpage_posts', 10);
		Configuration::updateValue($this->name.'p_list_displ_date', 1);
		
		
		Configuration::updateValue($this->name.'block_display_date', 1);
		Configuration::updateValue($this->name.'block_display_img', 1);
		if($this->_is16==1){
		Configuration::updateValue($this->name.'p_block_img_width', 70);
			
		} else {
		Configuration::updateValue($this->name.'p_block_img_width', 50);
			
		}
		
		
		Configuration::updateValue($this->name.'tab_blog_pr', 1);
		Configuration::updateValue($this->name.'block_last_home', 1);
		Configuration::updateValue($this->name.'lists_img_width', 100);
		
		Configuration::updateValue($this->name.'post_display_date', 1);	
		Configuration::updateValue($this->name.'post_img_width', 200);
		Configuration::updateValue($this->name.'is_soc_buttons', 1);

		
		
		Configuration::updateValue($this->name.'noti', 1);	
		Configuration::updateValue($this->name.'mail', @Configuration::get('PS_SHOP_EMAIL'));
		Configuration::updateValue($this->name.'blog_bcat', 5);
		Configuration::updateValue($this->name.'blog_bposts', 5);
		
		
		Configuration::updateValue($this->name.'rsson', 1);
		Configuration::updateValue($this->name.'number_rssitems', 10);
		
		$languages = Language::getLanguages(false);
    	foreach ($languages as $language){
    		$i = $language['id_lang'];
    		$iso = strtoupper(Language::getIsoById($i));
    		
    		$rssname = Configuration::get('PS_SHOP_NAME');
    		Configuration::updateValue($this->name.'rssname_'.$i, $rssname);
			$rssdesc = Configuration::get('PS_SHOP_NAME');
			Configuration::updateValue($this->name.'rssdesc_'.$i, $rssdesc);
		}
		
		##### blog ########
	 	
		
		$this->generateRewriteRules();
		
		if($this->_is15 == 1)
	 		$this->createAdminTabs();
		
		
		Configuration::updateValue($this->name.'urlrewrite_on', 0);
		
		
		#### referrals ####
		
		$social_types = array("facebook","twitter","linkedin","google");
		
		foreach($social_types as $type){
			$type= substr($type,0,1);
			
			if($this->_is16){
				Configuration::updateValue($this->name.'_psextraRight'.$type, 'psextraRight'.$type);
			} else {
				Configuration::updateValue($this->name.'_psprFooter'.$type, 'psprFooter'.$type);
			}
	 		Configuration::updateValue($this->name.'_pscheckoutPage'.$type, 'pscheckoutPage'.$type);
	 		
			$languages = Language::getLanguages(false);
	    	foreach ($languages as $language){
	    		$i = $language['id_lang'];
	    		
	    		$promo_defaulttext = $this->l('Share and get Discount');
				Configuration::updateValue($this->name.$type.'defaulttext_'.$i, $promo_defaulttext);
			}
	 		
	 	}
		
		// categories
		Configuration::updateValue($this->name.'catbox', $this->getIdsCategories());
		// categories
		
		Configuration::updateValue($this->name.'cumulativeother', 1);
		Configuration::updateValue($this->name.'cumulativereduc', 1);
		
		
		Configuration::updateValue($this->name.'fbrefon', 1);
		Configuration::updateValue($this->name.'twrefon', 1);
		Configuration::updateValue($this->name.'grefon', 1);
		Configuration::updateValue($this->name.'lrefon', 1);
		
		Configuration::updateValue($this->name.'fbrefshareon', 1);
		Configuration::updateValue($this->name.'twrefshareon', 1);
		Configuration::updateValue($this->name.'grefshareon', 1);
		Configuration::updateValue($this->name.'lrefshareon', 1);
		
		
		
		Configuration::updateValue($this->name.'frefnum', 5);
		Configuration::updateValue($this->name.'trefnum', 5);
		Configuration::updateValue($this->name.'grefnum', 5);
		Configuration::updateValue($this->name.'lrefnum', 5);
			
		
		Configuration::updateValue($this->name.'gsize', 'tall');
		Configuration::updateValue($this->name.'lsize', 'top');
		
		
		$languages = Language::getLanguages(false);
    	foreach ($languages as $language){
    		$i = $language['id_lang'];
    		$iso = strtoupper(Language::getIsoById($i));
    		
    		$coupondesc = $this->displayName;
			Configuration::updateValue($this->name.'coupondesc_'.$i, $coupondesc.' - '.$iso);
		}
		
		Configuration::updateValue($this->name.'discount_type', 2);
		Configuration::updateValue($this->name.'percentage_val', 1);
		
		
		Configuration::updateValue($this->name.'tvalid', 168); // 1 week
		
		if($this->_is16)
		    		$cur = Currency::getCurrenciesByIdShop(Context::getContext()->shop->id);
		    	else
		    		$cur = Currency::getCurrencies();
		foreach ($cur AS $_cur){
    		if(Configuration::get('PS_CURRENCY_DEFAULT') == $_cur['id_currency']){
    			Configuration::updateValue('fbrefamount_'.(int)$_cur['id_currency'], 1);
    		}
		}
		
		#### referrals ####
		
		
		
		
		// google +1 button
		Configuration::updateValue($this->name.'status1', "on");
		Configuration::updateValue($this->name.'buttons1', "2gon");
		// google +1 button
		
		
		// google widget
		Configuration::updateValue($this->name.'gwon', 1);
	 	Configuration::updateValue($this->name.'positiong', "left");
	 	// google widget
		
		// linkedin button
	 	Configuration::updateValue($this->name.'linkedinbon', 1);
	 	Configuration::updateValue($this->name.'linkedinbuttons', "firston");
	 	// linkedin	button
	 	
		// pinterest button
		Configuration::updateValue($this->name.'pinterestbon', 1);
	 	Configuration::updateValue($this->name.'pinterestbuttons', "firston");
	 	// pinterest button
	 	
		//pinterest widget
	 	Configuration::updateValue($this->name.'_title', $this->l('My Latest Pins'));
	 	Configuration::updateValue($this->name.'_pusername', 'storepresta');
	 	Configuration::updateValue($this->name.'_pspecboard', '');
		Configuration::updateValue($this->name.'_width', 189);
		Configuration::updateValue($this->name.'_height', 400);
		Configuration::updateValue($this->name.'_number', 6);
		Configuration::updateValue($this->name.'_descr', 'on');
		Configuration::updateValue($this->name.'_descrl', 30);
		Configuration::updateValue($this->name.'_pwidth', 112);
		Configuration::updateValue($this->name.'_follow', 'on');
	 	Configuration::updateValue($this->name.'_pos', 'rightColumn');
	 	Configuration::updateValue($this->name.'_isonpinwidget', 1);
	 	//pinterest widget
	 	
		
		// facebook share button
		Configuration::updateValue($this->name.'shareon', 1);
	    // facebook share button
		
		
		//facebook comments
		Configuration::updateValue($this->name.'COMMENTON', 1);
		Configuration::updateValue($this->name.'COMMENTNBR', '6');
		Configuration::updateValue($this->name.'BGCUSTOM', '0');
		Configuration::updateValue($this->name.'BGCOLOR', '#FFFFFF');
		
		if($this->_is16)
			Configuration::updateValue($this->name.'COMMENTWIDTH', '1170');
		else
			Configuration::updateValue($this->name.'COMMENTWIDTH', '525');
		Configuration::updateValue($this->name.'ROUNDED', '1');
		Configuration::updateValue($this->name.'REGISTERSWITCH', '0');
		Configuration::updateValue($this->name.'LOGOSWITCH', '1');
		Configuration::updateValue($this->name.'TITLESWITCH', '1');
		Configuration::updateValue($this->name.'FOCUS', '0');
		Configuration::updateValue($this->name.'FORCE', '0');
		Configuration::updateValue($this->name.'APPADMIN', '100001948630482');
		
		//facebook comments
		
		
		//facebook widget
		Configuration::updateValue($this->name.'fbon', 1);
        Configuration::updateValue($this->name.'lb_facebook_page_url', 'https://www.facebook.com/pages/Storeprestamodulescom/173523079517579');
       
        Configuration::updateValue($this->name.'positionfb', "left");
         if($this->_is16)
	    	Configuration::updateValue($this->name.'lb_width','245');
       	else
        	Configuration::updateValue($this->name.'lb_width','190');
        Configuration::updateValue($this->name.'lb_height','370');
        Configuration::updateValue($this->name.'lb_connections','9');
        Configuration::updateValue($this->name.'lb_faces', 1);
        Configuration::updateValue($this->name.'lb_header', 1);
        Configuration::updateValue($this->name.'lb_bg_color', '#FFFFFF');
        
		// facebook widget
		
		// facebook like button
		Configuration::updateValue($this->name.'likeon', 1);
		Configuration::updateValue($this->name.'likefaces', 0);
	    Configuration::updateValue($this->name.'likecolor', 'light');
	    Configuration::updateValue($this->name.'likelayout', 'box_count');
	    Configuration::updateValue($this->name.'widthlikebox', 50);
		// facebook like button
		
		// twitter widget
		Configuration::updateValue($this->name.'tw_widgetid', '421754824971911168');
		Configuration::updateValue($this->name.'twitteron', 1);
		Configuration::updateValue($this->name.'user_name', "twitter");
		Configuration::updateValue($this->name.'position', "right");
		if($this->_is16)
			Configuration::updateValue($this->name.'width', 245);
	    else
        	Configuration::updateValue($this->name.'width', 190);
		
		Configuration::updateValue($this->name.'height', 370);
		Configuration::updateValue($this->name.'tweets_link', "#0084B4");
		Configuration::updateValue($this->name.'tw_color_scheme', "light");
		Configuration::updateValue($this->name.'tw_aria_pol', 0);
		// twitter widget
		
		// twitter button
		Configuration::updateValue($this->name.'twitterbon', 1);
		Configuration::updateValue($this->name.'buttons', "firston");
		// twitter button
		
		$array_need = array('f','t','g','y','p','l','m');
		foreach($this->_prefix_position_connects as $prefix){
			Configuration::updateValue($this->name.'_footer'.$prefix, 'footer'.$prefix);
			
			Configuration::updateValue($this->name.'_top'.$prefix, 'top'.$prefix);
	 		Configuration::updateValue($this->name.'_leftcolumn'.$prefix, 'leftcolumn'.$prefix);
	 		Configuration::updateValue($this->name.'_authpage'.$prefix, 'authpage'.$prefix);
	 		if(in_array($prefix,$array_need))
	 			Configuration::updateValue($this->name.'_welcome'.$prefix, 'welcome'.$prefix);
		}
		
		// changes OAuth 2.0
	 	if(version_compare(_PS_VERSION_, '1.6', '>')){
			$_http_host = Tools::getShopDomainSsl(true, true).__PS_BASE_URI__; 
		} else {
			$_http_host = _PS_BASE_URL_.__PS_BASE_URI__;
		}
		Configuration::updateValue($this->name.'oru', $_http_host.'modules/'.$this->name.'/login.php');
		// changes OAuth 2.0
		
		
		if (!parent::install())
			return false;
			
			
		if (!$this->registerHook('header') OR 
			!$this->registerHook('leftColumn') OR 
			!$this->registerHook('rightColumn') OR
			!$this->registerHook('productTab') OR
			!$this->registerHook('productTabContent') OR
			
	 		!$this->registerHook('footer') OR
	 		!$this->registerHook('extraLeft') OR 
	 		!$this->registerHook('home') OR
	 		
	 		!$this->registerHook('myAccountBlock') OR
	 	    
	 		!$this->registerHook('customerAccount') OR
		 	!$this->registerHook('OrderConfirmation') OR 
		 	!$this->registerHook('extraRight') OR
		 	!$this->registerHook('productFooter') OR
		 	!$this->registerHook('productActions') OR	
		 	(($this->_is15==1)?!$this->registerHook('displayShoppingCartFooter'):!$this->registerHook('shoppingCart')) OR 
	 		
			!$this->createCustomerTbl() OR
	 		!$this->_createFolderAndSetPermissions() OR
	 		!$this->createUserTwitterTable() OR
	 		!$this->createGoogleWidgetTbl() OR
	 		!$this->_createFolderAndSetPermissionsPinterestWidget() OR
	 		!$this->installReferralsTable() 
	 		OR !$this->_installDB()
			OR !$this->__createFolderAndSetPermissionsContentPack()
	 		
	 		)
			return false;
		
		
		return true;
	}
	
		function uninstall()
	{
		if($this->_is15 == 1)
			$this->uninstallTab();
		
		$this->_uninstallDB();
		
		if (!$this->uninstallTable() OR !parent::uninstall()
			)
			return false;
		return true;
	}
	
private function uninstallTab(){
		
		
		$tab_id = Tab::getIdFromClassName("AdminBlockblog");
		if($tab_id){
			$tab = new Tab($tab_id);
			$tab->delete();
		}
		
		$tab_id = Tab::getIdFromClassName("AdminBlockblogCategories");
		if($tab_id){
			$tab = new Tab($tab_id);
			$tab->delete();
		}
		
		$tab_id = Tab::getIdFromClassName("AdminBlockblogPosts");
		if($tab_id){
			$tab = new Tab($tab_id);
			$tab->delete();
		}
		
		$tab_id = Tab::getIdFromClassName("AdminBlockblogComments");
		if($tab_id){
			$tab = new Tab($tab_id);
			$tab->delete();
		}
		
		$tab_id = Tab::getIdFromClassName("AdminReviews");
		if($tab_id){
			$tab = new Tab($tab_id);
			$tab->delete();
		}
		
		$tab_id = Tab::getIdFromClassName("AdminShopreviews");
		if($tab_id){
			$tab = new Tab($tab_id);
			$tab->delete();
		}
		
		$tab_id = Tab::getIdFromClassName("AdminGuestbooks");
		if($tab_id){
			$tab = new Tab($tab_id);
			$tab->delete();
		}
		
		$tab_id = Tab::getIdFromClassName("AdminNews");
		if($tab_id){
			$tab = new Tab($tab_id);
			$tab->delete();
		}
		
		$tab_id = Tab::getIdFromClassName("AdminQuestions");
		if($tab_id){
			$tab = new Tab($tab_id);
			$tab->delete();
		}
		
		
		@unlink(_PS_ROOT_DIR_."/img/t/AdminBlockblog.gif");
	}
	
	
	
	
	
	private function createAdminTabs(){
		
		
			@copy(dirname(__FILE__)."/AdminBlockblog.gif",_PS_ROOT_DIR_."/img/t/AdminBlockblog.gif");
		
		 	$langs = Language::getLanguages();
            $id_lang = (int)Configuration::get('PS_LANG_DEFAULT');

          
            $tab0 = new Tab();
            $tab0->class_name = "AdminBlockblog";
            $tab0->module = $this->name;
            $tab0->id_parent = 0; 
            foreach($langs as $l){
                    $tab0->name[$l['id_lang']] = $this->l('Content Pack');
            }
            $tab0->save();
            $main_tab_id = $tab0->id;

            unset($tab0);
            
            $tab1 = new Tab();
            $tab1->class_name = "AdminBlockblogCategories";
            $tab1->module = $this->name;
            $tab1->id_parent = $main_tab_id; 
            foreach($langs as $l){
                    $tab1->name[$l['id_lang']] = $this->l('Blog Categories');
            }
            $tab1->save();

            unset($tab1);
            
            $tab2 = new Tab();
            $tab2->class_name = "AdminBlockblogPosts";
            $tab2->module = $this->name;
            $tab2->id_parent = $main_tab_id; 
            foreach($langs as $l){
                    $tab2->name[$l['id_lang']] = $this->l('Blog Posts');
            }
            $tab2->save();

            unset($tab2);
            
            $tab3 = new Tab();
            $tab3->class_name = "AdminBlockblogComments";
            $tab3->module = $this->name;
            $tab3->id_parent = $main_tab_id; 
            foreach($langs as $l){
                    $tab3->name[$l['id_lang']] = $this->l('Blog Comments');
            }
            $tab3->save();

            unset($tab3);
  
            $tab4 = new Tab();
            $tab4->class_name = "AdminReviews";
            $tab4->module = $this->name;
            $tab4->id_parent = $main_tab_id; 
            foreach($langs as $l){
                    $tab4->name[$l['id_lang']] = $this->l('Product Reviews');
            }
            $tab4->save();

            unset($tab4);
            
            $tab5 = new Tab();
            $tab5->class_name = "AdminShopreviews";
            $tab5->module = $this->name;
            $tab5->id_parent = $main_tab_id; 
            foreach($langs as $l){
                    $tab5->name[$l['id_lang']] = $this->l('Moderate Testimonials');
            }
            $tab5->save();

            unset($tab5);
            
            
            $tab6 = new Tab();
            $tab6->class_name = "AdminFaqs";
            $tab6->module = $this->name;
            $tab6->id_parent = $main_tab_id; 
            foreach($langs as $l){
                    $tab6->name[$l['id_lang']] = $this->l('Moderate FAQ');
            }
            $tab6->save();

            unset($tab6);
            
            $tab7 = new Tab();
            $tab7->class_name = "AdminGuestbooks";
            $tab7->module = $this->name;
            $tab7->id_parent = $main_tab_id; 
            foreach($langs as $l){
                    $tab7->name[$l['id_lang']] = $this->l('Moderate Guestbook');
            }
            $tab7->save();

            unset($tab7);
            
            
            $tab8 = new Tab();
            $tab8->class_name = "AdminNews";
            $tab8->module = $this->name;
            $tab8->id_parent = $main_tab_id; 
            foreach($langs as $l){
                    $tab8->name[$l['id_lang']] = $this->l('Moderate News');
            }
            $tab8->save();

            unset($tab8);
            
            $tab9 = new Tab();
            $tab9->class_name = "AdminQuestions";
            $tab9->module = $this->name;
            $tab9->id_parent = $main_tab_id; 
            foreach($langs as $l){
                    $tab9->name[$l['id_lang']] = $this->l('Moderate Product Questions');
            }
            $tab9->save();

            unset($tab9);
	}
	
	
	
 	private function generateRewriteRules(){
            
            if(Configuration::get('PS_REWRITING_SETTINGS')){

                $rules = "#propack - not remove this comment \n";
                
                $physical_uri = array();
                 if($this->_is15){
                foreach (ShopUrl::getShopUrls() as $shop_url)
				{
                    if(in_array($shop_url->physical_uri,$physical_uri)) continue;
                    
                  $rules .= "RewriteRule ^(.*)blog/category/([0-9a-zA-Z-_]+)/?$ ".$shop_url->physical_uri."modules/propack/blockblog-category.php?category_id=$2 [QSA,L] \n";
				  $rules .= "RewriteRule ^(.*)blog/post/([0-9a-zA-Z-_]+)/?$ ".$shop_url->physical_uri."modules/propack/blockblog-post.php?post_id=$2 [QSA,L] \n";
				  $rules .= "RewriteRule ^(.*)blog/categories/?$ ".$shop_url->physical_uri."modules/propack/blockblog-categories.php [QSA,L] \n"; 
                  $rules .= "RewriteRule ^(.*)blog/?$ ".$shop_url->physical_uri."modules/propack/blockblog-all-posts.php [QSA,L] \n";
                   
                  $rules .= "RewriteRule ^(.*)testimonials/?$ ".$shop_url->physical_uri."modules/".$this->name."/blockshopreviews-form.php [QSA,L] \n"; 
	                    
                  $rules .= "RewriteRule ^(.*)faq/?$ ".$shop_url->physical_uri."modules/".$this->name."/faq.php [QSA,L] \n"; 
	                  
                  $rules .= "RewriteRule ^(.*)guestbook/?$ ".$shop_url->physical_uri."modules/".$this->name."/blockguestbook-form.php [QSA,L] \n";

                  $rules .= "RewriteRule ^(.*)news/?$ ".$shop_url->physical_uri."modules/".$this->name."/items.php [QSA,L] \n";
	              $rules .= "RewriteRule ^(.*)news/([0-9a-zA-Z-_]+)/?$ ".$shop_url->physical_uri."modules/".$this->name."/item.php?item_id=$2 [QSA,L] \n";
				   
	                 
                    $physical_uri[] = $shop_url->physical_uri;
                } 
                
                 } else{
                	$rules .= "RewriteRule ^(.*)blog/category/([0-9a-zA-Z-_]+)/?$ /modules/propack/blockblog-category.php?category_id=$2 [QSA,L] \n";
				  	$rules .= "RewriteRule ^(.*)blog/post/([0-9a-zA-Z-_]+)/?$ /modules/propack/blockblog-post.php?post_id=$2 [QSA,L] \n";
				  	$rules .= "RewriteRule ^(.*)blog/categories/?$ /modules/propack/blockblog-categories.php [QSA,L] \n"; 
                  	$rules .= "RewriteRule ^(.*)blog/?$ /modules/propack/blockblog-all-posts.php [QSA,L] \n"; 
                    
                  	$rules .= "RewriteRule ^(.*)testimonials/?$ /modules/".$this->name."/blockshopreviews-form.php [QSA,L] \n";
                  	
                  	$rules .= "RewriteRule ^(.*)faq/?$ /modules/".$this->name."/faq.php [QSA,L] \n";  
	                
                  	$rules .= "RewriteRule ^(.*)guestbook/?$ /modules/".$this->name."/blockguestbook-form.php [QSA,L] \n"; 
	                
                  	$rules .= "RewriteRule ^(.*)news/?$ /modules/".$this->name."/items.php [QSA,L] \n"; 
	                $rules .= "RewriteRule ^(.*)news/([0-9a-zA-Z-_]+)/?$ /modules/".$this->name."/item.php?item_id=$2 [QSA,L] \n";
				   
                }
                $rules .= "#propack \n\n";
                
                $path = _PS_ROOT_DIR_.'/.htaccess';

                  if(is_writable($path)){
                      
                      $existingRules = file_get_contents($path);
                      
                      if(!strpos($existingRules, "blog_for_prestashop")){
                        $handle = fopen($path, 'w');
                        fwrite($handle, $rules.$existingRules);
                        fclose($handle);
                      }
                  }
              }
        }
	
	private function __createFolderAndSetPermissionsContentPack(){
		
		$prev_cwd = getcwd();
		
		$module_dir = dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."upload".DIRECTORY_SEPARATOR;
		@chdir($module_dir);
		//folder avatars
		$module_dir_img = $module_dir."blockblog".DIRECTORY_SEPARATOR; 
		@mkdir($module_dir_img, 0777);

		@chdir($prev_cwd);
		
		
		$prev_cwd = getcwd();
		
		$module_dir = dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."upload".DIRECTORY_SEPARATOR;
		@chdir($module_dir);
		//folder avatars
		$module_dir_img = $module_dir."blocknews".DIRECTORY_SEPARATOR; 
		@mkdir($module_dir_img, 0777);

		@chdir($prev_cwd);
		
		
		return true;
	} 
	
	private function _installDB(){
		$sql = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'blog_category` (
							  `id` int(11) NOT NULL auto_increment,
							  `ids_shops` varchar(1024) NOT NULL default \'0\',
							  `time_add` timestamp NOT NULL default CURRENT_TIMESTAMP,
							  PRIMARY KEY  (`id`)
							) ENGINE='.(defined('_MYSQL_ENGINE_')?_MYSQL_ENGINE_:"MyISAM").' DEFAULT CHARSET=utf8;';
		if (!Db::getInstance()->Execute($sql))
			return false;
			
		$query = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'blog_category_data` (
							  `id_item` int(11) NOT NULL,
							  `id_lang` int(11) NOT NULL,
							  `title` varchar(5000) default NULL,
							  `seo_description` text,
							  `seo_keywords` varchar(5000) default NULL,
							  `seo_url` varchar(5000) default NULL,
							  KEY `id_item` (`id_item`)
							) ENGINE='.(defined('_MYSQL_ENGINE_')?_MYSQL_ENGINE_:"MyISAM").' DEFAULT CHARSET=utf8';
		if (!Db::getInstance()->Execute($query))
			return false;
			
		$sql = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'blog_post` (
					  `id` int(11) NOT NULL auto_increment,
					  `img` text,
					  `ids_shops` varchar(1024) NOT NULL default \'0\',
					  `status` int(11) NOT NULL default \'1\',
					  `is_comments` int(11) NOT NULL default \'1\',
					  `time_add` timestamp NOT NULL default CURRENT_TIMESTAMP,
					  PRIMARY KEY  (`id`)
					) ENGINE='.(defined('_MYSQL_ENGINE_')?_MYSQL_ENGINE_:"MyISAM").' DEFAULT CHARSET=utf8;';
		if (!Db::getInstance()->Execute($sql))
			return false;
			
		$query = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'blog_post_data` (
							  `id_item` int(11) NOT NULL,
							  `id_lang` int(11) NOT NULL,
							  `title` varchar(5000) default NULL,
							  `seo_keywords` varchar(5000) default NULL,
							  `seo_description` text,
							  `content` text,
							  `seo_url` varchar(5000) default NULL,
							  KEY `id_item` (`id_item`)
							) ENGINE='.(defined('_MYSQL_ENGINE_')?_MYSQL_ENGINE_:"MyISAM").' DEFAULT CHARSET=utf8';
		if (!Db::getInstance()->Execute($query))
			return false;
		
			
		$sql = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'blog_comments` (
							  `id` int(11) NOT NULL auto_increment,
							  `id_lang` int(11) NOT NULL,
							  `name` varchar(5000) default NULL,
							  `email` varchar(500) default NULL,
							  `comment` text,
							  `status` int(11) NOT NULL default \'0\',
							  `id_post` int(11) NOT NULL,
							  `id_shop` int(11) NOT NULL default \'0\',
							  `time_add` timestamp NOT NULL default CURRENT_TIMESTAMP,
							  PRIMARY KEY  (`id`)
							) ENGINE='.(defined('_MYSQL_ENGINE_')?_MYSQL_ENGINE_:"MyISAM").' DEFAULT CHARSET=utf8;';
		if (!Db::getInstance()->Execute($sql))
			return false;

		$sql = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'blog_category2post` (
							  `category_id` int(11) NOT NULL,
							  `post_id` int(11) NOT NULL,
							  KEY `category_id` (`category_id`),
							  KEY `post_id` (`post_id`),
							  KEY `category2post` (`category_id`,`post_id`)
							) ENGINE='.(defined('_MYSQL_ENGINE_')?_MYSQL_ENGINE_:"MyISAM").' DEFAULT CHARSET=utf8;';
		if (!Db::getInstance()->Execute($sql))
			return false;
			
			
		#### Product reviews + Google Snippets, Breadcrumb, Rich Pin ####	
		$db = Db::getInstance();
		$query = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'reviewsnippets` (
				  `id` int(11) NOT NULL auto_increment,
				  `id_product` int(11) NOT NULL,
				  `id_customer` int(11) NOT NULL default \'0\',
				  `subject` varchar(500) default NULL,
				  `text_review` text,
				  `customer_name` varchar(500) NOT NULL,
				  `recommended_product` int(11) NOT NULL default \'1\' COMMENT \'1 - Yes, 2 - No\',
				  `rating` int(11) NOT NULL,
				  `id_lang` int(11) NOT NULL default \'0\',
				  `id_shop` int(11) NOT NULL default \'0\',
				  `active` int(11) NOT NULL default \'1\',
				  `deleted` int(11) NOT NULL default \'0\',
				  `date_add` timestamp NOT NULL default CURRENT_TIMESTAMP,
				   `ip` VARCHAR(255) NOT NULL,
				   `email` VARCHAR(255) NOT NULL,
				   `is_import` int(11) NOT NULL default \'0\',
				   PRIMARY KEY  (`id`),
				   KEY `id_product` (`id_product`),
				   KEY `id_customer` (`id_customer`)
				) ENGINE='.(defined(_MYSQL_ENGINE_)?_MYSQL_ENGINE:"MyISAM").' DEFAULT CHARSET=utf8';
		$db->Execute($query);
		
		$sql = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'reviewsnippets_data_order` (
					  `id` int(10) NOT NULL AUTO_INCREMENT,
					  `id_shop` int(11) NOT NULL default \'0\',
					  `order_id` int(10) NOT NULL,
					  `date_add` timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\',
					  `status` int(10) NOT NULL default \'0\',
					  `customer_id` int(11) NOT NULL default \'0\',
					  `data` text,
					  PRIMARY KEY (`id`)
					) ENGINE='.(defined(_MYSQL_ENGINE_)?_MYSQL_ENGINE:"MyISAM").' DEFAULT CHARSET=utf8;';
		$db->Execute($sql);
		
		$sql = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'reviewsnippets_customer` (
						  `id_shop` int(11) NOT NULL default \'0\',
						  `customer_id` int(11) NOT NULL default \'0\',
						  `status` int(10) NOT NULL default \'0\',
						  PRIMARY KEY (`id_shop`,`customer_id`),
						  KEY `shop_status` (`id_shop`,`status`)
						) ENGINE='.(defined(_MYSQL_ENGINE_)?_MYSQL_ENGINE:"MyISAM").' DEFAULT CHARSET=utf8;';
		$db->Execute($sql);
		#### Product reviews + Google Snippets, Breadcrumb, Rich Pin ####
			
		
		##### Testimonials #####	
		$query = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'blockshopreviews` (
							  `id` int(11) NOT NULL auto_increment,
							  `name` varchar(500) NOT NULL,
							  `email` varchar(500) NOT NULL,
							  `web` varchar(500) default NULL,
							  `company` varchar(500) default NULL,
							  `address` varchar(500) default NULL,
							  `message` text NOT NULL,
							  `id_shop` int(11) NOT NULL default \'0\',
							  `id_lang` int(11) NOT NULL default \'0\',
							  `active` int(11) NOT NULL default \'0\',
							  `is_deleted` int(11) NOT NULL default \'0\',
							  `date_add` timestamp NOT NULL default CURRENT_TIMESTAMP,
							  PRIMARY KEY  (`id`)
							) ENGINE='.(defined('_MYSQL_ENGINE_')?_MYSQL_ENGINE_:"MyISAM").' DEFAULT CHARSET=utf8;';
		$db->Execute($query);
		
		##### Testimonials #####	
		
		
		### FAQ ####
		
		$sql = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'faq_category` (
							  `id` int(11) NOT NULL auto_increment,
							  `ids_shops` varchar(1024) NOT NULL default \'0\',
							  `order_by` int(10) default NULL,
							  `status` int(11) NOT NULL default \'1\',
							  `time_add` timestamp NOT NULL default CURRENT_TIMESTAMP,
							  PRIMARY KEY  (`id`)
							) ENGINE='.(defined('_MYSQL_ENGINE_')?_MYSQL_ENGINE_:"MyISAM").' DEFAULT CHARSET=utf8;';
		Db::getInstance()->Execute($sql);
			
		$query = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'faq_category_data` (
							  `id_item` int(11) NOT NULL,
							  `id_lang` int(11) NOT NULL,
							  `title` varchar(5000) default NULL,
							  KEY `id_item` (`id_item`)
							) ENGINE='.(defined('_MYSQL_ENGINE_')?_MYSQL_ENGINE_:"MyISAM").' DEFAULT CHARSET=utf8';
		Db::getInstance()->Execute($query);
			
		$sql = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'faq_item` (
							  `id` int(11) NOT NULL auto_increment,
							  `status` int(11) NOT NULL default \'1\',
							  `order_by` int(10) default NULL,
							  `ids_shops` varchar(1024) NOT NULL default \'0\',
							  `customer_name` varchar(5000) NOT NULL,
							  `customer_email` varchar(5000) NOT NULL,
							  `is_by_customer` int(11) NOT NULL DEFAULT \'0\',
							  `is_add_by_customer` int(11) NOT NULL DEFAULT \'0\',
							  `time_add` timestamp NOT NULL default CURRENT_TIMESTAMP,
							  PRIMARY KEY  (`id`)
							) ENGINE='.(defined('_MYSQL_ENGINE_')?_MYSQL_ENGINE_:"MyISAM").' DEFAULT CHARSET=utf8;';
		Db::getInstance()->Execute($sql);
			
		$query = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'faq_item_data` (
							  `id_item` int(11) NOT NULL,
							  `id_lang` int(11) NOT NULL,
							  `title` varchar(5000) NOT NULL,
							  `content` text default NULL,
							  KEY `id_item` (`id_item`)
							) ENGINE='.(defined('_MYSQL_ENGINE_')?_MYSQL_ENGINE_:"MyISAM").' DEFAULT CHARSET=utf8';
		Db::getInstance()->Execute($query);
		
		$sql = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'faq_category2item` (
							  `category_id` int(11) NOT NULL,
							  `faq_id` int(11) NOT NULL,
							  KEY `category_id` (`category_id`),
							  KEY `post_id` (`faq_id`),
							  KEY `category2item` (`category_id`,`faq_id`)
							) ENGINE='.(defined('_MYSQL_ENGINE_')?_MYSQL_ENGINE_:"MyISAM").' DEFAULT CHARSET=utf8;';
		Db::getInstance()->Execute($sql);
			
		#### FAQ ####
		
		### Guestbook ###
		$query = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'blockguestbook` (
							  `id` int(11) NOT NULL auto_increment,
							  `name` varchar(500) NOT NULL,
							  `email` varchar(500) NOT NULL,
							  `ip` varchar(500) default NULL,
							  `message` text NOT NULL,
							  `id_shop` int(11) NOT NULL default \'0\',
							  `id_lang` int(11) NOT NULL default \'0\',
							  `active` int(11) NOT NULL default \'0\',
							  `is_deleted` int(11) NOT NULL default \'0\',
							  `date_add` timestamp NOT NULL default CURRENT_TIMESTAMP,
							  PRIMARY KEY  (`id`)
							) ENGINE='.(defined('_MYSQL_ENGINE_')?_MYSQL_ENGINE_:"MyISAM").' DEFAULT CHARSET=utf8;';
		$db->Execute($query);
		### GuestBook ###
		
		### News ###
		$sql = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'blocknews` (
							  `id` int(11) NOT NULL auto_increment,
							  `img` text, 
							  `ids_shops` varchar(1024) NOT NULL default \'0\',
							  `status` int(11) NOT NULL default \'1\',
							  `time_add` timestamp NOT NULL default CURRENT_TIMESTAMP,
							  PRIMARY KEY  (`id`)
							) ENGINE='.(defined('_MYSQL_ENGINE_')?_MYSQL_ENGINE_:"MyISAM").' DEFAULT CHARSET=utf8;';
		if (!Db::getInstance()->Execute($sql))
			return false;
			
		$query = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'blocknews_data` (
							  `id_item` int(11) NOT NULL,
							  `id_lang` int(11) NOT NULL,
							  `seo_description` text,
							  `seo_keywords` varchar(5000) default NULL,
							  `seo_url` varchar(5000) default NULL,
							  `title` varchar(5000) NOT NULL,
							  `content` text NOT NULL,
							  KEY `id_item` (`id_item`)
							) ENGINE='.(defined('_MYSQL_ENGINE_')?_MYSQL_ENGINE_:"MyISAM").' DEFAULT CHARSET=utf8';
		Db::getInstance()->Execute($query);
		### News ###
		
		### Product questions ###
		$db = Db::getInstance();
		$query = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'prodquestions` (
							  `id` int(11) NOT NULL auto_increment,
							  `name` varchar(500) NOT NULL,
							  `question` text,
							  `response` text,
							  `email` VARCHAR(255) NOT NULL,
							  `id_shop` int(11) NOT NULL default \'0\',
							  `id_lang` int(11) NOT NULL default \'0\',
							  `id_product` int(11) NOT NULL,
							  `is_active` int(11) NOT NULL default \'0\',
							  `time_add` timestamp NOT NULL default CURRENT_TIMESTAMP,
							  PRIMARY KEY  (`id`)
							) ENGINE='.(defined('_MYSQL_ENGINE_')?_MYSQL_ENGINE_:"MyISAM").' DEFAULT CHARSET=utf8';
		$db->Execute($query);
		### Product questions ###
		
		return true;
	}
	
	private function _uninstallDB() {
		Db::getInstance()->Execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'blog_category');
		Db::getInstance()->Execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'blog_category_data');
		Db::getInstance()->Execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'blog_post');
		Db::getInstance()->Execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'blog_post_data');
		Db::getInstance()->Execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'blog_comments');
		Db::getInstance()->Execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'blog_category2post');
		
		Db::getInstance()->Execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'reviewsnippets');
		
		Db::getInstance()->Execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'blockshopreviews');
		
		Db::getInstance()->Execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'faq_category');
		Db::getInstance()->Execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'faq_category_data');
		Db::getInstance()->Execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'faq_item');
		Db::getInstance()->Execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'faq_item_data');
		Db::getInstance()->Execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'faq_category2item');
		
		Db::getInstance()->Execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'blockguestbook');
		
		Db::getInstance()->Execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'blocknews');
		Db::getInstance()->Execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'blocknews_data');
		
		Db::getInstance()->Execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'prodquestions');
		return true;
	}
	
	public function uninstallTable() {
		Db::getInstance()->Execute('DROP TABLE IF EXISTS '._DB_PREFIX_.$this->name.'_img');
		Db::getInstance()->Execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'fb_customer');
		Db::getInstance()->Execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'tw_customer');
		Db::getInstance()->Execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'four_referral');
		
		return true;
	}
	
	
function installReferralsTable(){
		$db = Db::getInstance();
		$query = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'four_referral` (
						  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
						  `user_id` int(11) unsigned NOT NULL,
						  `id_product` bigint(20) NOT NULL default \'0\',
						  `coupon_id` int(11) unsigned NOT NULL default \'0\',
						  `ip` VARCHAR(255) NOT NULL,
						  `id_shop` int(11) NOT NULL default \'0\',
						  `type` int(11) unsigned NOT NULL default \'0\' COMMENT \'0 - direct, 1 - facebook, 2 - twitter, 3 - linkedin, 4 - google\',
						  `date` datetime NOT NULL,
						  PRIMARY KEY (`id`),
						  KEY `user_id` (`user_id`)
						) ENGINE='.(defined('_MYSQL_ENGINE_')?_MYSQL_ENGINE_:"MyISAM").' DEFAULT CHARSET=utf8 AUTO_INCREMENT=1';
	
		$db->Execute($query);
		return true;
	}
private function _createFolderAndSetPermissionsPinterestWidget(){
		
		$prev_cwd = getcwd();
		
		@chdir(_PS_ROOT_DIR_.'/upload/');

		$make_dir = _PS_ROOT_DIR_."/upload/pinterestwidget/"; 
		@mkdir($make_dir, 0777);
		@chdir($make_dir);
		
		$make_dir = $make_dir."cache/"; 
		@mkdir($make_dir, 0777);

		@chdir($prev_cwd);
		
		return true;
	}
	
	function createGoogleWidgetTbl()
	{
	
	$db = Db::getInstance();
	$sql = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'google_widget` (
							  `id` int(11) NOT NULL auto_increment,
							  `content` text NOT NULL,
							  PRIMARY KEY  (`id`)
							) ENGINE='.(defined('_MYSQL_ENGINE_')?_MYSQL_ENGINE_:"MyISAM").' DEFAULT CHARSET=utf8;';
	Db::getInstance()->Execute($sql);
	
	$gwidgetcode = json_encode('<iframe src="http://widgetsplus.com:8080/13671.htm" width="190" height="379" style="padding:0; margin:0; overflow:hidden;" frameborder="0"></iframe>');
	 	
	$sql = 'INSERT into `'._DB_PREFIX_.'google_widget` SET
							   `content` = "'.mysql_escape_string($gwidgetcode).'"
							   ';
		
	$result = $db->Execute($sql);
	return true;
	
	}
	
	private function _createFolderAndSetPermissions(){
		
		$prev_cwd = getcwd();
		
		$module_dir = dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."upload".DIRECTORY_SEPARATOR;
		@chdir($module_dir);
		
		//folder logo
		
		$module_dir_img = $module_dir.$this->name.DIRECTORY_SEPARATOR; 
		@mkdir($module_dir_img, 0777);

		@chdir($prev_cwd);
		
		return true;
	} 
	
	function createCustomerTbl()
	{
	
		
		$db = Db::getInstance();
		
		$query = 'CREATE TABLE IF NOT EXISTS '._DB_PREFIX_.'fb_customer (
				  `customer_id` int(10) NOT NULL,
				  `fb_id` bigint(20) NOT NULL,
				  `id_shop` int(11) NOT NULL default \'0\',
				  UNIQUE KEY `PROPACK_CUSTOMER` (`customer_id`,`fb_id`,`id_shop`)
				  ) ENGINE=InnoDB DEFAULT CHARSET=utf8';
		$db->Execute($query);

		$sql = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.$this->name.'_img` (
					  `id` int(11) NOT NULL auto_increment,
					  `img` text,
					  `id_shop` int(11) NOT NULL default \'0\',
					  `type` int(11) NOT NULL default \'1\' 
					  	,
					  PRIMARY KEY  (`id`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;';
		$db->Execute($sql);
		
		return true;
			
	
	}
	
	public function createUserTwitterTable(){
		
		$db = Db::getInstance();
		$query = 'CREATE TABLE IF NOT EXISTS '._DB_PREFIX_.'tw_customer (
				   `id` int(11) NOT NULL AUTO_INCREMENT,
					  `twitter_id` bigint(20) NOT NULL,
					  `user_id` int(11) NOT NULL,
					  `id_shop` int(11) NOT NULL default \'0\',
					   UNIQUE KEY `PROPACK_CUSTOMER` (`twitter_id`,`user_id`,`id_shop`),
					  PRIMARY KEY (`id`)
					) ENGINE='.(defined('_MYSQL_ENGINE_')?_MYSQL_ENGINE_:"MyISAM").'  DEFAULT CHARSET=utf8';
		$db->Execute($query);
		return true;
		
	}
			
	public function getContent()
    {
    	$cookie = $this->context->cookie;
		
    	global  $currentIndex;
    	$this->_html = '';
    	$this->_html .= $this->_jsandcss();
       
    	
    #### Product questions ####
        
        if (Tools::isSubmit('submit_q'))
        {
        	 Configuration::updateValue($this->name.'pqon', Tools::getValue('pqon'));
        	 
        	 Configuration::updateValue($this->name.'qsettings', Tools::getValue('qsettings'));
        	 Configuration::updateValue($this->name.'qnoti', Tools::getValue('qnoti'));
        	 Configuration::updateValue($this->name.'qmail', Tools::getValue('qmail'));
        	 Configuration::updateValue($this->name.'qperpage_q', Tools::getValue('qperpage_q'));
        	 Configuration::updateValue($this->name.'qis_captcha', Tools::getValue('qis_captcha'));
        	 Configuration::updateValue($this->name.'position_ask_q', Tools::getValue('position_ask_q'));
        	 $page = (int)Tools::getValue("page_q");
			 Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'&page_q='.$page);
			
        	 $this->_html .= '<script>init_tabs(38);</script>';
        	 
        }
        
   		 // delete item
		if (Tools::isSubmit("delete_item_pq")) {
			if (Validate::isInt(Tools::getValue("id"))) {
				
				include_once(dirname(__FILE__).'/classes/prodquestionshelp.class.php');
				$obj_prodquestionshelp = new prodquestionshelp();
				
				$obj_prodquestionshelp->delete(array('id'=>Tools::getValue("id")));
				$page = Tools::getValue("page_q");
				Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'&page_q='.$page);
			}
			$this->_html .= '<script>init_tabs(38);</script>';
		}
		
    	if (Tools::isSubmit('cancel_item_pq'))
        {
        	$page = Tools::getValue("page_q");
        	Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'&page_q='.$page);
        	$this->_html .= '<script>init_tabs(38);</script>';
		}
		
     	if (Tools::isSubmit('submit_item_pq'))
        {
        	include_once(dirname(__FILE__).'/classes/prodquestionshelp.class.php');
			$obj_prodquestionshelp = new prodquestionshelp();
				
        	$name = (strlen(Tools::getValue("name"))==0?Tools::getValue("name"):Tools::getValue("name"));
        	$question = Tools::getValue("question");
        	$response = Tools::getValue("response");
        	$publish = (int)Tools::getValue("publish");
        	$id = Tools::getValue("id");
     		
         	$data = array('name' => $name,
         				  'question' => $question,
         				  'id' => $id,
         				  'response' => $response,
         				  'publish' => $publish
         				 );
         	if(strlen($name)>0) {
         		$obj_prodquestionshelp->updateItem($data);
         		if($publish)
         			$obj_prodquestionshelp->sendNotificationResponse(array('id'=>$id));	
         	}
        	$page = Tools::getValue("page_q");
			Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'&page_q='.$page);
			$this->_html .= '<script>init_tabs(38);</script>';
		}
    	
    	if (Tools::isSubmit('edit_item_pq') || Tools::isSubmit('page_q'))
        {
        	$this->_html .= '<script>init_tabs(38);</script>';
        }
        #### Product questions ####
        
        #### News ####
        
    	include_once(dirname(__FILE__).'/classes/blocknewshelp.class.php');
		$obj_blocknews = new blocknewshelp();
		
    	
		
		if (Tools::isSubmit('submit_item_n'))
        {
	        if($this->_is15){
		    		$cat_shop_association = Tools::getValue("cat_shop_association");
		    } else{
		    		$cat_shop_association = array(0=>0);
		    }
        	$seo_url = Tools::getValue("seo_url");
    		$languages = Language::getLanguages(false);
	    	$data_title_content_lang = array();
	    	foreach ($languages as $language){
	    		$id_lang = $language['id_lang'];
	    		$title = Tools::getValue("titlenews_".$id_lang);
	    		$content = Tools::getValue("contentnews_".$id_lang);
	    		$post_seokeywords = Tools::getValue("post_seokeywordsnews_".$id_lang);
	    		$post_seodescription = Tools::getValue("post_seodescriptionnews_".$id_lang);
	    		
	    		
	    		if(strlen($title)>0 && strlen($content)>0 && !empty($cat_shop_association))
	    		{
	    			$data_title_content_lang[$id_lang] = array('title' => $title,
	    									 				    'content' => $content,
	    														'post_seodescription' => $post_seodescription,
	    													    'post_seokeywords' => $post_seokeywords,
	    			 										    'seo_url' => $seo_url
	    													    
	    													    );		
	    		}
	    	}
	    	
        	$item_status = Tools::getValue("item_status");
        	
        	$data = array( 'data_title_content_lang'=>$data_title_content_lang,
         				 	'item_status' => $item_status,
        				  'cat_shop_association' => $cat_shop_association,
         				
         				  );
         	if(sizeof($data_title_content_lang)>0)
         		$obj_blocknews->saveItem($data);
        		
			Tools::redirectAdmin($currentIndex.'&pageitems_n&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'');
			$this->_html .= '<script>init_tabs(37);</script>';
		}
		
    	if (Tools::isSubmit("delete_item_n")) {
			if (Validate::isInt(Tools::getValue("id"))) {
				
				$data = array('id' => Tools::getValue("id"));
				$obj_blocknews->deleteItem($data);
				
				$page = Tools::getValue("pageitems_n");
				Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'&pageitems_n='.$page);
			}
			$this->_html .= '<script>init_tabs(37);</script>';
			
		}
		
    	if (Tools::isSubmit('submit_news'))
        {
        	 Configuration::updateValue($this->name.'newson', Tools::getValue('newson'));
        	 
        	 Configuration::updateValue($this->name.'news_home', Tools::getValue('news_home'));
        	 Configuration::updateValue($this->name.'news_left', Tools::getValue('news_left'));
        	 Configuration::updateValue($this->name.'news_right', Tools::getValue('news_right'));
        	 Configuration::updateValue($this->name.'news_footer', Tools::getValue('news_footer'));
        	
        	 Configuration::updateValue($this->name.'nfaq_blc', Tools::getValue('nfaq_blc'));
        	 Configuration::updateValue($this->name.'nperpage_posts', Tools::getValue('nperpage_posts'));
        	 $this->_html .= '<script>init_tabs(37);</script>';
        }
       
    	if (Tools::isSubmit('cancel_item_n'))
        {
        	$page = Tools::getValue("pageitems_n");
        	Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'&pageitems_n='.$page);
        	$this->_html .= '<script>init_tabs(37);</script>';
		}
		
		if (Tools::isSubmit('update_item_n'))
        {
        	$id = Tools::getValue("id");
     		$seo_url = Tools::getValue("seo_url");
    		
        	if($this->_is15){
		    		$cat_shop_association = Tools::getValue("cat_shop_association");
		    } else{
		    		$cat_shop_association = array(0=>0);
		    }
     		
        	$languages = Language::getLanguages(false);
	    	$data_title_content_lang = array();
	    	foreach ($languages as $language){
	    		$id_lang = $language['id_lang'];
	    		$title = Tools::getValue("titlenews_".$id_lang);
	    		$content = Tools::getValue("contentnews_".$id_lang);
	    		$post_seokeywords = Tools::getValue("post_seokeywordsnews_".$id_lang);
	    		$post_seodescription = Tools::getValue("post_seodescriptionnews_".$id_lang);
	    		
	    		
	    		if(strlen($title)>0 && strlen($content)>0 && !empty($cat_shop_association))
	    		{
	    			$data_title_content_lang[$id_lang] = array('title' => $title,
	    									 				    'content' => $content,
	    			 											'post_seokeywords' => $post_seokeywords,
	    			 										   'post_seodescription' => $post_seodescription,
	    													  'seo_url'=>$seo_url
	    													    );		
	    		}
	    	}
        	
         	$item_status = Tools::getValue("item_status");
        	$post_images = Tools::getValue("post_images");
        	
         	$data = array('data_title_content_lang'=>$data_title_content_lang,
        				  'id' => $id,
         				  'item_status' => $item_status,
         				  'post_images' => $post_images,
         				  'cat_shop_association' => $cat_shop_association,
         				 );
         	if(sizeof($data_title_content_lang)>0)
         		$obj_blocknews->updateItem($data);
         		
         	$page = Tools::getValue("pageitems_n");
         	Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'&pageitems_n='.$page);
			$this->_html .= '<script>init_tabs(37);</script>';
        }
        
    	if (Tools::isSubmit('edit_item_n') || Tools::isSubmit('pageitems_n'))
        {
        	$this->_html .= '<script>init_tabs(37);</script>';
        }
        
        #### News ####
        
        
        ### GuestBook ####
        
    	include_once(dirname(__FILE__).'/classes/guestbook.class.php');
		$obj_guestbook = new guestbook();
		
	    
       // publish
	   if (Tools::isSubmit("published_g")) {
			if (Validate::isInt(Tools::getValue("id"))){
				$obj_guestbook->publish(array('id'=>Tools::getValue("id")));
			} 
			Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'&page_g='.Tools::getValue("page_g"));
			
		}
		
		//unpublish
		if (Tools::isSubmit("unpublished_g")) {
			if (Validate::isInt(Tools::getValue("id"))){
				$obj_guestbook->unpublish(array('id'=>Tools::getValue("id")));
				
			} 
			Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'&page_g='.Tools::getValue("page_g"));
			
		}
		
    	// delete item
		if (Tools::isSubmit("delete_item_g")) {
			if (Validate::isInt(Tools::getValue("id"))) {
				$obj_guestbook->delete(array('id'=>Tools::getValue("id")));
				Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'&page_g='.Tools::getValue("page_g"));
			
			}
			
		}
	    
	    if (Tools::isSubmit('submit_guestbook'))
        {
        	
        	 Configuration::updateValue($this->name.'guon', Tools::getValue('guon'));
        	
        	  Configuration::updateValue($this->name.'g_home', Tools::getValue('g_home'));
        	 Configuration::updateValue($this->name.'g_left', Tools::getValue('g_left'));
        	 Configuration::updateValue($this->name.'g_right', Tools::getValue('g_right'));
        	 Configuration::updateValue($this->name.'g_footer', Tools::getValue('g_footer'));
        	
        	 Configuration::updateValue($this->name.'gperpage', Tools::getValue('gperpage'));
        	 Configuration::updateValue($this->name.'gnoti', Tools::getValue('gnoti'));
        	 Configuration::updateValue($this->name.'gmail', Tools::getValue('gmail'));
        	 Configuration::updateValue($this->name.'gbook_blc', Tools::getValue('gbook_blc'));
        	 
        	 Configuration::updateValue($this->name.'gis_captcha', Tools::getValue('gis_captcha'));
        	 
        	 
        	 $this->_html .= '<script>init_tabs(36);</script>';
        
        }
        
        
        if (Tools::isSubmit('submit_item_g'))
        {
        	$name = (strlen(Tools::getValue("name"))==0?Tools::getValue("name"):Tools::getValue("name"));
        	$email = (strlen(Tools::getValue("email"))==0?Tools::getValue("email"):Tools::getValue("email"));
        	$message = (strlen(Tools::getValue("message"))==0?Tools::getValue("message"):Tools::getValue("message"));
        	$publish = (int)Tools::getValue("publish");
        	
        	$obj_guestbook->updateItem(array('name'=>$name,
        									 'email'=>$email,
        									 'message'=>$message,
        									 'publish'=>$publish,
        									 'id'=>Tools::getValue("id")
        									 )
        								);
        	
        	Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'&page_g='.Tools::getValue("page_g"));
			$this->_html .= '<script>init_tabs(36);</script>';
        }
               
		if (Tools::isSubmit('cancel_item_g'))
        {
        	Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'&page_g='.Tools::getValue("page_g"));
			$this->_html .= '<script>init_tabs(36);</script>';
		}
        
		if (Tools::isSubmit('page_g')|| Tools::isSubmit('edit_item_g'))
        {
         $this->_html .= '<script>init_tabs(36);</script>';
        }
		
        ### GuestBook ####
        
        #### FAQ ####
       
        include_once(dirname(__FILE__).'/classes/blockfaqhelp.class.php');
		$obj_blockfaq = new blockfaqhelp();
		
		
		$id_self = (int)Tools::getValue('id');
		$order_self = Tools::getValue('order_self');
    	if($order_self){
				$obj_blockfaq->update_order($id_self, $order_self, Tools::getValue('id_change'), Tools::getValue('order_change'));
					Tools::redirectAdmin($currentIndex.'&item_faq_page&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'');
		
				
			}
			
    	$id_self = (int)Tools::getValue('id_faqcat');
		$order_self = Tools::getValue('order_self_faqcat');
		if($order_self){
				$obj_blockfaq->update_order_faqcat($id_self, $order_self, Tools::getValue('id_change_faqcat'), 
											 Tools::getValue('order_change_faqcat'));
					Tools::redirectAdmin($currentIndex.'&item_faq_page&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'');
									 
			}	
		
		// faq category //
    	if(Tools::isSubmit('submit_item_faq_cat')){
			
			
			$languages = Language::getLanguages(false);
	    	$data_title_content_lang = array();
	    	
        	if($this->_is15){
	    		$faq_shop_association = Tools::getValue("faq_shop_association");
	    	} else{
	    		$faq_shop_association = array(0=>0);
	    	}
	    	$cat_status = Tools::getValue("faq_cat_status");
	    	$faq_questions_association = Tools::getValue("faq_questions_association");
	    	
	    	foreach ($languages as $language){
	    		$id_lang = $language['id_lang'];
	    		$title = Tools::getValue("titlecat_".$id_lang);
	    		
	    		if(strlen($title)>0 && !empty($faq_shop_association))
	    		{
	    			$data_title_content_lang[$id_lang] = array('title' => $title,
	    									 				    );		
	    		}
	    	}
	    	
        	$data = array( 'data_title_content_lang'=>$data_title_content_lang,
        				   'item_status' => $cat_status,
        				   'faq_shop_association' => $faq_shop_association,
        				   'faq_questions_association'=>$faq_questions_association
         				  );
         				  
         	if(sizeof($data_title_content_lang)>0)
         		$obj_blockfaq->saveItemCategory($data);
        		
			Tools::redirectAdmin($currentIndex.'&item_faq_page&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'');
		}	
		
		
		if(Tools::isSubmit('update_item_faq_cat')){
        	
        	
        	$id = Tools::getValue("id");
     		
        	$languages = Language::getLanguages(false);
	    	$data_title_content_lang = array();
        	if($this->_is15){
	    		$faq_shop_association = Tools::getValue("faq_shop_association");
	    	} else{
	    		$faq_shop_association = array(0=>0);
	    	}
	    	
	    	foreach ($languages as $language){
	    		$id_lang = $language['id_lang'];
	    		$title = Tools::getValue("titlecat_".$id_lang);
	    		
	    		if(strlen($title)>0 && !empty($faq_shop_association))
	    		{
	    			$data_title_content_lang[$id_lang] = array('title' => $title
	    									 				    );		
	    		}
	    	}
        	
         	$cat_status = Tools::getValue("faq_cat_status");
         	$faq_questions_association = Tools::getValue("faq_questions_association");
	    	
         	$data = array('data_title_content_lang'=>$data_title_content_lang,
        				  'id' => $id,
         				  'item_status' => $cat_status,
         				  'faq_shop_association' => $faq_shop_association,
         				  'faq_questions_association' => $faq_questions_association
         				  );
         	if(sizeof($data_title_content_lang)>0)
         		$obj_blockfaq->updateItemCategory($data);
        	
          	Tools::redirectAdmin($currentIndex.'&item_faq_page&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'');
			
        }
        
   		 if (Tools::isSubmit("delete_item_faqcat")) {
			if (Validate::isInt(Tools::getValue("id"))) {
				
				$data = array('id' => Tools::getValue("id"));
				$obj_blockfaq->deleteItemCategory($data);
				
				Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'');
			}
			
		}
		
    	if (Tools::isSubmit('cancel_item_faq_cat'))
        {
        	Tools::redirectAdmin($currentIndex.'&item_faq_page&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'');
		}	
			
		// faq category //
    	
		
		if (Tools::isSubmit('submit_item_q'))
        {
        	
        	$languages = Language::getLanguages(false);
	    	$data_title_content_lang = array();
	    	
        	if($this->_is15){
	    		$faq_shop_association = Tools::getValue("faq_shop_association");
	    	} else{
	    		$faq_shop_association = array(0=>0);
	    	}
	    	
	    	$faq_item_status = Tools::getValue("faq_item_status");
	    	$is_by_customer = Tools::getValue("is_by_customer");
	    	$faq_customer_email = Tools::getValue("faq_customer_email");
	    	$faq_customer_name = Tools::getValue("faq_customer_name");
	    	$faq_category_association = Tools::getValue("faq_category_association");
	    	
	    	
	    	foreach ($languages as $language){
	    		$id_lang = $language['id_lang'];
	    		$title = Tools::getValue("titlefaq_".$id_lang);
	    		$content = Tools::getValue("contentfaq_".$id_lang);
	    		
	    		if(strlen($title)>0 && strlen($content)>0 && !empty($faq_shop_association))
	    		{
	    			$data_title_content_lang[$id_lang] = array('title' => $title,
	    									 				    'content' => $content
	    													    );		
	    		}
	    	}
	    	
        	$data = array( 'data_title_content_lang'=>$data_title_content_lang,
        				   'item_status' => 1,
        				   'faq_shop_association' => $faq_shop_association,
        				   'is_by_customer' => $is_by_customer,
        				   'faq_customer_name' => $faq_customer_name,
        				   'faq_customer_email'=>$faq_customer_email,
        				   'faq_category_association'=>$faq_category_association
        				  
         				  );
         	if(sizeof($data_title_content_lang)>0)
         		$obj_blockfaq->saveItem($data);
        	
        	
			//Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'');
			Tools::redirectAdmin($currentIndex.'&item_faq_page&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'');
        	
			$this->_html .= '<script>init_tabs(35);</script>';
		}
		
    	if (Tools::isSubmit("delete_item_q")) {
			if (Validate::isInt(Tools::getValue("id"))) {
				
				$data = array('id' => Tools::getValue("id"));
				$obj_blockfaq->deleteItem($data);
				
			Tools::redirectAdmin($currentIndex.'&item_faq_page&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'');
        	
			$this->_html .= '<script>init_tabs(35);</script>';
			}
			
		}
		
		
		
    	if (Tools::isSubmit('submit_faq'))
        {
        	 Configuration::updateValue($this->name.'faq_home', Tools::getValue('faq_home'));
        	 Configuration::updateValue($this->name.'faq_left', Tools::getValue('faq_left'));
        	 Configuration::updateValue($this->name.'faq_right', Tools::getValue('faq_right'));
        	 Configuration::updateValue($this->name.'faq_footer', Tools::getValue('faq_footer'));
        	 
        	 Configuration::updateValue($this->name.'faq_blc', Tools::getValue('faq_blc'));
        	 
        	  Configuration::updateValue($this->name.'faqon', Tools::getValue('faqon'));
        	  
        	  Configuration::updateValue($this->name.'faqis_captcha', Tools::getValue('faqis_captcha'));
        	 
        	 
        	 Configuration::updateValue($this->name.'faqis_askform', Tools::getValue('faqis_askform'));
        	 
        	 
        	 Configuration::updateValue($this->name.'notifaq', Tools::getValue('notifaq'));
        	 Configuration::updateValue($this->name.'mailfaq', Tools::getValue('mailfaq'));
        	  
        	Tools::redirectAdmin($currentIndex.'&item_faq_page&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'');
        	 
        	$this->_html .= '<script>init_tabs(35);</script>';
        }
       
    	if (Tools::isSubmit('cancel_item_q'))
        {
        	Tools::redirectAdmin($currentIndex.'&item_faq_page&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'');
        	
			$this->_html .= '<script>init_tabs(35);</script>';
		}
		
		if (Tools::isSubmit('update_item_q'))
        {
        	
        	$id = Tools::getValue("id");
     		
        	$languages = Language::getLanguages(false);
	    	$data_title_content_lang = array();
        	if($this->_is15){
	    		$faq_shop_association = Tools::getValue("faq_shop_association");
	    	} else{
	    		$faq_shop_association = array(0=>0);
	    	}
	    	
	    	$faq_item_status = Tools::getValue("faq_item_status");
	    	$is_by_customer = Tools::getValue("is_by_customer");
	    	$faq_customer_email = Tools::getValue("faq_customer_email");
	    	$faq_customer_name = Tools::getValue("faq_customer_name");
	    	$faq_category_association = Tools::getValue("faq_category_association");
	    	
	    	$is_add_by_customer = Tools::getValue("is_add_by_customer");
	    	
	    	
	    	foreach ($languages as $language){
	    		$id_lang = $language['id_lang'];
	    		$title = Tools::getValue("titlefaq_".$id_lang);
	    		$content = Tools::getValue("contentfaq_".$id_lang);
	    		
	    		if(strlen($title)>0 && strlen($content)>0 && !empty($faq_shop_association))
	    		{
	    			$data_title_content_lang[$id_lang] = array('title' => $title,
	    									 				    'content' => $content
	    													    );		
	    		}
	    	}
        	
         	$data = array('data_title_content_lang'=>$data_title_content_lang,
        				  'id' => $id,
         				  'item_status' => $faq_item_status,
         				  'faq_shop_association' => $faq_shop_association,
         				  'is_by_customer' => $is_by_customer,
        				  'faq_customer_name' => $faq_customer_name,
        				  'faq_customer_email'=>$faq_customer_email,
        				  'faq_category_association'=>$faq_category_association,
         				  'is_add_by_customer' => $is_add_by_customer
         				  );
         	if(sizeof($data_title_content_lang)>0)
         		$obj_blockfaq->updateItem($data);
         		
        	
         	Tools::redirectAdmin($currentIndex.'&item_faq_page&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'');
        	
			$this->_html .= '<script>init_tabs(35);</script>';
        }
        
   		 if (Tools::isSubmit('edit_item_q') || $order_self || Tools::isSubmit('item_faq_page') || 
   		 	 Tools::isSubmit('edit_item_faqcat') || Tools::isSubmit('order_self') || Tools::isSubmit('id_category'))
        {
        	$this->_html .= '<script>init_tabs(35);</script>';
        }
    	
       #### FAQ ####
        
        #### Testimonials #####
        
    	include_once(dirname(__FILE__).'/classes/shopreviews.class.php');
		$obj_shopreviews = new shopreviews();
		
	    
       // publish
	   if (Tools::isSubmit("published_t")) {
			if (Validate::isInt(Tools::getValue("id"))){
				$obj_shopreviews->setPublsh(array('id'=>Tools::getValue("id"), 'active'=>1));
			} 
			
			Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'&page_t='.Tools::getValue("page_t"));
				
			$this->_html .= '<script>init_tabs(34);</script>';
		}
		
		//unpublish
		if (Tools::isSubmit("unpublished_t")) {
			if (Validate::isInt(Tools::getValue("id"))){
					$obj_shopreviews->setPublsh(array('id'=>Tools::getValue("id"), 'active'=>0));
			} 
			Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'&page_t='.Tools::getValue("page_t"));
				
			$this->_html .= '<script>init_tabs(34);</script>';
		}
		
    	// delete item
		if (Tools::isSubmit("delete_item_t")) {
			if (Validate::isInt(Tools::getValue("id"))) {
				$obj_shopreviews->deteleItem(array('id'=>Tools::getValue("id")));
			//	Tools::redirectAdmin($currentIndex.'&tab=AdminModules&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'');
			}
			Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'&page_t='.Tools::getValue("page_t"));
				
			$this->_html .= '<script>init_tabs(34);</script>';
			
		}
	    
	    if (Tools::isSubmit('submit_testim'))
        {
        	 Configuration::updateValue($this->name.'testimon', Tools::getValue('testimon'));
        	
        	 Configuration::updateValue($this->name.'tlast', Tools::getValue('tlast'));
        	 //Configuration::updateValue($this->name.'tposition', Tools::getValue('tposition'));
        	 
        	 Configuration::updateValue($this->name.'t_home', Tools::getValue('t_home'));
        	 Configuration::updateValue($this->name.'t_left', Tools::getValue('t_left'));
        	 Configuration::updateValue($this->name.'t_right', Tools::getValue('t_right'));
        	 Configuration::updateValue($this->name.'t_footer', Tools::getValue('t_footer'));
        	 
        	 
        	 
        	 Configuration::updateValue($this->name.'tperpage', Tools::getValue('tperpage'));
        	 Configuration::updateValue($this->name.'tnoti', Tools::getValue('tnoti'));
        	 Configuration::updateValue($this->name.'tmail', Tools::getValue('tmail'));
        	 
        	 Configuration::updateValue($this->name.'tis_captcha', Tools::getValue('tis_captcha'));
        	 Configuration::updateValue($this->name.'tis_web', Tools::getValue('tis_web'));
        	 Configuration::updateValue($this->name.'tis_company', Tools::getValue('tis_company'));
        	 Configuration::updateValue($this->name.'tis_addr', Tools::getValue('tis_addr'));
        	 
        	 Configuration::updateValue($this->name.'tn_rssitemst', Tools::getValue('tn_rssitemst'));
        	 Configuration::updateValue($this->name.'trssontestim', Tools::getValue('trssontestim'));
        	
        	 Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'&page_t='.Tools::getValue("page_t"));
			
        	 $this->_html .= '<script>init_tabs(34);</script>';
        }
        
        
        if (Tools::isSubmit('submit_item_t'))
        {
        	$name = (strlen(Tools::getValue("name"))==0?Tools::getValue("name"):Tools::getValue("name"));
        	$email = (strlen(Tools::getValue("email"))==0?Tools::getValue("email"):Tools::getValue("email"));
        	$web = Tools::getValue("web");
        	$company = Tools::getValue("company");
        	$address = Tools::getValue("address");
        	
        	$message = (strlen(Tools::getValue("message"))==0?Tools::getValue("message"):Tools::getValue("message"));
        	$publish = (int)Tools::getValue("publish");
        	
        	
        	$obj_shopreviews->updateItem(array('name'=>$name,
        									   'email'=>$email,
        									   'web' =>$web,
        									   'message'=>$message,
        									   'publish'=>$publish,
        									   'address'=>$address,
        									   'company'=>$company,
        									   'id' =>Tools::getValue("id")
        									   )
        								);
        	
        	Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'&page_t='.Tools::getValue("page_t"));
				
			$this->_html .= '<script>init_tabs(34);</script>';
			
		}
       
		if (Tools::isSubmit('cancel_item_t'))
        {
        	Tools::redirectAdmin($currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'&page_t='.Tools::getValue("page_t"));
				
			$this->_html .= '<script>init_tabs(34);</script>';
			
		}
		
		if (Tools::isSubmit('edit_item_t') || Tools::isSubmit('page_t'))
        {
        	$this->_html .= '<script>init_tabs(34);</script>';
			
		}
        
        
        #### Testimonials #####
        
    	###### Product reviews + Google Snippets, Breadcrumb, Rich Pin ######
		
    	if (Tools::isSubmit('richpins_settings')) {
        	$this->_html .= '<script>init_tabs(33);</script>';
        }
        
    	if(Tools::isSubmit('submit_richpins_settings')){
    		// rich pins
			Configuration::updateValue($this->name.'pinbutton_on', Tools::getValue('pinbutton_on'));
	        Configuration::updateValue($this->name.'pinvis_on', Tools::getValue('pinvis_on'));
	        Configuration::updateValue($this->name.'pbuttons', Tools::getValue('pbuttons'));
	        	
	        Configuration::updateValue($this->name.'_leftColumn', Tools::getValue('leftColumn'));
	        Configuration::updateValue($this->name.'_extraLeft', Tools::getValue('extraLeft'));
	        Configuration::updateValue($this->name.'_productFooter', Tools::getValue('productFooter'));
	        Configuration::updateValue($this->name.'_rightColumn', Tools::getValue('rightColumn'));
	        Configuration::updateValue($this->name.'_extraRight', Tools::getValue('extraRight'));
	        Configuration::updateValue($this->name.'_productActions', Tools::getValue('productActions'));
			// rich pins
			Tools::redirectAdmin($currentIndex.'&richpins_settings&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)));
	   
    	}
    	
  	   if (Tools::isSubmit('breadcramb_settings')) {
        	$this->_html .= '<script>init_tabs(32);</script>';
        }
    	
    	if(Tools::isSubmit('submit_breadcrumb_settings')){
	    	 // breadcramb
	        Configuration::updateValue($this->name.'breadvis_on', Tools::getValue('breadvis_on'));
	        // breadcramb	
    		Tools::redirectAdmin($currentIndex.'&breadcramb_settings&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)));
	    }
    	
    	
    	if (Tools::isSubmit('gsnippets_settings')) {
        	$this->_html .= '<script>init_tabs(30);</script>';
        }
        
    	if(Tools::isSubmit('submit_gsnippets_settings')){
    		
    		Configuration::updateValue($this->name.'gsnipblock', Tools::getValue('gsnipblock'));
			Configuration::updateValue($this->name.'id_hook_gsnipblock', Tools::getValue('id_hook_gsnipblock'));
			Configuration::updateValue($this->name.'gsnipblock_width', Tools::getValue('gsnipblock_width'));
			Configuration::updateValue($this->name.'gsnipblocklogo', Tools::getValue('gsnipblocklogo'));
			
    		Tools::redirectAdmin($currentIndex.'&gsnippets_settings&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)));
	    }
    	
        include_once(dirname(__FILE__).'/classes/reviewshelp.class.php');
		$obj_reviewshelp = new reviewshelp();
		
     	
      	$edit_submit_items = Tools::getValue("edit_submit_items_rev");
      
        if ($edit_submit_items == 1 || Tools::isSubmit('edit_item_rev') || Tools::isSubmit('page_rev')) {
        	$this->_html .= '<script>init_tabs(29);</script>';
        }
        
	    if(Tools::isSubmit('submit_item_rev')){
	    	
	    	$action = Tools::getValue('submit_item_rev');
	    	$id = (int)Tools::getValue('id');
	    	
	    	switch($action){
	    		case 'Publish':
	    			$obj_reviewshelp->publish(array('id'=>$id));
					
	    		break;
	    		case 'Unpublish':
	    			$obj_reviewshelp->unpublish(array('id'=>$id));
	    		break;
	    		case 'delete':
	    			$obj_reviewshelp->delete(array('id'=>$id));
	    		break;
	    	}
	    	$page = Tools::getValue("page_rev");
	    	Tools::redirectAdmin($currentIndex.'&edit_submit_items_rev=1&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'&page_rev='.$page);
	    }
	    
    	$submit_rev_set = Tools::getValue("submit_rev_set");
      
        if ($submit_rev_set == 1) {
        	$this->_html .= '<script>init_tabs(28);</script>';
        }
	    
	    
	    if (Tools::isSubmit('submit_rev'))
        {
        	
        	 Configuration::updateValue($this->name.'reviewson', Tools::getValue('reviewson'));
        	 
        	 Configuration::updateValue($this->name.'starscat', Tools::getValue('starscat'));
        	 
        	 $languages = Language::getLanguages(false);
        	 foreach ($languages as $language){
    			$i = $language['id_lang'];
        		Configuration::updateValue($this->name.'emailreminder_'.$i, Tools::getValue('emailreminder_'.$i));
        	 }
        	
        	 Configuration::updateValue($this->name.'delay', Tools::getValue('delay'));
        	 Configuration::updateValue($this->name.'reminder', Tools::getValue('reminder'));
        	
        	 
        	 Configuration::updateValue($this->name.'settings', Tools::getValue('settings'));
        	 Configuration::updateValue($this->name.'x_reviews', Tools::getValue('x_reviews'));
        	 Configuration::updateValue($this->name.'is_onereview', Tools::getValue('is_onereview'));
        	 Configuration::updateValue($this->name.'position', Tools::getValue('position'));
        	 Configuration::updateValue($this->name.'is_captcha', Tools::getValue('is_captcha'));
        	 Configuration::updateValue($this->name.'switch_lng', Tools::getValue('switch_lng'));
        	 Configuration::updateValue($this->name.'noti_snip', Tools::getValue('noti_snip'));
        	 Configuration::updateValue($this->name.'mail_snip', Tools::getValue('mail_snip'));
        	 Configuration::updateValue($this->name.'revlast', Tools::getValue('revlast'));
        	 Configuration::updateValue($this->name.'subjecton', Tools::getValue('subjecton'));
        	 Configuration::updateValue($this->name.'recommendedon', Tools::getValue('recommendedon'));
        	 Configuration::updateValue($this->name.'ipon', Tools::getValue('ipon'));
        	 Configuration::updateValue($this->name.'revperpage', Tools::getValue('revperpage'));
			 Configuration::updateValue($this->name.'homeon', Tools::getValue('homeon'));
        	 
        	Configuration::updateValue($this->name.'rsson', Tools::getValue('rsson'));
			Configuration::updateValue($this->name.'n_rss_snip', Tools::getValue('n_rss_snip'));
			
			
        	$languages = Language::getLanguages(false);
        	foreach ($languages as $language){
    			$i = $language['id_lang'];
        		Configuration::updateValue($this->name.'rssname_snip_'.$i, Tools::getValue('rssname_snip_'.$i));
        		Configuration::updateValue($this->name.'rssdesc_snip_'.$i, Tools::getValue('rssdesc_snip_'.$i));
        	}
        	Tools::redirectAdmin($currentIndex.'&submit_rev_set=1&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)));
	   		
        }
       if (Tools::isSubmit('cancel_item_rev'))
        {
        	$page = Tools::getValue("page_rev");
        	Tools::redirectAdmin($currentIndex.'&edit_submit_items_rev=1&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'&page_rev='.$page);
		}
		
		if (Tools::isSubmit('save_item_rev'))
        {
        	$name = Tools::getValue("name");
        	$email = Tools::getValue("email");
        	$subject = Tools::getValue("subject");
        	$text_review = Tools::getValue("text_review");
        	$publish = (int)Tools::getValue("publish");
        	$page = Tools::getValue("page");
        	$id = Tools::getValue("id");
        	$rating = Tools::getValue("rating");
        	$date_add = Tools::getValue("date_add");
        	$date_add_old = Tools::getValue("date_add_old");
        	
        	$obj_reviewshelp->updateReview(array('subject' => $subject,
        										 'text_review' => $text_review,
        										 'publish' => $publish,
        										 'id' => $id,
        										 'name' => $name,
        										 'email' => $email,
        										 'rating' => $rating,
        										 'date_add' => $date_add,
        										 'date_add_old' => $date_add_old
         										 )
        								   );
        	$page = Tools::getValue("page_rev");
        	Tools::redirectAdmin($currentIndex.'&edit_submit_items_rev=1&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'&page_rev='.$page);
        }
        
        
        // import comments
        if (Tools::isSubmit('submitcomments'))
        {
        	include_once(dirname(__FILE__).'/classes/importhelp.class.php');
			$obj = new importhelp();
        	
        	$obj->importComments();
			
        	Tools::redirectAdmin($currentIndex.'&page_rev&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)));
		}
    	// import comments
        ###### Product reviews + Google Snippets, Breadcrumb, Rich Pin ######
		
    	
    	
    	//$currentIndex = '';
    	include_once(dirname(__FILE__).'/classes/blog.class.php');
		$obj_blog = new bloghelp();
    	
    	
        ################# category ##########################
        // list category
       $page_cat = Tools::getValue("pagecategories");
       $list_categories = Tools::getValue("list_categories");
        if (strlen($page_cat)>0 || strlen($list_categories)>0) {
        	$this->_html .= '<script>init_tabs(22);</script>';
        }
        $edit_item_category = Tools::getValue("edit_item_category");
    	if (strlen($edit_item_category)>0) {
        	$this->_html .= '<script>init_tabs(23);</script>';
        }
        // add category
        if (Tools::isSubmit("submit_addcategory")) {
        	$seo_url = Tools::getValue("seo_url");
        	$languages = Language::getLanguages(false);
	    	$data_title_content_lang = array();
	    	
	    	if($this->_is15){
	    		$cat_shop_association = Tools::getValue("cat_shop_association");
	    	} else{
	    		$cat_shop_association = array(0=>1);
	    	}
	    	
	    	
	    	
	    	foreach ($languages as $language){
	    		$id_lang = $language['id_lang'];
	    		$category_title = Tools::getValue("category_title_".$id_lang);
	    		$category_seokeywords = Tools::getValue("category_seokeywords_".$id_lang);
	    		$category_seodescription = Tools::getValue("category_seodescription_".$id_lang);
	    		
	    		if(strlen($category_title)>0 && !empty($cat_shop_association))
	    		{
	    			$data_title_content_lang[$id_lang] = array('category_title' => $category_title,
	    									 				   'category_seokeywords' => $category_seokeywords,
	    			 										   'category_seodescription' => $category_seodescription,
	    													   'seo_url' =>$seo_url
	    														
	    													    );		
	    		}
	    	}
	    	
        	$data = array( 'data_title_content_lang'=>$data_title_content_lang,
        					'cat_shop_association' => $cat_shop_association
         				  );
         	
         		
        	
         	if(sizeof($data_title_content_lang)>0)
        		$obj_blog->saveCategory($data);
         	
         	Tools::redirectAdmin($currentIndex.'&list_categories=1&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'');
			 
         }
        // delete category
        $delete_item_category = Tools::getValue("delete_item_category");
        if (strlen($delete_item_category)>0) {
			if (Validate::isInt(Tools::getValue("id_category"))) {
				$obj_blog->deleteCategory(array('id'=>Tools::getValue("id_category")));
				Tools::redirectAdmin($currentIndex.'&list_categories=1&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'');
			}
		}
		// cancel edit category 
    	if (Tools::isSubmit('cancel_editcategory'))
        {
       	Tools::redirectAdmin($currentIndex.'&list_categories=1&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'');
		}
		//edit category
     	if (Tools::isSubmit("submit_editcategory")) {
     		$seo_url = Tools::getValue("seo_url");
     		$languages = Language::getLanguages(false);
	    	$data_title_content_lang = array();
	    	
     		if($this->_is15){
	    		$cat_shop_association = Tools::getValue("cat_shop_association");
	    	} else{
	    		$cat_shop_association = array(0=>1);
	    	}
	    	
	    	foreach ($languages as $language){
	    		$id_lang = $language['id_lang'];
	    		$category_title = Tools::getValue("category_title_".$id_lang);
	    		$category_seokeywords = Tools::getValue("category_seokeywords_".$id_lang);
	    		$category_seodescription = Tools::getValue("category_seodescription_".$id_lang);
	    		
	    		if(strlen($category_title)>0 && !empty($cat_shop_association))
	    		{
	    			$data_title_content_lang[$id_lang] = array('category_title' => $category_title,
	    									 				   'category_seokeywords' => $category_seokeywords,
	    													   'category_seodescription' => $category_seodescription,
	    													   'seo_url' =>$seo_url
	    													    );		
	    		}
	    	}
        	
     		
         	$id_editcategory = Tools::getValue("id_editcategory");
         	$data = array('data_title_content_lang'=>$data_title_content_lang,
        				  'id_editcategory' => $id_editcategory,
         				  'cat_shop_association' => $cat_shop_association
         				 );
         	
         	if(sizeof($data_title_content_lang)>0)
         		$obj_blog->updateCategory($data);
         	$this->_html .= '<script>init_tabs(22);</script>'; 
         	Tools::redirectAdmin($currentIndex.'&list_categories=1&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'');
			
         }
		 ################# category ##########################
		 
         
         ################# posts ##########################
        // add post
    	if (Tools::isSubmit("submit_addpost")) {
         	$seo_url = Tools::getValue("seo_url");
    		$languages = Language::getLanguages(false);
	    	$data_title_content_lang = array();
	    	
	    	$time_add = Tools::getValue("time_add");
	    	
    		if($this->_is15){
	    		$cat_shop_association = Tools::getValue("cat_shop_association");
	    	} else{
	    		$cat_shop_association = array(0=>1);
	    	}
	    	
	    	foreach ($languages as $language){
	    		$id_lang = $language['id_lang'];
	    		$post_title = Tools::getValue("post_title_".$id_lang);
	    		$post_seokeywords = Tools::getValue("post_seokeywords_".$id_lang);
	    		$post_seodescription = Tools::getValue("post_seodescription_".$id_lang);
	    		$post_content = Tools::getValue("content_".$id_lang);
	    		
	    		if(strlen($post_title)>0 && !empty($cat_shop_association))
	    		{
	    			$data_title_content_lang[$id_lang] = array('post_title' => $post_title,
	    									 				   'post_seokeywords' => $post_seokeywords,
	    			 										   'post_seodescription' => $post_seodescription,
	    													   'post_content' => $post_content,
	    														'seo_url' => $seo_url
	    													    );		
	    		}
	    	}
	    	
        	
         	$ids_categories = Tools::getValue("ids_categories");
        	$post_status = Tools::getValue("post_status");
        	$post_iscomments = Tools::getValue("post_iscomments");
        	
         	$data = array('data_title_content_lang'=>$data_title_content_lang,
         				  'ids_categories' => $ids_categories,
         				  'post_status' => $post_status,
         				  'post_iscomments' => $post_iscomments,
         				  'cat_shop_association' => $cat_shop_association,
         				  'time_add' => $time_add
         				 );
         				 
			
         				 
         	if(sizeof($data_title_content_lang)>0 && sizeof($ids_categories)>0)
         		$obj_blog->savePost($data);
         	Tools::redirectAdmin($currentIndex.'&list_posts=1&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'');
			
         }
        //list posts
        $page_cat = Tools::getValue("pageposts");
        $list_posts = Tools::getValue("list_posts");
        if (strlen($page_cat)>0 || strlen($list_posts)>0) {
        	$this->_html .= '<script>init_tabs(24);</script>';
        }
    	$edit_item_posts = Tools::getValue("edit_item_posts");
    	if (strlen($edit_item_posts)>0) {
        	$this->_html .= '<script>init_tabs(25);</script>';
        }
    	// delete posts
        $delete_item_posts = Tools::getValue("delete_item_posts");
        if (strlen($delete_item_posts)>0) {
			if (Validate::isInt(Tools::getValue("id_posts"))) {
				$obj_blog->deletePost(array('id'=>Tools::getValue("id_posts")));
				Tools::redirectAdmin($currentIndex.'&list_posts=1&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'');
			}
		}
    	// cancel edit posts 
    	if (Tools::isSubmit('cancel_editposts'))
        {
       	Tools::redirectAdmin($currentIndex.'&list_posts=1&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'');
		}
   		 //edit posts
     	if (Tools::isSubmit("submit_editposts")) {
     		$seo_url = Tools::getValue("seo_url");
     		$languages = Language::getLanguages(false);
	    	$data_title_content_lang = array();
	    	
	    	$time_add = Tools::getValue("time_add");
	    	
	    	if($this->_is15){
	    		$cat_shop_association = Tools::getValue("cat_shop_association");
	    	} else{
	    		$cat_shop_association = array(0=>1);
	    	}
	    	
	    	
	    	foreach ($languages as $language){
	    		$id_lang = $language['id_lang'];
	    		$post_title = Tools::getValue("post_title_".$id_lang);
	    		$post_seokeywords = Tools::getValue("post_seokeywords_".$id_lang);
	    		$post_seodescription = Tools::getValue("post_seodescription_".$id_lang);
	    		$post_content = Tools::getValue("content_".$id_lang);
	    		
	    		if(strlen($post_title)>0 && !empty($cat_shop_association))
	    		{
	    			$data_title_content_lang[$id_lang] = array('post_title' => $post_title,
	    									 				   'post_seokeywords' => $post_seokeywords,
	    			 										   'post_seodescription' => $post_seodescription,
	    													   'post_content' => $post_content,
	    														'seo_url'=>$seo_url
	    													    );		
	    		}
	    	}
     		
     		$id_editposts = Tools::getValue("id_editposts");
     		
         	$ids_categories = Tools::getValue("ids_categories");
        	$post_status = Tools::getValue("post_status");
        	$post_iscomments = Tools::getValue("post_iscomments");
        	$post_images = Tools::getValue("post_images");
        	
         	$data = array('data_title_content_lang'=>$data_title_content_lang,
         				  'ids_categories' => $ids_categories,
         				  'post_status' => $post_status,
         				  'post_iscomments' => $post_iscomments,
         				  'id_editposts' => $id_editposts,
         				  'post_images' => $post_images,
         				  'cat_shop_association' => $cat_shop_association,
         				  'time_add' => $time_add
         				 );
         	if(sizeof($data_title_content_lang)>0 && sizeof($ids_categories)>0)
         		$obj_blog->updatePost($data);
         	$this->_html .= '<script>init_tabs(24);</script>';
         	Tools::redirectAdmin($currentIndex.'&list_posts=1&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'');
		 }
         ################# posts ##########################
         
		 
		 ################# comments ##########################
        // delete comments
        $delete_item_comments = Tools::getValue("delete_item_comments");
        
        if (strlen($delete_item_comments)>0) {
        	if (Validate::isInt(Tools::getValue("id_comments"))) {
				$obj_blog->deleteComment(array('id'=>Tools::getValue("id_comments")));
				Tools::redirectAdmin($currentIndex.'&list_comments=1&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'');
			}
		}
    	 //list comments
        $page_comments = Tools::getValue("pagecomments");
        $list_comments = Tools::getValue("list_comments");
        if (strlen($page_comments)>0 || strlen($list_comments)>0) {
        	$this->_html .= '<script>init_tabs(26);</script>';
        }
   	    $edit_item_comments = Tools::getValue("edit_item_comments");
    	if (strlen($edit_item_comments)>0) {
        	$this->_html .= '<script>init_tabs(27);</script>';
        }
    	// cancel edit comments 
    	if (Tools::isSubmit('cancel_editcomments'))
        {
       	Tools::redirectAdmin($currentIndex.'&list_comments=1&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'');
		}
     	//edit comments
     	if (Tools::isSubmit("submit_editcomments")) {
     		
     		$id_editcomments = Tools::getValue("id_editcomments");
     		
         	$comments_name = Tools::getValue("comments_name");
        	$comments_email = Tools::getValue("comments_email");
        	$comments_comment = Tools::getValue("comments_comment");
        	$comments_status = Tools::getValue("comments_status");
        	
         	$data = array('comments_name' => $comments_name,
         				  'comments_email' => $comments_email,
         				  'comments_comment' => $comments_comment,
         				  'comments_status' => $comments_status,
         	 			  'id_editcomments' => $id_editcomments
         				 );
         	if(strlen($comments_name)>0 && strlen($comments_comment)>0)
         		$obj_blog->updateComment($data);
         	$this->_html .= '<script>init_tabs(26);</script>';
         	Tools::redirectAdmin($currentIndex.'&list_comments=1&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'');
		 }
        ################# comments ##########################
         
    	if (Tools::isSubmit('submit_blogsettings'))
        {
        	Configuration::updateValue($this->name.'blogon', Tools::getValue('blogon'));
        	
        	
        	// footer 
        	Configuration::updateValue($this->name.'cat_footer', Tools::getValue('cat_footer'));
			Configuration::updateValue($this->name.'posts_footer', Tools::getValue('posts_footer'));
			Configuration::updateValue($this->name.'arch_footer', Tools::getValue('arch_footer'));
			Configuration::updateValue($this->name.'search_footer', Tools::getValue('search_footer'));
        	// footer 
        	
        	// right 
        	Configuration::updateValue($this->name.'cat_right', Tools::getValue('cat_right'));
			Configuration::updateValue($this->name.'posts_right', Tools::getValue('posts_right'));
			Configuration::updateValue($this->name.'arch_right', Tools::getValue('arch_right'));
			Configuration::updateValue($this->name.'search_right', Tools::getValue('search_right'));
        	// right 
        	
			
			// left 
        	Configuration::updateValue($this->name.'cat_left', Tools::getValue('cat_left'));
			Configuration::updateValue($this->name.'posts_left', Tools::getValue('posts_left'));
			Configuration::updateValue($this->name.'arch_left', Tools::getValue('arch_left'));
			Configuration::updateValue($this->name.'search_left', Tools::getValue('search_left'));
        	// left 
        	
        	
        	 
        	 Configuration::updateValue($this->name.'c_list_display_date', Tools::getValue('c_list_display_date'));
        	 Configuration::updateValue($this->name.'p_list_displ_date', Tools::getValue('p_list_displ_date'));
        	 Configuration::updateValue($this->name.'perpage_posts', Tools::getValue('perpage_posts'));
        	 Configuration::updateValue($this->name.'lists_img_width', Tools::getValue('lists_img_width'));
        	 Configuration::updateValue($this->name.'block_display_date', Tools::getValue('block_display_date')); 
        	 Configuration::updateValue($this->name.'block_display_img', Tools::getValue('block_display_img')); 
        	 
        	 Configuration::updateValue($this->name.'p_block_img_width', Tools::getValue('p_block_img_width')); 
        	 
        	 
        	 
        	 Configuration::updateValue($this->name.'noti', Tools::getValue('noti'));
        	 Configuration::updateValue($this->name.'mail', Tools::getValue('mail'));
        	 Configuration::updateValue($this->name.'perpage_catblog', Tools::getValue('perpage_catblog'));
        	 
        	 
        	 Configuration::updateValue($this->name.'block_last_home', Tools::getValue('block_last_home'));
        	 Configuration::updateValue($this->name.'tab_blog_pr', Tools::getValue('tab_blog_pr'));
        	 
        	 
        	 Configuration::updateValue($this->name.'post_display_date', Tools::getValue('post_display_date'));
        	 Configuration::updateValue($this->name.'post_img_width', Tools::getValue('post_img_width'));
        	 Configuration::updateValue($this->name.'is_soc_buttons', Tools::getValue('is_soc_buttons'));
        	 
        	 
        	 Configuration::updateValue($this->name.'blog_bcat', Tools::getValue('blog_bcat'));
        	 Configuration::updateValue($this->name.'blog_bposts', Tools::getValue('blog_bposts'));
        	 
        	Configuration::updateValue($this->name.'rsson', Tools::getValue('rsson'));
			Configuration::updateValue($this->name.'number_rssitems', Tools::getValue('number_rssitems'));
			
			
        	$languages = Language::getLanguages(false);
        	foreach ($languages as $language){
    			$i = $language['id_lang'];
        		Configuration::updateValue($this->name.'rssname_'.$i, Tools::getValue('rssname_'.$i));
        		Configuration::updateValue($this->name.'rssdesc_'.$i, Tools::getValue('rssdesc_'.$i));
        	}
        	 
        	 $this->_html .= '<script>init_tabs(21);</script>';
        }
        
        if(Tools::isSubmit('submitsitemap')){
        	$obj_blog->generateSitemap();
        	$this->_html .= '<script>init_tabs(21);</script>';
        }
        	
        if (Tools::isSubmit('loginblock'))
        {
        	
        	foreach($this->_prefix_position_connects as $prefix){
				Configuration::updateValue($this->name.'_top'.$prefix, Tools::getValue('top'.$prefix));
	        	Configuration::updateValue($this->name.'_rightcolumn'.$prefix, Tools::getValue('rightcolumn'.$prefix));
	        	Configuration::updateValue($this->name.'_leftcolumn'.$prefix, Tools::getValue('leftcolumn'.$prefix));
	        	Configuration::updateValue($this->name.'_footer'.$prefix, Tools::getValue('footer'.$prefix));
	        	Configuration::updateValue($this->name.'_authpage'.$prefix, Tools::getValue('authpage'.$prefix));
	        	Configuration::updateValue($this->name.'_welcome'.$prefix, Tools::getValue('welcome'.$prefix));
	        }
	        
	        
        	
          $this->_html .= '<script>init_tabs(1);</script>';
        }
        
        if (Tools::isSubmit('uploadimages'))
        {
        	include_once(dirname(__FILE__).'/classes/facebookhelp.class.php');
			$obj = new facebookhelp();
			
			
	        // 	save facebook connect image	
			if(!empty($_FILES['post_image_facebook']['name'])){
				$obj->saveImage(array('type'=>'facebook'));	
			}
			
	        // save facebook connect small image	
			if(!empty($_FILES['post_image_facebooksmall']['name'])){
				$obj->saveImage(array('type'=>'facebooksmall'));	
			}
			
			#######################
			
        	// save twitter connect image	
			if(!empty($_FILES['post_image_twitter']['name'])){
				$obj->saveImage(array('type'=>'twitter'));	
			}
			
	        // save twitter connect small image	
			if(!empty($_FILES['post_image_twittersmall']['name'])){
				$obj->saveImage(array('type'=>'twittersmall'));	
			}
			
        	#######################
        	
      		  // save google connect image	
			if(!empty($_FILES['post_image_google']['name'])){
				$obj->saveImage(array('type'=>'google'));	
			}
			
	        // save google connect image	
			if(!empty($_FILES['post_image_googlesmall']['name'])){
				$obj->saveImage(array('type'=>'googlesmall'));	
			}
        	
			#######################
			
       		 // save yahoo connect image	
			if(!empty($_FILES['post_image_yahoo']['name'])){
				$obj->saveImage(array('type'=>'yahoo'));	
			}
			
	        // save yahoo connect small image	
			if(!empty($_FILES['post_image_yahoosmall']['name'])){
				$obj->saveImage(array('type'=>'yahoosmall'));	
			}
			
			#######################
			
        	// save paypal connect image	
			if(!empty($_FILES['post_image_paypal']['name'])){
				$obj->saveImage(array('type'=>'paypal'));	
			}
			// save paypal connect small image	
			if(!empty($_FILES['post_image_paypalsmall']['name'])){
				$obj->saveImage(array('type'=>'paypalsmall'));	
			}
			
			#######################
			
       		 // save linkedin connect image	
			if(!empty($_FILES['post_image_linkedin']['name'])){
				$obj->saveImage(array('type'=>'linkedin'));	
			}
			
	        // save linkedin connect small image	
			if(!empty($_FILES['post_image_linkedinsmall']['name'])){
				$obj->saveImage(array('type'=>'linkedinsmall'));	
			}
			
			#######################
			
			 // save livejournal connect image	
			if(!empty($_FILES['post_image_livejournal']['name'])){
				$obj->saveImage(array('type'=>'livejournal'));	
			}
			
	        // save livejournal connect small image	
			if(!empty($_FILES['post_image_livejournalsmall']['name'])){
				$obj->saveImage(array('type'=>'livejournalsmall'));	
			}
			
			#######################
			
			 // save myid connect image	
			if(!empty($_FILES['post_image_microsoft']['name'])){
				$obj->saveImage(array('type'=>'microsoft'));	
			}
			
	        // save myid connect small image	
			if(!empty($_FILES['post_image_microsoftsmall']['name'])){
				$obj->saveImage(array('type'=>'microsoftsmall'));	
			}
			
			#######################
			/*
			 // save openid connect image	
			if(!empty($_FILES['post_image_openid']['name'])){
				$obj->saveImage(array('type'=>'openid'));	
			}
			
	        // save openid connect small image	
			if(!empty($_FILES['post_image_openidsmall']['name'])){
				$obj->saveImage(array('type'=>'openidsmall'));	
			}
			*/
			#######################
			
			 // save clavid connect image	
			if(!empty($_FILES['post_image_clavid']['name'])){
				$obj->saveImage(array('type'=>'clavid'));	
			}
			
	        // save clavid connect small image	
			if(!empty($_FILES['post_image_clavidsmall']['name'])){
				$obj->saveImage(array('type'=>'clavidsmall'));	
			}
			
			#######################
			
			 // save flickr connect image	
			if(!empty($_FILES['post_image_flickr']['name'])){
				$obj->saveImage(array('type'=>'flickr'));	
			}
			
	        // save flickr connect small image	
			if(!empty($_FILES['post_image_flickrsmall']['name'])){
				$obj->saveImage(array('type'=>'flickrsmall'));	
			}
			
			#######################
			
			 // save wordpress connect image	
			if(!empty($_FILES['post_image_wordpress']['name'])){
				$obj->saveImage(array('type'=>'wordpress'));	
			}
			
	        // save wordpress connect small image	
			if(!empty($_FILES['post_image_wordpresssmall']['name'])){
				$obj->saveImage(array('type'=>'wordpresssmall'));	
			}
			
			#######################
			
			 // save aol connect image	
			if(!empty($_FILES['post_image_aol']['name'])){
				$obj->saveImage(array('type'=>'aol'));	
			}
			
	        // save aol connect small image	
			if(!empty($_FILES['post_image_aolsmall']['name'])){
				$obj->saveImage(array('type'=>'aolsmall'));	
			}
			
			#######################
			
        	$this->_html .= '<script>init_tabs(2);</script>';
        }
        
        if (Tools::isSubmit('facebooksettings'))
        {
         Configuration::updateValue($this->name.'appid', Tools::getValue('appid'));
	     Configuration::updateValue($this->name.'secret', Tools::getValue('secret'));
         $this->_html .= '<script>init_tabs(3);</script>';
        }
        
        if (Tools::isSubmit('twittersettings'))
        {
        Configuration::updateValue($this->name.'twitterconskey', Tools::getValue('twitterconskey'));
	    Configuration::updateValue($this->name.'twitterconssecret', Tools::getValue('twitterconssecret'));
	    $this->_html .= '<script>init_tabs(4);</script>';
        }
        
    	if (Tools::isSubmit('paypalsettings'))
        {
        Configuration::updateValue($this->name.'clientid', Tools::getValue('clientid'));
        Configuration::updateValue($this->name.'psecret', Tools::getValue('psecret'));
        Configuration::updateValue($this->name.'pcallback', Tools::getValue('pcallback'));
         $this->_html .= '<script>init_tabs(5);</script>';
        }
        
     	if (Tools::isSubmit('linkedinsettings'))
        {
      	Configuration::updateValue($this->name.'lapikey', Tools::getValue('lapikey'));
        Configuration::updateValue($this->name.'lsecret', Tools::getValue('lsecret'));
		$this->_html .= '<script>init_tabs(6);</script>';
        }
       
    	if (Tools::isSubmit('microsoftsettings'))
        {
         Configuration::updateValue($this->name.'mclientid', Tools::getValue('mclientid'));
         Configuration::updateValue($this->name.'mclientsecret', Tools::getValue('mclientsecret'));
		 $this->_html .= '<script>init_tabs(70);</script>';
        }
        
   	   if (Tools::isSubmit('googlesettings'))
        {
        // changes OAuth 2.0
	 	
		 	Configuration::updateValue($this->name.'oci', Tools::getValue('oci'));
        	Configuration::updateValue($this->name.'ocs', Tools::getValue('ocs'));
        	Configuration::updateValue($this->name.'oru', Tools::getValue('oru'));
        	
        	// changes OAuth 2.0
		 $this->_html .= '<script>init_tabs(80);</script>';
        }
        
        
    if (Tools::isSubmit('twitterbutton'))
        {
         Configuration::updateValue($this->name.'buttons', Tools::getValue('buttons'));
		 Configuration::updateValue($this->name.'twitterbon', Tools::getValue('twitterbon'));
		 $this->_html .= '<script>init_tabs(7);</script>';
        }
        
     	if (Tools::isSubmit('twitterwidget'))
        {
        // twitter widget
		Configuration::updateValue($this->name.'twitteron', Tools::getValue('twitteron'));
        Configuration::updateValue($this->name.'user_name', Tools::getValue('user_name'));
        Configuration::updateValue($this->name.'position', Tools::getValue('position'));
        Configuration::updateValue($this->name.'width', Tools::getValue('width'));
        Configuration::updateValue($this->name.'height', Tools::getValue('height'));
        Configuration::updateValue($this->name.'tweets_link', Tools::getValue('tweets_link'));
        Configuration::updateValue($this->name.'tw_color_scheme', Tools::getValue('tw_color_scheme'));
        Configuration::updateValue($this->name.'tw_widgetid', Tools::getValue('tw_widgetid'));
        Configuration::updateValue($this->name.'tw_aria_pol', Tools::getValue('tw_aria_pol'));
        // twitter widget
        $this->_html .= '<script>init_tabs(8);</script>';
        }
        
        if (Tools::isSubmit('facebooklike'))
        {
	        // facebook like button
	        Configuration::updateValue($this->name.'widthlikebox', Tools::getValue('widthlikebox'));
	        Configuration::updateValue($this->name.'likeon', Tools::getValue('likeon'));
	        Configuration::updateValue($this->name.'likefaces', Tools::getValue('likefaces'));
		    Configuration::updateValue($this->name.'likecolor', Tools::getValue('likecolor'));
		    Configuration::updateValue($this->name.'likelayout', Tools::getValue('likelayout'));
		    // facebook like button
		    $this->_html .= '<script>init_tabs(9);</script>';
        }
        
        if (Tools::isSubmit('facebookwidget'))
        {
        	// facebook widget
        	Configuration::updateValue($this->name.'fbon', Tools::getValue('fbon'));
		    Configuration::updateValue($this->name.'lb_facebook_page_url', Tools::getValue('lb_facebook_page_url'));
			Configuration::updateValue($this->name.'positionfb', Tools::getValue('positionfb'));
			Configuration::updateValue($this->name.'lb_width', Tools::getValue('lb_width'));
			Configuration::updateValue($this->name.'lb_height', Tools::getValue('lb_height'));
			Configuration::updateValue($this->name.'lb_connections', Tools::getValue('lb_connections'));
			Configuration::updateValue($this->name.'lb_faces', Tools::getValue('lb_faces'));
			Configuration::updateValue($this->name.'lb_header', Tools::getValue('lb_header'));
			Configuration::updateValue($this->name.'lb_bg_color', Tools::getValue('lb_bg_color'));
			// facebook widget
        	 $this->_html .= '<script>init_tabs(10);</script>';
        }
        
        if (Tools::isSubmit('facebookcomments'))
        {
        	//facebook comments
        	 Configuration::updateValue($this->name.'COMMENTON', Tools::getValue('COMMENTON'));
		 	 Configuration::updateValue($this->name.'COMMENTNBR', Tools::getValue($this->name.'COMMENTNBR'));
			 Configuration::updateValue($this->name.'BGCUSTOM', Tools::getValue($this->name.'BGCUSTOM'));
			 Configuration::updateValue($this->name.'BGCOLOR', Tools::getValue($this->name.'BGCOLOR'));
			 Configuration::updateValue($this->name.'COMMENTWIDTH', Tools::getValue($this->name.'COMMENTWIDTH'));
			 Configuration::updateValue($this->name.'ROUNDED', Tools::getValue($this->name.'ROUNDED'));
			 Configuration::updateValue($this->name.'REGISTERSWITCH', Tools::getValue($this->name.'REGISTERSWITCH'));
			 Configuration::updateValue($this->name.'LOGOSWITCH', Tools::getValue($this->name.'LOGOSWITCH'));
			 Configuration::updateValue($this->name.'TITLESWITCH', Tools::getValue($this->name.'TITLESWITCH'));
			 Configuration::updateValue($this->name.'FOCUS', Tools::getValue($this->name.'FOCUS'));
			 Configuration::updateValue($this->name.'FORCE', Tools::getValue($this->name.'FORCE'));
			 Configuration::updateValue($this->name.'APPADMIN', Tools::getValue($this->name.'APPADMIN'));
			//facebook comments
        	$this->_html .= '<script>init_tabs(11);</script>';
        }
        
        
        if (Tools::isSubmit('facebookshare'))
        {
        	//facebook share button
            Configuration::updateValue($this->name.'shareon', Tools::getValue('shareon'));
	    	//facebook share button
        	$this->_html .= '<script>init_tabs(12);</script>';
        }
        
    	if (Tools::isSubmit('pinterestwidget'))
        {
        	//pinterest widget
            Configuration::updateValue($this->name.'_title', Tools::getValue('ptitle'));
			Configuration::updateValue($this->name.'_pusername', Tools::getValue('pusername'));
			Configuration::updateValue($this->name.'_width', Tools::getValue('pwidth'));
			Configuration::updateValue($this->name.'_height', Tools::getValue('pheight'));
			Configuration::updateValue($this->name.'_number', Tools::getValue('pnumber'));
			Configuration::updateValue($this->name.'_descr', Tools::getValue('pdescr'));
			Configuration::updateValue($this->name.'_descrl', Tools::getValue('pdescrl'));
			Configuration::updateValue($this->name.'_pwidth', Tools::getValue('pwidthblock'));
			Configuration::updateValue($this->name.'_follow', Tools::getValue('pfollow'));
			Configuration::updateValue($this->name.'_pos', Tools::getValue('ppos'));
			Configuration::updateValue($this->name.'_isonpinwidget', Tools::getValue('isonpinwidget'));
			//pinterest widget
        	$this->_html .= '<script>init_tabs(13);</script>';
        }
        
        if (Tools::isSubmit('pinterestbutton'))
        {
        	// pinterest button
        	Configuration::updateValue($this->name.'pinterestbon', Tools::getValue('pinterestbon'));
			Configuration::updateValue($this->name.'pinterestbuttons', Tools::getValue('pinterestbuttons'));	
      		 // pinterest button
        	$this->_html .= '<script>init_tabs(14);</script>';
        }
        
         if (Tools::isSubmit('linkedinbutton'))
        {
        	//linkedin button
       	 	Configuration::updateValue($this->name.'linkedinbon', Tools::getValue('linkedinbon'));
			Configuration::updateValue($this->name.'linkedinbuttons', Tools::getValue('linkedinbuttons'));
		
        	//linkedin button
        	$this->_html .= '<script>init_tabs(15);</script>';
        }
        
        if (Tools::isSubmit('googlewidget'))
        {
         // google widget
           Configuration::updateValue($this->name.'gwon', Tools::getValue('gwon'));
			Configuration::updateValue($this->name.'positiong', Tools::getValue('positiong'));
			
		 	include_once(dirname(__FILE__).'/classes/googlewidgethelp.class.php');
			$obj_googlewidgethelp = new googlewidgethelp();
			$data = Tools::getValue('gwidgetcode');
			$obj_googlewidgethelp->updateItem(array('content'=>$data));
         // google widget
         $this->_html .= '<script>init_tabs(16);</script>';
        }
        
        if (Tools::isSubmit('googlebutton'))
        {
        	// google +1 button
        	Configuration::updateValue($this->name.'status1', Tools::getValue('status1'));
			Configuration::updateValue($this->name.'buttons1', Tools::getValue('buttons1'));
        	// google +1 button
        	$this->_html .= '<script>init_tabs(17);</script>';
        }
        
        
        
        
        
    
        if(Tools::isSubmit('facebookref')){
        	Configuration::updateValue($this->name.'fbrefon', Tools::getValue('fbrefon'));
        	Configuration::updateValue($this->name.'fbrefshareon', Tools::getValue('fbrefshareon'));
        	Configuration::updateValue($this->name.'frefnum', Tools::getValue('frefnum'));
        	
            $type_ref = "f";
    	
          	$languages = Language::getLanguages(false);
        	foreach ($languages as $language){
    			$i = $language['id_lang'];
        		Configuration::updateValue($this->name.$type_ref.'defaulttext_'.$i, Tools::getValue($type_ref.'defaulttext_'.$i));
        	}
	        Configuration::updateValue($this->name.'_psextraLeft'.$type_ref, Tools::getValue('psextraLeft'.$type_ref));
		    Configuration::updateValue($this->name.'_psextraRight'.$type_ref, Tools::getValue('psextraRight'.$type_ref));
		    Configuration::updateValue($this->name.'_psprFooter'.$type_ref, Tools::getValue('psprFooter'.$type_ref));
	        Configuration::updateValue($this->name.'_psprActions'.$type_ref, Tools::getValue('psprActions'.$type_ref));
	        Configuration::updateValue($this->name.'_pscheckoutPage'.$type_ref, Tools::getValue('pscheckoutPage'.$type_ref));
	         
        	$this->_html .= '<script>init_tabs(18);</script>';	
        }
        
        
    	if(Tools::isSubmit('twitterref')){
        	Configuration::updateValue($this->name.'twrefon', Tools::getValue('twrefon'));
        	Configuration::updateValue($this->name.'twrefshareon', Tools::getValue('twrefshareon'));
        	Configuration::updateValue($this->name.'trefnum', Tools::getValue('trefnum'));
        	
        	$type_ref = "t";
    		$languages = Language::getLanguages(false);
        	foreach ($languages as $language){
    			$i = $language['id_lang'];
    			Configuration::updateValue($this->name.$type_ref.'defaulttext_'.$i, Tools::getValue($type_ref.'defaulttext_'.$i));
        	}
	        Configuration::updateValue($this->name.'_psextraLeft'.$type_ref, Tools::getValue('psextraLeft'.$type_ref));
		    Configuration::updateValue($this->name.'_psextraRight'.$type_ref, Tools::getValue('psextraRight'.$type_ref));
		    Configuration::updateValue($this->name.'_psprFooter'.$type_ref, Tools::getValue('psprFooter'.$type_ref));
	        Configuration::updateValue($this->name.'_psprActions'.$type_ref, Tools::getValue('psprActions'.$type_ref));
	        Configuration::updateValue($this->name.'_pscheckoutPage'.$type_ref, Tools::getValue('pscheckoutPage'.$type_ref));
	    
        	$this->_html .= '<script>init_tabs(19);</script>';	
        }
        
   	   if(Tools::isSubmit('googleref')){
        	Configuration::updateValue($this->name.'grefon', Tools::getValue('grefon'));
        	Configuration::updateValue($this->name.'grefshareon', Tools::getValue('grefshareon'));
        	Configuration::updateValue($this->name.'grefnum', Tools::getValue('grefnum'));
        	Configuration::updateValue($this->name.'gsize', Tools::getValue('gsize'));
        
        	
        	$type_ref = "g";
   	   		$languages = Language::getLanguages(false);
        	foreach ($languages as $language){
    			$i = $language['id_lang'];
        		Configuration::updateValue($this->name.$type_ref.'defaulttext_'.$i, Tools::getValue($type_ref.'defaulttext_'.$i));
        	}
	        Configuration::updateValue($this->name.'_psextraLeft'.$type_ref, Tools::getValue('psextraLeft'.$type_ref));
		    Configuration::updateValue($this->name.'_psextraRight'.$type_ref, Tools::getValue('psextraRight'.$type_ref));
		    Configuration::updateValue($this->name.'_psprFooter'.$type_ref, Tools::getValue('psprFooter'.$type_ref));
	        Configuration::updateValue($this->name.'_psprActions'.$type_ref, Tools::getValue('psprActions'.$type_ref));
	        Configuration::updateValue($this->name.'_pscheckoutPage'.$type_ref, Tools::getValue('pscheckoutPage'.$type_ref));
	    
        	$this->_html .= '<script>init_tabs(20);</script>';	
        }
        
    	if(Tools::isSubmit('linkedinref')){
        	Configuration::updateValue($this->name.'lrefon', Tools::getValue('lrefon'));
        	Configuration::updateValue($this->name.'lrefshareon', Tools::getValue('lrefshareon'));
        	Configuration::updateValue($this->name.'lrefnum', Tools::getValue('lrefnum'));
        	Configuration::updateValue($this->name.'lsize', Tools::getValue('lsize'));
        
        	$type_ref = "l";
    		$languages = Language::getLanguages(false);
        	foreach ($languages as $language){
    			$i = $language['id_lang'];
        		Configuration::updateValue($this->name.$type_ref.'defaulttext_'.$i, Tools::getValue($type_ref.'defaulttext_'.$i));
        	}
	        Configuration::updateValue($this->name.'_psextraLeft'.$type_ref, Tools::getValue('psextraLeft'.$type_ref));
		    Configuration::updateValue($this->name.'_psextraRight'.$type_ref, Tools::getValue('psextraRight'.$type_ref));
		    Configuration::updateValue($this->name.'_psprFooter'.$type_ref, Tools::getValue('psprFooter'.$type_ref));
	        Configuration::updateValue($this->name.'_psprActions'.$type_ref, Tools::getValue('psprActions'.$type_ref));
	        Configuration::updateValue($this->name.'_pscheckoutPage'.$type_ref, Tools::getValue('pscheckoutPage'.$type_ref));
	    
	        $this->_html .= '<script>init_tabs(61);</script>';	
        }
        
   	 	if (Tools::isSubmit('refsettings'))
        {
        	
        	$languages = Language::getLanguages(false);
        	foreach ($languages as $language){
    			$i = $language['id_lang'];
        		Configuration::updateValue($this->name.'storename_'.$i, Tools::getValue('storename_'.$i));
        		Configuration::updateValue($this->name.'storedesc_'.$i, Tools::getValue('storedesc_'.$i));
        		Configuration::updateValue($this->name.'coupondesc_'.$i, Tools::getValue('coupondesc_'.$i));
        	}
        	
        	        	
         	
        	Configuration::updateValue($this->name.'tvalid', Tools::getValue('tvalid'));
        	
			Configuration::updateValue($this->name.'discount_type', Tools::getValue('discount_type'));
			Configuration::updateValue($this->name.'percentage_val', Tools::getValue('percentage_val'));
			
        	
        	foreach (Tools::getValue('fbrefamount') AS $id => $value){
				Configuration::updateValue('fbrefamount_'.(int)($id), (float)($value));
        	}
        	
        	
        	if(Tools::getValue($this->name.'isminamount') == true){
	        	foreach (Tools::getValue('fbrefminamount') AS $id => $value){
					Configuration::updateValue('fbrefminamount_'.(int)($id), (float)($value));
	        	}
        	}
        	
            Configuration::updateValue($this->name.'isminamount', Tools::getValue($this->name.'isminamount'));
        	
            // category
            
            $categoryBox = Tools::getValue('categoryBox');
            $categoryBox = implode(",",$categoryBox);
            Configuration::updateValue($this->name.'catbox', $categoryBox);
            
            Configuration::updateValue($this->name.'cumulativeother', Tools::getValue('cumulativeother'));
            Configuration::updateValue($this->name.'cumulativereduc', Tools::getValue('cumulativereduc'));
            
           $this->_html .= '<script>init_tabs(62);</script>';
        }
        
    	if (Tools::isSubmit('refmanager') || Tools::isSubmit('start_modref') 
    		|| Tools::isSubmit('start_mod'))
        {
        	$this->_html .= '<script>init_tabs(63);</script>';
        }
        
        
    	if(Tools::isSubmit('submit_urlrewritesettings')){
        	Configuration::updateValue($this->name.'urlrewrite_on', Tools::getValue('urlrewrite_on'));
        	$this->_html .= '<script>init_tabs(78);</script>';
        }
        
        
        $this->_html .= $this->_displayForm();
        return $this->_html;
    }



	private function _displayForm()
     {
     	$_html = '';
     	
     	$_html .= '
		<fieldset>
					<legend><img src="../modules/'.$this->name.'/logo.gif"  />
					'.$this->displayName.':</legend>
					
					
		<fieldset class="'.$this->name.'-menu">
			<legend>'.$this->l('Menu').':</legend>
		<ul class="leftMenu">
			
			<li><a href="javascript:void(0)" onclick="tabs_custom(77)" id="tab-menu-77" class="selected"><img src="../modules/'.$this->name.'/logo.gif" />'.$this->l('Welcome').'</a></li>';
$_html .= '<li><a href="javascript:void(0)" onclick="tabs_custom(78)" id="tab-menu-78" ><img src="../modules/'.$this->name.'/logo.gif" />'.$this->l('SEO URL Rewrite').'</a></li>';
		
			$_html .= '<li><a href="javascript:void(0)" onclick="tabs_custom(1)" id="tab-menu-1" ><img src="../modules/'.$this->name.'/img/logo.gif" />'.$this->l('Position Connects').'</a></li>
			<li><a href="javascript:void(0)" onclick="tabs_custom(2)" id="tab-menu-2"><img src="../modules/'.$this->name.'/img/logo.gif"  />'.$this->l('Images Connect Buttons').'</a></li>
			<li><a href="javascript:void(0)" onclick="tabs_custom(3)" id="tab-menu-3"><img src="../modules/'.$this->name.'/img/settings_f.png"  />'.$this->l('Facebook API Settings').'</a></li>
			<li><a href="javascript:void(0)" onclick="tabs_custom(4)" id="tab-menu-4"><img src="../modules/'.$this->name.'/img/settings_t.png"  />'.$this->l('Twitter API Settings').'</a></li>
			<li><a href="javascript:void(0)" onclick="tabs_custom(5)" id="tab-menu-5"><img src="../modules/'.$this->name.'/img/settings_p.png"  />'.$this->l('Paypal API Settings').'</a></li>
			<li><a href="javascript:void(0)" onclick="tabs_custom(6)" id="tab-menu-6"><img src="../modules/'.$this->name.'/img/settings_l.png"  />'.$this->l('LinkedIn API Settings').'</a></li>
			<li><a href="javascript:void(0)" onclick="tabs_custom(70)" id="tab-menu-70"><img src="../modules/'.$this->name.'/img/settings_m.png"  />'.$this->l('Microsoft API Settings').'</a></li>
			<li><a href="javascript:void(0)" onclick="tabs_custom(80)" id="tab-menu-80"><img src="../modules/'.$this->name.'/img/settings_g.png"  />'.$this->l('Google API Settings').'</a></li>
			
			<li><a href="javascript:void(0)" onclick="tabs_custom(7)" id="tab-menu-7"><img src="../modules/'.$this->name.'/img/settings_t.png"  />'.$this->l('Twitter Button').'</a></li>
			<li><a href="javascript:void(0)" onclick="tabs_custom(8)" id="tab-menu-8"><img src="../modules/'.$this->name.'/img/settings_t.png"  />'.$this->l('Twitter Widget').'</a></li>
			
			<li><a href="javascript:void(0)" onclick="tabs_custom(9)" id="tab-menu-9"><img src="../modules/'.$this->name.'/img/settings_f.png"  />'.$this->l('Facebook Like Button').'</a></li>
			<li><a href="javascript:void(0)" onclick="tabs_custom(10)" id="tab-menu-10"><img src="../modules/'.$this->name.'/img/settings_f.png"  />'.$this->l('Facebook Widget').'</a></li>
			<li><a href="javascript:void(0)" onclick="tabs_custom(11)" id="tab-menu-11"><img src="../modules/'.$this->name.'/img/settings_f.png"  />'.$this->l('Facebook Comments').'</a></li>
			<li><a href="javascript:void(0)" onclick="tabs_custom(12)" id="tab-menu-12"><img src="../modules/'.$this->name.'/img/settings_f.png"  />'.$this->l('Facebook Share Button').'</a></li>
			
			<li><a href="javascript:void(0)" onclick="tabs_custom(13)" id="tab-menu-13"><img src="../modules/'.$this->name.'/img/pinterest.png"  />'.$this->l('Pinterest Widget').'</a></li>
			<li><a href="javascript:void(0)" onclick="tabs_custom(14)" id="tab-menu-14"><img src="../modules/'.$this->name.'/img/pinterest.png"  />'.$this->l('Pinterest Button').'</a></li>
			
			<li><a href="javascript:void(0)" onclick="tabs_custom(15)" id="tab-menu-15"><img src="../modules/'.$this->name.'/img/settings_l.png"  />'.$this->l('LinkedIn Button').'</a></li>
			
			<li><a href="javascript:void(0)" onclick="tabs_custom(16)" id="tab-menu-16"><img src="../modules/'.$this->name.'/img/settings_g.png"  />'.$this->l('Google Widget').'</a></li>
			<li><a href="javascript:void(0)" onclick="tabs_custom(17)" id="tab-menu-17"><img src="../modules/'.$this->name.'/img/settings_g.png"  />'.$this->l('Google +1 Button').'</a></li>';
			
		     	$_html .= '<li>&nbsp;</li>
					<li><a href="javascript:void(0)" onclick="tabs_custom(18)" id="tab-menu-18"><img src="../modules/'.$this->name.'/img/settings_facebook.png"  />'.$this->l('Facebook Referrals').'</a></li>
					<li><a href="javascript:void(0)" onclick="tabs_custom(19)" id="tab-menu-19"><img src="../modules/'.$this->name.'/img/settings_twitter.png" />'.$this->l('Twitter Referrals').'</a></li>
					<li><a href="javascript:void(0)" onclick="tabs_custom(20)" id="tab-menu-20"><img src="../modules/'.$this->name.'/img/settings_google.png" />'.$this->l('Google Referrals').'</a></li>';
		 if($this->is_l == 1)
			$_html .= '<li><a href="javascript:void(0)" onclick="tabs_custom(61)" id="tab-menu-61"><img src="../modules/'.$this->name.'/img/settings_linkedin.png" />'.$this->l('LinkedIn Referrals').'</a></li>';
		$_html .= '<li>&nbsp;</li>
		<li><a href="javascript:void(0)" onclick="tabs_custom(62)" id="tab-menu-62"><img src="../modules/'.$this->name.'/img/connects-logo.png" />'.$this->l('Voucher Settings').'</a></li>
		<li><a href="javascript:void(0)" onclick="tabs_custom(63)" id="tab-menu-63"><img src="../modules/'.$this->name.'/img/connects-logo.png" />'.$this->l('Referrals Manager').'</a></li>
			
		';
		$_html .= '<li>&nbsp;</li>';
		
		$_html .=	'<li><a href="javascript:void(0)" onclick="tabs_custom(21)" id="tab-menu-21" class="selected"><img src="../modules/'.$this->name.'/img/logo-blog.gif" />'.$this->l('Blog Settings').'</a></li>
			<li><a href="javascript:void(0)" onclick="tabs_custom(22)" id="tab-menu-22"><img src="../modules/'.$this->name.'/img/logo-blog.gif" />'.$this->l('Categories').'</a></li>';
		 $edit_item_category = Tools::getValue("edit_item_category");
		 if (strlen($edit_item_category)>0) {
			$_html .=	'<li><a href="javascript:void(0)" onclick="tabs_custom(23)" id="tab-menu-23" style="font-weight:100;font-size:12px"><img src="../modules/'.$this->name.'/img/logo-blog.gif" />'.$this->l('Edit Category').'</a></li>';
		 } else {
		 	$_html .=	'<li><a href="javascript:void(0)" onclick="tabs_custom(23)" id="tab-menu-23" style="font-weight:100;font-size:12px"><img src="../modules/'.$this->name.'/img/logo-blog.gif" />'.$this->l('Add Category').'</a></li>';
		 }
		 
		$_html .=	'<li><a href="javascript:void(0)" onclick="tabs_custom(24)" id="tab-menu-24"><img src="../modules/'.$this->name.'/img/logo-blog.gif" />'.$this->l('Posts').'</a></li>';
		
		$edit_item_posts = Tools::getValue("edit_item_posts");
		if (strlen($edit_item_posts)>0) {
			$_html .=	'<li><a href="javascript:void(0)" onclick="tabs_custom(25)" id="tab-menu-25" style="font-weight:100;font-size:12px"><img src="../modules/'.$this->name.'/img/logo-blog.gif" />'.$this->l('Edit Post').'</a></li>';
		} else {
			$_html .=	'<li><a href="javascript:void(0)" onclick="tabs_custom(25)" id="tab-menu-25" style="font-weight:100;font-size:12px"><img src="../modules/'.$this->name.'/img/logo-blog.gif" />'.$this->l('Add Post').'</a></li>';
		}
		
		$_html .=	'<li><a href="javascript:void(0)" onclick="tabs_custom(26)" id="tab-menu-26"><img src="../modules/'.$this->name.'/img/logo-blog.gif" />'.$this->l('Comments').'</a></li>';
			
		$edit_item_comments = Tools::getValue("edit_item_comments");
		if(strlen($edit_item_comments)>0){
			$_html .=	'<li><a href="javascript:void(0)" onclick="tabs_custom(27)" id="tab-menu-27" style="font-weight:100;font-size:12px"><img src="../modules/'.$this->name.'/img/logo-blog.gif" />'.$this->l('Edit Comments').'</a></li>';
		}
		
		#### Product reviews + Google Snippets, Breadcrumb, Rich Pin ####
		 $_html .= '<li><a href="javascript:void(0)" onclick="tabs_custom(28)" id="tab-menu-28" class="selected"><img src="../modules/'.$this->name.'/i/settings_reviews.gif" />'.$this->l('Reviews Settings').'</a></li>';
 		 $_html .= '<li><a href="javascript:void(0)" onclick="tabs_custom(29)" id="tab-menu-29"><img src="../modules/'.$this->name.'/i/settings_reviews.gif"  />'.$this->l('Moderate Product Reviews').'</a></li>';
 		 $_html .= '<li><a href="javascript:void(0)" onclick="tabs_custom(30)" id="tab-menu-30"><img src="../modules/'.$this->name.'/i/ico-google.gif" />'.$this->l('Google Snippets Settings').'</a></li>';
		 $_html .= '<li><a href="javascript:void(0)" onclick="tabs_custom(31)" id="tab-menu-31"><img src="../modules/'.$this->name.'/i/ico-google.gif" />'.$this->l('Google Snippets Testing Tools').'</a></li>';
		 $_html .= '<li><a href="javascript:void(0)" onclick="tabs_custom(32)" id="tab-menu-32"><img src="../modules/'.$this->name.'/i/ico-google.gif" />'.$this->l('Rich Snippets for Breadcrumb').'</a></li>';	
		 $_html .= '<li><a href="javascript:void(0)" onclick="tabs_custom(33)" id="tab-menu-33"><img src="../modules/'.$this->name.'/i/ico-pinterest.png" />'.$this->l('Pinterest Rich Pins Settings').'</a></li>';
		#### Product reviews + Google Snippets, Breadcrumb, Rich Pin ####
		
		
		// testimonials
		$_html .= '<li><a href="javascript:void(0)" onclick="tabs_custom(34)" id="tab-menu-34"><img src="../modules/'.$this->name.'/img/logo-testimonials.gif" />'.$this->l('Testimonials').'</a></li>';
		// testimonials
		
		
		// faq
		$_html .=	'<li><a href="javascript:void(0)" onclick="tabs_custom(35)" id="tab-menu-35"><img src="../modules/'.$this->name.'/img/logo-faq.gif" />'.$this->l('FAQ').'</a></li>';
		// faq
		
		// guestbook
		$_html .=	'<li><a href="javascript:void(0)" onclick="tabs_custom(36)" id="tab-menu-36"><img src="../modules/'.$this->name.'/img/logo-blockguestbook.gif" />'.$this->l('Guestbook').'</a></li>';
		// guestbook
		
		// news
		$_html .=	'<li><a href="javascript:void(0)" onclick="tabs_custom(37)" id="tab-menu-37"><img src="../modules/'.$this->name.'/img/logo-news.gif" />'.$this->l('News').'</a></li>';
		// news
		
		// prod questions
		$_html .=	'<li><a href="javascript:void(0)" onclick="tabs_custom(38)" id="tab-menu-38"><img src="../modules/'.$this->name.'/img/logo-prodquestions.gif" />'.$this->l('Product Questions').'</a></li>';
		// prod questions
		
			
			$_html .= '</ul>
		</fieldset>
			
			<div class="'.$this->name.'-content">';
				$_html .= '<div id="tabs-77">'.$this->_welcome().'</div>';
				$_html .= '<div id="tabs-78">'.$this->_drawSettingsSeoURL().'</div>';
				
				$_html .= '<div id="tabs-1">'.$this->_drawPositionsConnectsForm().'</div>';
				$_html .= '<div id="tabs-2">'.$this->_drawImageConnectForm().'</div>';
				$_html .= '<div id="tabs-3">'.$this->_drawFacebookForm().'</div>';
     			$_html .= '<div id="tabs-4">'.$this->_drawTwitterForm().'</div>';
     			$_html .= '<div id="tabs-5">'.$this->_drawPaypalSettingsForm().'</div>';
     			$_html .= '<div id="tabs-6">'.$this->_drawLinkedInSettingsForm().'</div>';
     			$_html .= '<div id="tabs-70">'.$this->_drawMicrosoftSettingsForm().'</div>';
     			$_html .= '<div id="tabs-80">'.$this->_drawGoogleSettingsForm().'</div>';
     			
     			$_html .= '<div id="tabs-7">'.$this->_drawTwitterButtonSettingsForm().'</div>';
     			$_html .= '<div id="tabs-8">'.$this->_drawTwitterWidgetSettingsForm().'</div>';
     			
     			$_html .= '<div id="tabs-9">'.$this->_drawFacebookLikeButtonSettingsForm().'</div>';
     			$_html .= '<div id="tabs-10">'.$this->_drawFacebookWidgetSettingsForm().'</div>';
     			$_html .= '<div id="tabs-11">'.$this->_drawFacebookCommentsSettingsForm().'</div>';
     			$_html .= '<div id="tabs-12">'.$this->_drawFacebookShareButtonSettingsForm().'</div>';
     			
     			$_html .= '<div id="tabs-13">'.$this->_drawPinterestWidgetSettingsForm().'</div>';
     			$_html .= '<div id="tabs-14">'.$this->_drawPinterestButtonSettingsForm().'</div>';
     			
     			$_html .= '<div id="tabs-15">'.$this->_drawLinkedInButtonSettingsForm().'</div>';
     			
     			$_html .= '<div id="tabs-16">'.$this->_drawGoogleWidgetSettingsForm().'</div>';
     			$_html .= '<div id="tabs-17">'.$this->_drawGoogleButtonSettingsForm().'</div>';
     			
     			
     			$_html .= '<div id="tabs-18">'.$this->_drawReferralsSettings(array('type'=>'facebook')).'</div>';
				$_html .= '<div id="tabs-19">'.$this->_drawReferralsSettings(array('type'=>'twitter')).'</div>';
				$_html .= '<div id="tabs-20">'.$this->_drawReferralsSettings(array('type'=>'google')).'</div>';
				if($this->is_l == 1)
				$_html .= '<div id="tabs-61">'.$this->_drawReferralsSettings(array('type'=>'linkedin')).'</div>';
				
				
				$_html .= '<div id="tabs-62">'.$this->_drawReferralsSettingsForm().'</div>';
				$_html .= '<div id="tabs-63">'.$this->_referralsManagerForm().'</div>';
				
				
				$_html .= '<div id="tabs-21">'.$this->_drawSettingsForm().'</div>
				<div id="tabs-22">'.$this->_drawCategories().'</div>';
		      
		    	if (strlen($edit_item_category)>0) {
		        	$_html .= '<div id="tabs-23">'.$this->_drawAddCategoryForm(array('action'=>'edit',
		        																		  'id'=>Tools::getValue("id_category"))
		        																	).'</div>';
				} else {
		    		$_html .= '<div id="tabs-23">'.$this->_drawAddCategoryForm().'</div>';
				}
				
				$_html .=  '<div id="tabs-24">'.$this->_drawPosts(array('edit'=>2)).'</div>';
				
				if (strlen($edit_item_posts)>0) {
					$_html .=  '<div id="tabs-25">'.$this->_drawAddPostForm(array('action'=>'edit',
		        																		  'id'=>Tools::getValue("id_posts"))
																				).'</div>';
				} else {
					$_html .=  '<div id="tabs-25">'.$this->_drawAddPostForm().'</div>';
				}
				$_html .=  '<div id="tabs-26">'.$this->_drawComments(array('edit'=>2)).'</div>';
				
     			if(strlen($edit_item_comments)>0){
					$_html .=	'<div id="tabs-27">'.$this->_drawEditComments(array('action'=>'edit',
		        																	   'id'=>Tools::getValue("id_comments"))
		        																	).'</div>';
				}
				
				
				#### Product reviews + Google Snippets, Breadcrumb, Rich Pin ####
				$_html .= '<div id="tabs-28">'.$this->_drawSettingsSnip().'</div>';
				$_html .= '<div id="tabs-29">'.$this->_drawProductReviews().'</div>';
				$_html .= '<div id="tabs-30">'.$this->_drawGoogleSnippetsSettingsForm().'</div>';
				$_html .= '<div id="tabs-31">'.$this->_drawGoogleSnippetsTestingToolForm().'</div>';
				$_html .= '<div id="tabs-32">'.$this->_drawGoogleBreadcrambSettingsForm().'</div>';
				$_html .= '<div id="tabs-33">'.$this->_drawPinterestRichPinsForm().'</div>';
				#### Product reviews + Google Snippets, Breadcrumb, Rich Pin ####
				
				
				// testimonials
				$_html .= '<div id="tabs-34">'.$this->_drawSettingsTestim().$this->_drawTestImonials().'</div>';
				// testimonials
				
				
				// faq
				$_html .= '<div id="tabs-35"><div style="overflow:auto">
					'.$this->_drawSettingsFAQ().'<br/><br/>'.$this->drawFAQCategories().'<br/>'.$this->drawFaqItems().'</div></div>';
				// faq
				
				
				// guestbook
				$_html .= '<div id="tabs-36">'.$this->_drawSettingsGuestbook().$this->drawGuestbookMessages().'</div>';
				// guestbook
				
				// news
				$_html .= '<div id="tabs-37"><div style="overflow:auto">
				'.$this->_drawNewsSettings().$this->drawNews().'</div></div>';
				// news
		
				// prod questions
				$_html .= '<div id="tabs-38">'.$this->_drawSettingsProdquestions().$this->ModerateQuestions().'</div>';
				// prod questions
     			
			$_html .= '</div>';
				
			$_html .= '<div style="clear:both"></div>';
			$_html .= '</div>
			
			
		</fieldset>	';
			
		return $_html;
     	
    }

 
public function ModerateQuestions($data=null){
    	$cookie = $this->context->cookie;
			
		global $currentIndex;
    	
    	$currentIndex = isset($data['currentindex'])?$data['currentindex']:$currentIndex;
    	$controller = isset($data['controller'])?$data['controller']:'AdminModules';
    	$token = isset($data['token'])?$data['token']:Tools::getAdminToken($controller.intval(Tab::getIdFromClassName($controller)).intval($cookie->id_employee));
    	
		$_html = '';
		
		$_html .= '<br/><br/>';
		
		$_html .= '<fieldset>
					<legend><img src="../modules/'.$this->name.'/img/logo-prodquestions.gif" />
					'.$this->l('Moderate Product Questions').'</legend>';
    	
    	include_once(dirname(__FILE__).'/classes/prodquestionshelp.class.php');
		$obj_prodquestionshelp = new prodquestionshelp();
				
    	if(Tools::isSubmit("edit_item_pq")){
    		
    		$_data = $obj_prodquestionshelp->getItem(array('id'=>(int)Tools::getValue("id")));
    		
    		$_html .= '
    					<form action="'.$_SERVER['REQUEST_URI'].'" method="post">';
    		
    		$name = $_data['items'][0]['name'];
    		$email = isset($_data['items'][0]['email'])?$_data['items'][0]['email']:"&nbsp;";
    		$question = $_data['items'][0]['question'];
    		$response = $_data['items'][0]['response'];
    		$date = $_data['items'][0]['time_add'];
    		$active = $_data['items'][0]['is_active'];
    		$id = $_data['items'][0]['id'];
    		$id_product = $_data['items'][0]['id_product'];
    		$_product_info = $this->getProduct(array('id'=>$id_product));
    		
    		$_html .= '<label>'.$this->l('ID').':</label>';
    		$_html .= '<div style="padding:0 0 1em 210px;line-height:1.6em;">'.$id.'</div>';
    		
    		$_html .= '<label>'.$this->l('Name').':</label>
    					<div class="margin-form">
							<input type="text" name="name"  style="width:200px"
			                	   value="'.$name.'">
						</div>';
    		
    		$_html .= '<label>'.$this->l('Email').':</label>
    					<div style="padding:0 0 1em 210px;line-height:1.6em;">
							'.$email.'
						</div><div style="clear:both;"></div>';
    				
    		$_html .= '<label>'.$this->l('Product').':</label>
    					<div class="margin-form">';
    			foreach($_product_info['product'] as $_item_product){
    					$name_product = isset($_item_product['name'])?stripslashes($_item_product['name']):'';
    					$link_product = isset($_item_product['link'])?$_item_product['link']:'';
    					if(strlen($name_product)==0) continue;
						$_html .= '<a href="'.$link_product.'" target="_blank" style="font-size:13px;color: rgb(38, 140, 205); text-decoration: underline;">'.$name_product.'</a>';
    				}	
			$_html .= '</div>';
    		
    		$_html .= '<label>'.$this->l('Question').':</label>
    					<div class="margin-form">
							<textarea name="question" cols="50" rows="6"  
			                	   >'.$question.'</textarea>
						</div>';
    		$_html .= '<label>'.$this->l('Response').':</label>
    					<div class="margin-form">
							<textarea name="response" cols="50" rows="6"  
			                	   >'.$response.'</textarea>
						</div>';
    		$_html .= '<label>'.$this->l('Date Add').':</label>';
    		$_html .= '<div style="padding:0 0 1em 210px;line-height:1.6em;">'.$date.'</div>';
    		
    		
    		$_html .= '
				<label>'.$this->l('Publish').'</label>
				<div class = "margin-form" >';
				
			$_html .= '<input type = "checkbox" name = "publish" id = "publish" value ="1" '.(($active ==1)?'checked':'').'/>';
				
			$_html .= '</div>';
				
			$_html .= '<label>&nbsp;</label>
						<div class = "margin-form"  style="margin-top:20px">
						<input type="submit" name="cancel_item_pq" value="'.$this->l('Cancel').'" 
                		   class="button"  />&nbsp;&nbsp;&nbsp;
						<input type="submit" name="submit_item_pq" value="'.$this->l('Save').'" 
                		   class="button"  />
                		  </div>';
			
    		$_html .= '</form>';
			
    		
    	} else {
    	
    	$start = (int)Tools::getValue("page_q");
		
    	$_id_selected_product = (int)Tools::getValue("id_product");
		
    	
		$_data = $obj_prodquestionshelp->getItems(array('start'=>$start,'step'=>$this->_step,'admin' => 1,'id_selected_product'=>$_id_selected_product));

		$paging = $obj_prodquestionshelp->PageNav($start,$_data['count_all_items'],$this->_step,0 ,
											array('admin' => 1,'currentIndex'=>$currentIndex,
												  'token' => $token));
    	
		$all_products = $_data['all_products'];
		
		if(sizeof($all_products)>0){
		$_html .= '<div style="margin-bottom:10px;float:right">';
		$_html .= '<b>'.$this->l('Filter questions by product').':&nbsp;</b>';
		$_html .= '<select onchange="window.location.href=\''.$currentIndex.'&page_q&configure='.$this->name.'&token='.$token.'&id_product=\'+this.options[this.selectedIndex].value">';

		foreach($all_products as $_product_id){
			$_product_id = $_product_id['id_product'];
			$_product_info1 = $this->getProduct(array('id'=>$_product_id));
			
			foreach($_product_info1['product'] as $_item_product1){
    					$name_product1 = isset($_item_product1['name'])?stripslashes($_item_product1['name']):'';
    					if(strlen($name_product1)==0) continue;
						$_html .= '<option value='.$_product_id.' '.(($_id_selected_product == $_product_id)?'selected="selected"':'').'>'.$name_product1.'</option>';
    				}
			
		}
		
		$_html .= '<select>';
		if($_id_selected_product)
		$_html .= '&nbsp;&nbsp;<a href="'.$currentIndex.'&page_q&configure='.$this->name.'&token='.$token.'" 
						style="text-decoration:underline">'.$this->l('Clear search').'</a>';
		$_html .= '</div>';
		
		$_html .= '<div style="clear:both"></div>';
		}
		
    	$_html .= '<table class = "table" width = 100%>
			<tr>
				<th>'.$this->l('No.').'</th>
				<th width=100>'.$this->l('Name').'</th>
				<th width=100>'.$this->l('Email').'</th>
				<th width=100>'.$this->l('Product').'</th>
				<th width = "200">'.$this->l('Question').'</th>
				<th width = "200">'.$this->l('Response').'</th>
				<th>'.$this->l('Date').'</th>
				<th>'.$this->l('Status').'</th>
				<th width = "44">'.$this->l('Action').'</th>
			</tr>';
    	
    	$i=0;
    	if(sizeof($_data['items'])>0){
		foreach($_data['items'] as $_item){
			$i++;
			$id = $_item['id'];
			$name = $_item['name'];
			$email = isset($_item['email'])?$_item['email']:"&nbsp;";
			$question = $_item['question'];
			$response = $_item['response'];
			$date = $_item['time_add'];
			$active = $_item['is_active'];
			$id_product = $_item['id_product'];
			
			$_product_info = $this->getProduct(array('id'=>$id_product));
			$_html .= 
			'<tr>
			<td style = "color:black;">'.$id.'</td>
			<td style = "color:black;">'.$name.'</td>
			<td style = "color:black;">'.$email.'</td>
			';
			$_html .= '<td style = "color:black;">';
			foreach($_product_info['product'] as $_item_product){
    					$name_product = isset($_item_product['name'])?stripslashes($_item_product['name']):'';
    					$link_product = isset($_item_product['link'])?$_item_product['link']:'';
    					if(strlen($name_product)==0) continue;
						$_html .= '<a href="'.$link_product.'" target="_blank" style="color: rgb(38, 140, 205); text-decoration: underline;">'.$name_product.'</a>';
    				}
    		$_html .= '</td>';
			$_html .= '<td style = "color:black;">'.(strlen($question)>33?substr($question,0,33)."...":$question).'</td>';
			$_html .= '<td style = "color:black;">'.(strlen($response)>33?substr($response,0,33)."...":$response).'</td>';
			
			$_html .= '<td style = "color:black;">'.$date.'</td>';
			
			$_html .= '
			<td style = "color:black;text-align:center;">';
			if($active == 1)
				$_html .= '<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">';
			else
				$_html .= '<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">';
				
			
			 
			$_html .= '</td>
			<td>
				<form action = "'.$_SERVER['REQUEST_URI'].'" method = "POST">
				 <input type = "hidden" name = "id" value = "'.$id.'"/>
				 <a href="'.$currentIndex.'&configure='.$this->name.'&token='.$token.'&edit_item_pq&id='.(int)($id).'&page_q='.$start.'" title="'.$this->l('Edit').'"><img src="'._PS_ADMIN_IMG_.'edit.gif" alt="" /></a> 
				 <a href="'.$currentIndex.'&configure='.$this->name.'&token='.$token.'&delete_item_pq&id='.(int)($id).'&page_q='.$start.'" title="'.$this->l('Delete').'"  onclick = "javascript:return confirm(\''.$this->l('Are you sure you want to remove this item?').'\');"><img src="'._PS_ADMIN_IMG_.'delete.gif" alt="" /></a>'; 
				 $_html .= '</form>
			 </td>
			 </tr>';
			
			$_html .= '</tr>';
		} 
		
    	} else {
    		$_html .= '<tr>
    					<td colspan=9 style="border-bottom:none;text-align:center;padding:10px">
    					'.$this->l('No questions for moderate.').'</td>
    				   </tr>';
    		}
    	
    	$_html .= '</table>
						';
    	if($i!=0){
    	$_html .= '<div style="margin:5px">';
    	$_html .= $paging;
    	$_html .= '</div>';
    	}
    	}
    	
    	
    	$_html .=	'</fieldset>'; 
    	
    	return $_html;
    }
    
    private function _drawSettingsProdquestions(){
    	$cookie = $this->context->cookie;
		
    	global $currentIndex;
		$_html = '';
    	$_html .= '<fieldset>
					<legend><img src="../modules/'.$this->name.'/img/logo-prodquestions.gif" />'
    				.$this->l('Product Questions Settings').':</legend>';
    	$_html .= '
        <form action="'.$_SERVER['REQUEST_URI'].'" method="post">';
    	
    	
    	$_html .= '<table style="width:100%">';
    	
    	
    	$_html .= '<tr>';
    	$_html .= '<td style="text-align:right;width:30%;padding:0 20px 0 0">';
    	
    	$_html .= '<b>'.$this->l('Enable or Disable Product questions').':</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td class="r-set">';
    	$_html .=  '
					<input type="radio" value="1" id="text_list_on" name="pqon" onclick="enableOrDisablepqon(1)"
							'.(Tools::getValue('pqon', Configuration::get($this->name.'pqon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					<input type="radio" value="0" id="text_list_off" name="pqon" onclick="enableOrDisablepqon(0)"
						   '.(!Tools::getValue('pqon', Configuration::get($this->name.'pqon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
				';
		
    	$_html .= '</div>';
    	
		$_html .= '<script type="text/javascript">
			    	function enableOrDisablepqon(id)
						{
						if(id==0){
							$("#block-pqon-settings").hide(200);
						} else {
							$("#block-pqon-settings").show(200);
						}
							
						}
					</script>';
    	
		$_html .= '</td>';
		$_html .= '</tr>';
		$_html .= '</table>';
    	
		$_html .= '<div id="block-pqon-settings" '.(Configuration::get($this->name.'pqon')==1?'style="display:block"':'style="display:none"').'>';
    	
    	
    	$_html .= '<table class="table-settings" style="width:100%">';
    	
    	$_html .= '<tr>
    					<td style="text-align:right">
    						<label style="float:none">'.$this->l('Who can add questions?').'</label>
						</td>
						<td>
							<table width=100%>
								<tr>
									<td width=4%>
										<input type="radio" value="all" id="all" name="qsettings"
											'.(Tools::getValue('qsettings', Configuration::get($this->name.'qsettings')) == "all" ? 'checked="checked" ' : '').'>
					  				</td>
					  				<td>'.$this->l('All Users').'</td>
								</tr>
								<tr>
									<td width=4%>
										<input type="radio" value="reg" id="reg" name="qsettings"
											'.(Tools::getValue('qsettings', Configuration::get($this->name.'qsettings')) == "reg" ? 'checked="checked" ' : '').'>
					  
									</td>
									<td>'.$this->l('Only registered users').'</td>
								</tr>
								
							</table>
						</td>
				</tr>';
    	
    	$_html .= '<tr>';
    	$_html .= '<td style="text-align:right;width:30%;padding:0 20px 0 0">';
    	
    	$_html .= '<b>'.$this->l('Questions per Page:').'</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td style="text-align:left">';
		$_html .=  '
					<input type="text" name="qperpage_q"  
			               value="'.Tools::getValue('qperpage_q', Configuration::get($this->name.'qperpage_q')).'"
			               >
				';
		$_html .= '</td>';
		$_html .= '</tr>';
		
		$_html .= '<tr>';
    	$_html .= '<td style="text-align:right;width:30%;padding:0 20px 0 0">';
    	
    	$_html .= '<b>'.$this->l('Enable Captcha on submit form').':</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td style="text-align:left">';
		$_html .=  '
					<input type="radio" value="1" id="text_list_on" name="qis_captcha"
							'.(Tools::getValue('qis_captcha', Configuration::get($this->name.'qis_captcha')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					<input type="radio" value="0" id="text_list_off" name="qis_captcha"
						   '.(!Tools::getValue('qis_captcha', Configuration::get($this->name.'qis_captcha')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
				';
		$_html .= '</td>';
		$_html .= '</tr>';
		
		$_html .= '<tr>';
    	$_html .= '<td style="text-align:right;width:30%;padding:0 20px 0 0">';
    	
    	$_html .= '<b>'.$this->l('Position Ask a Question Button:').'</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td style="text-align:left">';
		$_html .=  '
					<select class="select" name="position_ask_q" 
							id="position">
						<option '.(Tools::getValue('position_ask_q', Configuration::get($this->name.'position_ask_q'))  == "extraright" ? 'selected="selected" ' : '').' value="extraright">'.$this->l('Extraright').'</option>
						<option '.(Tools::getValue('position_ask_q', Configuration::get($this->name.'position_ask_q')) == "extraleft" ? 'selected="selected" ' : '').' value="extraleft">'.$this->l('Extraleft').'</option>
						<option '.(Tools::getValue('position_ask_q', Configuration::get($this->name.'position_ask_q')) == "none" ? 'selected="selected" ' : '').' value="none">'.$this->l('None').'</option>
						
					</select>
				';
		$_html .= '</td>';
		$_html .= '</tr>';
    	
    	$_html .= '<tr>';
    	$_html .= '<td style="text-align:right;width:30%;padding:0 20px 0 0">';
    	
    	$_html .= '<b>'.$this->l('Admin email:').'</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td style="text-align:left">';
		$_html .=  '
					<input type="text" name="qmail"  size="40"
			               value="'.Tools::getValue('qmail', Configuration::get($this->name.'qmail')).'"
			               >
				';
		$_html .= '</td>';
		$_html .= '</tr>';
		
		$_html .= '<tr>';
    	$_html .= '<td style="text-align:right;width:30%;padding:0 20px 0 0">';
    	
    	$_html .= '<b>'.$this->l('E-mail notification:').'</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td style="text-align:left">';
		$_html .= '<input type = "checkbox" name = "qnoti" id = "qnoti" value ="1" '.((Tools::getValue($this->name.'qnoti', Configuration::get($this->name.'qnoti')) ==1)?'checked':'').'/>';
		$_html .= '</td>';
		$_html .= '</tr>';
		
		
		$_html .= '</table>';
    	
		$_html .= '</div>';
		
    	$_html .= '<p class="center" style="text-align:center;border: 1px solid #EBEDF4; padding: 10px; margin-top: 10px;">
					<input type="submit" name="submit_q" value="'.$this->l('Update settings').'" 
                		   class="button"  />
                	</p>';
   		$_html .= '</form>';
    	$_html .=	'</fieldset>';
    	
    	return $_html;
    }
    
    public function drawNews($data = null){
    	$cookie = $this->context->cookie;
		
    	global $currentIndex;
    	
    	$currentIndex = isset($data['currentindex'])?$data['currentindex']:$currentIndex;
    	$controller = isset($data['controller'])?$data['controller']:'AdminModules';
    	$token = isset($data['token'])?$data['token']:Tools::getAdminToken($controller.intval(Tab::getIdFromClassName($controller)).intval($cookie->id_employee));
    	
    	
     	$i=0;
     	$_html = '';
     	
     	$_html = '<br/><br/>';
		
     	$_html .= '<style type="text/css">
     	fieldset.news-form-add label{width:150px !important}
     	fieldset.news-form-add div.margin-form {
    		padding: 0 0 1em 160px !important;
			}
     	</style>';
     	
		$_html .= '<fieldset class="news-form-add">
					<legend><img src="../modules/'.$this->name.'/img/logo-news.gif" />
					'.$this->l('Moderate News').'</legend>';
		
		
		
		include_once(dirname(__FILE__).'/classes/blocknewshelp.class.php');
		$obj_blocknews = new blocknewshelp();
		
		
		if(Tools::isSubmit("edit_item_n")){
			
			$divLangName = "ccontentnews¤titlenews¤post_seokeywordsnews¤post_seodescriptionnews";
			
			
			$_data = $obj_blocknews->getItem(array('id'=>(int)Tools::getValue("id")));
			
			$id = $_data['item'][0]['id'];
			$img = $_data['item'][0]['img'];
			$status = $_data['item'][0]['status'];
			$data_content = isset($_data['item']['data'])?$_data['item']['data']:'';
			
			$_html .= '<form action="'.$_SERVER['REQUEST_URI'].'" method="post" enctype="multipart/form-data">';
    		
    		$_html .= '<label>'.$this->l('Title:').'</label>
    					<div class="margin-form">';
    		
			$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
	    	$languages = Language::getLanguages(false);
	    	
	    	foreach ($languages as $language){
			$id_lng = (int)$language['id_lang'];
	    	$title = isset($data_content[$id_lng]['title'])?$data_content[$id_lng]['title']:"";
			
			$_html .= '	<div id="titlenews_'.$language['id_lang'].'" 
							 style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;"
							 >

						<input type="text" style="width:400px"   
								  id="titlenews_'.$language['id_lang'].'" 
								  name="titlenews_'.$language['id_lang'].'" 
								  value="'.htmlentities(stripslashes($title), ENT_COMPAT, 'UTF-8').'"/>
						</div>';
	    	}
			ob_start();
			$this->displayFlags($languages, $defaultLanguage, $divLangName, 'titlenews');
			$displayflags = ob_get_clean();
			$_html .= $displayflags;
    		$_html .= '<div style="clear:both"></div>';
							
			$_html .= '</div>';
			
			
			
			if(Configuration::get($this->name.'urlrewrite_on') == 1){
			// identifier
			$cookie = $this->context->cookie;
		
			$current_lng =  $cookie->id_lang;
			$seo_url = isset($_data['item']['data'][$current_lng]['seo_url'])?$_data['item']['data'][$current_lng]['seo_url']:"";
		    		
			$_html .= '<label>'.$this->l('Identifier (SEO URL)').'</label>';
	    	
	    	$_html .= '<div class="margin-form">';
	    	
				
				$_html .= '
							<input type="text" style="width:400px"   
									  id="seo_url" 
									  name="seo_url" 
									  value="'.$seo_url.'"/>
							<p>(eg: domain.com/news/identifier)</p>
							';
		    $_html .=  '</div>';
			}
		
    		$_html .= '<label>'.$this->l('SEO Keywords').'</label>';
    			
    	
    	
	    	$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
		    $languages = Language::getLanguages(false);
	    	
	    	$_html .= '<div class="margin-form">';
	    	
			foreach ($languages as $language){
				$id_lng = (int)$language['id_lang'];
		    	$seo_keywords = isset($_data['item']['data'][$id_lng]['seo_keywords'])?$_data['item']['data'][$id_lng]['seo_keywords']:"";
		    	
				$_html .= '	<div id="post_seokeywordsnews_'.$language['id_lang'].'" 
								 style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;"
								 >
							<textarea id="post_seokeywordsnews_'.$language['id_lang'].'" 
									  name="post_seokeywordsnews_'.$language['id_lang'].'" 
									  cols="50" rows="10"  
				                	   >'.htmlentities(stripslashes($seo_keywords), ENT_COMPAT, 'UTF-8').'</textarea>
							
							</div>';
		    	}
			ob_start();
			$this->displayFlags($languages, $defaultLanguage, $divLangName, 'post_seokeywordsnews');
			$displayflags = ob_get_clean();
			$_html .= $displayflags;
			$_html .= '<div style="clear:both"></div>';
				        
			$_html .=  '</div>';
				        
		
    	
	    	$_html .= '<label>'.$this->l('SEO Description').'</label>';
	    			
	    	
	    	
	    	$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
		    $languages = Language::getLanguages(false);
	    	
	    	$_html .= '<div class="margin-form">';
	    	
			foreach ($languages as $language){
				$id_lng = (int)$language['id_lang'];
		    	$seo_description = isset($_data['item']['data'][$id_lng]['seo_description'])?$_data['item']['data'][$id_lng]['seo_description']:"";
		    	
				$_html .= '	<div id="post_seodescriptionnews_'.$language['id_lang'].'" 
								 style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;"
								 >
							<textarea id="post_seodescriptionnews_'.$language['id_lang'].'" 
									  name="post_seodescriptionnews_'.$language['id_lang'].'" 
									  cols="50" rows="10"  
				                	   >'.htmlentities(stripslashes($seo_description), ENT_COMPAT, 'UTF-8').'</textarea>
							
							</div>';
		    	}
			ob_start();
			$this->displayFlags($languages, $defaultLanguage, $divLangName, 'post_seodescriptionnews');
			$displayflags = ob_get_clean();
			$_html .= $displayflags;
			$_html .= '<div style="clear:both"></div>';
				        
			$_html .=  '</div>';
			
			
			
    		
    		$_html .= '<label>'.$this->l('Logo Image').'</label>
    			
    				<div class="margin-form">
					<input type="file" name="post_image" id="post_image" ';
    	if($this->_is16 == 0){
    	 $_html .= 'class="customFileInput"';
    	} 
    	 $_html .= '/>
					<p>Allow formats *.jpg; *.jpeg; *.png; *.gif.</p>';

    	
	    	if(strlen($img)>0){
	    	$_html .= '<div id="post_images_list">';
	    		$_html .= '<div style="float:left;margin:10px" id="post_images_id">';
	    		$_html .= '<table width=100%>';
	    		
	    		$_html .= '<tr><td align="left">';
	    		$_html .= '<input type="radio" checked name="post_images"/>';
	    		
	    		$_html .= '</td>';
	    		
	    		$_html .= '<td align="right">';
	    		
	    			$_html .= '<a href="javascript:void(0)" title="'.$this->l('Delete').'"  
	    						onclick = "delete_img_news('.$id.');"><img src="'._PS_ADMIN_IMG_.'delete.gif" alt="" /></a>
	    					';
	    		
	    		$_html .= '</td>';
	    		
	    		$_html .= '<tr>';
	    		$_html .= '<td colspan=2>';
	    		$_html .= '<img src="../upload/blocknews/'.$img.'" style="width:50px;height:50px"/>';
	    		$_html .= '</td>';
	    		$_html .= '</tr>';
	    		
	    		$_html .= '</table>';
	    		
	    		$_html .= '</div>';
	    	//}
	    	$_html .= '<div style="clear:both"></div>';
	    	$_html .= '</div>';
	    	}
	    	
	    	$_html .= '</div>';
    		
    		
    		if(defined('_MYSQL_ENGINE_')){
	    		
    		$_html .= '<label>'.$this->l('Content:').'</label>
	    					<div class="margin-form" >';
    		
    		$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
	    	$languages = Language::getLanguages(false);
	    	
	    	foreach ($languages as $language){
	    	$id_lng = (int)$language['id_lang'];
	    	$content = isset($data_content[$id_lng]['content'])?$data_content[$id_lng]['content']:"";
			
			$_html .= '	<div id="ccontentnews_'.$language['id_lang'].'" 
							 style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;"
							 >

						<textarea class="rte" cols="25" rows="10" style="width:400px"   
								  id="contentnews_'.$language['id_lang'].'" 
								  name="contentnews_'.$language['id_lang'].'">'.htmlentities(stripslashes($content), ENT_COMPAT, 'UTF-8').'</textarea>

					</div>';
	    	}
	    	
			ob_start();
			$this->displayFlags($languages, $defaultLanguage, $divLangName, 'ccontentnews');
			$displayflags = ob_get_clean();
			$_html .= $displayflags;
	    	
			$_html .= '<div style="clear:both"></div>';
			
			$_html .= '</div>';
	    	}else{
	    		
	    		$_html .= '<label>'.$this->l('Content:').'</label>
	    					<div class="margin-form">';
	    					
	    		$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
		    	$languages = Language::getLanguages(false);
		    	$divLangName = "ccontent";
		    	
		    	foreach ($languages as $language){
				$id_lng = (int)$language['id_lang'];
	    		$content = isset($data_content[$id_lng]['content'])?$data_content[$id_lng]['content']:"";
			
				$_html .= '	<div id="ccontentnews_'.$language['id_lang'].'" 
								 style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;"
								 >
	
							<textarea class="rte" cols="25" rows="10" style="width:400px"   
									  id="contentnews_'.$language['id_lang'].'" 
									  name="contentnews_'.$language['id_lang'].'">'.htmlentities(stripslashes($content), ENT_COMPAT, 'UTF-8').'</textarea>
	
						</div>';
		    	}
				ob_start();
				$this->displayFlags($languages, $defaultLanguage, $divLangName, 'ccontentnews');
				$displayflags = ob_get_clean();
				$_html .= $displayflags;
		    	
				$_html .= '<div style="clear:both"></div>';
				
				$_html .= '</div>';
	    	}
	    	
	    	$_html .= '<label>'.$this->l('Status').'</label>
				<div class = "margin-form">';
				
			$_html .= '<select name="item_status" style="width:100px">
						<option value=1 '.(($status==1)?"selected=\"true\"":"").'>'.$this->l('Enabled').'</option>
						<option value=0 '.(($status==0)?"selected=\"true\"":"").'>'.$this->l('Disabled').'</option>
					   </select>';
				
				
			$_html .= '</div>';
			
			
			if($this->_is15){
	    	// shop association
	    	$_html .= '<div class="clear"></div>';
	    	$_html .= '<label>'.$this->l('Shop association').':</label>';
	    	$_html .= '<div class="margin-form">';
	
			$_html .= '<table width="50%" cellspacing="0" cellpadding="0" class="table">
							<tr>
								<th>Shop</th>
							</tr>';
			$u = 0;
			
			
			
			$shops = Shop::getShops();
			$shops_tmp = explode(",",isset($_data['item'][0]['ids_shops'])?$_data['item'][0]['ids_shops']:"");
			
			$count_shops = sizeof($shops);
			foreach($shops as $_shop){
				$id_shop = $_shop['id_shop'];
				$name_shop = $_shop['name'];
				 $_html .= '<tr>
							<td>
								<img src="../img/admin/lv2_'.((($count_shops-1)==$u)?"f":"b").'.png" alt="" style="vertical-align:middle;">
								<label class="child">';
			 
				
					$_html .= '<input type="checkbox"  
									   name="cat_shop_association[]" 
									   value="'.$id_shop.'" '.((in_array($id_shop,$shops_tmp))?'checked="checked"':'').' 
									   class="input_shop" 
									   />
									'.$name_shop.'';
					
					$_html .= '</label>
							</td>
						</tr>';
			 $u++;
			}
		
			$_html .= '</table>';
				
			$_html .= '</div>';
																	
	    	}
	    	// shop association
	    
			
    	
    		$_html .= '<label>&nbsp;</label>
						<div class = "margin-form"  style="margin-top:10px">
						<input type="submit" name="cancel_item_n" value="'.$this->l('Cancel').'" 
                		   class="button"  />&nbsp;&nbsp;&nbsp;
						<input type="submit" name="update_item_n" value="'.$this->l('Update').'" 
                		   class="button"  />
                		  </div>';
    		
    		$_html .= '</form>';
    		
		}else{
			
			$divLangName = "ccontentnews¤titlenews¤post_seokeywordsnews¤post_seodescriptionnews";
			$name = "";
			$content = "";
			$seo_url  = "";
			$seo_keywords = "";
			$seo_description = "";
			
    		$_html .= '<a href="javascript:void(0)" onclick="$(\'#add-news-form\').show(200);$(\'#link-add-news-form\').hide(200)"
    					id="link-add-news-form"	
					  style="border: 1px solid rgb(222, 222, 222); padding: 5px; margin-bottom: 10px; display: block; font-size: 16px; color: maroon; text-align: center; font-weight: bold; text-decoration: underline;"
					  >'.$this->l('Add New Item').'</a>';
    		
    		$_html .= '<div style="border: 1px solid rgb(222, 222, 222);padding-top:10px;display:none" id="add-news-form">';
			$_html .= '<form action="'.$_SERVER['REQUEST_URI'].'" method="post" enctype="multipart/form-data">';
    		
    		$_html .= '<label>'.$this->l('Title:').'</label>
    					<div class="margin-form">';
    		
    		
    		$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
	    	$languages = Language::getLanguages(false);
	    	
	    	foreach ($languages as $language){
			$id_lng = (int)$language['id_lang'];
	    	
			$_html .= '	<div id="titlenews_'.$language['id_lang'].'" 
							 style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;"
							 >

						<input type="text" style="width:400px"   
								  id="titlenews_'.$language['id_lang'].'" 
								  name="titlenews_'.$language['id_lang'].'" 
								  value="'.htmlentities(stripslashes($name), ENT_COMPAT, 'UTF-8').'"/>
						</div>';
	    	}
			ob_start();
			$this->displayFlags($languages, $defaultLanguage, $divLangName, 'titlenews');
			$displayflags = ob_get_clean();
			$_html .= $displayflags;
			$_html .= '<div style="clear:both"></div>';
    		
			$_html .= '</div>';
			
			
			
			
			if(Configuration::get($this->name.'urlrewrite_on') == 1){
			// identifier
			$cookie = $this->context->cookie;
			$current_lng =  $cookie->id_lang;
				
			$_html .= '<label>'.$this->l('Identifier (SEO URL)').'</label>';
	    	
	    	$_html .= '<div class="margin-form">';
	    	
				
				$_html .= '
							<input type="text" style="width:400px"   
									  id="seo_url" 
									  name="seo_url" 
									  value="'.$seo_url.'"/>
							<p>(eg: domain.com/news/identifier)</p>
							';
		    $_html .=  '</div>';
			}
		
	    	$_html .= '<label>'.$this->l('SEO Keywords').'</label>';
	    			
	    	
	    	
	    	$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
		    $languages = Language::getLanguages(false);
	    	
	    	$_html .= '<div class="margin-form">';
	    	
			foreach ($languages as $language){
				$id_lng = (int)$language['id_lang'];
		    	
				$_html .= '	<div id="post_seokeywordsnews_'.$language['id_lang'].'" 
								 style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;"
								 >
							<textarea id="post_seokeywordsnews_'.$language['id_lang'].'" 
									  name="post_seokeywordsnews_'.$language['id_lang'].'" 
									  cols="50" rows="10"  
				                	   >'.htmlentities(stripslashes($seo_keywords), ENT_COMPAT, 'UTF-8').'</textarea>
							
							</div>';
		    	}
			ob_start();
			$this->displayFlags($languages, $defaultLanguage, $divLangName, 'post_seokeywordsnews');
			$displayflags = ob_get_clean();
			$_html .= $displayflags;
			$_html .= '<div style="clear:both"></div>';
				        
			$_html .=  '</div>';
			        
		
    	
	    	$_html .= '<label>'.$this->l('SEO Description').'</label>';
	    			
	    	
	    	
	    	$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
		    $languages = Language::getLanguages(false);
	    	
	    	$_html .= '<div class="margin-form">';
	    	
			foreach ($languages as $language){
				$id_lng = (int)$language['id_lang'];
		    	
				$_html .= '	<div id="post_seodescriptionnews_'.$language['id_lang'].'" 
								 style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;"
								 >
							<textarea id="post_seodescriptionnews_'.$language['id_lang'].'" 
									  name="post_seodescriptionnews_'.$language['id_lang'].'" 
									  cols="50" rows="10"  
				                	   >'.htmlentities(stripslashes($seo_description), ENT_COMPAT, 'UTF-8').'</textarea>
							
							</div>';
		    	}
			ob_start();
			$this->displayFlags($languages, $defaultLanguage, $divLangName, 'post_seodescriptionnews');
			$displayflags = ob_get_clean();
			$_html .= $displayflags;
			$_html .= '<div style="clear:both"></div>';
				        
			$_html .=  '</div>';
			        
		
			
			
			
    		
    		$_html .= '<label>'.$this->l('Logo Image').'</label>
    			
    				<div class="margin-form">
					<input type="file" name="post_image" id="post_image" ';
    	if($this->_is16 == 0){
    	 $_html .= 'class="customFileInput"';
    	} 
    	 $_html .= '/>
					<p>Allow formats *.jpg; *.jpeg; *.png; *.gif.</p>';
    	
	    	$_html .= '</div>';
    		
    		if(defined('_MYSQL_ENGINE_')){
	    	
    			
    		$_html .= '<label>'.$this->l('Content:').'</label>
	    					<div class="margin-form" >';
    			$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
	    	$languages = Language::getLanguages(false);
	    	
	    	foreach ($languages as $language)

			$_html .= '	<div id="ccontentnews_'.$language['id_lang'].'" 
							 style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;"
							 >

						<textarea class="rte" cols="25" rows="10" style="width:400px"   
								  id="contentnews_'.$language['id_lang'].'" 
								  name="contentnews_'.$language['id_lang'].'">'.htmlentities(stripslashes($content), ENT_COMPAT, 'UTF-8').'</textarea>

					</div>';
			ob_start();
			$this->displayFlags($languages, $defaultLanguage, $divLangName, 'ccontentnews');
			$displayflags = ob_get_clean();
			$_html .= $displayflags;
			$_html .= '<div style="clear:both"></div>';
			$_html .= '</div>';
			
	    	}else{
	    		
	    	$_html .= '<label>'.$this->l('Content:').'</label>
	    					<div class="margin-form" >';
    			$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
	    	$languages = Language::getLanguages(false);
	    	
	    	foreach ($languages as $language)

			$_html .= '	<div id="ccontentnews_'.$language['id_lang'].'" 
							 style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;"
							 >

						<textarea class="rte" cols="25" rows="10" style="width:400px"   
								  id="contentnews_'.$language['id_lang'].'" 
								  name="contentnews_'.$language['id_lang'].'">'.htmlentities(stripslashes($content), ENT_COMPAT, 'UTF-8').'</textarea>

					</div>';
			ob_start();
			$this->displayFlags($languages, $defaultLanguage, $divLangName, 'ccontentnews');
			$displayflags = ob_get_clean();
			$_html .= $displayflags;
			$_html .= '<div style="clear:both"></div>';
			$_html .= '</div>';
	    	}
	    	
	    	
		$_html .= '<label>'.$this->l('Status').'</label>
				<div class = "margin-form" style="padding: 0pt 0pt 10px 130px;">';
				
		$_html .= '<select name="item_status">
					<option value=1 selected="true">'.$this->l('Enabled').'</option>
					<option value=0>'.$this->l('Disabled').'</option>
				   </select>';
			$_html .= '</div>';
			
		
			
		if($this->_is15){
    	// shop association
    	$_html .= '<div class="clear"></div>';
    	$_html .= '<label>'.$this->l('Shop association').':</label>';
    	$_html .= '<div class="margin-form">';

		$_html .= '<table width="50%" cellspacing="0" cellpadding="0" class="table">
						<tr>
							<th>Shop</th>
						</tr>';
		$u = 0;
		
		$shops = Shop::getShops();
		$shops_tmp = array();
		
		$count_shops = sizeof($shops);
		foreach($shops as $_shop){
			$id_shop = $_shop['id_shop'];
			$name_shop = $_shop['name'];
			 $_html .= '<tr>
						<td>
							<img src="../img/admin/lv2_'.((($count_shops-1)==$u)?"f":"b").'.png" alt="" style="vertical-align:middle;">
							<label class="child">';
		 
			
				$_html .= '<input type="checkbox"  
								   name="cat_shop_association[]" 
								   value="'.$id_shop.'" '.((in_array($id_shop,$shops_tmp))?'checked="checked"':'').' 
								   class="input_shop" 
								   />
								'.$name_shop.'';
				
				$_html .= '</label>
						</td>
					</tr>';
		 $u++;
		}
	
		$_html .= '</table>';
			
		$_html .= '</div>';
																
    	}
    	// shop association
			
    	
    		$_html .= '<label>&nbsp;</label>
						<div class = "margin-form"  style="margin-top:10px">
						<input type="button" value="'.$this->l('Cancel').'" 
                		   class="button"  
                		   onclick="$(\'#link-add-news-form\').show(200);$(\'#add-news-form\').hide(200);" 
                		   />&nbsp;&nbsp;&nbsp;
						<input type="submit" name="submit_item_n" value="'.$this->l('Save').'" 
                		   class="button"  />
                		  </div>';
    		
    		$_html .= '</form>';
    		$_html .= '</div>';
		
    		$_html .= '<br/>';
    		
			$_html .= '<table class = "table" width = 100%>
			<tr>
				<th width="5%">'.$this->l('ID').'</th>
				<th width="10%">'.$this->l('Image').'</th>';
			
			if($this->_is15){
					$_html .= '<th width=100>'.$this->l('Shop').'</th>';
    			}
				$_html .= '<th width=50>'.$this->l('Language').'</th>';
			
			$_html .= '<th>'.$this->l('Title').'</th>
				<th width="20%">'.$this->l('Date').'</th>
				<th width="5%">'.$this->l('Status').'</th>
				<th width = "7%">'.$this->l('Action').'</th>
			</tr>';
			
			$start = (int)Tools::getValue("pageitems_n");
			$_data = $obj_blocknews->getItems(array('admin'=>1,'start' => $start,'step'=>$this->_step));
			$_items = $_data['items'];
			
			$paging = $obj_blocknews->PageNav($start,$_data['count_all'],$this->_step, 
											array('admin' => 1,'currentIndex'=>$currentIndex,
												  'token' => $token,
												  'item' => 'items'
											));
			
			if(sizeof($_items)>0){
				
				foreach($_items as $_item){
					//echo "<pre>"; var_dump($_item);
					$i=1;
					$id = $_item['id'];
					$title = $_item['title'];
					$img = $_item['img'];
					$status = $_item['status'];
					$date = $_item['time_add'];
					
				$ids_lng = isset($_item['ids_lng'])?$_item['ids_lng']:array();
				$lang_for_item = array();
				foreach($ids_lng as $lng_id){
					$data_lng = Language::getLanguage($lng_id);
					$lang_for_item[] = $data_lng['iso_code']; 
				}
				$lang_for_item = implode(",",$lang_for_item);
	
				if($this->_is15){
					$ids_shops = explode(",",$_item['ids_shops']);
					
					$shops = Shop::getShops();
					$name_shop = array();
					foreach($shops as $_shop){
						$id_shop_lists = $_shop['id_shop'];
						if(in_array($id_shop_lists,$ids_shops))
							$name_shop[] = $_shop['name'];
					}
					$name_shop = implode(",<br/>",$name_shop);
				}
			
					$_html .= 
						'<tr>
						<td style = "color:black;">'.$id.'</td>';
					
					$_html .= '<td style = "color:black;" align="center">';
					
					if($img)
						$_html .= '<img src="../upload/blocknews/'.$img.'" style="width:40px;height:40px" />';
					else
						$img = '&nbsp;';
					$_html .= '</td>';
					
					
					if($this->_is15){
						$_html .= '<td style = "color:black;">'.$name_shop.'</td>';
					}
					$_html .= '<td style = "color:black;">'.$lang_for_item.'</td>';
					
					
					$_html .= '<td style = "color:black;">'.$title.'</td>';
					$_html .= '<td style = "color:black;">'.$date.'</td>';
					if($status)
						$_html .= '<td align="center"><img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif"></td>';
					else
						$_html .= '<td align="center"><img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif"></td>';
				
			
					$_html .= '<td>
				
								 <input type = "hidden" name = "id" value = "'.$id.'"/>
								 <a href="'.$currentIndex.'&configure='.$this->name.'&token='.$token.'&edit_item_n&id='.(int)($id).'&pageitems='.$start.'" title="'.$this->l('Edit').'"><img src="'._PS_ADMIN_IMG_.'edit.gif" alt="" /></a> 
								 <a href="'.$currentIndex.'&configure='.$this->name.'&token='.$token.'&delete_item_n&id='.(int)($id).'&pageitems='.$start.'" title="'.$this->l('Delete').'"  onclick = "javascript:return confirm(\''.$this->l('Are you sure you want to remove this item?').'\');"><img src="'._PS_ADMIN_IMG_.'delete.gif" alt="" /></a>'; 
								 $_html .= '</form>
							 </td>';
					$_html .= '</tr>';
				}
			} else {
			$_html .= '<tr><td colspan="8" style="text-align:center;font-weight:bold;padding:10px">'.$this->l('Items not found').'</td></tr>';	
			}
			
			$_html .= '</table>';
		}
			
		     if($i!=0){
		    	$_html .= '<div style="margin:5px">';
		    	$_html .= $paging;
		    	$_html .= '</div>';
		    	}
		
		$_html .=	'</fieldset>'; 
		
		
     	return $_html;
    }
    
    
 private function _drawNewsSettings(){
 		$cookie = $this->context->cookie;
		
    	global $currentIndex;
     	$_html = '';
		$_html .= '<form action="'.$_SERVER['REQUEST_URI'].'" method="post" >';
		
		$_html .= '
		<fieldset>
					<legend><img src="../modules/'.$this->name.'//img/logo-news.gif"  />
					'.$this->l('News Settings').':</legend>';
		
		$_html .= '<table style="width:100%">';
    	
    	
    	$_html .= '<tr>';
    	$_html .= '<td style="text-align:right;width:40%;padding:0 20px 0 0">';
    	
    	$_html .= '<b>'.$this->l('Enable or Disable News').':</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td class="r-set">';
    	$_html .=  '
					<input type="radio" value="1" id="text_list_on" name="newson" onclick="enableOrDisablenewson(1)"
							'.(Tools::getValue('newson', Configuration::get($this->name.'newson')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					<input type="radio" value="0" id="text_list_off" name="newson" onclick="enableOrDisablenewson(0)"
						   '.(!Tools::getValue('newson', Configuration::get($this->name.'newson')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
				';
		
    	$_html .= '</div>';
    	
		$_html .= '<script type="text/javascript">
			    	function enableOrDisablenewson(id)
						{
						if(id==0){
							$("#block-newson-settings").hide(200);
						} else {
							$("#block-newson-settings").show(200);
						}
							
						}
					</script>';
    	
		$_html .= '</td>';
		$_html .= '</tr>';
		$_html .= '</table>';
    	
		$_html .= '<div id="block-newson-settings" '.(Configuration::get($this->name.'newson')==1?'style="display:block"':'style="display:none"').'>';
    	
		
		
		$_html .= '<table class="table-settings" style="width:100%">';
    	
		
		$_html .= '<tr>';
    	$_html .= '<td style="text-align:right;width:40%;padding:0 20px 0 0">';
    	
    	$_html .= '<b>'.$this->l('News per Page:').'</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td style="text-align:left">';
		$_html .=  '
					<input type="text" name="nperpage_posts"  
			               value="'.Tools::getValue('nperpage_posts', Configuration::get($this->name.'nperpage_posts')).'"
			               >
				';
		$_html .= '</td>';
		$_html .= '</tr>';
		
		$_html .= '<tr>';
    	$_html .= '<td style="text-align:right;width:35%;padding:0 20px 0 0">';
    	
    	$_html .= '<b>'.$this->l('The number of items in the "Block Last News":').'</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td style="text-align:left">';
		$_html .=  '
					<input type="text" name="nfaq_blc"  
			               value="'.Tools::getValue('nfaq_blc', Configuration::get($this->name.'nfaq_blc')).'"
			               >
				';
		$_html .= '</td>';
		$_html .= '</tr>';
		
		
		
		####
		$_html .= '<tr>';
    	$_html .= '<td style="text-align:right;width:40%;padding:0 20px 0 0">';
    	
		$_html .= '<b>'.$this->l('Position Block Last News:').'</b>';
		
		$_html .= '</td>';
    	$_html .= '<td style="text-align:left">';
		
				//$_html .= '<div class="margin-form choose_hooks">';
	    		$_html .= '<table style="width:66%;">
	    				<tr>
	    					<td style="width: 33%">'.$this->l('Left Column').'</td>
	    					<td style="width: 33%">'.$this->l('Right Column').'</td>
	    					
	    				</tr>
	    				<tr>
	    					<td>
	    						<input type="checkbox" name="news_left" '.((Tools::getValue($this->name.'news_left', Configuration::get($this->name.'news_left')) ==1)?'checked':'').'  value="1"/>
	    					</td>
	    					<td>
	    						<input type="checkbox" name="news_right" '.((Tools::getValue($this->name.'news_right', Configuration::get($this->name.'news_right')) ==1)?'checked':'') .' value="1"/>
	    					</td>
	    					
	    				</tr>
	    				<tr>
	    					<td>'.$this->l('Footer').'</td>
	    					<td>'.$this->l('Home').'</td>
	    					
	    				</tr>
	    				<tr>
	    					<td>
	    						<input type="checkbox" name="news_footer" '.((Tools::getValue($this->name.'news_footer', Configuration::get($this->name.'news_footer')) ==1)?'checked':'').' value="1"/>
	    					</td>
	    					<td>
	    						<input type="checkbox" name="news_home" '.((Tools::getValue($this->name.'news_home', Configuration::get($this->name.'news_home')) ==1)?'checked':'').' value="1"/>
	    					</td>
	    					
	    				</tr>
	    				
	    			</table>';
	    //$_html .= '</div>';
		$_html .= '</td>';
		$_html .= '</tr>';
				
		###
		
		
    	$_html .= '</table>';
    	
    	
    	$_html .= '</div>';
			
			$_html .= '<p class="center" style="text-align:center;border: 1px solid #EBEDF4; padding: 10px; margin-top: 10px;">
					<input type="submit" name="submit_news" value="'.$this->l('Update settings').'" 
                		   class="button"  />
                	</p>';
					
					
		$_html .= '</fieldset>	';
		$_html .= '</form>';
		
		
		return $_html;
    }
    
    
	private function _drawSettingsGuestbook(){
		$cookie = $this->context->cookie;
		
    	global $currentIndex;
    	
    	$_html = '';
    	$_html .= '<fieldset>
					<legend><img src="../modules/'.$this->name.'/img/logo-blockguestbook.gif" />'
    				.$this->l('Guestbook Settings').':</legend>';
    	$_html .= '
        <form action="'.$_SERVER['REQUEST_URI'].'" method="post">';
    	
    	
    	$_html .= '<table style="width:100%">';
    	
    	
    	$_html .= '<tr>';
    	$_html .= '<td style="text-align:right;width:35%;padding:0 20px 0 0">';
    	
    	$_html .= '<b>'.$this->l('Enable or Disable Guestbook').':</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td class="r-set">';
    	$_html .=  '
					<input type="radio" value="1" id="text_list_on" name="guon" onclick="enableOrDisableguon(1)"
							'.(Tools::getValue('guon', Configuration::get($this->name.'guon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					<input type="radio" value="0" id="text_list_off" name="guon" onclick="enableOrDisableguon(0)"
						   '.(!Tools::getValue('guon', Configuration::get($this->name.'guon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
				';
		
    	$_html .= '</div>';
    	
		$_html .= '<script type="text/javascript">
			    	function enableOrDisableguon(id)
						{
						if(id==0){
							$("#block-guon-settings").hide(200);
						} else {
							$("#block-guon-settings").show(200);
						}
							
						}
					</script>';
    	
		$_html .= '</td>';
		$_html .= '</tr>';
		$_html .= '</table>';
    	
		$_html .= '<div id="block-guon-settings" '.(Configuration::get($this->name.'guon')==1?'style="display:block"':'style="display:none"').'>';
    	
    	
    	$_html .= '<table class="table-settings" style="width:100%">';
    		
    	/*$_html .= '<tr>';
    	$_html .= '<td style="text-align:right;width:30%;padding:0 20px 0 0">';
    	
    	$_html .= '<b>'.$this->l('Position Messages Block:').'</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td style="text-align:left">';
		$_html .=  '
					<select class="select" name="gposition" 
							id="gposition">
						<option '.(Tools::getValue('gposition', Configuration::get($this->name.'gposition'))  == "left" ? 'selected="selected" ' : '').' value="left">'.$this->l('Left').'</option>
						<option '.(Tools::getValue('gposition', Configuration::get($this->name.'gposition')) == "right" ? 'selected="selected" ' : '').' value="right">'.$this->l('Right').'</option>
						<option '.(Tools::getValue('gposition', Configuration::get($this->name.'gposition')) == "home" ? 'selected="selected" ' : '').' value="home">'.$this->l('Home').'</option>
						<option '.(Tools::getValue('gposition', Configuration::get($this->name.'gposition')) == "footer" ? 'selected="selected" ' : '').' value="footer">'.$this->l('Footer').'</option>
						<option '.(Tools::getValue('gposition', Configuration::get($this->name.'gposition')) == "none" ? 'selected="selected" ' : '').' value="none">'.$this->l('None').'</option>
						
					</select>
				';
		$_html .= '</td>';
		$_html .= '</tr>';*/
    	
    	$_html .= '<tr>';
    	$_html .= '<td style="text-align:right;width:30%;padding:0 20px 0 0">';
    	
		$_html .= '<b>'.$this->l('Position Messages Block:').'</b>';
		
		$_html .= '</td>';
    	$_html .= '<td style="text-align:left">';
		
				$_html .= '<table style="width:66%;">
	    				<tr>
	    					<td style="width: 33%">'.$this->l('Left Column').'</td>
	    					<td style="width: 33%">'.$this->l('Right Column').'</td>
	    					
	    				</tr>
	    				<tr>
	    					<td>
	    						<input type="checkbox" name="g_left" '.((Tools::getValue($this->name.'g_left', Configuration::get($this->name.'g_left')) ==1)?'checked':'').'  value="1"/>
	    					</td>
	    					<td>
	    						<input type="checkbox" name="g_right" '.((Tools::getValue($this->name.'g_right', Configuration::get($this->name.'g_right')) ==1)?'checked':'') .' value="1"/>
	    					</td>
	    					
	    				</tr>
	    				<tr>
	    					<td>'.$this->l('Footer').'</td>
	    					<td>'.$this->l('Home').'</td>
	    					
	    				</tr>
	    				<tr>
	    					<td>
	    						<input type="checkbox" name="g_footer" '.((Tools::getValue($this->name.'g_footer', Configuration::get($this->name.'g_footer')) ==1)?'checked':'').' value="1"/>
	    					</td>
	    					<td>
	    						<input type="checkbox" name="g_home" '.((Tools::getValue($this->name.'g_home', Configuration::get($this->name.'g_home')) ==1)?'checked':'').' value="1"/>
	    					</td>
	    					
	    				</tr>
	    				
	    			</table>';
	    //$_html .= '</div>';
		$_html .= '</td>';
		$_html .= '</tr>';
		
		$_html .= '<tr>';
    	$_html .= '<td style="text-align:right;width:30%;padding:0 20px 0 0">';
    	
    	$_html .= '<b>'.$this->l('Messages per Page:').'</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td style="text-align:left">';
		$_html .=  '
					<input type="text" name="gperpage"  
			               value="'.Tools::getValue('gperpage', Configuration::get($this->name.'gperpage')).'"
			               >
				';
		$_html .= '</td>';
		$_html .= '</tr>';
		
		$_html .= '<tr>';
    	$_html .= '<td style="text-align:right;width:35%;padding:0 20px 0 0">';
    	
    	$_html .= '<b>'.$this->l('The number of items in the "Block Guestbook":').'</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td style="text-align:left">';
		$_html .=  '
					<input type="text" name="gbook_blc"  
			               value="'.Tools::getValue('gbook_blc', Configuration::get($this->name.'gbook_blc')).'"
			               >
				';
		$_html .= '</td>';
		$_html .= '</tr>';
		
		$_html .= '<tr>';
    	$_html .= '<td style="text-align:right;width:35%;padding:0 20px 0 0">';
    	
    	$_html .= '<b>'.$this->l('Enable Captcha on submit form').':</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td style="text-align:left">';
		$_html .=  '
					<input type="radio" value="1" id="text_list_on" name="gis_captcha"
							'.(Tools::getValue('gis_captcha', Configuration::get($this->name.'gis_captcha')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					<input type="radio" value="0" id="text_list_off" name="gis_captcha"
						   '.(!Tools::getValue('gis_captcha', Configuration::get($this->name.'gis_captcha')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
				';
		$_html .= '</td>';
		$_html .= '</tr>';
		
		$_html .= '<tr>';
    	$_html .= '<td style="text-align:right;width:30%;padding:0 20px 0 0">';
    	
    	$_html .= '<b>'.$this->l('Admin email:').'</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td style="text-align:left">';
		$_html .=  '
					<input type="text" name="gmail"  
			               value="'.Tools::getValue('gmail', Configuration::get($this->name.'gmail')).'"
			               >
				';
		$_html .= '</td>';
		$_html .= '</tr>';
		
		$_html .= '<tr>';
    	$_html .= '<td style="text-align:right;width:30%;padding:0 20px 0 0">';
    	
    	$_html .= '<b>'.$this->l('E-mail notification:').'</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td style="text-align:left">';
		$_html .= '<input type = "checkbox" name = "gnoti" id = "gnoti" value ="1" '.((Tools::getValue($this->name.'gnoti', Configuration::get($this->name.'gnoti')) ==1)?'checked':'').'/>';
		$_html .= '</td>';
		$_html .= '</tr>';
		
		
		$_html .= '</table>';
		
		$_html .= '</div>';
    	
    	$_html .= '<p class="center" style="text-align:center;border: 1px solid #EBEDF4; padding: 10px; margin-top: 10px;">
					<input type="submit" name="submit_guestbook" value="'.$this->l('Update settings').'" 
                		   class="button"  />
                	</p>';
   		$_html .= '</form>';
    	$_html .=	'</fieldset>';
    	
    	
    	
    	return $_html;
		
    }
    
public function drawGuestbookMessages($data = null){
		$cookie = $this->context->cookie;
		
		global $currentIndex;
		
		$currentIndex = isset($data['currentindex'])?$data['currentindex']:$currentIndex;
    	$controller = isset($data['controller'])?$data['controller']:'AdminModules';
    	$token = isset($data['token'])?$data['token']:Tools::getAdminToken($controller.intval(Tab::getIdFromClassName($controller)).intval($cookie->id_employee));
    	
    	$_html = '';
    	
    	$_html .= '<br/><br/>';
    	
    	$_html .= '<fieldset>
					<legend><img src="../modules/'.$this->name.'/img/logo-blockguestbook.gif" />
					'.$this->l('Moderate Messages').'</legend>';
    	
    	include_once(dirname(__FILE__).'/classes/guestbook.class.php');
		$obj_guestbook = new guestbook();
				
    	if(Tools::isSubmit("edit_item_g")){
    		$_data = $obj_guestbook->getItem(array('id'=>(int)Tools::getValue("id")));
    		
    		$_html .= '
    					<form action="'.$_SERVER['REQUEST_URI'].'" method="post">';
    		
    		//echo "<pre>"; var_dump($_data); exit;
    		$name = $_data['reviews'][0]['name'];
    		$email = $_data['reviews'][0]['email'];
    		$ip = $_data['reviews'][0]['ip'];
    		$message = $_data['reviews'][0]['message'];
    		$date = $_data['reviews'][0]['date_add'];
    		$active = $_data['reviews'][0]['active'];
    		$id = $_data['reviews'][0]['id'];
    		
    		$lang = $_data['reviews'][0]['id_lang'];
    		$data_lng = Language::getLanguage($lang);
			$lang_for_testimonial = $data_lng['iso_code'];

			if($this->_is15){
				$id_shop = $_data['reviews'][0]['id_shop'];
				
				$shops = Shop::getShops();
				$name_shop = '';
				foreach($shops as $_shop){
					$id_shop_lists = $_shop['id_shop'];
					if($id_shop == $id_shop_lists)
						$name_shop = $_shop['name'];
				}
			}
    		
    		$_html .= '<label>'.$this->l('ID').':</label>';
    		$_html .= '<div style="padding:0 0 1em 210px;line-height:1.6em;">'.$id.'</div>';
    		
    		if($this->_is15){
    			$_html .= '<label>'.$this->l('Shop').'</label>
    					<div class="margin-form">
							'.$name_shop.'
						</div>';
			}
			$_html .= '<label>'.$this->l('Language').'</label>
    					<div class="margin-form">
							'.$lang_for_testimonial.'
						</div>';
    		
    		$_html .= '<label>'.$this->l('Name').':</label>
    					<div class="margin-form">
							<input type="text" name="name"  style="width:200px"
			                	   value="'.$name.'">
						</div>';
    		$_html .= '<label>'.$this->l('Email').':</label>
    					<div class="margin-form">
							<input type="text" name="email"  style="width:200px"
			                	   value="'.$email.'">
						</div>';
    	
    		$_html .= '<label>'.$this->l('Message').':</label>
    					<div class="margin-form">
							<textarea name="message" cols="50" rows="10"  
			                	   >'.$message.'</textarea>
						</div>';
    		
    		$_html .= '<label>'.$this->l('Date Add').':</label>';
    		$_html .= '<div style="padding:0 0 1em 210px;line-height:1.6em;">'.$date.'</div>';
    		
    		
    		$_html .= '
				<label>'.$this->l('Publish').'</label>
				<div class = "margin-form" >';
				
			$_html .= '<input type = "checkbox" name = "publish" id = "publish" value ="1" '.(($active ==1)?'checked':'').'/>';
				
			$_html .= '</div>';
				
			$_html .= '<label>&nbsp;</label>
						<div class = "margin-form"  style="margin-top:20px">
						<input type="submit" name="cancel_item_g" value="'.$this->l('Cancel').'" 
                		   class="button"  />&nbsp;&nbsp;&nbsp;
						<input type="submit" name="submit_item_g" value="'.$this->l('Save').'" 
                		   class="button"  />
                		  </div>';
			
    		$_html .= '</form>';
			
    		
    	} else {
    	
    	
    	$_html .= '<table class = "table" width = 100%>
			<tr>
				<th>'.$this->l('No.').'</th>';
    	
    	$_html .= '<th width = 50>'.$this->l('Lang').'</th>';
    		
    	if($this->_is15){
    		$_html .= '<th width = 100>'.$this->l('Shop').'</th>';
    	}
    	
		$_html .= '<th>'.$this->l('Name').'</th>
				<th width = 100>'.$this->l('Email').'</th>
				<th width = 100>'.$this->l('IP').'</th>
				<th width = "300">'.$this->l('Message').'</th>
				<th>'.$this->l('Date').'</th>
				<th>'.$this->l('Published').'</th>
				<th width = "44">'.$this->l('Action').'</th>
			</tr>';
    	
    	$name_module = $this->name;
		$start = (int)Tools::getValue("page_g");
		
		$_data = $obj_guestbook->getItems(array('start'=>$start,'step'=>$this->_step,'admin' => 1));

		$_data_translate = $this->translateItems();
		$page_translate = $_data_translate['page']; 

		$paging = $obj_guestbook->PageNav($start,$_data['count_all_reviews'],$this->_step, 
											array('admin' => 1,'currentIndex'=>$currentIndex,
												  'token' => $token,
												 'page'=>$page_translate)
											);
    	$i=0;
    	if(sizeof($_data['reviews'])>0){
		foreach($_data['reviews'] as $_item){
			$i++;
			$id = $_item['id'];
			$name = $_item['name'];
			$email = $_item['email'];
			$ip = $_item['ip'];
			$message = $_item['message'];
			$date = $_item['date_add'];
			$active = $_item['active'];
			
			$lang = $_item['id_lang'];
    		$data_lng = Language::getLanguage($lang);
			$lang_for_testimonial = $data_lng['iso_code'];

			if($this->_is15){
				$id_shop = $_data['reviews'][0]['id_shop'];
				
				$shops = Shop::getShops();
				$name_shop = '';
				foreach($shops as $_shop){
					$id_shop_lists = $_shop['id_shop'];
					if($id_shop == $id_shop_lists)
						$name_shop = $_shop['name'];
				}
			}
			
			$_html .= 
			'<tr>
			<td style = "color:black;">'.$id.'</td>';
			
			$_html .= '<td style="color:black">'.$lang_for_testimonial.'</td>';
	
			if($this->_is15){
				$_html .= '<td style="color:black">'.$name_shop.'</td>';
			}
			
		$_html .= '<td style = "color:black;">'.$name.'</td>
			<td style = "color:black;">'.$email.'</td>
			<td style = "color:black;">'.$ip.'</td>';
			
			$_html .= '<td style = "color:black;">'.(strlen($message)>50?substr($message,0,50)."...":$message).'</td>
			<td style = "color:black;">'.$date.'</td>';
			
			$_html .= '
			<td style = "color:black;text-align:center;">
			 <form action = "'.$_SERVER['REQUEST_URI'].'" method = "POST">';
			 if ($active == 1) {
					$_html .= '<input type = "submit" name = "unpublished_g" value = "Unpublish" class = "button unpublished"/>';
				 }
				 else{
					$_html .= '<input type = "submit" name = "published_g" value = "Publish" class = "button published"/>';
				 }
			$_html .= '</td>
			<td>
				
				 <input type = "hidden" name = "id" value = "'.$id.'"/>
				 <a href="'.$currentIndex.'&configure='.$this->name.'&token='.$token.'&edit_item_g&id='.(int)($id).'" title="'.$this->l('Edit').'"><img src="'._PS_ADMIN_IMG_.'edit.gif" alt="" /></a> 
				 <a href="'.$currentIndex.'&configure='.$this->name.'&token='.$token.'&delete_item_g&id='.(int)($id).'" title="'.$this->l('Delete').'"  onclick = "javascript:return confirm(\''.$this->l('Are you sure you want to remove this item?').'\');"><img src="'._PS_ADMIN_IMG_.'delete.gif" alt="" /></a>'; 
				 $_html .= '</form>
			 </td>
			 </tr>';
			
			$_html .= '</tr>';
		}
    	
    	} else {
			$_html .= '<tr><td colspan="10" style="text-align:center;font-weight:bold;padding:10px">
			'.$this->l('Messages not found').'</td></tr>';	
			
		}
		
    	$_html .= '</table>
						';
    	if($i!=0){
    	$_html .= '<div style="margin:5px">';
    	$_html .= $paging;
    	$_html .= '</div>';
    	}
    	}
    	
    	
    	$_html .=	'</fieldset>'; 
		
		return $_html;
    }
    
    
 public function drawFAQCategories($data=null){
    	$cookie = $this->context->cookie;
    	
    	global $currentIndex;
     	
    	$currentIndex = isset($data['currentindex'])?$data['currentindex']:$currentIndex;
    	$controller = isset($data['controller'])?$data['controller']:'AdminModules';
    	$token = isset($data['token'])?$data['token']:Tools::getAdminToken($controller.intval(Tab::getIdFromClassName($controller)).intval($cookie->id_employee));
    	
    	
     	$_html = '';
		
		
		//faq operations
		
		$_html .= '<fieldset>
					<legend><img src="../modules/'.$this->name.'/img/logo-faq.gif" />
					'.$this->l('Moderate FAQ Categories').'</legend>';
		
		
		
		include_once(dirname(__FILE__).'/classes/blockfaqhelp.class.php');
		$obj_blockfaq = new blockfaqhelp();
		
		
		if(Tools::isSubmit("edit_item_faqcat")){
			$divLangName = "titlecat";
			$_data = $obj_blockfaq->getCategoryItem(array('id'=>(int)Tools::getValue("id"),'admin'=>1));
			
			$data_content = isset($_data['item']['data'])?$_data['item']['data']:'';
			$status = isset($_data['item'][0]['status'])?$_data['item'][0]['status']:'';
			
			$customer_email = isset($_data['item'][0]['customer_email'])?$_data['item'][0]['customer_email']:$this->_admin_email;
			$customer_name = isset($_data['item'][0]['customer_name'])?$_data['item'][0]['customer_name']:$this->l('admin');
			
			$faq_questions_association = isset($_data['item'][0]['faq_questions_ids'])?$_data['item'][0]['faq_questions_ids']:array();
			//var_dump($faq_questions_association);
			$_html .= '<form action="'.$_SERVER['REQUEST_URI'].'" method="post">';
    		
    		$_html .= '<label>'.$this->l('Category title').':</label>
    					<div class="margin-form">';
			
    		
    		$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
	    	$languages = Language::getLanguages(false);
	    	
	    	foreach ($languages as $language){
			$id_lng = (int)$language['id_lang'];
	    	$title = isset($data_content[$id_lng]['title'])?$data_content[$id_lng]['title']:"";
			
			$_html .= '	<div id="titlecat_'.$language['id_lang'].'" 
							 style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;"
							 >

						<input type="text" style="width:400px"   
								  id="titlecat_'.$language['id_lang'].'" 
								  name="titlecat_'.$language['id_lang'].'" 
								  value="'.htmlentities(stripslashes($title), ENT_COMPAT, 'UTF-8').'"/>
						</div>';
	    	}
			ob_start();
			$this->displayFlags($languages, $defaultLanguage, $divLangName, 'titlecat');
			$displayflags = ob_get_clean();
			$_html .= $displayflags;
    		$_html .= '<div style="clear:both"></div>';
    		
    		$_html .= '</div>';
    		
    		
    		
			$_data_cat = $obj_blockfaq->getItems();
			
	    	if(sizeof($_data_cat['items'])){
	    		
	    	$_html .= '<div class="clear"></div>';
	    	$_html .= '<label>'.$this->l('Select Questions (optional)').':</label>';
	    	
	    	$_html .=  '<div class="margin-form">';
	    	
	    	$_html .= '<select name="faq_questions_association[]" multiple size="10">';
	    	foreach($_data_cat['items'] as $item){
	    		$_html .= '<option value='.$item['id'].' '.(in_array($item['id'],$faq_questions_association)?'selected="true"':'').'>'.$item['title'].'</option>';	
	    	}
	    	
	    	$_html .= '</select>';
	    	
	    	$_html .= '</div>';
	    	
	    	}
	    	
	    	if($this->_is15){
	    	// shop association
	    	$_html .= '<div class="clear"></div>';
	    	$_html .= '<label>'.$this->l('Shop association').':</label>';
	    	$_html .= '<div class="margin-form">';
	
			$_html .= '<table width="50%" cellspacing="0" cellpadding="0" class="table">
							<tr>
								<th>Shop</th>
							</tr>';
			$u = 0;
			
			$shops = Shop::getShops();
			$shops_tmp = explode(",",isset($_data['item'][0]['ids_shops'])?$_data['item'][0]['ids_shops']:"");
			
			$count_shops = sizeof($shops);
			foreach($shops as $_shop){
				$id_shop = $_shop['id_shop'];
				$name_shop = $_shop['name'];
				 $_html .= '<tr>
							<td>
								<img src="../img/admin/lv2_'.((($count_shops-1)==$u)?"f":"b").'.png" alt="" style="vertical-align:middle;">
								<label class="child">';
			 
				
					$_html .= '<input type="checkbox"  
									   name="faq_shop_association[]" 
									   value="'.$id_shop.'" '.((in_array($id_shop,$shops_tmp))?'checked="checked"':'').' 
									   class="input_shop" 
									   />
									'.$name_shop.'';
					
					$_html .= '</label>
							</td>
						</tr>';
			 $u++;
			}
		
			$_html .= '</table>';
				
			$_html .= '</div>';
																	
	    	}
	    	// shop association
	    	
	    	
	    	
	    	
	    	$_html .= '<label>'.$this->l('Status').'</label>
				<div class = "margin-form">';
				
			$_html .= '<select name="faq_cat_status" style="width:100px">
						<option value=1 '.(($status==1)?"selected=\"true\"":"").'>'.$this->l('Enabled').'</option>
						<option value=0 '.(($status==0)?"selected=\"true\"":"").'>'.$this->l('Disabled').'</option>
					   </select>';
			
				
			$_html .= '</div>';
    	
    		$_html .= '<label>&nbsp;</label>
						<div class = "margin-form"  style="margin-top:10px">
						<input type="submit" name="cancel_item_faq_cat" value="'.$this->l('Cancel').'" 
                		   class="button"  />&nbsp;&nbsp;&nbsp;
						<input type="submit" name="update_item_faq_cat" value="'.$this->l('Update').'" 
                		   class="button"  />
                		  </div>';
    		
    		$_html .= '</form>';
    		
		}else{
			$divLangName = "titlecat";
			$status = 1;
			$name = "";
			$content = "";
			
			
    		$_html .= '<a href="javascript:void(0)" onclick="$(\'#add-cat-form\').show(200);$(\'#link-add-cat-form\').hide(200)"
    					id="link-add-cat-form"	
					  style="border: 1px solid rgb(222, 222, 222); padding: 5px; margin-bottom: 10px; display: block; font-size: 16px; color: maroon; text-align: center; font-weight: bold; text-decoration: underline;"
					  >'.$this->l('Add New FAQ Category').'</a>';
    		
    		$_html .= '<div style="border: 1px solid rgb(222, 222, 222);padding-top:10px;display:none" id="add-cat-form">';
			$_html .= '<form action="'.$_SERVER['REQUEST_URI'].'" method="post">';
    		
    		$_html .= '<label>'.$this->l('Category title').':</label>
    					<div class="margin-form">';
			
    		
    		$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
	    	$languages = Language::getLanguages(false);
	    	
	    	foreach ($languages as $language){
			$id_lng = (int)$language['id_lang'];
	    	
			$_html .= '	<div id="titlecat_'.$language['id_lang'].'" 
							 style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;"
							 >

						<input type="text" style="width:400px"   
								  id="titlecat_'.$language['id_lang'].'" 
								  name="titlecat_'.$language['id_lang'].'" 
								  value="'.htmlentities(stripslashes($name), ENT_COMPAT, 'UTF-8').'"/>
						</div>';
	    	}
			ob_start();
			$this->displayFlags($languages, $defaultLanguage, $divLangName, 'titlecat');
			$displayflags = ob_get_clean();
			$_html .= $displayflags;
			$_html .= '<div style="clear:both"></div>';
    		
    		$_html .= '</div>';
    		
    		
			$_data_cat = $obj_blockfaq->getItems();
	    	if(sizeof($_data_cat['items'])){
	    		
	    	$_html .= '<div class="clear"></div>';
	    	$_html .= '<label>'.$this->l('Select Questions (optional)').':</label>';
	    	
	    	$_html .=  '<div class="margin-form">';
	    	
	    	$_html .= '<select name="faq_questions_association[]" multiple size="10">';
	    	foreach($_data_cat['items'] as $item){
	    		$_html .= '<option value='.$item['id'].'>'.$item['title'].'</option>';	
	    	}
	    	
	    	$_html .= '</select>';
	    	
	    	$_html .= '</div>';
	    	
	    	}
    		
	    	
	    	if($this->_is15){
	    	// shop association
	    	$_html .= '<div class="clear"></div>';
	    	$_html .= '<label>'.$this->l('Shop association').':</label>';
	    	$_html .= '<div class="margin-form">';
	
			$_html .= '<table width="50%" cellspacing="0" cellpadding="0" class="table">
							<tr>
								<th>Shop</th>
							</tr>';
			$u = 0;
			
			$shops = Shop::getShops();
			$shops_tmp = explode(",",isset($_data['item'][0]['ids_shops'])?$_data['item'][0]['ids_shops']:"");
			
			$count_shops = sizeof($shops);
			foreach($shops as $_shop){
				$id_shop = $_shop['id_shop'];
				$name_shop = $_shop['name'];
				 $_html .= '<tr>
							<td>
								<img src="../img/admin/lv2_'.((($count_shops-1)==$u)?"f":"b").'.png" alt="" style="vertical-align:middle;">
								<label class="child">';
			 
				
					$_html .= '<input type="checkbox"  
									   name="faq_shop_association[]" 
									   value="'.$id_shop.'" '.((in_array($id_shop,$shops_tmp))?'checked="checked"':'').' 
									   class="input_shop" 
									   />
									'.$name_shop.'';
					
					$_html .= '</label>
							</td>
						</tr>';
			 $u++;
			}
		
			$_html .= '</table>';
				
			$_html .= '</div>';
																	
	    	}
	    	// shop association
	    	
	    	
	    	$_html .= '<label>'.$this->l('Status').'</label>
				<div class = "margin-form">';
				
			$_html .= '<select name="faq_cat_status" style="width:100px">
					<option value=1 '.(($status==1)?"selected=\"true\"":"").'>'.$this->l('Enabled').'</option>
					<option value=0 '.(($status==0)?"selected=\"true\"":"").'>'.$this->l('Disabled').'</option>
				   </select>';
			
				
			$_html .= '</div>';
    	
    		$_html .= '<label>&nbsp;</label>
						<div class = "margin-form"  style="margin-top:10px">
						<input type="button" value="'.$this->l('Cancel').'" 
                		   class="button"  
                		   onclick="$(\'#link-add-cat-form\').show(200);$(\'#add-cat-form\').hide(200);" 
                		   />&nbsp;&nbsp;&nbsp;
						<input type="submit" name="submit_item_faq_cat" value="'.$this->l('Save').'" 
                		   class="button"  />
                		  </div>';
    		
    		$_html .= '</form>';
    		$_html .= '</div>';
		
    		$_html .= '<br/>';
    		
			$_html .= '<table class = "table" width = 100%>
			<tr>
				<th width=50>'.$this->l('ID').'</th>
				<th width=100>'.$this->l('Lang').'</th>';
			
		
    		if($this->_is15){
    			$_html .= '<th width = 100>'.$this->l('Shop').'</th>';
    		}
    		
    		
			$_html .= '<th>'.$this->l('Category Title').'</th>';
			
			$_html .= '<th width=150>'.$this->l('Number of questions').'</th>';
    		
			
			//$_html .= '<th width=100>'.$this->l('Position').'</th>';
			
			
			
			$_html .= '<th width = "50">'.$this->l('Status').'</th>
				<th width = "50">'.$this->l('Action').'</th>
			</tr>';
			$_data = $obj_blockfaq->getItemsCategory(array('admin'=>1));
			$_items = $_data['items'];
			$count_stickers =  sizeof($_items);
			if($count_stickers>0){
				$i=0;
				foreach($_items as $_item){
					$sticker = $_items[$i];
					$id = $_item['id'];
					$title = $_item['title'];
					$status = $_items[$i]['status'];
					
					$count_faq = $_items[$i]['count_faq'];
					
					if($this->_is15){

						$id_shop = $_item['ids_shops'];
						$id_shop = explode(",",$id_shop);
						$shops = Shop::getShops();
						$name_shop = array();
						foreach($shops as $_shop){
							$id_shop_lists = $_shop['id_shop'];
							if(in_array($id_shop_lists,$id_shop))
								$name_shop[] = $_shop['name'];
						}
						$name_shop = implode(",",$name_shop);
					}
					
					$ids_lng = isset($_item['ids_lng'])?$_item['ids_lng']:array();
					$lang_for_faq = array();
					foreach($ids_lng as $lng_id){
						$data_lng = Language::getLanguage($lng_id);
						$lang_for_faq[] = $data_lng['iso_code']; 
					}
					$lang_for_faq = implode(",",$lang_for_faq);
					
					$_html .= 
						'<tr>
						<td style = "color:black;">'.$id.'</td>';
					$_html .= '<td style = "color:black;">'.$lang_for_faq.'</td>';
					
					if($this->_is15){
						$_html .= '<td style="color:black">'.$name_shop.'</td>';
					}
					
					$_html .= '<td style = "color:black;">'.$title.'</td>';
					
					$_html .= '<td style = "color:black;">'.$count_faq.'</td>';
					
					
					/*$_html .= '<td style = "color:black;">';
					if($i < $count_stickers - 1):
				$_html	.= '<a href="'.$currentIndex.'&configure='.$this->name.'&token='.$token.'
										&id_faqcat=' . $id . '
										&order_self_faqcat=' . $sticker['order_by'] . '
										&id_change_faqcat='. $_items[$i+1]['id'] . '
										&order_change_faqcat=' . $_items[$i+1]['order_by'].'">
								<img border="0" src="'.__PS_BASE_URI__.'img/admin/down.gif">
							</a>';
 					endif;
				if($i > 0):
				$_html	.= '<a href="'.$currentIndex.'&configure='.$this->name.'&token='.$token.'
								&id_faqcat=' .$id . '
								&order_self_faqcat=' . $sticker['order_by'] . '
								&id_change_faqcat='. $_items[$i-1]['id'] . '
								&order_change_faqcat=' . $_items[$i-1]['order_by'] .'"> 
								<img border="0" src="'.__PS_BASE_URI__.'img/admin/up.gif">
							</a>';
				endif;
					
					$_html .= '</td>';*/
					
					
				if($status)
					$_html .= '<td><img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif"></td>';
				else
					$_html .= '<td><img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif"></td>';
					
					
					$_html .= '<td>
				
								 <input type = "hidden" name = "id" value = "'.$id.'"/>
								 <a href="'.$currentIndex.'&configure='.$this->name.'&token='.$token.'&edit_item_faqcat&id='.(int)($id).'" title="'.$this->l('Edit').'"><img src="'._PS_ADMIN_IMG_.'edit.gif" alt="" /></a> 
								 <a href="'.$currentIndex.'&configure='.$this->name.'&token='.$token.'&delete_item_faqcat&id='.(int)($id).'" title="'.$this->l('Delete').'"  onclick = "javascript:return confirm(\''.$this->l('Are you sure you want to remove this item?').'\');"><img src="'._PS_ADMIN_IMG_.'delete.gif" alt="" /></a>'; 
								 $_html .= '</form>
							 </td>';
					$_html .= '</tr>';
					$i++;
				}
			} else {
			$_html .= '<tr><td colspan="7" style="text-align:center;font-weight:bold;padding:10px">
						'.$this->l('FAQ Categories not found').'</td></tr>';	
			}
			
			$_html .= '</table>';
		}
			
			
		
		$_html .=	'</fieldset>'; 
		
		
     	return $_html;
    }
    
     public function drawFaqItems($data = null){
    	$cookie = $this->context->cookie;
    	
    	
    	global $currentIndex;
     	
    	$currentIndex = isset($data['currentindex'])?$data['currentindex']:$currentIndex;
    	$controller = isset($data['controller'])?$data['controller']:'AdminModules';
    	$token = isset($data['token'])?$data['token']:Tools::getAdminToken($controller.intval(Tab::getIdFromClassName($controller)).intval($cookie->id_employee));
    	
    	
     	$_html = '';
     	
     	$_html .= '<br/><br/>';
     	
		$_html .= '<style type="text/css">
		fieldset.faqitems label{width:130px!important}
		fieldset.faqitems div.margin-form{padding: 0pt 0pt 10px 140px!important;}
		</style>';
		
		
		//faq operations
		
		$_html .= '<fieldset class="faqitems">
					<legend><img src="../modules/'.$this->name.'/img/logo-faq.gif" />
					'.$this->l('Moderate Questions').'</legend>';
		
		
		
		include_once(dirname(__FILE__).'/classes/blockfaqhelp.class.php');
		$obj_blockfaq = new blockfaqhelp();
		
		
		if(Tools::isSubmit("edit_item_q")){
			$divLangName = "ccontentfaq¤titlefaq";
			
			$_data = $obj_blockfaq->getItem(array('id'=>(int)Tools::getValue("id")));
			
			$data_content = isset($_data['item']['data'])?$_data['item']['data']:'';
			
			$status = isset($_data['item'][0]['status'])?$_data['item'][0]['status']:'';
			
			$is_by_customer = isset($_data['item'][0]['is_by_customer'])?$_data['item'][0]['is_by_customer']:0;
			
			$is_add_by_customer = isset($_data['item'][0]['is_add_by_customer'])?$_data['item'][0]['is_add_by_customer']:0;
			
			$customer_email = isset($_data['item'][0]['customer_email'])?$_data['item'][0]['customer_email']:$this->_admin_email;
			$customer_name = isset($_data['item'][0]['customer_name'])?$_data['item'][0]['customer_name']:$this->l('admin');
			
			$faq_category_association = isset($_data['item'][0]['faq_category_ids'])?$_data['item'][0]['faq_category_ids']:array();

			$_html .= '<form action="'.$_SERVER['REQUEST_URI'].'" method="post">';
    		$_html .= '<input type="hidden" value="'.$is_add_by_customer.'" name="is_add_by_customer"/>';
    		$_html .= '<label>'.$this->l('Question:').'</label>
    					<div class="margin-form">';
			
    		
    		$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
	    	$languages = Language::getLanguages(false);
	    	
	    	foreach ($languages as $language){
			$id_lng = (int)$language['id_lang'];
	    	$title = isset($data_content[$id_lng]['title'])?$data_content[$id_lng]['title']:"";
			
			$_html .= '	<div id="titlefaq_'.$language['id_lang'].'" 
							 style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;"
							 >

						<input type="text" style="width:400px"   
								  id="titlefaq_'.$language['id_lang'].'" 
								  name="titlefaq_'.$language['id_lang'].'" 
								  value="'.htmlentities(stripslashes($title), ENT_COMPAT, 'UTF-8').'"/>
						</div>';
	    	}
			ob_start();
			$this->displayFlags($languages, $defaultLanguage, $divLangName, 'titlefaq');
			$displayflags = ob_get_clean();
			$_html .= $displayflags;
    		$_html .= '<div style="clear:both"></div>';
    		
    		$_html .= '</div>';
    		
    		if(defined('_MYSQL_ENGINE_')){
	    	$_html .= '<label>'.$this->l('Answer:').'</label>
	    					<div class="margin-form" >';
			
	    	$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
	    	$languages = Language::getLanguages(false);
	    	
	    	foreach ($languages as $language){
	    	$id_lng = (int)$language['id_lang'];
	    	$content = isset($data_content[$id_lng]['content'])?$data_content[$id_lng]['content']:"";
			
			$_html .= '	<div id="ccontentfaq_'.$language['id_lang'].'" 
							 style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;"
							 >

						<textarea class="rte" cols="25" rows="10" style="width:400px"   
								  id="contentfaq_'.$language['id_lang'].'" 
								  name="contentfaq_'.$language['id_lang'].'">'.htmlentities(stripslashes($content), ENT_COMPAT, 'UTF-8').'</textarea>

					</div>';
	    	}
	    	
			ob_start();
			$this->displayFlags($languages, $defaultLanguage, $divLangName, 'ccontentfaq');
			$displayflags = ob_get_clean();
			$_html .= $displayflags;
	    	
			$_html .= '<div style="clear:both"></div>';
			
	    	
	    	$_html .= '</div>
						';
	    	}else{
	    		$_html .= '<label>'.$this->l('Answer').'</label>
	    					<div class="margin-form">';
				
	    		$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
		    	$languages = Language::getLanguages(false);
		    	$divLangName = "ccontentfaq";
		    	
		    	foreach ($languages as $language){
				$id_lng = (int)$language['id_lang'];
	    		$content = isset($data_content[$id_lng]['content'])?$data_content[$id_lng]['content']:"";
			
				$_html .= '	<div id="ccontentfaq_'.$language['id_lang'].'" 
								 style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;"
								 >
	
							<textarea class="rte" cols="25" rows="10" style="width:400px"   
									  id="contentfaq_'.$language['id_lang'].'" 
									  name="contentfaq_'.$language['id_lang'].'">'.htmlentities(stripslashes($content), ENT_COMPAT, 'UTF-8').'</textarea>
	
						</div>';
		    	}
				ob_start();
				$this->displayFlags($languages, $defaultLanguage, $divLangName, 'ccontentfaq');
				$displayflags = ob_get_clean();
				$_html .= $displayflags;
		    	
				$_html .= '<div style="clear:both"></div>';
	    		
	    		$_html .= '</div>
						';
	    	}
	    	
	    	
			$_data_cat = $obj_blockfaq->getItemsCategory(array('admin'=>1));
	    	if(sizeof($_data_cat['items'])){
	    		
	    	$_html .= '<div class="clear"></div>';
	    	$_html .= '<label>'.$this->l('Category association').':</label>';
	    	
	    	$_html .=  '<div class="margin-form">';
	    	
			
	    	$_html .= '<select name="faq_category_association[]" multiple size="10">';
	    	$_html .= '<option value=0>---</option>';	
	    	foreach($_data_cat['items'] as $item){
	    		
	    		
	    		$_html .= '<option value='.$item['id'].' '.(in_array($item['id'],$faq_category_association)?'selected="true"':'').'>'.$item['title'].'</option>';	
	    	}
	    	
	    	$_html .= '</select>';
	    	
	    	$_html .= '</div>';
	    	
	    	}
	    	
	    	if($this->_is15){
	    	// shop association
	    	$_html .= '<div class="clear"></div>';
	    	$_html .= '<label>'.$this->l('Shop association').':</label>';
	    	$_html .= '<div class="margin-form">';
	
			$_html .= '<table width="50%" cellspacing="0" cellpadding="0" class="table">
							<tr>
								<th>Shop</th>
							</tr>';
			$u = 0;
			
			$shops = Shop::getShops();
			$shops_tmp = explode(",",isset($_data['item'][0]['ids_shops'])?$_data['item'][0]['ids_shops']:"");
			
			$count_shops = sizeof($shops);
			foreach($shops as $_shop){
				$id_shop = $_shop['id_shop'];
				$name_shop = $_shop['name'];
				 $_html .= '<tr>
							<td>
								<img src="../img/admin/lv2_'.((($count_shops-1)==$u)?"f":"b").'.png" alt="" style="vertical-align:middle;">
								<label class="child">';
			 
				
					$_html .= '<input type="checkbox"  
									   name="faq_shop_association[]" 
									   value="'.$id_shop.'" '.((in_array($id_shop,$shops_tmp))?'checked="checked"':'').' 
									   class="input_shop" 
									   />
									'.$name_shop.'';
					
					$_html .= '</label>
							</td>
						</tr>';
			 $u++;
			}
		
			$_html .= '</table>';
				
			$_html .= '</div>';
																	
	    	}
	    	// shop association
	    	
	    	$_html .= '<label>'.$this->l('Show By customer').':</label>';
	    	
	    	$_html .=  '<div class="margin-form">
	    	
					<input type="radio" value="1" id="text_list_on" name="is_by_customer"
							'.($is_by_customer ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					<input type="radio" value="0" id="text_list_off" name="is_by_customer" 
						   '.(!$is_by_customer ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
				</div>';
	    	
	    	$_html .= '<label>'.$this->l('Customer email').':</label>
    			
    				<div class="margin-form">
					<input style="width:400px" type="text" name="faq_customer_email" size="128" value="'.$customer_email.'">
			        
			       </div>';
	    	
	    	
	    	$_html .= '<label>'.$this->l('Customer name').':</label>
    			
    				<div class="margin-form">
					<input style="width:400px" type="text" name="faq_customer_name" size="128" value="'.$customer_name.'">
			        
			       </div>';
	    	
	    	$_html .= '<label>'.$this->l('Status').'</label>
				<div class = "margin-form">';
				
			$_html .= '<select name="faq_item_status" style="width:100px">
						<option value=1 '.(($status==1)?"selected=\"true\"":"").'>'.$this->l('Enabled').'</option>
						<option value=0 '.(($status==0)?"selected=\"true\"":"").'>'.$this->l('Disabled').'</option>
					   </select>';
			
				
			$_html .= '</div>';
    	
    		$_html .= '<label>&nbsp;</label>
						<div class = "margin-form"  style="margin-top:10px">
						<input type="submit" name="cancel_item_q" value="'.$this->l('Cancel').'" 
                		   class="button"  />&nbsp;&nbsp;&nbsp;
						<input type="submit" name="update_item_q" value="'.$this->l('Update').'" 
                		   class="button"  />
                		  </div>';
    		
    		$_html .= '</form>';
    		
		}else{
			$divLangName = "ccontentfaq¤titlefaq";
			$name = "";
			$content = "";
			$status = 1;
			
			$customer_email = $this->_admin_email;
			$customer_name = $this->l('admin');
			$is_by_customer = 0;
			
			
    		$_html .= '<a href="javascript:void(0)" onclick="$(\'#add-question-form\').show(200);$(\'#link-add-question-form\').hide(200)"
    					id="link-add-question-form"	
					  style="border: 1px solid rgb(222, 222, 222); padding: 5px; margin-bottom: 10px; display: block; font-size: 16px; color: maroon; text-align: center; font-weight: bold; text-decoration: underline;"
					  >'.$this->l('Add New Question').'</a>';
    		
    		$_html .= '<div style="border: 1px solid rgb(222, 222, 222);padding-top:10px;display:none" id="add-question-form">';
			$_html .= '<form action="'.$_SERVER['REQUEST_URI'].'" method="post">';
    		
    		$_html .= '<label>'.$this->l('Question').':</label>
    					<div class="margin-form">';
			
    		
    		$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
	    	$languages = Language::getLanguages(false);
	    	
	    	foreach ($languages as $language){
			$id_lng = (int)$language['id_lang'];
	    	
			$_html .= '	<div id="titlefaq_'.$language['id_lang'].'" 
							 style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;"
							 >

						<input type="text" style="width:400px"   
								  id="titlefaq_'.$language['id_lang'].'" 
								  name="titlefaq_'.$language['id_lang'].'" 
								  value="'.htmlentities(stripslashes($name), ENT_COMPAT, 'UTF-8').'"/>
						</div>';
	    	}
			ob_start();
			$this->displayFlags($languages, $defaultLanguage, $divLangName, 'titlefaq');
			$displayflags = ob_get_clean();
			$_html .= $displayflags;
			$_html .= '<div style="clear:both"></div>';
    		
    		$_html .= '</div>';
    		
    		if(defined('_MYSQL_ENGINE_')){
	    	$_html .= '<label>'.$this->l('Answer').':</label>
	    					<div class="margin-form" >';
							
	    	
	    	
	    		$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
	    	$languages = Language::getLanguages(false);
	    	
	    	foreach ($languages as $language)

			$_html .= '	<div id="ccontentfaq_'.$language['id_lang'].'" 
							 style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;"
							 >

						<textarea class="rte" cols="25" rows="10" style="width:400px"   
								  id="contentfaq_'.$language['id_lang'].'" 
								  name="contentfaq_'.$language['id_lang'].'">'.htmlentities(stripslashes($content), ENT_COMPAT, 'UTF-8').'</textarea>

					</div>';
			ob_start();
			$this->displayFlags($languages, $defaultLanguage, $divLangName, 'ccontentfaq');
			$displayflags = ob_get_clean();
			$_html .= $displayflags;
			$_html .= '<div style="clear:both"></div>';
	    	
	    	$_html .= '</div>
						';
	    	}else{
	    		$_html .= '<label>'.$this->l('Answer').'</label>
	    					<div class="margin-form">';
	    		
				
	    		
	    		$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
	    	$languages = Language::getLanguages(false);
	    	
	    	foreach ($languages as $language)

			$_html .= '	<div id="ccontentfaq_'.$language['id_lang'].'" 
							 style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;"
							 >

						<textarea class="rte" cols="25" rows="10" style="width:400px"   
								  id="contentfaq_'.$language['id_lang'].'" 
								  name="contentfaq_'.$language['id_lang'].'">'.htmlentities(stripslashes($content), ENT_COMPAT, 'UTF-8').'</textarea>

					</div>';
			ob_start();
			$this->displayFlags($languages, $defaultLanguage, $divLangName, 'ccontentfaq');
			$displayflags = ob_get_clean();
			$_html .= $displayflags;
			$_html .= '<div style="clear:both"></div>';
				
				$_html .= '</div>
						';
	    	}
	    	
	    	
	    	$_data_cat = $obj_blockfaq->getItemsCategory(array('admin'=>1));
	    	if(sizeof($_data_cat['items'])){
	    		
	    	$_html .= '<div class="clear"></div>';
	    	$_html .= '<label>'.$this->l('Category association').':</label>';
	    	
	    	$_html .=  '<div class="margin-form">';
	    	
			//echo "<pre>"; var_dump($_data_cat); 
	    	
	    	$_html .= '<select name="faq_category_association[]" multiple size="10">';
	    	$_html .= '<option value=0 selected="true">---</option>';	
	    	foreach($_data_cat['items'] as $item){
	    		$_html .= '<option value='.$item['id'].'>'.$item['title'].'</option>';	
	    	}
	    	
	    	$_html .= '</select>';
	    	
	    	$_html .= '</div>';
	    	
	    	}
	    	
	    	if($this->_is15){
	    	// shop association
	    	$_html .= '<div class="clear"></div>';
	    	$_html .= '<label>'.$this->l('Shop association').':</label>';
	    	$_html .= '<div class="margin-form">';
	
			$_html .= '<table width="50%" cellspacing="0" cellpadding="0" class="table">
							<tr>
								<th>Shop</th>
							</tr>';
			$u = 0;
			
			$shops = Shop::getShops();
			$shops_tmp = explode(",",isset($_data['item'][0]['ids_shops'])?$_data['item'][0]['ids_shops']:"");
			
			$count_shops = sizeof($shops);
			foreach($shops as $_shop){
				$id_shop = $_shop['id_shop'];
				$name_shop = $_shop['name'];
				 $_html .= '<tr>
							<td>
								<img src="../img/admin/lv2_'.((($count_shops-1)==$u)?"f":"b").'.png" alt="" style="vertical-align:middle;">
								<label class="child">';
			 
				
					$_html .= '<input type="checkbox"  
									   name="faq_shop_association[]" 
									   value="'.$id_shop.'" '.((in_array($id_shop,$shops_tmp))?'checked="checked"':'').' 
									   class="input_shop" 
									   />
									'.$name_shop.'';
					
					$_html .= '</label>
							</td>
						</tr>';
			 $u++;
			}
		
			$_html .= '</table>';
				
			$_html .= '</div>';
																	
	    	}
	    	// shop association
	    	
	    	$_html .= '<label>'.$this->l('Show By customer').':</label>';
	    	
	    	$_html .=  '<div class="margin-form">
	    	
					<input type="radio" value="1" id="text_list_on" name="is_by_customer"
							'.($is_by_customer ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					<input type="radio" value="0" id="text_list_off" name="is_by_customer" 
						   '.(!$is_by_customer ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
				</div>';
	    	
	    	$_html .= '<label>'.$this->l('Customer email').':</label>
    			
    				<div class="margin-form">
					<input style="width:400px" type="text" name="faq_customer_email" size="128" value="'.$customer_email.'">
			        
			       </div>';
	    	
	    	
	    	$_html .= '<label>'.$this->l('Customer name').':</label>
    			
    				<div class="margin-form">
					<input style="width:400px" type="text" name="faq_customer_name" size="128" value="'.$customer_name.'">
			        
			       </div>';
	    	
	    	
	    	$_html .= '<label>'.$this->l('Status').'</label>
				<div class = "margin-form">';
				
			$_html .= '<select name="faq_item_status" style="width:100px">
						<option value=1 '.(($status==1)?"selected=\"true\"":"").'>'.$this->l('Enabled').'</option>
						<option value=0 '.(($status==0)?"selected=\"true\"":"").'>'.$this->l('Disabled').'</option>
					   </select>';
			
				
			$_html .= '</div>';
    	
    		$_html .= '<label>&nbsp;</label>
						<div class = "margin-form"  style="margin-top:10px">
						<input type="button" value="'.$this->l('Cancel').'" 
                		   class="button"  
                		   onclick="$(\'#link-add-question-form\').show(200);$(\'#add-question-form\').hide(200);" 
                		   />&nbsp;&nbsp;&nbsp;
						<input type="submit" name="submit_item_q" value="'.$this->l('Save').'" 
                		   class="button"  />
                		  </div>';
    		
    		$_html .= '</form>';
    		$_html .= '</div>';
		
    		$_html .= '<br/>';
    		
    		$_data = $obj_blockfaq->getItemsCategory(array('admin'=>1));
    		
    		$_id_selected_category = Tools::getValue("id_category");
    		
    		$all_category = $_data['items'];
			
			
			if(sizeof($all_category)>0){
			$_html .= '<div style="margin-bottom:10px;float:right">';
			$_html .= '<b>'.$this->l('Filter questions by category').':&nbsp;</b>';
			$_html .= '<select onchange="window.location.href=\''.$currentIndex.'&configure='.$this->name.'&token='.$token.'&id_category=\'+this.options[this.selectedIndex].value">';
			$_html .= '<option value=0>---</option>';
			foreach($all_category as $_items){
				$_category_id = $_items['id'];
							$name_product1 = isset($_items['title'])?stripslashes($_items['title']):'';
	    					if(strlen($name_product1)==0) continue;
							$_html .= '<option value='.$_category_id.' '.(($_id_selected_category == $_category_id)?'selected="selected"':'').'>'.$name_product1.'</option>';
	    		
			}
			
			$_html .= '<select>';
			if($_id_selected_category)
			$_html .= '&nbsp;&nbsp;<a href="'.$currentIndex.'&item_faq_page&configure='.$this->name.'&token='.$token.'" 
							style="text-decoration:underline">'.$this->l('Clear search').'</a>';
			$_html .= '</div>';
			
			$_html .= '<div style="clear:both"></div>';
			}
    		
			$_html .= '<table class = "table" width = 100%>
			<tr>
				<th width=50>'.$this->l('ID').'</th>
				<th width=100>'.$this->l('Lang').'</th>';
			
			if($this->_is15){
    			$_html .= '<th width = 100>'.$this->l('Shop').'</th>';
    		}
    		
			
				$_html .= '<th>'.$this->l('Question').'</th>';
				
				$_html .= '<th width=100>'.$this->l('Category ID').'</th>';
    			$_html .= '<th width=120>'.$this->l('By Customer').'</th>';
				
				$_html .= '<th width=100>'.$this->l('Position').'</th>
				<th width = "50">'.$this->l('Status').'</th>
				<th width = "50">'.$this->l('Action').'</th>
			</tr>';
			
			$_data = $obj_blockfaq->getItems(array('id_category'=>$_id_selected_category));
			
			$_items = $_data['items'];
			$count_stickers =  sizeof($_items);
			if($count_stickers>0){
				$i=0;
				foreach($_items as $_item){
					$sticker = $_items[$i];
					$id = $_item['id'];
					$title = $_item['title'];
					$is_by_customer = $_item['is_by_customer'];
					//$customer_name = isset($_item['customer_name'])?$_item['customer_name']:'<span style="text-align:center">---</span>';
					$status = $_items[$i]['status'];
					
					
					$faq_category_ids = isset($_items[$i]['faq_category_ids'])?$_items[$i]['faq_category_ids']:'<span style="text-align:center">---</span>';
					
					if(@strlen($faq_category_ids)==0)
						$faq_category_ids = '<span style="text-align:center">---</span>';
					
					
					if($this->_is15){

						$id_shop = $_item['ids_shops'];
						$id_shop = explode(",",$id_shop);
						$shops = Shop::getShops();
						$name_shop = array();
						foreach($shops as $_shop){
							$id_shop_lists = $_shop['id_shop'];
							if(in_array($id_shop_lists,$id_shop))
								$name_shop[] = $_shop['name'];
						}
						$name_shop = implode(",",$name_shop);
					}
					
					$ids_lng = isset($_item['ids_lng'])?$_item['ids_lng']:array();
					$lang_for_faq = array();
					foreach($ids_lng as $lng_id){
						$data_lng = Language::getLanguage($lng_id);
						$lang_for_faq[] = $data_lng['iso_code']; 
					}
					$lang_for_faq = implode(",",$lang_for_faq);
					
					$_html .= 
						'<tr>
						<td style = "color:black;">'.$id.'</td>';
					$_html .= '<td style = "color:black;">'.$lang_for_faq.'</td>';
					
					if($this->_is15){
						$_html .= '<td style="color:black">'.$name_shop.'</td>';
					}
					
					$_html .= '<td style = "color:black;">'.$title.'</td>';
					
					$_html .= '<td style = "color:black">'.$faq_category_ids.'</td>';
					
					
				if($is_by_customer)
					$_html .= '<td><img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif"></td>';
				else
					$_html .= '<td><img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif"></td>';
					
				//	$_html .= '<td style = "color:black">'.$customer_name.'</td>';
					
					
					
					$_html .= '<td style = "color:black;">';
					if($i < $count_stickers - 1):
				$_html	.= '<a href="'.$currentIndex.'&configure='.$this->name.'&token='.$token.'
										&id=' . $id . '
										&order_self=' . $sticker['order_by'] . '
										&id_change='. $_items[$i+1]['id'] . '
										&order_change=' . $_items[$i+1]['order_by'].'">
								<img border="0" src="'.__PS_BASE_URI__.'img/admin/down.gif">
							</a>';
 					endif;
				if($i > 0):
				$_html	.= '<a href="'.$currentIndex.'&configure='.$this->name.'&token='.$token.'
								&id=' .$id . '
								&order_self=' . $sticker['order_by'] . '
								&id_change='. $_items[$i-1]['id'] . '
								&order_change=' . $_items[$i-1]['order_by'] .'"> 
								<img border="0" src="'.__PS_BASE_URI__.'img/admin/up.gif">
							</a>';
				endif;
				
					$_html .= '</td>';

					if($status)
					$_html .= '<td><img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif"></td>';
				else
					$_html .= '<td><img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif"></td>';
					
			
					
					$_html .= '<td>
				
								 <input type = "hidden" name = "id" value = "'.$id.'"/>
								 <a href="'.$currentIndex.'&configure='.$this->name.'&token='.$token.'&edit_item_q&id='.(int)($id).'" title="'.$this->l('Edit').'"><img src="'._PS_ADMIN_IMG_.'edit.gif" alt="" /></a> 
								 <a href="'.$currentIndex.'&configure='.$this->name.'&token='.$token.'&delete_item_q&id='.(int)($id).'" title="'.$this->l('Delete').'"  onclick = "javascript:return confirm(\''.$this->l('Are you sure you want to remove this item?').'\');"><img src="'._PS_ADMIN_IMG_.'delete.gif" alt="" /></a>'; 
								 $_html .= '</form>
							 </td>';
					$_html .= '</tr>';
					$i++;
				}
			} else {
			$_html .= '<tr><td colspan="9" style="text-align:center;font-weight:bold;padding:10px">'.$this->l('Questions not found').'</td></tr>';	
			}
			
			$_html .= '</table>';
		}
			
			
		
		$_html .=	'</fieldset>'; 
		
		
     	return $_html;
    
    } 
    
    
    
     private function _drawSettingsFAQ(){
    	$cookie = $this->context->cookie;
		
    	global $currentIndex;
     	
     	$_html = '';
		$_html .= '<form action="'.$_SERVER['REQUEST_URI'].'" method="post" >';
		
		$_html .= '
		<fieldset>
					<legend><img src="../modules/'.$this->name.'/img/logo-faq.gif"  />
					'.$this->l('FAQ Settings').':</legend>';
		
		$_html .= '<table style="width:100%">';
    	
    	
    	$_html .= '<tr>';
    	$_html .= '<td style="text-align:right;width:40%;padding:0 20px 0 0">';
    	
    	$_html .= '<b>'.$this->l('Enable or Disable FAQ').':</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td class="r-set">';
    	$_html .=  '
					<input type="radio" value="1" id="text_list_on" name="faqon" onclick="enableOrDisablefaqon(1)"
							'.(Tools::getValue('faqon', Configuration::get($this->name.'faqon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					<input type="radio" value="0" id="text_list_off" name="faqon" onclick="enableOrDisablefaqon(0)"
						   '.(!Tools::getValue('faqon', Configuration::get($this->name.'faqon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
				';
		
    	$_html .= '</div>';
    	
		$_html .= '<script type="text/javascript">
			    	function enableOrDisablefaqon(id)
						{
						if(id==0){
							$("#block-faqon-settings").hide(200);
						} else {
							$("#block-faqon-settings").show(200);
						}
							
						}
					</script>';
    	
		$_html .= '</td>';
		$_html .= '</tr>';
		$_html .= '</table>';
    	
		$_html .= '<div id="block-faqon-settings" '.(Configuration::get($this->name.'faqon')==1?'style="display:block"':'style="display:none"').'>';
    	
		
		$_html .= '<table class="table-settings" style="width:100%">';
    	
		
		$_html .= '<tr>';
    	$_html .= '<td style="text-align:right;width:35%;padding:0 20px 0 0">';
    	
    	$_html .= '<b>'.$this->l('The number of items in the "Block FAQ":').'</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td style="text-align:left">';
		$_html .=  '
					<input type="text" name="faq_blc"  
			               value="'.Tools::getValue('faq_blc', Configuration::get($this->name.'faq_blc')).'"
			               >
				';
		$_html .= '</td>';
		$_html .= '</tr>';
		
		
		$_html .= '<tr>';
    	$_html .= '<td style="text-align:right;width:30%;padding:0 20px 0 0">';
    	
    	$_html .= '<b>'.$this->l('Enable Ask a Question submit form').':</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td style="text-align:left">';
		$_html .=  '
					<input type="radio" value="1" id="text_list_on" name="faqis_askform"
							'.(Tools::getValue('faqis_askform', Configuration::get($this->name.'faqis_askform')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					<input type="radio" value="0" id="text_list_off" name="faqis_askform"
						   '.(!Tools::getValue('faqis_askform', Configuration::get($this->name.'faqis_askform')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
				';
		$_html .= '</td>';
		$_html .= '</tr>';
		
		$_html .= '<tr>';
    	$_html .= '<td style="text-align:right;width:30%;padding:0 20px 0 0">';
    	
    	$_html .= '<b>'.$this->l('Enable Captcha on submit form').':</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td style="text-align:left">';
		$_html .=  '
					<input type="radio" value="1" id="text_list_on" name="faqis_captcha"
							'.(Tools::getValue('faqis_captcha', Configuration::get($this->name.'faqis_captcha')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					<input type="radio" value="0" id="text_list_off" name="faqis_captcha"
						   '.(!Tools::getValue('faqis_captcha', Configuration::get($this->name.'faqis_captcha')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
				';
		$_html .= '</td>';
		$_html .= '</tr>';
		
		
		$_html .= '<tr>';
    	$_html .= '<td style="text-align:right;width:30%;padding:0 20px 0 0">';
    	
    	$_html .= '<b>'.$this->l('Admin email:').'</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td style="text-align:left">';
		$_html .=  '
					<input type="text" name="mailfaq"  size="40"
			               value="'.Tools::getValue('mailfaq', Configuration::get($this->name.'mailfaq')).'"
			               >
				';
		$_html .= '</td>';
		$_html .= '</tr>';
		
		$_html .= '<tr>';
    	$_html .= '<td style="text-align:right;width:30%;padding:0 20px 0 0">';
    	
    	$_html .= '<b>'.$this->l('E-mail notification:').'</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td style="text-align:left">';
		$_html .= '<input type = "checkbox" name = "notifaq" id = "notifaq" value ="1" '.((Tools::getValue($this->name.'notifaq', Configuration::get($this->name.'notifaq')) ==1)?'checked':'').'/>';
		$_html .= '</td>';
		$_html .= '</tr>';
		
		####
		$_html .= '<tr>';
    	$_html .= '<td style="text-align:right;width:40%;padding:0 20px 0 0">';
    	
		$_html .= '<b>'.$this->l('Position "Block FAQ":').'</b>';
		
		$_html .= '</td>';
    	$_html .= '<td style="text-align:left">';
		
				//$_html .= '<div class="margin-form choose_hooks">';
	    		$_html .= '<table style="width:66%;">
	    				<tr>
	    					<td style="width: 33%">'.$this->l('Left Column').'</td>
	    					<td style="width: 33%">'.$this->l('Right Column').'</td>
	    					
	    				</tr>
	    				<tr>
	    					<td>
	    						<input type="checkbox" name="faq_left" '.((Tools::getValue($this->name.'faq_left', Configuration::get($this->name.'faq_left')) ==1)?'checked':'').'  value="1"/>
	    					</td>
	    					<td>
	    						<input type="checkbox" name="faq_right" '.((Tools::getValue($this->name.'faq_right', Configuration::get($this->name.'faq_right')) ==1)?'checked':'') .' value="1"/>
	    					</td>
	    					
	    				</tr>
	    				<tr>
	    					<td>'.$this->l('Footer').'</td>
	    					<td>'.$this->l('Home').'</td>
	    					
	    				</tr>
	    				<tr>
	    					<td>
	    						<input type="checkbox" name="faq_footer" '.((Tools::getValue($this->name.'faq_footer', Configuration::get($this->name.'faq_footer')) ==1)?'checked':'').' value="1"/>
	    					</td>
	    					<td>
	    						<input type="checkbox" name="faq_home" '.((Tools::getValue($this->name.'faq_home', Configuration::get($this->name.'faq_home')) ==1)?'checked':'').' value="1"/>
	    					</td>
	    					
	    				</tr>
	    				
	    			</table>';
	    //$_html .= '</div>';
		$_html .= '</td>';
		$_html .= '</tr>';
				
		###
		
		
    	$_html .= '</table>';
    	
    	$_html .= '</div>';
			
			$_html .= '<p class="center" style="text-align:center;border: 1px solid #EBEDF4; padding: 10px; margin-top: 10px;">
					<input type="submit" name="submit_faq" value="'.$this->l('Update settings').'" 
                		   class="button"  />
                	</p>';
					
					
		$_html .= '</fieldset>	';
		$_html .= '</form>';
		
		
		
		return $_html;
		
    }
    
    
    
    
public function _drawTestImonials($data = null){
		$cookie = $this->context->cookie;
		
		global $currentIndex;
		
		$currentIndex = isset($data['currentindex'])?$data['currentindex']:$currentIndex;
    	$controller = isset($data['controller'])?$data['controller']:'AdminModules';
    	$token = isset($data['token'])?$data['token']:Tools::getAdminToken($controller.intval(Tab::getIdFromClassName($controller)).intval($cookie->id_employee));
    	
		
    	$_html = '';
    	
    	$_html .= '<br/><br/>';
    	
    	$_html .= '<fieldset>
					<legend><img src="../modules/'.$this->name.'/img/logo-testimonials.gif" />'.$this->l('Moderate Testimonals').'</legend>';
    	
    	include_once(dirname(__FILE__).'/classes/shopreviews.class.php');
		$obj_shopreviews = new shopreviews();
				
    	if(Tools::isSubmit("edit_item_t")){
    		$_data = $obj_shopreviews->getItem(array('id'=>(int)Tools::getValue("id")));
    		
    		$_html .= '
    					<form action="'.$_SERVER['REQUEST_URI'].'" method="post">';
    		
    		$name = $_data['reviews'][0]['name'];
    		$email = $_data['reviews'][0]['email'];
    		$web = $_data['reviews'][0]['web'];
    		$message = $_data['reviews'][0]['message'];
    		$date = $_data['reviews'][0]['date_add'];
    		$active = $_data['reviews'][0]['active'];
    		$id = $_data['reviews'][0]['id'];
    		
    		$company = $_data['reviews'][0]['company'];
    		$address = $_data['reviews'][0]['address'];
    		
    		
    		$lang = $_data['reviews'][0]['id_lang'];
    		$data_lng = Language::getLanguage($lang);
			$lang_for_testimonial = $data_lng['iso_code'];

			if($this->_is15){
				$id_shop = $_data['reviews'][0]['id_shop'];
				
				$shops = Shop::getShops();
				$name_shop = '';
				foreach($shops as $_shop){
					$id_shop_lists = $_shop['id_shop'];
					if($id_shop == $id_shop_lists)
						$name_shop = $_shop['name'];
				}
			}
    		
    		$_html .= '<label>'.$this->l('ID:').'</label>';
    		$_html .= '<div style="padding:0 0 1em 210px;line-height:1.6em;">'.$id.'</div>';
    		
    		if($this->_is15){
    			$_html .= '<label>'.$this->l('Shop').'</label>
    					<div class="margin-form">
							'.$name_shop.'
						</div>';
			}
			$_html .= '<label>'.$this->l('Language').'</label>
    					<div class="margin-form">
							'.$lang_for_testimonial.'
						</div>';
    		
    		$_html .= '<label>'.$this->l('Name:').'</label>
    					<div class="margin-form">
							<input type="text" name="name"  style="width:200px"
			                	   value="'.$name.'">
						</div>';
    		$_html .= '<label>'.$this->l('Email:').'</label>
    					<div class="margin-form">
							<input type="text" name="email"  style="width:200px"
			                	   value="'.$email.'">
						</div>';
    		
    		if(Configuration::get($this->name.'tis_web')){
	    		$_html .= '<label>'.$this->l('Web:').'</label>
	    					<div class="margin-form">
								<input type="text" name="web"  style="width:200px"
				                	   value="'.$web.'">
							</div>';
	    	}
    		if(Configuration::get($this->name.'tis_company')){
	    		$_html .= '<label>'.$this->l('Company').':</label>
	    					<div class="margin-form">
								<input type="text" name="company"  style="width:200px"
				                	   value="'.$company.'">
							</div>';
	    	}
    		if(Configuration::get($this->name.'tis_addr')){
	    		$_html .= '<label>'.$this->l('Address').':</label>
	    					<div class="margin-form">
								<input type="text" name="address"  style="width:200px"
				                	   value="'.$address.'">
							</div>';
	    	}
    		$_html .= '<label>'.$this->l('Message:').'</label>
    					<div class="margin-form">
							<textarea name="message" cols="50" rows="10"  
			                	   >'.$message.'</textarea>
						</div>';
    		
    		$_html .= '<label>'.$this->l('Date Add:').'</label>';
    		$_html .= '<div style="padding:0 0 1em 210px;line-height:1.6em;">'.$date.'</div>';
    		
    		
    		$_html .= '
				<label>'.$this->l('Publish').'</label>
				<div class = "margin-form" >';
				
			$_html .= '<input type = "checkbox" name = "publish" id = "publish" value ="1" '.(($active ==1)?'checked':'').'/>';
				
			$_html .= '</div>';
				
			$_html .= '<label>&nbsp;</label>
						<div class = "margin-form"  style="margin-top:20px">
						<input type="submit" name="cancel_item_t" value="'.$this->l('Cancel').'" 
                		   class="button"  />&nbsp;&nbsp;&nbsp;
						<input type="submit" name="submit_item_t" value="'.$this->l('Save').'" 
                		   class="button"  />
                		  </div>';
			
    		$_html .= '</form>';
			
    		
    	} else {
    	
    	
    	$_html .= '<table class = "table" width = 100%>
			<tr>
				<th>'.$this->l('No.').'</th>';
    	
    		$_html .= '<th width = 50>'.$this->l('Lang').'</th>';
    		
    		if($this->_is15){
    			$_html .= '<th width = 100>'.$this->l('Shop').'</th>';
    		}
    	
		$_html .= '<th>'.$this->l('Name').'</th>';
		if($this->_is16!=1)
			$_html .=	'<th width = 100>'.$this->l('Email').'</th>';
    	
    	if(Configuration::get($this->name.'tis_web')){
			$_html .= '<th width = 100>'.$this->l('Web').'</th>';
    	}
    	
    	
		$_html .= '<th width = "300">'.$this->l('Message').'</th>
				<th>'.$this->l('Date').'</th>
				<th>'.$this->l('Published').'</th>
				<th width = "44">'.$this->l('Action').'</th>
			</tr>';
    	
    	$name_module = $this->name;
		$start = (int)Tools::getValue("page_t");
		
		$_data = $obj_shopreviews->getTestimonials(array('start'=>$start,'step'=>$this->_step,'admin' => 1));

		$paging = $obj_shopreviews->PageNav($start,$_data['count_all_reviews'],$this->_step, 
											array('admin' => 1,'currentIndex'=>$currentIndex,
												  'token' => $token));
    	$i=0;
    	
    	
    	if(sizeof($_data['reviews'])>0){
		foreach($_data['reviews'] as $_item){
			$i++;
			$id = $_item['id'];
			$name = $_item['name'];
			$email = $_item['email'];
			$web = $_item['web'];
			$message = $_item['message'];
			$date = $_item['date_add'];
			$active = $_item['active'];
			
			$company = $_item['company'];
    		$address = $_item['address'];
    		
    		
    		$lang = $_item['id_lang'];
    		$data_lng = Language::getLanguage($lang);
			$lang_for_testimonial = $data_lng['iso_code'];

			if($this->_is15){
				$id_shop = $_data['reviews'][0]['id_shop'];
				
				$shops = Shop::getShops();
				$name_shop = '';
				foreach($shops as $_shop){
					$id_shop_lists = $_shop['id_shop'];
					if($id_shop == $id_shop_lists)
						$name_shop = $_shop['name'];
				}
			}
			
			$_html .= 
			'<tr>
			<td style = "color:black;">'.$id.'</td>';
			
	$_html .= '<td style="color:black">'.$lang_for_testimonial.'</td>';
	
	if($this->_is15){
		$_html .= '<td style="color:black">'.$name_shop.'</td>';
	}
			
	$_html .= '<td style = "color:black;">'.$name.'</td>';
	if($this->_is16!=1)
		$_html .= '<td style = "color:black;">'.$email.'</td>';
			
			if(Configuration::get($this->name.'tis_web')){
				if(strlen($web)>0){
					$_html .= '<td><a  style = "color:#996633;text-decoration:underline" href = "http://'.$web.'">http://'.$web.'</a></td>';
				} else {
					$_html .= '<td>&nbsp;</td>';
				}
			}
			
			$_html .= '<td style = "color:black;">'.(strlen($message)>50?substr($message,0,50)."...":$message).'</td>
			<td style = "color:black;">'.$date.'</td>';
			
			$_html .= '
			<td style = "color:black;text-align:center;">
			 <form action = "'.$_SERVER['REQUEST_URI'].'" method = "POST">';
			 if ($active == 1) {
					$_html .= '<input type = "submit" name = "unpublished_t" value = "Unpublish" class = "button unpublished"/>';
				 }
				 else{
					$_html .= '<input type = "submit" name = "published_t" value = "Publish" class = "button published"/>';
				 }
			$_html .= '</td>
			<td>
				
				 <input type = "hidden" name = "id" value = "'.$id.'"/>
				 <a href="'.$currentIndex.'&configure='.$this->name.'&token='.$token.'&edit_item_t&id='.(int)($id).'" title="'.$this->l('Edit').'"><img src="'._PS_ADMIN_IMG_.'edit.gif" alt="" /></a> 
				 <a href="'.$currentIndex.'&configure='.$this->name.'&token='.$token.'&delete_item_t&id='.(int)($id).'" title="'.$this->l('Delete').'"  onclick = "javascript:return confirm(\''.$this->l('Are you sure you want to remove this item?').'\');"><img src="'._PS_ADMIN_IMG_.'delete.gif" alt="" /></a>'; 
				 $_html .= '</form>
			 </td>
			';
			
			$_html .= '</tr>';
		}
    	
    	} else {
			$_html .= '<tr><td colspan="9" style="text-align:center;font-weight:bold;padding:10px">
			'.$this->l('TestImonials not found').'</td></tr>';	
			
		}
		
    	$_html .= '</table>
						';
    	if($i!=0){
    	$_html .= '<div style="margin:5px">';
    	$_html .= $paging;
    	$_html .= '</div>';
    	}
    	}
    	
    	
    	$_html .=	'</fieldset>'; 
		
		return $_html;
    }
    
    
private function _drawSettingsTestim(){
		$cookie = $this->context->cookie;
		
   	global $currentIndex;
		
    	$_html = '';
    	
    	$_html .= '<style type="text/css">
    		.testimsettings-left{text-align:right;width:30%;padding:0 20px 0 0}
    		.table-settings td{padding:3px}
    		</style>';
    	
    	$_html .= '<fieldset>
					<legend><img src="../modules/'.$this->name.'/img/logo-testimonials.gif" />'
    				.$this->l('Testimonals Settings:').'</legend>';
    	$_html .= '
        <form action="'.$_SERVER['REQUEST_URI'].'" method="post">';
    	
    	$_html .= '<table class="table-settings">';
    	
    	
    	$_html .= '<tr>';
    	$_html .= '<td class="l-set">';
    	
    	$_html .= '<b>'.$this->l('Enable or Disable Testimonials').':</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td class="r-set">';
    	$_html .=  '
					<input type="radio" value="1" id="text_list_on" name="testimon" onclick="enableOrDisabletestimon(1)"
							'.(Tools::getValue('testimon', Configuration::get($this->name.'testimon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					<input type="radio" value="0" id="text_list_off" name="testimon" onclick="enableOrDisabletestimon(0)"
						   '.(!Tools::getValue('testimon', Configuration::get($this->name.'testimon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
				';
		
    	$_html .= '</div>';
    	
		$_html .= '<script type="text/javascript">
			    	function enableOrDisabletestimon(id)
						{
						if(id==0){
							$("#block-testimon-settings").hide(200);
						} else {
							$("#block-testimon-settings").show(200);
						}
							
						}
					</script>';
    	
		$_html .= '</td>';
		$_html .= '</tr>';
		$_html .= '</table>';
    	
		$_html .= '<div id="block-testimon-settings" '.(Configuration::get($this->name.'testimon')==1?'style="display:block"':'style="display:none"').'>';
    	
    	
    	$_html .= '<table class="table-settings" style="width:100%">';
    	
    	
    	$_html .= '<tr>';
    	$_html .= '<td style="text-align:right;width:50%;padding:0 20px 0 0">';
    	
    	$_html .= '<b>'.$this->l('The number of items in the "TestImonials Block":').'</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td style="text-align:left">';
		$_html .=  '
					<input type="text" name="tlast"  
			               value="'.Tools::getValue('tlast', Configuration::get($this->name.'tlast')).'"
			               >
				';
		$_html .= '</td>';
		$_html .= '</tr>';
    	
    	/*$_html .= '<tr>';
    	$_html .= '<td class="testimsettings-left">';
    	
    	$_html .= '<b>'.$this->l('Position Testimonals Block:').'</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td style="text-align:left">';
		$_html .=  '
					<select class="select" name="tposition" 
							id="position">
						<option '.(Tools::getValue('tposition', Configuration::get($this->name.'tposition'))  == "left" ? 'selected="selected" ' : '').' value="left">'.$this->l('Left').'</option>
						<option '.(Tools::getValue('tposition', Configuration::get($this->name.'tposition')) == "right" ? 'selected="selected" ' : '').' value="right">'.$this->l('Right').'</option>
						<option '.(Tools::getValue('tposition', Configuration::get($this->name.'tposition')) == "home" ? 'selected="selected" ' : '').' value="home">'.$this->l('Home').'</option>
						<option '.(Tools::getValue('tposition', Configuration::get($this->name.'tposition')) == "footer" ? 'selected="selected" ' : '').' value="footer">'.$this->l('Footer').'</option>
						<option '.(Tools::getValue('tposition', Configuration::get($this->name.'tposition')) == "none" ? 'selected="selected" ' : '').' value="none">'.$this->l('None').'</option>
										
					</select>
				';
		$_html .= '</td>';
		$_html .= '</tr>';*/
		
		####
		$_html .= '<tr>';
    	$_html .= '<td class="testimsettings-left">';
    	
		$_html .= '<b>'.$this->l('Position Testimonals Block:').'</b>';
		
		$_html .= '</td>';
    	$_html .= '<td style="text-align:left">';
		
				//$_html .= '<div class="margin-form choose_hooks">';
	    		$_html .= '<table style="width:66%;">
	    				<tr>
	    					<td style="width: 33%">'.$this->l('Left Column').'</td>
	    					<td style="width: 33%">'.$this->l('Right Column').'</td>
	    					
	    				</tr>
	    				<tr>
	    					<td>
	    						<input type="checkbox" name="t_left" '.((Tools::getValue($this->name.'t_left', Configuration::get($this->name.'t_left')) ==1)?'checked':'').'  value="1"/>
	    					</td>
	    					<td>
	    						<input type="checkbox" name="t_right" '.((Tools::getValue($this->name.'t_right', Configuration::get($this->name.'t_right')) ==1)?'checked':'') .' value="1"/>
	    					</td>
	    					
	    				</tr>
	    				<tr>
	    					<td>'.$this->l('Footer').'</td>
	    					<td>'.$this->l('Home').'</td>
	    					
	    				</tr>
	    				<tr>
	    					<td>
	    						<input type="checkbox" name="t_footer" '.((Tools::getValue($this->name.'t_footer', Configuration::get($this->name.'t_footer')) ==1)?'checked':'').' value="1"/>
	    					</td>
	    					<td>
	    						<input type="checkbox" name="t_home" '.((Tools::getValue($this->name.'t_home', Configuration::get($this->name.'t_home')) ==1)?'checked':'').' value="1"/>
	    					</td>
	    					
	    				</tr>
	    				
	    			</table>';
	    //$_html .= '</div>';
		$_html .= '</td>';
		$_html .= '</tr>';
		
		$_html .= '<tr>';
    	$_html .= '<td class="testimsettings-left">';
    	
    	$_html .= '<b>'.$this->l('Testimonials per Page:').'</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td style="text-align:left">';
		$_html .=  '
					<input type="text" name="tperpage"  
			               value="'.Tools::getValue('tperpage', Configuration::get($this->name.'tperpage')).'"
			               >
				';
		$_html .= '</td>';
		$_html .= '</tr>';
		
		$_html .= '<tr>';
    	$_html .= '<td class="testimsettings-left">';
    	
    	$_html .= '<b>'.$this->l('Enable Captcha on submit form').':</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td style="text-align:left">';
		$_html .=  '
					<input type="radio" value="1" id="text_list_on" name="tis_captcha"
							'.(Tools::getValue('tis_captcha', Configuration::get($this->name.'tis_captcha')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					<input type="radio" value="0" id="text_list_off" name="tis_captcha"
						   '.(!Tools::getValue('tis_captcha', Configuration::get($this->name.'tis_captcha')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
				';
		$_html .= '</td>';
		$_html .= '</tr>';
		
		$_html .= '<tr>';
    	$_html .= '<td class="testimsettings-left">';
    	
    	$_html .= '<b>'.$this->l('Enable Web address on submit form').':</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td style="text-align:left">';
		$_html .=  '
					<input type="radio" value="1" id="text_list_on" name="tis_web"
							'.(Tools::getValue('tis_web', Configuration::get($this->name.'tis_web')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					<input type="radio" value="0" id="text_list_off" name="tis_web"
						   '.(!Tools::getValue('tis_web', Configuration::get($this->name.'tis_web')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
				';
		$_html .= '</td>';
		$_html .= '</tr>';
		
		$_html .= '<tr>';
    	$_html .= '<td class="testimsettings-left">';
    	
    	$_html .= '<b>'.$this->l('Enable Company on submit form').':</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td style="text-align:left">';
		$_html .=  '
					<input type="radio" value="1" id="text_list_on" name="tis_company"
							'.(Tools::getValue('tis_company', Configuration::get($this->name.'tis_company')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					<input type="radio" value="0" id="text_list_off" name="tis_company"
						   '.(!Tools::getValue('tis_company', Configuration::get($this->name.'tis_company')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
				';
		$_html .= '</td>';
		$_html .= '</tr>';
		
		
		$_html .= '<tr>';
    	$_html .= '<td class="testimsettings-left">';
    	
    	$_html .= '<b>'.$this->l('Enable Address on submit form').':</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td style="text-align:left">';
		$_html .=  '
					<input type="radio" value="1" id="text_list_on" name="tis_addr"
							'.(Tools::getValue('tis_addr', Configuration::get($this->name.'tis_addr')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					<input type="radio" value="0" id="text_list_off" name="tis_addr"
						   '.(!Tools::getValue('tis_addr', Configuration::get($this->name.'tis_addr')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
				';
		$_html .= '</td>';
		$_html .= '</tr>';
		
		
		$_html .= '<tr>';
    	$_html .= '<td class="testimsettings-left">';
    	
    	$_html .= '<b>'.$this->l('Admin email:').'</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td style="text-align:left">';
		$_html .=  '
					<input type="text" name="tmail"  
			               value="'.Tools::getValue('tmail', Configuration::get($this->name.'tmail')).'"
			               >
				';
		$_html .= '</td>';
		$_html .= '</tr>';
		
		$_html .= '<tr>';
    	$_html .= '<td class="testimsettings-left">';
    	
    	$_html .= '<b>'.$this->l('E-mail notification:').'</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td style="text-align:left">';
		$_html .= '<input type = "checkbox" name = "tnoti" id = "tnoti" value ="1" '.((Tools::getValue($this->name.'tnoti', Configuration::get($this->name.'tnoti')) ==1)?'checked':'').'/>';
		$_html .= '</td>';
		$_html .= '</tr>';
		
		$_html .= '<tr>';
    	$_html .= '<td class="testimsettings-left">';
    	
    	$_html .= '<b>'.$this->l('Enable or Disable RSS Feed').':</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td style="text-align:left">';
    	
    	
    	$_html .=  '
					<input type="radio" value="1" id="text_list_on" name="trssontestim" 
							'.(Tools::getValue('trssontestim', Configuration::get($this->name.'trssontestim')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					
					<input type="radio" value="0" id="text_list_off" name="trssontestim" 
						   '.(!Tools::getValue('trssontestim', Configuration::get($this->name.'trssontestim')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
				';
		$_html .= '</td>';
		$_html .= '</tr>';
		
    
    	
    	$_html .= '<tr>';
    	$_html .= '<td class="testimsettings-left">';
		
		
    	$_html .= '<b>'.$this->l('Number of items in RSS Feed').':</b>';

    	$_html .= '<td style="text-align:left">';
    	$_html .=  '
					<input type="text" name="tn_rssitemst"  
			               value="'.Tools::getValue('tn_rssitemst', Configuration::get($this->name.'tn_rssitemst')).'"
			               >
				';
		
    	$_html .= '</td>';
		$_html .= '</tr>';
		
		$_html .= '</table>';
		
		$_html .= '</div>';
    	
    	$_html .= '<p class="center" style="text-align:center;border: 1px solid #EBEDF4; padding: 10px; margin-top: 10px;">
					<input type="submit" name="submit_testim" value="'.$this->l('Update settings').'" 
                		   class="button"  />
                	</p>';
   		$_html .= '</form>';
    	$_html .=	'</fieldset>';
    	
    	return $_html;
   }
    
    
     private function _drawPinterestRichPinsForm(){
    	$_html = '';
    	
    	
    	
    	$_html .= '<fieldset>
					<legend><img src="../modules/'.$this->name.'/i/ico-pinterest.png"  />
						'.$this->l('Pinterest Rich Pins Settings').'</legend>';
    	
    	$_html .= '
        <form action="'.$_SERVER['REQUEST_URI'].'" method="post" >';
    	
    	// Enable or Disable Rich Pins
    	$_html .= '<label style="width:29%">'.$this->l('Enable or Disable Rich Pins').':</label>
				<div class="margin-form">
				
					<input type="radio" value="1" id="text_list_on" name="pinvis_on" onclick="enableOrDisablePin(1)"
							'.(Tools::getValue('pinvis_on', Configuration::get($this->name.'pinvis_on')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					
					<input type="radio" value="0" id="text_list_off" name="pinvis_on" onclick="enableOrDisablePin(0)"
						   '.(!Tools::getValue('pinvis_on', Configuration::get($this->name.'pinvis_on')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
					<p class="clear">'.$this->l('Enable or Disable Rich Pins').'.</p>
				</div>';
    	
    	$_html .= '<script type="text/javascript">
			    	function enableOrDisablePin(id)
						{
						if(id==0){
							$("#block-pin-settings").hide(200);
							$("#block-pin-help").hide(200);
						} else {
							$("#block-pin-settings").show(200);
							$("#block-pin-help").show(200);
						
						}
							
						}
					</script>';
    	
    	
    	
    	$_html .= '<div id="block-pin-settings" '.(Configuration::get($this->name.'pinvis_on')==1?'style="display:block"':'style="display:none"').'>';
    	
    	$_html .= '<label style="width:29%">'.$this->l('Enable or Disable Pinterest Button').':</label>
				<div class="margin-form">
				
					<input type="radio" value="1" id="text_list_on" name="pinbutton_on" 
							'.(Tools::getValue('pinbutton_on', Configuration::get($this->name.'pinbutton_on')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					
					<input type="radio" value="0" id="text_list_off" name="pinbutton_on" 
						   '.(!Tools::getValue('pinbutton_on', Configuration::get($this->name.'pinbutton_on')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
					<p class="clear">'.$this->l('Enable or Disable Pinterest Button').'.</p>
				</div>';
    	
    	 
  	 $_html .= '<label>'.$this->l('Pinterest Button style').'</label>
				<div class="margin-form">';
  		$_html .= '<table style="width:50%;" cellpadding="0" cellspacing="0">';
    	$_html .= '<tr>
	    			   <td style="">
	    			   		<input type="radio" value="firston" id="pbuttons" name="pbuttons"
								'.(Tools::getValue('pbuttons', Configuration::get($this->name.'pbuttons')) == "firston" ? 'checked="checked" ' : '').'>
					   </td>
	    			   <td>
	    			   	<img src="../modules/'.$this->name.'/i/p-top.png" />
					   </td>
    			   ';
    	$_html .= '<td style="">
	    			   		<input type="radio" value="secondon" id="pbuttons" name="pbuttons"
								'.(Tools::getValue('pbuttons', Configuration::get($this->name.'pbuttons')) == "secondon" ? 'checked="checked" ' : '').'>
					   </td>
	    			   <td>
	    			   	<img src="../modules/'.$this->name.'/i/p-horizontal.png" />
					   </td>';
		$_html .= '<td style="">
	    			   		<input type="radio" value="threeon" id="pbuttons" name="pbuttons"
								'.(Tools::getValue('pbuttons', Configuration::get($this->name.'pbuttons')) == "threeon" ? 'checked="checked" ' : '').'>
					   </td>
	    			   <td>
	    			   	<img src="../modules/'.$this->name.'/i/p-none.png" />
					   </td>
					</tr>';
		$_html .= '</table>';
		
		$_html .= '</div>';
		
		
		$leftColumn = Configuration::get($this->name.'_leftColumn');
		$extraLeft = Configuration::get($this->name.'_extraLeft');
		$productFooter = Configuration::get($this->name.'_productFooter');
		$rightColumn = Configuration::get($this->name.'_rightColumn');
		$extraRight = Configuration::get($this->name.'_extraRight');
		$productActions = Configuration::get($this->name.'_productActions');
		
		ob_start();?>
		<style>
			.choose_hooks input{margin-bottom: 10px}
		</style>
        		
        		<label>Position:</label>
				<div class="margin-form choose_hooks">
	    			<table style="width:80%;">
	    				<tr>
	    					
	    					<td style="width: 33%"><?= $this->l('Left column, only product page')?></td>
	    					<td style="width: 33%"><?= $this->l('Extra left')?></td>
	    					<td style="width: 33%"><?= $this->l('Product footer')?></td>
	    				</tr>
	    				<tr>
	    					
	    					<td>
	    						<input type="checkbox" name="leftColumn" <?=($leftColumn == 'leftColumn' ? 'checked="checked"' : ''); ?> value="leftColumn"/>
	    					</td>
	    					<td>
	    						<input type="checkbox" name="extraLeft" <?=($extraLeft == 'extraLeft' ? 'checked="checked"' : ''); ?> value="extraLeft"/>
	    					</td>
	    					<td>
	    						<input type="checkbox" name="productFooter" <?= ($productFooter == 'productFooter' ? 'checked="checked"' : ''); ?> value="productFooter"/>
	    					</td>
	    				</tr>
	    				<tr>
	    					<td><?= $this->l('Right column, only product page')?></td>
	    					<td><?= $this->l('Extra right')?></td>
	    					<td><?= $this->l('Product actions')?></td>
	    				</tr>
	    				<tr>
	    					
	    					<td>
	    						<input type="checkbox" name="rightColumn" <?= ($rightColumn == 'rightColumn' ? 'checked="checked"' : ''); ?> value="rightColumn"/>
	    					</td>
	    					<td>
	    						<input type="checkbox" name="extraRight" <?= ($extraRight == 'extraRight' ? 'checked="checked"' : ''); ?> value="extraRight"/>
	    					</td>
	    						<td>
	    						<input type="checkbox" name="productActions" <?= ($productActions == 'productActions' ? 'checked="checked"' : '') ?> value="productActions"/>
	    					</td>
	    				</tr>
	    				
	    			</table>
	    		</div>
				

		<?php 	$_html .= ob_get_contents();
		ob_end_clean();
		
    	$_html .= '</div>';
    	
    	$_html .= $this->_updateButton(array('name'=>'submit_richpins_settings'));
    	
    	$_html .= '</fieldset>';
    	
    	$_html .= '<br/>';
    	// rich pins settings help
	    $_html .= $this->_helpPinterestRichPins();
		//rich pins settings help
    	
    	return $_html;
    }
    
    
   private function _helpPinterestRichPins(){
    	$_html = '';
    	
    	
    	
    	$_html .= '<div id="block-pin-help" '.(Configuration::get($this->name.'pinvis_on')==1?'style="display:block"':'style="display:none"').'>';
    	
    	$_html .= '<fieldset>
					<legend><img src="../modules/'.$this->name.'/i/ico-pinterest.png"  />
						'.$this->l('Help').'</legend>';
    	
    	$_html .= '<h3 class="title-block-content">'.$this->l('Help').'</h3>';
    	
    	$_html .= '<b>'.$this->l('To validate your shop, please follow these steps').':</b><br/><br/>

	    - '.$this->l('Create an account or login to pinterest on').' <a href="http://www.pinterest.com" style="text-decoration:underline" target="_blank">http://www.pinterest.com</a><br/><br/>
	    - '.$this->l('Open another tab in your browser and go to').' <a href="http://developers.pinterest.com/rich_pins/validator/" style="text-decoration:underline" target="_blank">http://developers.pinterest.com/rich_pins/validator/</a><br/><br/>
	    - '.$this->l('Insert the url of one of your shop products in the text field and press "Validate" button').'<br/><br/>
	    - '.$this->l('Once your url has been processed you will see a page similar to the screenshot below with the data of your rich pin, now press on the "Apply now" button just below "Validate"').'<br/><br/>
	    	<img src="../modules/'.$this->name.'/i/pinterest-help/p-help1.png" '.(($this->_is15)?'':'style="width:600px"').' />
			<br/><br/>    	
	    - '.$this->l('Now you will be prompted to insert the domain where the rich pins will be validated and the data format for the rich pins.').'
	    	<br/> <br/> 
	    	'.$this->l('The domain and the data format should be precompiled, just check if the domain is correct and that data format is "HTML Tags" and then click "Apply now"').' 
	    <br/><br/>
	    <img src="../modules/'.$this->name.'/i/pinterest-help/p-help2.png" '.(($this->_is15)?'':'style="width:600px"').' />
	    <br/><br/>
	    - '.$this->l('The process is complete, now it\'s only a matter of time to get your site enabled for rich pins.').'
	    <br/><br/>
	    <img src="../modules/'.$this->name.'/i/pinterest-help/p-help3.png" />
	    <br/><br/>
	    '.$this->l('Remember that you need to validate only 1 pin to enable rich pins on your whole domain.').'
	    <br/><br/>
		'.$this->l('All your old pins will be converted automatically to rich pins when the first pin is verified.').'
	    ';
    	
    	$_html .= '</fieldset>';
    	
		$_html .= '</div>';
		
		
		
		return $_html;
    		
    }
    
    private function _drawGoogleBreadcrambSettingsForm(){
    	$_html = '';
    	$_html .= '
        <form action="'.$_SERVER['REQUEST_URI'].'" method="post" >';
    	$_html .= '<fieldset>
					<legend><img src="../modules/'.$this->name.'/i/ico-google.gif"  />
						'.$this->l('Rich Snippets for Breadcrumb Settings').'</legend>';
    	
    	// Enable or Disable Rich Pins
    	$_html .= '<label style="width:29%">'.$this->l('Enable or Disable Rich Snippets for Breadcrumb').':</label>
				<div class="margin-form">
				
					<input type="radio" value="1" id="text_list_on" name="breadvis_on" 
							'.(Tools::getValue('breadvis_on', Configuration::get($this->name.'breadvis_on')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					
					<input type="radio" value="0" id="text_list_off" name="breadvis_on" 
						   '.(!Tools::getValue('breadvis_on', Configuration::get($this->name.'breadvis_on')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
					<p class="clear">'.$this->l('Enable or Disable Rich Snippets for Breadcrumb').'.</p>
				</div>';
    	
    	$_html .= $this->_updateButton(array('name'=>'submit_breadcrumb_settings'));
 			
 		$_html .= '</fieldset>';
 		$_html .= '</form>';
 		
    	return $_html;
    }
    
    private function _drawGoogleSnippetsTestingToolForm(){
    	$_html = '';
    	$_html .= '
        <form action="http://www.google.com/webmasters/tools/richsnippets" target="_blank" method="GET">';
    	$_html .= '<fieldset>
					<legend><img src="../modules/'.$this->name.'/i/ico-google.gif" />'.$this->l('Google Snippets Testing Tools').'</legend>
					
					';
    	
		
    	$data_products = $this->_getProductsList();
    	
		if(sizeof($data_products['products'])>0){
    	$_html .= '<label>'.$this->l('Check Product URL:').'</label>
    			
    				<div class="margin-form">';
    				
    				
    	
    				$_html .= '<select name="url">';
    				foreach($data_products['products'] as $_item){
    					$name = isset($_item['name'])?stripslashes($_item['name']):'';
    					$link = isset($_item['link'])?$_item['link']:'';
    					if(strlen($name)==0) continue;
						$_html .= '<option  value="'.$link.'">'.$name.'</option>';
    				}
    				$_html .= '</select>';
    				
			        $_html .= '<input type="submit" value="'.$this->l('Check URL').'" 
                		   			  class="button"
                		   			  style="margin-left:10px"  />
					<p class="clear">'.$this->l('Select Product URL to view Snippet in test mode.').'</p>
					
				</div>';
		} else {
			$_html .= '<div style="text-align:center;font-weight:bold;color:red">'.$this->l('Products not found!').'</div>';
		}
		
		$_html .=	'</fieldset>';
		$_html .=	'</form>'; 
		
		return $_html;
    }
	
    private function _drawGoogleSnippetsSettingsForm(){
    	$_html = '';
    	$_html .= '
        <form action="'.$_SERVER['REQUEST_URI'].'" method="post" >';
    	
    	$_html .= '<fieldset>
					<legend><img src="../modules/'.$this->name.'/i/ico-google.gif"  />
						'.$this->l('Google Snippets Settings').'</legend>';
		
		 $_html .= '<label>'.$this->l('Display Google Rich Snippets Block').'</label>
				<div class="margin-form">
				
					<input type="radio" value="1" id="text_list_on" name="gsnipblock" onclick="enableOrDisableSnippets(1)"
							'.(Tools::getValue('gsnipblock', Configuration::get($this->name.'gsnipblock')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					
					<input type="radio" value="0" id="text_list_off" name="gsnipblock" onclick="enableOrDisableSnippets(0)"
						   '.(!Tools::getValue('gsnipblock', Configuration::get($this->name.'gsnipblock')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
					<p class="clear">'.$this->l('Enable or Disable Google Rich Snippets Block. You need to activate this option if you want the Google Rich Snippets functionality to work correctly. It will display a nice visual badge with summary information about your product and its ratings on each product page, as well aggregate ratings on your homepage.').'</p>
				</div>';
		 
		 $_html .= '<script type="text/javascript">
			    	function enableOrDisableSnippets(id)
						{
						if(id==0){
							$("#block-snip-settings").hide(200);
						} else {
							$("#block-snip-settings").show(200);
						}
							
						}
					</script>';
		 
		 $_html .= '<div id="block-snip-settings" '.(Configuration::get($this->name.'gsnipblock')==1?'style="display:block"':'style="display:none"').'>';
    	
		 
		 $_html .= '<label>'.$this->l('Width Google Rich Snippets Block').':</label>
    			
    				<div class="margin-form">
					<input type="text" name="gsnipblock_width"  style="width:200px"
			                		value="'.Tools::getValue('gsnipblock_width', Configuration::get($this->name.'gsnipblock_width')).'"> px
			    	<p class="clear">'.$this->l('Width Google Rich Snippets Block in pixel.').'</p>
				
					</div>';
		 
		 $_html .= '<label>'.$this->l('Enable Logo in Google Rich Snippets Block').'</label>
				<div class="margin-form">
				
					<input type="radio" value="1" id="text_list_on" name="gsnipblocklogo"
							'.(Tools::getValue('gsnipblocklogo', Configuration::get($this->name.'gsnipblocklogo')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					
					<input type="radio" value="0" id="text_list_off" name="gsnipblocklogo"
						   '.(!Tools::getValue('gsnipblocklogo', Configuration::get($this->name.'gsnipblocklogo')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
					<p class="clear">'.$this->l('Enable Logo in Google Rich Snippets Block').'.</p>
				</div>';
		 
		$_html .= '<label>'.$this->l('Select Hook where displayed Google Rich Snippets Block').':</label>
    					<div class="margin-form" style="margin-bottom:20px">';
    		
			$data_hooks = $this->_hooks_avaiable;

			    	
			   $_html .= '<select name="id_hook_gsnipblock">';
						foreach($data_hooks as $id_hook => $name_hook){
		    					
								
			    			if($id_hook == Configuration::get($this->name.'id_hook_gsnipblock')){
			    					$_html .= '<option  value="'.$id_hook.'" selected="selected">'.$name_hook.'</option>';
							}else{
									$_html .= '<option  value="'.$id_hook.'">'.$name_hook.'</option>';
 			    			}
							}
			    		$_html .= '</select>';
 			$_html .= '</div>';	
 			
 			$_html .= '</div>';
 			
 			$_html .= $this->_updateButton(array('name'=>'submit_gsnippets_settings'));
 			
 			$_html .= '</fieldset>';
 			$_html .= '</form>';
 			
    	return $_html;
    }

	  
	private function _drawSettingsSnip(){
		$_html = '';
    	
		$_html .= '
    	
        <form action="'.$_SERVER['REQUEST_URI'].'" method="post">';
		
    	$_html .= '<fieldset>
					<legend><img src="../modules/'.$this->name.'/i/settings_reviews.gif" />'
    				.$this->l('Reviews Settings:').'</legend>';
    	
    	$_html .= '<style type="text/css">
    				.table-settings{width:100%}
    				.table-settings tr td.l-set{text-align:right;width:50%;padding:5px 20px 5px 5px}
    				.table-settings tr td.r-set{text-align:left}
    				
    				</style>';			
    	
    	
    	$_html .= '<table class="table-settings">';
    	
    	
    	$_html .= '<tr>';
    	$_html .= '<td class="l-set">';
    	
    	$_html .= '<b>'.$this->l('Enable or Disable Product Reviews:').'</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td class="r-set">';
    	$_html .=  '
					<input type="radio" value="1" id="text_list_on" name="reviewson" onclick="enableOrDisableREVIEWS(1)"
							'.(Tools::getValue('reviewson', Configuration::get($this->name.'reviewson')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					<input type="radio" value="0" id="text_list_off" name="reviewson" onclick="enableOrDisableREVIEWS(0)"
						   '.(!Tools::getValue('reviewson', Configuration::get($this->name.'reviewson')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
				';
		
    	$_html .= '</div>';
    	
		$_html .= '<script type="text/javascript">
			    	function enableOrDisableREVIEWS(id)
						{
						if(id==0){
							$("#block-reviews-settings").hide(200);
						} else {
							$("#block-reviews-settings").show(200);
						}
							
						}
					</script>';
    	
		$_html .= '</td>';
		$_html .= '</tr>';
		$_html .= '</table>';
    	
		$_html .= '<div id="block-reviews-settings" '.(Configuration::get($this->name.'reviewson')==1?'style="display:block"':'style="display:none"').'>';
    	
		
    	$_html .= '<table class="table-settings">';
    	
    	
    	$_html .= '<tr>
    					<td style="text-align:right">
    						<label style="float:none">'.$this->l('Who can add reviews?').'</label>
						</td>
						<td>
							<table class="table-settings">
								<tr>
									<td width=4%>
										<input type="radio" value="all" id="all" name="settings"
											'.(Tools::getValue('settings', Configuration::get($this->name.'settings')) == "all" ? 'checked="checked" ' : '').'>
					  				</td>
					  				<td>'.$this->l('All Users').'</td>
								</tr>
								<tr>
									<td width=4%>
										<input type="radio" value="reg" id="reg" name="settings"
											'.(Tools::getValue('settings', Configuration::get($this->name.'settings')) == "reg" ? 'checked="checked" ' : '').'>
					  
									</td>
									<td>'.$this->l('Only registered users').'</td>
								</tr>
								<tr>
									<td width=4%>
										<input type="radio" value="buy" id="buy" name="settings"
								'.(Tools::getValue('settings', Configuration::get($this->name.'settings')) == "buy" ? 'checked="checked" ' : '').'>
					  
									</td>
									<td>'.$this->l('Only users who already bought the product').'</td>
								</tr>
								
								
							</table>
						</td>
				</tr>';
    	
    	
    	$_html .= '<tr>';
    	$_html .= '<td class="l-set">';
    	
    	$_html .= '<b>'.$this->l('The user can add more one review').':</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td class="r-set">';
		$_html .=  '
					<input type="radio" value="1" id="text_list_on" name="is_onereview"
							'.(Tools::getValue('is_onereview', Configuration::get($this->name.'is_onereview')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					<input type="radio" value="0" id="text_list_off" name="is_onereview"
						   '.(!Tools::getValue('is_onereview', Configuration::get($this->name.'is_onereview')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
				';
		$_html .= '</td>';
		$_html .= '</tr>';
    	
    	$_html .= '<tr>';
    	$_html .= '<td class="l-set">';
    	
    	$_html .= '<b>'.$this->l('Enable or Disable Captcha').':</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td class="r-set">';
		$_html .=  '
					<input type="radio" value="1" id="text_list_on" name="is_captcha"
							'.(Tools::getValue('is_captcha', Configuration::get($this->name.'is_captcha')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					<input type="radio" value="0" id="text_list_off" name="is_captcha"
						   '.(!Tools::getValue('is_captcha', Configuration::get($this->name.'is_captcha')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
				';
		$_html .= '</td>';
		$_html .= '</tr>';
    	
    	$_html .= '<tr>';
    	$_html .= '<td class="l-set">';
    	
    	$_html .= '<b>'.$this->l('MULTILANGUAGE. Separates different languages comments depended on the language selected by the customer (e.g. only English comments on the English site)').':</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td class="r-set">';
		$_html .=  '
					<input type="radio" value="1" id="text_list_on" name="switch_lng"
							'.(Tools::getValue('switch_lng', Configuration::get($this->name.'switch_lng')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					<input type="radio" value="0" id="text_list_off" name="switch_lng"
						   '.(!Tools::getValue('switch_lng', Configuration::get($this->name.'switch_lng')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
				';
		$_html .= '</td>';
		$_html .= '</tr>';
		
		
		
			// Enable or Disable stars for each reviews
    	$_html .= '<tr>';
    	$_html .= '<td class="l-set">';
    	
    	$_html .= '<b>'.$this->l('Enable or Disable stars on the category and search pages').':</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td class="r-set">
				
				
					<table cellpadding="0" cellspacing="0" width="40%">
					<tr>
					<td valign="top">
					<input type="radio" value="1" id="text_list_on" name="starscat" 
							'.(Tools::getValue('starscat', Configuration::get($this->name.'starscat')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					
					<input type="radio" value="0" id="text_list_off" name="starscat" 
						   '.(!Tools::getValue('starscat', Configuration::get($this->name.'starscat')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					</td>
					
					</tr>
					</table>
				';
    	$_html .= '</td>';
		$_html .= '</tr>';
    	// Enable or Disable stars for each reviews
    	
    	$_html .= '<tr>';
    	$_html .= '<td class="l-set">';
    	
    	$_html .= '<b>'.$this->l('Reviews per page on Frontend').':</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td class="r-set">';
		$_html .=  '
					<input type="text" name="revperpage"  
			               value="'.Tools::getValue('revperpage', Configuration::get($this->name.'revperpage')).'"
			               >
				';
		$_html .= '</td>';
		$_html .= '</tr>';
		
		$_html .= '<tr>';
    	$_html .= '<td class="l-set">';
    	
    	$_html .= '<b>'.$this->l('The number of items in the "Last Reviews":').'</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td class="r-set">';
		$_html .=  '
					<input type="text" name="revlast"  
			               value="'.Tools::getValue('revlast', Configuration::get($this->name.'revlast')).'"
			               >
				';
		$_html .= '</td>';
		$_html .= '</tr>';
    	
    	
    	$_html .= '<tr>';
    	$_html .= '<td class="l-set">';
    	
    	$_html .= '<b>'.$this->l('Position "Last Reviews" Block:').'</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td class="r-set">';
		$_html .=  '
					<select class="select" name="position" 
							id="position">
						<option '.(Tools::getValue('position', Configuration::get($this->name.'position'))  == "left" ? 'selected="selected" ' : '').' value="left">'.$this->l('Left').'</option>
						<option '.(Tools::getValue('position', Configuration::get($this->name.'position')) == "right" ? 'selected="selected" ' : '').' value="right">'.$this->l('Right').'</option>
						<option '.(Tools::getValue('position', Configuration::get($this->name.'position')) == "none" ? 'selected="selected" ' : '').' value="none">'.$this->l('None').'</option>
					</select>
				';
		$_html .= '</td>';
		$_html .= '</tr>';
		
		
		$_html .= '<tr>';
    	$_html .= '<td class="l-set">';
    	
    	$_html .= '<b>'.$this->l('Enable or Disable Block "Last Reviews" on Home page').':</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td class="r-set">';
		$_html .=  '
					<input type="radio" value="1" id="text_list_on" name="homeon"
							'.(Tools::getValue('homeon', Configuration::get($this->name.'homeon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					<input type="radio" value="0" id="text_list_off" name="homeon"
						   '.(!Tools::getValue('homeon', Configuration::get($this->name.'homeon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
				';
		$_html .= '</td>';
		$_html .= '</tr>';
		
		$_html .= '<tr>';
    	$_html .= '<td class="l-set">';
    	
    	$_html .= '<b>'.$this->l('Enable or Disable (X reviews) in Left Column, Right Column, Home page').':</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td class="r-set">';
		$_html .=  '
					<input type="radio" value="1" id="text_list_on" name="x_reviews"
							'.(Tools::getValue('x_reviews', Configuration::get($this->name.'x_reviews')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					<input type="radio" value="0" id="text_list_off" name="x_reviews"
						   '.(!Tools::getValue('x_reviews', Configuration::get($this->name.'x_reviews')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
				';
		$_html .= '</td>';
		$_html .= '</tr>';
		
		$_html .= '<tr>';
    	$_html .= '<td class="l-set">';
    	
    	$_html .= '<b>'.$this->l('Enable or Disable field "Subject":').'</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td class="r-set">';
		$_html .=  '
					<input type="radio" value="1" id="text_list_on" name="subjecton"
							'.(Tools::getValue('subjecton', Configuration::get($this->name.'subjecton')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					<input type="radio" value="0" id="text_list_off" name="subjecton"
						   '.(!Tools::getValue('subjecton', Configuration::get($this->name.'subjecton')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
				';
		$_html .= '</td>';
		$_html .= '</tr>';
		
		
		$_html .= '<tr>';
    	$_html .= '<td class="l-set">';
    	
    	$_html .= '<b>'.$this->l('Enable or Disable field "Recommended":').'</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td class="r-set">';
		$_html .=  '
					<input type="radio" value="1" id="text_list_on" name="recommendedon"
							'.(Tools::getValue('recommendedon', Configuration::get($this->name.'recommendedon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					<input type="radio" value="0" id="text_list_off" name="recommendedon"
						   '.(!Tools::getValue('recommendedon', Configuration::get($this->name.'recommendedon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
				';
		$_html .= '</td>';
		$_html .= '</tr>';
		
		
		$_html .= '<tr>';
    	$_html .= '<td class="l-set">';
    	
    	$_html .= '<b>'.$this->l('Enable or Disable field "IP":').'</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td class="r-set">';
		$_html .=  '
					<input type="radio" value="1" id="text_list_on" name="ipon"
							'.(Tools::getValue('ipon', Configuration::get($this->name.'ipon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					<input type="radio" value="0" id="text_list_off" name="ipon"
						   '.(!Tools::getValue('ipon', Configuration::get($this->name.'ipon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
				';
		$_html .= '</td>';
		$_html .= '</tr>';
		
		$_html .= '<tr>';
    	$_html .= '<td class="l-set">';
    	
    	$_html .= '<b>'.$this->l('Admin email:').'</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td class="r-set">';
		$_html .=  '
					<input type="text" name="mail_snip"  
			               value="'.Tools::getValue('mail_snip', Configuration::get($this->name.'mail_snip')).'"
			               >
				';
		$_html .= '</td>';
		$_html .= '</tr>';
		
		$_html .= '<tr>';
    	$_html .= '<td class="l-set">';
    	
    	$_html .= '<b>'.$this->l('E-mail notification:').'</b>';
    	
    	$_html .= '</td>';
    	$_html .= '<td class="r-set">';
		$_html .= '<input type = "checkbox" name = "noti_snip" id = "noti_snip" value ="1" '.((Tools::getValue($this->name.'noti_snip', Configuration::get($this->name.'noti_snip')) ==1)?'checked':'').'/>';
		$_html .= '</td>';
		$_html .= '</tr>';
		
		
		
		
		$_html .= '<tr>';
    	$_html .= '<td class="l-set">';
    	
    	
		$_html .= '<b>'.$this->l('Enable or Disable RSS Feed').':</b>';
    	
    	$_html .= '<script type="text/javascript">
			    	function enableOrDisableRSS(id)
						{
						if(id==0){
							$("#block-rss_snip-settings").hide(200);
						} else {
							$("#block-rss_snip-settings").show(200);
						}
							
						}
					</script>';
    	$_html .= '</td>';
    	$_html .= '<td class="r-set">';
    	
    	
    	$_html .=  '
					<input type="radio" value="1" id="text_list_on" name="rsson_snip" onclick="enableOrDisableRSS(1)"
							'.(Tools::getValue('rsson_snip', Configuration::get($this->name.'rsson_snip')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					
					<input type="radio" value="0" id="text_list_off" name="rsson_snip" onclick="enableOrDisableRSS(0)"
						   '.(!Tools::getValue('rsson_snip', Configuration::get($this->name.'rsson_snip')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
				';
		$_html .= '</td>';
		$_html .= '</tr>';
		$_html .= '<tr>';
    	$_html .= '<td colspan=2>';
    	
    	$_html .= '<div id="block-rss_snip-settings" '.(Configuration::get($this->name.'rsson_snip')==1?'style="display:block"':'style="display:none"').'>';
    	
    	$_html .= '<table class="table-settings">';
    	$_html .= '<tr>';
    	$_html .= '<td class="l-set">';
    	
    	
		
		$divLangName = "rssname_snip¤srssdesc_snip";
		
    	// Title of your RSS Feed
		
		$_html .= '<b>'.$this->l('Title of your RSS Feed').':</b>';
    	$_html .= '</td>';
    	$_html .= '<td class="r-set">';
    			
		
    		$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
	    	$languages = Language::getLanguages(false);
	    	
	    	foreach ($languages as $language){
			$id_lng = (int)$language['id_lang'];
	    	$rssname = Configuration::get($this->name.'rssname_snip'.'_'.$id_lng);
	    	
	    	
			$_html .= '	<div id="rssname_snip_'.$language['id_lang'].'" 
							 style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;"
							 >

						<input type="text" style="width:300px"   
								  id="rssname_snip_'.$language['id_lang'].'" 
								  name="rssname_snip_'.$language['id_lang'].'" 
								  value="'.htmlentities(stripslashes($rssname), ENT_COMPAT, 'UTF-8').'"/>
						</div>';
	    	}
			$_html .= '';
			ob_start();
			$this->displayFlags($languages, $defaultLanguage, $divLangName, 'rssname_snip');
			$displayflags = ob_get_clean();
			$_html .= $displayflags;
		
		
		
    	// Description of your RSS Feed
    	$_html .= '</td>';
		$_html .= '</tr>';
		$_html .= '<tr>';
    	$_html .= '<td class="l-set">';
		
		
    	$_html .= '<b>'.$this->l('Description of your RSS Feed').':</b>';
    	$_html .= '<td class="r-set">';
    			
    	
    		$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
	    	$languages = Language::getLanguages(false);
	    	
	    	foreach ($languages as $language){
			$id_lng = (int)$language['id_lang'];
	    	$rssdesc = Configuration::get($this->name.'rssdesc_snip_'.$id_lng);
	    	
	    	
			$_html .= '	<div id="srssdesc_snip_'.$language['id_lang'].'" 
							 style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;"
							 >

							 <input type="text" style="width:300px"   
								  id="rssdesc_snip_'.$language['id_lang'].'" 
								  name="rssdesc_snip_'.$language['id_lang'].'" 
								  value="'.htmlentities(stripslashes($rssdesc), ENT_COMPAT, 'UTF-8').'"/>
								  
					</div>';
	    	}
			$_html .= '';
			ob_start();
			$this->displayFlags($languages, $defaultLanguage, $divLangName, 'srssdesc_snip');
			$displayflags = ob_get_clean();
			$_html .= $displayflags;
			
		// Description of your RSS Feed
		
		$_html .= '</td>';
		$_html .= '</tr>';
		$_html .= '<tr>';
    	$_html .= '<td class="l-set">';
		
		
    	$_html .= '<b>'.$this->l('Number of items in RSS Feed').':</b>';

    	$_html .= '<td class="r-set">';
    	$_html .=  '
					<input type="text" name="n_rss_snip"  
			               value="'.Tools::getValue('n_rss_snip', Configuration::get($this->name.'n_rss_snip')).'"
			               >
				';
		
    	$_html .= '</td>';
		$_html .= '</tr>';
		
    	$_html .= '</table>';
		
		// last div
		$_html .= '</div>';
		
		$_html .= '</td>';
		$_html .= '</tr>';
		
		
		$_html .= '<tr>';
    	$_html .= '<td class="l-set" valign="top" style="padding-top:20px">';
		
		$_html .= '<b>'.$this->l('Send a review reminder email to customers').':</b>';
    	
    	$_html .= '<script type="text/javascript">
			    	function enableOrDisableReminder(id)
						{
						if(id==0){
							$("#block-reminder-settings").hide(200);
						} else {
							$("#block-reminder-settings").show(200);
						}
							
						}
					</script>';
    	
    	
    	$_html .= '</td>';
    	$_html .= '<td class="r-set" style="padding-top:20px">';
    	
    	//$_html .= '<div class="margin-form">';
    	$_html .=  '
					<input type="radio" value="1" id="text_list_on" name="reminder" onclick="enableOrDisableReminder(1)"
							'.(Tools::getValue('reminder', Configuration::get($this->name.'reminder')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					
					<input type="radio" value="0" id="text_list_off" name="reminder" onclick="enableOrDisableReminder(0)"
						   '.(!Tools::getValue('reminder', Configuration::get($this->name.'reminder')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
					<p class="clear">
					'.$this->l('If activated, when a customer purchases a product on your shop, an e-mail will be sent to him after X days (specify below after selecting "yes" here) to invite him to rate the product.').'
					<br/><br/>
					<b>'.$this->l('IMPORTANT NOTE').'</b>: '.$this->l('This requires to set a CRON task on your server. ').'
					<br/><br/>
					'._PS_BASE_URL_.__PS_BASE_URI__.'modules/'.$this->name.'/cron.php
					</p>
				
				';
		//$_html .= '</div>';
		$_html .= '</td>';
		$_html .= '</tr>';
		$_html .= '<tr>';
    	$_html .= '<td colspan=2>';
		
		$_html .= '<div id="block-reminder-settings" '.(Configuration::get($this->name.'reminder')==1?'style="display:block"':'style="display:none"').'>';
    	
		$_html .= '<table class="table-settings">';
    	$_html .= '<tr>';
    	$_html .= '<td class="l-set" valign="top">';
    	
		
		$_html .= '<b>'.$this->l('Delay for sending reminder email').':</b>';
		
		$_html .= '</td>';
    	$_html .= '<td class="r-set">';
		
		//$_html .= '<div class="margin-form">';
    	$_html .=  '
					<input type="text" name="delay"  
			               value="'.Tools::getValue('delay', Configuration::get($this->name.'delay')).'"
			               >&nbsp;('.$this->l('days').')
				';
		$_html .= '<p class="clear">'.$this->l('We recommend you enter at least 7 days here to have enough time to process the order and for the customer to receive it.').'</p>';
    	//$_html .= '</div>';
    	
    	
    	$_html .= '</td>';
		$_html .= '</tr>';
		$_html .= '<tr>';
    	$_html .= '<td class="l-set" valign="top">';
    	
    	
    	$divLangName = "emailreminder";
		
    	
		$_html .= '<b>'.$this->l('Email reminder subject ').':</b>';
    			
		$_html .= '</td>';
    	$_html .= '<td class="r-set">';
    	
		//$_html .= '<div class="margin-form">';
		
    		$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
	    	$languages = Language::getLanguages(false);
	    	
	    	foreach ($languages as $language){
			$id_lng = (int)$language['id_lang'];
	    	$rssname = Configuration::get($this->name.'emailreminder'.'_'.$id_lng);
	    	
	    	
			$_html .= '	<div id="emailreminder_'.$language['id_lang'].'" 
							 style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;"
							 >

						<input type="text" style="width:400px"   
								  id="emailreminder_'.$language['id_lang'].'" 
								  name="emailreminder_'.$language['id_lang'].'" 
								  value="'.htmlentities(stripslashes($rssname), ENT_COMPAT, 'UTF-8').'"/>
						</div>';
	    	}
			$_html .= '';
			ob_start();
			$this->displayFlags($languages, $defaultLanguage, $divLangName, 'emailreminder');
			$displayflags = ob_get_clean();
			$_html .= $displayflags;
			$_html .= '<div style="clear:both"></div>';
		
			$_html .= '<p class="clear">'.$this->l('You can customize the subject of the e-mail here.').' '
			. $this->l('If you wish to customize the e-mail message itself, you will need to manually edit the files in the')
			.'  "mails" '
			. $this->l(' folder inside the')
			.' "'.$this->name.'" '
			.$this->l('module folder, for each language, both the text and the HTML version each time. ').'</p>';
	    		
			$_html .= '</div>';
			
		
		//$_html .= '</div>';
		
			$_html .= '</td>';
		$_html .= '</tr>';
		
    	
		$_html .= '</table>';
			
		
		$_html .= '</td>';
		$_html .= '</tr>';
		
		
		
		$_html .= '</table>';
		
		
		$_html .= '</div>';
		
    	$_html .= $this->_updateButton(array('name'=>'submit_rev'));
    	
   		
    	$_html .=	'</fieldset>';
    	
    	
		$_html .= '<br/>';
    	
    	include_once(dirname(__FILE__).'/classes/importhelp.class.php');
		$obj = new importhelp();
    	if ($obj->ifExsitsTableProductcomments()){
    	$_html .= $this->_productComments();
    	}
    	
    	$_html .= '</form>';
    	
    	$_html .= '<br/>';
    	
    	return $_html;
	}
	
	
private function _productComments(){
    	include_once(dirname(__FILE__).'/classes/importhelp.class.php');
		$obj = new importhelp();

		$data_comments = $obj->getCountComments();
		
		$is_count_comments = $data_comments['is_count_comments'];
		$count_comments = $data_comments['comments'];
		
		$_html = '';
		$_html .= '<fieldset>
					<legend>'.$this->l('Tools').'</legend>';
    	
    	
    	$_html .= '<p class="hint clear" style="display: block; font-size: 11px; width: 95%;position:relative">
    				
    				'.$this->l('If you are already using PrestaShop "Product comments" module, you can import all your existing ratings and comments so as not to lose any of your history. ').'
                     <br/><br/>';
    	
    	if($is_count_comments>0){
    		   $_html .= $this->l('You have').' <b>'.$count_comments.'</b> '.$this->l('comments').' &nbsp;&nbsp;&nbsp; ';
        	   $_html .= '<input type="submit" value="'.$this->l('Import Product comments').'" name="submitcomments" class="button">';
    	} else{ 
    		
    		$_html .= '<b>'.$this->l('Your database no contains Product comments for imports').'</b>';
    	
    	} 
                     
         $_html .= '</p>';
    	
    	
    	$_html .= '</fieldset>';
    	
    	return $_html;
	    	
    }
    
	public function _drawProductReviews($_data_in = null){
		$cookie = $this->context->cookie;
		
		global $currentIndex;
		
		$currentIndex = isset($_data_in['currentindex'])?$_data_in['currentindex']:$currentIndex;
    	$controller = isset($_data_in['controller'])?$_data_in['controller']:'AdminModules';
    	$is_tab = isset($_data_in['is_tab'])?$_data_in['is_tab']:0;
    	
    	$token = isset($_data_in['token'])?$_data_in['token']:Tools::getAdminToken($controller.intval(Tab::getIdFromClassName($controller)).intval($cookie->id_employee));
    	
		
		include_once(dirname(__FILE__).'/classes/reviewshelp.class.php');
		$obj_reviewshelp = new reviewshelp();
		$_html = '';
		
		$j=0;
		
		$is_recommendedon = Configuration::get($this->name.'recommendedon');
		$is_subjecton = Configuration::get($this->name.'subjecton');
		$is_ipon = Configuration::get($this->name.'ipon');
		
		if(Tools::isSubmit("edit_item_rev")){
			
			$_data = $obj_reviewshelp->getItem(array('id'=>(int)Tools::getValue("id")));
    		
			$_html .= '<fieldset>
					<legend><img src="../modules/'.$this->name.'/i/settings_reviews.gif" />
					'.$this->l('Edit Product Review').'</legend>';
			
    		$_html .= '
    					<form method="post">';
    		
    		$subject = $_data['reviews'][0]['subject'];
    		$text_review = $_data['reviews'][0]['text_review'];
    		$date = $_data['reviews'][0]['date_add'];
    		$active = $_data['reviews'][0]['active'];
    		$id = $_data['reviews'][0]['id'];
    		$name = $_data['reviews'][0]['customer_name'];
    		$email = $_data['reviews'][0]['email'];
    		$ip = $_data['reviews'][0]['ip'];
    		$rating = $_data['reviews'][0]['rating'];
    		
    		$_html .= '<label>'.$this->l('ID:').'</label>';
    		$_html .= '<div style="padding:0 0 1em 210px;line-height:1.6em;">'.$id.'</div>';
    		
    		$_html .= '<label>'.$this->l('Customer name:').'</label>
    					<div class="margin-form" >
							<input type="text" name="name"  style="width:200px"
			                	   value="'.$name.'">
						</div>';	
    		$_html .= '<label>'.$this->l('Email:').'</label>
    					<div class="margin-form" >
							<input type="text" name="email"  style="width:200px"
			                	   value="'.$email.'">
						</div>';	
    		
    		$_html .= '<label '.($is_subjecton?'':'style="display:none"').'>'.$this->l('Subject:').'</label>
    					<div class="margin-form" '.($is_subjecton?'':'style="display:none"').'>
							<input type="text" name="subject"  style="width:200px"
			                	   value="'.$subject.'">
						</div>';
    		
    		$_html .= '<label>'.$this->l('Text:').'</label>
    					<div class="margin-form">
							<textarea name="text_review" cols="50" rows="10"  
			                	   >'.$text_review.'</textarea>
						</div>';
    		
    		$_html .= '<label>'.$this->l('Rating:').'</label>
    					<div class="margin-form" >
							<input type="text" name="rating"  style="width:200px"
			                	   value="'.$rating.'">
						</div>';
    		
    		$_html .= '<label '.($is_ipon?'':'style="display:none"').'>'.$this->l('IP:').'</label>';
    		$_html .= '<div style="padding:0 0 1em 210px;line-height:1.6em;'.($is_ipon?'':'display:none').'">'.(strlen($ip)>0?$ip:"&nbsp;").'</div>';
    		
    		$_html .= '<label>'.$this->l('Date Add:').'</label>';
    		$_html .= '<div style="padding:0 0 1em 210px;line-height:1.6em;">';
    		
    		$date_tmp = strtotime($date);
    		$date_tmp = date('Y-m-d',$date_tmp);
    		
    		//$_html .= $date_tmp;
    		$_html .= '<input type="hidden" name="date_add_old" value="'.$date_tmp.'" />';
    		
    		$_html .= '<input type="text" name="date_add" 
			                	   value="'.$date_tmp.'">&nbsp; YYYY-MM-DD';
    		$_html .= '</div>';
    		
    		
    		$_html .= '
				<label>'.$this->l('Publish').'</label>
				<div class = "margin-form" >';
				
			$_html .= '<input type = "checkbox" name = "publish" id = "publish" value ="1" '.(($active ==1)?'checked':'').'/>';
				
			$_html .= '</div>';
				
			$_html .= '<label>&nbsp;</label>
						<div class = "margin-form"  style="margin-top:20px">
						<input type="submit" name="cancel_item_rev" value="'.$this->l('Cancel').'" 
                		   class="button"  />&nbsp;&nbsp;&nbsp;
						<input type="submit" name="save_item_rev" value="'.$this->l('Save').'" 
                		   class="button"  />
                		  </div>';
			
    		$_html .= '</form>';
			
		} else {
			$_html .= '<fieldset>
					<legend><img src="../modules/'.$this->name.'/i/settings_reviews.gif" />
					'.$this->l('Moderate Product Reviews').'</legend>';
        	$_html .= '<table class="table" width=100% >';
    	
    		$_html .= '<tr>
    					<td style="width:20px;border-bottom:none;text-align:center;font-weight:bold;background-color:#F4E6C9">'.$this->l('Id').'</td>
    			        <td style="width:60px;border-bottom:none;text-align:center;font-weight:bold;background-color:#F4E6C9">'.$this->l('Customer Name').'</td>';
    		if($this->_is16!=1)
    			$_html .= '<td style="width:60px;border-bottom:none;text-align:center;font-weight:bold;background-color:#F4E6C9">'.$this->l('Email').'</td>';
    		$_html .= '<td style="width:60px;border-bottom:none;text-align:center;font-weight:bold;background-color:#F4E6C9">'.$this->l('Product Name').'</td>
    			        <td style="width:60px;border-bottom:none;text-align:center;font-weight:bold;background-color:#F4E6C9">'.$this->l('Date').'</td>';
		if($is_ipon){	        
    		$_html .=  '<td style="width:60px;border-bottom:none;text-align:center;font-weight:bold;background-color:#F4E6C9">'.$this->l('IP').'</td>';
    		}
    		if($is_subjecton){	        
    		$_html .=  '<td style="width:60px;border-bottom:none;text-align:center;font-weight:bold;background-color:#F4E6C9">'.$this->l('Subject').'</td>';
    		}
    		//$_html .=  '<td style="width:20px;border-bottom:none;text-align:center;font-weight:bold;background-color:#F4E6C9">'.$this->l('Text').'</td>';
    		$_html .= '<td style="width:10px;border-bottom:none;text-align:center;font-weight:bold;background-color:#F4E6C9">'.$this->l('Rating').'</td>
    			        <td style="width:40px;border-bottom:none;text-align:center;font-weight:bold;background-color:#F4E6C9">'.$this->l('Publish').'</td>
    			        <td style="width:40px;border-bottom:none;text-align:center;font-weight:bold;background-color:#F4E6C9">'.$this->l('Action').'</td>
    			        
    			   </tr>';
    		
    		$start = (int)Tools::getValue("page_rev");
    		
    		$data_in = $obj_reviewshelp->getAllReviews(array('start' => $start));
    		
    		$paging = $obj_reviewshelp->PageNavAdmin($start,$data_in['count_all_reviews'],$obj_reviewshelp->getStepForAdminReviewsAll(), 
											array('admin' => 1,'currentIndex'=>$currentIndex,
												  'token' => '&configure='.$this->name.'&token='.$token,
												));
    
    		
	    	$data = $data_in['reviews'];
	    	$count_all_reviews = $data_in['count_all_reviews'];
	    	if(sizeof($data)>0){
	    		
	    		for($i=0;$i<sizeof($data);$i++){
	    		$j++;
	    		
	    		$id = $data[$i]['id'];
	    		$customer_name = $data[$i]['customer_name'];
				$date = date('Y-m-d',strtotime($data[$i]['date_add']));
				$subject = $data[$i]['subject'];
				$text_review  = $data[$i]['text_review'];
				$product_name = $data[$i]['product_name'];
				$active = $data[$i]['active'];
				$ip = $data[$i]['ip'];
				$email = $data[$i]['email'];
				$rating = $data[$i]['rating'];
				$product_link = $data[$i]['product_link'];
				$product_image = $data[$i]['product_image'];
				
				$_html .= '<tr>
							<td style="width:20px;text-align:center">'.$id.'</td>
		    				<td style="width:60px;text-align:center">'.$customer_name.'</td>';
				if($this->_is16!=1)
		    		$_html .= '<td style="width:60px;text-align:center">'.$email.'</td>';
		    	$_html .= '<td style="width:60px;text-align:center">';
		    	$_html .= '<table width="100%">';
		    	$_html .= '<tr><td style="border-bottom:none;">';
				$_html .= '<img src="'.$product_image.'" width="50" style="float:left" />';
				$_html .= '</td><td  style="border-bottom:none;">';
		    	$_html .= '<a href="'.$product_link.'" target="_blank" style="float:left;font-size: 12px; text-decoration: underline;">
		    				'.$product_name.'
		    				</a>';
		    	$_html .= '</td></tr>';
		    	$_html .= '</table>';
		    	$_html .= '<div style="clear:both"></div>';
		    	
		    	$_html .= '</td>
		    				<td style="width:60px;text-align:center"> '.$date.'</td>';
	    		if($is_ipon){
		    	$_html .=   '<td style="width:60px;text-align:center">'.$ip.'</td>';
				}
				if($is_subjecton){
		    	$_html .=   '<td style="width:60px;text-align:center">'.$subject.'</td>';
				}
				
				//$_html .= 	'<td style="width:20px;">'.(strlen($text_review)>20?substr($text_review,0,20)."...":$text_review).'</td>';
		    			$_html .= '<td style="width:10px;text-align:center">'.$rating.'</td>
		    				<td style="text-align:center">
			    <form action="'.$currentIndex.'&configure='.$this->name.'&token='.$token.'&page='.$start.'" method="post">
							   		<input type="hidden" name="id" value="'.$id.'" />';
				
				    		 if ($active == 1) {
								$_html .= '<input type = "submit" name = "submit_item_rev" value = "Unpublish" 
												  class = "button unpublished"/>';
							 }
							 else{
								$_html .= '<input type = "submit" name = "submit_item_rev" value = "Publish" 
												  class = "button published"/>';
							 }
				
					$_html .= '</form>
								</td>
			    				<td style="width:7%">';
			    				$_html .= '
								 		   <a href="'.$currentIndex.(($is_tab == 0)?'&configure='.$this->name:'').'&token='.$token.'&edit_item_rev&id='.(int)($id).'&page='.$start.'" title="'.$this->l('Edit').'"><img src="'._PS_ADMIN_IMG_.'edit.gif" alt="" /></a> 
				 						   <a href="'.$currentIndex.'&configure='.$this->name.'&token='.$token.'&submit_item_rev=delete&id='.(int)($id).'&page='.$start.'" title="'.$this->l('Delete').'"  onclick = "javascript:return confirm(\''.$this->l('Are you sure you want to remove this item?').'\');"><img src="'._PS_ADMIN_IMG_.'delete.gif" alt="" /></a>'; 
				
			    				$_html .= '</td>
			    				
		    			   </tr>
		    			   ';
	    		}
	    		
	    	} else {
    		$_html .= '<tr>
    					<td colspan=11 style="border-bottom:none;text-align:center;padding:10px">'.$this->l('No reviews for moderate.').'</td>
    				   </tr>';
    		}
		}
		
		$_html .= '</table>';
		
		if($j!=0){
    	$_html .= '<div style="margin:5px">';
    	$_html .= $paging;
    	$_html .= '</div>';
    	}
		
    	
		
    	
    	return $_html;
    }
    

    
    
	public function _drawAddCategoryForm($data = null){
		$cookie = $this->context->cookie;
		
		global $currentIndex;
		$currentIndex = isset($data['currentindex'])?$data['currentindex']:$currentIndex;
    	$controller = isset($data['controller'])?$data['controller']:'AdminModules';
    	$is_tab = isset($data['is_tab'])?$data['is_tab']:0;
    	
    	$token = isset($data['token'])?$data['token']:Tools::getAdminToken($controller.intval(Tab::getIdFromClassName($controller)).intval($cookie->id_employee));
    	
    	
		$action = isset($data['action'])?$data['action']:'';
		$id = isset($data['id'])?$data['id']:0;
		
		$title = '';
		$seo_description = '';
		$seo_keywords = '';
		$button = $this->l('Add Category');
		$title_block = $this->l('Add Category');
		
		if($action == 'edit'){
			include_once(dirname(__FILE__).'/classes/blog.class.php');
			$obj_blog = new bloghelp();
			$_data = $obj_blog->getCategoryItem(array('id'=>$id,'admin'=>1));
			$button = $this->l('Update Category');
			$title_block = $this->l('Edit Category');
		}
		
		$divLangName = "category_title¤category_seokeywords¤category_seodescription";
		
		$_html = '';
    	$_html .= '<form method="post" 
    					action="'.$currentIndex.'&configure='.$this->name.'&token='.$token.'" 
    					enctype="multipart/form-data">';
    	
    	
    	$_html .= '<fieldset >
					<legend><img src="../modules/'.$this->name.'/img/logo-blog.gif" />'.$title_block.'</legend>';
		
    	$_html .= '<label>'.$this->l('Title').'</label>';

    	$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
	    $languages = Language::getLanguages(false);
    	
    	$_html .= '<div class="margin-form">';
    	
		foreach ($languages as $language){
			$id_lng = (int)$language['id_lang'];
	    	$title = isset($_data['category']['data'][$id_lng]['title'])?$_data['category']['data'][$id_lng]['title']:"";
	    	
			$_html .= '	<div id="category_title_'.$language['id_lang'].'" 
							 style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;"
							 >

						<input type="text" style="width:400px"   
								  id="category_title_'.$language['id_lang'].'" 
								  name="category_title_'.$language['id_lang'].'" 
								  value="'.htmlentities(stripslashes($title), ENT_COMPAT, 'UTF-8').'"/>
						</div>';
	    	}
		ob_start();
		$this->displayFlags($languages, $defaultLanguage, $divLangName, 'category_title');
		$displayflags = ob_get_clean();
		$_html .= $displayflags;
		$_html .= '<div style="clear:both"></div>';
			        
		$_html .=  '</div>';

		// identifier
		$cookie = $this->context->cookie;
		
		$current_lng =  $cookie->id_lang;
		$seo_url = isset($_data['category']['data'][$current_lng]['seo_url'])?$_data['category']['data'][$current_lng]['seo_url']:"";
	   
		if(Configuration::get($this->name.'urlrewrite_on') == 1){
		 	
		$_html .= '<label>'.$this->l('Identifier (SEO URL)').'</label>';
    	
    	$_html .= '<div class="margin-form">';
    	
			
			$_html .= '
						<input type="text" style="width:400px"   
								  id="seo_url" 
								  name="seo_url" 
								  value="'.$seo_url.'"/>
						<p>(eg: domain.com/blog/category/identifier)</p>
						';
	    $_html .=  '</div>';
		} else {
			$_html .= '<input type="hidden" name="seo_url" value="'.$seo_url.'" />';
		}
		 
    	$_html .= '<label>'.$this->l('SEO Keywords').'</label>';
    			
    	
    	$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
	    $languages = Language::getLanguages(false);
    	
    	$_html .= '<div class="margin-form">';
    	
		foreach ($languages as $language){
			$id_lng = (int)$language['id_lang'];
	    	$seo_keywords = isset($_data['category']['data'][$id_lng]['seo_keywords'])?$_data['category']['data'][$id_lng]['seo_keywords']:"";
	    	
			$_html .= '	<div id="category_seokeywords_'.$language['id_lang'].'" 
							 style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;"
							 >
						<textarea cols="50" rows="10"  
			                	  id="category_seokeywords_'.$language['id_lang'].'" 
								  name="category_seokeywords_'.$language['id_lang'].'"
								  >'.htmlentities(stripslashes($seo_keywords), ENT_COMPAT, 'UTF-8').'</textarea>
						</div>';
	    	}
		ob_start();
		$this->displayFlags($languages, $defaultLanguage, $divLangName, 'category_seokeywords');
		$displayflags = ob_get_clean();
		$_html .= $displayflags;
		$_html .= '<div style="clear:both"></div>';
		
    	$_html .=  '</div>';
    	
    	
    	$_html .= '<label>'.$this->l('SEO Description').'</label>';
    			
    	
    	$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
	    $languages = Language::getLanguages(false);
    	
    	$_html .= '<div class="margin-form">';
    	
		foreach ($languages as $language){
			$id_lng = (int)$language['id_lang'];
	    	$seo_description = isset($_data['category']['data'][$id_lng]['seo_description'])?$_data['category']['data'][$id_lng]['seo_description']:"";
	    	
			$_html .= '	<div id="category_seodescription_'.$language['id_lang'].'" 
							 style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;"
							 >
						<textarea cols="50" rows="10"  
			                	  id="category_seodescription_'.$language['id_lang'].'" 
								  name="category_seodescription_'.$language['id_lang'].'"
								  >'.htmlentities(stripslashes($seo_description), ENT_COMPAT, 'UTF-8').'</textarea>
						</div>';
	    	}
		ob_start();
		$this->displayFlags($languages, $defaultLanguage, $divLangName, 'category_seodescription');
		$displayflags = ob_get_clean();
		$_html .= $displayflags;
		$_html .= '<div style="clear:both"></div>';
		
    	$_html .=  '</div>';
    	
    	
    	
    	
    	if($this->_is15){
    	// shop association
    	$_html .= '<div class="clear"></div>';
    	$_html .= '<label>'.$this->l('Shop association').':</label>';
    	$_html .= '<div class="margin-form">';

		$_html .= '<table width="50%" cellspacing="0" cellpadding="0" class="table">
						<tr>
							<th>Shop</th>
						</tr>';
		$u = 0;
		
		$shops = Shop::getShops();
		$shops_tmp = explode(",",isset($_data['category'][0]['ids_shops'])?$_data['category'][0]['ids_shops']:"");
		
		$count_shops = sizeof($shops);
		foreach($shops as $_shop){
			$id_shop = $_shop['id_shop'];
			$name_shop = $_shop['name'];
			 $_html .= '<tr>
						<td>
							<img src="../img/admin/lv2_'.((($count_shops-1)==$u)?"f":"b").'.png" alt="" style="vertical-align:middle;">
							<label class="child">';
		 
			
				$_html .= '<input type="checkbox"  
								   name="cat_shop_association[]" 
								   value="'.$id_shop.'" '.((in_array($id_shop,$shops_tmp))?'checked="checked"':'').' 
								   class="input_shop" 
								   />
								'.$name_shop.'';
				
				$_html .= '</label>
						</td>
					</tr>';
		 $u++;
		}
	
		$_html .= '</table>';
			
		$_html .= '</div>';
																
    	}
    	// shop association
    	
		$_html .= '</fieldset>';
    	
		if($action == 'edit'){
		$_html .= '<input type = "hidden" name = "id_editcategory" value = "'.$id.'"/>';
    	$_html .= '<p class="center" style="text-align:center;background: none; padding: 10px; margin-top: 10px;">
					<input type="submit" name="cancel_editcategory" value="'.$this->l('Cancel').'" 
                		   class="button"  />
    				<input type="submit" name="submit_editcategory" value="'.$button.'" 
                		   class="button"  />
                	
                	</p>';
		} else {
		$_html .= '<p class="center" style="text-align:center;background: none; padding: 10px; margin-top: 10px;">
					<input type="submit" name="cancel_editcategory" value="'.$this->l('Cancel').'" 
                		   class="button"  />
					<input type="submit" name="submit_addcategory" value="'.$button.'" 
                		   class="button"  />
                	</p>';
			
		}
    	$_html .= '</form>';
    	
    	if($action == 'edit'){
    		if($controller == 'AdminModules')
    		$_html .= $this->_drawPosts(array('edit'=>1,'id_category'=>$id,
    										 ));
    		else
    		$_html .= $this->_drawPosts(array('edit'=>1,'id_category'=>$id,
    										  'currentindex' => 'index.php?tab=AdminBlockblogPosts',
    										  'controller'=>'AdminBlockblogPosts')
    									);
    	}
    	
    	return $_html;
    }
    
    
	public function _drawAddPostForm($data = null){
		$cookie = $this->context->cookie;
		
		global $currentIndex;
		$currentIndex = isset($data['currentindex'])?$data['currentindex']:$currentIndex;
    	$controller = isset($data['controller'])?$data['controller']:'AdminModules';
    	
    	$token = isset($data['token'])?$data['token']:Tools::getAdminToken($controller.intval(Tab::getIdFromClassName($controller)).intval($cookie->id_employee));
    	
		
		include_once(dirname(__FILE__).'/classes/blog.class.php');
		$obj_blog = new bloghelp();
		
		
		$action = isset($data['action'])?$data['action']:'';
		$id = isset($data['id'])?$data['id']:0;
		
		
		$id_category = array();
		$title = '';
		$seo_description = '';
		$seo_keywords = '';
		$content = '';
		$status = 1;
		$is_comments = 1;
		$button = $this->l('Add Post');
		$title_block = $this->l('Add Post');
		$img = '';
		
		if($action == 'edit'){
			$_data = $obj_blog->getPostItem(array('id'=>$id));
			$id_category=$_data['post'][0]['category_ids'];

			$img = $_data['post'][0]['img'];
			$status = $_data['post'][0]['status'];
			$is_comments = $_data['post'][0]['is_comments'];
			$time_add = $_data['post'][0]['time_add'];
			
			$button = $this->l('Update Post');
			$title_block = $this->l('Edit Post');
		}
		
		$divLangName = "ccontent¤post_title¤post_seokeywords¤post_seodescription";
		
    	$_html = '';
    	$_html .= '<form method="post" action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'" enctype="multipart/form-data"
    	style="overflow:auto">';
    	
    	$_html .= '<fieldset >
					<legend><img src="../modules/'.$this->name.'/img/logo-blog.gif" />'.$title_block.'</legend>';
		
    	$_html .= '<label style="width:120px">'.$this->l('Title').'</label>';
    			
    	
    	
    	$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
	    $languages = Language::getLanguages(false);
    	
    	$_html .= '<div class="margin-form" style="padding: 0pt 0pt 10px 130px;">';
    	
		foreach ($languages as $language){
			$id_lng = (int)$language['id_lang'];
	    	$title = isset($_data['post']['data'][$id_lng]['title'])?$_data['post']['data'][$id_lng]['title']:"";
	    	
			$_html .= '	<div id="post_title_'.$language['id_lang'].'" 
							 style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;"
							 >

						<input type="text" style="width:400px"   
								  id="post_title_'.$language['id_lang'].'" 
								  name="post_title_'.$language['id_lang'].'" 
								  value="'.htmlentities(stripslashes($title), ENT_COMPAT, 'UTF-8').'"/>
						</div>';
	    	}
		ob_start();
		$this->displayFlags($languages, $defaultLanguage, $divLangName, 'post_title');
		$displayflags = ob_get_clean();
		$_html .= $displayflags;
		$_html .= '<div style="clear:both"></div>';
			        
		$_html .=  '</div>';
    	
    
	if(Configuration::get($this->name.'urlrewrite_on') == 1){
		// identifier
		$cookie = $this->context->cookie;
		
		$current_lng =  $cookie->id_lang;
		$seo_url = isset($_data['post']['data'][$current_lng]['seo_url'])?$_data['post']['data'][$current_lng]['seo_url']:"";
	    	
		$_html .= '<label style="width:120px">'.$this->l('Identifier (SEO URL)').'</label>';
    	
    	$_html .= '<div class="margin-form" style="padding: 0pt 0pt 10px 130px;">';
    	
			
			$_html .= '
						<input type="text" style="width:400px"   
								  id="seo_url" 
								  name="seo_url" 
								  value="'.$seo_url.'"/>
						<p>(eg: domain.com/blog/post/identifier)</p>
						';
	    $_html .=  '</div>';
		}
		
    	$_html .= '<label style="width:120px">'.$this->l('SEO Keywords').'</label>';
    			
    	
    	
    	$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
	    $languages = Language::getLanguages(false);
    	
    	$_html .= '<div class="margin-form" style="padding: 0pt 0pt 10px 130px;">';
    	
		foreach ($languages as $language){
			$id_lng = (int)$language['id_lang'];
	    	$seo_keywords = isset($_data['post']['data'][$id_lng]['seo_keywords'])?$_data['post']['data'][$id_lng]['seo_keywords']:"";
	    	
			$_html .= '	<div id="post_seokeywords_'.$language['id_lang'].'" 
							 style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;"
							 >
						<textarea id="post_seokeywords_'.$language['id_lang'].'" 
								  name="post_seokeywords_'.$language['id_lang'].'" 
								  cols="50" rows="10"  
			                	   >'.htmlentities(stripslashes($seo_keywords), ENT_COMPAT, 'UTF-8').'</textarea>
						
						</div>';
	    	}
		ob_start();
		$this->displayFlags($languages, $defaultLanguage, $divLangName, 'post_seokeywords');
		$displayflags = ob_get_clean();
		$_html .= $displayflags;
		$_html .= '<div style="clear:both"></div>';
			        
		$_html .=  '</div>';
			        
		
    	
    	$_html .= '<label style="width:120px">'.$this->l('SEO Description').'</label>';
    			
    	
    	
    	$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
	    $languages = Language::getLanguages(false);
    	
    	$_html .= '<div class="margin-form" style="padding: 0pt 0pt 10px 130px;">';
    	
		foreach ($languages as $language){
			$id_lng = (int)$language['id_lang'];
	    	$seo_description = isset($_data['post']['data'][$id_lng]['seo_description'])?$_data['post']['data'][$id_lng]['seo_description']:"";
	    	
			$_html .= '	<div id="post_seodescription_'.$language['id_lang'].'" 
							 style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;"
							 >
						<textarea id="post_seodescription_'.$language['id_lang'].'" 
								  name="post_seodescription_'.$language['id_lang'].'" 
								  cols="50" rows="10"  
			                	   >'.htmlentities(stripslashes($seo_description), ENT_COMPAT, 'UTF-8').'</textarea>
						
						</div>';
	    	}
		ob_start();
		$this->displayFlags($languages, $defaultLanguage, $divLangName, 'post_seodescription');
		$displayflags = ob_get_clean();
		$_html .= $displayflags;
		$_html .= '<div style="clear:both"></div>';
			        
		$_html .=  '</div>';
			        
		
    	
    	
    	if(defined('_MYSQL_ENGINE_')){
    	$_html .= '<label style="width:50px">'.$this->l('Content').'</label>';
    	
    	$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
	    $languages = Language::getLanguages(false);
    	
    	$_html .= '<div class="margin-form" style="padding: 0pt 0pt 10px 50px;">';
    	
		foreach ($languages as $language){
			$id_lng = (int)$language['id_lang'];
			$content = isset($_data['post']['data'][$id_lng]['content'])?$_data['post']['data'][$id_lng]['content']:"";
	    	
			$_html .= '	<div id="ccontent_'.$language['id_lang'].'" 
							 style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;"
							 >
						<textarea id="content_'.$language['id_lang'].'" 
								  name="content_'.$language['id_lang'].'" 
								  class="rte" cols="30" rows="30"  
			                	   >'.htmlentities(stripslashes($content), ENT_COMPAT, 'UTF-8').'</textarea>
						
						</div>';
	    	}
		ob_start();
		$this->displayFlags($languages, $defaultLanguage, $divLangName, 'ccontent');
		$displayflags = ob_get_clean();
		$_html .= $displayflags;
		$_html .= '<div style="clear:both"></div>';
			        
		$_html .=  '</div>';
    	
    	}else{
    		$_html .= '<label style="width:120px">'.$this->l('Content').'</label>';
    		
    		
    		
    		$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
		    $languages = Language::getLanguages(false);
	    	
	    	$_html .= '<div class="margin-form" style="padding: 0pt 0pt 10px 50px;">';
	    	
			foreach ($languages as $language){
				$id_lng = (int)$language['id_lang'];
		    	$content = isset($_data['post']['data'][$id_lng]['content'])?$_data['post']['data'][$id_lng]['content']:"";
		    	
				$_html .= '	<div id="ccontent_'.$language['id_lang'].'" 
								 style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;"
								 >
							<textarea id="content_'.$language['id_lang'].'" 
									  name="content_'.$language['id_lang'].'" 
									  class="rte" cols="30" rows="30"  
				                	   >'.htmlentities(stripslashes($content), ENT_COMPAT, 'UTF-8').'</textarea>
							
							</div>';
		    	}
			ob_start();
			$this->displayFlags($languages, $defaultLanguage, $divLangName, 'ccontent');
			$displayflags = ob_get_clean();
			$_html .= $displayflags;
			$_html .= '<div style="clear:both"></div>';
				        
			$_html .=  '</div>';
    	}
    	
    	$_html .= '<label style="width:120px">'.$this->l('Logo Image').'</label>
    			
    				<div class="margin-form" style="padding: 0pt 0pt 10px 130px;">
					<input type="file" name="post_image" id="post_image" ';
    	if($this->_is16 == 0){
    	 $_html .= 'class="customFileInput"';
    	} 
    	 $_html .= '/>
					<p>Allow formats *.jpg; *.jpeg; *.png; *.gif.</p>';

    	
    	if(strlen($img)>0){
    	$_html .= '<div id="post_images_list">';
    		$_html .= '<div style="float:left;margin:10px" id="post_images_id">';
    		$_html .= '<table width=100%>';
    		
    		$_html .= '<tr><td align="left">';
    			$_html .= '<input type="radio" checked name="post_images"/>';
    		
    		$_html .= '</td>';
    		
    		$_html .= '<td align="right">';
    		
    			$_html .= '<a href="javascript:void(0)" title="'.$this->l('Delete').'"  
    						onclick = "delete_img('.$id.');"><img src="'._PS_ADMIN_IMG_.'delete.gif" alt="" /></a>
    					';
    		
    		$_html .= '</td>';
    		
    		$_html .= '<tr>';
    		$_html .= '<td colspan=2>';
    		$_html .= '<img src="../upload/blockblog/'.$img.'" style="width:50px;height:50px"/>';
    		$_html .= '</td>';
    		$_html .= '</tr>';
    		
    		$_html .= '</table>';
    		
    		$_html .= '</div>';
    	
    	$_html .= '<div style="clear:both"></div>';
    	$_html .= '</div>';
    	}
    	
    	$_html .= '</div>';
    	
    	
		$_data_cat  = $obj_blog->getCategories(array('admin'=>1)); 
		
    	$_html .= '<label style="width:120px">'.$this->l('Select categories').'</label>
    					<div class="margin-form" style="padding: 0pt 0pt 10px 130px;">';
		
    	/*$_html .= '<select name="ids_categories[]" multiple="multiple" size="10" style="width:400px">';
		foreach($_data_cat['categories'] as $_item){
		    					
		    	$name = isset($_item['title'])?$_item['title']:'';
		    	$id_pr = isset($_item['id'])?$_item['id']:'';
		    	if(strlen($name)==0) continue;
		    	
		    	if(in_array($id_pr,$id_category))
		    		$_html .= '<option  value="'.$id_pr.'" selected>'.$name.'</option>';
		    	else
		    		$_html .= '<option  value="'.$id_pr.'">'.$name.'</option>';
		    	
		}
    	$_html .= '</select>';				
		*/
		
		$_html .= '
		<div style="height:140px; overflow-x:hidden; overflow-y:scroll; padding:0;" class="margin-form">
		
		<table cellspacing="0" cellpadding="0" style="min-width:500px;" class="table">
            <tr>
				<th style="width:40px;"></th>
				<th style="width:30px;">ID</th>
				<th>'.$this->l('Title').'</th>
				<th>'.$this->l('Lang').'</th>
            </tr>';
            
	$y=0;	
	foreach($_data_cat['categories'] as $_item){
		$name = isset($_item['title'])?$_item['title']:'';
		$id_pr = isset($_item['id'])?$_item['id']:'';
		
		$ids_lng = isset($_item['ids_lng'])?$_item['ids_lng']:array();
		$lang_for_category = array();
		foreach($ids_lng as $lng_id){
			$data_lng = Language::getLanguage($lng_id);
			$lang_for_category[] = $data_lng['iso_code']; 
		}
		$lang_for_category = implode(",",$lang_for_category);
		
		if(strlen($name)==0) continue;
		
       $_html .= '
       		<tr class="'.(($y%2==0)?'':'alt_row').'">
				<td>
					<input type="checkbox" value="'.$id_pr.'"  id="groupRelated_'.$id_pr.'"
						   class="groupBox" name="ids_categories[]"
						   '.(in_array($id_pr,$id_category)?'checked="checked"':'').' />
				</td>
				<td>'.$id_pr.'</td>
				<td><label class="t" for="groupRelated_'.$id_pr.'">'.$name.'</label></td>
				<td>'.$lang_for_category.'</td>
			</tr>';
       $y++;
	}
	

       $_html .= '
       </table>
									
		</div>';
		
		
		$_html .=  '</div>';
		
		
		
		$_html .= '<label style="width:120px">'.$this->l('Status').'</label>
				<div class = "margin-form" style="padding: 0pt 0pt 10px 130px;">';
				
		$_html .= '<select name="post_status" style="width:100px">
					<option value=1 '.(($status==1)?"selected=\"true\"":"").'>'.$this->l('Enabled').'</option>
					<option value=0 '.(($status==0)?"selected=\"true\"":"").'>'.$this->l('Disabled').'</option>
				   </select>';
			
				
			$_html .= '</div>';
			
		$_html .= '<label style="width:120px">'.$this->l('Enable Comments').'</label>
				<div class = "margin-form" style="padding: 0pt 0pt 10px 130px;">';
		
		$_html .= '<select name="post_iscomments" style="width:100px">
					<option value=1 '.(($is_comments==1)?"selected=\"true\"":"").'>'.$this->l('Enabled').'</option>
					<option value=0 '.(($is_comments==0)?"selected=\"true\"":"").'>'.$this->l('Disabled').'</option>
				   </select>';
				
			$_html .= '</div>';
			
		
		$_html .= '<div class="clear"></div>';	
		$_html .= '<label style="width:120px">'.$this->l('Publication Date').':</label>';
    	$_html .= '<div class="margin-form" style="padding: 0pt 0pt 10px 130px;">';
    	
    	$date_tmp = '';
    	if(isset($time_add)){
    	$date_tmp = strtotime($time_add);
    	$date_tmp = date('d-m-Y',$date_tmp);
    	} else {
    		$date_tmp = date('d-m-Y');
    	}
    	
    	
    	$_html .= '<input type="hidden" name="date_add_old" value="'.$date_tmp.'" />';
    		
    		
    	$_html .= '<input type="text" name="time_add" 
			                	   value="'.$date_tmp.'">&nbsp; DD-MM-YYYY';
    	$_html .=  '</div>';
    	
    	
			
		if($this->_is15){
    	// shop association
    	$_html .= '<div class="clear"></div>';
    	$_html .= '<label style="width:120px">'.$this->l('Shop association').':</label>';
    	$_html .= '<div class="margin-form" style="padding: 0pt 0pt 10px 130px;">';

		$_html .= '<table width="50%" cellspacing="0" cellpadding="0" class="table">
						<tr>
							<th>Shop</th>
						</tr>';
		$u = 0;
		
		$shops = Shop::getShops();
		$shops_tmp = explode(",",isset($_data['post'][0]['ids_shops'])?$_data['post'][0]['ids_shops']:"");
		
		$count_shops = sizeof($shops);
		foreach($shops as $_shop){
			$id_shop = $_shop['id_shop'];
			$name_shop = $_shop['name'];
			 $_html .= '<tr>
						<td>
							<img src="../img/admin/lv2_'.((($count_shops-1)==$u)?"f":"b").'.png" alt="" style="vertical-align:middle;">
							<label class="child">';
		 
			
				$_html .= '<input type="checkbox"  
								   name="cat_shop_association[]" 
								   value="'.$id_shop.'" '.((in_array($id_shop,$shops_tmp))?'checked="checked"':'').' 
								   class="input_shop" 
								   />
								'.$name_shop.'';
				
				$_html .= '</label>
						</td>
					</tr>';
		 $u++;
		}
	
		$_html .= '</table>';
			
		$_html .= '</div>';
																
    	}
    	// shop association
    	
		$_html .= '</fieldset>';
    	
		
		if($action == 'edit'){
		$_html .= '<input type = "hidden" name = "id_editposts" value = "'.$id.'"/>';
    	$_html .= '<p class="center" style="text-align:center;background: none; padding: 10px; margin-top: 10px;">
					<input type="submit" name="cancel_editposts" value="'.$this->l('Cancel').'" 
                		   class="button"  />
    				<input type="submit" name="submit_editposts" value="'.$button.'" 
                		   class="button"  />
                	
                	</p>';
		} else {
		$_html .= '<p class="center" style="text-align:center;background: none; padding: 10px; margin-top: 10px;">
				<input type="submit" name="cancel_editposts" value="'.$this->l('Cancel').'" 
                		   class="button"  />
    				
					<input type="submit" name="submit_addpost" value="'.$button.'" 
                		   class="button"  />
                	</p>';
			
		}
		
    	
    	$_html .= '</form>';
    	
		/*if($action == 'edit'){
    		$_html .= $this->_drawComments(array('edit'=>1,'id_posts'=>$id));
    	}*/
    	
		if($action == 'edit'){
			if($controller == 'AdminModules'){
    		$_html .= $this->_drawComments(array('edit'=>1,'id_posts'=>$id));
    		} else {
    			$controller = 'AdminBlockblogComments';
    		$_html .= $this->_drawComments(array('edit'=>1,
    											 'id_posts'=>$id,
    										     'currentindex' => 'index.php?tab=AdminBlockblogComments',
    										  //'currentindex' => Tools::getAdminToken($controller.intval(Tab::getIdFromClassName($controller)).intval($cookie->id_employee)),
    										     'controller'=>$controller
    											)
    									);
    		}
    	}
    	
    	return $_html;
    }
    
    public function _drawCategories($data = null){
    	$cookie = $this->context->cookie;
		
    	global $currentIndex;
    	include_once(dirname(__FILE__).'/classes/blog.class.php');
		$obj_blog = new bloghelp();
		
		$currentIndex = isset($data['currentindex'])?$data['currentindex']:$currentIndex;
    	$controller = isset($data['controller'])?$data['controller']:'AdminModules';
    	
    	$token = isset($data['token'])?$data['token']:Tools::getAdminToken($controller.intval(Tab::getIdFromClassName($controller)).intval($cookie->id_employee));
    	
		
    	$_html = '';
    	
    	$_html .= '<table class = "table" width = 100%>
			<tr>
				<th width=20>'.$this->l('No.').'</th>
				<th width=325>'.$this->l('Title Category').'</th>
				<th width=75>'.$this->l('Language').'</th>
				<th width=75>'.$this->l('Posts').'</th>
				<th width=75>'.$this->l('Date').'</th>
				<th width = "44">'.$this->l('Action').'</th>
			</tr>';
    	
    	$name_module = $this->name;
		$start = (int)Tools::getValue("pagecategories");
		
		$_data = $obj_blog->getCategories(array('start'=>$start,'step'=>$this->_step,'admin'=>1));
		
		//echo "<pre>"; var_dump($_data);
		
		$paging = $obj_blog->PageNav($start,$_data['count_all'],$this->_step, 
											array('admin' => 1,'currentIndex'=>$currentIndex,
												  'token' => '&configure='.$this->name.'&token='.$token,
												  'item' => 'categories'
											));
    	$i=0;
    	if(sizeof($_data['categories'])>0){
    	foreach($_data['categories'] as $_item){
			$i++;
			$id = $_item['id'];
			$name = @$_item['title'];
			$date = $_item['time_add'];
			$count_posts_for_category = $_item['count_posts'];
			
			$ids_lng = isset($_item['ids_lng'])?$_item['ids_lng']:array();
			$lang_for_category = array();
			foreach($ids_lng as $lng_id){
				$data_lng = Language::getLanguage($lng_id);
				$lang_for_category[] = $data_lng['iso_code']; 
			}
			$lang_for_category = implode(",",$lang_for_category);
			
			
			$_html .= 
			'<tr>
			<td style = "color:black;">'.$id.'</td>
			<td style = "color:black;">'.$name.'</td>';
			$_html .= '<td style = "color:black;">'.$lang_for_category.'</td>';
			$_html .= '<td style = "color:black;">'.$count_posts_for_category.'</td>';
			$_html .= '<td style = "color:black;">'.$date.'</td>
			
			<form action = "'.$_SERVER['REQUEST_URI'].'" name="get_categories" method = "POST">';
			$_html .= '
			<td>
				 <input type = "hidden" name = "id_category" value = "'.$id.'"/>
				 <a href="'.$currentIndex.'&configure='.$this->name.'&token='.$token.'&edit_item_category=1&id_category='.(int)($id).'" title="'.$this->l('Edit').'"><img src="'._PS_ADMIN_IMG_.'edit.gif" alt="" /></a> 
				 <a href="'.$currentIndex.'&configure='.$this->name.'&token='.$token.'&delete_item_category=1&id_category='.(int)($id).'" title="'.$this->l('Delete').'"  onclick = "javascript:return confirm(\''.$this->l('Are you sure you want to remove this item?').'\');"><img src="'._PS_ADMIN_IMG_.'delete.gif" alt="" /></a>'; 
				 $_html .= '</form>
			 </td>
			 </tr>';
			
			$_html .= '</tr>';
		}
    	} else {
    		$_html .= '<tr><td colspan=6 style="border-bottom:none;text-align:center;padding:10px"
    					>'.$this->l('There are not Categories yet').'</td><tr>';
    	}
    	
    	$_html .= '</table>';
    	if($i!=0){
    	$_html .= '<div style="margin:5px">';
    	$_html .= $paging;
    	$_html .= '</div>';
    	}
    	
    	return $_html;
    }
    
    public function _drawPosts($data = null){
    	$cookie = $this->context->cookie;
		
    	global $currentIndex;
    	
    	$currentIndex = isset($data['currentindex'])?$data['currentindex']:$currentIndex;
    	$controller = isset($data['controller'])?$data['controller']:'AdminModules';
    	
    	$token = isset($data['token'])?$data['token']:Tools::getAdminToken($controller.intval(Tab::getIdFromClassName($controller)).intval($cookie->id_employee));
    	
    	
    	$edit = isset($data['edit'])?$data['edit']:0;
    	$id_category = isset($data['id_category'])?(int)$data['id_category']:0;
    	
    	
    	include_once(dirname(__FILE__).'/classes/blog.class.php');
		$obj_blog = new bloghelp();
		$start = (int)Tools::getValue("pageposts");
		if($edit == 2){
			$_data = $obj_blog->getPosts(array('admin'=>2,'start'=>$start,'step'=>$this->_step));
		} else {
			$_data = $obj_blog->getPosts(array('admin'=>1,'id'=>$id_category));
		}
		
    	$_html = '';
    	if($edit ==1){
    		$count_all = $_data['count_all'];
    		$_html .= '<br/>';
    		$_html .= '<h2>Posts ('.$count_all.')</h2>';
    				
    	}
    	
    	
    	
    	$_html .= '<table class = "table" width = 100%>
			<tr>
				<th width=20>'.$this->l('No.').'</th>
				<th width =350>'.$this->l('Title Post').'</th>
				<th width=50>'.$this->l('Language').'</th>
				<th width=50>'.$this->l('Comments').'</th>
				<th width=50>'.$this->l('Status').'</th>
				<th width=100>'.$this->l('Date').'</th>
				<th width = "44">'.$this->l('Action').'</th>
			</tr>';
    	
    	$name_module = $this->name;
		
		
		if($edit ==2){
		
		$paging = $obj_blog->PageNav($start,$_data['count_all'],$this->_step, 
											array('admin' => 1,'currentIndex'=>$currentIndex,
												  'token' => '&configure='.$this->name.'&token='.$token,
												  'item' => 'posts'
											));
		}
		
		$i=0;
		if(sizeof($_data['posts'])>0){
		//echo "<pre>"; var_dump($_data);
		foreach($_data['posts'] as $_item){
			$i++;
			$id = $_item['id'];
			$name = $_item['title'];
			$date = $_item['time_add'];
			$status  = $_item['status'];
			$count_comments= $_item['count_comments'];
			
			$ids_lng = isset($_item['ids_lng'])?$_item['ids_lng']:array();
			$lang_for_category = array();
			foreach($ids_lng as $lng_id){
				$data_lng = Language::getLanguage($lng_id);
				$lang_for_category[] = $data_lng['iso_code']; 
			}
			$lang_for_category = implode(",",$lang_for_category);
			
			$_html .= 
			'<tr>
			<td style = "color:black;">'.$id.'</td>
			<td style = "color:black;">'.$name.'</td>';
			$_html .= '<td style = "color:black;">'.$lang_for_category.'</td>';
			$_html .= '<td style = "color:black;">'.$count_comments.'</td>';
			if($status)
				$_html .= '<td><img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif"></td>';
			else
				$_html .= '<td><img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif"></td>';
				
			$_html .= '<td style = "color:black;">'.$date.'</td>
			
			<form action = "'.$_SERVER['REQUEST_URI'].'" name="get_posts" method = "POST">';
			$_html .= '
			<td>
				 <input type = "hidden" name = "id" value = "'.$id.'"/>
				 <a href="'.$currentIndex.'&configure='.$this->name.'&token='.$token.'&edit_item_posts=1&id_posts='.(int)($id).'" title="'.$this->l('Edit').'"><img src="'._PS_ADMIN_IMG_.'edit.gif" alt="" /></a> 
				 <a href="'.$currentIndex.'&configure='.$this->name.'&token='.$token.'&delete_item_posts=1&id_posts='.(int)($id).'" title="'.$this->l('Delete').'"  onclick = "javascript:return confirm(\''.$this->l('Are you sure you want to remove this item?').'\');"><img src="'._PS_ADMIN_IMG_.'delete.gif" alt="" /></a>'; 
				 $_html .= '</form>
			 </td>
			 </tr>';
			
			$_html .= '</tr>';
		}
    	
    	} else {
    		$_html .= '<tr><td colspan=7 style="border-bottom:none;text-align:center;padding:10px">'.$this->l('No Posts.').'</td></tr>';
    	}
		
    	$_html .= '</table>';
    	if($i!=0 && $edit == 2){
    	$_html .= '<div style="margin:5px">';
    	$_html .= $paging;
    	$_html .= '</div>';
    	}
    	
    	
    	return $_html;
    }
    
     public function _drawComments($data = null){
     	$cookie = $this->context->cookie;
		
     	global $currentIndex;
     	
     	$currentIndex = isset($data['currentindex'])?$data['currentindex']:$currentIndex;
    	$controller = isset($data['controller'])?$data['controller']:'AdminModules';
    	
    	$token = isset($data['token'])?$data['token']:Tools::getAdminToken($controller.intval(Tab::getIdFromClassName($controller)).intval($cookie->id_employee));
    	
    	
    	$edit = isset($data['edit'])?$data['edit']:0;
    	$id_posts = isset($data['id_posts'])?(int)$data['id_posts']:0;
    	
    	
    	include_once(dirname(__FILE__).'/classes/blog.class.php');
		$obj_blog = new bloghelp();
		$start = (int)Tools::getValue("pagecomments");
		if($edit == 2){
			$_data = $obj_blog->getComments(array('admin'=>2,'start'=>$start,'step'=>$this->_step));
		} else {
			$_data = $obj_blog->getComments(array('admin'=>1,'id'=>$id_posts));
		}
		
    	$_html = '';
    	if($edit ==1){
    		$count_all = $_data['count_all'];
    		$_html .= '<br/>';
    		$_html .= '<h2>'.$this->l('Comments').' ('.$count_all.')</h2>';
    				
    	}
    	
    	$_html .= '<table class = "table" width = 100%>
			<tr>
				<th width=20>'.$this->l('No.').'</th>
				<th width=100>'.$this->l('Post').'</th>';
    			if($this->_is15){
					$_html .= '<th width=100>'.$this->l('Shop').'</th>';
    			}
				$_html .= '<th width=50>'.$this->l('Language').'</th>
				<th width =250>'.$this->l('Comment').'</th>
				<th width=50>'.$this->l('Status').'</th>
				<th width=50>'.$this->l('Date').'</th>
				<th width = "44">'.$this->l('Action').'</th>
			</tr>';
    	
    	$name_module = $this->name;
		
		
		if($edit ==2){
		
		$paging = $obj_blog->PageNav($start,$_data['count_all'],$this->_step, 
											array('admin' => 1,'currentIndex'=>$currentIndex,
												  'token' => '&configure='.$this->name.'&token='.$token,
												  'item' => 'comments'
											));
		}
    	
		$i=0;
		
		if(sizeof($_data['comments'])>0){
		
		foreach($_data['comments'] as $_item){
			$i++;
			$id = $_item['id'];
			$name = substr($_item['comment'],0,100);
			$date = $_item['time_add'];
			$status  = $_item['status'];
			
			$data_lng = Language::getLanguage($_item['id_lang']);
			$lang_for_comment = $data_lng['iso_code'];

			if($this->_is15){
				$id_shop = $_item['id_shop'];
				
				$shops = Shop::getShops();
				$name_shop = '';
				foreach($shops as $_shop){
					$id_shop_lists = $_shop['id_shop'];
					if($id_shop == $id_shop_lists)
						$name_shop = $_shop['name'];
				}
			}
			
			$post_id = (int)$_item['id_post'];
			$_info_cat = $obj_blog->getPostItem(array('id' => $post_id));
			$title_post = isset($_info_cat['post']['data'][1]['title'])?$_info_cat['post']['data'][1]['title']:'';
			
			$_html .= 
			'<tr>
			<td style = "color:black;">'.$id.'</td>';
			
			$_html .= '<td style = "color:black;">'.$title_post.'</td>';
			
			if($this->_is15){
				$_html .= '<td style = "color:black;">'.$name_shop.'</td>';
			}
			$_html .= '<td style = "color:black;">'.$lang_for_comment.'</td>';
			 
			$_html .= '<td style = "color:black;">'.$name.'</td>';
			if($status)
				$_html .= '<td><img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif"></td>';
			else
				$_html .= '<td><img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif"></td>';
				
			$_html .= '<td style = "color:black;">'.$date.'</td>';
			
			$_html .= '
			<td>';
			$_html .= '<form action = "'.$_SERVER['REQUEST_URI'].'" name="get_posts" method = "POST">
				 <input type = "hidden" name = "id" value = "'.$id.'"/>
				 <a href="'.$currentIndex.'&configure='.$this->name.'&token='.$token.'&edit_item_comments=1&id_comments='.(int)($id).'" title="'.$this->l('Edit').'"><img src="'._PS_ADMIN_IMG_.'edit.gif" alt="" /></a> 
				 <a href="'.$currentIndex.'&configure='.$this->name.'&token='.$token.'&delete_item_comments=1&id_comments='.(int)($id).'" title="'.$this->l('Delete').'"  onclick = "javascript:return confirm(\''.$this->l('Are you sure you want to remove this item?').'\');"><img src="'._PS_ADMIN_IMG_.'delete.gif" alt="" /></a>'; 
				 $_html .= '</form>
			 </td>
			 </tr>';
			
			$_html .= '</tr>';
		}
		
    	 } else {
    		$_html .= '<tr><td colspan=8 style="border-bottom:none;text-align:center;padding:10px"
    					>'.$this->l('There are not Comments yet').'</td><tr>';
    	}
    	
    	$_html .= '</table>';
    	if($i!=0 && $edit == 2){
    	$_html .= '<div style="margin:5px">';
    	$_html .= $paging;
    	$_html .= '</div>';
    	}
    	
    	return $_html;
    }
    
    public function _drawEditComments($data = null){
    	$cookie = $this->context->cookie;
		
    	global $currentIndex;
		$currentIndex = isset($data['currentindex'])?$data['currentindex']:$currentIndex;
    	$controller = isset($data['controller'])?$data['controller']:'AdminModules';
    	
    	$token = isset($data['token'])?$data['token']:Tools::getAdminToken($controller.intval(Tab::getIdFromClassName($controller)).intval($cookie->id_employee));
    	
	
    	
    	include_once(dirname(__FILE__).'/classes/blog.class.php');
		$obj_blog = new bloghelp();
		
		$action = isset($data['action'])?$data['action']:'';
		$id = isset($data['id'])?$data['id']:0;
		
    	if($action == 'edit'){
			$_data = $obj_blog->getCommentItem(array('id'=>$id));
			$name = $_data['comments'][0]['name'];
			$email = $_data['comments'][0]['email'];
			$comment = $_data['comments'][0]['comment'];
			$status = $_data['comments'][0]['status'];
			
			$time_add = $_data['comments'][0]['time_add'];
			
			$data_lng = Language::getLanguage($_data['comments'][0]['id_lang']);
			$lang_for_comment = $data_lng['iso_code'];

			if($this->_is15){
				$id_shop = $_data['comments'][0]['id_shop'];
				
				$shops = Shop::getShops();
				$name_shop = '';
				foreach($shops as $_shop){
					$id_shop_lists = $_shop['id_shop'];
					if($id_shop == $id_shop_lists)
						$name_shop = $_shop['name'];
				}
			}
			
			$post_id = (int)$_data['comments'][0]['id_post'];
			$_info_cat = $obj_blog->getPostItem(array('id' => $post_id));
			$title_post = isset($_info_cat['post']['data'][1]['title'])?$_info_cat['post']['data'][1]['title']:'';
			
			$button = $this->l('Update Comment');
			$title_block = $this->l('Edit Comment');
		}
		
    	$_html = '';
    	
    	$_html .= '<form method="post" action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'" enctype="multipart/form-data">';
    	
    	$_html .= '<fieldset >
					<legend><img src="../modules/'.$this->name.'/img/logo-blog.gif" />'.$title_block.'</legend>';
		
    	
    	$_html .= '<label style="width:120px">'.$this->l('Date').'</label>
    				<div class="margin-form" style="padding: 5px 0pt 10px 130px;">
					'.$time_add.'
			       </div>';
    	
    	$_html .= '<label style="width:120px">'.$this->l('Post title').'</label>
    			    <div class="margin-form" style="padding: 5px 0pt 10px 130px;">
					'.$title_post.'
			       </div>';
    	if($this->_is15){
    	$_html .= '<label style="width:120px">'.$this->l('Shop').'</label>
    			    <div class="margin-form" style="padding: 5px 0pt 10px 130px;">
					'.$name_shop.'
			       </div>';
    	}
    	
    	$_html .= '<label style="width:120px">'.$this->l('Lang').'</label>
    			    <div class="margin-form" style="padding: 5px 0pt 10px 130px;">
					'.$lang_for_comment.'
			       </div>';
    	 
    	
    	$_html .= '<label style="width:120px">'.$this->l('Name').'</label>
    			
    				<div class="margin-form" style="padding: 0pt 0pt 10px 130px;">
					<input type="text" name="comments_name" value="'.$name.'"  style="width:274px">
			        
			       </div>';
    	
    	$_html .= '<label style="width:120px">'.$this->l('Email').'</label>
    			
    				<div class="margin-form" style="padding: 0pt 0pt 10px 130px;">
					<input type="text" name="comments_email" value="'.$email.'"  style="width:274px">
			        
			       </div>';
    
    	$_html .= '<label style="width:120px">'.$this->l('Comment').'</label>
    			
    				<div class="margin-form" style="padding: 0pt 0pt 10px 130px;">
					<textarea name="comments_comment" cols="50" rows="10"  
			                	   >'.$comment.'</textarea>
			        
			       </div>';
    	
    	$_html .= '<label style="width:120px">'.$this->l('Status').'</label>
				<div class = "margin-form" style="padding: 0pt 0pt 10px 130px;">';
				
		$_html .= '<select name="comments_status" style="width:100px">
					<option value=1 '.(($status==1)?"selected=\"true\"":"").'>'.$this->l('Enabled').'</option>
					<option value=0 '.(($status==0)?"selected=\"true\"":"").'>'.$this->l('Disabled').'</option>
				   </select>';
			
		$_html .= '</div>';
    
		$_html .= '</fieldset>';
		
		if($action == 'edit'){
		$_html .= '<input type = "hidden" name = "id_editcomments" value = "'.$id.'"/>';
    	$_html .= '<p class="center" style="text-align:center;background: none; padding: 10px; margin-top: 10px;">
					<input type="submit" name="cancel_editcomments" value="'.$this->l('Cancel').'" 
                		   class="button"  />
    				<input type="submit" name="submit_editcomments" value="'.$button.'" 
                		   class="button"  />
                	
                	</p>';
		} 
		
    	
    	$_html .= '</form>';
    	
    	return $_html;
    }
    
private function _drawSettingsForm(){
    	$_html = '';
    	
    	$_html .= '<style type="text/css">
    				.settings-blog label{width:350px!important}
    				.choose_hooks input{margin-bottom: 10px}
    				</style>';
    	
    	$_html .= '<div class="settings-blog">'; 
    	
    	$_html .= '<form method="post" action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'" enctype="multipart/form-data">';
    	
    	$_html .= '<fieldset>
					<legend><img src="../modules/'.$this->name.'/img/logo-blog.gif" />
						'.$this->l('Blog Settings').'</legend>';

    	
    	$_html .= '<label>'.$this->l('Enable or Disable Blog:').'</label>';
    	
    	$_html .= '<div class="margin-form">';
    	$_html .=  '
					<input type="radio" value="1" id="text_list_on" name="blogon" onclick="enableOrDisableBLOG(1)"
							'.(Tools::getValue('blogon', Configuration::get($this->name.'blogon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					<input type="radio" value="0" id="text_list_off" name="blogon" onclick="enableOrDisableBLOG(0)"
						   '.(!Tools::getValue('blogon', Configuration::get($this->name.'blogon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
				';
		
    	$_html .= '</div>';
    	
		$_html .= '<script type="text/javascript">
			    	function enableOrDisableBLOG(id)
						{
						if(id==0){
							$("#block-blog-settings").hide(200);
						} else {
							$("#block-blog-settings").show(200);
						}
							
						}
					</script>';
    	
		$_html .= '<div id="block-blog-settings" '.(Configuration::get($this->name.'blogon')==1?'style="display:block"':'style="display:none"').'>';
    	
		
		
		$_html .= '<label>'.$this->l('The number of items in the "Blog categories":').'</label>';
    	
    	$_html .= '<div class="margin-form">';
    	$_html .=  '
					<input type="text" name="blog_bcat"  
			               value="'.Tools::getValue('blog_bcat', Configuration::get($this->name.'blog_bcat')).'"
			               >
				';
		$_html .= '</div>';
		
		$_html .= '<div class="clear"></div>';
		$_html .= '<br/><br/>';
		
    	$_html .= '<label>'.$this->l('Categories per Page:').'</label>';
    	
   		 $_html .= '<div class="margin-form">';
			$_html .=  '
					<input type="text" name="perpage_catblog"  
			               value="'.Tools::getValue('perpage_catblog', Configuration::get($this->name.'perpage_catblog')).'"
			               >
				';
		$_html .= '</div>';
		
		$_html .= '<label>'.$this->l('Display date on list Categories page:').'</label>';
    	
     	$_html .= '<div class="margin-form">';
			$_html .= '<input type="checkbox" value="1" name="c_list_display_date" '.((Tools::getValue($this->name.'c_list_display_date', Configuration::get($this->name.'c_list_display_date')) ==1)?'checked':'').'>';
        $_html .= '</div>';
        
        
        $_html .= '<br/><br/>';
		
		
		
		$_html .= '<div class="clear"></div>';
		
		
		$_html .= '<label>'.$this->l('Display block "Blog Posts recents" on Home Page').':</label>';
    	
     	$_html .= '<div class="margin-form">';
			$_html .= '<input type="checkbox" value="1" name="block_last_home" '.((Tools::getValue($this->name.'block_last_home', Configuration::get($this->name.'block_last_home')) ==1)?'checked':'').'>';
        $_html .= '</div>';
        
        $_html .= '<div class="clear"></div>';
		
        
        $_html .= '<label>'.$this->l('Display tab "Blog" on Product Page').':</label>';
    	
     	$_html .= '<div class="margin-form">';
			$_html .= '<input type="checkbox" value="1" name="tab_blog_pr" '.((Tools::getValue($this->name.'tab_blog_pr', Configuration::get($this->name.'tab_blog_pr')) ==1)?'checked':'').'>';
        $_html .= '</div>';
        
        $_html .= '<div class="clear"></div>';
		
			$_html .= '<label>'.$this->l('The number of items in the block "Blog Posts recents"').':</label>';
    	
    	$_html .= '<div class="margin-form">';
    	$_html .=  '
					<input type="text" name="blog_bposts"  
			               value="'.Tools::getValue('blog_bposts', Configuration::get($this->name.'blog_bposts')).'"
			               >
				';
		$_html .= '</div>';
		
		$_html .= '<div class="clear"></div>';
		
		$_html .= '<label>'.$this->l('Display date in the block "Blog Posts recents"').':</label>';
    	
     	$_html .= '<div class="margin-form">';
			$_html .= '<input type="checkbox" value="1" name="block_display_date" '.((Tools::getValue($this->name.'block_display_date', Configuration::get($this->name.'block_display_date')) ==1)?'checked':'').'>';
        $_html .= '</div>';
        
        $_html .= '<div class="clear"></div>';
		
        $_html .= '<label>'.$this->l('Display images in the block "Blog Posts recents"').':</label>';
    	
     	$_html .= '<div class="margin-form">';
			$_html .= '<input type="checkbox" value="1" name="block_display_img" '.((Tools::getValue($this->name.'block_display_img', Configuration::get($this->name.'block_display_img')) ==1)?'checked':'').'>';
        $_html .= '</div>';
        
        $_html .= '<div class="clear"></div>';
        
        $_html .= '<label>'.$this->l('Image width in the block "Blog Posts recents"').':</label>';
		
		$_html .= '<div class="margin-form">';
    	$_html .=  '
					<input type="text" name="p_block_img_width"  
			               value="'.Tools::getValue('p_block_img_width', Configuration::get($this->name.'p_block_img_width')).'"
			               >&nbsp;px
				';
		$_html .= '</div>';
        
        
		
		$_html .= '<div class="clear"></div>';
		$_html .= '<br/><br/>';
		
    	$_html .= '<label>'.$this->l('Posts per Page in the list view').':</label>';
    	
    	$_html .= '<div class="margin-form">';
    	$_html .=  '
					<input type="text" name="perpage_posts"  
			               value="'.Tools::getValue('perpage_posts', Configuration::get($this->name.'perpage_posts')).'"
			               >
				';
		$_html .= '</div>';
		
		$_html .= '<label>'.$this->l('Display date on list posts view').':</label>';
    	
    	$_html .= '<div class="margin-form">';
    	
    	$_html .= '<input type="checkbox" value="1" name="p_list_displ_date" '.((Tools::getValue($this->name.'p_list_displ_date', Configuration::get($this->name.'p_list_displ_date')) ==1)?'checked':'').'>';
      
		$_html .= '</div>';
		
		$_html .= '<label>'.$this->l('Image width in lists posts').':</label>';
		
		$_html .= '<div class="margin-form">';
    	$_html .=  '
					<input type="text" name="lists_img_width"  
			               value="'.Tools::getValue('lists_img_width', Configuration::get($this->name.'lists_img_width')).'"
			               >&nbsp;px
				';
		$_html .= '</div>';
		
		 $_html .= '<br/><br/>';
		 
		 $_html .= '<label>'.$this->l('Display date on post page').':</label>';
    	
     	$_html .= '<div class="margin-form">';
			$_html .= '<input type="checkbox" value="1" name="post_display_date" '.((Tools::getValue($this->name.'post_display_date', Configuration::get($this->name.'post_display_date')) ==1)?'checked':'').'>';
        $_html .= '</div>';
        
        $_html .= '<label>'.$this->l('Image width on post page').':</label>';
		
		$_html .= '<div class="margin-form">';
    	$_html .=  '
					<input type="text" name="post_img_width"  
			               value="'.Tools::getValue('post_img_width', Configuration::get($this->name.'post_img_width')).'"
			               >&nbsp;px
				';
		$_html .= '</div>';
		
		 $_html .= '<label>'.$this->l('Active Social share buttons').':</label>';
    	
     	$_html .= '<div class="margin-form">';
			$_html .= '<input type="checkbox" value="1" name="is_soc_buttons" '.((Tools::getValue($this->name.'is_soc_buttons', Configuration::get($this->name.'is_soc_buttons')) ==1)?'checked':'').'>';
        $_html .= '</div>';
		
		
		$_html .= '<br/><br/>';
        
    	
		
		
		$_html .= '<div class="clear"></div>';
		
		$_html .= '<label>'.$this->l('Enable or Disable RSS Feed').':</label>';
    	
    	$_html .= '<script type="text/javascript">
			    	function enableOrDisableRSS(id)
						{
						if(id==0){
							$("#block-rss-settings").hide(200);
						} else {
							$("#block-rss-settings").show(200);
						}
							
						}
					</script>';
    	
    	$_html .= '<div class="margin-form">';
    	
    	$_html .=  '
					<input type="radio" value="1" id="text_list_on" name="rsson" onclick="enableOrDisableRSS(1)"
							'.(Tools::getValue('rsson', Configuration::get($this->name.'rsson')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					
					<input type="radio" value="0" id="text_list_off" name="rsson" onclick="enableOrDisableRSS(0)"
						   '.(!Tools::getValue('rsson', Configuration::get($this->name.'rsson')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
				';
		
    	$_html .= '</div>';
    	$_html .= '<div class="clear"></div>';
    	$_html .= '<div id="block-rss-settings" '.(Configuration::get($this->name.'rsson')==1?'style="display:block"':'style="display:none"').'>';
    	
    	
    	
		
		$divLangName = "rssname¤srssdesc";
		
    	// Title of your RSS Feed
		
		$_html .= '<label>'.$this->l('Title of your RSS Feed').':</label>';
    	$_html .= '<div class="margin-form">';		
		
    		$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
	    	$languages = Language::getLanguages(false);
	    	
	    	foreach ($languages as $language){
			$id_lng = (int)$language['id_lang'];
	    	$rssname = Configuration::get($this->name.'rssname'.'_'.$id_lng);
	    	
	    	
			$_html .= '	<div id="rssname_'.$language['id_lang'].'" 
							 style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;"
							 >

						<input type="text" style="width:300px"   
								  id="rssname_'.$language['id_lang'].'" 
								  name="rssname_'.$language['id_lang'].'" 
								  value="'.htmlentities(stripslashes($rssname), ENT_COMPAT, 'UTF-8').'"/>
						</div>';
	    	}
			$_html .= '';
			ob_start();
			$this->displayFlags($languages, $defaultLanguage, $divLangName, 'rssname');
			$displayflags = ob_get_clean();
			$_html .= $displayflags;
		
		
		
    	// Description of your RSS Feed
    	$_html .= '</div>';
		
		$_html .= '<div class="clear"></div>';
    	$_html .= '<label>'.$this->l('Description of your RSS Feed').':</label>';

    	$_html .= '<div class="margin-form">';
    	
    		$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
	    	$languages = Language::getLanguages(false);
	    	
	    	foreach ($languages as $language){
			$id_lng = (int)$language['id_lang'];
	    	$rssdesc = Configuration::get($this->name.'rssdesc_'.$id_lng);
	    	
	    	
			$_html .= '	<div id="srssdesc_'.$language['id_lang'].'" 
							 style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;"
							 >

							 <input type="text" style="width:300px"   
								  id="rssdesc_'.$language['id_lang'].'" 
								  name="rssdesc_'.$language['id_lang'].'" 
								  value="'.htmlentities(stripslashes($rssdesc), ENT_COMPAT, 'UTF-8').'"/>
								  
					</div>';
	    	}
			$_html .= '';
			ob_start();
			$this->displayFlags($languages, $defaultLanguage, $divLangName, 'srssdesc');
			$displayflags = ob_get_clean();
			$_html .= $displayflags;
			
		// Description of your RSS Feed
		
		$_html .= '</div>';
		
		$_html .= '<div class="clear"></div>';
    	$_html .= '<label>'.$this->l('Number of items in RSS Feed').':</label>';

    	$_html .= '<div class="margin-form">';
    	$_html .=  '
					<input type="text" name="number_rssitems"  
			               value="'.Tools::getValue('number_rssitems', Configuration::get($this->name.'number_rssitems')).'"
			               >
				';
		
    	
		$_html .= '</div>';
		
		$_html .= '</div>';
		
		$_html .= '<div class="clear"></div>';
		
    
		
		$_html .= '<br/><br/>';
		
		$_html .= '<label>'.$this->l('E-mail notification:').'</label>';
    	
    	$_html .= '<div class="margin-form">';
    	$_html .= '<input type = "checkbox" name = "noti" id = "noti" value ="1" '.((Tools::getValue($this->name.'noti', Configuration::get($this->name.'noti')) ==1)?'checked':'').'/>';
		$_html .= '</div>';
		
    	$_html .= '<label>'.$this->l('Admin email:').'</label>';
    	
    	$_html .= '<div class="margin-form">';
    	$_html .=  '
					<input type="text" name="mail"  
			               value="'.Tools::getValue('mail', Configuration::get($this->name.'mail')).'"
			               >
				';
		$_html .= '</div>';
		
		$_html .= '<div class="clear"></div>';
		
    
		
		$_html .= '<br/><br/>';
		
		/*$cat_left = Configuration::get($this->name.'cat_left');
		$posts_left = Configuration::get($this->name.'posts_left');
		$arch_left = Configuration::get($this->name.'arch_left');
		$search_left = Configuration::get($this->name.'search_left');
		*/
				
        $_html .= '<label>'.$this->l('Left column').':</label>
				<div class="margin-form choose_hooks">
	    			<table style="width:66%;">
	    				<tr>
	    					<td style="width: 33%">'.$this->l('Blog Categories').'</td>
	    					<td style="width: 33%">'.$this->l('Blog Posts recents').'</td>
	    					
	    				</tr>
	    				<tr>
	    					<td>
	    						<input type="checkbox" name="cat_left" '.((Tools::getValue($this->name.'cat_left', Configuration::get($this->name.'cat_left')) ==1)?'checked':'').'  value="1"/>
	    					</td>
	    					<td>
	    						<input type="checkbox" name="posts_left" '.((Tools::getValue($this->name.'posts_left', Configuration::get($this->name.'posts_left')) ==1)?'checked':'') .' value="1"/>
	    					</td>
	    					
	    				</tr>
	    				<tr>
	    					<td>'.$this->l('Block Archives').'</td>
	    					<td>'.$this->l('Block Search').'</td>
	    					
	    				</tr>
	    				<tr>
	    					<td>
	    						<input type="checkbox" name="arch_left" '.((Tools::getValue($this->name.'arch_left', Configuration::get($this->name.'arch_left')) ==1)?'checked':'').' value="1"/>
	    					</td>
	    					<td>
	    						<input type="checkbox" name="search_left" '.((Tools::getValue($this->name.'search_left', Configuration::get($this->name.'search_left')) ==1)?'checked':'').' value="1"/>
	    					</td>
	    					
	    				</tr>
	    				
	    			</table>
	    		</div>';
				

		
		
		$_html .= '<div class="clear"></div>';
		
		
		$_html .= '<br/><br/>';
		
		/*$cat_right = Configuration::get($this->name.'cat_right');
		$posts_right = Configuration::get($this->name.'posts_right');
		$arch_right = Configuration::get($this->name.'arch_right');
		$search_right = Configuration::get($this->name.'search_right');
		
		*/
		
        		
        $_html .= '<label>'.$this->l('Right column').':</label>
				<div class="margin-form choose_hooks">
	    			<table style="width:66%;">
	    				<tr>
	    					<td style="width: 33%">'.$this->l('Blog Categories').'</td>
	    					<td style="width: 33%">'.$this->l('Blog Posts recents').'</td>
	    					
	    				</tr>
	    				<tr>
	    					<td>
	    						<input type="checkbox" name="cat_right" '.((Tools::getValue($this->name.'cat_right', Configuration::get($this->name.'cat_right')) ==1)?'checked':'').'  value="1"/>
	    					</td>
	    					<td>
	    						<input type="checkbox" name="posts_right" '.((Tools::getValue($this->name.'posts_right', Configuration::get($this->name.'posts_right')) ==1)?'checked':'').' value="1"/>
	    					</td>
	    					
	    				</tr>
	    				<tr>
	    					<td>'. $this->l('Block Archives').'</td>
	    					<td>'. $this->l('Block Search').'</td>
	    					
	    				</tr>
	    				<tr>
	    					<td>
	    						<input type="checkbox" name="arch_right" '.((Tools::getValue($this->name.'arch_right', Configuration::get($this->name.'arch_right')) ==1)?'checked':'').' value="1"/>
	    					</td>
	    					<td>
	    						<input type="checkbox" name="search_right" '.((Tools::getValue($this->name.'search_right', Configuration::get($this->name.'search_right')) ==1)?'checked':'').' value="1"/>
	    					</td>
	    					
	    				</tr>
	    				
	    			</table>
	    		</div>';
				

		
		
	
		
		$_html .= '<div class="clear"></div>';
	
		$_html .= '<br/><br/>';
		
		/*$cat_footer = Configuration::get($this->name.'cat_footer');
		$posts_footer = Configuration::get($this->name.'posts_footer');
		$arch_footer = Configuration::get($this->name.'arch_footer');
		$search_footer = Configuration::get($this->name.'search_footer');
		
		*/
		
        		
        $_html .= '<label>'.$this->l('Footer').':</label>
				<div class="margin-form choose_hooks">
	    			<table style="width:66%;">
	    				<tr>
	    					<td style="width: 33%">'.$this->l('Blog Categories').'</td>
	    					<td style="width: 33%">'.$this->l('Blog Posts recents').'</td>
	    					
	    				</tr>
	    				<tr>
	    					<td>
	    						<input type="checkbox" name="cat_footer" '.((Tools::getValue($this->name.'cat_footer', Configuration::get($this->name.'cat_footer')) ==1)?'checked':'').'  value="1"/>
	    					</td>
	    					<td>
	    						<input type="checkbox" name="posts_footer" '.((Tools::getValue($this->name.'posts_footer', Configuration::get($this->name.'posts_footer')) ==1)?'checked':'').' value="1"/>
	    					</td>
	    					
	    				</tr>
	    				<tr>
	    					<td>'. $this->l('Block Archives').'</td>
	    					<td>'. $this->l('Block Search').'</td>
	    					
	    				</tr>
	    				<tr>
	    					<td>
	    						<input type="checkbox" name="arch_footer" '.((Tools::getValue($this->name.'arch_footer', Configuration::get($this->name.'arch_footer')) ==1)?'checked':'').' value="1"/>
	    					</td>
	    					<td>
	    						<input type="checkbox" name="search_footer" '.((Tools::getValue($this->name.'search_footer', Configuration::get($this->name.'search_footer')) ==1)?'checked':'').' value="1"/>
	    					</td>
	    					
	    				</tr>
	    				
	    			</table>
	    		</div>';
			
		
		$_html .= '<div class="clear"></div>';
		
		
		$_html .= '</div>';
		
			
			$_html .= '<p class="center" style="text-align:center;text-align:center;background: none; padding: 10px; margin-top: 10px;">
					<input type="submit" name="submit_blogsettings" value="'.$this->l('Update settings').'" 
                		   class="button"  />
                	</p>';

		$_html .= '</fieldset>';
			
    	
    	
    	$_html .= '<br/><br/>';
    	
    	$_html .= '<fieldset>
					<legend>'.$this->l('Tools').'</legend>';
    	
    	
    	/*if($this->_is15){
    	$_html .= $this->_hint15();
    		 
    	} else{
    	$_html .= $this->_hint();
    	}	*/
    	
    	$_html .= '<p>
                     <input type="submit" value="'.$this->l('Regenerate Google sitemap').'" name="submitsitemap" class="button"> 
                     &nbsp; <a target="_blank" href="'._PS_BASE_URL_.__PS_BASE_URI__.'upload/blockblog/blog.xml">
                     			'._PS_BASE_URL_.__PS_BASE_URI__.'upload/blockblog/blog.xml
                     		</a> 
                    </p>';
    	
    	$_html .= '<p class="hint clear" style="display: block; font-size: 11px; width: 95%; margin-top:20px;position:relative">
                            '.$this->l('To declare blog sitemap xml, add this line at the end of your robots.txt file').': <br><br>
							  <strong>
								Sitemap '._PS_BASE_URL_.__PS_BASE_URI__.'upload/blockblog/blog.xml
							 </strong>
                            </p>
                ';
    	
    	$_html .= '</fieldset>';
    	$_html .= '</form>';
    	
    	$_html .= '</div>';
    	return $_html;
    }

 private function _drawSettingsSeoURL(){
    	$_html = '';
    	
    	$_html .= '<form method="post" action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'" enctype="multipart/form-data">';
    	
    	$_html .= '<fieldset>
					<legend><img src="../modules/'.$this->name.'/logo.gif" />
						'.$this->l('SEO URL Rewrite').'</legend>';

    	
    	
    	
    	$_html .= '<label>'.$this->l('Enable or Disable URL rewriting').':</label>';
    	
    	
    	$_html .= '<div class="margin-form">';
		$_html .=  '
					<input type="radio" value="1" id="text_list_on" name="urlrewrite_on" onclick="enableOrDisableToolsSEO(1)"
							'.(Tools::getValue('urlrewrite_on', Configuration::get($this->name.'urlrewrite_on')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					
					<input type="radio" value="0" id="text_list_off" name="urlrewrite_on"  onclick="enableOrDisableToolsSEO(0)"
						   '.(!Tools::getValue('urlrewrite_on', Configuration::get($this->name.'urlrewrite_on')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
					<p class="clear">'.$this->l('Enable only if your server allows URL rewriting (recommended)').'.</p>
				';
		
		$_html .= '</div>';
		
		$_html .= '<p class="center" style="text-align:center;text-align:center;background: none; padding: 10px; margin-top: 10px;">
					<input type="submit" name="submit_urlrewritesettings" value="'.$this->l('Update settings').'" 
                		   class="button"  />
                	</p>';

		$_html .= '</fieldset>';
			
    	$_html .= '<script type="text/javascript">
			    	function enableOrDisableToolsSEO(id)
						{
						if(id==0){
							$("#block-tools-settings-seo").hide(200);
						} else {
							$("#block-tools-settings-seo").show(200);
						}
							
						}
					</script>';
    	
    	$_html .= '<br/><br/>';
    	
    	$_html .= '<div id="block-tools-settings-seo" '.(Configuration::get($this->name.'urlrewrite_on')==1?'style="display:block"':'style="display:none"').'>';
    	
    	$_html .= '<fieldset>
					<legend>'.$this->l('Tools').'</legend>';
    	
    	
    	if($this->_is15){
    	$_html .= $this->_hint15();
    		 
    	} else{
    	$_html .= $this->_hint();
    	}	
    	
    	$_html .= '</fieldset>';
    	$_html .= '</form>';
    	
    	
    	$_html .= '</div>';
    	return $_html;
    }
    
    
private function _hint(){
    	$_html = '';
    	
    	$_html .= '<p style="display: block; font-size: 11px; width: 95%; margin-bottom:20px;position:relative" class="hint clear">
    	<b style="color:#585A69">'.$this->l('If url rewriting doesn\'t works, check that this above lines exist in your current .htaccess file, if no, add it manually on top of your .htaccess file').':</b>
    	<br/><br/>
    	<code>
		RewriteRule ^(.*)blog/category/([0-9a-zA-Z-_]+)/?$ /modules/'.$this->name.'/blockblog-category.php?category_id=$2 [QSA,L]
		</code>
		<br/>
		<code>
		RewriteRule ^(.*)blog/post/([0-9a-zA-Z-_]+)/?$ /modules/'.$this->name.'/blockblog-post.php?post_id=$2 [QSA,L]
		</code>
		<br/>
		<code>
		RewriteRule ^(.*)blog/categories/?$ /modules/'.$this->name.'/blockblog-categories.php [QSA,L] 
		</code>
		<br/>
		<code>
		RewriteRule ^(.*)blog/?$ /modules/'.$this->name.'/blockblog-all-posts.php [QSA,L] 
		</code>
		
		<br/><br/>
		<code>
		RewriteRule ^(.*)testimonials/?$ /modules/'.$this->name.'/blockshopreviews-form.php [QSA,L] 
	    </code>
	    
	    <br/><br/>
	    <code>
		RewriteRule ^(.*)faq/?$ /modules/'.$this->name.'/faq.php [QSA,L] 
	    </code>
		
	    <br/><br/>
	    <code>
		RewriteRule ^(.*)guestbook/?$ /modules/'.$this->name.'/blockguestbook-form.php [QSA,L] 
	    </code>
	    
	    <br/><br/>
    	<code>
		RewriteRule ^(.*)news/?$ /modules/'.$this->name.'/items.php [QSA,L]
		</code>
		<br/>
		<code>
		RewriteRule ^(.*)news/([0-9a-zA-Z-_]+)/?$ /modules/'.$this->name.'/item.php?item_id=$2 [QSA,L]  
		</code>
		
			<br/><br/>
		</p>';
    	
    	return $_html;
    }
    
    private function _hint15(){
    	$_html = '';
    	
    	$_html .= '<p style="display: block; font-size: 11px; width: 95%; margin-bottom:20px;position:relative" class="hint clear">
    	<b style="color:#585A69">'.$this->l('If url rewriting doesn\'t works, check that this above lines exist in your current .htaccess file, if no, add it manually on top of your .htaccess file').':</b>
    	<br/><br/>
    	
    	<b><code>
		RewriteRule ^(.*)blog/category/([0-9a-zA-Z-_]+)/?$ /modules/'.$this->name.'/blockblog-category.php?category_id=$2 [QSA,L]
		</code>
		</b>
		<br/>
		<b>
		<code>
		RewriteRule ^(.*)blog/post/([0-9a-zA-Z-_]+)/?$ /modules/'.$this->name.'/blockblog-post.php?post_id=$2 [QSA,L]
		</code>
		</b>
		<br/>
		<b>
		<code>
		RewriteRule ^(.*)blog/categories/?$ /modules/'.$this->name.'/blockblog-categories.php [QSA,L] 
		</code>
		</b>
		<br/>
		<b>
		<code>
		RewriteRule ^(.*)blog/?$ /modules/'.$this->name.'/blockblog-all-posts.php [QSA,L] 
		</code>
		</b>
		
		<br/><br/>
		<b>
    	<code>
		RewriteRule ^(.*)testimonials/?$ /modules/'.$this->name.'/blockshopreviews-form.php [QSA,L] 
	    </code>
		</b>
		
		<br/><br/>
		<b>
		<code>
		RewriteRule ^(.*)faq/?$ /modules/'.$this->name.'/faq.php [QSA,L] 
	    </code>
	    </b>
	    
	    <br/><br/>
		<b>
	    <code>
		RewriteRule ^(.*)guestbook/?$ /modules/'.$this->name.'/blockguestbook-form.php [QSA,L] 
	    </code>
	    </b>
	    
	    <br/><br/>
	    <b>
    	<code>
		RewriteRule ^(.*)news/?$ /modules/'.$this->name.'/items.php [QSA,L]
		</code>
		</b>
		<br/>
		<b>
		<code>
		RewriteRule ^(.*)news/([0-9a-zA-Z-_]+)/?$ /modules/'.$this->name.'/item.php?item_id=$2 [QSA,L]  
		</code>
		</b>
		
		</p>';
    	
    	return $_html;
    }
    
    private function _drawReferralsSettings($data = null){
    	
    	$type= $data['type'];
    	
    	$cookie = $this->context->cookie;
		
		$_html = '';
    		
    	$_html .= '
        <form action="'.$_SERVER['REQUEST_URI'].'" method="post" >';
    	$_html .= '<fieldset>
					<legend><img src="../modules/'.$this->name.'/img/settings_'.$type.'.png" />'.ucfirst($type)." ".$this->l('Referrals Settings').'</legend>
					
					';
    	
    	switch($type){
    	case 'twitter':
    	/// twitter
    	$_html .= '<label><img src="../modules/'.$this->name.'/i/twitter.gif" />'.$this->l('Enabled Twitter Referrals:').'</label>
				<div class="margin-form">
				
					<input type="radio" value="1" id="text_list_on" name="twrefon"
							'.(Tools::getValue('twrefon', Configuration::get($this->name.'twrefon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					
					<input type="radio" value="0" id="text_list_off" name="twrefon"
						   '.(!Tools::getValue('twrefon', Configuration::get($this->name.'twrefon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
					<p class="clear">'.$this->l('Enable or disable Twitter Referrals.').'</p>
				</div>';
    	
    	// enable or disable share order
    	$_html .= '<label><img src="../modules/'.$this->name.'/i/twitter.gif" />'.$this->l('Enabled Twitter at Order Confirm Page').':</label>
				<div class="margin-form">
				
					<input type="radio" value="1" id="text_list_on" name="twrefshareon"
							'.(Tools::getValue('twrefshareon', Configuration::get($this->name.'twrefshareon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					
					<input type="radio" value="0" id="text_list_off" name="twrefshareon"
						   '.(!Tools::getValue('twrefshareon', Configuration::get($this->name.'twrefshareon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
					<p class="clear">'.$this->l('Enable or disable Twitter at Order Confirm Page').'</p>
				</div>';
    	
    	break;
    	
    	case 'google':
    	/// google
    	$_html .= '<label><img src="../modules/'.$this->name.'/i/google.gif" />'.$this->l('Enabled Google Referrals:').'</label>
				<div class="margin-form">
				
					<input type="radio" value="1" id="text_list_on" name="grefon"
							'.(Tools::getValue('grefon', Configuration::get($this->name.'grefon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					
					<input type="radio" value="0" id="text_list_off" name="grefon"
						   '.(!Tools::getValue('grefon', Configuration::get($this->name.'grefon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
					<p class="clear">'.$this->l('Enable or disable Google Referrals.').'</p>
				</div>';
    	
    	// enable or disable share order
    	$_html .= '<label><img src="../modules/'.$this->name.'/i/google.gif" />'.$this->l('Enabled Google at Order Confirm Page').':</label>
				<div class="margin-form">
				
					<input type="radio" value="1" id="text_list_on" name="grefshareon"
							'.(Tools::getValue('grefshareon', Configuration::get($this->name.'grefshareon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					
					<input type="radio" value="0" id="text_list_off" name="grefshareon"
						   '.(!Tools::getValue('grefshareon', Configuration::get($this->name.'grefshareon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
					<p class="clear">'.$this->l('Enable or disable Google at Order Confirm Page').'.</p>
				</div>';
    	
    	$_html .= '<label>'.$this->l('Size').':</label>
				<div class="margin-form">
					<select class="select" name="gsize" 
							id="gsize">
							
						<option '.((Tools::getValue('gsize', Configuration::get($this->name.'gsize')) == "small")? 'selected="selected" ' : '').' value="small">'.$this->l('Small (15px)').'</option>
						<option '.((Tools::getValue('gsize', Configuration::get($this->name.'gsize')) == "medium") ? 'selected="selected" ' : '').' value="medium">'.$this->l('Medium (20px)').'</option>
					  	<option '.((Tools::getValue('gsize', Configuration::get($this->name.'gsize')) == "") ? 'selected="selected" ' : '').' value="">'.$this->l('Standart (24px)').'</option>
						<option '.((Tools::getValue('gsize', Configuration::get($this->name.'gsize')) == "tall") ? 'selected="selected" ' : '').' value="tall">'.$this->l('Tall (60px)').'</option>
												
					</select>
				</div>';
    	
    	break;
    	case 'linkedin':
    	/// LinkedIn
    	$_html .= '<label><img src="../modules/'.$this->name.'/i/linkedin.gif" />'.$this->l('Enabled LinkedIn Referrals:').'</label>
				<div class="margin-form">
				
					<input type="radio" value="1" id="text_list_on" name="lrefon"
							'.(Tools::getValue('lrefon', Configuration::get($this->name.'lrefon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					
					<input type="radio" value="0" id="text_list_off" name="lrefon"
						   '.(!Tools::getValue('lrefon', Configuration::get($this->name.'lrefon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
					<p class="clear">'.$this->l('Enable or disable LinkedIn Referrals.').'</p>
				</div>';
    	
    	// enable or disable share order
    	$_html .= '<label><img src="../modules/'.$this->name.'/i/linkedin.gif" />'.$this->l('Enabled LinkedIn at Order Confirm Page').':</label>
				<div class="margin-form">
				
					<input type="radio" value="1" id="text_list_on" name="lrefshareon"
							'.(Tools::getValue('lrefshareon', Configuration::get($this->name.'lrefshareon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					
					<input type="radio" value="0" id="text_list_off" name="lrefshareon"
						   '.(!Tools::getValue('lrefshareon', Configuration::get($this->name.'lrefshareon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
					<p class="clear">'.$this->l('Enable or disable LinkedIn at Order Confirm Page').'.</p>
				</div>';
    	
    		$_html .= '<label>'.$this->l('Choose a count mode').':</label>
				<div class="margin-form">
					<select class="select" name="lsize" 
							id="lsize">
							
						<option '.((Tools::getValue('lsize', Configuration::get($this->name.'lsize')) == "top")? 'selected="selected" ' : '').' value="top">'.$this->l('Vertical').'</option>
						<option '.((Tools::getValue('lsize', Configuration::get($this->name.'lsize')) == "right") ? 'selected="selected" ' : '').' value="right">'.$this->l('Horizontal').'</option>
					  	<option '.((Tools::getValue('lsize', Configuration::get($this->name.'lsize')) == "") ? 'selected="selected" ' : '').' value="">'.$this->l('No Count').'</option>
												
					</select>
				</div>';
    	break;
    	case 'facebook':
    	// enable or disable
    	$_html .= '<label><img src="../modules/'.$this->name.'/i/facebook.gif" />'.$this->l('Enabled Facebook Referrals:').'</label>
				<div class="margin-form">
				
					<input type="radio" value="1" id="text_list_on" name="fbrefon"
							'.(Tools::getValue('fbrefon', Configuration::get($this->name.'fbrefon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					
					<input type="radio" value="0" id="text_list_off" name="fbrefon"
						   '.(!Tools::getValue('fbrefon', Configuration::get($this->name.'fbrefon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
					<p class="clear">'.$this->l('Enable or disable Facebook Referrals.').'</p>
				</div>';
    	
    	// enable or disable share order
    	$_html .= '<label><img src="../modules/'.$this->name.'/i/facebook.gif" />'.$this->l('Enabled Facebook at Order Confirm Page').':</label>
				<div class="margin-form">
				
					<input type="radio" value="1" id="text_list_on" name="fbrefshareon"
							'.(Tools::getValue('fbrefshareon', Configuration::get($this->name.'fbrefshareon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					
					<input type="radio" value="0" id="text_list_off" name="fbrefshareon"
						   '.(!Tools::getValue('fbrefshareon', Configuration::get($this->name.'fbrefshareon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
					<p class="clear">'.$this->l('Enable or disable Facebook at Order Confirm Page').'.</p>
				</div>';
    	break;
		
    	}
    	
    	
    	$type_ref = substr($type,0,1);
    	
    	$psextraLeft = Configuration::get($this->name.'_psextraLeft'.$type_ref);
		
		$psprFooter = Configuration::get($this->name.'_psprFooter'.$type_ref);
		$psprActions  = Configuration::get($this->name.'_psprActions'.$type_ref);
		$psextraRight = Configuration::get($this->name.'_psextraRight'.$type_ref);
		
		$pscheckoutPage = Configuration::get($this->name.'_pscheckoutPage'.$type_ref);
		
		$_html .= '<style type="text/css">
			.choose_hooks input{margin-bottom: 10px}
		</style>
        		
        		<label>'.$this->l('Position').':</label>
				<div class="margin-form choose_hooks">
	    			<table style="width:90%;">
	    				<tr>
	    					<td style="width: 33%">'.$this->l('Order / Checkout Page').'</td>
	    					<td style="width: 33%">'.$this->l('Extra left').'</td>
	    					<td style="width: 33%">'.$this->l('Extra right').'</td>
	    				</tr>
	    				<tr>
	    					<td>
	    						<input type="checkbox" name="pscheckoutPage'.$type_ref.'" '.($pscheckoutPage == 'pscheckoutPage'.$type_ref ? 'checked="checked"' : '').' value="pscheckoutPage'.$type_ref.'"/>
	    					</td>
	    					<td>
	    						<input type="checkbox" name="psextraLeft'.$type_ref.'" '.($psextraLeft == 'psextraLeft'.$type_ref ? 'checked="checked"' : '').' value="psextraLeft'.$type_ref.'"/>
	    					</td>
	    					<td>
	    						<input type="checkbox" name="psextraRight'.$type_ref.'" '.($psextraRight == 'psextraRight'.$type_ref ? 'checked="checked"' : '').' value="psextraRight'.$type_ref.'"/>
	    					</td>
	    				</tr>
	    				<tr>
	    					<td>'.$this->l('Product footer').'</td>
	    					<td>'.$this->l('Product actions').'</td>
	    					<td>&nbsp;</td>
	    				</tr>
	    				<tr>
	    					<td>
	    						<input type="checkbox" name="psprFooter'.$type_ref.'" '.($psprFooter == 'psprFooter'.$type_ref ? 'checked="checked"' : '').' value="psprFooter'.$type_ref.'"/>
	    					</td>
	    					<td>
	    						<input type="checkbox" name="psprActions'.$type_ref.'" '.($psprActions == 'psprActions'.$type_ref ? 'checked="checked"' : '').' value="psprActions'.$type_ref.'"/>
	    					</td>
	    					<td>&nbsp;</td>
	    				</tr>
	    				
	    				
	    			</table>
	    			
	    		</div>';
				
    	
		// advertise text
		$divLangName = $type_ref."defaulttext";
		
		$_html .= '<label>'.$this->l('Promo button text').':</label>
    			
    				<div class="margin-form">';
		
    		$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
	    	$languages = Language::getLanguages(false);
	    	
	    	foreach ($languages as $language){
			$id_lng = (int)$language['id_lang'];
	    	$promo_default_text = Configuration::get($this->name.$type_ref.'defaulttext'.'_'.$id_lng);
	    	
			$_html .= '	<div id="'.$type_ref.'defaulttext_'.$language['id_lang'].'" 
							 style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;"
							 >

						<input type="text" style="width:400px"   
								  id="'.$type_ref.'defaulttext_'.$language['id_lang'].'" 
								  name="'.$type_ref.'defaulttext_'.$language['id_lang'].'" 
								  value="'.htmlentities(stripslashes($promo_default_text), ENT_COMPAT, 'UTF-8').'"/>
						</div>';
	    	}
			$_html .= '';
			ob_start();
			$this->displayFlags($languages, $defaultLanguage, $divLangName, $type_ref.'defaulttext');
			$displayflags = ob_get_clean();
			$_html .= $displayflags;
			$_html .= '<div style="clear:both"></div>';
			$_html .= '<p class="clear">'.$this->l('Promo button text').'</p>';
			$_html .= '</div>';
    	
		// advertise text
		
    	
    	// Number of Refferals
    	$_html .= '<label>'.$this->l('Number of Referrals').':</label>
    			
    				<div class="margin-form">
					<input type="text" name="'.$type_ref.'refnum"  style="width: 50px"
			                		value="'.Tools::getValue($type_ref.'refnum', Configuration::get($this->name.$type_ref.'refnum')).'">
				</div>';
		
    	$_html .= $this->_updateButton(array('name'=>$type.'ref'));
    	
    	$_html .=	'</fieldset>'; 
		
		$_html .= '</form>';
    	
    	return $_html;
    }
    

    
    private function _referralsManagerForm(){
    	
    	$_html = '';
    	
	     $id = (int)Tools::getValue('id');
        if(Tools::getValue('start_mod')){
        	$start = Tools::getValue('start_mod');
        } else {
        	$start = 0;
        }
    	
    	$modulePath = dirname(__FILE__);		
		$moduleUrl = $this->getUrl();
		
		$currentUrl = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$currentUrl = preg_replace("#&add=.*$#", "", $currentUrl);
		$currentUrl = preg_replace("#&id=.*$#", "", $currentUrl);
		$currentUrl = preg_replace("#&saved=.*$#", "", $currentUrl);
        
		$is_l = $this->is_l();
		
    	if ($id)
		{	
			if(Tools::getValue('start_modref')){
	        	$start = Tools::getValue('start_modref');
	        } else {
	        	$start = 0;
	        }
			$step = $this->stepref;
			$_info = $this->getItem(array('start'=>$start,'step' => $step,'id'=>$id));
			$data = $_info['data'];
			$count_all = $_info['count_all'];
			$_data_item = $_info['data_item'];
			
			### translates ###
			$ref_manager_text = $this->l('Referrals Manager');
			$back_text =  $this->l('Back');
			$id_text = $this->l('ID');
			$customer_name_text = $this->l('Customer Name');
			$fb_ref_text = $this->l('Facebook referrals');
			$tw_ref_text = $this->l('Twitter referrals');
			$linked_ref_text = $this->l('LinkedIn referrals');
			$google_ref_text = $this->l('Google referrals');
			
			$ip_text = $this->l('IP');
			$type_ref_text = $this->l('Type Referral');
			$fb_ref_one_text = $this->l('Facebook referral');
			$tw_ref_one_text = $this->l('Twitter referral');
			$linkedin_ref_one_text = $this->l('LinkedIn referral');
			$google_ref_one_text = $this->l('Google referral');
			$customer_ref_text = $this->l('Customer referrals:');
			
			$no_items_text = $this->l('There is no items.');
			### translates ###
			
			ob_start();
			include($modulePath . "/tpl/edit.php");
			$_html .= ob_get_contents();
			ob_end_clean();
		}
		else
		{
			$step = $this->step;
			$_info = $this->getItems(array('start'=>$start,'step' => $step));
			$data = $_info['data'];
			$count_all = $_info['count_all'];
			
			### translates ###
			$ref_manager_text = $this->l('Referrals Manager');
			$id_text = $this->l('ID');
			$customer_text = $this->l('Customer');
			$fb_ref_text = $this->l('Facebook referrals');
			$tw_ref_text = $this->l('Twitter referrals');
			$linked_ref_text = $this->l('LinkedIn referrals');
			$google_ref_text = $this->l('Google referrals');
			$no_items_text = $this->l('There is no items.');
			### translates ###
			
			ob_start();
			include($modulePath . "/tpl/grid.php");
			$_html .= ob_get_contents();
			
			ob_end_clean();
		}
		
		return $_html;
        
    }
   
    
	private function _drawReferralsSettingsForm(){
	$cookie = $this->context->cookie;
		
	global $currentIndex;
    	$_html = '';
    	
    	
	if(version_compare(_PS_VERSION_, '1.5', '>')){
    	// datapicker
    	$context = Context::getContext();
		$_html .= $context->controller->addJqueryUi('ui.datepicker');
		
		
		ob_start();
		$id = array('datepickerFrom', 'datepickerTo');
		$time = false;
		echo '<script type="text/javascript" src="'.__PS_BASE_URI__.'js/jquery/jquery-ui.will.be.removed.in.1.6.js"></script>';
		echo '<link type="text/css" rel="stylesheet" href="'.__PS_BASE_URI__.'js/jquery/ui/themes/ui-lightness/jquery.ui.theme.css" />';
		echo '<link type="text/css" rel="stylesheet" href="'.__PS_BASE_URI__.'js/jquery/ui/themes/ui-lightness/jquery.ui.datepicker.css" />';	
		$iso = Db::getInstance()->getValue('SELECT iso_code FROM '._DB_PREFIX_.'lang WHERE `id_lang` = '.(int)Context::getContext()->language->id);
		if ($iso != 'en')
			echo '<script type="text/javascript" src="'.__PS_BASE_URI__.'js/jquery/ui/i18n/jquery.ui.datepicker-'.Tools::htmlentitiesUTF8($iso).'.js"></script>';
		echo '<script type="text/javascript">';
			if (is_array($id))
			foreach ($id as $id2)
			 bindDatepicker($id2, $time);
			else
			 bindDatepicker($id, $time);
		echo '</script>';
		// datapicker
		$_html .= ob_get_clean();
		}
		
    	$_html .= '
        <form action="'.$_SERVER['REQUEST_URI'].'" method="post" >';
    	$_html .= '<fieldset style="margin-top:10px;">
					<legend><img src="../modules/'.$this->name.'/img/connects-logo.png" />'.$this->l('Referrals Settings').'</legend>
					
					';
    	
    	
		
    	
		$divLangName = "coupondesc";
		
    	// Promotional Store Name multi
		
		/*$_html .= '<label>'.$this->l('Promotional Store Name:').'</label>
    			
    				<div class="margin-form">';
		
    		$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
	    	$languages = Language::getLanguages(false);
	    	
	    	foreach ($languages as $language){
			$id_lng = (int)$language['id_lang'];
	    	$storename = Configuration::get($this->name.'storename'.'_'.$id_lng);
	    	
	    	
			$_html .= '	<div id="storename_'.$language['id_lang'].'" 
							 style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;"
							 >

						<input type="text" style="width:400px"   
								  id="storename_'.$language['id_lang'].'" 
								  name="storename_'.$language['id_lang'].'" 
								  value="'.htmlentities(stripslashes($storename), ENT_COMPAT, 'UTF-8').'"/>
						</div>';
	    	}
			$_html .= '';
			ob_start();
			$this->displayFlags($languages, $defaultLanguage, $divLangName, 'storename');
			$displayflags = ob_get_clean();
			$_html .= $displayflags;
			$_html .= '<div style="clear:both"></div>';
			
			$_html .= '</div>';
			*/
    	// Promotional Store Description Multi
    	
    	/*$_html .= '<label>'.$this->l('Promotional Store Description:').'</label>
    			
    				<div class="margin-form">';
		
    		$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
	    	$languages = Language::getLanguages(false);
	    	
	    	foreach ($languages as $language){
			$id_lng = (int)$language['id_lang'];
	    	$storedesc = Configuration::get($this->name.'storedesc'.'_'.$id_lng);
	    	
	    	
			$_html .= '	<div id="sstoredesc_'.$language['id_lang'].'" 
							 style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;"
							 >

						<textarea class="rte"  cols="46" rows="5" style="width:400px"   
								  id="storedesc_'.$language['id_lang'].'" 
								  name="storedesc_'.$language['id_lang'].'">'.htmlentities(stripslashes($storedesc), ENT_COMPAT, 'UTF-8').'</textarea>
								  
						</div>';
	    	}
			$_html .= '';
			ob_start();
			$this->displayFlags($languages, $defaultLanguage, $divLangName, 'sstoredesc');
			$displayflags = ob_get_clean();
			$_html .= $displayflags;
			$_html .= '<div style="clear:both"></div>';
			
			$_html .= '</div>';*/
			
    	// Promotional Store Description Multi
    	
    	
    	// Coupon Description Multi
    	
		$_html .= '<label>'.$this->l('Coupon Description:').'</label>
    			
    				<div class="margin-form">';
		
    		$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
	    	$languages = Language::getLanguages(false);
	    	
	    	foreach ($languages as $language){
			$id_lng = (int)$language['id_lang'];
	    	$coupondesc = Configuration::get($this->name.'coupondesc'.'_'.$id_lng);
	    	
	    	
			$_html .= '	<div id="coupondesc_'.$language['id_lang'].'" 
							 style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;"
							 >

						<input type="text" style="width:400px"   
								  id="coupondesc_'.$language['id_lang'].'" 
								  name="coupondesc_'.$language['id_lang'].'" 
								  value="'.htmlentities(stripslashes($coupondesc), ENT_COMPAT, 'UTF-8').'"/>
						</div>';
	    	}
			$_html .= '';
			ob_start();
			$this->displayFlags($languages, $defaultLanguage, $divLangName, 'coupondesc');
			$displayflags = ob_get_clean();
			$_html .= $displayflags;
			$_html .= '<div style="clear:both"></div>';
			
			$_html .= '</div>';
    	// Coupon Description Multi
    	
			
			
    	
    	
    	// discount type
    	$_html .= '<label>'.$this->l('Discount Type:').'</label>
    			
    				<div class="margin-form">
    				<select class="select" name="discount_type" onChange="selectItemsFb(this.selectedIndex)"
							id="discount_type">
						<option '.(Tools::getValue('discount_type', Configuration::get($this->name.'discount_type'))  == 1 ? 'selected="selected" ' : '').' value="1">'.$this->l('Percentages').'</option>
						<option '.(Tools::getValue('discount_type', Configuration::get($this->name.'discount_type')) == 2 ? 'selected="selected" ' : '').' value="2">'.$this->l('Currency').'</option>
					</select>
					
				</div>
				
				<script type="text/javascript">
    	function selectItemsFb(id)
			{
			if(id==0){
				$("#fb-currency").hide();
				$("#fb-percentage").show(200);
			} else {
				$("#fb-percentage").hide();
				$("#fb-currency").show(200);
			}
				
			}
		</script>
				';
    	
    	if($this->_is16)
    		$cur = Currency::getCurrenciesByIdShop(Context::getContext()->shop->id);
    	else
    		$cur = Currency::getCurrencies();
    	
    	// Discount Amount
    	
    	$_html .= '<div id="fb-currency" 
    				'.(Tools::getValue('discount_type', Configuration::get($this->name.'discount_type')) == 2 ? '' : 'style="display:none" ').'>';
	
    	
    	$_html .= '<div class="margin-form">
    				<table cellpadding="5" style="border: 1px solid #BBB;" border="0">
											<tr>
												<th style="width: 80px;">'.$this->l('Currency').'</th>
												<th>'.$this->l('Discount Amount:').'</th>
											</tr>';
    	
    	
    	foreach ($cur AS $_cur)
					$_html .= '<tr>
									<td>
										'.(Configuration::get('PS_CURRENCY_DEFAULT') == $_cur['id_currency'] ? '<span style="font-weight: bold;">' : '').htmlentities($_cur['name'], ENT_NOQUOTES, 'utf-8').(Configuration::get('PS_CURRENCY_DEFAULT') == $_cur['id_currency'] ? '</span>' : '').'
									</td>
									<td>
											<input type="text" name="fbrefamount['.(int)($_cur['id_currency']).']" id="fbrefamount['.(int)($_cur['id_currency']).']" value="'.Tools::getValue('fbrefamount['.(int)($_cur['id_currency']).']', Configuration::get('fbrefamount_'.(int)($_cur['id_currency']))).'" 
											style="width: 50px; text-align: right;" /> '.$_cur['sign'].'
									</td>		
								</tr>	
									';
		$_html .= '</table></div>';
    	
    	$_html .= '</div>
    	
    	<div id="fb-percentage" '.(Tools::getValue('discount_type', Configuration::get($this->name.'discount_type'))  == 1 ? '' : 'style="display:none"').'>
    	<label style="font-size: 13px; font-weight: bold; color: rgb(0, 0, 0);">'.$this->l('Voucher percentage:').'</label>
    	<div class="margin-form">
    	<input type="text" name="percentage_val"
    			
			   value="'.Tools::getValue('percentage_val', Configuration::get($this->name.'percentage_val')).'">%
		</div>
		</div>
			                		
    	';
    	
    	$_html .= '<label>'.$this->l('Minimum checkout').':</label>
    			
    				<div class="margin-form">
    				<input type="checkbox" value="'.(Configuration::get($this->name.'isminamount') == true ? 1 : 0).'"
    				name="'.$this->name.'isminamount" id="'.$this->name.'isminamount"
    				'.(Configuration::get($this->name.'isminamount') == true ? 'checked="checked" ' : '').'>

	    					
				</div>
				
		<script type="text/javascript">
		
		$("#'.$this->name.'isminamount").change(function() {
        if($(this).is(":checked")) {
            //alert("check");
            $("#'.$this->name.'isminamount").val($(this).is(":checked"));        
    	
            $("#fan-isminamount").show(200);
        } else {
        	//alert("no check");
            $("#fan-isminamount").hide(200);
        }
        });
    
    	</script>
				';
    	
    	$_html .= '<div id="fan-isminamount" 
    				'.(Configuration::get($this->name.'isminamount') == true? '' : 'style="display:none" ').'>';
		
    	$_html .= '	<div class="margin-form">
    				<table cellpadding="5" style="border: 1px solid #BBB;" border="0">
											<tr>
												<th style="width: 80px;">'.$this->l('Currency').'</th>
												<th>'.$this->l('Minimum checkout').'</th>
											</tr>';
    	if($this->_is16)
    		$cur = Currency::getCurrenciesByIdShop(Context::getContext()->shop->id);
    	else
    		$cur = Currency::getCurrencies();
		foreach ($cur AS $_cur)
					$_html .= '<tr>
									<td>
										'.(Configuration::get('PS_CURRENCY_DEFAULT') == $_cur['id_currency'] ? '<span style="font-weight: bold;">' : '').htmlentities($_cur['name'], ENT_NOQUOTES, 'utf-8').(Configuration::get('PS_CURRENCY_DEFAULT') == $_cur['id_currency'] ? '</span>' : '').'
									</td>
									<td>
											<input type="text" name="fbrefminamount['.(int)($_cur['id_currency']).']" id="fbrefminamount['.(int)($_cur['id_currency']).']" value="'.(int)Tools::getValue('fbrefminamount['.(int)($_cur['id_currency']).']', Configuration::get('fbrefminamount_'.(int)($_cur['id_currency']))).'" 
											style="width: 50px; text-align: right;" /> '.$_cur['sign'].'
									</td>		
								</tr>	
									';
		$_html .= '</table></div>';
    	
    	$_html .= '</div>';
    	
    	// select categories
			$_html .= '
						<label>'.$this->l('Select categories').':</label>
    					<div class="margin-form" style="margin-bottom:20px">';		
					
			$cat = new Category();
			$list_cat = $cat->getCategories($cookie->id_lang);
			
			$_html .= '<table class="table">';
			$_html .= '<tr>
						<th><input type="checkbox" onclick="checkDelBoxes(this.form, \'categoryBox[]\', this.checked)" class="noborder" name="checkme"></th>
						<th>ID</th>
						<th style="width: 400px">'.$this->l('Name').'</th>
						</tr>';
			$current_cat = Category::getRootCategory()->id;
			ob_start();
			$this->recurseCategoryForInclude($list_cat, $list_cat, $current_cat);
			$cat_option = ob_get_clean();
			
			$_html .= $cat_option;
			
			$_html .= '</table>';
			
			$_html .= '</div>';
 			
			// select categories
    	
    	
    	
    	// calendar
    	//$_html .= $this->displayCalendar();
    	
			// Term of validity
    	$_html .= '<label>'.$this->l('Term of validity').':</label>
    			
    				<div class="margin-form">
					<input type="text" name="tvalid"  style="width: 50px"
			                		value="'.Tools::getValue('tvalid', Configuration::get($this->name.'tvalid')).'">&nbsp; '.$this->l('hours').'
			         <p class="clear">'.$this->l('Voucher term of validity in hours').'.</p>
				</div>';
    	
    	// Cumulative with others vouchers
    	$_html .= '<label>'.$this->l('Cumulative with others vouchers').':</label>
				<div class="margin-form">
				
					<input type="radio" value="1" id="text_list_on" name="cumulativeother"
							'.(Tools::getValue('cumulativeother', Configuration::get($this->name.'cumulativeother')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					
					<input type="radio" value="0" id="text_list_off" name="cumulativeother"
						   '.(!Tools::getValue('cumulativeother', Configuration::get($this->name.'cumulativeother')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
				</div>';
    	$_html .='<br/>';
    	
    	// Cumulative with price reductions
    	$_html .= '<label>'.$this->l('Cumulative with price reductions').':</label>
				<div class="margin-form">
				
					<input type="radio" value="1" id="text_list_on" name="cumulativereduc"
							'.(Tools::getValue('cumulativereduc', Configuration::get($this->name.'cumulativereduc')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					
					<input type="radio" value="0" id="text_list_off" name="cumulativereduc"
						   '.(!Tools::getValue('cumulativereduc', Configuration::get($this->name.'cumulativereduc')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
				</div>';
    	$_html .= $this->_updateButton(array('name'=>'refsettings'));
    	
    	$_html .=	'</fieldset>'; 
		
		$_html .= '</form>';
    	
    	return $_html;
    }
	
    
    function recurseCategoryForInclude($indexedCategories, $categories, $current, $id_category = 1, $id_category_default = NULL)
	{
		global $done;
		static $irow;
		$id_obj = intval(Tools::getValue($this->identifier));

		if (!isset($done[$current['infos']['id_parent']]))
			$done[$current['infos']['id_parent']] = 0;
		$done[$current['infos']['id_parent']] += 1;

		$todo = @sizeof($categories[$current['infos']['id_parent']]);
		$doneC = $done[$current['infos']['id_parent']];

		$level = $current['infos']['level_depth'] + 1;
		$img = $level == 1 ? 'lv1.gif' : 'lv'.$level.'_'.($todo == $doneC ? 'f' : 'b').'.gif';
	//var_dump(in_array($id_category,explode(",",Configuration::get($this->name.'catbox'))));
		echo '
		<tr class="'.($irow++ % 2 ? 'alt_row' : '').'">
			<td>
				<input type="checkbox" name="categoryBox[]" class="categoryBox'.($id_category_default == $id_category ? ' id_category_default' : '').'" id="categoryBox_'.$id_category.'" value="'.$id_category.'" '.((in_array($id_category,explode(",",Configuration::get($this->name.'catbox'))) OR in_array($id_category, $indexedCategories) OR (intval(Tools::getValue('id_category')) == $id_category AND !intval($id_obj))) ? ' checked="checked"' : '').' />
			</td>
			<td>
				'.$id_category.'
			</td>
			<td>
				<img src="../modules/'.$this->name.'/i/'.$img.'" alt="" /> &nbsp;<label for="categoryBox_'.$id_category.'" class="t">'.stripslashes($this->hideCategoryPosition($current['infos']['name'])).'</label>
			</td>
		</tr>';

		if (isset($categories[$id_category]))
			foreach ($categories[$id_category] AS $key => $row)
				if ($key != 'infos')
					$this->recurseCategoryForInclude($indexedCategories, $categories, $categories[$id_category][$key], $key, $id_category_default);
	}
	
	function recurseCategoryIds($indexedCategories, $categories, $current, $id_category = 1, $id_category_default = NULL)
	{
		global $done;
		static $irow;
		
		// set variables
		static $_idsCat;
		
		if ($id_category == 1) {
			$_idsCat = null;
		}
		
		$id_obj = intval(Tools::getValue($this->identifier));

		if (!isset($done[$current['infos']['id_parent']]))
			$done[$current['infos']['id_parent']] = 0;
		$done[$current['infos']['id_parent']] += 1;

		$todo = @sizeof($categories[$current['infos']['id_parent']]);
		$doneC = $done[$current['infos']['id_parent']];

		$_idsCat[] = (string)$id_category;
		//echo $id_category.",";

		if (isset($categories[$id_category]))
			foreach ($categories[$id_category] AS $key => $row)
				if ($key != 'infos')
					$this->recurseCategoryIds($indexedCategories, $categories, $categories[$id_category][$key], $key, $id_category_default);
		return $_idsCat;
	}
	
	function getIdsCategories(){
		/// get all category ids ///
		$cookie = $this->context->cookie;
		
		$cat = new Category();
		$list_cat = $cat->getCategories($cookie->id_lang);
		$current_cat = Category::getRootCategory()->id;
		$cat_ids = $this->recurseCategoryIds($list_cat, $list_cat, $current_cat);
		$cat_ids = implode(",",$cat_ids);
		return $cat_ids;
		/// get all category ids ///
	}
    
	public function hideCategoryPosition($name)
	{
		return preg_replace('/^[0-9]+\./', '', $name);
	}
    
    
    
public function getfacebooklib($id_lang){
    	
    	$lang = new Language((int)$id_lang);
		
    	$lng_code = isset($lang->language_code)?$lang->language_code:$lang->iso_code;
    	if(strstr($lng_code, '-')){
			$res = explode('-', $lng_code);
			$language_iso = strtolower($res[0]).'_'.strtoupper($res[1]);
		} else {
			$language_iso = strtolower($lng_code).'_'.strtoupper($lng_code);
		}
			
			
		if (!in_array($language_iso, $this->getfacebooklocale()))
			$language_iso = "en_US";
		
		if (Configuration::get('PS_SSL_ENABLED') == 1)
			$url = "https://";
		else
			$url = "http://";
		
		return array('url'=>$url . 'connect.facebook.net/'.$language_iso.'/all.js#xfbml=1&appId='.Configuration::get($this->name.'appid'),
					  'lng_iso' => $language_iso);
    }
    
	public function getfacebooklocale()
	{
		$locales = array();

		if (($xml=simplexml_load_file(_PS_MODULE_DIR_ . $this->name."/lib/facebook_locales.xml")) === false)
			return $locales;
			
		$result = $xml->xpath('/locales/locale/codes/code/standard/representation');

		foreach ($result as $locale)
		{
			list($k, $node) = each($locale);
			$locales[] = $node;
		}
			
		return $locales;
	}
    
public function getOrderPage($data = null){
    	$smarty = $this->context->smarty;
		$cookie = $this->context->cookie;
		
		
		$http_referrer = isset($data['http_referrer'])?$data['http_referrer']:$this->_http_referer;
		
    	$id_lang = (int)$cookie->id_lang;
    	
    	$iso_lang = Language::getIsoById(intval($id_lang))."/";   
			
		if(!$this->_multiple_lang)
			$iso_lang = "";   
			
		
		// if order page    
   	   if(version_compare(_PS_VERSION_, '1.5', '>')){
	        $data = explode("?",$http_referrer);
	    	$data  = end($data);
	    	$data_url_rewrite_on = explode("/",$http_referrer);
	    	$data_url_rewrite_on = end($data_url_rewrite_on);
	    	
	    	$link = new Link();
	    	
	    	if(version_compare(_PS_VERSION_, '1.4', '>')){
			$my_account = $link->getPageLink("my-account", true, $id_lang);
	    	
			$quick_order =$link->getPageLink("quick-order", true, $id_lang); 
			
			$order = $link->getPageLink("order", true, $id_lang);
	    	} else {
	    		$my_account = "my-account";
	    	
				$quick_order ="quick-order"; 
			
				$order ="order";
	    	} 
			
	        if(version_compare(_PS_VERSION_, '1.6', '>')){
				$_http_host = Tools::getShopDomainSsl(true, true).__PS_BASE_URI__; 
			} else {
				$_http_host = _PS_BASE_URL_.__PS_BASE_URI__;
			}
			
			$order = str_replace($_http_host.$iso_lang,'',$order);
			
			if(Configuration::get('PS_REWRITING_SETTINGS'))
	    		$uri = str_replace($_http_host,'',$my_account);
	    	else 
	    		$uri = 'index.php?controller=my-account&id_lang='.$id_lang;
	    		
	    	
	    		
	    	$order_page = 0;
	        if($data == 'controller=order' || $data_url_rewrite_on == 'order' ||
	        	$data == 'controller=quick-order' || $data_url_rewrite_on == 'quick-order'){
	        		
	        	$order_page = 1;
	    		if($data == 'controller=order' || $data == 'controller=quick-order')
	    			$uri = 'index.php?controller=order&step=1&id_lang='.$id_lang;
	    		elseif($data_url_rewrite_on == 'order' || $data_url_rewrite_on = 'quick-order')
	    		 	$uri = $iso_lang.$order.'?step=1';
	    		 	
	    		 
	    	}
	    	$smarty->assign($this->name.'order_page', $order_page);
	    } else {
	    	$data = explode("/",$http_referrer);
	    	$data  = end($data);
	    	
	    	if(Configuration::get('PS_REWRITING_SETTINGS') && version_compare(_PS_VERSION_, '1.4', '>'))
	    		$uri = $iso_lang.'my-account';
	    	else 
	    		$uri = 'my-account.php?id_lang='.$id_lang;
	    	$order_page = 0;
	    	if($data == 'order.php' 
	    	|| $data == 'order'
	    	){
	    		$order_page = 1;
	    		if($data == 'order.php')
	    			$uri = 'order.php?step=1&id_lang='.$id_lang;
	    		elseif($data == 'order')
	    		 	$uri = $iso_lang.'order?step=1';
	    		 	
	    	}
	    	$smarty->assign($this->name.'order_page', $order_page);
	    }
	    
	    $smarty->assign($this->name.'uri', $uri);
    	// if order page
    	$smarty->assign($this->name.'http_referer', $http_referrer);
    	
    	return array('uri'=>$uri);
    }
    
public function setReferralsSettings(){
		$smarty = $this->context->smarty;
		$cookie = $this->context->cookie;
		$current_language = (int)$cookie->id_lang;
		
		$is_logged = isset($cookie->id_customer)?$cookie->id_customer:0;
		
		include_once(dirname(__FILE__).'/classes/fourreferralsModule.php');
		
		$id_product = 0; //(int)Tools::getValue('id_product');
		
		$data_exists_referrals = fourreferralsModule::getCustomerReferralsMyAccount(array('customer_id'=>$is_logged,'id_product'=>$id_product));


		$smarty->assign($this->name.'fe', $data_exists_referrals['facebook']);
		$smarty->assign($this->name.'te', $data_exists_referrals['twitter']);
		$smarty->assign($this->name.'ge', $data_exists_referrals['google']);
		$smarty->assign($this->name.'le', $data_exists_referrals['linkedin']);
		
		
		$is_l = $this->is_l();

		$frefnum =  Configuration::get($this->name.'frefnum');
		$trefnum =  Configuration::get($this->name.'trefnum');
		$grefnum =  Configuration::get($this->name.'grefnum');
		$lrefnum =  Configuration::get($this->name.'lrefnum');
		
		$smarty->assign(array(
			$this->name.'frefnum' => $frefnum,
			$this->name.'trefnum' => $trefnum,
			$this->name.'grefnum' => $grefnum,
			$this->name.'lrefnum' => $lrefnum,
			$this->name.'is_l' => $is_l,
		));	
		
		
		$id_product = (int)Tools::getValue('id_product');
 		if($id_product!=0){
		$_data_img = $this->_getPicture(array('product_id' => $id_product));
		$picture = $_data_img['img'];
	    //////
    	// for ps 1.5.0.0
			if(strpos($picture,"https://") !== false){
	    		$picture = str_replace("https://","",$picture);
	    		$picture = "https://".$picture;
	    		
	    	} else {
	    		$picture = str_replace("http://","",$picture);
	    		$picture = "http://".$picture;
	    	}
    	// end for ps 1.5.0.0
    	$_data = $this->_getInfoAboutProduct();
    	
 		} else {
 				if(version_compare(_PS_VERSION_, '1.6', '>')){
					$_http_host = Tools::getShopDomainSsl(true, true).__PS_BASE_URI__; 
				} else {
					$_http_host = _PS_BASE_URL_.__PS_BASE_URI__;
				}
				$_data = array(
						'name'=>Configuration::get('PS_SHOP_NAME'),
						'description'=>Configuration::get('PS_SHOP_NAME'),
						'url'=>$_http_host
						);
 				$picture = 	$_http_host.'img/logo.jpg';
 		}
    	
 		$smarty->assign($this->name.'product_id', $id_product);
    	
		$smarty->assign($this->name.'img', isset($picture)?$picture:'');
		$smarty->assign($this->name.'name', isset($_data['name'])?$_data['name']:'');
		$smarty->assign($this->name.'description', isset($_data['description'])?strip_tags($_data['description']):'');
		$smarty->assign($this->name.'url', isset($_data['url'])?str_replace('&','&amp;', $_data['url']):'');
		   
		foreach(array("f","g","l","t") as $type_ref){
		
			$smarty->assign($this->name.'_psextraLeft'.$type_ref, Configuration::get($this->name.'_psextraLeft'.$type_ref));
			$smarty->assign($this->name.'_psextraRight'.$type_ref, Configuration::get($this->name.'_psextraRight'.$type_ref));
			$smarty->assign($this->name.'_psprFooter'.$type_ref, Configuration::get($this->name.'_psprFooter'.$type_ref));
			$smarty->assign($this->name.'_psprActions'.$type_ref, Configuration::get($this->name.'_psprActions'.$type_ref));
			$smarty->assign($this->name.'_pscheckoutPage'.$type_ref, Configuration::get($this->name.'_pscheckoutPage'.$type_ref));

			$smarty->assign($this->name.$type_ref.'defaulttext', Configuration::get($this->name.$type_ref.'defaulttext_'.$current_language));
		
		}
		
		
		$smarty->assign($this->name.'gsize', Configuration::get($this->name.'gsize'));
		$smarty->assign($this->name.'lsize', Configuration::get($this->name.'lsize'));
		
		
	        
		
		}
		
		
public function hookCustomerAccount($params)
	{
		$smarty = $this->context->smarty;
		$cookie = $this->context->cookie;
		
		
		$smarty->assign($this->name.'fbrefon', Configuration::get($this->name.'fbrefon'));
		$smarty->assign($this->name.'twrefon', Configuration::get($this->name.'twrefon'));
		$smarty->assign($this->name.'grefon', Configuration::get($this->name.'grefon'));
		$smarty->assign($this->name.'lrefon', Configuration::get($this->name.'lrefon'));
		
		$smarty->assign($this->name.'is16', $this->_is16);
		
		
		$smarty->assign($this->name.'is16', $this->_is16);
		###### Product reviews + Google Snippets, Breadcrumb, Rich Pin ######
		if(Configuration::get($this->name.'reviewson') == 1){
	
		$id_customer = (int)$cookie->id_customer;
		
		$smarty->assign(array($this->name.'id_customer' => $id_customer));
		
		$smarty->assign($this->name.'is_ps15', $this->_is15);
		}
		$smarty->assign($this->name.'reviewson', Configuration::get($this->name.'reviewson'));
		
		###### Product reviews + Google Snippets, Breadcrumb, Rich Pin ######
		
		
		$is_logged = isset($cookie->id_customer)?$cookie->id_customer:0;
		if ($is_logged)
			return $this->display(__FILE__, 'socref-my-account.tpl');
	}
	
	
public function hookMyAccountBlock($params)
	{
		$smarty = $this->context->smarty;
		$cookie = $this->context->cookie;
		$smarty->assign($this->name.'is16', $this->_is16);
		###### Product reviews + Google Snippets, Breadcrumb, Rich Pin ######
		if(Configuration::get($this->name.'reviewson') == 1){
	
		$id_customer = (int)$cookie->id_customer;
		$smarty->assign($this->name.'is_ps15', $this->_is15);
		
		$smarty->assign(array($this->name.'id_customer' => $id_customer));
		
		}
		$smarty->assign($this->name.'reviewson', Configuration::get($this->name.'reviewson'));
		
		###### Product reviews + Google Snippets, Breadcrumb, Rich Pin ######
	
		
		return $this->display(__FILE__, 'my-account-block.tpl');
	}

	public function hookShoppingCart($params)
	{
		return $this->hookDisplayShoppingCartFooter($params);
	}
	
	public function hookDisplayShoppingCartFooter($params){
		
		$this->setReferralsSettings();
        
		return $this->display(__FILE__, 'cart.tpl');	
	}
    
public function hookOrderConfirmation($params){
	
	$smarty = $this->context->smarty;
		$cookie = $this->context->cookie;
		
		$this->setReferralsSettings();
		
		
		$_link_obj = new Link();
		$id_lang = intval($params['cookie']->id_lang);
		
		
		$_products_for_order = $params['objOrder']->getProducts();
    	
    	$ordered_items = array();
    	
    	foreach($_products_for_order as $_item){
    		$_product_id = (int) $_item['product_id'];
    		$ordered_items[] = $_item['product_name'];	
    	}
    	
    	$_obj_product = new Product($_product_id);
    	
    	foreach($_obj_product->getImages($id_lang) as $_item_img){
    		$id_img = (int) isset($_item_img['id_image'])?$_item_img['id_image']:0;
    		break;
    	}
    	
    	
		if(defined('_MYSQL_ENGINE_')){
    		$tpl_vars = @$smarty->tpl_vars;
    		$base_dir_tmp = @$tpl_vars['base_dir'];
	    	$base_dir = @$base_dir_tmp->value;
    		
    		$picture = $_link_obj->getImageLink($_product_id."-".$id_img,$_product_id."-".$id_img);
    		//$picture = str_replace($base_dir,"",$picture);
    		
    		// for ps 1.5.0.0
			if(strpos($picture,"https://") !== false){
	    		$picture = str_replace("https://","",$picture);
	    		$picture = "https://".$picture;
	    		
	    	} else {
	    		$picture = str_replace("http://","",$picture);
	    		$picture = "http://".$picture;
	    	}
    		// end for ps 1.5.0.0
    		
    	} else {
    		
    		$tpl_vars = @$smarty->_tpl_vars;
    		$base_dir = @$tpl_vars['base_dir'];
	    		
    		$data_product = $this->_getInfoAboutProduct();
	    	$info_product = $data_product;
	    	
	    	$picture = $_link_obj->getImageLink(
	    										$info_product['url'],
	    										$_product_id."-".$id_img."-large"
	    										);
	    	
	    	$picture = substr($base_dir,0,-1).$picture;
	    	
	    	
	    	
	    }
    	
    	$smarty->assign($this->name.'picture', isset($picture)?$picture:'');
		
		$current_language = (int)$cookie->id_lang;
		
		$smarty->assign(array(
		
		$this->name.'is_l' => $this->is_l,
		
		$this->name.'fbrefon' => Configuration::get($this->name.'fbrefon'),
		$this->name.'twrefon' => Configuration::get($this->name.'twrefon'),
		$this->name.'grefon' => Configuration::get($this->name.'grefon'),
		$this->name.'lrefon' => Configuration::get($this->name.'lrefon'),
		$this->name.'fbrefshareon' => Configuration::get($this->name.'fbrefshareon'),
		$this->name.'twrefshareon' => Configuration::get($this->name.'twrefshareon'),
		$this->name.'grefshareon' => Configuration::get($this->name.'grefshareon'),
		$this->name.'lrefshareon' => Configuration::get($this->name.'lrefshareon'),
		
		//$this->name.'name' => $this->name,
		$this->name.'cid' =>(int)$cookie->id_customer,
		//$this->name.'storename' => $this->l('My new orders in ').Configuration::get($this->name.'storename_'.$current_language),
		$this->name.'storedesc' => $this->l('I\'ve just ordered items: ').implode(', ', $ordered_items),
		));
		
		
		if (!empty($params['objOrder']) && is_object($params['objOrder'])) 
		{
			include_once(dirname(__FILE__).'/classes/featureshelp.class.php');
			$obj = new featureshelp();
	    	
			$guest = false;

            // check if customer is guest
            if (version_compare(_PS_VERSION_, '1.4', '>')) {
                $customer = new Customer($params['objOrder']->id_customer);

                if (Validate::isLoadedObject($customer)) {
                    $guest = $customer->isGuest();
                }
                unset($customer);
            }
			
			if (false === $obj->isDataExist(
											array('id_shop'=>$this->_id_shop, 
												  'order_id'=>$params['objOrder']->id
												 )
											)
				&&
                empty($guest)							
				) {
				
				if (Configuration::get($this->name.'reminder') && isset($params['objOrder']->id_customer) &&
					is_numeric($params['objOrder']->id_customer)
				) {
					
					$status  = $obj->getStatus(
												array('id_shop'=>$this->_id_shop, 
													 'customer_id'=> $params['objOrder']->id_customer
													)
											   );

					if (false === $status) {
						$obj->addStatus(
										array('id_shop'=>$this->_id_shop, 
											  'customer_id'=> $params['objOrder']->id_customer,
											  'status'=>1
											 )
										);

						$add_status = 1;
					}
					
					if (!empty($add_status)) {
						$id_lang = $cookie->id_lang;
						$products = $obj->getProductsInOrder(
															  array('order_id'=>$params['objOrder']->id,
																	'id_lang' => $id_lang
																	)
															 );

						if (!empty($products)) {
							$data = array();
							foreach ($products as $product) {
								
								$product['rate'] = 0;
								$attributes = Product::getProductProperties($id_lang, $product);
								$data[] = array('title' => $attributes['name'], 
												 'category' => $attributes['category'], 
												 'link' => $attributes['link']
												);

								unset($attributes);
							}
							
							$obj->saveOrder(
											array('id_shop'=>$this->_id_shop,  
												  'order_id' => $params['objOrder']->id, 
												  'customer_id' => $params['objOrder']->id_customer, 
												  'data' => $data
												  )
											);

							unset($data);
						}
					}
				}
			}
		}
		
		return $this->display(__FILE__, 'orderconfirm.tpl');
		
		}
	
		
public function hookproductTabContent($params)
	{
		$smarty = $this->context->smarty;
		$cookie = $this->context->cookie;
		
		$smarty->assign($this->name.'urlrewrite_on', Configuration::get($this->name.'urlrewrite_on'));
		
		if($this->_is_friendly_url){
			$smarty->assign($this->name.'iso_lng', $this->_iso_lng);
		} else {
			$smarty->assign($this->name.'iso_lng', '');
		}
		
		$smarty->assign($this->name.'is16', $this->_is16);
		##### Product Questions #####
		if(Configuration::get($this->name.'pqon') == 1){
		
		include_once(dirname(__FILE__).'/classes/prodquestionshelp.class.php');
		$obj_prodquestionshelp = new prodquestionshelp();
		
		$id_product = (int)Tools::getValue('id_product');
		$id_customer = (int)$cookie->id_customer;
		
		$count_items = $obj_prodquestionshelp->countItems(array('id_product'=>$id_product));
		$smarty->assign(array($this->name.'count_itemspq' => $count_items));
				
		$info_items = $obj_prodquestionshelp->getItems(array('id_product'=>$id_product,
														     'start' => 0
														   )
													 );

		$pagenav = $obj_prodquestionshelp->PageNav(0,$count_items,
													(int)Configuration::get($this->name.'qperpage_q'),$id_product);
		
		$smarty->assign(array('pagenavpq' => $pagenav,'itemspq' => $info_items['items']));
		
		$customer_lastname = "";
		$customer_firstname = "";
		$email = "";
		if($id_customer != 0){
			$customer_lastname = $cookie->customer_lastname;
			$customer_firstname = $cookie->customer_firstname;
			$email = $cookie->email;
		}
		$smarty->assign(array($this->name.'customer_lastname' => $customer_lastname));
		$smarty->assign(array($this->name.'customer_firstname' => $customer_firstname));
		$smarty->assign(array($this->name.'email' => $email));
		
		
		$smarty->assign(array($this->name.'id_customer' => $id_customer));
		$smarty->assign(array($this->name.'id_product' => $id_product));
		$smarty->assign($this->name.'qsettings', Configuration::get($this->name.'qsettings'));
		$smarty->assign($this->name.'qis_captcha', Configuration::get($this->name.'qis_captcha'));
		
		$smarty->assign($this->name.'is_ps15',$this->_is15);
		}
		$smarty->assign($this->name.'pqon', Configuration::get($this->name.'pqon'));
		##### Product Questions #####

		###### Product reviews + Google Snippets, Breadcrumb, Rich Pin ######
		
		
		if(Configuration::get($this->name.'reviewson') == 1){
		
		$id_lang = (int)$cookie->id_lang;
		$iso_lang = Language::getIsoById(intval($id_lang));
		$smarty->assign($this->name.'iso_langrev', $iso_lang);
		
		include_once(dirname(__FILE__).'/classes/reviewshelp.class.php');
		$obj_reviewshelp = new reviewshelp();
		
		$id_customer = (int)$cookie->id_customer;
		$id_product = (int)Tools::getValue('id_product');
		
		
		$smarty->assign(array($this->name.'id_customer' => $id_customer));
		$smarty->assign(array($this->name.'id_product' => $id_product));
		
		
		$data_in = $obj_reviewshelp->getReviews(array('id_product' => $id_product,'start' => 0));
		$reviews = $data_in['reviews'];
		$count_all_reviews = $data_in['count_all_reviews'];
		$pagenav = $obj_reviewshelp->PageNavSiteOrig(0,$count_all_reviews,(int)Configuration::get($this->name.'revperpage'),$id_product);
		
		$smarty->assign(array('reviews' => $reviews,'pagenav' => $pagenav));
		
		$smarty->assign($this->name.'settings', Configuration::get($this->name.'settings'));
		
		$smarty->assign($this->name.'subjecton', Configuration::get($this->name.'subjecton'));
		$smarty->assign($this->name.'recommendedon', Configuration::get($this->name.'recommendedon'));
    	$smarty->assign($this->name.'ipon', Configuration::get($this->name.'ipon'));
		
    	$smarty->assign($this->name.'is_captcha', Configuration::get($this->name.'is_captcha'));
    	$smarty->assign($this->name.'position', Configuration::get($this->name.'position'));
    	$smarty->assign($this->name.'is_onereview', Configuration::get($this->name.'is_onereview'));
    	
    	$is_buy = $obj_reviewshelp->checkProductBought(array('id_product'=>$id_product,
    												         'id_customer'=>$id_customer)
    												   );
		$smarty->assign(array($this->name.'is_buy' => $is_buy));
		
		if(Configuration::get($this->name.'is_onereview') != 1){
			$is_alreadyaddreview = $obj_reviewshelp->checkIsUserAlreadyAddReview(array('id_product'=>$id_product,
																				   'id_customer'=>$id_customer)
																			 );
			$smarty->assign(array($this->name.'is_add' => $is_alreadyaddreview));
		
        } else {
			$smarty->assign(array($this->name.'is_add' => 0));
		}
	
		$smarty->assign($this->name.'is_ps15',$this->_is15);
		
		$smarty->assign($this->name.'id_hook_gsnipblock_left_right',Configuration::get($this->name.'id_hook_gsnipblock'));
		
		}
		$smarty->assign($this->name.'reviewson', Configuration::get($this->name.'reviewson'));
		
		###### Product reviews + Google Snippets, Breadcrumb, Rich Pin ######
		
		
		#### blog ####
		if(Configuration::get($this->name.'blogon') == 1){
	
		include_once(dirname(__FILE__).'/classes/blog.class.php');
		$obj_blog = new bloghelp();
    	$_data_cat = $obj_blog->getCategoriesBlock();
		
		$smarty->assign(array($this->name.'categories' => $_data_cat['categories']
							  )
						);	
		
		$smarty->assign($this->name.'tab_blog_pr', Configuration::get($this->name.'tab_blog_pr'));
		
		
		}
		$smarty->assign($this->name.'blogon', Configuration::get($this->name.'blogon'));
		#### blog ####
		
		$APPID = Configuration::get($this->name.'appid');
		$smarty->assign($this->name.'appid', $APPID);	 

		$BGCUSTOM = Configuration::get($this->name.'BGCUSTOM');
		if ( $BGCUSTOM == 1 ) { $BGCOLOR = Configuration::get($this->name.'BGCOLOR'); $BGCOLOR = "$BGCOLOR"; }
		else { $BGCOLOR = "transparent"; }
		$smarty->assign($this->name.'BGCOLOR', $BGCOLOR);	 
		
		
		$REDIRECT = Configuration::get($this->name.'REDIRECT');
		if(Tools::getValue('fb_comment_id') && $REDIRECT == 1 ) { $smarty->assign($this->name.'REDIRECT', 1); }
		else { $smarty->assign($this->name.'REDIRECT', 0); }

		$COMMENTNBR = Configuration::get($this->name.'COMMENTNBR');
		$smarty->assign($this->name.'COMMENTNBR', $COMMENTNBR);
		$COMMENTWIDTH = Configuration::get($this->name.'COMMENTWIDTH');
		$smarty->assign($this->name.'COMMENTWIDTH', $COMMENTWIDTH);
		$REGISTERSWITCH = Configuration::get($this->name.'REGISTERSWITCH');
		$smarty->assign($this->name.'REGISTERSWITCH', $REGISTERSWITCH);				 		
		$TITLESWITCH = Configuration::get($this->name.'TITLESWITCH');
		$smarty->assign($this->name.'TITLESWITCH', $TITLESWITCH);
		$LIKETOPSWITCH = Configuration::get($this->name.'LIKETOPSWITCH');
		$smarty->assign($this->name.'LIKETOPSWITCH', $LIKETOPSWITCH);	
		$LIKEBOTTOMSWITCH = Configuration::get($this->name.'LIKEBOTTOMSWITCH');
		$smarty->assign($this->name.'LIKEBOTTOMSWITCH', $LIKEBOTTOMSWITCH);	
		$DISCLAMERSWITCH = Configuration::get($this->name.'DISCLAMERSWITCH');
		$smarty->assign($this->name.'DISCLAMERSWITCH', $DISCLAMERSWITCH);	
		
		$smarty->assign($this->name.'COMMENTON', Configuration::get($this->name.'COMMENTON'));
		
		$cookie = $this->context->cookie;
				
				
		$smarty->assign($this->name.'is16', $this->_is16);
		
		$smarty->assign('this_path', $this->_path);
		return $this->display(__FILE__, 'TabContent.tpl');
		

	}	
	
public function hookproductTab($params)
	{
		$smarty = $this->context->smarty;
		$cookie = $this->context->cookie;
		$smarty->assign($this->name.'is16', $this->_is16);
		
		#### Product questions ####
		if(Configuration::get($this->name.'pqon') == 1){
		include_once(dirname(__FILE__).'/classes/prodquestionshelp.class.php');
		$obj_prodquestionshelp = new prodquestionshelp();
		$id_product = (int)Tools::getValue('id_product');
		$count_items = $obj_prodquestionshelp->countItems(array('id_product'=>$id_product));
		
		$smarty->assign(array($this->name.'count_items' => $count_items));
		}
		$smarty->assign($this->name.'pqon', Configuration::get($this->name.'pqon'));
		#### Product questions ####
		
		###### Product reviews + Google Snippets, Breadcrumb, Rich Pin ######
		if(Configuration::get($this->name.'reviewson') == 1){
		
		$id_customer = (int)$cookie->id_customer;
		
		include_once(dirname(__FILE__).'/classes/reviewshelp.class.php');
		$obj_reviewshelp = new reviewshelp();
		
		$smarty->assign(
						array(
								'nbReviews' => (int)($obj_reviewshelp->getCountReviews(
																			  array(
																			  		'id_product' => (int)(Tools::getValue('id_product'))
																			  		)
																			  )
													  ),
								'textReview' => $obj_reviewshelp->number_ending( (int)($obj_reviewshelp->getCountReviews(
																			  array(
																			  		'id_product' => (int)(Tools::getValue('id_product'))
																			  		)
																			  )
													  		), $this->l('reviews'), $this->l('review'), $this->l('reviews')),
								'avg_rating' => $obj_reviewshelp->getAvgReview(
													  					 array(
																			  	'id_product' => (int)(Tools::getValue('id_product'))
																			  	)
													  				 )
								
							 )
						);
		$smarty->assign(array($this->name.'id_customer' => $id_customer));
		
		$is_logged = isset($params['cookie']->id_customer)?$params['cookie']->id_customer:0;
		$smarty->assign($this->name.'islogged', $is_logged);
		
		}
		$smarty->assign($this->name.'reviewson', Configuration::get($this->name.'reviewson'));
		
		###### Product reviews + Google Snippets, Breadcrumb, Rich Pin ######
		
		
		
		#### blog ####
		if(Configuration::get($this->name.'blogon') == 1){
	
		 include_once(dirname(__FILE__).'/classes/blog.class.php');
		$obj_blog = new bloghelp();
    	$_data_cat = $obj_blog->getCategoriesBlock();
		
		$smarty->assign(array($this->name.'categories' => $_data_cat['categories']
							  )
						);	
		$smarty->assign($this->name.'tab_blog_pr', Configuration::get($this->name.'tab_blog_pr'));
		}
		$smarty->assign($this->name.'blogon', Configuration::get($this->name.'blogon'));
		#### blog ####	
		 		
		$LOGOSWITCH = Configuration::get($this->name.'LOGOSWITCH');
		$smarty->assign($this->name.'LOGOSWITCH', $LOGOSWITCH);	
		$FOCUS = Configuration::get($this->name.'FOCUS');
		$smarty->assign($this->name.'FOCUS', $FOCUS);		

		$smarty->assign($this->name.'COMMENTON', Configuration::get($this->name.'COMMENTON'));

		$smarty->assign($this->name.'is16', $this->_is16);
		
		
		$smarty->assign('this_path', $this->_path);
		return $this->display(__FILE__, 'tab.tpl');
	}
		
function hookhome($params)
	{
		$smarty = $this->context->smarty;
		
		$smarty->assign($this->name.'urlrewrite_on', Configuration::get($this->name.'urlrewrite_on'));
		
		if($this->_is_friendly_url){
			$smarty->assign($this->name.'iso_lng', $this->_iso_lng);
		} else {
			$smarty->assign($this->name.'iso_lng', '');
		}
		
		### News ###
		if(Configuration::get($this->name.'newson') == 1){
		include_once(dirname(__FILE__).'/classes/blocknewshelp.class.php');
		$obj_blocknewshelp = new blocknewshelp();
    	$_data = $obj_blocknewshelp->getItemsBlock();
		$smarty->assign(array($this->name.'itemsblocknews' => $_data['items']
							  )
						);
		
		
		$smarty->assign($this->name.'news_home', Configuration::get($this->name.'news_home'));
		}
		$smarty->assign($this->name.'newson', Configuration::get($this->name.'newson'));
		
		### News ####
		
		### GuestBook ###
		if(Configuration::get($this->name.'guon') == 1){
		include_once(dirname(__FILE__).'/classes/guestbook.class.php');
		$obj_guestbook = new guestbook();
    	$_data = $obj_guestbook->getItems(array('start'=>0,
    											 'step'=>Configuration::get($this->name.'gbook_blc')
    											));

		$smarty->assign(array($this->name.'reviews_g' => $_data['reviews'], 
							  $this->name.'count_all_reviews_g' => $_data['count_all_reviews'])
						);
		
		$smarty->assign($this->name.'g_home', Configuration::get($this->name.'g_home'));
		
		$is_ps15 = 0;
		if($this->_is15){
		$is_ps15 = 1;	
		}
		
		$smarty->assign($this->name.'is_ps15', $is_ps15);
		
		} 
		$smarty->assign($this->name.'guon', Configuration::get($this->name.'guon'));
		
		### GuestBook ###
		
		### FAQ ###
		if(Configuration::get($this->name.'faqon') == 1){
		include_once(dirname(__FILE__).'/classes/blockfaqhelp.class.php');
		$obj_blockfaqhelp = new blockfaqhelp();
    	$_data = $obj_blockfaqhelp->getItemsBlock();
		
		$smarty->assign(array($this->name.'itemsblock' => $_data['items']
							  )
						);
		$smarty->assign($this->name.'faq_home', Configuration::get($this->name.'faq_home'));
		
		} 
		$smarty->assign($this->name.'faqon', Configuration::get($this->name.'faqon'));
		
		### FAQ ###
		
		#### Testimonials ####
		if(Configuration::get($this->name.'testimon') == 1){
		include_once(dirname(__FILE__).'/classes/shopreviews.class.php');
		$obj_shopreviews = new shopreviews();
    	$_data = $obj_shopreviews->getTestimonials(array('start'=>0,'step'=>Configuration::get($this->name.'tlast')));

		$smarty->assign(array($this->name.'reviews_t' => $_data['reviews'], 
							  $this->name.'count_all_reviews_t' => $_data['count_all_reviews'])
						);
		
		//$smarty->assign($this->name.'tposition', Configuration::get($this->name.'tposition'));
		$smarty->assign($this->name.'t_home', Configuration::get($this->name.'t_home'));
		
		$smarty->assign($this->name.'tis_web', Configuration::get($this->name.'tis_web'));
		$is_ps15 = 0;
		if($this->_is15){
		$is_ps15 = 1;	
		}
		
		$smarty->assign($this->name.'is_ps15', $is_ps15);
		$smarty->assign($this->name.'trssontestim', Configuration::get($this->name.'trssontestim'));
		
		} 
		$smarty->assign($this->name.'testimon', Configuration::get($this->name.'testimon'));
		
		#### Testimonials ####
		
		###### Product reviews + Google Snippets, Breadcrumb, Rich Pin ######
		if(Configuration::get($this->name.'reviewson') == 1){
		
		if(Configuration::get($this->name.'homeon') == 1){
			include_once(dirname(__FILE__).'/classes/reviewshelp.class.php');
			$obj_reviewshelp = new reviewshelp();
	    	$_data = $obj_reviewshelp->getLastReviews(array('start'=>0,'step'=>Configuration::get($this->name.'revlast')));
	
			$smarty->assign(array($this->name.'reviews' => $_data['reviews']));
			
			$ps15 = 0;
			if(version_compare(_PS_VERSION_, '1.5', '>')){
				$ps15 = 1;
			} 
			$smarty->assign($this->name.'is_ps15', Configuration::get($this->name.'is_ps15'));
			$smarty->assign($this->name.'rsson_snip', Configuration::get($this->name.'rsson_snip'));
			$smarty->assign($this->name.'x_reviews', Configuration::get($this->name.'x_reviews'));
		
		}
		
		$smarty->assign($this->name.'homeon_snip', Configuration::get($this->name.'homeon'));
		
		}
		$smarty->assign($this->name.'reviewson', Configuration::get($this->name.'reviewson'));
		
		###### Product reviews + Google Snippets, Breadcrumb, Rich Pin ######
		
		
		#### blog ####
		if(Configuration::get($this->name.'blogon') == 1){
	
		include_once(dirname(__FILE__).'/classes/blog.class.php');
		$obj_blog = new bloghelp();
    	$_data_post = $obj_blog->getRecentsPosts();
		
		$smarty->assign(array($this->name.'posts' => $_data_post['posts']
							  )
						);
		
		$smarty->assign($this->name.'block_display_date', Configuration::get($this->name.'block_display_date'));
		$smarty->assign($this->name.'block_display_img', Configuration::get($this->name.'block_display_img'));

		
		
		$smarty->assign($this->name.'block_last_home', Configuration::get($this->name.'block_last_home'));
		
		$ps15 = 0;
		if($this->_is15){
			$ps15 = 1;
		} 
		$smarty->assign($this->name.'is_ps15', $ps15);
		
		$smarty->assign($this->name.'rsson', Configuration::get($this->name.'rsson'));
		
		
		
		}
		$smarty->assign($this->name.'blogon', Configuration::get($this->name.'blogon'));
		#### blog ####
		
		
		// google widget
        $smarty->assign($this->name.'gwon', Configuration::get($this->name.'gwon'));
        $smarty->assign($this->name.'positiong', Configuration::get($this->name.'positiong'));
        
        include_once(dirname(__FILE__).'/classes/googlewidgethelp.class.php');
		$obj_googlewidgethelp = new googlewidgethelp();
		$data = $obj_googlewidgethelp->getItem();
       	$googlewidget = $data['item'];   
        $smarty->assign($this->name.'googlewidget', $googlewidget);
		
		// twitter widget
		$smarty->assign($this->name.'twitteron', Configuration::get($this->name.'twitteron'));
		$smarty->assign($this->name.'user_name', Configuration::get($this->name.'user_name'));
		$smarty->assign($this->name.'position', Configuration::get($this->name.'position'));
		$smarty->assign($this->name.'width', Configuration::get($this->name.'width'));
		$smarty->assign($this->name.'height', Configuration::get($this->name.'height'));
		$smarty->assign($this->name.'tweets_link', Configuration::get($this->name.'tweets_link'));
		$smarty->assign($this->name.'tw_color_scheme', Configuration::get($this->name.'tw_color_scheme'));
		$smarty->assign($this->name.'tw_aria_pol', Configuration::get($this->name.'tw_aria_pol'));
		$smarty->assign($this->name.'tw_widgetid', Configuration::get($this->name.'tw_widgetid'));
		
		// twitter widget
		
		
		$smarty->assign($this->name.'fbon', Configuration::get($this->name.'fbon'));
		
		$smarty->assign($this->name.'lb_facebook_page_url', Configuration::get($this->name.'lb_facebook_page_url'));
        $smarty->assign($this->name.'lb_width', Configuration::get($this->name.'lb_width'));
        $smarty->assign($this->name.'lb_faces',(Configuration::get($this->name.'lb_faces')) ? 'true' : 'false');
        $smarty->assign($this->name.'lb_height', Configuration::get($this->name.'lb_height'));
        $smarty->assign($this->name.'lb_connections', Configuration::get($this->name.'lb_connections'));
        $smarty->assign($this->name.'lb_stream', (Configuration::get($this->name.'lb_stream')) ? 'true' : 'false');
        $smarty->assign($this->name.'lb_header', (Configuration::get($this->name.'lb_header')) ? 'true' : 'false');
        $smarty->assign($this->name.'lb_transparency', (Configuration::get($this->name.'lb_transparency')) ? 'true' : 'false');
        $smarty->assign($this->name.'lb_bg_color', Configuration::get($this->name.'lb_bg_color'));
        $smarty->assign($this->name.'positionfb', Configuration::get($this->name.'positionfb'));
        
        $pos = Configuration::get($this->name.'_pos');
		$smarty->assign($this->name.'_isonpinwidget', Configuration::get($this->name.'_isonpinwidget'));
		
		if($pos == 'home'){
			$smarty->assign($this->name.'pinterestwidget', $this->assignvars());
        } else {
			$smarty->assign($this->name.'pinterestwidget', '');
        }
        
        
        
        
        
		return $this->display(__FILE__, 'home.tpl');		
	}
		
public function hookproductFooter($params){
		
	$smarty = $this->context->smarty;
		
		$smarty->assign($this->name.'is16', $this->_is16);
		###### Product reviews + Google Snippets, Breadcrumb, Rich Pin ######
		//if(Configuration::get($this->name.'reviewson') == 1){
		
		
		$_product_id = Tools::getValue('id_product');
		
		if(Configuration::get($this->name.'gsnipblock') &&
		  (Configuration::get($this->name.'id_hook_gsnipblock') == 6) &&
		  $_product_id
		  ){
		
		$smarty->assign($this->name.'productfooter', 
						$this->snippetBlockSettings(array('product_id'=>$_product_id,'params'=>$params))
						);
		} else {
			  	$smarty->assign($this->name.'productfooter','');
		}		
		
		  
		// pinterest
		$smarty->assign($this->name.'pinvis_on', Configuration::get($this->name.'pinvis_on'));
		$smarty->assign($this->name.'pinbutton_on', Configuration::get($this->name.'pinbutton_on'));
		$smarty->assign($this->name.'pbuttons', Configuration::get($this->name.'pbuttons'));
		$smarty->assign($this->name.'_productFooter', Configuration::get($this->name.'_productFooter'));
		// pinterest
		
		//}
		//$smarty->assign($this->name.'reviewson', Configuration::get($this->name.'reviewson'));
		
		###### Product reviews + Google Snippets, Breadcrumb, Rich Pin ######
		
    	$this->setReferralsSettings();
    	
		return $this->display(__FILE__, 'productfooter.tpl');
	}
	
public function hookproductActions($params){
		$this->setReferralsSettings();
		
		$smarty = $this->context->smarty;
		
		
		###### Product reviews + Google Snippets, Breadcrumb, Rich Pin ######
		//if(Configuration::get($this->name.'reviewson') == 1){
		$smarty->assign($this->name.'is16', $this->_is16);
			
		$_product_id = Tools::getValue('id_product');
		
		if(Configuration::get($this->name.'gsnipblock') &&
		  (Configuration::get($this->name.'id_hook_gsnipblock') == 8) &&
		  $_product_id
		  ){
		
		$smarty->assign($this->name.'productactions',
						$this->snippetBlockSettings(array('product_id'=>$_product_id,'params'=>$params))
						);
		} else {
		  	$smarty->assign($this->name.'productactions','');
		}		
		
		// pinterest
		$smarty->assign($this->name.'pinvis_on', Configuration::get($this->name.'pinvis_on'));
		$smarty->assign($this->name.'pinbutton_on', Configuration::get($this->name.'pinbutton_on'));
		$smarty->assign($this->name.'pbuttons', Configuration::get($this->name.'pbuttons'));
		$smarty->assign($this->name.'_productActions', Configuration::get($this->name.'_productActions'));
		// pinterest 

		//}
		//$smarty->assign($this->name.'reviewson', Configuration::get($this->name.'reviewson'));
		
		###### Product reviews + Google Snippets, Breadcrumb, Rich Pin ######
			
		////////
 		$_product_id = (int)Tools::getValue('id_product');
		$_data_img = $this->_getPicture(array('product_id' => $_product_id,'params'=>$params));
		$picture = $_data_img['img'];
	    //////
    	
		// for ps 1.5.0.0
			if(strpos($picture,"https://") !== false){
	    		$picture = str_replace("https://","",$picture);
	    		$picture = "https://".$picture;
	    		
	    	} else {
	    		$picture = str_replace("http://","",$picture);
	    		$picture = "http://".$picture;
	    	}
    	// end for ps 1.5.0.0
		
    	$_data = $this->_getInfoAboutProduct($params);
		//$picture = $_data['img'];
    	$productname = $_data['name'];
		
		$smarty->assign($this->name.'appid', Configuration::get($this->name.'appid'));
    	$smarty->assign($this->name.'picture', isset($picture)?$picture:'');
    	$smarty->assign($this->name.'shareon', Configuration::get($this->name.'shareon'));
    	$smarty->assign($this->name.'productname', $productname);
		
		return $this->display(__FILE__, 'productactions.tpl');
	}
	
public function hookExtraRight($params)
	{
		$smarty = $this->context->smarty;
		$cookie = $this->context->cookie;
		$smarty->assign($this->name.'is16', $this->_is16);
		global $page_name, $logged;

		#### Product questions ####
		if(Configuration::get($this->name.'pqon') == 1){
		include_once(dirname(__FILE__).'/classes/prodquestionshelp.class.php');
		$obj_prodquestionshelp = new prodquestionshelp();
		$id_product = (int)Tools::getValue('id_product');
		$count_items = $obj_prodquestionshelp->countItems(array('id_product'=>$id_product));
		
		$smarty->assign(array($this->name.'count_items' => $count_items));
		}
		$smarty->assign($this->name.'position_ask_q', Configuration::get($this->name.'position_ask_q'));
		$smarty->assign($this->name.'pqon', Configuration::get($this->name.'pqon'));
		#### Product questions ####
		
		###### Product reviews + Google Snippets, Breadcrumb, Rich Pin ######
		
		
		$_product_id = Tools::getValue('id_product');
		if(Configuration::get($this->name.'gsnipblock') &&
		  (Configuration::get($this->name.'id_hook_gsnipblock') == 5) &&
		  $_product_id
		  ){
				$smarty->assign($this->name.'extrarightsnippet', 
								$this->snippetBlockSettings(array('product_id'=>$_product_id,'params'=>$params))
								);
		  } else {
		  	$smarty->assign($this->name.'extrarightsnippet','');
		  }
		  
		 // pinterest
		$smarty->assign($this->name.'pinvis_on', Configuration::get($this->name.'pinvis_on'));
		$smarty->assign($this->name.'pinbutton_on', Configuration::get($this->name.'pinbutton_on'));
		$smarty->assign($this->name.'pbuttons', Configuration::get($this->name.'pbuttons'));
		$smarty->assign($this->name.'_extraRight', Configuration::get($this->name.'_extraRight'));
		// pinterest 
    	
		
		###### Product reviews + Google Snippets, Breadcrumb, Rich Pin ######
    	$this->setReferralsSettings();
    	
    	
    	$content_only = (int)Tools::getValue('content_only');
    	$smarty->assign($this->name.'content_only', $content_only);
    	
		return $this->display(__FILE__, 'share.tpl');		
	}
		
function hookExtraLeft($params)
	{
		
		$smarty = $this->context->smarty;
		
		$smarty->assign($this->name.'is16', $this->_is16);
		#### Product questions ####
		if(Configuration::get($this->name.'pqon') == 1){
		include_once(dirname(__FILE__).'/classes/prodquestionshelp.class.php');
		$obj_prodquestionshelp = new prodquestionshelp();
		$id_product = (int)Tools::getValue('id_product');
		$count_items = $obj_prodquestionshelp->countItems(array('id_product'=>$id_product));
		
		$smarty->assign(array($this->name.'count_items' => $count_items));
		}
		$smarty->assign($this->name.'position_ask_q', Configuration::get($this->name.'position_ask_q'));
		$smarty->assign($this->name.'pqon', Configuration::get($this->name.'pqon'));
		#### Product questions ####
		
		###### Product reviews + Google Snippets, Breadcrumb, Rich Pin ######
		
		$_product_id = Tools::getValue('id_product');
		
		if(Configuration::get($this->name.'gsnipblock') &&
		  (Configuration::get($this->name.'id_hook_gsnipblock') == 9) &&
		  $_product_id
		  ){
		
		$smarty->assign($this->name.'extraleftsnippet', 
						$this->snippetBlockSettings(array('product_id'=>$_product_id,'params'=>$params))
						);
		} else {
			  	$smarty->assign($this->name.'extraleftsnippet','');
		}		
		
		// pinterest
		$smarty->assign($this->name.'pinvis_on', Configuration::get($this->name.'pinvis_on'));
		$smarty->assign($this->name.'pinbutton_on', Configuration::get($this->name.'pinbutton_on'));
		$smarty->assign($this->name.'pinterestbuttons', Configuration::get($this->name.'pinterestbuttons'));
		$smarty->assign($this->name.'_extraLeft', Configuration::get($this->name.'_extraLeft'));
		// pinterest
		
		###### Product reviews + Google Snippets, Breadcrumb, Rich Pin ######
		
		$smarty->assign($this->name.'buttons', Configuration::get($this->name.'buttons'));
		$smarty->assign($this->name.'twitterbon', Configuration::get($this->name.'twitterbon'));
		
		$smarty->assign($this->name.'buttonsfb', Configuration::get($this->name.'buttonsfb'));
		$smarty->assign($this->name.'twitterfbon', Configuration::get($this->name.'twitterfbon'));
		
		
		$smarty->assign($this->name.'likeon', Configuration::get($this->name.'likeon'));
		$smarty->assign($this->name.'likelayout', Configuration::get($this->name.'likelayout'));
		$smarty->assign($this->name.'likefaces', Configuration::get($this->name.'likefaces'));
		$smarty->assign($this->name.'widthlikebox', Configuration::get($this->name.'widthlikebox'));
		$smarty->assign($this->name.'likecolor', Configuration::get($this->name.'likecolor'));
		
		
		$smarty->assign($this->name.'buttons1', Configuration::get($this->name.'buttons1'));
		$smarty->assign($this->name.'status1', Configuration::get($this->name.'status1'));
		
		// pinterest
		$smarty->assign($this->name.'pinterestbon', Configuration::get($this->name.'pinterestbon'));
		$smarty->assign($this->name.'pbuttons', Configuration::get($this->name.'pbuttons'));
		
		$_product_id = (int)Tools::getValue('id_product');
		$_data_img = $this->_getPicture(array('product_id' => $_product_id,'params'=>$params));
		$picture = $_data_img['img'];
		$smarty->assign($this->name.'img', isset($picture)?$picture:'');
		
		//  linkedin
		$smarty->assign($this->name.'linkedinbon', Configuration::get($this->name.'linkedinbon'));
		$smarty->assign($this->name.'linkedinbuttons', Configuration::get($this->name.'linkedinbuttons'));
	
		$this->setReferralsSettings();
		
		$content_only = (int)Tools::getValue('content_only');
    	$smarty->assign($this->name.'content_only', $content_only);
		
		return $this->display(__FILE__, 'like.tpl');		
	}
	
function hookFooter($params){
 		
    	$smarty = $this->context->smarty;
		$cookie = $this->context->cookie;
		
		
		$smarty->assign($this->name.'is16', $this->_is16);
		###### Product reviews + Google Snippets, Breadcrumb, Rich Pin ######
		//if(Configuration::get($this->name.'reviewson') == 1){
		
		
		$_product_id = Tools::getValue('id_product');
		
		if(Configuration::get($this->name.'gsnipblock') &&
		  (Configuration::get($this->name.'id_hook_gsnipblock') == 6) &&
		  $_product_id
		  ){
		
		$smarty->assign($this->name.'productfooter', 
						$this->snippetBlockSettings(array('product_id'=>$_product_id,'params'=>$params))
						);
		} else {
			  	$smarty->assign($this->name.'productfooter','');
		}		
		
		  
		// pinterest
		$smarty->assign($this->name.'pinvis_on', Configuration::get($this->name.'pinvis_on'));
		$smarty->assign($this->name.'pinbutton_on', Configuration::get($this->name.'pinbutton_on'));
		$smarty->assign($this->name.'pbuttons', Configuration::get($this->name.'pbuttons'));
		$smarty->assign($this->name.'_productFooter', Configuration::get($this->name.'_productFooter'));
		// pinterest
		
		//}
		//$smarty->assign($this->name.'reviewson', Configuration::get($this->name.'reviewson'));
		
		###### Product reviews + Google Snippets, Breadcrumb, Rich Pin ######
		
		
		$smarty->assign($this->name.'urlrewrite_on', Configuration::get($this->name.'urlrewrite_on'));
		
		if($this->_is_friendly_url){
			$smarty->assign($this->name.'iso_lng', $this->_iso_lng);
		} else {
			$smarty->assign($this->name.'iso_lng', '');
		}
		
		### News ###
		if(Configuration::get($this->name.'newson') == 1){
		include_once(dirname(__FILE__).'/classes/blocknewshelp.class.php');
		$obj_blocknewshelp = new blocknewshelp();
    	$_data = $obj_blocknewshelp->getItemsBlock();
		$smarty->assign(array($this->name.'itemsblocknews' => $_data['items']
							  )
						);
		
		
		$smarty->assign($this->name.'news_footer', Configuration::get($this->name.'news_footer'));
		}
		$smarty->assign($this->name.'newson', Configuration::get($this->name.'newson'));
		
		### News ####
		
		### GuestBook ###
		if(Configuration::get($this->name.'guon') == 1){
		include_once(dirname(__FILE__).'/classes/guestbook.class.php');
		$obj_guestbook = new guestbook();
    	$_data = $obj_guestbook->getItems(array('start'=>0,
    											 'step'=>Configuration::get($this->name.'gbook_blc')
    											));

		$smarty->assign(array($this->name.'reviews_g' => $_data['reviews'], 
							  $this->name.'count_all_reviews_g' => $_data['count_all_reviews'])
						);
		
		$smarty->assign($this->name.'g_footer', Configuration::get($this->name.'g_footer'));
		
		$is_ps15 = 0;
		if($this->_is15){
		$is_ps15 = 1;	
		}
		
		$smarty->assign($this->name.'is_ps15', $is_ps15);
		
		} 
		$smarty->assign($this->name.'guon', Configuration::get($this->name.'guon'));
		
		### GuestBook ###
		
		### FAQ ###
		if(Configuration::get($this->name.'faqon') == 1){
		include_once(dirname(__FILE__).'/classes/blockfaqhelp.class.php');
		$obj_blockfaqhelp = new blockfaqhelp();
    	$_data = $obj_blockfaqhelp->getItemsBlock();
		
		$smarty->assign(array($this->name.'itemsblock' => $_data['items']
							  )
						);
		$smarty->assign($this->name.'faq_footer', Configuration::get($this->name.'faq_footer'));
		
		} 
		$smarty->assign($this->name.'faqon', Configuration::get($this->name.'faqon'));
		
		### FAQ ###
		
		
		#### Testimonials ####
		if(Configuration::get($this->name.'testimon') == 1){
		include_once(dirname(__FILE__).'/classes/shopreviews.class.php');
		$obj_shopreviews = new shopreviews();
    	$_data = $obj_shopreviews->getTestimonials(array('start'=>0,'step'=>Configuration::get($this->name.'tlast')));

		$smarty->assign(array($this->name.'reviews_t' => $_data['reviews'], 
							  $this->name.'count_all_reviews_t' => $_data['count_all_reviews'])
						);
		
		//$smarty->assign($this->name.'tposition', Configuration::get($this->name.'tposition'));
		$smarty->assign($this->name.'t_footer', Configuration::get($this->name.'t_footer'));
		
		$smarty->assign($this->name.'tis_web', Configuration::get($this->name.'tis_web'));
		
		$is_ps15 = 0;
		if($this->_is15){
		$is_ps15 = 1;	
		}
		
		$smarty->assign($this->name.'is_ps15', $is_ps15);
		$smarty->assign($this->name.'trssontestim', Configuration::get($this->name.'trssontestim'));
		
		} 
		$smarty->assign($this->name.'testimon', Configuration::get($this->name.'testimon'));
		
		#### Testimonials ####
		
		
		###### Product reviews + Google Snippets, Breadcrumb, Rich Pin ######
		
		$_product_id = Tools::getValue('id_product');

		if(Configuration::get($this->name.'gsnipblock') &&
		  (Configuration::get($this->name.'id_hook_gsnipblock') == 7) &&
		  $_product_id
		  ){
		$smarty->assign($this->name.'footersnippet', 
						$this->snippetBlockSettings(array('product_id'=>$_product_id,'params'=>$params))
						);
		
		} else {
			$smarty->assign($this->name.'footersnippet','');
		}	
		
		$smarty->assign($this->name.'is_product_page', $_product_id);
		$smarty->assign($this->name.'pinvis_on', Configuration::get($this->name.'pinvis_on'));
		
		if(Configuration::get($this->name.'breadvis_on')==1){
			
		if(substr(_PS_VERSION_,0,3) == '1.3')
			$getTemplateVars_functions = 'get_template_vars';
		else
			$getTemplateVars_functions = 'getTemplateVars';
			
		if(!is_callable($smarty, $getTemplateVars_functions)){
			//$getTemplateVars = 'get_template_vars';
			$getTemplateVars = $getTemplateVars_functions;
		}
		if($smarty->{$getTemplateVars}('path')) {
			$path = $smarty->${'getTemplateVars'}('path');
			$output = $path;
			
			$path = preg_split('/<span class=\"navigation-pipe\">><\/span>/', $path);
			
			foreach($path as $key => $value) {
				$path[$key] = preg_replace('/^(<a href=\")([^>]*)([^<]*)(<\/a>)/', '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb">\1\2 itemprop="url"><span itemprop="title"\3</span>\4</span>', $value);
			}

			$returnTo = $this->l('return to');
			$home = $this->l('Home');
			$home = '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'._PS_BASE_URL_.__PS_BASE_URI__.'" title="'.$returnTo.' '.$home.'" itemprop="url"><span itemprop="title">'.$home.'</span></a></span>';
			
			$output = '<div style="display:none">'.$home.implode('', $path).'</div>';
			
			$smarty->assign($this->name.'breadcrambcustom',$output);
		} else {
				$smarty->assign($this->name.'breadcrambcustom','');
		}
		
		} else {
			$smarty->assign($this->name.'breadcrambcustom','');
		}
		
		$smarty->assign($this->name.'reviewson', Configuration::get($this->name.'reviewson'));
		
		###### Product reviews + Google Snippets, Breadcrumb, Rich Pin ######
		
		
		#### blog ####
		if(Configuration::get($this->name.'blogon') == 1){
		
		
		include_once(dirname(__FILE__).'/classes/blog.class.php');
		$obj_blog = new bloghelp();
    	$_data_cat = $obj_blog->getCategoriesBlock();
		$_data_post = $obj_blog->getRecentsPosts();
    	$_data_arch = $obj_blog->getArchives();
		$smarty->assign(array($this->name.'categories' => $_data_cat['categories'],
							  $this->name.'posts' => $_data_post['posts'],
							   $this->name.'arch' => $_data_arch['posts']
							  )
						);
		
						
		
		
		$smarty->assign($this->name.'block_display_date', Configuration::get($this->name.'block_display_date'));
		$smarty->assign($this->name.'block_display_img', Configuration::get($this->name.'block_display_img'));
		
		$smarty->assign($this->name.'cat_footer', Configuration::get($this->name.'cat_footer'));
		$smarty->assign($this->name.'posts_footer', Configuration::get($this->name.'posts_footer'));
		$smarty->assign($this->name.'arch_footer', Configuration::get($this->name.'arch_footer'));
		$smarty->assign($this->name.'search_footer', Configuration::get($this->name.'search_footer'));
		
		$smarty->assign($this->name.'rsson', Configuration::get($this->name.'rsson'));
		
		$ps15 = 0;
		if($this->_is15){
			$ps15 = 1;
		} 
		$smarty->assign($this->name.'is_ps15', $ps15);
		
		
		
		}
		$smarty->assign($this->name.'blogon', Configuration::get($this->name.'blogon'));
		#### blog ####
		
    	$smarty->assign('name_module', $this->displayName);
    	
    	// facebook API
    	$smarty->assign('blockfacebookappid', Configuration::get($this->name.'appid'));
    	$smarty->assign('blockfacebooksecret', Configuration::get($this->name.'secret'));
    	$smarty->assign($this->name.'appid', Configuration::get($this->name.'appid'));
    	$smarty->assign($this->name.'secret', Configuration::get($this->name.'secret'));
    	// facebook API
    	
    	$data_fb = $this->getfacebooklib((int)$cookie->id_lang);
		$smarty->assign($this->name.'lang', $data_fb['lng_iso']);
	
    	
    	
    	$smarty->assign($this->name.'is_ps5', $this->_is15);
    	
    	$is_logged = isset($cookie->id_customer)?$cookie->id_customer:0;
		$smarty->assign($this->name.'islogged', $is_logged);
		
    	### set variables for order page ####
		$this->getOrderPage();
    	### set variables for order page ####
    	
    	// positions connects
    	foreach($this->_prefix_position_connects as $prefix){
			$smarty->assign($this->name.'_top'.$prefix, Configuration::get($this->name.'_top'.$prefix));
    		$smarty->assign($this->name.'_footer'.$prefix, Configuration::get($this->name.'_footer'.$prefix));
    		$smarty->assign($this->name.'_authpage'.$prefix, Configuration::get($this->name.'_authpage'.$prefix));
    		$smarty->assign($this->name.'_welcome'.$prefix, Configuration::get($this->name.'_welcome'.$prefix));
    	
		}
    	// positions connects
    	
		
		############ social connects images ################
		include_once(dirname(__FILE__).'/classes/facebookhelp.class.php');
		$obj = new facebookhelp();
    	$data_img = $obj->getImages();
    	
    	foreach($this->_prefix_connects_image as $prefix_image => $value){
    		$img_big = $data_img[$prefix_image];
    		$img_small = $data_img[$prefix_image.'small'];
    		$smarty->assign($this->name.$prefix_image.'img', $img_big);
    		$smarty->assign($this->name.$prefix_image.'smallimg', $img_small);
    			
    	}
    	############ social connects images ################
		
  
  		// google widget
        $smarty->assign($this->name.'gwon', Configuration::get($this->name.'gwon'));
        $smarty->assign($this->name.'positiong', Configuration::get($this->name.'positiong'));
        
        include_once(dirname(__FILE__).'/classes/googlewidgethelp.class.php');
		$obj_googlewidgethelp = new googlewidgethelp();
		$data = $obj_googlewidgethelp->getItem();
       	$googlewidget = $data['item'];   
        $smarty->assign($this->name.'googlewidget', $googlewidget);
			
		// pinterest widget
 		$pos = Configuration::get($this->name.'_pos');
		$smarty->assign($this->name.'_isonpinwidget', Configuration::get($this->name.'_isonpinwidget'));
		
		if($pos == 'footer'){
			$smarty->assign($this->name.'pinterestwidget', $this->assignvars());
        } else {
			$smarty->assign($this->name.'pinterestwidget', '');
        }
        // pinterest widget
        
        // twitter widget
		$smarty->assign($this->name.'twitteron', Configuration::get($this->name.'twitteron'));
		$smarty->assign($this->name.'user_name', Configuration::get($this->name.'user_name'));
		$smarty->assign($this->name.'position', Configuration::get($this->name.'position'));
		$smarty->assign($this->name.'width', Configuration::get($this->name.'width'));
		$smarty->assign($this->name.'height', Configuration::get($this->name.'height'));
		$smarty->assign($this->name.'tweets_link', Configuration::get($this->name.'tweets_link'));
		$smarty->assign($this->name.'tw_color_scheme', Configuration::get($this->name.'tw_color_scheme'));
		$smarty->assign($this->name.'tw_aria_pol', Configuration::get($this->name.'tw_aria_pol'));
		$smarty->assign($this->name.'tw_widgetid', Configuration::get($this->name.'tw_widgetid'));
		
		// twitter widget
		
		
		$smarty->assign($this->name.'fbon', Configuration::get($this->name.'fbon'));
		
		$smarty->assign($this->name.'lb_facebook_page_url', Configuration::get($this->name.'lb_facebook_page_url'));
        $smarty->assign($this->name.'lb_width', Configuration::get($this->name.'lb_width'));
         $smarty->assign($this->name.'lb_faces',(Configuration::get($this->name.'lb_faces')) ? 'true' : 'false');
        $smarty->assign($this->name.'lb_height', Configuration::get($this->name.'lb_height'));
        $smarty->assign($this->name.'lb_connections', Configuration::get($this->name.'lb_connections'));
        $smarty->assign($this->name.'lb_stream', (Configuration::get($this->name.'lb_stream')) ? 'true' : 'false');
        $smarty->assign($this->name.'lb_header', (Configuration::get($this->name.'lb_header')) ? 'true' : 'false');
        $smarty->assign($this->name.'lb_transparency', (Configuration::get($this->name.'lb_transparency')) ? 'true' : 'false');
        $smarty->assign($this->name.'lb_bg_color', Configuration::get($this->name.'lb_bg_color'));
        $smarty->assign($this->name.'positionfb', Configuration::get($this->name.'positionfb'));
		
        
        
    	return $this->display(__FILE__, 'footer.tpl');
    }
    
    function hookHeader($params){
    	$smarty = $this->context->smarty;
		$cookie = $this->context->cookie;
		
		
		### Product questions ###
    	$smarty->assign($this->name.'pqon', Configuration::get($this->name.'pqon'));
		### Product questions ###
		
    	### News ###
    	$smarty->assign($this->name.'newson', Configuration::get($this->name.'newson'));
		### News ###
    	
    	### Guestbook ###
    	$smarty->assign($this->name.'guon', Configuration::get($this->name.'guon'));
		### Guestbook ###
    	
    	### faq ###
    	$smarty->assign($this->name.'faqon', Configuration::get($this->name.'faqon'));
    	### faq ###
    	
    	### Testimonials ###
    	$smarty->assign($this->name.'trssontestim', Configuration::get($this->name.'trssontestim'));
		$smarty->assign($this->name.'testimon', Configuration::get($this->name.'testimon'));
		
    	### Testimonials ###
    	
    	
    	### blog for prestashop ###
    	$smarty->assign($this->name.'rsson', Configuration::get($this->name.'rsson'));
		$smarty->assign($this->name.'blogon', Configuration::get($this->name.'blogon'));
		### blog for prestashop ###
		
		###### Product reviews + Google Snippets, Breadcrumb, Rich Pin ######
		$smarty->assign($this->name.'rsson_snip', Configuration::get($this->name.'rsson_snip'));
    	
    	$_product_id = Tools::getValue('id_product');
		
		$smarty->assign($this->name."gsnipblock",Configuration::get($this->name.'gsnipblock'));  
		$smarty->assign($this->name."_product_id",$_product_id);
		
		
		if($_product_id != 0 ){
		//// new ///
    	
		$product = new Product($_product_id,false,intval($cookie->id_lang));
		$currency = new Currency(intval($params['cart']->id_currency));
		if (!$currency) {
			try {
				$currency = Currency::getCurrencyInstance($cookie->id_currency);
			} catch (Exception $e) {
			}
		}
		$cover_img = $product->getCover($_product_id);
		$qty = $product->getQuantity($_product_id);
		$desc = ($product->description_short != "") ? $product->description_short : $product->description;
		$link = new Link();
		
		$data_picture = $this->_getPicture();
		$picture = $data_picture['picture'];
		
		$smarty->assign(array(
			'product_name' => $product->name,
			'product_image' => $picture,
			'product_price_custom' => number_format($product->getPrice(),2,".",","),
			'product_description' => Tools::htmlentitiesUTF8(strip_tags($desc)),
			'currency_custom' => $currency->iso_code,
			'quantity' => $qty,
			'stock_string' => ($qty > 0) ? 'in_stock' : 'out_of_stock'
		));
		
		}
		
		
		// pinterest
    	$smarty->assign($this->name.'is_product_page', $_product_id);
		$smarty->assign($this->name.'pinvis_on', Configuration::get($this->name.'pinvis_on'));
		$smarty->assign($this->name.'pinbutton_on', Configuration::get($this->name.'pinbutton_on'));
		// pinterest
		
		$smarty->assign($this->name.'reviewson', Configuration::get($this->name.'reviewson'));
		
		###### Product reviews + Google Snippets, Breadcrumb, Rich Pin ######
		
		$smarty->assign($this->name.'starscat', Configuration::get($this->name.'starscat'));
		
		if(Configuration::get($this->name.'starscat') == 1){
		### product list ####
		
		if(defined('_MYSQL_ENGINE_')){
			$page_name = $smarty->tpl_vars['page_name']->value;
		}else{
			$page_name = $smarty->_tpl_vars['page_name'];
		}
		
		$id_supplier = Tools::getValue('id_supplier');
		$id_manufacturer = Tools::getValue('id_manufacturer');
		$id_category = Tools::getValue('id_category');
		$id_product = Tools::getValue('id_product');
		
		$id_lang = intval($cookie->id_lang);
		
		$db = Db::getInstance();
		
		$is_category = 0;
		
		if($id_supplier){
			$is_category = 1;
			
			if(version_compare(_PS_VERSION_, '1.5', '>')){
			$sql = 'SELECT p.id_product
					FROM ' . _DB_PREFIX_ . 'product p 
					LEFT JOIN '._DB_PREFIX_.'product_lang pl ON (p.id_product = pl.id_product AND pl.id_lang = '.intval($id_lang).' 
					AND pl.id_shop = '.$this->_id_shop.') 
					LEFT JOIN '._DB_PREFIX_.'product_shop ps ON(p.id_product = ps.id_product AND ps.id_shop = '.$this->_id_shop.') 
					WHERE ps.active = 1
					AND p.id_supplier = '.$id_supplier.' LIMIT 100
					';
			}else {
				$sql = 'SELECT p.id_product FROM '._DB_PREFIX_.'product p
	            LEFT JOIN '._DB_PREFIX_.'product_lang pl 
	            ON (p.id_product = pl.id_product AND pl.id_lang = '.intval($id_lang).')
	            WHERE p.active = 1 AND p.id_supplier = '.$id_supplier.' LIMIT 100';
				
				
			}
		
		}elseif($id_manufacturer){
				$is_category = 1;
		
			if(version_compare(_PS_VERSION_, '1.5', '>')){
			$sql = 'SELECT p.id_product
					FROM ' . _DB_PREFIX_ . 'product p 
					LEFT JOIN '._DB_PREFIX_.'product_lang pl ON (p.id_product = pl.id_product AND pl.id_lang = '.intval($id_lang).' 
					AND pl.id_shop = '.$this->_id_shop.') 
					LEFT JOIN '._DB_PREFIX_.'product_shop ps ON(p.id_product = ps.id_product AND ps.id_shop = '.$this->_id_shop.') 
					WHERE ps.active = 1
					AND p.id_manufacturer = '.$id_manufacturer.' LIMIT 100
					';
			}else {
				$sql = 'SELECT p.id_product FROM '._DB_PREFIX_.'product p
	            LEFT JOIN '._DB_PREFIX_.'product_lang pl 
	            ON (p.id_product = pl.id_product AND pl.id_lang = '.intval($id_lang).')
	            WHERE p.active = 1 AND p.id_manufacturer = '.$id_manufacturer.' LIMIT 100';
			}
			
		}elseif($id_category){
			
				$is_category = 1;
		
			
		if(version_compare(_PS_VERSION_, '1.5', '>')){
			$sql = 'SELECT p.id_product
					FROM 
					' . _DB_PREFIX_ . 'product p
					JOIN ' . _DB_PREFIX_ . 'category_product cp
					ON cp.id_category = '.$id_category.' 
					LEFT JOIN '._DB_PREFIX_.'product_lang pl ON (p.id_product = pl.id_product AND pl.id_lang = '.intval($id_lang).' 
					AND pl.id_shop = '.$this->_id_shop.') 
					LEFT JOIN '._DB_PREFIX_.'product_shop ps ON(p.id_product = ps.id_product AND ps.id_shop = '.$this->_id_shop.') 
					WHERE ps.active = 1 LIMIT 100
					';
			}else {
				$sql = 'SELECT p.id_product FROM '._DB_PREFIX_.'product p
				JOIN ' . _DB_PREFIX_ . 'category_product cp
				ON cp.id_category = '.$id_category.' 
	            LEFT JOIN '._DB_PREFIX_.'product_lang pl 
	            ON (p.id_product = pl.id_product AND pl.id_lang = '.intval($id_lang).')
	            WHERE p.active = 1 LIMIT 100';
			}

		}elseif((strrpos($_SERVER['SCRIPT_NAME'], 'search.php') || strrpos($_SERVER['SCRIPT_NAME'], 'prices-drop.php') || (isset($_GET['controller']) && ($_GET['controller'] == 'search' || $_GET['controller'] == 'prices-drop')))){
				$is_category = 1;
		
		if(version_compare(_PS_VERSION_, '1.5', '>')){
			$sql = 'SELECT p.id_product
					FROM 
					' . _DB_PREFIX_ . 'product p
					LEFT JOIN '._DB_PREFIX_.'product_lang pl ON (p.id_product = pl.id_product AND pl.id_lang = '.intval($id_lang).' 
					AND pl.id_shop = '.$this->_id_shop.') 
					LEFT JOIN '._DB_PREFIX_.'product_shop ps ON(p.id_product = ps.id_product AND ps.id_shop = '.$this->_id_shop.') 
					WHERE ps.active = 1 LIMIT 100
					';
			}else {
				$sql = 'SELECT p.id_product FROM '._DB_PREFIX_.'product p
				LEFT JOIN '._DB_PREFIX_.'product_lang pl 
	            ON (p.id_product = pl.id_product AND pl.id_lang = '.intval($id_lang).')
	            WHERE p.active = 1 LIMIT 100';
			}
		}
		
		if(Configuration::get($this->name.'reviewson')==1){
		
	    include_once(dirname(__FILE__).'/classes/reviewshelp.class.php');
		$obj_reviewshelp = new reviewshelp();
			
		
		$data_products = array();
		
		if(isset($sql)){

				$items = $db->ExecuteS($sql);
				
				foreach($items as $item){
					$id_product = $item['id_product'];
					
					$data_product = $this->getProduct(array('id'=>$id_product));
					foreach($data_product['product'] as $_item_product){
    					$link_product = isset($_item_product['link'])?$_item_product['link']:'';
    				}

    				$count_review = $obj_reviewshelp->getCountReviews(array('id_product' => $id_product));
					$avg_rating = $obj_reviewshelp->getAvgReview(array('id_product' => $id_product));
			    	
					
					$data_products[$id_product] = array('id_product'=>$id_product, 
														'link'=>$link_product,
														'avg_rating'=>$avg_rating,
														'count_review'=>$count_review
														);
				}
				
		}
		$smarty->assign($this->name.'_data_products', $data_products);
		$smarty->assign($this->name.'is_category', $is_category);
		}
		
		}
		
		$smarty->assign($this->name.'reviewson', Configuration::get($this->name.'reviewson'));
		#### product list ####
		
		$smarty->assign($this->name.'is_l', $this->is_l);
    	
    	
		if(version_compare(_PS_VERSION_, '1.5', '>')){
    		$this->context->controller->addCSS(($this->_path).'css/referrals.css', 'all');
    		
    		//$this->context->controller->addJS('https://platform.twitter.com/widgets.js');
    	} 
    	
    	$smarty->assign(array(
		$this->name.'fbrefon' => Configuration::get($this->name.'fbrefon'),
		$this->name.'twrefon' => Configuration::get($this->name.'twrefon'),
		$this->name.'grefon' => Configuration::get($this->name.'grefon'),
		$this->name.'lrefon' => Configuration::get($this->name.'lrefon'),
		$this->name.'fbrefshareon' => Configuration::get($this->name.'fbrefshareon'),
		$this->name.'twrefshareon' => Configuration::get($this->name.'twrefshareon'),
		$this->name.'grefshareon' => Configuration::get($this->name.'grefshareon'),
		$this->name.'lrefshareon' => Configuration::get($this->name.'lrefshareon'),
		));
		
		
		$is_soc_ref_page = 0;
		if ((stripos($_SERVER['REQUEST_URI'], '/modules/'.$this->name.'/soc-referrals.php') !== FALSE)){
			$is_soc_ref_page = 1;
			
		}
		$smarty->assign($this->name.'is_soc_ref', $is_soc_ref_page);
		
		
		
		
		
		
		// facebook comments
    	$smarty->assign($this->name.'COMMENTON', Configuration::get($this->name.'COMMENTON'));
		
    	
    	// linkedin
    	$smarty->assign($this->name.'linkedinbon', Configuration::get($this->name.'linkedinbon'));
    	
    	
    	////////
 		$_product_id = (int)Tools::getValue('id_product');
		$_data_img = $this->_getPicture(array('product_id' => $_product_id,'params'=>$params));
		$picture = $_data_img['img'];
	    //////
	    
		// for ps 1.5.0.0
			if(strpos($picture,"https://") !== false){
	    		$picture = str_replace("https://","",$picture);
	    		$picture = "https://".$picture;
	    		
	    	} else {
	    		$picture = str_replace("http://","",$picture);
	    		$picture = "http://".$picture;
	    	}
    	// end for ps 1.5.0.0
		
		$_data = $this->_getInfoAboutProduct($params);
    	
		
    	$smarty->assign($this->name.'product_id', isset($_data['id_product'])?$_data['id_product']:0);
    	$smarty->assign($this->name.'name', isset($_data['name'])?$_data['name']:'');
    	$smarty->assign($this->name.'img', isset($picture)?$picture:'');
    	$smarty->assign($this->name.'description', isset($_data['description'])?strip_tags($_data['description']):'');
    	$smarty->assign($this->name.'url', isset($_data['url'])?str_replace('&','&amp;', $_data['url']):'');
    	$smarty->assign($this->name.'id_product', $_product_id);
    	
    	$APPADMIN = Configuration::get($this->name.'APPADMIN');
    	$smarty->assign($this->name.'APPADMIN', isset($APPADMIN)?$APPADMIN:'');
		
		$BGCUSTOM = Configuration::get($this->name.'BGCUSTOM');
		if ( $BGCUSTOM == 1 ) { $BGCOLOR = Configuration::get($this->name.'BGCOLOR'); $BGCOLOR = "$BGCOLOR"; }
		else { $BGCOLOR = "transparent"; }
		
		$smarty->assign($this->name.'BGCOLOR', $BGCOLOR);			
		$FORCE = Configuration::get($this->name.'FORCE');
		$smarty->assign($this->name.'FORCE', $FORCE);
		$ROUNDED = Configuration::get($this->name.'ROUNDED');
		$smarty->assign($this->name.'ROUNDED', $ROUNDED);

		$smarty->assign($this->name.'positionl', Configuration::get($this->name.'positionl'));
    	
    	$smarty->assign($this->name.'BGCOLORL', Configuration::get($this->name.'BGCOLORL'));
    	
    	$smarty->assign($this->name.'COMMENTON', Configuration::get($this->name.'COMMENTON'));
    	
         
    	$smarty->assign('name_module', $this->displayName);
    	
    	// facebook API
    	$smarty->assign('blockfacebookappid', Configuration::get($this->name.'appid'));
    	$smarty->assign('blockfacebooksecret', Configuration::get($this->name.'secret'));
    	
    	$smarty->assign($this->name.'appid', Configuration::get($this->name.'appid'));
    	$smarty->assign($this->name.'secret', Configuration::get($this->name.'secret'));
    	
    	// facebook API
    	
    	$data_fb = $this->getfacebooklib((int)$params['cookie']->id_lang);
    	$smarty->assign($this->name.'fbliburl', $data_fb['url']);
		$smarty->assign($this->name.'lang', $data_fb['lng_iso']);
	
    	
    	$smarty->assign($this->name.'is_ps5', $this->_is15);
    	
    	$is_logged = isset($params['cookie']->id_customer)?$params['cookie']->id_customer:0;
		$smarty->assign($this->name.'islogged', $is_logged);
		
    	
    	// positions connects
    	foreach($this->_prefix_position_connects as $prefix){
			$smarty->assign($this->name.'_top'.$prefix, Configuration::get($this->name.'_top'.$prefix));
    		$smarty->assign($this->name.'_footer'.$prefix, Configuration::get($this->name.'_footer'.$prefix));
    		$smarty->assign($this->name.'_authpage'.$prefix, Configuration::get($this->name.'_authpage'.$prefix));
    		$smarty->assign($this->name.'_welcome'.$prefix, Configuration::get($this->name.'_welcome'.$prefix));
    	
		}
    	// positions connects
    	
		
		############ social connects images ################
		include_once(dirname(__FILE__).'/classes/facebookhelp.class.php');
		$obj = new facebookhelp();
    	$data_img = $obj->getImages();
    	
    	foreach($this->_prefix_connects_image as $prefix_image => $value){
    		$img_big = $data_img[$prefix_image];
    		$img_small = $data_img[$prefix_image.'small'];
    		$smarty->assign($this->name.$prefix_image.'img', $img_big);
    		$smarty->assign($this->name.$prefix_image.'smallimg', $img_small);
    			
    	}
    	############ social connects images ################
		
    	$id_lang = (int)$cookie->id_lang;
    	
    	$iso_lang = Language::getIsoById(intval($id_lang))."/";   
			
    	if(!$this->_multiple_lang)
			$iso_lang = "";   
			
    	$smarty->assign($this->name.'iso_lang', $iso_lang);
    	  
    	if(Configuration::get('PS_REWRITING_SETTINGS') && version_compare(_PS_VERSION_, '1.4', '>')){
    		$smarty->assign($this->name.'is_rewrite', 1);
    	} else {
    		$smarty->assign($this->name.'is_rewrite',0);
    	}
    	
		
    	
    	### set variables for order page ####
		$this->getOrderPage();
    	### set variables for order page ####
    	
    	
    	$smarty->assign($this->name.'is15', $this->_is15);
    	$smarty->assign($this->name.'is16', $this->_is16);
		
    	$data_errors = $this->_translations;
    	$smarty->assign('ferror', $data_errors['facebook']);
    	$smarty->assign('terror', $data_errors['twitter']);
    	$smarty->assign('lerror', $data_errors['linkedin']);
    	$smarty->assign('merror', $data_errors['microsoft']);
    	$smarty->assign('perror', $data_errors['paypal']);
    	
    	
    	// configs 
    	
    	//paypal
    	$clientid = Configuration::get($this->name.'clientid');
		$psecret = Configuration::get($this->name.'psecret');
		$pcallback = Configuration::get($this->name.'pcallback');
		if(strlen($clientid)>0 && strlen($psecret)>0 && strlen($pcallback)>0){
			$smarty->assign($this->name.'pconf', 1);
    	} else {
    		$smarty->assign($this->name.'pconf', 0);
    	}
    	
    	// twitter
		$consumer_key = Configuration::get($this->name.'twitterconskey');
		$consumer_secret = Configuration::get($this->name.'twitterconssecret');
		if(strlen($consumer_key)>0 && strlen($consumer_secret)>0){
			$smarty->assign($this->name.'tconf', 1);
    	} else {
    		$smarty->assign($this->name.'tconf', 0);
    	}
    	
    	// linkedin
		$lapikey = Configuration::get($this->name.'lapikey');
		$lsecret = Configuration::get($this->name.'lsecret');
		
		if(strlen($lapikey)>0 && strlen($lsecret)>0){
			$smarty->assign($this->name.'lconf', 1);
    	} else {
    		$smarty->assign($this->name.'lconf', 0);
    	}
    	
    	// microsoft
		$mclientid = Configuration::get($this->name.'mclientid');
		$mclientsecret = Configuration::get($this->name.'mclientsecret');
		
		if(strlen($mclientid)>0 && strlen($mclientsecret)>0){
			$smarty->assign($this->name.'mconf', 1);
    	} else {
    		$smarty->assign($this->name.'mconf', 0);
    	}
    	
    	// configs 
    	
    	#### show popup for twitter customer which not changed email address  #####
		if(Configuration::get('PS_REWRITING_SETTINGS')){
			$request_uri = $_SERVER["REQUEST_URI"];
		} else {
			$request_uri = $_SERVER["REQUEST_URI"];
			$request_uri = str_replace("index.php","",$request_uri);
		}
		
		
	    $link = new Link();
	    if(version_compare(_PS_VERSION_, '1.4', '>')){
			$my_account = $link->getPageLink("my-account", true, $id_lang);
	    	
			} else {
	    		$my_account = "my-account";
	    	} 
			
			
		$req_uri = explode("/",$request_uri);
		$req_uri = end($req_uri);
		$is_my_account_page = stripos($my_account,$req_uri);
		
		
		if($cookie->id_customer){
			$customer_email = $cookie->email;
			
			$is_twitter_customer = stripos($customer_email,"twitter.com");
			
			$smarty->assign($this->name.'cid', $cookie->id_customer);
		}
		
		$show_twitter_popup = 0;
		if($is_my_account_page && $is_twitter_customer)
			$show_twitter_popup = 1;
			
		$smarty->assign($this->name.'twpopup', $show_twitter_popup);	
		#### show popup for twitter customer which not changed email address  #####
		$data_tw = $this->twTranslate();
		$smarty->assign($this->name.'tw_one', $data_tw['twitter_one']);
		$smarty->assign($this->name.'tw_two', $data_tw['twitter_two']);	
		
		
		
		
		
    	return $this->display(__FILE__, 'head.tpl');
    }
    
    #### show popup for twitter customer which not changed email address  #####
    public function twTranslate(){
    	return array('valid_email' => $this->l('This email address is not valid'),
    				 'exists_customer' => $this->l('An account using this email address has already been registered.'),
    				 'send_email' => $this->l('Password has been sent to your mailbox:'),
    				 'log_in' => $this->l('You must be log in.'),
    	 			 'twitter_one'=>$this->l('You have linked your Prestashop account to your Twitter profile'),
					 'twitter_two'=>$this->l('Because Twitter does not give us your e-mail address, your account was created with a false generic e-mail. Please update your e-mail address now by filling it out below.'),
					
    				);
    }
	#### show popup for twitter customer which not changed email address  #####
    
	function hookRightColumn($params)
	{
		
		$smarty = $this->context->smarty;
		$cookie = $this->context->cookie;
		
		global $cart;
		
		$smarty->assign($this->name.'urlrewrite_on', Configuration::get($this->name.'urlrewrite_on'));
		
		if($this->_is_friendly_url){
			$smarty->assign($this->name.'iso_lng', $this->_iso_lng);
		} else {
			$smarty->assign($this->name.'iso_lng', '');
		}
		
		### News ###
		if(Configuration::get($this->name.'newson') == 1){
		include_once(dirname(__FILE__).'/classes/blocknewshelp.class.php');
		$obj_blocknewshelp = new blocknewshelp();
    	$_data = $obj_blocknewshelp->getItemsBlock();
		
    	$smarty->assign(array($this->name.'itemsblocknews' => $_data['items']
							  )
						);
		
		
		$smarty->assign($this->name.'news_right', Configuration::get($this->name.'news_right'));
		}
		$smarty->assign($this->name.'newson', Configuration::get($this->name.'newson'));
		
		### News ####
		
		### GuestBook ###
		if(Configuration::get($this->name.'guon') == 1){
		include_once(dirname(__FILE__).'/classes/guestbook.class.php');
		$obj_guestbook = new guestbook();
    	$_data = $obj_guestbook->getItems(array('start'=>0,
    											 'step'=>Configuration::get($this->name.'gbook_blc')
    											));

		$smarty->assign(array($this->name.'reviews_g' => $_data['reviews'], 
							  $this->name.'count_all_reviews_g' => $_data['count_all_reviews'])
						);
		
		$smarty->assign($this->name.'g_right', Configuration::get($this->name.'g_right'));
		
		$is_ps15 = 0;
		if($this->_is15){
		$is_ps15 = 1;	
		}
		
		$smarty->assign($this->name.'is_ps15', $is_ps15);
		
		} 
		$smarty->assign($this->name.'guon', Configuration::get($this->name.'guon'));
		
		### GuestBook ###
		
		
		### FAQ ###
		if(Configuration::get($this->name.'faqon') == 1){
		include_once(dirname(__FILE__).'/classes/blockfaqhelp.class.php');
		$obj_blockfaqhelp = new blockfaqhelp();
    	$_data = $obj_blockfaqhelp->getItemsBlock();
		
		$smarty->assign(array($this->name.'itemsblock' => $_data['items']
							  )
						);
		$smarty->assign($this->name.'faq_right', Configuration::get($this->name.'faq_right'));
		
		} 
		$smarty->assign($this->name.'faqon', Configuration::get($this->name.'faqon'));
		
		### FAQ ###
		
		#### Testimonials ####
		if(Configuration::get($this->name.'testimon') == 1){
		include_once(dirname(__FILE__).'/classes/shopreviews.class.php');
		$obj_shopreviews = new shopreviews();
    	$_data = $obj_shopreviews->getTestimonials(array('start'=>0,'step'=>Configuration::get($this->name.'tlast')));

		$smarty->assign(array($this->name.'reviews_t' => $_data['reviews'], 
							  $this->name.'count_all_reviews_t' => $_data['count_all_reviews'])
						);
		
		//$smarty->assign($this->name.'tposition', Configuration::get($this->name.'tposition'));
		$smarty->assign($this->name.'t_right', Configuration::get($this->name.'t_right'));
		
		$smarty->assign($this->name.'tis_web', Configuration::get($this->name.'tis_web'));
		$is_ps15 = 0;
		if($this->_is15){
		$is_ps15 = 1;	
		}
		
		$smarty->assign($this->name.'is_ps15', $is_ps15);
		$smarty->assign($this->name.'trssontestim', Configuration::get($this->name.'trssontestim'));
		
		} 
		$smarty->assign($this->name.'testimon', Configuration::get($this->name.'testimon'));
		
		#### Testimonials ####
		
		###### Product reviews + Google Snippets, Breadcrumb, Rich Pin ######
		if(Configuration::get($this->name.'reviewson') == 1){
		
		include_once(dirname(__FILE__).'/classes/reviewshelp.class.php');
		$obj_reviewshelp = new reviewshelp();
    	$_data = $obj_reviewshelp->getLastReviews(array('start'=>0,'step'=>Configuration::get($this->name.'revlast')));

		$smarty->assign(array($this->name.'reviews' => $_data['reviews']));
		$smarty->assign($this->name.'position', Configuration::get($this->name.'position'));
		$smarty->assign($this->name.'rsson_snip', Configuration::get($this->name.'rsson_snip'));
		$smarty->assign($this->name.'x_reviews', Configuration::get($this->name.'x_reviews'));
			
		}
		$smarty->assign($this->name.'reviewson', Configuration::get($this->name.'reviewson'));
		
		$_product_id = Tools::getValue('id_product');
		
		if(Configuration::get($this->name.'gsnipblock') &&
		  (Configuration::get($this->name.'id_hook_gsnipblock') == 1) &&
		  $_product_id
		  ){
		
			$smarty->assign($this->name.'rightsnippet', 
							$this->snippetBlockSettings(array('product_id'=>$_product_id,'params'=>$params))
							);
		  
		  } else {
			  	$smarty->assign($this->name.'rightsnippet','');
			  }
		  
		// pinterest
		$smarty->assign($this->name.'pinvis_on', Configuration::get($this->name.'pinvis_on'));
		$smarty->assign($this->name.'pinbutton_on', Configuration::get($this->name.'pinbutton_on'));
		$smarty->assign($this->name.'pbuttons', Configuration::get($this->name.'pbuttons'));
		$smarty->assign($this->name.'_rightColumn', Configuration::get($this->name.'_rightColumn'));
		// pinterest
		
	
		###### Product reviews + Google Snippets, Breadcrumb, Rich Pin ######
		
		
		#### blog ####
		if(Configuration::get($this->name.'blogon') == 1){
		include_once(dirname(__FILE__).'/classes/blog.class.php');
		$obj_blog = new bloghelp();
    	$_data_cat = $obj_blog->getCategoriesBlock();
		$_data_post = $obj_blog->getRecentsPosts();
    	
		$smarty->assign(array($this->name.'categories' => $_data_cat['categories'],
							  $this->name.'posts' => $_data_post['posts']
							  )
						);
		
		$smarty->assign($this->name.'block_display_date', Configuration::get($this->name.'block_display_date'));
		$smarty->assign($this->name.'block_display_img', Configuration::get($this->name.'block_display_img'));
		
		$smarty->assign($this->name.'cat_right', Configuration::get($this->name.'cat_right'));
		$smarty->assign($this->name.'posts_right', Configuration::get($this->name.'posts_right'));
		$smarty->assign($this->name.'arch_right', Configuration::get($this->name.'arch_right'));
		$smarty->assign($this->name.'search_right', Configuration::get($this->name.'search_right'));
		
		$smarty->assign($this->name.'rsson', Configuration::get($this->name.'rsson'));
		
		$ps15 = 0;
		if($this->_is15){
			$ps15 = 1;
		} 
		$smarty->assign($this->name.'is_ps15', $ps15);
		
		
		}
		$smarty->assign($this->name.'blogon', Configuration::get($this->name.'blogon'));
		#### blog ####
		
		
		$data_fb = $this->getfacebooklib((int)$cookie->id_lang);
		$smarty->assign($this->name.'lang', $data_fb['lng_iso']);
		
    	$is_logged = isset($cookie->id_customer)?$cookie->id_customer:0;
    	
		$smarty->assign(array(
			'cart' => $cart,
			'cart_qties' => $cart->nbProducts(),
			'logged' => $is_logged,
			'customerName' => ($cookie->logged ? $cookie->customer_firstname.' '.$cookie->customer_lastname : false),
			'firstName' => ($cookie->logged ? $cookie->customer_firstname : false),
			'lastName' => ($cookie->logged ? $cookie->customer_lastname : false)
		));
		
		
		$smarty->assign($this->name.'islogged', $is_logged);
		
		############ social connects images ################
		include_once(dirname(__FILE__).'/classes/facebookhelp.class.php');
		$obj = new facebookhelp();
    	$data_img = $obj->getImages();
    	
    	foreach($this->_prefix_connects_image as $prefix_image => $value){
    		$img_big = $data_img[$prefix_image];
    		$img_small = $data_img[$prefix_image.'small'];
    		$smarty->assign($this->name.$prefix_image.'img', $img_big);
    		$smarty->assign($this->name.$prefix_image.'smallimg', $img_small);
    			
    	}
    	############ social connects images ################
    	
    	// positions connects
    	foreach($this->_prefix_position_connects as $prefix){
    		$smarty->assign($this->name.'_rightcolumn'.$prefix, Configuration::get($this->name.'_rightcolumn'.$prefix));
    	}
    	// positions connects
    	
    	
    	
    	
    	### set variables for order page ####
		$this->getOrderPage();
    	### set variables for order page ####
    	
    	$smarty->assign($this->name.'is15', $this->_is15);
    	$smarty->assign($this->name.'is16', $this->_is16);
		
    	$data_errors = $this->_translations;
    	$smarty->assign('ferror', $data_errors['facebook']);
    	$smarty->assign('terror', $data_errors['twitter']);
    	$smarty->assign('lerror', $data_errors['linkedin']);
    	$smarty->assign('merror', $data_errors['microsoft']);
    	$smarty->assign('perror', $data_errors['paypal']);
    	
    	
    	// configs 
    	
    	//paypal
    	$clientid = Configuration::get($this->name.'clientid');
		$psecret = Configuration::get($this->name.'psecret');
		$pcallback = Configuration::get($this->name.'pcallback');
		if(strlen($clientid)>0 && strlen($psecret)>0 && strlen($pcallback)>0){
			$smarty->assign($this->name.'pconf', 1);
    	} else {
    		$smarty->assign($this->name.'pconf', 0);
    	}
    	
    	// twitter
		$consumer_key = Configuration::get($this->name.'twitterconskey');
		$consumer_secret = Configuration::get($this->name.'twitterconssecret');
		if(strlen($consumer_key)>0 && strlen($consumer_secret)>0){
			$smarty->assign($this->name.'tconf', 1);
    	} else {
    		$smarty->assign($this->name.'tconf', 0);
    	}
    	
    	// linkedin
		$lapikey = Configuration::get($this->name.'lapikey');
		$lsecret = Configuration::get($this->name.'lsecret');
		
		if(strlen($lapikey)>0 && strlen($lsecret)>0){
			$smarty->assign($this->name.'lconf', 1);
    	} else {
    		$smarty->assign($this->name.'lconf', 0);
    	}
    	
    	// microsoft
		$mclientid = Configuration::get($this->name.'mclientid');
		$mclientsecret = Configuration::get($this->name.'mclientsecret');
		
		if(strlen($mclientid)>0 && strlen($mclientsecret)>0){
			$smarty->assign($this->name.'mconf', 1);
    	} else {
    		$smarty->assign($this->name.'mconf', 0);
    	}
    	
    	// configs 
    	
    	
		// google widget
		$gwon = Configuration::get($this->name.'gwon');
        $smarty->assign($this->name.'gwon', $gwon);
        $positiong = Configuration::get($this->name.'positiong');
        $smarty->assign($this->name.'positiong', $positiong);
        
        
        if($positiong == 'right' && $gwon){
        include_once(dirname(__FILE__).'/classes/googlewidgethelp.class.php');
		$obj_googlewidgethelp = new googlewidgethelp();
		$data = $obj_googlewidgethelp->getItem();
       	$googlewidget = $data['item'];   
        $smarty->assign($this->name.'googlewidget', $googlewidget);
        } else {
        $smarty->assign($this->name.'googlewidget', '');	
        }
        
        
		// twitter widget
		$smarty->assign($this->name.'twitteron', Configuration::get($this->name.'twitteron'));
		$smarty->assign($this->name.'user_name', Configuration::get($this->name.'user_name'));
		$smarty->assign($this->name.'position', Configuration::get($this->name.'position'));
		$smarty->assign($this->name.'width', Configuration::get($this->name.'width'));
		$smarty->assign($this->name.'height', Configuration::get($this->name.'height'));
		$smarty->assign($this->name.'tweets_link', Configuration::get($this->name.'tweets_link'));
		$smarty->assign($this->name.'tw_color_scheme', Configuration::get($this->name.'tw_color_scheme'));
		$smarty->assign($this->name.'tw_aria_pol', Configuration::get($this->name.'tw_aria_pol'));
		$smarty->assign($this->name.'tw_widgetid', Configuration::get($this->name.'tw_widgetid'));
		
		// twitter widget
		
		
		$smarty->assign($this->name.'fbon', Configuration::get($this->name.'fbon'));
		
		$smarty->assign($this->name.'lb_facebook_page_url', Configuration::get($this->name.'lb_facebook_page_url'));
        $smarty->assign($this->name.'lb_width', Configuration::get($this->name.'lb_width'));
        $smarty->assign($this->name.'lb_faces',(Configuration::get($this->name.'lb_faces')) ? 'true' : 'false');
        $smarty->assign($this->name.'lb_height', Configuration::get($this->name.'lb_height'));
        $smarty->assign($this->name.'lb_connections', Configuration::get($this->name.'lb_connections'));
        $smarty->assign($this->name.'lb_stream', (Configuration::get($this->name.'lb_stream')) ? 'true' : 'false');
        $smarty->assign($this->name.'lb_header', (Configuration::get($this->name.'lb_header')) ? 'true' : 'false');
        $smarty->assign($this->name.'lb_transparency', (Configuration::get($this->name.'lb_transparency')) ? 'true' : 'false');
        $smarty->assign($this->name.'lb_bg_color', Configuration::get($this->name.'lb_bg_color'));
        $smarty->assign($this->name.'positionfb', Configuration::get($this->name.'positionfb'));
        
        $pos = Configuration::get($this->name.'_pos');
        $isonpinwidget =Configuration::get($this->name.'_isonpinwidget');
		$smarty->assign($this->name.'_isonpinwidget', $isonpinwidget);
		
		
		if($pos == 'rightColumn' && $isonpinwidget){
			$smarty->assign($this->name.'pinterestwidget', $this->assignvars());
        } else {
			$smarty->assign($this->name.'pinterestwidget', '');
        }
		
		
		if(version_compare(_PS_VERSION_, '1.5', '>')){
			return $this->display(__FILE__, 'right15.tpl');
		} else {
			return $this->display(__FILE__, 'right.tpl');
		}

		
	}
    
function hookLeftColumn($params)
	{
		$smarty = $this->context->smarty;
		$cookie = $this->context->cookie;
		
		global $cart;
		
		
		$smarty->assign($this->name.'urlrewrite_on', Configuration::get($this->name.'urlrewrite_on'));
		
		if($this->_is_friendly_url){
			$smarty->assign($this->name.'iso_lng', $this->_iso_lng);
		} else {
			$smarty->assign($this->name.'iso_lng', '');
		}
		
		### News ###
		if(Configuration::get($this->name.'newson') == 1){
		include_once(dirname(__FILE__).'/classes/blocknewshelp.class.php');
		$obj_blocknewshelp = new blocknewshelp();
    	$_data = $obj_blocknewshelp->getItemsBlock();
		
    	$smarty->assign(array($this->name.'itemsblocknews' => $_data['items']
							  )
						);
		
		
		$smarty->assign($this->name.'news_left', Configuration::get($this->name.'news_left'));
		}
		$smarty->assign($this->name.'newson', Configuration::get($this->name.'newson'));
		
		### News ####
		
		### GuestBook ###
		if(Configuration::get($this->name.'guon') == 1){
		include_once(dirname(__FILE__).'/classes/guestbook.class.php');
		$obj_guestbook = new guestbook();
    	$_data = $obj_guestbook->getItems(array('start'=>0,
    											 'step'=>Configuration::get($this->name.'gbook_blc')
    											));

		$smarty->assign(array($this->name.'reviews_g' => $_data['reviews'], 
							  $this->name.'count_all_reviews_g' => $_data['count_all_reviews'])
						);
		
		$smarty->assign($this->name.'g_left', Configuration::get($this->name.'g_left'));
		
		$is_ps15 = 0;
		if($this->_is15){
		$is_ps15 = 1;	
		}
		
		$smarty->assign($this->name.'is_ps15', $is_ps15);
		
		} 
		$smarty->assign($this->name.'guon', Configuration::get($this->name.'guon'));
		
		### GuestBook ###
		
		### FAQ ###
		if(Configuration::get($this->name.'faqon') == 1){
		include_once(dirname(__FILE__).'/classes/blockfaqhelp.class.php');
		$obj_blockfaqhelp = new blockfaqhelp();
    	$_data = $obj_blockfaqhelp->getItemsBlock();
		
		$smarty->assign(array($this->name.'itemsblock' => $_data['items']
							  )
						);
		$smarty->assign($this->name.'faq_left', Configuration::get($this->name.'faq_left'));
		
		} 
		$smarty->assign($this->name.'faqon', Configuration::get($this->name.'faqon'));
		
		### FAQ ###
		
		#### Testimonials ####
		if(Configuration::get($this->name.'testimon') == 1){
		include_once(dirname(__FILE__).'/classes/shopreviews.class.php');
		$obj_shopreviews = new shopreviews();
    	$_data = $obj_shopreviews->getTestimonials(array('start'=>0,'step'=>Configuration::get($this->name.'tlast')));

		$smarty->assign(array($this->name.'reviews_t' => $_data['reviews'], 
							  $this->name.'count_all_reviews_t' => $_data['count_all_reviews'])
						);
		
		//$smarty->assign($this->name.'tposition', Configuration::get($this->name.'tposition'));
		
		$smarty->assign($this->name.'t_left', Configuration::get($this->name.'t_left'));
		
		$smarty->assign($this->name.'tis_web', Configuration::get($this->name.'tis_web'));
		$is_ps15 = 0;
		if($this->_is15){
		$is_ps15 = 1;	
		}
		
		$smarty->assign($this->name.'is_ps15', $is_ps15);
		$smarty->assign($this->name.'trssontestim', Configuration::get($this->name.'trssontestim'));
		
		} 
		$smarty->assign($this->name.'testimon', Configuration::get($this->name.'testimon'));
		
		#### Testimonials ####
		
		###### Product reviews + Google Snippets, Breadcrumb, Rich Pin ######
		if(Configuration::get($this->name.'reviewson') == 1){
		
		include_once(dirname(__FILE__).'/classes/reviewshelp.class.php');
		$obj_reviewshelp = new reviewshelp();
    	$_data = $obj_reviewshelp->getLastReviews(array('start'=>0,'step'=>Configuration::get($this->name.'revlast')));

		$smarty->assign(array($this->name.'reviews' => $_data['reviews']));
		$smarty->assign($this->name.'position', Configuration::get($this->name.'position'));
		$smarty->assign($this->name.'rsson_snip', Configuration::get($this->name.'rsson_snip'));
		$smarty->assign($this->name.'x_reviews', Configuration::get($this->name.'x_reviews'));
		}
		$smarty->assign($this->name.'reviewson', Configuration::get($this->name.'reviewson'));
		
		$_product_id = Tools::getValue('id_product');
		
		if(Configuration::get($this->name.'gsnipblock') &&
		  (Configuration::get($this->name.'id_hook_gsnipblock') == 2) &&
		  $_product_id
		  ){
		
		 	$smarty->assign($this->name.'leftsnippet',
		 				 $this->snippetBlockSettings(array('product_id'=>$_product_id,'params'=>$params))
		 				 );
		
		} else {
			$smarty->assign($this->name.'leftsnippet','');
		}
				
		
		// pinterest
		$smarty->assign($this->name.'pinvis_on', Configuration::get($this->name.'pinvis_on'));
		$smarty->assign($this->name.'pinbutton_on', Configuration::get($this->name.'pinbutton_on'));
		$smarty->assign($this->name.'pbuttons', Configuration::get($this->name.'pbuttons'));
		$smarty->assign($this->name.'_leftColumn', Configuration::get($this->name.'_leftColumn'));
		// pinterest
		
		
		###### Product reviews + Google Snippets, Breadcrumb, Rich Pin ######
		
		
		
		#### blog ####
		if(Configuration::get($this->name.'blogon') == 1){
		
		include_once(dirname(__FILE__).'/classes/blog.class.php');
		$obj_blog = new bloghelp();
    	$_data_cat = $obj_blog->getCategoriesBlock();
		$_data_post = $obj_blog->getRecentsPosts();
		$_data_arch = $obj_blog->getArchives();
    	
		
		$smarty->assign(array($this->name.'categories' => $_data_cat['categories'],
							  $this->name.'posts' => $_data_post['posts'],
							  $this->name.'arch' => $_data_arch['posts']
							  )
						);
		
		
		
		$smarty->assign($this->name.'block_display_date', Configuration::get($this->name.'block_display_date'));
		$smarty->assign($this->name.'block_display_img', Configuration::get($this->name.'block_display_img'));
		
		$smarty->assign($this->name.'cat_left', Configuration::get($this->name.'cat_left'));
		$smarty->assign($this->name.'posts_left', Configuration::get($this->name.'posts_left'));
		$smarty->assign($this->name.'arch_left', Configuration::get($this->name.'arch_left'));
		$smarty->assign($this->name.'search_left', Configuration::get($this->name.'search_left'));
		
		
		$ps15 = 0;
		if($this->_is15){
			$ps15 = 1;
		} 
		$smarty->assign($this->name.'is_ps15', $ps15);
		
		$smarty->assign($this->name.'rsson', Configuration::get($this->name.'rsson'));
		
		
		
		}
		$smarty->assign($this->name.'blogon', Configuration::get($this->name.'blogon'));
		#### blog ####
		
		$data_fb = $this->getfacebooklib((int)$cookie->id_lang);
		$smarty->assign($this->name.'lang', $data_fb['lng_iso']);
		
    	$is_logged = isset($params['cookie']->id_customer)?$params['cookie']->id_customer:0;
    	
		$smarty->assign(array(
			'cart' => $cart,
			'cart_qties' => $cart->nbProducts(),
			'logged' => $is_logged,
			'customerName' => ($cookie->logged ? $cookie->customer_firstname.' '.$cookie->customer_lastname : false),
			'firstName' => ($cookie->logged ? $cookie->customer_firstname : false),
			'lastName' => ($cookie->logged ? $cookie->customer_lastname : false)
		));
		
		
		$smarty->assign($this->name.'islogged', $is_logged);
		
		############ social connects images ################
		include_once(dirname(__FILE__).'/classes/facebookhelp.class.php');
		$obj = new facebookhelp();
    	$data_img = $obj->getImages();
    	
    	foreach($this->_prefix_connects_image as $prefix_image => $value){
    		$img_big = $data_img[$prefix_image];
    		$img_small = $data_img[$prefix_image.'small'];
    		$smarty->assign($this->name.$prefix_image.'img', $img_big);
    		$smarty->assign($this->name.$prefix_image.'smallimg', $img_small);
    			
    	}
    	############ social connects images ################
    	
    	// positions connects
    	foreach($this->_prefix_position_connects as $prefix){
    		$smarty->assign($this->name.'_leftcolumn'.$prefix, Configuration::get($this->name.'_leftcolumn'.$prefix));
    	}
    	// positions connects
    	
    	
    	
		### set variables for order page ####
		$this->getOrderPage();
    	### set variables for order page ####
    	
    	$smarty->assign($this->name.'is15', $this->_is15);
    	$smarty->assign($this->name.'is16', $this->_is16);
		
    	$data_errors = $this->_translations;
    	$smarty->assign('ferror', $data_errors['facebook']);
    	$smarty->assign('terror', $data_errors['twitter']);
    	$smarty->assign('lerror', $data_errors['linkedin']);
    	$smarty->assign('merror', $data_errors['microsoft']);
    	$smarty->assign('perror', $data_errors['paypal']);
    	
    	
    	// configs 
    	
    	//paypal
    	$clientid = Configuration::get($this->name.'clientid');
		$psecret = Configuration::get($this->name.'psecret');
		$pcallback = Configuration::get($this->name.'pcallback');
		if(strlen($clientid)>0 && strlen($psecret)>0 && strlen($pcallback)>0){
			$smarty->assign($this->name.'pconf', 1);
    	} else {
    		$smarty->assign($this->name.'pconf', 0);
    	}
    	
    	// twitter
		$consumer_key = Configuration::get($this->name.'twitterconskey');
		$consumer_secret = Configuration::get($this->name.'twitterconssecret');
		if(strlen($consumer_key)>0 && strlen($consumer_secret)>0){
			$smarty->assign($this->name.'tconf', 1);
    	} else {
    		$smarty->assign($this->name.'tconf', 0);
    	}
    	
    	// linkedin
		$lapikey = Configuration::get($this->name.'lapikey');
		$lsecret = Configuration::get($this->name.'lsecret');
		
		if(strlen($lapikey)>0 && strlen($lsecret)>0){
			$smarty->assign($this->name.'lconf', 1);
    	} else {
    		$smarty->assign($this->name.'lconf', 0);
    	}
    	
    	// microsoft
		$mclientid = Configuration::get($this->name.'mclientid');
		$mclientsecret = Configuration::get($this->name.'mclientsecret');
		
		if(strlen($mclientid)>0 && strlen($mclientsecret)>0){
			$smarty->assign($this->name.'mconf', 1);
    	} else {
    		$smarty->assign($this->name.'mconf', 0);
    	}
    	
    	// configs 
    	
    	
	// google widget
        $smarty->assign($this->name.'gwon', Configuration::get($this->name.'gwon'));
        $smarty->assign($this->name.'positiong', Configuration::get($this->name.'positiong'));
        
        include_once(dirname(__FILE__).'/classes/googlewidgethelp.class.php');
		$obj_googlewidgethelp = new googlewidgethelp();
		$data = $obj_googlewidgethelp->getItem();
       	$googlewidget = $data['item'];   
        $smarty->assign($this->name.'googlewidget', $googlewidget);
    	
		// twitter widget
		$smarty->assign($this->name.'twitteron', Configuration::get($this->name.'twitteron'));
		$smarty->assign($this->name.'user_name', Configuration::get($this->name.'user_name'));
		$smarty->assign($this->name.'position', Configuration::get($this->name.'position'));
		$smarty->assign($this->name.'width', Configuration::get($this->name.'width'));
		$smarty->assign($this->name.'height', Configuration::get($this->name.'height'));
		$smarty->assign($this->name.'tweets_link', Configuration::get($this->name.'tweets_link'));
		$smarty->assign($this->name.'tw_color_scheme', Configuration::get($this->name.'tw_color_scheme'));
		$smarty->assign($this->name.'tw_aria_pol', Configuration::get($this->name.'tw_aria_pol'));
		$smarty->assign($this->name.'tw_widgetid', Configuration::get($this->name.'tw_widgetid'));
		
		// twitter widget
		
		
		$smarty->assign($this->name.'fbon', Configuration::get($this->name.'fbon'));
		
		$smarty->assign($this->name.'lb_facebook_page_url', Configuration::get($this->name.'lb_facebook_page_url'));
        $smarty->assign($this->name.'lb_width', Configuration::get($this->name.'lb_width'));
         $smarty->assign($this->name.'lb_faces',(Configuration::get($this->name.'lb_faces')) ? 'true' : 'false');
        $smarty->assign($this->name.'lb_height', Configuration::get($this->name.'lb_height'));
        $smarty->assign($this->name.'lb_connections', Configuration::get($this->name.'lb_connections'));
        $smarty->assign($this->name.'lb_stream', (Configuration::get($this->name.'lb_stream')) ? 'true' : 'false');
        $smarty->assign($this->name.'lb_header', (Configuration::get($this->name.'lb_header')) ? 'true' : 'false');
        $smarty->assign($this->name.'lb_transparency', (Configuration::get($this->name.'lb_transparency')) ? 'true' : 'false');
        $smarty->assign($this->name.'lb_bg_color', Configuration::get($this->name.'lb_bg_color'));
        $smarty->assign($this->name.'positionfb', Configuration::get($this->name.'positionfb'));
		
	 	$pos = Configuration::get($this->name.'_pos');
		$smarty->assign($this->name.'_isonpinwidget', Configuration::get($this->name.'_isonpinwidget'));
		
		if($pos == 'leftColumn'){
			$smarty->assign($this->name.'pinterestwidget', $this->assignvars());
        } else {
			$smarty->assign($this->name.'pinterestwidget', '');
        }
		
		if(version_compare(_PS_VERSION_, '1.5', '>')){
			return $this->display(__FILE__, 'left15.tpl');
		} else {
			return $this->display(__FILE__, 'left.tpl');
		}

		
	}
    
 private function _drawGoogleButtonSettingsForm(){
    	$_html = '';
    	
    	$_html .= '
        <form action="'.$_SERVER['REQUEST_URI'].'" method="post" >';
    	
    	$_html .= '<fieldset>
					<legend><img src="../modules/'.$this->name.'/img/settings_g.png"  />'.$this->l('Google +1 Button Settings').'</legend>';
    	
    	
    	$_html .= '<table style="width:100%;">';
		$_html .= '<label>'.$this->l('Enabled Google +1 Block:').'</label>
				<div class="margin-form">
				
					<input type="radio" value="on" id="status1" name="status1"
							'.((Tools::getValue('status1', Configuration::get($this->name.'status1'))  == "on") ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					
					<input type="radio" value="off" id="status1" name="status1"
						   '.((Tools::getValue('status1', Configuration::get($this->name.'status1')) == "off") ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
					<p class="clear">'.$this->l('Enable or disable Block').'</p>
				</div>';
		
    	$_html .= '';
    	
    	$_html .= '<tr>
	    			   <td style="width:35%;text-align:center;padding:30px">
	    			   		<input type="radio" value="1gon" id="buttons1" name="buttons1"
								'.(Tools::getValue('buttons1', Configuration::get($this->name.'buttons1')) == "1gon" ? 'checked="checked" ' : '').'>
					   </td>
	    			   <td>
	    			   	<img src="../modules/'.$this->name.'/img/1gon.png" />
					   </td>
				</tr><tr>
    			   ';
    	$_html .= '
	    			   <td style="width:35%;text-align:center;padding:30px">
	    			   		<input type="radio" value="2gon" id="buttons1" name="buttons1"
								'.(Tools::getValue('buttons1', Configuration::get($this->name.'buttons1')) == "2gon" ? 'checked="checked" ' : '').'>
					   </td>
	    			   <td>
	    			   	<img src="../modules/'.$this->name.'/img/2gon.png" />
					   </td>
    			   </tr>';
    	
    	$_html .= '</table>';
    	
    	
    	
    	$_html .=	'</fieldset>'; 
    	
    	 $_html .= $this->_updateButton(array('name'=>'googlebutton'));
    	$_html .= '</form>';
    	
    	return $_html;
    }
    
    private function _drawGoogleWidgetSettingsForm(){
    	$_html = '';
    	
    	$_html .= '
        <form action="'.$_SERVER['REQUEST_URI'].'" method="post" >';
    	
    	$_html .= '<fieldset>
					<legend><img src="../modules/'.$this->name.'/img/settings_g.png"  />'.$this->l('Google Widget Settings').'</legend>';
    	
    	 $_html .= '<label>'.$this->l('Enabled Google Widget:').'</label>
				
					<div class="margin-form">
					<input type="radio" value="1" id="text_list_on" name="gwon"
							'.(Tools::getValue('gwon', Configuration::get($this->name.'gwon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					
					<input type="radio" value="0" id="text_list_off" name="gwon"
						   '.(!Tools::getValue('gwon', Configuration::get($this->name.'gwon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
					<p class="clear">'.$this->l('Enable or disable Widget').'</p>
					</div>
                    
                    ';
       	 
       	 $_html .= '<label>'.$this->l('Position:').'</label>
				<div class="margin-form">
					<select class="select" name="positiong" 
							id="position">
						<option '.(Tools::getValue('positiong', Configuration::get($this->name.'positiong'))  == "left" ? 'selected="selected" ' : '').' value="left">'.$this->l('Left').'</option>
						<option '.(Tools::getValue('positiong', Configuration::get($this->name.'positiong')) == "right" ? 'selected="selected" ' : '').' value="right">'.$this->l('Right').'</option>
						<option '.(Tools::getValue('positiong', Configuration::get($this->name.'positiong')) == "home" ? 'selected="selected" ' : '').' value="home">'.$this->l('Home').'</option>
					    <option '.(Tools::getValue('positiong', Configuration::get($this->name.'positiong')) == "footer" ? 'selected="selected" ' : '').' value="footer">'.$this->l('Footer').'</option>
					
					</select>
				</div>';
       	 
       	include_once(dirname(__FILE__).'/classes/googlewidgethelp.class.php');
		$obj_googlewidgethelp = new googlewidgethelp();
		$data = $obj_googlewidgethelp->getItem();
       	$googlewidget = $data['item'];   
		
       	 $_html .= '<label>'.$this->l('Google+ Widget Code').':</label>
                    <div class="margin-form">
                    	<textarea name="gwidgetcode" style="width:90%;height:150px">'.$googlewidget.'</textarea>
                    	<p class="clear">'.$this->l('Get Google+ Widget Code please visit').': <a href=http://widgetsplus.com/ style=color:green;text-decoration:underline>http://widgetsplus.com/</a>
                    	<br/>
									'.$this->l('or').'
									<br/>
					'.$this->l('To configure the "Google+ Widget Code" read Installation_guid.pdf , which is located in the folder  with the module.').'
					
                    	</p>
                    </div> ';
       	 
       	 
			$_html .= '</fieldset>';
        	
        $_html .= $this->_updateButton(array('name'=>'googlewidget'));
    	$_html .= '</form>';
    	
        
        return $_html;
    }
    
    private function _drawLinkedInButtonSettingsForm(){
    	$_html = '';
		
    	$_html .= '
        <form action="'.$_SERVER['REQUEST_URI'].'" method="post" >';
    	
    	$_html .= '<fieldset>
					<legend><img src="../modules/'.$this->name.'/img/settings_l.png"  />'.$this->l('LinkedIn Button Settings').'</legend>';
    	
    	

  	 $_html .= '<table style="width:100%;">';
  	 $_html .= '<label>'.$this->l('Enabled LinkedIn Button:').'</label>
				<div class="margin-form">
				
					<input type="radio" value="1" id="text_list_on" name="linkedinbon"
							'.(Tools::getValue('linkedinbon', Configuration::get($this->name.'linkedinbon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					
					<input type="radio" value="0" id="text_list_off" name="linkedinbon"
						   '.(!Tools::getValue('linkedinbon', Configuration::get($this->name.'linkedinbon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
					<p class="clear">'.$this->l('Enable or disable LinkedIn Button').'</p>
				</div>';
   
    	$_html .= '<tr>
	    			   <td style="width:35%;text-align:center;padding:30px">
	    			   		<input type="radio" value="firston" id="firston" name="linkedinbuttons"
								'.(Tools::getValue('linkedinbuttons', Configuration::get($this->name.'linkedinbuttons')) == "firston" ? 'checked="checked" ' : '').'>
					   </td>
	    			   <td>
	    			   	<img src="../modules/'.$this->name.'/img/linkedinfirston.png" />
					   </td>
    			   </tr>';
    	$_html .= '<tr>
	    			   <td style="width:35%;text-align:center;padding:30px">
	    			   		<input type="radio" value="secondon" id="secondon" name="linkedinbuttons"
								'.(Tools::getValue('linkedinbuttons', Configuration::get($this->name.'linkedinbuttons')) == "secondon" ? 'checked="checked" ' : '').'>
					   </td>
	    			   <td>
	    			   	<img src="../modules/'.$this->name.'/img/linkedinsecondon.png" />
					   </td>
    			   </tr>';
    	$_html .= '<tr>
	    			   <td style="width:35%;text-align:center;padding:30px">
	    			   		<input type="radio" value="threeon" id="threeon" name="linkedinbuttons"
								'.(Tools::getValue('linkedinbuttons', Configuration::get($this->name.'linkedinbuttons')) == "threeon" ? 'checked="checked" ' : '').'>
					   </td>
	    			   <td>
	    			   	<img src="../modules/'.$this->name.'/img/linkedinthreeon.png" />
					   </td>
    			   </tr>';
    	$_html .= '</table>';
    	$_html .= '</fieldset>';
    	
    	
    		$_html .= $this->_updateButton(array('name'=>'linkedinbutton'));
    	$_html .= '</form>';
    	
    	
    	return $_html;
    }
    
    private function _drawPinterestButtonSettingsForm(){
    	$_html = '';
		$_html .= '
        <form action="'.$_SERVER['REQUEST_URI'].'" method="post" >';
    	
    	$_html .= '<fieldset>
					<legend><img src="../modules/'.$this->name.'/img/pinterest.png"  />'.$this->l('Pinterest Button').'</legend>';
    	
	   $_html .= '<table style="width:100%;">';
  	 $_html .= '<label>'.$this->l('Enabled Pinterest Button:').'</label>
				<div class="margin-form">
				
					<input type="radio" value="1" id="text_list_on" name="pinterestbon"
							'.(Tools::getValue('pinterestbon', Configuration::get($this->name.'pinterestbon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					
					<input type="radio" value="0" id="text_list_off" name="pinterestbon"
						   '.(!Tools::getValue('pinterestbon', Configuration::get($this->name.'pinterestbon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
					<p class="clear">'.$this->l('Enable or disable Pinterest Button').'</p>
				</div>';
   
    	$_html .= '<tr>
	    			   <td style="width:35%;text-align:center;padding:30px">
	    			   		<input type="radio" value="firston" id="firston" name="pinterestbuttons"
								'.(Tools::getValue('pinterestbuttons', Configuration::get($this->name.'pinterestbuttons')) == "firston" ? 'checked="checked" ' : '').'>
					   </td>
	    			   <td>
	    			   	<img src="../modules/'.$this->name.'/img/p2.png" />
					   </td>
    			   </tr>';
    	$_html .= '<tr>
	    			   <td style="width:35%;text-align:center;padding:30px">
	    			   		<input type="radio" value="secondon" id="secondon" name="pinterestbuttons"
								'.(Tools::getValue('pinterestbuttons', Configuration::get($this->name.'pinterestbuttons')) == "secondon" ? 'checked="checked" ' : '').'>
					   </td>
	    			   <td>
	    			   	<img src="../modules/'.$this->name.'/img/p1.png" />
					   </td>
    			   </tr>';
    	
    	$_html .= '</table>';
    	$_html .= '</fieldset>';
    	
    	$_html .= $this->_updateButton(array('name'=>'pinterestbutton'));
    	$_html .= '</form>';
    	
    	
    	return $_html;
    }
    
    private function _drawPinterestWidgetSettingsForm(){
    	
    	$is_onpin = Configuration::get($this->name.'_isonpinwidget');
		$title = Configuration::get($this->name.'_title');
		$pusername = Configuration::get($this->name.'_pusername');
		$width = Configuration::get($this->name.'_width');
		$height = Configuration::get($this->name.'_height');
		$number = Configuration::get($this->name.'_number');
		$descr = Configuration::get($this->name.'_descr');
		$descrl = Configuration::get($this->name.'_descrl');
		$pwidth = Configuration::get($this->name.'_pwidth');
		$follow = Configuration::get($this->name.'_follow');
		$pos = Configuration::get($this->name.'_pos');
		
		$_html = '';
		
		ob_start();?>

     
	
        <form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" >
    	
    	<fieldset>
					<legend><img src="../modules/<?php echo $this->name?>/img/pinterest.png"  /><?=$this->l('Pinterest Widget Settings')?></legend>
    	
    		 
    		
				
				<label><?php echo $this->l('Enabled Pinterest Widget') ?>:</label>
				<div class="margin-form">
				
					<input type="radio" value="1" id="text_list_on" name="isonpinwidget"
							<?php echo ($is_onpin == 1?'checked="checked" ' : '')?>>
					<label for="dhtml_on" class="t"> 
						<img alt="<?php echo $this->l('Enabled')?>" title="<?php echo $this->l('Enabled')?>" src="../img/admin/enabled.gif">
					</label>
					
					<input type="radio" value="0" id="text_list_off" name="isonpinwidget"
						   <?php echo ($is_onpin != 1?'checked="checked" ' : '')?>>
					<label for="dhtml_off" class="t">
						<img alt="<?php echo $this->l('Disabled')?>" title="<?php echo $this->l('Disabled')?>" src="../img/admin/disabled.gif">
					</label>
					
					<p class="clear"><?php echo $this->l('Enable or disable Pinterest Widget') ?></p>
				</div>
				<label><?php echo $this->l('Title')?>:</label>
		        <div class="margin-form">
		        	<input value="<?php echo $title?>" name="ptitle" type="text" style="margin-right: 5px;">
		        </div>
		        <label><?php echo $this->l('Pinterest username') ?>:</label>
		        <div class="margin-form">
		        	<input value="<?php echo $pusername?>" name="pusername" type="text" style="margin-right: 5px;">
		        </div>
		       
    			<label><?php echo $this->l('Widget Width') ?>:</label>
		        <div class="margin-form">
		        	<input value="<?php echo $width?>" name="pwidth" type="text" style="margin-right: 5px;">px
		        </div>
		        <label><?php echo $this->l('Widget Pins Container Height') ?>:</label>
		        <div class="margin-form">
		        	<input value="<?php echo $height?>" name="pheight" type="text" style="margin-right: 5px;">px
		        </div>
		        <label><?php echo $this->l('Number of Pins To Show') ?>:</label>
		        <div class="margin-form">
		        	<input value="<?php echo $number?>" name="pnumber" type="text" style="margin-right: 5px;">
		        </div>
		        <label><?php echo $this->l('Show Description')?>:</label>
		        <div class="margin-form">
		        	<input type="checkbox" name="pdescr" <?php echo ($descr == "on" ? 'checked="checked" ' : '')?> value="on" style="margin-top: 5px;"/>
		        </div>
		        <label><?php echo $this->l('Description Length') ?>:</label>
		        <div class="margin-form">
		        	<input value="<?php echo $descrl?>" name="pdescrl" type="text" style="margin-right: 5px;">
		        </div>
		        <label><?php echo $this->l('Pin Block Width')?>:</label>
		        <div class="margin-form">
		        	<input value="<?php echo $pwidth?>" name="pwidthblock" type="text" style="margin-right: 5px;">px
		        </div>
		        <label><?php echo $this->l('Show Follow Me Button')?>:</label>
		        <div class="margin-form">
		        	<input type="checkbox" name="pfollow" <?php echo $follow == "on" ? 'checked="checked" ' : ''?> value="on" style="margin-top: 5px;"/>
		        </div>
		        <label><?php echo $this->l('Position')?>:</label>
		       	<div class="margin-form">
<?php 				$positions = array('leftColumn', 'rightColumn', 'home', 'footer');?>
					<select name="ppos" size="1" style="width: 138px;">
<?php 					foreach ($positions as $name ):?>
							<option value="<?php echo $name?>" <?php echo  ($name == $pos ? 'selected="selected"' : '')?>><?php echo $name?></option>
<?php 					endforeach;?>
					</select>
		        </div>
			</fieldset>
			
			
    	<?php echo $this->_updateButton(array('name'=>'pinterestwidget')); ?>
    	</form>
    	
		
<?php 	//$_html = ob_get_contents();
		$_html = ob_get_clean();
    	
    	return $_html;
    }
    
    private function _drawFacebookShareButtonSettingsForm(){
    	$_html = '';
    	$_html .= '
        <form action="'.$_SERVER['REQUEST_URI'].'" method="post" >';
    	
    	$_html .= '<fieldset>
					<legend><img src="../modules/'.$this->name.'/img/settings_f.png"  />'.$this->l('Facebook Share Button Settings').'</legend>';
    	
    	$_html .= '<label>'.$this->l('Enabled Share Button:').'</label>
				<div class="margin-form">
				
					<input type="radio" value="1" id="text_list_on" name="shareon"
							'.(Tools::getValue('shareon', Configuration::get($this->name.'shareon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					
					<input type="radio" value="0" id="text_list_off" name="shareon"
						   '.(!Tools::getValue('shareon', Configuration::get($this->name.'shareon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
					<p class="clear">'.$this->l('Enable or disable Share Button.').'</p>
				</div>';
    	$_html .= '</fieldset>';
    	
    	$_html .= $this->_updateButton(array('name'=>'facebookshare'));
    	$_html .= '</form>';
    	
    	
    	return $_html;
    }
    
    private function _drawFacebookCommentsSettingsForm(){
    	$_html = '';
    
    	$_html .= '
        <form action="'.$_SERVER['REQUEST_URI'].'" method="post" >';
    	
    	$_html .= '<fieldset>
					<legend><img src="../modules/'.$this->name.'/img/settings_f.png"  />'.$this->l('Facebook Comments Settings').'</legend>';
    	
		###############  comments items #################
		
			$_html .= '<label>'.$this->l('Enabled Comments:').'</label>
				<div class="margin-form">
				
					<input type="radio" value="1" id="text_list_on" name="COMMENTON"
							'.(Tools::getValue('COMMENTON', Configuration::get($this->name.'COMMENTON')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					
					<input type="radio" value="0" id="text_list_off" name="COMMENTON"
						   '.(!Tools::getValue('COMMENTON', Configuration::get($this->name.'COMMENTON')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
					<p class="clear">'.$this->l('Enable or disable Comments').'</p>
				</div>';
			
			$_html .= '<label>'.$this->l('Numbers of comments').'</label>
			<div class="margin-form">
				<input type="text" size="26" name="'.$this->name.'COMMENTNBR" 
					   value="'.Configuration::get($this->name.'COMMENTNBR').'" />
					   <br/><br/>
				<a class="button" 
				   href="http://developers.facebook.com/tools/comments?id='.Tools::getValue('appid', Configuration::get($this->name.'appid')).'&view=edit_settings" 
				   target="_blank">'.$this->l('Settings Comments').'</a>
				   <br/><br/>
				<a class="button" 
				   href="http://developers.facebook.com/tools/comments?id='.Tools::getValue('appid', Configuration::get($this->name.'appid')).'&view=queue" 
				   target="_blank">'.$this->l('Moderate Comments').'</a>
				   <br/><br/>
				<a class="button" 
				   href="http://developers.facebook.com/tools/comments?id='.Tools::getValue('appid', Configuration::get($this->name.'appid')).'" 
				   target="_blank">'.$this->l('Check new comments').'</a>
			</div>
			<label>'.$this->l('Background').' : </label>
			<div class="margin-form">
			<select name="'.$this->name.'BGCUSTOM">
					<option style="width:150px;" '.('0'==Configuration::get($this->name.'BGCUSTOM')?'selected="selected"':'').' 
							value="0">'.$this->l('Transparent').'</option>
					<option style="width:150px;" '.('1'==Configuration::get($this->name.'BGCUSTOM')?'selected="selected"':'').' 
							value="1">'.$this->l('Custom').'</option>
				</select>
			</div>';
		
		
			$_html .= $this->_colorpicker(array('name' => $this->name.'BGCOLOR',
											'color' => Configuration::get($this->name.'BGCOLOR'),
											'title' => $this->l('Style')
											  ));		
											  
		
			$_html .= '<label>'.$this->l('Width').' : </label>		
			<div class="margin-form">
			<input title="'.$this->l('Enter the width of the comment box here in pixels').'" 
					   type="text" size="10" 
					   name="'.$this->name.'COMMENTWIDTH" 
					   value="'.Configuration::get($this->name.'COMMENTWIDTH').'" /> px	
				
			</div>
		
			<label>'.$this->l('Rounded').'</label>
			<div class="margin-form">
			<input type="radio" name="'.$this->name.'ROUNDED" 
				  id="'.$this->name.'ROUNDED_on" 
				  value="1" 
				  '.(Tools::getValue($this->name.'ROUNDED', Configuration::get($this->name.'ROUNDED')) ? 'checked="checked" ' : '').'/>
			<label class="t" for="'.$this->name.'ROUNDED_on"> 
				<img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" 
					title="'.$this->l('Enabled').'" /></label>
			<input type="radio" name="'.$this->name.'ROUNDED" 
				   id="'.$this->name.'ROUNDED_off" 
				   value="0" '.(!Tools::getValue($this->name.'ROUNDED', Configuration::get($this->name.'ROUNDED')) ? 'checked="checked" ' : '').'/>
			<label class="t" for="'.$this->name.'ROUNDED_off"> 
				<img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" 
					 title="'.$this->l('Disabled').'" /></label>
			<p class="clear">'.$this->l('Display rounded corner for some object in the facebook comment tab').'</p>
			</div>

			<label>'.$this->l('Private').'</label>
			<div class="margin-form">
			<input type="radio" name="'.$this->name.'REGISTERSWITCH" 
				   id="'.$this->name.'REGISTERSWITCH_on" 
				   value="1" '.(Tools::getValue($this->name.'REGISTERSWITCH', Configuration::get($this->name.'REGISTERSWITCH')) ? 'checked="checked" ' : '').'/>
			<label class="t" for="'.$this->name.'REGISTERSWITCH_on"> 
				 <img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" 
				 	  title="'.$this->l('Enabled').'" /></label>
			<input type="radio" name="'.$this->name.'REGISTERSWITCH" 
				   id="'.$this->name.'REGISTERSWITCH_off" 
				   value="0" '.(!Tools::getValue($this->name.'REGISTERSWITCH', Configuration::get($this->name.'REGISTERSWITCH')) ? 'checked="checked" ' : '').'/>
			<label class="t" for="'.$this->name.'REGISTERSWITCH_off"> 
				<img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" 
					title="'.$this->l('Disabled').'" /></label>
			<p class="clear">'.$this->l('Display the facebook REGISTER on the comments tab near the comment counter').'</p>
			</div>

			<label>'.$this->l('Logo').'</label>
			<div class="margin-form">
			<input type="radio" name="'.$this->name.'LOGOSWITCH" id="'.$this->name.'LOGOSWITCH_on" 
				  value="1" '.(Tools::getValue($this->name.'LOGOSWITCH', Configuration::get($this->name.'LOGOSWITCH')) ? 'checked="checked" ' : '').'/>
			<label class="t" for="'.$this->name.'LOGOSWITCH_on"> 
				<img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" 
					title="'.$this->l('Enabled').'" /></label>
			<input type="radio" name="'.$this->name.'LOGOSWITCH" id="'.$this->name.'LOGOSWITCH_off" 
				  value="0" '.(!Tools::getValue($this->name.'LOGOSWITCH', Configuration::get($this->name.'LOGOSWITCH')) ? 'checked="checked" ' : '').'/>
			<label class="t" for="'.$this->name.'LOGOSWITCH_off"> 
				<img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" 
					 title="'.$this->l('Disabled').'" /></label>
			<p class="clear">'.$this->l('Display the facebook logo on the comments tab near the comment counter').'</p>
			</div>

			<label>'.$this->l('Title').'</label>
			<div class="margin-form">
			<input type="radio" name="'.$this->name.'TITLESWITCH" 
				  id="'.$this->name.'TITLESWITCH_on" 
				  value="1" '.(Tools::getValue($this->name.'TITLESWITCH', Configuration::get($this->name.'TITLESWITCH')) ? 'checked="checked" ' : '').'/>
			<label class="t" for="'.$this->name.'TITLESWITCH_on"> 
				<img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" 
					title="'.$this->l('Enabled').'" /></label>
			<input type="radio" name="'.$this->name.'TITLESWITCH" 
				   id="'.$this->name.'TITLESWITCH_off" 
				   value="0" '.(!Tools::getValue($this->name.'TITLESWITCH', Configuration::get($this->name.'TITLESWITCH')) ? 'checked="checked" ' : '').'/>
			<label class="t" for="'.$this->name.'TITLESWITCH_off"> 
				<img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" 
					 title="'.$this->l('Disabled').'" /></label>
			<p class="clear">'.$this->l('Display the title "FACEBOOK COMMENT" before the comments zone').'</p>
			</div>

			<label>'.$this->l('Focus').'</label>
			<div class="margin-form">
			<input type="radio" name="'.$this->name.'FOCUS" 
				   id="'.$this->name.'FOCUS_on" 
				   value="1" '.(Tools::getValue($this->name.'FOCUS', Configuration::get($this->name.'FOCUS')) ? 'checked="checked" ' : '').'/>
			<label class="t" for="'.$this->name.'FOCUS_on"> 
				<img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" 
					title="'.$this->l('Enabled').'" /></label>
			<input type="radio" name="'.$this->name.'FOCUS" id="'.$this->name.'FOCUS_off" 
					value="0" '.(!Tools::getValue($this->name.'FOCUS', Configuration::get($this->name.'FOCUS')) ? 'checked="checked" ' : '').'/>
			<label class="t" for="'.$this->name.'FOCUS_off"> 
				<img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" 
					title="'.$this->l('Disabled').'" /></label>
			<p class="clear">'.$this->l('force the user browser to open the facebook comments tab when the page is loaded').'</p>
			</div>

			<label>'.$this->l('Force').'</label>
			<div class="margin-form">
			<input type="radio" name="'.$this->name.'FORCE" 
				   id="'.$this->name.'FORCE_on" 
				   value="1" '.(Tools::getValue($this->name.'FORCE', Configuration::get($this->name.'FORCE')) ? 'checked="checked" ' : '').'/>
			<label class="t" for="'.$this->name.'FORCE_on"> 
				<img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" 
					title="'.$this->l('Enabled').'" /></label>
			<input type="radio" name="'.$this->name.'FORCE" 
				   id="'.$this->name.'FORCE_off" 
				   value="0" '.(!Tools::getValue($this->name.'FORCE', Configuration::get($this->name.'FORCE')) ? 'checked="checked" ' : '').'/>
			<label class="t" for="'.$this->name.'FORCE_off"> 
				<img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" 
					title="'.$this->l('Disabled').'" /></label>
			<p class="clear">'.$this->l('Force to display the facebook comments tab. Usefull to avoid some theme conflict').'</p>
			</div>';

		$admin_img = "";
		$admin_explode = explode(",", Configuration::get($this->name.'APPADMIN'));
		foreach($admin_explode as $admin_explode) { 
			$admin_img .= '<a href="http://www.facebook.com/profile.php?&id='.$admin_explode.'" target="_blank">
								<img class="fb-admins" width="70"
									 src="https://graph.facebook.com/'.$admin_explode.'/picture?type=large">
							</a>';	
		}
		
		$_html .= '
			<label>'.$this->l('My App').'</label>
			<div class="margin-form">
				<a class="button" 
				   href="http://www.facebook.com/apps/application.php?id='.Tools::getValue('appid', Configuration::get($this->name.'appid')).'" 
				   target="_blank">'.$this->l('Check My App').'</a>
				<br/><br/>
				<a class="button" 
				   href="http://www.facebook.com/developers/editapp.php?app_id='.Tools::getValue('appid', Configuration::get($this->name.'appid')).'&view=web" 
				   target="_blank">'.$this->l('Configure App').'</a>
				<br/><br/>
				<a class="button" 
				   href="http://developers.facebook.com/setup" 
				   target="_blank">'.$this->l('Create an App').'</a>
			</div>


			<label>'.$this->l('Moderators').'</label>
			<div class="margin-form">
				<input title="'.$this->l('Enter your facebook fan page id here').'" 
					   type="text" name="'.$this->name.'APPADMIN" 
					   value="'.Configuration::get($this->name.'APPADMIN').'" />
				<p class="clear">'.$this->l('Id administrators,  separated by commas').'</p>
				<br/>
				'.$admin_img.'
			
			</div>';
	
			
			$_html .= '</fieldset>';	
	
		
		############## end comments items ###############
		
		$_html .= $this->_updateButton(array('name'=>'facebookcomments'));
    	$_html .= '</form>';
		
		return $_html;
    }
    
    private function _drawFacebookWidgetSettingsForm(){
    	$_html =  '';
    	
    	$_html .= '
        <form action="'.$_SERVER['REQUEST_URI'].'" method="post" >';
    	
    	$_html .= '<fieldset>
					<legend><img src="../modules/'.$this->name.'/img/settings_f.png"  />'.$this->l('Facebook Widget Settings').'</legend>';

    	
    	   
         $_html .= '<label>'.$this->l('Enabled Facebook Widget:').'</label>
				
					<div class="margin-form">
					<input type="radio" value="1" id="text_list_on" name="fbon"
							'.(Tools::getValue('fbon', Configuration::get($this->name.'fbon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					
					<input type="radio" value="0" id="text_list_off" name="fbon"
						   '.(!Tools::getValue('fbon', Configuration::get($this->name.'fbon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
					<p class="clear">'.$this->l('Enable or disable Twitter Widget').'</p>
					</div>
                    
                    <label>'.$this->l('Facebook Page URL').'</label>
                    <div class="margin-form">
                        <input  type="text" style="width:200px" name="lb_facebook_page_url" 
                        		value="'.Tools::getValue($this->name.'lb_facebook_page_url', Configuration::get($this->name.'lb_facebook_page_url')).'" />
                        <p class="clear">'.$this->l('The URL of the Facebook Page for this Like box. <br/>  Create Page go to: <a href=http://www.facebook.com/pages/create.php style=color:green;text-decoration:underline target=_blank>http://www.facebook.com/pages/create.php</a>').'</p>
                    </div>';
       	 
       	 	$_html .= '<label>'.$this->l('Position:').'</label>
				<div class="margin-form">
					<select class="select" name="positionfb" 
							id="position">
						<option '.(Tools::getValue('positionfb', Configuration::get($this->name.'positionfb'))  == "left" ? 'selected="selected" ' : '').' value="left">'.$this->l('Left').'</option>
						<option '.(Tools::getValue('positionfb', Configuration::get($this->name.'positionfb')) == "right" ? 'selected="selected" ' : '').' value="right">'.$this->l('Right').'</option>
					<option '.(Tools::getValue('positionfb', Configuration::get($this->name.'positionfb')) == "home" ? 'selected="selected" ' : '').' value="home">'.$this->l('Home').'</option>
					    <option '.(Tools::getValue('positionfb', Configuration::get($this->name.'positionfb')) == "footer" ? 'selected="selected" ' : '').' value="footer">'.$this->l('Footer').'</option>
					
					</select>
				</div>
                    <label>'.$this->l('Width').'</label>
                    <div class="margin-form">
                        <input type="text" style="width:200px" name="lb_width" 
                        	   value="'.Tools::getValue($this->name.'lb_width', Configuration::get($this->name.'lb_width')).'" />
                        <p class="clear">'.$this->l('The width of the plugin in pixels.').'</p>
                    </div>
                    <label>'.$this->l('Height').'</label>
                    <div class="margin-form">
                        <input type="text" style="width:200px" name="lb_height"
                        	   value="'.Tools::getValue($this->name.'lb_height', Configuration::get($this->name.'lb_height')).'" />
                        <p class="clear">'.$this->l('The height of the plugin in pixels.').'</p>
                    </div>
                    <label>'.$this->l('Connections').'</label>
                    <div class="margin-form">
                        <input type="text" style="width:200px" name="lb_connections" 
                        		value="'.Tools::getValue($this->name.'lb_connections', Configuration::get($this->name.'lb_connections')).'" />
                        <p class="clear">'.$this->l('Show a sample of this many users who have liked this Page.').'</p>
                    </div>
                    <label>'.$this->l('Show faces').'</label>
                    <div class="margin-form">
                        <input type="checkbox" name="lb_faces" 
                        value="1" '.( Tools::getValue($this->name.'lb_faces', Configuration::get($this->name.'lb_faces')) ? 'checked="checked"' : false ).' />
                        <p class="clear">'.$this->l('Show the faces for the public profile.').'</p>
                    </div>
                    <label>'.$this->l('Show header').'</label>
                    <div class="margin-form">
                        <input type="checkbox" name="lb_header" 
                        value="1" '.( Tools::getValue($this->name.'lb_header', Configuration::get($this->name.'lb_header')) ? 'checked="checked"' : false ).' />
                        <p class="clear">'.$this->l('Show the "Find us on Facebook" bar at top. Only shown when either stream or connections are present.').'</p>
                    </div>
                    <label>'.$this->l('Iframe background color').'</label>
                    <div class="margin-form">
                        <input type="text" style="width:200px" name="lb_bg_color" 
                        	   value="'.Tools::getValue($this->name.'lb_bg_color', Configuration::get($this->name.'lb_bg_color')).'" />
                        <p class="clear">'.$this->l('Set iframe background color if transparency is not allowed.').'</p>
                    </div>
                </fieldset>
            	
               ';
       	 	
       	 	 $_html .= $this->_updateButton(array('name'=>'facebookwidget'));
    		$_html .= '</form>';
        
        
        
        return $_html;
    }
    
    private function _drawFacebookLikeButtonSettingsForm(){
    	$_html = '';
    	$_html .= '
        <form action="'.$_SERVER['REQUEST_URI'].'" method="post" >';
    	
    	$_html .= '<fieldset>
					<legend><img src="../modules/'.$this->name.'/img/settings_f.png"  />'.$this->l('Facebook Like Button Settings').'</legend>';

    	
    
    	$_html .= '<label>'.$this->l('Enabled Like Button:').'</label>
				<div class="margin-form">
				
					<input type="radio" value="1" id="text_list_on" name="likeon"
							'.(Tools::getValue('likeon', Configuration::get($this->name.'likeon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					
					<input type="radio" value="0" id="text_list_off" name="likeon"
						   '.(!Tools::getValue('likeon', Configuration::get($this->name.'likeon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
					<p class="clear">'.$this->l('Enable or disable Like Button.').'</p>
				</div>';

		$_html .= '<label>'.$this->l('Show Faces:').'</label>
				<div class="margin-form">
					<select class="select" name="likefaces" 
							id="likefaces">
						<option '.(Tools::getValue('likefaces', Configuration::get($this->name.'likefaces')) ? 'selected="selected" ' : '').' value="1">'.$this->l('Enable').'</option>
						<option '.(!Tools::getValue('likefaces', Configuration::get($this->name.'likefaces')) ? 'selected="selected" ' : '').' value="0">'.$this->l('Disable').'</option>
					</select>
				</div>
				
				<label>'.$this->l('Color Scheme:').'</label>
				<div class="margin-form">
					<select class="select" name="likecolor" 
							id="likecolor">
						<option '.((Tools::getValue('likecolor', Configuration::get($this->name.'likecolor'))
									|| Tools::getValue('likecolor', Configuration::get($this->name.'likecolor')) == 'light') ? 'selected="selected" ' : '').' value="light">'.$this->l('Light').'</option>
						<option '.((Tools::getValue('likecolor', Configuration::get($this->name.'likecolor')) == 'dark') ? 'selected="selected" ' : '').' value="dark">'.$this->l('Dark').'</option>
					</select>
				</div>';
				
		$_html .= '<label>'.$this->l('Layout Style:').'</label>
				<div class="margin-form">
					<select class=" select" name="likelayout" 
							id="likelayout">
						<option '.((Tools::getValue('likelayout', Configuration::get($this->name.'likelayout')) == 'standard' 
									|| Tools::getValue('likelayout', Configuration::get($this->name.'likelayout'))
									) ? 'selected="selected" ' : '').' value="standard">Standard</option>
						<option '.((Tools::getValue('likelayout', Configuration::get($this->name.'likelayout')) == 'button_count') ? 'selected="selected" ' : '').' value="button_count">'.$this->l('Button Count').'</option>
						<option '.((Tools::getValue('likelayout', Configuration::get($this->name.'likelayout')) == 'box_count') ? 'selected="selected" ' : '').' value="box_count">'.$this->l('Box Count').'</option>
					</select>
				</div>
				
				
				<label>'.$this->l('Width:').'</label>
				<div class="margin-form">
					<input type="text" value="'.Tools::getValue('widthlikebox', Configuration::get($this->name.'widthlikebox')).'" 
							name="widthlikebox" >
					<p class="clear">'.$this->l('The width of the Like Button in pixels.').'</p>
				</div>';
				
			$_html .= '</fieldset>';
			
			$_html .= $this->_updateButton(array('name'=>'facebooklike'));
    	$_html .= '</form>';
    	
    	return $_html;
    }
	
private function _drawTwitterWidgetSettingsForm(){
    	$_html = '';
    	$_html .= '
        <form action="'.$_SERVER['REQUEST_URI'].'" method="post" >';
    	
    	$_html .= '<fieldset>
					<legend><img src="../modules/'.$this->name.'/img/settings_t.png"  />'.$this->l('Twitter Widget Settings').'</legend>';

    	
    	
    	$_html .= '<label>'.$this->l('Enabled Twitter Widget:').'</label>
				<div class="margin-form">
				
					<input type="radio" value="1" id="text_list_on" name="twitteron"
							'.(Tools::getValue('twitteron', Configuration::get($this->name.'twitteron')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					
					<input type="radio" value="0" id="text_list_off" name="twitteron"
						   '.(!Tools::getValue('twitteron', Configuration::get($this->name.'twitteron')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
					<p class="clear">'.$this->l('Enable or disable Twitter Widget').'</p>
				</div>';
    	
    	
		$_html .= '<label>'.$this->l('User Name:').'</label>
    			
    				<div class="margin-form">
					<input type="text" name="user_name"  style="width:200px"
			                		value="'.Tools::getValue('user_name', Configuration::get($this->name.'user_name')).'">
					</div>';

		$_html .= '<label>'.$this->l('Twitter Widget ID').'</label>
    			
    				<div class="margin-form">
					<input type="text" name="tw_widgetid"  style="width:200px"
			                		value="'.Tools::getValue('tw_widgetid', Configuration::get($this->name.'tw_widgetid')).'">
					<p class="clear">
					'.$this->l('In order to configure your Twitter feed in this module configuration screen, you must first register it on Twitter.').'
					<br/><br/>
					'.$this->l('Please visit').' <a href=https://twitter.com/settings/widgets style=color:green;text-decoration:underline target=_blank>https://twitter.com/settings/widgets</a>
					<br/><br/>
					'.$this->l('And then come back to this screen to complete the configuration.').'
					<br/><br/>
					'.$this->l('You will find the Twitter widget ID and user name in the code Twitter will give you.').'
					<br/><br/>
					'.$this->l('DO NOT paste the entire piece of JavaScript code in the widget ID field, only the numeric widget ID.').'
					</p>
			        </div>';
		
		
		
		$_html .= '<label>'.$this->l('Position:').'</label>
				<div class="margin-form">
					<select class="select" name="position" 
							id="position">
						<option '.(Tools::getValue('position', Configuration::get($this->name.'position'))  == "left" ? 'selected="selected" ' : '').' value="left">'.$this->l('Left').'</option>
						<option '.(Tools::getValue('position', Configuration::get($this->name.'position')) == "right" ? 'selected="selected" ' : '').' value="right">'.$this->l('Right').'</option>
						<option '.(Tools::getValue('position', Configuration::get($this->name.'position')) == "home" ? 'selected="selected" ' : '').' value="home">'.$this->l('Home').'</option>
					    <option '.(Tools::getValue('position', Configuration::get($this->name.'position')) == "footer" ? 'selected="selected" ' : '').' value="footer">'.$this->l('Footer').'</option>
			
					</select>
				</div>';
    	
    	
    	$_html .= '<label>'.$this->l('Width:').'</label>
					<div class="margin-form">
						<input type="text" value="'.Tools::getValue('width', Configuration::get($this->name.'width')).'" 
								name="width" >
					</div>';
    	
	    $_html .= '<label>'.$this->l('Height:').'</label>
					<div class="margin-form">
						<input type="text" value="'.Tools::getValue('height', Configuration::get($this->name.'height')).'" 
								name="height" >
					</div>';
	    
	  
	    
    	$_html .= '<label>'.$this->l('Color Scheme').'</label>
				<div class="margin-form">
					<select class="select" name="tw_color_scheme" 
							id="tw_color_scheme">
						<option '.(Tools::getValue('tw_color_scheme', Configuration::get($this->name.'tw_color_scheme'))  == "light" ? 'selected="selected" ' : '').' value="light">'.$this->l('Light').'</option>
						<option '.(Tools::getValue('tw_color_scheme', Configuration::get($this->name.'tw_color_scheme')) == "dark" ? 'selected="selected" ' : '').' value="dark">'.$this->l('Dark').'</option>
					
					</select>
				</div>';
	
		$_html .= $this->_colorpicker_tw(array('name' => 'tweets_link',
											'color' => Configuration::get($this->name.'tweets_link'),
											'title' => $this->l('Tweets Link')
											  ));	
		
		$_html .= ' <label>'.$this->l(' Activate ARIA politeness').'</label>
                    <div class="margin-form">
                        <input type="checkbox" name="tw_aria_pol" 
                        value="1" '.( Tools::getValue($this->name.'tw_aria_pol', Configuration::get($this->name.'tw_aria_pol')) ? 'checked="checked"' : false ).' />
                        <p class="clear">
                        '.$this->l(' ARIA is an accessibility system that aids people using assistive technology interacting with dynamic web content.').'
                        <br/><br/>
                        '.$this->l('Read more about ARIA on W3C\'s website').':  <a href=http://www.w3.org/WAI/intro/aria.php style=color:green;text-decoration:underline target=_blank>http://www.w3.org/WAI/intro/aria.php</a>
                        </p>
                    </div>';								  
	 
		$_html .= '</fieldset>';
			
		$_html .= $this->_updateButton(array('name'=>'twitterwidget'));
		
		$_html .= '</form>';	
    	
    	return $_html;
    }

	private function _drawTwitterButtonSettingsForm(){
		$_html = '';
	$_html .= '
        <form action="'.$_SERVER['REQUEST_URI'].'" method="post" >';	
    	
		$_html .= '<fieldset>
					<legend><img src="../modules/'.$this->name.'/img/settings_t.png"  />'.$this->l('Twitter Button Settings').'</legend>';

    
    	$_html .= '<table style="width:100%;">';
  	 $_html .= '<label>'.$this->l('Enabled Twitter Button:').'</label>
				<div class="margin-form">
				
					<input type="radio" value="1" id="text_list_on" name="twitterbon"
							'.(Tools::getValue('twitterbon', Configuration::get($this->name.'twitterbon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_on" class="t"> 
						<img alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" src="../img/admin/enabled.gif">
					</label>
					
					<input type="radio" value="0" id="text_list_off" name="twitterbon"
						   '.(!Tools::getValue('twitterbon', Configuration::get($this->name.'twitterbon')) ? 'checked="checked" ' : '').'>
					<label for="dhtml_off" class="t">
						<img alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" src="../img/admin/disabled.gif">
					</label>
					
					<p class="clear">'.$this->l('Enable or disable Twitter Button').'</p>
				</div>';
   
    	$_html .= '<tr>
	    			   <td style="width:35%;text-align:center;padding:30px">
	    			   		<input type="radio" value="firston" id="firston" name="buttons"
								'.(Tools::getValue('buttons', Configuration::get($this->name.'buttons')) == "firston" ? 'checked="checked" ' : '').'>
					   </td>
	    			   <td>
	    			   	<img src="../modules/'.$this->name.'/img/firston.png" />
					   </td>
    			   </tr>';
    	$_html .= '<tr>
	    			   <td style="width:35%;text-align:center;padding:30px">
	    			   		<input type="radio" value="secondon" id="secondon" name="buttons"
								'.(Tools::getValue('buttons', Configuration::get($this->name.'buttons')) == "secondon" ? 'checked="checked" ' : '').'>
					   </td>
	    			   <td>
	    			   	<img src="../modules/'.$this->name.'/img/secondon.png" />
					   </td>
    			   </tr>';
    	$_html .= '<tr>
	    			   <td style="width:35%;text-align:center;padding:30px">
	    			   		<input type="radio" value="threeon" id="threeon" name="buttons"
								'.(Tools::getValue('buttons', Configuration::get($this->name.'buttons')) == "threeon" ? 'checked="checked" ' : '').'>
					   </td>
	    			   <td>
	    			   	<img src="../modules/'.$this->name.'/img/threeon.png" />
					   </td>
    			   </tr>';
    	$_html .= '</table>';
    	$_html .= '</fieldset>';
    	
    	$_html .= $this->_updateButton(array('name'=>'twitterbutton'));
		
		$_html .= '</form>';
		
    	return $_html;
	}
	
    private function _drawImageConnectForm(){
    	$_html = '';
    	
    	$_html .= '<fieldset>
					<legend><img src="../modules/'.$this->name.'/img/logo.gif"  />
						'.$this->l('Images Connect Buttons').'</legend>';

    	$_html .= '
        <form action="'.$_SERVER['REQUEST_URI'].'" enctype="multipart/form-data" method="post" >';	
    	
    	$_html .= '<style>
			.block-item-postions-image-buttons{border: 1px solid #CCCED7;margin: 5px 0;padding: 10px 0px 0px 0px;}
		</style>';
    	
    	include_once(dirname(__FILE__).'/classes/facebookhelp.class.php');
		$obj = new facebookhelp();
    	
    	
		
		foreach($this->_prefix_connects_image as $k => $v){
			$item = $k;
			$translate_image = $v['translate_image'];
			$translate_small_image = $v['translate_small_image'];
			$prefix = $v['prefix'];
			
			
		$_html .= '<div class="block-item-postions-image-buttons">';
    	$_html .= '<label><img src="../modules/'.$this->name.'/img/settings_'.$prefix.'.png"  />'.$translate_image.'</label>
    			
    				<div class="margin-form">
					<input type="file" name="post_image_'.$item.'" id="post_image_'.$item.'" />';
    	
    	
    	$data_img = $obj->getImages(array('admin'=>1));
    	
    	
    	$_html .= '&nbsp;&nbsp;&nbsp;<img id="image'.$prefix.'" src="'.@$data_img[$item].'">';
    	
    	if(strlen(@$data_img[$item.'_block'])>0)
    		$_html .= '&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" id="image'.$prefix.'-click" style="text-decoration:underline" onclick="return_default_img(\''.$item.'\',\''.$this->l('Are you sure you want to remove this item?').'\')">'.$this->l('Click here to return the default image').'</a>';
		
		$_html .= '<p>Allow formats *.jpg; *.jpeg; *.png; *.gif.</p>';
    	$_html .= '</div>';
    	
    	
    	$_html .= '<label><img src="../modules/'.$this->name.'/img/settings_'.$prefix.'.png"  />'.$translate_small_image.'</label>
    			
    	<div class="margin-form">
		<input type="file" name="post_image_'.$item.'small" id="post_image_'.$item.'small" />';
    	
    	
    	$_html .= '&nbsp;&nbsp;&nbsp;<img id="image'.$prefix.'small" src="'.@$data_img[$item.'small'].'">';
    	
    	if(strlen(@$data_img[$item.'_blocksmall'])>0)
    		$_html .= '&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" id="image'.$prefix.'-clicksmall" style="text-decoration:underline" onclick="return_default_img(\''.$item.'small\',\''.$this->l('Are you sure you want to remove this item?').'\')">'.$this->l('Click here to return the default image').'</a>';
		
		$_html .= '<p>Allow formats *.jpg; *.jpeg; *.png; *.gif.</p>';
    	$_html .= '</div>';
    	
    	$_html .= '</div>';
		}
    	
    	
    	
    	$_html .= $this->_updateButton(array('name'=>'uploadimages'));
		
		$_html .= '</form>';
		
		return $_html;
    }
    
private function _drawPositionsConnectsForm(){
    	$_html = '';
    	
    	$_html .= '<fieldset>
					<legend><img src="../modules/'.$this->name.'/img/logo.gif"  />
						'.$this->l('Main Settings').'</legend>';

    	$_html .= '
        <form action="'.$_SERVER['REQUEST_URI'].'" method="post" >';	
    	
		
    	$_html .= '<style>
			.choose_hooks input{margin-bottom: 10px}
			.block-item-postions-buttons{border: 1px solid #CCCED7;margin: 5px 0;padding: 10px;}
		</style>';
    	
    	##### positions render form #####
    	foreach($this->_prefix_position_connects as $text_postion => $prefix_postion){
    		
    	$prefix = $prefix_postion;
    	$_html .= '<div class="block-item-postions-buttons">';
    	$_html .= '<label><img src="../modules/'.$this->name.'/img/settings_'.$prefix.'.png"  />'.$text_postion.':</label>
    			
    				';
    	
    	
    	$top = Configuration::get($this->name.'_top'.$prefix);
		$rightcolumn = Configuration::get($this->name.'_rightcolumn'.$prefix);
		$leftcolumn  = Configuration::get($this->name.'_leftcolumn'.$prefix);
		$footer = Configuration::get($this->name.'_footer'.$prefix);
		$authpage  = Configuration::get($this->name.'_authpage'.$prefix);
		$welcome = Configuration::get($this->name.'_welcome'.$prefix);
		
		$_html .= '<div class="margin-form choose_hooks">
	    			<table style="width:80%;">
	    				<tr>
	    					<td style="width: 33%">'.$this->l('Top').'</td>
	    					<td style="width: 33%">'.$this->l('Right Column').'</td>
	    					<td style="width: 33%">'.$this->l('Left Column').'</td>
	    				</tr>
	    				<tr>
	    					<td>
	    						<input type="checkbox" name="top'.$prefix.'" '.($top == 'top'.$prefix ? 'checked="checked"' : '').' value="top'.$prefix.'"/>
	    					</td>
	    					<td>
	    						<input type="checkbox" name="rightcolumn'.$prefix.'" '.($rightcolumn == 'rightcolumn'.$prefix ? 'checked="checked"' : '').' value="rightcolumn'.$prefix.'"/>
	    					</td>
	    					<td>
	    						<input type="checkbox" name="leftcolumn'.$prefix.'" '.($leftcolumn == 'leftcolumn'.$prefix ? 'checked="checked"' : '').' value="leftcolumn'.$prefix.'"/>
	    					</td>
	    				</tr>
	    				<tr>
	    					<td>'.$this->l('Footer').'</td>
	    					<td>'.$this->l('Authentication page').'</td>
	    					<td>'.$this->l('Near with text Welcome').'</td>
	    				</tr>
	    				<tr>
	    					<td>
	    						<input type="checkbox" name="footer'.$prefix.'" '.($footer == 'footer'.$prefix ? 'checked="checked"' : '').' value="footer'.$prefix.'"/>
	    					</td>
	    					<td>
	    						<input type="checkbox" name="authpage'.$prefix.'" '.($authpage == 'authpage'.$prefix ? 'checked="checked"' : '').' value="authpage'.$prefix.'"/>
	    					</td>
	    					<td>
	    						<input type="checkbox" name="welcome'.$prefix.'" '.($welcome == 'welcome'.$prefix ? 'checked="checked"' : '').' value="welcome'.$prefix.'"/>
	    					</td>
	    				</tr>
	    				
	    			</table>
	    		</div>';
				
        	$_html .= '</div>';

		}
    	##### positions render form #####
    				
		
		$_html .= $this->_updateButton(array('name'=>'loginblock'));
		
		$_html .= '</form>';
			$_html .= '</fieldset>';
			
			
    	
    	return $_html;
    }
    
private function _welcome(){
 		$cookie = $this->context->cookie;
 		
		$current_language = (int)$cookie->id_lang;
		$iso_lng = Language::getIsoById(intval($current_language));
		$time = time();
		$_html  = '';
		
		if(version_compare(_PS_VERSION_, '1.5', '<')){
			$width = 600;
		} else {
			$width = 670;
		}
		
    	$_html .= '<fieldset>
					<legend><img src="../modules/'.$this->name.'/logo.gif" />'.$this->l('Welcome').'</legend>
					
					';
    	
    	$_html .=  $this->l('Welcome and thank you for purchasing the module.').
    			'<br/><br/>
    			<iframe src="http://storeprestamodules.com/promo.php?ts='.$time.'&amp;version='.$this->version.'&amp;name='.$this->name.'&amp;lang='.$iso_lng.'" class="storeprestamodulespromoiframe" 
    			style="border: 1px solid #CCCCCC !important;height: 550px !important;overflow: auto !important;width: '.$width.'px !important;"></iframe>
    			';
    	$_html .=	'</fieldset>'; 
    			
    	return $_html;
    }
    
    private function _drawGoogleSettingsForm(){
    	$_html = '';
    	
    	$_html .= '<fieldset>
					<legend><img src="../modules/'.$this->name.'/img/settings_g.png" />'.$this->l('Google API Settings').'</legend>
					
					';
    	
    	$_html .= '
        <form action="'.$_SERVER['REQUEST_URI'].'" method="post" >';
    	
    	// changes OAuth 2.0
	 	
		// Google Client Id
		$_html .= '<label>'.$this->l('Google Client Id').':</label>
    			
    				<div class="margin-form">
					<input type="text" name="oci"  style="width:350px"
			                		value="'.Tools::getValue('oci', Configuration::get($this->name.'oci')).'">
					<p class="clear">'.$this->l('This is the "Google Client Id" you need to get for your application to work. You can get it from here').' <a href="https://console.developers.google.com/project" style="color:green;text-decoration:underline" target="_blank">
									 	https://console.developers.google.com/project</a>
										<br/>
									'.$this->l('or').'
									<br/>
					'.$this->l('To configure the "Google Client Id" read Installation_guid.pdf , which is located in the folder  with the module.').'
					<br/>
					'.$this->l('or').'
					<br/>
					'.$this->l('Read our blog').' <a href="http://storeprestamodules.com/blog/how-to-configure-google-client-id-and-google-client-secret/"
									 style="color:green;text-decoration:underline" target="_blank">
									 '.$this->l('How to configure Google Client Id and Google Client Secret?').'</a>
										
					</p>
				</div>';
    	
    	// Google Client Secret
		$_html .= '<label>'.$this->l('Google Client Secret').':</label>
    			
    				<div class="margin-form">
					<input type="text" name="ocs"  style="width:350px"
			                		value="'.Tools::getValue('ocs', Configuration::get($this->name.'ocs')).'">
					<p class="clear">'.$this->l('This is the "Google Client Secret" you need to get for your application to work. You can get it from here').' <a href="https://console.developers.google.com/project" style="color:green;text-decoration:underline" target="_blank">
									 	https://console.developers.google.com/project</a>
										<br/>
									'.$this->l('or').'
									<br/>
					'.$this->l('To configure the "Google Client Secret" read Installation_guid.pdf , which is located in the folder  with the module.').'
					<br/>
					'.$this->l('or').'
					<br/>
					'.$this->l('Read our blog').' <a href="http://storeprestamodules.com/blog/how-to-configure-google-client-id-and-google-client-secret/"
									 style="color:green;text-decoration:underline" target="_blank">
									 '.$this->l('How to configure Google Client Id and Google Client Secret?').'</a>
										
					</p>
				
				</div>';
		
		
		$_html .= '<label>'.$this->l('Google Callback URL').':</label>
    			
    				<div class="margin-form">
					<input type="text" name="oru"  style="width:350px"
			                		value="'.Tools::getValue('oru', Configuration::get($this->name.'oru')).'">
					<p class="clear">'.$this->l('This is the "Google Callback URL" you need to get for your application to work. You can get it from here').' <a href="https://console.developers.google.com/project" style="color:green;text-decoration:underline" target="_blank">
									 	https://console.developers.google.com/project</a>
										<br/>
									'.$this->l('or').'
									<br/>
					'.$this->l('To configure the "Google Callback URL" read Installation_guid.pdf , which is located in the folder  with the module.').'
					<br/>
					'.$this->l('or').'
					<br/>
					'.$this->l('Read our blog').' <a href="http://storeprestamodules.com/blog/how-to-configure-google-client-id-and-google-client-secret/"
									 style="color:green;text-decoration:underline" target="_blank">
									 '.$this->l('How to configure Google Client Id and Google Client Secret?').'</a>
										
					</p>
				
				</div>';
		// changes OAuth 2.0
		
		
    	
		$_html .= $this->_updateButton(array('name'=>'googlesettings'));
		
		$_html .= '</form>';
    	
		$_html .=	'</fieldset>'; 
		
		
    	
    	return $_html;
    }
    
     private function _drawMicrosoftSettingsForm(){
    	$_html = '';
    	
    	$_html .= '<fieldset>
					<legend><img src="../modules/'.$this->name.'/img/settings_m.png" />'.$this->l('Microsoft Live Settings').'</legend>
					
					';
    	
    	$_html .= '
        <form action="'.$_SERVER['REQUEST_URI'].'" method="post" >';
    	
    	$_html .= '<label>'.$this->l('Microsoft Live Client ID').':</label>
    			
    				<div class="margin-form">
					<input type="text" name="mclientid"  style="width:274px"
			                		value="'.Tools::getValue('mclientid', Configuration::get($this->name.'mclientid')).'">
					<p class="clear">'.$this->l('This is the "Microsoft Live Client ID" you need to get for your application to work. You can get it from here').' <a href="https://account.live.com/developers/applications/create?tou=1" style="color:green;text-decoration:underline" target="_blank">
									 	https://account.live.com/developers/applications/create?tou=1</a>
										<br/>
									'.$this->l('or').'
									<br/>
					'.$this->l('To configure the "Microsoft Live Client ID" read Installation_guid.pdf , which is located in the folder  with the module.').'
					<br/>
					'.$this->l('or').'
					<br/>
					'.$this->l('Read our blog').' <a href="http://storeprestamodules.com/blog/how-to-configure-microsoft-live-client-id-and-microsoft-live-client-secret/"
									 style="color:green;text-decoration:underline" target="_blank">
									 '.$this->l('How to configure Microsoft Live Client ID and Microsoft Live Client Secret?').'</a>
										
					</p>
				</div>';
    	
    	// Facebook Secret Key
		$_html .= '<label>'.$this->l('Microsoft Live Client Secret').':</label>
    			
    				<div class="margin-form">
					<input type="text" name="mclientsecret"  style="width:274px"
			                		value="'.Tools::getValue('mclientsecret', Configuration::get($this->name.'mclientsecret')).'">
					<p class="clear">'.$this->l('This is the "Microsoft Live Client Secret" you need to get for your application to work. You can get it from here').' <a href="https://account.live.com/developers/applications/create?tou=1" style="color:green;text-decoration:underline" target="_blank">
									 	https://account.live.com/developers/applications/create?tou=1</a>
										<br/>
									'.$this->l('or').'
									<br/>
					'.$this->l('To configure the "Microsoft Live Client Secret" read Installation_guid.pdf , which is located in the folder  with the module.').'
					<br/>
					'.$this->l('or').'
					<br/>
					'.$this->l('Read our blog').' <a href="http://storeprestamodules.com/blog/how-to-configure-microsoft-live-client-id-and-microsoft-live-client-secret/"
									 style="color:green;text-decoration:underline" target="_blank">
									 '.$this->l('How to configure Microsoft Live Client ID and Microsoft Live Client Secret?').'</a>
										
					</p>
				
				</div>';
		
		
    	
		$_html .= $this->_updateButton(array('name'=>'microsoftsettings'));
		
		$_html .= '</form>';
    	
		$_html .=	'</fieldset>'; 
		
		
    	
    	return $_html;
    }
    
    
    private function _drawLinkedInSettingsForm(){
    	$_html = '';
    	
    	$_html .= '<fieldset>
					<legend><img src="../modules/'.$this->name.'/img/settings_l.png" />'.$this->l('LinkedIn Settings').'</legend>
					
					';
    	
    	$_html .= '
        <form action="'.$_SERVER['REQUEST_URI'].'" method="post" >';	
    	
    	$_html .= '<label>'.$this->l('LinkedIn API Key').':</label>
    			
    				<div class="margin-form">
					<input type="text" name="lapikey"  style="width:274px"
			                		value="'.Tools::getValue('lapikey', Configuration::get($this->name.'lapikey')).'">
					<p class="clear">'.$this->l('This is the "LinkedIn API Key" you need to get for your application to work. You can get it from here').' <a href="https://www.linkedin.com/secure/developer" style="color:green;text-decoration:underline" target="_blank">
									 	https://www.linkedin.com/secure/developer</a>
										<br/>
									'.$this->l('or').'
									<br/>
					'.$this->l('To configure the "LinkedIn API Key" read Installation_guid.pdf , which is located in the folder  with the module.').'
					<br/>
					'.$this->l('or').'
					<br/>
					'.$this->l('Read our blog').' <a href="http://storeprestamodules.com/blog/how-to-configure-linkedin-api-key-and-linedin-secret-key/"
									 style="color:green;text-decoration:underline" target="_blank">
									 '.$this->l('How to configure LinkedIn API Key and LinkedIn Secret Key?').'</a>
										
					</p>
				</div>';
    	
    	$_html .= '<label>'.$this->l('LinkedIn Secret Key').':</label>
    			
    				<div class="margin-form">
					<input type="text" name="lsecret"  style="width:274px"
			                		value="'.Tools::getValue('lsecret', Configuration::get($this->name.'lsecret')).'">
					<p class="clear">'.$this->l('This is the "LinkedIn Secret Key" you need to get for your application to work. You can get it from here').' <a href="https://www.linkedin.com/secure/developer" style="color:green;text-decoration:underline" target="_blank">
									 	https://www.linkedin.com/secure/developer</a>
										<br/>
									'.$this->l('or').'
									<br/>
					'.$this->l('To configure the "LinkedIn Secret Key" read Installation_guid.pdf , which is located in the folder  with the module.').'
					<br/>
					'.$this->l('or').'
					<br/>
					'.$this->l('Read our blog').' <a href="http://storeprestamodules.com/blog/how-to-configure-linkedin-api-key-and-linedin-secret-key/"
									 style="color:green;text-decoration:underline" target="_blank">
									 '.$this->l('How to configure LinkedIn API Key and LinkedIn Secret Key?').'</a>
										
					</p>
				
				</div>';
		
		$_html .= $this->_updateButton(array('name'=>'linkedinsettings'));
		
		$_html .= '</form>';
		
    	
		$_html .=	'</fieldset>'; 
		
		
    	
    	return $_html;
    }
    
    
private function _drawPaypalSettingsForm(){
    	$_html = '';
    	
    	$_html .= '<fieldset >
					<legend><img src="../modules/'.$this->name.'/img/settings_p.png" />'.$this->l('Paypal API Settings').'</legend>
					
					';
    	
    		$_html .= '
        <form action="'.$_SERVER['REQUEST_URI'].'" method="post" >';	
    	// Paypal Client ID
    	$_html .= '<label>'.$this->l('Paypal Client ID').':</label>
    			
    				<div class="margin-form">
					<input type="text" name="clientid"  style="width:374px"
			                		value="'.Tools::getValue('clientid', Configuration::get($this->name.'clientid')).'">
					<p class="clear">'.$this->l('This is the "Paypal Client ID" you need to get for your application to work. You can get it from here').' <a href="https://developer.paypal.com/webapps/developer/applications/myapps" style="color:green;text-decoration:underline" target="_blank">
									 	https://developer.paypal.com/webapps/developer/applications/myapps</a>
										<br/>
									'.$this->l('or').'
									<br/>
					'.$this->l('To configure the "Paypal Client ID" read Installation_guid.pdf , which is located in the folder  with the module.').'
					<br/>
					'.$this->l('or').'
					<br/>
					'.$this->l('Read our blog').' <a href="http://storeprestamodules.com/blog/how-to-configure-paypal-client-id-and-paypal-secret/"
									 style="color:green;text-decoration:underline" target="_blank">
									 '.$this->l('How to configure Paypal Client ID and Paypal Secret?').'</a>
										
					</p>
				</div>';
    	
    	// Secret
		$_html .= '<label>'.$this->l('Paypal Secret').':</label>
    			
    				<div class="margin-form">
					<input type="text" name="psecret"  style="width:374px"
			                		value="'.Tools::getValue('psecret', Configuration::get($this->name.'psecret')).'">
					<p class="clear">'.$this->l('This is the "Paypal Secret" you need to get for your application to work. You can get it from here').' <a href="https://developer.paypal.com/webapps/developer/applications/myapps" style="color:green;text-decoration:underline" target="_blank">
									 	https://developer.paypal.com/webapps/developer/applications/myapps</a>
										<br/>
									'.$this->l('or').'
									<br/>
					'.$this->l('To configure the "Paypal Secret" read Installation_guid.pdf , which is located in the folder  with the module.').'
					<br/>
					'.$this->l('or').'
					<br/>
					'.$this->l('Read our blog').' <a href="http://storeprestamodules.com/blog/how-to-configure-paypal-client-id-and-paypal-secret/"
									 style="color:green;text-decoration:underline" target="_blank">
									 '.$this->l('How to configure Paypal Client ID and Paypal Secret?').'</a>
										
					</p>
				
				</div>';
		
		// Secret
		$_html .= '<label>'.$this->l('Callback URL').':</label>
    			
    				<div class="margin-form">
					<input type="text" name="pcallback"  style="width:374px"
			                		value="'.Tools::getValue('pcallback', Configuration::get($this->name.'pcallback')).'">
					<p class="clear">'.$this->l('This is the "Callback URL" you need to get for your application to work. You can get it from here').' <a href="https://developer.paypal.com/webapps/developer/applications/myapps" style="color:green;text-decoration:underline" target="_blank">
									 	https://developer.paypal.com/webapps/developer/applications/myapps</a>
					</p>
				
				</div>';
		
			$_html .= $this->_updateButton(array('name'=>'paypalsettings'));
		
		$_html .= '</form>';
    	
		$_html .=	'</fieldset>'; 
		
		
    	
    	return $_html;
    }
	
private function _drawTwitterForm(){
    	$_html = '';
    	
    	$_html .= '<fieldset>
					<legend><img src="../modules/'.$this->name.'/img/settings_t.png"  />'.$this->l('Twitter API Settings').'</legend>';

    		$_html .= '
        <form action="'.$_SERVER['REQUEST_URI'].'" method="post" >';	
    	
		$_html .= '<label>'.$this->l('Consumer key:').'</label>
    			
    				<div class="margin-form">
					<input type="text" name="twitterconskey"  style="width:274px"
			               value="'.Tools::getValue('twitterconskey', Configuration::get($this->name.'twitterconskey')).'"
			               >
			         <p class="clear">'.$this->l('This is the "Consumer key" you need to get for your application to work. You can get it from here').'<a href="https://twitter.com/apps" style="color:green;text-decoration:underline" target="_blank">
									 	https://twitter.com/apps</a>
										<br/>
									'.$this->l('or').'
									<br/>
					'.$this->l('To configure the "Consumer key" read Installation_guid.pdf , which is located in the folder  with the module.').'
					<br/>
					'.$this->l('or').'
					<br/>
					'.$this->l('Read our blog').' <a href="http://storeprestamodules.com/blog/how-to-configure-twitter-consumer-key-and-twitter-consumer-secret/"
									 style="color:green;text-decoration:underline" target="_blank">
									 '.$this->l('How to configure Twitter Consumer Key and Twitter Consumer Secret ?').'</a>
										
					</p>
					
			       </div>';
		
		$_html .= '<label>'.$this->l('Consumer secret:').'</label>
    			
    				<div class="margin-form">
					<input type="text" name="twitterconssecret"  style="width:274px"
			               value="'.Tools::getValue('twitterconssecret', Configuration::get($this->name.'twitterconssecret')).'">
					 <p class="clear">'.$this->l('This is the "Consumer secret" you need to get for your application to work.  You can get it from here').' <a href="https://twitter.com/apps" style="color:green;text-decoration:underline" target="_blank">
									 	https://twitter.com/apps</a>
										<br/>
									'.$this->l('or').'
									<br/>
					'.$this->l('To configure the "Consumer secret" read Installation_guid.pdf , which is located in the folder  with the module.').'
					<br/>
					'.$this->l('or').'
					<br/>
					'.$this->l('Read our blog').' <a href="http://storeprestamodules.com/blog/how-to-configure-twitter-consumer-key-and-twitter-consumer-secret/"
									 style="color:green;text-decoration:underline" target="_blank">
									 '.$this->l('How to configure Twitter Consumer Key and Twitter Consumer Secret ?').'</a>
										
					</p>
					
					
			       </div>';
		$_html .= $this->_updateButton(array('name'=>'twittersettings'));
		
		$_html .= '</form>';
		
			$_html .= '</fieldset>';
    	
    	return $_html;
    }
    
    
private function _drawFacebookForm(){
    	$_html = '';
    	
    	$_html .= '<fieldset >
					<legend><img src="../modules/'.$this->name.'/img/settings_f.png" />
					'.$this->l('Facebook API Settings').'</legend>
					
					';
    	
    	$_html .= '
        <form action="'.$_SERVER['REQUEST_URI'].'" method="post" >';	
    	
		// Facebook Application Id
    	$_html .= '<label>'.$this->l('Facebook Application Id:').'</label>
    			
    				<div class="margin-form">
					<input type="text" name="appid"  style="width:274px"
			                		value="'.Tools::getValue('appid', Configuration::get($this->name.'appid')).'">
					<p class="clear">'.$this->l('This is the "Facebook Application Id" you need to get for your application to work. You can get it from here').' <a href="http://developers.facebook.com/setup" style="color:green;text-decoration:underline" target="_blank">
									 	http://developers.facebook.com/setup</a>
										<br/>
									'.$this->l('or').'
									<br/>
					'.$this->l('To configure the "Facebook Application Id" read Installation_guid.pdf , which is located in the folder  with the module.').'
					<br/>
					'.$this->l('or').'
					<br/>
					'.$this->l('Read our blog').' <a href="http://storeprestamodules.com/blog/how-to-configure-facebook-app-id-and-facebook-secret-key/"
									 style="color:green;text-decoration:underline" target="_blank">
									 '.$this->l('How to configure Facebook App Id and Facebook Secret Key?').'</a>
										
					</p>
				</div>';
    	
    	// Facebook Secret Key
		$_html .= '<label>'.$this->l('Facebook Secret Key:').'</label>
    			
    				<div class="margin-form">
					<input type="text" name="secret"  style="width:274px"
			                		value="'.Tools::getValue('secret', Configuration::get($this->name.'secret')).'">
					<p class="clear">'.$this->l('This is the "Facebook Secret Key" you need to get for your application to work. You can get it from here').' <a href="http://developers.facebook.com/setup" style="color:green;text-decoration:underline" target="_blank">
									 	http://developers.facebook.com/setup</a>
										<br/>
									'.$this->l('or').'
									<br/>
					'.$this->l('To configure the "Facebook Secret Key" read Installation_guid.pdf , which is located in the folder  with the module.').'
					<br/>
					'.$this->l('or').'
					<br/>
					'.$this->l('Read our blog').' <a href="http://storeprestamodules.com/blog/how-to-configure-facebook-app-id-and-facebook-secret-key/"
									 style="color:green;text-decoration:underline" target="_blank">
									 '.$this->l('How to configure Facebook App Id and Facebook Secret Key?').'</a>
										
					</p>
				
				</div>';
		
		$_html .= $this->_updateButton(array('name'=>'facebooksettings'));
		
		$_html .= '</form>';
		$_html .=	'</fieldset>'; 
		
		
    	
    	return $_html;
    }
   


    
    
private function _updateButton($data){
    	$name = isset($data['name'])?$data['name']:'';
    
    	$_html = '';
    	$_html .= '<p class="center" style="text-align:center;border: 1px solid #EBEDF4; padding: 10px; margin-top: 10px;">
					<input type="submit" name="'.$name.'" value="'.$this->l('Update settings').'" 
                		   class="button"  />
                	</p>';
    	
    	
    	
    	return $_html;
    	
    }
    
    
 public function _jsandcss(){
    	$_html = '';
    	
 		if(version_compare(_PS_VERSION_, '1.6', '>')){
    	$_html .=  '<link rel="stylesheet" media="screen" type="text/css" href="../modules/'.$this->name.'/css/prestashop16.css" />';
    		
    	}
    	
    	$_html .= '<link rel="stylesheet" href="../modules/'.$this->name.'/css/colorpicker.css" type="text/css" />';
        $_html .=  '<link rel="stylesheet" media="screen" type="text/css" href="../modules/'.$this->name.'/css/layout.css" />';
    	$_html .= '<script type="text/javascript" src="../modules/'.$this->name.'/js/colorpicker.js"></script>';
    	$_html .= '<script type="text/javascript" src="../modules/'.$this->name.'/js/eye.js"></script>';
    	$_html .= '<script type="text/javascript" src="../modules/'.$this->name.'/js/utils.js"></script>';
    	$_html .= '<script type="text/javascript" src="../modules/'.$this->name.'/js/layout.js?ver=1.0.2"></script>';
    	
    	
    	// custom menu
    	$_html .= '<link rel="stylesheet" href="../modules/'.$this->name.'/css/custom_menu.css" type="text/css" />';
    	$_html .= '<script type="text/javascript" src="../modules/'.$this->name.'/js/custom_menu.js"></script>';
    	$_html .= '<script type="text/javascript" src="../modules/'.$this->name.'/js/javascript.js"></script>';
    	
    	
    	$_html .= '<link rel="stylesheet" href="../modules/'.$this->name.'/css/blog.css" type="text/css" />';
      
    	
    	// custom-input-file
    	
    	$_html .= '<link rel="stylesheet" href="../modules/'.$this->name.'/css/custom-input-file.css" type="text/css" />';
    	$_html .= '<script type="text/javascript" src="../modules/'.$this->name.'/js/custom-input-file.js"></script>';
    	
    	// testimonials
    	$_html .= '<link rel="stylesheet" href="../modules/'.$this->name.'/css/blockshopreviews.css" type="text/css" />';
      
    	// guestbook
    	$_html .= '<link rel="stylesheet" href="../modules/'.$this->name.'/css/blockguestbook.css" type="text/css" />';
      
 
     $cookie = $this->context->cookie;
    
		$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
		$iso = Language::getIsoById((int)($cookie->id_lang));
		$isoTinyMCE = (file_exists(_PS_ROOT_DIR_.'/js/tiny_mce/langs/'.$iso.'.js') ? $iso : 'en');
		$ad = dirname($_SERVER["PHP_SELF"]);
		
		if(defined('_MYSQL_ENGINE_') && Tools::substr(_PS_VERSION_,0,3) != '1.5'){
		$_html .=  '
			<script type="text/javascript">	
			var iso = \''.$isoTinyMCE.'\' ;
			var pathCSS = \''._THEME_CSS_DIR_.'\' ;
			var ad = \''.$ad.'\' ;
			</script>';
			$_html .= '<script type="text/javascript" src="'.__PS_BASE_URI__.'js/tiny_mce/tiny_mce.js"></script>
			<script type="text/javascript" src="'.__PS_BASE_URI__.'js/tinymce.inc.js"></script>';
		$_html .= '
		<script type="text/javascript">id_language = Number('.$defaultLanguage.');</script>';
		} 
		
		if(version_compare(_PS_VERSION_, '1.5', '>')  || 
			!defined('_MYSQL_ENGINE_')){
			
			if(version_compare(_PS_VERSION_, '1.5', '>')){
				$_html .=  '
			<script type="text/javascript">	
			var iso = \''.$isoTinyMCE.'\' ;
			var pathCSS = \''._THEME_CSS_DIR_.'\' ;
			var ad = \''.$ad.'\' ;
			</script>';
				$_html .= '<script type="text/javascript" src="'.__PS_BASE_URI__.'js/tiny_mce/tiny_mce.js"></script>
				<script type="text/javascript" src="'.__PS_BASE_URI__.'js/tinymce.inc.js"></script>';
			} else {
				$_html .=  '
			<script type="text/javascript">	
			var iso = \''.$isoTinyMCE.'\' ;
			var pathCSS = \''._THEME_CSS_DIR_.'\' ;
			var ad = \''.$ad.'\' ;
			</script>';
				$_html .= '<script type="text/javascript" src="'.__PS_BASE_URI__.'js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
				';
			}
			
			
			
		$_html .= '<script type="text/javascript">
					tinyMCE.init({
						mode : "specific_textareas",
						theme : "advanced",
						editor_selector : "rte",';
		if(version_compare(_PS_VERSION_, '1.5', '>')){
			 $_html .= 'skin:"cirkuit",';
		}
			$_html  .=  'editor_deselector : "noEditor",';
			
			if(version_compare(_PS_VERSION_, '1.6', '<')){
			$_html .=  'plugins : "safari,pagebreak,style,layer,table,advimage,advlink,inlinepopups,media,searchreplace,contextmenu,paste,directionality,fullscreen",
						//Theme options
						theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
						theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,forecolor,backcolor",
						theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,media,|,ltr,rtl,|,fullscreen",
						theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,pagebreak",
						theme_advanced_toolbar_location : "top",
						theme_advanced_toolbar_align : "left",
						theme_advanced_statusbar_location : "bottom",
						theme_advanced_resizing : false,
					';
			}else{
			$_html .= 'toolbar1 : "code,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,|,blockquote,colorpicker,pasteword,|,bullist,numlist,|,outdent,indent,|,link,unlink,|,cleanup,|,media,image",
		   			   plugins : "colorpicker link image paste pagebreak table contextmenu filemanager table code media autoresize textcolor",
		   			   ';
			}
		
						
						
		  $_html .=	   'content_css : "'.__PS_BASE_URI__.'themes/'._THEME_NAME_.'/css/global.css",
						document_base_url : "'.__PS_BASE_URI__.'",';
		  if(!defined('_MYSQL_ENGINE_')){
		  $_html .=		'width: "550",';
		  } else {
		  	if(version_compare(_PS_VERSION_, '1.5', '>'))
		  		$_html .=		'width: "650",';
		  	else
		  		$_html .= 'width: "400",';
		  }
		  
		  $_html .=	    'height: "auto",
						font_size_style_values : "8pt, 10pt, 12pt, 14pt, 18pt, 24pt, 36pt",
						// Drop lists for link/image/media/template dialogs
						template_external_list_url : "lists/template_list.js",
						external_link_list_url : "lists/link_list.js",
						external_image_list_url : "lists/image_list.js",
						media_external_list_url : "lists/media_list.js",';
			
			if(version_compare(_PS_VERSION_, '1.5', '>')){
			$_html .= 	'elements : "nourlconvert,ajaxfilemanager",
						 file_browser_callback : "ajaxfilemanager",';
			} else {
			$_html .= 	'elements : "nourlconvert",';
			}
			
			$_html .=	'entity_encoding: "raw",
						convert_urls : false,
						language : "'.(file_exists(_PS_ROOT_DIR_.'/js/tinymce/jscripts/tiny_mce/langs/'.$iso.'.js') ? $iso : 'en').'"
						
					});
		</script>';
		
		}
		
    	return $_html;
    }
    
public function renderTplCategories(){
    	return Module::display(dirname(__FILE__).'/propack.php', 'categories.tpl');
    } 
    
    public function renderTplCategory(){
    	return Module::display(dirname(__FILE__).'/propack.php', 'category.tpl');
    }
    
    public function renderTplAllPosts(){
    return Module::display(dirname(__FILE__).'/propack.php', 'all-posts.tpl');
    }
    
public function renderTplPost(){
    	return Module::display(dirname(__FILE__).'/propack.php', 'post.tpl');
    }
    
    public function renderTplListCat_list(){
    	return Module::display(dirname(__FILE__).'/propack.php', 'list_blogcat.tpl');
    }
    
    public function renderTplList_list(){
    	return Module::display(dirname(__FILE__).'/propack.php', 'list.tpl');
    }
    
    public function renderTplList_comments(){
    	return Module::display(dirname(__FILE__).'/propack.php', 'list_comments.tpl');
    }
    
	public function renderTplItemsTestIm(){
		return Module::display(dirname(__FILE__).'/propack.php', 'blockshopreviews.tpl');
	}
	
	
	public function renderTplListTestIm(){
		return Module::display(dirname(__FILE__).'/propack.php', 'list_testim.tpl');
	}
	
	public function renderTplFaq(){
    	return Module::display(dirname(__FILE__).'/propack.php', 'faq.tpl');
    }
    
	public function renderTplGuestbook(){
    	return Module::display(dirname(__FILE__).'/propack.php', 'blockguestbook.tpl');
    }
    
    public function renderTplListGuestbook(){
    	return Module::display(dirname(__FILE__).'/propack.php', 'list_guestbook.tpl');
    }
    
	public function renderTplItemsNews(){
		return Module::display(dirname(__FILE__).'/propack.php', 'items.tpl');
	}
	
	public function renderTplListNews(){
		return Module::display(dirname(__FILE__).'/propack.php', 'list_news.tpl');
	}
	public function renderTplItemNews(){
		return Module::display(dirname(__FILE__).'/propack.php', 'item.tpl');
	}
	public function renderTplListProductQuestions(){
		return Module::display(dirname(__FILE__).'/propack.php', 'list_questions.tpl');
	}
	
    
	
public function translateItems(){
    	return array('page'=>$this->l('Page'),
    				 'email_subject' =>  $this->l('New Comment from Your Blog'),
    				 'meta_title_categories' => $this->l('Blog categories'),
    			     'meta_description_categories' => $this->l('Blog categories'),
    				 'meta_keywords_categories' => $this->l('Blog categories'),
    				 'meta_title_all_posts' => $this->l('All Posts'),
    				 'meta_description_all_posts' => $this->l('All Posts'),
    				 'meta_keywords_all_posts' => $this->l('All Posts'),
    				 'add_new' => $this->l('Add New'),
    				 'title_home' => $this->l('Blog'),
    				 'title_categories' => $this->l('Categories'),
    				 'title_posts' => $this->l('Posts'),
    				 'title_comments' => $this->l('Comments'),
    	
    				 'subject_testimonials'=>$this->l('New Testionial from Your Customer'),
    				 'meta_title_testimonials'=>$this->l('Testimonials'),
    				 'meta_description_testimonials'=>$this->l('Testimonials'),
    				 'meta_keywords_testimonials'=>$this->l('Testimonials'),
    	
    				 'meta_title_faq'=>$this->l('Frequently asked questions - FAQ'),
    				 'meta_description_faq'=>$this->l('Frequently asked questions - FAQ'),
    				 'meta_keywords_faq'=>$this->l('Frequently asked questions - FAQ'),
    				 'notification_new_q' => $this->l('New Question'),
    				 'response_for_q' => $this->l('Response for question'),
    				 'guest' => $this->l('Guest'),
    				
    				 'subject_guestbook'=>$this->l('New Post from Guestbook'),
    	 			 'meta_title_guestbook'=>$this->l('Guestbook'),
    				 'meta_description_guestbook'=>$this->l('Guestbook'),
    				 'meta_keywords_guestbook'=>$this->l('Guestbook'),
    	
    	 			 'seo_text_news'=> $this->l('News'),
    	
    				 'notification_new_q'=>$this->l('New Question'),
    				 'response_for_q' => $this->l('Response for question'),
    				 'guest'=>$this->l('Guest'),
    				);
    }
    
	public function translateCustom(){
		return array(
					 'page'=>$this->l('Page'),
					 'new_review' => $this->l('New Review'),
		             'reviews' => $this->l('reviews'),
					 'review' => $this->l('review'),
					 'category' => $this->l('Category'),
					 'product'=> $this->l('Product'),
			         'rate_post'=>$this->l('Rate / post a review for this product on'),
					 'sent_cron_items'=>$this->l('Number of cron items sent'),
					 'delete_cron_items'=>$this->l('Number of cron items deleted'),
					 'no_sent_items'=>$this->l('No tasks sent'),
					 'review_reminder'=>$this->l('Please Enable Review reminder email to customers in admin panel'),
		  		     'review_voucher'=>$this->l('You submit a review and get voucher for discount'),
					 'billing_address'=>$this->l('Delivery Address')
					);
	}
    
	
private function _colorpicker_tw($data){
    	
    	$name = $data['name'];
    	$color = $data['color'];
    	$title = $data['title'];
    	
    	$_html = '';
    	$_html .= '<label style="margin-top:6px">'.$title.':'.'</label>
					<div class="margin-form">
						<input type="text" 
								id="'.$name.'_val"
							   value="'.Tools::getValue($name, Configuration::get($this->name.$name)).'" 
								name="'.$name.'" style="float:left;margin-top:6px;margin-right:10px" >';
    	$_html .= '<div id="'.$name.'" style="float:left;"><div style="background-color: '.$color.';"></div></div>
    			  <div style="clear:both"></div>
						<script> $(\'#'.$name.'\').ColorPicker({
								color: \''.$color.'\',
								onShow: function (colpkr) {
									$(colpkr).fadeIn(500);
									return false;
								},
								onHide: function (colpkr) {
									$(colpkr).fadeOut(500);
									return false;
								},
								onChange: function (hsb, hex, rgb) {
									$(\'#'.$name.' div\').css(\'backgroundColor\', \'#\' + hex);
									$(\'#'.$name.'_val\').val(\'\');
									$(\'#'.$name.'_val\').val(\'#\' + hex);
								}
							});</script>';
    	$_html .= '</div>';
    	return $_html;
    }
 
private function _colorpicker($data){
    	
    	$name = $data['name'];
    	$color = $data['color'];
    	$title = $data['title'];
    	
    	$_html = '';
    	$_html .= '<label style="margin-top:6px">'.$title.':'.'</label>
					<div class="margin-form">
						<input type="text" 
								id="'.$name.'_val"
							   value="'.Tools::getValue($name, Configuration::get($name)).'" 
								name="'.$name.'" style="float:left;margin-top:6px;margin-right:10px" >';
    	$_html .= '<div id="'.$name.'" style="float:left;"><div style="background-color: '.$color.';"></div></div>
    			  <div style="clear:both"></div>
						<script>$(\'#'.$name.'\').ColorPicker({
								color: \''.$color.'\',
								onShow: function (colpkr) {
									$(colpkr).fadeIn(500);
									return false;
								},
								onHide: function (colpkr) {
									$(colpkr).fadeOut(500);
									return false;
								},
								onChange: function (hsb, hex, rgb) {
									$(\'#'.$name.' div\').css(\'backgroundColor\', \'#\' + hex);
									$(\'#'.$name.'_val\').val(\'\');
									$(\'#'.$name.'_val\').val(\'#\' + hex);
								}
							});</script>';
    	$_html .= '</div>';
    	return $_html;
    }
    
public function snippetBlockSettings($data){
		$smarty = $this->context->smarty;
		$cookie = $this->context->cookie;
		
		global $cart;
		
		$_product_id = $data['product_id'];
		$params = isset($data['params'])?$data['params']:null;
		
		$_link_obj = new Link();
    	$_link_to_product = $_link_obj->getProductLink($_product_id);
    	
    	$id_lang = intval($cookie->id_lang);
    	
    	$_obj_product = new Product($_product_id);
    	
    	
    	$id_img = 0;
    	foreach($_obj_product->getImages($id_lang) as $_item_img){
    		$id_img = (int) isset($_item_img['id_image'])?$_item_img['id_image']:0;
    		break;
    	}
    
		if(version_compare(_PS_VERSION_, '1.5', '>')){
    		$picture = $_link_obj->getImageLink($_product_id."-".$id_img,$_product_id."-".$id_img,"medium_default");
    	} else {
    		$picture = $_link_obj->getImageLink($_product_id."-".$id_img,$_product_id."-".$id_img);
    	}
    	
    	$picture = $_link_obj->getImageLink($_product_id."-".$id_img,$_product_id."-".$id_img);
   
    	
    	if(substr(_PS_VERSION_,0,3) == '1.3'){
    			$smarty = $this->context->smarty;
		
				$_http_host = $smarty->_tpl_vars['base_dir_ssl'];
	    		$picture = $_http_host.$picture;
	    	}
	    	
	    if (Configuration::get('PS_SSL_ENABLED') == 1)
			$url = "https://";
		else
			$url = "http://";
    	
    	$productname = addslashes($_obj_product->name[$id_lang]);
		
		if($url == "https://"){
	    	$picture = $url.str_replace("http://","",$picture);;
	    }else{
	    	$picture = $url.str_replace($url,"",$picture);;
	    }
	     
		$smarty->assign($this->name.'picture', isset($picture)?$picture:'');
    	$smarty->assign($this->name.'productname', $productname);
    	
		
    	//// new ///
    	
		$product = new Product($_product_id,false,intval($cookie->id_lang));
		$currency = new Currency(intval($cart->id_currency));
		if (!$currency) {
			try {
				$currency = Currency::getCurrencyInstance($cookie->id_currency);
			} catch (Exception $e) {
			}
		}
		$cover_img = $product->getCover($_product_id);
		$qty = $product->getQuantity($_product_id);
		$desc = ($product->description_short != "") ? $product->description_short : $product->description;
		$link = new Link();
		
		$smarty->assign(array(
			'product_brand' => Manufacturer::getNameById($product->id_manufacturer),
			'product_name' => $product->name,
			'product_image' => $picture,
			'product_price_custom' => number_format($product->getPrice(),2,".",","),
			'product_description' => Tools::htmlentitiesUTF8(strip_tags($desc)),
			'product_category' => $this->_getDefaultCategory($product->id_category_default),
			'currency_custom' => $currency->iso_code,
			'quantity' => $qty,
			'stock_string' => ($qty > 0) ? 'in_stock' : 'out_of_stock'
		));
		
		if (isset($product->upc) && !Tools::isEmpty($product->upc)) {
			$smarty->assign(array('show_identifier' => true,'identifier_type' => 'upc', 'identifier_value' => $product->upc));
		}
		elseif (!Tools::isEmpty($product->ean13)) {
			$smarty->assign(array('show_identifier' => true,'identifier_type' => 'sku', 'identifier_value' => $product->ean13));
		} else {
			$smarty->assign(array('show_identifier' => false));
		}
		
		if (Configuration::get('GPROFILE_ID') != "") {
			$smarty->assign("gprofile_id",Configuration::get('GPROFILE_ID'));
		} else {
			$smarty->assign("gprofile_id",false);
		}
		/// end new ///
		
		
		$smarty->assign($this->name.'gsnipblock', Configuration::get($this->name.'gsnipblock'));
    	$smarty->assign($this->name.'id_hook_gsnipblock', Configuration::get($this->name.'id_hook_gsnipblock'));
    	$smarty->assign($this->name.'gsnipblock_width', Configuration::get($this->name.'gsnipblock_width'));
    	$smarty->assign($this->name.'gsnipblocklogo', Configuration::get($this->name.'gsnipblocklogo'));
    	
    	
    	
    	$count_review = 0;
		$avg_rating = 0;
		
		if(Configuration::get($this->name.'reviewson')==1){
		
	    	include_once(dirname(__FILE__).'/classes/reviewshelp.class.php');
			$obj_reviewshelp = new reviewshelp();
			
			$count_review = $obj_reviewshelp->getCountReviews(array('id_product' => $_product_id));
			$avg_rating = $obj_reviewshelp->getAvgReview(array('id_product' => $_product_id));
	    	
		}
		
		$smarty->assign($this->name.'count', $count_review);
		$smarty->assign($this->name.'total', $avg_rating);
		
    	if($product->getPrice()==0)
			return '';
		else
			return $this->display(__FILE__, 'snippet.tpl');		
	}
	
private function _getDefaultCategory($id_category)
	{
		$cookie = $this->context->cookie;
		
		$_category = new Category($id_category);
		return $_category->getName(intval($cookie->id_lang));
	}
	

 	private function _getProducts(){
		
		$smarty = $this->context->smarty;
		$cookie = $this->context->cookie;
		
		$id_lang = intval($cookie->id_lang);
		$db = Db::getInstance();
		if(version_compare(_PS_VERSION_, '1.5', '>')){
			
			$sql = 'SELECT p.id_product, pl.`link_rewrite`, pl.`name`, ps.id_shop FROM '._DB_PREFIX_.'product p 
					LEFT JOIN '._DB_PREFIX_.'product_lang pl ON (p.id_product = pl.id_product AND pl.id_lang = '.intval($id_lang).' 
					AND pl.id_shop = '.Shop::getCurrentShop().') 
					LEFT JOIN '._DB_PREFIX_.'product_shop ps ON(p.id_product = ps.id_product AND ps.id_shop = '.Shop::getCurrentShop().') 
					WHERE ps.active = 1';
		} else {
		$sql = 'SELECT p.id_product, pl.`link_rewrite`, pl.`name` FROM '._DB_PREFIX_.'product p
	            LEFT JOIN '._DB_PREFIX_.'product_lang pl ON (p.id_product = pl.id_product AND pl.id_lang = '.intval($id_lang).')
	            WHERE p.active = 1';
		}
		$result = Db::getInstance()->ExecuteS($sql);
		
	    $data_all[] = array();
		foreach($result as $products){
			
			$id_product= isset($products['id_product'])?$products['id_product']:'';
			$link_rewrite= isset($products['link_rewrite'])?$products['link_rewrite']:'';
			$_category= isset($products['category'])?$products['category']:'';
			$_category = htmlspecialchars($_category); 
			//$_ean13= isset($products['ean13'])?$products['ean13']:'';
			
			$link = new Link();
			$_url = $link->getProductLink($id_product, 
										  $link_rewrite, 
										  $_category 
										  //$_ean13
										  );
		
			
			$_name = isset($products['name'])?$products['name']:'';
			$_name = addslashes($_name);
			$_url = isset($_url)?$_url:'';
			
			$data_all[] = array('link' => $_url, 'name' => $_name);
		
		}
		
		
		
		return array('products' => $data_all);
	}
    
	
	private function _getProductsList(){
		
		$smarty = $this->context->smarty;
		$cookie = $this->context->cookie;
		
		$id_lang = intval($cookie->id_lang);
		$db = Db::getInstance();
		if(version_compare(_PS_VERSION_, '1.5', '>')){
			
			$sql = 'SELECT p.id_product, pl.`link_rewrite`, pl.`name`, ps.id_shop FROM '._DB_PREFIX_.'product p 
					LEFT JOIN '._DB_PREFIX_.'product_lang pl ON (p.id_product = pl.id_product AND pl.id_lang = '.intval($id_lang).' 
					AND pl.id_shop = '.Context::getContext()->shop->id.') 
					LEFT JOIN '._DB_PREFIX_.'product_shop ps ON(p.id_product = ps.id_product AND ps.id_shop = '.Context::getContext()->shop->id.') 
					WHERE ps.active = 1 limit 1000';
		} else {
		$sql = 'SELECT p.id_product, pl.`link_rewrite`, pl.`name` FROM '._DB_PREFIX_.'product p
	            LEFT JOIN '._DB_PREFIX_.'product_lang pl ON (p.id_product = pl.id_product AND pl.id_lang = '.intval($id_lang).')
	            WHERE p.active = 1 limit 1000';
		}
		$result = Db::getInstance()->ExecuteS($sql);
		
	    $data_all[] = array();
		foreach($result as $products){
			
			$id_product= isset($products['id_product'])?$products['id_product']:'';
			$link_rewrite= isset($products['link_rewrite'])?$products['link_rewrite']:'';
			$_category= isset($products['category'])?$products['category']:'';
			$_category = htmlspecialchars($_category); 
			$_ean13= isset($products['ean13'])?$products['ean13']:'';
			
			$link = new Link();
			if(version_compare(_PS_VERSION_, '1.5', '>')){
			
			$force_routes = false;
			if(Configuration::get('PS_REWRITING_SETTINGS')==1)
				$force_routes = true;
				
			$_url = $link->getProductLink($id_product, 
										  $link_rewrite, 
										  $_category,
										  $_ean13,
										  $id_lang,
										  Context::getContext()->shop->id,
										  0,
										  $force_routes 
										  );

			} else {
				$_url = $link->getProductLink($id_product, 
										  $link_rewrite, 
										  $_category
										 
										  );
			}
			
			
			$_name = isset($products['name'])?$products['name']:'';
			$_name = addslashes($_name);
			$_url = isset($_url)?$_url:'';
			
			$data_all[] = array('link' => $_url, 'name' => $_name);
		
		}
		
		
		
		return array('products' => $data_all);
	}
 	
	public function renderTpl($data){
		$name = $data['name'];
		$data_reviews = $data['data'];
		
		$smarty = $this->context->smarty;
		$smarty->assign(array('reviews' => $data_reviews));
		
		return $this->display(__FILE__.'/propack.php', $name.'.tpl');
	}
	
	public function renderTplLeftRight($data){
		$name = $data['name'];
		$data_reviews = $data['data'];
		
		$smarty = $this->context->smarty;
		
		$smarty->assign(array($this->name.'reviews' => $data_reviews['reviews']));
		$smarty->assign($this->name.'position', Configuration::get($this->name.'position'));
		$smarty->assign($this->name.'rsson', Configuration::get($this->name.'rsson'));
		$smarty->assign($this->name.'x_reviews', Configuration::get($this->name.'x_reviews'));
    	
		return $this->display(__FILE__.'/propack.php', $name.'.tpl');
	}
	
	public function renderMyReviews(){
		return $this->display(__FILE__.'/propack.php', 'my-reviews.tpl');
	}
	
	public function renderListReviewsAllMy(){
		return $this->display(__FILE__.'/propack.php', 'list_reviews_all_my.tpl');	
	}
    
private function _getPicture($data = null){
    	$smarty = $this->context->smarty;
    	$cookie = $this->context->cookie;
		
    	$params = isset($data['params'])?$data['params']:'';
    	$_product_id =$data['product_id'];
    	
    	$_link_obj = new Link();
    	$id_lang = intval($cookie->id_lang);
    	$id_img = 0;
    	$_obj_product = new Product($_product_id);
    	foreach($_obj_product->getImages($id_lang) as $_item_img){
    		$id_img = (int) isset($_item_img['id_image'])?$_item_img['id_image']:0;
    		break;
    	}
    	if(defined('_MYSQL_ENGINE_')){
    		$tpl_vars = $smarty->tpl_vars;
    		$base_dir_tmp = $tpl_vars['base_dir'];
	    	$base_dir = $base_dir_tmp->value;
    		isset($id_img)?$id_img = $id_img:$id_img = 0;
    		$picture = $_link_obj->getImageLink($_product_id."-".$id_img,$_product_id."-".$id_img);	
    
    	} else {
    		
    		$tpl_vars = $smarty->_tpl_vars;
    		$base_dir = $tpl_vars['base_dir'];
	    		
    		$data_product = $this->_getInfoAboutProduct($params);
	    	$info_product = @$data_product['info_product'];
	    	$picture = $_link_obj->getImageLink(
	    										$info_product[0]['link_rewrite'],
	    										$_product_id."-".$id_img."-large"
	    										);
	    	//$picture = substr($base_dir,0,-1).$picture;
	    	$picture = "http://".$_SERVER['HTTP_HOST'].$picture;
	    }
	    
	    return array('img'=>$picture,'picture'=>$picture);
    }
    
private function _getInfoAboutProduct($params = null){
    	$cookie = $this->context->cookie;
		
    	$id_product = (int)Tools::getValue('id_product');
    	
    	if($id_product != 0){
	    	$id_lang = intval($cookie->id_lang);
	    	
	    	$result = Db::getInstance()->ExecuteS('
	            SELECT p.*, pl.`description`, pl.`description_short`, pl.`link_rewrite`, pl.`meta_description`, pl.`meta_keywords`, pl.`meta_title`, pl.`name`, p.`ean13`,
	                i.`id_image`, il.`legend`,  m.`name` AS manufacturer_name
	            FROM `'._DB_PREFIX_.'product` p
	            LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (p.`id_product` = pl.`id_product` AND pl.`id_lang` = '.intval($id_lang).')
	            LEFT JOIN `'._DB_PREFIX_.'image` i ON (i.`id_product` = p.`id_product` AND i.`cover` = 1)
	            LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON (i.`id_image` = il.`id_image` AND il.`id_lang` = '.intval($id_lang).')
	            LEFT JOIN `'._DB_PREFIX_.'manufacturer` m ON (m.`id_manufacturer` = p.`id_manufacturer`)
	            WHERE p.`active` = 1 AND p.id_product = '.$id_product);
	       
	    	$_data = Product::getProductsProperties($id_lang, $result);
	        $description = isset($_data[0]['description_short'])?$_data[0]['description_short']:'';
	    	
	    	// get name
	        $_name = isset($_data[0]['name'])?$_data[0]['name']:'';
	        
	        // get image
	        $image = Image::getImages($id_lang, $id_product);
			$_img = _PS_BASE_URL_.__PS_BASE_URI__."img/p/".
					 (isset($image[0]['id_product'])?$image[0]['id_product']:'')
					 ."-".
					 (isset($image[0]['id_image'])?$image[0]['id_image']:'').".jpg";
	        
	        // current url
	        $_url = isset($_data[0]['link'])?$_data[0]['link']:'';
    	}
        return array('name' => isset($_name)?$_name:'', 'img' => isset($_img)?$_img:'',
        			 'url'=>isset($_url)?$_url:'', 'id_product' => isset($id_product)?$id_product:0,
        				'description'=>isset($description)?$description:'');
    	
    }
    

private function getProduct($data){
		
		$id = (int) $data['id'];
		$smarty = $this->context->smarty;
		$cookie = $this->context->cookie;
		
		$id_lang = intval($cookie->id_lang);
		$result = Db::getInstance()->ExecuteS('
	            SELECT p.id_product, pl.`link_rewrite`, pl.`name`
	            FROM `'._DB_PREFIX_.'product` p
	            LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (p.`id_product` = pl.`id_product` AND pl.`id_lang` = '.intval($id_lang).')
	            WHERE p.`active` = 1 AND p.`id_product` = '.$id.' limit 1');
		
	    $data_all[] = array();
		foreach($result as $products){
			
			$id_product= isset($products['id_product'])?$products['id_product']:'';
			$link_rewrite= isset($products['link_rewrite'])?$products['link_rewrite']:'';
			$_category= isset($products['category'])?$products['category']:'';
			$_category = htmlspecialchars($_category); 
			//$_ean13= isset($products['ean13'])?$products['ean13']:'';
			
			$link = new Link();
			$_url = $link->getProductLink($id_product, 
										  $link_rewrite, 
										  $_category 
										  //$_ean13
										  );
		
			
			$_name = isset($products['name'])?stripslashes($products['name']):'';
			$_name = addslashes($_name);
			$_url = isset($_url)?$_url:'';
			
			$data_all[] = array('link' => $_url, 'name' => $_name);
		
		}
		
		
		
		return array('product' => $data_all);
	}
    
private function assignvars(){
			
		$smarty = $this->context->smarty;
		
		$pusername = Configuration::get($this->name.'_pusername');
		//$pspecboard = Configuration::get($this->name.'_pspecboard');
		$number = Configuration::get($this->name.'_number');
		$descrl = Configuration::get($this->name.'_descrl');
		
		/*if($pspecboard !== ''){	
			$feed_url = 'http://pinterest.com/'.$pusername.'/'.$pspecboard.'/rss';
		}else{*/
			$feed_url = 'http://pinterest.com/'.$pusername.'/feed.rss';	
		//}
		require_once _PS_ROOT_DIR_ . "/modules/".$this->name."/lib/pinterestwidget/api.feedsprocessing.php";
		$feed = new feedsProcessingAPI();
		
		$feed_items = array();
		if ($feed->get($feed_url, $number)){

			
			
			foreach ($feed->items as $item){
	
                $item_param = array();

                $item_param["id"] = $item->get_id();

                $item_param["category"] = $item->get_category();

                $item_param["title"] = $item->get_title();

                $description = $item->get_description();
                $item_param["description"] = $this->trim_descr($description, $descrl);
				
                preg_match('/<img src="(.+)">/', $description, $pin_image_link);
                $item_param["image_link"] = $pin_image_link[1];
                
                $item_param["link"] = $item->get_link();

                $item_param["date"] = $item->get_date("M d Y H:i");
                
                $author = $item->get_author();
                
                if (is_object($author)){

                    $item_param["author"] = array("email" => $author->get_email(), "link" => $author->get_link(), "name" => $author->get_name()) ;
                
                }
                
                $feed_items[] = $item_param;
            }
		}
		
		$smarty->assign($this->name.'_title', Configuration::get($this->name.'_title'));
		$smarty->assign($this->name.'_pusername', Configuration::get($this->name.'_pusername'));
		$smarty->assign($this->name.'_width', Configuration::get($this->name.'_width'));
		$smarty->assign($this->name.'_height', Configuration::get($this->name.'_height'));
		$smarty->assign($this->name.'_pwidth', Configuration::get($this->name.'_pwidth'));
		$smarty->assign($this->name.'_follow', Configuration::get($this->name.'_follow'));
		$smarty->assign($this->name.'_descr', Configuration::get($this->name.'_descr'));
		$smarty->assign($this->name.'_feed_items', $feed_items);
		
		return $this->display(__FILE__, 'pinterestwidget.tpl');
			
	}
	
private function trim_descr($description, $descrl){
		
		$description = str_replace("\n",'',strip_tags($description));
		
		if(strlen($description) <= $descrl){
			
			return $description;
			
		}else{
			
			$description = substr($description, 0 , $descrl);
			
			if(substr($description, -1) == ' '){
				$description = substr($description, 0 , $descrl - 1) . '...';
			}else{
				$description .= '...';
			}
		}
		
		return $description;
	}
	
	
private function getUrl($isFront = false)
	{

		if (!$isFront)
		{
			$siteUrl = $_SERVER['REQUEST_URI'];
			$siteUrl = explode("?", $siteUrl);		
			if (isset($siteUrl[0])) $siteUrl = explode("/", $siteUrl[0]); else return $_SERVER['HTTP_HOST'];
			if (count($siteUrl) < 2) return $_SERVER['HTTP_HOST'];		
			
			array_pop($siteUrl);
			array_pop($siteUrl);
			
			$siteUrl = implode("/", $siteUrl);
			$siteUrl = "http://" . $_SERVER['HTTP_HOST'] . $siteUrl;
		}
		else
		{			
			$siteUrl = $_SERVER['REQUEST_URI'];
			$siteUrl = explode("?", $siteUrl);		
			if (isset($siteUrl[0])) $siteUrl = explode("/", $siteUrl[0]); else return $_SERVER['HTTP_HOST'];
			if (count($siteUrl) < 2) return $_SERVER['HTTP_HOST'];		
			
			array_pop($siteUrl);			
			
			$siteUrl = implode("/", $siteUrl);
			$siteUrl = "http://" . $_SERVER['HTTP_HOST'] . $siteUrl;
		}
			return $siteUrl;
	}
	
	

private function getItems($data)
	{
		
		$start = $data['start'];
		$step = $data['step'];
		
		$sql = 'SELECT distinct fr.user_id         
       				   FROM `'. _DB_PREFIX_ . 'four_referral` as fr
       				   WHERE user_id != 0
       				   ORDER BY fr.`user_id` DESC LIMIT '.$start.' ,'.$step.'';
		$_data_ids = Db::getInstance()->ExecuteS($sql);
		
		$user_data = array();
		foreach($_data_ids as $_item_id){
			$user_id = $_item_id['user_id'];
				
			// get info about user //
			$sql = 'SELECT c.id_customer as id,
					   c.firstname,
					   c.lastname
					   FROM  `'. _DB_PREFIX_ . 'customer` c
					   WHERE c.id_customer = '.$user_id;
			$info_user = Db::getInstance()->ExecuteS($sql);
			
			$user_data[] = $info_user[0];
		}
		$_data_tmp = $user_data;
		
		$_data = array();
		
		foreach($_data_tmp as $_item){
			$_id_customer = (int)$_item['id'];
			
			$sql_is_exist = 'select COUNT(*) as count from `'. _DB_PREFIX_ . 'four_referral` 
        					where user_id = '.$_id_customer.'';
			
			$data_exist_user = Db::getInstance()
			->getRow($sql_is_exist);
			
			if($data_exist_user['count']>0){
			
			
			$data_count_facebook = Db::getInstance()
			->getRow('select COUNT(*) as count from `'. _DB_PREFIX_ . 'four_referral` 
        					where `type` = 1 and user_id = '.$_id_customer.'');
			
			$data_count_twitter = Db::getInstance()
			->getRow('select COUNT(*) as count from `'. _DB_PREFIX_ . 'four_referral` 
        					where `type` = 2 and user_id = '.$_id_customer.'');
			
			$data_count_linkedin = Db::getInstance()
			->getRow('select COUNT(*) as count from `'. _DB_PREFIX_ . 'four_referral` 
        					where `type` = 3 and user_id = '.$_id_customer.'');
			
			$data_count_google = Db::getInstance()
			->getRow('select COUNT(*) as count from `'. _DB_PREFIX_ . 'four_referral` 
        					where `type` = 4 and user_id = '.$_id_customer.'');
			
			$_item['count_facebook'] = $data_count_facebook['count'];
			$_item['count_twitter'] = $data_count_twitter['count'];
			$_item['count_linkedin'] = $data_count_linkedin['count'];
			$_item['count_google'] = $data_count_google['count'];
			
			$_data[] = $_item;
			}
			
		}
		
		
		$sql_count = 'SELECT distinct c.id_customer,
					   c.firstname,
					   c.lastname
					   FROM  `'. _DB_PREFIX_ . 'customer` c';
		$_data_tmp = Db::getInstance()->ExecuteS($sql_count);
		$count_all = 0;
		foreach($_data_tmp as $_item){
			$_id_customer = (int)$_item['id_customer'];
			
			$data_exist_user = Db::getInstance()
			->getRow('select COUNT(*) as count from `'. _DB_PREFIX_ . 'four_referral` 
        					where user_id = '.$_id_customer.'');
			
			if($data_exist_user['count']>0){
				$count_all++;
			}
			
		}
		return array('data' => $_data, 'count_all' => $count_all );
	}
private function getItem($data)
	{	
		
		$id = (int)$data['id'];
		$sql = 'SELECT c.id_customer as id,
					   c.firstname,
					   c.lastname
					   FROM  `'. _DB_PREFIX_ . 'customer` c
					   WHERE c.id_customer = '.$id.'';
		$_data_tmp = Db::getInstance()->ExecuteS($sql);
		
		$id_customer = (int) $_data_tmp[0]['id'];
		
			
			$data_count_facebook = Db::getInstance()
			->getRow('select COUNT(*) as count from `'. _DB_PREFIX_ . 'four_referral` 
        					where `type` = 1 and user_id = '.$id_customer.'');
			
			$data_count_twitter = Db::getInstance()
			->getRow('select COUNT(*) as count from `'. _DB_PREFIX_ . 'four_referral` 
        					where `type` = 2 and user_id = '.$id_customer.'');
			
			$data_count_linkedin = Db::getInstance()
			->getRow('select COUNT(*) as count from `'. _DB_PREFIX_ . 'four_referral` 
        					where `type` = 3 and user_id = '.$id_customer.'');
			
			$data_count_google = Db::getInstance()
			->getRow('select COUNT(*) as count from `'. _DB_PREFIX_ . 'four_referral` 
        					where `type` = 4 and user_id = '.$id_customer.'');
			
		$_data_tmp[0]['count_facebook'] = $data_count_facebook['count'];
		$_data_tmp[0]['count_twitter'] = $data_count_twitter['count'];
		$_data_tmp[0]['count_linkedin'] = $data_count_linkedin['count'];
		$_data_tmp[0]['count_google'] = $data_count_google['count'];
		
		
		$_referrals_customer = $this->getItemsReferrals(array('id_customer' => $id_customer,'data' => $data ));
		
		$_data = $_referrals_customer['data'];
		$count_all = $_referrals_customer['count_all'];
		
		return array('data' => $_data, 'count_all' => $count_all, 'data_item' => $_data_tmp );
	}
	
private function getItemsReferrals($data)
	{
		
		$start = $data['data']['start'];
		$step = $data['data']['step'];
		$id_customer = (int)$data['id_customer'];
		
		$sql = 'SELECT *
					   FROM  `'. _DB_PREFIX_ . 'four_referral`
					   WHERE user_id = '.$id_customer.'
					   ORDER BY `date` DESC LIMIT '.$start.' ,'.$step.'';
		$_data = Db::getInstance()->ExecuteS($sql);
		
		$sql_count = 'SELECT count(*) as count 
					   FROM  `'. _DB_PREFIX_ . 'four_referral`
					   WHERE user_id = '.$id_customer.'';
		$_data_tmp = Db::getInstance()->ExecuteS($sql_count);
		$count_all = $_data_tmp[0]['count'];
		
		
		return array('data' => $_data, 'count_all' => $count_all );
	}
	
	
public function translateText(){
		$cookie = $this->context->cookie;
		
		
		
		switch (Configuration::get($this->name.'discount_type'))
				{
					case 1:
						// percent
						$fid_discount_type = 1;
						$fvalue = Configuration::get($this->name.'percentage_val');
						break;
					case 2:
						// currency
						$fid_discount_type = 2;
						$id_currency = (int)$cookie->id_currency;
						$fvalue = Configuration::get('fbrefamount_'.(int)$id_currency);
					break;
					default:
						$fid_discount_type = 2;
						$id_currency = (int)$cookie->id_currency;
						$fvalue = Configuration::get('fbrefamount_'.(int)$id_currency);
				}
				$fvaluta = "%";
				
				if($fid_discount_type == 2){
					if($this->_is16)
			    		$cur = Currency::getCurrenciesByIdShop(Context::getContext()->shop->id);
			    	else
			    		$cur = Currency::getCurrencies();	
					foreach ($cur AS $_cur){
			    	if(Configuration::get('PS_CURRENCY_DEFAULT') == $_cur['id_currency']){
			    			$fvaluta = $_cur['sign'];
			    		}
			    	}
				} 
			
		
		return array('share_text' => $this->l('Share'),
					 'share_text_two' => $this->l('and get Discount'),
					 'firsttext' => $this->l('You get voucher for discount'),
					 'secondtext' => $this->l('Here is you voucher code'),
					 'threetext' => $this->l('It is valid until'),
					 'discountvalue' => $fvalue.$fvaluta,
					 'product'=> $this->l('product'),
					 'products'=>$this->l('products'),
					'get_voucher'=>$this->l('You get voucher for discount')
					);
	}
	
	/*
	  * *  echo $n." ".number_ending($n, "reviews", "review", "reviews"); 
	 */
	public function number_ending($number, $ending0, $ending1, $ending2) {
		$num100 = $number % 100;
		$num10 = $number % 10;
		if ($num100 >= 5 && $num100 <= 20) {
			return $ending0;
		} else if ($num10 == 0) {
			return $ending0;
		} else if ($num10 == 1) {
			return $ending1;
		} else if ($num10 >= 2 && $num10 <= 4) {
			return $ending2;
		} else if ($num10 >= 5 && $num10 <= 9) {
			return $ending0;
		} else {
			return $ending2;
		}
	}
	
	
function PageNav($start,$count,$step,$currentUrl)
	{
		
		$res = '';
		$product_count = $count;
		$res .= '<div class="pages" style="margin-top:10px;text-align:left">';
		$res .= '<span>'.$this->l('Page').': </span>';
		$res .= '<span class="nums">';
		
		$start1 = $start;
			for ($start1 = ($start - $step*4 >= 0 ? $start - $step*4 : 0); $start1 < ($start + $step*5 < $product_count ? $start + $step*5 : $product_count); $start1 += $step)
				{
					$par = (int)($start1 / $step) + 1;
					if ($start1 == $start)
						{
						
						$res .= '<b>'. $par .'</b>';
						}
					else
						{
						
						$res .= '<a href="'.$currentUrl . "&start_mod=" . ($start1 ? $start1 : 0).'" 
									>'.$par.'</a>';
						  
						}
				}
		
		$res .= '</span>';
		$res .= '</div>';
		
		
		return $res;
	}
	
function PageNavRef($start,$count,$step,$currentUrl,$customer_id)
	{
		
		$res = '';
		$product_count = $count;
		$res .= '<div class="pages" style="margin-top:10px;text-align:left">';
		$res .= '<span>'.$this->l('Page').': </span>';
		$res .= '<span class="nums">';
		
		$start1 = $start;
			for ($start1 = ($start - $step*4 >= 0 ? $start - $step*4 : 0); $start1 < ($start + $step*5 < $product_count ? $start + $step*5 : $product_count); $start1 += $step)
				{
					$par = (int)($start1 / $step) + 1;
					if ($start1 == $start)
						{
						
						$res .= '<b>'. $par .'</b>';
						}
					else
						{
						
						$res .= '<a href="'.$currentUrl . "&start_modref=" . ($start1 ? $start1 : 0).'&id='.$customer_id.'" 
									>'.$par.'</a>';
						  
						}
				}
		
		$res .= '</span>';
		$res .= '</div>';
		
		
		return $res;
	}
	
public function renderTplfourreferrals($data = null){
	
		return Module::display(dirname(__FILE__).'/propack.php', 'socreferrals.tpl');
	}
	
}




?>