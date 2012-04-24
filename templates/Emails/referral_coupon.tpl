{config_load file=templates.ini section="common" scope="global"}

Dear, {$user.login}.
<br /><br />
We appreciate your help with finding new clients for our site and we are glad to send you<br />
discount coupon to use on our site.<br />
<br />
Coupon details:<br />
Name: {$coupon.name}<br />
Description: {$coupon.description}<br />
Type: {$coupon.apply_type}<br />
Code: {$coupon.code}<br />
<br />
<br />
Scotty Makeup Store team.