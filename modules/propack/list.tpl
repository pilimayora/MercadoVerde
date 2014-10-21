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
	<table cellspacing="0" cellpadding="0" border="0" width="100%" class="productsTable compareTableNew {if $propackis16==1}float-left-table16{/if}">
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