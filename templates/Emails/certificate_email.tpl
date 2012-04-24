<p>{config_load file=templates.ini section="common" scope="global"}
  
  Dear {$data.person_name},<br />
  <br />
  Your friend ordered a gift certificate for you from of <a href="{#full_url#}" >Scotty Makeup Store</a>.</p>
<p>You can use your certificate anytime you want by entering this code : {$data.code} at cart checkout page on our site.</p>
<p>Your certificate is for: {$data.price|money}<br />
  <br />
  {if $data.person_comment}
  Personal message:<br />
  {$data.person_comment}
  {/if} <br />
  Scotty's Makeup Store team.</p>
