<?php
class marketplaceProductimageeditModuleFrontController extends ModuleFrontController{

	public function initContent(){
		
		global $cookie;
		global $smarty;
		parent::initContent();
		$id_lang = $this->context->cookie->id_lang;
		$seller_product_id = Tools::getValue('id_product');
		$img_ps_dir1 = _PS_IMG_DIR_;
		$img_ps_dir = _MODULE_DIR_."marketplace/img/";
		$module_dir = _MODULE_DIR_;
		
		if($seller_product_id>0) {
			
			$obj_marketplace_product = new SellerProductDetail();
			$is_product_onetime_activate = $obj_marketplace_product->getMarketPlaceShopProductDetailBYmspid($seller_product_id);
						
			if($is_product_onetime_activate) {
				$link = new Link();
				$id_product = $is_product_onetime_activate['id_product'];
				$product = new Product($id_product);
				$id_image_detail = $product->getImages($id_lang);
				
				$product_link_rewrite = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("SELECT * FROM `". _DB_PREFIX_."product_lang` WHERE id_product=".$id_product." and id_lang=".$id_lang);
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
				$unactive_image = $obj_marketplace_product->unactiveImage($seller_product_id);
				if($unactive_image) 
					$smarty->assign("unactive_image",$unactive_image);
					
				$smarty->assign("id_image",$id_image);
				$smarty->assign("image_link",$image_link);
				$smarty->assign("is_cover",$is_cover);
				$smarty->assign("position",$position);
				$smarty->assign("id_product",$id_product);
				$smarty->assign("img_ps_dir",$img_ps_dir);
				$this->setTemplate('imageedit.tpl');
				}
			}
	}
}
?>