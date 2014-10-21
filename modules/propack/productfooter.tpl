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

{if $propackfbrefon == 1 || $propacktwrefon == 1 || $propackgrefon == 1 || $propacklrefon == 1}



{if $propackfbrefon == 1 && $propack_psprFooterf == "psprFooterf"}
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


{if $propacktwrefon == 1 && $propack_psprFootert == "psprFootert"}
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


{if $propackgrefon == 1 && $propack_psprFooterg == "psprFooterg"}
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

{if $propacklrefon == 1 && $propackis_l==1 && $propack_psprFooterl == "psprFooterl"}
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

{$propackproductfooter}



{if $propackpinvis_on == 1 && $propack_productFooter == 'productFooter' 
&& $propackpinbutton_on == 1}
<a href="//www.pinterest.com/pin/create/button/?
		url=http://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}
		&media={$product_image}
		&description={$meta_description|escape:'htmlall':'UTF-8'}" 
  data-pin-do="buttonPin" data-pin-config="{if $propackpbuttons == 'firston'}above{/if}{if $propackpbuttons == 'secondon'}beside{/if}{if $propackpbuttons == 'threeon'}none{/if}">
  <img src="//assets.pinterest.com/images/pidgets/pin_it_button.png" />
</a>
{/if}