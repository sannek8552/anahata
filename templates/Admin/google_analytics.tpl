{config_load file=templates.ini section="common" scope="global"}
<fieldset id="google_analytics">

<legend>Google Analytics</legend>
<div class="google_analytics">
{if $no_settings || $errors}
	Google analytics settings are incorrect, or have not been entered.<br />
        Please go to <a href="{#script_url#}{seo_url rm=AdminSettings}">Settings manager</a> to fix this.
        <br /><br />
        {foreach from=$errors key=key item=item}
        <b><font color="red">{$key} error</font></b>: {$item}<br />
        {/foreach}

    
{else}
        <form name="date_form" action="{#scropt_url#}{seo_url rm="GoogleAnalytics"}" method="post">
              <table>
                  <tr>
                      <td >
                          <b>Date Range</b>
                      </td>                      
                  </tr>
                  <tr>                      
                      <td>
                          <input style="width: auto;" readonly type="text" name="start_date" id="start_date_id" value="{$date.start_date|date_format:"%d/%m/%Y"}" title="string___input date"/>
                          <img style="vertical-align: middle;" src="{#js_url#}jscalendar/jscalendar.gif" alt="choose date" id="start_date_img" border="0"/>
                      </td>
                      <td>
                      		<input style="width: auto;" readonly type="text" name="end_date" id="end_date_id" value="{$date.end_date|date_format:"%d/%m/%Y"}"title="string___input date" />
                          <img style="vertical-align: middle;" src="{#js_url#}jscalendar/jscalendar.gif" alt="choose date" id="end_date_img" border="0"/>
   	                   </td>
                  </tr>
                  <tr>
                  	  <td>
   	                   <input type="checkbox" id="chk_date_id" onclick="prepare_previous_date();" style="width: auto;"/> Compare to past
   	                  </td>
                  </tr>
                  <tr>                      
                      <td>
                          <input style="width: auto;" readonly type="text" name="prev_start_date" id="prev_start_date_id" value="{$date.prev_start_date|date_format:"%d/%m/%Y"}" title="string___input date"/>
                          <img style="vertical-align: middle;" src="{#js_url#}jscalendar/jscalendar.gif" alt="choose date" id="prev_start_date_img" border="0"/>
                      </td>
                      <td>                          
                          <input style="width: auto;" readonly type="text" name="prev_end_date" id="prev_end_date_id" value="{$date.prev_end_date|date_format:"%d/%m/%Y"}" title="string___input date"/>
                          <img style="vertical-align: middle;" src="{#js_url#}jscalendar/jscalendar.gif" alt="choose date" id="prev_end_date_img" border="0"/>
                      </td>
                  </tr>
                  <tr>
                      <td colspan="3">
                          <input type="submit" value="Apply" name="submit" class="submit-button"/>
                      </td>
                  </tr>
            </table>
            

        
        </form>
        <div id="chart_div"></div>
        <table width="100%" style="text-align: center;">
            <tr>
                <th colspan="2" align="left">
                    Site Usage
                </th>
            </tr>
            <tr>
                <td >
                    <div class="current">{$data.visits} Visits </div>
                    <div class="previous">
                        Previous: {$data.prev_visits}
                        &nbsp;
                        <font {if $data.visits_rate < 0}color="red"{else}color="green"{/if}>
                            ({$data.visits_rate|string_format:"%.2f"}%)
                        </font>
                    </div>
                </td>
                <td>
                    <div class="current">{$data.bounces|string_format:"%.2f"}% Bounce Rate</div>
                    <div class="previous">
                        Previous: {$data.prev_bounces|string_format:"%.2f"}%
                        &nbsp;
                        <font {if $data.bounces_rate > 0}color="red"{else}color="green"{/if}>
                            ({$data.bounces_rate|string_format:"%.2f"}%)
                        </font>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="current">{$data.pageviews} Page views </div>
                    <div class="previous">
                        Previous: {$data.prev_pageviews}
                        &nbsp;
                        <font {if $data.pageviews_rate < 0}color="red"{else}color="green"{/if}>
                            ({$data.pageviews_rate|string_format:"%.2f"}%)
                        </font>
                    </div>
                </td>
                <td>
                    <div class="current">
                        {$data.time_on_site} Avg. Time on Site
                    </div>
                    <div class="previous">
                        Previous: {$data.prev_time_on_site}
                        &nbsp;
                        <font {if $data.time_on_site_rate < 0}color="red"{else}color="green"{/if}>
                            ({$data.time_on_site_rate|string_format:"%.2f"}%)
                        </font>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="current">{$data.pages_to_visit|string_format:"%.2f"} Pages/Visit </div>
                    <div class="previous">
                        Previous: {$data.prev_pages_to_visit|string_format:"%.2f"}
                        &nbsp;
                        <font {if $data.pages_to_visit_rate < 0}color="red"{else}color="green"{/if}>
                            ({$data.pages_to_visit_rate|string_format:"%.2f"}%)
                        </font>
                    </div>
                </td>
                <td>
                    <div class="current">{$data.newVisits|string_format:"%.2f"}% New Visits </div>
                    <div class="previous">
                        Previous: {$data.prev_newVisits|string_format:"%.2f"}%
                        &nbsp;
                        <font {if $data.newVisits_rate < 0}color="red"{else}color="green"{/if}>
                            ({$data.newVisits_rate|string_format:"%.2f"}%)
                        </font>
                    </div>
                </td>
            </tr>
        </table>
        <table align="center" class="pie_chart" width="500px" style="text-align:left; float:left;" cellpadding="0" cellspacing="0">
            <tr>
                <th colspan="2" align="left">
                    Traffic Sources Overview
                </th>
            </tr>
            <tr>
                <td align="center">
                    <img src="http://chart.apis.google.com/chart?chs=150x150&chd=t:{$traffic_report.direct/$data.visits*100|string_format:"%.2f"},{$traffic_report.referral/$data.visits*100|string_format:"%.2f"},{$traffic_report.search/$data.visits*100|string_format:"%.2f"}&cht=p&chco=058DC7|50B432|ED561B" alt="pie" />
                </td>
                <td>
                    <ul>
                        <li class="rank_1">
                            <div class="legend"></div>
                            <font size="4">Direct Traffic</font> <br /> 
                            {$traffic_report.direct|string_format:"%.2f"}
                            {if !empty($data.visits)}
                            ({$traffic_report.direct/$data.visits*100|string_format:"%.2f"}&nbsp;%)
                            {else}0%
                            {/if}
                        </li>
                        <li class="rank_2">
                            <div class="legend"></div>
                            <font size="4">Referring Sites</font> <br />
                            {$traffic_report.referral|string_format:"%.2f"}
                            {if !empty($data.visits)}
                            ({$traffic_report.referral/$data.visits*100|string_format:"%.2f"}&nbsp;%)
                            {else}0%
                            {/if}
                        </li>
                        <li class="rank_3">
                            <div class="legend"></div>
                            <font size="4">Search Engines</font> <br />
                            {$traffic_report.search|string_format:"%.2f"}
                            {if !empty($data.visits)}
                            ({$traffic_report.search/$data.visits*100|string_format:"%.2f"}&nbsp;%)
                            {else}0%
                            {/if}
                        </li>
                    </ul>
                </td>
            </tr>
        </table>
        <table align="center" width="500px" style="text-align:left;" cellpadding="0" cellspacing="0">
            <tr><td>
            <table id="pre_content_overview" width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <th colspan="3" align="left">
                    Content Overview
                </th>
            </tr>
            <tr style="background-color: #CFCFCF;">
                <td width="50%" >
                    Pages
                </td>
                <td width="25%" align="center">
                    Page Views
                </td>
                <td width="25%" align="center">
                    %
                </td>
            </tr>
            {foreach from=$page_report key=key item=row name=overview}
            {if $smarty.foreach.overview.iteration == 11}
            </table>
            <table id="full_content_overview" width="100%" cellpadding="0" cellspacing="0" style="display: none;">
            {/if}
            <tr>
                <td colspan="3" align="left" style="background-color: #EFEFEF;">
                    <font size="4">{$key}</font>
                </td>
            </tr>
            <tr>
                <td width="50%">
                    {$date.start_date} - {$date.end_date}
                </td>
                <td align="center" width="25%">
                    {$row.pageviews}
                </td>
                <td align="center" width="25%">
                    {$row.pageviews/$data.pageviews*100|string_format:"%.2f"}%
                </td>

            </tr>
            {if $prev_page_report[$key]}
            <tr>
                <td>
                    {$date.prev_start_date} - {$date.prev_end_date}
                </td>
                <td align="center">
                    {$prev_page_report[$key].pageviews}
                </td>
                <td align="center">
                    {$prev_page_report[$key].pageviews/$data.prev_pageviews*100|string_format:"%.2f"}%
                </td>

            </tr>
            <tr>
                <td>
                    % Change
                </td>
                <td align="center">
                    <font {if $row.view_change < 0}color="red"{else}color="green"{/if}>{$row.view_change|string_format:"%.2f"}%</font>
                </td>
                <td align="center">
                    <font {if $row.view_rate_change < 0}color="red"{else}color="green"{/if}>{$row.view_rate_change|string_format:"%.2f"}%</font>
                </td>

            </tr>
            {/if}
            {/foreach}
            </table>
            </td></tr>
            <tr>
                <td>
                    <a href="javascript:void(0);" onclick="view_full_overview();">View full list</a>
                </td>
            </tr>
        </table>
        </div>
            {literal}
        <script type="text/javascript">
	  Calendar.setup({inputField  : "start_date_id",ifFormat    : "%d/%m/%Y",button  : "start_date_img"});
          Calendar.setup({inputField  : "end_date_id",ifFormat    : "%d/%m/%Y",button  : "end_date_img"});
          Calendar.setup({inputField  : "prev_start_date_id",ifFormat    : "%d/%m/%Y",button  : "prev_start_date_img"});
          Calendar.setup({inputField  : "prev_end_date_id",ifFormat    : "%d/%m/%Y",button  : "prev_end_date_img"});

          validator.add('date_form');
	</script>
    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["areachart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Date');
        data.addColumn('number', 'Visits');
        data.addColumn('number', 'Previous Visits');

{/literal}
        data.addRows({$visitors_report|@count});
        {counter start=-1 print=false name="1"}
        {counter start=-1 print=false name="2"}
        {counter start=-1 print=false name="3"}
        {foreach from=$visitors_report item=item}
            data.setValue({counter name="1"}, 0, '{$item.date}');
            data.setValue({counter name="2"}, 1, {$item.visits});
            data.setValue({counter name="3"}, 2, {$item.prev_visits});
        {/foreach}
{literal}
        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, {width: 700, height: 300, legend: 'top', title: 'Visitors Overview', pointSize: 4});
      }

      function view_full_overview()
      {
          document.getElementById('full_content_overview').style.display = '';
      }

      function prepare_previous_date()
      {
          if($('chk_date_id').checked)
          {
                this.current_node = this.oCurrentTextNode;
                var req = new JsHttpRequest();
                var query = {};
                query['start_date'] = $('start_date_id').value;
                query['end_date'] = $('end_date_id').value;
                req.onreadystatechange = function()
                {
                    if(4 == req.readyState)
                    {
                        $('prev_start_date_id').value = req.responseJS.prev_start_date;
                        $('prev_end_date_id').value = req.responseJS.prev_end_date;
                    }
                }
                req.caching = false;
                req.open('post', ajax_prefix + '?rm=ajax_analytics_date', true);
                req.send(query);
          }
      }


    </script>
{/literal}
{/if}
    </div>
</fieldset>



 


       
       

