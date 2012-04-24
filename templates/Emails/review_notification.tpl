{config_load file=templates.ini section="common" scope="global"}

A new review has been added to the website. Please go to Administration/Review Manager to approve, or remove this review.
<br /><br />
Name: {$data.name} <br />
Review: {$data.comment} <br />
Product : <a href="{#domain_name#}{#script_url#}{seo_url rm=Product param1=$data.product_id}" >{#domain_name#}{#script_url#}{seo_url rm=Product param1=$data.product_id}</a>