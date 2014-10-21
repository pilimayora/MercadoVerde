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

function return_default_img(type,text){
        	if(confirm(text))
        	{
        	if(type=="google")
        		$('#imageg').css('opacity',0.5);
        	if(type=="facebook")
        		$('#imagef').css('opacity',0.5);	
        	if(type=="paypal")
        		$('#imagep').css('opacity',0.5);	
        	if(type=="facebooksmall")
        		$('#imagefsmall').css('opacity',0.5);
        	if(type=="googlesmall")
        		$('#imagegsmall').css('opacity',0.5);
        	if(type=="paypalsmall")
        		$('#imagepsmall').css('opacity',0.5);	
        	if(type=="twittersmall")
        		$('#imaget').css('opacity',0.5);
        	if(type=="twittersmall")
        		$('#imagetsmall').css('opacity',0.5);	
        	if(type=="yahoosmall")
        		$('#imagey').css('opacity',0.5);
        	if(type=="yahoosmall")
        		$('#imageysmall').css('opacity',0.5);
        	if(type=="linkedin")
        		$('#imagel').css('opacity',0.5);
        	if(type=="linkedinsmall")
        		$('#imagelsmall').css('opacity',0.5);
        	if(type=="livejournal")
        		$('#imagelive').css('opacity',0.5);
        	if(type=="livejournalsmall")
        		$('#imagelivesmall').css('opacity',0.5);
        	if(type=="microsoft")
        		$('#imagem').css('opacity',0.5);
        	if(type=="microsoftsmall")
        		$('#imagemsmall').css('opacity',0.5);
        	if(type=="openid")
        		$('#imageo').css('opacity',0.5);
        	if(type=="openidsmall")
        		$('#imageosmall').css('opacity',0.5);
        	if(type=="clavid")
        		$('#imagec').css('opacity',0.5);
        	if(type=="clavidsmall")
        		$('#imagecsmall').css('opacity',0.5);
        	if(type=="flickr")
        		$('#imagefl').css('opacity',0.5);
        	if(type=="flickrsmall")
        		$('#imageflsmall').css('opacity',0.5);
        	if(type=="wordpress")
        		$('#imagew').css('opacity',0.5);
        	if(type=="wordpresssmall")
        		$('#imagewsmall').css('opacity',0.5);
        	if(type=="aol")
        		$('#imagea').css('opacity',0.5);
        	if(type=="aolsmall")
        		$('#imageasmall').css('opacity',0.5);
        	
        	
        	$.post('../modules/propack/ajax/admin_image.php', {
        		action:'returnimage',
        		type : type
        	}, 
        	function (data) {
        		if (data.status == 'success') {
        			
        			if(type=="yahoo"){
                		$('#imagey').css('opacity',1);
                		var count = Math.random();
            			document.getElementById('imagey').src = "";
            			document.getElementById('imagey').src = "../modules/propack/i/yahoo.png?re=" + count;
            			$('#imagey-click').remove();
        			}
        			if(type=="yahoosmall"){
                		$('#imageysmall').css('opacity',1);
                		var count = Math.random();
            			document.getElementById('imageysmall').src = "";
            			document.getElementById('imageysmall').src = "../modules/propack/i/yahoo-small.png?re=" + count;
            			$('#imagey-clicksmall').remove();
        			}
        			if(type=="twitter"){
                		$('#imaget').css('opacity',1);
                		var count = Math.random();
            			document.getElementById('imaget').src = "";
            			document.getElementById('imaget').src = "../modules/propack/i/twitter.png?re=" + count;
            			$('#imaget-click').remove();
        			}
        			if(type=="twittersmall"){
                		$('#imagetsmall').css('opacity',1);
                		var count = Math.random();
            			document.getElementById('imagetsmall').src = "";
            			document.getElementById('imagetsmall').src = "../modules/propack/i/twitter-small.png?re=" + count;
            			$('#imaget-clicksmall').remove();
        			}
        			if(type=="google"){
                		$('#imageg').css('opacity',1);
                		var count = Math.random();
            			document.getElementById('imageg').src = "";
            			document.getElementById('imageg').src = "../modules/propack/i/google.png?re=" + count;
            			$('#imageg-click').remove();
        			}
        			if(type=="googlesmall"){
                		$('#imagegsmall').css('opacity',1);
                		var count = Math.random();
            			document.getElementById('imagegsmall').src = "";
            			document.getElementById('imagegsmall').src = "../modules/propack/i/google-small.png?re=" + count;
            			$('#imageg-clicksmall').remove();
        			}
        			if(type=="facebook"){
                		$('#imagef').css('opacity',1);
                		var count = Math.random();
            			document.getElementById('imagef').src = "";
            			document.getElementById('imagef').src = "../modules/propack/i/facebook.png?re=" + count;
            			$('#imagef-click').remove();
        			}
        			if(type=="facebooksmall"){
                		$('#imagefsmall').css('opacity',1);
                		var count = Math.random();
            			document.getElementById('imagefsmall').src = "";
            			document.getElementById('imagefsmall').src = "../modules/propack/i/facebook-small.png?re=" + count;
            			$('#imagef-clicksmall').remove();
        			}
        			if(type=="paypal"){
                		$('#imagep').css('opacity',1);
                		var count = Math.random();
            			document.getElementById('imagep').src = "";
            			document.getElementById('imagep').src = "../modules/propack/i/paypal.png?re=" + count;
            			$('#imagep-click').remove();
        			}
        			
        			if(type=="paypalsmall"){
                		$('#imagepsmall').css('opacity',1);
                		var count = Math.random();
            			document.getElementById('imagepsmall').src = "";
            			document.getElementById('imagepsmall').src = "../modules/propack/i/paypal-small.png?re=" + count;
            			$('#imagep-clicksmall').remove();
        			}
        			
        			if(type=="linkedin"){
                		$('#imagel').css('opacity',1);
                		var count = Math.random();
            			document.getElementById('imagel').src = "";
            			document.getElementById('imagel').src = "../modules/propack/i/linkedin.png?re=" + count;
            			$('#imagel-click').remove();
        			}
        			
        			if(type=="linkedinsmall"){
                		$('#imagelsmall').css('opacity',1);
                		var count = Math.random();
            			document.getElementById('imagelsmall').src = "";
            			document.getElementById('imagelsmall').src = "../modules/propack/i/linkedin-small.png?re=" + count;
            			$('#imagel-clicksmall').remove();
        			}
        			
        			if(type=="livejournal"){
                		$('#imagelive').css('opacity',1);
                		var count = Math.random();
            			document.getElementById('imagelive').src = "";
            			document.getElementById('imagelive').src = "../modules/propack/i/livejournal.png?re=" + count;
            			$('#imagelive-click').remove();
        			}
        			
        			if(type=="livejournalsmall"){
                		$('#imagelivesmall').css('opacity',1);
                		var count = Math.random();
            			document.getElementById('imagelivesmall').src = "";
            			document.getElementById('imagelivesmall').src = "../modules/propack/i/livejournal-small.png?re=" + count;
            			$('#imagelive-clicksmall').remove();
        			}
        			
        			if(type=="microsoft"){
                		$('#imagem').css('opacity',1);
                		var count = Math.random();
            			document.getElementById('imagem').src = "";
            			document.getElementById('imagem').src = "../modules/propack/i/microsoft.png?re=" + count;
            			$('#imagem-click').remove();
        			}
        			
        			if(type=="microsoftsmall"){
                		$('#imagemsmall').css('opacity',1);
                		var count = Math.random();
            			document.getElementById('imagemsmall').src = "";
            			document.getElementById('imagemsmall').src = "../modules/propack/i/microsoft-small.png?re=" + count;
            			$('#imagem-clicksmall').remove();
        			}
        			
        			if(type=="openid"){
                		$('#imageo').css('opacity',1);
                		var count = Math.random();
            			document.getElementById('imageo').src = "";
            			document.getElementById('imageo').src = "../modules/propack/i/openid.png?re=" + count;
            			$('#imageo-click').remove();
        			}
        			
        			if(type=="openidsmall"){
                		$('#imageosmall').css('opacity',1);
                		var count = Math.random();
            			document.getElementById('imageosmall').src = "";
            			document.getElementById('imageosmall').src = "../modules/propack/i/openid-small.png?re=" + count;
            			$('#imageo-clicksmall').remove();
        			}
        			
        			if(type=="clavid"){
                		$('#imagec').css('opacity',1);
                		var count = Math.random();
            			document.getElementById('imagec').src = "";
            			document.getElementById('imagec').src = "../modules/propack/i/clavid.png?re=" + count;
            			$('#imagec-click').remove();
        			}
        			
        			if(type=="clavidsmall"){
                		$('#imagecsmall').css('opacity',1);
                		var count = Math.random();
            			document.getElementById('imagecsmall').src = "";
            			document.getElementById('imagecsmall').src = "../modules/propack/i/clavid-small.png?re=" + count;
            			$('#imagec-clicksmall').remove();
        			}
        			
        			if(type=="flickr"){
                		$('#imagefl').css('opacity',1);
                		var count = Math.random();
            			document.getElementById('imagefl').src = "";
            			document.getElementById('imagefl').src = "../modules/propack/i/flickr.png?re=" + count;
            			$('#imagefl-click').remove();
        			}
        			
        			if(type=="flickrsmall"){
                		$('#imageflsmall').css('opacity',1);
                		var count = Math.random();
            			document.getElementById('imageflsmall').src = "";
            			document.getElementById('imageflsmall').src = "../modules/propack/i/flickr-small.png?re=" + count;
            			$('#imagefl-clicksmall').remove();
        			}
        			
        			if(type=="wordpress"){
                		$('#imagew').css('opacity',1);
                		var count = Math.random();
            			document.getElementById('imagew').src = "";
            			document.getElementById('imagew').src = "../modules/propack/i/wordpress.png?re=" + count;
            			$('#imagew-click').remove();
        			}
        			
        			if(type=="wordpresssmall"){
                		$('#imagewsmall').css('opacity',1);
                		var count = Math.random();
            			document.getElementById('imagewsmall').src = "";
            			document.getElementById('imagewsmall').src = "../modules/propack/i/wordpress-small.png?re=" + count;
            			$('#imagew-clicksmall').remove();
        			}
        			
        			if(type=="aol"){
                		$('#imagea').css('opacity',1);
                		var count = Math.random();
            			document.getElementById('imagea').src = "";
            			document.getElementById('imagea').src = "../modules/propack/i/aol.png?re=" + count;
            			$('#imagea-click').remove();
        			}
        			
        			if(type=="aolsmall"){
                		$('#imageasmall').css('opacity',1);
                		var count = Math.random();
            			document.getElementById('imageasmall').src = "";
            			document.getElementById('imageasmall').src = "../modules/propack/i/aol-small.png?re=" + count;
            			$('#imagea-clicksmall').remove();
        			}
                	
        		} else {
        			if(type=="yahoo")
                		$('#imagey').css('opacity',1);
        			if(type=="yahoosmall")
                		$('#imageysmall').css('opacity',1);
        			if(type=="twitter")
                		$('#imaget').css('opacity',1);
        			if(type=="twittersmall")
                		$('#imagetsmall').css('opacity',1);
        			if(type=="google")
                		$('#imageg').css('opacity',1);
        			if(type=="googlesmall")
                		$('#imagegsmall').css('opacity',1);
        			if(type=="facebook")
                		$('#imagef').css('opacity',1);	
        			if(type=="paypal")
                		$('#imagep').css('opacity',1);	
        			if(type=="facebooksmall")
                		$('#imagefsmall').css('opacity',1);
        			if(type=="paypalsmall")
                		$('#imagepsmall').css('opacity',1);	
        			if(type=="linkedin")
                		$('#imagel').css('opacity',1);	
        			if(type=="linkedinsmall")
                		$('#imagelsmall').css('opacity',1);
        			if(type=="livejournal")
                		$('#imagelive').css('opacity',1);	
        			if(type=="livejournalsmall")
                		$('#imagelivesmall').css('opacity',1);
        			if(type=="microsoft")
                		$('#imagem').css('opacity',1);	
        			if(type=="microsoftsmall")
                		$('#imagemsmall').css('opacity',1);
        			if(type=="openid")
                		$('#imageo').css('opacity',1);	
        			if(type=="openidsmall")
                		$('#imageosmall').css('opacity',1);
        			if(type=="clavid")
                		$('#imagec').css('opacity',1);	
        			if(type=="clavidsmall")
                		$('#imagecsmall').css('opacity',1);
        			if(type=="flickr")
                		$('#imagefl').css('opacity',1);	
        			if(type=="flickrsmall")
                		$('#imageflsmall').css('opacity',1);
        			if(type=="wordpress")
                		$('#imagew').css('opacity',1);	
        			if(type=="wordpresssmall")
                		$('#imagewsmall').css('opacity',1);
        			if(type=="aol")
                		$('#imagea').css('opacity',1);	
        			if(type=="aolsmall")
                		$('#imageasmall').css('opacity',1);
        			
        			alert(data.message);
        		}
        		
        	}, 'json');
        	}

        }