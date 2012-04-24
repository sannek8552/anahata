{config_load file=templates.ini section="common" scope="global"}

<!-- Individual YUI JS files --> 
<script type="text/javascript" src="{#js_url#}yui/build/yahoo-dom-event/yahoo-dom-event.js"></script> 
<script type="text/javascript" src="{#js_url#}yui/build/dragdrop/dragdrop-min.js"></script> 
<script type="text/javascript" src="{#js_url#}yui/build/element/element-min.js"></script> 
<script type="text/javascript" src="{#js_url#}yui/build/datasource/datasource-min.js"></script> 
<script type="text/javascript" src="{#js_url#}yui/build/datatable/datatable.js"></script> 

<script type="text/javascript" src="{#js_url#}yui/build/tabview/tabview-min.js"></script> 
<script type="text/javascript" src="{#js_url#}yui/build/container/container-min.js"></script> 
<script type="text/javascript" src="{#js_url#}yui/build/element/element-min.js"></script> 
<script type="text/javascript" src="{#js_url#}yui/build/paginator/paginator-min.js"></script> 
<script type="text/javascript" src="{#js_url#}yui/build/connection/connection-min.js"></script> 
<script type="text/javascript" src="{#js_url#}yui/build/json/json-min.js"></script> 
<script type="text/javascript" src="{#js_url#}yui/build/cookie/cookie-min.js"></script>
<script type="text/javascript" src="{#js_url#}yui/build/resize/resize-min.js"></script> 

<link rel="stylesheet" type="text/css" href="{#js_url#}yui/build/paginator/assets/skins/sam/paginator.css"> 
<link rel="stylesheet" type="text/css" href="{#js_url#}yui/build/container/assets/skins/sam/container.css">
<link rel="stylesheet" type="text/css" href="{#js_url#}yui/build/datatable/assets/skins/sam/datatable.css"> 
<link rel="stylesheet" type="text/css" href="{#js_url#}yui/build/tabview/assets/skins/sam/tabview.css">
<link rel="stylesheet" type="text/css" href="{#js_url#}yui/build/resize/assets/skins/sam/resize.css">
<link rel="stylesheet" type="text/css" href="{#css_url#}admin_1.css">

<script type="text/javascript" src="{#js_url#}helper.js"></script>
<script type="text/javascript" src="{#js_url#}formatters.js"></script>
<script type="text/javascript" src="{#js_url#}const.js"></script>
<script type="text/javascript" src="{#js_url#}settings.js"></script>

<script type="text/javascript" src="{#js_url#}NewsLetter/nluser.js"></script>
<script type="text/javascript" src="{#js_url#}NewsLetter/nlgroup.js"></script>
<script type="text/javascript" src="{#js_url#}NewsLetter/nlmail.js"></script>
<script type="text/javascript" src="{#js_url#}NewsLetter/nlposting.js"></script>
<script type="text/javascript" src="{#js_url#}NewsLetter/nlmethod.js"></script>
<script type="text/javascript" src="{#js_url#}NewsLetter/nlsettings.js"></script>
<script type="text/javascript" src="{#js_url#}NewsLetter/nlreadreport.js"></script>
<script type="text/javascript" src="{#js_url#}NewsLetter/nlunsubscribereport.js"></script>

<script type="text/javascript" src="{#js_url#}jscalendar/calendar.js"></script>
<script type="text/javascript" src="{#js_url#}jscalendar/lang/calendar-en.js"></script>
<script type="text/javascript" src="{#js_url#}jscalendar/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" href="{#js_url#}jscalendar/calendar-win2k-1.css" />

<h2>Newsletter</h2>
<div>
	<div id="tab_container" class="yui-navset">
		<ul class="yui-nav">
			<li class="selected"><a href="#tab1" onclick="reset_form('nluser_filter',nluser);"><em>Subscribers</em></a></li>
			<li><a href="#tab2" onclick="reset_form('group_filter',nlgroup);"><em>Groups</em></a></li>
			<li><a href="#tab3" onclick="reset_form('mail_filter',nlmail);"><em>E-mails</em></a></li>
			<li><a href="#tab4" onclick="reset_form('posting_filter',nlposting);"><em>Postings</em></a></li>
			<li><a href="#tab5" onclick="reset_form('method_filter',nlmethod);"><em>Methods</em></a></li>
			<li><a href="#tab6" ><em>Settings</em></a></li>
                        <li><a href="#tab7" onclick="reset_form(false,nlreadreport);"><em>Read report</em></a></li>
                        <li><a href="#tab8" onclick="reset_form(false,nlunsubscribereport);"><em>Unsubscribe report</em></a></li>
		</ul>
		<div class="yui-content">

			<div> {*-- Users --*}
                            
				<div class="search_bar">{literal}
					<div class="actions"><a href="javascript:void(0);" onclick="nluser.edit('');">Add new Subscriber</a></div>
					<div class="search_button"><a href="javascript: void(0)" onclick="show_hide_els('import_box_nluser', {0: 'search_box_nluser'});">Import</a></div>
					<div class="search_button"><a href="javascript: void(0)" onclick="show_hide_els('search_box_nluser', {0: 'import_box_nluser'});">Search</a></div>
                                        <div class="search_button"><a href="javascript: void(0)" onclick="reset_form('nluser_filter',nluser);">Reset</a></div>
					<div style="clear: both"></div>
				</div>{/literal}
				<div class="search_box" id="search_box_nluser">
					<div style="float: left">
						<form id="nluser_filter" action="javascript:void(0);" method="post">
						<table>
							<tr>
								<td>First Name</td>
								<td><input type="text" value="" name="first_name" /></td>
							</tr>
							<tr>
								<td>Last Name</td>
								<td><input type="text" value="" name="last_name" /></td>
							</tr>
							<tr>
								<td>E-mail</td>
								<td><input type="text" value="" name="email" /></td>
							</tr>
							<tr>
								<td>Group</td>
								<td>
									<select name="group" style="width: auto;">
									<option value='0'>All groups</option>
									{foreach from=$groups item=i}<option value='{$i.id}'>{$i.title}</option>{/foreach}
									</select>
								</td>
						</table>
						</form>
					</div>

					<div class="go_button"><a href="javascript: void(0)" onclick="nluser.search_go('nluser_filter');">Go</a></div>
					<div style="clear: both"></div>
				</div>

				<div class="search_box" id="import_box_nluser">
					<div style="float: left">
						<form id="nluser_import" action="{#script_url#}" method="post" target="import_box" enctype="multipart/form-data">
							<input type="hidden" name="rm" value="admin_nl_user_csv" />
							<input type="file" name="csv_file" />
						</form>
						<div id="import_report_box" style="width: 800px; max-height: 100px; overflow-y: auto; margin: 5px 0;"></div>
						<iframe name="import_box" style="visibility: hidden; height: 1px; width: 800px; border: 0;"></iframe>
					</div>
					<div class="go_button"><a href="javascript: void(0)" onclick="$('nluser_import').submit();">Go</a></div>
					<div style="clear: both"></div>
				</div>
				
				<div id="nluser-nav-1"></div>
                               
				<div id="nlusers"></div>
                                
                                <div><a href="javascript:void(0);" onclick="delete_all();">Delete All</a></div>
                                
				<div id="nluser-nav-2"></div>
                                        
			</div>

			<div> {*-- Groups --*}
				<div class="search_bar">
					<div class="actions"><a href="javascript:void(0);" onclick="nlgroup.edit('');">Add new Group</a></div>
					<div class="search_button"><a href="javascript: void(0)" onclick="show_hide_el('search_box_group');">Search</a></div>
					<div style="clear: both"></div>
				</div>
				<div class="search_box" id="search_box_group">
					<div style="float: left">
						<form id="group_filter" action="javascript:void(0);" method="post">
						<table>
							<tr>
								<td>Title</td>
								<td><input type="text" value="" name="title" /></td>
							</tr>
						</table>
						</form>
					</div>

					<div class="go_button"><a href="javascript: void(0)" onclick="nlgroup.search_go('group_filter');">Go</a></div>
					<div style="clear: both"></div>
				</div>
				<div id="nlgroup-nav-1"></div>
				<div id="nlgroups"></div>
				<div id="nlgroup-nav-2"></div>
			</div>

			<div> {*-- Mails --*}
				<div class="search_bar">
					<div class="actions"><a href="javascript:void(0);" onclick="nlmail.edit('');" id="add_email_id">Add new e-mail</a></div>
					<div class="search_button"><a href="javascript: void(0)" onclick="show_hide_el('search_box_mail');">Search</a></div>
					<div style="clear: both"></div>
				</div>
				<div class="search_box" id="search_box_mail">
					<div style="float: left">
						<form id="mail_filter" action="javascript:void(0);" method="post">
						<table>
							<tr>
								<td>Title</td>
								<td><input type="text" value="" name="title" /></td>
							</tr>
						</table>
						</form>
					</div>

					<div class="go_button"><a href="javascript: void(0)" onclick="nlmail.search_go('mail_filter');">Go</a></div>
					<div style="clear: both"></div>
				</div>
				<div id="nlmail-nav-1"></div>
				<div id="nlmails"></div>
				<div id="nlmail-nav-2"></div>
			</div>

			<div> {*-- Postings --*}
				<div class="search_bar">
					<div class="actions"><a href="javascript:void(0);" onclick="nlposting.edit('');">Add new Posting</a></div>
					<div class="search_button"><a href="javascript: void(0)" onclick="show_hide_el('search_box_posting');">Search</a></div>
					<div style="clear: both"></div>
				</div>
				<div class="search_box" id="search_box_posting">
					<div style="float: left">
						<form id="posting_filter" action="javascript:void(0);" method="post">
						<table>
							<tr>
								<td>Title</td>
								<td><input type="text" value="" name="title" /></td>
							</tr>
						</table>
						</form>
					</div>

					<div class="go_button"><a href="javascript: void(0)" onclick="nlposting.search_go('posting_filter');">Go</a></div>
					<div style="clear: both"></div>
				</div>
				<div id="nlposting-nav-1"></div>
				<div id="nlpostings"></div>
				<div id="nlposting-nav-2"></div>
			</div>

			<div> {*-- Methods --*}
				<div class="search_bar">
					<div class="actions"><a href="javascript:void(0);" onclick="nlmethod.edit('');">Add new Method</a></div>
					<div class="search_button"><a href="javascript: void(0)" onclick="show_hide_el('search_box_method');">Search</a></div>
					<div style="clear: both"></div>
				</div>
				<div class="search_box" id="search_box_method">
					<div style="float: left">
						<form id="method_filter" action="javascript:void(0);" method="post">
						<table>
							<tr>
								<td>Title</td>
								<td><input type="text" value="" name="title" /></td>
							</tr>
						</table>
						</form>
					</div>

					<div class="go_button"><a href="javascript: void(0)" onclick="nlmethod.search_go('method_filter');">Go</a></div>
					<div style="clear: both"></div>
				</div>
				<div id="nlmethod-nav-1"></div>
				<div id="nlmethods"></div>
				<div id="nlmethod-nav-2"></div>
			</div>
			
			<div id="settings_box"> {*-- Settings --*}
			</div>
                        <div> {*-- ReadReport --*}

				<div id="nlreadreport-nav-1"></div>
				<div id="nlreadreports"></div>
				<div id="nlreadreport-nav-2"></div>
			</div>
                        <div> {*-- UnsubscribeReport --*}

				<div id="nlunsubscribereport-nav-1"></div>
				<div id="nlunsubscribereports"></div>
				<div id="nlunsubscribereport-nav-2"></div>
			</div>

			<div  id="information">
                            {include file='Admin/NewsLetter/helper_icons.tpl'}
                        </div>
		</div>
	</div>
</div>

{literal}
<script type="text/javascript">
YAHOO.util.Event.onDOMReady(nluser_init);
var tab_view;

var nluser_list;
var nluser_paginator;
var nluser_ds;

var nlgroup_list;
var nlgroup_paginator;
var nlgroup_ds;

var nlmail_list;
var nlmail_paginator;
var nlmail_ds;

function nluser_init(){
	tab_view = new YAHOO.widget.TabView("tab_container");

	//-- user ---------------------------------------------------------------------------------
	var nluser_column_defs = {/literal}{$nl_user_column_defs}{literal};

	nluser_ds = new YAHOO.util.DataSource(ajax_prefix + 'admin_nl_user_list_ajax.html',{connMethodPost:true});
	nluser_ds.responseType = YAHOO.util.DataSource.TYPE_JSON;
	nluser_ds.responseSchema = {
		resultsList: "records",
		fields: {/literal}{$nl_user_source_fields},{literal}
		metaFields: {totalRecords: "totalRecords" }
	};

	nluser_paginator = new YAHOO.widget.Paginator({
		rowsPerPage:		10,
		containers:			["nluser-nav-1", "nluser-nav-2"], 
		template:			YAHOO.widget.Paginator.TEMPLATE_ROWS_PER_PAGE,
		rowsPerPageOptions:	[5,10,25,50,100,250,500],
		pageLinks:			10
	});

	var nluser_data_config = {
		initialRequest:		'',
		dynamicData:		true,
		paginator:			nluser_paginator,
		sortedBy:			{key: "first_name", dir:'asc'},
		generateRequest:	nluser.generate_request
	};

	nluser_list = new YAHOO.widget.DataTable('nlusers', nluser_column_defs, nluser_ds, nluser_data_config);

	nluser_list.handleDataReturnPayload = function(oRequest, oResponse, oPayload){
		oPayload.totalRecords = oResponse.meta.totalRecords;
		return oPayload;
	}

	//-- group -------------------------------------------------------------------------------------
	var nlgroup_column_defs = {/literal}{$nl_group_column_defs}{literal};

	nlgroup_ds = new YAHOO.util.DataSource(ajax_prefix + 'admin_nl_group_list_ajax.html',{connMethodPost:true});
	nlgroup_ds.responseType = YAHOO.util.DataSource.TYPE_JSON;
	nlgroup_ds.responseSchema = {
		resultsList: "records",
		fields: {/literal}{$nl_group_source_fields},{literal}
		metaFields: {totalRecords: "totalRecords" }
	};

	nlgroup_paginator = new YAHOO.widget.Paginator({
		rowsPerPage:		10,
		containers:			["nlgroup-nav-1", "nlgroup-nav-2"], 
		template:			YAHOO.widget.Paginator.TEMPLATE_ROWS_PER_PAGE,
		rowsPerPageOptions:	[5,10,25,50,100],
		pageLinks:			10
	});

	var nlgroup_data_config = {
		initialRequest:		'',
		dynamicData:		true,
		paginator:			nlgroup_paginator,
		sortedBy:			{key: "title", dir:'asc'},
		generateRequest:	nlgroup.generate_request
	};

	nlgroup_list = new YAHOO.widget.DataTable('nlgroups', nlgroup_column_defs, nlgroup_ds, nlgroup_data_config);

	nlgroup_list.handleDataReturnPayload = function(oRequest, oResponse, oPayload){
		oPayload.totalRecords = oResponse.meta.totalRecords;
		return oPayload;
	}

	//-- mail --------------------------------------------------------------------------------------
	var nlmail_column_defs = {/literal}{$nl_mail_column_defs}{literal};

	nlmail_ds = new YAHOO.util.DataSource(ajax_prefix + 'admin_nl_mail_list_ajax.html',{connMethodPost:true});
	nlmail_ds.responseType = YAHOO.util.DataSource.TYPE_JSON;
	nlmail_ds.responseSchema = {
		resultsList: "records",
		fields: {/literal}{$nl_mail_source_fields},{literal}
		metaFields: {totalRecords: "totalRecords" }
	};

	nlmail_paginator = new YAHOO.widget.Paginator({
		rowsPerPage:		10,
		containers:			["nlmail-nav-1", "nlmail-nav-2"], 
		template:			YAHOO.widget.Paginator.TEMPLATE_ROWS_PER_PAGE,
		rowsPerPageOptions:	[5,10,25,50,100],
		pageLinks:			10
	});

	var nlmail_data_config = {
		initialRequest:		'',
		dynamicData:		true,
		paginator:			nlmail_paginator,
		sortedBy:			{key: "title", dir:'asc'},
		generateRequest:	nlmail.generate_request
	};

	nlmail_list = new YAHOO.widget.DataTable('nlmails', nlmail_column_defs, nlmail_ds, nlmail_data_config);

	nlmail_list.handleDataReturnPayload = function(oRequest, oResponse, oPayload){
		oPayload.totalRecords = oResponse.meta.totalRecords;
		return oPayload;
	}

	//-- posting -----------------------------------------------------------------------------------
	var nlposting_column_defs = {/literal}{$nl_posting_column_defs}{literal};

	nlposting_ds = new YAHOO.util.DataSource(ajax_prefix + 'admin_nl_posting_list_ajax.html',{connMethodPost:true});
	nlposting_ds.responseType = YAHOO.util.DataSource.TYPE_JSON;
	nlposting_ds.responseSchema = {
		resultsList: "records",
		fields: {/literal}{$nl_posting_source_fields},{literal}
		metaFields: {totalRecords: "totalRecords" }
	};

	nlposting_paginator = new YAHOO.widget.Paginator({
		rowsPerPage:		10,
		containers:			["nlposting-nav-1", "nlposting-nav-2"], 
		template:			YAHOO.widget.Paginator.TEMPLATE_ROWS_PER_PAGE,
		rowsPerPageOptions:	[5,10,25,50,100],
		pageLinks:			10
	});

	var nlposting_data_config = {
		initialRequest:		'',
		dynamicData:		true,
		paginator:			nlposting_paginator,
		sortedBy:			{key: "title", dir:'asc'},
		generateRequest:	nlposting.generate_request
	};

	nlposting_list = new YAHOO.widget.DataTable('nlpostings', nlposting_column_defs, nlposting_ds, nlposting_data_config);

	nlposting_list.handleDataReturnPayload = function(oRequest, oResponse, oPayload){
		oPayload.totalRecords = oResponse.meta.totalRecords;
		return oPayload;
	}

	//-- method ------------------------------------------------------------------------------------
	var nlmethod_column_defs = {/literal}{$nl_method_column_defs}{literal};

	nlmethod_ds = new YAHOO.util.DataSource(ajax_prefix + 'admin_nl_method_list_ajax.html',{connMethodPost:true});
	nlmethod_ds.responseType = YAHOO.util.DataSource.TYPE_JSON;
	nlmethod_ds.responseSchema = {
		resultsList: "records",
		fields: {/literal}{$nl_method_source_fields},{literal}
		metaFields: {totalRecords: "totalRecords" }
	};

	nlmethod_paginator = new YAHOO.widget.Paginator({
		rowsPerPage:		10,
		containers:			["nlmethod-nav-1", "nlmethod-nav-2"], 
		template:			YAHOO.widget.Paginator.TEMPLATE_ROWS_PER_PAGE,
		rowsPerPageOptions:	[5,10,25,50,100],
		pageLinks:			10
	});

	var nlmethod_data_config = {
		initialRequest:		'',
		dynamicData:		true,
		paginator:			nlmethod_paginator,
		sortedBy:			{key: "title", dir:'asc'},
		generateRequest:	nlmethod.generate_request
	};

	nlmethod_list = new YAHOO.widget.DataTable('nlmethods', nlmethod_column_defs, nlmethod_ds, nlmethod_data_config);

	nlmethod_list.handleDataReturnPayload = function(oRequest, oResponse, oPayload){
		oPayload.totalRecords = oResponse.meta.totalRecords;
		return oPayload;
	}
	//-- settings ----------------------------------------------------------------------------------
	nlsettings.load();

        //-- readreport -----------------------------------------------------------------------------------
	var nlreadreport_column_defs = {/literal}{$nl_readreport_column_defs}{literal};

	nlreadreport_ds = new YAHOO.util.DataSource(ajax_prefix + 'admin_nl_readreport_list_ajax.html',{connMethodPost:true});
	nlreadreport_ds.responseType = YAHOO.util.DataSource.TYPE_JSON;
	nlreadreport_ds.responseSchema = {
		resultsList: "records",
		fields: {/literal}{$nl_readreport_source_fields},{literal}
		metaFields: {totalRecords: "totalRecords" }
	};

	nlreadreport_paginator = new YAHOO.widget.Paginator({
		rowsPerPage:		10,
		containers:			["nlreadreport-nav-1", "nlreadreport-nav-2"],
		template:			YAHOO.widget.Paginator.TEMPLATE_ROWS_PER_PAGE,
		rowsPerPageOptions:	[5,10,25,50,100],
		pageLinks:			10
	});

	var nlreadreport_data_config = {
		initialRequest:		'',
		dynamicData:		true,
		paginator:			nlreadreport_paginator,
		sortedBy:			{key: "updated", dir:'desc'},
		generateRequest:	nlreadreport.generate_request
	};

	nlreadreport_list = new YAHOO.widget.DataTable('nlreadreports', nlreadreport_column_defs, nlreadreport_ds, nlreadreport_data_config);

	nlreadreport_list.handleDataReturnPayload = function(oRequest, oResponse, oPayload){
		oPayload.totalRecords = oResponse.meta.totalRecords;
		return oPayload;
	}

        //-- unsubscribereport -----------------------------------------------------------------------------------
	var nlunsubscribereport_column_defs = {/literal}{$nl_unsubscribereport_column_defs}{literal};

	nlunsubscribereport_ds = new YAHOO.util.DataSource(ajax_prefix + 'admin_nl_unsubscribereport_list_ajax.html',{connMethodPost:true});
	nlunsubscribereport_ds.responseType = YAHOO.util.DataSource.TYPE_JSON;
	nlunsubscribereport_ds.responseSchema = {
		resultsList: "records",
		fields: {/literal}{$nl_unsubscribereport_source_fields},{literal}
		metaFields: {totalRecords: "totalRecords" }
	};

	nlunsubscribereport_paginator = new YAHOO.widget.Paginator({
		rowsPerPage:		10,
		containers:			["nlunsubscribereport-nav-1", "nlunsubscribereport-nav-2"],
		template:			YAHOO.widget.Paginator.TEMPLATE_ROWS_PER_PAGE,
		rowsPerPageOptions:	[5,10,25,50,100],
		pageLinks:			10
	});

	var nlunsubscribereport_data_config = {
		initialRequest:		'',
		dynamicData:		true,
		paginator:			nlunsubscribereport_paginator,
		sortedBy:			{key: "unsubscribe_date", dir:'desc'},
		generateRequest:	nlunsubscribereport.generate_request
	};

	nlunsubscribereport_list = new YAHOO.widget.DataTable('nlunsubscribereports', nlunsubscribereport_column_defs, nlunsubscribereport_ds, nlunsubscribereport_data_config);

	nlunsubscribereport_list.handleDataReturnPayload = function(oRequest, oResponse, oPayload){
		oPayload.totalRecords = oResponse.meta.totalRecords;
		return oPayload;
	}
}

function tiny_edit(textarea_id){
	tinyMCE.init({
			// General options
               mode : "exact",
               elements: textarea_id,
               theme : "advanced",
               plugins : "ibrowser,safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,storage,fullpage",

               // Theme options
               theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
               theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
               theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
               theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,ibrowser,storage,fullpage",
               theme_advanced_toolbar_location : "top",
               theme_advanced_toolbar_align : "left",
               theme_advanced_statusbar_location : "bottom",
               content_css : {/literal}"{#css_url#}main.css",{literal}
               theme_advanced_resizing : true,

             remove_script_host : true,
             document_base_url : {/literal}"{#domain_name#}{#script_url#}",{literal}

               // Example word content CSS (should be your site CSS) this one removes paragraph margins
               //content_css : "css/main.css",

               // Drop lists for link/image/media/template dialogs
               template_external_list_url : "lists/template_list.js",
               external_link_list_url : "lists/link_list.js",
               external_image_list_url : "lists/image_list.js",
               media_external_list_url : "lists/media_list.js",
               convert_urls : false

			
		});
}

function calendar_setup()
{
    Calendar.setup({inputField  : "date_id",ifFormat    : "%d/%m/%Y",button  : "date_img"});
}

function delete_all()
{
    var node = document.getElementsByName('delete[]');
    var to_delete = {};

    for (var i=0; i<node.length; i++)
    {
        if(node[i].checked) to_delete[node[i].value] = node[i].value;
    }
    nluser.delete_all(to_delete);

}

function check_all()
{
    
    var main_box = document.getElementById('select_all');
    var cheks=window.document.body.getElementsByTagName("input");
    for (var i=cheks.length-1; i>=0; i--)
    {
        if (cheks[i].getAttribute("type", 1)=="checkbox")
        {
            cheks[i].checked=main_box.checked;
        }
    }

}

function reset_form(form_id,type)
{
    if (form_id != false) {
        reset_form_params(form_id);
    }
    type.search_reset();

    
}

function tiny_clear(textarea_id){

    tinyMCE.get(textarea_id).setContent('');

}

</script>
{/literal}
