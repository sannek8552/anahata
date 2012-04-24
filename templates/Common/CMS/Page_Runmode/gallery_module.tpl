{config_load file=templates.ini section="common" scope="global"}
<table width="100%">
{foreach from=$page item=item key=key}
<tr>
	<td colspan="2">{$item.name}</td>
</tr>
<tr>
	<td><img src="{#script_url#}gallery/240_{$item.pic1}" /></td>
	<td><img src="{#script_url#}gallery/240_{$item.pic2}" /></td>
</tr>
<tr>
	<td colspan="2">{$item.description|nl2br}</td>
</tr>
{/foreach}
<tr>
	<td colspan="2">
	{if $num.current!='1'}
            <a href="{#script_url#}{seo_url rm=$seo_url param1=$num.current-1}">Previous</a>
            {else}
            Previous
            {/if}

            {foreach from=$num.prepared item=item key=key}
            <a href="{#script_url#}{seo_url rm=$seo_url param1=$item}">
                {if $num.current==$item}<b>{/if}
                {$item}
                {if $num.current==$item}</b>{/if}
            </a>
            {/foreach}
            {if $num.current!=$num.pages}
            <a href="{#script_url#}{seo_url rm=$seo_url param1=$num.current+1}">Next</a>
            {else}
            Next
            {/if}
	</td>
</tr>
</table>