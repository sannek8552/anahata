    
        {foreach from=$items item=item}
        
        {if $cross_pages[$seo_data][$item.id]}
        <li>
            <a href="{#script_url#}{seo_url rm=$item.seo_url}" >{$item.title}</a>
            {if $item.sub}
                {include file='sub_cross_1.tpl' items=$item.sub }
            {/if}
        {elseif $item.sub}
             {include file='sub_cross.tpl' items=$item.sub seo_data=$seo_data}
        </li>
        {/if}
       
        {/foreach}
    


   