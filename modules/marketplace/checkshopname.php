<?php
	include '../../config/config.inc.php';
		$shopname = Tools::getValue('shopname');
		$name = addslashes($shopname);
		$name = Db::getInstance()->getRow("SELECT * FROM `" ._DB_PREFIX_ ."marketplace_seller_info` WHERE shop_name ='$name'");
		if(empty($name))
			echo 0;
		echo $name;
?>