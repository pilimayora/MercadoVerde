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

class googlewidgethelp{
	public function getItem($_data = null){
		
		
		$sql = '
			SELECT pc.*
			FROM `'._DB_PREFIX_.'google_widget` pc';
			
			
			$item = Db::getInstance()->ExecuteS($sql);
			
			$googlewigdet = isset($item[0]['content'])?$item[0]['content']:'';
			$googlewigdet = json_decode($googlewigdet);
			
			
			
	   return array('item' => $googlewigdet);
	}
	
	
	public function updateItem($data = null){
		
		
		// delete data
		$sql = 'DELETE FROM `'._DB_PREFIX_.'google_widget`';
		$result = Db::getInstance()->Execute($sql);
		
		$content = $data['content'];
		
		// insert new data
		$sql = 'INSERT into `'._DB_PREFIX_.'google_widget` SET
							   `content` = "'.mysql_escape_string($content).'"
							   ';
		$result = Db::getInstance()->Execute($sql);
		
	}
	
}