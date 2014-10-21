{include file="toolbar.tpl" toolbar_btn=$toolbar_btn toolbar_scroll=$toolbar_scroll title=$title}
<fieldset>
	<legend>Mass Product Update Detail</legend>
	<div class="container-massupdate">
		<div class="row_info">
			<div class="row_info_left">
				{l s="Mass Price Update On" mod='productmassupdate'}
			</div>
			<div class="row_info_right">
				{$mass_price_update_on_lang}
			</div>
		</div>
		{if $category_info==-1}
			<div class="row_info">
			<div class="row_info_left">
				{l s="Update On" mod='productmassupdate'}
			</div>
			<div class="row_info_right">
				{l s="All Category" mod='productmassupdate'}
			</div>
		</div>
		{else}
			<div class="row_info">
				<div class="row_info_left">
					{l s="Category In Updation" mod='productmassupdate'}
				</div>
				<div class="row_info_right">
					{foreach $category_info as $cat_info}
						{$cat_info['name']},
					{/foreach}
				</div>
			</div>
		{/if}
		<div class="row_info">
			<div class="row_info_left">
				{l s="Mass Price Update Type" mod='productmassupdate'}
			</div>
			<div class="row_info_right">
				{$mass_price_update_type_lang}
			</div>
		</div>
		<div class="row_info">
			<div class="row_info_left">
				{l s="Mass Price Update Value" mod='productmassupdate'}
			</div>
			<div class="row_info_right">
				{$mass_price_update_value}
			</div>
		</div>
		<div class="row_info">
			<div class="row_info_left">
				{l s="Created Date" mod='productmassupdate'}
			</div>
			<div class="row_info_right">
				{$update_on}
			</div>
		</div>
		<div class="row_info">
			<div class="row_info_left">
				{l s="Is Revert Back" mod='productmassupdate'}
			</div>
			<div class="row_info_right">
				{$is_revert_back}
			</div>
		</div>
		<div class="row_info">
			<div class="row_info_left">
				{l s="Is Revert Back Date" mod='productmassupdate'}
			</div>
			<div class="row_info_right">
				{$revert_back_date}
			</div>
		</div>
	</div>
</fieldset>