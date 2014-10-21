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

{if $propack_leftcolumnf == "leftcolumnf" || $propack_leftcolumng == "leftcolumng" 
    || $propack_leftcolumnp == "leftcolumnp" || $propack_leftcolumnt == "leftcolumnt" 
	|| $propack_leftcolumny == "leftcolumny" || $propack_leftcolumnl == "leftcolumnl"
	|| $propack_leftcolumnlive == "leftcolumnlive" 
	|| $propack_footerm == "footerm" || $propack_leftcolumnc == "leftcolumnc"
	|| $propack_leftcolumnfl == "leftcolumnfl" || $propack_leftcolumnw == "leftcolumnw"
	|| $propack_leftcolumna == "leftcolumna"}

{if !$propackislogged}

<div class="block">
		<h4 style="text-align:left;{if $propackis16 == 1}margin-bottom:0px{/if}">{l s='Your account' mod='propack'}</h4>
<form action="{$base_dir_ssl}{if $propackis_rewrite == 1}{$propackiso_lang}{if $propackis15 == 1}login{else}authentication{/if}{else}authentication.php{/if}" method="post">
		<fieldset style="border-bottom:1px none #D0D3D8;border-top:none;background-color:#F1F2F4">
		<div class="form_content clearfix">
			<p class="text" style="padding-bottom:10px">
				<br/>
				<label for="email" style="margin-left:10px"><b>{l s='E-mail:' mod='propack'}</b></label>
				<br/>
				<span  style="margin-left:10px"><input type="text" id="email" name="email" 
							 value="{if isset($smarty.post.email)}{$smarty.post.email|escape:'htmlall'|stripslashes}{/if}" 
							 class="account_input" style="width:14em"/>
				</span>
			</p>
			<p class="text" style="padding-bottom:10px">
				<br/>
				<label for="passwd"  style="margin-left:10px"><b>{l s='Password:' mod='propack'}</b></label>
				<br/>
				<span  style="margin-left:10px"><input type="password" id="passwd" name="passwd" 
							 value="{if isset($smarty.post.passwd)}{$smarty.post.passwd|escape:'htmlall'|stripslashes}{/if}" 
							 class="account_input" style="width:14em"/>
				</span>
			</p>
				{if isset($back)}
					<input type="hidden" class="hidden" name="back" value="{$back|escape:'htmlall':'UTF-8'}"  style="margin-left:10px" />
				{/if}
				
				<div class="fbtwgblock-columns15">
				<input type="submit" id="SubmitLogin" name="SubmitLogin" class="button" 
						value="{l s='Log in' mod='propack'}" />
				<div style="clear:both"></div>
				{if $propack_leftcolumnf == "leftcolumnf"}
				<a href="javascript:void(0)" onclick="return fblogin();" 
				   title="Facebook" >
	   				<img src="{$propackfacebooksmallimg}" alt="Facebook"  />
	 			</a>
	 			{/if}
	 			{if $propack_leftcolumnt == "leftcolumnt"}
	 			<a href="javascript:void(0)" title="Twitter" 
		   		  	{if $propacktconf == 1}
		   		        onclick="javascript:popupWin = window.open('{$base_dir}modules/propack/twitter.php{if $propackorder_page == 1}?http_referer={$propackhttp_referer|urlencode}{/if}', 'login', 'location,width=600,height=600,top=0'); popupWin.focus();"
			   		{else}
						onclick="alert('{$terror|escape:'htmlall'}')"
					{/if}  
					>
						<img src="{$propacktwittersmallimg}" alt="Twitter" />
				</a>
				{/if}
	 			{if $propack_leftcolumng == "leftcolumng"}
	 			<a href="javascript:void(0)" title="Google" 
		   		   onclick="javascript:popupWin = window.open('{$base_dir}modules/propack/login.php?p=google{if $propackorder_page == 1}&http_referer={$propackhttp_referer|urlencode}{/if}', 'openId', 'location,width=512,height=512,top=0');popupWin.focus();">
						<img src="{$propackgooglesmallimg}" alt="Google" />
				</a>
				{/if}
				 {if $propack_leftcolumny == "leftcolumny"}
				<a href="javascript:void(0)" title="Yahoo"
		   			onclick="javascript:popupWin = window.open('{$base_dir}modules/propack/login.php?p=yahoo{if $propackorder_page == 1}&http_referer={$propackhttp_referer|urlencode}{/if}', 'openId', 'location,width=400,height=300,top=0');popupWin.focus();">
					<img src="{$propackyahoosmallimg}" alt="Yahoo"  />
				</a>
	 			{/if}
				{if $propack_leftcolumnp == "leftcolumnp"}
	 			<a href="javascript:void(0)" title="Paypal" 
		   		   	{if $propackpconf == 1} 
		   		   		onclick="javascript:popupWin = window.open('{$base_dir}modules/propack/paypalconnect.php{if $propackorder_page == 1}?http_referer={$propackhttp_referer|urlencode}{/if}', 'openId', 'location,width=512,height=512,top=0');popupWin.focus();">
		   			{else}
						onclick="alert('{$perror|escape:'htmlall'}')">
					{/if}
						<img src="{$propackpaypalsmallimg}" alt="Paypal" />
				</a>
				{/if}
				{if $propack_leftcolumnl == "leftcolumnl"}
	 			<a href="javascript:void(0)" title="LinkedIn" 
		   		  {if $propacklconf == 1}  
		   		   onclick="javascript:popupWin = window.open('{$base_dir}modules/propack/linkedin.php{if $propackorder_page == 1}?http_referer={$propackhttp_referer|urlencode}{/if}', 'openId', 'location,width=512,height=512,top=0');popupWin.focus();">
		   		{else}
					onclick="alert('{$lerror|escape:'htmlall'}')">
				{/if}
					<img src="{$propacklinkedinsmallimg}" alt="LinkedIn" />
				</a>
				{/if}
				{if $propack_leftcolumnm == "leftcolumnm" }
	 			<a href="javascript:void(0)" title="Microsoft Live"
	 			{if $propackmconf == 1}
		   		   onclick="javascript:popupWin = window.open('{$base_dir}modules/propack/microsoft.php{if $propackorder_page == 1}?http_referer={$propackhttp_referer|urlencode}{/if}', 'openId', 'location,width=512,height=512,top=0');popupWin.focus();">
		   		{else}
		        	onclick="alert('{$merror|escape:'htmlall'}')">
				{/if} 
						<img src="{$propackmicrosoftsmallimg}" alt="Microsoft Live" />
				</a>
				{/if}
				{if $propack_leftcolumnlive == "leftcolumnlive"}
				<a href="javascript:void(0)" title="Livejournal"
		   			onclick="javascript:popupWin = window.open('{$base_dir}modules/propack/login.php?p=livejournal{if $propackorder_page == 1}&http_referer={$propackhttp_referer|urlencode}{/if}', 'openId', 'location,width=400,height=300,top=0');popupWin.focus();">
					<img src="{$propacklivejournalsmallimg}" alt="Livejournal"  />
				</a>
	 			{/if}
	 			
	 			
	 			{if $propack_leftcolumnc == "leftcolumnc"}
				<a href="javascript:void(0)" title="Clavid"
		   			onclick="javascript:popupWin = window.open('{$base_dir}modules/propack/login.php?p=clavid{if $propackorder_page == 1}&http_referer={$propackhttp_referer|urlencode}{/if}', 'openId', 'location,width=400,height=300,top=0');popupWin.focus();">
					<img src="{$propackclavidsmallimg}" alt="Clavid"  />
				</a>
	 			{/if}
	 			{if $propack_leftcolumnfl == "leftcolumnfl"}
				<a href="javascript:void(0)" title="Flickr"
		   			onclick="javascript:popupWin = window.open('{$base_dir}modules/propack/login.php?p=flickr{if $propackorder_page == 1}&http_referer={$propackhttp_referer|urlencode}{/if}', 'openId', 'location,width=400,height=300,top=0');popupWin.focus();">
					<img src="{$propackflickrsmallimg}" alt="Flickr"  />
				</a>
	 			{/if}
	 			{if $propack_leftcolumnw == "leftcolumnw"}
				<a href="javascript:void(0)" title="Wordpress"
		   			onclick="javascript:popupWin = window.open('{$base_dir}modules/propack/login.php?p=wordpress{if $propackorder_page == 1}&http_referer={$propackhttp_referer|urlencode}{/if}', 'openId', 'location,width=400,height=300,top=0');popupWin.focus();">
					<img src="{$propackwordpresssmallimg}" alt="Wordpress"  />
				</a>
	 			{/if}
	 			{if $propack_leftcolumna == "leftcolumna"}
				<a href="javascript:void(0)" title="Aol"
		   			onclick="javascript:popupWin = window.open('{$base_dir}modules/propack/login.php?p=aol{if $propackorder_page == 1}&http_referer={$propackhttp_referer|urlencode}{/if}', 'openId', 'location,width=400,height=300,top=0');popupWin.focus();">
					<img src="{$propackaolsmallimg}" alt="Aol" />
				</a>
	 			{/if}
	 			<a href="#" class="propack-last"></a>
				<div style="clear:both"></div>
				</div>
			<p class="lost_password" style="margin-top:10px;">
				<a style="margin-left:10px" href="{$base_dir}{if $propackis_rewrite == 1}{$propackiso_lang}password-recovery{else}password.php{/if}">{l s='Forgot your password?' mod='propack'}</a>
			</p>
			</div>
		</fieldset>
</form>
</div>

{else}
<div class="block">
		<h4 style="text-align:left;{if $propackis16 == 1}margin-bottom:0px{/if}">{l s='Your account' mod='propack'}</h4>
		<div class="block_content" style="background-color:#F1F2F4">
		<br/>
		<p style="padding-left:10px">
			{l s='Welcome' mod='propack'},<br/> <b>{$customerName}</b> (<a href="{$base_dir}{if $propackis_rewrite == 1}{$propackiso_lang}{else}index.php{/if}?mylogout" 
											 title="{l s='Log out' mod='propack'}"
											 style="text-decoration:underline">{l s='Log out' mod='propack'}</a>)
		</p>
		<br/>
		
		<div style="padding-left:10px">
				<img src="{$module_dir}img/icon/my-account.gif" alt="{l s='Your Account' mod='propack'}"/>
				<a href="{$base_dir_ssl}{if $propackis_rewrite == 1}{$propackiso_lang}my-account{else}my-account.php{/if}" 
				   title="{l s='Your Account' mod='propack'}"><b>{l s='Your Account' mod='propack'}</b></a>
		</div>  
		 <br/> 
		<div style="padding-left:10px">
			<img src="{$module_dir}img/icon/cart.gif" alt="{l s='Your Shopping Cart' mod='propack'}"/>
			<a href="{$base_dir_ssl}{if $propackis_rewrite == 1}{$propackiso_lang}order{else}order.php{/if}" title="{l s='Your Shopping Cart' mod='propack'}"><b>{l s='Cart:' mod='propack'}</b></a>
			<span class="ajax_cart_quantity{if $cart_qties == 0} hidden{/if}">{$cart_qties}</span>
			<span class="ajax_cart_product_txt{if $cart_qties != 1} hidden{/if}">{l s='product' mod='propack'}</span>
			<span class="ajax_cart_product_txt_s{if $cart_qties < 2} hidden{/if}">{l s='products' mod='propack'}</span>
			
				<span class="ajax_cart_total{if $cart_qties == 0} hidden{/if}">
					{if $priceDisplay == 1}
						{convertPrice price=$cart->getOrderTotal(false, 4)}
					{else}
						{convertPrice price=$cart->getOrderTotal(true, 4)}
					{/if}
				</span>
			<span class="ajax_cart_no_product{if $cart_qties > 0} hidden{/if}">{l s='(empty)' mod='propack'}</span> 
		</div>
		 <br/>
		</div>
</div>

{/if}

{/if}



{if $propacktwitteron == 1}

{if $propackposition == "left"}
{if !empty($propackuser_name) && !empty($propacktw_widgetid)}

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

{/if}
{/if}

{/if}


{if $propackfbon == 1}

{if $propackpositionfb == "left"}
<div class="facebook_like_box_block">

    
   
    
    <iframe src="http://www.facebook.com/plugins/likebox.php?href={$propacklb_facebook_page_url|escape:"url"}&amp;width={$propacklb_width}&amp;colorscheme=light&amp;show_faces={$propacklb_faces}&amp;border_color&amp;stream={$propacklb_stream}&amp;header={$propacklb_header}&amp;height={$propacklb_height}" scrolling="no" frameborder="0" style="{if $propacklb_transparency == "false"}background-color: {$propacklb_bg_color};{/if}border:none; overflow:hidden; width:{$propacklb_width}px; height:{$propacklb_height}px;" allowTransparency="{if $propacklb_transparency == "false"}false{else}true{/if}"></iframe>
  
    
   
</div>
{/if}
{/if}

{if $propackgwon == 1}

{if $propackpositiong == "left"}

{$propackgooglewidget}

{/if}

{/if}


{if $propack_isonpinwidget == 1}
{$propackpinterestwidget}
{/if}



{if $propackblogon == 1}

{if $propackcat_left == 1}

	<div id="blockblogcat_block_left" class="block  {if $propackis16 == 1}blockmanufacturer16{else}blockmanufacturer{/if}" style="margin-top:10px">
		<h4 class="title_block" style="text-align:center">
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
		<div class="block_content">
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


{if $propackposts_left == 1}

	<div id="blockblogposts_block_left" class="block {if $propackis16 == 1}blockmanufacturer16{else}blockmanufacturer{/if}" >
		<h4 class="title_block"  {if $propackrsson == 0}style="text-align:center;font-size:12px"{/if}>
			
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
		<div class="block_content">
		{if count($propackposts) > 0}
	    <ul>
	     {foreach from=$propackposts item=items name=myLoop1}
	    	{foreach from=$items.data item=blog name=myLoop}
	    	
	    	<li style="margin-top:5px;{if $propackis_ps15 == 0}border-bottom:1px dotted #CCCCCC{/if}">
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


{if $propackarch_left == 1}
<div id="blockblogarch_block_left" class="block {if $propackis16 == 1}blockmanufacturer16{else}blockmanufacturer{/if} search_blog" >
	<h4 class="title_block">{l s='Blog Archives' mod='propack'}</h4>
	
       	<div class="block_content">
                <p>
                {if sizeof($propackarch)>0}
          			<ul class="bullet">
          				{foreach from=$propackarch item=items key=year name=myarch}
          				<li><a class="arch-category" href="javascript:void(0)" 
          					   onclick="show_arch({$smarty.foreach.myarch.index},'left')">{$year}</a></li>
          				<div id="arch{$smarty.foreach.myarch.index}left" 
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
    				{l s='There are not Archives yet.' mod='propack'}
    				{/if}
                   
                 </p>
     		</div>
	
</div>
{/if}

{if $propacksearch_left == 1}
<div id="blockblogsearch_block_left" class="block {if $propackis16 == 1}blockmanufacturer16{else}blockmanufacturer{/if} search_blog" >
	<h4 class="title_block">{l s='Search in Blog' mod='propack'}</h4>
	{if $propackurlrewrite_on == 1}
     <form method="get" action="{$base_dir}{$propackiso_lng}blog">
    {else}
     <form method="get" action="{$module_dir}blockblog-all-posts.php">
    {/if}
       	<div class="block_content">
                 <p>
                    <input type="text" value="" name="search" {if $propackis_ps15 == 0}class="search_text"{/if}>
                    <input type="submit" value="go" class="button_mini {if $propackis_ps15 == 0}search_go{/if}">
                    {if $propackis_ps15 == 0}<div class="clear"></div>{/if}
                </p>
     		</div>
	</form>
</div>
{/if}

{/if}




<div id="blockreviews_block_left"  class="block">

{if $propackreviewson == 1}

{if $propackposition == "left"}



<div class="block blockmanufacturer" >
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
		<div class="block_content">
			{if count($propackreviews)>0}
			<ul class="shoppers-block-items">
			{foreach from=$propackreviews item=review name=myLoop}
	    		<li>
	    			
	    			<table width="100%">
	    				<tr>
	    					<td align="center">
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
	    								<td style="padding-bottom:7px">
	    									<a href="{$review.product_link}" 
	    		   	   						   title="{$review.product_name|escape:'htmlall':'UTF-8'}"
	    		   	   						   >
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
	    		   	   				>
	    		   	   				{$review.text_review|strip_tags|substr:0:45}{if strlen($review.text_review)>45}...{/if}
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

{$propackleftsnippet}



{if $propackpinvis_on == 1 && $propack_leftColumn == 'leftColumn' 
&& $propackpinbutton_on == 1}
<a href="//www.pinterest.com/pin/create/button/?
		url=http://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}
		&media={$product_image}
		&description={$meta_description|escape:'htmlall':'UTF-8'}" 
  data-pin-do="buttonPin" data-pin-config="{if $propackpbuttons == 'firston'}above{/if}{if $propackpbuttons == 'secondon'}beside{/if}{if $propackpbuttons == 'threeon'}none{/if}">
  <img src="//assets.pinterest.com/images/pidgets/pin_it_button.png" />
</a>
{/if}

</div>


{if $propacktestimon == 1}

{if $propackt_left == 1}

	<div id="blocktestim_block_left" class="block myaccount {if $propackis_ps15 == 1}ps15-color-background{/if} {if $propackis16 == 1}blockshopreviews-block16{/if}">
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
		
		<div class="block_content">
	    {if $propackcount_all_reviews_t > 0}
	    
	    {foreach from=$propackreviews_t item=review name=myLoop}
	    <div class="rItem">
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

{if $propackfaq_left == 1}

	<div id="blockfaq_block_left" class="block {if $propackis16 == 1}blockmanufacturer16{else}blockmanufacturer{/if}" >
		<h4 class="title_block" align="center">
		{if $propackurlrewrite_on == 1}
		<a href="{$base_dir}{$propackiso_lng}faq" title="{l s='FAQ' mod='propack'}">
		{else}
		<a href="{$base_dir}modules/propack/faq.php" title="{l s='FAQ' mod='propack'}">
		{/if}
			{l s='FAQ' mod='propack'}
		</a>
		</h4>
		<div class="block_content">
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
	     <p style="margin-top:10px;text-align:center">
	     {if $propackurlrewrite_on == 1}
	    	 <a title="{l s='View all' mod='propack'}" 
				 href="{$base_dir}{$propackiso_lng}faq">{l s='View all' mod='propack'} >></a>
	     {else}
			<a title="{l s='View all' mod='propack'}" 
				href="{$base_dir}modules/propack/faq.php">{l s='View all' mod='propack'} >></a>
		  {/if}
		</p>
	    {else}
		<div style="padding:10px">
			{l s='Questions not found.' mod='propack'}
		</div>
		{/if}
		</div>
	</div>
{/if}

{/if}



{if $propackguon == 1}

{if $propackg_left == 1}

	<div id="blockg_block_left" class="block blockmanufacturer {if $propackis16 == 1}blockguestbook-block16{/if}" >
		
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
		
		<div class="block_content">
		{if $propackcount_all_reviews_g > 0}
	    
	    
	    {foreach from=$propackreviews_g item=review name=myLoop}
	    <div class="rItem">
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
			>
	    {else}
			<a class="button_large" title="{l s='View all posts' mod='propack'}" 
			   href="{$base_dir_ssl}modules/propack/blockguestbook-form.php"
			>
		{/if}
				{l s='View all posts' mod='propack'}
			</a>
		</p>
	    
	    {else}
		<div style="padding:10px">
			{l s='There are not posts yet.' mod='propack'}
		</div>
		{/if}
		</div>
	</div>
{/if}

{/if}


{if $propacknewson == 1}

{if $propacknews_left == 1}

	<div id="blocknews_block_left" class="block {if $propackis16 == 1}blockmanufacturer16{else}blockmanufacturer{/if}" >
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
	    
	    <p style="text-align:center;margin-top:5px">
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