<?php
class marketplacepaginationdataModuleFrontController extends ModuleFrontController{
	public function initContent(){
		 parent::initContent();
		 $per_page = 15;
		 $page = Tools::getValue('page');
		 $start = ($page-1)*$per_page;
	}	
}
?>