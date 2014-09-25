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

#upload_logo1 {
	  visibility: hidden;
	  width: 0;
	  height: 0;
	}
	#fileSelect
	{
	  -moz-border-bottom-colors: none;
		-moz-border-left-colors: none;
		-moz-border-right-colors: none;
		-moz-border-top-colors: none;
		background: -moz-linear-gradient(center top , rgba(255, 255, 255, 0.3) 50%, #FFCC00 50%, #FFCC00) repeat scroll 0 0 #FFCC00;
		border-color: #FFCC00 #FFCC00 #9F9F9F;
		border-image: none;
		border-radius: 2px 2px 2px 2px;
		border-style: solid;
		border-width: 1px;
		box-shadow: 0 1px 0 rgba(255, 255, 255, 0.5) inset;
		color: #08233E;
		cursor: pointer;
		padding: 4px;
		text-shadow: 0 1px #FFFFFF;
	}
	#fileSelect:hover:before {
	  border-color: black;
	}
	#fileSelect:active:before {
	  background: -webkit-linear-gradient(top, #e3e3e3, #f9f9f9);
	}
	#img_size_error
	{
	 float:left;
	 color:red;
	 font-size:14px;
	}
	.info_description {
		clear: both;
		color: #7F7F7F;
		font-family: Georgia,Arial,'sans-serif';
		font-size: 11px;
		font-style: italic;
		text-align: left;
		width: 100%;
	}
</style>

<script language="javascript" type="text/javascript">

tinyMCE.init({

		lang : "fr",
        theme : "advanced",
        mode : "textareas",
		theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "top",
        theme_advanced_resizing : true,
		editor_selector : 'about_business',
});
</script>
<div class="seller_registration_form">
	<div class="page-heading">
		<h1>{l s='Seller Request' mod='marketplace'}</h1>
	</div>
	{if $img_size_error == 1}
	<div id="img_size_error">
	  Image must be of 200px*200px
	</div>
	{/if}
	<div class="seller_registration_form_content">
		<form action="{$new_link2}" method="post" id="createaccountform" class="std" enctype="multipart/form-data">
			<div class="inner_form_div">
				<div class="row-info">
					<div id="error" style="display:none;">{l s='All field required' mod='marketplace'}</div>
				</div>
				<div id="outer_container">
					<div class="row-info">	
						<div class="row-info-left">{l s='Shop Name' mod='marketplace'}<sup>*</sup></div>	
						<div class="row-info-right">
						<input class="reg_sel_input" type="text" id="shop_name1" name="shop_name" />
						<input type="hidden" id="checkshopurl" value="{$modules_dir}marketplace/checkshopname.php"/>
						<label class="errors" id="shop_name_error">Required field.</label>
						</div>	
					</div>	
					<div class="row-info">
						<div class="row-info-left">{l s='Shop Description' mod='marketplace'}</div>
						<div class="row-info-right1"><textarea name="about_business"  class="about_business" style="height: 100px;   padding: 2%;width: 98%;"></textarea></div>
					</div> <!--about_business--> 
					<div class="row-info">  
						<div id="upload_logo" class="sell_row">
							<div class="row-info-left">{l s='Upload Logo' mod='marketplace'}</div>
							<div class="row-info-right1">
								<input class="reg_sel_input" id="upload_logo1" type="file"  name="upload_logo" />
								<button id="fileSelect" name="upload_logo">Upload Logo</button>
								<div class="info_description">{l s='Logo Size Must Be 200*200' mod='marketplace'}</div>
							</div>
						</div> <!--upload_logo-->
						
					</div>
					  
					<div id="person_name" class="row-info" >
						<div class="row-info-left">{l s=' Seller Name' mod='marketplace'}<sup>*</sup></div>
						<div class="row-info-right"><input class="reg_sel_input"  type="text" name="person_name" id="person_name1" /><label class="errors" id="person_name_error">Required field.</label></div>
					</div> <!-- person_name--> 
					
					<div class="row-info">
						<div class="row-info-left">{l s='Phone' mod='marketplace'}<sup>*</sup></div>
						<div class="row-info-right"><input class="reg_sel_input" type="text" name="phone" id="phone1" maxlength="10" /><label class="errors" id="phone_error"></label></div>
					</div> <!-- phone-->
						 
							
				<div class="row-info">
					<div class="row-info-left">{l s='Fax' mod='marketplace'}</div>
					<div class="row-info-right"><input class="reg_sel_input" type="text" name="fax"  id="fax1" maxlength="10" /><label class="errors" id="fax_error"></label></div>
				</div> <!-- fax--> 
				
				<div class="row-info">	
					<div class="row-info-left">{l s='Business Email' mod='marketplace'}</div>
					<div class="row-info-right"><input class="reg_sel_input" type="text" name="business_email_id" id="business_email_id1"  /><label class="errors" id="business_email_id_error">Not a Valid Email Address</label></div>
				</div>  <!-- siteurl--> 
							
				<div class="row-info">	
					<div class="row-info-left">{l s='Address' mod='marketplace'}</div>
					<div class="row-info-right1"><textarea name="address"></textarea></div>
				</div>
				
				<div id="facebook" class="row-info" >
						<div class="row-info-left">{l s='Facebook Id' mod='marketplace'}</div>
						<div class="row-info-right"><input class="reg_sel_input"  type="text" name="fb_id" id="fb_id1" /></div>
					</div>
					
				<div id="twitter" class="row-info" >
						<div class="row-info-left">{l s='Twitter Id' mod='marketplace'}</div>
						<div class="row-info-right"><input class="reg_sel_input"  type="text" name="tw_id" id="tw_id1" /></div>
					</div>	
					
				{hook h="DisplayMpshoprequestfooterhook"}
				
				<div class="row-info" style="text-align:center;">
					<input type="submit" value="{l s='Register' mod='marketplace'}" class="button_large"  id="seller_save"/>
				</div>  
			</div> <!-- outer_container--> 	
			
			</div>
		</form>
	</div>
</div>


<script type="text/javascript">
	document.querySelector('#fileSelect').addEventListener('click', function(e) {
								e.preventDefault();
								  // Use the native click() of the file input.
								  document.querySelector('#upload_logo1').click();
							}, false);
	var error = 0;
		$(document).ready(function() {
		
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
	
	
	$("#createaccountform").submit(function() {
			
		if($("#phone1").val() == "" || $("#address1").val() == "" || $("#shop_name1").val() == "" || $("#person_name1").val() == "" ) 
		{
			$("#error").css("display","block");
			return false;
		} 
		else if(error == 1)
		{
			return false;
		} 
		else 
		{
			$("#error").css("display","none");
			return true;
		}
	});
});		 
</script>