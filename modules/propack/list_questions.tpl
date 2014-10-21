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

{foreach from=$items item=item name=myLoop}
<div class="item-questions">
	<div class="answBox answBox-question">
		<div class="answInf">
			{l s='From' mod='propack'} <strong>{$item.name|escape:'htmlall':'UTF-8'}</strong> 
			<span>|</span>  <small>{$item.time_add}</small>
		</div>
		<p>
		  {$item.question|escape:'htmlall':'UTF-8'}
		</p>
	</div>

	<div class="answBox answBox-response">
		<div class="answInf">
			<b>{l s='administrator' mod='propack'}</b> 
		</div>
		<p>
			{$item.response|escape:'htmlall':'UTF-8'}
		</p>
	</div>
</div>
{/foreach}