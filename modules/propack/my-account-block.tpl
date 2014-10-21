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


<li {if $propackis_ps15 == 0}style="background: url('{$module_template_dir}img/connects-logo.png')  no-repeat scroll 0 0 transparent;"{/if}>
	<a href="{$base_dir_ssl}modules/propack/soc-referrals.php" 
	   title="{l s='Social Referrals' mod='propack'}">
	   
	   {if $propackis16 == 1}<i>{/if}
	   <img src="{$module_template_dir}img/connects-logo.png" 
	   		alt="{l s='Social Referrals' mod='propack'}" class="icon" />
  	   {if $propackis16 == 1}</i>{/if}
  	   
	   {if $propackis16 == 1}<span>{/if}
	   		{l s='Social Referrals' mod='propack'}
	   {if $propackis16 == 1}</span>{/if}
	</a>
	
</li>

{/if}

{if $propackreviewson == 1}

{if $propackid_customer != 0}

<li {if $propackis_ps15 == 0}style="background: url('{$module_template_dir}i/settings_reviews.gif')  no-repeat scroll 0 0 transparent;"{/if}>
	
	<a href="{$base_dir_ssl}modules/propack/my-reviews.php" 
	   title="{l s='Reviews' mod='propack'}">
	   
	   {if $propackis16 == 1}<i>{/if}
	   {if $propackis_ps15 == 1}
	   <img class="icon" src="{$module_template_dir}i/settings_reviews.gif" />
	   {/if}
	   {if $propackis16 == 1}</i>{/if}
	   {if $propackis16 == 1}<span>{/if}
	   	{l s='My Reviews' mod='propack'}
	   	{if $propackis16 == 1}</span>{/if}
	   
	
	   	</a>
</li>

{/if}


{/if}