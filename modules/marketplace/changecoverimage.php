<?php
	include '../../config/config.inc.php';
	if(isset($_POST['id_image'])) {
		$id_image = $_POST['id_image'];
		$is_cover = $_POST['is_cover'];
		$id_pro = $_POST['id_pro'];
		$product = new Product($id_pro);
		$product->setCoverWs($id_image);
		//echo 1;
		
		// Db::getInstance()->execute('UPDATE `'._DB_PREFIX_.'image_shop` image_shop, `'._DB_PREFIX_.'image` i
			// SET image_shop.`cover` = 0 
			// WHERE i.`id_product` = '.$id_pro.' AND i.id_image = image_shop.id_image
			// AND image_shop.id_shop=1');
		// Db::getInstance()->execute('UPDATE `'._DB_PREFIX_.'image_shop`
			// SET `cover` = 1 WHERE `id_image` = '.(int)$id_image);
			echo 1;
	} else {
		echo 0;
	}
?>