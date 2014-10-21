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
include_once(dirname(__FILE__).'/classes/reviewshelp.class.php');
$obj_reviewshelp = new reviewshelp();

$_name = "propack";

if(Configuration::get($_name.'reviewson')!=1)
	exit;

global $cookie;
$id_lang = (int)$cookie->id_lang;
$data_language = $obj_reviewshelp->getfacebooklib($id_lang);
$rss_title =  Configuration::get($_name.'rssname_snip_'.$id_lang);;
$rss_description =  Configuration::get($_name.'rssdesc_snip_'.$id_lang);;

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


if(Configuration::get($_name.'rsson_snip') == 1){

$createXML .= "<rss version=\"0.92\">\n";
$createXML .= "<channel>
	<title><![CDATA[".$rss_title."]]></title>
	<link>$rootURL</link>
	<description>".$rss_description."</description>
	<lastBuildDate>$latestBuild</lastBuildDate>
	<docs>http://backend.userland.com/rss092</docs>
	<language>".$data_language['rss_language_iso']."</language>
";

$data_rss_items = $obj_reviewshelp->getItemsForRSS();

//echo "<pre>"; var_dump($data_rss_items); exit;

foreach($data_rss_items['items'] as $_item)
{
	$page = $_item['page']; 
	$description = $_item['seo_description'];
	$title = $_item['title'];
	$img = $_item['img'];
	
	$createXML .= $obj_reviewshelp->createRSSFile($title,$description,$page, $img);
}
$createXML .= "</channel>\n </rss>";
// Finish it up
}

echo $createXML;















?>