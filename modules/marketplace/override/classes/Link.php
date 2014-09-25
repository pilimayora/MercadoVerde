<?php

class Link extends LinkCore
{
	public function getModuleLink($module, $controller = 'default', array $params = array(), $ssl = null, $id_lang = null, $id_shop = null)
	{
		if (!$id_lang)
			$id_lang = Context::getContext()->language->id;

		$url = $this->getBaseLink($id_shop, $ssl).$this->getLangLink($id_lang, null, $id_shop);
		
		// If the module has its own route ... just use it !
		if (Dispatcher::getInstance()->hasRoute('module-'.$module.'-'.$controller, $id_lang, $id_shop))
			return $this->getPageLink('module-'.$module.'-'.$controller, $ssl, $id_lang, $params);
		else	
		{
			// Set available keywords
			$params['module'] = $module;
			$params['controller'] = $controller ? $controller : 'default';	
			if (Configuration::get('PS_REWRITING_SETTINGS'))
			{
				if(isset($params['shop']))
				{
					$params['shop'] = $params['shop'];
					if(isset($params['l']))
						$params['l'] = $params['l'];
					else
						$params['l'] ='';
						
					if(isset($params['shop_name']))
						$params['shop_name'] = $params['shop_name'];
					else
						$params['shop_name'] ='';
						
					return $url.Dispatcher::getInstance()->createUrl('mp_shop_rule', $id_lang, $params, $this->allow, '', $id_shop);
				}
			}
			return $url.Dispatcher::getInstance()->createUrl('module', $id_lang, $params, $this->allow, '', $id_shop);
		}
	}
}