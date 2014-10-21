{*
* Hook - Confirmacion de Orden
* 
* @author    Kijam.com <info@kijam.com>
* @copyright 2014 Kijam.com
* @license   Comercial
*}
{if $status == 'ok'}
	<p>{l s='Tu pedido' mod='mpar'} <span class="bold">{$shop_name|escape:'htmlall':'UTF-8'}</span> {l s='fue procesada con exito.' mod='mpar'}
		<br /><br /><span class="bold">{l s='Si usted pago un envio a domicilio el pedido se le enviara lo mas pronto posible.' mod='mpar'}</span>
		<br /><br />{l s='Para cualquier duda o más información, por favor póngase en contacto con nuestro.' mod='mpar'} <a href="{$link->getPageLink('contact', true)}">{l s='Atencion al Cliente' mod='mpar'}</a>.
	</p>
{else}
	{if $status == 'pending'}
		<p class="warning">
			{l s='Su pago fue procesado pero actualmente se encuentra en estado <b>Pendiente</b>, quiere decir que su pago aun no a sido liberado por su banco.' mod='mpar'} 
		</p>
	{else}
		<p class="warning">
			{l s='Al parecer ocurrio un problema con su pago. Si crees que esto es un error comuniquece con nuestro' mod='mpar'} <a href="{$link->getPageLink('contact', true)|escape:'htmlall':'UTF-8'}">{l s='Atencion al Cliente' mod='mpar'}</a>.
		</p>
	{/if}
{/if}

<!-- Modulo desarrollado por Kijam.com -->
