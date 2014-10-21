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

<li>
	<a title="Profile Extended" href="{$link->getPageLink('modules/profileextended/my-avatar.php', true)}">
		<img class="icon" alt="Profile Extended" src="{$link->getPageLink('modules/profileextended/profileextended.gif', true)}">
	</a>
	<a title="Profile Extended" href="{$link->getPageLink('modules/profileextended/my-profile.php', true)}">{l s='Profile Extended' mod='profileextended'}</a>
</li>
<li>
	<a title="Messages" href="{$link->getPageLink('modules/profileextended/my-messages.php', true)}">
		<img class="icon" alt="Messages" src="{$link->getPageLink('modules/profileextended/messages.gif', true)}">
	</a>
	<a title="Messages" href="{$link->getPageLink('modules/profileextended/my-messages.php', true)}">{l s='Messages' mod='profileextended'}
		{if $count_new_messages}({$count_new_messages}){/if}
	</a>
</li>