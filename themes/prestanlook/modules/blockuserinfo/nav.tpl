<!-- Block user information module NAV  -->
{if $is_logged}
	<div class="header_user_info">
		<a href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}" title="{l s='View my customer account' mod='blockuserinfo'}" class="account" rel="nofollow"><span>{$cookie->customer_firstname} {$cookie->customer_lastname}</span></a>
	</div>
{/if}
<div class="header_user_info">
	{if $is_logged}
		<a class="logout" href="{$link->getPageLink('index', true, NULL, "mylogout")|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Log me out' mod='blockuserinfo'}">
			{l s='Sign out' mod='blockuserinfo'}
		</a>
	{else}
		<a  href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}" class="a_nav" rel="nofollow" title="{l s='Log in to your customer account' mod='blockuserinfo'}">
                    <i class="icon-lock" aria-hidden="true"></i>Logowanie<span class="red_register"><i class="icon-user"></i>Rejestracja</span>
		</a>
	{/if}
</div>
<!-- /Block usmodule NAV -->
