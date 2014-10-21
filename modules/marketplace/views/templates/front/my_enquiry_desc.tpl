<style>
	#center_column {
		width:757px !important;
	}
</style>
<span id="my_bulk_buy_query">My Marketplace Query</span>
<span id="back"><a id="back_button" href="{$link->getModuleLink('marketplace', 'my_queries')}">back</a><input type="hidden" value="{$base_dir}" id="base_url" /></span>
	<div class="view_enq">
	   
		   <div id="info">
			 <div class="info_part"><span class="head">Product Name:</span><span class="info_ans">{$product_name}</span></div>
			 <div class="info_part"><span class="head">Title:</span><span class="info_ans">{$title}</span></div>
			 <div class="info_part"><input type="button" name="reply" value="Reply" id="reply" /><span id="result_text"></span></div>
		  </div>
	      <div id="info_desc"><span>Description:</span><p>{$description}</p></div>
	</div>
	

	<div id="send_mail">
		<textarea id="mail_data" cols="90" rows=5"></textarea>
		<input type="button" name="send_email" value="Send Mail" id="send_email" />
		<input type="hidden" name="id_info" value="{$query_id}" id="id_info" />
		<input type="hidden" name="id_cus" value="{$seller_customer_id}" id="id_cus" />
	</div>	  
{assign var=j value=0}
	 {while $j != $count}
	
		
		
	 
	 {if $query_records[$j]['from'] == $my_id}
	    <div id="nego_data"><span>Me:</span><p>{$query_records[$j]['description']}</p></div>
		 
	 {else}
		 <div id="nego_data"><span>Seller:</span><p>{$query_records[$j]['description']}</p></div>
	 {/if}
		
		 
		
	
		  {assign var=j value=$j+1} {/while}
<script type="text/javascript">

$(document).ready(function() {

var url= $('#base_url').val();
var current_url = '{$my_queries_link}';
$('#back_button').attr('href',current_url)

			$('#reply').click(function() {
			$('#send_mail').slideDown('fast');
			$('#reply').css('display','none');
			});
			
			$('#send_email').click(function() {
			var mail_data = $("#mail_data").val();
			var id_info = $('#id_info').val();
			var id_cus = $('#id_cus').val();
			var my_id = {$my_id};
			
				$.ajax({
								type: 'GET',
								url: baseDir+'modules/marketplace/mail_send_seller.php',
								async: true,
								
								data: 'mail_data='+mail_data+'&id_info='+id_info+'&send_by='+my_id+'&send_to='+id_cus+'',
								
								cache: false,
								success: function(data)
								{
							
									if(data == 1)
									{
									
									$('#result_text').css('display','block');
									$('#result_text').text("Mail Send");
									$('#result_text').fadeOut(10000);
									$('#status_result').text("Negotiation");
									$('#negotiate').removeAttr("disabled");
									$('#send_mail').slideUp('slow');
									$('#mail_data').attr('value','');
									$('#reply').css('display','block');
									
									}
								}
								});
			
			});
});
</script>		 
