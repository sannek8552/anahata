IconConst = function()
{
	var t = this;
	t.edit = function(title_alt)
	{
		if (title_alt == undefined) title_alt='Edit';  
		return '<img title="' + title_alt + '" alt="' + title_alt + '" src="'+img_prefix + 'application_edit.png' + '" border="0" />';
	};
	t.detail = function(title_alt)
	{
		if (title_alt == undefined) title_alt='Details';  
		return '<img title="' + title_alt + '" alt="' + title_alt + '" src="'+img_prefix + 'application_view.png' + '" border="0" />';
	}
	t.delete_i = function(title_alt)
	{
		if (title_alt == undefined) title_alt='Delete';
		return '<img title="' + title_alt + '" alt="' + title_alt + '" src="'+img_prefix + 'application_delete.png' + '" border="0" />';
	}
	t.location = function(title_alt)
	{
		if (title_alt == undefined) title_alt='Locations';
		return '<img title="' + title_alt + '" alt="' + title_alt + '" src="'+img_prefix + 'map_go.png' + '" border="0" />';
	}
	t.group = function(title_alt)
	{
		if (title_alt == undefined) title_alt='Group';
		return '<img title="' + title_alt + '" alt="' + title_alt + '" src="'+img_prefix + 'group_go.png' + '" border="0" />';
	}
	t.lock_edit = function(title_alt)
	{
		if (title_alt == undefined) title_alt='Change Password';
		return '<img title="' + title_alt + '" alt="' + title_alt + '" src="'+img_prefix + 'lock_edit.png' + '" border="0" />';
	}
	
	t.take_bpo = function(title_alt)
	{
		if (title_alt == undefined) title_alt='Claim';
		return '<img title="' + title_alt + '" alt="' + title_alt + '" src="'+img_prefix + 'flag_green.png' + '" border="0" />';
		return 'take';
	}
	
	t.complete_bpo = function(title_alt)
	{
		if (title_alt == undefined) title_alt='Complete';
		return '<img title="' + title_alt + '" alt="' + title_alt + '" src="'+img_prefix + 'application_go.png' + '" border="0" />';
		return 'take';
	}
	t.access = function(title_alt)
	{
		if (title_alt == undefined) title_alt='Access';
		return '<img title="' + title_alt + '" alt="' + title_alt + '" src="'+img_prefix + 'group_go.png' + '" border="0" />';
	}
	
	t.revise = function(title_alt)
	{
		if (title_alt == undefined) title_alt='Revision';
		return '<img title="' + title_alt + '" alt="' + title_alt + '" src="'+img_prefix + 'application_revise.png' + '" border="0" />';
	}
	t.result = function(title_alt)
	{
		if (title_alt == undefined) title_alt='View Result';
		return '<img title="' + title_alt + '" alt="' + title_alt + '" src="'+img_prefix + 'application_put.png' + '" border="0" />';
	}


	t.convert = function(title_alt)
	{
		if (title_alt == undefined) title_alt='Convert';
		return '<img title="' + title_alt + '" alt="' + title_alt + '" src="'+img_prefix + 'convert_lead.gif' + '" border="0" />';
	}

	t.claim = function(title_alt)
	{
		if (title_alt == undefined) title_alt='Claim';
		return '<img title="' + title_alt + '" alt="' + title_alt + '" src="'+img_prefix + 'flag_green.png' + '" border="0" />';
	}
	
	t.phone = function(title_alt)
	{
		if (title_alt == undefined) title_alt='Set Phoned';
		return '<img title="' + title_alt + '" alt="' + title_alt + '" src="'+img_prefix + 'telephone.png' + '" border="0" />';
	}

	t.map = function(title_alt)
	{
		if (title_alt == undefined) title_alt='View Map';
		return '<img title="' + title_alt + '" alt="' + title_alt + '" src="'+img_prefix + 'map.png' + '" border="0" />';
	}
	
	t.add_folder = function(title_alt)
	{
		if (title_alt == undefined) title_alt='Add Folder';
		return '<img title="' + title_alt + '" alt="' + title_alt + '" src="'+img_prefix + 'folder_add.png' + '" border="0" />';
	}
	
	t.add_file = function(title_alt)
	{
		if (title_alt == undefined) title_alt='Add File';
		return '<img title="' + title_alt + '" alt="' + title_alt + '" src="'+img_prefix + 'page_add.png' + '" border="0" />';
	}
	
	t.login_as = function(title_alt)
	{
		if (title_alt == undefined) title_alt='Login As';
		return '<img title="' + title_alt + '" alt="' + title_alt + '" src="'+img_prefix + 'user_go.png' + '" border="0" />';
	}
	
	t.assure_bpo = function(title_alt)
	{
		if (title_alt == undefined) title_alt='Confirm';
		return '<img title="' + title_alt + '" alt="' + title_alt + '" src="'+img_prefix + 'application_go.png' + '" border="0" />';
		return 'take';
	}
	t.feature = function(title_alt)
	{
		if (title_alt == undefined) title_alt='Feature';
		return '<img title="' + title_alt + '" alt="' + title_alt + '" src="'+img_prefix + 'flag_purple.png' + '" border="0" />';
	}

	t.add_time = function(title_alt)
	{
		if (title_alt == undefined) title_alt='Request Time';
		return '<img title="' + title_alt + '" alt="' + title_alt + '" src="'+img_prefix + 'time_add.png' + '" border="0" />';
	}
	
	t.add_access = function(title_alt)
	{
		if (title_alt == undefined) title_alt='Add Access';
		return '<img title="' + title_alt + '" alt="' + title_alt + '" src="'+img_prefix + 'door.png' + '" border="0" />';
	}
	
	t.have_access = function(title_alt)
	{
		if (title_alt == undefined) title_alt='Have Access';
		return '<img title="' + title_alt + '" alt="' + title_alt + '" src="'+img_prefix + 'door_open.png' + '" border="0" />';
	}

	t.play = function(title_alt){
		if (title_alt == undefined) title_alt='Start';
		return '<img title="' + title_alt + '" alt="' + title_alt + '" src="'+img_prefix + 'NewsLetter/control_play_blue.png' + '" border="0" />';
	}
        t.play2 = function(title_alt){
		if (title_alt == undefined) title_alt='Start';
		return '<img title="' + title_alt + '" alt="' + title_alt + '" src="'+img_prefix + 'NewsLetter/control_fastforward_blue.png' + '" border="0" />';
	}
	t.stop = function(title_alt){
		if (title_alt == undefined) title_alt='Stop';
		return '<img title="' + title_alt + '" alt="' + title_alt + '" src="'+img_prefix + 'NewsLetter/control_stop_blue.png' + '" border="0" />';
	}
        t.send_mail = function(title_alt){
		if (title_alt == undefined) title_alt='Send mail';
		return '<img title="' + title_alt + '" alt="' + title_alt + '" src="'+img_prefix + 'NewsLetter/email_go.png' + '" border="0" />';
	}

}

var icon_const = new IconConst();