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

function go_page_blog(page,item_id){
	
	$('#list_reviews').css('opacity',0.5);
	$.post(baseDir + 'modules/propack/ajax.php', {
		action:'pagenav',
		page : page,
		item_id : item_id
	}, 
	function (data) {
		if (data.status == 'success') {
		
		$('#list_reviews').css('opacity',1);
		
		$('#list_reviews').html('');
		$('#list_reviews').prepend(data.params.content);
		
		$('#page_nav').html('');
		$('#page_nav').prepend(data.params.page_nav);
		
		
		
	    } else {
			$('#list_reviews').css('opacity',1);
			alert(data.message);
		}
		
	}, 'json');

}

function go_page_blog_comments(page,item_id){
	
	$('#blog-list-comments').css('opacity',0.5);
	$.post(baseDir + 'modules/propack/ajax.php', {
		action:'pagenavcomments',
		page : page,
		item_id : item_id
	}, 
	function (data) {
		if (data.status == 'success') {
		
		$('#blog-list-comments').css('opacity',1);
		
		$('#blog-list-comments').html('');
		$('#blog-list-comments').prepend(data.params.content);
		
		$('#page_nav').html('');
		$('#page_nav').prepend(data.params.page_nav);
		
		
		
	    } else {
			$('#blog-list-comments').css('opacity',1);
			alert(data.message);
		}
		
	}, 'json');

}


function trim(str) {
	   str = str.replace(/(^ *)|( *$)/,"");
	   return str;
	   }

function add_comment(id_post){
	
	
	var _name_review = $('#name-review').val();
	var _email_review = $('#email-review').val();
	var _text_review = $('#text-review').val();

	//clear errors
	$('#name-review').removeClass('error_testimonials_form');
	$('#email-review').removeClass('error_testimonials_form');
	$('#text-review').removeClass('error_testimonials_form');
	
	if(trim(_name_review).length == 0){
		$('#name-review').addClass('error_testimonials_form');
		alert("Please, enter the Name.");
		return;
	}
	
	if(trim(_email_review).length == 0){
		$('#email-review').addClass('error_testimonials_form');
		alert("Please, enter the Email.");
		return;
	}

	if(trim(_text_review).length == 0){
		$('#text-review').addClass('error_testimonials_form');
		alert("Please, enter the Message.");
		return;
	}
		
	$('#add-review-form').css('opacity','0.5');
	$.post(baseDir + 'modules/propack/ajax.php', 
			{action:'addcomment',
			 name:_name_review,
			 email:_email_review,
			 id_post:id_post,
			 text_review:_text_review
			 }, 
	function (data) {
		if (data.status == 'success') {

				$('#name-review').val('');
				$('#email-review').val('');
				$('#text-review').val('');

				$('#add-review-form').hide();
				$('#succes-review').show();
				
			
			
			$('#add-review-form').css('opacity','1');
			
			
		} else {
			
			var error_type = data.params.error_type;
			
			if(error_type == 1){
				$('#name-review').addClass('error_testimonials_form');
				alert("Please, enter the Name.");
			} else if(error_type == 2){
				$('#email-review').addClass('error_testimonials_form');
				alert("Please enter a valid email address. For example johndoe@domain.com.");
			} else if(error_type == 3){
				$('#text-review').addClass('error_testimonials_form');
				alert("Please, enter the Message.");
			} else {
				alert(data.message);
			}
			$('#add-review-form').css('opacity','1');
			
		}
	}, 'json');
}



