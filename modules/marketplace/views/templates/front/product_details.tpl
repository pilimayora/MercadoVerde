<style>
#product_details
{
 float:left;
 width:750px;
 min-height:350px;
 border:1px solid;
 margin-left:20px;
 margin-bottom:20px;
 background-color:#cccccc;
}
#main_info_block
{
  float:left;
  width:750px;
  margin-left:20px;
  margin-bottom:20px;
}
#info
{
 float:left;
 margin-left:30px;
 margin-top:20px;
 width:440px;
}
.info_div ,.title ,.title_info,#image_info,#image_details
{
	float:left;
}
.info_div
{
	width:100%;
	margin-top:20px;
}
.title
{
 width:125px;
 font-weight:bold;
 font-size:12px;
}
.title_info
{
	margin-left:30px;
}
#image_info
{
 margin-top:30px;
 width:280px;
}
#image_details
{
	width:700px;
	margin-left:30px;
	background-color:#ffffff;
	margin-bottom:20px;
}
table {
    border: 0 none;
    border-spacing: 0;
    empty-cells: show;
    font-size: 100%;
    width: 100%;
}
table tr th 
{
     background: -moz-linear-gradient(center top , #F9F9F9, #ECECEC) repeat-x scroll left top #ECECEC;
    color: #333333;
    font-size: 13px;
    padding: 4px 6px;
    text-align: center;
    text-shadow: 0 1px 0 #FFFFFF;
}
table tr td {
    border-bottom: 1px solid #CCCCCC;
    color: #333333;
    font-size: 12px;
    padding: 4px 4px 4px 6px;
    text-align: center;
}
#fileSelect,#fileSelect1
	{
	/*   background: -moz-linear-gradient(center top , rgba(255, 255, 255, 0.3) 50%, #FFCC00 50%, #FFCC00) repeat scroll 0 0 #FFCC00; */
	   background: none repeat scroll 0 0 #FFCC00; 
       border-color: #FFCC00 #FFCC00 #9F9F9F;
       border-radius: 2px 2px 2px 2px;
       border-style: solid;
       border-width: 1px;
       color: #08233E;
       cursor: pointer;
       padding: 4px;
       text-shadow: 0 1px #FFFFFF;
	}
{if $browser == 'notie'}
#update_add_image {
    height: 0;
    visibility: hidden;
    width: 0;
}
{/if}
{if $browser == 'notie'}
#product_image{
    height: 0;
    visibility: hidden;
    width: 0;
}	
{/if}
.list_content li span a {
    color: #6C702F !important;
}
</style>

<div class="main_block">

 	{hook h="DisplayMpmenuhook"}
	
<div id="main_info_block">
	<div class="page_heading" style="float:left;width:100%;border-bottom:1px solid;line-height:2px;margin-left:20px;margin-bottom:10px;">
<h1>Product Detail</h1>
</div>
     <div id="product_details">
	  <div id="info">
	   <div id="pd_name" class="info_div">
	    <div class="title">
		 Product Name :
		</div>
		<div class="title_info">
		 {$name}
		</div>
	   </div>
	   
	   <div id="pd_desc" class="info_div">
	    <div class="title">
		 Product Description :
		</div>
		<div class="title_info">
		 {$description}
		</div>
	   </div>

       <div id="pd_price" class="info_div">
	    <div class="title">
		 Product Price :
		</div>
		<div class="title_info">
		 {$price}
		</div>
	   </div> 

       <div id="pd_qty" class="info_div">
	    <div class="title">
		 Product Quantity :
		</div>
		<div class="title_info">
		 {$quantity}
		</div>
	   </div>

       <div id="pd_status" class="info_div">
	    <div class="title">
		 Status :
		</div>
		<div class="title_info">
		 {if {$status} == 1}
		   Approved
		 {else}
           Pending
         {/if}		   
		</div>
		
	   </div>

          
	   </div>
	
	 <div id="image_info">
	{if $is_approve==1}
		<img src="http://{$image_id}"  style="max-width:280px;max-height:200px;"/>
	{else}
		{if $mp_pro_image!=0}
			<img src="{$modules_dir}/marketplace/img/product_img/{$cover_img}.jpg"  style="max-width:280px;max-height:200px;"/>
		{/if}
	{/if}
       </div>
{if $is_approve==1}	
<div style="float:left;width:100%;margin-left:30px;margin-top:30px;margin-bottom:20px;">
		<div style="float:left;"><b>Images:</b></div>
        <div style="float:left;">
		<form action="{$product_details_link}&id={$id}" method="post" enctype="multipart/form-data">
		 <!--<input type="file" name="product_image">
		 
		 <span style="margin-left:20px;">
								<input class="required" type="file" name="update_add_image" id="update_add_image"/>
							    <button id="fileSelect1" name="update_add_image">Add Image</button>
		</span> -->
		  <span style="margin-left:20px;">
								<input class="required" type="file" name="product_image" id="product_image"/>
								{if $browser == 'notie'}
							    <button id="fileSelect1" name="product_image">Add Product Image</button>
								{/if}
		</span>	
        <input type="submit" value="Add Image" name="add_image">		
		</form> 
		</div>
</div>		
{/if}
	{if $is_approve==1}
      <div id="image_details">
	    
		
		<table>
		 <tr>
		  <th>Image</th>
		  <th>Position</th>
		  <th>Cover</th>
		  <th>Action</th>
		 </tr>
		 {if {$count} > 0}
		  {foreach from=$img_info item=foo}
		   <tr class="unactiveimageinforow{$foo.id_image}">
		    <td><a class="fancybox" href="http://{$foo.image_link}">
		    <img title="15" width="45" height="45" alt="15" src="http://{$foo.image_link}" />
		   </a>
		   </td>
		    <td>{$foo.position}</td>
		   <td>
		    {if {$foo.cover} == 1}
			 <img class="covered" id="changecoverimage{$foo.id_image}" alt="{$foo.id_image}" src="{$img_ps_dir}admin/enabled.gif" is_cover="1"  id_pro="{$id}" />
			{else}
			 <img class="covered" id="changecoverimage{$foo.id_image}" alt="{$foo.id_image}" src="{$img_ps_dir}admin/forbbiden.gif" is_cover="0"  id_pro="{$id}" />
			{/if} 
		   </td>
		   <td>
		   {if {$foo.cover} == 1}
		     <img title="Delete this image" is_cover="1" class="delete_pro_image" alt="{$foo.id_image}"  src="{$img_ps_dir}admin/delete.gif" id_pro="{$id_product}" />
		   {else}
		     <img title="Delete this image" is_cover="0" class="delete_pro_image" alt="{$foo.id_image}"  src="{$img_ps_dir}admin/delete.gif" id_pro="{$id_product}" />
           {/if}		   
		   </td>
		   </tr>
		  {/foreach}
		 {/if}
		 
		</table>
	
      </div>
	 {else}
		<div id="image_details" style="float:left;margin-top:10px;">
			<table>
			 <tr>
				<th>Image</th>
				
			 </tr>
			 {foreach $mp_pro_image as $mp_pro_ima}
				<tr>
					<td>
						<a class="fancybox" href="{$modules_dir}/marketplace/img/product_img/{$mp_pro_ima['seller_product_image_id']}.jpg">
							<img title="15" width="45" height="45" alt="15" src="{$modules_dir}/marketplace/img/product_img/{$mp_pro_ima['seller_product_image_id']}.jpg" />
						</a>
					</td>
					
				</tr>
			 {/foreach}
			</table>
		</div>
	 {/if}
</div>	  
	  </div>
		<div class="left full">
			{hook h="DisplayMpproductdescriptionfooterhook"}
		</div>
	</div>

<script type="text/javascript">
				$('.fancybox').fancybox();
				
			$('.covered').live('click',function(e) {
				e.preventDefault();
				var id_image = $(this).attr('alt');
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
								alert("some error occurs");
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

			$('.delete_pro_image').live('click',function(e) {
				e.preventDefault();
				var id_image = $(this).attr('alt');
				var is_cover = $(this).attr('is_cover');
				var id_pro = $(this).attr('id_pro');
				var r=confirm("You want to delete image ?");
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
								alert("some error occurs");
							} else {
								alert("delete successfully");
								$(".unactiveimageinforow"+id_image).remove();
							}
						}
					});
				}
			});			{if $browser == 'notie'}
				
						/*	document.querySelector('#fileSelect1').addEventListener('click', function(e) {
								e.preventDefault();
								  // Use the native click() of the file input.
								  document.querySelector('#update_add_image').click();
							}, false);	 */
							
							document.querySelector('#fileSelect1').addEventListener('click', function(e) {
								e.preventDefault();
								  // Use the native click() of the file input.
								  document.querySelector('#product_image').click();
							}, false);
                       {/if}							
				
</script>
