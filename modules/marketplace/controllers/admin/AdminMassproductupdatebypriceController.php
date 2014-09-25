<?php
include_once dirname(__FILE__).'/../../classes/Massupdateoption.php';
class AdminMassproductupdatebypriceController extends ModuleAdminController
{
	public function __construct()
	{
		$this->table = 'massupdateoption';
		$this->className = 'Massupdateoption';
		$this->context     = Context::getContext();
		$this->addRowAction('edit');
		$this->addRowAction('delete');
		$this->addRowAction('view');
		$this->explicitSelect = true;
		$obj_massupdate = new Massupdateoption();
		$massupdate_id = $obj_massupdate->findAllIdExceptLastDetail();
		$massupdate_maxid = $obj_massupdate->findMaximumId();
		if($massupdate_maxid) {
			$is_revert_back = $obj_massupdate->isRevertBack($massupdate_maxid);
			if(!$is_revert_back)
				$this->addRowActionSkipList('delete',$massupdate_maxid);
		}
		if($massupdate_id) {
			foreach($massupdate_id as $massipdate) {
				$skip_row[] = $massipdate['id'];
			}
			if($is_revert_back)
				$skip_row[] = $massupdate_maxid;
			$this->addRowActionSkipList('edit',$skip_row);
		}
		$this->_select .= "sp.name as `name`,(CASE a.`mass_price_update_on` WHEN 0 THEN 'ALL PRODUCT' ELSE 'BY CATEGORY' END) as mass_price_update_on_lang,(CASE a.`mass_price_update_type` WHEN 0 THEN 'Percentage' ELSE 'FIXED' END) as mass_price_update_type_lang";
		$this->fields_list = array(
				'id' => array(
					'title' => $this->l('Id') ,
					'align' => 'center',
					'width'=> 25
				),
				'name' => array(
					'title' => $this->l('Shop Name') ,
					'align' => 'center',
					'width'=> 25
				),
				'mass_price_update_on_lang' => array(
					'title' => $this->l('Price Update ON') ,
					'align' => 'center',
					'width'=> 25
				),
				'mass_price_update_type_lang' => array(
					'title' => $this->l('Mass Price Update Type') ,
					'align' => 'center',
					'width'=> 25
				),
				'mass_price_update_value' => array(
					'title' => $this->l('Value') ,
					'align' => 'center',
					'width'=> 25
				),
			);
		$this->identifier = 'id';
		$this->_join .='LEFT Join `'._DB_PREFIX_.'shop` sp ON (a.`id_shop`=sp.`id_shop`)';
		
		parent::__construct();
		if (!$this->module->active)
			Tools::redirectAdmin($this->context->link->getAdminLink('AdminHome'));
	}
	
		
	public function setMedia()
	{
		$this->addCSS(array('/modules/productmassupdate/views/css/style.css')); 
		$this->addJS(array('/modules/productmassupdate/views/js/fieldform.js')); 
		return parent::setMedia();
	}
	
	public function renderForm() {
			$root = Category::getRootCategory();
			$tab_root = array('id_category' => $root->id, 'name' => $root->name);
			$helper = new Helper();
			$category_tree = $helper->renderCategoryTree();
			
			
		if($this->display == 'add')	{
			$this->context->smarty->assign('set','1');
			$this->context->smarty->assign('category_tree',$category_tree);
			$this->fields_form = array(
						 'submit' => array(
						 'title' => $this->l('    Save   '),
						 'class' => 'button'
						 )
					);
		} else {
			$this->context->smarty->assign('set','0');
			$id = Tools::getValue('id');
			$obj_massupdate = new Massupdateoption();
			$obj_massupdate->id = $id;
			$row_detail = $obj_massupdate->findMassUpdateDeatailById();
			$id_lang = $this->context->language->id;
			if($row_detail) {
				if($row_detail['mass_price_update_on']==0) {
					$mass_price_update_on_lang = 'All Product';
				} else {
					$mass_price_update_on_lang = 'Update by category';
				}
				if($row_detail['mass_price_update_type']==0) {
					$mass_price_update_type_lang = 'Percentage';
				} else {
					$mass_price_update_type_lang = 'Fixed';
				}
				
				if($row_detail['mass_price_update_on']==1) {
					//category id
					$category_info = $obj_massupdate->findCategoryIdInfo($id_lang,$row_detail['id_shop']);
				} else {
					$category_info = '-1';
					
				}
				$mass_price_update_value = $row_detail['mass_price_update_value'];
				$mass_update_id = $row_detail['id'];
			} else {
				$category_info = '-1';
				$cat_asso = '';
				$mass_price_update_on_lang = 'N/A';
				$mass_price_update_type_lang = 'N/A';
				$mass_price_update_value = 'N/A';
				$mass_update_id = $id;
			}
			
			$this->context->smarty->assign('mass_price_update_on_lang',$mass_price_update_on_lang);
			$this->context->smarty->assign('mass_price_update_type_lang',$mass_price_update_type_lang);
			$this->context->smarty->assign('mass_price_update_value',$mass_price_update_value);
			$this->context->smarty->assign('category_info',$category_info);
			$this->context->smarty->assign('id',$mass_update_id);
			$this->fields_form = array(
						 'submit' => array(
						 'title' => $this->l('    Update   '),
						 'class' => 'button'
						 )
					);
		}
		return parent::renderForm();
	}
	
	
	public function initToolBar()
	{
		parent::initToolBar();
		unset($this->toolbar_btn['save']);
	}
	
	public function postProcess() {
		if(Tools::isSubmit('submitAddmassupdateoption')) {
			$this->processAdd();
		}
		
		if ($this->tabAccess['delete'] && Tools::isSubmit('deletemassupdateoption')) {
			$this->processDelete();
		}
	}
	public function processAdd() {
		$id_shop = $this->context->shop->id;
		if(Tools::getValue('set') == 1) {
			$mass_price_update_on = Tools::getValue('mass_price_update_on');
			$mass_price_update_type = Tools::getValue('mass_price_update_type');
			$mass_price_update_value = Tools::getValue('mass_price_update_value');
			
			if($mass_price_update_on==1) {
				if(!isset($_POST['categoryBox'])) {
					$this->errors[] = Tools::displayError($this->l('Choose At Least One Category'));
				}
			}
			if($mass_price_update_value=='') {
				$this->errors[] = Tools::displayError('Mass Price Update Value Is Mandatory Field And Should be Numeric');
			}
			$obj_mass_update = new Massupdateoption();
			if(Tools::getValue('set') == 1) {
				
				if (empty($this->errors)) {
					$is_inserted = $obj_mass_update->insertMassupdateoption($mass_price_update_on,$mass_price_update_type,$mass_price_update_value,$id_shop);
					
					if($is_inserted) {
						if($mass_price_update_on==1) {
							//category product
							foreach($_POST['categoryBox'] as $id_cat) {
								$prodct_info = $obj_mass_update->findProductIdByCategory($id_cat);
								$insert_into_catasso = $obj_mass_update->insertMassUpdateCategoryAssociation($is_inserted,$id_cat);
								foreach($prodct_info as $pro_in) {
									$is_update = $obj_mass_update->updatePrice($pro_in['id_product'],$pro_in['price'],$mass_price_update_type,$mass_price_update_value);
								}
							}
						} else {
							//all product
							$prodct_info = $obj_mass_update->findAllProductId();
							
							$i=0;
							foreach($prodct_info as $pro_in) {
								$is_update = $obj_mass_update->updatePrice($pro_in['id_product'],$pro_in['price'],$mass_price_update_type,$mass_price_update_value);
								$i++;
							}
						}
						$redirect = self::$currentIndex.'&conf=4&token='.$this->token;
						$this->redirect_after = $redirect;
					} else {
						$this->errors[] = Tools::displayError('Database write error occurs please try again after some time.');
						$this->display = 'add';
					}
				} else {
					$this->display = 'add';
				}
			}		
		} else {
			$id = Tools::getValue('id');
			$obj_mass_update = new Massupdateoption();
			$obj_mass_update->id = $id;
			$row_detail = $obj_mass_update->findMassUpdateDeatailById();
			$mass_price_update_type = $row_detail['mass_price_update_type'];
			$mass_price_update_value = $row_detail['mass_price_update_value'];
			$id_lang = $this->context->language->id;
			if($row_detail['mass_price_update_on']==1) {
				//for category
				$cat_info = $obj_mass_update->findCategoryIdOfMassUpdate();
				foreach($cat_info as $cat_in) {
					$prodct_info = $obj_mass_update->findProductIdByCategory($cat_in['id_category']);
					foreach($prodct_info as $pro_in) {
						$is_update = $obj_mass_update->revertPrice($pro_in['id_product'],$pro_in['price'],$mass_price_update_type,$mass_price_update_value);
					}
				}
			} else {
				//for all product
				$prodct_info = $obj_mass_update->findAllProductId();
				foreach($prodct_info as $pro_in) {
					$is_update = $obj_mass_update->revertPrice($pro_in['id_product'],$pro_in['price'],$mass_price_update_type,$mass_price_update_value);
				}
			}
			$is_revert = $obj_mass_update->updateIsRevert($id,1);
			$redirect = self::$currentIndex.'&conf=4&token='.$this->token;
			$this->redirect_after = $redirect;
		}
	}
	public function renderView()
	{
		$id = Tools::getValue('id');
		$obj_massupdate = new Massupdateoption();
		$obj_massupdate->id = $id;
		$row_detail = $obj_massupdate->findMassUpdateDeatailById();
		$id_lang = $this->context->language->id;
		if($row_detail) {
			if($row_detail['mass_price_update_on']==0) {
				$mass_price_update_on_lang = 'All Product';
			} else {
				$mass_price_update_on_lang = 'Update by category';
			}
			if($row_detail['mass_price_update_type']==0) {
				$mass_price_update_type_lang = 'Percentage';
			} else {
				$mass_price_update_type_lang = 'Fixed';
			}
			if($row_detail['is_revert_back']==0) {
				$is_revert_back = "No";
				$revert_back_date = "N/A";
			} else {
				$is_revert_back = "Yes";
				$revert_back_date = $row_detail['revert_back'];
			}
			
			
			if($row_detail['mass_price_update_on']==1) {
				//category id
				$cat_asso = $obj_massupdate->findCategoryIdInfo($id_lang,$row_detail['id_shop']);
				
				$this->tpl_view_vars = array(
					'mass_price_update_on_lang' => $mass_price_update_on_lang,
					'mass_price_update_type_lang' => $mass_price_update_type_lang,
					'mass_price_update_value' => $row_detail['mass_price_update_value'],
					'update_on' => $row_detail['update_on'],
					'is_revert_back' => $is_revert_back,
					'revert_back_date' => $revert_back_date,
					'category_info'=>$cat_asso,
				);
			} else {
				$this->tpl_view_vars = array(
					'mass_price_update_on_lang' => $mass_price_update_on_lang,
					'mass_price_update_type_lang' => $mass_price_update_type_lang,
					'mass_price_update_value' => $row_detail['mass_price_update_value'],
					'update_on' => $row_detail['update_on'],
					'is_revert_back' => $is_revert_back,
					'revert_back_date' => $revert_back_date,
					'category_info'=>'-1',
				);
			}
		}
		 return parent::renderView();
	}
	public function processDelete() {
		$id = Tools::getValue('id');
		
		$obj_massupdate = new Massupdateoption();
		$obj_massupdate->id = $id;
		$row_detail = $obj_massupdate->findMassUpdateDeatailById();
		if($row_detail) {
			if($row_detail['mass_price_update_on']==1) {
				$cat_asso = $obj_massupdate->findCategoryIdOfMassUpdate();
				if($cat_asso) {
					$del_asso = $obj_massupdate->dleteCategoryAssociation($id);
					if($del_asso) {
						$dele_massupdate = $obj_massupdate->deleteMassupdateoption();
					} else {
						//error
					}
				} else {
					$dele_massupdate = $obj_massupdate->deleteMassupdateoption();
				}
			} else {
				$dele_massupdate = $obj_massupdate->deleteMassupdateoption();
			}
		} else {
			//no data exist
		}
		
		 Tools::redirectAdmin($currentIndex.'index.php?controller=AdminMassproductupdatebyprice&conf=1&token='.$this->token);		
	}
}
