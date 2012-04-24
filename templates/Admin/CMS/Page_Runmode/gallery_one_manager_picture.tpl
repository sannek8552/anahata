{config_load file=templates.ini section="common" scope="global"}
<h2>Фоторафии альбома {$gallery_data.name}</h2>
<div class="NewButton"><a href="{#script_url#}{seo_url rm="Gallery_One_Manager"}">&larr; Назад</a></div>
<form name="picture_form" action="{#script_url#}{seo_url param1='picture' param2=$gallery_data.id}" enctype="multipart/form-data" method="post">
    <fieldset name="information" id="information">
      <legend>Добавить фотографию</legend>
<table>
<tr>
	<td colspan="2" align="center"><h1>Pictures for {$gallery_data.name}</h1></td>
</tr>
<tr>
	<td>Название:</td>
	<td><input type="text" name="name" value="{$name}" title="string___Введите название"/></td>
</tr>
<tr>
	<td>Краткое описание:</td>
	<td>
		<textarea name="description" title="string___Введите краткое описание">{$description}</textarea>
	</td>
</tr>
<tr>
	<td valign="bottom">Фотография:</td>
	<td><input type="file" name="pic1" />
            {if $id}<img src="{#script_url#}{#gallery#}/thumb_{$pic1}" />{/if}
        </td>
</tr>

<tr>
	<td>Индекс сортировки:</td>
	<td><input type="text" name="order_no" value="{$order_no}" title="integer___Введите индекс сортировки (число)"/></td>
</tr>
<tr>
	<td>&nbsp;{if $id}<input type="hidden" name="picture_id" value="{$id}"/>{/if}</td>
	<td><input type="submit" name="save" value="{if $id}Сохранить{else}Добавить{/if}" class="submit-button"/>
            {if $id}
                <input type="button" name="save" value="Отмена" class="submit-button" onclick="window.location = '{#script_url#}{seo_url param1=picture param2=$gallery_data.id}'"/>
            {/if}
        </td>
</tr>
</table>
</form>
</table>
</fieldset>
</form>

<div class="table-list">
<table>
      <thead>
        <tr>
          <th scope="col" nowrap="nowrap">Название</th>
          <th scope="col" nowrap="nowrap">Краткое описание</th>
          <th scope="col" nowrap="nowrap">Фоторафия</th>
          <th scope="col" nowrap="nowrap">Индекс сортировки</th>
          <th scope="col" nowrap="nowrap">Функции</th>
          </tr>
      </thead>

{foreach from=$page item=item key=key}
<tr>
	<td>{$item.name}</td>
	<td>{$item.description}</td>
	<td><img src="{#script_url#}{#gallery#}/thumb_{$item.pic1}" /></td>
	<td>{$item.order_no}</td>
	<td>
		<a href="{#script_url#}{seo_url param1='picture' param2=$gallery_data.id param3='edit' param4=$item.id}">Редактировать</a> |
		<a href="{#script_url#}{seo_url param1='picture' param2=$gallery_data.id param3='delete' param4=$item.id}" onclick="return confirm('Вы уверены?');">Удалить</a> |
	</td>
</tr>
{/foreach}
<tfoot>
<tr>
	<td colspan="100">
</td>
</tr>
<tr>
	<td colspan="6">
	{foreach from=$num.prepared item=item key=key}
	<a href="{#script_url#}{seo_url param1='picture' param2=$gallery_data.id param3='list' param4=$item}">{$item}</a>
	{/foreach}
	</td>
</tr>
</tfoot>
</table>

<script type="text/javascript">
    validator.add('picture_form');
</script>