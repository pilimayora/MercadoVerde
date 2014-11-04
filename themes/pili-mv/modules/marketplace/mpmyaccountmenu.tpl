<style>
h4 a
{
color:{$color1}!important;
font-size:{$font_size1}px;
font-family:{$font_family1};
}
</style>
<!-- MODULE WishList -->	
	{if $is_seller==1}
	<li class="">
		<a href="{$account_dashboard}" title="Account Dashboard"><img src="{$base_dir}modules/marketplace/img/account_dashboard.gif" class="icon" alt="MarketPlace."/>
			{l s='Account Dashboard' mod='marketplace'}
		</a>
	</li>
	
	<li class="">
		<a href="{$edit_profile}" title="Edit Profile">
		<img src="{$base_dir}modules/marketplace/img/edit_seller.gif" class="icon" alt="MarketPlace."/>
			{l s='Edit Profile' mod='marketplace'}
		</a>
	</li>
	
	
	<li class="">
		<a href="{$seller_profile}" title="Seller Profile" target="_blank"><img src="{$base_dir}modules/marketplace/img/edit_seller.gif" class="icon" alt="MarketPlace."/>
			{l s='Seller Profile' mod='marketplace'}
		</a>
	</li>
	
	
	<li class="">
		<a href="{$link_store}" title="View Shop" target="_blank">
		<img src="{$base_dir}modules/marketplace/img/mkt.gif" class="icon" alt="MarketPlace."/>
			{l s='Shop' mod='marketplace'}
		</a>
	</li>
	
	
	<li class="">
		<a href="{$link_collection}" title="View Collection" target="_blank"><img src="{$base_dir}modules/marketplace/img/collection.gif" class="icon" alt="MarketPlace."/>
			{l s='Collection' mod='marketplace'}
		</a>
	</li>
	
	
	<li class="">
		<a href="{$add_product}" title="Add product"><img src="{$base_dir}modules/marketplace/img/add_product.gif" class="icon" alt="MarketPlace."/>
			{l s='Add Product' mod='marketplace'}
		</a>
	</li>
	
	<li class="">
		<a href="{$product_list}" title="Product List"><img src="{$base_dir}modules/marketplace/img/product_list.gif" class="icon" alt="MarketPlace."/>
			{l s='Product List' mod='marketplace'}
		</a>
	</li>
	
	<li class="">
		<a href="{$my_order}" title="My order"><img src="{$base_dir}modules/marketplace/img/my_order.gif" class="icon" alt="MarketPlace."/>
			{l s='My order' mod='marketplace'}
		</a>
	</li>
	
	<li class="">
		<a href="{$payment_details}" title="Payment Detail"><img src="{$base_dir}modules/marketplace/img/payment.gif" class="icon" alt="MarketPlace."/>
			{l s='Payment Detail' mod='marketplace'}
		</a>
	</li>
	

	
	{else if $is_seller==0}
	<li class="">
	<img src="{$base_dir}modules/marketplace/img/mkt.gif" class="icon" alt="MarketPlace."/>
		{l s='Your Request has been already sent to Admin.Wait For Admin Approval' mod='marketplace'}
	</li>
		
	{else if $is_seller==-1}
	<li class="titulo-categoria-tienda">
		<a href="{$new_link1}" title="{l s='Crear Tienda' mod='marketplace'}">
			<span>{l s='Crear Tienda' mod='marketplace'}</span>
		</a>
	</li>
	{/if}
	
<!-- END : MODULE WishList -->