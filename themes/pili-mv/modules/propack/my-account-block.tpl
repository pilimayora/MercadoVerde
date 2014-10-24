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
<li>
	<a href="{$base_dir_ssl}modules/propack/soc-referrals.php" 
	   title="{l s='Social Referrals' mod='propack'}">
	   {if $propackis16 == 1}<span>{/if}
	   		{l s='Social Referrals' mod='propack'}
	   {if $propackis16 == 1}</span>{/if}
	</a>
	
</li>

{/if}

{if $propackreviewson == 1}

{if $propackid_customer != 0}

<li>
	<a href="{$base_dir_ssl}modules/propack/my-reviews.php" 
	   title="{l s='Reviews' mod='propack'}">
	   {if $propackis16 == 1}<span>{/if}
	   	{l s='My Reviews' mod='propack'}
	   	{if $propackis16 == 1}</span>{/if}
	</a>
</li>

{/if}


{/if}