<?php
require_once('classes/CMS/Contact_Form_Holder.php');
require_once('classes/CMS/Contact_Holder.php');

class Page_Contact_News extends Runmode 
{
	function Page_Contact_News()
	{
		$GLOBALS['core.application']->init_module('xml', true);
		parent::Runmode();
	}
	
	function process()
	{
		$data = array('rss_url'=>'http://www.ntv.ru/exp/newsrss.jsp', 
					'rss_ajax'=>0, 
					'rss_title'=>1, 
					'rss_pubdate'=>1, 
					'rss_description'=>1,
					'rss_id' => 0,
					'rss_list'=>20
					);
		if (isset($_REQUEST['section']) && !empty($_REQUEST['section'])&& preg_match('/[0-9]+/i',$_REQUEST["section"]))		
		{
			$sql='SELECT * FROM #p#rss WHERE rss_id=?';
			$data=$GLOBALS['core.sql']->getRow($sql,array($_REQUEST["section"]));
		}
		else
		{
			if (isset($_REQUEST['url_rss']) && !empty($_REQUEST['url_rss']))		
			{
				$data['rss_url']=$_REQUEST['url_rss'];
			}
			if (isset($_REQUEST['ajax_rss']) && !empty($_REQUEST['ajax_rss']))		
			{
				$data['rss_ajax']=$_REQUEST['ajax_rss'];
			}
			if (isset($_REQUEST['list_rss']) && !empty($_REQUEST['list_rss']))		
			{
				$data['rss_list']=$_REQUEST['list_rss'];
			}
			if (isset($_REQUEST['title_rss']) && !empty($_REQUEST['title_rss']))		
			{
				$data['rss_list']=$_REQUEST['title_rss'];
			}
			if (isset($_REQUEST['description_rss']) && !empty($_REQUEST['description_rss']))		
			{
				$data['rss_list']=$_REQUEST['description_rss'];
			}
		}
		$GLOBALS['core.smarty']->assign('data',$data);
		if ($data['rss_ajax']!=1)			
		{
			$GLOBALS['core.xml']->setInput($data['rss_url']); 
			$news = $GLOBALS['core.xml']->parser_xml_to_array();
                        //pp($news);
			$GLOBALS['core.smarty']->assign('list_news',$news["rss"]["channel"][0]["item"]);
		}
		else 
		{
			$_SESSION['data_rss']=serialize($data);
		}
		return $GLOBALS['core.smarty']->fetch('Common/CMS/Page_Runmode/contact_module_news.tpl');
	}
	
	function save($array, $id)
	{
		$f=fopen("news_".$id.".txt","w");
		$rcc=serialize($array);
		fwrite($f,$rcc);
		fclose($f);
	}

} 
?>