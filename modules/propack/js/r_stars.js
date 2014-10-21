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

var NUMBER_OF_STARS = 5;

function init_rating()
{
    var ratings = document.getElementsByTagName('div');
    for (var i = 0; i < ratings.length; i++)
    {
        if (ratings[i].className != 'rating')
            continue;
            
        var rating = ratings[i].firstChild.nodeValue;
       	put_stars(ratings[i], rating);
    }
}

function put_stars(div, rating)
{
	if (rating == null) return;
	
	while (div.childNodes.length > 0)
		div.removeChild(div.firstChild);

	if (rating > NUMBER_OF_STARS || rating < 0)
	    return;
	
	for (var j = 0; j < NUMBER_OF_STARS; j++)
	{
		var star_anchor = document.createElement('a');
		star_anchor.setAttribute('href', 'javascript:void(' + j + ')');
		
	    var star = document.createElement('img');
	    star.setAttribute('src', module_dir+'images/rstar1.png');
	    star.setAttribute('width', '15');
	    star.setAttribute('height', '22');
	    if (rating >= 1)
	    {
	        star.setAttribute('src', module_dir+'images/rstar1.png');
	        star.className = 'on';
	        star_anchor.className = 'star1';
	        rating--;
	    }
	    else if(rating == 0.5)
	    {
	        star.setAttribute('src', module_dir+'images/rstar1.png');
	        star.className = 'half';
	        star_anchor.className = 'star1';
	        rating = 0;
	    }
	    else
	    {
	        star.setAttribute('src', module_dir+'images/rstar2.png');
	        star.className = 'off';
	        star_anchor.className = 'star2';
	    }
	    
	    if (div.getAttribute('id') != null)
	    {
		    var widgetId = div.getAttribute('id').substr(7);
		    star.setAttribute('id', 'star_'+widgetId+'_'+(j+1));
		    div.appendChild(star_anchor);
		    star_anchor.appendChild(star)
	    }
	    else
	    {
		    div.appendChild(star);
	    }
	   
	}
}



var rating_checked = false;
var block_rating = 0;

function read_rating_review_shop(obj){
	 var rat = document.getElementById(obj);
	 rating_review_shop(obj,rat.value);
	}

	function rating_review_shop(obj,rating_value){
	  var _img;
	  //document.getElementById('error_rating').innerHTML = '';
	  //document.getElementById('ratingText').style.color = '#2F5997';
	  var rat = document.getElementById(obj);
	  //if(rating_value == 0) return;
	  rat.value = rating_value;
	  for(var i=1; i<=5; i++){
	   if(i<=rating_value){
	    _img = document.getElementById('img_'+obj+'_'+i);
	    _img.src = module_dir+'images/rating_star1.png';
	   }else{
	    _img = document.getElementById('img_'+obj+'_'+i);
	    _img.src = module_dir+'images/rating_star2.png';
	   }
	  }
	}

	function _rating_efect_rev(star,action,obj){
	 if(block_rating==0){
	  var _img;
	  clear_rating_rev(obj);
	   if(action==1){
	     for(var i=1; i<=5; i++){
		    _img = document.getElementById('img_'+obj+'_'+i);
		    _img.src = module_dir+'images/rating_star2.png';
	     }
	   }
	   else{
	     for(var i=1; i<=star; i++){
		    _img = document.getElementById('img_'+obj+'_'+i);
	        _img.src = module_dir+'images/rating_star1.png';
	     }
	   }
	 }
	}
	
function clear_rating_rev(obj){
	  var _img;
	  for(var i=1; i<=5; i++){
	    _img = document.getElementById('img_'+obj+'_'+i);
	    _img.src = module_dir+'images/rating_star2.png';
	  }
	}
loaded = true;

function trim(str) {
	   str = str.replace(/(^ *)|( *$)/,"");
	   return str;
	   }

