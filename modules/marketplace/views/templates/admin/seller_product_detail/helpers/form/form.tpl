<style>
.add_one {
	font-size:{$add_size}px;
	font-weight:bold;
	color:{$add_color}!important;
	width:150px!important;
	margin-left:10px!important;
	font-family:{$add_font_family};
}

#addproduct_fieldset {
	width:400px;
	border:1px solid {$add_border_color};
}
.row-info {
    float: left;
    padding-left: 2%;
    padding-top: 10px;
    width: 98%;
}
.row-info-left {
    color: {$add_color}!important;
    float: left;
    font-family: {$add_font_family};
    font-size: {$add_size}px;
    font-weight: bold;
    height: 32px;
    width: 24%;
}

.row-info-right {
    float: left;
    font-size: 15px;
    width: 76%;
}

.row-info-right input[type="text"],select{
	width:25%;
	padding:6px;
}

.product_error {
	float:left;
	width:40%;
	color:red;
	margin-left:0px !important;
}

.middle_container {
	float:left;
	width:100%;
}	
.table {
	border: 0 none;
	border-spacing: 0;
	empty-cells: show;
	font-size: 100%;
	width:100%;
}
.table tr {
	padding:5px;
}
.table tr th {
	background: -moz-linear-gradient(center top , #F9F9F9, #ECECEC) repeat-x scroll left top #ECECEC;
	color: #333333;
	font-size: 13px;
	padding: 4px 6px;
	text-align: left;
	text-shadow: 0 1px 0 #FFFFFF;
	text-align:center;
}
.table tr td {
	border-bottom: 1px solid #CCCCCC;
	color: #333333;
	font-size: 12px;
	padding: 4px 4px 4px 6px;
	text-align:center;
}

#tree1 label{
	padding-left:2px;
	font-size:12px;
	float:none !important;
}

#tree1 ul{
	margin-left:13px;
	margin-top:3px;
}

#tree1{
	background:none !important;
	border: 0 !important;
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
		editor_selector : 'product_description'
		
});

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
		editor_selector : 'short_description'
		
});
</script>
		
{if $show_toolbar}
	{include file="toolbar.tpl" toolbar_btn=$toolbar_btn toolbar_scroll=$toolbar_scroll}
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
	
						<div class="row-info">
							<div id="error" style="display:none;">All field required</div>
						</div>
						<div id="outer_container">
							{if {$set}==1}
								{hook h='DisplayMpaddproductheaderhook'}
								<div class="row-info">	
									<div class="row-info-left">{l s='Choose Customer' mod='marketplace'}<sup>*</sup></div>	
									<div class="row-info-right">
										<select name="shop_customer">
											{foreach $customer_info as $cusinfo}
												<option value="{$cusinfo['id_customer']}">{$cusinfo['email']}</option>
											{/foreach}
										</select>
									</div>	
								</div>
							{else}
								<input type="hidden" value="{$pro_info['id']}" name="market_place_product_id" />
								
							{/if}
							<div class="row-info">	
								<div class="row-info-left">
									<label class="add_one" for="product_name" >{l s='Product Name :' mod='marketplace'}</label>
								</div>
								<div class="row-info-right">
									<input type="text" id="product_name" name="product_name"  {if {$set}==0}value="{$pro_info['product_name']}"{/if}/> <sup>*</sup>
									<span id="product_name_error">{l s='Value should be Character ' mod='marketplace'}</span>
								</div>
							</div>
							
							<div class="row-info">	
								<div class="row-info-left">
									<label class="add_one" for="short_description">{l s='Short Description :' mod='marketplace'}</label>
								</div>
								<div class="row-info-right" style="height:220px;">
									<span>
										<textarea style="width:550px;height:200px;" id="short_description" name="short_description" class="short_description">
											{if {$set}==0}{$pro_info['short_description']}{/if}
										</textarea>
									</span>
									<span id="short_description_error">
										{l s='Value should be Character ' mod='marketplace'}
									</span>
								</div>
							</div>
							<div class="row-info">	
								<div class="row-info-left">
									<label class="add_one" for="product_description">{l s='Product Description :' mod='marketplace'}</label>
								</div>
								<div class="row-info-right">
									<span>
										<textarea style="width:550px;height:200px;" id="product_description" name="product_description" class="product_description">
											{if {$set}==0}{$pro_info['description']}{/if}
										</textarea>
									</span>
									<span id="product_description_error">
										{l s='Value should be Character ' mod='marketplace'}
									</span>
								</div>
							</div>
							<div class="row-info">	
								<div class="row-info-left">
									<label class="add_one" for="product_price">
										{l s='Product Price :' mod='marketplace'}</label>
								</div>
								<div class="row-info-right">
										<input type="text" id="product_price" name="product_price" {if {$set}==0}value="{$pro_info['price']}"{/if} /> <sup>*</sup>
									<div id="product_price_error" class="product_error">
										{l s='Value should be Numeric' mod='marketplace'}
									</div>
								</div>
							</div>
							<div class="row-info">
								<div class="row-info-left">
									<label class="add_one" for="product_quantity">{l s='Product Quantity :' mod='marketplace'}</label>
								</div>
								<div class="row-info-right">
									<input type="text" id="product_quantity" name="product_quantity" {if {$set}==0}value="{$pro_info['quantity']}"{/if} /> <sup>*</sup>
									<div id="product_quantity_error" class="product_error">
										{l s='Value should be Integer ' mod='marketplace'}
									</div>
								</div> 
							</div>
							<div class="row-info">
								<div class="row-info-left">
									<label class="add_one" for="product_category">{l s='Product Category :' mod='marketplace'}</label>
								</div>
								<div class="row-info-right">	
									{$categoryTree}
								</div>
							</div>
							
							<script type="text/javascript">
								$(document).ready(function() {
									$('#tree1').checkboxTree();
								});
							</script>
			
							<div class="row-info">
								<div class="row-info-left">
									<label class="add_one" for="product_image">{l s='Upload Image:' mod='marketplace'}</label>
								</div>
								<div class="row-info-right">
									<span><input type="file" id="product_image" name="product_image" value="" size="chars" /></span><br />
									<a onclick="showOtherImage(); return false;">
								</div>
								
							</div>
							{if {$set}==1}
								<div class="row-info">
									<div class="row-info-left">
										<span id="add_img">{l s='Add Other Image :' mod='marketplace'}</a></span><br />
									</div>
									<div class="row-info-right">
										<div id="otherimages"></div>
									</div>
								</div>
								{hook h="DisplayMpaddproductfooterhook"}
							{/if}
							{if {$set}==0}
								{hook h="DisplayMpupdateproductfooterhook"}
								{if {$is_product_onetime_activate}==1}
									{if {$is_image_found}==1}
										<div class="row-info">
											<div class="row-info-left">
												<span id="add_img">{l s='Active Image for Product' mod='marketplace'}</a></span><br />
											</div>
											
										</div>
										<div class="row-info">
											<table id="imageTable" cellspacing="0" cellpadding="0" class="table">
												<tr>
													<th>Image</th>
													<th>Position</th>
													<th>Cover</th>
													<th>Action</th>		
												</tr>
												{assign var=j value=0}
												{foreach $id_image as $id_image1}
													<tr class="imageinforow{$id_image1}">
														<td>
															<a class="fancybox" href="http://{$image_link[$j]}">
																<img width="45" height="45" alt="15" src="http://{$image_link[$j]}">
															</a>
														</td>
														<td>{$position[$j]}</td>
														<td>
														
															{if {$is_cover[$j]}==1} 
														
																<img class="covered" id="changecoverimage{$id_image1}" alt="{$id_image1}" src="../img/admin/enabled.gif" is_cover="1" id_pro="{$id_product}">
																
														
															{else}
														
																<img class="covered" id="changecoverimage{$id_image1}" alt="{$id_image1}" src="../img/admin/forbbiden.gif" is_cover="0" id_pro="{$id_product}">
														
															{/if}
														
														</td>
														<td>
														
														{if {$is_cover[$j]}==1 }
														
															<img title="Delete this image" class="delete_pro_image" alt="{$id_image1}" src="../img/admin/delete.gif" is_cover="1" id_pro="{$id_product}">
													
														{else}
														
															<img title="Delete this image" class="delete_pro_image" alt="{$id_image1}" src="../img/admin/delete.gif" is_cover="0" id_pro="{$id_product}">
														{/if}
														</td>
													</tr>
													{assign var=j value=$j+1}
												{/foreach}
											</table>
										</div>
									{/if}
								{/if}
								{if {$is_unactive_image}==1}
									<div class="row-info">
										<div class="row-info-left">
											<span id="add_img">{l s='Unactive Image for Product' mod='marketplace'}</a></span><br />
										</div>						
									</div>
									<div class="row-info">
										<table id="imageTable" cellspacing="0" cellpadding="0" class="table">
											<tr>
												<th>{l s='Image' mod='marketplace'}</th>
												<th>Action</th>		
											</tr>
											{foreach $unactive_image as $unactive_image1}
												<tr class="unactiveimageinforow{$unactive_image1['id']}">
													<td>
														<a class="fancybox" href="../modules/marketplace/img/product_img/{$unactive_image1['seller_product_image_id']}.jpg">
															<img title="15" width="45" height="45" alt="15" src="../modules/marketplace/img/product_img/{$unactive_image1['seller_product_image_id']}.jpg" />
														</a>
													</td>
													<td>
														<img title="Delete this image" class="delete_unactive_pro_image" alt="{$unactive_image1['id']}" src="../img/admin/delete.gif" img_name="{$unactive_image1['seller_product_image_id']}">
													</td>
												</tr>
											{/foreach}
										</table>
									</div>
								{/if}
							{/if}
	<div class="margin-form">
		<input type="submit"
			id="{if isset($field.id)}{$field.id}{else}{$table}_form_submit_btn{/if}"
			
			name="{if isset($field.name)}{$field.name}{else}{$submit_action}{/if}{if isset($field.stay) && $field.stay}AndStay{/if}"
			{if isset($field.class)}class="{$field.class}"{/if} />
			
	</div>
</form>
</fieldset>
{/block}
{block name=script}
	<script language="javascript" type="text/javascript">



	var i=2;

function showOtherImage() {

var newdiv = document.createElement('div');

newdiv.setAttribute("id","childDiv"+i);

newdiv.innerHTML = "<input type='file' id='images"+i+"' name='images[]' /><a href=\"javascript:;\" onclick=\"removeEvent('childDiv"+i+"')\">Remove</a>";

var ni = document.getElementById('otherimages');

ni.appendChild(newdiv);

i++;

} 





function removeEvent(divNum)

{

var d = document.getElementById('otherimages');

var olddiv = document.getElementById(divNum);

d.removeChild(olddiv);

i--;

} 







$(document).ready(function() {	

	var error = 0;

	$("#product_price").change(function() {



	var numeric = /^[0-9]+$/;

	var space =  /\s/g;

	var price_val = $("#product_price").val(); 

	if(space.test(price_val)) {

	$("#product_price_error").css("display","block");

	$("#product_price_error").html('There Should be no space');

	}

	else

	{

			if($("#product_price").val().match(numeric))

			{

		

			$("#product_price_error").css("display","none");

			 error = 0;

			}

			else

			{

				if(parseFloat(price_val) == price_val)

				{

				$("#product_price_error").css("display","none");

				 error = 0;

				}

				else

				{

				$("#product_price_error").css("display","block");

				$("#product_price_error").html('Value should be integer');

				error = 1;

				}

			}

	}

	});



	$("#product_quantity").change(function() {

	var numeric = /^[0-9]+$/;
	var space =  /\s/g;
	var quantity_val = $("#product_quantity").val(); 
	if(space.test(quantity_val)) {
	$("#product_quantity_error").css("display","block");
	$("#product_quantity_error").html('There Should be no space');
	}
	else
	{
	if($("#product_quantity").val().match(numeric))
	{
	$("#product_quantity_error").css("display","none");
	 error = 0;
	}
	else
	{
	$("#product_quantity_error").css("display","block");
	$("#product_quantity_error").html('Value should be integer');
	error = 1;
	}
	}

	});





{*	$("#create-account_form").submit(function() {

	if($("#product_quantity").val() == "" || $("#product_price").val() == "" || $("#product_name").val() == "" )

	{

	$("#error").css("display","block");

	$(".product_upload_info").css("display","none");

	return false;

	}

	else if(error == 1)

	{

	return false;

	}

	else

	{

	$("#error").css("display","none");

	}

	});
*}


	});		 



</script>

<script type="text/javascript">
	$('.fancybox').fancybox();	
	
	$('.delete_unactive_pro_image').live('click',function(e) {
		e.preventDefault();
		var id_image = $(this).attr('alt');
		var img_name = $(this).attr('img_name');
		var r=confirm("You want to delete image ?");
		if(r==true) {
			$.ajax({
				type: 'POST',
				url:	'../modules/marketplace/deleteunactiveproductimage.php',
				async: true,
				data: 'id_image=' + id_image + '&img_name=' + img_name,
				cache: false,
				success: function(data)
				{
					if(data==0) {
						alert("some error occurs");
					} else {
						alert("delete successfully");
						$(".unactiveimageinforow"+id_image).remove();
					}
				}
			});
		}
	});
	
	$('.delete_pro_image').live('click',function(e) {
		e.preventDefault();
		var id_image = $(this).attr('alt');
		var is_cover = $(this).attr('is_cover');
		var id_pro = $(this).attr('id_pro');
		var r=confirm("You want to delete image ?");
		if(r==true) {
			$.ajax({
				type: 'POST',
				url:	'../modules/marketplace/deleteproductimage.php',
				async: true,
				data: 'id_image=' + id_image + '&is_cover=' + is_cover + '&id_pro=' + id_pro,
				cache: false,
				success: function(data)
				{
					if(data==0) {
						alert("some error occurs");
					} else {
						alert("delete successfully");
						$(".imageinforow"+id_image).remove();
					}
				}
			});
		}
	});
	$('.covered').live('click',function(e) {
		e.preventDefault();
		var id_image = $(this).attr('alt');
		var is_cover = $(this).attr('is_cover');
		var id_pro = $(this).attr('id_pro');
		if(is_cover==0) {
			$.ajax({
				type: 'POST',
				url:	'../modules/marketplace/changecoverimage.php',
				async: true,
				data: 'id_image=' + id_image + '&is_cover=' + is_cover + '&id_pro=' + id_pro,
				cache: false,
				success: function(data)
				{
					if(data==0) {
						alert("some error occurs");
					} else {
						if(is_cover==0) {
							$('.covered').attr('src','../img/admin/forbbiden.gif');
							$('.covered').attr('is_cover','0')
							$('#changecoverimage'+id_image).attr('src','../img/admin/enabled.gif')
							$('#changecoverimage'+id_image).attr('is_cover','1');
						} else {
							
						}
					}
				}
			});
		}
	});
</script>

{/block}