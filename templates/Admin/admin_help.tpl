{config_load file=templates.ini section="common" scope="global"}

<div id="helpLightbox">
	<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
		<td>
			<iframe src="{#help_url#}{$page}" class="helpiFrame""></iframe>
		</td>
	</tr>
	<tr>
		<td align="center"><input type="button" name="Close" value="Close" class="submit-button" onclick="Lightbox.close();"/></td>
	</tr>
	</table>
</div>