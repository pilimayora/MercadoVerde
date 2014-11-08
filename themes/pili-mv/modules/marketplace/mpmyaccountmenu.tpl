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
	<li class="titulo-categoria-perfil">
		<a href="#">
			<span>Mi Tienda</span>
		</a>
	</li>
	<li class="">
		<a href="{$account_dashboard}" title="Account Dashboard">
			<span>{l s='Account Dashboard' mod='marketplace'}</span>
		</a>
	</li>
	
	<li class="">
		<a href="{$edit_profile}" title="Edit Profile">
			<span>{l s='Edit Profile' mod='marketplace'}</span>
		</a>
	</li>
	
	
	<li class="">
		<a href="{$seller_profile}" title="Seller Profile" target="_blank">
			<span>{l s='Seller Profile' mod='marketplace'}</span>
		</a>
	</li>
	
	
	<li class="">
		<a href="{$link_store}" title="View Shop" target="_blank">
			<span>{l s='Shop' mod='marketplace'}</span>
		</a>
	</li>
	
	
	<li class="">
		<a href="{$link_collection}" title="View Collection" target="_blank">
			<span>{l s='Collection' mod='marketplace'}</span>
		</a>
	</li>
	
	
	<li class="">
		<a href="{$add_product}" title="Add product">
			<span>{l s='Add Product' mod='marketplace'}</span>
		</a>
	</li>
	
	<li class="">
		<a href="{$product_list}" title="Product List">
			<span>{l s='Product List' mod='marketplace'}</span>
		</a>
	</li>
	
	<li class="">
		<a href="{$my_order}" title="My order">
			<span>{l s='My order' mod='marketplace'}</span>
		</a>
	</li>
	
	<li class="">
		<a href="{$payment_details}" title="Payment Detail">
			<span>{l s='Payment Detail' mod='marketplace'}</span>
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