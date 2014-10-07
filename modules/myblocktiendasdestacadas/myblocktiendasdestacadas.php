<?php
if (!defined('_PS_VERSION_'))
	exit;

class MyBlockTiendasDestacadas extends Module 
{
	public function __construct()
	{
		$this->name = 'myblocktiendasdestacadas';
		$this->tab = 'content_management';
		$this->version = '1.0';
		$this->author = 'Pili Mayora';
		$this->need_instance = 0;

		parent::__construct();

		$this->displayName = $this->l('Tiendas destacadas');
		$this->description = $this->l('Seccion del homepage con tiendas destacadas');

		$this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
	}

	public function install() 
	{
		return parent::install() &&
			$this->registerHook('home') &&
			$this->registerHook('homeTab') &&
			$this->registerHook('header');
	}

	public function uninstall()
	{
		return parent::uninstall();
	}

	public function hookDisplayHome()
	{		
		return $this->display(__FILE__, 'myblocktiendasdestacadas.tpl');
	}

	public function hookDisplayHomeTab()
	{		
		return $this->display(__FILE__, 'myblocktiendasdestacadas.tpl');
	}

	public function hookDisplayHeader()
	{
		$this->context->controller->addCSS($this->_path.'css/myblocktiendasdestacadas.css', 'all');
	}
}
?>