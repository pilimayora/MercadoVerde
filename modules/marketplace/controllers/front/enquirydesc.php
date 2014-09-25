<?php
include_once 'modules/marketplace/get_info.php';
class marketplaceenquirydescModuleFrontController extends ModuleFrontController
{

	public function initContent()
    {
	
		global $smarty;
        parent::initContent();
        $link     = new link();
		$customer_id= $this->context->cookie->id_customer;
	    $id_lang = $this->context->cookie->id_lang;
		$id = $_GET['id'];
		
		$obj = new get_info();
		$query = $obj->get_query($id);
		$product_name = $obj->product_name($query['id_product'],$id_lang);
		$query_records = $obj->query_replies($id);
		$count = count($query_records);
		
		
		$smarty->assign("count", $count);
		$smarty->assign("query_records", $query_records);
		$smarty->assign("product_name", $product_name);
		$smarty->assign("title", $query['title']);
		$smarty->assign("description", $query['description']);
		
		
		$this->setTemplate('enquiry_desc.tpl');
	
	}
	
	public function setMedia()
    {
	    parent::setMedia();
        $this->addCSS(_MODULE_DIR_.'marketplace/css/enq_desc.css');
    }
	
}

?>