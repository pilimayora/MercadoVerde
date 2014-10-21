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

{foreach from=$reviews item=review name=myLoop}
	<table cellspacing="0" cellpadding="0" border="0" width="100%" class="productsTable compareTableNew">
		<tbody>
			<tr class="line1">
			<td class="info">
				<p class="commentbody_center">
				{$review.message|escape:'htmlall':'UTF-8'}
				
				<br><br>
				<span class="foot_center">{l s='Posted by' mod='propack'} {$review.name|escape:'htmlall':'UTF-8'}</span><br>
				<span class="foot_center">{$review.date_add|date_format:"%d-%m-%Y"}</span><br>
				<br>
				</p>
			</td>
			</tr>
		</tbody>
	</table>
{/foreach}