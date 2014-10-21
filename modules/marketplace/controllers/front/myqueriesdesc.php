<?php
include_once 'modules/marketplace/get_info.php';
class marketplacemyqueriesdescModuleFrontController extends ModuleFrontController
{

	public function initContent()
    {
	
		global $smarty;
        parent::initContent();
        $link     = new link();
		$my_queries_link = $link->getModuleLink('marketplace','myqueries');
		$customer_id= $this->context->cookie->id_customer;
	    $id_lang = $this->context->cookie->id_lang;
		$id = $_GET['id'];
		
		$obj = new get_info();
		$query = $obj->get_query($id);
		$product_name = $obj->product_name($query['id_product'],$id_lang);
		$query_records = $obj->query_replies($id);
		$count = count($query_records);
		
		$query_info = Db::getInstance()->getRow('select * from `'._DB_PREFIX_ .'customer_query` where `id`='.$id.'' );
		
        
		$smarty->assign("seller_customer_id", $query_info['id_customer_to']);
		$smarty->assign("my_id", $customer_id);
		$smarty->assign("count", $count);
		
		$smarty->assign("query_id", $id);
		$smarty->assign("query_records", $query_records);
		$smarty->assign("product_name", $product_name);
		$smarty->assign("title", $query['title']);
		$smarty->assign("description", $query['description']);
		$smarty->assign("my_queries_link", $my_queries_link);
		
		
		$this->setTemplate('my_enquiry_desc.tpl');
	
	}
	
	public function setMedia()
    {
	    parent::setMedia();
        $this->addCSS(_MODULE_DIR_.'marketplace/css/enq_desc.css');
    }
	
}

?>