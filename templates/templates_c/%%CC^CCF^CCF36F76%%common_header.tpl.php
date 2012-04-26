<?php /* Smarty version 2.6.18, created on 2012-04-26 09:48:35
         compiled from common_header.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'common_header.tpl', 1, false),array('function', 'seo_url', 'common_header.tpl', 69, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => "templates.ini",'section' => 'common','scope' => 'global'), $this);?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php if ($this->_tpl_vars['seo_data']['page_title']): ?>Анахата :: <?php echo $this->_tpl_vars['seo_data']['page_title']; ?>
<?php else: ?>Школа ЙОГИ Анахата<?php endif; ?></title>
<?php if ($this->_tpl_vars['seo_data']['page_description']): ?><meta name="description" content="<?php echo $this->_tpl_vars['seo_data']['page_description']; ?>
" /><?php endif; ?>
<?php if ($this->_tpl_vars['seo_data']['keywords']): ?><meta name="keywords" content="<?php echo $this->_tpl_vars['seo_data']['keywords']; ?>
" /><?php endif; ?>

<link rel="image_src" href="<?php echo $this->_config[0]['vars']['img_url']; ?>
logo.png" />
<link href="<?php echo $this->_config[0]['vars']['css_url']; ?>
main.css?1=2" rel="stylesheet" type="text/css" />
<link  href="<?php echo $this->_config[0]['vars']['css_url']; ?>
slimbox.css" rel="stylesheet" type="text/css" media="screen" />
<link  href="<?php echo $this->_config[0]['vars']['css_url']; ?>
jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript">
        var script_url = '<?php echo $this->_config[0]['vars']['script_url']; ?>
';
        var images_prefix = '<?php echo $this->_config[0]['vars']['img_url']; ?>
';
        var ajax_prefix = '<?php echo $this->_config[0]['vars']['script_url']; ?>
';
        var common_prefix = '<?php echo $this->_config[0]['vars']['common_url']; ?>
';        
</script>
<script type="text/javascript" src="<?php echo $this->_config[0]['vars']['js_url']; ?>
validator_o.js"></script>

<script type="text/javascript" src="<?php echo $this->_config[0]['vars']['js_url']; ?>
AJAX.js"></script>
<script type="text/javascript" src="<?php echo $this->_config[0]['vars']['js_url']; ?>
body_blocker.js"></script>
<script type="text/javascript" src="<?php echo $this->_config[0]['vars']['js_url']; ?>
jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="<?php echo $this->_config[0]['vars']['js_url']; ?>
jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="<?php echo $this->_config[0]['vars']['js_url']; ?>
jquery.placeholder.min.js"></script>
<?php echo ' 
<script type="text/javascript">        
           
        $(document).ready(function(){
            jQuery(\'input[placeholder], textarea[placeholder]\').placeholder();
            //init_additional();
            '; ?>
<?php echo $this->_tpl_vars['text_to_init']; ?>
<?php echo '

            /*$(\'#search_form\').bind(\'submit\', function(){
                var url = \''; ?>
<?php echo $this->_config[0]['vars']['script_url']; ?>
<?php echo 'Search/\';
                url += $("#search_form input[name=\'search\']").val() + \'.html\';
                $(\'#search_form\').attr(\'action\', url);
            });*/

            
        });
        
    </script>


<script type="text/javascript" src="http://userapi.com/js/api/openapi.js?49"></script>
<script type="text/javascript" src="http://vk.com/js/api/share.js?11" charset="windows-1251"></script>
<script type="text/javascript">
  VK.init({apiId: 2923829, onlyWidgets: true});
</script>
'; ?>


</head>
<body>
<div id="wrapper">
    <div id="container">
        <div id="header">
            <a href="<?php echo $this->_config[0]['vars']['script_url']; ?>
index.html" class="logo" title="Анахата :: Главная"></a>
            <div class="banner">
                <img src="<?php echo $this->_config[0]['vars']['img_url']; ?>
test_banner.png" alt=""/>
            </div>
            <div class="clear"></div>

        </div>
        <div id="menu">
            <ul>
                <li><a href="<?php echo $this->_config[0]['vars']['script_url']; ?>
<?php echo smarty_function_seo_url(array('rm' => 'index'), $this);?>
">Главная</a></li>
                <li <?php if ($this->_tpl_vars['seo_data']['page_title'] == 'О нас'): ?>class="active"<?php endif; ?>><a href="<?php echo $this->_config[0]['vars']['script_url']; ?>
<?php echo smarty_function_seo_url(array('rm' => 'About'), $this);?>
">О нас</a></li>
                <li <?php if ($this->_tpl_vars['seo_data']['page_title'] == 'Расписание'): ?>class="active"<?php endif; ?>><a href="<?php echo $this->_config[0]['vars']['script_url']; ?>
<?php echo smarty_function_seo_url(array('rm' => 'schedule'), $this);?>
">Расписание</a></li>
                <li <?php if ($this->_tpl_vars['seo_data']['page_title'] == 'Фотогалерея'): ?>class="active"<?php endif; ?>><a href="<?php echo $this->_config[0]['vars']['script_url']; ?>
<?php echo smarty_function_seo_url(array('rm' => 'Photogallery'), $this);?>
">Фотогалерея</a></li>
            </ul>

        </div>

        <div id="main" >
          <div id="content">

                <?php if ($this->_tpl_vars['body']): ?>
                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['body'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

                <?php elseif ($this->_tpl_vars['body_as_text']): ?>
                    <?php echo $this->_tpl_vars['body_as_text']; ?>


                <?php endif; ?>
          </div>
          
        </div>
        <div id="footer">
            <p>Школа ЙОГИ Анахата г. Томск</p>
            </div>
        
    </div>
</div>
</body>
</html>