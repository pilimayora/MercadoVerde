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
{l s='Frequently asked questions' mod='propack'}
{/capture}

{if $propackis16 == 0}
{include file="$tpl_dir./breadcrumb.tpl"}
{else}
<h1 class="page-heading">{$meta_title}</h1>
{/if}

<div class="border-block-faq">

<div class="b-tab">
	<ul>
		<li class="current"><a href="#" {if $propackis16 == 1}class="b-tab-16"{/if}>{l s='Frequently asked questions' mod='propack'}</a></li>
	</ul>					
</div>

<div class="clear"></div>
<div class="b-search-friends">
	<div class="float-left"></div>
	
	<div class="float-right margin-top-5">
	<b style="color:#666666">{l s='Filter by category' mod='propack'}:&nbsp;</b>
	<select onchange="window.location.href='{if $propackis_urlrewrite == 1}{$base_dir}{$propackiso_lng}faq{else}{$base_dir}modules/propack/faq.php{/if}?category_id='+this.options[this.selectedIndex].value">
	<option value=0>---</option>
	
	{foreach from=$propackdata_categories.items item=cat name=myLoop}
	<option value={$cat.id} {if $propackselected_cat == $cat.id}selected="selected"{/if}>{$cat.title}</option>
	{/foreach}
		
	</select>
	
	{if $propackselected_cat != 0}
	<a href="{if $propackis_urlrewrite == 1}{$base_dir}{$propackiso_lng}faq{else}{$base_dir}modules/propack/faq.php{/if}" 
	   style="text-decoration:underline">{l s='clear filter' mod='propack'}</a>
	{/if}
	
	<br/><br/>
	{if $propackis_urlrewrite == 1}
	<form method="get" action="{$base_dir}{$propackiso_lng}faq">
	{else}
	<form method="get" action="{$base_dir}modules/propack/faq.php">
	{/if}
	<fieldset>
	<input type="submit" value="go" class="button_mini {if $propackis_ps15 == 0}search_go{/if}" />
    <input type="text" class="txt" name="search" onfocus="{literal}if(this.value == '{/literal}{l s='Search' mod='propack'}{literal}') {this.value='';};{/literal}" onblur="{literal}if(this.value == '') {this.value='{/literal}{l s='Search' mod='propack'}{literal}';};{/literal}" value="{l s='Search' mod='propack'}" {if $propackis_ps15 == 0}style="height:16px"{/if} />
	{if $propackis_search == 1}
	{if $propackis_urlrewrite == 1}
	<a href="{$base_dir}{$propackiso_lng}faq" class="clear-search-shoppers">
	{else}
	<a href="{$base_dir}modules/propack/faq.php" class="clear-search-shoppers">
	{/if}
	{l s='Clear search' mod='propack'}</a>
	{/if}
	</fieldset>
	</form>
	
	
	
	</div>
	
	<div class="clear"></div>
</div>
	<div class="clear"></div>	
<div class="main-text-box">

{if $propackfaqis_askform == 1}

<a class="blueBtn" href="javascript:void(0)" onclick="show_form_question(1)" id="button-bottom-add-question" ><b {if $propackis16==1}class="padding16-faq"{/if}>{l s='Ask a question' mod='propack'}</b></a>
	
<div id="succes-question-faq">
{l s='Thank you, moderator will answer as soon as possible!' mod='propack'}						
</div>
	
<div id="add-question-form">

	<div class="title-rev" id="idTab666-my">
		<div style="float:left">
		{l s='Ask a question' mod='propack'}
		</div>
		<a href="javascript:void(0)" class="greyBtnBig" onclick="show_form_question(0)"
		   style="float:right;margin-bottom:0px" >
			<b {if $propackis16==1}class="padding16"{/if}>{l s='hide form' mod='propack'}</b>
		</a>
		<div style="clear:both"></div>
	</div>
	<table>
				
		<tr>
			<td class="form-left">{l s='Name' mod='propack'}:</td>
			<td class="form-right">
				<input type="text" name="name-question" id="name-question" style="margin-left:0px;width:80%" {if $propackcustomer_firstname || $propackcustomer_lastname}value="{$propackcustomer_firstname} {$propackcustomer_lastname}"{else}value=""{/if} />
			</td>
		</tr>
		<tr>
			<td class="form-left">{l s='Email' mod='propack'}:</td>
			<td class="form-right">
				<input type="text" name="email-question" id="email-question" style="margin-left:0px;width:80%" value="{$propackemail}" />
			</td>
		</tr>
		
		<tr>
			<td class="form-left">{l s='Category' mod='propack'}:</td>
			<td class="form-right">
			
					<select name="category-faq" id="category-faq">';
					<option value=0>---</option>
					
					{foreach from=$propackdata_categories.items item=cat name=myLoop}
					<option value={$cat.id}>{$cat.title}</option>
					{/foreach}
						
					</select>
			</td>
		</tr>
		
		
	
	
		
		<tr>
			<td class="form-left">{l s='Question' mod='propack'}:</td>
			<td class="form-right">
				<textarea style="margin-left:0px;width:80%;height:120px" id="text-question" name="text-question" cols="42" rows="7"></textarea>
			</td>
		</tr>
		{if $propackfaqis_captcha == 1}
		<tr>
			<td class="form-left">&nbsp;</td>
			<td class="form-right">
			<img width="100" height="26" class="float-left" id="secureCodReview" src="{$base_dir_ssl}modules/propack/captcha.php" alt="Captcha" />
			<input type="text" class="inpCaptchaReview float-left" id="inpCaptchaReview" size="6" />
				  <div class="clr"></div>
						  
			<div id="error_inpCaptchaReview" class="errorTxtAdd"></div>	
			</td>
		</tr>
		{/if}
		<tr>
			<td class="form-left">&nbsp;</td>
			<td class="form-right">
				<a href="javascript:void(0)" class="greenBtnBig" onclick="add_question()"
				   style="margin:5px auto 0" >
					<b {if $propackis16==1}class="padding16"{/if}>{l s='Ask a question' mod='propack'}</b>
				</a>
			</td>
		</tr>
		
	</table>
	

</div>
<br/><br/>



{literal}
<script type="text/javascript">


function add_question(){
	var _name_question = $('#name-question').val();
	var _email_question = $('#email-question').val();
	var _text_question = $('#text-question').val();
	{/literal}{if $propackfaqis_captcha == 1}{literal}
		var _captcha = $('#inpCaptchaReview').val();
	{/literal}{/if}{literal}

	
	if(trim(_name_question).length == 0){
		alert("{/literal}{l s='Please, enter the name.' mod='propack'}{literal}");
		return;
	}

	if(trim(_email_question).length == 0){
		alert("{/literal}{l s='Please, enter the email.' mod='propack'}{literal}");
		return;
	}

	if(trim(_text_question).length == 0){
		alert("{/literal}{l s='Please, enter the question.' mod='propack'}{literal}");
		return;
	}

	var category = $('#category-faq').val();
	
	{/literal}{if $propackfaqis_captcha == 1}{literal}
		if(trim(_captcha).length == 0){
			$('#inpCaptchaReview').addClass('error_testimonials_form');
			alert("{/literal}{l s='Please, enter the security code.' mod='propack'}{literal}");
			return;
		}
	{/literal}{/if}{literal}
		
	$('#add-question-form').css('opacity',0.5);
	$.post(baseDir + 'modules/propack/ajax.php', 
			{action:'addfaqquestion',
			 name:_name_question,
			 email:_email_question,
			 text_question:_text_question,
			 {/literal}{if $propackfaqis_captcha == 1}{literal}
			 	 captcha:_captcha,
			 {/literal}{/if}{literal}
			 category:category
			 }, 
	function (data) {
		$('#add-question-form').css('opacity',1);
		
		if (data.status == 'success') {

			
			show_form_question(0);

			$('#name-question').val('');
			$('#email-question').val('');
			$('#text-question').val('');
			$('#inpCaptchaReview').val('');
			
			$('#succes-question-faq').show();

			$('#email-question').removeClass('error_testimonials_form');
			$('#inpCaptchaReview').removeClass('error_testimonials_form');
			

			{/literal}{if $propackfaqis_captcha == 1}{literal}
				var count = Math.random();
				document.getElementById('secureCodReview').src = "";
				document.getElementById('secureCodReview').src = "{/literal}{$module_dir}{literal}captcha.php?re=" + count;
			{/literal}{/if}{literal}
			
					
		} else {
			$('#add-question-form').css('opacity',1);
			var error_type = data.params.error_type;
			
			if(error_type == 2){
				$('#email-question').addClass('error_testimonials_form');
				alert("{/literal}{l s='Please enter a valid email address. For example johndoe@domain.com.' mod='propack'}{literal}");
			} 
			{/literal}{if $propackfaqis_captcha == 1}{literal}
				else if(error_type == 3){ 
					$('#inpCaptchaReview').addClass('error_testimonials_form');
					alert("{/literal}{l s='You entered the wrong security code.' mod='propack'}{literal}");
				} 
			{/literal}{/if}{literal}

			else {
				alert(data.message);
			}

				{/literal}{if $propackfaqis_captcha == 1}{literal}
					var count = Math.random();
					document.getElementById('secureCodReview').src = "";
					document.getElementById('secureCodReview').src = "{/literal}{$module_dir}{literal}captcha.php?re=" + count;
				{/literal}{/if}{literal}
			
		}
	}, 'json');
}


function show_form_question(par){
	if(par == 1){
		 $('#button-bottom-add-question').hide(200);
	     $('#add-question-form').show(200);
	     $('#succes-question-faq').hide();
	} else {
		$('#button-bottom-add-question').show(200);
	     $('#add-question-form').hide(200);
	}
}

function trim(str) {
	   str = str.replace(/(^ *)|( *$)/,"");
	   return str;
	   }
</script>
{/literal}


{/if}

{if $propackis_search == 1}
<h3 class="search-result-item">{l s='Results for' mod='propack'} "{$propacksearch}"</h3>
<br/>
{/if}

{if $propackselected_cat!=0}
{foreach from=$propackdata_categories.items item=cat name=myLoop}
	{if $propackselected_cat == $cat.id}
	<h3 class="filter-by-cat-result-item">{l s='Questions in' mod='propack'} <span class="category-faq-color">{$cat.title}</span></h3>
	{/if}
{/foreach}
{/if}		

<div class="clear"></div>


{if count($propackitems) > 0}

{foreach from=$propackitems item=faq name=myLoop}			
	<p class="faqItem" id="faq_{$faq.id}">
		<strong>{$faq.title|escape:'htmlall':'UTF-8'}</strong>
	</p>
	<div id="faq_{$faq.id}_block" style="display: none;" 
		class="faqAnsw">
	<p>
      {l s='Posted' mod='propack'}: {$faq.time_add|date_format}
      
      {if $faq.is_by_customer && strlen($faq.customer_name)>0}
      {l s='by' mod='propack'} <b>{$faq.customer_name}</b>
      {/if}
      
      {if count($faq.categories)>0}
       {l s='in' mod='propack'}  
      {foreach from=$faq.categories item=category name=catname}
      <a {if $propackis_urlrewrite == 1}href="{$base_dir}{$propackiso_lng}faq?category_id={$category.category_id}"{else}href="{$base_dir}modules/propack/faq.php?category_id={$category.category_id}"{/if}	title="{$category.title}">{$category.title}</a>{if $smarty.foreach.catname.last}{else}, {/if}
      {/foreach}   
      {/if}
      
    </p>
    	
	{$faq.content}
		
	</div>
{/foreach}


{else}
<p class="faqAnsw" style="text-align:center">{l s='Questions not found' mod='propack'}</p>
{/if}
	
	</div>

</div>


{literal}
<script type="text/javascript">
jQuery(document).ready(function(){
$('.main-text-box .faqItem').click(function () { 
    $(this).next()[!$(this).next().is(':visible') ? 'show' : 'hide'](400);
  });


var vars = [], hash = '';
var hashes = window.location.href.slice(window.location.href.indexOf('#') + 1);

for(var i = 0; i < hashes.length; i++)
{
	hash += hashes[i];
}
$('#'+hash+'_block').show(200);

});
</script>
{/literal}