<?php
if (!defined('_PS_VERSION_'))
	exit;

class MyBlockSellos extends Module 
{
	public function __construct()
	{
		$this->name = 'myblocksellos';
		$this->tab = 'content_management';
		$this->version = '1.0';
		$this->author = 'Pili Mayora';
		$this->need_instance = 0;

		parent::__construct();

		$this->displayName = $this->l('Sellos de sustentabilidad');
		$this->description = $this->l('Descripcion del significado de los sellos de sustentabilidad en el homepage');

		$this->confirmUninstall = $this->l('Are you sure you want to uninstall?');		
	}

	public function install() 
	{
		return parent::install() &&
			$this->registerHook('home') &&
			$this->registerHook('header') &&
			$this->registerHook('topColumn');
	}

	public function uninstall()
	{
		return parent::uninstall() && 
			Configuration::deleteByName('MYBLOCKSELLOS_NAME');
	}

	public function hookDisplayHome()
	{		
		return $this->display(__FILE__, 'myblocksellos.tpl');
	}

	public function hookDisplayTopColumn()
	{		
		return $this->display(__FILE__, 'myblocksellos.tpl');
	}

	public function hookDisplayHeader()
	{
		$this->context->controller->addCSS($this->_path.'css/myblocksellos.css', 'all');
	}
}
?>