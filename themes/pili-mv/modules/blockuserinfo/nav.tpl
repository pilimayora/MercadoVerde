<!-- Block user information module NAV  -->
<div class="header_user_info">
	{if $is_logged}
		<!-- <a class="logout" href="{$link->getPageLink('index', true, NULL, "mylogout")|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Log me out' mod='blockuserinfo'}">
			{l s='Sign out' mod='blockuserinfo'}
		</a> -->
	{else}
		<a class="login" href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Log in to your customer account' mod='blockuserinfo'}">
			{l s='Ingresar / Registrate' mod='blockuserinfo'}
		</a>
	{/if}
</div>
{if $is_logged}
	<div class="header_user_info">
		<a href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}" title="{l s='View my customer account' mod='blockuserinfo'}" class="account" rel="nofollow">
			<span class="customer_welcome">Hola {$cookie->customer_firstname}!</span>
		</a>
		<span class="customer_prof_pic"></span>
		<span class="customer_notifications"></span>
		<span class="customer_messages"></span>
	</div>
{/if}
<!-- /Block usmodule NAV -->
