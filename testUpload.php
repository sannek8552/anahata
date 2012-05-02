<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<button id="uploader" >Upload</button>
<script src="/anahata/js/jquery-1.7.min.js" type="text/javascript"></script>
<script type="text/javascript" src="/anahata/js/ajaxupload.3.5.js"></script>
<script type="text/javascript">
$(function(){
        var btnUpload=$('#uploader');
        new AjaxUpload(btnUpload, {
                action: '/anahata/test.php',
                name: 'file',
                responseType : 'json',
                onSubmit: function(file, ext){
                         if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
                                status.text('Only JPG, PNG or GIF files are allowed');
                                return false;
                        }

                },
                onComplete: function(file, res){
                        if(res.success){
                            alert(res.filename);
                        }
                }
        });

});
</script>