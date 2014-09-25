<h3>{l s='Product Detail' mod='marketplace'}</h3>
{foreach $order_info as $ord_info}
	<div class="main_pro_div">
		<div class="pro_div"><span class="order_span">{l s='Ordered:' mod='marketplace'}</span><span class="order_span1">{$ord_info['product_name']}</span></div>
		<div class="pro_div"><span class="order_span">{l s='Quantity:' mod='marketplace'}</span><span class="order_span1">{$ord_info['product_quantity']}</span></div>
		<div class="pro_div"><span class="order_span">{l s='Price:' mod='marketplace'}</span><span class="order_span1">{$order_currency}{$ord_info['total_price_tax_incl']|string_format:"%.2f"}</span></div>
	</div>
{/foreach}