{config_load file=templates.ini section="common" scope="global"}

<div id="faqsContact">
<form name="tell_a_friend_form" id="tell_a_friend_form_id" method="post" action="#" >
<input type="hidden" name="save" value="1" />
<input type="hidden" name="id" value="{$data.id}" />
<table width="100%" align="center">
<tr>
	<td colspan="2"><h3>Tell a Friend</h3></td>
</tr>
<tr>
	<td>Your Name</td>
	<td><input type="text" name="your_name" value="{$data.your_name}" title="string___Please input your name" /></td>
</tr>
<tr>
	<td>Your E-mail</td>
	<td><input type="text" name="your_email" value="{$data.your_email}" title="email___Please input your e-mail" /></td>
</tr>
<tr>
	<td>Name of friend</td>
	<td><input type="text" name="friend_name" value="{$data.friend_name}" title="string___Please input friend name" /></td>
</tr>
<tr>
	<td>E-mail of friend</td>
	<td><input type="text" name="friend_email" value="{$data.friend_email}" title="email___Please input friend e-mail" /></td>
</tr>
<tr>
	<td>Comment</td>
	<td>
		<textarea name="friend_comment" >{$data.comment}</textarea>
	</td>
</tr>
{if $captcha}
<tr>
	<td>
		Captcha
	</td>
	<td>
		<img src="{#script_url#}{seo_url rm=Get_Img param1=$section param2=$smarty.now}" /> 
		<br/>
			{if $wrong_captcha == 1}
				<div style="color:red;" >Please enter correct code</div>
			{/if}
		<br/>
		<input type="text" name="check_captcha_{$section}" title="string___Please enter code" />
	</td>
</tr>
{/if}
<tr>	
	<td><input type="button" class="btn" name="send" value="Send" onclick="tell_a_friend_save('tell_a_friend_form_id');" /></td>
	<td><input type="button" class="btn" name="close" value="Close" onclick="Lightbox.close();" /></td>
</tr>
</table>
</form>
</div>