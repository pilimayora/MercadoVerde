<?php
	include '../../config/config.inc.php';
	if(isset($_POST['id_image'])) {
		$img_name = $_POST['img_name'];
		$delete =  Db::getInstance()->delete("marketplace_product_image","id=".$_POST['id_image']." and seller_product_image_id	='".$_POST['img_name']."'");
		$dir = 'modules/marketplace/img/product_img/';
		
		if($delete) {
			unlink($dir.$_POST['img_name'].'jpg');
			echo 1;
		} else {
			echo 0;
		}
	} else {
		echo 0;
	}
?>