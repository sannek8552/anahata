{config_load file=templates.ini section="common" scope="global"}

{if $no_contact_form}
Contact Form not found
{else}
<form name="contact_form_{$section}" method="post" enctype="multipart/form-data" action="{#script_url#}{if $seo_url}{seo_url rm=$seo_url}{/if}">
<table width="100%">
{*pre defined field*}
{*
<tr>
	<td>Your Email</td>
	<td><input type="text" name="email" value="" title="email___Enter valid email!" /></td>
</tr>
*}
{*pre defined field*}
{foreach from=$fields item=item key=key}
<tr>
	<td nowrap="nowrap">
		{if !$default_values}
			{$item.field_name}
		{else}
		&nbsp;
		{/if}	</td>
	<td>
		{if $item.field_type=="text"}
                <input type="text" name="field_{$item.id}" {if $default_values}value="Name" onfocus="this.value = '';" onblur="if (this.value == '') this.value = 'Name';"{/if} {if $iferror[$item.id]}value="{$iferror[$item.id]}"{/if} {if $item.field_validation}title="{$item.field_validation}___{$item.field_error}"{/if} />
		{elseif $item.field_type=='checkbox'}
			<input type="checkbox" name="field_{$item.id}" {if $iferror[$item.id] == 'Checked'}checked{/if}/>
		{elseif $item.field_type=='textarea'}
		<textarea name="field_{$item.id}" cols="30" rows="5" {if $item.field_validation}title="{$item.field_validation}___{$item.field_error}"{/if}>{if $iferror[$item.id]}{$iferror[$item.id]}{/if}</textarea>
		{elseif $item.field_type=='select'}
			<select name="field_{$item.id}" {if $item.field_validation}title="{$item.field_validation}___{$item.field_error}"{/if}>
				<option value="">Select</option>
				{foreach from=$item.answer item=a_item key=a_key}
				<option value="{$a_item}" {if $iferror[$item.id]} {if $a_item == $iferror[$item.id]}selected{/if}{/if}>{$a_item}</option>
				{/foreach}
			</select>
		{elseif $item.field_type=='email'}	
			<input type="text" name="email" {if $default_values}value="E-mail" onfocus="this.value = '';"  onblur="if (this.value == '') this.value = 'E-mail';"{/if} {if $iferror.email}value="{$iferror.email}"{/if} {if $item.field_validation}title="email___{$item.field_error}"{/if} />
		{elseif $item.field_type=='name'}	
			<input type="text" name="name" {if $default_values}value="Name" onfocus="this.value = '';"  onblur="if (this.value == '') this.value = 'Name';"{/if} {if $iferror.name}value="{$iferror.name}"{/if} {if $item.field_validation}title="string___{$item.field_error}"{/if} />
		{elseif $item.field_type=='file'}	
			<input type="file" name="field_{$item.id}" {if $iferror.file}value="{$iferror.file}"{/if} {if $item.field_validation}title="string___{$item.field_error}"{/if} />
			{foreach from = $er item = e}
				{if $e == $item.id} <div style="color:red;">{$item.field_error}</div> {/if}
			{/foreach}
			{foreach from = $sys_er item = se key = sk}
				{if $sk == $item.id}<div style="color:red;">{$se}</div>{/if}
			{/foreach}
		{/if}
	</td>
</tr>
{/foreach}
{if $show_captcha == 1}
<tr>
	<td>
		Captcha
	</td>
	<td>
		<img src="{#script_url#}{seo_url rm=Get_Img param1=$section param2=$smarty.now}" /> <br/>{if $wrong_captcha == 1}
			<div style="color:red;" >Please enter correct code</div>
		{/if}<br/>
		
		<input type="text" name="check_captcha_{$section}" title="string___Please enter code" />
	</td>
</tr>
{/if}
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" name="save_{$section}" value="Submit" class="btn"/></td>
</tr>
</table>
</form>
{literal}
<script type="text/javascript">
window.addEvent('domready',function()
{
	{/literal}   
    validator.add('contact_form_{$section}');
    {literal}
});
</script>
{/literal}
{/if}