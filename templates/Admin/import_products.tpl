{config_load file=templates.ini section="common" scope="global"}

<div class="content-container">
  <h2>Admin - Import Products</h2>
  <p>Please note, importing products can take several minutes. Please be patient.</p>
  
  <form action="{#script_url#}{seo_url}" method="post" >
  <input type="submit" name="save" value="Import products" onclick="{literal}$('text_back').innerHTML='Import started. Please wait.';this.form.submit();return true;{/literal}" />
  </form>
  
  <div id="text_back" >
  </div>
  
</div>