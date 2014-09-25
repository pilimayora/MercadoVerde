<?php
class AdminMetaController extends AdminMetaControllerCore
{
	public function addAllRouteFields()
	{
		$this->addFieldRoute('product_rule', $this->l('Route to products'));
		$this->addFieldRoute('category_rule', $this->l('Route to category'));
		$this->addFieldRoute('layered_rule', $this->l('Route to category with attribute selected_filter for the module block layered'));
		$this->addFieldRoute('supplier_rule', $this->l('Route to supplier'));
		$this->addFieldRoute('manufacturer_rule', $this->l('Route to manufacturer'));
		$this->addFieldRoute('cms_rule', $this->l('Route to CMS page'));
		$this->addFieldRoute('cms_category_rule', $this->l('Route to CMS category'));
		$this->addFieldRoute('module', $this->l('Route to modules'));
		$this->addFieldRoute('mp_shop_rule', $this->l('Route to Marketplace Shop'));
	}
}
?>