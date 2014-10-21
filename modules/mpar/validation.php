<?php
/**
* Capturador de IPN
*
* @author    Kijam.com <info@kijam.com>
* @copyright 2014 Kijam.com
* @license   Comercial
*/

header('Content-type: text/plain');

include(dirname(__FILE__).'/../../config/config.inc.php');
include(_PS_ROOT_DIR_.'/init.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);
include(dirname(__FILE__).'/mpar.php');

$mpar = new Mpar();

if (empty(Mpar::$mpar_client_id) || empty(Mpar::$mpar_client_secret))
	die('Modulo no instalado');

if (!Tools::getValue('id'))
	die('ID Desconocido');

$result = $mpar->validateMercadoPago(Tools::getValue('id'));

if ($result['status'] && $result['order_id'])
{
	$id_cart = (int)$result['order_id'];
	$cart = new Cart($id_cart);
	if (!Validate::isLoadedObject($cart))
		exit;

	$customer = new Customer((int)$cart->id_customer);
	$status_act = $result['status'];

	$id_order = Order::getOrderByCartId($id_cart);
	$currency = new Currency((int)$cart->id_currency);

	if ($id_order > 0)
	{
		$order = new Order($id_order);
		$order->setCurrentState($status_act);
	}
	else
		$mpar->validateOrder($id_cart, $status_act, $cart->getOrderTotal(true, Cart::BOTH),
								$mpar->displayName, 'Monto Total cobrado: '.round($mpar->get_rate(Tools::strtoupper($result['currency_id']), Tools::strtoupper($currency->iso_code)) * (float)$result['price'], 2).
								' '.$currency->iso_code.(Tools::strtoupper($result['currency_id']) != Tools::strtoupper($currency->iso_code)?', El cliente pago con '.Tools::strtoupper($result['currency_id']).
								' y esto puede generar comisiones adicionales debido a que se hace conversiones de moneda.':'').
								"\n\nResultado del IPN:\n".$result['message'], array(),
								null, false, $customer->secure_key);

	if (!Validate::isLoadedObject($order))
		$order = new Order(Order::getOrderByCartId($id_cart));

	if (Validate::isLoadedObject($order))
		Db::getInstance()->Execute('INSERT INTO `'._DB_PREFIX_.'mpar` (id_order, mp_op_id, status, next_retry)
						VALUES
						(".$order->id.", \''.pSQL(Tools::getValue('id')).'\', '.$order->getCurrentState().', '.(time() + 6 * 60 * 60).')');
}
