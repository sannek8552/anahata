{config_load file=templates.ini section="common" scope="global"}
<div id="bodyContent">
<h1>Bank Deposit Details</h1>
 <p> {$deposit.info} </p>

 {*<p><strong>Transaction ID</strong>: 0300{$trid}*}
  <br />
  <br />
  <input type="button" name="process" value="Process" onclick="document.location = 'FinishDeposit.html';" />
</p>
</div>
