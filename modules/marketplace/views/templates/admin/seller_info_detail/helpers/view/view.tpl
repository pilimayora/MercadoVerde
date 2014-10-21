<style>
	.row-info-right1 textarea{
		background-color: white;
	}
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
{if $show_toolbar}
	{include file="toolbar.tpl" toolbar_btn=$toolbar_btn toolbar_scroll=$toolbar_scroll title=$title}
	<div class="leadin">{block name="leadin"}{/block}</div>
{/if}
{block name="override_tpl"}
	<fieldset>
       <legend>View Seller</legend>
	   
	   <div class="form_registration">
		<div class="seller_registration_form">
			<div class="seller_registration_form_content">
				<div class="inner_form_div">
						
						<div id="outer_container">
							<div class="row-info">	
								<div class="row-info-left">{l s='Shop Name' mod='sellerpartner'}<sup>*</sup></div>	
								<div class="row-info-right"><input class="reg_sel_input" type="text" id="shop_name1" name="shop_name" value="{$market_place_seller_info['shop_name']}" disabled/><label class="errors" id="shop_name_error">Required field.</label></div>	
							</div>	
							<div class="row-info">
								<div class="row-info-left">{l s='Shop Description' mod='sellerpartner'}</div>
								<div class="row-info-right1"><textarea rows="6" cols="35" disabled>{$about_shop}</textarea></div>
							</div> <!--about_business--> 
							
							
							 
							<div id="person_name" class="row-info" >
								<div class="row-info-left">{l s=' Seller Name' mod='sellerpartner'}<sup>*</sup></div>
								<div class="row-info-right"><input class="reg_sel_input"  type="text" name="person_name" id="person_name1" value="{$seller_name}" disabled/><label class="errors" id="person_name_error">Required field.</label></div>
							</div> <!-- person_name--> 
							
							<div class="row-info">
								<div class="row-info-left">{l s='Phone' mod='sellerpartner'}<sup>*</sup></div>
								<div class="row-info-right"><input class="reg_sel_input" type="text" name="phone" id="phone1" maxlength="10" value="{$phone}" disabled/><label class="errors" id="phone_error"></label></div>
							</div> <!-- phone-->
								 
									
						<div class="row-info">
							<div class="row-info-left">{l s='Fax' mod='sellerpartner'}</div>
							<div class="row-info-right"><input class="reg_sel_input" type="text" name="fax"  id="fax1" maxlength="10" value="{$fax}" disabled/><label class="errors" id="fax_error"></label></div>
						</div> <!-- fax--> 
						
						<div class="row-info">	
							<div class="row-info-left">{l s='Business Email' mod='sellerpartner'}</div>
							<div class="row-info-right"><input class="reg_sel_input" type="text" name="business_email_id" id="business_email_id1"  value="{$business_email}" style="height:25px;" disabled/><label class="errors" id="business_email_id_error" >Not a Valid Email Address</label></div>
						</div>  <!-- siteurl--> 
									
						<div class="row-info">	
							<div class="row-info-left">{l s='Address' mod='sellerpartner'}</div>
							<div class="row-info-right1"><input class="reg_sel_input" type="text" name="address" id="address" maxlength="10" value="{$address}" disabled/></div>
						</div>
						
						<div id="facebook" class="row-info" >
								<div class="row-info-left">{l s='Facebook Id' mod='sellerpartner'}</div>
								<div class="row-info-right"><input class="reg_sel_input"  type="text" name="fb_id" id="fb_id1" value="{$facebook_id}" disabled/></div>
							</div>
							
						<div id="twitter" class="row-info" >
								<div class="row-info-left">{l s='Twitter Id' mod='sellerpartner'}</div>
								<div class="row-info-right"><input class="reg_sel_input"  type="text" name="tw_id" id="tw_id1" value="{$twitter_id}" disabled/></div>
						</div>	
						
						<div class="row-info">  
									<div class="row-info-left">{l s='Shop Logo' mod='sellerpartner'}</div>
									<div class="prev_image" style="float:left;">
										<img src="../modules/marketplace/img/shop_img/{$market_place_seller_id}-{$market_place_seller_info['shop_name']}.jpg" width="100" height="100"/>
									</div>
						</div>
						
						<div class="row-info">  
									<div class="row-info-left">{l s='Seller Logo' mod='sellerpartner'}</div>
									<div class="prev_image" style="float:left;">
										<img src="../modules/marketplace/img/seller_img/{$market_place_seller_id}.jpg" width="100" height="100" />
									</div>
						</div>
					</div> <!-- outer_container--> 	
					
					</div>
			</div>
		</div>	
	</div>
							
	</fieldset>
	
{/block}
<script type="text/javascript">
	$('.fancybox').fancybox();
</script>