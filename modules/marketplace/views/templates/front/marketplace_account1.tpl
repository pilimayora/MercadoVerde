<style>
.list_content li span a {
	color:{$color} !important;
	font-size:{$font_size1}px;
	font-family:{$font_family2};
}

#loading { 
width: 100%; 
position: absolute;
}

{* #pagination
{
text-align:center;
margin-left:220px;
}

#pagination li{
list-style: none; 
float: left; 
margin-right: 16px; 
padding:5px; 
border:solid 1px #dddddd;
color:#0063DC;
}

#pagination li:hover
{ 
color:#FF0084; 
cursor: pointer; 
}
*}
.account-detail {
    border: 1px solid {$edit_border_color};
	background-color:{$edit_back_color};

}
.data-table thead th {

	background-color:{$heading_color};

	background-image:url({$modules_dir}marketplace/img/bkg_th.gif);
	background-position:0 100%;
	background-repeat: no-repeat;
	font-family:{$order_heading_family};
	font-size:{$order_heading_size}px;
}

.data-table td {
	padding:3px 8px;
	font-size:{$order_heading_size}px;
	font-family{$order_heading_family};
}

.data-table .odd {
  background-color:{$odd_row_color};
  background-position:initial initial;
  background-repeat:initial initial;
  font-size:{$order_heading_size}px;
  font-family{$order_heading_family};
}

.data-table .even {
  background-color:{$even_row_color};
  background-position:initial initial;
  background-repeat:initial initial;
  font-size:{$order_row_size}px;
  font-family:{$order_row_family};
}

.box-account .box-head h2 {
  background-position:0 0;
  background-repeat:no-repeat;
  color:{$recent_color};
  float:left;
  font-size:{$recent_size}px;
  font-weight:bold;
  margin:0;
  padding-left:21px;
  text-transform:uppercase;
  padding-bottom:0px;
}

h1 {

  font-size:{$main_heading_size}px;

  color:{$main_heading_color};

  font-family:{$main_heading_family};

}

.h {
	float:left;
	width:100%;
}
.product_list .h .td {
background-color: #766666;
	 background-attachment:scroll;

  background-color:{$pro_color};

  background-image:none;

  background-position:0 0;

  background-repeat:repeat repeat;

  border-bottom-color:#FBFBFB;

  border-bottom-style:solid;

  border-bottom-width:1px;

  border-right-color:#ECF7FB;

  border-right-style:solid;

  border-right-width:1px;

  color:white;

  font-weight:bold;

  padding:7px 9px 7px 10px;

  font-size:{$pro_head_font_size};

  font-family:{$pro_head_font_family};
  width:9.3%;
  float:left;
}
.color_two {
	float:left;
	width:100%;
	background-color:{$color5};
	background-repeat:repeat repeat;
}
.color_one {
	float:left;
	width:100%;
	 background-color:{$color6};
	 background-repeat:repeat repeat;
}
.color_one:hover {
	 background-color:#FFF1B5;
}
.color_two:hover {
	background-color:#FFF1B5;
}
.product_list .color_two .td {

  background-attachment:scroll;

   background-image:none;

  background-position:0 0;

  background-repeat:repeat repeat;

  border-right-color:#F5F5F5;

  border-right-style:solid;

  border-right-width:1px;

  color:#666666;

  padding:9px 9px 9px 10px;

  font-size:{$row_font_size};

  font-family:{$row_font_family};
	float:left;
	width:9.3%;
}

.product_list .color_one .td {

  background-attachment:scroll;

 

  background-image:none;

  background-position:0 0;

  background-repeat:repeat repeat;

  border-right-color:#F5F5F5;

  border-right-style:solid;

  border-right-width:1px;

  color:#666666;

  padding:9px 9px 9px 10px;

  font-size:{$row_font_size};

  font-family:{$row_font_family};
	float:left;
	width:9.3%;
}


.product_list tr.h td {

  background-attachment:scroll;

  background-color:{$pro_color};

  background-image:none;

  background-position:0 0;

  background-repeat:repeat repeat;

  border-bottom-color:#FBFBFB;

  border-bottom-style:solid;

  border-bottom-width:1px;

  border-right-color:#ECF7FB;

  border-right-style:solid;

  border-right-width:1px;

  color:white;

  font-weight:bold;

  padding:7px 9px 7px 10px;

  font-size:{$pro_head_font_size};

  font-family:{$pro_head_font_family};

}
.product_list tr.color_two td {

  background-attachment:scroll;

  background-color:{$color5};

  background-image:none;

  background-position:0 0;

  background-repeat:repeat repeat;

  border-right-color:#F5F5F5;

  border-right-style:solid;

  border-right-width:1px;

  color:#666666;

  padding:9px 9px 9px 10px;

  font-size:{$row_font_size};

  font-family:{$row_font_family};

}

.product_list tr.color_one td {

  background-attachment:scroll;

  background-color:{$color6};

  background-image:none;

  background-position:0 0;

  background-repeat:repeat repeat;

  border-right-color:#F5F5F5;

  border-right-style:solid;

  border-right-width:1px;

  color:#666666;

  padding:9px 9px 9px 10px;

  font-size:{$row_font_size};

  font-family:{$row_font_family};

}

.row-info-left {
    color: {$edit_color};
	font-size: {$edit_size}px;
	font-family:{$edit_font_family};
}

.row_info {
	float:left;
	width:100%;
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
{if $browser == 'notie'}
#update_shop_logo,#update_seller_logo {
	  visibility: hidden;
	  width: 0;
	  height: 0;
	}
{/if}



</style>


<style>
.pay
{
font-size:13px;
font-weight:bold;
color:black;
font-family:arial;
margin-right:30px;

}
#payment_mode
{

height:26px;
margin-right:30px;
}
#pay_form
{
padding:0px;
}
#payment_detail
{
margin-top:10px;
}


.row-info-right {
    color:{$propage_color};
    font-size:{$propage_size}px;
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
        theme_advanced_resizing : true,
		editor_selector : 'update_about_shop_detail',
});
</script>

<!-- Block myaccount module -->

<div class="main_block" >
	{hook h="DisplayMpmenuhook"}
	<div class="dashboard_content">
		{if $logic==1}
			<div class="dashboard">
					<div class="page-title">
						<h1>{l s='My Dashboard' mod='marketplace'}</h1>
					</div>
					<div class="left full">
						{hook h='DisplayMpdashboardtophook'}
					</div>
					<div class="left full">
						{hook h='DisplayMpdashboardbottomhook'}
					</div>
					<div class="box-account box-recent">
							<div class="box-head">
								<h2>{l s='Recent Orders' mod='marketplace'}</h2>
								<!--<a href="{$account_dashboard}&id_shop={$id_shop}&l=4">{l s='View All' mod='marketplace'}</a>-->
								<a href="{$link->getModuleLink('marketplace','marketplaceaccount',['shop'=>{$id_shop},'l'=>4])}">{l s='View All' mod='marketplace'}</a>
							</div>
							<table class="data-table" id="my-orders-table">

								<thead>

								<tr class="first last">

								<th>{l s='Order' mod='marketplace'} #</th>

								<th>{l s='Date' mod='marketplace'}</th>

								<th>{l s='Ship To' mod='marketplace'}</th>

								<th>

									<span class="nobr">{l s='Order Total' mod='marketplace'}</span>

								</th>

								<th>{l s='Status' mod='marketplace'}</th>

								

								</tr>

								</thead>

								

								<tbody>

								

								{assign var=i value=0}

								{while $i != $count}

								{if $i % 2 == 0}

								<tr class="even">

								{else}

								<tr class="odd">

								{/if}

								

								

								<td>{$dashboard[$i]['id_order']}</td>

								<td><span class="nobr">{$dashboard[$i]['date_add']}</span></td>

								<td>{$dashboard[$i]['name']}</td>

								<td><span class="price">{$order_currency[$i]}{$dashboard[$i]['total_price']}</span></td>

								<td><em>{$dashboard[$i]['order_status']}</em></td>

								

								</tr>

								{assign var=i value=$i+1}

								{/while}

								

								

								</tbody>

							</table>

				</div>			
				
				<div class="box-account box-recent">
					<div class="box-head">
						<h2>{l s='Orders Graph' mod='marketplace'}</h2>
					</div>
					<div class="box-head" style="padding-bottom:10px;">
						<div class="label">
							{l s='From:' mod='marketplace'}
						</div>
						<div class="input_type">
							<input id="graph_from" class="datepicker" type="text" style="text-align: center" value="{$from_date}" name="graph_from">
						</div>
						<div class="label">
							{l s='To:' mod='marketplace'}
						</div>
						<div class="input_type">
							<input id="graph_to" class="datepicker1" type="text" style="text-align: center" value="{$to_date}" name="graph_to">
						</div>
					</div>
					<div id="chart_div" style="width:100%; height: 500px;overflow:hidden;"></div>
					<script type="text/javascript" src="https://www.google.com/jsapi"></script>
					<script type="text/javascript">
						var order = '{l s='order' js=1}';
						var order_value = '{l s='value' js=1}';
					</script>
					<script type="text/javascript">
						google.load("visualization", "1", {
										  packages:["corechart"]
									});
						
						google.setOnLoadCallback(drawChart);  
						function drawChart() {
							
							{assign var=i value={$loop_exe}}
							var data = google.visualization.arrayToDataTable([
							['date_add', order, order_value],
							{while $i>0}
							{if $i>1}
								['{$newdate[$i]}',{$count_order_detail[$i]},{$product_price_detail[$i]}],
							{else}
								['{$newdate[$i]}',{$count_order_detail[$i]},{$product_price_detail[$i]}],
							{/if}
							{assign var=i value=$i-1}
							{/while}
							]);

							var options = {
							  title: 'Premium income',

							  pointSize:3,
							  vAxis: {
									minValue: 1
									}
							};
							
							var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
							chart.draw(data, options);
						}
					</script>
				</div>
			</div>
			<script type="text/javascript">
				$('.datepicker').datepicker({
					dateFormat: 'yy-mm-dd',
					defaultDate: -30
				});
				$('.datepicker1').datepicker({
					dateFormat: 'yy-mm-dd'
				});
				$('#graph_to').change(function(e) {
					 var from_date = $('#graph_from').val();
					var to_date = $(this).val();
					document.location.href="{$base_dir}index.php?fc=module&module=marketplace&controller=marketplaceaccount&shop=1&l=1&from_date="+from_date+"&to_date="+to_date;
					//document.location.href="{$account_dashboard}&l=1&from_date="+from_date+"&to_date="+to_date;
					
				});
			</script>
		</div>

		{else if $logic==2}

			<div class="dashboard_profile">

				<div class="page-heading">

					<h1>{l s='My PROFILE' mod='marketplace'}</h1>

				</div>

				<div class="profile_content">

					<div class="profile_content_heading">

						{if $edit==0}

							<div class="heading_name">{l s='Account information' mod='marketplace'}</div>

							<div class="heading_option"><a href="{$edit_profile}&l=2&edit-profile" title="View Profile">{l s='Edit' mod='marketplace'}</a></div>

						{else if $edit==1}

							<div class="heading_name">{l s='Edit Account Information' mod='marketplace'}</div>

						{*	<div class="heading_option"><a href="{$account_dashboard}&l=2" title="View Profile">{l s='Back' mod='marketplace'}</a></div>*}

						{/if}

					</div>

					{if $edit==0}

						<div class="account-detail">

							{if $update}

								{if $update==1}

								

									<div class="row-info">

										<div class="update_error">

											{l s='Profile information successfully updated.' mod='marketplace'}

										</div>

									</div>

								{else $update==0}
									<div class="row-info">

										<div class="update_error">

											{l s='some error occurs while updating your profile.' mod='marketplace'}

										</div>

									</div>

								{/if}

							{/if}

							<div class="row-info">

					

								<div class="row-info-left">{l s='Seller Name' mod='marketplace'}</div>

								<div class="row-info-right">{$marketplace_seller_info['seller_name']}</div>

							</div>

							<div class="row-info">

								<div class="row-info-left">{l s='Shop name' mod='marketplace'}</div>

								<div class="row-info-right">{$marketplace_seller_info['shop_name']}</div>

							</div>

							<div class="row-info">

								<div class="row-info-left">{l s='Business email' mod='marketplace'}</div>

								<div class="row-info-right">{$marketplace_seller_info['business_email']}</div>

							</div>

							<div class="row-info">

								<div class="row-info-left">{l s='Phone' mod='marketplace'}</div>

								<div class="row-info-right">{$marketplace_seller_info['phone']}</div>

							</div>

							<div class="row-info">

								<div class="row-info-left">{l s='Fax' mod='marketplace'}</div>

								<div class="row-info-right">{$marketplace_seller_info['fax']}</div>

							</div>

							<div class="row-info">

								<div class="row-info-left">{l s='Facebook Id' mod='marketplace'}</div>

								<div class="row-info-right">

									{if $marketplace_seller_info['facebook_id']==''}

										{l s='Not found' mod='marketplace'}

									{else}

										{$marketplace_seller_info['facebook_id']}

									{/if}

								</div>

							</div>

							<div class="row-info">

								<div class="row-info-left">{l s='Twitter Id' mod='marketplace'}</div>

								

								<div class="row-info-right">

									{if $marketplace_seller_info['twitter_id']==''}

										{l s='Not found' mod='marketplace'}

									{else}

										{$marketplace_seller_info['twitter_id']}

									{/if}

								</div>

							</div>

							<div class="row-info">

								<div class="row-info-left">{l s='Address' mod='marketplace'}</div>

								<div class="row-info-right">{$marketplace_seller_info['address']}</div>

							</div>

							<div class="row-info">

								<div class="row-info-left">{l s='About shop' mod='marketplace'}</div>

								<div class="row-info-right">

									{if $market_place_shop['about_us']==''}

										{l s='Please write some information about your shop' mod='marketplace'}

									{else}

										{$market_place_shop['about_us']}

									{/if}

								</div>

							</div>

							<div class="row-info">

								<div class="row-info-left">{l s='Shop Logo' mod='marketplace'}</div>

								<div class="row-info-right"><img src='{$logo_path}' width="40" height="40"  alt={$marketplace_seller_info['shop_name']}></div>
								
							</div>
							
							{hook h="DisplayMpshopviewfooterhook"}

						</div>

					{else if $edit==1}

						<form action="{$editprofile}" method="post"   enctype="multipart/form-data" accept-charset="UTF-8,ISO-8859-1,UTF-16" onsubmit="return validateForm();">

							<input type="hidden" value="{$id_shop}" name="update_id_shop" />

							<div class="account-detail">

								<div class="row-info">

									<div class="update_error">
                                      {if $shop_img_size_error == 1}
										{l s='Shop logo image must be of 200px x 200px.' mod='marketplace'}
									  {/if}
									  {if $seller_img_size_error==1}
										{l s='Seller image must be of 200px x 200px.' mod='marketplace'}
									  {/if}
									</div>

								</div>

								<div class="row-info">

									<div class="row-info-left">{l s='Seller Name' mod='marketplace'}<sup>*</sup></div>

									<div class="row-info-right">
									<input class="required" type="text" value="{$marketplace_seller_info['seller_name']}" name="update_seller_name" id="update_seller_name"/>
								    <span style="margin-left:20px;">
								     <input class="required" type="file" name="update_seller_logo" id="update_seller_logo"/>
								    {if $browser == 'notie'}
							         <button id="fileSelect1" name="update_seller_logo">{l s='Upload Seller Pic' mod='marketplace'}</button>
								    <div class="info_description" style="text-align:center;">{l s='image Size Must Be 200*200' mod='marketplace'}</div>
									{/if}
								</span>
									</div>

								</div>

								<div class="row-info">

									<div class="row-info-left">{l s='Shop name' mod='marketplace'}<sup>*</sup></div>

									<div class="row-info-right"><input class="required" type="text" value="{$marketplace_seller_info['shop_name']}" name="update_shop_name" id="update_shop_name"/></div>

								</div>

								<div class="row-info">

									<div class="row-info-left">{l s='Business email' mod='marketplace'}<sup>*</sup></div>

									<div class="row-info-right"><input class="required" type="text" value="{$marketplace_seller_info['business_email']}" name="update_business_email" id="update_business_email"/></div>

								</div>

								<div class="row-info">

									<div class="row-info-left">{l s='Phone' mod='marketplace'}<sup>*</sup></div>

									<div class="row-info-right"><input class="required" type="text" value="{$marketplace_seller_info['phone']}" name="update_phone" id="update_phone"/></div>

								</div>

								<div class="row-info">

									<div class="row-info-left">{l s='Fax' mod='marketplace'}</div>

									<div class="row-info-right"><input class="required" type="text" value="{$marketplace_seller_info['fax']}" name="update_fax" id="update_fax"/></div>

								</div>

								<div class="row-info">

									<div class="row-info-left">{l s='Facebook Id' mod='marketplace'}</div>

									<div class="row-info-right"><input class="required" type="text" value="{$marketplace_seller_info['facebook_id']}" name="update_facbook_id" id="update_facbook_id"/></div>

								</div>

								<div class="row-info">

									<div class="row-info-left">{l s='Twitter Id' mod='marketplace'}</div>

									<div class="row-info-right"><input class="required" type="text" value="{$marketplace_seller_info['twitter_id']}" name="update_twitter_id" id="update_twitter_id"/></div>

								</div>

								<div class="row-info">

									<div class="row-info-left">{l s='address' mod='marketplace'}</div>

									<div class="row-info-right1">

										<textarea class="required"  name="update_address" id="update_address" style="width:415px;height:103px;padding:10px;">{$marketplace_address}</textarea>

									</div>

								</div>

								<div class="row-info" style="margin-bottom: 24px;">

									<div class="row-info-left">{l s='About shop' mod='marketplace'}</div>

									<div class="row-info-right1">

										<textarea name="update_about_shop" id="update_about_shop" class="update_about_shop_detail">

											{$market_place_shop['about_us']}

										</textarea>

									</div>

								</div>

								<div class="row-info">

									<div class="row-info-left">{l s='Shop Logo' mod='marketplace'}</div>

									<div class="row-info-right">
									<input class="required" type="file" name="update_shop_logo" id="update_shop_logo"/>
						            {if $browser == 'notie'}
							          <button id="fileSelect" name="update_shop_logo">{l s='Upload Image' mod='marketplace'}</button>
									  <div class="info_description">{l s='Logo Size Must Be 200*200' mod='marketplace'}</div>
								    {/if}
									</div>



								</div>
								{hook h="DisplayMpshopaddfooterhook"}
								

								<div class="row-info" />

									<div class="submit-button"><input type="submit" value="{l s='submit' mod='marketplace'}" name="update_profile" id="update_profile"></div>

								</div>

							</div>							

						</form>

						

						<script type="text/javascript">
                          
                         {if $browser == 'notie'}
							document.querySelector('#fileSelect').addEventListener('click', function(e) {
								e.preventDefault();
								  // Use the native click() of the file input.
								  document.querySelector('#update_shop_logo').click();
							}, false);
							
							document.querySelector('#fileSelect1').addEventListener('click', function(e) {
								e.preventDefault();
								  // Use the native click() of the file input.
								  document.querySelector('#update_seller_logo').click();
							}, false);

                        {/if}

							function validateForm() {
								var seller_name_req = '{l s='Seller Name is required.' js=1}';
								var shop_name_req = '{l s='Shop name is required.' js=1}';
								var business_email_req = '{l s='Business Email  is required.' js=1}';
								var business_email_formate = '{l s='Business Email should have the format abc@example.com' js=1}';
								var phone_num_req = '{l s='Phone is a required field.' js=1}';
								var space_not_allow = '{l s='Space is not allowed.' js=1}';
								var phone_num_char = '{l s='Phone number must have 10 characters.' js=1}';
								var phone_num_nume = '{l s='Phone number must be numeric.' js=1}';
								var shop_logo_format = '{l s='Shop Logo must have jpg, png, gif' js=1}';
								
								
								var numeric = /^[0-9]+$/;

								var alpha = /^[a-zA-Z]*$/;

								var space =  /\s/g;

								var email_check = /^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;

								

								var seller_name = $('#update_seller_name').val();

								var shop_name = $('#update_shop_name').val();

								var business_email = $('#update_business_email').val();

								var phone = $('#update_phone').val();

								var fax = $('#update_fax').val();

								var shop_logo = $('#update_shop_logo').val();

								if(seller_name=='') {

									$('.update_error').html(seller_name_req);

									return false;

								} else {

									$('.update_error').html('');

								}

								

								if(shop_name=='') {

									$('.update_error').html(shop_name_req);

									return false;

								} else {

									$('.update_error').html('');

								}

								

								if(business_email=='') {

									$('.update_error').html(business_email_req);

									return false;

								} else {

									if(!email_check.test(business_email)){

										$('.update_error').html(business_email_formate);

										return false;

									} else {

										$('.update_error').html('');

									}

								}

								if(phone=='') {

									$('.update_error').html(phone_num_req);

									return false;

								} else {

									if(space.test(phone)) {

										$('.update_error').html(space_not_allow);

										return false;

									} else {

										if(phone.match(numeric)) {

											if(phone.length==10) {

												$('.update_error').html('');

											} else  {

												$('.update_error').html(phone_num_char);

												return false;

											}

										} else {

											$('.update_error').html(phone_num_nume);

											return false;

										}

									}

								}

								

								
								if(shop_logo!='') {

									var logo_extention = shop_logo.substring(shop_logo.lastIndexOf('.') + 1).toLowerCase();

									if(logo_extention=='gif' || logo_extention=='png' || logo_extention=='jpg') {

										$('.update_error').html('');

									} else {

										$('.update_error').html(shop_logo_format);

										return false;

									}

								}															

							}

						</script>

					{/if}

				</div>

			</div>

		{else if $logic==3}
			{if $is_deleted == 1}
				<div id="update_sucess">
					<img style="margin-left:20px;margin-top:10px;" src="{$modules_dir}marketplace/img/ok2.png" /> 
					<span class="sucess_msg">{l s='Deleted Successful' mod='marketplace'}</span>
				</div>
			{else if $is_edited == 1}
				<div id="update_sucess">
					<img style="margin-left:20px;margin-top:10px;" src="{$modules_dir}marketplace/img/ok2.png" /> 
					<span class="sucess_msg">{l s='Updated Successful' mod='marketplace'}</span>
				</div>
			{/if}
			<!-- sorting code start -->
			{if $product_lists!=0}
				<div id="refine_search">
					<div class="sortPagiBar clearfix">
						<form id="productsSortForm" action="{$sorting_link}&p={$page_no}">
							<p class="select">
								<label for="selectPrductSort">{l s='Sort by' mod='marketplace'}</label>
								<select id="selectPrductSort" class="selectSortProduct">
									<option value="position:asc" selected="selected">--</option>
									<option value="price:asc">{l s='Price: lowest first' mod='marketplace'}</option>
									<option value="price:desc">{l s='Price: highest first' mod='marketplace'}</option>
									<option value="name:asc">{l s='Product Name: A to Z' mod='marketplace'}</option>
									<option value="name:desc">{l s='Product Name: Z to A' mod='marketplace'}</option>
									<option value="date_add:asc">{l s='Creation Date: asc' mod='marketplace'}</option>
									<option value="date_add:desc">{l s='Creation Date: desc' mod='marketplace'}</option>
								</select>
							</p>
						</form>

						<script type="text/javascript">
							var min_item = 'Please select at least one product';
							var max_item = "You cannot add more than 3 product(s) to the product comparison";
							$(document).ready(function(){
							$('.selectSortProduct').change(function()
								{
								
									var requestSortProducts = '{$sorting_link}';
									var splitData = $(this).val().split(':');
									
									document.location.href = requestSortProducts + ((requestSortProducts.indexOf('?') < 0) ? '?' : '&') + 'orderby=' + splitData[0] + '&orderway=' + splitData[1];
									
								});
							});
						</script>
					</div>
				</div>
			{/if}
			<!-- sorting code end -->
				<div class="product_list">
					<div class="left full">
						{hook h="DisplayMpproductdetailheaderhook"}
					</div>
					<div id="loading" ></div>
					<div class="table" style="width:100%;float:left;">
						<div class="h">
							<div class="td">
								{l s='Name' mod='marketplace'}

							</div>
							<div class="td" style="width:25%;">
								{l s='Description' mod='marketplace'}
							</div>
							<div class="td">
								{l s='Price' mod='marketplace'}
							</div>
							<div class="td">
								{l s='Quantity' mod='marketplace'}
							</div>
							<div class="td">
								{l s='Approved' mod='marketplace'}
							</div>
							<div class="td">
								{l s='Action' mod='marketplace'}
							</div>
							<div class="td">
								{l s='Image Edit' mod='marketplace'}
							</div>
						</div>
					<div id="content">
					{if $product_lists!=0}
						{assign var=i value=1} 
						{foreach $product_lists as $product}
							{if $i % 2 == 0}
								<div class="color_one"  name="dash">
							{else}
								<div class="color_two"  name="dash">
							{/if}
									<a href="{$product_details_link}&id={$product['id']}">
										<div class="td">
											{$product['product_name']}
										</div>
									</a>
									<a href="{$product_details_link}&id={$product['id']}">
										<div class="td" style="width:25%;">
											{$product['description']|mb_substr:0:30}
										</div>
									</a>
									<a href="{$product_details_link}&id={$product['id']}">
										<div class="td">
											{$product['price']}
										</div>
									</a>
									<a href="{$product_details_link}&id={$product['id']}">
										<div class="td">
											{$product['quantity']}
										</div>
									</a>
									{if $product['active'] == 0}
										<a href="{$product_details_link}&id={$product['id']}">
											<div class="td">
												{l s='Not Approved' mod='marketplace'}
											</div>
										</a>
									{else}
										<a href="{$product_details_link}&id={$product['id']}">
											<div class="td">
												{l s='Approved' mod='marketplace'}
											</div>
										</a>
									{/if}
									<div class="td">
										<img id="{$product['id']}" class="edit_img" src="{$img_ps_dir}admin/edit.gif"/>
										<img id="{$product['id']}" class="delete_img" src="{$img_ps_dir}admin/delete.gif"/>
									</div>
									<div class="td" style="text-align:center">
										<a href="" class="edit_seq"  alt="1"  product-id="{$product['id']}" id="">
											<img class="img_detail" alt="Details" id="edit_seq{$product['id']}" src="{$img_ps_dir}admin/more.png">
										</a>
										<input type="hidden" id="urlimageedit" value="{$imageediturl}"/>
									</div>
							{if $i % 2 == 0}
								</div>
							{else}
								</div>
							{/if}
								<div  class="row_info">
									<div id="content{$product['id']}" class="content_seq">
									</div>
								</div>
							{assign var=i value=$i+1}
						{/foreach}
						{* Pagination Code Start*}
						{if isset($no_follow) AND $no_follow}
							{assign var='no_follow_text' value='rel="nofollow"'}
						{else}
							{assign var='no_follow_text' value=''}
						{/if}
						{if isset($p) AND $p}
							{if isset($smarty.get.id_category) && $smarty.get.id_category && isset($category)}
								{if !isset($current_url)}
									{assign var='requestPage' value=$link->getPaginationLink('category', $category, false, false, true, false)}
								{else}
									{assign var='requestPage' value=$current_url}
								{/if}
									{assign var='requestNb' value=$link->getPaginationLink('category', $category, true, false, false, true)}
								{elseif isset($smarty.get.id_manufacturer) && $smarty.get.id_manufacturer && isset($manufacturer)}
									{assign var='requestPage' value=$link->getPaginationLink('manufacturer', $manufacturer, false, false, true, false)}
									{assign var='requestNb' value=$link->getPaginationLink('manufacturer', $manufacturer, true, false, false, true)}
								{elseif isset($smarty.get.id_supplier) && $smarty.get.id_supplier && isset($supplier)}
									{assign var='requestPage' value=$link->getPaginationLink('supplier', $supplier, false, false, true, false)}
									{assign var='requestNb' value=$link->getPaginationLink('supplier', $supplier, true, false, false, true)}
								{else}
									{assign var='requestPage' value=$pagination_link}
									{assign var='requestNb' value=$pagination_link}
								{/if}
						<!-- Pagination -->
								<div id="pagination{if isset($paginationId)}_{$paginationId}{/if}" class="pagination">
								{if $start!=$stop}
									<ul class="pagination">
										{if $p != 1}
							
										{assign var='p_previous' value=$p-1}
											<li id="pagination_previous{if isset($paginationId)}_{$paginationId}{/if}" class="pagination_previous"><a {$no_follow_text} href="{$link->goPage($requestPage, $p_previous)}">&laquo;&nbsp;{l s='Previous'}</a></li>
										{else}
											<li id="pagination_previous{if isset($paginationId)}_{$paginationId}{/if}" class="disabled pagination_previous"><span>&laquo;&nbsp;{l s='Previous'}</span></li>
										{/if}
										{if $start==3}
							
											<li><a {$no_follow_text}  href="{$link->goPage($requestPage, 1)}">1</a></li>
											<li><a {$no_follow_text}  href="{$link->goPage($requestPage, 2)}">2</a></li>
										{/if}
										{if $start==2}
											<li><a {$no_follow_text}  href="{$link->goPage($requestPage, 1)}">1</a></li>
										{/if}
										{if $start>3}
											<li><a {$no_follow_text}  href="{$link->goPage($requestPage, 1)}">1</a></li>
											<li class="truncate">...</li>
										{/if}
										{section name=pagination start=$start loop=$stop+1 step=1}
											{if $p == $smarty.section.pagination.index}
												<li class="current"><span>{$p|escape:'htmlall':'UTF-8'}</span></li>
											{else}
												<li><a {$no_follow_text} href="{$link->goPage($requestPage, $smarty.section.pagination.index)}">{$smarty.section.pagination.index|escape:'htmlall':'UTF-8'}</a></li>
											{/if}
										{/section}
										{if $pages_nb>$stop+2}
											<li class="truncate">...</li>
											<li><a href="{$link->goPage($requestPage, $pages_nb)}">{$pages_nb|intval}</a></li>
										{/if}
										{if $pages_nb==$stop+1}
											<li><a href="{$link->goPage($requestPage, $pages_nb)}">{$pages_nb|intval}</a></li>
										{/if}
										{if $pages_nb==$stop+2}
											<li><a href="{$link->goPage($requestPage, $pages_nb-1)}">{$pages_nb-1|intval}</a></li>
											<li><a href="{$link->goPage($requestPage, $pages_nb)}">{$pages_nb|intval}</a></li>
										{/if}
										{if $pages_nb > 1 AND $p != $pages_nb}
											{assign var='p_next' value=$p+1}
												<li id="pagination_next{if isset($paginationId)}_{$paginationId}{/if}" class="pagination_next"><a {$no_follow_text} href="{$link->goPage($requestPage, $p_next)}">{l s='Next'}&nbsp;&raquo;</a></li>
											{else}
												<li id="pagination_next{if isset($paginationId)}_{$paginationId}{/if}" class="disabled pagination_next"><span>{l s='Next'}&nbsp;&raquo;</span></li>
											{/if}
										</ul>
									{/if}
									{if $nb_products > $products_per_page}
										<form action="{if !is_array($requestNb)}{$requestNb}{else}{$requestNb.requestUrl}{/if}" method="get" class="pagination">
											<p>
												{if isset($search_query) AND $search_query}<input type="hidden" name="search_query" value="{$search_query|escape:'htmlall':'UTF-8'}" />{/if}
												{if isset($tag) AND $tag AND !is_array($tag)}<input type="hidden" name="tag" value="{$tag|escape:'htmlall':'UTF-8'}" />{/if}
												<input type="submit" class="button_mini" value="{l s='OK'}" />
												<label for="nb_item">{l s='items:'}</label>
												<select name="n" id="nb_item">
													{assign var="lastnValue" value="0"}
													{foreach from=$nArray item=nValue}
														{if $lastnValue <= $nb_products}
															<option value="{$nValue|escape:'htmlall':'UTF-8'}" {if $n == $nValue}selected="selected"{/if}>{$nValue|escape:'htmlall':'UTF-8'}</option>
														{/if}
														{assign var="lastnValue" value=$nValue}
													{/foreach}
												</select>
												{if is_array($requestNb)}
													{foreach from=$requestNb item=requestValue key=requestKey}
														{if $requestKey != 'requestUrl'}
															<input type="hidden" name="{$requestKey|escape:'htmlall':'UTF-8'}" value="{$requestValue|escape:'htmlall':'UTF-8'}" />
														{/if}
													{/foreach}
												{/if}
											</p>
										</form>
									{/if}
								</div>
						
								{* Pagination code end *}
							{/if}
						{else}
							<div class="color_one"  name="dash" style="text-align:center;">
								{l s='Oops no product uploaded yet' mod='marketplace'}
							</div>
						{/if}
					</div>
					
					
					<div class="left full">
						{hook h="DisplayMpproductdetailfooterhook"}
					</div>
		<input type="hidden" id="moduledir" value="{$moduledir}" />		
		<script type="text/javascript">
		$(document).ready(function()
		{
				$(".edit_seq").live('click',function(e) {
				e.preventDefault();
				var is_alt = $(this).attr("alt");
				var error_msg = '{l s='Space is not allowed.' js=1}';
				var id_product = $(this).attr("product-id");
				$(".edit_seq").attr("alt","1");
				$(".content_seq").hide();
				$(".content_seq").html("");
				$(".img_detail").attr('src','{$img_ps_dir}admin/more.png');
				if(is_alt==1) {
					$("#edit_seq"+id_product).attr('src','{$img_ps_dir}admin/less.png');
					$(this).attr("alt","0");
					$("#content"+id_product).show();
					$.ajax({
					type: 	'POST',
					url:	'{$modules_dir}marketplace/productimageedit.php',
					async: 	true,
					data: 	'id_product=' + id_product +'&id_lang='+{$id_lang},
					cache: 	false,
					success: function(data)
					{
						if(data!=0) {
							$('#content'+id_product).html(data);
						}
						else {
							alert(error_msg);

						}
					}
				});
					
				} else {
					$(this).attr("alt","1");
					$("#content"+id_product).hide();
					$("#content"+id_product).html("");
				}
			});
			
			$('.delete_pro_image').live('click',function(e) {
				e.preventDefault();
				var id_image = $(this).attr('alt');
				var confirm_delete_msg = '{l s='Do you want to delete the photo?' js=1}';
				var error_msg = '{l s='An error occurred.' js=1}';
				var delete_msg = '{l s='Deleted.' js=1}';
				var is_cover = $(this).attr('is_cover');
				var id_pro = $(this).attr('id_pro');
				var r=confirm(confirm_delete_msg);
				
				if(r==true) {
					$.ajax({
						type: 'POST',
						url:	'{$modules_dir}marketplace/deleteproductimage.php',
						async: true,
						data: 'id_image=' + id_image + '&is_cover=' + is_cover + '&id_pro=' + id_pro,
						cache: false,
						success: function(data)
						{
							if(data==0) {
								alert(error_msg);

							} else {
								alert(delete_msg);
								$(".unactiveimageinforow"+id_image).remove();
							}
						}
					});
				
				}
			});
			$('.delete_unactive_pro_image').live('click',function(e) {
				e.preventDefault();
				var id_image = $(this).attr('alt');
				var confirm_delete_msg = '{l s='Do you want to delete the photo?' js=1}';
				var error_msg = '{l s='An error occurred.' js=1}';
				var delete_msg = '{l s='Deleted.' js=1}';
				var img_name = $(this).attr('img_name');
				var r=confirm(confirm_delete_msg);
				
				if(r==true) {
					$.ajax({
						type: 'POST',
						url:	'{$modules_dir}marketplace/deleteunactiveproductimage.php',
						async: true,
						data: 'id_image=' + id_image + '&img_name=' + img_name,
						cache: false,
						success: function(data)
						{
							if(data==0) {
								alert(error_msg);

							} else {
								alert(delete_msg);
								$(".unactiveimageinforow"+id_image).remove();
							}
						}
					});
				}
				
			});
			$('.covered').live('click',function(e) {
				e.preventDefault();
				var id_image = $(this).attr('alt');
				var error_msg = '{l s='An error occurred.' js=1}';
				var is_cover = $(this).attr('is_cover');
				var id_pro = $(this).attr('id_pro');
				if(is_cover==0) {
				
					$.ajax({
						type: 'POST',
						url:	'{$modules_dir}marketplace/changecoverimage.php',
						async: true,
						data: 'id_image=' + id_image + '&is_cover=' + is_cover + '&id_pro=' + id_pro,
						cache: false,
						success: function(data)
						{
							if(data==0) {
								alert(error_msg);

							} else {
								if(is_cover==0) {
									$('.covered').attr('src','{$img_ps_dir}admin/forbbiden.gif');
									$('.covered').attr('is_cover','0')
									$('#changecoverimage'+id_image).attr('src','{$img_ps_dir}admin/enabled.gif')
									$('#changecoverimage'+id_image).attr('is_cover','1');
								} else {
									
								}
							}
						}
					});
				}
	
			});
			});
		</script>

		{else if $logic==4}

			<div class="dashboard">

				<div class="box-account box-recent">

					<div class="box-head">

						<h2>{l s='Recent Orders' mod='marketplace'}</h2>


					</div>

							

					<table class="data-table" id="my-orders-table">

						<thead>

							<tr class="first last">

								<th>{l s='Order #' mod='marketplace'}</th>


								<th>{l s='Date' mod='marketplace'}</th>


								<th>{l s='Ship To' mod='marketplace'}</th>


								{*<th>

								<span class="nobr">{l s='Order Total' mod='marketplace'}</span>

								</th>*}

								<th>{l s='Status' mod='marketplace'}</th>


								<th>{l s='Payment Mode' mod='marketplace'}</th>

								

							</tr>

						</thead>

								

						<tbody>
							<input type="hidden" id="id_shop_order" name="id_shop_order" value="{$id_shop}" />
							<input type="hidden" id="order_link" name="order_link" value="{$order_view_link}" />
							
							{assign var=i value=0}
							{while $i != $count}
									
								{if $i % 2 == 0}

									<tr class="even order_tr" is_id_order="{$dashboard[$i]['id_order']}" is_id_order_detail="{$dashboard[$i]['id_order_detail']}">
								{else}

									<tr class="odd order_tr" is_id_order="{$dashboard[$i]['id_order']}" is_id_order_detail="{$dashboard[$i]['id_order_detail']}">
								{/if}
									
									
										<td>{$dashboard[$i]['id_order']}</td>

										<td><span class="nobr">{$dashboard[$i]['date_add']}</span></td>

										<td>{$order_by_cus[$i]['firstname']}</td>

										{*<td><span class="price">{$order_currency[$i]}{$dashboard[$i]['total_price']*$dashboard[$i]['qty']}</span></td>*}

										<td><em>{$dashboard[$i]['order_status']}</em></td>
										<td><em>{$dashboard[$i]['payment_mode']}</em></td>
										{*<td><em>{$dashboard[$i]['ordered_product_name']}</em></td>
										<td><em>{$dashboard[$i]['qty']}</em></td>*}
										
										

									</tr>

							{assign var=i value=$i+1}
							{/while}

						</tbody>

					</table>

				</div>			

			</div>
			
			
			<div class="dashboard">
			
				<div class="box-account box-recent">
						<div class="box-head">
						<h2>{l s='Customer Feedback' mod='marketplace'}</h2>
						</div>
						
						
						{assign var=i value=0}
						{while $i != $count_msg}
						<div id="feedback_box">
								<div id="feedback_by" class="feedback_inner_box"><h4>{l s='FeedBack By' mod='marketplace'}</h4><span>{$message[$i]['firstname']}</span></div>
								<div id="product_name" class="feedback_inner_box"><h4>{l s='Product Name' mod='marketplace'}</h4><span>{$message[$i]['product_name']}</span></div>
								<div id="feedback" class="feedback_inner_box"><h4>{l s='FeedBack' mod='marketplace'}</h4><span>{$message[$i]['message']}</span></div>
								<div id="date_add" class="feedback_inner_box"><h4>{l s='Date Add' mod='marketplace'}</h4><span>{$message[$i]['date_add']}</span></div>
						</div>
						{assign var=i value=$i+1}
						{/while}
				</div>
			
			</div>
			<script type="text/javascript">
				$(document).ready(function(){
					$(".even").click(function()
					{
						var id_order =  $(this).attr('is_id_order');
						var order_link =  $('#order_link').val();
						var id_shop_order =  $('#id_shop_order').val();
						window.location.href = "{$base_dir}index.php?fc=module&module=marketplace&controller=marketplaceaccount&flag=1&shop="+id_shop_order+"&l=6&id_order="+id_order;
						//window.location.href = order_link+'&shop='+id_shop_order+'&l=6&id_order='+id_order;
						
					});
					
					$(".odd").click(function()
					{
						var id_order =  $(this).attr('is_id_order');
						var order_link =  $('#order_link').val();
						var id_shop_order =  $('#id_shop_order').val();
						window.location.href = "{$base_dir}index.php?fc=module&module=marketplace&controller=marketplaceaccount&flag=1&shop="+id_shop_order+"&l=6&id_order="+id_order;
						//window.location.href = order_link+'&shop='+id_shop_order+'&l=6&id_order='+id_order;
						
					});
					});
			</script>
		{else if $logic==5}
			<div class="page-heading">
				<h1 style="border-bottom:0px;">{l s='PAYMENT DETAIL' mod='marketplace'}</h1>
			</div>
			<div class="row-info" style="padding-left:0%;width:100%;border: 1px solid black;padding-bottom: 20px;">
			<form action="{$payPro_link}&pay=1" method="post" class="std" enctype="multipart/form-data" id="pay_form" accept-charset="UTF-8,ISO-8859-1,UTF-16">
			{if $payment_detail_exist == 0}
			<div class="row-info">
				<div class="row-info-left">
					<label class="pay" for="payment_mode">{l s='Payment Mode :' mod='marketplace'}</label>
				</div>
				<div class="row-info-right">
					<select id="payment_mode" name="payment_mode" class="account_input">
						{foreach $pay_mode as $pay_mode1}
							<option id="{$pay_mode1['id']}" value="{$pay_mode1['id']}">{$pay_mode1['payment_mode']}</option>
						{/foreach}
					</select>
				</div>
			</div>
			
			<div class="row-info">
				<div class="row-info-left">
					<label class="pay" for="payment_detail">{l s='Payment Detail :' mod='marketplace'}</label>
				</div>
				<div class="row-info-right1">
					<span><textarea id="payment_detail" name="payment_detail" value="" class="account_input" rows="4" cols="50"></textarea></span>
				</div>
			</div>
			<input type="hidden" id="customer_id" name="customer_id" value="{$customer_id}" class="account_input"/>
			<div class="row-info">
				<center>
					<input type="submit" id="SubmitProduct" name="SubmitCreate" class="button_large" value="{l s='Payment' mod='marketplace'}"/>
				</center>
			</div>
			{else if $payment_detail_exist == 1}
			<div class="row-info">
				<div  style="width:100px;float:right;"><a href="" class="edit_payment_details" style="color:blue;">edit</a><a href="" class="back_payment_details" style="color:blue;display:none;">back</a></div>
			</div>
			<div class="row-info">
				<div class="row-info-left">
					<label class="pay">{l s='Payment Mode :' mod='marketplace'}</label>
				</div>
				<div class="row-info-right">
					<label id="label_payment_mode">{$payment_mode}</label>
					<select id="payment_mode" name="payment_mode" class="account_input" style="display:none;">
						{foreach $pay_mode as $pay_mode1}
							<option id="{$pay_mode1['id']}" value="{$pay_mode1['id']}">{$pay_mode1['payment_mode']}</option>
						{/foreach}
					</select>
				</div>
			</div>
			<div class="row-info">
				<div class="row-info-left">
					<label class="pay">{l s='Payment Details :' mod='marketplace'}</label>
				</div>
				<div class="row-info-right">
					<label id="label_payment_mode_details">{$payment_mode_details}</label>
					<textarea id="payment_detail" name="payment_detail" value="" class="account_input" style="display:none;" rows="4" cols="50">{$payment_mode_details}</textarea>
				</div>
			</div>
			<div class="row-info">
		
				<input id="submit_payment_details" type="submit" name="edit_payment_details" value="submit" style="display:none;margin-left:200px;" />
				
			</div>
			{/if}
	</form>
	<div class="left full">
		{hook h="DisplayMppaymentdetailfooterhook"}
	</div>
</div>
		{else if $logic==6}
		
		<div class="dashboard">
				<div class="box-account box-recent">
					<div class="box-head">
						<div class="half left">
							{hook h='DisplayMpOrderheaderlefthook'}
						</div>
						<div class="half right">
							{hook h='DisplayMpOrderheaderrighthook'}
						</div>
					</div>
					<div id="box-head1">
						{hook h='DisplayMpbottomordercustomerhook'}
					</div>
					
					<div id="box-head2">
						{hook h='DisplayMpbottomorderstatushook'}
					</div>
					{hook h='DisplayMpordershippingrighthook'}
					{hook h='DisplayMpordershippinghook'}
				
					<div id="box-head3">
						{hook h='DisplayMpbottomorderproductdetailhook'}
					</div>
			</div>
		</div>
		
		{/if}

	</div>

{if $logic ==3}
<!-- /Block myaccount module -->
<script type="text/javascript">

$(document).ready(function(){

 $(".edit_img").click(function()

 {

var id=$(this).attr("id");
 
var url = '{$pro_upd_link}&id='+id+'&editproduct=1';

window.location.href = url;

});

 $(".delete_img").click(function()

 {				
				var confirm_msg = '{l s='Are you sure?' js=1}';  
				var con = confirm(confirm_msg);

				if(con == false)

				{}

				else

				{

				var id=$(this).attr("id");

				var url = '{$pro_upd_link}&id='+id+'&deleteproduct=1';

				window.location.href = url;

				}

});
})
</script>
{/if}
<script type="text/javascript">
$('.edit_payment_details').click(function(e)
{

	e.preventDefault();
	$(this).hide();
	$('.back_payment_details').show();
	$('#submit_payment_details').show();
	$('#label_payment_mode').hide();
	$('#label_payment_mode + select').show();
	
	$('#label_payment_mode_details').hide();
	$('#label_payment_mode_details + textarea').show();
	
});

$('.back_payment_details').click(function(e)
{
	e.preventDefault();
	$(this).hide();
	$('.edit_payment_details').show();
	$('#label_payment_mode').show();
	$('#label_payment_mode + select').hide();
	$('#submit_payment_details').hide();
	$('#label_payment_mode_details').show();
	$('#label_payment_mode_details + textarea').hide();
});

	
</script>
