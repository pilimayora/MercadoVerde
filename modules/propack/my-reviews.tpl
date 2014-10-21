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

{literal}
<script type="text/javascript">
//<![CDATA[
	var baseDir = '{/literal}{$base_dir_ssl}{literal}';
//]]>
</script>
{/literal}

{if $propackis16 == 0}
{capture name=path}<a href="{$base_dir}my-account.php">{l s='My account' mod='propack'}</a>
<span class="navigation-pipe">{$navigationPipe}</span>{l s='Reviews' mod='propack'}{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}

<h2>{l s='Reviews' mod='propack'}</h2>
{else}
<h3 class="page-product-heading">{l s='Reviews' mod='propack'}</h3>
{/if}

{if count($propackmy_reviews)>0}
<div class="block-center" id="block-history">
	<div id="gsniprev-list">
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
	
	<div id="gsniprev-nav-pre">{$propackpaging}</div>
	
	</div>
	<div id="gsniprev-nav"></div>
	{literal}
<script type="text/javascript">
	function paging_reviewsnippets_all_my( page,id_product ){

		$('#gsniprev-list').css('opacity',0.5);
		$('#gsniprev-nav-pre').css('opacity',0.5);
		
		$.post(baseDir+'modules/propack/ajax.php', 
					{action:'navallmy',
					 page:page
					 }, 
		function (data) {
			if (data.status == 'success') {

				$('#gsniprev-list').css('opacity',1);
				$('#gsniprev-nav-pre').css('opacity',1);
				
				$('#gsniprev-list').html('');
				var content = $('#gsniprev-list').prepend(data.params.content);
		    	$(content).hide();
		    	$(content).fadeIn('slow');

		    	$('#gsniprev-nav').html('');
				var paging = $('#gsniprev-nav').prepend(data.params.paging);
		    	$(paging).hide();
		    	$(paging).fadeIn('slow');
		    	
			} else {
				alert(data.message);
			}
		}, 'json');
	}
</script>
{/literal}
</div>
{else}
<div style="border:1px solid #C4C4C4;background:#FAFAFA;padding:10px">
	{l s='There are not Product Reviews yet.' mod='propack'}
</div>
{/if}

{if $propackis16 == 0}
<ul class="footer_links">
	<li><a href="{$base_dir}my-account.php"><img src="{$img_dir}icon/my-account.gif" alt="" class="icon" /></a>
		<a href="{$base_dir}my-account.php">{l s='Back to Your Account' mod='propack'}</a></li>
	<li><a href="{$base_dir}"><img src="{$img_dir}icon/home.gif" alt="" class="icon" /></a>
		<a href="{$base_dir}">{l s='Home' mod='propack'}</a></li>
</ul>
{/if}