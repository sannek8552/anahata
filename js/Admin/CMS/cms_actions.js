var cms_actions = 
{
	'type_selected' : function(type)
	{
		var req = new JsHttpRequest();
		var query = {};
		query['type'] = type;
		//alert(type);
		//query['rm'] = cms.runmode;
		query['action'] = 'strategy_run';
		query['parent_id'] = cms.parent_id;
		req.onreadystatechange = function()
		{
			if(4 == req.readyState)
			{
				//alert(req.responseText);
				//alert(req.responseJS.status);
				if('false' == req.responseJS.status)
				{
					//alert(req.responseJS.message);
					cms.show_fail_message(req.responseJS.message);
					return;
				}
				cms.change_type(req.responseJS.type);
				cms.params_to_back = req.responseJS.params_to_back;
				cms.place_content(req.responseJS.content);
			}
		}
		//alert(ajax_prefix);
		req.caching = false;
		req.open('post', ajax_prefix + '?rm=' + cms.runmode, true);
		req.send(query);
	},
	
	'prev_step' : function(type)
	{
		var req = new JsHttpRequest();
		var query = {};
		query['type'] = type;
		//alert(type);
		//query['rm'] = cms.runmode;
		query['action'] = 'strategy_run';
		query['step'] = 'prev';
		req.onreadystatechange = function()
		{
			if(4 == req.readyState)
			{
				//alert(req.responseText);
				//alert(req.responseJS.status);
				if('false' == req.responseJS.status)
				{
					//alert(req.responseJS.message);
					cms.show_fail_message(req.responseJS.message);
					return;
				}
				cms.params_to_back = req.responseJS.params_to_back;
				cms.change_type(req.responseJS.type);
				cms.place_content(req.responseJS.content);
			}
		}
		//alert(ajax_prefix);
		req.caching = false;
		req.open('post', ajax_prefix + '?rm=' + cms.runmode, true);
		req.send(query);
		//alert('cms action go prev ' + type);
	},
	'new_page' : function(parent_id)
	{
		var req = new JsHttpRequest();
		var query = {};
		query['new_page'] = 'new_page';
		query['action'] = 'strategy_run';
		query['parent_id'] = parent_id;
		//alert(parent_id);
		req.onreadystatechange = function()
		{
			if(4 == req.readyState)
			{
				//alert(req.responseText);
				//alert(req.responseJS.status);
				if('false' == req.responseJS.status)
				{
					//alert(req.responseJS.message);
					cms.show_fail_message(req.responseJS.message);
					return;
				}
				cms.change_type(req.responseJS.type);
				cms.place_content(req.responseJS.content);
			}
		}
		//alert(ajax_prefix);
		req.caching = false;
		req.open('post', ajax_prefix + '?rm=' + cms.runmode, true);
		req.send(query);
	},
	'view_item' : function()
	{
		
		var req = new JsHttpRequest();
		var query = {};
		query['current_action'] = cms.current_action;
		query['action'] = 'strategy_run';
		query['view_id'] = cms.view_id;
		
		req.onreadystatechange = function()
		{
			if(4 == req.readyState)
			{
		
				if('false' == req.responseJS.status)
				{
		
					cms.show_fail_message(req.responseJS.message);
					return;
				}
				cms.place_content(req.responseJS.content,req.responseJS.text_to_init);
				
			}
		}
		req.caching = false;
		req.open('post', ajax_prefix + '?rm=' + cms.runmode, true);
		req.send(query);
	},
	/*'info_item' : function(view_id)
	{
		
		var req = new JsHttpRequest();
		var query = {};
		query['new_page'] = 'info_page';
		query['action'] = 'strategy_run';
		query['edit_id'] = view_id;
		query['step'] = 'info';
		//alert(parent_id);
		//alert('here');
		req.onreadystatechange = function()
		{
			if(4 == req.readyState)
			{
				//alert(req.responseText);
				//alert(req.responseJS.status);
				if('false' == req.responseJS.status)
				{
					//alert(req.responseJS.message);
					cms.show_fail_message(req.responseJS.message);
					return;
				}
				//alert('here');
				cms.change_type(req.responseJS.type);
				cms.params_to_back = req.responseJS.params_to_back;
				//alert(req.responseJS.text_to_init);
				cms.place_content(req.responseJS.content,req.responseJS.text_to_init);
				//alert(req.responseJS.text_to_init);
				
			}
		}
		//alert(ajax_prefix);
		req.caching = false;
		req.open('post', ajax_prefix + '?rm=' + cms.runmode, true);
		req.send(query);
	},*/
	'active_item' : function(view_id,active)
	{
		
		var req = new JsHttpRequest();
		var query = {};
		query['current_action'] = cms.current_action;
		query['action'] = 'strategy_run';
		query['edit_id'] = view_id;
		
		query['active'] = active;
		
		req.onreadystatechange = function()
		{
			if(4 == req.readyState)
			{
				
				if('false' == req.responseJS.status)
				{
					
					cms.show_fail_message(req.responseJS.message);
					return;
				}
				
				cms.place_content(req.responseJS.content,req.responseJS.text_to_init);
				
				
			}
		}
		
		req.caching = false;
		req.open('post', ajax_prefix + '?rm=' + cms.runmode, true);
		req.send(query);
	},
	
	'publish_item' : function(view_id,active)
	{
		var req = new JsHttpRequest();
		var query = {};
		query['current_action'] = cms.current_action;
		query['action'] = 'strategy_run';
		query['edit_id'] = view_id;
		query['publish'] = active;
		
		req.onreadystatechange = function()
		{
			if(4 == req.readyState)
			{
		
				if('false' == req.responseJS.status)
				{
		
					cms.show_fail_message(req.responseJS.message);
					return;
				}
				cms.place_content(req.responseJS.content,req.responseJS.text_to_init);
				
			}
		}
		//alert(ajax_prefix);
		req.caching = false;
		req.open('post', ajax_prefix + '?rm=' + cms.runmode, true);
		req.send(query);
	},
	
	
	'edit_item' : function()
	{
		var req = new JsHttpRequest();
		var query = {};
		query['current_action'] = cms.current_action;
		query['action'] = 'strategy_run';
		query['edit_id'] = cms.edit_id;
		
		req.onreadystatechange = function()
		{
			if(4 == req.readyState)
			{
				if('false' == req.responseJS.status)
				{
					cms.show_fail_message(req.responseJS.message);
					return;
				}
				cms.place_params(req.responseJS.params);
			}
		}
		req.caching = false;
		req.open('post', ajax_prefix + '?rm=' + cms.runmode, true);
		req.send(query);
	},
	
	'next_step' : function()
	{
		var req = new JsHttpRequest();
		var query = {};
		query['action'] = 'strategy_run';
		query['step'] = 'next';
		query['current_action'] = cms.current_action;
		query['parent_id'] = cms.parent_id;
		query['edit_id'] = cms.edit_id;
		query['params_to_save'] = {};
		for(var i in cms.params_to_back)
		{
			if('rich_edit' == cms.params_to_back[i])
			{
				query['params_to_save'][i] = tinyMCE.get('simple_module_contentid').getContent();
				//alert(tinyMCE.getContent());
			}
			else if('javascript' == cms.params_to_back[i])
			{
				query['params_to_save'][i] = eval('query[\'params_to_save\'][i]='+i);
				//alert(query['params_to_save'][i]);
			}
			else
			{
				query['params_to_save'][i] = $(i).value;
			}
		}
		req.onreadystatechange = function()
		{
			if(4 == req.readyState)
			{
				if('false' == req.responseJS.status)
				{
					cms.show_fail_message(req.responseJS.message);
					return;
				}
				cms.hide();
				cms.rebuild_menu();
				
			}
		}
		
		req.caching = false;
		req.open('post', ajax_prefix + '?rm=' + cms.runmode, true);
		req.send(query);
	},
	
	'delete_item' : function(item_id)
	{
		var query = {};
		query['to_delete'] = item_id;
		query['current_action'] = cms.current_action;
		var req = new JsHttpRequest();
		req.onreadystatechange = function()
		{
			if(4 == req.readyState)
			{
				if('false' == req.responseJS.status)
				{
					cms.show_fail_message(req.responseJS.message);
					return;
				}
				cms.place_content('Item deleted' , '');
				cms.rebuild_menu();
			}
		}
		
		req.caching = false;
		req.open('post', ajax_prefix + '?rm=' + cms.runmode, true);
		req.send(query);
	}
	
}