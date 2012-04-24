{config_load file=templates.ini section="common" scope="global"}
{literal}
<script type="text/javascript">		
window.addEvent('domready', function()
	{			
		var Tips2 = new Tips($$('.Tips2'), {				initialize:function(){					this.fx = new Fx.Style(this.toolTip, 'opacity', {duration: 500, wait: false}).set(0);				},				onShow: function(toolTip) {					this.fx.start(1);				},				onHide: function(toolTip) {					this.fx.start(0);				}			});		
	}); 	
</script>	
<style type="text/css">		
.imgRight {
	float:right;
}
.tool-title
{
	display:none;
}
</style>	
{/literal}


<div class="content-container">
<h2>Individual Certificate Manager</h2>
<div><a href="{#script_url#}{seo_url rm = AdminCertificate}">&larr; Certificate Manager</a></div>
<div id="adminProduct">
  <form name="edit_certificate" action="{#script_url#}{seo_url rm= AdminCertificate }" enctype="multipart/form-data" method="post">
  <input type="hidden" name="row_num" value="1" />
      <fieldset name="information" id="information">
    	<legend>Certificate</legend>
    	{if $certificate.id}
  			<input type="hidden" name="id" value="{$certificate.id}" />
		{/if}
  		<input type="hidden" name="action" value="save" />    
  		<table>      
  			<tr>
      			<td valign="top"><b>Name</b></td>
	  			<td colspan="2"><input onchange="populate_product_seo(true);" id="name" type="text" name="name" value="{$certificate.name}" title="string___<br/>Please enter product name" /></td>
	  		</tr>
    		<tr>
      			<td valign="top"><b>Item C<span class="style1">ode</span></b></td>  
	  			<td colspan="2"><input type="text" name="number" value="{$certificate.number}" /></td>
	  		</tr>    
    		<tr>
      			<td valign="top"><b>Price</b></td>
      			<td colspan="2">
                    <input type="text" name="price" value="{$certificate.price}" id="price_row"  title="numeric___<br/>Please enter price" />
                </td>
			</tr>    	
    		<tr>
      			<td valign="top"><b>Order</b></td>
    			<td colspan="2"><input type="text" name="order_no" value="{$certificate.order_no}"/></td>
	  		</tr>
    		<tr>
      			<td valign="top"><b>Subcategory Image</b></td>
    			<td colspan="2"><input type="checkbox" class="submit-button" name="subcategory_picture" {$certificate.subcategory_picture|checked}/></td>
	  		</tr>    
    		<tr>      
      			<td valign="top"><b>Image Upload</b></td>  
  				<td width="200" valign="top"><input type="file" name="picture" />
	  			{if $certificate.id}
        			<a href="#" title="<div style='background-color:#ffffff;padding:5px;'><IMG src='{#script_url#}{show_image id=$certificate.id width=tip_width height=tip_height param1=2}'/></div>" class="Tips2" ><b>Hover here to see current image</b></a>
	  			{/if}
	  			</td>	    
	  			<td width="99" valign="top">&nbsp;</td>
    		</tr>
    		<tr>
      			<td valign="top"><b>Basic Description</b></td>
	    		<td colspan="2"><textarea name="description" class="wide">{$certificate.description}</textarea></td>
	  		</tr>    
    		<tr>
      			<td valign="top"><b>HTML Editor - Full Description</b></td>
	  			<td colspan="2">	  	
		 			<textarea style="height:500px; width: 600px;" name="full_description" id="full_descriptionid" >{$certificate.full_description}</textarea>
		 		</td>
    		</tr>
    		<tr>
        		<td valign="top"><b>Seo url</b></td>
	    		<td colspan="2">
	    			<input id="seo_url" type="text" name="seo" onchange="clean_seo(this);" value="{$certificate.seo}" title="string___Please input seo url" />
	    			<br />
	    			<a href="javascript:void(0);" onclick="populate_product_seo(false);">Auto Fill from Name</a>
				</td>
    		</tr>
    		<tr>
    			<td valign="top"><b>Inactive</b></td>
    			<td colspan="2"><input type="checkbox" name="inactive" {if $certificate.inactive == 1}checked{/if} /></td>
    		</tr>    		    	
    		<tr>
      			<td>
      				<input type="submit" class="submit-button" name="save" value="Save" />
      			</td>
	  		</tr>
  		</table>
    	</fieldset>
  </div>
  
</form>
  {fceditor_init}</div>
<script type="text/javascript">
validator.add('edit_certificate');
{literal}
populate_product_seo = function(auto)
{
		//alert('populate');
		if(!auto || $('seo_url').value.length == 0)
		{
			var page_title = $('name').value;
			page_title = page_title.replace(/\s/g,'-');
            page_title = page_title.replace(/\&/g,'and');
			page_title = page_title.replace(/([^a-z|A-Z|\d|\-])/g,'');
			$('seo_url').value = page_title;
			//alert('populated');
		}
};

clean_seo = function(elem)
{
	elem.value = elem.value.replace(/\s/g,'-');
    elem.value = elem.value.replace(/\&/g,'and');
	elem.value = elem.value.replace(/([^a-z|A-Z|\d|\-])/g,'');
}

{/literal}

</script>

<script type="text/javascript">
{literal}
tinyMCE.init({
		// General options
		mode : "exact",
		elements: "full_descriptionid",
		theme : "advanced",
		plugins : "ibrowser,safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,ibrowser",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example word content CSS (should be your site CSS) this one removes paragraph margins
		content_css : "{/literal}{#css_url#}main.css{literal}",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js"
		
	});
{/literal}
</script>

