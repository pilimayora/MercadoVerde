<?php
/**
* Modulo MercadoPago Argentina Pro
*
* @author    Kijam.com <info@kijam.com>
* @copyright 2014 Kijam.com
* @license   Comercial
*/

if (!defined('_PS_VERSION_'))
	exit;

require_once dirname(__FILE__).'/lib/mercadopagoar.php';

class Mpar extends PaymentModule
{
	public static $mpar_client_id;
	public static $mpar_client_secret;
	public static $mpar_fee;
	public static $mpar_sandbox_active;
	public static $mpar_modal_active;
	private static $mpar_validation_path;
	private static $mpar_bank_transfer_active;
	private static $currency_convert;
	private static $site_url;
	private static $mp;

	public function __construct()
	{
		$this->name = 'mpar';
		$this->tab = 'payments_gateways';
		$this->version = '3.0.5';
		$this->author = 'Kijam.com';
		$this->module_key = '529acf1abc2bd9b8772b9b42c46b47bb';

		parent::__construct();

		$this->displayName = $this->l('MercadoPago Argentina Pro');
		$this->description = $this->l('Plataforma de pago MercadoPago solo valido para Argentina');

		self::$site_url = Tools::htmlentitiesutf8((Configuration::get('PS_SSL_ENABLED') ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].__PS_BASE_URI__);
		self::$mpar_sandbox_active = (int)Configuration::get('MPAR_SANDBOX');
		self::$mpar_modal_active = (int)Configuration::get('MPAR_MODAL');
		self::$mpar_client_id = Configuration::get('MPAR_CLIENT_ID');
		self::$mpar_client_secret = Configuration::get('MPAR_CLIENT_SECRET');
		self::$mpar_fee = (float)Configuration::get('MPAR_FEE');
		self::$mpar_validation_path = Configuration::get('MPAR_VALIDATION');
		self::$mpar_bank_transfer_active = (int)Configuration::get('MPAR_BTRANSFER');
		self::$currency_convert = (array)Tools::jsonDecode(Configuration::get('currency_convert'), true);
		self::$mp = false;

		/* For 1.4.3 and less compatibility */
		$update_config = array('MPAR_OS_PENDING', 'MPAR_OS_AUTHORIZATION', 'MPAR_OS_REFUSED', 'PS_OS_CHEQUE', 'PS_OS_PAYMENT', 'PS_OS_PREPARATION', 'PS_OS_SHIPPING', 'PS_OS_CANCELED', 'PS_OS_REFUND', 'PS_OS_ERROR', 'PS_OS_OUTOFSTOCK', 'PS_OS_BANKWIRE', 'PS_OS_PAYPAL', 'PS_OS_WS_PAYMENT');
		foreach ($update_config as $u)
			if (!Configuration::get($u) && defined('_'.$u.'_'))
				Configuration::updateValue($u, constant('_'.$u.'_'));

		if (empty(self::$mpar_client_id) || empty(self::$mpar_client_secret))
			$this->warning = $this->l('Los campos client_id y client_secret son requeridos para validar los pagos');
		else
		{
			self::$mp = new MercadoPagoAR(self::$mpar_client_id, self::$mpar_client_secret);
			if (self::$mpar_sandbox_active)
				self::$mp->sandbox_mode(true);
		}

		//For updates...
		if (file_exists(dirname(__FILE__).'/validation.php') && !empty(self::$mpar_validation_path) && self::$mpar_validation_path != 'validation.php')
		{
			@rename(dirname(__FILE__).'/'.self::$mpar_validation_path, dirname(__FILE__).'/bk_'.time().'_'.self::$mpar_validation_path);
			@rename(dirname(__FILE__).'/validation.php', dirname(__FILE__).'/'.self::$mpar_validation_path);
		}

		/** Backward compatibility */
		require(_PS_MODULE_DIR_.$this->name.'/backward_compatibility/backward.php');
	}

	public function createOrderState()
	{
		if ((int)Configuration::get('MPAR_OS_AUTHORIZATION'))
		{
			$order_state = new OrderState((int)Configuration::get('MPAR_OS_AUTHORIZATION'));
			@unlink(dirname(__FILE__).'/../../img/os/'.(int)$order_state->id.'.gif');
			$order_state->delete();
		}

		if ((int)Configuration::get('MPAR_OS_PENDING'))
		{
			$order_state = new OrderState((int)Configuration::get('MPAR_OS_PENDING'));
			@unlink(dirname(__FILE__).'/../../img/os/'.(int)$order_state->id.'.gif');
			$order_state->delete();
		}

		if ((int)Configuration::get('MPAR_OS_REFUSED'))
		{
			$order_state = new OrderState((int)Configuration::get('MPAR_OS_REFUSED'));
			@unlink(dirname(__FILE__).'/../../img/os/'.(int)$order_state->id.'.gif');
			$order_state->delete();
		}

		$order_state = new OrderState();
		$order_state->name = array();

		foreach (Language::getLanguages() as $language)
		{
			$order_state->name[$language['id_lang']] = $this->l('Pago aceptado en MercadoPago AR');
			$order_state->template[$language['id_lang']] = 'payment';
		}

		$order_state->send_email = true;
		$order_state->color = '#00FF00';
		$order_state->hidden = false;
		$order_state->delivery = true;
		$order_state->logable = true;
		$order_state->invoice = true;
		$order_state->template = 'payment';
		if ($order_state->add())
		{
			$source = dirname(__FILE__).'/img/state_ms_1.gif';
			$destination = dirname(__FILE__).'/../../img/os/'.(int)$order_state->id.'.gif';
			@copy($source, $destination);
		}
		Configuration::updateValue('MPAR_OS_AUTHORIZATION', (int)$order_state->id);

		$order_state = new OrderState();
		$order_state->name = array();

		foreach (Language::getLanguages() as $language)
			$order_state->name[$language['id_lang']] = $this->l('Pago pendiente en MercadoPago AR');

		$order_state->send_email = false;
		$order_state->color = '#DDEEFF';
		$order_state->hidden = false;
		$order_state->delivery = false;
		$order_state->logable = false;
		$order_state->invoice = false;

		if ($order_state->add())
		{
			$source = dirname(__FILE__).'/img/state_ms_2.gif';
			$destination = dirname(__FILE__).'/../../img/os/'.(int)$order_state->id.'.gif';
			@copy($source, $destination);
		}
		Configuration::updateValue('MPAR_OS_PENDING', (int)$order_state->id);

		$order_state = new OrderState();
		$order_state->name = array();

		foreach (Language::getLanguages() as $language)
		{
			$order_state->name[$language['id_lang']] = $this->l('Pago rechazado en MercadoPago AR');
			$order_state->template[$language['id_lang']] = 'order_canceled';
		}

		$order_state->send_email = true;
		$order_state->color = '#FF0000';
		$order_state->hidden = false;
		$order_state->delivery = false;
		$order_state->logable = false;
		$order_state->invoice = false;
		if ($order_state->add())
		{
			$source = dirname(__FILE__).'/img/state_ms_3.gif';
			$destination = dirname(__FILE__).'/../../img/os/'.(int)$order_state->id.'.gif';
			@copy($source, $destination);
		}
		Configuration::updateValue('MPAR_OS_REFUSED', (int)$order_state->id);

		return true;
	}

	private function generateRandomString($length)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_';
		$random_string = '';
		for ($i = 0; $i < $length; $i++)
			$random_string .= $characters[rand(0, Tools::strlen($characters) - 1)];

		return $random_string;
	}

	public function install()
	{
		if (!function_exists('curl_version'))
		{
			$this->_errors[] = $this->l('No se encontro Curl instalado');
			return false;
		}

		$validation_rand = $this->generateRandomString(12);
		$validation_name = 'validation-'.$validation_rand.'.php';
		if (!@rename(dirname(__FILE__).'/validation.php', dirname(__FILE__).'/'.$validation_name))
			$validation_name = 'validation.php';

		$db_created = Db::getInstance()->Execute('CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'mpar` (
				`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
				`id_order` INT(11) NOT NULL,
				`id_shop` INT(11) NOT NULL,
				`mp_op_id` varchar(100) NOT NULL,
				`status` INT(11) NOT NULL,
				`next_retry` INT(11) NOT NULL,
				UNIQUE(mp_op_id),
				INDEX(id_order),
				INDEX(id_shop),
				INDEX(next_retry, status)
				)');

		if (!$db_created)
			$this->_errors[] = $this->l('No se pudo crear la tabla en la Base de Datos');

		$result = $db_created && parent::install()
			&& $this->registerHook('orderConfirmation')
			&& $this->registerHook('payment')
			&& (_PS_VERSION_ < '1.5'?$this->registerHook('header'):$this->registerHook('displayHeader'))
			&& Configuration::updateValue('MPAR_VALIDATION', $validation_name);

		if (!$result && $db_created)
			Db::getInstance()->Execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'mpar`');

		if (!$result && $validation_name != 'validation.php')
			@rename(dirname(__FILE__).'/'.$validation_name, dirname(__FILE__).'/validation.php');

		if ($result)
			$this->createOrderState();

		return $result;
	}

	public function uninstall()
	{
		if ((int)Configuration::get('MPAR_OS_AUTHORIZATION'))
		{
			$order_state = new OrderState((int)Configuration::get('MPAR_OS_AUTHORIZATION'));
			@unlink(dirname(__FILE__).'/../../img/os/'.(int)$order_state->id.'.gif');
			$order_state->delete();
		}

		if ((int)Configuration::get('MPAR_OS_PENDING'))
		{
			$order_state = new OrderState((int)Configuration::get('MPAR_OS_PENDING'));
			@unlink(dirname(__FILE__).'/../../img/os/'.(int)$order_state->id.'.gif');
			$order_state->delete();
		}

		if ((int)Configuration::get('MPAR_OS_REFUSED'))
		{
			$order_state = new OrderState((int)Configuration::get('MPAR_OS_REFUSED'));
			@unlink(dirname(__FILE__).'/../../img/os/'.(int)$order_state->id.'.gif');
			$order_state->delete();
		}

		Configuration::deleteByName('MPAR_OS_AUTHORIZATION');
		Configuration::deleteByName('MPAR_OS_PENDING');
		Configuration::deleteByName('MPAR_OS_REFUSED');
		Configuration::deleteByName('MPAR_SANDBOX');
		Configuration::deleteByName('MPAR_MODAL');
		Configuration::deleteByName('MPAR_CLIENT_ID');
		Configuration::deleteByName('MPAR_CLIENT_SECRET');
		Configuration::deleteByName('MPAR_FEE');
		Configuration::deleteByName('MPAR_VALIDATION');
		Configuration::deleteByName('MPAR_BTRANSFER');

		if (self::$mpar_validation_path)
			@rename(dirname(__FILE__).'/'.self::$mpar_validation_path, dirname(__FILE__).'/validation.php');

		Db::getInstance()->Execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'mpar`');
		return (parent::uninstall());
	}

	public function hookDisplayHeader($params)
	{
		return $this->hookHeader($params);
	}

	public function hookHeader($params)
	{
		$valid = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
						SELECT * FROM `'._DB_PREFIX_.'mpar`
						WHERE `next_retry` < '.time().' AND `status` = '.Configuration::get('MPAR_OS_PENDING'));

		foreach ($valid as &$pago)
		{
			$order = new Order($pago['id_order']);
			if (Validate::isLoadedObject($order))
			{
				if ($order->getCurrentState() == $pago['status'])
				{
					$result = $this->validateMercadoPago($pago['mp_op_id']);
					if (isset($result['status']))
					{
						if ($result['status'] != $order->getCurrentState())
						{
							$order->setCurrentState($result['status']);
							$message = new Message();
							$message->id_customer = (int)$order->id_customer;
							$message->message = $result['message'];
							$message->id_order = (int)$order->id;
							$message->private = true;
							$message->add();
						}
					}
				}
				Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'mpar` SET `next_retry` = '.(time() + 6 * 60 * 60).', `status` = '.$order->getCurrentState().' WHERE id = '.$pago['id']);
			}
		}
		return '';
	}

	public function hookOrderConfirmation($params)
	{
		if (!$this->active)
			return;

		if ($params['objOrder']->module != $this->name)
			return;

		switch ($params['objOrder']->getCurrentState())
		{
			case Configuration::get('MPAR_OS_AUTHORIZATION'):
				$this->context->smarty->assign(array('status' => 'ok', 'id_order' => $params['objOrder']->id));
				break;
			case Configuration::get('MPAR_OS_PENDING'):
				$this->context->smarty->assign(array('status' => 'pending', 'id_order' => $params['objOrder']->id));
				break;
			default:
				$this->context->smarty->assign('status', 'failed');
				break;
		}

		return $this->display(__FILE__, 'views/templates/hook/hookorderconfirmation.tpl');
	}

	private function preProcess()
	{
		if (Tools::isSubmit('submitModule'))
		{
			self::$mpar_client_id = Tools::getValue('client_id');
			self::$mpar_client_secret = Tools::getValue('client_secret');
			self::$mpar_fee = (float)Tools::getValue('fee');
			self::$mpar_sandbox_active = (int)Tools::getValue('sandbox');
			self::$mpar_modal_active = (int)Tools::getValue('modal');
			self::$mpar_bank_transfer_active = (int)Tools::getValue('btransfer');

			Configuration::updateValue('MPAR_CLIENT_ID', self::$mpar_client_id);
			Configuration::updateValue('MPAR_CLIENT_SECRET', self::$mpar_client_secret);
			Configuration::updateValue('MPAR_FEE', self::$mpar_fee);
			Configuration::updateValue('MPAR_SANDBOX', self::$mpar_sandbox_active);
			Configuration::updateValue('MPAR_MODAL', self::$mpar_modal_active);
			Configuration::updateValue('MPAR_BTRANSFER', self::$mpar_bank_transfer_active);

			return '<div class="conf confirm"><img src="../img/admin/ok.gif"/>'.$this->l('Configuracion Actualizada').'</div>';
		}
		return '';
	}

	public function get_rate($from, $to)
	{
		if ($from == $to)
			return 1;

		if (isset(self::$currency_convert[$from]) 
				&& isset(self::$currency_convert[$from][$to])
				&& self::$currency_convert[$from][$to]['time'] > time() - 60 * 60 * 12)
					return (float)self::$currency_convert[$from][$to]['rate'];

		$headers = array(
				'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
				'Host:download.finance.yahoo.com',
				'Connection:keep-alive',
				'Connection:keep-alive',
				'User-Agent:Mozilla/5.0 (Windows NT 6.3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36'
			);

		$ch = curl_init('http://download.finance.yahoo.com/d/quotes.csv?e=.csv&f=l1&s='.$from.$to.'=X');
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		$result = curl_exec($ch);
		self::$currency_convert[$from][$to]['time'] = time();
		self::$currency_convert[$from][$to]['rate'] = (float)$result;

		Configuration::updateValue('currency_convert', Tools::jsonEncode(self::$currency_convert));

		return self::$currency_convert[$from][$to]['rate'];		
	}

	public function validateMercadoPago($mp_op_id = false)
	{
		if (!$mp_op_id)
			return false;

		try
		{
			$payment_info = self::$mp->get_payment_info($mp_op_id);
		}
		catch (Exception $e)
		{
			return false;
		}

		$fp = fopen(dirname(__FILE__).'/log_mp.txt', 'a');
		fwrite($fp, '##MSG##'.print_r($payment_info, true).'##MSG##\n\n\n\n');
		fclose($fp);

		if (isset($payment_info['response']) && isset($payment_info['response']['collection']))
			$payment_info = $payment_info['response']['collection'];

		$ret = array();
		if (!isset($payment_info['status']) || !isset($payment_info['order_id']))
			$ret['errors'][] = 'Error: '.print_r($payment_info, true);
		else
		{
			switch ($payment_info['status'])
			{
				case 'approved':
					$status_act = Configuration::get('MPAR_OS_AUTHORIZATION');
					break;
				case 'refunded':
				case 'cancelled':
				case 'rejected':
					$status_act = Configuration::get('MPAR_OS_REFUSED');
					break;
				default:
					$status_act = Configuration::get('MPAR_OS_PENDING');
					break;
			}

			$fee = ((float)self::$mpar_fee) / 100.0;
			$ret['price'] = ((float)$payment_info['total_paid_amount']) - ((float)$payment_info['total_paid_amount']) * ((float)$fee);
			$ret['currency_id'] = $payment_info['currency_id'];
			$ret['status'] = $status_act;
			$ret['order_id'] = (int)$payment_info['order_id'];
			$ret['message'] = Tools::jsonEncode($payment_info).'\n';
		}
		return $ret;
	}

	private function _displayPresentation()
	{
		$out = '
		<fieldset class="width">
			<legend><img src="../img/admin/contact.gif" />'.$this->l('Obtener una cuenta Mercado Pago - Argentina').'</legend>
			<p>
				'.$this->l('Para obtener una cuenta en mercado pago venezuela haga click en el siguiente enlace:')
				.' <a href="https://www.mercadopago.com/mla/registration" class="link" target="_blank" >&raquo; '.$this->l('Link').' &laquo;</a>
			</p>
		</fieldset>';
		return $out;
	}

	public function getContent()
	{
		$str = $this->preProcess();

		$str .= '<h2>'.$this->displayName.'</h2>'
		.$this->_displayPresentation()
		.'<br />
		<form action="'.Tools::htmlentitiesutf8($_SERVER['REQUEST_URI']).'" method="post">
			<fieldset class="width">
				<legend><img src="../img/admin/contact.gif" />'.$this->l('Configuracion').'</legend>
				<label>'.$this->l('Client_id').' <sup>*</sup></label>
				<div class="margin-form">
					<input type="text" size="20" name="client_id" value="'.Tools::safeOutput(self::$mpar_client_id).'" />
					<p><a href="https://www.mercadopago.com/mla/herramientas/aplicaciones" target="_blank">'.$this->l('Busque esta informacion aquí').'</a></p>
				</div>
				<br class="clear" style="clear:both" />
				<label>'.$this->l('Client_secret').' <sup>*</sup></label>
				<div class="margin-form">
					<input type="text" size="20" name="client_secret" value="'.Tools::safeOutput(self::$mpar_client_secret).'" />
					<p><a href="https://www.mercadopago.com/mla/herramientas/aplicaciones" target="_blank">'.$this->l('Busque esta informacion aquí').'</a></p>
				</div>
				<br class="clear" style="clear:both" />
				<label>'.$this->l('Cobrar un % de comision al cliente por usar MercadoPago:').' <sup>*</sup></label>
				<div class="margin-form">
					<input type="text" size="20" name="fee" value="'.Tools::htmlentitiesUTF8(self::$mpar_fee).'" />
					<p>Solo valor decimal, ejemplo: 6.99</p>
				</div>
				<br class="clear" style="clear:both" />
				<label><span style="color:red !important;">'.$this->l('CAMBIAR').'</span> '.$this->l('URL de Estado de los pagos por:').' <sup>*</sup></label>
				<div class="margin-form">
					<p>'.self::$site_url.'modules/'.$this->name.'/'.self::$mpar_validation_path.'</p>
					<p><a href="https://www.mercadopago.com/mla/herramientas/notificaciones" target="_blank">'.$this->l('Cambie esta informacion aquí').'</a></p>
				</div>
				<br class="clear" style="clear:both" />
				<label>'.$this->l('Permitir Transferencias/Depositos Bancarios como Metodo de Pago Usando Mercadopago').' <sup>*</sup></label>
				<div class="margin-form">
					<p><select name="btransfer"><option value="0">No</option><option value="1" '.(self::$mpar_bank_transfer_active?'selected':'').'>Si</option></select></p>
				</div>
				<br class="clear" style="clear:both" />
				<label>'.$this->l('Ventana Modal (Al hacer click en "Pagar" la ventana de MercadoPago se abre sobre la Misma Pagina)').' <sup>*</sup></label>
				<div class="margin-form">
					<p><select name="modal"><option value="0">No</option><option value="1" '.(self::$mpar_modal_active?'selected':'').'>Si</option></select></p>
				</div>
				<br class="clear" style="clear:both" />
				<label>'.$this->l('Modo de Prueba').' <sup>*</sup></label>
				<div class="margin-form">
					<p><select name="sandbox"><option value="0">Desactivado</option><option value="1" '.(self::$mpar_sandbox_active?'selected':'').'>Activo</option></select></p>
					<p>
						<p>De acuerdo al medio de pago que utilices, puedes generar que el pago simulado se informe con un estado determinado.</p>
						<p>Elige entre diferentes medios de pago y genera una respuesta determinada:</p>
						<ul class="bulleted">
							<li>
								<p><strong>Dinero en cuenta:</strong> El monto de dinero en cuenta es fijo. No se agota si lo usas en más de un pago y tampoco afecta tu saldo real.</p>
								<p>Para probar, ingresa cualquier clave y el estado será: <b>approved</b>.</p>
							</li>
							<li>
								<p><strong>Tarjetas de crédito:</strong> Puedes usar cualquier código de seguridad.</p>
								<p>Para probar, elige una de las siguientes tarjetas de acuerdo al estado que quieras obtener:</p>
								<ul class="squared">
									<li><p>Visa Nº 4444444444440008: <b>approved</b>.</p></li>
									<li><p>Mastercard Nº 5031111111116601: <b>pending</b>.</p></li>
								</ul>
							</li>
							<li>
								<p><strong>Boleto, depósito o cupón:</strong></p>
								<p>Al probar, obtendrás el estado: <b>pending</b>.</p>
							</li>
						</ul>
					</p>
				</div>
				<br /><center><input type="submit" name="submitModule" value="'.$this->l('Actualizar Configuracion').'" class="button" /></center>
			</fieldset>
		</form>';
		return $str;
	}

	public function hookPayment($params)
	{
		if (self::$mpar_fee === false || self::$mp === false)
			return '';

		$currency = new Currency((int)$params['cart']->id_currency);
		//$lang = new Language((int)$params['cart']->id_lang);
		$customer = new Customer((int)$params['cart']->id_customer);
		$address = new Address((int)$params['cart']->id_address_invoice);
		//$country = new Country((int)$address->id_country, (int)$params['cart']->id_lang);
		//$products = $params['cart']->getProducts();
		$fee = 100.0 / (100.0 - (float)self::$mpar_fee);

		//$url = (_PS_VERSION_ < '1.5') ? 'order-confirmation.php' : 'index.php?controller=order-confirmation';
		$params['cart']->getOrderTotal(true, Cart::BOTH);
		$preference_data = array(
			'items' => array(
				array(
					'id' => $params['cart']->id,
					'title' => "Carrito No: {$params['cart']->id} - ".$address->firstname.' '.$address->lastname,
					'quantity' => 1,
					'currency_id' => $currency->iso_code,
					'unit_price' => $fee * $params['cart']->getOrderTotal(true, Cart::BOTH)
				)
			),
			'back_urls' => array(
				'success'=> self::$site_url.'modules/'.$this->name.'/return.php',
				'failure'=> self::$site_url.'modules/'.$this->name.'/return.php',
				'pending'=> self::$site_url.'modules/'.$this->name.'/return.php'
			),

			'external_reference' => $params['cart']->id,
			'payer'=> array(
				'email' => $customer->email,
				'name' =>  $customer->firstname.' '.$customer->lastname
			)
		);
		if (!self::$mpar_bank_transfer_active)
		{
			$preference_data['payment_methods']['excluded_payment_types'][] = array('id' => 'bank_transfer');
			$preference_data['payment_methods']['excluded_payment_types'][] = array('id' => 'atm');
			$preference_data['payment_methods']['excluded_payment_types'][] = array('id' => 'ticket');
		}

		$mpar_params = array();

		try
		{
			$preference = self::$mp->create_preference($preference_data);
		}
		catch(Exception $error)
		{
			$mpar_params['error'] = $this->l('Error conectando a MercadoPago: ').print_r($error, true);
		}

		$mpar_params['price']		= $fee * $params['cart']->getOrderTotal(true, Cart::BOTH);
		$mpar_params['item_id']		= $params['cart']->id;
		$mpar_params['back_url']	= self::$site_url.'modules/'.$this->name.'/return.php';
		$mpar_params['modal']		= self::$mpar_modal_active;
		$mpar_params['init_point']	= self::$mpar_sandbox_active?$preference['response']['sandbox_init_point']:$preference['response']['init_point'];

		$this->context->smarty->assign($mpar_params);
		$this->context->smarty->assign('fee', self::$mpar_fee);
		$this->context->smarty->assign('feeTotal', $mpar_params['price'] - $params['cart']->getOrderTotal(true, Cart::BOTH));
		$this->context->smarty->assign('newPrice', $mpar_params['price']);
		return $this->display(__FILE__, 'views/templates/hook/mpar.tpl');
	}
}
