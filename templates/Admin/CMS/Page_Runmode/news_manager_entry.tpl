{config_load file=templates.ini section="common" scope="global"}
<script type="text/javascript" src="{#js_url#}jscalendar/calendar.js"></script>
<script type="text/javascript" src="{#js_url#}jscalendar/lang/calendar-en.js"></script>
<script type="text/javascript" src="{#js_url#}jscalendar/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" href="{#js_url#}jscalendar/calendar-win2k-1.css" />
<h2>Новости ленты "{$news_data.name}"</h2>
<div class="NewButton"><a href="{#script_url#}{seo_url rm="News_Manager"}">&larr; Назад</a></div><br />
<form action="{#script_url#}{seo_url param1=$news_data.id param2 = $num_pages.current}" method="post" name="frm" enctype="multipart/form-data">
    <fieldset name="information" id="information">
      <legend>{if $news_to_edit}Редактировать{else}Создать{/if} новость</legend>
	<table>
		<tr>
			<td align="right">
			Заголовок:
			</td>
			<td align="left">
				<input type="text" title="string___Пожалуйста, введите название" name="name" value="{$news_to_edit.name|escape}" />
			</td>
		</tr>
		<tr>
			<td align="right" valign="top">
			Короткая часть:
			</td>
			<td align="left">
					<textarea name="short" id="shortid" style="width: 50%;" title="">{$news_to_edit.short}</textarea>
			</td>
		</tr>
		<tr>
			<td align="right" valign="top">
			Основная часть:
			</td>
			<td align="left" width="90%" >
				<textarea name="full" id="fullid" style="width: 100%;" rows="35" title="">{$news_to_edit.full}</textarea>
			</td>
		</tr>
		<tr>
			<td align="right">
			Дата:
			</td>
			<td align="left">
			<input type="text" readonly name="adddate" id="date_field_adddate" {if $news_to_edit.adddate}value="{$news_to_edit.adddate}"{else} value="{$smarty.now|date_format:'%Y-%m-%d'}"{/if} /><img src="{#js_url#}jscalendar/jscalendar.gif" id="trig_adddate" />
			</td>
		</tr>
                <tr>
			<td align="right">Изображение:</td>
			<td align="left">
				<input type="file" name="file"/>
			</td>
                        {if $news_to_edit.image}<img src="{#upload#}200_{$news_to_edit.image}" alt="Изображение"/>{/if}
		</tr>
		<tr>
			<td align="right" valign="top">
				<input type="hidden" value="{$hid_id}" name="hid_id" />
				<input type="hidden" value="{$hid_news_id}" name="hid_news_id" />
			</td>
			<td align="left">
				<input type="submit" value="{if $news_to_edit}Сохранить{else}Создать{/if}" name="send" class="submit-button"/>
			</td>
		</tr>
	</table>
    </fieldset>
</form>
<div class="table-list">
<table>
  <thead>
        <tr>
          <th scope="col" nowrap="nowrap">№</th>
          <th scope="col" nowrap="nowrap">Название</th>
          <th scope="col" nowrap="nowrap">Короткая часть</th>
          <th scope="col" nowrap="nowrap">Дата</th>
          <th scope="col" nowrap="nowrap">Функции</th>
      </thead>
	{foreach from = $all_news item = item key = key}
	<tr>
		<td valign="top">
		{$key+1}		</td>
	  <td valign="top">
		{$item.name}		</td>
	  <td valign="top" >
		{$item.short}
		</td>
		<td valign="top" >
		{$item.adddate|date_format:"%d-%m-%Y"} {$item.addtime|date_format:"%H:%M"}
		</td>
		<td valign="top">
			<a title="Редактировать" href="{#script_url#}{seo_url param1 = $news_data.id param2 = $num_pages.current param3="edit" param4=$item.id}"><img border="none" src="{#admin_img_url#}edit.png" alt="Редактировать" /></a>
			<a title="Удалить" href="{#script_url#}{seo_url param1 = $news_data.id param2 = $num_pages.current param3="delete" param4=$item.id}" onclick="return confirm('Are you sure?');"><img border="none" src="{#admin_img_url#}cross.png" alt="Удалить" /></a>
			{if $item.publish == 1}
			<a title="Не опубликовывать" href="{#script_url#}{seo_url param1 = $news_data.id param2 = $num_pages.current param3='unpublish' param4=$item.id}" onclick="return confirm('Вы уверены?');"><img border="none" src="{#admin_img_url#}folder_delete.png" alt="Не опубликовывать" /></a>
			{elseif $item.publish == 0}
			<a title="Опубликовать" href="{#script_url#}{seo_url param1 = $news_data.id param2 = $num_pages.current param3='publish' param4=$item.id}" onclick="return confirm('Вы уверены?');"><img border="none" src="{#admin_img_url#}save.gif" alt="Опубликовать" /></a>
			{/if}
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
{foreach from = $num_pages.prepared item=item}
{if $num_pages.current==$item}
<b><a href="{#script_url#}{seo_url param1=$news_data.id param2=$item}" >{$item}</a></b>
{else}
<a href="{#script_url#}{seo_url param1=$news_data.id param2=$item}" >{$item}</a>
{/if}
{/foreach}
<script type="text/javascript">
 validator.add("frm");
</script>
<script type="text/javascript">
{literal}
tinyMCE.init({
		// General options
                language : "ru",
		mode : "exact",
		elements: "shortid, fullid",
		theme : "advanced",
		plugins : "ibrowser,safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,ibrowser",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
                {/literal}content_css : "{#css_url#}main.css?1",
		// Example word content CSS (should be your site CSS) this one removes paragraph margins
		//content_css : "css/word.css",
                remove_script_host : false,
                relative_urls:false,
                document_base_url : "{#domain_name#}{#script_url#}",{literal}
		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js"
		
	});
Calendar.setup({inputField  : "date_field_adddate",ifFormat    : "%Y-%m-%d",button  : "trig_adddate"});
{/literal}
</script>