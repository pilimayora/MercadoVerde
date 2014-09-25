<div style="height:650px;margin-left:60px;">
	<form action="{$payPro_link}" method="post" class="std" enctype="multipart/form-data" accept-charset="UTF-8,ISO-8859-1,UTF-16">
		<fieldset id="addproduct_fieldset">
		
			<p class="text">
				<label class="add_one" for="payment_mode">{l s='Payment Mode :' mod='marketplace'}</label>
				<select id="payment_mode" name="payment_mode" class="account_input">
					 {foreach $pay_mode as $pay_mode1}
					<option id="{$pay_mode1['id']}" value="{$pay_mode1['id']}">{$pay_mode1['payment_mode']}</option>
					 {/foreach}
				</select>
			</p>
			
			<p class="text">
				<label class="add_one" for="payment_detail">{l s='Payment Detail :' mod='marketplace'}</label>
				<span><textarea id="payment_detail" name="payment_detail" value="" class="account_input"></textarea></span>
			</p>
			
			<p class="text">
				<label class="add_one" for="payment_detail"></label>
				<span><input type="hidden" id="customer_id" name="customer_id" value="{$customer_id}" class="account_input"/></span>
			</p>
			
			<center>
			<input type="submit" id="SubmitProduct" name="SubmitCreate" class="button_large" value="{l s='Payment' mod='marketplace'}"/>
			</center>
		</fieldset>
	</form>
</div>