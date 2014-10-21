{*
* Hook - Despliegue de Boton de Pago
*
* @author    Kijam.com <info@kijam.com>
* @copyright 2014 Kijam.com
* @license   Comercial
*}
<div class="row">
	<div class="col-xs-12 col-md-6">
		<p class="payment_module">
			{if empty($init_point)}
				{$error|escape:'htmlall':'UTF-8'}
			{else}
				<div style="min-height: 90px;min-width:115px;margin-right: 15px;float:left;">
				<a href="{$init_point}" id="botonMP" name="MP-Checkout" class="lightblue-M-Ov-ArOn" mp-mode="{if $modal == 1}modal{else}redirect{/if}" onreturn="execute_my_onreturn_ar">
					{l s='Pagar' mod='mpar'}
				</a>
				</div>
				<div style="float:left;max-width: 330px;">
					<strong>{l s='Pagar con Tarjeta de Credito' mod='mpar'}</strong><br />{l s='Puede tardar hasta 48 horas hábiles bancarias.' mod='mpar'}{if $fee >= 0.001}{l s=' Tiene costos adicionales.' mod='mpar'}{/if}<br /><br />
				{if $fee >= 0.001}
					<strong>{l s='Costo por servicios:' mod='mpar'}</strong> {$fee|escape:'htmlall':'UTF-8'}% {l s='del monto total' mod='mpar'} (<b>{displayPrice price=$feeTotal}</b>).<br />
					<strong>{l s='En MercadoPago debera pagar:' mod='mpar'}</strong> <b style="color:red">{displayPrice price=$newPrice}</b>
				{/if}
				</div>
			{/if}
			<br style="clear:both;height:0;line-height:0" />
		</p>
	</div>
</div>
<style>
	#MP-Checkout-dialog {
		z-index: 200000 !important;
	}
</style>
<script type="text/javascript" src="https://www.mercadopago.com/org-img/jsapi/mptools/buttons/render.js"></script>
<script type="text/javascript">
	function execute_my_onreturn_ar(data) {
		console.log(data);
		window.location.href="{$back_url|escape:'htmlall':'UTF-8'}?external_reference="+data.external_reference+"&collection_status="+data.collection_status;
	}
</script>

<!-- Modulo desarrollado por Kijam.com -->
