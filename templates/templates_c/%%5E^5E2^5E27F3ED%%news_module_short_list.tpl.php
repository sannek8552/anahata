<?php /* Smarty version 2.6.18, created on 2012-04-25 09:38:49
         compiled from Common/CMS/Page_Runmode/news_module_short_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'Common/CMS/Page_Runmode/news_module_short_list.tpl', 1, false),array('function', 'seo_url', 'Common/CMS/Page_Runmode/news_module_short_list.tpl', 13, false),array('modifier', 'date_format', 'Common/CMS/Page_Runmode/news_module_short_list.tpl', 5, false),array('modifier', 'escape', 'Common/CMS/Page_Runmode/news_module_short_list.tpl', 7, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => "templates.ini",'section' => 'common','scope' => 'global'), $this);?>

<div class="short_news" >
<?php $_from = $this->_tpl_vars['all_news']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
<div class="item">
    <div class="news_date"><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['adddate'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d-%m-%Y") : smarty_modifier_date_format($_tmp, "%d-%m-%Y")); ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['item']['addtime'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>
</div>
    <div class="news_name">
        <h2><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h2>
    </div>
    <div class="news_description">
        <?php if ($this->_tpl_vars['item']['short']): ?>
            <?php echo $this->_tpl_vars['item']['short']; ?>

            <?php if ($this->_tpl_vars['item']['full']): ?>
                <a href="<?php echo $this->_config[0]['vars']['script_url']; ?>
<?php echo smarty_function_seo_url(array('rm' => $this->_tpl_vars['seo_url'],'param1' => 1,'param2' => 'full_article','param3' => $this->_tpl_vars['item']['id']), $this);?>
">Подробнее...</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    
</div>
<?php endforeach; else: ?>
    Нет записей
<?php endif; unset($_from); ?>
</div>
