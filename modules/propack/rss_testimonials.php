<?php
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

include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/../../init.php');
include_once(dirname(__FILE__).'/classes/shopreviews.class.php');
$shopreviews = new shopreviews();

$_name = "propack";
if(version_compare(_PS_VERSION_, '1.6', '>')){
$_http_host = Tools::getShopDomainSsl(true, true).__PS_BASE_URI__; 
} else {
$_http_host = _PS_BASE_URL_.__PS_BASE_URI__;
}

global $cookie;
$id_lang = (int)$cookie->id_lang;
$data_language = $shopreviews->getfacebooklib($id_lang);
$rss_title =  '<![CDATA['.Configuration::get('PS_SHOP_NAME').']]>';
$rss_description =  '<![CDATA['.Configuration::get('PS_SHOP_NAME').' Testimonials]]>';

if (Configuration::get('PS_SSL_ENABLED') == 1)
	$url = "https://";
else
	$url = "http://";

$site = $_SERVER['HTTP_HOST'];
			
// Lets build the page
$rootURL = $url.$site."/feeds/";
$latestBuild = date("r");

// Lets define the the type of doc we're creating.
$createXML = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";


if(Configuration::get($_name.'trssontestim') == 1){

$createXML .= "<rss version=\"0.92\">\n";
$createXML .= "<channel>
	<title>".$rss_title."</title>
	<link>$url$site</link>
	<description>".$rss_description."</description>
	<lastBuildDate>$latestBuild</lastBuildDate>
	<docs>http://backend.userland.com/rss092</docs>
	<language>".$data_language['rss_language_iso']."</language>
	<image>
			<title>".$rss_title."</title>
			<url>".$_http_host."img/logo.jpg</url>
			<link>$url$site</link>
	</image>
";

$data_rss_items = $shopreviews->getItemsForRSS();

//echo "<pre>"; var_dump($data_rss_items); exit;

foreach($data_rss_items['items'] as $_item)
{
	$page = $_item['page']; 
	$description = $_item['seo_description'];
	$title = $_item['title'];
	$pubdate = $_item['pubdate'];
	$createXML .= $shopreviews->createRSSFile($title,$description,$page,$pubdate);
}
$createXML .= "</channel>\n </rss>";
// Finish it up
}

echo $createXML;















?>