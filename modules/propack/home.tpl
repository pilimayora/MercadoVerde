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

<div class="propack-clear"></div>

{if $propackfbon == 1}

{if $propackpositionfb == "home"}

<div class="propack-block">
     <iframe src="http://www.facebook.com/plugins/likebox.php?href={$propacklb_facebook_page_url|escape:"url"}&amp;width={$propacklb_width}&amp;colorscheme=light&amp;show_faces={$propacklb_faces}&amp;border_color&amp;stream={$propacklb_stream}&amp;header={$propacklb_header}&amp;height={$propacklb_height}" scrolling="no" frameborder="0" style="{if $propacklb_transparency == "false"}background-color: {$propacklb_bg_color};{/if}border:none; overflow:hidden; width:{$propacklb_width}px; height:{$propacklb_height}px;" allowTransparency="{if $propacklb_transparency == "false"}false{else}true{/if}"></iframe>
  
</div>

{/if}
{/if}


{if $propacktwitteron == 1}

{if $propackposition == "home"}

{if !empty($propackuser_name) && !empty($propacktw_widgetid)}

<div class="propack-block">

{literal}
<script type="text/javascript">
	!function(d,s,id)
	{
		var js,fjs = d.getElementsByTagName(s)[0];
		if (!d.getElementById(id)) {
			js = d.createElement(s);
			js.id = id;
			js.src = "//platform.twitter.com/widgets.js";
			fjs.parentNode.insertBefore(js,fjs);
		}
	}(document,"script","twitter-wjs");
</script>
{/literal}


 <a class="twitter-timeline" href="https://twitter.com/{$propackuser_name}" 
    data-widget-id="{$propacktw_widgetid}" 
    {if isset($propacktw_color_scheme) && $propacktw_color_scheme == 'dark'}data-theme="dark"{/if}
    {if !empty($propacktweets_link)} data-link-color="{$propacktweets_link}"{/if}
    {if !empty($propacktw_aria_pol)} data-aria-polite="assertive"{/if}
    {if !empty($propackwidth)} width="{$propackwidth}"{/if}
    {if !empty($propackheight)} height="{$propackheight}"{/if}
    >Tweets {l s='by' mod='propack'} @{$propackuser_name}</a>
</div>
{/if}

{/if}

{/if}

{if $propackgwon == 1}

{if $propackpositiong == "home"}
<div class="propack-block">
{$propackgooglewidget}
</div>
{/if}

{/if}

{if $propack_isonpinwidget == 1}
<div class="propack-block">
{$propackpinterestwidget}
</div>
{/if}

<div class="propack-clear"></div>


{if $propackis15 == 1 || $propackis16 == 1}
<div id="left_column">
{/if}

{if $propackblogon == 1}

{if $propackblock_last_home == 1}

	<div id="blockblogblock_block_left"  class="block {if $propackis16 == 1}blockmanufacturer16{else}blockmanufacturer{/if}" 
			{if $propackis_ps15 == 0}style="margin-top:10px"{/if}>
		<h4 class="title_block" {if $propackrsson == 0}style="text-align:center;font-size:12px"{/if}>
			
			<div {if $propackrsson == 1}class="float-left"{/if}>
				{if $propackurlrewrite_on == 1}
				<a href="{$base_dir}{$propackiso_lng}blog"
				   title="{l s='Blog Posts recents' mod='propack'}"
					>{l s='Blog Posts recents' mod='propack'}</a>
				{else}
					<a href="{$module_dir}blockblog-all-posts.php"
					   title="{l s='Blog Posts recents' mod='propack'}"
						>{l s='Blog Posts recents' mod='propack'}</a>
						
				{/if}
			</div>
			{if $propackrsson == 1}
			<div class="float-left margin-left-5">
			
				<a href="{$module_dir}rss.php" title="{l s='RSS Feed' mod='propack'}" target="_blank">
					<img src="{$module_dir}i/feed.png" alt="{l s='RSS Feed' mod='propack'}" />
				</a>
			</div>
			{/if}
			
			<div class="clear"></div>
		</h4>
		<div class="block_content block-items-data">
		{if count($propackposts) > 0}
	    <ul>
	     {foreach from=$propackposts item=items name=myLoop1}
	    	{foreach from=$items.data item=blog name=myLoop}
	    	
	    	<li style="margin-top:5px; {if $propackis_ps15 == 0}border-bottom:1px dotted #CCCCCC{/if}">
	    		<table width="100%" {if $propackis16 == 1}class="home-blockblog-posts"{/if}>
	    		
	    				<tr>
	    				{if $propackblock_display_img == 1 && strlen($blog.img)>0}
	    					<td align="center" {if strlen($blog.img)>0}style="width:20%"{/if}>
	    					{if strlen($blog.img)>0}
	    					{if $propackurlrewrite_on == 1}
	    						<a href="{$base_dir}{$propackiso_lng}blog/post/{$blog.seo_url}" 
	    		  				title="{$blog.title}">
	    					{else}
	    						<a href="{$base_dir}modules/propack/blockblog-post.php?post_id={$blog.id}" 
	    		  				title="{$blog.title}">
	    		  			{/if}
	    						<img src="{$base_dir}upload/blockblog/{$blog.img}" title="{$blog.title}" 
	    						     alt="{$blog.title}" />
	    						</a>
	    					{/if}
	    					</td>
	    				{/if}
	    					<td>
	    						<table width="100%" >
	    							<tr>
	    								<td align="left">
	    								{if $propackurlrewrite_on == 1}
	    								<a href="{$base_dir}{$propackiso_lng}blog/post/{$blog.seo_url}" 
		    		  						   title="{$blog.title}"><b>{$blog.title}</b></a>
	    								{else}
	    									<a href="{$base_dir}modules/propack/blockblog-post.php?post_id={$blog.id}" 
		    		  						   title="{$blog.title}"><b>{$blog.title}</b></a>
		    		  					{/if}
		    		  					<div style="padding:5px">
		    		  					{$blog.content|strip_tags|substr:0:90}{if strlen($blog.content)>90}...{/if}
		    		  					</div>
	    								</td>
	    							</tr>
	    							{if $propackblock_display_date == 1}
	    							<tr>
	    								<td align="right">{$blog.time_add|date_format}</td>
	    							</tr>
	    							{/if}
	    						</table>
		    					
	    					</td>
	    				</tr>
	    		</table>
	    		
	    	</li>
	    	{/foreach}
	    {/foreach}
	    </ul>
	    {else}
		<div style="padding:10px">
			{l s='There are not Posts yet.' mod='propack'}
		</div>
		{/if}
		</div>
	</div>

{/if}


{/if}


{if $propackreviewson == 1}

{if $propackhomeon_snip == 1}

<div id="blockreviews_block_left" class="block {if $propackis16 == 1}blockmanufacturer16{else}blockmanufacturer{/if}" style="margin-top:10px">
		<h4 class="title_block" style="text-align:center">
			<div class="propack-float-left">
			{l s='Last Product Reviews' mod='propack'}
			</div>
			<div class="propack-float-left margin-left-5">
			{if $propackrsson_snip == 1}
				<a href="{$module_dir}rss_reviews.php" title="{l s='RSS Feed' mod='propack'}" target="_blank">
					<img src="{$module_dir}i/feed.png" alt="{l s='RSS Feed' mod='propack'}" />
				</a>
			{/if}
			</div>
			<div class="propack-clear"></div>
		</h4>
		<div class="block_content block-items-data">
			{if count($propackreviews)>0}
			<ul class="shoppers-block-items">
			{foreach from=$propackreviews item=review name=myLoop}
	    		<li>
	    			
	    			<table width="100%">
	    				<tr>
	    					<td align="center" style="width:20%;text-align:center">
	    						<a href="{$review.product_link}" 
	    		   	   			   title="{$review.product_name|escape:'htmlall':'UTF-8'}"
	    		   	   				>
	    						<img src="{$review.product_img}" title="{$review.product_name|escape:'htmlall':'UTF-8'}" 
	    							 alt = "{$review.product_name|escape:'htmlall':'UTF-8'}" style="height:45px" />
	    						</a>
	    					</td>
	    					<td>
	    						<table width="100%">
	    							<tr>
	    								<td>
	    									<a href="{$review.product_link}" 
	    		   	   						   title="{$review.product_name|escape:'htmlall':'UTF-8'}"
	    		   	   						   style="padding:{if $propackis16 == 1}10px 10px 10px 0px{else}5px 5px 5px 0px{/if}">
	    											{$review.product_name|escape:'htmlall':'UTF-8'}
	    										</a>	
	    								</td>
	    							</tr>
	    							<tr>
	    								<td>
	    									
	    									{section name=ratid loop=5}
							    				{if $smarty.section.ratid.index < $review.rating} 
								    				<img src="{$module_dir}images/ico-star.png" style="float:left" alt="{$smarty.section.ratid.index}"/>
								    			{else}
								    				<img src="{$module_dir}images/ico-star-grey.png" style="float:left" alt="{$smarty.section.ratid.index}"/>
								    			{/if}
								    			
											{/section}
											{if $propackx_reviews == 1}
											<span class="count_reviews"><a href="{$review.product_link}" 
	    		   	   						   title="{$review.product_name|escape:'htmlall':'UTF-8'}"
	    		   	   						   >({$review.count_reviews})</a></span>
	    		   	   						{/if}
	    		   	   						<div class="propack-clear"></div>
	    								</td>
	    							</tr>
	    						</table>
	    					</td>
	    				</tr>
	    				<tr>
	    					<td colspan="2">
	    						<a href="{$review.product_link}" 
	    		   	   			   title="{$review.text_review}"
	    		   	   				style="font-size:11px">
	    		   	   				{$review.text_review|strip_tags|substr:0:95}{if strlen($review.text_review)>95}...{/if}
	    						</a>
	    					</td>
	    				</tr>
	    			</table>
	    			
	    			
	    		   	
	    		</li>
	    	{/foreach}
	    	</ul>
	    	{else}
	    		<div style="padding:10px">
					{l s='There are not Product Reviews yet.' mod='propack'}
				</div>
	    	{/if}
	    </div>
</div>

{/if}

{/if}



{if $propacktestimon == 1}

{if $propackt_home == 1}

	<div id="blocktestim_block_left" class="block myaccount ps15-color-background {if $propackis16 == 1}blockshopreviews-block16{/if}" style="margin-top:10px">
		<h4 class="title_block" style="text-align:center;margin-bottom:0px">
		<div class="float-left">
			{if $propackurlrewrite_on == 1}
			<a href="{$base_dir}{$propackiso_lng}testimonials">{l s='Testimonials' mod='propack'}&nbsp;(&nbsp;{$propackcount_all_reviews_t}&nbsp;)</a>
		    {else}
				<a href="{$base_dir}modules/propack/blockshopreviews-form.php">{l s='Testimonials' mod='propack'}&nbsp;(&nbsp;{$propackcount_all_reviews_t}&nbsp;)</a>
			{/if}
		</div>
		<div class="float-left margin-left-5">
		{if $propacktrssontestim == 1}
			<a href="{$module_dir}rss_testimonials.php" title="{l s='RSS Feed' mod='propack'}" target="_blank">
				<img src="{$module_dir}i/feed.png" alt="{l s='RSS Feed' mod='propack'}" />
			</a>
		{/if}
		</div>
		<div class="clear"></div>
		</h4>
		
		<div class="block_content block-items-data">
	    {if $propackcount_all_reviews_t > 0}
	    
	    {foreach from=$propackreviews_t item=review name=myLoop}
	    <div class="rItem" style="width:auto">
			<div class="ratingBox">
				<small>{l s='Review By' mod='propack'} <b>{$review.name|escape:'htmlall':'UTF-8'}</b></small>						
			</div>
			<span style="font-size: 11px;">
			
				{$review.message|substr:0:100}
				{if strlen($review.message)>100}...{/if}
				
			</span>
			<br /><br />
			{if $propacktis_web == 1}
			{if strlen($review.web)>0}
			<small>
				<a title="http://{$review.web}" rel="nofollow" href="http://{$review.web}" 
				   target="_blank" style="font-size: 11px;color:#2580C7;text-decoration:underline"
				   >http://{$review.web}</a>
			</small>
			<br />
			{/if}
			{/if}
			<small>{$review.date_add|date_format:"%d-%m-%Y"}</small>
		</div>
		{/foreach}
		{else}
		<div class="rItem no-items-shopreviews">
			{l s='There are not testimonials yet.' mod='propack'}
		</div>
		{/if}
		</div>
	
	</div>
{/if}

{/if}


{if $propackfaqon == 1}

{if $propackfaq_home == 1}

	<div id="blockfaq_block_left" class="block {if $propackis16 == 1}blockmanufacturer16{else}blockmanufacturer{/if}" style="margin-top:10px">
		<h4 class="title_block" align="center">
		{if $propackurlrewrite_on == 1}
		<a href="{$base_dir}{$propackiso_lng}faq" title="{l s='FAQ' mod='propack'}">
		{else}
		<a href="{$base_dir}modules/propack/faq.php" title="{l s='FAQ' mod='propack'}">
		{/if}
			{l s='FAQ' mod='propack'}
		</a>
		</h4>
		<div class="block_content block-items-data">
		{if count($propackitemsblock) > 0}
	    <ul class="bullet">
	    	{foreach from=$propackitemsblock item=items name=myLoop1}
	    	{foreach from=$items.data item=item name=myLoop}
	    	<li class="{if $smarty.foreach.myLoop.first}first_item{elseif $smarty.foreach.myLoop.last}last_item{else}item{/if}">
	    	{if $propackurlrewrite_on == 1}
	    	<a href="{$base_dir}{$propackiso_lng}faq#faq_{$item.id}" 
	    		   title="{$item.title}">
	    	{else}
	    	<a href="{$base_dir}modules/propack/faq.php#faq_{$item.id}" 
	    		   title="{$item.title}">
	    	{/if}
	    		{$item.title}
	    	</a>
	    	</li>
	    	{/foreach}
	    	{/foreach}
	    </ul>
	     
	    {else}
		<div style="padding:10px;text-align:center">
			{l s='Questions not found.' mod='propack'}
		</div>
		{/if}
		</div>
	</div>
{/if}

{/if}


{if $propackguon == 1}

{if $propackg_home == 1}

	<div id="blockg_block_left" class="block blockmanufacturer" style="margin-top:10px">
		
		<h4 class="title_block" style="text-align:center">
			{if $propackurlrewrite_on == 1}
			<a href="{$base_dir_ssl}{$propackiso_lng}guestbook">
				{l s='Guestbook' mod='propack'}
			</a>
		    {else}
			<a href="{$base_dir_ssl}modules/propack/blockguestbook-form.php">
				{l s='Guestbook' mod='propack'}
			</a>
			{/if}
		</h4>
		
		<div class="block_content block-items-data">
		{if $propackcount_all_reviews_g > 0}
	    
	    
	    {foreach from=$propackreviews_g item=review name=myLoop}
	    <div class="rItem" style="width:auto">
			<div class="ratingBox">
				<small>{l s='Post By' mod='propack'} <b>{$review.name|escape:'htmlall':'UTF-8'}</b></small>						
			</div>
			<span style="font-size: 11px;">
			
				{$review.message|substr:0:100}
				{if strlen($review.message)>100}...{/if}
				
			</span>
			<br><br>
			
			<small>{$review.date_add|date_format:"%d-%m-%Y"}</small>
		</div>
		{/foreach}
	    
	    {else}
		<div style="padding:10px;text-align:center">
			{l s='There are not posts yet.' mod='propack'}
		</div>
		{/if}
		</div>
	</div>
{/if}

{/if}


{if $propacknewson == 1}

{if $propacknews_home == 1}

	<div id="blocknews_block_left" class="block {if $propackis16 == 1}blockmanufacturer16{else}blockmanufacturer{/if}" style="margin-top:10px">
		<h4 class="title_block" align="center">
		{if $propackurlrewrite_on == 1}
		<a href="{$base_dir}{$propackiso_lng}news">
		{else}
		<a href="{$base_dir}modules/propack/items.php">
		{/if}
			{l s='Last News' mod='propack'}
		</a>
		</h4>
		<div class="block_content block-items-data">
		{if count($propackitemsblocknews) > 0}
	    <ul>
	    {foreach from=$propackitemsblocknews item=items name=myLoop1}
	    	{foreach from=$items.data item=item name=myLoop}
	    	<li class="{if $smarty.foreach.myLoop.first}first_item{elseif $smarty.foreach.myLoop.last}last_item{else}item{/if}">
	    	
		    	<table width="100%">
		    				<tr>
		    				{if strlen($item.img)>0}
		    					<td align="center" width="20%" style="text-align:center">
		    						{if $propackurlrewrite_on == 1}
		    						<a href="{$base_dir}{$propackiso_lng}news/{$item.seo_url}" 
		    		  				title="{$item.title}">
		    		  				{else}
		    						<a href="{$base_dir}modules/propack/item.php?item_id={$item.id}" 
		    		  				title="{$item.title}">
		    		  				{/if}
		    						<img src="{$base_dir}upload/blocknews/{$item.img}" title="{$item.title}" />
		    						</a>
		    					</td>
		    				{/if}
		    					<td>
		    						<table width="100%">
		    							<tr>
		    								<td align="left">
		    									{if $propackurlrewrite_on == 1}
					    						<a href="{$base_dir}{$propackiso_lng}news/{$item.seo_url}" 
					    		  				title="{$item.title}" style="padding:5px">
					    		  				{else}
					    						<a href="{$base_dir}modules/propack/item.php?item_id={$item.id}" 
					    		  				title="{$item.title}" style="padding:5px">
					    		  				{/if}
		    									   <b>{$item.title}</b>
			    		  						</a>
		    								</td>
		    							</tr>
		    							<tr>
		    								<td align="left">{$item.time_add|date_format}</td>
		    							</tr>
		    						</table>
			    					
		    					</td>
		    				</tr>
		    		</table>
	    	</li>
	    		{/foreach}
	    	{/foreach}
	    </ul>
	    
	    {else}
		<div style="padding:10px">
			{l s='News not found.' mod='contentpack'}
		</div>
		{/if}
		</div>
	</div>
{/if}

{/if}


{if $propackis15 == 1 || $propackis16 == 1}
</div>
{/if}