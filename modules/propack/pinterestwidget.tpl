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
	<style type="text/css">
		#propack-pins{
			width: {/literal}{$propack_width}{literal}px;
			border: 1px solid #ccc;
			margin-bottom: 15px;
			font-family: "helvetica neue",arial,sans-serif;
			font-weight: bold;
			text-shadow: 0 1px #FFFFFF;

			-moz-border-radius: 2px; 
			-webkit-border-radius: 2px;
			border-radius: 2px;
		}
		.propack-pins{
			background-attachment: fixed;
		    background-color: #f7f5f5;
		    background-image: url("{/literal}{$module_dir}{literal}img/noise.png");
			height: {/literal}{$propack_height}{literal}px;
		}
		.propack-pins-h{
			background-color: #FAF7F7;
			color: #524D4D;
			padding: 8px 20px 8px 10px;
			border-bottom-color: #ccc;
			border-bottom-style: solid;
		    border-bottom-width: 1px;
			font-size: 13px;
			
			-moz-box-shadow: 0 0 0 1px #FFFFFF inset;
			-webkit-box-shadow: 0 0 0 1px #FFFFFF inset;
			box-shadow: 0 0 0 1px #FFFFFF inset;
		}
		.propack-pins-cont{
			overflow-y: auto;
			overflow-x: hidden;
			width: 100%;
			height: 100%;
		}
		.propack-pin{
			background-color: #FFFFFF;
		    font-size: 11px;
		    padding: 15px 15px 0;
		    width: {/literal}{$propack_pwidth}{literal}px;
			margin: 0 auto 15px;

			-moz-box-shadow: 0 1px 3px rgba(34, 25, 25, 0.4);
			-webkit-box-shadow: 0 1px 3px rgba(34, 25, 25, 0.4);
			box-shadow: 0 1px 3px rgba(34, 25, 25, 0.4);
		}
		.propack-pin-image{
			margin: 0;
			padding: 0;
			width: {/literal}{$propack_pwidth}{literal}px;			
		}
		.propack-pin-image a{
			display: block;
		}
		.propack-pin-image img{
			width: 100%;
			margin: 0 auto;
		}
		.propack-pin-desc{
			padding: 10px 15px;
			background-color: #F2F0F0;
			margin: 10px -15px 0 -15px;
		}
		
		.propack-pin-desc p{
			text-align: center;
			color: #AD9C9C;
			margin: 0!important;
			padding: 0!important;
		}
		.propack-follow-me{
			background-color: #FAF7F7;
			border-top-color: #ccc;
			border-top-style: solid;
		    border-top-width: 1px;
			padding: 6px 0 3px;
		
			-moz-box-shadow: 0 0 0 1px #FFFFFF inset;
			-webkit-box-shadow: 0 0 0 1px #FFFFFF inset;
			box-shadow: 0 0 0 1px #FFFFFF inset;
		}
	</style>
{/literal}
<div id="propack-pins">
	<div class="propack-pins-h"><img src="{$module_dir}img/pinterest.png" style="margin: 0 10px -3px 0;">{$propack_title}</div>
	<div class="propack-pins">
		<div class="propack-pins-cont">
			{foreach from=$propack_feed_items item="item" name="propack_pins"}
				<div class="propack-pin" {if $smarty.foreach.propack_pins.first}style="margin-top: 10px;"{/if}>
					<div class="propack-pin-image">
						<a href="{$item.link}" title="{$item.title}">
							<img src="{$item.image_link}" title="{$item.title}" alt="{$item.title}">
						</a>
					</div>
					{if $propack_descr == 'on'}
						<div class="propack-pin-desc">
							<p>{$item.description}</p>
						</div>
					{/if}
				</div>
			{/foreach}
		</div>
	</div>
	{if $propack_follow == 'on'}
		<div class="propack-follow-me">
			<a href="http://pinterest.com/{$propack_pusername}/" target="_blank" style="display: block; margin: 0 auto; width: 156px;">
				<img src="http://passets-cdn.pinterest.com/images/follow-on-pinterest-button.png" width="156" height="26" alt="Follow Me on Pinterest" />
			</a>
		</div>
	{/if}
</div>