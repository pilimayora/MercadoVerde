<style>
	.row-info-left {
		color: {$req_text_color};
		float: left;
		font-family: myraid pro;
		font-size: {$req_text_size}px;
		font-weight: bold;
		height: 32px;
		width: 24%;
		font-family:{$req_text_font_family};
	}
	.inner_form_div {
		border: 1px solid {$req_border_color};
		float: left;
		margin-top: 10px;
		padding: 2.5%;
		width: 95%;
	}

	.page-heading h1 {
		margin-bottom: 4px;
		padding-bottom: 6px;
		padding-top: 4px;
		font-size:{$req_heading_size}px;
		font-family:{$req_heading_font_family};
		color:{$req_heading_color};
	}

</style>

<script language="javascript" type="text/javascript">
	tinyMCE.init({

		mode : "specific_textareas",
		theme : "advanced",
		theme_advanced_buttons1 : "bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright,forecolor, justifyfull,bullist,numlist,undo,redo,link,unlink,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		//theme_advanced_statusbar_location : "bottom",
		plugins : 'inlinepopups',
        theme_advanced_resizing : true,
		editor_selector : 'about_business'
		
});
</script>
		
{if $show_toolbar}
	{include file="toolbar.tpl" toolbar_btn=$toolbar_btn toolbar_scroll=$toolbar_scroll title=$title}
	<div class="leadin">{block name="leadin"}{/block}</div>
{/if}
{block name="other_fieldsets"}
	 <fieldset>
       <legend>Add New seller</legend>
    <form id="{$table}_form" class="defaultForm {$name_controller}" action="{$current}&{if !empty($submit_action)}{$submit_action}{/if}&token={$token}" method="post" enctype="multipart/form-data" {if isset($style)}style="{$style}"{/if}>
	{if $form_id}
		<input type="hidden" name="{$identifier}" id="{$identifier}" value="{$form_id}" />
	{/if}
	<input type="hidden" name="set" id="set" value="{$set}" />
	
	<div class="form_registration">
		<div class="seller_registration_form">
			<div class="seller_registration_form_content">
				<div class="inner_form_div">
						<div class="row-info">
							<div id="error" style="display:none;">All field required</div>
						</div>
						<div id="outer_container">
							{if {$set}==1}
								<div class="row-info">	
									<div class="row-info-left">{l s='Chosse Customer' mod='sellerpartner'}<sup>*</sup></div>	
									<div class="row-info-right">
										<select name="shop_customer">
											{foreach $customer_info as $cusinfo}
												<option value="{$cusinfo['id_customer']}">{$cusinfo['email']}</option>
											{/foreach}
										</select>
									</div>	
								</div>
							{else}
								<input type="hidden" value="{$market_place_seller_id}" name="market_place_seller_id" />
								<input type="hidden" value="{$shop_name}" name="pre_shop_name" />
							{/if}
							<div class="row-info">	
								<div class="row-info-left">{l s='Shop Name' mod='sellerpartner'}<sup>*</sup></div>	
								<div class="row-info-right"><input class="reg_sel_input" type="text" id="shop_name1" name="shop_name" value="{$shop_name}"/><label class="errors" id="shop_name_error">Required field.</label></div>	
							</div>	
							<div class="row-info">
								<div class="row-info-left">{l s='Shop Description' mod='sellerpartner'}</div>
								<div class="row-info-right1"><textarea name="about_business"  class="about_business" style="height: 100px;   padding: 2%;width: 550px;">{$about_shop}</textarea></div>
							</div> <!--about_business--> 
							{if {$set}==0}
								<div class="row-info">  
									<div class="row-info-left">{l s='Previous Logo' mod='sellerpartner'}</div>
									<div class="prev_image" style="float:left;">
										<img src="../modules/marketplace/img/shop_img/{$market_place_seller_id}-{$shop_name}.jpg" />
									</div>
								</div>
							{/if} 
							<div class="row-info">  
								<div id="upload_logo" class="sell_row">
									{if {$set}==0}
										<div class="row-info-left">{l s='Change Logo' mod='sellerpartner'}</div>
									{else}
										<div class="row-info-left">{l s='Upload Logo' mod='sellerpartner'}</div>
									{/if}
									<div class="row-info-right"><input class="reg_sel_input" type="file"  name="upload_logo" /></div>
								</div> <!--upload_logo-->
							</div>
							 
							<div id="person_name" class="row-info" >
								<div class="row-info-left">{l s=' Seller Name' mod='sellerpartner'}<sup>*</sup></div>
								<div class="row-info-right"><input class="reg_sel_input"  type="text" name="person_name" id="person_name1" value="{$seller_name}"/><label class="errors" id="person_name_error">Required field.</label></div>
							</div> <!-- person_name--> 
							
							<div class="row-info">
								<div class="row-info-left">{l s='Phone' mod='sellerpartner'}<sup>*</sup></div>
								<div class="row-info-right"><input class="reg_sel_input" type="text" name="phone" id="phone1" maxlength="10" value="{$phone}"/><label class="errors" id="phone_error"></label></div>
							</div> <!-- phone-->
								 
									
						<div class="row-info">
							<div class="row-info-left">{l s='Fax' mod='sellerpartner'}</div>
							<div class="row-info-right"><input class="reg_sel_input" type="text" name="fax"  id="fax1" maxlength="10" value="{$fax}"/><label class="errors" id="fax_error"></label></div>
						</div> <!-- fax--> 
						
						<div class="row-info">	
							<div class="row-info-left">{l s='Business Email' mod='sellerpartner'}</div>
							<div class="row-info-right"><input class="reg_sel_input" type="text" name="business_email_id" id="business_email_id1"  value="{$business_email}" style="height:25px;"/><label class="errors" id="business_email_id_error" >Not a Valid Email Address</label></div>
						</div>  <!-- siteurl--> 
									
						<div class="row-info">	
							<div class="row-info-left">{l s='Address' mod='sellerpartner'}</div>
							<div class="row-info-right1"><textarea name="address">{$address}</textarea></div>
						</div>
						
						<div id="facebook" class="row-info" >
								<div class="row-info-left">{l s='Facebook Id' mod='sellerpartner'}</div>
								<div class="row-info-right"><input class="reg_sel_input"  type="text" name="fb_id" id="fb_id1" value="{$facebook_id}"/></div>
							</div>
							
						<div id="twitter" class="row-info" >
								<div class="row-info-left">{l s='Twitter Id' mod='sellerpartner'}</div>
								<div class="row-info-right"><input class="reg_sel_input"  type="text" name="tw_id" id="tw_id1" value="{$twitter_id}"/></div>
							</div>	
					</div> <!-- outer_container--> 	
					
					</div>
			</div>
		</div>






	
	</div>
	
	<div class="margin-form">
		<input type="submit"
			id="{if isset($field.id)}{$field.id}{else}{$table}_form_submit_btn{/if}"
			value="{$field.title}"
			name="{if isset($field.name)}{$field.name}{else}{$submit_action}{/if}{if isset($field.stay) && $field.stay}AndStay{/if}"
			{if isset($field.class)}class="{$field.class}"{/if} />
			
	</div>
</form>
</fieldset>
{/block}
{block name=script}
	<script type="text/javascript">
		$(document).ready(function() {	
			var error = 0;
			var space =  /\s/g;
			$("#fax1").focusin(function() {
				$("#fax_error").html('');
				error = 0;
			});
			$("#fax1").focusout(function() {
				var numeric = /^[0-9]+$/;
				var fax = $("#fax1").val();
				if(fax=='') {
					$("#fax_error").html('');
					error = 0;
				} else {
					if(space.test(fax)) {
						$("#fax_error").css("display","block");
						$("#fax_error").html('Space are not allowed.');
						error = 1;
					} else {
						if(fax.match(numeric)) {
							$("#fax_error").html('');
							error = 0;
						}
						else {
							$("#fax_error").css("display","block");
							$("#fax_error").html('Must be in integer.');
							error = 1;
						}
					}
				}
			});
		
			$("#phone1").focusin(function() {
				$("#phone_error").html('');
				error = 0;
			});
			
			$("#phone1").focusout(function() {
				var numeric = /^[0-9]+$/;
				var phone = $("#phone1").val();
				if(phone=='') {
					$("#phone_error").css("display","block");
					$("#phone_error").html('Required field');
					error = 1;
				} else {
					if(space.test(phone)) {
						$("#phone_error").css("display","block");
						$("#phone_error").html('Space are not allowed.');
						error = 1;
					} else {
						if(phone.match(numeric)) {
							$("#phone_error").html('');
							error = 0;
						} else {
							$("#phone_error").css("display","block");
							$("#phone_error").html('Must be in integer.');
							error = 1;
						}
					}
				}
			});
		
		
		
		$("#person_name1").focusin(function() {
			$("#person_name_error").css("display","none");
			error = 0;
		});
		
		$("#person_name1").focusout(function() {
			if($("#person_name1").val()=='') {
				$("#person_name_error").css("display","block");
				error = 1;
			} else {
				$("#person_name_error").css("display","none");
				error = 0;
			}
		});
		$("#shop_name1").focusin(function() {
			$("#shop_name_error").css("display","none");
			error = 0;
		});
		$("#shop_name1").focusout(function() {
			if($("#shop_name1").val()=='') {
				$("#shop_name_error").css("display","block");
				error = 1;
			} else {
				$("#shop_name_error").css("display","none");
				error = 0;
			}
		});
		
		$("#business_email_id1").change(function() {
			var email= $("#business_email_id1").val();
			var mail =/^[a-zA-Z]*$/;
			var reg = /^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
			if(!reg.test(email)){         
				$("#business_email_id_error").css("display","block");
				error = 1;
			}else{   
				$("#business_email_id_error").css("display","none");
				error = 0;
			}
			
		});
		
		
		{*$("#marketplace_seller_info_form").submit(function() {
			if($("#phone1").val() == "" || $("#address1").val() == "" || $("#shop_name1").val() == "" || $("#person_name1").val() == "" ) {
				$("#error").css("display","block");
				return false;
			} else if(error == 1) {
				return false;
			} else {
				$("#error").css("display","none");
				return true;
			}
		});*}
	});		 
</script>
{/block}