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

{foreach from=$categories item=category name=myLoop}
	<table cellspacing="0" cellpadding="0" border="0" width="100%" class="productsTable compareTableNew {if $propackis16==1}float-left-table16{/if}">
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