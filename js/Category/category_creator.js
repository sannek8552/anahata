Category_Creator = function()
{
	var t = this;

	var rm = 'category_creator';
	t.rm = rm;
	var oTreeView;
	var oTextNodeMap = {};
	var oCurrentTextNode = null;
	var params_to_back = {
		title : 'text',
		description : 'rich_edit',
		seo_url : 'text',
		page_title : 'text',
		keywords : 'text',
		page_description : 'text',
		google_priority : 'text',
		access: 'text',
		revisions: 'revisions',
		active : 'checkbox',
		published : 'checkbox'
	};
	t.params_to_back = params_to_back;
	t.oTextNodeMap = oTextNodeMap;
	t.oCurrentTextNode = oCurrentTextNode;

	var cut_node;
	t.cut_node = cut_node;

	var current_action = '';
	t.current_action = current_action;
	var current_id = 0;
	t.current_id = current_id;
	var current_node = null
	t.current_node = current_node;

	t.init_tree = function()
	{
		//alert(category_tree.root.title);
		oTreeView = new YAHOO.widget.TreeView("mytreeview");
		var oTextNode;

		var root_node = new YAHOO.widget.TextNode({label:category_tree.root.title,labelElId : category_tree.root.id, expanded :true}, oTreeView.getRoot());
		oTextNodeMap[root_node.labelElId] = root_node;

		this.attach_attributes(root_node, category_tree.root);

		for(var i in category_tree.sub)
		{

			if(category_tree.sub[i].parent_id != undefined && category_tree.sub[i].parent_id != null)
			oTextNode = new YAHOO.widget.TextNode({ label       :category_tree.sub[i].title,
			labelElId   :category_tree.sub[i].id,
			expanded    :false}, root_node);
			oTextNodeMap[oTextNode.labelElId] = oTextNode;
			//oTextNode.cms_data = {parent_id: category_tree[i].parent_id, title: category_tree[i].title, id : category_tree[i].id};
			this.attach_attributes(oTextNode, category_tree.sub[i]);
			if(category_tree.sub[i].sub != undefined && category_tree.sub[i].sub != null)
			this.build_sub_node(category_tree.sub[i].sub, oTextNode);


		}

		oTreeView.draw();
		this.init_menu();
	};

	t.attach_attributes = function(text_node, attrib)
	{
		text_node.cms_data = {parent_id: attrib.parent_id, title: attrib.title, published : attrib.published, active : attrib.active, id : attrib.id, order_id:parseInt(attrib.order_id)};
	}

	t.build_sub_node = function(sub, root)
	{
		for(var i in sub)
		{
			if(sub[i].parent_id != undefined && sub[i].parent_id != null)
			oTextNode = new YAHOO.widget.TextNode({label:sub[i].title,labelElId : sub[i].id, expanded :false}, root);
			oTextNodeMap[oTextNode.labelElId] = oTextNode;
			//oTextNode.cms_data = {parent_id: sub[i].parent_id, title: sub[i].title, id : sub[i].id};
			this.attach_attributes(oTextNode, sub[i]);
			if(sub[i].sub != undefined && sub[i].sub != null)
			this.build_sub_node(sub[i].sub, oTextNode);
		}
	};

	var oContextMenu;

	t.init_menu = function()
	{
		oContextMenu = new YAHOO.widget.ContextMenu("mytreecontextmenu", {
			trigger: "mytreeview",
			lazyload: true,
			itemdata: [
			/*{ text: "Add Child Node", onclick: { fn: addNode } },
			{ text: "Edit Node Label", onclick: { fn: editNodeLabel } },
			{ text: "Delete Node", onclick: { fn: deleteNode } }*/
			]});
			oContextMenu.subscribe("triggerContextMenu", t.onTriggerContextMenu);
	};

	t.addNode = function()
	{
		//alert('add' + this.oCurrentTextNode.cms_data.id);
		this.current_node = this.oCurrentTextNode;
		var req = new JsHttpRequest();
		var query = {};
		query['action'] = 'add';
		query['category_id'] = this.oCurrentTextNode.cms_data.id;
		req.creator = this;
		req.onreadystatechange = function()
		{
			if(4 == req.readyState)
			{
				req.creator.current_action = 'add';
				req.creator.current_id = req.responseJS.id;
				req.creator.clean_editor();
				$('category_editor_div').style.display = 'block';
				document.getElementById('bad_seo').innerHTML = '';
			}
		}
		req.caching = false;
		req.open('post', ajax_prefix + '?rm=' + this.rm, true);
		req.send(query);
	};

	t.editNode = function()
	{
		this.current_node = this.oCurrentTextNode;
		//alert('edit ' + this.oCurrentTextNode.cms_data.id);
		var req = new JsHttpRequest();
		var query = {};
		query['action'] = 'edit';
		query['category_id'] = this.oCurrentTextNode.cms_data.id;
		req.creator = this;
		req.onreadystatechange = function()
		{
			if(4 == req.readyState)
			{
				req.creator.current_action = 'edit';
				req.creator.current_id = req.responseJS.id;
				req.creator.place_params(req.responseJS);
				document.getElementById('bad_seo').innerHTML = '';
				$('category_editor_div').style.display = 'block';
			}
		}
		req.caching = false;
		req.open('post', ajax_prefix + '?rm=' + this.rm, true);
		req.send(query);

	};

	t.deleteNode = function()
	{
		//alert('delete ' + this.oCurrentTextNode.cms_data.title);

		if(this.oCurrentTextNode.cms_data.id != 0)
		{
			if(!confirm('Вы уверены что хотите удалить все категории и под-категории?'))
			return;
			var req = new JsHttpRequest();
			query = {};
			query['action'] = 'delete';
			query['category_id'] = this.oCurrentTextNode.cms_data.id;
			req.creator = this;
			req.onreadystatechange = function()
			{
				if(4 == req.readyState)
				{
					//alert('up');
				}
			}
			req.caching = false;
			req.open('post', ajax_prefix + '?rm=' + this.rm, true);
			req.send(query);

			delete oTextNodeMap[this.oCurrentTextNode.labelElId];

			oTreeView.removeNode(this.oCurrentTextNode);
			oTreeView.draw();
			req.creator.hide_editor();

		}
		else
		{
			alert('Невозможно удалить корневую категорию');
		}
	}

	t.clean_editor = function()
	{
		for(var i in this.params_to_back)
		{
			if('rich_edit' == this.params_to_back[i])
			{
				tinyMCE.get('description').setContent('');
			}
			else if('checkbox' == this.params_to_back[i])
			{
				$(i).checked = false;
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
		//need to clean special checkbox we have
		$('keep_open').checked = false;
		$('revisions').innerHTML = '';
	}

	t.loadRevision = function(id)
	{
		//this.current_node = this.oCurrentTextNode;
		//alert('edit ' + this.oCurrentTextNode.cms_data.id);
		var req = new JsHttpRequest();
		var query = {};
		query['action'] = 'loadRevision';
		query['rev_id'] = id;
		req.creator = this;
		req.onreadystatechange = function()
		{
			if(4 == req.readyState)
			{

				req.creator.current_action = 'edit';
				req.creator.current_id = req.responseJS.record_id;
				req.creator.place_params(req.responseJS);
				$('page_editor_div').style.display = 'block';
				document.getElementById('bad_seo').innerHTML = '';
			}
		}
		req.caching = false;
		req.open('post', ajax_prefix + '?rm=' + this.rm, true);
		req.send(query);

	};

	t.preview = function(close)
	{
		if(!close)
		{

			var myWidth = 0, myHeight = 0;
			if( typeof( window.innerWidth ) == 'number' ) {
				//Non-IE
				myHeight = window.innerHeight;
			} else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
				//IE 6+ in 'standards compliant mode'
				myHeight = document.documentElement.clientHeight;
			} else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
				//IE 4 compatible
				myHeight = document.body.clientHeight;
			}
			myWidth = document.body.clientWidth-3;

			if(this['preview_panel'] == undefined)
			{
				this['preview_panel'] = new YAHOO.widget.Panel('preview_panel',{
					x:0,
					y:0,
					width: myWidth-20+'px',
					height: myHeight+'px',
					visible: true,
					close: false,
					constraintoviewport: true,
					fixedcenter: false,
					modal: true,
					draggable: false
					//context: [this['preview_panel'],"tl","tl"]


				});



			}

			this['preview_panel'].setHeader('Preview <a class="container-close" href="javascript:void(0);" onclick="category_creator.preview(true)">Close</a>');
			this['preview_panel'].setBody('Loading...');
			this['preview_panel'].setFooter('');
			this['preview_panel'].render(document.body);

			var query = this.get_params();
			query['id'] = this.oCurrentTextNode.cms_data.id;
			query['action'] = this.current_action;
			var req = new JsHttpRequest();
			req.overlay = this['preview_panel'];
			req.onreadystatechange = function()
			{

				if(req.readyState == 4)
				{

					req.overlay.setBody('<iframe src="'+req.responseJS.url+'category_preview.html" width="100%" height="100%">Can\'t load iFraim</iframe>');
					req.overlay.show();
					document.getElementById('preview_panel').style.width =  myWidth+'px';
					document.getElementById('preview_panel').style.height = myHeight+'px';
					document.getElementById('preview_panel_c').style.width =  myWidth+'px';
					document.getElementById('preview_panel_c').style.height = myHeight+'px';
					document.getElementById('preview_panel_mask').style.height = myHeight+'px';
					document.getElementById('preview_panel_c').style.left = 0;
					document.getElementById('preview_panel_c').style.right = 0;
					document.getElementById('preview_panel_c').style.padding = 0;
					document.getElementById('preview_panel_c').style.top = 0;
					document.getElementById('preview_panel_c').style.zIndex = 1000;


				}
			}
			req.caching = false;
			req.open('POST', ajax_prefix + '?rm=ajax_category_preview', true);
			req.send(query);
		}
		else
		{
			if(this['preview_panel'] != undefined)
			{
				this['preview_panel'].destroy();
				delete this['preview_panel'];
			}
		}

	};

	t.hide_editor = function()
	{
		$('category_editor_div').style.display = 'none';
		/*if(document.location.href.indexOf('#saved') == -1)
		{
		document.location = document.location + '#saved';
		}
		else
		{
		document.location = document.location;
		}*/
	}

	t.save = function()
	{
		var req = new JsHttpRequest();
		var query = this.get_params();
		query['action'] = this.current_action;
		query['category_id'] = this.current_id;
		query['save'] = true;
		req.creator = this;
		req.onreadystatechange = function()
		{
			if(4 == req.readyState)
			{
				if(req.responseJS.errors)
				{

					var errors = req.responseJS.errors;
					if(errors.seo_url == 1)
					{
						document.getElementById('bad_seo').innerHTML = '<font color=\"red\">Unavailable Seo url </font>';
					}
				}
				else
				{

					if($('keep_open').checked)
					{
						document.getElementById('bad_seo').innerHTML = '';
					}
					else
					{
						req.creator.hide_editor();
					}
					if('add' == req.creator.current_action)
					{
						//alert(req.responseJS.title);
						var attr = {label:req.responseJS.title, labelElId : req.responseJS.id, expanded :false,active:req.responseJS.active,published:req.responseJS.published};
						oChildNode = new YAHOO.widget.TextNode(attr, req.creator.current_node, false);

						req.creator.oTextNodeMap[oChildNode.labelElId] = oChildNode;
						req.creator.attach_attributes(oChildNode, req.responseJS);
						req.creator.reorder_menu(req.creator.current_node);
						req.creator.current_node.expand();
						req.creator.current_node.refresh();
						oTreeView.draw();
						req.creator.current_action = 'edit';
						req.creator.current_id = req.responseJS.id;
						req.creator.current_node = oChildNode;
						//alert('current_id '+req.responseJS.id);
					}
					else
					{
						req.creator.oTextNodeMap[req.creator.current_node.labelElId].label = req.responseJS.title;
						req.creator.oTextNodeMap[req.creator.current_node.labelElId].active = req.responseJS.active;
						req.creator.oTextNodeMap[req.creator.current_node.labelElId].published = req.responseJS.published;
						req.creator.current_node.getLabelEl().innerHTML = req.responseJS.title;
					}
					alert('saved');
				}
			}
		}
		req.caching = false;
		req.open('post', ajax_prefix + '?rm=' + this.rm, true);
		req.send(query);
	};

	t.reorder_menu = function(node)
	{
		//alert('node.children.length '+node.children.length);
		var temp_node;
		var idx;
		for(var i = 0; i< node.children.length-1;i++)
		{
			temp_node = node.children[i];
			idx = i;
			for(var j = i+1;j < node.children.length;j++)
			{
				if(node.children[j].cms_data.order_id < node.children[idx].cms_data.order_id)
				{
					idx = j;
				}
			}
			node.children[i] = node.children[idx];
			node.children[idx] = temp_node;

		}
		return true;
	}

	/*Cancel current editor*/
	t.cancel = function()
	{
		this.hide_editor();
	}

	t.get_params = function()
	{
		var params = {};
		for(var i in this.params_to_back)
		{
			if('rich_edit' == this.params_to_back[i])
			{
				//alert(tinyMCE.get('description'));
				params[i] = tinyMCE.get('description').getContent();
			}
			else if('checkbox' == this.params_to_back[i])
			{
				params[i] = $(i).checked ? 1 : 0;
			}
			else
			{
				if($(i).nodeName=='SELECT')
				{
					params[i] = $(i).value;
				}
				else
				{

					params[i] = $(i).value;
				}
			}
		}
		return params;
	};

	t.place_params = function(params)
	{

		for(var i in this.params_to_back)
		{
			if('rich_edit' == this.params_to_back[i])
			{
				tinyMCE.get('description').setContent(params[i]);
			}
			else
			{
				if($(i).nodeName=='SELECT')
				{
					$(i).value = params[i];
				}
				else
				{

					if($(i).type=='checkbox')
					{
						if(params[i] == 1)
						{
							$(i).checked = true;
						}
						else
						{
							$(i).checked = false;
						}
					}
					else
					{
						if('created' == this.params_to_back[i])
						{
							$(i).innerHTML = '<strong> Created at: </strong>' + params[i] + ' by: '+ params['created_user_id'];
						}
						if('updated' == this.params_to_back[i])
						{
							$(i).innerHTML = '<strong> Last modified at: </strong>' + params[i] + ' by: '+ params['updated_user_id'];
						}
						if('revisions' == this.params_to_back[i])
						{
							var rev_text = '';
							var revisions = params[i];
							for(var j = 0; j < revisions.length; j++)
							{
								//alert(revisions[j]);
								rev_text += '<div class="rev_item"><a href="javascript:void(0)" onclick="category_creator.loadRevision('+revisions[j]["id"]+')">'+revisions[j]["created"]+' </a></div>'
							}

							$(i).innerHTML = rev_text;
						}
						else
						{$(i).value = params[i];}
					}
				}
			}
		}
	};

	t.moveUp = function()
	{

		var parent_node = this.oCurrentTextNode.parent;

		for(var i = 0; i < parent_node.children.length;i++)
		{
			if(parent_node.children[i].cms_data.id==this.oCurrentTextNode.cms_data.id)
			{
				//if(i != 0)
				//{

				var temp = parent_node.children[i-1].cms_data.order_id;
				parent_node.children[i-1].cms_data.order_id = parent_node.children[i].cms_data.order_id;
				parent_node.children[i].cms_data.order_id = temp;

				//send request to server to perform same operation
				var req = new JsHttpRequest();
				//var query = this.get_params();
				query = {};
				query['action'] = 'move_up';
				query['category_id'] = this.oCurrentTextNode.cms_data.id;
				req.creator = this;
				req.onreadystatechange = function()
				{
					if(4 == req.readyState)
					{
						//alert('up');
					}
				}
				req.caching = false;
				req.open('post', ajax_prefix + '?rm=' + this.rm, true);
				req.send(query);
				break;
				//}
			}
		}
		this.reorder_menu(parent_node);
		parent_node.refresh();
		//alert('up ' + this.oCurrentTextNode.cms_data.id);
	}

	t.moveDown = function()
	{
		var parent_node = this.oCurrentTextNode.parent;

		for(var i = 0; i < parent_node.children.length;i++)
		{
			if(parent_node.children[i].cms_data.id==this.oCurrentTextNode.cms_data.id)
			{
				if(i != parent_node.children.length-1)
				{
					var temp = parent_node.children[i+1].cms_data.order_id;
					parent_node.children[i+1].cms_data.order_id = parent_node.children[i].cms_data.order_id;
					parent_node.children[i].cms_data.order_id = temp;
					//send request to server to perform same operation
					var req = new JsHttpRequest();
					//var query = this.get_params();
					query = {};
					query['action'] = 'move_down';
					query['category_id'] = this.oCurrentTextNode.cms_data.id;
					req.creator = this;
					req.onreadystatechange = function()
					{
						if(4 == req.readyState)
						{
							//alert('down');
						}
					}
					req.caching = false;
					req.open('post', ajax_prefix + '?rm=' + this.rm, true);
					req.send(query);
					break;
				}
			}
		}
		this.reorder_menu(parent_node);
		parent_node.refresh();
		//alert('down ' + this.oCurrentTextNode.cms_data.id);
	}
	
	t.publish = function()
	{
		//send request to server to perform same operation
		var req = new JsHttpRequest();
		//var query = this.get_params();
		query = {};
		query['action'] = 'publish';
		query['category_id'] = this.oCurrentTextNode.cms_data.id;
		req.current_node = this.oCurrentTextNode;
		req.creator = this;
		req.onreadystatechange = function()
		{
			if(4 == req.readyState)
			{
				req.current_node.cms_data.published = 1;
			}
		}
		req.caching = false;
		req.open('post', ajax_prefix + '?rm=' + this.rm, true);
		req.send(query);
		//break;
		//alert('publish ' + this.oCurrentTextNode.cms_data.id);
	}
	
	t.unpublish = function()
	{
		var req = new JsHttpRequest();
		//var query = this.get_params();
		query = {};
		query['action'] = 'unpublish';
		query['category_id'] = this.oCurrentTextNode.cms_data.id;
		req.current_node = this.oCurrentTextNode;
		req.creator = this;
		req.onreadystatechange = function()
		{
			if(4 == req.readyState)
			{
				req.current_node.cms_data.published = 0;
			}
		}
		req.caching = false;
		req.open('post', ajax_prefix + '?rm=' + this.rm, true);
		req.send(query);
		//alert('unpublish ' + this.oCurrentTextNode.cms_data.id);
	}
	
	t.activate = function()
	{
		var req = new JsHttpRequest();
		//var query = this.get_params();
		query = {};
		query['action'] = 'activate';
		query['category_id'] = this.oCurrentTextNode.cms_data.id;
		req.current_node = this.oCurrentTextNode;
		req.creator = this;
		req.onreadystatechange = function()
		{
			if(4 == req.readyState)
			{
				req.current_node.cms_data.active = 1;
			}
		}
		req.caching = false;
		req.open('post', ajax_prefix + '?rm=' + this.rm, true);
		req.send(query);
		//alert('Activate ' + this.oCurrentTextNode.cms_data.id);
	}
	
	t.deactivate = function()
	{
		var req = new JsHttpRequest();
		//var query = this.get_params();
		query = {};
		query['action'] = 'deactivate';
		query['category_id'] = this.oCurrentTextNode.cms_data.id;
		req.current_node = this.oCurrentTextNode;
		req.creator = this;
		req.onreadystatechange = function()
		{
			if(4 == req.readyState)
			{
				req.current_node.cms_data.active = 0;
			}
		}
		req.caching = false;
		req.open('post', ajax_prefix + '?rm=' + this.rm, true);
		req.send(query);
		//alert('Deactivate ' + this.oCurrentTextNode.cms_data.id);
	}

	t.cut = function()
	{
		this.cut_node = this.oCurrentTextNode;
	};

	t.can_paste = function(node_cut, node_paste)
	{
		if(node_cut == node_paste)
		{
			return false;
		}
		var temp_node = node_paste.parent;
		while(!temp_node.isRoot())
		{
			if(temp_node == node_cut)
			return false;
			temp_node = temp_node.parent;
		}
		return true;
	};

	t.paste = function()
	{
		if(!this.can_paste(this.cut_node, this.oCurrentTextNode))
		{
			alert('can not paste');
			return false;
		}

		var req = new JsHttpRequest();
		//var query = this.get_params();
		query = {};
		query['action'] = 'move';
		query['to'] = this.oCurrentTextNode.cms_data.id;
		query['category_id'] = this.cut_node.cms_data.id;
		req.current_node = this.oCurrentTextNode;
		req.creator = this;
		req.cut_node = this.cut_node;
		req.current_node = this.oCurrentTextNode;
		req.onreadystatechange = function()
		{
			if(4 == req.readyState)
			{
				//need to change parent of the cut_node to current node
				var temp_parent = req.cut_node.parent;

				oTreeView.popNode(req.cut_node);
				var max = 1;
				for(var i =0; i < req.current_node.children.length;i++)
				{
					max = req.current_node.children[i].cms_data.order_id + 1;
				}
				req.cut_node.cms_data.order_id = max;
				req.cut_node.appendTo(req.current_node);
				req.current_node.refresh();
				req.current_node.expand();
				oTreeView.draw();
				req.creator.cut_node = null;
			}
		}
		req.caching = false;
		req.open('post', ajax_prefix + '?rm=' + this.rm, true);
		req.send(query);



	};

	t.populate_seo = function(auto)
	{
		//alert('populate');
		if(!auto || $('seo_url').value.length == 0)
		{
			var page_title = $('page_title').value;
			page_title = page_title.replace(/\s/g,'-');
			page_title = page_title.replace(/\&/g,'and');
			page_title = page_title.replace(/([^a-z|A-Z|\d|\-])/g,'');
			$('seo_url').value = page_title;
			//alert('populated');
		}

	};

	t.onTriggerContextMenu = function(p_oEvent)
	{
		var oTarget = this.contextEventTarget,
		Dom = YAHOO.util.Dom;

		var oTextNode = YAHOO.util.Dom.hasClass(oTarget, "ygtvlabel") ?
		oTarget : Dom.getAncestorByClassName(oTarget, "ygtvlabel");
		if (oTextNode)
		{
			category_creator.oCurrentTextNode = category_creator.oTextNodeMap[oTarget.id];
		}
		else
		{
			this.cancel();
			return;
		}
		var items = this.getItems();
		var groups = this.getItemGroups();
		//alert(items.length);
		//alert(groups.length);
		var len = items.length;
		for(var i = 0; i < len; i++)
		{
			this.removeItem(0);
		}
		//alert(oCurrentTextNode.cms_data.parent_id);
		var ad_item;
		var edit_option = {classname : 'edit_page', text: 'Редактировать', onclick: {fn: category_creator.editNode,scope: category_creator}};
		var add_option = {classname : 'add_page', text: 'Добавить', onclick: {fn: category_creator.addNode,scope: category_creator}};
		var delete_option = {classname : 'delete_page', text: 'Удалить', onclick: {fn: category_creator.deleteNode, scope: category_creator}};
		var spacer_option = {text: "<hr/>",disabled:true,classname : 'spacer_page'};
		
		var publish_option = {classname : 'publish_page', text: 'Опубликовать', onclick: {fn: category_creator.publish,scope: category_creator}};
		var unpublish_option = {classname : 'unpublish_page', text: 'Не опубликовывать', onclick: {fn: category_creator.unpublish,scope:category_creator}};

		var activate_option = {classname : 'activate_page', text: 'Активировать', onclick: {fn: category_creator.activate,scope:category_creator}};
		var deactivate_option = {classname : 'deactivate_page', text: 'Деактивировать', onclick: {fn: category_creator.deactivate, scope:category_creator}};

		var move_up = {classname : 'move_up', text: 'Переместить вверх', onclick: {fn: category_creator.moveUp, scope: category_creator}};
		var move_down = {classname : 'move_down', text: 'Переместить вниз', onclick: {fn: category_creator.moveDown, scope: category_creator}};

		var cut = {classname : 'cut_page', text: 'Вырезать', onclick: {fn: category_creator.cut, scope: category_creator}};
		var paste = {disabled:true,classname : 'paste_page', text: 'Вставить', onclick: {fn: category_creator.paste, scope: category_creator}};


		/* ad_item = [
		edit_option,
		delete_option,
		add_option



		];*/
		//alert('id '+category_creator.oCurrentTextNode.cms_data.id);
		if(category_creator.oCurrentTextNode.cms_data.id == 0)
		{
			ad_item = [
			add_option,
			spacer_option

			];

		}
		else
		{
			ad_item = [
			edit_option,
			delete_option,
			add_option];
			
			if(category_creator.oCurrentTextNode.cms_data.published == 1)
			{
				ad_item[ad_item.length] = unpublish_option;
			}
			else
			{
				ad_item[ad_item.length] = publish_option;
			}
			
			if(category_creator.oCurrentTextNode.cms_data.active == 1)
			{
				ad_item[ad_item.length] = deactivate_option;
			}
			else
			{
				ad_item[ad_item.length] = activate_option;
			}
			
			ad_item[ad_item.length] = spacer_option;
			ad_item[ad_item.length] = move_up;
			ad_item[ad_item.length] = move_down;
			ad_item[ad_item.length] = spacer_option;
			ad_item[ad_item.length] = cut;
			/*
			spacer_option,
			move_up,
			move_down,
			spacer_option,
			cut
			];
			*/
		}
		
		/*if(category_creator.oCurrentTextNode.cms_data.active == 1)
		{
		ad_item[ad_item.length] = deactivate_option;
		}
		else
		{
		ad_item[ad_item.length] = activate_option;
		}*/



		if(category_creator.cut_node != null && category_creator.cut_node != undefined && category_creator.can_paste(category_creator.cut_node,category_creator.oCurrentTextNode))
		paste.disabled = false;
		ad_item[ad_item.length] = paste;
		this.addItems(ad_item);
		this.render(document.body);
	};
};


YAHOO.util.Event.onDOMReady(init_tree);

var category_creator = new Category_Creator();

function init_tree()
{

	category_creator.init_tree();
}