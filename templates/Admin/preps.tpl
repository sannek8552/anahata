{config_load file=templates.ini section="common" scope="global"}
<h2>Преподаватели</h2>
<form action="{#script_url#}{seo_url param1='save'}" method="post" name="frm" enctype="multipart/form-data">
    <fieldset>
      <legend>{if $data}Редактировать{else}Добавить{/if} преподавателя</legend>
	<table>
		<tr>
			<td align="right">Фио:</td>
			<td align="left">
				<input type="text" title="string___Пожалуйста, введите название" name="fio" value="{$data.fio|escape}" />
			</td>
		</tr>
                <tr>
			<td align="right">Фотография:</td>
			<td align="left">
				<input type="file" name="file"/>
			</td>
                        {if $data.photo}<img src="{#upload#}thumb_{$data.photo}" alt="Фотография"/>{/if}
		</tr>
		<tr>
			<td align="right" valign="top">Биография:</td>
			<td align="left">
                                <textarea name="bio" id="bio" style="width: 50%;" title="">{$data.bio}</textarea>
			</td>
		</tr>
		<tr>
			<td align="right" valign="top">
				<input type="hidden" value="{$data.id}" name="id" />
			</td>
			<td align="left">
                            <input type="submit" value="{if $data}Сохранить{else}Добавить{/if}" name="send" class="submit-button"/>
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
          <th scope="col" nowrap="nowrap">Фио</th>
          <th scope="col" nowrap="nowrap">Фото</th>
          <th scope="col" nowrap="nowrap">Функции</th>
        </tr>
      </thead>
	{foreach from = $preps item = item key = key}
	<tr>
            <td valign="top">{$key+1}</td>
            <td valign="top">{$item.fio}</td>
            <td valign="top"><img alt="Фотография" src="{#upload#}thumb_{$item.photo}" alt="Фотография"/></td>
            <td valign="top">
                <a title="Редактировать" href="{#script_url#}{seo_url param1='edit' param2=$item.id}"><img border="none" src="{#admin_img_url#}edit.png" alt="Редактировать" /></a>
                <a title="Удалить" href="{#script_url#}{seo_url param1='delete' param2=$item.id}" onclick="return confirm('Вы уверены?');"><img border="none" src="{#admin_img_url#}cross.png" alt="Удалить" /></a>
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

<script type="text/javascript">
 validator.add("frm");
</script>
<script type="text/javascript">
{literal}
tinyMCE.init({
		// General options
                language : "ru",
		mode : "exact",
		elements: "bio",
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
{/literal}
</script>