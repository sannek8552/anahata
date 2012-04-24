<p>{config_load file=templates.ini section="common" scope="global"}
  </p>
<p>Hello. A request to restore your password has been made.  </p>
<p>If it was not you please ignore this email.</p>
<p>  To restore your password you need to go this link - <a href="{#full_url#}{seo_url rm=Remind_Password param1="$confirmation_code" }">{#full_url#}{seo_url rm=Remind_Password param1="$confirmation_code" }</a></p>
<p>Yout login is {$login}</p>
<p>Your password then will be {$new_password} </p>
