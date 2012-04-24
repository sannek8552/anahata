{config_load file=templates.ini section="common" scope="global"}
<br /><br /><br />
Product {$product_data.name} or one of it options have reached low stock limit.
<br /><br />
Link at product :  <a href="{#full_url#}{seo_url rm=AdminProduct param1=edit param2=$product_data.id}">{$product_data.name}</a>
<br /><br />