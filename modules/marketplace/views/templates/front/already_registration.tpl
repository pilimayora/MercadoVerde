{if $login == 0}



<div id="update_sucess" style="border:1px solid #72CB67;width:100%;height:40px;background-color:#DFFAD3;">

<span class="sucess_msg" style="color:#383838;font-weight:bold;float:left;margin-top:10px;margin-left:10px;">{l s='You have to Login to make a Seller Request.' mod='marketplace'}</span>

</div>



{else}



		{if $is_seller== 0}

		

		<div id="update_sucess" style="border:1px solid #72CB67;width:100%;height:40px;background-color:#DFFAD3;">

		<span class="sucess_msg" style="color:#383838;font-weight:bold;float:left;margin-top:10px;margin-left:10px;">{l s='Your Request has been sent to Admin.Wait for the Approval from Admin' mod='marketplace'}</span>

		</div>

		

		{else}

		

		<div id="update_sucess" style="border:1px solid #72CB67;width:100%;height:40px;background-color:#DFFAD3;">

		<span class="sucess_msg" style="color:#383838;font-weight:bold;margin-top:10px;margin-left:10px;float:left;">{l s='You have already made a Seller Request and Approved by Admin. ' mod='marketplace'}<a href="{$new_link3}">Add Product</a></span>

		</div>

		

		{/if}





{/if}