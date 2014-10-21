<style>

.Shop_signature {
	color:{$shop_color};
    font-size:{$shop_size}px;
	font-family:{$shop_font_family};
	text-align:center;
    font-weight: bold;
    line-height: 1;
    margin:19px 10% 5px 12.5%;
    width: 76%;
}
.about_us h1 {
color:{$shop_head_color};
font-size:{$shop_head_size};
font-family:{$shop_head_font_family};
border-bottom: 1px dotted #737739;
}
#left_column
{
 display:none;
}
#right_column
{
 display:none;
}
#inner-block {
	width:238px;
}
#slider1 {
	float:left;
	width:100%;
}
#slide {
	float:left;
	width:100%;
}
#col-left,#col-center,#col-right,#main-block,#inner-block,#partner-info,#class_name,#shop_name,#feedback,#about_us,#site_link,#see_more,#image_main_block,#seller_details,#seller_name,#seller_email,.title,.inner_span,#slider,#recent_products
{
 float:left;
}
#main-block
{
 width:980px;
 border:1px solid;
 min-height:400px;
 margin-top:10px;
}
#col-left
{
  width:200px;
  margin-left:20px;
  margin-top:20px;
}
#img-block
{
 border: 1px solid #C4C1BC;
 margin-bottom: 20px;
 float:left;
}
#col-center
{
 width:400px;
 min-height:200px;
 margin-left:20px;
 margin-top:20px;
}
#col-right
{
 width:300px;
 height:200px;
 margin-left:20px;
 margin-top:53px;
 background:none repeat scroll 0 0 #F8F7F5
 
}
#shop_info
{
 width:100%;
 min-height:180px;
 margin-top:20px;
 background:none repeat scroll 0 0 #F8F7F5
}
.block
{
 border:1px solid #c4c1bc;
}
#partner-info,#feedback
{
 width:100%;
 
}
#shop_name
{
 width:100%;
 
 border-bottom:1px solid #c7c7c7;
}
h5
{
 padding:5px;
}
#site_link
{
width:100%;
padding:10px;
}
#about_us
{
 width:95%;
 padding:10px;
}
#see_more
{
 width:290px;
 padding-top:10px;
 padding-left:10px;
 font-weight:bold;
}
#image_main_block
{
 width:280px;
 padding:10px;
 
}
.product_img_link
{
 margin-left:4px;
 margin-top:4px;
 float:left;
}
#seller_details
{
 width:100%;
 
}
#feedback
{
 border-bottom:1px solid #C7C7C7;
}
.title
{
 font-weight:bold;
 border-bottom:1px solid #C7C7C7;
 width:100%;
 font-size:14px;
 background:none repeat scroll 0 0 #F8F7F5
}
.inner_span
{
 padding:5px;
}
#seller_name,#seller_email
{
 padding:5px;
 width:100%;
}

#slider1 {
    float: left;
    width: 70%;
	margin-left: 20px;
}
#recent_products
{
 width:100%;
 float:left;
 //margin-left:16px;
}
</style>



<div id="main-block">

	

     <div id="col-left">
	  <div id="img-block" class="block">
	   <a href="{$link_store}"><img src="{$modules_dir}marketplace/img/shop_img/{$seller_id}-{$shop_name}.jpg" alt="{$shop_name}" width="200" height="200"></a>
	  </div>
	  
	
	   <div id="shop_name" class="block">
	    <div style="float:left;width:100%;"> 
		 <div class="title"><span class="inner_span">{$shop_name}</span></div>
		 <div style="width:100%;float:left;background-color:#F1F9FF;">
			<h5><p>View Full Collection</p></h5>
			 <a href="{$link_collection}" style="float:right;margin-right:1px;color:blue;">{l s='Collection' mod='marketplace'}</a></div>
		 </div>
		</div> 
      
	   
	   <div id="feedback" class="block">
	    <div style="float:left;width:100%;">
		 <div class="title"><span class="inner_span">{l s='Feedback About Seller' mod='marketplace'}</span></div>
		 <div style="width:100%;float:left;background-color:#F1F9FF;"><h5><p>Rating:<span class="avg_rating"></span></p></h5>
		 <a href="{$all_reviews}" style="float:right;margin-right:1px;color:blue;">{l s='View All Reviews' mod='marketplace'}</a></div>
		</div>
	   </div>
	   <div id="seller_details" class="block">
	    <div style="float:left;width:100%;">
		 <div class="title"><span class="inner_span">{l s='Seller Details' mod='marketplace'}</span></div>
		 <div style="float:left;width:100%;background-color:#F1F9FF;">
		 <div id="seller_name"><b>{l s='Name:' mod='marketplace'}</b>  {$seller_name}</div>
		 {if $business_email!==""}
		 <div id="seller_email"><b>{l s='Email:' mod='marketplace'}</b>  {$business_email}</div>
		 {else}
		  <div id="seller_email"><b>{l s='Email:' mod='marketplace'}</b> {l s=' NA' mod='marketplace'}</div>
		 {/if}
		 <a href="{$Seller_profile}" style="float:right;margin-right:1px;color:blue;margin-top:5px;">
		 	{l s='View Seller Profile' mod='marketplace'}
		 </a>
		 </div>
		</div>
	   </div>
	   {hook h='DisplayMpshoplefthook'}
	  </div>
	
	 <div id="col-center">
	  <div id="shop_title">
	    <h3>{$shop_name}</h3>	
	  </div>
	  <div id="shop_info" class="block">
	    <div id="site_link">
		 <b style="font-size:14px;">
		 	{l s='About Us' mod='marketplace'}
		 </b>
		</div>
		<div id="about_us">
		 {$about_us}
	    </div>
	 </div>
	 </div>
	 <div class="rightcol">
		 <div id="col-right" class="block">
		  <div id="see_more"><a href="">{l s='See More Products' mod='marketplace'}...</a></div>
		  <div id="image_main_block">
		  {assign var=j value=0}
		  {while $j != $count_product}
		  
		  <a href="{$base_dir}index.php?id_product={$product_id[$j]}&controller=product" class="product_img_link" title="{$product_name[$j]}">

			<img src="{$image_link[$j]}" alt="" width="49" height="49" style="border:1px solid #CCCCCC"/>

			</a>
		  
		  {assign var=j value=$j+1}
		  {/while}
		  </div>
		 </div>
		 <div class="sprighthook">
				{hook h='DisplayMpshoprightmhook'}
		 </div>
	</div>
	 <div id="slider1">
		 <div id="recent_products">{l s='Recent Products' mod='marketplace'}</div>
		 <div class="example" id="slide">
			<div>
				<ul>
					{assign var=j value=0}
					{while $j != $count_product}
						<li> 
							<a href="{$base_dir}index.php?id_product={$product_id[$j]}&controller=product" class="product_img_link" title="{$product_name[$j]}">
								<img src="{$image_link[$j]}" alt="" width="99" height="99" style="border:1px solid #CCCCCC;"/>
							</a>
						</li>
						{assign var=j value=$j+1}
					{/while}
				</ul> 
			</div>
		</div>
		{hook h='DisplayMpshopcontentbottomhook'}
	</div>
		

</div>






		




			
<script type="text/javascript">
$('.avg_rating').raty(
{
									
	path: '{$modules_dir}marketplace/rateit/lib/img',
	score: {$avg_rating},
	readOnly: true,
});
</script>
<script type="text/javascript">
		$(document).ready(function()
{		
			$('#slide').microfiche();
});			
</script>