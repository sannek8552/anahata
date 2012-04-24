{config_load file=templates.ini section="common" scope="global"}
<div style="margin:5px;{if $page_width}width:{$page_width}px;{/if}{if $page_height}height:{$page_height}px;{/if}">
    <div style="overflow:auto;{if $page_height}height:{$page_height-30}px;{/if}">
    {$content}
    </div>
    <div style="text-align:center;margin-bottom:5px;margin-top:5px;"><input value="Close" type="button" onclick="Lightbox.close();"/></div>
</div>
