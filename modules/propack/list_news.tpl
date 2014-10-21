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

{foreach from=$posts item=post name=myLoop}
	<table cellspacing="0" cellpadding="0" border="0" width="100%" class="productsTable compareTableNew">
		<tbody>
			<tr class="line1">
			<td class="info">
			
			<table width="100%">
				<tr>
				{if strlen($post.img)>0}
					<td style="background:none;border-bottom:none">
					{if $propackurlrewrite_on == 1}
						<a href="{$base_dir}{$propackiso_lng}news/{$post.seo_url}" 
					   title="{$post.title|escape:'htmlall':'UTF-8'}">
					{else}
						<a href="{$base_dir}modules/propack/item.php?item_id={$post.id}" 
					   title="{$post.title|escape:'htmlall':'UTF-8'}">
					{/if}
							<img src="{$base_dir}upload/blocknews/{$post.img}" 
							     title="{$post.title|escape:'htmlall':'UTF-8'}" 
							    />
						</a>
					</td>
				{/if}
					<td style="background:none;border-bottom:none;{if strlen($post.img)==0} width:100%{else} width:80%{/if}">
						<h3>
								{if $propackurlrewrite_on == 1}
									<a href="{$base_dir}{$propackiso_lng}news/{$post.seo_url}" 
								   title="{$post.title|escape:'htmlall':'UTF-8'}">
								{else}
									<a href="{$base_dir}modules/propack/item.php?item_id={$post.id}" 
								   title="{$post.title|escape:'htmlall':'UTF-8'}">
								{/if}
									{$post.title|escape:'htmlall':'UTF-8'}
								</a>
							</h3>
					</td>
				</tr>
			</table>
			
			<p class="commentbody_center">
				{$post.content|substr:0:140}
				{if strlen($post.content)>140}...{/if}
				
				{if $propackurlrewrite_on == 1}
				<a href="{$base_dir}{$propackiso_lng}news/{$post.seo_url}" 
				   title="{$post.title|escape:'htmlall':'UTF-8'}">
				{else}
				<a href="{$base_dir}modules/propack/item.php?item_id={$post.id}" 
				   title="{$post.title|escape:'htmlall':'UTF-8'}">
				{/if}
						{l s='more' mod='propack'}
				</a>
				
				<br><br>
				
				<span class="foot_center">{$post.time_add|date_format}</span>
				<br>
				</p>
			</td>
			</tr>
		</tbody>
	</table>
{/foreach}