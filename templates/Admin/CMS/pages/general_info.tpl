{config_load file=templates.ini section="common" scope="global"}
<div class="sectionHeader">Page data</div>

<div class="sectionBody">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tbody>
  	<tr>
	    <td colspan="2"><b>General</b></td>
  	</tr>
  <tr>
  	<td valign="top" width="200">Title: </td>
    <td><b>{$info.title}</b></td>
  </tr>
  <tr>
    <td valign="top" width="200">Page title: </td>
    <td><small>{$info.page_title}</small></td>
  </tr>
  <tr>
    <td valign="top">Type: </td>
    <td>{$info.page_type}</td>
  </tr>
    <tr>
    <td valign="top">Keywords: </td>
    <td>{$info.keywords}</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><b>Changes</b></td>
  </tr>
  <tr>
    <td>Created: </td>
    <td>{$info.created|date_format:"%m.%d.%Y %H:%M:%S"}</td>
  </tr>
  <tr>
    <td>Edited: </td>
    <td>{$info.updated|date_format:"%m.%d.%Y %H:%M:%S"}</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><b>Status</b></td>
  </tr>
  <tr>
    <td>Active: </td>
    <td>{if $info.active == 1}yes{else}no{/if}</td>
  </tr>
  <tr>
    <td>Published</td>
    <td>{if $info.published == 1}yes{else}no{/if}</td>
  </tr>
  <tr>
    <td>Menu index: </td>
    <td>0</td>
  </tr>
  <tr>
    <td>Show in menu: </td>
    <td></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
</tbody></table>
</div>
</div>