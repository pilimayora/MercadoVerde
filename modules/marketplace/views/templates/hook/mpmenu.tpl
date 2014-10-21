<div class="menu_item">
		<p class="menutitle">{l s='Market Place' mod='marketplace'}</p>
		{if $is_seller==-1}
			<div class="block_content">
				<ul class="bullet">
					<li><a href="{$new_link}" title="seller request">{l s='Seller Request' mod='marketplace'}</a></li>
				</ul>
			</div>
		{else if $is_seller==0}
			<div class="block_content">
				<h3>{l s='Your request for seller has been send to admin approval' mod='marketplace'}</h3>
			</div>
		{else if $is_seller==1}
			<div class="list_content">
				<ul>
					<li><span><a href="{$account_dashboard}" title="Account Dashboard" {if $logic==1}style="color:{$recent_color} !important;"{/if}>{l s='Account Dashboard' mod='marketplace'}</a></span></li>

					<li><span><a href="{$edit_profile}" title="Edit Profile" {if $logic==2}style="color:{$recent_color} !important;"{/if}>{l s='Edit Profile' mod='marketplace'}</a></span></li>

					<li><span><a href="{$seller_profile}" title="Seller Profile" target="_blank">{l s='Seller Profile' mod='marketplace'}</a></span></li>
					

					<li><span><a href="{$link_store}" title="View Shop" target="_blank">{l s='Shop' mod='marketplace'}</a></span></li>
					

					<li><span><a href="{$link_collection}" title="View Collection" target="_blank">{l s='Collection' mod='marketplace'}</a></span></li>
					

					<li><span><a href="{$add_product}" title="Add product" target="_blank" {if $logic=='add_product'}style="color:{$recent_color} !important;"{/if}>{l s='Add Product' mod='marketplace'}</a></span></li>
					

					<li><span><a href="{$product_list}" title="Product List" {if $logic==3}style="color:{$recent_color} !important;"{/if}>{l s='Product List' mod='marketplace'}</a></span></li>
					

					<li><span><a href="{$my_order}" title="My order" {if $logic==4}style="color:{$recent_color} !important;"{/if}>{l s='My order' mod='marketplace'}</a></span></li>
					
					<li><span><a href="{$payment_details}" title="Payment Detail" {if $logic==5}style="color:{$recent_color} !important;"{/if}>{l s='Payment Detail' mod='marketplace'}</a></span></li>					
					{hook h="DisplayMpmenuhookext"}
				</ul>

			</div>

		{/if}

</div>