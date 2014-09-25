<style>
{if $browser == 'notie'}
#product_image
{
  visibility: hidden;
  width: 0;
  height: 0;
}
{/if}
.fileSelect
{
  -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    /* background: -moz-linear-gradient(center top , rgba(255, 255, 255, 0.3) 50%, #FFCC00 50%, #FFCC00) repeat scroll 0 0 #FFCC00; */
	background: none repeat scroll 0 0 #FFCC00;
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
.fileSelect:hover:before {
  border-color: black;
}
.fileSelect:active:before {
  background: -webkit-linear-gradient(top, #e3e3e3, #f9f9f9);
}
.list_content li span a {
    color: #6C702F !important;
}
.row-info-left {

    color: {$edit_color};

    float: left;

    font-family: Arial;

    font-size: {$edit_size}px;

    font-weight: bold;

    height: 32px;

    width: 29%;

}
.row-info-right {

    color:{$propage_color};

    float: left;

    font-size:{$propage_size}px;

    width: 68%;

	font-family:{$propage_font_family};

}
.row_info {
	float:left;
	width:100%;
}

.add_one

{

font-size:{$add_size}px;

font-weight:bold;

color:{$add_color}!important;

width:150px!important;

margin-left:10px!important;

/*font-family:{$add_font_family};*/

}

#addproduct_fieldset

{

width:400px;

border:1px solid {$add_border_color};

}

.row-info-right1 {

    color:{$propage_color};

    float: left;

    font-size:{$propage_size}px;

   
    width: 68%;

	font-family:{$propage_font_family};

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

        theme_advanced_resizing : true

});



</script>

<style type="text/css">

	.product_upload_info {

		float:left;

		width:100%;

		font-weight:bold;

		color:green;

		font-size:12px;

	}
	
#add_img {
    color: #0000FF;
    float: left;
    font-family: times new roman;
    margin-bottom: 10px;
    margin-left: 0;
    margin-top: 10px;
    width: 100%;
}

#add_img:hover {
	text-decoration:underline;
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
    background: url("../../img/admin/icon-valid.png") no-repeat scroll 6px 6px #DFF2BF;
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
	font-size:12px;
}

#tree1 ul{
	margin-left:13px;
	margin-top:3px;
}
</style>



{if $login == 1}
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
{if $product_upload}

	{if $product_upload==1}
		<div class="main_error">
			<div class="warn1">
				{l s='Your product uploaded successfully' mod='marketplace'}
			</div>
		</div>

	{else if $product_upload==2}
		<div class="main_error">
			<div class="warn">{l s='There was some error occurs while uploading your product' mod='marketplace'}</div>
		</div>		
	{/if}
	
{/if}

<center><span id="error">{l s='Field Should not be Empty.' mod='marketplace'}</span></center>

{hook h='DisplayMpaddproductheaderhook'}
<div class="main_block">
	{hook h="DisplayMpmenuhook"}
<div class="account-detail" style="float:left;width:73%;border:1px solid;margin-left:10px;margin-bottom:20px;">

	<div style="float:left;margin-top:30px;width:600px;">
		<form action="{$new_link4}" method="post" id="create-account" class="std" enctype="multipart/form-data" accept-charset="UTF-8,ISO-8859-1,UTF-16" style="width:100%;">


			<div class="row-info">
			 <div class="row-info-left">

				<label class="add_one" for="product_name" style="margin-top:20px;display:inline;">{l s='Product Name :' mod='marketplace'}</label>
             </div>
			 <div class="row-info-right">
				<span><input type="text" id="product_name" name="product_name" value="" class="account_input" /></span>
             </div>
				<span id="product_name_error">{l s='Value should be Character ' mod='marketplace'}</span>

			</div>

            <div class="row-info">
			 <div class="row-info-left">

				<label class="add_one" for="short_description" style="margin-top:20px;display:inline;">{l s='Short Description :' mod='marketplace'}</label>
             </div>
			 <div class="row-info-right1">
				<span><textarea class="tinymce" id="short_description" name="short_description" value=""   rows="3" cols="2"></textarea></span>
             </div>
				<span id="short_description_error">{l s='Value should be Character ' mod='marketplace'}</span>

			</div>

			<div class="row-info">
               <div class="row-info-left">
				<label class="add_one" style="display:inline;" for="product_description">{l s='Product Description :' mod='marketplace'}</label>
               </div>
			   <div class="row-info-right1">
				<span><textarea class="tinymce" id="product_description" name="product_description" value=""   rows="3" cols="2"></textarea></span>
               </div>
				<span id="product_description_error">{l s='Value should be Character ' mod='marketplace'}</span>

			</div>

			<div class="row-info">
			  <div class="row-info-left">

				<label class="add_one" style="display:inline;" for="product_price">{l s='Product Price :' mod='marketplace'}</label>
              </div>
			  
			  <div class="row-info-right">
				<span><input type="text" id="product_price" name="product_price" value=""  class="account_input" /></span>
              </div>
				<span id="product_price_error">{l s='Value should be Integer ' mod='marketplace'}</span>

			</div>

			<div class="row-info">
               <div class="row-info-left">
				<label class="add_one" for="product_quantity">{l s='Product Quantity :' mod='marketplace'}</label>
               </div>
			    <div class="row-info-right">
				<span><input type="text" id="product_quantity" name="product_quantity" value=""  class="account_input"  /></span>
                </div>
				<span id="product_quantity_error">{l s='Value should be Integer ' mod='marketplace'}</span>

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
					<label class="add_one" for="product_image">{l s='Upload Image :' mod='marketplace'}</label>
                  </div>
				  
				 <div class="row-info-right1"> 
					<span>
						<input type="file" id="product_image" name="product_image" value="" class="account_input"   size="chars"  />
						{if $browser == 'notie'}
						<button class="fileSelect" name="product_image">Upload Image</button>
						{/if}
					</span>
				</div>
				 <div class="row-info-right1" style="margin-top:5px;"> 
					<a onclick="showOtherImage(); return false;">
						<div id="add_img">
							{l s='Add Other Image :' mod='marketplace'}
						</div>
					</a>
					<div id="otherimages" style="margin-left:0px;"> </div>
                 </div>
				</div>
				{hook h="DisplayMpaddproductfooterhook"}
			<div class="row-info">
				<center><input type="submit" id="SubmitProduct" name="SubmitCreate" class="button_large" value="{l s='Add Product' mod='marketplace'}" /></center>
			</div>
		</form>
	</div>
</div>

{else}

<div id="update_sucess" style="border:1px solid #CC0000;width:100%;height:40px;background-color:#FFBABA;">
	<span class="sucess_msg" style="color:#383838;font-weight:bold;float:left;margin-top:10px;margin-left:10px;">{l s='You are logged out.Please Login to add Product.' mod='marketplace'}</span>
</div>

{/if}

</div>




<script language="javascript" type="text/javascript">
{if $browser == 'notie'}
document.querySelector('.fileSelect').addEventListener('click', function(e) {
e.preventDefault();
  // Use the native click() of the file input.
  document.querySelector('#product_image').click();
}, false);
{/if}
	var i=2;

function showOtherImage() {

var newdiv = document.createElement('div');

newdiv.setAttribute("id","childDiv"+i);

newdiv.innerHTML = "<input type='file' id='images"+i+"' name='images[]'  style='width:85px;'/><a style='color:#0000FF;' href=\"javascript:;\" onclick=\"removeEvent('childDiv"+i+"')\">Remove</a>";

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