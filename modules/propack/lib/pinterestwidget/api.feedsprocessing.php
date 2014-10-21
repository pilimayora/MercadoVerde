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

class feedsProcessingAPI{
    
	public $simplePie;
    
    public $timeout;

    public $cacheLocation;

    public $cacheSeconds;

    public $error;

    public $feed;

    public $autodiscover;

    public $items;

    function __construct(){
        
        $this->timeout = 10;
        $this->cacheLocation = _PS_ROOT_DIR_ . "/upload/pinterestwidget/cache/";
        $this->cacheSeconds = 1;
        $this->feed = array();
        $this->items = array();

        require_once dirname(__FILE__)."/simplepie.php";

        $this->simplePie = new SimplePie();
    }

    function get($url, $number){
    	if (file_exists($this->cacheLocation)){
        
            if (is_writable($this->cacheLocation)) {

            	$this->simplePie->set_timeout($this->timeout);

                $this->simplePie->set_cache_location($this->cacheLocation);

                $this->simplePie->set_cache_duration($this->cacheSeconds);

                $this->simplePie->set_feed_url($url);

                if ($this->simplePie->init()){
                
                    $this->feed["copyright"] = $this->simplePie->get_copyright();

                    $this->feed["description"] = $this->simplePie->get_description();

                    $this->feed["language"] = $this->simplePie->get_language();

                    $this->feed["title"] = $this->simplePie->get_title();

                    $this->feed["link"] = $this->simplePie->get_link();

                    $this->items = $this->simplePie->get_items(0,$number);

                }else{

                    $this->error = 1;
                    
                    return false;
                }
            }else{

                $this->error = 2;
                
                return false;
            }
        }else{
        
            $this->error = 3;
            
            return false;
        }
        
        return true;
    }
}
?>
