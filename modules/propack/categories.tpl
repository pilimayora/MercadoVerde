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
			
	<div class="{if $propackis16==1}sortTools sortTools16{else}sortTools{/if}" style="margin-bottom: 10px;">
		<ul class="actions">
			<li class="frst">
					<strong>{l s='Categories' mod='propack'}  ( <span id="count_items_top" style="color: #333;">{$count_all}</span> )</strong>
			</li>
		</ul>
	</div>

</div>


<div id="list_reviews" class="productsBox1">

{foreach from=$categories item=category name=myLoop}
	<table cellspacing="0" cellpadding="0" border="0" width="100%"
			class="productsTable compareTableNew {if $propackis16==1}float-left-table16{/if}">
		<tbody>
			<tr class="line1">
			<td class="info">
				
				<table width="100%">
					<tr>
					
						<td style="background:none;border-bottom:none;text-align: left;width:100%;">
							<h3>
							{if $propackurlrewrite_on == 1}
								<a href="{$base_dir}{$propackiso_lng}blog/category/{$category.seo_url}" 
						   	  			 title="{$category.title|escape:'htmlall':'UTF-8'}">
										{$category.title|escape:'htmlall':'UTF-8'}
									</a>
							{else}
									<a href="{$base_dir}modules/propack/blockblog-category.php?category_id={$category.id}" 
						   	  			 title="{$category.title|escape:'htmlall':'UTF-8'}">
										{$category.title|escape:'htmlall':'UTF-8'}
									</a>
							{/if}
								</h3>
						</td>
					</tr>
				</table>
				
				
				<br/><br/>
				
				
				<span class="foot_center">
				{if $propackc_list_display_date == 1}
					{$category.time_add|date_format:"%d-%m-%Y"}, &nbsp;
				{/if}
				{if $propackurlrewrite_on == 1}
				<a href="{$base_dir}{$propackiso_lng}blog/category/{$category.seo_url}" 
					   title="{$category.title|escape:'htmlall':'UTF-8'}">
						{$category.count_posts} {l s='posts' mod='propack'}
				</a>
				{else}
				<a href="{$base_dir}modules/propack/blockblog-category.php?category_id={$category.id}" 
					   title="{$category.title|escape:'htmlall':'UTF-8'}">
						{$category.count_posts} {l s='posts' mod='propack'}
				</a>
				{/if}
				</span>
				<br/>
				
			</td>
			</tr>
		</tbody>
	</table>
{/foreach}
{if $propackis16==1}<div class="clear"></div>{/if}
</div>


<div class="toolbar-bottom">
			
	<div class="{if $propackis16==1}sortTools sortTools16{else}sortTools{/if}" id="show">
		
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
	{l s='There are not category yet' mod='propack'}
	</div>
{/if}

</div>

{literal}
<script type="text/javascript">
function go_page_blog_cat(page){
	
	$('#list_reviews').css('opacity',0.5);
	$.post(baseDir + 'modules/propack/ajax.php', {
		action:'pagenavblogcat',
		page : page
	}, 
	function (data) {
		if (data.status == 'success') {
		
		$('#list_reviews').css('opacity',1);
		
		$('#list_reviews').html('');
		$('#list_reviews').prepend(data.params.content);
		
		$('#page_nav').html('');
		$('#page_nav').prepend(data.params.page_nav);
		
		
		
	    } else {
			$('#list_reviews').css('opacity',1);
			alert(data.message);
		}
		
	}, 'json');

}

</script>
{/literal}{if $propackis16 == 1}{literal}
<style type="text/css">
table td, table th{padding:0px}
</style>
{/literal}{/if}{literal}
{/literal}
