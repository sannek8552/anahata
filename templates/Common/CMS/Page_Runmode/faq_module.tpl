{config_load file=templates.ini section="common" scope="global"}
<table width="100%">
<tr>
	<td align="center"><h1>{$faq_name}</h1></td>
</tr>
<tr>
	<td>
	<div id="faq_accordion">
	{foreach from=$faq_entries item=item key=key}
        <h3 class="toggler atStart">
                {$item.title}
        </h3>
        <div class="element atStart">
                {$item.content}
        </div>
	{/foreach}
	</div>
	</td>
</tr>
{*foreach from=$faq_entries item=item key=key}
<tr>
	<td>
		<h3>{$item.title}</h3> <br/><br/>
		{$item.content}
	</td>
</tr>
{/foreach*}
</table>
<script type="text/javascript">
var accordion = null;
</script>
