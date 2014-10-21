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

<script type="text/javascript">
//<![CDATA[
{literal}
	var baseDir = '{/literal}{$base_dir_ssl}{literal}';
{/literal}
//]]>
</script>

{if $propackis16 == 0}
{capture name=path}<a href="{$base_dir}my-account.php">{l s='My account' mod='propack'}</a><span class="navigation-pipe">{$navigationPipe}</span>{l s='Social Referrals' mod='propack'}{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}

<h2>{l s='Social Referrals' mod='propack'}</h2>
{else}
<h3 class="page-product-heading">{l s='Social Referrals' mod='propack'}</h3>
{/if}


<div class="block-center" id="block-history">
	<table id="order-list" class="std">
		<tbody>
			
			<tr class="alternate_item">
				<td class="history_date" style="border:none">
				{if $propackfbrefon == 1}
				
					<div style="display:block; text-align:center; clear:both;">
                    <div class="facebook_share float-left">
                		<div class="facebook_share_l float-left"></div>
                		<div class="facebook_share_bg float-left">
                			<span>
                				<a href="javascript:void(0)" onclick="share_facebook();"
                					title="{$propackfdefaulttext}">{$propackfdefaulttext}</a>
                			</span>
                		</div>
                		<div class="facebook_share_r float-left" ></div>
                		<div class="clear"></div>
            		</div>
                    
                    <div class="facebook-count float-left">{$propackfe}/{$propackfrefnum}</div>
                    
                    <div class="clear"></div>
                    
    				</div>			
					
					<br/>
				{/if}
				
				{if $propacktwrefon == 1}
				<!-- twitter referrals -->
				<div style="display:block; text-align:center; clear:both;">
                    <div class="twitter_share float-left">
                		<div class="twitter_share_l float-left"></div>
                		<div class="twitter_share_bg float-left">
                			<span>
                				{literal}
									<script type="text/javascript">
									   //Twitter Widgets JS
										            window.twttr = (function (d,s,id) {
										             var t, js, fjs = d.getElementsByTagName(s)[0];
										            if (d.getElementById(id)) return; js=d.createElement(s); js.id=id;
										            js.src="//platform.twitter.com/widgets.js"; fjs.parentNode.insertBefore(js, fjs);
										            return window.twttr || (t = { _e: [], ready: function(f){ t._e.push(f) } });
										            }(document, "script", "twitter-wjs"));

										            twttr.ready(function(twttr) {       
										                twttr.events.bind('tweet', function (event) {
										                	addRemoveDiscount('twitter');
										                	//alert("twitter");
										                });
										            }); 
									</script>
								{/literal}
                				
                				<a href="https://twitter.com/intent/tweet?url={$propackurl}&amp;text={$propackname}" 
                				title="{$propacktdefaulttext}">{$propacktdefaulttext}</a>
                				
                			</span>
                		</div>
                		<div class="twitter_share_r float-left" ></div>
                		<div class="clear"></div>
            		</div>
            		
            		<div class="twitter-count float-left">{$propackte}/{$propacktrefnum}</div>
            		<div class="clear"></div>
                    
    			</div>
				<!-- twitter referrals -->
				
				
				<br/>
				{/if}
				
				{if $propackgrefon == 1}
				<!-- google referrals -->
				
				<table style="cellpadding:0px; cellspacing:0px; border:0px;" class="google_b float-left">
					<tr>
						<td class="leftside">
							<g:plusone size="{$propackgsize}" callback="doGoogle" href="{$propackurl}"></g:plusone>
						</td>
						<td class="rightside">
							{$propackgdefaulttext}
						</td>
					<td  class="rightside border-white">
							<div class="google-count">{$propackge}/{$propackgrefnum}</div>
							
            			</td>
					</tr>
				</table>
				<div class="clear"></div>
				
				<!-- google referrals -->
				
				   <br/>
				{/if}
				
				{if $propacklrefon == 1 && $propackis_l==1}
				{literal}
				<script src="//platform.linkedin.com/in.js" type="text/javascript"></script>
				{/literal}
            	
				<table style="cellpadding:0px; cellspacing:0px; border:0px;" class="l_top float-left">
					<tr>
						<td class="leftside">
						{literal}
							<script type="IN/Share" data-counter="{/literal}{$propacklsize}{literal}" data-onSuccess="doLinkedIn" data-url="{/literal}{$propackurl}{literal}"></script>
						{/literal}
						</td>
						<td class="rightside">
							{$propackldefaulttext}
						</td>
					<td  class="rightside border-white">
						<div class="linkedin-count ">{$propackle}/{$propacklrefnum}</div>
						</td>
					</tr>
				</table>
				<div class="clear"></div>
				
				
            	{/if}
				
				</td>
			</tr>
		</tbody>
	</table>
</div>


<br />
<h2>{l s='Coupons' mod='propack'}</h2>

{literal}
<style type="text/css">
table.std th, table.table_block th{padding:5px!important}
</style>
{/literal}

{if isset($discount) && count($discount) && $nbDiscounts}
<table class="discount std">
	<thead>
		<tr>
			<th class="discount_code first_item">{l s='Code' mod='propack'}</th>
			<th class="discount_description item">{l s='Description' mod='propack'}</th>
			<th class="discount_quantity item">{l s='Quantity' mod='propack'}</th>
			<th class="discount_value item">{l s='Value' mod='propack'}*</th>
			<th class="discount_minimum item">{l s='Minimum' mod='propack'}</th>
			<th class="discount_cumulative item">{l s='Cumulative' mod='propack'}</th>
			<th class="discount_expiration_date last_item">{l s='Expiration date' mod='propack'}</th>
		</tr>
	</thead>
	<tbody>
	{foreach from=$discount item=discountDetail name=myLoop}
		<tr class="{if $smarty.foreach.myLoop.first}first_item{elseif $smarty.foreach.myLoop.last}last_item{else}item{/if} {if $smarty.foreach.myLoop.index % 2}alternate_item{/if}">
			<td class="discount_code">{$discountDetail.name}</td>
			<td class="discount_description">{$discountDetail.description}</td>
			<td class="discount_quantity">{$discountDetail.quantity_for_user}</td>
			<td class="discount_value">
				{if $discountDetail.id_discount_type == 1}
					{$discountDetail.value|escape:'htmlall':'UTF-8'}%
				{elseif $discountDetail.id_discount_type == 2}
					{convertPrice price=$discountDetail.value}
				{else}
					{l s='Free shipping' mod='propack'}
				{/if}
			</td>
			<td class="discount_minimum">
				{if $discountDetail.minimal == 0}
					{l s='none' mod='propack'}
				{else}
					{convertPrice price=$discountDetail.minimal}
				{/if}
			</td>
			<td class="discount_cumulative">
				{if $discountDetail.cumulable == 1}
					<img src="{$module_dir}img/yes.gif" alt="{l s='Yes' mod='propack'}" class="icon" />
				{else}
					<img src="{$module_dir}img/no.gif" alt="{l s='No' mod='propack'}" class="icon" />
				{/if}
			</td>
			<td class="discount_expiration_date">{dateFormat date=$discountDetail.date_to}</td>
		</tr>
	{/foreach}
	</tbody>
</table>
<p>
	*{l s='Tax included' mod='propack'}
</p>
{else}
<div style="padding: 10px; text-align: center;border:1px solid #BDC2C9">
{l s='You do not possess any coupons.' mod='propack'}
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