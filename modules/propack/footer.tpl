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
<script type="text/javascript"><!--
//<![CDATA[

{/literal}
{if $blockfacebookappid != '' && $blockfacebooksecret != ''}
{literal}


window.fbAsyncInit = function() {
	FB.init({appId: '{/literal}{$propackappid}{literal}', 
		     status: true, 
		     cookie: true, 
		     xfbml: true,
             oauth: true});
	{/literal}{if !$propackislogged}{literal}
	return;
	{/literal}{/if}{literal}
	
	FB.getLoginStatus(function(response) {
	   if (response.status == 'connected') {
	      greet();
	   }
	});
};


	function login(){
		$.post(baseDir+'modules/propack/ajax.php', 
					{action:'login',
					 secret:'{/literal}{$blockfacebooksecret}{literal}',
					 appid:'{/literal}{$blockfacebookappid}{literal}'
					 }, 
		function (data) {
			if (data.status == 'success') {
						
				{/literal}{if $propackorder_page == 1}{literal}
					var url = "{/literal}{$base_dir_ssl}{$propackuri|urldecode}{literal}";
				{/literal}{else}{literal}		
					var url = "{/literal}http://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI|urldecode}{literal}";
				{/literal}{/if}{literal}		
				window.location.href= url;
				
				
						
			} else {
				alert(data.message);
			}
		}, 'json');
	}
	function logout(){
				var url = "{/literal}{$base_dir}index.php?mylogout{literal}";
				$('#fb-log-out').html('');
				$('#fb-log-out').html('Log in');
				$('#fb-fname-lname').remove();
				window.location.href= url;
	}
	function greet(){
	   FB.api('/me', function(response) {
		   
		var src = 'https://graph.facebook.com/'+response.id+'/picture';
		//$('#header_user_info span').append('<img style="margin-left:5px" height="20" src="'+src+'"/>');
			
		{/literal}{if !$propackislogged}{literal}
			login();
		{/literal}{/if}{literal}
		 });
	}


	   function fblogin(){
		   
			FB.init({appId: '{/literal}{$blockfacebookappid}{literal}', 
					status: true, 
					cookie: true, 
					xfbml: true,
		         	oauth: true});
         	
				FB.login(function(response) {
		            if (response.status == 'connected') {
			            login();
		            } else {
		                // user is not logged in
		                logout();
		            }
		        }, {scope:'email,user_birthday'});
		       
		        return false;
			}
	   {/literal}
{else}
{literal}
function fblogin(){
	alert("{/literal}{l s='Error: Please fill Facebook App Id and Facebook Secret Key in settings with module ' mod='propack'}{$name_module}{literal}");
	return;	
}
{/literal}
{/if}
{literal}
// ]]>--></script>
{/literal}   



<div class="propack-clear"></div>
{if $propackfbon == 1}

{if $propackpositionfb == "footer"}

<div class="propack-block">
   <iframe src="http://www.facebook.com/plugins/likebox.php?href={$propacklb_facebook_page_url|escape:"url"}&amp;width={$propacklb_width}&amp;colorscheme=light&amp;show_faces={$propacklb_faces}&amp;border_color&amp;stream={$propacklb_stream}&amp;header={$propacklb_header}&amp;height={$propacklb_height}" scrolling="no" frameborder="0" style="{if $propacklb_transparency == "false"}background-color: {$propacklb_bg_color};{/if}border:none; overflow:hidden; width:{$propacklb_width}px; height:{$propacklb_height}px;" allowTransparency="{if $propacklb_transparency == "false"}false{else}true{/if}"></iframe>
   
</div>
{/if}
{/if}


{if $propacktwitteron == 1}

{if $propackposition == "footer"}

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

{if $propackpositiong == "footer"}
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



{if $propackblogon == 1}

<div class="clear"></div>
<br/>

{if $propackcat_footer == 1}

	<div id="blockblogcat_block_footer"  class="block footer-block {if $propackis16 == 1}blockmanufacturer16-footer{else}blockmanufacturer{/if}" style="width:{if $propackis_ps15 == 0}190{else}200{/if}px;float:left;margin-right:10px;margin-left:10px">
		<h4 style="text-align:center;" {if $propackis16 == 1}class="footer-blocks-border-white-h4"{/if}>
		{if $propackurlrewrite_on == 1}
			<a href="{$base_dir}{$propackiso_lng}blog/categories"
			   title="{l s='Blog Categories' mod='propack'}"
				>{l s='Blog Categories' mod='propack'}</a>
		{else}
			<a href="{$module_dir}blockblog-categories.php"
			   title="{l s='Blog Categories' mod='propack'}"
				>{l s='Blog Categories' mod='propack'}</a>
				
		{/if}
		</h4>
		<div class="block_content block-items-data toggle-footer {if $propackis16 == 1}footer-blocks-border-white-content{/if}">
		{if count($propackcategories) > 0}
	    <ul class="bullet">
	    {foreach from=$propackcategories item=items name=myLoop1}
	    	{foreach from=$items.data item=blog name=myLoop}
	    	
	    	<li class="{if $smarty.foreach.myLoop.first}first_item{elseif $smarty.foreach.myLoop.last}last_item{else}item{/if}">
	    		{if $propackurlrewrite_on == 1}
	    		<a href="{$base_dir}{$propackiso_lng}blog/category/{$blog.seo_url}" 
	    		   title="{$blog.title}">{$blog.title}</a>
	    		{else}
	    		<a href="{$base_dir}modules/propack/blockblog-category.php?category_id={$blog.id}" 
	    		   title="{$blog.title}">{$blog.title}</a>
	    		{/if}
	    		
	    	</li>
	    	{/foreach}
	    {/foreach}
	    </ul>
	     <p style="margin-top:10px">
	     {if $propackurlrewrite_on == 1}
	    	 <a title="{l s='View all categories' mod='propack'}" 
				href="{$base_dir}{$propackiso_lng}blog/categories">{l s='View all categories' mod='propack'} >></a>
	     {else}
			<a title="{l s='View all categories' mod='propack'}" 
				href="{$module_dir}blockblog-categories.php">{l s='View all categories' mod='propack'} >></a>
		  {/if}
		</p>
	    {else}
		<div style="padding:10px">
			{l s='There are not Categories yet.' mod='propack'}
		</div>
		{/if}
		</div>
	</div>
{/if}


{if $propackposts_footer == 1}

	<div id="blockblogposts_block_footer" class="block footer-block {if $propackis16 == 1}blockmanufacturer16-footer{else}blockmanufacturer{/if} blockblog-block" style="width:{if $propackis_ps15 == 0}190{else}200{/if}px;float:left;margin-right:10px;">
		<h4 {if $propackrsson == 0}style="text-align:center;font-size:12px"{/if} {if $propackis16 == 1}class="footer-blocks-border-white-h4"{/if}>
			
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
		<div class="block_content block-items-data toggle-footer {if $propackis16 == 1}footer-blocks-border-white-content{/if}">
		{if count($propackposts) > 0}
	    <ul>
	     {foreach from=$propackposts item=items name=myLoop1}
	    	{foreach from=$items.data item=blog name=myLoop}
	    	
	    	<li style="{if $propackis16 == 0}margin-top:5px;{/if}{if $propackis_ps15 == 0}border-bottom:1px dotted #CCCCCC{/if}">
	    		<table width="100%">
	    				<tr>
	    				{if $propackblock_display_img == 1}
	    					<td align="center">
	    					{if strlen($blog.img)>0}
	    					{if $propackurlrewrite_on == 1}
	    						<a href="{$base_dir}{$propackiso_lng}blog/post/{$blog.seo_url}" 
	    		  				title="{$blog.title}">
	    					{else}
	    						<a href="{$base_dir}modules/propack/blockblog-post.php?post_id={$blog.id}" 
	    		  				title="{$blog.title}">
	    		  			{/if}
	    						<img src="{$base_dir}upload/blockblog/{$blog.img}" title="{$blog.title}" 
	    							alt="{$blog.title}"  />
	    						</a>
	    					{/if}
	    					</td>
	    				{/if}
	    					<td>
	    						<table width="100%">
	    							<tr>
	    								<td align="left">
	    								{if $propackurlrewrite_on == 1}
	    								<a href="{$base_dir}{$propackiso_lng}blog/post/{$blog.seo_url}" 
		    		  						   title="{$blog.title}"><b>{$blog.title}</b></a>
	    								{else}
	    									<a href="{$base_dir}modules/propack/blockblog-post.php?post_id={$blog.id}" 
		    		  						   title="{$blog.title}"><b>{$blog.title}</b></a>
		    		  					{/if}
	    								</td>
	    							</tr>
	    							{if $propackblock_display_date == 1}
	    							<tr>
	    								<td align="left">{$blog.time_add|date_format}</td>
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
	     <p style="margin-top:10px">
	      {if $propackurlrewrite_on == 1}
				<a href="{$base_dir}{$propackiso_lng}blog"
				   title="{l s='View all posts' mod='propack'}"
					>{l s='View all posts' mod='propack'} >></a>
		  {else}
				<a href="{$module_dir}blockblog-all-posts.php"
				   title="{l s='View all posts' mod='propack'}"
					>{l s='View all posts' mod='propack'} >></a>
						
		  {/if}
		</p>
	    
	    {else}
		<div style="padding:10px">
			{l s='There are not Posts yet.' mod='propack'}
		</div>
		{/if}
		</div>
	</div>
{/if}



{if $propackarch_footer == 1}
<div id="blockblogarch_block_footer"  class="block footer-block {if $propackis16 == 1}blockmanufacturer16-footer{else}blockmanufacturer{/if}" style="width:{if $propackis_ps15 == 0}190{else}200{/if}px;float:left;margin-right:10px">
	<h4 {if $propackis16 == 1}class="footer-blocks-border-white-h4"{/if}>{l s='Blog Archives' mod='propack'}</h4>
	
       	<div class="block_content block-items-data toggle-footer {if $propackis16 == 1}footer-blocks-border-white-content{/if}">
                
                 {if sizeof($propackarch)>0}
                 
          			<ul class="bullet">
          				{foreach from=$propackarch item=items key=year name=myarch}
          				<li><a class="arch-category" href="javascript:void(0)" 
          					   onclick="show_arch({$smarty.foreach.myarch.index},'footer')">{$year}</a></li>
          				<div id="arch{$smarty.foreach.myarch.index}footer" 
    						{if $smarty.foreach.myarch.first}{else}style="display:none"{/if}
    						>
          					{foreach from=$items item=item name=myLoop1}
    					<li class="arch-subcat">
    					{if $propackurlrewrite_on == 1}
    						<a class="arch-subitem" href="{$base_dir}{$propackiso_lng}blog?y={$year}&m={$item.month}">
    							{$item.time_add|date_format:"%B"}&nbsp;({$item.total})
    						</a>
    					{else}
    						<a class="arch-subitem" href="{$module_dir}blockblog-all-posts.php?y={$year}&m={$item.month}">
    							{$item.time_add|date_format:"%B"}&nbsp;({$item.total})
    						</a>
    					 {/if} 
    					</li>
    						{/foreach}
    					</div>
    					{/foreach}
    				</ul>
    				
                   {else}
                   <div style="padding:10px">
    			  		{l s='There are not Archives yet.' mod='propack'}
    			  	</div>
    			   {/if}
                 
     		</div>
	
</div>
{/if}

{if $propacksearch_footer == 1}
<div id="blockblogsearch_block_footer" class="block footer-block  {if $propackis16 == 1}blockmanufacturer16-footer{else}blockmanufacturer{/if} search_blog" style="width:{if $propackis_ps15 == 0}190{else}200{/if}px;float:left;">
	<h4 {if $propackis16 == 1}class="footer-blocks-border-white-h4"{/if}>{l s='Search in Blog' mod='propack'}</h4>
	<div class="block-items-data toggle-footer">
	{if $propackurlrewrite_on == 1}
     <form method="get" action="{$base_dir}{$propackiso_lng}blog">
    {else}
     <form method="get" action="{$module_dir}blockblog-all-posts.php">
    {/if}
       	<div class="block_content {if $propackis16 == 1}footer-blocks-border-white-content{/if}">
                 <p>
                    <input type="text" size="18" value="" name="search" {if $propackis_ps15 == 0}class="search_text"{/if}>
                    <input type="submit" value="go" class="button_mini {if $propackis_ps15 == 0}search_go{/if}">
                    {if $propackis_ps15 == 0}<div class="clear"></div>{/if}
                </p>
     		</div>
	</form>
	</div>
</div>
{/if}



<div class="clear"></div>


{/if}



{$propackfootersnippet}

{$propackbreadcrambcustom}

{if $propackpinvis_on == 1 && $propackis_product_page != 0}

{literal}
<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>
{/literal}

{/if}

<div class="clear"></div>

{if $propacktestimon == 1}

{if $propackt_footer == 1}


	<div id="blocktestim_block_footer"  class="block footer-block myaccount ps15-color-background {if $propackis16 == 1}blockshopreviews-footer16{/if}" style="float:left;margin:5px;{if $propackis_ps15 == 1}color:black{/if}">
		<h4 style="text-align:center; {if $propackis16 == 1}border-top:1px!important{/if}" >
		
		<div class="float-left">
			{if $propackurlrewrite_on == 1}
					<a {if $propackis_ps15 == 1}style="color:black"{/if} href="{$base_dir}{$propackiso_lng}testimonials"
					>{l s='Testimonials' mod='propack'}&nbsp;(&nbsp;{$propackcount_all_reviews_t}&nbsp;)</a>
		   {else}
				<a href="{$base_dir}modules/propack/blockshopreviews-form.php" {if $propackis_ps15 == 1}style="color:black"{/if}
				>{l s='Testimonials' mod='propack'}&nbsp;(&nbsp;{$propackcount_all_reviews_t}&nbsp;)</a>
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
		
		<div class="block-items-data toggle-footer">
	    {if $propackcount_all_reviews_t > 0}
	    
	    {foreach from=$propackreviews_t item=review name=myLoop}
	    <div class="rItem" {if $propackis_ps15 == 1}style="padding:0px"{/if}>
			<div class="ratingBox">
				<small>{l s='Review By' mod='propack'} <b>{$review.name|escape:'htmlall':'UTF-8'}</b></small>						
			</div>
			<span style="font-size: 11px;">
			
				{$review.message|substr:0:50}
				{if strlen($review.message)>50}...{/if}
				
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
		
	    
	    
	   <div class="submit_testimonal" align="center">
	   {if $propackurlrewrite_on == 1}
	   <a title="{l s='Submit Testimonial' mod='propack'}" class="exclusive_large" 
	  		   href="{$base_dir}{$propackiso_lng}testimonials">{l s='Submit Testimonial' mod='propack'}</a>
	   {else}
	  		<a title="{l s='Submit Testimonial' mod='propack'}" class="exclusive_large" 
	  		   href="{$base_dir}modules/propack/blockshopreviews-form.php">{l s='Submit Testimonial' mod='propack'}</a>
	   {/if}
		</div>
		</div>
	
	</div>
{/if}

{/if}


{if $propackfaqon == 1}

{if $propackfaq_footer == 1}
	<div id="blockfaq_block_footer" class="block footer-block {if $propackis16 == 1}blockmanufacturer16-footer{else}blockmanufacturer{/if}" style="float:left;margin:5px;width:193px">
	
		<h4 align="center" class="footer-blocks-border-white-h4">
		{if $propackurlrewrite_on == 1}
		<a href="{$base_dir}{$propackiso_lng}faq" title="{l s='FAQ' mod='propack'}">
		{else}
		<a href="{$base_dir}modules/propack/faq.php" title="{l s='FAQ' mod='propack'}">
		{/if}
			{l s='FAQ' mod='propack'}
		</a>
		</h4>
		<div class="block_content footer-blocks-border-white-content block-items-data toggle-footer">
		{if count($propackitemsblock) > 0}
	    <ul class="bullet">
	    	{foreach from=$propackitemsblock item=items name=myLoop1}
	    	{foreach from=$items.data item=item name=myLoop}
	    	<li class="{if $smarty.foreach.myLoop.first}first_item{elseif $smarty.foreach.myLoop.last}last_item{else}item{/if}">
	    	{if $propackurlrewrite_on == 1}
	    	<a href="{$base_dir}{$propackiso_lng}faq#faq_{$item.id}" 
	    		   title="{$item.title}" {if $propackis16 == 0}style="color:black"{/if}>
	    	{else}
	    	<a href="{$base_dir}modules/propack/faq.php#faq_{$item.id}" 
	    		   title="{$item.title}" {if $propackis16 == 0}style="color:black"{/if}>
	    	{/if}
	    		{$item.title}
	    	</a>
	    	</li>
	    	{/foreach}
	    	{/foreach}
	    </ul>
	     <p style="margin-top:10px;text-align:center">
	     {if $propackurlrewrite_on == 1}
	    	 <a title="{l s='View all' mod='propack'}" 
				 href="{$base_dir}{$propackiso_lng}faq" {if $propackis16 == 0}style="color:black"{/if}>{l s='View all' mod='propack'} >></a>
	     {else}
			<a title="{l s='View all' mod='propack'}" 
				href="{$base_dir}modules/propack/faq.php" {if $propackis16 == 0}style="color:black"{/if}>{l s='View all' mod='propack'} >></a>
		  {/if}
		</p>
	    {else}
		<div style="padding:10px;color:black">
			{l s='Questions not found.' mod='propack'}
		</div>
		{/if}
		</div>
	</div>
{/if}

{/if}



{if $propackguon == 1}

{if $propackg_footer == 1}
	<div id="blockblogsearch_block_footer" class="block footer-block {if $propackis16 == 1}blockguestbook-footer16{/if}" style="float:left;margin:5px;width:193px">
		
		<h4 style="text-align:center;" class="footer-blocks-border-white-h4">
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
		
		<div class="block_content block-items-data toggle-footer" style="background:white">
		{if $propackcount_all_reviews_g > 0}
	    
	    
	    {foreach from=$propackreviews_g item=review name=myLoop}
	    <div class="rItem" style="color:black">
			<div class="ratingBox">
				<small>{l s='Post By' mod='propack'} <b>{$review.name|escape:'htmlall':'UTF-8'}</b></small>						
			</div>
			<span style="font-size: 11px;">
			
				{$review.message|substr:0:47}
				{if strlen($review.message)>47}...{/if}
				
			</span>
			<br><br>
			
			<small>{$review.date_add|date_format:"%d-%m-%Y"}</small>
		</div>
		{/foreach}
	   
	    <p align="center">
	    {if $propackurlrewrite_on == 1}
	    	<a class="button_large" title="{l s='View all posts' mod='propack'}" 
			   href="{$base_dir_ssl}{$propackiso_lng}guestbook"
			style="color:black;{if $propackis16 == 1}margin-bottom:10px{/if}">
	    {else}
			<a class="button_large" title="{l s='View all posts' mod='propack'}" 
			   href="{$base_dir_ssl}modules/propack/blockguestbook-form.php"
			style="color:black;{if $propackis16 == 1}margin-bottom:10px{/if}">
		{/if}
				{l s='View all posts' mod='propack'}
			</a>
		</p>
	    
	    {else}
		<div style="padding:10px;color:black">
			{l s='There are not posts yet.' mod='propack'}
		</div>
		{/if}
		</div>
	</div>
{/if}

{/if}


{if $propacknewson == 1}

{if $propacknews_footer == 1}
	<div id="blockblogsearch_block_footer" class="block footer-block {if $propackis16 == 1}blockmanufacturer16-footer{else}blockmanufacturer{/if}" style="float:left;margin:5px;width:193px">
		<h4 align="center" style="border:1px solid white;border-bottom:none">
		{if $propackurlrewrite_on == 1}
		<a href="{$base_dir}{$propackiso_lng}news">
		{else}
		<a href="{$base_dir}modules/propack/items.php">
		{/if}
			{l s='Last News' mod='propack'}
		</a>
		</h4>
		<div class="block_content block-items-data toggle-footer" style="border:1px solid white">
		{if count($propackitemsblocknews) > 0}
	    <ul>
	    {foreach from=$propackitemsblocknews item=items name=myLoop1}
	    	{foreach from=$items.data item=item name=myLoop}
	    	<li class="{if $smarty.foreach.myLoop.first}first_item{elseif $smarty.foreach.myLoop.last}last_item{else}item{/if}">
	    	
		    	<table width="100%">
		    				<tr>
		    				{if strlen($item.img)>0}
		    					<td align="center" width="40%">
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
					    		  				title="{$item.title}">
					    		  				{else}
					    						<a href="{$base_dir}modules/propack/item.php?item_id={$item.id}" 
					    		  				title="{$item.title}">
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
	    
	    <p style="text-align:center;margin-top:5px;margin-bottom:5px">
			{if $propackurlrewrite_on == 1}
			<a class="button_large" title="{l s='View all news' mod='propack'}" 
			href="{$base_dir}{$propackiso_lng}news">
			{else}
			<a class="button_large" title="{l s='View all news' mod='propack'}" 
			href="{$module_dir}items.php">
			{/if}
			{l s='View all news' mod='propack'}
			</a>
		</p>
	    
	    {else}
		<div style="padding:10px">
			{l s='News not found.' mod='propack'}
		</div>
		{/if}
		</div>
	</div>
{/if}

{/if}

<div class="clear"></div>