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

if (isset($_POST['action']) && $_POST['action'] == 'save')
{
	$title = addslashes(strip_tags($_POST['title']));
	$message = addslashes(strip_tags($_POST['message']));
	$res = Belvg::sendMessage($cookie->id_customer, $title, $message, 0, (count($_FILES['file'])>0 ? $_FILES['file'] : array()));
	if ($res) header('Location: ?err=no');
	else header('Location: ?err=yes');
}
if (isset($_GET['action'], $_GET['id']) && $_GET['action'] == 'delete' && (int)$_GET['id'] > 0)
{
	Belvg::enableMessage((int)$_GET['id'], $cookie->id_customer);
	header('Location: ?err=no');
}

$inbox = array();
$outbox = array();
$message = array();

		$inbox = Db::getInstance()->
		ExecuteS('SELECT * FROM '._DB_PREFIX_.'belvg_customerprofile_messages WHERE type = 1 AND enable != 1 AND customer_id = ' . $cookie->id_customer . ' ORDER BY id DESC');

		$outbox = Db::getInstance()->
		ExecuteS('SELECT * FROM '._DB_PREFIX_.'belvg_customerprofile_messages WHERE type = 0 AND enable != 1 AND customer_id = ' . $cookie->id_customer . ' ORDER BY id DESC');
		
		$smarty->assign('inbox', $inbox);
		$smarty->assign('outbox', $outbox);
	
if (isset($_GET['action'], $_GET['id']) && $_GET['action'] == 'read' && (int)$_GET['id'] > 0)
	{
		$message = Db::getInstance()->getRow('SELECT * FROM '._DB_PREFIX_.'belvg_customerprofile_messages WHERE id = ' . (int)$_GET['id'] . ' AND customer_id = ' . $cookie->id_customer);
		$smarty->assign('message', $message);
	}

if (Tools::file_exists_cache(_PS_THEME_DIR_.'modules/profileextended/my-messages.tpl'))
	$smarty->display(_PS_THEME_DIR_.'modules/profileextended/my-messages.tpl');
elseif (Tools::file_exists_cache(dirname(__FILE__).'/my-messages.tpl'))
	$smarty->display(dirname(__FILE__).'/my-messages.tpl');
else
	echo Tools::displayError('No template found');

include(dirname(__FILE__).'/../../footer.php');


