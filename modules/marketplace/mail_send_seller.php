<?php
include '../../config/config.inc.php';
include 'get_info.php';
$data = $_GET['mail_data'];
$id_info = $_GET['id_info'];
$send_by = $_GET['send_by'];
$send_to = $_GET['send_to'];

$obj = new get_info();
$customer_info= $obj->getCustomerInfo($send_by);
$seller_info= $obj->getSellerInfo($send_to);
$mail_from = $customer_info['email'];
$mail_to = $seller_info['business_email'];


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