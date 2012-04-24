{config_load file=templates.ini section="common" scope="global"}

<div class="content-container">
  <h2>Admin - Site Backup</h2>
  <p>Please note, creating backup copy of site can take several minutes. Please be patient.</p>

  
  <form action="{#script_url#}{seo_url}" method="post" >
  <input type="submit" name="save" value="Create and Download site backup" onclick="{literal}$('text_back').innerHTML='Creating backup copy of site started. Please wait.';this.form.submit();return true;{/literal}" />
  </form>
  
  <div id="text_back" >
  </div>
  
</div>