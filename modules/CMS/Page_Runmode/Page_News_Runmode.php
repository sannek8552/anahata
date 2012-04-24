<?php
require_once('classes/CMS/News_Holder.php');
require_once('classes/CMS/News_Entry_Holder.php');
class Page_News_Runmode extends Runmode 
{
	function Page_News_Runmode()
	{
		$this->base_map[0] = 'page_id';
		$this->base_map[1] = 'full';
		$this->base_map[2] = 'id';
		
		parent::Runmode();
	}
	function process()
	{
                if (isset($_REQUEST['short_list'])) {
                    $GLOBALS['core.application']->init_module('list', true);
                    $news_holder = new News_Holder($_REQUEST['section']);
                    //pp($_REQUEST);
                    $news_id = $news_holder->get_data('id');
                    $news_holder->get_for_short_list($news_id);

                    $GLOBALS['core.smarty']->assign('news_name', $news_holder->get_data('name'));
                    return $GLOBALS['core.smarty']->fetch('Common/CMS/Page_Runmode/news_module_short_list.tpl');
                }
		elseif(isset($_REQUEST['full']) && $_REQUEST['full'] == 'full_article')
		{
			if(isset($_REQUEST['id']) && is_numeric($_REQUEST['id']))
			{
				$new_for_all = new News_Holder($_REQUEST['section']);
				//$all = $new_for_all->get_entries_id();
				$news_entry_holder = new News_Entry_Holder($_REQUEST['id']);
				$flag = 0;
				if((int)count($news_entry_holder->get_data()) == 0)
				{
					$flag = 1;
				}
				elseif(0 == $news_entry_holder->get_data('publish'))
				{
					$flag = 1;
				}
				
				if($flag == 0)
				{
					$GLOBALS['core.smarty']->assign('article', $news_entry_holder->get_data());
					$GLOBALS['core.smarty']->assign('hid_current', $_REQUEST['page_id']);
				}
				else 
				{
					$GLOBALS['core.smarty']->assign('error_article', 1);
				}
			}
		}
		else
		{
			$GLOBALS['core.application']->init_module('list', true);
			$news_holder = new News_Holder($_REQUEST['section']);
                        //pp($_REQUEST);
			$news_id = $news_holder->get_data('id');
			if(isset($_REQUEST['page_id']) && is_numeric($_REQUEST['page_id']))
			{
				$news_holder->get_by_page($_REQUEST['page_id'], $news_id, 1);
			}
			else 
			{
				$news_holder->get_by_page(1, $news_id, 1);
			}
			$GLOBALS['core.smarty']->assign('news_name', $news_holder->get_data('name'));
		}


                return $GLOBALS['core.smarty']->fetch('Common/CMS/Page_Runmode/news_module.tpl');
	}
}
?>