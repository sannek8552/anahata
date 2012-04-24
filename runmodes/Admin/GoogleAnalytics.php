<?php
require_once('Admin_Header.php');
require_once('CMS/SettingsHolder.php');
require_once('CMS/GoogleAnalytics_Holder.php');

class GoogleAnalytics extends Runmode
{
	function GoogleAnalytics()
	{
		parent::Runmode();
	}
	
	function process()
	{
            $sh = new SettingsHolder();
            $settings = $sh->loadSettings();
            $errors = array();
            if(isset($settings['analytics_login']) && isset($settings['analytics_password']) && isset($settings['analytics_profile_id']) && !empty($settings['analytics_login']) && !empty($settings['analytics_password']) && !empty($settings['analytics_profile_id']))
            {
                $login = $settings['analytics_login'];
                $password = $settings['analytics_password'];
                $profile_id = 'ga:'.$settings['analytics_profile_id'];
                //$profile_id = $settings['analytics_profile_id'];
                $start_date         =   isset($_REQUEST['start_date'])?$_REQUEST['start_date']:date('d/m/Y', time());
                $end_date           =   isset($_REQUEST['end_date'])?$_REQUEST['end_date']:date('d/m/Y', time());
                $prev_start_date    =   isset($_REQUEST['prev_start_date'])?$_REQUEST['prev_start_date']:date('d/m/Y', time()-86400);
                $prev_end_date      =   isset($_REQUEST['prev_end_date'])?$_REQUEST['prev_end_date']:date('d/m/Y', time()-86400);
                //pp($start_date);
                $start_date         = date("Y-m-d", mktime(0, 0, 0, substr($start_date,3,2), substr($start_date,0,2), substr($start_date,-4,4)));
                //pp($start_date);exit();
                $end_date           = date("Y-m-d", mktime(0, 0, 0, substr($end_date,3,2), substr($end_date,0,2), substr($end_date,-4,4)));
                $prev_start_date    = date("Y-m-d", mktime(0, 0, 0, substr($prev_start_date,3,2), substr($prev_start_date,0,2), substr($prev_start_date,-4,4)));
                $prev_end_date      = date("Y-m-d", mktime(0, 0, 0, substr($prev_end_date,3,2), substr($prev_end_date,0,2), substr($prev_end_date,-4,4)));


                if($start_date>$end_date || $prev_start_date>$prev_end_date) $errors['Date'] = 'Invalid Date Range. Start Date is greated than End Date';
                $ga = new GoogleAnalytics_Holder();
                if(!$ga->_authenticate($login,$password)) $errors['Authenticate'] = 'Failed to authenticate, please check your email and password.';
                if(!$ga->setProfile($profile_id)) $errors['ProfileId'] = 'The format should XXXXXX, of up to 10 digits, where XXXXXX is your profile number.';
                if(!$ga->getReport(array('metrics'=>urlencode('ga:pageviews'))))
                {
                    $errors['Request'] = 'Bad request or Permission denied with ['.$profile_id.'] profileId. Please check the profile ID, and make sure Google has verified your tracking code, and that Google has already started collecting data.';
                }
                if(!empty($errors))
                {
                    $GLOBALS['core.smarty']->assign('errors',$errors);
                }
                else
                {
                    $ga->setDateRange($start_date, $end_date);
                    $cur_prev_report_metrics = array(
                                                'visits',
                                                'pageviews',
                                                'bounces',
                                                'entrances',
                                                'timeOnSite',
                                                'newVisits'
                                                );
                    $cur_report = $ga->getReport(array('metrics'=>urlencode('ga:pageviews,ga:visits,ga:bounces,ga:entrances,ga:timeOnSite,ga:newVisits')));
                    foreach($cur_report as $row) $cur_report = $row;
                    $this-> validate_report($cur_report,$cur_prev_report_metrics);

                    $page_report = $ga->getReport(array('dimensions' =>urlencode('ga:pagePath'),'metrics'=>urlencode('ga:pageviews'),'sort'=>'-ga:pageviews'));

                    $traffic_report = $ga->getReport(array('dimensions' =>urlencode('ga:medium'),'metrics'=>urlencode('ga:visits'),'sort'=>'-ga:visits'));
                    $traffic_report = array('direct'=>isset($traffic_report['(none)']['visits'])?$traffic_report['(none)']['visits']:0,
                                            'search'=>isset($traffic_report['organic']['visits'])?$traffic_report['organic']['visits']:0,
                                            'referral'=>isset($traffic_report['referral']['visits'])?$traffic_report['referral']['visits']:0);
                    /***   visitors report   ***/
                    $visitors_report = $ga->getReport(array('dimensions' =>urlencode('ga:date'),'metrics'=>urlencode('ga:visits'),'sort'=>'ga:date'));
                    
                    $end_date_array = explode('-',$end_date);
                    $v_end_date = mktime(0, 0, 0, $end_date_array[1], $end_date_array[2], $end_date_array[0]);
                    $start_date_array = explode('-',$start_date);
                    $v_start_date = mktime(0, 0, 0, $start_date_array[1], $start_date_array[2], $start_date_array[0]);
                    $prev_start_date_array = explode('-',$prev_start_date);
                    $v_prev_start_date = mktime(0, 0, 0, $prev_start_date_array[1], $prev_start_date_array[2], $prev_start_date_array[0]);
                    $v_prev_end_date = $v_prev_start_date + $v_end_date - $v_start_date;
                    $ga->setDateRange($prev_start_date, date("Y-m-d",$v_prev_end_date ));
                    $prev_visitors_report = $ga->getReport(array('dimensions' =>urlencode('ga:date'),'metrics'=>urlencode('ga:visits'),'sort'=>'ga:date'));
                    $temp = array();
                    foreach($visitors_report as $key=>$value)
                    {
                        $visitors_report[$key]['date'] = date("d M", mktime(0, 0, 0, substr($key,4,-2), substr($key,6), substr($key,0,-4)));
                        $temp[] = $visitors_report[$key];
                    }
                    $visitors_report = $temp;

                    $i=0;
                    foreach($prev_visitors_report as $key=>$value)
                    {
                        if(isset($visitors_report[$i]))
                        $visitors_report[$i]['prev_visits'] = $value['visits'];
                        $i++;
                    }
                    /***   end   ***/
                    $ga->setDateRange($prev_start_date, $prev_end_date);
                    $prev_report = $ga->getReport(array('metrics'=>urlencode('ga:pageviews,ga:visits,ga:bounces,ga:entrances,ga:timeOnSite,ga:newVisits')));
                    foreach($prev_report as $row) $prev_report = $row;
                    $this-> validate_report($prev_report,$cur_prev_report_metrics);

                    $prev_page_report = $ga->getReport(array('dimensions' =>urlencode('ga:pagePath'),'metrics'=>urlencode('ga:pageviews'), 'sort'=>'-ga:pageviews'));

                    $data['visits'] = $cur_report['visits'];
                    $data['prev_visits'] = $prev_report['visits'];
                    if(!empty($prev_report['visits']))
                        $data['visits_rate'] = ($cur_report['visits']-$prev_report['visits'])/$prev_report['visits']*100;
                    else $data['visits_rate'] = 0;
                    $data['pageviews'] = $cur_report['pageviews'];
                    $data['prev_pageviews'] = $prev_report['pageviews'];
                    if(!empty($prev_report['pageviews']))
                        $data['pageviews_rate'] = ($cur_report['pageviews']-$prev_report['pageviews'])/$prev_report['pageviews']*100;
                    else $data['pageviews_rate'] = 0;
                    if(!empty($cur_report['entrances']))
                        $data['bounces'] = $cur_report['bounces']/$cur_report['entrances']*100;
                    else $data['bounces']= 0;
                    if(!empty($prev_report['entrances']))
                        $data['prev_bounces'] = $prev_report['bounces']/$prev_report['entrances']*100;
                    else $data['prev_bounces'] = 0;
                    $data['bounces_rate'] = $data['bounces']-$data['prev_bounces'];
                    if(!empty($cur_report['visits']))
                        $data['pages_to_visit'] = $cur_report['pageviews']/$cur_report['visits'];
                    else $data['pages_to_visit'] = 0;
                    if(!empty($prev_report['visits']))
                        $data['prev_pages_to_visit'] = $prev_report['pageviews']/$prev_report['visits'];
                    else $data['prev_pages_to_visit'] = 0;
                    if(!empty($data['prev_pages_to_visit']))
                        $data['pages_to_visit_rate'] = ($data['pages_to_visit']- $data['prev_pages_to_visit'])/ $data['prev_pages_to_visit']*100;
                    else $data['pages_to_visit_rate'] = 0;
                    if(!empty($cur_report['visits']))
                        $data['time_on_site'] = $this->format_time($cur_report['timeOnSite']/$cur_report['visits']);
                    else $data['time_on_site'] = 0;
                    if(!empty($prev_report['visits']))
                        $data['prev_time_on_site'] = $this->format_time($prev_report['timeOnSite']/$prev_report['visits']);
                    else $data['prev_time_on_site'] = 0;
                    if(!empty($cur_report['visits']) && !empty($prev_report['visits']) && !empty($prev_report['timeOnSite']))
                        $data['time_on_site_rate'] = (($cur_report['timeOnSite']/$cur_report['visits'] - $prev_report['timeOnSite']/$prev_report['visits'])/ ($prev_report['timeOnSite']/$prev_report['visits']))*100;
                    else $data['time_on_site_rate'] = 0;
                    if(!empty($cur_report['visits']))
                        $data['newVisits'] = $cur_report['newVisits']/$cur_report['visits']*100;
                    else $data['newVisits']=0;
                    if(!empty($prev_report['visits']))
                        $data['prev_newVisits'] = $prev_report['newVisits']/$prev_report['visits']*100;
                    else $data['prev_newVisits'] = 0;
                    $data['newVisits_rate'] = $data['newVisits']- $data['prev_newVisits'];

                    foreach($page_report as $key=>$row)
                    {
                        if(isset($prev_page_report[$key]) && !empty($prev_page_report[$key]['pageviews']) && !empty($data['pageviews']) && !empty($data['prev_pageviews']))
                        {
                            $page_report[$key]['view_change'] = ($row['pageviews'] - $prev_page_report[$key]['pageviews'])/$prev_page_report[$key]['pageviews']*100;
                            $page_report[$key]['view_rate_change'] = ($row['pageviews']/$data['pageviews'] - $prev_page_report[$key]['pageviews']/$data['prev_pageviews'])/($prev_page_report[$key]['pageviews']/$data['prev_pageviews'])*100;
                        }

                    }

                    $GLOBALS['core.smarty']->assign('data',$data);
                    $GLOBALS['core.smarty']->assign('page_report',$page_report);
                    $GLOBALS['core.smarty']->assign('prev_page_report',$prev_page_report);
                    $GLOBALS['core.smarty']->assign('date',array('start_date'=>$start_date,
                                                                'end_date'=>$end_date,
                                                                'prev_start_date'=>$prev_start_date,
                                                                'prev_end_date'=>$prev_end_date,));
                    $GLOBALS['core.smarty']->assign('traffic_report',$traffic_report);
                    $GLOBALS['core.smarty']->assign('visitors_report',$visitors_report);
                    $GLOBALS['core.smarty']->assign('prev_visitors_report',$prev_visitors_report);
                    //pp($visitors_report);
                }
            }
            else
            {
                $GLOBALS['core.smarty']->assign('no_settings',1);
            }

            return Admin_Header::out('google_analytics');
	}
        function format_time($sec)
        {
            $a = array(
                        3600  => 'hour',
                        60    => 'min',
                        1     => 'sec'
                        );
            $out = array();
            foreach ($a as $k=>$v)
            {
                $tmp = floor($sec/$k);

                if($tmp == 0)               $out[$v] = '00';
                elseif($tmp <10 && $tmp>0)  $out[$v] = '0'.$tmp;
                else                        $out[$v] = $tmp;

                $sec -= $tmp*$k;
            }

            return join(':',$out);
        }

        function validate_report(&$report,$metrics)
        {
            foreach($metrics as $metric)
                $report[$metric] = isset($report[$metric])?$report[$metric]:0;

        }

        function date_process_ajax()
        {
            $start_date = isset($_REQUEST['start_date'])?$_REQUEST['start_date']:0;
            $end_date = isset($_REQUEST['end_date'])?$_REQUEST['end_date']:0;
            $success = false;
            if(!empty($start_date)&&!empty($end_date))
            {
                
                $start_date_array = explode('/',$start_date);
                $start_date = mktime(0, 0, 0, $start_date_array[1], $start_date_array[0], $start_date_array[2]);
                $end_date_array = explode('/',$end_date);
                $end_date = mktime(0, 0, 0, $end_date_array[1], $end_date_array[0], $end_date_array[2]);
                $prev_start_date = $start_date-($end_date-$start_date)-86400;
                $prev_end_date = $end_date-($end_date-$start_date)-86400;
                $prev_start_date = date('d/m/Y',$prev_start_date);
                $prev_end_date = date('d/m/Y',$prev_end_date);
                //pp($prev_start_date);
                //pp($prev_end_date);
                $out['prev_start_date'] = $prev_start_date;
                $out['prev_end_date'] = $prev_end_date;
                $success = true;
            }
            //pp($_REQUEST);
            $out['success'] = $success;
            $GLOBALS['core.ajax']->put_to_output($out);
        }

	
	
}
?>