<?php
include '../../config/config.inc.php';
include_once 'classes/SellerProductDetail.php';
global $cookie;

$id_lang = 1;
$seller_product_id = $_POST['id_product'];
$img_ps_dir1 = _PS_IMG_DIR_;
$img_ps_dir = _MODULE_DIR_."marketplace/img/";
$module_dir = _MODULE_DIR_;
if($seller_product_id>0) {
	$obj_marketplace_product = new SellerProductDetail();
	$is_product_onetime_activate = $obj_marketplace_product->getMarketPlaceShopProductDetailBYmspid($seller_product_id);
				
	if($is_product_onetime_activate) {
		$link = new Link();
		$id_product = $is_product_onetime_activate['id_product'];
		//$id_image_detail = Image::getImages($id_lang, $id_product);
		$product = new Product($id_product);
		$id_image_detail = $product->getImages($id_lang);
		$product_link_rewrite = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `". _DB_PREFIX_."product_lang` where id_product=".$id_product." and id_lang=".$id_lang);
		$name = $product_link_rewrite['link_rewrite'];
		if(!empty($id_image_detail)) {
			foreach($id_image_detail as $id_image_info) {
				$id_image[] = $id_image_info['id_image'];
				$ids = $id_product.'-'.$id_image_info['id_image'];
				$image_link[] = $link->getImageLink($name,$ids);
				$is_cover[] = $id_image_info['cover'];
				$position[] = $id_image_info['position'];
			}
		}				
?>
		<html>
		<head>
			<style>
				.middle_container {
					float:left;
					width:100%;
				}	
				.table {
					border: 0 none;
					border-spacing: 0;
					empty-cells: show;
					font-size: 100%;
					width:100%;
				}
				.table tr {
					padding:5px;
				}
				.table tr th {
					background: -moz-linear-gradient(center top , #F9F9F9, #ECECEC) repeat-x scroll left top #ECECEC;
					color: #333333;
					font-size: 13px;
					padding: 4px 6px;
					text-align: left;
					text-shadow: 0 1px 0 #FFFFFF;
					text-align:center;
				}
				.table tr td {
					border-bottom: 1px solid #CCCCCC;
					color: #333333;
					font-size: 12px;
					padding: 4px 4px 4px 6px;
					text-align:center;
				}
			</style>
		</head>
		<body>
			<div class="middle_container">
				<div style="float:left;width:100%;">Active Image</div>
				<table id="imageTable" cellspacing="0" cellpadding="0" class="table">
					<tr>
						<th>Image</th>
						<th>Position</th>
						<th>Cover</th>
						<th>Action</th>		
					</tr>
				<?php
					if(isset($id_image)) {
						$j=0;
					
						foreach($id_image as $id_image1) {
				?>
							<tr class="imageinforow<?php echo $id_image1; ?>">
								<td>
									<a class="fancybox" href="http://<?php echo $image_link[$j]; ?>">
										<img title="15" width="45" height="45" alt="15" src="http://<?php echo $image_link[$j]; ?>">
									</a>
								</td>
								<td>
									<a class="fancybox" href="">
										<?php echo $position[$j]; ?>
									</a>
								</td>
								<td>
								<?php
									if($is_cover[$j]==1) {
								?>
										<img class="covered" id="changecoverimage<?php echo $id_image1; ?>" alt="<?php echo $id_image1; ?>" src="<?php echo $img_ps_dir;?>enabled.gif" is_cover="1" id_pro="<?php echo $id_product; ?>">
										
								<?php
									} else {
								?>
										<img class="covered" id="changecoverimage<?php echo $id_image1; ?>" alt="<?php echo $id_image1; ?>" src="<?php echo $img_ps_dir;?>forbbiden.gif" is_cover="0" id_pro="<?php echo $id_product; ?>">
								<?php
									}
								?>
								</td>
								<td>
								<?php
									if($is_cover[$j]==1) {
								?>
									<img title="Delete this image" class="delete_pro_image" alt="<?php echo $id_image1; ?>" src="<?php echo $img_ps_dir;?>delete.gif" is_cover="1" id_pro="<?php echo $id_product; ?>">
								<?php
									} else {
								?>
									<img title="Delete this image" class="delete_pro_image" alt="<?php echo $id_image1; ?>" src="<?php echo $img_ps_dir;?>delete.gif" is_cover="0" id_pro="<?php echo $id_product; ?>">
								<?php
									}
								?>
								</td>
							</tr>
				<?php
							$j++;
						}
					} else {
				?>
					<tr>
						<td>
						</td>
						<td colspan="2">
							No Image has been uploaded Yet
						</td>
						<td>
						</td>
					</tr>
				<?php
					}
				?>	
				</table>
				<?php
					$unactive_image = $obj_marketplace_product->unactiveImage($seller_product_id);
					if($unactive_image) {
				?>
						<div style="float:left;width:100%;">Unactive Image</div>
						<table id="imageTable" cellspacing="0" cellpadding="0" class="table">
							<tr>
								<th>Image</th>
								<th>Action</th>		
							</tr>
<?php
							foreach($unactive_image as $unactive_image1) {
?>
								<tr class="unactiveimageinforow<?php echo $unactive_image1['id']; ?>">
									<td>
										<a class="fancybox" href="<?php echo $module_dir;?>marketplace/img/product_img/<?php echo $unactive_image1['seller_product_image_id']; ?>.jpg">
											<img title="15" width="45" height="45" alt="15" src="<?php echo $module_dir;?>marketplace/img/product_img/<?php echo $unactive_image1['seller_product_image_id']; ?>.jpg" />
										</a>
									</td>
									<td>
										<img title="Delete this image" class="delete_unactive_pro_image" alt="<?php echo $unactive_image1['id']; ?>" src="<?php echo $img_ps_dir;?>delete.gif" img_name="<?php echo $unactive_image1['seller_product_image_id']; ?>">
									</td>
								</tr>
					
<?php
							}
?>
						</table>
<?php
					}
?>
			</div>
			<script type="text/javascript">
				$('.fancybox').fancybox();
				
				
			</script>
		</body>
	</html>
<?php
	} else {
		$unactive_image = $obj_marketplace_product->unactiveImage($seller_product_id);
		if($unactive_image) {
?>
		<html>
		<head>
			<style>
				.middle_container {
					float:left;
					width:100%;
				}	
				.table {
					border: 0 none;
					border-spacing: 0;
					empty-cells: show;
					font-size: 100%;
					width:100%;
				}
				.table tr {
					padding:5px;
				}
				.table tr th {
					background: -moz-linear-gradient(center top , #F9F9F9, #ECECEC) repeat-x scroll left top #ECECEC;
					color: #333333;
					font-size: 13px;
					padding: 4px 6px;
					text-align: left;
					text-shadow: 0 1px 0 #FFFFFF;
					text-align:center;
				}
				.table tr td {
					border-bottom: 1px solid #CCCCCC;
					color: #333333;
					font-size: 12px;
					padding: 4px 4px 4px 6px;
					text-align:center;
				}
			</style>
		</head>
		<body>
			<div class="middle_container">
				<div style="float:left;width:100%;">Unactive Image</div>
				<table id="imageTable" cellspacing="0" cellpadding="0" class="table">
					<tr>
						<th>Image</th>
						<th>Action</th>		
					</tr>
<?php
				foreach($unactive_image as $unactive_image1) {
?>
					<tr class="unactiveimageinforow<?php echo $unactive_image1['id']; ?>">
						<td>
							<a class="fancybox" href="<?php echo $module_dir;?>marketplace/img/product_img/<?php echo $unactive_image1['seller_product_image_id']; ?>.jpg">
								<img title="15" width="45" height="45" alt="15" src="<?php echo $module_dir;?>marketplace/img/product_img/<?php echo $unactive_image1['seller_product_image_id']; ?>.jpg" />
							</a>
						</td>
						<td>
							<img title="Delete this image" class="delete_unactive_pro_image" alt="<?php echo $unactive_image1['id']; ?>" src="<?php echo $img_ps_dir;?>delete.gif" img_name="<?php echo $unactive_image1['seller_product_image_id']; ?>">
						</td>
					</tr>
					
<?php
				}
?>
				</table>
			</div>
			<script type="text/javascript">
				$('.fancybox').fancybox();
			</script>
		</body>
<?php		
		} else {
?>
		<div class="middle_container" style="float:left;width:100%;">
			<div style="float:left;width:100%;">No Image has been uploaded Yet</div>
		</div>
<?php
		}
	}
		
} else {
		echo 0;		//id_product not set
}
?>