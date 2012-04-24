{config_load file=templates.ini section="common" scope="global"}
<h2>Управление фотоальбомами</h2>
<form name="gallery_form" method="post" action="{#script_url#}{seo_url}">    
<fieldset name="information" id="information">
      <legend>{if $id}Редактировать{else}Добавить{/if} фотоальбом</legend>
<table>
<tr>
	<td colspan="2"></td>
</tr>
<tr>
	<td><strong>Название альбома:</strong></td>
	<td><input name="name" type="text" title="string___Введите имя" value="{$name}" size="40" /></td>
</tr>
<tr>
	<td><strong>Фотографий на странице:</strong></td>
	<td><input name="items_per_page" type="text" title="integer___Введите число" value="{$items_per_page}" size="15"/></td>
</tr>

<tr>
	<td >&nbsp;
	{if $id}<input type="hidden" name="id" value="{$id}"/>{/if}
	</td>
	<td>
            <input type="submit" name="save" value="{if $id}Сохранить{else}Добавить{/if}" class="submit-button"/>
            {if $id}
            <input type="button" name="save" value="Отмена" class="submit-button" onclick="window.location = '{#script_url#}{seo_url}'"/>
            {/if}
        </td>
</tr>
</table>
</fieldset>
</form>
<script type="text/javascript">
validator.add('gallery_form');
</script>
<div class="NewButton"><a href="{#script_url#}{seo_url rm="Gallery_One_Manager"}">Создать новый альбом</a></div><br /><br>
<div class="table-list">
<table>
      <thead>
        <tr>
          <th scope="col" nowrap="nowrap">Название</th>
          <th scope="col" nowrap="nowrap">Функции</th>          </tr>
      </thead>
{foreach from=$gallery item=item key=key}
<tr>
	<td>{$item.name}</td>
	<td>
            <a title="Редактировать альбом" href="{#script_url#}{seo_url param1='edit' param2=$item.id}"><img border="none" src="{#admin_img_url#}edit.png" alt="Редактировать" /></a>
            <a title="Редактировать фотографии" href="{#script_url#}{seo_url param1='picture' param2=$item.id param3='clear'}"><img border="none" src="{#admin_img_url#}pictures.png" alt="Фотографии" /></a>
            <a title="Удалить альбом" href="{#script_url#}{seo_url param1='delete' param2=$item.id}" onclick="return confirm('Вы уверены? \nВсе фоторафии альбома будут удалены.');"><img border="none" src="{#admin_img_url#}cross.png" alt="Удалить" /></a>
        </td>
</tr>
{/foreach}
<tfoot>
<tr>
	<td colspan="100">
</td>
</tr>
</tfoot>
</table>
</div>