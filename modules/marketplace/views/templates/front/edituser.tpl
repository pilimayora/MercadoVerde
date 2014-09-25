<script language="javascript" type="text/javascript" src="{$base_dir}modules/marketplace/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
	tinyMCE.init({

		mode : "specific_textareas",
		theme : "advanced",
		theme_advanced_buttons1 : "bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright,forecolor, justifyfull,bullist,numlist,undo,redo,link",
		theme_advanced_buttons2 : "unlink,fontselect,fontsizeselect",
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
		theme_advanced_buttons1 : "bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright,forecolor, justifyfull,bullist,numlist,undo,redo,link",
		theme_advanced_buttons2 : "unlink,fontselect,fontsizeselect",
		theme_advanced_buttons3 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		//theme_advanced_statusbar_location : "bottom",
		plugins : 'inlinepopups',
        theme_advanced_resizing : true,
		editor_selector : 'short_description'
		
});
</script>
<style type="text/css">
	
	.product_upload_info {
		float:left;
		width:100%;
		font-weight:bold;
		color:red;
	}
	/*#left_column {
		display:none !important;
	}
	#right_column {
		display:none !important;
	}
	#center_column {
		width:100% !important;
	}*/
</style>
<style>

	#product_image {
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
	
.add_one

{

font-size:{$add_size}px;

font-weight:bold;

color:{$add_color}!important;

width:150px!important;

margin-left:10px!important;

font-family:{$add_font_family};

}

#addproduct_fieldset {
    border: 1px solid;
    float: left;
    width: 100%;
}


.row-info {
    float: left;
    padding-left: 5%;
    padding-top: 10px;
    width: 95%;
}

.row-info-left {
    float: left;
    font-family: myraid pro;
    font-weight: bold;
    height: 32px;
    width: 29%;
}


.row-info-right {
    float: left;
    width: 68%;
}

.main_error {
	float:left;
	width:100%;
	margin-bottom:10px;
}
.main_error .warn {
    background: url("../../img/admin/icon-attention.png") no-repeat scroll 6px 6px #FFBABA;
    border: 1px solid #9E6014;
    border-radius: 3px 3px 3px 3px;
    color: #D8000C;
    font-size: 12px;
    font-weight: normal;
    line-height: 20px;
    margin: 0 0 10px;
    min-height: 28px;
    padding: 13px 5px 5px 40px
}
.main_error .warn1 {
    background: url("img/admin/icon-valid.png") no-repeat scroll 6px 6px #DFF2BF;
    border: 1px solid #4F8A10;
    border-radius: 3px 3px 3px 3px;
    color: #4F8A10;
    font-size: 12px;
    font-weight: normal;
    line-height: 20px;
    margin: 0 0 10px;
    min-height: 28px;
    padding: 13px 5px 5px 40px
}
#tree1 label{
	padding-left:2px;
	font-size:10px;
}

#tree1 ul{
	margin-left:13px;
	margin-top:3px;
}
</style>

<span id="error">{l s='Field Should not be Empty.' mod='marketplace'}</span>
<div class="main_error">
	{if $is_main_er==1}
		<div class="warn">
			{l s='Product name is required field.' mod='marketplace'}
		</div>
	{else if $is_main_er==2}
		<div class="warn">
			{l s='Product name must not have Invalid characters <>;=#{}' mod='marketplace'}
		</div>
	{else if $is_main_er==3}
		<div class="warn">
			{l s='Short description have not valid data.' mod='marketplace'}
		</div>
	{else if $is_main_er==4}
		<div class="warn">
			{l s='Product description have not valid data' mod='marketplace'}
		</div>
	{else if $is_main_er==5}
		<div class="warn">
			{l s='product price should be numeric' mod='marketplace'}
		</div>
	{else if $is_main_er==6}
		<div class="warn">
			{l s='product quantity should be greater than 0' mod='marketplace'}
		</div>
	{else if $is_main_er==7}
		<div class="warn">
			{l s='Please select atleast one category' mod='marketplace'}
		</div>	
	{/if}
</div>
{hook h='DisplayMpupdateproductheaderhook'}
<div id="addproduct_fieldset" style="width:100%;float:left;">

<form action="{$edit_pro_link}&edited=1&id={$id}" method="post"  enctype="multipart/form-data" accept-charset="UTF-8,ISO-8859-1,UTF-16" >

		
			<div class="row-info">
				<div class="row-info-left">{l s='Product Name :' mod='marketplace'}</div>
				<div class="row-info-right">
					<input type="text" id="product_name" name="product_name" value="{$pro_info['product_name']}" class="account_input" />
					<span id="product_name_error">{l s='Value should be Character ' mod='marketplace'}</span>
				</div>
			</div>

			
			<div class="row-info">
				<div class="row-info-left">
					{l s='Product Short Description :' mod='marketplace'}
				</div>
				<div class="row-info-right1">
					<textarea class="short_description" id="short_description" name="short_description" value="{$pro_info['description']}" style="width:300px;">{$pro_info['short_description']}</textarea></span>
					<span id="short_description_error">{l s='Value should be Character ' mod='marketplace'}
				</div>
			</div>
			
			
			<div class="row-info">
				<div class="row-info-left">
					{l s='Product Description :' mod='marketplace'}
				</div>
				<div class="row-info-right1">
					<textarea class="product_description" id="product_description" name="product_description" value="{$pro_info['description']}" style="width:300px;">{$pro_info['description']}</textarea></span>
					<span id="product_description_error">{l s='Value should be Character ' mod='marketplace'}
				</div>
			</div>


			<div class="row-info">
				<div class="row-info-left">{l s='Product Price :' mod='marketplace'}</div>
				<span><input type="text" id="product_price" name="product_price" value="{$pro_info['price']}"  class="account_input" /></span>
				<span id="product_price_error">{l s='Value should be Integer ' mod='marketplace'}</span>
			</div>


			<div class="row-info">
				<div class="row-info-left">
					{l s='Product Quantity :' mod='marketplace'}
				</div>
				<span><input type="text" id="product_quantity" name="product_quantity" value="{$pro_info['quantity']}"  class="account_input"  /></span>
				<span id="product_quantity_error">{l s='Value should be Integer ' mod='marketplace'}</span>
			</div> 


			<div class="row-info">
				<div class="row-info-left">
					{l s='Product Category :' mod='marketplace'}
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
					{l s='Upload Image :' mod='marketplace'}
				</div>
				<div class="row-info-right">
					<input type="file" id="product_image" name="product_image" value="" class="account_input"   size="chars" />
					<button id="fileSelect" name="product_image">Upload Image</button>
				</div>				
			</div>
			{hook h="DisplayMpupdateproductfooterhook"}
			<div class="row-info">
				<center>
					<input type="submit" id="SubmitCreate" name="SubmitCreate" class="button_large" value="{l s='Update' mod='marketplace'}" style="float:none;margin-bottom:35px;margin-top:30px;width:75px;" />
				</center>
			</div>
		
	</form>
</div>



<script language="javascript" type="text/javascript">

document.querySelector('#fileSelect').addEventListener('click', function(e) {
e.preventDefault();
  // Use the native click() of the file input.
  document.querySelector('#product_image').click();
}, false);

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





	$("#create-account_form").submit(function() {

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



	});		 



</script>