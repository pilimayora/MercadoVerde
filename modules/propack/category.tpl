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
					<strong>{l s='Posts' mod='propack'}  ( <span id="count_items_top" style="color: #333;">{$count_all}</span> )</strong>
			</li>
		</ul>
		
		{if $propackrsson == 1}
		<ul class="sorter">
			<li>
				<span>
				
			
					<a href="{$module_dir}rss.php" title="{l s='RSS Feed' mod='propack'}" target="_blank">
						<img src="{$module_dir}i/feed.png" alt="{l s='RSS Feed' mod='propack'}" />
					</a>
				</span>
			</li>
			
		</ul>
		{/if}
				
	</div>

</div>


<div id="list_reviews" class="productsBox1">
{foreach from=$posts item=post name=myLoop}
	<table cellspacing="0" cellpadding="0" border="0" width="100%" 
	class="productsTable compareTableNew {if $propackis16==1}float-left-table16{/if}">
		<tbody>
			<tr class="line1">
			<td class="info">
				
				<table width="100%">
					<tr>
					{if strlen($post.img)>0}
						<td style="background:none;border-bottom:none">
						{if $propackurlrewrite_on == 1}
							<a href="{$base_dir}{$propackiso_lng}blog/post/{$post.seo_url}" 
						   	   title="{$post.title|escape:'htmlall':'UTF-8'}">
						{else}
							<a href="{$base_dir}modules/propack/blockblog-post.php?post_id={$post.id}" 
						   	   title="{$post.title|escape:'htmlall':'UTF-8'}">
						{/if}   	   
								<img src="{$base_dir}upload/blockblog/{$post.img}" title="{$post.title|escape:'htmlall':'UTF-8'}" 
									 alt="{$post.title|escape:'htmlall':'UTF-8'}"
							    	 style="float:left;" />
							</a>
						
						</td>
					{/if}
						<td style="background:none;border-bottom:none;text-align: left;{if strlen($post.img)==0} width:100%{else} width:80%{/if}">
							<h3>
							{if $propackurlrewrite_on == 1}
								<a href="{$base_dir}{$propackiso_lng}blog/post/{$post.seo_url}" 
						   	  			 title="{$post.title|escape:'htmlall':'UTF-8'}">
										{$post.title|escape:'htmlall':'UTF-8'}
									</a>
							{else}
									<a href="{$base_dir}modules/propack/blockblog-post.php?post_id={$post.id}" 
						   	  			 title="{$post.title|escape:'htmlall':'UTF-8'}">
										{$post.title|escape:'htmlall':'UTF-8'}
									</a>
							{/if}
								</h3>
						</td>
					</tr>
				</table>
				
				
				<p class="commentbody_center">
				{$post.content|substr:0:140}
				{if strlen($post.content)>140}...{/if}
				{if $propackurlrewrite_on == 1}
				<a href="{$base_dir}{$propackiso_lng}blog/post/{$post.seo_url}" 
					   title="{$post.title|escape:'htmlall':'UTF-8'}">
				
				{else}
				<a href="{$base_dir}modules/propack/blockblog-post.php?post_id={$post.id}" 
					   title="{$post.title|escape:'htmlall':'UTF-8'}">
				{/if}
						{l s='more' mod='propack'}
				</a>
				<br/><br/>
				{if isset($post.category_ids[0].title)}
				<span class="foot_center">
				{l s='Posted in' mod='propack'}
				
				{foreach from=$post.category_ids item=category_item name=catItemLoop}
				   {if $propackurlrewrite_on == 1}
				   <a href="{$base_dir}{$propackiso_lng}blog/category/{$category_item.seo_url}"
					   title="{$category_item.title}">{$category_item.title}
					</a>
				   {else}
					<a href="{$base_dir}modules/propack/blockblog-category.php?category_id={$category_item.id}"
					   title="{$category_item.title}">{$category_item.title}
					</a>
				   {/if}
					{if count($post.category_ids)>1}
					{if $smarty.foreach.catItemLoop.first},&nbsp;{elseif $smarty.foreach.catItemLoop.last}&nbsp;{else},&nbsp;{/if}
					{else}
					
					{/if}
					
				{/foreach}
				</span>
				<br/><br/>
				{/if}
				
				<span class="foot_center">
				{if $propackp_list_displ_date == 1}
				{$post.time_add|date_format:"%d-%m-%Y"}, &nbsp;
				{/if}
				{if $propackurlrewrite_on == 1}
				<a href="{$base_dir}{$propackiso_lng}blog/post/{$post.seo_url}" 
					   title="{$post.title|escape:'htmlall':'UTF-8'}">
				
				{else}
				<a href="{$base_dir}modules/propack/blockblog-post.php?post_id={$post.id}" 
					   title="{$post.title|escape:'htmlall':'UTF-8'}">
				{/if}	
						{$post.count_comments} {l s='comments' mod='propack'}
				</a>
				
				</span>
				<br/>
				</p>
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
	{l s='There are not posts yet' mod='propack'}
	</div>
{/if}

</div>
{literal}
<script type="text/javascript">
function go_page_blog(page,item_id){
	
	$('#list_reviews').css('opacity',0.5);
	$.post(baseDir+'modules/propack/ajax.php', {
		action:'pagenav',
		page : page,
		item_id : item_id
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
