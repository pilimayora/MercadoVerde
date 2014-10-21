<?php
class get_info
{

  public function get_query($id)
  {
    $query_info = Db::getInstance()->getRow('select * from `'._DB_PREFIX_ .'customer_query` where `id`='.$id.'' );
	return $query_info;
  }
  public function product_name($id,$lang)
  {
    $pd_name = Db::getInstance()->getRow('select `name` from `'._DB_PREFIX_ .'product_lang` where `id_product`='.$id.' and `id_lang`='.$lang.'' );
	
	return $pd_name['name'];
  }
  
  public function query_replies($id)
  {
    $query_records = Db::getInstance()->executeS('select * from `'._DB_PREFIX_ .'query_records` where `id_query`='.$id.'' );
	
	return $query_records;
  }
  
  public function getCustomerInfo($id)
  {
    $customer_info = Db::getInstance()->getRow('select * from `'._DB_PREFIX_ .'customer` where `id_customer`='.$id.'' );
	
	return $customer_info;
  }
  
  public function getSellerInfo($id)
  {
    $seller_info = Db::getInstance()->getRow('select * from `'._DB_PREFIX_ .'marketplace_seller_info` where `id`='.$id.'' );
	
	return $seller_info;
  }
  
 public function  getSellerId($id)
 {
	$seller_info = Db::getInstance()->getRow('select `marketplace_seller_id` from `'._DB_PREFIX_ .'marketplace_customer` where `id_customer`='.$id.'');
	
	return $seller_info['marketplace_seller_id'];
 }
  
  public function insert_record($send_by,$send_to,$data,$id_info)
  {
	$insert = Db::getInstance()->execute('insert into `'._DB_PREFIX_ .'query_records`(`from`,`to`,`description`,`id_query`) values('.$send_by.','.$send_to.',"'.$data.'",'.$id_info.')' );
	
	if($insert)
	 return '1';
	else
     return '0';	
  }
  
  public function insert_feedback($seller_id,$id_customer,$email,$rating,$feedback)
  {
	 $insert = Db::getInstance()->execute('insert into `'._DB_PREFIX_ .'seller_reviews`(`id_seller`,`id_customer`,`customer_email`,`rating`,`review`,`active`)values('.$seller_id.','.$id_customer.',"'.$email.'",'.$rating.',"'.$feedback.'",1)');
	 if($insert)
	 return '1';
	else
     return '0';
  }
  
}
?>