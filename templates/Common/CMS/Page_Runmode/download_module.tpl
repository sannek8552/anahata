{config_load file=templates.ini section="common" scope="global"}
{if $data}
<div class="download_files">
    <h4>{$section_name}</h4>
    {foreach from=$data key=key item=item}
        <div class="item" style="margin-bottom: 10px;">
        <b>Filename:</b> <a href="{#script_url#}{seo_url rm="Download" param1=$item.id}">{$item.file}</a><br />
        {if !empty($item.description)}<b>Description:</b> {$item.description|escape|nl2br}{/if}
        </div>
    {/foreach}
</div>
{/if}