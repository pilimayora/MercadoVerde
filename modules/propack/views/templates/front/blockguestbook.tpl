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

{capture name=path}
{l s='Guestbook' mod='propack'}
{/capture}


{if $propackis16 == 0}
{include file="$tpl_dir./breadcrumb.tpl"}

<h2>{l s='Guestbook' mod='propack'}</h2>
{else}
<h1 class="page-heading">{$meta_title}</h1>
{/if}


<div style="border:1px solid #CCCCCC;padding:5px">
{if $count_all_reviews > 0}

<div class="toolbar-top">
			
	<div class="sortTools {if $propackis16 == 1}sortTools16{/if}" id="show" style="margin-bottom: 10px;">
		<ul class="actions">
			<li class="frst">
					<strong>{l s='Posts' mod='propack'}  ( <span id="count_items_top" style="color: #333;">{$count_all_reviews}</span> )</strong>
			</li>
		</ul>
	</div>

</div>


<div id="list_reviews" class="productsBox1">
{foreach from=$reviews item=review name=myLoop}
	<table cellspacing="0" cellpadding="0" border="0" width="100%" class="productsTable compareTableNew {if $propackis16==1}float-left-table16{/if}">
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
{if $propackis16==1}<div class="clear"></div>{/if}
</div>


<div class="toolbar-bottom">
			
	<div class="sortTools {if $propackis16 == 1}sortTools16{/if}" id="show">
		
		<ul style="margin-left: 38%;">
			<li style="border: medium none; padding: 0pt;">	
			
			<table class="toolbar">
			<tbody>
			<tr class="pager">
				<td id="page_nav" class="pages">
					{$paging}
				</td>
			</tr>
			</tbody>
	</table>
</li>
		</ul>
		
			</div>

		</div>
{else}
	<div style="padding:10px;text-align:center;font-weight:bold">
	{l s='There are not posts yet' mod='propack'}
	</div>
{/if}

</div>


<div id="succes-review-guestbook">
{l s='Your post has been successfully sent. Thanks for post!' mod='propack'}						
</div>

<div id="add-review-form-guestbook">
	<div class="title-rev" id="idTab666-my">
		<div style="float:left">
		{l s='Add Post' mod='propack'}
		</div>
		
		<div style="clear:both"></div>
	</div>
	<table>
		<tr>
			<td class="form-left">{l s='Name' mod='propack'}:<span style="color:#EB340A">*</span></td>
			<td class="form-right">
				<input type="text" name="name-review"
					   id="name-review"  
					   style="margin-left:0px;width:80%" 
					   />
			</td>
		</tr>	
		<tr>
			<td class="form-left">{l s='Email' mod='propack'}:<span style="color:#EB340A">*</span></td>
			<td class="form-right">
				<input type="text" name="email-review"
					   id="email-review"  
					   style="margin-left:0px;width:80%" 
					   />
			</td>
		</tr>
		
		<tr>
			<td class="form-left">{l s='Post' mod='propack'}:<span style="color:#EB340A">*</span></td>
			<td class="form-right">
				<textarea style="margin-left:0px;width:80%;height:120px"
						  id="text-review"
						  name="text-review"></textarea>
			</td>
		</tr>
		{if $propackgis_captcha == 1}
		<tr>
			<td class="form-left">&nbsp;</td>
			<td class="form-right">
			<img width="100" height="26" class="float-left" id="secureCodReview" 
				src="{$base_dir_ssl}modules/propack/captcha.php" alt="Captcha">
			<input type="text" class="inpCaptchaReview float-left" id="inpCaptchaReview" 
			 size="6">
				  <div class="clr"></div>
						  
			<div id="error_inpCaptchaReview" class="errorTxtAdd"></div>	
			</td>
		</tr>
		{/if}
		<tr>
			<td class="form-left">&nbsp;</td>
			<td class="form-right">
				<a href="javascript:void(0)" class="greenBtnBig" onclick="add_gusetbook_post()"
				   style="margin:5px auto 0" >
					<b {if $propackis16==1}class="padding16"{/if}>{l s='Add Post' mod='propack'}</b>
				</a>
			</td>
		</tr>
	</table>
</div>

{literal}
<script type="text/javascript">

function trim(str) {
	   str = str.replace(/(^ *)|( *$)/,"");
	   return str;
	   }

function add_gusetbook_post(){
	
	
	var _name_review = $('#name-review').val();
	var _email_review = $('#email-review').val();
	var _text_review = $('#text-review').val();
	{/literal}{if $propackgis_captcha == 1}{literal}
		var _captcha = $('#inpCaptchaReview').val();
	{/literal}{/if}{literal}

	//clear errors
	$('#name-review').removeClass('error_testimonials_form');
	$('#email-review').removeClass('error_testimonials_form');
	$('#text-review').removeClass('error_testimonials_form');
	$('#inpCaptchaReview').removeClass('error_testimonials_form');
	
	
	if(trim(_name_review).length == 0){
		$('#name-review').addClass('error_testimonials_form');
		alert("{/literal}{l s='Please, enter the Name.' mod='propack'}{literal}");
		return;
	}
	
	if(trim(_email_review).length == 0){
		$('#email-review').addClass('error_testimonials_form');
		alert("{/literal}{l s='Please, enter the Email.' mod='propack'}{literal}");
		return;
	}

	if(trim(_text_review).length == 0){
		$('#text-review').addClass('error_testimonials_form');
		alert("{/literal}{l s='Please, enter the Post.' mod='propack'}{literal}");
		return;
	}

	{/literal}{if $propackgis_captcha == 1}{literal}
		if(trim(_captcha).length == 0){
			$('#inpCaptchaReview').addClass('error_testimonials_form');
			alert("{/literal}{l s='Please, enter the security code.' mod='propack'}{literal}");
			return;
		}
	{/literal}{/if}{literal}
	
		
	$('#add-review-form-guestbook').css('opacity','0.5');
	$.post(baseDir + 'modules/propack/ajax.php', 
			{action:'addreviewguestbook',
			 name:_name_review,
			 email:_email_review,
			 {/literal}{if $propackgis_captcha == 1}{literal}
			 	 captcha:_captcha,
			 {/literal}{/if}{literal}
			 text_review:_text_review
			 }, 
	function (data) {
		if (data.status == 'success') {

				$('#name-review').val('');
				$('#email-review').val('');
				$('#text-review').val('');
				$('#inpCaptchaReview').val('');
				

				$('#add-review-form-guestbook').hide();
				$('#succes-review-guestbook').show();

				{/literal}{if $propackgis_captcha == 1}{literal}
					var count = Math.random();
					document.getElementById('secureCodReview').src = "";
					document.getElementById('secureCodReview').src = "{/literal}{$base_dir}modules/propack/{literal}captcha.php?re=" + count;
				{/literal}{/if}{literal}
			
			$('#add-review-form-guestbook').css('opacity','1');
			
			
		} else {
			
			var error_type = data.params.error_type;
			
			if(error_type == 1){
				$('#name-review').addClass('error_testimonials_form');
				alert("{/literal}{l s='Please, enter the Name.' mod='propack'}{literal}");
			} else if(error_type == 2){
				$('#email-review').addClass('error_testimonials_form');
				alert("{/literal}{l s='Please enter a valid email address. For example johndoe@domain.com.' mod='propack'}{literal}");
			} else if(error_type == 3){
				$('#text-review').addClass('error_testimonials_form');
				alert("{/literal}{l s='Please, enter the Post.' mod='propack'}{literal}");
			} 
			{/literal}{if $propackgis_captcha == 1}{literal}
				else if(error_type == 4){ 
					$('#inpCaptchaReview').addClass('error_testimonials_form');
					alert("{/literal}{l s='You entered the wrong security code.' mod='propack'}{literal}");
				} 
			{/literal}{/if}{literal}
			else {
				alert(data.message);
			}

			{/literal}{if $propackgis_captcha == 1}{literal}
				var count = Math.random();
				document.getElementById('secureCodReview').src = "";
				document.getElementById('secureCodReview').src = "{/literal}{$base_dir}modules/propack/{literal}captcha.php?re=" + count;
			{/literal}{/if}{literal}
				
			$('#add-review-form-guestbook').css('opacity','1');
			
		}
	}, 'json');
}


function go_page_guestbook(page){
	$('#list_reviews').css('opacity',0.5);
	
	$.post(baseDir + 'modules/propack/ajax.php', {
		action:'pagenavguestbook',
		page : page
	}, 
	function (data) {
		if (data.status == 'success') {
		
		$('#list_reviews').css('opacity',1);
		
		$('#list_reviews').html('');
		$('#list_reviews').prepend(data.params.content);
		
		$('#page_nav').html('');
		$('#page_nav').prepend(data.params.page_nav);
		
		
		
	    } else {
			$('#list_reviews').css('opacity',1);
			alert(data.message);
		}
		
	}, 'json');

}


</script>
{/literal}