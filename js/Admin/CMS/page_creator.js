
function CMS(id)
{
	//this.select_type = select_type;
	this.runmode = 'page_master_ajax';
	this.type = '';
	this.params_to_back = {
			title : 'text',
			simple_module_contentid : 'rich_edit',
			page_title : 'text', 
			keywords : 'text',
			page_description : 'text',
			seo_url : 'text',
			google_priority : 'text',
			template : 'text'
			};
	this.parent_id = '';
	this.edit_id = '';
	this.hide = hide;
	this.current_action = '';
	this.show_fail_message = show_fail_message;
	this.place_content = place_content;
	//this.change_type = change_type;
	//this.prev_step = prev_step;
	this.next_step = next_step;
	this.new_item = new_item;
	this.rebuild_menu = rebuild_menu;
	this.edit_item = edit_item;
	this.view_item = view_item;
	this.info_item = info_item;
	this.active_item = active_item;
	this.publish_item = publish_item;
	
	this.delete_item = delete_item;
	
	this.clear_process = clear_process;
	
	this.place_params = place_params;
	
	function place_params(params)
	{
		var master_div = $('page_master_div');
		var page_editor_div = $('page_editor_div');
		
		master_div.style.display = 'none';
		page_editor_div.style.display = 'block';
		for(var i in cms.params_to_back)
		{
			if('rich_edit' == cms.params_to_back[i])
			{
				tinyMCE.get('simple_module_contentid').setContent(params[i]);
			}
			else
			{
				if($(i).nodeName=='SELECT')
				{
					$(i).value = params[i];
				}
				else
				{
					$(i).value = params[i];
				}
			}
		}
	}
	
	function select_type(type_id)
	{
		var master_div = $('page_master_div');
		cms_actions.type_selected(type_id);
	}
	
	function show_fail_message(message)
	{
		
		alert(message);
	}
	
	function place_content(content, text_to_init)
	{
		//alert('here');
		var master_div = $('page_master_div');
		var page_editor_div = $('page_editor_div');
		
		master_div.innerHTML = content;
		
		if(text_to_init)
		{
			eval(text_to_init);
		}
		master_div.style.display = 'block';
		page_editor_div.style.display = 'none';
			
	}
	
	/*function change_type(type)
	{
		//alert('in change_type');
		this.type = type;
	}*/
	
	/*function prev_step()
	{
		//unload_tiny();
		cms_actions.prev_step(this.type);
		
	}*/
	
	function next_step()
	{
		if(this.current_action == 'edit_item')
			this.current_action = 'save_item';
		cms_actions.next_step();
	}
	
	function new_item(parent_id)
	{
		this.clear_process();
		
		this.parent_id = parent_id;
		this.current_action = 'new_page';
		
		var master_div = $('page_master_div');
		var page_editor_div = $('page_editor_div');
		master_div.style.display = 'none';
		page_editor_div.style.display = 'block';
		
	}
	
	function info_item(menu_id)
	{
		this.clear_process();
		this.info_id = menu_id;
		//unload_tiny();
		cms_actions.info_item(menu_id);
	}
	
	function active_item(menu_id,active)
	{
		this.clear_process();
		this.active_id = menu_id;
		this.current_action = 'active_item';
		cms_actions.active_item(menu_id, active);
	}
	
	function publish_item(menu_id,active)
	{
		this.clear_process();
		this.active_id = menu_id;
		this.current_action = 'publish_item';
		
		cms_actions.publish_item(menu_id,active);
	}
	
	function view_item(menu_id)
	{
		
		this.clear_process();
		this.view_id = menu_id;
		this.current_action = 'view_item';
		
		cms_actions.view_item();
	}
	
	function edit_item(menu_id)
	{
		this.clear_process();
		this.current_action = 'edit_item';
		this.edit_id = menu_id;
		cms_actions.edit_item();
	}
	
	function delete_item(menu_id)
	{
		
		this.clear_process();
		this.current_action = 'delete_item';
		cms_actions.delete_item(menu_id);
	}
	
	function rebuild_menu()
	{
		
		tree.refresh_tree(1);
		//tree.refresh_menu(final_params.edit_id);
		this.clear_process();
		if(document.location.href.indexOf('#saved') == -1)
		{
			document.location = document.location + '#saved';
		}
		else
		{
			document.location = document.location;
		}
	}
	
	function clear_process()
	{
		this.type = '';
		this.parent_id = '';
		this.edit_id = '';
		this.view_id = '';
		this.current_action = '';
		for(var i in cms.params_to_back)
		{
			if('rich_edit' == cms.params_to_back[i])
			{
				tinyMCE.get('simple_module_contentid').setContent('');
			}
			else
			{
				if($(i).nodeName=='SELECT')
				{
					$(i).selectedIndex = 0;
				}
				else
				{
					$(i).value = '';
				}
			}
		}
	}
	
	function hide()
	{
		var master_div = $('page_master_div');
		var page_editor_div = $('page_editor_div');
		master_div.style.display = 'none';
		page_editor_div.style.display = 'none';
	}
}

cms = new CMS();
/*function init_tiny()
{
	//if(null != document.getElementById('simple_module_contentid'))
	//	tinyMCE.execCommand('mceAddControl', false, 'simple_module_contentid');
	//var sc = document.createElement('script');
	//sc.src = js_prefix + 'init_tiny.js';
	//document.body.appendChild(sc);
	
}
function unload_tiny()
{
	//tinyMCE.execCommand('mceRemoveControl', false, 'txaEditableContent');
	//if(null != document.getElementById('simple_module_contentid') && tinyMCE.get('simple_module_contentid') != undefined)
	//	tinyMCE.execCommand('mceRemoveControl', false,  'simple_module_contentid');
}*/