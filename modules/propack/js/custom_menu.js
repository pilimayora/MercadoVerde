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

function PageNav( page ){

		$('#reviews-admin').css('opacity',0.5);
		var request_uri = $('#request_uri').val();
		
		$.post('../modules/propack/ajax.php', 
					{action:'pagenav',
					 page:page,
					 request_uri:request_uri
					 }, 
		function (data) {
			if (data.status == 'success') {

				$('#reviews-admin').css('opacity',1);
				
				$('#reviews-admin').html('');
				var content = $('#reviews-admin').prepend(data.params.content);
		    	$(content).hide();
		    	$(content).fadeIn('slow');

		    	
								
			} else {
				alert(data.message);
			}
		}, 'json');
	}

function delete_img(item_id){
	
	if(confirm("Are you sure you want to remove this item ?"))
	{
	$('#post_images_list').css('opacity',0.5);
	$.post('../modules/propack/ajax.php', {
		action:'deleteimg',
		item_id : item_id
	}, 
	function (data) {
		if (data.status == 'success') {
		$('#post_images_list').css('opacity',1);
		$('#post_images_list').html('');
			
		} else {
			$('#post_images_list').css('opacity',1);
			alert(data.message);
		}
		
	}, 'json');
	}

}

function tabs_custom(id){
	
	for(i=0;i<100;i++){
		$('#tab-menu-'+i).removeClass('selected');
	}
	$('#tab-menu-'+id).addClass('selected');
	for(i=0;i<100;i++){
		$('#tabs-'+i).hide();
	}
	$('#tabs-'+id).show();
}

function init_tabs(id){
	$('document').ready( function() {
		for(i=0;i<100;i++){
			$('#tabs-'+i).hide();
		}
		$('#tabs-'+id).show();
		tabs_custom(id);
	});
}

init_tabs(77);