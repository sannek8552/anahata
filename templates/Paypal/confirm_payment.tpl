{config_load file=templates.ini section="common"}
<form action="{#script_url#}" method="post">
<input type="hidden" name="rm" value="do_payment"/>
<input type="hidden" name="request_id" value="{$request_id}"/>
<h1>Finalise Order</h1>
	<table width =400>
    <tr>
    	<td width="100"><b>Payment Total:</b></td>
        <td>
        	{$currencyCodeType} ${$paymentAmount}
        </td>
    </tr>
	<tr>
    	<td class="thinfield">
        	<input type="submit" value="Pay" />
        </td>
    </tr>
    </table>


</form>