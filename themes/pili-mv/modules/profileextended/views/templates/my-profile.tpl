{*/*
* 2007-2012 PrestaShop 
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
*         DISCLAIMER   *
* *************************************** */
/* Do not edit or add to this file if you wish to upgrade Prestashop to newer
* versions in the future.
* ****************************************************
* @category   Belvg
* @package    Belvg_UserProfileExtended
* @copyright  Copyright (c) 2010 - 2012 BelVG LLC. (http://www.belvg.com)
* @license    http://store.belvg.com/BelVG-LICENSE-COMMUNITY.txt
*/*}

<div id="my-avatar">
	{capture name=path}<a href="{$link->getPageLink('my-account.php', true)}">{l s='My account' mod='profileextended'}</a><span class="navigation-pipe">{$navigationPipe}</span>{l s='Profile Extended' mod='profileextended'}{/capture}
	{include file="$tpl_dir./breadcrumb.tpl"}

<h2>{l s='Profile Extended' mod='profileextended'}</h2>
	
	{if $error}
		<div class="error">
			<p>There is {$smarty.request.err} error :</p>
			<ul>
			<li>File(s) is not valid!</li>
			</ul>
		</div>
	{elseif $ok}
		<p class="success"> 
			{$ok}
		</ok>
	{/if}
	
	{$content}

	<ul class="footer_links">
		<li><a href="{$link->getPageLink('my-account.php', true)}"><img src="{$img_dir}icon/my-account.gif" alt="" class="icon" /></a><a href="{$link->getPageLink('my-account.php', true)}">{l s='Back to Your Account' mod='blockwishlist'}</a></li>
		<li><a href="{$base_dir}"><img src="{$img_dir}icon/home.gif" alt="" class="icon" /></a><a href="{$base_dir}">{l s='Home' mod='blockwishlist'}</a></li>
	</ul>
</div>
