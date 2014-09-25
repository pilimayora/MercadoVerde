<style>
#mp_main_block
{
 float:left;
}
.mp_info_block
{
 margin-top:5px;
 float:left;
 width:100%;
}
.mp_title
{
 float:left;
 width:200px;
 font-weight:bold;
}
.desc
{
 float:left;

}
</style>

<div id="mp_main_block">
<div class="mp_info_block">
<div class="mp_title">
 Customer Name :
</div>
<div class="desc">
 {$customer_name}
</div> 
</div>
<div class="mp_info_block">
<div class="mp_title">
 Customer Email :
</div>
<div class="desc">
 {$review_detail['customer_email']}
</div>
</div>
<div class="mp_info_block">
<div class="mp_title">
 Rating :
</div>
<div class="desc">
 
 {for $foo=1 to $review_detail['rating']}
    <img src="../modules/marketplace/img/star-on.png" />
 {/for}
</div>
</div>
<div class="mp_info_block">
<div class="mp_title">
 Customer Review :
</div>
<div class="desc">
{$review_detail['review']}
</div>
</div>
<div class="mp_info_block">
<div class="mp_title">
 Time :
</div>
<div class="desc">
 {$review_detail['timestamp']}
</div>
</div>
</div>
