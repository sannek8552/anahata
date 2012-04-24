    
        {foreach from=$items item=item}
        
        {if $cross_key == $item.id}
        <li>
            <a href="{#script_url#}{seo_url rm=$item.seo_url}" >{$item.title}</a>
            {if $item.sub}
                {include file='Common/CMS/CrossPage/sub_cross_1.tpl' items=$item.sub }
            {/if}
        {elseif $item.sub}
             {include file='Common/CMS/CrossPage/sub_cross.tpl' items=$item.sub seo_data=$seo_data cross_key=$cross_key}
        </li>
        {/if}
       
        {/foreach}
    


   