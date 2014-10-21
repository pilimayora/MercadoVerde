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
{if $propackurlrewrite_on == 1}
<a href="{$base_dir}{$propackiso_lng}news">
{else}
<a href="{$base_dir}modules/propack/items.php">
{/if}
{l s='News' mod='propack'}</a>
	<span class="navigation-pipe">></span>
{$meta_title}
{/capture}

{include file="$tpl_dir./breadcrumb.tpl"}

<h2>{$meta_title}</h2>
<div class="blog-post-item">

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
					
							<img src="{$base_dir}upload/blocknews/{$post.img}" 
							     title="{$post.title|escape:'htmlall':'UTF-8'}" 
							    />
					</td>
				{/if}
					<td style="background:none;border-bottom:none;{if strlen($post.img)==0} width:100%{else} width:80%{/if}">
						<h3>
								{$post.title|escape:'htmlall':'UTF-8'}
						</h3>
					</td>
				</tr>
			</table>
			
			
				<p class="commentbody_center">
				{$post.content}
				<br><br>
				
				<div class="share-buttons-item">

				<!-- Place this tag where you want the +1 button to render -->
				<g:plusone size="small" href="http://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}" 
						   count="false"></g:plusone>
				
				<!-- Place this tag after the last plusone tag -->
				{literal}
				<script type="text/javascript">
				  (function() {
				    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
				    po.src = 'https://apis.google.com/js/plusone.js';
				    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
				  })();
				</script>
				{/literal}
				
					<a href="http://twitter.com/?status={$meta_title|escape:'htmlall':'UTF-8'} : http://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}" rel="nofollow" target="_blank" title="Twitter">
					       <img src="{$base_dir}modules/propack/i/share/1292323517.png" alt="Twitter">
					</a>
					<a href="http://www.facebook.com/share.php?u=http://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}" rel="nofollow" target="_blank" title="Facebook">
					      <img src="{$base_dir}modules/propack/i/share/1292323398.png" alt="Facebook">
					</a>
					<a href="http://www.myspace.com/Modules/PostTo/Pages/?u=http://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}" rel="nofollow" target="_blank" title="MySpace">
					       <img src="{$base_dir}modules/propack/i/share/1292323442.png" alt="MySpace">
					</a>
					<a href="https://www.google.com/bookmarks/mark?op=add&amp;bkmk=http://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}&amp;title={$meta_title|escape:'htmlall':'UTF-8'}" rel="nofollow" target="_blank" title="Google Bookmarks">
					      <img src="{$base_dir}modules/propack/i/share/1293027456.png" alt="Google Bookmarks">
					</a>
					<a href="http://bookmarks.yahoo.com/toolbar/savebm?opener=tb&amp;u=http://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}&amp;t={$meta_title|escape:'htmlall':'UTF-8'}" rel="nofollow" target="_blank" title="Yahoo! Bookmarks">
					       <img src="{$base_dir}modules/propack/i/share/1293094139.png" alt="Yahoo! Bookmarks">
					</a>
					<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=http://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}&amp;title={$meta_title|escape:'htmlall':'UTF-8'}" rel="nofollow" target="_blank" title="LinkedIn">
					       <img src="{$base_dir}modules/propack/i/share/1292323420.png" alt="LinkedIn">
					</a>
					<a href="http://www.mixx.com/submit?page_url=http://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}" rel="nofollow" target="_blank" title="Mixx">
					       <img src="{$base_dir}modules/propack/i/share/1292323430.png" alt="Mixx">
					</a>
					<a href="http://reddit.com/submit?url=http://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}&amp;title={$meta_title|escape:'htmlall':'UTF-8'}" rel="nofollow" target="_blank" title="Reddit">
					      <img src="{$base_dir}modules/propack/i/share/1292323468.png" alt="Reddit">
					</a>
					<a href="http://www.stumbleupon.com/submit?url=http://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}&amp;title={$meta_title|escape:'htmlall':'UTF-8'}" rel="nofollow" target="_blank" title="StumbleUpon">
						   <img src="{$base_dir}modules/propack/i/share/1292323491.png" alt="StumbleUpon">
					</a>
						<a href="http://digg.com/submit?phase=2&amp;url=http://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}" rel="nofollow" target="_blank" title="Digg">
					       <img src="{$base_dir}modules/propack/i/share/1292323357.png" alt="Digg">
					</a>
					<a href="http://del.icio.us/post?url=http://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}" rel="nofollow" target="_blank" title="Del.icio.us">
					       <img src="{$base_dir}modules/propack/i/share/1292323295.png" alt="Del.icio.us">
					</a>
				</div>	
			
			
				
				<span class="foot_center" style="float:left;margin-left:10px" >{$post.time_add|date_format}</span>
				<div style="clear:both"></div>
				<br>
				</p>
			</td>
			</tr>
		</tbody>
	</table>
{/foreach}
{if $propackis16==1}<div class="clear"></div>{/if}
</div>


</div>