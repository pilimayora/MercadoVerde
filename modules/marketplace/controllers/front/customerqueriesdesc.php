<?php
include_once 'modules/marketplace/get_info.php';
class marketplacecustomerqueriesdescModuleFrontController extends ModuleFrontController
{

	public function initContent()
    {
	
		global $smarty;
        parent::initContent();
        $link     = new link();
		
		
		$customer_id= $this->context->cookie->id_customer;
		if($customer_id!='') {
			$param = array('seller_id'=>$customer_id);
			$customer_queries_link = $link->getModuleLink('marketplace','customerqueries',$param);
			
			$id_lang = $this->context->cookie->id_lang;
			$id = $_GET['id'];
			
			$obj = new get_info();
			$query = $obj->get_query($id);
			$product_name = $obj->product_name($query['id_product'],$id_lang);
			$query_records = $obj->query_replies($id);
			$count = count($query_records);
			
			$seller_id =  Db::getInstance()->getRow('select * from `'._DB_PREFIX_ .'marketplace_customer` where `id_customer`='.$customer_id.'' );
			 
			$query_info = Db::getInstance()->getRow('select * from `'._DB_PREFIX_ .'customer_query` where `id`='.$id.'' );
			
			
			$smarty->assign("seller_customer_id", $query_info['id_customer_to']);
			$smarty->assign("my_id", $customer_id);
			$smarty->assign("customer_id", $query_info['id_customer']);
			$smarty->assign("count", $count);
			
			$smarty->assign("query_id", $id);
			$smarty->assign("query_records", $query_records);
			$smarty->assign("product_name", $product_name);
			$smarty->assign("title", $query['title']);
			$smarty->assign("description", $query['description']);
			$smarty->assign("customer_queries_link", $customer_queries_link);
			
			
			$this->setTemplate('customer_enquiry_desc.tpl');
		}
	}
	
	public function setMedia()
    {
	    parent::setMedia();
        $this->addCSS(_MODULE_DIR_.'marketplace/css/enq_desc.css');
    }
	
}

?>