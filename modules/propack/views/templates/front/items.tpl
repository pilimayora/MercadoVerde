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

{capture name=path}
{$meta_title}
{/capture}


{if $propackis16 == 0}
{include file="$tpl_dir./breadcrumb.tpl"}

<h2>{$meta_title}</h2>
{else}
<h1 class="page-heading">{$meta_title}</h1>
{/if}


<div style="margin-top:10px;border:1px solid #CCCCCC;padding:5px">
{if $count_all > 0}

<div class="toolbar-top">
			
	<div class="sortTools {if $propackis16==1}sortTools16{/if}" id="show" style="margin-bottom: 10px;">
		<ul class="actions">
			<li class="frst">
					<strong>{l s='Items' mod='propack'}  ( <span id="count_items_top" style="color: #333;">{$count_all}</span> )</strong>
			</li>
		</ul>
	</div>

</div>


<div id="list_reviews" class="productsBox1">
{foreach from=$posts item=post name=myLoop}
	<table cellspacing="0" cellpadding="0" border="0" width="100%" class="productsTable compareTableNew {if $propackis16==1}float-left-table16{/if}">
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
{if $propackis16==1}<div class="clear"></div>{/if}
</div>


<div class="toolbar-bottom">
			
	<div class="sortTools {if $propackis16==1}sortTools16{/if}" id="show">
		
		<ul style="margin-left: 38%;">
			<li style="border: medium none; padding: 0pt;">	
			
			<table class="toolbar">
			<tbody>
			<tr class="pager">
				<td id="page_nav" class="pages">
					{$paging}
				</td>
			</tr>
			</tbody>
	</table>
</li>
		</ul>
		
			</div>

		</div>
{else}
	<div style="padding:10px;text-align:center;font-weight:bold">
	{l s='There are not news yet' mod='propack'}
	</div>
{/if}

</div>
