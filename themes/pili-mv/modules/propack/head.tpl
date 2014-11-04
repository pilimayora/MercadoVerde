{*
/**
 * StorePrestaModules SPM LLC.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://storeprestamodules.com/LICENSE.txt
 *
 /*
 * 
 * @author    StorePrestaModules SPM <kykyryzopresto@gmail.com>
 * @category others
 * @package propack
 * @copyright Copyright (c) 2011 - 2014 SPM LLC. (http://storeprestamodules.com)
 * @license   http://storeprestamodules.com/LICENSE.txt
*/
*}

{if $smarty.server.REQUEST_URI != "/"}
<meta property="fb:app_id" content="{$propackappid}"/>
<meta property="fb:admins" content="{$propackAPPADMIN}"/>
{if $propackproduct_id != 0}
<meta property="og:title" content="{$propackname|escape:html:'UTF-8'}"/>
<meta property="og:description" content="{$meta_description|escape:html:'UTF-8'}"/>
<meta property="og:image" content="{$propackimg}"/>
{/if}
<meta property="og:url" content="{$propackurl}"/>
<meta property="og:type" content="product"/>
{/if}

{if $propackpinvis_on == 1 && $propackpinbutton_on == 1 && $propackis_product_page != 0}

<meta property="og:title" content="{$product_name|escape:'htmlall':'UTF-8'}" />
<meta property="og:description" content="{$meta_description|escape:'htmlall':'UTF-8'}" />
<meta property="og:type" content="product" />
<meta property="og:url" content="http://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}" />
<meta property="og:site_name" content="{$shop_name|escape:'htmlall':'UTF-8'}" />
<meta property="og:price:amount" content="{$product_price_custom}" />
<meta property="og:price:currency" content="{$currency_custom}" />
<meta property="og:availability" content="{if $stock_string=='in_stock'}instock{else}{$stock_string}{/if}" />

{/if}

{if $propackreviewson == 1}
<link href="{$module_dir}css/reviewsnippets.css" rel="stylesheet" type="text/css" media="all" />
{/if}

{if $propackgsnipblock == 1 && $propack_product_id != 0}
<link href="{$module_dir}css/snippets-css.css" rel="stylesheet" type="text/css" media="all" />
{/if}

{if $propackrsson_snip == 1 && $propackreviewson == 1}
<link rel="alternate" type="application/rss+xml" href="{$base_dir_ssl}modules/propack/rss_reviews.php" />
{/if}


{if $propackblogon == 1}

<!-- Module Blog for PrestaShop -->
<link href="{$module_dir}css/blog.css" rel="stylesheet" type="text/css" media="all" />
{literal}
<script type="text/javascript">
function show_arch(id,column){
	for(i=0;i<100;i++){
		//$('#arch'+i).css('display','none');
		$('#arch'+i+column).hide(200);
	}
	//$('#arch'+id).css('display','block');
	$('#arch'+id+column).show(200);
	
}
</script>
{/literal}

{if $propackrsson == 1}
<link rel="alternate" type="application/rss+xml" href="{$base_dir_ssl}modules/propack/rss.php" />
{/if}
<!-- Module Blog for PrestaShop -->

{/if}


{if $propacktestimon == 1}
<!-- Module Testimonals -->
<link href="{$module_dir}css/blockshopreviews.css" rel="stylesheet" type="text/css" media="all" />
{literal}
<script type="text/javascript" src="{/literal}{$module_dir}{literal}js/blockshopreviews.js"></script>
{/literal}

{if $propacktrssontestim == 1}
<link rel="alternate" type="application/rss+xml" href="{$base_dir_ssl}modules/propack/rss_testimonials.php" />
{/if}
<!-- Module Testimonals -->
{/if}

{if $propackfaqon == 1}
<!-- Module FAQ -->
<link href="{$base_dir}modules/propack/css/blockfaq.css" 
	rel="stylesheet" type="text/css" media="all" />
<!-- Module FAQ -->
{/if}

{if $propackguon == 1}
<!-- Module GuestBook -->
<link href="{$module_dir}css/blockguestbook.css" rel="stylesheet" type="text/css" media="all" />
<!-- Module GuestBook -->
{/if}

{if $propacknewson == 1}
<!-- Module News -->
<link href="{$base_dir}modules/propack/css/blocknews.css" 
	rel="stylesheet" type="text/css" media="all" />
	
{literal}
<script type="text/javascript" src="{/literal}{$module_dir}{literal}js/blocknews.js"></script>
{/literal}
<!-- Module News -->
{/if}


{if $propackpqon == 1}
<!-- Module Product questions -->
<link href="{$base_dir}modules/propack/css/prodquestions.css" 
	rel="stylesheet" type="text/css" media="all" />
<!-- Module Product questions -->
{/if}

{if $propackstarscat == 1}
<!--  product list settings -->
{if $propackis_category == 1 && $propackreviewson == 1}

{literal}
<script type="text/javascript">

	$(document).ready(function(){
		{/literal}
		{foreach from=$propack_data_products key="id_product" item="item_product"}

		{if $propackis16 == 1}
		{literal}
		append_block = $('.product_list li.ajax_block_product:has(a.ajax_add_to_cart_button[data-id-product="{/literal}{$id_product}{literal}"]) div.right-block');
		{/literal}
		{else}
		{literal}
		append_block = $('#product_list li.ajax_block_product:has(a.ajax_add_to_cart_button[rel="ajax_id_product_{/literal}{$id_product}{literal}"]) div.right_block');
		{/literal}
		{/if}
		{literal}
		
		
		if(append_block.length > 0){
			append_block.append($('<div class="rating" style="margin:10px 0 10px 10px;float:left">{/literal}{$item_product.avg_rating}{literal}<\/div><a style="float:left;margin:10px" href="{/literal}{$item_product.link}{literal}">({/literal}{$item_product.count_review}{literal})<\/a><div style="clear:both"><\/div>'));
			//append_block.append($('<div class="rating" style="margin:10px 0 10px 10px;">{/literal}{$item_product.avg_rating}{literal}<\/div>'));
			//append_block.append('<a class="catalog-rating" href="{/literal}{$item_product.link}{literal}">({/literal}{$item_product.count_review}{literal})<\/a>'+stars+'<div class="propacks-clear"><\/div>');
			
				
		}else{
			
		}
		{/literal}
		{/foreach}
		{literal}
	});
	</script>	
	{/literal}
	
	
{literal}
<script type="text/javascript">
var module_dir = '{/literal}{$module_dir}{literal}';
</script>
{/literal}


<script type="text/javascript" src="{$module_dir}js/r_stars.js"></script>
{literal}
<script type="text/javascript">
jQuery(document).ready(init_rating);
</script>
{/literal}	
{/if}

<!--  product list settings -->
{/if}

{if $propackCOMMENTON == 1}
<link href="{$base_dir}modules/propack/css/facebookcomments.css" rel="stylesheet" type="text/css" media="all" />
{/if}
	
{if $propacklinkedinbon == 1}
{literal}
<script src="//platform.linkedin.com/in.js" type="text/javascript"></script>
{/literal}
{/if}


{literal}
<style type="text/css">
{/literal}
{if $smarty.server.REQUEST_URI != "/"}
{literal}
.buttons-propack td{vertical-align:bottom;width:20%}

.buttons-propack td{vertical-align:bottom;width:33%}
.propack-block{float:left;margin:0 5px}
.propack-clear{clear:both}

{/literal}{if $propackCOMMENTON == 1}{literal}

	div#idTabCU22 {
			background-color: {/literal}{$propackBGCOLOR}{literal};
		{/literal}{if $propackROUNDED == '1'}{literal}
			-moz-border-radius: 5px;
			border-radius: 5px;
			-webkit-border-radius: 5px;
		{/literal}{/if}{literal}		
		{/literal}{if $propackFORCE == '1'}{literal}display: block;{/literal}{/if}{literal}
	}
	
	div#customefacebookcommentstitle {
		{/literal}{if $propackROUNDED == '1'}{literal}
			-moz-border-radius-topright: 5px;
			border-top-right-radius: 5px;
			-webkit-border-top-right-radius: 5px;
			-moz-border-radius-topleft: 5px;
			border-top-left-radius: 5px;
			-webkit-border-top-left-radius: 5px;
		{/literal}{/if}{literal}
	}
	
	div#customefacebookcommentsdisclamer {
		{/literal}{if $propackROUNDED == '1'}{literal}
			-moz-border-radius: 5px;
			border-radius: 5px;
			-webkit-border-radius: 5px;
		{/literal}{/if}{literal}
	}		
	
	a#customefacebookcommentsregister {
		{/literal}{if $propackROUNDED == '1'}{literal}
			-moz-border-radius: 5px;
			border-radius: 5px;
			-webkit-border-radius: 5px;
		{/literal}{/if}{literal}
	}		
	
{/literal}{/if}

{/if}
	
{if !$propackislogged}

{literal}

.wrap a{text-decoration:none;opacity:1}
.wrap a:hover{text-decoration:none;opacity:0.5}
.width_propack{margin-top:12px}

.wrap1 a{text-decoration:none;opacity:1}
.wrap1 a:hover{text-decoration:none;opacity:0.5}
.width_propack1{width:40px}

.fbtwgblock-columns15{margin-top:10px;margin-left:10px}
.fbtwgblock-columns{margin-top:10px}

.fbtwgblock-columns15 a{float:left;margin-top:10px;margin-right:5px;opacity:1}
.fbtwgblock-columns15 a:hover{float:left;margin-top:10px;margin-right:5px;opacity:0.5}
.fbtwgblock-columns15 a.propack-last{margin-right:0px!important;}

.fbtwgblock-columns a{float:left;margin-top:10px;margin-right:5px;opacity:1}
.fbtwgblock-columns a:hover{float:left;margin-top:10px;margin-right:5px;opacity:0.5}
.fbtwgblock-columns a.propack-last{margin-right:0px!important;}

a.propack-log-in:hover{opacity:0.5}
a.propack-log-in{opacity:1} 
.propack-log-in-left{padding-left:5px!important;margin-left:5px!important}
{/literal}
{if $propack_topf == "topf" || $propack_topg == "topg" || $propack_topp == "topp"
|| $propack_topt == "topt" || $propack_topy == "topy" || $propack_topl == "topl"
|| $propack_toplive == "toplive" || $propack_topo == "topm"
|| $propack_topc == "topc" || $propack_topfl == "topfl" || $propack_topw == "topw"
|| $propack_topa == "topa"}
{literal}
#follow-teaser  {
	background-color:#F3F3F3;
	border-bottom:none;
	text-shadow:#7e9f5f 1px 1px;
	color:white;
	font-weight:bold;
	padding:10px 0;
	font-size:1.05em;
	/*margin-bottom:20px;*/
}
#follow-teaser .wrap {
    margin: auto;
    position: relative;
    width: auto;
	text-align:center
}

{/literal}
{/if}

{if $propack_footerf == "footerf" || $propack_footerg == "footerg" 
    || $propack_footerp == "footerp" || $propack_footert == "footert" 
    || $propack_footery == "footery" || $propack_footerl == "footerl"
	|| $propack_footerlive == "footerlive" 
	||  $propack_footerm == "footerm" ||  $propack_footerc == "footerc"
	||  $propack_footerfl == "footerfl" ||  $propack_footerw == "footerw"
	||  $propack_footera == "footera"}
{literal}
#follow-teaser-footer  {
	background-color:#F3F3F3;
	border-bottom:none;
	text-shadow:#7e9f5f 1px 1px;
	color:white;
	font-weight:bold;
	padding:10px 0;
	font-size:1.05em;
	width:100%;
	/*position:absolute;*/
	left:0px;
	margin-top:0px;
}
#follow-teaser-footer .wrap {
    margin: auto;
    position: relative;
    /*width: 52%;*/
	text-align:center
}

{/literal}
{/if}
{/if}
{literal}
</style>
{/literal}




{if !$propackislogged}

{literal}
<script type="text/javascript">
{/literal}
{if $propackis16 != 1}	
{literal}
<!--
//<![CDATA[
{/literal}
{/if}
	
{if $propack_footerf == "footerf" || $propack_footerg == "footerg" 
    || $propack_footerp == "footerp" || $propack_footert == "footert" 
    || $propack_footery == "footery" || $propack_footerl == "footerl" 
    ||  $propack_footerlive == "footerlive" 
    ||  $propack_footerm == "footerm" ||  $propack_footerc == "footerc"
    ||  $propack_footerfl == "footerfl" ||  $propack_footerw == "footerw"
    ||  $propack_footera == "footera"}
{literal}

$(document).ready(function() {
	var bottom_teaser = '<div id="follow-teaser-footer">'+
	'<div class="wrap">'+
	
	{/literal}{if $propack_footerf == "footerf"}{literal}
	'<a href="javascript:void(0)" onclick="return fblogin();" title="Facebook">'+
		'<img src="{/literal}{$propackfacebookimg}{literal}" class="width_propack" alt="Facebook"  />'+
	'</a>&nbsp;'+
	{/literal}
	{/if}
	{if $propack_footert == "footert"}{literal}
		'<a href="javascript:void(0)"'+ 
			{/literal}{if $propacktconf == 1}{literal} 
			   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/twitter.php{/literal}{if $propackorder_page == 1}{literal}?http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'login\', \'location,width=600,height=600,top=0\'); popupWin.focus();"'+
			 {/literal}{else}{literal}
				  'onclick="alert(\'{/literal}{$terror|escape:'htmlall'}{literal}\')"'+
			 {/literal}{/if}{literal}
			 'title="Twitter">'+
			'<img src="{/literal}{$propacktwitterimg}{literal}" style="margin-top:12px" />'+
		'</a>&nbsp;'+
	{/literal}
	{/if}
	{if $propack_footerg == "footerg"}{literal}
	'<a href="javascript:void(0)" title="Google"'+
	   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/login.php?p=google{/literal}{if $propackorder_page == 1}{literal}&http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'openId\', \'location,width=512,height=512,top=0\');popupWin.focus();">'+
			'<img src="{/literal}{$propackgoogleimg}{literal}"  style="margin-top:12px" alt="Google" />'+
		'</a>&nbsp;'+
	{/literal}{/if}
	{if $propack_footery == "footery"}{literal}
	'<a href="javascript:void(0)" title="Yahoo"'+
	   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/login.php?p=yahoo{/literal}{if $propackorder_page == 1}{literal}&http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'openId\', \'location,width=400,height=300,top=0\');popupWin.focus();"'+
		'>'+
		'<img src="{/literal}{$propackyahooimg}{literal}" style="margin-top:12px" alt="Yahoo"  />'+
	'</a>&nbsp;'+
	{/literal}{/if}
	{if $propack_footerp == "footerp"}{literal}
	'<a href="javascript:void(0)" title="Paypal"'+
		{/literal}{if $propackpconf == 1}{literal} 
		   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/paypalconnect.php{/literal}{if $propackorder_page == 1}{literal}?http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'openId\', \'location,width=512,height=512,top=0\');popupWin.focus();">'+
	    {/literal}{else}{literal}
				  'onclick="alert(\'{/literal}{$perror|escape:'htmlall'}{literal}\')">'+
		 {/literal}{/if}{literal}
		'<img src="{/literal}{$propackpaypalimg}{literal}"  style="margin-top:12px" alt="Paypal" />'+
		'</a>&nbsp;'+
	{/literal}{/if}
	{if $propack_footerl == "footerl"}{literal}
	'<a href="javascript:void(0)" title="LinkedIn"'+
		{/literal}{if $propacklconf == 1}{literal} 
		   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/linkedin.php{/literal}{if $propackorder_page == 1}{literal}?http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'openId\', \'location,width=512,height=512,top=0\');popupWin.focus();">'+
		{/literal}{else}{literal}
				  'onclick="alert(\'{/literal}{$lerror|escape:'htmlall'}{literal}\')">'+
		{/literal}{/if}{literal}  
		'<img src="{/literal}{$propacklinkedinimg}{literal}"  style="margin-top:12px" alt="LinkedIn" />'+
		'</a>&nbsp;'+
	{/literal}{/if}
	{if $propack_footerm == "footerm"}{literal}
		'<a href="javascript:void(0)" title="Microsoft Live"'+
		{/literal}{if $propackmconf == 1}{literal} 
		   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/microsoft.php{/literal}{if $propackorder_page == 1}{literal}?http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'openId\', \'location,width=512,height=512,top=0\');popupWin.focus();">'+
		{/literal}{else}{literal}
				  'onclick="alert(\'{/literal}{$merror|escape:'htmlall'}{literal}\')">'+
		{/literal}{/if}{literal}   
			
				'<img src="{/literal}{$propackmicrosoftimg}{literal}"  style="margin-top:12px" alt="Microsoft Live" \/>'+
			'<\/a>&nbsp;'+
	{/literal}{/if}
			
	{if $propack_footerlive == "footerlive"}{literal}
	'<a href="javascript:void(0)" title="Livejournal"'+
	   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/login.php?p=livejournal{/literal}{if $propackorder_page == 1}{literal}&http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'openId\', \'location,width=400,height=300,top=0\');popupWin.focus();"'+
		'>'+
		'<img src="{/literal}{$propacklivejournalimg}{literal}" style="margin-top:12px" alt="Livejournal"  />'+
	'</a>&nbsp;'+
	{/literal}{/if}
	
	{if $propack_footerc == "footerc"}{literal}
	'<a href="javascript:void(0)" title="Clavid"'+
	   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/login.php?p=clavid{/literal}{if $propackorder_page == 1}{literal}&http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'openId\', \'location,width=400,height=300,top=0\');popupWin.focus();"'+
		'>'+
		'<img src="{/literal}{$propackclavidimg}{literal}" style="margin-top:12px" alt="Clavid"  />'+
	'</a>&nbsp;'+
	{/literal}{/if}
	{if $propack_footerfl == "footerfl"}{literal}
	'<a href="javascript:void(0)" title="Flickr"'+
	   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/login.php?p=flickr{/literal}{if $propackorder_page == 1}{literal}&http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'openId\', \'location,width=400,height=300,top=0\');popupWin.focus();"'+
		'>'+
		'<img src="{/literal}{$propackflickrimg}{literal}" style="margin-top:12px" alt="Flickr"  />'+
	'</a>&nbsp;'+
	{/literal}{/if}
	{if $propack_footerw == "footerw"}{literal}
	'<a href="javascript:void(0)" title="Wordpress"'+
	   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/login.php?p=wordpress{/literal}{if $propackorder_page == 1}{literal}&http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'openId\', \'location,width=400,height=300,top=0\');popupWin.focus();"'+
		'>'+
		'<img src="{/literal}{$propackwordpressimg}{literal}" style="margin-top:12px" alt="Wordpress"  />'+
	'</a>&nbsp;'+
	{/literal}{/if}
	{if $propack_footera == "footera"}{literal}
	'<a href="javascript:void(0)" title="Aol"'+
	   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/login.php?p=aol{/literal}{if $propackorder_page == 1}{literal}&http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'openId\', \'location,width=400,height=300,top=0\');popupWin.focus();"'+
		'>'+
		'<img src="{/literal}{$propackaolimg}{literal}" style="margin-top:12px" alt="Aol"  />'+
	'</a>&nbsp;'+
	{/literal}{/if}{literal}
	
	
	
	'</div>'+ 
'</div>';

$('body').append(bottom_teaser);

    });
   
{/literal}
{/if}


{if $propack_topf == "topf" || $propack_topg == "topg" || $propack_topp == "topp"
	|| $propack_topt == "topt" || $propack_topy == "topy" || $propack_toplive == "toplive"
	 || $propack_topo == "topm" || $propack_topc == "topc"
	|| $propack_topfl == "topfl" || $propack_topw == "topw" || $propack_topa == "topa"}
{literal}


$(document).ready(function() {
	

	var top_teaser = '<div id="follow-teaser">'+
	'<div class="wrap">'+
	
	{/literal}{if $propack_topf == "topf"}{literal}
		'<a href="javascript:void(0)" onclick="return fblogin();" title="Facebook">'+
			'<img src="{/literal}{$propackfacebookimg}{literal}" class="width_propack"  alt="Facebook" />'+
		'</a>&nbsp;'+
		{/literal}
		{/if}
		{if $propack_topt == "topt"}{literal}
			'<a href="javascript:void(0)"'+ 
			{/literal}{if $propacktconf == 1}{literal} 
				   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/twitter.php{/literal}{if $propackorder_page == 1}{literal}?http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'login\', \'location,width=600,height=600,top=0\'); popupWin.focus();"'+
			 {/literal}{else}{literal}
						  'onclick="alert(\'{/literal}{$terror|escape:'htmlall'}{literal}\')"'+
			 {/literal}{/if}{literal}
			 'title="Twitter">'+
				'<img src="{/literal}{$propacktwitterimg}{literal}" style="margin-top:12px" />'+
			'</a>&nbsp;'+
		{/literal}
		{/if}
		{if $propack_topg == "topg"}{literal}
		'<a href="javascript:void(0)" title="Google"'+
		   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/login.php?p=google{/literal}{if $propackorder_page == 1}{literal}&http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'openId\', \'location,width=512,height=512,top=0\');popupWin.focus();">'+
				'<img src="{/literal}{$propackgoogleimg}{literal}"  style="margin-top:12px" alt="Google" />'+
			'</a>&nbsp;'+
		{/literal}{/if}
		{if $propack_topy == "topy"}{literal}
		'<a href="javascript:void(0)" title="Yahoo"'+
		   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/login.php?p=yahoo{/literal}{if $propackorder_page == 1}{literal}&http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'openId\', \'location,width=400,height=300,top=0\');popupWin.focus();"'+
			'>'+
			'<img src="{/literal}{$propackyahooimg}{literal}" style="margin-top:12px" alt="Yahoo"  />'+
		'</a>&nbsp;'+
		{/literal}{/if}
		{if $propack_topp == "topp"}{literal}
		'<a href="javascript:void(0)" title="Paypal"'+
			{/literal}{if $propackpconf == 1}{literal} 
			   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/paypalconnect.php{/literal}{if $propackorder_page == 1}{literal}?http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'openId\', \'location,width=512,height=512,top=0\');popupWin.focus();">'+
		    {/literal}{else}{literal}
					  'onclick="alert(\'{/literal}{$perror|escape:'htmlall'}{literal}\')">'+
			 {/literal}{/if}{literal}
			'<img src="{/literal}{$propackpaypalimg}{literal}"  style="margin-top:12px" alt="Paypal" />'+
			'</a>&nbsp;'+
		{/literal}{/if}
		{if $propack_topl == "topl"}{literal}
		'<a href="javascript:void(0)" title="LinkedIn"'+
			{/literal}{if $propacklconf == 1}{literal} 
			   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/linkedin.php{/literal}{if $propackorder_page == 1}{literal}?http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'openId\', \'location,width=512,height=512,top=0\');popupWin.focus();">'+
			{/literal}{else}{literal}
					  'onclick="alert(\'{/literal}{$lerror|escape:'htmlall'}{literal}\')">'+
			{/literal}{/if}{literal} 
			'<img src="{/literal}{$propacklinkedinimg}{literal}"  style="margin-top:12px" alt="LinkedIn" />'+
			'</a>&nbsp;'+
		{/literal}{/if}
		{if $propack_topm == "topm"}{literal}
			'<a href="javascript:void(0)" title="Microsoft Live"'+

			{/literal}{if $propackmconf == 1}{literal} 
			   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/microsoft.php{/literal}{if $propackorder_page == 1}{literal}?http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'openId\', \'location,width=512,height=512,top=0\');popupWin.focus();">'+
			{/literal}{else}{literal}
					  'onclick="alert(\'{/literal}{$merror|escape:'htmlall'}{literal}\')">'+
			{/literal}{/if}{literal}	

			'<img src="{/literal}{$propackmicrosoftimg}{literal}"  style="margin-top:12px" alt="Microsoft Live" \/>'+
				'<\/a>&nbsp;'+
		{/literal}{/if}
		{if $propack_toplive == "toplive"}{literal}
		'<a href="javascript:void(0)" title="Livejournal"'+
		   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/login.php?p=livejournal{/literal}{if $propackorder_page == 1}{literal}&http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'openId\', \'location,width=400,height=300,top=0\');popupWin.focus();"'+
			'>'+
			'<img src="{/literal}{$propacklivejournalimg}{literal}" style="margin-top:12px" alt="Livejournal"  />'+
		'</a>&nbsp;'+
		{/literal}{/if}
		
		
		{if $propack_topc == "topc"}{literal}
		'<a href="javascript:void(0)" title="Clavid"'+
		   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/login.php?p=clavid{/literal}{if $propackorder_page == 1}{literal}&http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'openId\', \'location,width=400,height=300,top=0\');popupWin.focus();"'+
			'>'+
			'<img src="{/literal}{$propackclavidimg}{literal}" style="margin-top:12px" alt="Clavid"  />'+
		'</a>&nbsp;'+
		{/literal}{/if}
		{if $propack_topfl == "topfl"}{literal}
		'<a href="javascript:void(0)" title="Flickr"'+
		   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/login.php?p=flickr{/literal}{if $propackorder_page == 1}{literal}&http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'openId\', \'location,width=400,height=300,top=0\');popupWin.focus();"'+
			'>'+
			'<img src="{/literal}{$propackflickrimg}{literal}" style="margin-top:12px" alt="Flickr"  />'+
		'</a>&nbsp;'+
		{/literal}{/if}
		{if $propack_topw == "topw"}{literal}
		'<a href="javascript:void(0)" title="Wordpress"'+
		   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/login.php?p=wordpress{/literal}{if $propackorder_page == 1}{literal}&http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'openId\', \'location,width=400,height=300,top=0\');popupWin.focus();"'+
			'>'+
			'<img src="{/literal}{$propackwordpressimg}{literal}" style="margin-top:12px" alt="Wordpress"  />'+
		'</a>&nbsp;'+
		{/literal}{/if}
		{if $propack_topa == "topa"}{literal}
		'<a href="javascript:void(0)" title="Aol"'+
		   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/login.php?p=aol{/literal}{if $propackorder_page == 1}{literal}&http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'openId\', \'location,width=400,height=300,top=0\');popupWin.focus();"'+
			'>'+
			'<img src="{/literal}{$propackaolimg}{literal}" style="margin-top:12px" alt="Aol"  />'+
		'</a>&nbsp;'+
		{/literal}{/if}{literal}
	
	'</div>'+ 
'</div>';

$('body').prepend(top_teaser);

    });
   
    	
{/literal}
{/if}




{if $blockfacebookappid != '' && $blockfacebooksecret != ''}
{literal}

$(document).ready(function(){

	//add div fb-root
	if ($('div#fb-root').length == 0)
	{
	    FBRootDom = $('<div>', {'id':'fb-root'});
	    $('body').prepend(FBRootDom);
	}

	(function(d){
        var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
        js = d.createElement('script'); js.id = id; js.async = true;
        js.src = "//connect.facebook.net/{/literal}{$propacklang}{literal}/all.js";
        d.getElementsByTagName('head')[0].appendChild(js);
      }(document));
});	

	function login(){
		$.post(baseDir+'modules/propack/ajax.php', 
					{action:'login',
					 secret:'{/literal}{$blockfacebooksecret}{literal}',
					 appid:'{/literal}{$blockfacebookappid}{literal}'
					 }, 
		function (data) {
			if (data.status == 'success') {
						
				{/literal}{if $propackorder_page == 1}{literal}
					var url = "{/literal}{$base_dir_ssl}{$propackuri|urldecode}{literal}";
				{/literal}{else}{literal}		
					//var url = "{/literal}http://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI|urldecode}{literal}";
					var url = "{/literal}{$base_dir_ssl}{$propackuri|urldecode}{literal}";
				{/literal}{/if}{literal}		
				window.location.href= url;
				
				
						
			} else {
				alert(data.message);
			}
		}, 'json');
	}
	function logout(){
				var url = "{/literal}{$base_dir}index.php?mylogout{literal}";
				$('#fb-log-out').html('');
				$('#fb-log-out').html('Log in');
				$('#fb-fname-lname').remove();
				window.location.href= url;
	}
	function greet(){
	   FB.api('/me', function(response) {
		   
		var src = 'https://graph.facebook.com/'+response.id+'/picture';
		$('#header_user_info span').append('<img style="margin-left:5px" height="20" src="'+src+'"/>');
			
		{/literal}{if !$propackislogged}{literal}
			login();
		{/literal}{/if}{literal}
		 });
	}


	   function fblogin(){
		   
			FB.init({appId: '{/literal}{$blockfacebookappid}{literal}', 
					status: true, 
					cookie: true, 
					xfbml: true,
		         	oauth: true});
         	
				FB.login(function(response) {
		            if (response.status == 'connected') {
			            login();
		            } else {
		                // user is not logged in
		                logout();
		            }
		        }, {scope:'email,user_birthday'});
		       
		        return false;
			}
	   {/literal}
{else}
{literal}
function fblogin(){
	alert("{/literal}{$ferror|escape:'htmlall'}{literal}");
	return;	
}
{/literal}
{/if}
		   




{literal}
$(document).ready(function() {

	 var ph = '<div class="wrap" style="text-align:center">'+
	{/literal}
		{if $propack_authpagef == "authpagef"}
	{literal}
	 '<a href="javascript:void(0)" onclick="return fblogin();" title="Facebook">'+
	   '<img src="{/literal}{$propackfacebookimg}{literal}" alt="Facebook" style="margin-top:12px"  />'+
	 '<\/a>&nbsp;'+
	 {/literal}
	 	{/if}
	 {if $propack_authpaget == "authpaget"}{literal}
		'<a href="javascript:void(0)"'+ 
		{/literal}{if $propacktconf == 1}{literal} 
			   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/twitter.php{/literal}{if $propackorder_page == 1}{literal}?http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'login\', \'location,width=600,height=600,top=0\'); popupWin.focus();"'+
		 {/literal}{else}{literal}
					  'onclick="alert(\'{/literal}{$terror|escape:'htmlall'}{literal}\')"'+
		 {/literal}{/if}{literal}
		 'title="Twitter">'+
			'<img src="{/literal}{$propacktwitterimg}{literal}" style="margin-top:12px" />'+
		'</a>&nbsp;'+
	 {/literal}
	 {/if}
		 
	 {if $propack_authpageg == "authpageg"}
	 {literal}
	 '<a href="javascript:void(0)" title="Google"'+
	   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/login.php?p=google{/literal}{if $propackorder_page == 1}{literal}&http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'openId\', \'location,width=512,height=512,top=0\');popupWin.focus();">'+
			'<img src="{/literal}{$propackgoogleimg}{literal}" alt="Google" style="margin-top:12px" />'+
		'</a>&nbsp;'+
	 {/literal}
	 {/if}
	 {if $propack_authpagey == "authpagey"}{literal}
		'<a href="javascript:void(0)" title="Yahoo"'+
		   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/login.php?p=yahoo{/literal}{if $propackorder_page == 1}{literal}&http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'openId\', \'location,width=400,height=300,top=0\');popupWin.focus();"'+
			'>'+
			'<img src="{/literal}{$propackyahooimg}{literal}" style="margin-top:12px" alt="Yahoo"  />'+
		'</a>&nbsp;'+
	 {/literal}{/if}
	 {if $propack_authpagep == "authpagep"}
	 {literal}
	 '<a href="javascript:void(0)" title="Paypal"'+
	 	{/literal}{if $propackpconf == 1}{literal}
		   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/paypalconnect.php{/literal}{if $propackorder_page == 1}{literal}?http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'openId\', \'location,width=512,height=512,top=0\');popupWin.focus();">'+
	     {/literal}{else}{literal}
				  'onclick="alert(\'{/literal}{$perror|escape:'htmlall'}{literal}\')">'+
		 {/literal}{/if}{literal}
		 	'<img src="{/literal}{$propackpaypalimg}{literal}" alt="Paypal" style="margin-top:12px" />'+
	 '</a>&nbsp;'+
	 {/literal}
		 {/if}
	 {if $propack_authpagel == "authpagel"}
	 {literal}
		 '<a href="javascript:void(0)" title="LinkedIn"'+
			 {/literal}{if $propacklconf == 1}{literal} 
			   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/linkedin.php{/literal}{if $propackorder_page == 1}{literal}?http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'openId\', \'location,width=512,height=512,top=0\');popupWin.focus();">'+
			 {/literal}{else}{literal}
					  'onclick="alert(\'{/literal}{$lerror|escape:'htmlall'}{literal}\')">'+
			{/literal}{/if}{literal}
			'<img src="{/literal}{$propacklinkedinimg}{literal}" alt="LinkedIn" style="margin-top:12px" />'+
		 '</a>&nbsp;'+
	 {/literal}
	 {/if}
	{if $propack_authpagem == "authpagem"}
		 {literal}
			 '<a href="javascript:void(0)" title="Microsoft Live"'+
			 
			    {/literal}{if $propackmconf == 1}{literal} 
				   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/microsoft.php{/literal}{if $propackorder_page == 1}{literal}?http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'openId\', \'location,width=512,height=512,top=0\');popupWin.focus();">'+
				{/literal}{else}{literal}
						  'onclick="alert(\'{/literal}{$merror|escape:'htmlall'}{literal}\')">'+
				{/literal}{/if}{literal}

				'<img src="{/literal}{$propackmicrosoftimg}{literal}" alt="Microsoft Live" style="margin-top:12px" \/>'+
			 '<\/a>&nbsp;'+
		 {/literal}
	 {/if}
	 {if $propack_authpagelive == "authpagelive"}{literal}
		'<a href="javascript:void(0)" title="Livejournal"'+
		   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/login.php?p=livejournal{/literal}{if $propackorder_page == 1}{literal}&http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'openId\', \'location,width=400,height=300,top=0\');popupWin.focus();"'+
			'>'+
			'<img src="{/literal}{$propacklivejournalimg}{literal}" style="margin-top:12px" alt="Livejournal"  />'+
		'</a>&nbsp;'+
	 {/literal}{/if}
	 
	
	 {if $propack_authpagec == "authpagec"}{literal}
		'<a href="javascript:void(0)" title="Clavid"'+
		   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/login.php?p=clavid{/literal}{if $propackorder_page == 1}{literal}&http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'openId\', \'location,width=400,height=300,top=0\');popupWin.focus();"'+
			'>'+
			'<img src="{/literal}{$propackclavidimg}{literal}" style="margin-top:12px" alt="Clavid"  />'+
		'</a>&nbsp;'+
	 {/literal}{/if}
	 {if $propack_authpagefl == "authpagefl"}{literal}
		'<a href="javascript:void(0)" title="Flickr"'+
		   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/login.php?p=flickr{/literal}{if $propackorder_page == 1}{literal}&http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'openId\', \'location,width=400,height=300,top=0\');popupWin.focus();"'+
			'>'+
			'<img src="{/literal}{$propackflickrimg}{literal}" style="margin-top:12px" alt="Flickr"  />'+
		'</a>&nbsp;'+
	 {/literal}{/if}
	 {if $propack_authpagew == "authpagew"}{literal}
		'<a href="javascript:void(0)" title="Wordpress"'+
		   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/login.php?p=wordpress{/literal}{if $propackorder_page == 1}{literal}&http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'openId\', \'location,width=400,height=300,top=0\');popupWin.focus();"'+
			'>'+
			'<img src="{/literal}{$propackwordpressimg}{literal}" style="margin-top:12px" alt="Wordpress"  />'+
		'</a>&nbsp;'+
	 {/literal}{/if}
	 {if $propack_authpagea == "authpagea"}{literal}
		'<a href="javascript:void(0)" title="Aol"'+
		   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/login.php?p=aol{/literal}{if $propackorder_page == 1}{literal}&http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'openId\', \'location,width=400,height=300,top=0\');popupWin.focus();"'+
			'>'+
			'<img src="{/literal}{$propackaolimg}{literal}" style="margin-top:12px" alt="Aol"  />'+
		'</a>&nbsp;'+
	 {/literal}{/if}
	 {literal}
	'<\/div>';
	
    $('#login_form').after(ph);


    var ph_top = '&nbsp;'+
    {/literal}
		{if $propack_welcomef == "welcomef"}
	{literal}
       '<a href="javascript:void(0)" onclick="return fblogin();" title="Facebook" class="propack-log-in{/literal}{if $propackis_ps5 == 1} propack-log-in-left{/if}{literal}">'+
	   '<img src="{/literal}{$propackfacebooksmallimg}{literal}" alt="Facebook"  />'+
	 '<\/a>&nbsp;'+
	 {/literal}
	 	{/if}
	 {if $propack_welcomet == "welcomet"}{literal}
		'<a href="javascript:void(0)" title="Twitter" class="propack-log-in{/literal}{if $propackis_ps5 == 1} propack-log-in-left{/if}{literal}"'+ 
		{/literal}{if $propacktconf == 1}{literal} 
			   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/twitter.php{/literal}{if $propackorder_page == 1}{literal}?http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'login\', \'location,width=600,height=600,top=0\'); popupWin.focus();"'+
		 {/literal}{else}{literal}
					  'onclick="alert(\'{/literal}{$terror|escape:'htmlall'}{literal}\')"'+
		 {/literal}{/if}{literal}
		 'title="Twitter" class="propack-log-in">'+
	 			'<img src="{/literal}{$propacktwittersmallimg}{literal}" />'+
		'</a>&nbsp;'+
	 {/literal}
	 {/if}
	 {if $propack_welcomeg == "welcomeg"}
	 {literal}
	 '<a href="javascript:void(0)" title="Google" class="propack-log-in{/literal}{if $propackis_ps5 == 1} propack-log-in-left{/if}{literal}"'+
	   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/login.php?p=google{/literal}{if $propackorder_page == 1}{literal}&http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'openId\', \'location,width=512,height=512,top=0\');popupWin.focus();">'+
			'<img src="{/literal}{$propackgooglesmallimg}{literal}" alt="Google"  />'+
		'</a>&nbsp;'+
	 {/literal}
	 {/if}

	 {if $propack_welcomey == "welcomey"}{literal}
		'<a href="javascript:void(0)" title="Yahoo" class="propack-log-in{/literal}{if $propackis_ps5 == 1} propack-log-in-left{/if}{literal}"'+
		   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/login.php?p=yahoo{/literal}{if $propackorder_page == 1}{literal}&http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'openId\', \'location,width=400,height=300,top=0\');popupWin.focus();"'+
			'>'+
			'<img src="{/literal}{$propackyahoosmallimg}{literal}" alt="Yahoo"  />'+
		'</a>&nbsp;'+
	 {/literal}{/if}
		 
	 {if $propack_welcomep == "welcomep"}
	 {literal}
	 '<a href="javascript:void(0)" title="Paypal" class="propack-log-in{/literal}{if $propackis_ps5 == 1} propack-log-in-left{/if}{literal}"'+
	 	{/literal}{if $propackpconf == 1}{literal}
		   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/paypalconnect.php{/literal}{if $propackorder_page == 1}{literal}?http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'openId\', \'location,width=512,height=512,top=0\');popupWin.focus();">'+
	     {/literal}{else}{literal}
		   	  'onclick="alert(\'{/literal}{$perror|escape:'htmlall'}{literal}\')">'+
		 {/literal}{/if}{literal}
		 '<img src="{/literal}{$propackpaypalsmallimg}{literal}" alt="Paypal" />'+
	 '</a>&nbsp;'+
	 {/literal}
		 {/if}
	{if $propack_welcomel == "welcomel"}
	 {literal}
	 '<a href="javascript:void(0)" title="LinkedIn" class="propack-log-in{/literal}{if $propackis_ps5 == 1} propack-log-in-left{/if}{literal}"'+
	 	{/literal}{if $propacklconf == 1}{literal} 
		   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/linkedin.php{/literal}{if $propackorder_page == 1}{literal}?http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'openId\', \'location,width=512,height=512,top=0\');popupWin.focus();">'+
		{/literal}{else}{literal}
			  'onclick="alert(\'{/literal}{$lerror|escape:'htmlall'}{literal}\')">'+
		{/literal}{/if}{literal} 
		'<img src="{/literal}{$propacklinkedinsmallimg}{literal}" alt="LinkedIn" />'+
	 '</a>&nbsp;'+
	 {/literal}
		 {/if}
		{if $propack_welcomem == "welcomem"}
			 {literal}
			 '<a class="propack-log-in{/literal}{if $propackis_ps5 == 1} propack-log-in-left{/if}{literal}" href="javascript:void(0)" title="Microsoft Live" {/literal}{if $propackis_ps5 == 1}style="padding-left:10px"{/if}{literal}'+

			 	{/literal}{if $propackmconf == 1}{literal} 
				   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/microsoft.php{/literal}{if $propackorder_page == 1}{literal}?http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'openId\', \'location,width=512,height=512,top=0\');popupWin.focus();">'+
				{/literal}{else}{literal}
						  'onclick="alert(\'{/literal}{$merror|escape:'htmlall'}{literal}\')">'+
				{/literal}{/if}{literal}
				
			   	'<img src="{/literal}{$propackmicrosoftsmallimg}{literal}" alt="Microsoft Live" \/>'+
			 '<\/a>&nbsp;'+
			 {/literal}
		 {/if}		 
	 {if $propack_welcomelive == "welcomelive"}{literal}
		'<a href="javascript:void(0)" title="Livejournal" class="propack-log-in{/literal}{if $propackis_ps5 == 1} propack-log-in-left{/if}{literal}"'+
		   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/login.php?p=livejournal{/literal}{if $propackorder_page == 1}{literal}&http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'openId\', \'location,width=400,height=300,top=0\');popupWin.focus();"'+
			'>'+
			'<img src="{/literal}{$propacklivejournalsmallimg}{literal}" alt="Livejournal"  />'+
		'</a>&nbsp;'+
	 {/literal}{/if}
	 
	
	 {if $propack_welcomec == "welcomec"}{literal}
		'<a href="javascript:void(0)" title="Clavid" class="propack-log-in{/literal}{if $propackis_ps5 == 1} propack-log-in-left{/if}{literal}"'+
		   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/login.php?p=clavid{/literal}{if $propackorder_page == 1}{literal}&http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'openId\', \'location,width=400,height=300,top=0\');popupWin.focus();"'+
			'>'+
			'<img src="{/literal}{$propackclavidsmallimg}{literal}" alt="Clavid"  />'+
		'</a>&nbsp;'+
	 {/literal}{/if}
	 {if $propack_welcomefl == "welcomefl"}{literal}
		'<a href="javascript:void(0)" title="Flickr" class="propack-log-in{/literal}{if $propackis_ps5 == 1} propack-log-in-left{/if}{literal}"'+
		   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/login.php?p=flickr{/literal}{if $propackorder_page == 1}{literal}&http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'openId\', \'location,width=400,height=300,top=0\');popupWin.focus();"'+
			'>'+
			'<img src="{/literal}{$propackflickrsmallimg}{literal}" alt="Flickr"  />'+
		'</a>&nbsp;'+
	 {/literal}{/if}
	 {if $propack_welcomew == "welcomew"}{literal}
		'<a href="javascript:void(0)" title="Wordpress" class="propack-log-in{/literal}{if $propackis_ps5 == 1} propack-log-in-left{/if}{literal}"'+
		   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/login.php?p=wordpress{/literal}{if $propackorder_page == 1}{literal}&http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'openId\', \'location,width=400,height=300,top=0\');popupWin.focus();"'+
			'>'+
			'<img src="{/literal}{$propackwordpresssmallimg}{literal}" alt="Wordpress"  />'+
		'</a>&nbsp;'+
	 {/literal}{/if}
	{if $propack_welcomea == "welcomea"}{literal}
		'<a href="javascript:void(0)" title="Aol" class="propack-log-in{/literal}{if $propackis_ps5 == 1} propack-log-in-left{/if}{literal}"'+
		   'onclick="javascript:popupWin = window.open(\'{/literal}{$base_dir}{literal}modules/propack/login.php?p=aol{/literal}{if $propackorder_page == 1}{literal}&http_referer={/literal}{$propackhttp_referer|urlencode}{/if}{literal}\', \'openId\', \'location,width=400,height=300,top=0\');popupWin.focus();"'+
			'>'+
			'<img src="{/literal}{$propackaolsmallimg}{literal}" alt="Aol"  />'+
		'</a>'+
	 {/literal}{/if}
	 {literal}
	 '';
    
    if($('#header_user_info a'))
    	$('#header_user_info a').after(ph_top);
    });
{/literal}

{if $propackis16 != 1}
{literal}
	// ]]>
-->
{/literal}
{/if}
{literal}	
</script>
{/literal}

{else}


{if $propacktwpopup == 1}

<!--  show popup for twitter customer which not changed email address  -->

{literal}
<style type="text/css">
div#fb-con-wrapper {
	width: 500px;
	padding: 20px 25px;
	position: fixed;
	bottom: 50%;
	left: 50%;
	margin-left: -250px;
	z-index: 9999;
	background-color: #EEE;
	color: #444;
	border-radius: 5px;
	font-size: 14px;
	font-weight: bold;
	display: none;
	box-shadow: 0 0 27px 0 #111;
	text-align: center;
	line-height: 1em;
}

div#fb-con {
	filter: alpha(opacity=70);
	-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=70)";	
	opacity: 0.7;
	background-color: #444;	
	width: 100%;
	height: 100%;	
	cursor: pointer;
	z-index: 9998;
	position: fixed;
	bottom: 0;
	top: 0;
	left:0;
	display: none;	
}
</style>
{/literal}


{literal}
<script type="text/javascript"><!--
{/literal}
{if $propackis16 != 1}	
{literal}

//<![CDATA[
{/literal}
{/if}


{literal}

$(document).ready(function() {
	var data = '<h4><img src="{/literal}{$module_dir}{literal}img/settings_t.png"/>&nbsp;{/literal}{$propacktw_one|escape:'htmlall'}{literal}</h4>'+
			   '<br/>'+
			   '<p>{/literal}{$propacktw_two|escape:'htmlall'}{literal} </p>'+
			   '<br/>'+
			   '<label for="twitter-email">{/literal}{l s='Your e-mail' mod='propack'}{literal}:</label>&nbsp;<input type="text" value="" id="twitter-email" name="twitter-email">'+
			   '<br/>'+
			   '<br/>'+
			   '<a class="button" onclick="update_twitter_email();return false;" value="{/literal}{l s='Send' mod='propack'}{literal}"><b>{/literal}{l s='Send' mod='propack'}{literal}</b></a>'
			   '';
    if ($('div#fb-con-wrapper').length == 0)				
	{					
		conwrapper = '<div id="fb-con-wrapper"><\/div>';		
		$('body').append(conwrapper);				
	}
	
	if ($('div#fb-con').length == 0)				
	{					
		condom = '<div id="fb-con"><\/div>';					
		$('body').append(condom);				
	}				

	$('div#fb-con').fadeIn(function(){	
				
		$(this).css('filter', 'alpha(opacity=70)');					
		$(this).bind('click dblclick', function(){						
		$('div#fb-con-wrapper').hide();						
		$(this).fadeOut();	
		});				
	});				

	$('div#fb-con-wrapper').html(data).fadeIn();
});

	function update_twitter_email(){
   	 $('#fb-con-wrapper').css('opacity',0.8);

	var twemail = $('#twitter-email').val();
    $.post(baseDir+'modules/propack/twupdate.php', 
    			{cid:'{/literal}{$propackcid}{literal}',
				 email:twemail 
    			 }, 
    function (data) {
    	if (data.status == 'success') {

    		$('#fb-con-wrapper').html('');
    		$('#fb-con-wrapper').html('<br/><p>'+data.params.content+'</p><br/>');
    		$('#fb-con-wrapper').css('opacity',1);
    	} else {
    		$('#fb-con-wrapper').css('opacity',1);
    		alert(data.message);
    		
    	}
    }, 'json');
    
  	 

    }
    
	{/literal}
	
{if $propackis16 != 1}
{literal}
	// ]]>

{/literal}
{/if}
{literal}
--></script>
{/literal}

<!--  show popup for twitter customer which not changed email address  -->
{/if}

{/if}




{if $propackis15 == 0}
<link href="{$base_dir}modules/propack/css/referrals.css" rel="stylesheet" type="text/css" media="all" />
{/if} 




<!--  for create vouchers by Storeprestamodules - http://storeprestamodules.com -->


{if $propackfbrefon == 1}
{literal}
<script type="text/javascript" src="{/literal}{$propackfbliburl}{literal}"></script>
{/literal}

{/if}

{literal}
<script type="text/javascript">
{/literal}
{if $propackis16 != 1}	
{literal}
<!--
//<![CDATA[
{/literal}
{/if}
{literal}

  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
  {/literal}
		
  {if $propackis16 != 1}
  {literal}
  	// ]]>
  -->
  {/literal}
  {/if}
  {literal} 
</script>
{/literal}

{if $propackis_soc_ref == 0}
{literal}
	<script type="text/javascript">
	{/literal}
		{if $propackis16 != 1}	
		{literal}
		<!--
		//<![CDATA[
		{/literal}
		{/if}
		{literal}
			
	   //Twitter Widgets JS
	     window.twttr = (function (d,s,id) {
	         var t, js, fjs = d.getElementsByTagName(s)[0];
	         if (d.getElementById(id)) return; js=d.createElement(s); js.id=id;
	         js.src="//platform.twitter.com/widgets.js"; fjs.parentNode.insertBefore(js, fjs);
	          return window.twttr || (t = { _e: [], ready: function(f){ t._e.push(f) } });
	          }(document, "script", "twitter-wjs"));

	     {/literal}
	  			
	  		{if $propackis16 != 1}
	  		{literal}
	  			// ]]>
	  		-->
	  		{/literal}
	  		{/if}
	  		{literal}	            
</script>
{/literal}        
{/if}

{if $propacktwrefon == 1 && $propackis_soc_ref == 0}
{literal}
	<script type="text/javascript">
	{/literal}
		{if $propackis16 != 1}	
		{literal}
		<!--
		//<![CDATA[
		{/literal}
		{/if}
		{literal}
			
	   

         		twttr.ready(function(twttr) {       
                twttr.events.bind('tweet', function (event) {
                	addRemoveDiscount('twitter');
                });
	            }); 
         		{/literal}
         			
             		{if $propackis16 != 1}
             		{literal}
             			// ]]>
             		-->
             		{/literal}
             		{/if}
             		{literal}	            
	</script>
{/literal}
{/if}


{literal}
                <script type="text/javascript">
                {/literal}
                	{if $propackis16 != 1}	
                	{literal}
                	<!--
                	//<![CDATA[
                	{/literal}
                	{/if}
                	{literal}
                	                
                {/literal}{if $propackgrefon == 1}{literal}
                function doGoogle(object)
            	{
                	if (object.state  == 'on')
            	    {
            	    	addRemoveDiscount('google');
            	    }
            	}
                {/literal}
                 {/if}
                	{if $propackfbrefon == 1}
                {literal}
                
				function share_facebook(){
					if (typeof(FB) != 'undefined' && FB != null ){
				        FB.ui({
				        method: 'feed',
				        name: '{/literal}{$propackname|escape:"html":"UTF-8"}{literal}',
				        link: '{/literal}{$propackurl}{literal}',
				        picture: '{/literal}{$propackimg}{literal}',
				        description: '{/literal}{$propackdescription|escape:"html":"UTF-8"}{literal}'
				        },
				        function(response) {
				            if (response && response.post_id) {
				           		addRemoveDiscount('facebook');
				            }
				        });
				        } else {
				            alert("{/literal}{l s='No Facebook APP, define own APP ID to use this feature' mod='propack'}{literal}");
				        }
				}
            	
                {/literal}{/if}{literal}


	            {/literal}{if $propacklrefon == 1}{literal}
		            
		          function doLinkedIn(response)
	            	{
	                  	addRemoveDiscount('linkedin');
	            	}
	            	
	            {/literal}{/if}{literal}

	            
	            	
                function addRemoveDiscount(data_type){
                 	 $('#facebook-fan-coupon-block').css('opacity',0.5);
                	  $.ajax({			
                      		type: 'POST',			
                      		url: baseDir+'modules/propack/process.php',			
                      		async: true,			
                      		//cache: false,			
                      		data: 'type='+data_type+'&id_product={/literal}{$propackid_product}{literal}',			
                      		success: function(data)			
                      		{	
                		  		  $('#facebook-fan-coupon-block').css('opacity',1);
                		  		  if(data.length==0) return;
		                    		  if ($('div#fb-con-wrapper').length == 0)				
		            	        		{					
		            	        			conwrapper = '<div id="fb-con-wrapper" class="'+data_type+'-block"><\/div>';		
		            	        			$('body').append(conwrapper);				
		            	        		}
		            	        		
		            	        		if ($('div#fb-con').length == 0)				
		            					{					
		            						condom = '<div id="fb-con"><\/div>';					
		            						$('body').append(condom);				
		            					}				
		
		            					$('div#fb-con').fadeIn(function(){	
		            								
		            						$(this).css('filter', 'alpha(opacity=70)');					
		            						$(this).bind('click dblclick', function(){						
		            						$('div#fb-con-wrapper').remove();						
		            						$(this).fadeOut();	
		            						window.location.reload();
		            						});				
		            					});				
		
		            					$('div#fb-con-wrapper').html(data).fadeIn();
									
		                          }		

                  		});

                  }

                {/literal}
                	
                    {if $propackis16 != 1}
                    {literal}
                    	// ]]>
                    -->
                    {/literal}
                    {/if}
                    {literal}             
              
		</script>
		{/literal}


<!--  for create vouchers by Storeprestamodules - http://storeprestamodules.com -->