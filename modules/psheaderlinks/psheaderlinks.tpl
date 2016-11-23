<!-- Block psheaderlinks module -->

{if $psheaderlinks}


	<div class="ps-header-links">
		
		<ul>
			{foreach from=$psheaderlinks item=link}
				<li><a href="{$link.url|escape}" title="{$link.title|escape}"><span class="icon-small helpicon"></span>{$link.text|escape}</a></li>
			{/foreach}
		</ul>	
	</div>


{/if}

<!-- /Block psheaderlinks module -->