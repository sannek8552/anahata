<?php
class Feed_Load extends Runmode 
{
	function Feed_Load()
	{
		$GLOBALS['core.application']->init_module('xml',true);
	} 
	function process_ajax()	
	{
		$data = array('rss_url'=>'http://www.ntv.ru/exp/newsrss.jsp', 
					'rss_ajax'=>0, 
					'rss_title'=>1, 
					'rss_pubdate'=>1, 
					'rss_description'=>1,
					'rss_id' => 0,
					'rss_list'=>20
					);
		$sobit   = $_REQUEST['action'];
		if ($sobit=='news')
		{
			$data=unserialize($_SESSION['data_rss']);
			$GLOBALS['core.xml']->setInput($data['rss_url']); //- ��� ��������
			$news=$GLOBALS['core.xml']->parser_xml_to_array();
			if (count($news["rss"]["channel"][0]["item"])>0)
			{
				$data['rss_ajax']=0;
				$GLOBALS['core.smarty']->assign('list_news',$news["rss"]["channel"][0]["item"]);
				$GLOBALS['core.smarty']->assign('data',$data);
				$result = array(
					"rez"=>"yes",
					'content' => $GLOBALS['core.smarty']->fetch('Common/CMS/Page_Runmode/contact_module_news.tpl')
				);
			}
			else 
			{
				$result = array(
					"rez"=>"no",
					'content' => ''
				);
				
			}
		}
		$GLOBALS['core.ajax']->put_to_output($result);
	}
}
?>
