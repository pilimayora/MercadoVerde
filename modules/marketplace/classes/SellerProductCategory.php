<?php
class SellerProductCategory extends ObjectModel{
	public $id;
	public $id_category;
	public $id_seller_product;
	public $is_default;
	
	public static $definition = array(
		'table' => 'marketplace_seller_product_category',
		'primary' => 'id',
		'fields' => array(
						'id_category' => array('type' => self::TYPE_INT),
						'is_default' => array('type' => self::TYPE_INT),
						'id_seller_product' => array('type' => self::TYPE_INT),
					)
	);
	
	public function add($autodate = true, $null_values = false){
		if (!parent::add($autodate, $null_values))
			return false;
		return Db::getInstance()->Insert_ID();
	}
	
	public function update($null_values = false){
		Cache::clean('getContextualValue_'.$this->id.'_*');
		$success = parent::update($null_values);
		return $success;
	}
		
	public function save($null_values = true, $autodate = true){
		if(!parent::save($null_values, $autodate))
			return false;
		return true;	
	}
	
	public function getMpDefaultCategory($mpproductid){
		$defaultcat = Db::getInstance()->getValue("SELECT `id_category` FROM `"._DB_PREFIX_."marketplace_seller_product` WHERE `id`=".$mpproductid);
		if(!empty($defaultcat))
			return $defaultcat;
		return false;	
	}
	
	function buildChildCategoryRecursive($oldID, $id_lang, $checked_product_cat=false, $defaultcatid=false){
		
			global $exclude; 
			global $depth;
			$tempTree = "";
			$category =  Db::getInstance()->ExecuteS("SELECT a.`id_category`,a.`id_parent`,l.`name` from `"._DB_PREFIX_."category` a LEFT  JOIN `"._DB_PREFIX_."category_lang` l  ON (a.`id_category`=l.`id_category`) where a.id_parent=".$oldID." and l.id_lang=".$id_lang." and l.`id_shop`=1 order by a.`id_category`");

			if(!empty($category)){
				$tempTree .= "<ul>";
				foreach($category as $child)
				 {
					  if ( $child['id_category'] != $child['id_parent'] )
					  {
						$tempTree .= "<li><input type='checkbox'";
						if(!empty($checked_product_cat)){					//For old products
							foreach($checked_product_cat as $product_cat){
								if($product_cat['id_category'] == $child['id_category'])
									$tempTree .= "checked";
							}
						}
						else{
							if($defaultcatid == $child['id_category'])
							$tree .= "checked";
						}
						$tempTree .= " name='product_category[]' value='".$child['id_category']."'><label>".$child['name']."</label>";
						$depth++;          										
						$tempTree .= $this->buildChildCategoryRecursive($child['id_category'], $id_lang, $checked_product_cat,$defaultcatid);          	
						$depth--;        											
						array_push($exclude, $child['id_category']);               
					  }
				 }
				$tempTree .= "</ul>";
			}
			return $tempTree; 
	}
}
?>