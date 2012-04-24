{config_load file=templates.ini section="common" scope="global"}
{if $data.rss_ajax}

<script src="{#js_url#}news_ajax.js" type="text/javascript"></script>	
	<input type="hidden" name="hid_id" value="{$data.rss_id}"/>

	<div>
		<div id="news_pech" style="clear:both;">
			Loading...
		</div>
	</div>
{else}
<div style="clear:both;">
{foreach key=key from=$list_news  item=ind_new}
{if $key<$data.rss_list}
	<div style="clear:both;">
		<ul>{if $data.rss_title}
			<a href="{$ind_new.link.0.value}">
				<li>{$ind_new.title.0.value}</li>
			</a>
		{/if}</ul>
		{if $data.rss_pubdate}
			{$ind_new.pubDate.0.value}
			<br/>
		{/if}
		{if $data.rss_description}
			{$ind_new.description.0.value}
		{/if}
	</div>
{/if}
{/foreach}
</div>
{/if}