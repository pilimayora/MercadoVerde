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

{if $propackis16 == 0}
{if $propackCOMMENTON == 1}
<li style="width:130px">
	{if $propackLOGOSWITCH == '1'}
		<img id="customefacebookcommentslogo" src="{$base_dir}/modules/propack/img/facebook.jpg" alt="{l s='Facebook logo' mod='propack'}" />{/if}
		
	<a href="#idTab22" id="idTabcustomefacebookcomments" 
		class="{if $propackFOCUS == '1'}selected{/if}">
			<fb:comments-count href="{$come_from}"></fb:comments-count>
		{l s='Comments' mod='propack'}</a>
</li>
{/if}

{/if}


{if $propackis16 == 0}
{if $propackblogon == 1}

{if $propacktab_blog_pr == 1}

{if count($propackcategories) > 0}
<li>
	<a href="#idTab999">{l s='Blog' mod='propack'}</a>
</li>
{/if}
{/if}
{/if}

{/if}


{if $propackreviewson == 1}

{if $propackis16 == 0}

<li>

	<a id="idTab666-my" href="#idTab666" class="idTabHrefShort">{l s='Reviews' mod='propack'} <span id="count-review-tab">({$nbReviews})</span></a>

</li>

{/if}

{literal}
<script type="text/javascript">
/*<![CDATA[*/

$(document).ready(function() {

    var ph = '<div id="review_block">'+
    		 '<div class="rating"  style="float: left; margin: 10px 10px 10px {/literal}{if $propackis16==1}{literal}110{/literal}{else}{literal}40{/literal}{/if}{literal}px;">{/literal}{$avg_rating}{literal}</div>'+
    		 '<div style="float: left; margin-top: 10px;font-size:12px;font-weight:bold"><span id="count_review_main">{/literal}{$nbReviews}{literal}</span> {/literal}{$textReview}{literal}</div>'+
    		 '<div style="clear:both"></div>'+
             '<a href="http://{/literal}{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}{literal}#idTab666" id="idTab666-my-click" class="greenBtnBig"><b {/literal}{if $propackis16==1}{literal}class="padding16-reviews"{/literal}{/if}{literal}>{/literal}{l s='Add review' mod='propack'}{literal}</b></a>'+
             '</div>';
    $('#short_description_block').after(ph);

    $('#idTab666-my-click').click(function(){
    	    
    	$.each($('#more_info_tabs li'), function(key, val) {
	        $(this).children().removeClass("selected");
	    });

    	$('#idTab666-my').addClass('selected');

    	for(i=0;i < $('#more_info_sheets').children().length;i++){
    		$('#more_info_sheets').children(i).addClass("block_hidden_only_for_screen");
    	}
        $('#idTab666').removeClass('block_hidden_only_for_screen');   

        $('.button-bottom-add-review').hide(200);
        $('#add-review-form').show(200);
        
    });

	});

	function show_form_review(par){
		if(par == 1){
			 $('.button-bottom-add-review').hide(200);
		     $('#add-review-form').show(200);
		} else {
			$('.button-bottom-add-review').show(200);
		     $('#add-review-form').hide(200);
		}
	}
/*]]>*/
</script>
{/literal}
{/if}



{if $propackpqon == 1}

{if $propackis16 == 0}
<li>
	<a href="#idTab777" id="idTab777-my">
		{l s='Questions' mod='propack'} <span id="count-questions-tab">({$propackcount_items})</span>
	</a>
	
</li>
{/if}

{literal}
<script type="text/javascript">
/*<![CDATA[*/

$(document).ready(function() {

    $('#idTab777-my-click').click(function(){
    	    
    	$.each($('#more_info_tabs li'), function(key, val) {
	        $(this).children().removeClass("selected");
	    });

    	$('#idTab777-my').addClass('selected');

    	for(i=0;i < $('#more_info_sheets').children().length;i++){
    		$('#more_info_sheets').children(i).addClass("block_hidden_only_for_screen");
    	}
        $('#idTab777').removeClass('block_hidden_only_for_screen');   

        $('#button-bottom-add-question').hide(200);
        $('#add-question-form').show(200);

        $('#succes-question').hide();
    });

});

function show_form_question(par){
	if(par == 1){
		 $('#button-bottom-add-question').hide(200);
	     $('#add-question-form').show(200);
	     $('#succes-question').hide();
	} else {
		$('#button-bottom-add-question').show(200);
	     $('#add-question-form').hide(200);
	}
}

function trim(str) {
	   str = str.replace(/(^ *)|( *$)/,"");
	   return str;
	   }

/*]]>*/
</script>
{/literal}



{/if}