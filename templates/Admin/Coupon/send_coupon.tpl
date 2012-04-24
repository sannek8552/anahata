{config_load file=templates.ini section="common"}
<div class="content-container">
<h2>Coupon Sending Manager &mdash;{if $addressee == 'registered'} For Previous Shoppers{else} For Previous Contacts{/if}</h2>
      <fieldset name="information" id="information">
    	<legend>Sending Settings</legend>
<p style="color:#FF0000">{$message}</p>
<form action="{#script_url#}{seo_url param1 = $addressee param2 = $c_id}" method="post">
	<table>
  <tr>
			<td>
        E-mail Subject line:<br/>
				<input type="text" name="subject" value="{$data.subject|escape}" />
			</td>
	  </tr>
		<tr>
			<td>
				E-mail list: <br/>
				<select name="addressees[]" size="10" multiple>
					{foreach from = $users item = item}
						
			  <option value="{$item.email}">{$item.login}|{$item.email}|{if $item.name} | {$item.name}{/if}</option>
					{/foreach}
				</select>
			</td>
		</tr>
		<tr>
			<td>
				<p><span style="color:#FF0000; font-weight: bold;">Important:</span> Do not paste text in directly below from any other application like Microsoft Word, <strong>without using the 'text tool' </strong>below to paste the text in, as it will cause the e-mail to display incorrectly when sending.</p>
				<p>E-mail content: <br/>
				  <textarea name="content" id="c_id">{$content}</textarea>
			        </p></td>
	  </tr>
		<tr>
			<td>
				<input type="submit" name="send" style="width: auto;" value="Send" />
			</td>
		</tr>
	</table>
</form>
</fieldset>
</div>
<script type="text/javascript">
{literal}
tinyMCE.init({
		// General options
		mode : "exact",
		elements: "c_id",
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

		// Example word content CSS (should be your site CSS) this one removes paragraph margins
		//content_css : "css/word.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js"
		
	});
{/literal}
</script>