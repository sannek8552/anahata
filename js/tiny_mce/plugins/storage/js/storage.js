tinyMCEPopup.requireLangPack();

function insert_module(module_string)
{
    tinyMCEPopup.execCommand('mceInsertContent', false, module_string);
    tinyMCEPopup.close();
}