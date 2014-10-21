<style>
input{
	padding:20px;
}
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
    width: 24%;
}

.row-info-right {
    color: #404040;
    float: left;
    font-size: 15px;
    width: 76%;
}

.row-info-right input{
	padding:6px;
	width:25%;
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

</style>
{if $show_toolbar}
	{include file="toolbar.tpl" toolbar_btn=$toolbar_btn toolbar_scroll=$toolbar_scroll title=$title}
	<div class="leadin">{block name="leadin"}{/block}</div>
{/if}
{block name="override_tpl"}
	<fieldset>
       <legend>View Product</legend>
							<div class="row-info">	
								<div class="row-info-left">
									<label class="add_one" for="product_name" >{l s='Product Name :' mod='marketplace'}<sup>*</sup></label>
								</div>
								<div class="row-info-right">
									<input type="text" value="{$pro_info['product_name']}" disabled/>
									<span id="product_name_error">{l s='Value should be Character ' mod='marketplace'}</span>
								</div>
							</div>
							<div class="row-info">	
								<div class="row-info-left">
									<label class="add_one" for="product_description">{l s='Product Description :' mod='marketplace'}</label>
								</div>
								<div class="row-info-right">
									<textarea rows="6" cols="45" disabled>{$pro_info['description']}</textarea>
									<span id="product_description_error">
										{l s='Value should be Character ' mod='marketplace'}
									</span>
								</div>
							</div>
							<div class="row-info">	
								<div class="row-info-left">
									<label class="add_one" for="product_price">
										{l s='Product Price :' mod='marketplace'}<sup>*</sup></label>
								</div>
								<div class="row-info-right">
										<input type="text" name="product_price" value="{$pro_info['price']}" disabled/>
									<div id="product_price_error" class="product_error">
										{l s='Value should be Numeric' mod='marketplace'}
									</div>
								</div>
							</div>
							<div class="row-info">
								<div class="row-info-left">
									<label class="add_one" for="product_quantity">{l s='Product Quantity :' mod='marketplace'}<sup>*</sup></label>
								</div>
								<div class="row-info-right">
										<input type="text" value="{$pro_info['quantity']}" disabled/>
									<div id="product_quantity_error" class="product_error">
										{l s='Value should be Integer ' mod='marketplace'}
									</div>
								</div> 
							</div>
							{hook h="DisplayMpviewextradetailhook"}
							
							
							{if {$set}==0}
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
												<th>Image</th>	
											</tr>
											{foreach $unactive_image as $unactive_image1}
												<tr class="unactiveimageinforow{$unactive_image1['id']}">
													<td>
														<a class="fancybox" href="../modules/marketplace/img/product_img/{$unactive_image1['seller_product_image_id']}.jpg">
															<img title="15" width="45" height="45" alt="15" src="../modules/marketplace/img/product_img/{$unactive_image1['seller_product_image_id']}.jpg" />
														</a>
													</td>
												</tr>
											{/foreach}
										</table>
									</div>
								{/if}
							{/if}
			
							
	</fieldset>
{/block}

<script type="text/javascript">
	$('.fancybox').fancybox();
</script>