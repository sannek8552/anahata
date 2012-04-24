{config_load file=templates.ini section="common" scope="global"}
<h2>Модуль новостей</h2>
<!--
<form action="{#script_url#}{seo_url}" method="post" name="frm">
    <fieldset name="information" id="information">
      <legend>{if $output_array}Редактировать{else}Создать{/if} новостную ленту</legend>
	<table>
		<tr>
			<td align="right">
				Название
			</td>
			<td align="left">
				<input title="string___Пожалуйста, введите название" type="text" value="{$output_array.name}" name="name"/>
			</td>
		</tr>
		<tr>
			<td align="right">
				Новостей на странице
			</td>
			<td align="left">
				<input title="numeric___Пожалуйста, введите число" type="text" value="{$output_array.items}" name="items"/>
			</td>
		</tr>
		<tr>
			<td align="right">
			<input type="hidden" name="hid_id" value="{$output_array.id}" />
			</td>
			<td align="left">
				<input type="submit" value="{if $output_array}Сохранить{else}Создать{/if}" name="send" class="submit-button"/>
			</td>
		</tr>
	</table>
    </fieldset>
</form>

<script type="text/javascript">
validator.add('frm');
</script>

<div class="NewButton"><a href="{#script_url#}{seo_url rm="News_Manager"}">Создать новостную ленту</a></div><br /><br />-->

<div class="table-list">
<table>
      <thead>
        <tr>
          <th width="170" nowrap="nowrap" scope="col">Код для вставки</th>
          <th scope="col" nowrap="nowrap">Название</th>
          <th width="170" nowrap="nowrap" scope="col">Новостей на странице</th>
          <th scope="col" nowrap="nowrap">Функции</th>
      </thead>
{foreach from=$objects item=item key=key}
<tr>
	<td>[news_module?section={$item.id}]</td>
	<td>{$item.name}</td>
	<td>{$item.items}</td>
	<td><!--<a title="Редактировать" href="{#script_url#}{seo_url param1='edit' param2=$item.id}"><img border="none" src="{#admin_img_url#}edit.png" alt="Редактировать" /></a>-->
	<a title="Редактировать новости" href="{#script_url#}{seo_url rm='News_Manager_Entry' param1=$item.id}"><img border="none" src="{#admin_img_url#}detail.png" alt="Редактировать новости" /></a>
	<!--<a title="Удалить" href="{#script_url#}{seo_url param1='delete' param2=$item.id}" onclick="return confirm('Все новости этой ленты будут удалены! \nВы уверены?');"><img border="none" src="{#admin_img_url#}cross.png" alt="Удалить" /></a>-->	</td>
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