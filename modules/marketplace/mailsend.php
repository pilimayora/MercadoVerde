<?php
include '../../config/config.inc.php';

$check = Db::getInstance()->execute('insert into `' . _DB_PREFIX_ . 'customer_query`(`id_product`,`id_customer`,`id_customer_to`,`title`,`description`) values('.$_POST['product_id'].','.$_POST['cust_id'].','.$_POST['seller-id'].',"'.$_POST['subject'].'","'.$_POST['ask'].'")');
if($check)
{

$product_name = $_POST['product-name'];
$to = $_POST['seller-email'];
$from = $_POST['email'];
$message = $_POST['ask'];
$subject = $_POST['subject'];
$headers = 'From: '.$from . "\r\n" .
    'Reply-To: '.$from . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

$a = mail($to, $subject, $message, $headers);
if($a)
echo '1';
else
echo '0';
}
else
 echo '0';
?>

