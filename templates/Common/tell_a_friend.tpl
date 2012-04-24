{config_load file=templates.ini section="common" scope="global"}
  <a href="javascript:void(0);" onclick="{literal}if (typeof(tell_a_friend) != 'function') {alert('Tell a Friend module is not installed');return false;}{/literal}tell_a_friend('{$pid}');" >Tell a Friend</a>
<script type="text/javascript" >
{literal}
function tell_a_friend(pid)
{
	Lightbox.get_html('tell_a_friend', {id:pid});
	Lightbox.get_html_callback = function()
	{
		validator.add('tell_a_friend_form');
	}
	
}

function tell_a_friend_save(form_id)
{
	var res = validator.check('tell_a_friend_form');	
	if (res)
	{
		Lightbox.submit_form(document.getElementById(form_id), 'tell_a_friend');
		Lightbox.submit_form_callback = function()
		{
			//
			if (Lightbox.req.responseJS.send != undefined && Lightbox.req.responseJS.send == 1)
			{
				alert('E-mail sent successfully!');
			}
		}
	}
}

{/literal}
</script>
