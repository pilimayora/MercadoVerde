<?php
if (!defined('_PS_VERSION_'))
	exit;
class marketplaceallreviewsModuleFrontController extends ModuleFrontController	
{
 public function initContent() 
 {
	global $cookie;
	global $smarty;
	
	$seller_id = Tools::getValue('seller_id');
	$link = new link();
	
	$reviews_info = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("select * from `"._DB_PREFIX_."seller_reviews` where `id_seller` =".$seller_id." order by timestamp desc");
	if($reviews_info)
	{
	    $reviews_details = array();
		$i = 0;
		foreach($reviews_info as $reviews)
		{
			$customer_info =Db::getInstance()->getRow("select * from `"._DB_PREFIX_."customer` where `id_customer`=".$reviews['id_customer']."");
				if($customer_info)
				{
					$reviews_details[$i]['customer_name'] = $customer_info['firstname']." ".$customer_info['lastname'];
					$reviews_details[$i]['customer_email'] = $customer_info['email'];
				}
			    else
				{
					$reviews_details[$i]['customer_name'] = "Not Available";
				    $reviews_details[$i]['customer_email'] = "Not Available";
			    }
					   
				$reviews_details[$i]['rating'] = $reviews['rating'];
			    $reviews_details[$i]['review'] = $reviews['review'];
			    $reviews_details[$i]['time'] = $reviews['timestamp'];
					   
				$i++;
		}
		$reviews_count = count($reviews_info);
		$smarty->assign("reviews_count", $reviews_count);
		$smarty->assign("reviews_details", $reviews_details);
	}
	else
	 $smarty->assign("reviews_count", 0);
	 
	$this->setTemplate('all_reviews.tpl');
	parent::initContent();
 }

 public function setMedia() 
 {
	parent::setMedia();
	$this->addCSS(_MODULE_DIR_.'marketplace/css/shop_store.css');
 } 
}
?>