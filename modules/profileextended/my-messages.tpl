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

<style>
	.mess-menu{
		background: none repeat scroll 0 0 #E2E2E2;
		border: 1px solid #CCCCCC;
		color: #333333 !important;
		display: block;
		padding: 2px 10px;
		text-decoration: none !important; float:left;	
		width:77px;
		margin-right:2px;
		text-align:center;
	}
	.mess-menu-act{
		background: none repeat scroll 0 0 #FFFFFF;
		border: 1px solid #CCCCCC;
		border-bottom: 1px solid #FFFFFF;
		color: #333333 !important;
		display: block;
		padding: 2px 10px;
		text-decoration: none !important; float:left;
		width:77px;	
		margin-right:2px;
		text-align:center;
	}
</style>
{literal}
	<script>
		function messMenu(button, id){
			$('.success').hide();
			$('#myprofileextended div').hide();
			$(id).show();
			$('.mess-menu-act').removeClass().addClass('mess-menu');
			$(button).removeClass().addClass('mess-menu-act');
		}
		function answer(text){
			$('.success').hide();
			$('#title').val('Re: ' + text);
			$('#myprofileextended div').hide();
			$('.mess-menu-act').removeClass().addClass('mess-menu');
			$('#new-butt').removeClass().addClass('mess-menu-act');			
			$('#new').show();
		}
	</script>
{/literal}
<div id="myprofileextended">
	{capture name=path}<a href="{$link->getPageLink('my-account.php', true)}">{l s='My account' mod='profileextended'}</a><span class="navigation-pipe">{$navigationPipe}</span>{l s='Messages' mod='profileextended'}{/capture}
	{include file="$tpl_dir./breadcrumb.tpl"}
	<h2>{l s='Messages' mod='profileextended'}</h2>

			<a class="mess-menu-act" href="javascript:;" onclick="messMenu(this, '#inbox')">{l s='Inbox' mod='profileextended'}</a>
			<a class="mess-menu" href="javascript:;" onclick="messMenu(this, '#outbox')">{l s='Outbox' mod='profileextended'}</a>
			<a id="new-butt" class="mess-menu" href="javascript:;" onclick="messMenu(this, '#new')">{l s='New Message' mod='profileextended'}</a>	
			<span style="clear:both;"><br><br></span>
			{if isset($smarty.request.err)}
				{if $smarty.request.err eq 'no'}
					<p class="success"> 
						{l s='Successfully!' mod='profileextended'}
					</p>
				{elseif $smarty.request.err eq 'yes'}	
					<div class="error">
						<ul>
							<li>Error!</li>
						</ul>
					</div>				
				{/if}
			{/if}
			<div id="inbox">
				<h3>{l s='Inbox Messages' mod='profileextended'}</h3>
				{if count($inbox)>0}
					<table width="100%" style="border:3px solid #F1F2F4">
						<thead>
							<th width="45%">{l s='Title' mod='profileextended'}</th>
							<th width="15%">{l s='Date' mod='profileextended'}</th>
							<th width="15%">{l s='Status' mod='profileextended'}</th>
							<th>{l s='Action' mod='profileextended'}</th>
						</thead>
						<tbody>
							{foreach from=$inbox item=v name=p}
								<tr {if $smarty.foreach.p.iteration%2}style="background-color:#F1F2F4;"{/if}>
									<td>{$v.title}</td>
									<td>{$v.date}</td>
									<td>{if $v.status eq 1}<font color="red">{l s='Not readed' mod='profileextended'}</font>{else}<font color="green">{l s='Readed' mod='profileextended'}</font>{/if}</td>
									<td>
										<a href="?action=read&id={$v.id}">{l s='Read' mod='profileextended'}</a> | 
										<a href="?action=delete&id={$v.id}" onclick="if (!confirm('{l s='Are you sure' mod='profileextended'}?')) return false;" href="">{l s='Delete' mod='profileextended'}</a> | 
										<a href="javascript:;" onclick="answer('{$v.title}');">{l s='Answer' mod='profileextended'}</a>
									</td>
								</tr>
							{foreachelse}
								<b>{l s='No messages' mod='profileextended'}</b>
							{/foreach}
						</tbody>
					</table>
				{else}
					{l s='No messages' mod='profileextended'}
				{/if}
			</div>
		
			
			<div id="outbox">
				<h3>{l s='Outbox Messages' mod='profileextended'}</h3>
				{if count($outbox)>0}
					<table width="100%" style="border:3px solid #F1F2F4">
						<thead>
							<th  width="45%">{l s='Title' mod='profileextended'}</th>
							<th width="15%">{l s='Date' mod='profileextended'}</th>
							<th  width="15%">{l s='Status' mod='profileextended'}</th>
							<th>{l s='Action' mod='profileextended'}</th>
						</thead>
						<tbody>
							{foreach from=$outbox item=v name=p}
								<tr {if $smarty.foreach.p.iteration%2}style="background-color:#F1F2F4;"{/if}>
									<td>{$v.title}</td>
									<td>{$v.date}</td>
									<td>{if $v.status eq 1}<font color="red">{l s='Not readed' mod='profileextended'}</font>{else}<font color="green">{l s='Readed' mod='profileextended'}</font>{/if}</td>
									<td>
										<a href="?action=read&id={$v.id}">{l s='Read' mod='profileextended'}</a> | 
										<a href="?action=delete&id={$v.id}" onclick="if (!confirm('{l s='Are you sure' mod='profileextended'}?')) return false;" href="">{l s='Delete' mod='profileextended'}</a> 
									</td>
								</tr>
							{foreachelse}
								<b>{l s='No messages' mod='profileextended'}</b>
							{/foreach}
						</tbody>
					</table>
				{else}
					{l s='No messages' mod='profileextended'}
				{/if}
			</div>			
		
			<div id="new">
				<script>
					function upZip(str) {
						if (str.length == 0) return true;
						reg=/\.zip"?$/;
						return reg.test(str.toLowerCase());
					}			
				</script>
				<h3>{l s='New Messages' mod='profileextended'}</h3>
				<form method="POST" class="std" onsubmit="{literal}if (!upZip($('#file input').val())){alert('Incorrect file format!'); return false;}{/literal} if ($('#title').val()=='' || $('#message').val()=='') return false;" enctype="multipart/form-data">
					<input type="hidden" name="action" value="save">
					<fieldset>
						<p class="text">
							<label>
								<b>{l s='Title' mod='profileextended'}: *</b>
							</label>
							<input type="text" id="title" value="" name="title" size="27">
						</p>
						<p class="text">
							<label>
								<b>{l s='Message' mod='profileextended'}: *</b>
							</label>
							<textarea id="message" style="width:203px; height:150px" name="message" ></textarea>
						</p>
						<p class="text">
							<label>
								<b>{l s='File' mod='profileextended'} (*.zip):</b>
							</label>
							<b id="file"><input type="file" value="" name="file" size="27"></b>
							<a href="#" onclick="jQuery('#file').html('<input type=file name=file size=27>')">
								<img src="{$base_dir}img/admin/disabled.gif">
							</a>
						</p>						
						<p class="submit">
							<input class="button" type="submit" value=" Post ">
						</p>
					</fieldset>
				</form>
			</div>
			
		{if isset($smarty.request.action)}
			{if $smarty.request.action eq 'read'}			
				<div id="read">
					<b>{l s='Title' mod='profileextended'}:</b> {$message.title}
					<br>
					<b>{l s='Date' mod='profileextended'}:</b> {$message.date}
					<br><b>{l s='Message' mod='profileextended'}:</b><br>
					{$message.message|stripslashes}
					{if $message.file}
						<br><br>
						<b>File:</b> <a href="{$base_dir}/upload/profile_extended/messages/{$message.file}">Attachment</a>
					{/if}
				</div>
				<script>
					$('.mess-menu-act').removeClass().addClass('mess-menu');
					$('#myprofileextended div').hide();
					$('#myprofileextended #read').show();
				</script>				
			{/if}
		{else}
				<script>
					$('#myprofileextended div').hide();
					$('#myprofileextended #inbox').show();
				</script>
		{/if}
	
	<ul class="footer_links">
		<li><a href="{$link->getPageLink('my-account.php', true)}"><img src="{$img_dir}icon/my-account.gif" alt="" class="icon" /></a><a href="{$link->getPageLink('my-account.php', true)}">{l s='Back to Your Account' mod='blockwishlist'}</a></li>
		<li><a href="{$base_dir}"><img src="{$img_dir}icon/home.gif" alt="" class="icon" /></a><a href="{$base_dir}">{l s='Home' mod='blockwishlist'}</a></li>
	</ul>
</div>