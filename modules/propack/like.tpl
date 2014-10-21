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

<li style="background:none">
<table width="100%" class="buttons-propack">
<tr>
{if $propacktwitterbon == 1}

<td>
	{if $propackbuttons == "firston"}
		<a href="http://twitter.com/share" class="twitter-share-button" 
			   			data-url="http://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}"
		           		data-counturl="http://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}"
		           		data-via="#"
				   		data-count="vertical">Tweet</a>
		
		
	{/if}
	
	{if $propackbuttons == "secondon"}
		<a href="http://twitter.com/share" class="twitter-share-button" 
			   			data-url="http://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}"
		           		data-counturl="http://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}"
		           		data-via="#"
				   		data-count="horizontal">Tweet</a>
		
		
	{/if}
	
	{if $propackbuttons == "threeon"}
		<a href="http://twitter.com/share" class="twitter-share-button" 
			   			data-url="http://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}"
		           		data-counturl="http://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}"
		           		data-via="#"
				   		data-count="none">Tweet</a>
		
		
	{/if}
</td>
{/if}

{if $propacklikeon == 1}
	
<td>
		<div class="fb-like" data-href="http://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}" 
			data-width="{$propackwidthlikebox}" 
			data-colorscheme="{$propacklikecolor}" data-layout="{$propacklikelayout}" data-action="like" 
			data-show-faces="{$propacklikefaces}" data-send="false"></div>
</td>


{/if}
	


	{if $propackstatus1 == "on"}
<td>
		
				
			{if $propackbuttons1 == "1gon"}
			
				<div class="g-plusone" href="http://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}" data-size="medium" data-count="true"></div>
				
			{/if}
			
			{if $propackbuttons1 == "2gon"}
			<div class="g-plusone" data-size="tall" href="http://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}" data-count="true"></div>
				
			{/if}
</td>
	{/if}
	

	
	


{if $propackpinterestbon == 1}
<td {if $propackpinterestbuttons == "firston"}style="vertical-align: bottom;"{/if}>
	{if $propackpinterestbuttons == "firston"}
		
		
		<a href="http://pinterest.com/pin/create/button/?url=http://{$smarty.server.HTTP_HOST|escape:"url"}{$smarty.server.REQUEST_URI|escape:"url"}&media={$propackimg|escape:"url"}&description={$meta_description|escape:"url"}" 
		   class="pin-it-button" count-layout="vertical" style="background:none;padding-left:0px;display:inline">
		 	<img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>
		
		{literal}
		<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>
		{/literal}
	
	{/if}
	
	{if $propackpinterestbuttons == "secondon"}
			
	<a href="http://pinterest.com/pin/create/button/?url=http://{$smarty.server.HTTP_HOST|escape:"url"}{$smarty.server.REQUEST_URI|escape:"url"}&media={$propackimg|escape:"url"}&description={$meta_description|escape:"url"}" 
		 class="pin-it-button" count-layout="horizontal" style="background:none;padding-left:0px;display:inline">
		 <img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>
		
		{literal}
		<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>
		{/literal}

		
		
	{/if}
	
</td>
{/if}

		
{if $propacklinkedinbon == 1}
<td>
	{if $propacklinkedinbuttons == "firston"}
		{literal}
		<script type="IN/Share" data-url="http://{/literal}{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}{literal}" data-counter="top"></script>
		{/literal}
	{/if}
	
	{if $propacklinkedinbuttons == "secondon"}
		{literal}
		<script type="IN/Share" data-url="http://{/literal}{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}{literal}" data-counter="right"></script>
		{/literal}
	{/if}
	
	{if $propacklinkedinbuttons == "threeon"}
		{literal}
		<script type="IN/Share" data-url="http://{/literal}{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}{literal}"></script>
		{/literal}
	{/if}
</td>
{/if}

</tr>
</table>

</li>




{if $propackfbrefon == 1 || $propacktwrefon == 1 || $propackgrefon == 1 || $propacklrefon == 1}



{if $propackfbrefon == 1 && $propack_psextraLeftf == "psextraLeftf"}
	<div style="display:block; text-align:center; clear:both;">
                    <div class="facebook_share float-left">
                		<div class="facebook_share_l float-left"></div>
                		<div class="facebook_share_bg float-left">
                			<span>
                				<a href="javascript:void(0)" onclick="share_facebook();"
                					title="{$propackfdefaulttext}">{$propackfdefaulttext}</a>
                			</span>
                		</div>
                		<div class="facebook_share_r float-left" ></div>
                		<div class="clear"></div>
            		</div>
                    
                    <div class="facebook-count float-left">{$propackfe}/{$propackfrefnum}</div>
                    
                    <div class="clear"></div>
                    
    				</div>			
					
			<br/>
{/if}


{if $propacktwrefon == 1 && $propack_psextraLeftt == "psextraLeftt"}
				<!-- twitter referrals -->
				<div style="display:block; text-align:center; clear:both;">
                    <div class="twitter_share float-left">
                		<div class="twitter_share_l float-left"></div>
                		<div class="twitter_share_bg float-left">
                			<span>
                				<a href="https://twitter.com/intent/tweet?url={$propackurl}&amp;text={$propackname}" 
                				title="{$propacktdefaulttext}">{$propacktdefaulttext}</a>
                				
                			</span>
                		</div>
                		<div class="twitter_share_r float-left" ></div>
                		<div class="clear"></div>
            		</div>
            		
            		<div class="twitter-count float-left">{$propackte}/{$propacktrefnum}</div>
            		<div class="clear"></div>
                    
    			</div>
				<!-- twitter referrals -->
				
				
				<br/>
{/if}


{if $propackgrefon == 1 && $propack_psextraLeftg == "psextraLeftg"}
				<!-- google referrals -->
				
				<table style="cellpadding:0px; cellspacing:0px; border:0px;" class="google_b float-left">
					<tr>
						<td class="leftside">
							<g:plusone size="{$propackgsize}" callback="doGoogle" href="{$propackurl}"></g:plusone>
						</td>
						<td class="rightside">
							{$propackgdefaulttext}
						</td>
					<td  class="rightside border-white">
							<div class="google-count">{$propackge}/{$propackgrefnum}</div>
							
            			</td>
					</tr>
				</table>
				<div class="clear"></div>
				
				<!-- google referrals -->
				
				   <br/>
{/if}

{if $propacklrefon == 1 && $propackis_l==1 && $propack_psextraLeftl == "psextraLeftl"}
				{literal}
				<script src="//platform.linkedin.com/in.js" type="text/javascript"></script>
				{/literal}
            	
				<table style="cellpadding:0px; cellspacing:0px; border:0px;" class="l_top float-left">
					<tr>
						<td class="leftside">
						{literal}
							<script type="IN/Share" data-counter="{/literal}{$propacklsize}{literal}" data-onSuccess="doLinkedIn" data-url="{/literal}{$propackurl}{literal}"></script>
						{/literal}
						</td>
						<td class="rightside">
							{$propackldefaulttext}
						</td>
					<td  class="rightside border-white">
						<div class="linkedin-count ">{$propackle}/{$propacklrefnum}</div>
						</td>
					</tr>
				</table>
				<div class="clear"></div>
			<br/>	
				
{/if}



{/if}


{$propackextraleftsnippet}



{if $propackpinvis_on == 1 && $propack_extraLeft == 'extraLeft' 
&& $propackpinbutton_on == 1}
<a href="//www.pinterest.com/pin/create/button/?
		url=http://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}
		&media={$product_image}
		&description={$meta_description|escape:'htmlall':'UTF-8'}" 
  data-pin-do="buttonPin" data-pin-config="{if $propackpbuttons == 'firston'}above{/if}{if $propackpbuttons == 'secondon'}beside{/if}{if $propackpbuttons == 'threeon'}none{/if}">
  <img src="//assets.pinterest.com/images/pidgets/pin_it_button.png" />
</a>
{/if}

{if $propackpqon == 1}

{if $propackposition_ask_q == 'extraleft' && $propackcontent_only == 0}
<a class="blueBtn" 
   href="http://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}#add-question-form" 
   id="idTab777-my-click"
	><b {if $propackis16==1}class="padding16-question"{/if}>{l s='Ask a question' mod='propack'} <span id="count-questions-tab1">({$propackcount_items})</span></b></a>

{/if}

{/if}
