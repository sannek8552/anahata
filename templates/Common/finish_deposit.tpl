{config_load file=templates.ini section="common" scope="global"}
<div id="bodyContent">
<h1>Success!</h1>
Thank you, your order has been submitted and will be processed shortly.
<h1>Bank Deposit Details</h1>
<p> {$deposit.info} </p>

 <p><strong>Transaction ID</strong>: {$trid}
  <br />
 </p>
</div>

{include file='Common/google_analytics_cart.tpl'}