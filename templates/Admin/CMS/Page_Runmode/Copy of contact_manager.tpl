{config_load file=templates.ini section="common" scope="global"}
<form name="contact_manager" method="post" action="{#script_url#}{seo_url}">
<h2>{if $edit_data}{$L_EDIT}{else}{$L_ADD}{/if} {$L_CONTACT_FORM}</h2>
<div class="NewButton"><input type="submit"  class="submit-button" name="save" value="{$L_ADD_NEW} {$L_CONTACT_FORM}"/></div>
<div class="content-container">
    <fieldset name="information" id="information">
      <legend>Contact Form Settings</legend>
<table>
<tr>
	<td>{$L_FROM_NAME}</td>
	<td><input name="from_name" type="text" title="string___{$L_ENTER_NAME}" value="{$edit_data.from_name}" size="50" /></td>
</tr>
<tr>
	<td>{$L_FROM_EMAIL}</td>
	<td><input name="from_email" type="text" title="email___{$L_ENTER_EMAIL}" value="{$edit_data.from_email}" size="50"/></td>
</tr>
<tr>
	<td>{$L_SUBJECT}</td>
	<td><input name="subject" type="text" title="string___{$L_ENTER_SUBJECT}" value="{$edit_data.subject}" size="50"/></td>
</tr>
<tr>
	<td>{$L_EMAIL_TEXT}</td>
	<td>
		{if $edit_data && $edit_data.mail_text}
			{fceditor_exact editor_name="mail_text" value=$edit_data.mail_text}
		{else}
			{fceditor_exact editor_name="mail_text" value=""}
		{/if}
	</td>
</tr>
<tr>
	<td>{$L_THANK_YOU_SEO_URL}</td>
	<td><input name="thank_you_page" type="text" value="{$edit_data.thank_you_page}" size="50"/></td>
</tr>
<tr>
	<td>
		&nbsp;
		{if $edit_data}
		<input type="hidden" name="id" value="{$edit_data.id}"/>
		{/if}
	</td>
	<td>
		<input type="submit"  class="submit-button" name="save" value="{if $edit_data}{$L_SAVE}{else}{$L_ADD}{/if}"/>
		{if $edit_data}<input type="button"  class="submit-button" name="cancel" value="{$L_CANCEL}" onclick="document.location='{#script_url#}{seo_url rm=Contact_Manager}'"/>{/if}
	</td>
</tr>
</table>
</fieldset>
<div class="table-list">
<table>
<thead>
      <tr>

	<th scope="col" nowrap="nowrap">{$L_INSERT_CODE}</th>
	<th scope="col" nowrap="nowrap">{$L_FROM_NAME}</th>
	<th scope="col" nowrap="nowrap">{$L_FROM_EMAIL}</th>
	<th scope="col" nowrap="nowrap">{$L_SUBJECT}</th>
	<th scope="col" nowrap="nowrap">{$L_EMAIL_TEXT}</th>
	<th scope="col" nowrap="nowrap">{$L_THANK_YOU}</th>
	<th scope="col" nowrap="nowrap">{$L_ENTRIES}</th>
	<th scope="col" nowrap="nowrap">{$L_FUNCTIONS}</th>
</tr></thead>
{foreach from=$settings item=item key=key}
<tr>
	<td><p><strong>[contact_module?section={$item.id}]</strong></p>
	  <p style="color:#FF0000;"><em>to include <a href="http://www.captcha.net/" target="_blank">Captcha</a> in your form, your snippet will be:</em></p>
	  <p><strong>[contact_module?section={$item.id}&amp;protect=1]</strong></p></td>
	<td>{$item.from_name}</td>
	<td>{$item.from_email}</td>
	<td>{$item.subject}</td>
	<td>{$item.mail_text}</td>
	<td>{$item.thank_you_page}</td>
	<td><a href="{#script_url#}{seo_url rm="Contact_Manager_Entry" param1=$item.id}">{$item.count}</a></td>
	<td>
		<a title="{$L_EDIT}" href="{#script_url#}{seo_url param1="edit" param2=$item.id}" ><img border="0" src="{#img_url#}edit.png" alt="{$L_EDIT}" /></a>
		<a title="{$L_FORM_FIELDS}" href="{#script_url#}{seo_url rm="Contact_Manager_Form" param1=$item.id}"><img border="0" src="{#img_url#}detail.png" alt="{$L_FORM_FIELDS}"/></a>
		<a title="{$L_DELETE}" href="{#script_url#}{seo_url param1="delete" param2=$item.id}" onclick="return confirm('{$L_ARE_YOU_SURE}');"><img border="none" src="{#img_url#}cross.png" alt="{$L_DELETE}" /></a>
		<a href="{#script_url#}{seo_url param1='make_csv' param2=$item.id}">csv</a>
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
validator.add('contact_manager');
</script>
{fceditor_init}