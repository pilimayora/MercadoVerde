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

{foreach from=$comments item=comment name=myLoop}
<table class="prfb-table-reviews">
	<tr>
		<td class="prfb-left">
			<div class="prfb-name">{$comment.name|escape:'htmlall':'UTF-8'}</div>
			<br>
			<span class="prfb-time">{$comment.time_add|date_format:"%d-%m-%Y"}</span>
			<br>
		</td>
		<td class="prfb-right">
			<div class="rvTxt">
				<p>{$comment.comment|escape:'htmlall':'UTF-8'}</p>
			</div>
		</td>
	</tr>
</table>
{/foreach}