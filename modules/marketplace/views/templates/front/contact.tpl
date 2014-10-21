<style>
.Shop_signature {
	color: {$cont_color};
    font-size: {$cont_size}px;
	font-family:{$cont_font_family};
	text-align:center;
    font-weight: bold;
    line-height: 1;
margin:19px 10% 5px 12.5%;
    width: 76%;
}
.contact_info{
font-size:{$cont_head_info_size}px;
font-weight:normal;
  font-family:{$cont_head_info_font_family};
  color:{$cont_head_info_color};
}

.contact_head
{
font-size:{$cont_head_size}px;
  font-weight:bold;
  line-height:20px;
  list-style:none;
  margin:0 0 0 20px;
  font-family:{$cont_head_font_family};
  color:{$cont_head_color};
}
#contactus ul
{
list-style:none;
}

.about_us h1 {
color:{$cont_heading_color};
font-family:{$cont_heading_font_family};
font-size:{$cont_heading_size}px;
border-bottom: 1px dotted #737739;
}
#wrapper {
    border: 1px solid {$cont_border_color};
    float: left;
    width: 100%;
}
</style>
<div id="wrapper">
	<div class="inner_wraper">
		<div class="header_container">
			<div class="logo1">
				{if $id_product}
					<a href="{$link_store}"><img src="{$base_dir}/modules/marketplace/img/shop_img/{$seller_id}-{$shop_name}.jpg" alt="{$shop_name}" width="100" height="100"></a>
				{else}
					<a href="{$link_store}"><img src="{$base_dir}/modules/marketplace/img/shop_img/{$seller_id}-{$shop_name}.jpg" alt="{$shop_name}" width="100" height="100"></a>
				{/if}
			</div>
			<div class="header_right">
				<div class="Shop_signature">
				{$shop_name} Shop
				</div>
				<div class="links" id="lin1"></div>
				<div class="links" id="lin" style="">
					
					<ul>
						{if $id_product}
							<li class="lin_header1" style="width: 78px;">
								<a href="{$link_collection}" style="">Collection</a>
							</li>
						{else}
							<li class="lin_header1" style="width: 78px;">
								<a href="{$link_collection}" style="">Collection</a>
							</li>
						{/if}
						<li class="head_sep"> <img src="{$base_dir}/modules/marketplace/img/NavSepLine.png"  height="35"/></li>
						{if $id_product}
							<li class="lin_header1" style="width:98px;">
								<a href="{$Seller_profile}" style="">Seller Profile</a>
							</li>
						{else}
							<li class="lin_header1" style="width:98px;">
								<a href="{$Seller_profile}" style="">Seller Profile</a>
							</li>
						{/if}
						<li class="head_sep"> <img src="{$base_dir}/modules/marketplace/img/NavSepLine.png"  height="35"/></li>
						{if $id_product}
					
						
							<li class="lin_header" style="width:65px;">
							<a href="{$link_conatct}" style="color:white !important;">Contact</a>
						</li>
						{else}
						
							<li class="lin_header" style="width:65px;">
							<a href="{$link_conatct}" style="color:white !important;">Contact</a>
						</li>
						{/if}
						
					</ul>
				</div>
				<div class="links" id="lin2"></div>
			</div>
		</div>
		<div class="header_bar_line"></div>
		<div class="store_container">
			<div class="about_us">
				<h1>Contact us</h1>
				
				<div class="about_us_description" id="contactus">
				<ul>
					<li><span class="contact_head">Business Mail :</span><span class="contact_info">{$business_email}</span></li>
					<li><span class="contact_head">Fax :</span><span class="contact_info">{$fax}</span></li>
					<li><span class="contact_head">Phone : </span><span class="contact_info">{$phone}</span></li>
					<li><span class="contact_head">Address :</span><span class="contact_info">{$address}</span></li>
					<li><span class="contact_head">Facebook :</span><span class="contact_info">{$facebook_id}</span></li>
					<li><span class="contact_head">Twitter :</span><span class="contact_info">{$twitter_id}</span></li>
				</ul>
				</div>
			</div>
		</div>
	</div>
</div>