<?php
/*
* 2007-2013 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2013 PrestaShop SA
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class Reviews extends ObjectModel
{
	public $id_review;
	public $id_seller;
	public $id_customer;
	public $customer_email;
	public $rating;
	public $review;
	public $timestamp;
	public $active;
	
 	 	 	 	 	 	 	
	/**
	 * @see ObjectModel::$definition
	 */
	public static $definition = array(
		'table' => 'seller_reviews',
		'primary' => 'id_review',
		'fields' => array(
			'id_seller' => 		array('type' => self::TYPE_INT),
			'id_customer' => 		array('type' => self::TYPE_INT),
			'customer_email' => 		array('type' => self::TYPE_INT)			
		),
	);
	
	
}