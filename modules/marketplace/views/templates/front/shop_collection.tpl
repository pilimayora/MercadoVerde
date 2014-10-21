<style>
#left_column,#right_column
 {
  display:none;
 }
#wrapper
 {
  float:left;
  width:980px;
  border:1px solid #C4C1BC; 
  margin-bottom:20px;
 }
#logo
{
 float:left;
 width:100%;
} 
#refine_search
{
 float:left;
 width:100%;
 height:20px;
 border-bottom:1px solid #C4C1BC;
}
#inner_wrapper
{
 width:100%;
 float:left;
 width:980px;
}
#seller_cat_list
{
 width:153px;
 float:left;
 border:1px solid #C4C1BC;
 margin-left:20px;
 margin-top:26px;
 margin-bottom:20px;
 
}
#products_block
{
 width:770px;
 float:left;
 margin-left:20px;
 margin-top:20px;
 
}
.img_thumb
{
 float:left;
 width:142px;
 margin:5px;
 border:1px solid #C4C1BC;
}
.image_thumbnail
{
 margin:5px;
 width:135px;
}
.price
{
 float:left;
 width:135px;
 margin-left:5px;
 margin-right:5px;
 margin-bottom:5px;
}
.price span
{
 width:135px;
 float:left;
 font-weight:bold;
 white-space: nowrap;
 overflow: hidden;
 text-overflow: ellipsis;
}
.uour-div {
white-space: nowrap;
width: 150px;
overflow: hidden;
text-overflow: ellipsis;
}
#cat_list_title
{
 width:100%;
 float:left;
 border-bottom:1px solid #C4C1BC;
 background:none repeat scroll 0 0 #F8F7F5
}
#cat_list
{
 float:left;
 width:100%;
 background:#F1F9FF;
 min-height:100px;
}
</style>
<div id="wrapper">
 <div id="logo">
	{hook h="DisplayMpcollectionbannerhook"}
  <img id="default_banner" src="{$modules_dir}marketplace/img/prestashop_logo.jpg" />
 </div>
 <div id="refine_search">
  <div class="sortPagiBar clearfix">

<form id="productsSortForm" action="{$link_collection}{if $cat_id>0}&cat_id={$cat_id}{/if}">
<p class="select">
<label for="selectPrductSort">Sort by</label>
<select id="selectPrductSort" class="selectProductSort">
<option value="position:asc" selected="selected">--</option>
<option value="price:asc">Price: lowest first</option>
<option value="price:desc">Price: highest first</option>
<option value="name:asc">Product Name: A to Z</option>
<option value="name:desc">Product Name: Z to A</option>
</select>
</p>
</form>

<script type="text/javascript">
var min_item = 'Please select at least one product';
var max_item = "You cannot add more than 3 product(s) to the product comparison";
</script>

</div>
 </div>
	<div id="inner_wrapper">
		<div id="seller_cat_list">
			<div id="cat_list_title">
				<span style="padding:4px;float:left;padding:8px;font-size:14px;"><b>Seller Category List</b></span>
			</div>
			<div id="cat_list">
				<ul>
					{assign var=k value=0}
						{while $k != $count_category}
							<span style="width:100%;float:left;padding:4px;"><a href="{$link_collection}&shop={$id_shop1}&cat_id={$category_id[$k]}" style="color:#1e7ec8;">{$category_name[$k]}({$category_qty[$k]})</a></span>
							{assign var=k value=$k+1}
						{/while}
				</ul>
			</div>
			{hook h="DisplayMpcollectionlefthook"}
		</div>
		<div id="products_block">
			{assign var=j value=0}
			{while $j != $count_product}
				<div class="img_thumb">
					<div class="image_thumbnail">
						<a href="{$base_dir}index.php?id_product={$product_id[$j]}&controller=product" class="product_img_link" title="{$product_name[$j]}">
							<img src="{$image_link[$j]}" alt="" width="135" height="135"/>
						</a>
					</div>
					<div class="price">
						<center>
							<span><a href="{$base_dir}index.php?id_product={$product_id[$j]}&controller=product">{$product_name[$j]}</a></span>
							<span>{$product_price[$j]}</span>
							<a class="button ajax_add_to_cart_button exclusive" rel="ajax_id_product_{$product_id[$j]}" href="{$base_dir}index.php?controller=cart&add=&id_product={$product_id[$j]}&token={$token}" title="Add to cart">
								Add to cart
							</a>
						</center>
					</div>
       	   
				</div>
				{assign var=j value=$j+1}
			{/while}
		</div>
		{hook h="DisplayMpcollectionfooterhook"}
	</div>
	
 {if $cat_id>0}
	<input type="hidden" value="{$cat_id}" id="cat_id_info">
 {else}
	<input type="hidden" value="0" id="cat_id_info">
 {/if}
</div>


{if $id_product1}
<script type="text/javascript">
$(document).ready(function()
{
	$('.selectProductSort').change(function()
	{
		var requestSortProducts = '{$link_collection}&id={$id_product1}&';
		var splitData = $(this).val().split(':');
		
		document.location.href = requestSortProducts + ((requestSortProducts.indexOf('?') < 0) ? '?' : '&') + 'orderby=' + splitData[0] + '&orderway=' + splitData[1];
		
	});
});
</script>
{else}
<script type="text/javascript">
	$(document).ready(function()
	{
		$('.selectProductSort').change(function()
		{
			var cat_id = $('#cat_id_info').val();
			if(cat_id>0) {
				var requestSortProducts = '{$link_collection}&shop={$id_shop1}&cat_id={$cat_id}';
			} else {
				var requestSortProducts = '{$link_collection}&shop={$id_shop1}&';
			}
			var splitData = $(this).val().split(':');
			
			document.location.href = requestSortProducts + ((requestSortProducts.indexOf('?') < 0) ? '?' : '&') + 'orderby=' + splitData[0] + '&orderway=' + splitData[1];
			
		});
	});
</script>
{/if}