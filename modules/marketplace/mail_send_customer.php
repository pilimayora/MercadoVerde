<?php
include '../../config/config.inc.php';
include 'get_info.php';
$data = $_GET['mail_data'];
$id_info = $_GET['id_info'];
$send_by = $_GET['send_by'];
$send_to = $_GET['send_to'];

$obj = new get_info();
$seller_id = $obj->getSellerId($send_by);
$customer_info= $obj->getCustomerInfo($send_to);
$seller_info= $obj->getSellerInfo($seller_id);
$mail_from = $seller_info['business_email'];;
$mail_to = $customer_info['email'];


$subject     = "Enquiry";
                $msg         = $data;
                $headers     = 'From:'.$mail_from.''. "\r\n" . 'Reply-To: '.$mail_from.'' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
                $mail        = mail($mail_to,$subject,$msg,$headers);
				
if($mail)
{
	$insert = $obj->insert_record($send_by,$send_to,$data,$id_info);
	echo $insert;
}				
?>