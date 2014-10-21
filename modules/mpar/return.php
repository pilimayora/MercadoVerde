<?php
/**
* Captura retorno de MercadoPago
*
* @author    Kijam.com <info@kijam.com>
* @copyright 2014 Kijam.com
* @license   Comercial
*/

include(dirname(__FILE__).'/../../config/config.inc.php');
include(_PS_ROOT_DIR_.'/init.php');
include(dirname(__FILE__).'/mpar.php');

if (Tools::getValue('external_reference') && Tools::getValue('collection_status'))
{
	if (Tools::getValue('collection_status') == 'null')
	{
		Tools::redirect('cart.php');
		exit;
	}
	$id_cart = (int)Tools::getValue('external_reference');
	$cart = new Cart($id_cart);
	$id_order = Order::getOrderByCartId($id_cart);
	if ($id_order > 0)
	{
		$order = new Order($id_order);
		$mpar = new Mpar();
		$customer = new Customer((int)$cart->id_customer);
		if (_PS_VERSION_ >= '1.5')
			Tools::redirect('index.php?controller=order-confirmation&id_cart='.$cart->id.'&id_module='.$mpar->id.'&id_order='.$order->id.'&key='.$customer->secure_key);
		else
			Tools::redirect('order-confirmation.php?id_cart='.$cart->id.'&id_module='.$mpar->id.'&id_order='.$order->id.'&key='.$customer->secure_key);
		exit;
	}
}
if (_PS_VERSION_ >= '1.5')
	Tools::redirect('index.php?controller=history');
else
	Tools::redirect('history.php');
