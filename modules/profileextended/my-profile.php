<?php

/*
* 2007-2012 PrestaShop 
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
*         DISCLAIMER   *
* *************************************** */
/* Do not edit or add to this file if you wish to upgrade Prestashop to newer
* versions in the future.
* ****************************************************
* @category   Belvg
* @package    Belvg_UserProfileExtended
* @copyright  Copyright (c) 2010 - 2012 BelVG LLC. (http://www.belvg.com)
* @license    http://store.belvg.com/BelVG-LICENSE-COMMUNITY.txt
*/

/*
/* SSL Management */
$useSSL = true;
//error_reporting(E_ALL | E_STRICT);
include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/../../header.php');
require_once dirname(__FILE__) . '/BelvgProfileExtended.php';

if (empty($cookie->id_customer)) header('Location: ' . __PS_BASE_URI__);

$errors = array();

$url = 'my-profile.php';

if (!isset($_GET['action'])) $_GET['action'] = '';
if (!isset($_GET['err'])) $_GET['err'] = '';

		if (isset($_GET['id']) && $_GET['action'] == 'attr_del' && (int)$_GET['id'] > 0)
		{	
			Belvg::deleteAttributeValues((int)$_GET['id'], (int)$cookie->id_customer);
			header('Location: '.$url);
		}
		
		if (isset($_POST['action'], $_POST['id']) && $_POST['action'] == 'save' && $_POST['id'])
		{
			$error = Belvg::saveAttributeValues($_POST, $_FILES, (int)$cookie->id_customer);
			if ($error === 0) header('Location: '.$url.'?err=no');
			else header('Location: '.$url.'?err='.$error);
		}		

			$output = Belvg::getAttributeValuesForm((int)$cookie->id_customer, $url.'?', __PS_BASE_URI__ . 'img/admin/', false);

		if ((int)$_GET['err'] > 0)
			$smarty->assign('error', (int)$_GET['err']);
		else $smarty->assign('error', '');
		if ($_GET['err'] == 'no')
			$smarty->assign('ok', Belvg::l('Your personal information has been successfully updated.'));
		else $smarty->assign('ok', '');	
		
	$smarty->assign('content', $output);

	if (Tools::file_exists_cache(_PS_THEME_DIR_.'modules/profileextended/my-profile.tpl'))
		$smarty->display(_PS_THEME_DIR_.'modules/profileextended/my-profile.tpl');
	elseif (Tools::file_exists_cache(dirname(__FILE__).'/my-profile.tpl'))
		$smarty->display(dirname(__FILE__).'/my-profile.tpl');
	else
		echo Tools::displayError('No template found');

include(dirname(__FILE__).'/../../footer.php');


