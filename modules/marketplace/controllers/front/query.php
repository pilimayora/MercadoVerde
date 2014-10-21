<?php
if (!defined('_PS_VERSION_'))
	exit;
class marketplacequeryModuleFrontController extends ModuleFrontController	
{
  public function initContent()
    {
        global $smarty;
        parent::initContent();
        $link     = new link();
		$param = array('flag'=>'1')
		$customer_queries_link = $link->getModuleLink('marketplace', 'customerqueries',$param);
		
		$id_lang     = $this->context->cookie->id_lang;
		$id_customer = $this->context->cookie->id_customer;
		
		$check_mkt_id = Db::getInstance()->getRow("select * from `"._DB_PREFIX_."marketplace_shop` where `id_customer`=".$id_customer."");
		if($check_mkt_id )
		 {
		   $seller_id = Db::getInstance()->getRow("select * from `"._DB_PREFIX_."marketplace_customer` where `id_customer`=".$id_customer."");
		   
		   $info = Db::getInstance()->executeS("select * from `"._DB_PREFIX_."customer_query` where `id_customer`=".$id_customer."");
		   
		  $smarty->assign("seller",1);
          $smarty->assign("seller_id",$seller_id['marketplace_seller_id']);		  
		 }
		else
         {
		   $info = Db::getInstance()->executeS("select * from `"._DB_PREFIX_."customer_query` where `id_customer`=".$id_customer."");
		   
		   $smarty->assign("seller",0); 
         }		
						  
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
   
                    if($info_details['id_customer'] == $id_customer)
                     $product_info[$i]['status'] = "My Query";
					else
                     $product_info[$i]['status'] = "Customers Query";					
				
					$i++;
				
				}
		
		}
		$count = count($product_info);
		$smarty->assign("count", $count);
		$smarty->assign("product_info", $product_info);	
		$smarty->assign("customer_queries_link", $customer_queries_link);	
		$this->setTemplate('product_queries.tpl');
		 
	}

    public function setMedia()
    {
        parent::setMedia();	
		$this->addCSS(_MODULE_DIR_.'marketplace/css/my_request.css');
	}	
}	
?>