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

<div class="snippets-clear"></div>

<div class="googlesnippetsblock" style="width:{$propackgsnipblock_width}{if $propackgsnipblock_width != "auto"}px{/if}">

{if $propackgsnipblocklogo == 1}
<div class="googlesnippetsblock-title">
<img src="{$base_dir}modules/propack/i/logo-snippet.png" border="0" />
</div>
{/if}

<div itemscope itemtype="http://data-vocabulary.org/Product">
  <table width="100%" border="0" class="snippets-table-block">
	  <tr>
	  	<td>
	  		<img itemprop="image" src="{$product_image}"  class="googlesnippetsblock-img" />
	  	</td>
	  	<td>
	  		<strong><span itemprop="name">{$product_name}</span></strong>
	  		<br/>
	  		{l s='Category' mod='propack'}: <span itemprop="category" content="{$product_category}">{$product_category}</span>
    		<br/>
	  		{l s='Brand' mod='propack'}: <span itemprop="brand">{$product_brand}</span>
	  	</td>
	  </tr>
	  <tr>
	  	<td colspan="2">
			<span itemprop="offerDetails" itemscope itemtype="http://data-vocabulary.org/Offer">
			    {l s='Price' mod='propack'}: {$currency_custom}<span itemprop="price">{$product_price_custom}</span>
			    <meta itemprop="currency" content="{$currency_custom}" />
			    <br/>
			    {l s='Condition' mod='propack'}: <span itemprop="condition" content="new">{l s='New' mod='propack'}</span>
			    <br/>
			    {l s='Available from' mod='propack'}: <span itemprop="seller">{$shop_name}</span>
			    <br/>
			    {l s='Stock' mod='propack'}: <span itemprop="availability" content="{$stock_string}">{if $stock_string=="in_stock"}{l s='In Stock' mod='propack'}{else}{$stock_string}{/if}</span>
			 </span>
			    		
	  	</td>
	  </tr>
	  <tr>
	  	<td colspan="2">
	  		{l s='Description' mod='propack'}: <span itemprop="description">{$product_description}</span>
	  	</td>
	  </tr>
	  {if $propackcount != 0}
	  <tr>
	  	<td colspan="2">
	  	<strong>{l s='Rating' mod='propack'}({l s='s' mod='propack'}):</strong>
	  	</td>
	  </tr>
	  <tr>
	  	<td colspan="2">
	  		<span itemprop="review" itemscope itemtype="http://data-vocabulary.org/Review-aggregate">
		  	{section name=ratid loop=5}
				{if $smarty.section.ratid.index < $propacktotal} 
					<img src="{$module_dir}images/rstar1.png" class="snippets-img-star" 
						 alt="{$smarty.section.ratid.index}"/>
				{else}
					<img src="{$module_dir}images/rstar2.png" class="snippets-img-star" 
						 alt="{$smarty.section.ratid.index}"/>
				{/if}
			{/section}
			<div class="snippets-clear"></div>
		    {l s='Rating' mod='propack'}: <span itemprop="rating">{$propacktotal}</span>/5 {l s='stars' mod='propack'}
		     <br/> 
		    {l s='Based on' mod='propack'}: <span itemprop="count">{$propackcount}</span> {l s='rating' mod='propack'}({l s='s' mod='propack'})
		  </span>
	  	</td>
	  </tr>
	  {/if}
  </table>
  
</div>

</div>


