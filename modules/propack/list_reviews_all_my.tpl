{*
/**
 * StorePrestaModules SPM LLC.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://storeprestamodules.com/LICENSE.txt
 *
 /*
 * 
 * @author    StorePrestaModules SPM <kykyryzopresto@gmail.com>
 * @category others
 * @package propack
 * @copyright Copyright (c) 2011 - 2014 SPM LLC. (http://storeprestamodules.com)
 * @license   http://storeprestamodules.com/LICENSE.txt
 */
*}

<table id="block-history" class="std">
		<tbody>
			<tr>
				<th class="first_item">
						{l s='Product' mod='propack'}
				</th>
				<th class="item" style="width:70px">
						{l s='Rating' mod='propack'}
				</th>
				
				{if $propacksubjecton == 1}
				<th class="item">
						{l s='Title' mod='propack'}
				</th>
				{/if}
				<th class="item">
						{l s='Text' mod='propack'}
				</th>
				<th class="item">
						{l s='Date Add' mod='propack'}
				</th>
				<th class="last_item">
						{l s='Status' mod='propack'}
				</th>
			</tr>
			{foreach from=$propackmy_reviews item=review}
			<tr>
				<td>
				<a href="{$review.product_link}" 
	    		   title="{$review.product_name}"
	    		   style="text-decoration:underline"
	    		   target="_blank">
	    			{$review.product_name}
	    		</a>	
				</td>
				
				<td>
				{if $review.rating != 0}
					{section name=ratid loop=5}
						{if $smarty.section.ratid.index < $review.rating} 
							<img src="{$module_dir}images/ico-star.png" class="gsniprev-img-star" alt="{$smarty.section.ratid.index}"/>
						{else}
							<img src="{$module_dir}images/ico-star-grey.png" class="gsniprev-img-star" alt="{$smarty.section.ratid.index}"/>
						{/if}
					{/section}
				{else}
					&nbsp;
				{/if}
				
				{if $propackrecommendedon == 1}
					<br/><br/>
					<div class="recommended">
						<span>{l s='Recommended to buy:' mod='propack'}</span> 
						{if $review.recommended_product == 1}
						<b class="yes">{l s='Yes' mod='propack'}</b>
						{else}
						<b class="no">{l s='No' mod='propack'}</b>
						{/if}
					</div>
				
				{/if}
				</td>
				
				{if $propacksubjecton == 1}
				<td>
				{if strlen($review.subject)>0}
					{$review.subject}
				{else}
					&nbsp;
				{/if}
				</td>
				{/if}
				
				<td>
				{if strlen($review.text_review)>0 }
					{$review.text_review|escape:'html':'UTF-8'|nl2br}
				{else}
					&nbsp;
				{/if}
				</td>
				
				<td>
				{dateFormat date=$review.date_add|escape:'html':'UTF-8' full=0}
				</td>
				<td>
				{if $review.active == 1}
				<img alt="{l s='Enabled' mod='propack'}" title="{l s='Enabled' mod='propack'}" 
				src="{$base_dir_ssl}img/admin/enabled.gif">
				{else}
				<img alt="{l s='Disabled' mod='propack'}" title="{l s='Disabled' mod='propack'}" 
				src="{$base_dir_ssl}img/admin/disabled.gif">
				{/if}
				</td>
			</tr>
			{/foreach}
		</tbody>
	</table>