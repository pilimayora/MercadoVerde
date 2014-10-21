<style>
.block .block-title {
    background: url("{$modules_dir}marketplace/img/bkg_block-title.gif") repeat-x scroll 0 0 transparent;
    border-bottom: 1px solid #DDDDDD;
    padding: 2px 9px;
}
.block-viewed .block-title strong {
    background-image: url("{$modules_dir}marketplace/img/i_block-viewed.gif");
}
.partnerdetails {
    background: none repeat scroll 0 0 #F4F3F3;
    height: auto;
    padding: 4px;
}

.partnerlinks {
    float: none !important;
}
ul, ol {
    list-style: none outside none;
}
ul.partnerlinks li {
    font-size: 12px;
    padding: 2px 0;
}
.partnerlinks li {
    float: none !important;
}

ul.partnerlinks li a {
    text-decoration: none;
}
.partnerlinks li a {
    border: 0 none !important;
    float: none !important;
}
a {
    color: #1E7EC8;
    text-decoration: underline;
}
#fbconnect {
    background-image: url("{$modules_dir}marketplace/img/fb.png");
}
#twconnect, #fbconnect {
    display: inline-block;
    height: 35px;
    width: 35px;
}
ul.partnerlinks li a {
    text-decoration: none;
}
.partnerlinks li a {
    border: 0 none !important;
    float: none !important;
}


#twconnect {
    background-image: url("{$modules_dir}marketplace/img/tw.png");
}
#twconnect, #fbconnect {
    display: inline-block;
    height: 35px;
    width: 35px;
}
#ask-data {
    background-clip: padding-box;
    background-color: #FFFFFF;
    border: 1px solid rgba(0, 0, 0, 0.3);
    border-radius: 6px 6px 6px 6px;
    box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
    display: none;
    left: 50%;
    margin: -250px 0 0 -280px;
    outline: medium none;
    position: fixed;
    top: 50%;
    width: 530px;
    z-index: 1050;
}
.modal-header {
    background-color: #F5F5F5;
    border-bottom: 1px solid #EEEEEE;
    border-radius: 4px 4px 0 0;
    padding: 9px 15px;
}
.modal-header h3 {
    display: inline-block;
    font-size: 20px;
    opacity: 0.6;
}
h3 {
    font-size: 16px;
    font-weight: bold;
}
h1, h2, h3, h4, h5, h6 {
    color: #0A263C;
    line-height: 1.35;
    margin: 0 0 5px;
}
.wk-close {
    color: #000000;
    cursor: pointer;
    float: right;
    font-size: 20px;
    font-weight: bold;
    line-height: 20px;
    opacity: 0.2;
    text-shadow: 0 1px 0 #FFFFFF;
}
#ask-form {
    display: inline-block;
    margin-top: 20px;
}
#ask-data .label {
    display: inline-block;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 7px;
    padding-left: 20px;
    text-align: left;
    width: 80px;
}
#ask-form input, .group-select select, #ask-form textarea {
    background-color: #FFFFFF;
    border: 1px solid #CCCCCC;
    border-radius: 4px 4px 4px 4px;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
    color: #555555;
    display: inline-block;
    font-size: 14px;
    height: 20px;
    line-height: 20px;
    margin-bottom: 10px;
    padding: 4px 6px;
    transition: border 0.2s linear 0s, box-shadow 0.2s linear 0s;
    vertical-align: top;
}
#ask-data input {
    height: 30px;
    margin-bottom: 10px;
    width: 315px;
}
input, select, textarea, button {
    color: #2F2F2F;
    font: 12px/15px Arial,Helvetica,sans-serif;
    vertical-align: middle;
}

#ask-form textarea {
    height: 75px;
    width: 313px;
}
.modal-footer:before, .modal-footer:after {
    content: "";
    display: table;
    line-height: 0;
}
.modal-footer {
    background-color: #F5F5F5;
    border-radius: 0 0 6px 6px;
    border-top: 1px solid #DDDDDD;
    box-shadow: 0 1px 0 #FFFFFF inset;
    margin-bottom: 0;
    margin-top: 10px;
    padding-bottom: 50px;
    text-align: right;
}
#ask-data .error1 {
    bottom: 15px;
    display: none;
    left: 170px;
    position: absolute;
}
.error1 {
    color: #DF280A;
    font-weight: bold;
}
#ask-data #askbtn, #ask-data #resetbtn {
    float: right;
    height: 30px;
    margin: 10px 23px 0 0;
    width: 80px;
}
#ask-data #askbtn:hover{ 
background-color:#E6E6E6;
cursor:pointer;
}
#ask-data #resetbtn:hover{
background-color:#E6E6E6;
cursor:pointer;
}
.error1-border {
    border-color: #FF0000 !important;
}
textarea {
    overflow: auto;
}
input.input-text, textarea {
    padding: 2px;
}

.mail-procss{
opacity: 0.5;cursor:wait;
}
.hc-name {
font-weight: normal 1important;
}
.wk-block-hover-div
{
	background: none repeat scroll 0 0 #FFFFFF;
    display: none;
    left: -485px;
    min-height: 120px;
    position: absolute;
    top: -35px;
    width: 420px;
    z-index: 9;
    border: 1px solid #BCE8F1;
    border-radius: 4px 4px 4px 4px;
    margin-bottom: 20px;
    padding: 8px 35px 8px 14px;
    text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
}
.wk-block-hover-div .arrow
{
	height: 23px;
    position: absolute;
    right: -17px;
    top: 31px;
    width: 50px;
}


.wk-block-hover-div:after, .wk-block-hover-div:before {
    border: 1px solid transparent;
    content: " ";
    height: 0;
    left: 100%;
    position: absolute;
    width: 0;
}
.wk-block-hover-div:after {
border-left-color: #FFFFFF;border-width: 7px;top: 36px;
}
.wk-block-hover-div:before {
order-left-color: #BCE8F1;border-width: 10px;top: 34px;
}
.profile-view{
position:relative;
}
.profile-view:hover .wk-block-hover-div,.wk-block-hover-div .arrow:hover{
display:block;
}.collection-view {	position:relative;}.collection-view:hover .wk-block-hover-div,.wk-block-hover-div .arrow:hover {	display:block;}
#ask-data
{
	background-clip: padding-box;
    background-color: #FFFFFF;
    border: 1px solid rgba(0, 0, 0, 0.3);
    border-radius: 6px 6px 6px 6px;
    box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
    left: 50%;
    margin: -250px 0 0 -280px;
    outline: medium none;
    position: fixed;
    top: 50%;
    width: 530px;
    z-index: 1050;
	display:none;
}
#askque{
cursor:pointer;
}
.wk-close
{
	color: #000000;
    float: right;
    font-size: 20px;
    font-weight: bold;
    line-height: 20px;
    opacity: 0.2;
    text-shadow: 0 1px 0 #FFFFFF;
	cursor: pointer;
}
.wk-close:hover{
opacity:1;
}
#ask-data .label
{
	display: inline-block;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 7px;
    padding-left: 20px;
    text-align: left;
    width: 80px;
}
#ask-data input{
height: 30px;margin-bottom: 10px;width: 315px;
}
#ask-data #askbtn,#ask-data #resetbtn
{
	float: right;
    height: 30px;
    margin: 10px 23px 0 0;
    width: 80px;
}

.error1-border{
border-color:#ff0000 ! important;
}
#ask-form input,.group-select select,
#ask-form textarea{
	background-color: #FFFFFF;
	border: 1px solid #CCCCCC;
	box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
	transition: border 0.2s linear 0s, box-shadow 0.2s linear 0s;
	border-radius: 4px 4px 4px 4px;
	color: #555555;
	display: inline-block;
	font-size: 14px;
	height: 20px;
	line-height: 20px;
	margin-bottom: 10px;
	padding: 4px 6px;
	vertical-align: top;
}
#ask-form textarea{
height: 75px;width: 313px;
}
#askbtn,#resetbtn{
	-moz-border-bottom-colors: none;
	-moz-border-left-colors: none;
	-moz-border-right-colors: none;
	-moz-border-top-colors: none;
	background-color: #F5F5F5;
	background-image: linear-gradient(to bottom, #FFFFFF, #E6E6E6);
	background-repeat: repeat-x;
	border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #A2A2A2;
	border-image: none;
	border-radius: 4px 4px 4px 4px;
	border-style: solid;
	border-width: 1px;
	box-shadow: 0 1px 0 rgba(255, 255, 255, 0.2) inset, 0 1px 2px rgba(0, 0, 0, 0.05);
	color: #333333;
	cursor: pointer;
	display: inline-block;
	font-size: 14px;
	line-height: 20px;
	margin-bottom: 0;
	padding: 4px 12px;
	text-align: center;
	text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
	vertical-align: middle;
	float:right;
}
#ask-form input[type="text"]:focus,#ask-form textarea:focus{
border-color: rgba(82, 168, 236, 0.8);box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset, 0 0 8px rgba(82, 168, 236, 0.6);	outline: 0 none;
}
#askbtn:hover,#resetbtn:hover{
    background-color: #E6E6E6;
    background-position: 0 -15px;
    color: #333333;
    text-decoration: none;
    transition: background-position 0.1s linear 0s;
}
#askbtn:focus,#resetbtn:focus{
outline: thin dotted #333333;outline-offset: -2px;
}
#askbtn.active,#askbtn.active {
    background-color: #E6E6E6;
    background-image: none;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15) inset, 0 1px 2px rgba(0, 0, 0, 0.05);
    outline: 0 none;
}
#ask-form{
display:inline-block;margin-top:20px;
}
.row-info {
	float: left; 
	padding-bottom: 4px;
    padding-left: 3%;  
	width: 97%;
}
.row-info .label {
	padding-top:5px;
	color: {$prof_color};
    font-size: {$prof_size}px;
	font-family:{$prof_font_family};
	float:left;	width:30%;
}
.row-info .label-info {
	float:left;
	width:70%;
}
.row-info .label1 {
	padding-top:5px;
	color: #666666; 
	font-size: 15px;
	font-family:{$prof_font_family};
	float:left;	width:35%;
}
.row-info .label-info1 {
	float:left;	
	width:64%;
}
</style>

<div id="idTab2">
	<div class="block-content">
		<div class="partnerdetails" style="width:100%;float: left;">
			<div class="sellerinfo" style="float:left;width:71%;">
				<div class="row-info">
					<div class="label1">Seller Name : </div>
						<div class="label-info1">{$mkt_seller_info['seller_name']}</div>
					</div>
					<div class="row-info">
						<div class="label1">Shop Name : </div>
						<div class="label-info1">{$mkt_seller_info['shop_name']}</div>	
					</div>
					<div class="row-info">
						<div class="label1">Seller email : </div>
						<div class="label-info1">{$seller_email}</div>
					</div>
					<div class="row-info">
						<div class="label1">Phone : </div>
						<div class="label-info1">{$mkt_seller_info['phone']}</div>
						</div>
					</div>	
					<div class="sellerlink" style="float:right;width:27%;border-left: 2px solid black;">
						<ul class="partnerlinks">
							<li class="profile-view">
								<a id="profileconnect" title="Visit Profile" href="{$link_profile}">View Profile</a>
								<div class="wk-block-hover-div">
									<div class="row-info">
										<div class="label">{l s='Seller Name' mod='marketplace'} : </div>
										<div class="label-info">
											{$mkt_seller_info['seller_name']}
										</div>
									</div>
									<div class="row-info">
										<div class="label">{l s='Shop Name' mod='marketplace'} : </div>
										<div class="label-info">{$mkt_seller_info['shop_name']}</div>
									</div>
									<div class="row-info">
										<div class="label">{l s='Seller email' mod='marketplace'} : </div>
										<div class="label-info">{$seller_email}</div>
									</div>	
									<div class="row-info">
										<div class="label">{l s='Phone' mod='marketplace'} : </div>
										<div class="label-info">{$mkt_seller_info['phone']}</div>
									</div>	
								</div>
							</li> 
							<li class="collection-view1">
								<a id="siteconnect" title="Visit Complete Collection" href="{$link_collection}">{l s='View Collection' mod='marketplace'}</a>
								<div class="wk-block-hover-div"></div>
							</li>
							<li>
								<a id="storeconnect" title="Visit Store" href="{$link_store}">{l s='View Store' mod='marketplace'}</a>
							</li>
							<li class="ask-que">
								<a href="#" id="askque" title="Ask Que">{l s='Ask Que' mod='marketplace'}</a>
							</li>
							<li>
								<a id="fbconnect" title="Link Up With Facebook" href="http://www.facebook.com/{$facebook_id}" target="_blank"> </a>	
								<a id="twconnect" title="Link Up With Twitter" href="http://www.twitter.com/{$twitter_id}" target="_blank"></a>
							</li>	
						</ul>	
					</div>	
				</div>
			</div>
		</div>
		<div id="ask-data" style="display: none;">
		<div class="modal-header">
		<h3>{l s='Ask Question to me' mod='marketplace'}..</h3>
		<span class="wk-close">x</span>
		<span style="clear: both;"/>
		</div>

		<form id="ask-form" method="post">
		
		<span class="label">{l s='Email' mod='marketplace'} :</span><input type="text" name="email" id="email_address" class="queryemail"/>
		<span class="label">{l s='Subject' mod='marketplace'} :</span><input type="text" name="subject" class="querysubject"/>
		<span class="label">{l s='Ask ' mod='marketplace'}:</span>
		<textarea name="ask" class="queryquestion"></textarea>
		<input type="hidden" name="product-name" value="{$product_name}"/>
		<input type="hidden" name="seller-id" value="{$seller_id}"/>
		<input type="hidden" name="seller-email" value="{$seller_email}"/>
		<input type="hidden" name="cust_id" value="{$cust_id}"/>
		<input type="hidden" name="product_id" value="{$id_product}"/>
		
		<div class="modal-footer">
		<span class="error1" style="display: inline;">{l s='Fill all the fields' mod='marketplace'}</span>
		<input type="reset" value="Reset" id="resetbtn"/>
		<input type="button" value="Ask" id="askbtn"/>
		<span style="clear: both;"/>
		</div>
		
		</form>
</div>






<script language="javascript" type="text/javascript">
	$("#email_address").focusout(function() {
		var email= $("#email_address").val();
		var mail =/^[a-zA-Z]*$/;
		var reg = /^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
		if(!reg.test(email)){         
			$(this).addClass('error1-border');
				$('#ask-form .error1').text('Enter Valid Email Address').slideDown('slow').delay(2000).slideUp('slow');	
		}
	});
	
	$(function(){
		$('#resetbtn').trigger('click');
		$('#ask-form .error1').text('');
		$('#ask-form').delegate('input,textarea','focus',function(){
			$(this).removeClass('error1-border');
		});
		$('#product').append($('#ask-data'));
		$('.ask-que').click(function(){
			$('#ask-form input,#ask-form textarea').removeClass('error1-border');
			{*$('#page').css('opacity','0.4');*}
			$('#ask-data').show();
		});
		$('.wk-close').click(function(){
			$('#page').css('opacity','1');
			$('#resetbtn').trigger('click');
			$('#ask-data').hide();
		});
		
		$('#askbtn').click(function(){
			var f=0;
			var isError = false;
			var email= $("#email_address").val();
			var mail =/^[a-zA-Z]*$/;
			var reg = /^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
			if(!reg.test(email)){         
				isError = true;
			}
			if(isError==false) {
				$('#ask-form input,#ask-form textarea').each(function(){
					if($(this).val()==' ')
					{
						$(this).addClass('error1-border');
						f++;
					}
				});
				
				
				if(f>0) {
					$('#ask-form .error1').text('Fill all the fields').slideDown('slow').delay(2000).slideUp('slow');							
				}
				else {	
					$('#ask-data').addClass('mail-procss');
					$.ajax({
						url:'{$modules_dir}marketplace/mailsend.php',
						data:$('#ask-form').serialize(),
						type:'post',
						dataType:'json',
						success:function(d){
						
							$('#ask-data').removeClass('mail-procss')
							if(d == 1)
							{
								alert('mail send...');
								$('.wk-close,#resetbtn').trigger('click');
							}
							else
							{
							 
								alert ("There is some error in sending mail");
								$('#resetbtn').trigger('click');
								
							}
						}
					});
				
				}
			} else {
				$(this).addClass('error1-border');
				$('#ask-form .error1').text('Enter Valid Email Address').slideDown('slow').delay(2000).slideUp('slow');	
			}
		});
	
	});
</script>