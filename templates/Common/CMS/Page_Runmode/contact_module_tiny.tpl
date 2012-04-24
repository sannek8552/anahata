{config_load file=templates.ini section="common" scope="global"}
{if $no_contact_form}
Contact Form not found
{else}
<form name="contact_form" method="post" action="{#script_url#}{if $seo_url}{seo_url rm=$seo_url}{/if}">
<table style="width:100px;">
{*pre defined field*}
{*
<tr>
	<td>Your Email<br/><input type="text" name="email" value="" title="email___Enter valid email" /></td>
</tr>
*}
{*pre defined field*}
{foreach from=$fields item=item key=key}
<tr>
	<td>{$item.field_name}<br/>
	
		{if $item.field_type=="text"}
			<input type="text" name="field_{$item.id}" {if $item.field_validation}title="{$item.field_validation}___{$item.field_error}"{/if} />
		{elseif $item.field_type=='checkbox'}
			<input type="checkbox" name="field_{$item.id}" />
		{elseif $item.field_type=='textarea'}
		<textarea name="field_{$item.id}" cols="15" rows="5" {if $item.field_validation}title="{$item.field_validation}___{$item.field_error}"{/if}></textarea>
		{elseif $item.field_type=='select'}
			<select name="field_{$item.id}" {if $item.field_validation}title="{$item.field_validation}___{$item.field_error}"{/if}>
				<option value="">Select</option>
				{foreach from=$item.answer item=a_item key=a_key}
				<option value="{$a_item}">{$a_item}</option>
				{/foreach}
			</select>
		{elseif $item.field_type=='email'}	
			<input type="text" name="email" value="" {if $item.field_validation}title="email___{$item.field_error}"{/if} />
		{elseif $item.field_type=='name'}	
			<input type="text" name="name" value="" {if $item.field_validation}title="string___{$item.field_error}"{/if} />	
		{/if}
	</td>
</tr>
{/foreach}
<tr>
	<td><input type="submit" name="save" value="Submit"/></td>
</tr>
</table>
</form>
{literal}
<script type="text/javascript">
//validator.add('contact_form');
window.addEvent('domready',function()
{
    //init_additional();
    validator.add('contact_form');
//    alert('added');
            
});
</script>
{/literal}
{/if}