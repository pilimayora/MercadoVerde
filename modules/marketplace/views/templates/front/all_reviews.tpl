<style>
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
 padding:1%;
 width:98%;
}
.seller_row
{
 width:100%;
 float:left;
 margin-top:5px;
}
h1
{
 color:red;
}
#left_column,#right_column
{
 display:none;
}
</style>
<h1>Reviews<span style="color:#666666;font-size:17px;font-weight:normal;">({$reviews_count})</span></h1>
<div id="wrapper">
 <div id="inner_wrapper">
 
                <div id="seller_review">
				{if $reviews_count != 0}
				{assign var=l value=1}
				{foreach from=$reviews_details item=details}
				<div class="review">
				 <div class="seller_row">
				  <span style="float:left;width:200px;font-size:14px;"><b>Rating:</b>
				  {assign var=i value=0}
					{while $i != $details.rating}
					<img src="{$modules_dir}marketplace/img/star-on.png" />
					{assign var=i value=$i+1}
					{/while}
				  {assign var=k value=0}	
				  {assign var=j value=5-$details.rating}
                  {while $k!=$j}
				   <img src="{$modules_dir}marketplace/img/star-off.png" />
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
				{if {$l}<{$reviews_count}}
					<hr style="width:100%;float:left;"></hr>
				{/if}
				 {assign var=l value=$l+1}
				{/foreach}
				{else}
				 <b> No reviews Available</b>
				{/if} 
				</div>
 </div>
</div>