<?php
 class marketplacemyqueriesModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        global $smarty;
        parent::initContent();
        $link     = new link();
		$id_customer = $this->context->cookie->id_customer;
		$id_lang     = $this->context->cookie->id_lang;
		$info = Db::getInstance()->executeS("select * from `"._DB_PREFIX_."customer_query` where `id_customer`=".$id_customer."");
		if($info)
		{
			$i = 0;
			$product_info = array();
			foreach($info as $info_details)
				{
					$pd_name = Db::getInstance()->getRow("select * from `"._DB_PREFIX_."product_lang` where `id_product`=".$info_details['id_product']." and `id_lang`=".$id_lang."");
								
					$product_info[$i]['id'] = $info_details['id'];
					$product_info[$i]['product_name'] = $pd_name['name'];
					$product_info[$i]['title'] = $info_details['title'];
                    $product_info[$i]['date'] = $info_details['timestamp'];					
				
					$i++;
				
				}
		
		}
		$seller_id = Db::getInstance()->getRow("select * from `"._DB_PREFIX_."marketplace_customer` where `id_customer`=".$id_customer."");
		if($seller_id)
		{
			$smarty->assign("is_seller", 1);	
			$smarty->assign("seller_id",$seller_id['marketplace_seller_id']);
			$param = array('seller_id'=>$id_customer);
			$customer_queries = $link->getModuleLink('marketplace', 'customerqueries',$param);
			$smarty->assign("customer_queries",$customer_queries);
		}
        else
         $smarty->assign("is_seller", 0);		
		$count = count($product_info);
		$smarty->assign("count", $count);
		$smarty->assign("product_info", $product_info);	
		$this->setTemplate('my_queries.tpl');
	}
	public function setMedia()
    {
        parent::setMedia();	
		$this->addCSS(_MODULE_DIR_.'marketplace/css/my_request.css');
	}
}	
?>