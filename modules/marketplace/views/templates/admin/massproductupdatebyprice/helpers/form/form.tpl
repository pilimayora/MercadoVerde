{if $show_toolbar}
	{include file="toolbar.tpl" toolbar_btn=$toolbar_btn toolbar_scroll=$toolbar_scroll title=$title}
	<div class="leadin">{block name="leadin"}{/block}</div>
{/if}
{block name="other_fieldsets"}
	 <fieldset>
		{if $set==1}
			<legend>{l s="Add New Mass Update" mod='productmassupdate'}</legend>
		{else}
			<legend>{l s="Revert Back Mass Update" mod='productmassupdate'}</legend>
		{/if}
    <form id="{$table}_form" class="defaultForm {$name_controller}" action="{$current}&{if !empty($submit_action)}{$submit_action}{/if}&token={$token}" method="post" enctype="multipart/form-data" {if isset($style)}style="{$style}"{/if}>
	{if $form_id}
		<input type="hidden" name="{$identifier}" id="{$identifier}" value="{$form_id}" />
	{/if}
	<input type="hidden" name="set" id="set" value="{$set}" />
	<div class="form_registration">
		<div class="row_info error" style="display:none;width:90%;" id="error_show">
			
		</div>
		{if $set==1}
			<div class="row_info">
				<div class="row_info_left">
					{l s="Mass Price Update On" mod='productmassupdate'}
				</div>
				<div class="row_info_right">
					<select id="mass_price_update_on" name="mass_price_update_on">
						<option value="0">{l s="All Product" mod='productmassupdate'}</option>
						<option value="1">{l s="Filter By Category" mod='productmassupdate'}</option>
					</select>
				</div>
			</div>
			<div class="row_info" id="category_info" style="display:none;">
				<div class="row_info_left">
					{l s="Choose category" mod='productmassupdate'}
				</div>
				<div class="row_info_right">
					{$category_tree}
				</div>
			</div>
			<div class="row_info">
				<div class="row_info_left">
					{l s="Mass Price Update Type" mod='productmassupdate'}
				</div>
				<div class="row_info_right">
					<select id="mass_price_update_type" name="mass_price_update_type">
						<option value="0">{l s="Percentage" mod='productmassupdate'}</option>
						<option value="1">{l s="Fixed" mod='productmassupdate'}</option>
					</select>
				</div>
			</div>
			</div>
			<div class="row_info">
				<div class="row_info_left">
					{l s="Mass Price Update Value" mod='productmassupdate'}
				</div>
				<div class="row_info_right">
					<input type="text" value="" id="mass_price_update_value" name="mass_price_update_value"/>
				</div>
			</div>
			<div class="row_info">
				<input type="button" value="Conform" id="mass_product_conform" class="button">
			</div>
					
			
				<div class="margin-form" style="display:none;" id="save_button">
					<input type="submit"
						id="{if isset($field.id)}{$field.id}{else}{$table}_form_submit_btn{/if}"
						value="Save"
						name="{if isset($field.name)}{$field.name}{else}{$submit_action}{/if}{if isset($field.stay) && $field.stay}AndStay{/if}"
						{if isset($field.class)}class="{$field.class}"{/if} class="button"/>
						
				</div>
		{else}
			<input type="hidden" value="{$id}" name="id" />
			<div class="row_info">
				<div class="row_info_left">
					{l s="Mass Price Update On :" mod='productmassupdate'}
				</div>
				<div class="row_info_right">
					{$mass_price_update_on_lang}
				</div>
			</div>
			{if $category_info!=-1}
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
			
			<div class="margin-form" id="update_button">
				<input type="submit"
						id="{if isset($field.id)}{$field.id}{else}{$table}_form_submit_btn{/if}"
						value="Revert Back"
						name="{if isset($field.name)}{$field.name}{else}{$submit_action}{/if}{if isset($field.stay) && $field.stay}AndStay{/if}"
						{if isset($field.class)}class="{$field.class}"{/if} class="button"/>
						
			</div>
		{/if}
	</div>
</form>
</fieldset>
{/block}