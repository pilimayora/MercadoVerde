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

{if $propackis16 == 1}
{if $propackCOMMENTON == 1}
<h3 class="page-product-heading {if $propackFOCUS == '1'}selected{/if}" id="#idTab22">
	{if $propackLOGOSWITCH == '1'}
		<img id="customefacebookcommentslogo" src="{$base_dir}/modules/propack/img/facebook.jpg" alt="{l s='Facebook logo' mod='propack'}" />
	{/if}
	<fb:comments-count href="{$come_from}"></fb:comments-count>
	{l s='Comments' mod='propack'}
</h3>		
{/if}

{/if}

{if $propackCOMMENTON == 1}
<div id="idTab22" style="margin-top:10px">

	
	{literal}
		<script type="text/javascript">
			{/literal}{if $propackREDIRECT == '1'}{literal}window.setTimeout("location=('{/literal}{$link->getProductLink($product)}{literal}');",0){/literal}{/if}{literal}				
		</script>
	{/literal}

	{if $logged == true || $propackREGISTERSWITCH == '0'}
		{if $propackTITLESWITCH == '1'}<div id="customefacebookcommentstitle">{l s='Facebook comments' mod='propack'}</div>{/if}
		
				{*
				{if $propackLIKETOPSWITCH == '1'}
					<iframe src="http://www.facebook.com/plugins/like.php?href={$come_from}&amp;layout=standard&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;height=30" 
							scrolling="no" 
							frameborder="0" 
							style="border:none; overflow:hidden; width:530px; height:30px;" 
							allowTransparency="true"></iframe>
					
				{/if}
				*}
				
				
					<fb:comments href="{$come_from}" 
							     num_posts="{$propackCOMMENTNBR}" 
							     width="{$propackCOMMENTWIDTH}" 
							     css="{$base_dir}modules/propack/facebookcomments.css"
							     ></fb:comments>
					
				{*
				{if $propackLIKEBOTTOMSWITCH == '1'}
					<iframe src="http://www.facebook.com/plugins/like.php?href={$come_from}&amp;layout=standard&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;height=30" 
							scrolling="no" 
							frameborder="0" 
							style="border:none; overflow:hidden; width:530px; height:30px;" 
							allowTransparency="true"></iframe>
					
				{/if}
				*}
			
		{else}<center><a href="{$base_dir}my-account.php" id="customefacebookcommentsregister">
				{l s='Only registered users can post a new comment.' mod='propack'}</center></a>
	{/if}
</div>
<div style="clear:both"></div>
{/if}



{if $propackis16 == 1}
{if $propacktab_blog_pr == 1}

{if count($propackcategories) > 0}
<h3 class="page-product-heading" id="#idTab999">
	{l s='Blog' mod='propack'}
</h3>
{/if}

{/if}

{/if}

{if $propackblogon == 1}

{if $propacktab_blog_pr == 1}

{if count($propackcategories) > 0}
<div id="idTab999" >
	    <ul class="bullet">
	    {foreach from=$propackcategories item=items name=myLoop1}
	    	{foreach from=$items.data item=blog name=myLoop}
	    	
	    	<li class="{if $smarty.foreach.myLoop.first}first_item{elseif $smarty.foreach.myLoop.last}last_item{else}item{/if}">
	    		   
	    		   {if $propackurlrewrite_on == 1}
		    		<a href="{$base_dir}{$propackiso_lng}blog/category/{$blog.seo_url}" title="{$blog.title}">{$blog.title}</a>
		    		{else}
		    		<a href="{$base_dir}modules/propack/blockblog-category.php?category_id={$blog.id}"  title="{$blog.title}">{$blog.title}</a>
		    		{/if}
	    		
	    	</li>
	    	{/foreach}
	    {/foreach}
	    </ul>
</div>

{/if}

{/if}

{/if}



{if $propackreviewson == 1}

{if $propackis16 == 1}
<h3 class="page-product-heading id="#idTab666">{l s='Reviews' mod='propack'} <span id="count-review-tab">({$nbReviews})</span></a>
</h3>
{/if}

<div id="idTab666">



<div id="reviews-list">

{if $reviews}

	{foreach from=$reviews item=review}
<table class="prfb-table-reviews">
	<tr>
		<td class="prfb-left">
			<div class="prfb-name">{$review.customer_name|escape:'html':'UTF-8'}</div>
			<br/>
			{if $propackipon == 1}
			{if strlen($review.ip) > 0}
			<span class="prfb-time">{l s='IP:' mod='propack'} {$review.ip}</span>
			<br/>
			<br/>
			{/if}
			{/if}
			<span class="prfb-time">{dateFormat date=$review.date_add|escape:'html':'UTF-8' full=0}</span>
			<br/>
			<div class="rating">{$review.rating}</div>
		</td>
		<td class="prfb-right">
			<div class="h3" {if $propacksubjecton == 0}style="display:none"{/if}>{$review.subject}</div>
			<div class="rvTxt">
				<p>
					{$review.text_review|escape:'html':'UTF-8'|nl2br}
				</p>
			</div>
		</td>
	</tr>
	<tr {if $propackrecommendedon == 0}style="display:none"{/if}>
		<td class="prfb-left-bottom">&nbsp;</td>
		<td class="prfb-right-bottom" >
			
		 	<div class="recommended">
				<span>{l s='Recommended to buy:' mod='propack'}</span> 
				{if $review.recommended_product == 1}
				<b class="yes">{l s='Yes' mod='propack'}</b>
				{else}
				<b class="no">{l s='No' mod='propack'}</b>
				{/if}
			</div>
				<div class="prfb-clear"></div>
		</td>
	</tr>
</table>
	{/foreach}
	<div id="reviews-paging1">{$pagenav}</div>
{else}
	<p class="align_center">{l s='No customer reviews for the moment.' mod='propack'}</p>
{/if}


</div>

<div id="reviews-paging"></div>

{literal}
<script type="text/javascript">
var module_dir = '{/literal}{$module_dir}{literal}';
</script>
{/literal}


<script type="text/javascript" src="{$module_dir}js/r_stars.js"></script>
{literal}
<script type="text/javascript">
jQuery(document).ready(init_rating);
</script>
{/literal}


{if $propackid_customer == 0 && $propacksettings == 'reg'}
<div class="no-registered-review">
						{l s='Only registered user can add review.' mod='propack'} 
						<a href="{$base_dir_ssl}{if $propackurlrewrite_on == 1}{$propackiso_langrev}/my-account{else}my-account.php{/if}" class="button" {if $propackis_ps15 == 0}style="margin:0 auto"{/if}>{l s='Login' mod='propack'}</a>
						
</div>

{elseif $propackis_buy == 0 && $propacksettings == 'buy'}
<div class="no-registered-review">
			<div class="text-no-reg">
						{l s='Only users who already bought the product can add review.' mod='propack'}
			</div>
</div>

{else}

{if $propackis_add == 1}

<div class="advertise-text-review">
				{l s='You have already add review for this product' mod='propack'}
</div>

{else}

<div class="button-bottom-add-review">
	<a href="javascript:void(0)" class="greenBtnBig" onclick="show_form_review(1)" >
		<b {if $propackis16==1}class="padding16-reviews"{/if}>{l s='Add Review' mod='propack'}</b>
	</a>
</div>

<div id="add-review-form">
	<div class="title-rev">
		<div style="float:left">
		{l s='Add Review' mod='propack'}
		</div>
		<a href="javascript:void(0)" class="greyBtnBig" onclick="show_form_review(0)"
		   style="float:right;margin-bottom:0px" >
			<b {if $propackis16==1}class="padding16"{/if}>{l s='hide form' mod='propack'}</b>
		</a>
		<div style="clear:both"></div>
	</div>
	<table>
		<tr>
			<td class="form-left">{l s='Rating:' mod='propack'}</td>
			<td  class="form-right">
				<span class="rat" style="cursor:pointer; padding-left: 3px;">
					<span onmouseout="read_rating_review_shop('rat_rel');">
						<img  style='margin-left: -3px;' onmouseover="_rating_efect_rev(1,0,'rat_rel')" onmouseout="_rating_efect_rev(1,1,'rat_rel')" onclick = "rating_review_shop('rat_rel',1); rating_checked=true; " src="{$module_dir}images/star-ps-empty.png" alt=""  id="img_rat_rel_1" />
						<img  style='margin-left: -3px;' onmouseover="_rating_efect_rev(2,0,'rat_rel')" onmouseout="_rating_efect_rev(2,1,'rat_rel')" onclick = "rating_review_shop('rat_rel',2); rating_checked=true;" src="{$module_dir}images/star-ps-empty.png" alt=""  id="img_rat_rel_2" />
						<img  style='margin-left: -3px;' onmouseover="_rating_efect_rev(3,0,'rat_rel')" onmouseout="_rating_efect_rev(3,1,'rat_rel')" onclick = "rating_review_shop('rat_rel',3); rating_checked=true;" src="{$module_dir}images/star-ps-empty.png" alt=""  id="img_rat_rel_3" />
						<img  style='margin-left: -3px;' onmouseover="_rating_efect_rev(4,0,'rat_rel')" onmouseout="_rating_efect_rev(4,1,'rat_rel')" onclick = "rating_review_shop('rat_rel',4); rating_checked=true;" src="{$module_dir}images/star-ps-empty.png" alt=""  id="img_rat_rel_4" />
						<img  style='margin-left: -3px;' onmouseover="_rating_efect_rev(5,0,'rat_rel')" onmouseout="_rating_efect_rev(5,1,'rat_rel')" onclick = "rating_review_shop('rat_rel',5); rating_checked=true;" src="{$module_dir}images/star-ps-empty.png" alt=""  id="img_rat_rel_5" />
					</span>
				</span>
				<input type="hidden" id="rat_rel" name="rat_rel" value="0"/>
			</td>
		</tr>
		{if !$propackislogged}
		<tr>
			<td class="form-left">{l s='Name:' mod='propack'}</td>
			<td class="form-right">
				<input type="text" name="name-review"  id="name-review"  style="margin-left:0px;width:80%" />
			</td>
		</tr>
		
		<tr>
			<td class="form-left">{l s='Email:' mod='propack'}</td>
			<td class="form-right">
				<input type="text" name="email-review" id="email-review"  style="margin-left:0px;width:80%" />
			</td>
		</tr>		
		{/if}
		<tr {if $propacksubjecton == 0}style="display:none"{/if}>
			<td class="form-left">{l s='Subject:' mod='propack'}</td>
			<td class="form-right">
				<input type="text" name="subject-review" id="subject-review"  style="margin-left:0px;width:80%" />
			</td>
		</tr>
		<tr>
			<td class="form-left">{l s='Text:' mod='propack'}</td>
			<td class="form-right">
				<textarea style="margin-left:0px;width:80%;height:120px" id="text-review"  name="text-review" cols="42" rows="7"></textarea>
			</td>
		</tr>
		<tr {if $propackrecommendedon == 0}style="display:none"{/if}>
			<td colspan="2" class="recommended-review">{l s='Do you recommend this product to buy?' mod='propack'} 
				<label class="yes-review">
					<input type="radio"  name="recommended-review" value="1" checked="checked"/>&nbsp;{l s='Yes' mod='propack'}
				</label>
				<label class="no-review">
					<input type="radio"  name="recommended-review" value="0"/>&nbsp;{l s='No' mod='propack'}
				</label>
			</td>
		</tr>
		{if $propackis_captcha == 1}
		<tr>
			<td class="form-left">&nbsp;</td>
			<td class="form-right">
			<img width="100" height="26" class="float-left" id="secureCodReview" src="{$base_dir_ssl}modules/propack/captcha.php" alt="Captcha"/>
			<input type="text" class="inpCaptchaReview float-left" id="inpCaptchaReview" size="6"/>
				  <div class="clr"></div>
						  
			<div id="error_inpCaptchaReview" class="errorTxtAdd"></div>	
			</td>
		</tr>
		{/if}
		<tr>
			<td class="form-left">&nbsp;</td>
			<td class="form-right">
				<a href="javascript:void(0)" class="greenBtnBig" onclick="add_review()" style="margin:5px auto 0" >
					<b {if $propackis16==1}class="padding16-reviews"{/if}>{l s='Add review' mod='propack'}</b>
				</a>
			</td>
		</tr>
	</table>

</div>



{literal}
<script type="text/javascript">



function add_review(){
	var _rating_review = $('#rat_rel').val();
	var _subject_review = $('#subject-review').val();
	var _text_review = $('#text-review').val();
	var _name_review = $('#name-review').val();
	var _email_review = $('#email-review').val();
	{/literal}{if $propackis_captcha == 1}{literal}
	var _captcha = $('#inpCaptchaReview').val();
	{/literal}{/if}{literal}
			
	var _recommended_review;
	
	if ($("input[name='recommended-review']:checked").val() == '1') {
		_recommended_review = 1;
	}
	else{
		_recommended_review = 0;
	}

	
	if(_rating_review == 0){
		alert("{/literal}{l s='Please, choose the rating.' mod='propack'}{literal}");
		return;
	}
	{/literal}{if !$propackislogged}{literal}
	if(trim(_name_review).length == 0){
		alert("{/literal}{l s='Please, enter the name.' mod='propack'}{literal}");
		return;
	}
	
	if(trim(_email_review).length == 0){
		alert("{/literal}{l s='Please, enter the email.' mod='propack'}{literal}");
		return;
	}
	{/literal}{/if}{literal}
	if(trim(_text_review).length == 0){
		alert("{/literal}{l s='Please, enter the text.' mod='propack'}{literal}");
		return;
	}


	{/literal}{if $propackis_captcha == 1}{literal}
	if(trim(_captcha).length == 0){
		alert("{/literal}{l s='Please, enter the security code.' mod='propack'}{literal}");
		return;
	}
	{/literal}{/if}{literal}
		
	$('#reviews-list').css('opacity',0.5);
	$('#add-review-form').css('opacity',0.5);
	$('#block-reviews-left-right').css('opacity',0.5);
	
	
	$.post(baseDir+'modules/propack/ajax.php', 
			{action:'addreview',
			 rating:_rating_review,
			 subject:_subject_review,
			 name:_name_review,
			 email:_email_review,
			 text_review:_text_review,
			 id_product:{/literal}{$propackid_product}{literal},
		 	 id_customer:{/literal}{$propackid_customer}{literal},
	 	 	 recommended_product:_recommended_review,
		 	 {/literal}{if $propackis_captcha == 1}{literal}
		 	 captcha:_captcha,
			 {/literal}{/if}{literal}
	 	 	 link:"http://{/literal}{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}{literal}"
		 	 
			 }, 
	function (data) {
		$('#reviews-list').css('opacity',1);
		$('#add-review-form').css('opacity',1);
		$('#block-reviews-left-right').css('opacity',1);
		
		if (data.status == 'success') {

			$('#reviews-list').html('');
			var paging = $('#reviews-list').prepend(data.params.content);
	    	$(paging).hide();
	    	$(paging).fadeIn('slow');

			$('#reviews-paging').html('');
			var paging = $('#reviews-paging').prepend(data.params.paging);
	    	$(paging).hide();
	    	$(paging).fadeIn('slow');

	    	/*
	    	{/literal}{if $propackposition == "left" || $propackid_hook_gsnipblock_left_right == 2}{literal}
		    $('#block-reviews-left').html('');
			var reviews_left = $('#block-reviews-left').prepend(data.params.reviews_left);
	    	$(reviews_left).hide();
	    	$(reviews_left).fadeIn('slow');
	    	{/literal}{/if}{literal}

	    	{/literal}{if $propackposition == "right" || $propackid_hook_gsnipblock_left_right == 1}{literal}
			$('#block-reviews-right').html('');
			var reviews_right = $('#block-reviews-right').prepend(data.params.reviews_right);
		    $(reviews_right).hide();
		    $(reviews_right).fadeIn('slow');
		    {/literal}{/if}{literal}
		    */	
			
			var count_review = data.params.count_reviews;

			$('#count-review-tab').html('');
			$('#count-review-tab').html('('+count_review+')');

			$('#count_review_main').html('');
			$('#count_review_main').html(count_review);

			var avg_rating = data.params.avg_rating;
			$('#review_block .rating').html('');
			$('#review_block .rating').html(avg_rating);
			
			jQuery(document).ready(init_rating);

			{/literal}{if $propackis_onereview == 0}{literal}
				$('#add-review-form').html('');
				
				var is_onereview_null ='<div class="advertise-text-review" style="border:none;padding:5px">'+
				'{/literal}{l s='You have already add review for this product' mod='propack'}{literal}'+
				'</div>';
			$('#add-review-form').html(is_onereview_null);
		
			{/literal}{else}{literal}
				show_form_review(0);
			{/literal}{/if}{literal}
			
			$('#subject-review').val('');
			$('#text-review').val('');
			$('#name-review').val('');
			$('#email-review').val('');
			$('#inpCaptchaReview').val('');
			$('#rat_rel').val('');
			

			{/literal}{if $propackis_captcha == 1}{literal}
			var count = Math.random();
			document.getElementById('secureCodReview').src = "";
			document.getElementById('secureCodReview').src = "{/literal}{$module_dir}{literal}captcha.php?re=" + count;
			{/literal}{/if}{literal}
			
			$(window).scrollTop(630);

			
					
		} else {
			
				var error_type = data.params.error_type;

				var ok = 1;
				if(error_type == 2){
					$('#email-review').addClass('error_testimonials_form');
					alert("{/literal}{l s='Please enter a valid email address. For example johndoe@domain.com.' mod='propack'}{literal}");
					var ok = 0;
				} 

				{/literal}{if $propackis_captcha == 1}{literal}
				if(error_type == 3){ 
					alert("{/literal}{l s='You entered the wrong security code.' mod='propack'}{literal}");
					var ok = 0;
				} 
				{/literal}{/if}{literal}
				
				if(ok == 1) {
					alert(data.message);
				}

				{/literal}{if $propackis_captcha == 1}{literal}
				var count = Math.random();
				document.getElementById('secureCodReview').src = "";
				document.getElementById('secureCodReview').src = "{/literal}{$module_dir}{literal}captcha.php?re=" + count;
				{/literal}{/if}{literal}
			
		}
	}, 'json');
}
</script>
{/literal}

{/if}

{/if}

</div>


{/if}




{if $propackpqon == 1}

{if $propackis16 == 1}
<h3 class="page-product-heading" id="#idTab777">
		{l s='Questions' mod='propack'} <span id="count-questions-tab">({$propackcount_items})</span>
</h3>
{/if}

<div id="idTab777" style="margin-top:10px">

{if $propackcount_itemspq > 0}

<div id="questions-list">

{foreach from=$itemspq item=item name=myLoop}
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


</div>

<div id="questions-paging">{$pagenavpq}</div>
{else}
	<p class="align_center">{l s='No customer questions for the moment.' mod='propack'}</p>
{/if}



{if $propackid_customer == 0 && $propackqsettings == 'reg'}
<div class="no-registered">
						{l s='Only registered user can ask a question.' mod='propack'} 
						<a href="{$base_dir_ssl}{if $propackurlrewrite_on == 1}{$propackiso_langrev}/my-account{else}my-account.php{/if}" class="button" {if $propackis_ps15 == 0}style="margin:0 auto"{/if}>{l s='Login' mod='propack'}</a>
						
</div>
{else}
<a class="blueBtn" 
   href="javascript:void(0)" onclick="show_form_question(1)" 
   id="button-bottom-add-question"
	><b {if $propackis16==1}class="padding16-question"{/if}>{l s='Ask a question' mod='propack'}</b></a>
	
<div id="succes-question">
{l s='Your Question  has been successfully sent our team. Thanks for question!' mod='propack'}						
</div>

<div id="add-question-form">

	<div class="title-rev" id="idTab777-my">
		<div style="float:left">
		{l s='Ask a question' mod='propack'}
		</div>
		<a href="javascript:void(0)" class="greyBtnBig" onclick="show_form_question(0)"
		   style="float:right;margin-bottom:0px" >
			<b {if $propackis16==1}class="padding16-question-form"{/if}>{l s='hide form' mod='propack'}</b>
		</a>
		<div style="clear:both"></div>
	</div>
	<table>
				
		<tr>
			<td class="form-left">{l s='Name' mod='propack'}:</td>
			<td class="form-right">
				<input type="text" name="name-questionpq" id="name-questionpq" style="margin-left:0px;width:80%"  {if $propackcustomer_firstname || $propackcustomer_lastname} value="{$propackcustomer_firstname} {$propackcustomer_lastname}" {else} value="" {/if} />
			</td>
		</tr>
		<tr>
			<td class="form-left">{l s='Email' mod='propack'}:</td>
			<td class="form-right">
				<input type="text" name="email-questionpq" id="email-questionpq" style="margin-left:0px;width:80%" value="{$propackemail}" />
			</td>
		</tr>
		<tr>
			<td class="form-left">{l s='Question' mod='propack'}:</td>
			<td class="form-right">
				<textarea style="margin-left:0px;width:80%;height:120px" id="text-questionpq" name="text-questionpq" cols="42" rows="7"></textarea>
			</td>
		</tr>
		{if $propackqis_captcha == 1}
		<tr>
			<td class="form-left">&nbsp;</td>
			<td class="form-right">
			<img width="100" height="26" class="float-left" id="secureCodReviewpq" src="{$base_dir_ssl}modules/propack/captcha.php" alt="Captcha">
			<input type="text" class="inpCaptchaReview float-left" id="inpCaptchaReviewpq" size="6">
				  <div class="clr"></div>
						  
			<div id="error_inpCaptchaReviewpq" class="errorTxtAdd"></div>	
			</td>
		</tr>
		{/if}
		<tr>
			<td class="form-left">&nbsp;</td>
			<td class="form-right">
				<a href="javascript:void(0)" class="greenBtnBig" onclick="add_question()" style="margin:5px auto 0" >
					<b {if $propackis16==1}class="padding16-question-form"{/if}>{l s='Ask a question' mod='propack'}</b>
				</a>
			</td>
		</tr>
		
	</table>
	

</div>
{/if}

</div>

{literal}
<script type="text/javascript">


function add_question(){
	var _name_question = $('#name-questionpq').val();
	var _email_question = $('#email-questionpq').val();
	var _text_question = $('#text-questionpq').val();
	{/literal}{if $propackqis_captcha == 1}{literal}
		var _captcha = $('#inpCaptchaReviewpq').val();
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

	{/literal}{if $propackqis_captcha == 1}{literal}
		if(trim(_captcha).length == 0){
			$('#inpCaptchaReviewpq').addClass('error_testimonials_form');
			alert("{/literal}{l s='Please, enter the security code.' mod='propack'}{literal}");
			return;
		}
	{/literal}{/if}{literal}
		
	$('#add-question-form').css('opacity',0.5);
	$.post(baseDir + 'modules/propack/ajax.php', 
			{action:'addquestion',
			 name:_name_question,
			 email:_email_question,
			 text_question:_text_question,
			 {/literal}{if $propackqis_captcha == 1}{literal}
			 	 captcha:_captcha,
			 {/literal}{/if}{literal}
			 id_product:{/literal}{$propackid_product}{literal}
		 	 }, 
	function (data) {
		$('#add-question-form').css('opacity',1);
		
		if (data.status == 'success') {

			
			show_form_question(0);

			$('#name-questionpq').val('');
			$('#email-questionpq').val('');
			$('#text-questionpq').val('');
			$('#inpCaptchaReviewpq').val('');
			
			$('#succes-question').show();

			$('#email-questionpq').removeClass('error_testimonials_form');
			$('#inpCaptchaReviewpq').removeClass('error_testimonials_form');
			

			{/literal}{if $propackqis_captcha == 1}{literal}
				var count = Math.random();
				document.getElementById('secureCodReviewpq').src = "";
				document.getElementById('secureCodReviewpq').src = "{/literal}{$module_dir}{literal}captcha.php?re=" + count;
			{/literal}{/if}{literal}
			
					
		} else {
			$('#add-question-form').css('opacity',1);
			var error_type = data.params.error_type;
			
			if(error_type == 2){
				$('#email-questionpq').addClass('error_testimonials_form');
				alert("{/literal}{l s='Please enter a valid email address. For example johndoe@domain.com.' mod='propack'}{literal}");
			} 
			{/literal}{if $propackqis_captcha == 1}{literal}
				else if(error_type == 3){ 
					$('#inpCaptchaReviewpq').addClass('error_testimonials_form');
					alert("{/literal}{l s='You entered the wrong security code.' mod='propack'}{literal}");
				} 
			{/literal}{/if}{literal}

			else {
				alert(data.message);
			}

				{/literal}{if $propackqis_captcha == 1}{literal}
					var count = Math.random();
					document.getElementById('secureCodReviewpq').src = "";
					document.getElementById('secureCodReviewpq').src = "{/literal}{$module_dir}{literal}captcha.php?re=" + count;
				{/literal}{/if}{literal}
			
		}
	}, 'json');
}


function go_page_question( page,id_product ){

	$('#questions-list').css('opacity',0.5);
	$('#questions-paging').css('opacity',0.5);
	
	
	$.post(baseDir + 'modules/propack/ajax.php', 
				{action:'pagenavsitepq',
				 page:page,
				 id_product:id_product
				 }, 
	function (data) {
		if (data.status == 'success') {

			
			$('#questions-list').css('opacity',1);
			$('#questions-paging').css('opacity',1);
			
			$('#questions-list').html('');
			var content = $('#questions-list').prepend(data.params.content);
	    	$(content).hide();
	    	$(content).fadeIn('slow');

	    	$('#questions-paging').html('');
			var paging = $('#questions-paging').prepend(data.params.paging);
	    	$(paging).hide();
	    	$(paging).fadeIn('slow');
	    	
							
		} else {
			alert(data.message);
		}
	}, 'json');
}
</script>
{/literal}

{/if}
