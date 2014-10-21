<link type="text/css" rel="stylesheet" href="{$modules_dir}customerpartner/customer_partner.css" />
<script language="javascript" type="text/javascript">



tinyMCE.init({



        theme : "advanced",



        mode : "textareas",



		theme_advanced_toolbar_location : "top",



        theme_advanced_toolbar_align : "left",



        theme_advanced_statusbar_location : "top",



        theme_advanced_resizing : true







});







</script>







<form action="edituser.php?vab=updatecustomer_partner&var={$unique_id}" method="post" enctype="multipart/form-data" autocomplete="off">







			



				<div id="main_edit">



				<div style="margin-left:15px;">



				



				<div class="edit_div">



				<label class="edit_label">Product Name:</label>



				<div class="margin-form">



					<input type="text" class="edit" id="edit_name" size="33" name="product_name" value="{$product_name}" /> <sup>*</sup>



				</div>



				</div>



			



				<div class="edit_div">



				<label class="edit_label">Product Description:</label>



				<div class="margin-form">



					<span><textarea class="tinymce" id="product_description" name="product_description" value="{$product_description}"  rows="3" cols="21" ></textarea></span>



				</div>



				</div>



				



				<div class="edit_div">	



				<label class="edit_label">Product Price: </label>



				<div class="margin-form">



					<input type="text" size="33" class="edit" id="edit_price" name="product_price" value="{$product_price}" /> <sup>*</sup>



				</div>



				</div>







				



				



				



				<div class="edit_div">	



				<label class="edit_label">Product Category:</label>



				<div class="margin-form">



					<select id="product_category" name="product_category"  id="edit_cat" class="edit">



					



					<span><option  value="2">Home</option></span>



						{foreach $arr as $arr1}



<span><option name ="main_category"  class="main_category" id="{$arr[1]}" value="{$arr1[1]}" {if $product_category == $arr1[1]}selected="selected"{/if} />{$arr1[0]}</option></span>



					{foreach $arr1[2] as $arr2}



><span><option  name ="sub_category"  class="sub_category" id="{$arr2['id_category']}" {if $product_category == $arr2['id_category']}selected="selected"{/if} value="{$arr2['id_category']}" >----{$arr2['name']}</option></span>	



						{/foreach}



						{/foreach}



						



					</select>



				</div>



				</div>



				



				



				



				<div class="edit_div">	



				<label class="edit_label">Product Quantity:</label>



				<div class="margin-form">



					<input type="text" size="33" class="edit" id="edit_quant" name="product_quantity" value="{$product_quantity}" /> <sup>*</sup>



				</div>



				</div>



				



				</div>



				



				



		







				<div class="clear">&nbsp;</div>



				<center>



					<input type="submit" value="Save" id="edit_save" name="editcustomer_partner" class="button" />



				</center><div class="clear">&nbsp;</div>



				<div class="small"><sup>*</sup>Required field</div>



				



				</div>



		</form>