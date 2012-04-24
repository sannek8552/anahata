{config_load file=templates.ini section="common" scope="global"}
    <h1> {$t_data.name|escape}</h1>
    <p>{$t_data.description|escape|nl2br}</p>
    {foreach from = $page item = item}
        {$item.content}<strong> {$item.name}</strong>
        <br/>
        <hr/>
        <br/>
    {/foreach}
    <div class="pages">
         {if $num_pages.current!='1'}
            <a href="{#script_url#}{seo_url rm=$seo_url param1=$num_pages.current-1}">Previous</a>
            {else}
            Previous
            {/if}

            {foreach from=$num_pages.prepared item=item key=key}
            <a href="{#script_url#}{seo_url rm=$seo_url param1=$item}">
                {if $num_pages.current==$item}<b>{/if}
                {$item}
                {if $num_pages.current==$item}</b>{/if}
            </a>
            {/foreach}
            {if $num_pages.current!=$num_pages.pages}
            &nbsp;<a href="{#script_url#}{seo_url rm=$seo_url param1=$num_pages.current+1}">Next</a>
            {else}
            Next
            {/if}
    </div>
