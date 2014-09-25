<style>

.Shop_signature {

	color: {$prof_color};

    font-size: {$prof_size}px;

	font-family:{$prof_font_family};

	text-align:center;

    font-weight: bold;

    line-height: 1;

    margin:19px 10% 5px 12.5%;

    width: 76%;

}

.seller_profile h1{

	border-bottom: 1px dotted #737739;

	color:red;

    font-size:{$shop_heading_size}px;

	font-family:{$shop_heading_font_family};

}
#seller_review
{
 width:100%;
 float:left;
 color:#666666;
}
.review
{
 float:left;
 width:100%;
 margin-top:5px;
 padding:5px;
 
}
.seller_row
{
 width:100%;
 float:left;
 margin-top:5px;
}
.view_all
{
float:left;
width:100%;
margin-bottom:10px;
}

#add_feedback
{
 width:100%;
 float:left;
}
#add_rating
{
 width:100%;
 float:left;
}
#left_column,#right_column
{
 display:none;
}

#main-block {
    border: 1px solid;
    float: left;
    margin-top: 10px;
    min-height: 400px;
    padding-bottom: 20px;
    width: 980px;
}
#col-left
{
 float:left;
 margin-left: 20px;
 margin-top: 20px;
 width: 200px;
}
#img-block
{
 border: 1px solid #C4C1BC;
 margin-bottom: 20px;
 float:left;
}
#feedback
{
 float:left;
 border: 1px solid #C4C1BC;
 width:100%;
}
.title {
    background: none repeat scroll 0 0 #F8F7F5;
    border-bottom: 1px solid #C7C7C7;
    font-size: 14px;
    font-weight: bold;
    width: 100%;
}
.inner_span {
    padding: 5px;
}
h5 {
    padding: 5px;
}
#col-center {
    float:left;
    margin-left: 20px;
    margin-top: 20px;
    min-height: 200px;
    width: 400px;
}
#seller_info {
    float:left;
    background: none repeat scroll 0 0 #F8F7F5;
    min-height: 180px;
    width: 100%;
}
#col-right,#seller_info
{
   border: 1px solid #C4C1BC;
}
#col-right {
    float:left;
    background: none repeat scroll 0 0 #F8F7F5;
    min-height: 100px;
    margin-left: 20px;
    margin-top: 50px;
    width: 300px;
}
#reviews_title
{
 float:left;
 width:100%;
 font-size:14px;
 border-bottom: 1px solid #C7C7C7;
}
#reviews_list
{
 float:left;
 width:300px;
 background:#F1F9FF;
 
 
}
#review_box
{
 width:100%;
 float:left;
 border-bottom: 1px solid #C7C7C7;
}
#col-bottom
{
 float:left;
 width:70%;
}
#review_add
{
 float:left;
 
 display:none;
 
  background: none repeat scroll 0 0 #EBEDF4;
  border: 1px solid #CCCED7;
  left: 35%;
  min-height: 200px;
  position: absolute;
  top: 32%;
  
  z-index: 100000;
  padding:10px;
}
#newbody
 {
    background-color: #333333;
    height: 100%;
    left: 0;
   
	-moz-opacity: 0.80;
    opacity:.80;
    filter: alpha(opacity=80);
    overflow-x: auto;
    overflow-y: scroll;
    position: fixed;
    right: 0;
    top: 0;
    width: 100%;
    z-index: 10000;
	display:none;
 }
</style>


<div id="main-block">
	<div id="col-left">
		<div id="img-block">
			<a href=""><img src="{$path}" width="200" height="200" /></a>
		</div>
		<div id="feedback">
			<div style="float:left;width:100%;">
				<div class="title">
					<span class="inner_span">{l s='Feedback About Seller' mod='marketplace'}</span>
				</div>
				<div style="width:100%;float:left;background-color:#F1F9FF;">
					<h5><p>Rating:<span class="avg_rating"></span></p></h5>
					<a href="{$all_reviews_links}&seller_id={$seller_id}" style="float:right;margin-right:1px;color:blue;">{l s='View All Reviews' mod='marketplace'}</a>
				</div>
			</div>
		</div>
		<div id="viecollection" style="border: 1px solid #C4C1BC;float: left;width: 100%;margin-top:5px;">
			<div style="float:left;width:100%;">
				<div class="title">
					<span class="inner_span">{l s='Collection' mod='marketplace'}</span>
				</div>
				<div style="width:100%;float:left;background-color:#F1F9FF;">
					<div style="float:left;margin:5%;">
					<a href="{$link_collection}" style=" color: #0000FF;font-size: 14px">{l s='View Collection' mod='marketplace'}</a>
					</div>
				</div>
			</div>
		</div>
		
		{hook h='DisplayMpsplefthook'}
   </div>
   <div id="col-center">
    <div id="seller_title">
	 <h3>{$market_place_seller_info['seller_name']}</h3>
	</div>
	<div id="seller_info" class="block">
	<div style="padding:10px;float:left;width:380px;">
	  <div class="seller_main_row">

						<div class="seller_main_row_left">

							{l s='Seller Name' mod='marketplace'}

							:

						</div>

						<div class="seller_main_row_right">

							{$market_place_seller_info['seller_name']}

						</div>

	  </div>
	  
	  <div class="seller_main_row">

						<div class="seller_main_row_left">

							{l s='Business EMail' mod='marketplace'}

							:

						</div>

						<div class="seller_main_row_right">

							{$market_place_seller_info['business_email']}

						</div>

	  </div>
	  
	  <div class="seller_main_row">

						<div class="seller_main_row_left">

							{l s='Phone' mod='marketplace'}

							:

						</div>

						<div class="seller_main_row_right">

							{$market_place_seller_info['phone']}

						</div>

	  </div>
	  
	  <div class="seller_main_row">

						<div class="seller_main_row_left">

							{l s='Address' mod='marketplace'}

							:

						</div>

						<div class="seller_main_row_right">
							{if $market_place_seller_info['address']!=''}
								{$market_place_seller_info['address']}
							{else}
								NA
							{/if}
						</div>

	  </div>
	  
	  <div class="seller_main_row">

						<div class="seller_main_row_left">

							{l s='Facebook' mod='marketplace'}

							:

						</div>

						<div class="seller_main_row_right">
							{if $market_place_seller_info['facebook_id']!=''}
								<a href="https://www.facebook.com/{$market_place_seller_info['facebook_id']}">
									{$market_place_seller_info['facebook_id']}
								</a>
							{else}
								NA
							{/if}
						</div>

	 </div>
	 <div class="seller_main_row">

						<div class="seller_main_row_left">

							{l s='Twitter' mod='marketplace'}

							:

						</div>

						<div class="seller_main_row_right">
							{if $market_place_seller_info['twitter_id']!=''}
								{$market_place_seller_info['twitter_id']}
							{else}
								NA
							{/if}
						</div>

	 </div>
	  </div>
	</div>
   </div>
   <div class="rightcol">
	   <div id="col-right" class="block">
		 <div id="reviews_title">
		  <span style="float:left;padding:5px;font-weight:bold;">{l s='Reviews' mod='marketplace'}</span>
		  <span style="float:right;padding:5px;"><a href="{$all_reviews_links}&seller_id={$seller_id}" style="color:blue;">{l s='View all' mod='marketplace'}</a></span>
		  <span style="float:right;padding:5px;"><a id="add_rev" href="" style="color:blue;">{l s='Add Review' mod='marketplace'}</a></span>
		 </div>
		 <div id="reviews_list">
		  {if $reviews_count != 0}
		   {foreach from=$reviews_details item=details}
			<div id="review_box">
			 <div class="review">
				<div class="seller_row">
					  <span style="float:left;width:290px;font-size:14px;"><b>{l s='Rating' mod='marketplace'}:</b>
					  {assign var=i value=0}
						{while $i != $details.rating}
						<img src="{$modules_dir}/marketplace/img/star-on.png" />
						{assign var=i value=$i+1}
						{/while}
					  {assign var=k value=0}	
					  {assign var=j value=5-$details.rating}
					  {while $k!=$j}
					   <img src="{$modules_dir}/marketplace/img/star-off.png" />
					  {assign var=k value=$k+1}
					  {/while}				  
					  </span>
					  <span style="float:left;width:290px;margin-top:5px;"><b>{l s='Posted On:' mod='marketplace'}</b>{$details.time}</span>
					 </div>
					 <div class="seller_row">
					  <span><b style="font-size:14px;margin-top:5px;">Customer:</b>{$details.customer_name}({$details.customer_email})</span>
					 </div>
					
					
					<div class="seller_row">
					 <span style="float:left;"><b style="font-size:14px;">{l s='Review:' mod='marketplace'}</b></span>
					 <span style="margin-left:5px;">{$details.review}</span>
					
					</div>
					
			</div>
		  </div>
			 
		   {/foreach}
		  
		   {else}
				<b>{l s=' No reviews Available' mod='marketplace'}</b>
		  {/if}
		  </div>
		  
		 </div>
		 <div class="sprighthook">
				{hook h='DisplayMpsprighthook'}
		 </div>
	 </div>
	 <div id="col-bottom">
	  <div id="slider1" style="float: left;margin-left: 20px;width: 720px;">
	   <div id="recent_products">Recent Products</div>
		 <div class="example" id="slide">
			<div>
				<ul>
					{assign var=j value=0}
					{while $j != $count_latest_pro}
						<li> 
							<a href="{$base_dir}index.php?id_product={$all_product_id[$j]}&controller=product" class="product_img_link" title="{$product_name[$j]}">
								<img src="http://{$product_link[$j]}" alt="{$all_product_name[$j]}" width="108" height="100">
							</a>
						</li>
						{assign var=j value=$j+1}
					{/while}
				</ul> 
			</div>
		</div>
	  </div>
	  {hook h='DisplayMpspcontentbottomhook'}
	 </div>
	 <div id="review_add">
				<form method="post" action="" id="review_submit">
				<div style="float:left;width:100%;margin-bottom:10px;">
				   <b style="font-weight:bold;font-size:16px;">Add Rating:</b>
				 <span id="rating_image">
				 </span>
				 <span style="float:right;margin-right:5px;"><a id="close_rev_btn" href="" style="color:blue;">close</a></span>
				</div> 
				 <div id="add_feedback">
				  <h3>Add Feedback</h3>
				  <textarea rows="5" cols="100" name="feedback"></textarea>
				 </div>
				 <input type="hidden" name="seller_id" value="{$seller_id}">
				 <input type="submit" value="submit" name="submit_feedback">
				 </form>
	  </div>
	  <div id="newbody"></div>
   </div>
  


<!--<div id="wrapper">

	<div class="inner_wraper">

		<div class="header_container">

			<div class="logo1">

				{if $id_product != ""}

					<a href="{$link_store}&id={$id_product}"><img src="{$modules_dir}/marketplace/img/shop_img/{$seller_id}-{$shop_name}.jpg" alt="{$shop_name}" width="100" height="100"></a>

				{else}

					<a href="{$link_store}"><img src="{$modules_dir}/marketplace/img/shop_img/{$market_place_seller_info['id']}-{$shop_name}.jpg" alt="{$shop_name}" width="100" height="100"></a>

				{/if}

			</div>

			<div class="header_right">

				<div class="Shop_signature">

					{$shop_name} Shop

				</div>

				<div class="links" id="lin1"></div>

				<div class="links" id="lin" style="">

					

					<ul>

						{if $id_product !=""}

							<li class="lin_header1" style="width: 78px;">

								<a href="{$link_collection}&id={$id_product}" style="">Collection</a>

							</li>

						{else}

							<li class="lin_header1" style="width: 78px;">

								<a href="{$link_collection}" style="">Collection</a>

							</li>

						{/if}

						<li class="head_sep"> <img src="{$modules_dir}/marketplace/img/NavSepLine.png"  height="35"/></li>

						{if $id_product !=""}

							<li class="lin_header1" style="width:98px;">

								<a href="{$seller_profile}&id={$id_product}" style="color:white !important;">Seller Profile</a>

							</li>

						{else}

							<li class="lin_header1" style="width:98px;">

								<a href="{$seller_profile}" style="color:white !important;">Seller Profile</a>

							</li>

						{/if}

						<li class="head_sep"> <img src="{$modules_dir}/marketplace/img/NavSepLine.png"  height="35"/></li>

						{if $id_product != "" }

							<li class="lin_header" style="width:65px;">

							<a href="{$link_contact}&id={$id_product}" style="">Contact</a>

						</li>

						{else}

							<li class="lin_header" style="width:65px;">

							<a href="{$link_contact}" style="">Contact</a>

						</li>

						{/if}

						

					</ul>

				</div>

				<div class="links" id="lin2"></div>

			</div>

		</div>

		<div class="header_bar_line"></div>

		<div class="seller_profile_container">

			<div class="seller_profile">

				<h1>{l s='Personal Info' mod='marketplace'}</h1>

				<div class="seller_detail">

					<div class="seller_main_row">

						<div class="seller_main_row_left">

							{l s='Seller Name' mod='marketplace'}

							:

						</div>

						<div class="seller_main_row_right">

							{$market_place_seller_info['seller_name']}

						</div>

					</div>

					<div class="seller_main_row">

						<div class="seller_main_row_left">

							{l s='Business EMail' mod='marketplace'}

							:

						</div>

						<div class="seller_main_row_right">

							{$market_place_seller_info['business_email']}

						</div>

					</div>
					
					<div class="seller_main_row">

						<div class="seller_main_row_left">

							{l s='Phone' mod='marketplace'}

							:

						</div>

						<div class="seller_main_row_right">

							{$market_place_seller_info['phone']}

						</div>

					</div>
					
					<div class="seller_main_row">

						<div class="seller_main_row_left">

							{l s='Address' mod='marketplace'}

							:

						</div>

						<div class="seller_main_row_right">
							{if $market_place_seller_info['address']!=''}
								{$market_place_seller_info['address']}
							{else}
								NA
							{/if}
						</div>

					</div>
					
					<div class="seller_main_row">

						<div class="seller_main_row_left">

							{l s='Facebook' mod='marketplace'}

							:

						</div>

						<div class="seller_main_row_right">
							{if $market_place_seller_info['facebook_id']!=''}
								{$market_place_seller_info['facebook_id']}
							{else}
								NA
							{/if}
						</div>

					</div>
					
					<div class="seller_main_row">

						<div class="seller_main_row_left">

							{l s='Twitter' mod='marketplace'}

							:

						</div>

						<div class="seller_main_row_right">
							{if $market_place_seller_info['twitter_id']!=''}
								{$market_place_seller_info['twitter_id']}
							{else}
								NA
							{/if}
						</div>

					</div>
				</div>
				
				<h1>Reviews<span style="color:#666666;font-size:17px;font-weight:normal;">({$reviews_count})</span>
				<span class="avg_rating"></span>
				<span style="float:right;font-size:12px;font-weight:normal;"><input type="button" value="Add Review" id="add_review"/></span></h1>
				<div id="review_add">
				<form method="post" action="" id="review_submit">
				<div style="float:left;width:100%;margin-bottom:10px;">
				   <b style="font-weight:bold;font-size:16px;">Add Rating:</b>
				 <span id="rating_image">
				 </span>
				</div> 
				 <div id="add_feedback">
				  <h3>Add Feedback</h3>
				  <textarea rows="5" cols="100" name="feedback"></textarea>
				 </div>
				 <input type="hidden" name="seller_id" value="{$seller_id}">
				 <input type="submit" value="submit" name="submit_feedback">
				 </form>
				</div>
                <div id="seller_review">
				{if $reviews_count != 0}
				{foreach from=$reviews_details item=details}
				<div class="review">
				 <div class="seller_row">
				  <span style="float:left;width:200px;font-size:14px;"><b>Rating:</b>
				  {assign var=i value=0}
					{while $i != $details.rating}
					<img src="{$modules_dir}/marketplace/img/star-on.png" />
					{assign var=i value=$i+1}
					{/while}
				  {assign var=k value=0}	
				  {assign var=j value=5-$details.rating}
                  {while $k!=$j}
				   <img src="{$modules_dir}/marketplace/img/star-off.png" />
                  {assign var=k value=$k+1}
                  {/while}				  
				  </span>
				  <span style="float:right;width:170px;"><b>Posted On:</b>{$details.time}</span>
				 </div>
				 <div class="seller_row">
				  <span><b style="font-size:14px;">Customer:</b>{$details.customer_name}({$details.customer_email})</span>
				 </div>
				
				
				<div class="seller_row">
				 <span style="float:left;"><b style="font-size:14px;">Review:</b></span>
				 <span style="margin-left:5px;">{$details.review}</span>
				
				</div>
				
				</div>
				<hr style="width:100%;float:left;"></hr>
				{/foreach}
				<div class="view_all">
				 <a href="{$all_reviews_links}&seller_id={$seller_id}" style="color:blue;">View All</a>
				</div>
				{else}
				 <b> No reviews Available</b>
				{/if} 
				</div>
				
				<h1>Latest Product</h1>

				

				<div class="best-sell-box">

					<span class="ed_nav ed_left"></span>

					<div class="best-sell">

					

					{assign var=j value=0}a

					{while $j != $count_latest_pro}

					

						<div class="best-sell-product">

	<a href="{$base_dir}index.php?id_product={$all_product_id[$j]}&controller=product"><div class="image"><img src="http://{$product_link[$j]}" alt="{$all_product_name[$j]}" width="100" height="100"></div><div class="name">{$all_product_name[$j]}</div></a><div class="price">${$all_product_price[$j]}</div></div>



						

					{assign var=j value=$j+1}

					{/while}

					</div>

					<span class="ed_nav ed_right"></span>

				</div>



				

						

							

				

			</div>

		</div>

	</div>

</div>-->







<script>

$('#add_rev').click(function(e)
{
 e.preventDefault();
 $('#newbody').css('display','block');
 $('#review_add').css('display','block');
});
$('#close_rev_btn').click(function(e)
{
 e.preventDefault();
 $('#newbody').css('display','none');
 $('#review_add').css('display','none');
});
	$(function(){

	if($('.best-sell .best-sell-product').length==0)

	{

		$('.best-sell-box').hide();

	}

	var wk_slider=$('.best-sell .best-sell-product').length;

	

	$('.ed_right').click(function() {

	

		if(wk_slider>3)

		{

		var thisthis=$(this).siblings('.best-sell');

		

		thisthis.animate(

		{

		"left":"-=480px"

		},1500);

		wk_slider=wk_slider-3;

		}

		

	});

	

	$('.ed_left').click(function() {

		var thisthis=$(this).siblings('.best-sell');

		if(wk_slider < $('.best-sell .best-sell-product').length){

			thisthis.animate(

			{

			"left":"+=480px"

			},1500);

			wk_slider=wk_slider+3;

		}

	});

	



});

$('#add_review').click(function()
{
  $('#review_add').toggle('slow');
});

$('#review_submit').submit(function()
{
 var rating_image = $( "input[name='rating_image']" ).val();
 if(rating_image == '' || rating_image == ' ' )
 {
  alert('You have not given any rating');
  return false;
 }
});

</script>


<script type="text/javascript">
								var id = 'rating_image';
								$('#'+id).raty({
								    path: '{$modules_dir}/marketplace/rateit/lib/img',
									scoreName: id,
									
								});				
							</script>
{if $avg_rating>0}
<script type="text/javascript">
$('.avg_rating').raty(
{
									
	path: '{$modules_dir}/marketplace/rateit/lib/img',
	score: {$avg_rating},
	readOnly: true,
});
</script>	
{/if}						
<script type="text/javascript">
		$(document).ready(function()
{		
			$('#slide').microfiche();
});			
</script>





