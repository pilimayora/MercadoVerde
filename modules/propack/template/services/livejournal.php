<?php 
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

$host = isset($_REQUEST['host'])?$_REQUEST['host']:"";

?>
<table style="width:100%;border:1px solid #E4E4E4;font:12px/1.55 Arial,Helvetica,sans-serif">
	<tr>
		<td style="padding:10px">
			<form action="<?php echo $host ?>modules/propack/login.php?p=login" method="post">
			    <input type="hidden" name="service_url" value="livejournal.com"/>
			    <b><h2 style="color:#0A263C">Livejournal Authorization</h2></b><br/>
			    <input type="text" name="openid_identifier" value="" class="input-text"/><br/>
			    <i style="color:#2F2F2F;">Your Livejournal username</i><br/>
			    <button class="button" type="submit">Login</button>
			</form>
		</td>
	</tr>
</table>

