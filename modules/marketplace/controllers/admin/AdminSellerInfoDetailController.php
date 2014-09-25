<?php
	include_once dirname(__FILE__).'/../../classes/SellerInfoDetail.php';
	include_once dirname(__FILE__).'/../../classes/ImageManipulator.php';
	class AdminSellerInfoDetailController extends ModuleAdminController {

		public function __construct() {
			
			$this->table       = 'marketplace_seller_info';

			$this->className   = 'SellerInfoDetail';

			$this->lang        = false;

		    $this->context     = Context::getContext();
			
			$lang_id = $this->context->language->id;
			
			
			$this->_join .= 'LEFT JOIN `'._DB_PREFIX_.'marketplace_customer` mpc ON (mpc.`marketplace_seller_id` = a.`id`)';
			$this->_select = 'mpc.`is_seller`,mpc.`id_customer`';
			$hook_res = Hook::exec('displayAdminSellerInfoJoin', array('flase' => 1));
			if($hook_res) {	
				$this->_join .=$hook_res;
				$hook_sel_res = Hook::exec('displayAdminSellerInfoSelect', array('flase' => 1));
				$this->_select .= $hook_sel_res;
			}
			
			$this->fields_list = array();
			$this->fields_list['id'] = array(
				'title' => $this->l('ID'),
				'align' => 'center',
				'width' => 25
			);
			
			$this->fields_list['id_customer'] = array(
				'title' => $this->l('Id customer'),
				'align' => 'center',
				'width' => 25
			);
			
			$this->fields_list['business_email'] = array(
				'title' => $this->l('Business email'),
				'align' => 'center',
				'width' => 25
			);
			
			$this->fields_list['seller_name'] = array(
				'title' => $this->l('Seller Name'),
				'align' => 'center',
				'width' => 25
			);
			
			$this->fields_list['shop_name'] = array(
				'title' => $this->l('Shop name'),
				'align' => 'center',
				'width' => 25
			);
			
			$this->fields_list['phone'] = array(
				'title' => $this->l('Phone'),
				'align' => 'center',
				'width' => 25
			);
			
			if($hook_res) {	
				$this->fields_list['plan_name'] = array(
					'title' => $this->l('Plan Name'),
					'align' => 'center',
					'width' => 25
				);
			}
			
			$this->fields_list['is_seller'] =array(
					'title' => $this->l('Status'),
					'active' => 'status',
					'align' => 'center',
					'type' => 'bool',
					'width' => 70,
					'orderby' => false
				);
			
			$this->identifier  = 'id';

			$this->bulk_actions = array('delete' => array('text' => $this->l('Delete selected'), 'confirm' => $this->l('Delete selected items?')));
			// var_dump(Db::getInstance()->executeS("delete from `"._DB_PREFIX_."marketplace_customer`"));
			parent::__construct();
			
		}

		public function renderList() {
			$this->addRowAction('edit');
			$this->addRowAction('delete');
			$this->addRowAction('view');
			return parent::renderList();

		}

		public function initToolbar() {
			parent::initToolbar();
		}	
		
		

		public function postProcess() {

			if (!($obj = $this->loadObject(true)))

				return;

			global $currentIndex;
			$currentindex = $currentIndex;
			$token = $this->token;
				
			$this->addJS(_PS_JS_DIR_ . 'tiny_mce/tiny_mce.js');
			$this->addJS(_PS_JS_DIR_ . 'tinymce.inc.js');
			$this->addCSS(_MODULE_DIR_ . 'marketplace/css/registration.css');
			
			if (Tools::isSubmit('statusmarketplace_seller_info')) 
			{
				$id = Tools::getValue('id');
				$this->make_seller_patner();
			} 
			else if($this->tabAccess['delete'] === '1' && Tools::isSubmit('deletemarketplace_seller_info')) {

				$id = (int)Tools::getValue('id');

				$this->delete_seller_info($id);

			} 
			//echo $currentindex;
			if($this->display == 'view') {
			
				global $smarty;
				global $currentIndex;
				$this->context       = Context::getContext();
				$id_lang             = $this->context->employee->id_lang;
				$id                  = Tools::getValue('id');
				$currentindex        = $currentIndex;
				
				$req_border_color        = Configuration::get('req-border-color');
				$req_heading_font_family = Configuration::get('req-heading-font-family');
				$req_heading_color       = Configuration::get('req-heading-color');
				$req_heading_size        = Configuration::get('req-heading-size');
				$req_text_font_family    = Configuration::get('req-text-font-family');
				$req_text_color          = Configuration::get('req-text-color');
				$req_text_size           = Configuration::get('req-text-size');
				
				$this->context->smarty->assign("req_border_color", $req_border_color);
				$this->context->smarty->assign("req_heading_font_family", $req_heading_font_family);
				$this->context->smarty->assign("req_heading_color", $req_heading_color);
				$this->context->smarty->assign("req_heading_size", $req_heading_size);
				$this->context->smarty->assign("req_text_font_family", $req_text_font_family);
				$this->context->smarty->assign("req_text_color", $req_text_color);
				$this->context->smarty->assign("req_text_size", $req_text_size);
				
				$market_place_seller_id = Tools::getValue('id');
				$selle_info = new SellerInfoDetail();
				$market_place_seller_info = $selle_info->sellerDetail($market_place_seller_id);
				$smarty->assign('market_place_seller_info',$market_place_seller_info);
				$this->context->smarty->assign('set','0');
				$this->context->smarty->assign('market_place_seller_id',$market_place_seller_info['id']);
				$this->context->smarty->assign('shop_name',$market_place_seller_info['shop_name']);
				$this->context->smarty->assign('business_email',$market_place_seller_info['business_email']);
				$this->context->smarty->assign('phone',$market_place_seller_info['phone']);
				$this->context->smarty->assign('seller_name',$market_place_seller_info['seller_name']);
				$this->context->smarty->assign('fax',$market_place_seller_info['fax']);
				$this->context->smarty->assign('address',$market_place_seller_info['address']);
				$this->context->smarty->assign('about_shop',$market_place_seller_info['about_shop']);
				$this->context->smarty->assign('facebook_id',$market_place_seller_info['facebook_id']);
				$this->context->smarty->assign('twitter_id',$market_place_seller_info['twitter_id']);
				
			}
			parent::postProcess();

		}

		public function renderForm() {
			
			$req_border_color        = Configuration::get('req-border-color');
			$req_heading_font_family = Configuration::get('req-heading-font-family');
			$req_heading_color       = Configuration::get('req-heading-color');
			$req_heading_size        = Configuration::get('req-heading-size');
			$req_text_font_family    = Configuration::get('req-text-font-family');
			$req_text_color          = Configuration::get('req-text-color');
			$req_text_size           = Configuration::get('req-text-size');
			
			$this->context->smarty->assign("req_border_color", $req_border_color);
			$this->context->smarty->assign("req_heading_font_family", $req_heading_font_family);
			$this->context->smarty->assign("req_heading_color", $req_heading_color);
			$this->context->smarty->assign("req_heading_size", $req_heading_size);
			$this->context->smarty->assign("req_text_font_family", $req_text_font_family);
			$this->context->smarty->assign("req_text_color", $req_text_color);
			$this->context->smarty->assign("req_text_size", $req_text_size);
				
				
			if($this->display == 'add')	{
				$customer_info =Db::getInstance()->executeS("SELECT cus.`id_customer`,cus.`email` FROM `"._DB_PREFIX_."customer` cus LEFT OUTER JOIN `"._DB_PREFIX_."marketplace_customer` mcus ON ( cus.id_customer = mcus.id_customer ) WHERE mcus.id_customer IS NULL");
				$this->context->smarty->assign('set','1');
				$this->context->smarty->assign('customer_info',$customer_info);
					$this->tpl_form_vars = array(
										'add' => 1
											);
			
				$this->fields_form = array(

					'submit' => array(
					'title' => $this->l('    Save   '),
					'class' => 'button'
					)
				);
			} else if($this->display == 'edit') {
				
				$market_place_seller_id = Tools::getValue('id');
				$selle_info = new SellerInfoDetail();
				$market_place_seller_info = $selle_info->sellerDetail($market_place_seller_id);
				
				$this->context->smarty->assign('set','0');
				$this->context->smarty->assign('market_place_seller_id',$market_place_seller_info['id']);
				$this->context->smarty->assign('shop_name',$market_place_seller_info['shop_name']);
				$this->context->smarty->assign('business_email',$market_place_seller_info['business_email']);
				$this->context->smarty->assign('phone',$market_place_seller_info['phone']);
				$this->context->smarty->assign('seller_name',$market_place_seller_info['seller_name']);
				$this->context->smarty->assign('fax',$market_place_seller_info['fax']);
				$this->context->smarty->assign('address',$market_place_seller_info['address']);
				$this->context->smarty->assign('about_shop',$market_place_seller_info['about_shop']);
				$this->context->smarty->assign('facebook_id',$market_place_seller_info['facebook_id']);
				$this->context->smarty->assign('twitter_id',$market_place_seller_info['twitter_id']);
				
				//For default image 
					
					$shopimage = $market_place_seller_info['id']."-".$market_place_seller_info['shop_name'].".jpg";
					$dirshop = _PS_MODULE_DIR_.'marketplace/img/shop_img/'.$shopimage;
					$sellerimage = $market_place_seller_info['id'].".jpg";
					$dirseller = _PS_MODULE_DIR_.'marketplace/img/seller_img/'.$sellerimage;
		
					if(file_exists($dirshop))
						$shopimagepath = _MODULE_DIR_. 'marketplace/img/shop_img/'.$shopimage;
					else
						$shopimagepath = _MODULE_DIR_. 'marketplace/img/shop_img/defaultimage.jpg';
					
					
					if(file_exists($dirseller))
						$sellerimagepath = _MODULE_DIR_. 'marketplace/img/seller_img/'.$sellerimage;
					else
						$sellerimagepath = _MODULE_DIR_. 'marketplace/img/seller_img/defaultimage.jpg';	
						
						
					$this->context->smarty->assign('shopimagepath',$shopimagepath);	
					$this->context->smarty->assign('sellerimagepath',$sellerimagepath);	
					//------
				
				$this->tpl_form_vars = array(
										'add' => 0
											);
				$this->fields_form = array(
					'legend' => array(
						'title' =>	$this->l('Edit Shop'),
						),
					
					'submit' => array(
						'title' => $this->l('   Save   '),
						'class' => 'button'
					)
				);
			}
			return parent::renderForm();
		}
		
		
		public function processSave() {
			//set==1 for add new
			//set == 0 for edit existing shop
			global $currentIndex;
			$currentindex = $currentIndex;
			
			$is_proceess = Tools::getValue('set');
			
			$shop_name = Tools::getValue('shop_name');
			$about_business = Tools::getValue('about_business');
			if($about_business=='') {
				$about_business = '';
			}
			$person_name = Tools::getValue('person_name');
			$phone = Tools::getValue('phone');
			$fax = Tools::getValue('fax');
			
			if(!$fax) {
				$fax='';
			}
			$business_email_id = Tools::getValue('business_email_id');
			if(!$business_email_id) {
				$business_email_id = '';
			}
			$address = Tools::getValue('address');
			if(!$address) {
				$address = '';
			}
			$fb_id = Tools::getValue('fb_id');
			
			if(!$fb_id) {
				$fb_id='';
			}
			$tw_id = Tools::getValue('tw_id');
			if(!$tw_id) {
				$tw_id='';
			}
			
			if($shop_name=='') {
					$this->errors[] = Tools::displayError('Shop name is requried field.');
				}
				
			if($person_name=='') {
				$this->errors[] = Tools::displayError('Seller name is requried field.');
			}
			
			if($phone=='') {
				$this->errors[] = Tools::displayError('Phone is requried field and must be numeric.');
			} else {
					if(!is_numeric($phone)) {
					$this->errors[] = Tools::displayError('Phone must be numeric.');
				}
			}
			
			if($is_proceess==1) {
				if (empty($this->errors)) {	
					$customer_id = Tools::getValue('shop_customer');
					
					$date_add  = date("y-m-d");
					
					// $result = Db::getInstance()->insert('marketplace_seller_info', array(
															// 'date_add' => pSQL($date_add),
															// 'business_email' => pSQL($business_email_id),
															// 'shop_name' => pSQL($shop_name),
															// 'seller_name' => pSQL($person_name),
															// 'phone' => (int) $phone,
															// 'address' => pSQL($address),
															// 'about_shop' => pSQL(trim($about_business)),
															// 'fax' => (int)$fax,
															// 'facebook_id' => pSQL($fb_id),
															// 'twitter_id' => pSQL($tw_id)
														// ));
					$obj_seller_info = new SellerInfoDetail();
					$obj_seller_info->business_email = $business_email_id;
					$obj_seller_info->seller_name = $person_name;
					$obj_seller_info->shop_name = $shop_name;
					$obj_seller_info->phone = $phone;
					$obj_seller_info->fax = $fax;
					$obj_seller_info->address = $address;
					$obj_seller_info->address = $address;
					$obj_seller_info->about_shop = $about_business;
					$obj_seller_info->facebook_id = $fb_id;
					$obj_seller_info->twitter_id = $tw_id;
					
					$marketplace_seller_id = $obj_seller_info->save();
					//var_dump($marketplace_seller_id);
					//die();
					 $result1               = Db::getInstance()->insert('marketplace_customer', array(
																			'marketplace_seller_id' => (int) $marketplace_seller_id,
																			'id_customer' => (int) $customer_id
																		));		
					
					if($_FILES['upload_logo']) {
						 if ($_FILES['upload_logo']['error'] > 0) {
							
						 } else {
							$validExtensions = array('.jpg','.jpeg','.gif','.png');
							$image_name            = $shop_name. ".jpg";
							
							$fileExtension   = strrchr($_FILES['upload_logo']['name'], ".");
							if (in_array($fileExtension, $validExtensions)) {
								
								$newNamePrefix = time() . '_';
								
								$manipulator   = new ImageManipulator($_FILES['upload_logo']['tmp_name']);
								$newImage      = $manipulator->resample(100, 100);
								
								$is_save = $manipulator->save(_PS_MODULE_DIR_.'marketplace/img/shop_img/'.$marketplace_seller_id.'-'. $image_name);
							}
						}
					}
					if($_FILES['upload_seller_logo']) 
					{
						
						if (!$_FILES['upload_seller_logo']['error'] > 0) 
						{
							$validExtensions = array('.jpg','.jpeg','.gif','.png');
							$image_name   = $marketplace_seller_id.".jpg";
							$fileExtension   = strrchr($_FILES['upload_seller_logo']['name'], ".");
							
							if (in_array($fileExtension, $validExtensions)) 
							{
								$dir = _PS_MODULE_DIR_.'marketplace/img/seller_img/';
								
								$newNamePrefix = time() . '_';
								
								$manipulator   = new ImageManipulator($_FILES['upload_seller_logo']['tmp_name']);
								$newImage      = $manipulator->resample(200, 200);
								
								$is_save = $manipulator->save($dir.$image_name);
								
								
							}
						}
						
					}
					Hook::exec('actionAddshopExtrafield', array('marketplace_seller_id' => $marketplace_seller_id));
          			//Tools::redirectAdmin($currentIndex.'&conf=4&token='.$this->token);
					
				} else {
					$this->display = 'add';
				}
			} else {
				if (empty($this->errors)) {
					$seller_id = Tools::getValue('market_place_seller_id');
					$obj_seller_info = new SellerInfoDetail($seller_id);
					$obj_seller_info->business_email = $business_email_id;
					$obj_seller_info->seller_name = $person_name;
					$obj_seller_info->shop_name = $shop_name;
					$obj_seller_info->phone = $phone;
					$obj_seller_info->fax = $fax;
					$obj_seller_info->address = $address;
					$obj_seller_info->address = $address;
					$obj_seller_info->about_shop = $about_business;
					$obj_seller_info->facebook_id = $fb_id;
					$obj_seller_info->twitter_id = $tw_id;
					
					$marketplace_seller_id = $obj_seller_info->save();
					// $result = Db::getInstance()->update('marketplace_seller_info', array(
					// 										'business_email' => pSQL($business_email_id),
					// 										'shop_name' => pSQL($shop_name),
					// 										'seller_name' => pSQL($person_name),
					// 										'phone' => (int) $phone,
					// 										'address' => pSQL($address),
					// 										'about_shop' => pSQL(trim($about_business)),
					// 										'fax' => (int)$fax,
					// 										'facebook_id' => pSQL($fb_id),
					// 										'twitter_id' => pSQL($tw_id)
					// 									),'id='.$seller_id);
					
					if($_FILES['upload_logo']) {
						
						if ($_FILES['upload_logo']['error'] > 0) {
							$pre_shop_name = Tools::getValue('pre_shop_name');
							if($pre_shop_name!=$shop_name) {
								$new_image_name = $seller_id.'-'.$shop_name.".jpg";
								$old_image_name = $seller_id.'-'.$pre_shop_name.".jpg";
								$dir = _PS_MODULE_DIR_.'marketplace/img/shop_img/';
								$rename = rename($dir.$old_image_name,$dir.$new_image_name);
							}
						} else {
							$validExtensions = array('.jpg','.jpeg','.gif','.png');
							$image_name   = $seller_id.'-'.$shop_name.".jpg";
							
							$fileExtension   = strrchr($_FILES['upload_logo']['name'], ".");
							if (in_array($fileExtension, $validExtensions)) {
								$dir = _PS_MODULE_DIR_.'/marketplace/img/shop_img/';
								$pre_shop_name = Tools::getValue('pre_shop_name');
								
								$old_image_name = $seller_id.'-'.$pre_shop_name.".jpg";
								if(file_exists($dir.$old_image_name))
								 unlink($dir.$old_image_name);
								
								$newNamePrefix = time() . '_';
								
								$manipulator   = new ImageManipulator($_FILES['upload_logo']['tmp_name']);
								$newImage      = $manipulator->resample(100, 100);
								
								$is_save = $manipulator->save($dir.$image_name);
								
								
							}
						}
					} 
						if($_FILES['upload_seller_logo']) 
					{
						
						if (!$_FILES['upload_seller_logo']['error'] > 0) 
						{
							$validExtensions = array('.jpg','.jpeg','.gif','.png');
							$image_name   = $seller_id.".jpg";
							$fileExtension   = strrchr($_FILES['upload_seller_logo']['name'], ".");
							
							if (in_array($fileExtension, $validExtensions)) 
							{
								$dir = _PS_MODULE_DIR_.'/marketplace/img/seller_img/';
								
								$newNamePrefix = time() . '_';
								
								$manipulator   = new ImageManipulator($_FILES['upload_seller_logo']['tmp_name']);
								$newImage      = $manipulator->resample(200, 200);
								
								$is_save = $manipulator->save($dir.$image_name);
								
								
							}
						}
						
					}
					Hook::exec('actionUpdateshopExtrafield', array('marketplace_seller_id' =>$seller_id));
					Tools::redirectAdmin($currentIndex.'&conf=4&token='.$this->token);
				} else {
					$this->display = 'edit';	
				}
			}
			
		}
		public function confirm_seller_patner($id,$currentindex,$token)
		
		{
		echo '
						 <script type="text/javascript">
						var con = confirm("Are You Sure");
						var id = '.$id.';
						var token ="'.$token.'";
						var currentindex = "'.$currentindex.'";
						if(con == false)
						{
						alert("You Cancelled");
						}
						else if(con == true )
						{
						var url=currentindex+"&vab=Arraymarketplace_seller_info1&token="+token+"&id="+id;
						window.location.href = url;
						}
						</script>';				
		
		}
				

		public function make_seller_patner() {

			$id = Tools::getValue('id');

			$market_place_seller_active = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("SELECT * from`"._DB_PREFIX_."marketplace_customer` where `marketplace_seller_id`=".$id);

			if($market_place_seller_active) {

				$is_seller = $market_place_seller_active['is_seller'];

				//market place customer id is orginal cutomer id from custmer table

				$market_place_cutomer_id = $market_place_seller_active['id_customer'];

				if($is_seller==0) {

					$is_update = Db::getInstance()->update('marketplace_customer', array('is_seller' =>1),'marketplace_seller_id='.$id);

					$market_place_seller_info = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("SELECT * from`"._DB_PREFIX_."marketplace_seller_info` where `id`=".$id);

					if($is_update) {

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

							if($is_inserted_shop_name)	{

								Hook::exec('actionActiveSellerPlan', array('mp_id_seller' => Tools::getValue('id')));
								
								$obj_seller_info = new SellerInfoDetail();
								$obj_seller_info->callMailFunction(Tools::getValue('id'),'Approve seller request',1,$this->context->employee->email,$this->context->shop->id);
								$redirect = self::$currentIndex.'&conf=5&token='.$this->token;

								$this->redirect_after = $redirect;

							} else {

								$is_update = Db::getInstance()->update('marketplace_customer', array('is_seller' =>0),'marketplace_seller_id='.$id);

								Tools::displayError($this->l('Some error occurs'));

							}

						}

					}

					else

						Tools::displayError($this->l('Some error occurs'));



				} else {

					$is_update = Db::getInstance()->update('marketplace_customer', array('is_seller' =>0),'marketplace_seller_id='.$id);

					if($is_update) {
						$obj_seller_info = new SellerInfoDetail();
						$obj_seller_info->callMailFunction(Tools::getValue('id'),'Approve seller request',2,$this->context->employee->email,$this->context->shop->id);
						
						$is_shop_active = Db::getInstance()->update('marketplace_shop', array('is_active' =>0),'id_customer='.$market_place_cutomer_id);

						$is_shop_created = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("SELECT * from`"._DB_PREFIX_."marketplace_shop` where `id_customer`=".$market_place_cutomer_id);

						

						$market_place_shop_id = $is_shop_created['id'];

						$update_marketplace_seller_product = Db::getInstance()->update('marketplace_seller_product', array('active' =>0),'id_shop='.$market_place_shop_id);

						

						$total_product_detail = Db::getInstance()->executeS("select `id_product` from `"._DB_PREFIX_."marketplace_shop_product` where `id_shop`=$market_place_shop_id");

						if($total_product_detail) {

							foreach($total_product_detail as $total_product_detail1) {

								$is_product_present = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("SELECT * from`"._DB_PREFIX_."product` where `id_product`=".$total_product_detail1['id_product']);

								if($is_product_present) {

									$is_inserted_shop_name = Db::getInstance()->update('product', array('active' =>0),'id_product='.$total_product_detail1['id_product']);

								} 

							}

							$redirect = self::$currentIndex.'&conf=5&token='.$this->token;

							$this->redirect_after = $redirect;

						} else {

							//Tools::displayError($this->l('Some error occurs'));

							//$this->displayInformation($this->l('Disable sucessfully'));

							$redirect = self::$currentIndex.'&conf=5&token='.$this->token;

							$this->redirect_after = $redirect;

						}

						

					} else

						Tools::displayError($this->l('Some error occurs'));

					//$this->errors[] = Tools::displayError($this->l('Error Message(s):' . $check['error_message']));



				}

			} else {

				Tools::displayError($this->l('Some error occurs'));

			}

		}

		public function delete_seller_info($id) {
		global $currentIndex;

			//$id = (int)Tools::getValue('id');

			$delete_row_from_marketplace_seller_info = Db::getInstance()->delete('marketplace_seller_info','id='.$id);

			//find id_customer 

			$id_customer_value = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("SELECT * from`"._DB_PREFIX_."marketplace_customer` where `marketplace_seller_id`=".$id);

			//real customer id present in customer table

			$market_place_cutomer_id = $id_customer_value['id_customer'];

			//delete data form marketplace customer

			$delete_row_from_marketplace_customer = Db::getInstance()->delete('marketplace_customer','marketplace_seller_id='.$id);

			//find shop id for that seller

			$id_shop_value = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("SELECT * from`"._DB_PREFIX_."marketplace_shop` where `id_customer`=".$market_place_cutomer_id);

			if($id_shop_value) {

				$market_place_shop_id = $id_shop_value['id'];

				$delete_row_from_marketplace_shop = Db::getInstance()->delete('marketplace_shop','id_customer='.$market_place_cutomer_id);

			

				//find product id for that seller

				$total_product_detail = Db::getInstance()->executeS("select `id_product` from `"._DB_PREFIX_."marketplace_shop_product` where `id_shop`=$market_place_shop_id");

				if($total_product_detail) {

					//delete all entry from main table provided by prestashop

					foreach($total_product_detail as $total_product_detail1) {

						$is_product_present = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("SELECT * from`"._DB_PREFIX_."product` where `id_product`=".$total_product_detail1['id_product']);

						if($is_product_present) {

							$delete_row_from_product = Db::getInstance()->delete('product','id_product='.$total_product_detail1['id_product']);

							$delete_row_from_product_attachment = Db::getInstance()->delete('product_attachment','id_product='.$total_product_detail1['id_product']);

							$delete_row_from_product_attribute = Db::getInstance()->delete('product_attribute','id_product='.$total_product_detail1['id_product']);

							$delete_row_from_product_carrier = Db::getInstance()->delete('product_carrier','id_product='.$total_product_detail1['id_product']);

							$delete_row_from_product_country_tax = Db::getInstance()->delete('product_country_tax','id_product='.$total_product_detail1['id_product']);

							$delete_row_from_product_download = Db::getInstance()->delete('product_download','id_product='.$total_product_detail1['id_product']);

							$product_group_reduction_cache = Db::getInstance()->delete('product_group_reduction_cache','id_product='.$total_product_detail1['id_product']);

							$delete_row_from_product_lang = Db::getInstance()->delete('product_lang','id_product='.$total_product_detail1['id_product']);

							$delete_row_from_product_sale = Db::getInstance()->delete('product_sale','id_product='.$total_product_detail1['id_product']);

							$delete_row_from_product_shop = Db::getInstance()->delete('product_shop','id_product='.$total_product_detail1['id_product']);

							$delete_row_from_product_supplier = Db::getInstance()->delete('product_supplier','id_product='.$total_product_detail1['id_product']);

							$delete_row_from_product_tag = Db::getInstance()->delete('product_tag','id_product='.$total_product_detail1['id_product']);

							$delete_row_from_category_product = Db::getInstance()->delete('category_product','id_product='.$total_product_detail1['id_product']);

							$delete_row_from_stock_available = Db::getInstance()->delete('stock_available','id_product='.$total_product_detail1['id_product']);

							$delete_row_from_image_lang = "DELETE FROM t2 USING `"._DB_PREFIX_."image`  t1 INNER JOIN `"._DB_PREFIX_."image_lang` t2 WHERE t1.`id_product`=".$total_product_detail1['id_product']." AND t1.`id_image`=t2.`id_image`";

							$delete = Db::getInstance()->Execute($delete_row_from_image_lang);	

						

							$delete_row_from_category_product = Db::getInstance()->delete('image','id_product='.$total_product_detail1['id_product']);

						} 

					}

				}

				//delete data from market place shop product

				$delete_row_from_marketplace_shop_product = Db::getInstance()->delete('marketplace_shop_product','id_shop='.$market_place_shop_id);

			

				//delete row from market place seller product

				$delete_row_from_marketplace_product_image = "DELETE FROM t2 USING `"._DB_PREFIX_."marketplace_seller_product`  t1 INNER JOIN `"._DB_PREFIX_."marketplace_product_image` t2 WHERE t1.`id_seller`=$id AND t1.`id`=t2.`seller_product_id`";

				$delete = Db::getInstance()->Execute($delete_row_from_marketplace_product_image);	

				$delete_row_from_marketplace_customer = Db::getInstance()->delete('marketplace_seller_product','id_shop='.$market_place_shop_id);

			}

			Tools::redirectAdmin($currentIndex.'&conf=1&token='.$this->token);

			

		}

		public function deleteSelection($data) {

			 $return = 1;

			if (is_array($data) && ($count = count($data))) {

				//Deleting data

				foreach ($data as $id) {

					//$return = Db::getInstance()->delete('erp_shop_merge', 'id = ' . (int) $id_data);

					$this->delete_seller_info((int)$id);

				}

			}

			return $return;

		}

	}

?>