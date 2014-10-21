$('#mass_price_update_on').live('change',function(e) {
	var mass_price_update_on = $(this).val();
	if(mass_price_update_on==0) {
		$('#category_info').css('display','none');
	} else {
		$('#category_info').css('display','block');
	}
});

$('#mass_product_conform').live('click',function(e) {
	var mass_price_update_value = $('#mass_price_update_value').val();
	if(isNaN(mass_price_update_value)) {
		if(mass_price_update_value=='') {
			$('#error_show').html("Mass Price Update Value Is Mandatory Field");
		} else {
			$('#error_show').html("Mass Price Update Value Should Be Numeric");
		}
		$('#error_show').fadeIn(1000);
		$('#error_show').fadeOut(10000);
	} else{
		if(mass_price_update_value=='') {
			$('#error_show').html("Mass Price Update Value Is Mandatory Field");
			$('#error_show').fadeIn(1000);
			$('#error_show').fadeOut(10000);
		} else {
			$('#error_show').fadeOut(1000);
			$('#mass_product_conform').fadeOut(1000);
			$('#save_button').fadeIn(1000);
		}
	}
});