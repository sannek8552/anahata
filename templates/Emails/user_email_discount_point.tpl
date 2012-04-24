{config_load file=templates.ini section="common" scope="global"}

Hello {$data.billing.name}, you have exceeded minimum amount of discount points.
Amount of points (AUD): {$data.discount_point|money} .
Now you can use your points to pay for products at {#full_url#}  .