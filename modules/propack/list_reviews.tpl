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

{foreach from=$reviews item=review}
<table class="prfb-table-reviews">
	<tr>
		<td class="prfb-left">
			<div class="prfb-name">{$review.customer_name|escape:'html':'UTF-8'}</div>
			<br/>
			{if $propackipon == 1}
			{if strlen($review.ip) > 0}
			<span class="prfb-time">{l s='IP:' mod='propack'} {$review.ip}</span>
			<br/>
			<br/>
			{/if}
			{/if}
			<span class="prfb-time">{dateFormat date=$review.date_add|escape:'html':'UTF-8' full=0}</span>
			<br/>
			<div class="rating">{$review.rating}</div>
		</td>
		<td class="prfb-right">
			<div class="h3" {if $propacksubjecton == 0}style="display:none"{/if}>{$review.subject}</div>
			<div class="rvTxt">
				<p>
					{$review.text_review|escape:'html':'UTF-8'|nl2br}
				</p>
			</div>
		</td>
	</tr>
	<tr {if $propackrecommendedon == 0}style="display:none"{/if}>
		<td class="prfb-left-bottom">&nbsp;</td>
		<td class="prfb-right-bottom" >
			
		 	<div class="recommended">
				<span>{l s='Recommended to buy:' mod='propack'}</span> 
				{if $review.recommended_product == 1}
				<b class="yes">{l s='Yes' mod='propack'}</b>
				{else}
				<b class="no">{l s='No' mod='propack'}</b>
				{/if}
			</div>
				<div class="prfb-clear"></div>
		</td>
	</tr>
</table>
{/foreach}

{literal}
<script type="text/javascript">
jQuery(document).ready(init_rating);
</script>
{/literal}