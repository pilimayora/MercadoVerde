<?php
	include '../../config/config.inc.php';
	
	if(isset($_POST['id_image'])) {
		$image = new Image($_POST['id_image']);
		$status = $image->delete();
		Product::cleanPositions($_POST['id_pro']);
		$delete =  Db::getInstance()->delete('image','id_image='.$_POST['id_image'].' and id_product='.$_POST['id_pro']);
		// if(isset($_POST['is_cover'])==1) {
			// images::deleteCover($_POST['id_pro']);
			// Product::cleanPositions($_POST['id_pro']);
		// }
		if($status) {
			echo 1;
		} else {
			echo 0;
		}
	} else {
		echo 0;
	}

?>