    
        {foreach from=$items item=item}
        {if $cross_pages[$seo_data][$item.id]}
            <a href="{#script_url#}{seo_url rm=$item.seo_url}" >{$item.title}</a><br />
            {if $item.sub}
                {include file='Common/CMS/CrossPage/sub_cross_2.tpl' items=$item.sub }
            {/if}
        {/if}
        {/foreach}
    


   