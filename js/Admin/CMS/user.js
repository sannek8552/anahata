User = function()
{
	var t= this;
	t.filter = {'login':"",'last_name':"",'first_name':"",'groups':"",'email':""};
	
	t.function_formatter = function(eCell, oRecord, oColumn, oData)
	{
		
		eCell.data_table_i = this;
		var edit_href = '';
		var password_href = '';
		
		edit_href = '<a href="javascript:void(0);" onclick="user.edit('+oData+');">'+icon_const.edit('Edit Users')+'</a>';
		password_href = '<a href="javascript:void(0);" onclick="user.change_password('+oData+');">'+icon_const.lock_edit('Change Password')+'</a>';
		

		var details_href = '<a href="javascript:void(0);" onclick="user.details('+oData+',this);">'+icon_const.detail('User Details')+'</a>';
		
		var delete_href = '';
		delete_href = '<a href="javascript:void(0);" onclick="user.delete_user('+oData+');">'+icon_const.delete_i()+'</a>';
		

		//var access = '<a href="'+ajax_prefix+'AccessRights/'+oRecord.getData('department_id')+'/'+oRecord.getData('user_id')+'.html">'+icon_const.access('Access')+'</a>';
		//var login_as = '<a href="javascript:void(0);" onclick="user.login_as('+oData+');">'+icon_const.login_as()+'</a>';
		//if(!admin_user)
		login_as = '';
		eCell.innerHTML = details_href + '' + login_as + '' + edit_href + '' + password_href + delete_href;
	};

	t.delete_user = function(user_id)
	{
		if(!confirm('Are you sure?'))
			return false;
		
		params = {user_id: user_id};
		var req = new JsHttpRequest();
		
		req.onreadystatechange = function()
		{
			if(req.readyState == 4)
			{
				user_list.onPaginatorChangeRequest(user_list.getState().pagination);
			}
		}
		req.caching = false;
		req.open('POST', ajax_prefix + '?rm=ajax_delete_user', true);
		req.send(params);
	};
	
	t.login_as = function(user_id)
	{
		//alert('logging in as ' + user_id);
		document.location = ajax_prefix + 'login_as/' + user_id + '.html';
	};
	
	t.details = function(user_id, cell)
	{
		if(this['d_l_overlay' + user_id] == undefined)
		{
			this['d_l_overlay' + user_id] = new YAHOO.widget.Panel('d_l_overlay' + user_id,{
				width: "300px",//"900px",
				//height: "650px",
				visible:true,
				close: true,
				/*x: YAHOO.util.Dom.getViewportWidth() / 2,
				y: YAHOO.util.Dom.getViewportHeight() / 2 - 150,*/
				constraintoviewport:true,
				fixedcenter:true,
				modal:true,
				draggable:false,
				zIndex: 1000
			});
		}
		
		this['d_l_overlay' + user_id].setHeader('User Details');
		this['d_l_overlay' + user_id].setBody('Loading...');
		this['d_l_overlay' + user_id].setFooter('');
		this['d_l_overlay' + user_id].render(document.body);
		params = {user_id: user_id};
		var req = new JsHttpRequest();
		//req.information_div = info_div;
		req.data_table_i = cell.data_table_i;
		req.overlay = this['d_l_overlay' + user_id];
		req.onreadystatechange = function()
		{
			if(req.readyState == 4)
			{
				//$(req.information_div).innerHTML = req.responseJS.html;
				//tab_view.selectTab(2);
				//req.overlay.setHeader('Agent Details');
				req.overlay.setBody(req.responseJS.html);
				req.overlay.setFooter('');
				req.overlay.show();
			}
		}
		req.caching = false;
		req.open('POST', ajax_prefix + '?rm=ajax_get_user_information', true);
		req.send(params);
	};

        t.add = function(info_div)
	{
		if(this['a_l_overlay'] == undefined)
		{
			this['a_l_overlay'] = new YAHOO.widget.Panel('a_l_overlay',{
				width: "300px",//"900px",
				//height: "650px",
				visible:true,
				close: true,
				/*x: YAHOO.util.Dom.getViewportWidth() / 2,
				y: YAHOO.util.Dom.getViewportHeight() / 2 - 150,*/
				constraintoviewport:true,
				fixedcenter:true,
				modal:true,
				draggable:false
			});
		}
		this['a_l_overlay'].setHeader('Add User');
		this['a_l_overlay'].setBody('Body');
		this['a_l_overlay'].setFooter('');
		this['a_l_overlay'].render(document.body);
		params = {};
		var req = new JsHttpRequest();
		req.information_div = info_div;
		req.overlay = this['a_l_overlay'];
		req.onreadystatechange = function()
		{
			if(req.readyState == 4)
			{
				$(req.information_div).innerHTML = req.responseJS.html
				//tab_view.selectTab(2);
				req.overlay.setBody(req.responseJS.html);
				req.overlay.show();
			}
		}
		req.caching = false;
		req.open('POST', ajax_prefix + '?rm=edit_department_user', true);
		req.send(params);
	};

        t.edit = function(user_id){
		if(this['e_l_overlay'] == undefined){
			this['e_l_overlay'] = new YAHOO.widget.Panel('e_l_overlay',{
				width: "300px",
				//height: "550px",
				visible: true,
				close: true,
				constraintoviewport: true,
				fixedcenter: true,
				modal: true,
				draggable: false
			});

		}
		this['e_l_overlay'].setHeader(user_id>0 ? 'Edit user' : 'Add new user');
		this['e_l_overlay'].setBody('Loading...');
		this['e_l_overlay'].setFooter('');
		this['e_l_overlay'].render(document.body);

		params = {user_id: user_id};
		var req = new JsHttpRequest();
		req.overlay = this['e_l_overlay'];
		req.onreadystatechange = function(){
			if(req.readyState == 4){
				//tab_view.selectTab(3);
				req.overlay.setBody(req.responseJS.html);
				req.overlay.show();
			}
		}
		req.caching = false;
		req.open('POST', ajax_prefix + '?rm=ajax_edit_user', true);
		req.send(params);
	};

        t.change_password = function(user_id){
		if(this['e_l_overlay'] == undefined){
			this['e_l_overlay'] = new YAHOO.widget.Panel('e_l_overlay',{
				width: "300px",
				//height: "550px",
				visible: true,
				close: true,
				constraintoviewport: true,
				fixedcenter: true,
				modal: true,
				draggable: false
			});

		}
		this['e_l_overlay'].setHeader('Change password');
		this['e_l_overlay'].setBody('Loading...');
		this['e_l_overlay'].setFooter('');
		this['e_l_overlay'].render(document.body);

		params = {user_id: user_id};
		var req = new JsHttpRequest();
		req.overlay = this['e_l_overlay'];
		req.onreadystatechange = function(){
			if(req.readyState == 4){
				//tab_view.selectTab(3);
				req.overlay.setBody(req.responseJS.html);
				req.overlay.show();
			}
		}
		req.caching = false;
		req.open('POST', ajax_prefix + '?rm=ajax_change_password', true);
		req.send(params);
	};

        t.save_edit = function(form_id){
		//now we prepared params and ready to send
		var params = get_form_params(form_id);
		var req = new JsHttpRequest();
		params['save'] = 1;
		req.user = this;
		req.overlay = this['e_l_overlay'];

		req.onreadystatechange = function()
                {
			if(req.readyState == 4)
                        {
				//$(req.information_div).innerHTML = req.responseJS.html
				//tab_view.selectTab(3);
				if(!req.responseJS.success)
                                {
					req.user['e_l_overlay'].setBody(req.responseJS.html);

				}
                                else
                                { //if(req.responseJS.success){
					user_list.onPaginatorChangeRequest(user_list.getState().pagination);
					//tab_view.selectTab(0);
					if(req.user['e_l_overlay'] != undefined)
                                        {
						req.user['e_l_overlay'].destroy();
						delete req.user['e_l_overlay'];
					}
				}
			}
		}
		req.caching = false;
		req.open('POST', ajax_prefix + '?rm=ajax_edit_user', true);
		req.send(params);

	};

        t.save_password = function(form_id){
		//now we prepared params and ready to send
		var params = get_form_params(form_id);
		var req = new JsHttpRequest();
		params['save'] = 1;
		req.user = this;
		req.overlay = this['e_l_overlay'];

		req.onreadystatechange = function()
                {
			if(req.readyState == 4)
                        {
				//$(req.information_div).innerHTML = req.responseJS.html
				//tab_view.selectTab(3);
				if(!req.responseJS.success)
                                {
					req.user['e_l_overlay'].setBody(req.responseJS.html);
                                                                                
				} 
                                else
                                { //if(req.responseJS.success){
					user_list.onPaginatorChangeRequest(user_list.getState().pagination);
					//tab_view.selectTab(0);
					if(req.user['e_l_overlay'] != undefined)
                                        {
						req.user['e_l_overlay'].destroy();
						delete req.user['e_l_overlay'];
					}
				}
			}
		}
		req.caching = false;
		req.open('POST', ajax_prefix + '?rm=ajax_change_password', true);
		req.send(params);

	};

	


	/*t.save_edit = function(form_id, info_div, action)
	{
		var form = $(form_id);
		var params = get_form_params(form_id);
		//now we prepared params and ready to send

		var req = new JsHttpRequest();
		params['save'] = 1;
		params['action'] = action;
		if (info_div)
		{
			params['do_validate'] = 1;
		}
		req.information_div = form_id;
		req.user = this;
		req.onreadystatechange = function()
		{
			if(req.readyState == 4)
			{
				
//				$(req.information_div).innerHTML = req.responseJS.html
				
				if(!req.responseJS.success)
				{
					if(req.responseJS.user_id != null)
						req.user['e_l_overlay' + req.responseJS.user_id].setBody(req.responseJS.html);
					else
						req.user['a_l_overlay'].setBody(req.responseJS.html);
				}
				//tab_view.selectTab(2);
				if(req.responseJS.success)
				{
					//save was done without problems
					user_list.onPaginatorChangeRequest(user_list.getState().pagination);
					//department_manager_list.onPaginatorChangeRequest(department_manager_list.getState().pagination);
					//tab_view.selectTab(1);
					//save was done without problems
					department_list.onPaginatorChangeRequest(department_list.getState().pagination);
					//tab_view.selectTab(0);
					if(req.user['e_l_overlay' + req.responseJS.user_id] != undefined)
					{
						req.user['e_l_overlay' + req.responseJS.user_id].destroy();
						delete req.user['e_l_overlay' + req.responseJS.user_id];
					}
					if(req.user['d_l_overlay' + req.responseJS.user_id] != undefined)
					{
						req.user['d_l_overlay' + req.responseJS.user_id].destroy();
						delete req.user['d_l_overlay' + req.responseJS.user_id];
					}
					if(req.user['a_l_overlay'] != undefined)
					{
						req.user['a_l_overlay'].destroy();
						delete req.user['a_l_overlay'];
					}
				}
			}
		}
                req.overlay.closw();
		req.caching = false;
		req.open('POST', ajax_prefix + '?rm=ajax_edit_user', true);
		req.send(params);

	};*/

	t.show_all = function()
	{
		$('user_filter').reset();
		t.filter = {'user_id':0, 'name':"", 'first_name':"", 'last_name':""};
			
		tab_view.getTab(1).set('label', 'Viewing All Users'); 
		
		tab_view.selectTab(1);
		var pagination = user_list.getState().pagination;
		pagination.recordOffset = 0;
		department_user_list.onPaginatorChangeRequest(pagination);
	};

	t.generate_request = function(oState, oSelf)
	{
        // Set defaults
        oState = oState || {pagination:null, sortedBy:null};
        var sort = (oState.sortedBy) ? oState.sortedBy.key : oSelf.getColumnSet().keys[0].getKey();
        var dir = (oState.sortedBy && oState.sortedBy.dir === YAHOO.widget.DataTable.CLASS_DESC) ? "desc" : "asc";
        var startIndex = (oState.pagination) ? oState.pagination.recordOffset : 0;
        var results = (oState.pagination) ? oState.pagination.rowsPerPage : null;
        
        // Build the request
        return  "sort=" + sort +
                "&dir=" + dir +
                "&startIndex=" + startIndex +
                "&filter[login]=" + t.filter['login'] +
                "&filter[first_name]=" + t.filter['first_name'] +
                "&filter[last_name]=" + t.filter['last_name'] +
                "&filter[groups]=" + t.filter['groups'] +
                "&filter[email]=" + t.filter['email'] +
                ((results !== null) ? "&results=" + results : "");
	};

	t.search_go = function(form_id)
	{
		//var temp = t.filter;
		//var filters = get_form_params(form_id);
                //t.filter = filters;
		//t.filter['user_id'] = temp['user_id'];
                
                t.filter = get_form_params(form_id);
                //alert(t.filter['login']);
		var pagination = user_list.getState().pagination;
		pagination.recordOffset = 0;
		user_list.onPaginatorChangeRequest(pagination);

               /* params = {filters: filters};
		var req = new JsHttpRequest();
                
		req.caching = false;
		req.open('POST', ajax_prefix + '?rm=ajax_user_list', true);
		req.send(params);*/
                
                /*var pagination = user_list.getState().pagination;
		pagination.recordOffset = 0;
		user_list.onPaginatorChangeRequest(pagination);
                alert(user_list.onPaginatorChangeRequest(pagination));*/
                
	};
	t.access = function(info_div, department_user_id)
	{
		if(this['acu_overlay' + department_user_id] == undefined)
		{
			this['acu_overlay' + department_user_id] = new YAHOO.widget.Panel('acu_overlay' + department_user_id,{
				width: "520px",//"900px",
				height: "600px",
				visible:true,
				close: true,
				constraintoviewport:true,
				fixedcenter:true,
				modal:true,
				draggable:false
			});
		}
		this['acu_overlay' + department_user_id].setHeader('Access User');
		this['acu_overlay' + department_user_id].setBody('Body');
		this['acu_overlay' + department_user_id].setFooter('');
		this['acu_overlay' + department_user_id].render(document.body);
		params = {department_user_id: department_user_id};
		var req = new JsHttpRequest();
		req.information_div = info_div;
		req.overlay = this['acu_overlay' + department_user_id];
		req.onreadystatechange = function()
		{
			if(req.readyState == 4)
			{
				$(req.information_div).innerHTML = req.responseJS.html;
				//tab_view.selectTab(3);
				req.overlay.setBody(req.responseJS.html);
				req.overlay.show();
			}
		}
		req.caching = false;
		req.open('POST', ajax_prefix + '?rm=access_department_user', true);
		req.send(params);		
	};
	t.save_access = function(form_id, info_div)
	{
		var params = get_form_params(form_id);
		var req = new JsHttpRequest();params['save'] = 1;
		req.information_div = info_div;
		req.department_user = this;
		req.onreadystatechange = function()
		{
			if(req.readyState == 4)
			{
				$(req.information_div).innerHTML = req.responseJS.html
				//tab_view.selectTab(3);
				if(!req.responseJS.success)
				{
					if(req.responseJS.department_user_id != null)
						req.department_user['acu_overlay' + req.responseJS.department_user_id].setBody(req.responseJS.html);
					else
					{
						
					}
				}
				
				if(req.responseJS.success)
				{
//					department_user_list.onPaginatorChangeRequest(department_user_list.getState().pagination);
					tab_view.selectTab(1);
					if(req.department_user['acu_overlay' + req.responseJS.department_user_id] != undefined)
					{
						req.department_user['acu_overlay' + req.responseJS.department_user_id].destroy();
						delete req.department_user['acu_overlay' + req.responseJS.department_user_id];
					}
				}
			}
		}
		req.caching = false;
		req.open('POST', ajax_prefix + '?rm=access_department_user', true);
		req.send(params);		
	};	
	
}

var user = new User();

function get_form_params(form_id)
{
	var form = $(form_id);
	var params = {};
	for(var i = 0; i < form.elements.length; i++)
	{
		var element = form.elements[i];
		var type = form.elements[i].type;
		if (form.elements[i].tagName != 'FIELDSET' && form.elements[i].type != 'checkbox' && form.elements[i].type != 'radio')
	  		params[form.elements[i].name] = form.elements[i].value;

		if (form.elements[i].type == 'textarea' && !form.elements[i].value)
		{
	  		params[form.elements[i].name] = form.elements[i].value;
		}

		if (form.elements[i].type == 'checkbox' && form.elements[i].checked)
	  		params[form.elements[i].name] = form.elements[i].value;
		else if(form.elements[i].type == 'checkbox' && !form.elements[i].checked)
	  		params[form.elements[i].name] = '';
		if (form.elements[i].type == 'radio' && form.elements[i].checked)
	  		params[form.elements[i].name] = form.elements[i].value;

		if (form.elements[i].type == 'select-multiple')
		{
	  		var values = [];
	  		for (var o=0;o<form.elements[i].options.length;o++)
	  		{
	    		if (form.elements[i].options[o].selected)
	  				values[values.length] = form.elements[i].options[o].value;
	  		}
	  		params[form.elements[i].name] = values;
		}
	}
	return params;
}