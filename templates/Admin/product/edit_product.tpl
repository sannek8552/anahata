{config_load file=templates.ini section="common" scope="global"}
{literal}

<style type="text/css">		
.imgRight {
	float:right;
}
.tool-title
{
	display:none;
}
</style>	
{/literal}


<div class="content-container">
<h2>Редактирование товара</h2>
<div><a href="{#script_url#}{seo_url rm = AdminProduct}">&larr; Управление товарами</a></div>
<div id="adminProduct">
  <form name="edit_product" action="{#script_url#}{seo_url rm= AdminProduct }" enctype="multipart/form-data" method="post">
  <input type="hidden" name="row_num" value="1" />
      <fieldset name="information" id="information">
    <legend>Товар</legend>
    {if $product.id}
  <input type="hidden" name="id" value="{$product.id}" />
    {/if}
  <input type="hidden" name="action" value="save" />
    
  <table>
    <tr>
      <td width="150" valign="top"><b>Категория</b></td>
	  <td colspan="2">
	    <select name="category_id" >
		{foreach from=$categories item=item key=key}
		<option value="{$key}" {if $key == $product.category_id}selected{/if}>{$item}</option>		
		{/foreach}
		</select>		
		</td>
	</tr>
    <tr>
        <td width="150" valign="top"><b>Производители</b></td>
        <td colspan="2">
            <select name="brand_id" >
            {foreach from=$brands item=item key=key}
            <option value="{$key}" {if $key == $product.brand_id}selected{/if}>{$item.title}</option>
            {/foreach}
            </select>
        </td>
    </tr>
    <tr>
      <td valign="top"><b>Название</b></td>
	  <td colspan="2"><input onchange="populate_product_seo(true);" id="name" type="text" name="name" value="{$product.name}" title="string___<br/>Пожалуйста, введите название" /></td>
	  </tr>

    <tr>
      	<td valign="top"><b>Цена</b></td>
  		<td colspan="2">
                <input type="text" name="price" value="{$product.price}" id="price_row"  title="numeric___<br/>Пожалуйста, введите цену" />    	</td>
	</tr>
        <tr>
        <td valign="top"><b>Новая цена</b></td>
  		<td colspan="2">
                <input type="text" name="newprice" value="{$product.newprice}" id="price_row"  />    	</td>
	</tr>
	<!--<tr>
		<td valign="top" ><b>Количество</b></td>
		<td colspan="2">
                    <input type="text" name="quantity" value="{$product.quantity}" title="integer___<br />Please enter quantity" />
                </td>
	</tr>	
    <tr>
      <td valign="top"><b>Вес</b></td>
	    <td colspan="2"><input type="text" name="weight" value="{$product.weight}" title="numeric___<br/>Please enter weight"/></td>
	  </tr>-->
    <tr>
      <td valign="top"><b>Индекс сортировки</b></td>
	    <td colspan="2"><input type="text" name="order_no" value="{$product.order_no}"/></td>
    </tr>
    <tr>
      <td valign="bottom"><b>Изображение 1</b></td>
      <td width="200" valign="top">
          <input type="file" name="picture1" />
          {if !empty($product.picture1)}
            <img src='{#picture_url#}thumb_{$product.picture1}' alt="Картинка"/>
            <input type="checkbox" name="delete_picture1" /> Удалить
          {else}
            Нет главного изображения
          {/if}
      </td>
      <td width="99" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td valign="bottom"><b>Изображение 2</b></td>
      <td width="200" valign="top">
          <input type="file" name="picture2" />
          {if !empty($product.picture2)}
            <img src='{#picture_url#}thumb_{$product.picture2}' alt="Картинка"/>
            <input type="checkbox" name="delete_picture2" /> Удалить
          {else}
            Нет изображения
          {/if}
      </td>
      <td width="99" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td valign="bottom"><b>Изображение 3</b></td>
      <td width="200" valign="top">
          <input type="file" name="picture3" />
          {if !empty($product.picture3)}
            <img src='{#picture_url#}thumb_{$product.picture3}' alt="Картинка"/>
            <input type="checkbox" name="delete_picture3" /> Удалить
          {else}
            Нет изображения
          {/if}
      </td>
      <td width="99" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td valign="bottom"><b>Изображение 4</b></td>
      <td width="200" valign="top">
          <input type="file" name="picture4" />
          {if !empty($product.picture4)}
            <img src='{#picture_url#}thumb_{$product.picture4}' alt="Картинка"/>
            <input type="checkbox" name="delete_picture4" /> Удалить
          {else}
            Нет изображения
          {/if}
      </td>
      <td width="99" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td valign="top"><b>Краткое описание</b></td>
        <td colspan="2"><textarea name="description" class="wide" cols="5" rows="20">{$product.description}</textarea></td>
    </tr>
    <tr>
      <td valign="top"><b>HTML Редактор - Описание товара</b></td>
      <td colspan="2">
         <textarea style="height:500px; width: 600px;" name="full_description" id="full_descriptionid" >{$product.full_description}</textarea>
      </td>
    </tr>
    <!--<tr>
        <td valign="top"><b>URL адрес</b></td>
	    <td colspan="2">
	    	<input id="seo_url" type="text" name="seo" onchange="clean_seo(this);" value="{$product.seo}" title="string___Please input seo url" />
	    	<br />
	    	<a href="javascript:void(0);" onclick="populate_product_seo(false);">Генерация на основе названия</a>
            </td>
    </tr>-->
    <tr>
    	<td valign="top"><b>Ключевые слова</b></td>
    	<td colspan="2"><input type="text" name="keywords" value="{$product.keywords}" /></td>
    </tr>
    <!--<tr>
    	<td valign="top"><b>Meta title</b></td>
    	<td colspan="2"><input type="text" name="page_title" value="{$product.page_title}" /></td>
    </tr>
    <tr>
    	<td valign="top"><b>Meta Description</b></td>
    	<td colspan="2"><textarea name="page_description">{$product.page_description}</textarea></td>
    </tr>-->
    <tr>
    	<td valign="top"><b>Сезон</b></td>
    	<td colspan="2"><input type="text" name="release_year" value="{$product.release_year}"/></td>
    </tr>
    <tr>
    	<td valign="top"><b>Не актиный</b></td>
    	<td colspan="2"><input type="checkbox" name="inactive" {if $product.inactive == 1}checked{/if} /></td>
    </tr>
    <tr>
    	<td valign="top"><b>Новинка</b></td>
    	<td colspan="2"><input type="checkbox" name="featured" {if $product.featured == 1}checked{/if} /></td>
    </tr>    
    <tr>
      <td>
      		<input type="submit" class="submit-button" name="save" value="Сохранить" />
                <input type="button" class="submit-button" name="cancel" value="Отмена" onclick="window.location = '{#script_url#}{seo_url rm = AdminProduct}'"/>
      </td>
	  </tr>
  </table>
    </fieldset>
  
  
</form>
    </div>
  {fceditor_init}</div>
<script type="text/javascript">
validator.add('edit_product');

var row_num = 2;
{literal}

populate_product_seo = function(auto)
{
		//alert('populate');
		if(!auto || $('seo_url').value.length == 0)
		{
			var page_title = $('name').value;
			page_title = page_title.replace(/\s/g,'-');
            page_title = page_title.replace(/\&/g,'and');
			page_title = page_title.replace(/([^a-z|A-Z|\d|\-])/g,'');
			$('seo_url').value = page_title;
			//alert('populated');
		}
};

clean_seo = function(elem)
{
	elem.value = elem.value.replace(/\s/g,'-');
    elem.value = elem.value.replace(/\&/g,'and');
	elem.value = elem.value.replace(/([^a-z|A-Z|\d|\-])/g,'');
}

{/literal}

</script>

<script type="text/javascript">
{literal}
tinyMCE.init({
		// General options
		mode : "exact",
		elements: "full_descriptionid",
		theme : "advanced",
		plugins : "ibrowser,safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,storage,media_manager",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,ibrowser,storage,media_manager",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		{/literal}
		{*
        remove_script_host : true,
        document_base_url : "{#domain_name#}{#script_url#}",
        *}
        convert_urls : false,
        {literal}


		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js"		
	});
{/literal}
</script>

