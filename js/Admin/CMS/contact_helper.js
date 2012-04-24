function contact_process_type_change()
{
	//alert($('field_type_id').value);
	if($('field_type_id').value == 'select')
	{
		$('select_div_id').style.display = 'block';
	}
	else
	{
		$('select_div_id').style.display = 'none';
	}
	
	if($('field_type_id').value == 'file')
	{
		$('file_div_id').style.display = 'block';
	}
	else
	{
		$('file_div_id').style.display = 'none';
	}
}

function contact_add_choice()
{
	var container = $('select_container_id');
	var new_div = document.createElement('div');
	var new_input = document.createElement('input');
	new_input.type = 'text';
	new_input.name = 'select_answer[]';
	
	new_div.appendChild(new_input);
	
	container.appendChild(new_div);
}

function contact_remove_choice()
{
	var container = $('select_container_id');
	container.removeChild(container.lastChild);
}