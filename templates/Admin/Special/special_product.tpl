{config_load file=templates.ini section="common" scope="global"}
<tr>
	<td colspan="100">
<fieldset name="information" id="information">
      <legend>Product Specials</legend>     
	<table>
    <tr>
    	<td><b>Special amount</b></td>
    	<td>
    		<div class="date"><input type="text" name="special_amount" value="{$special_data.amount}" title="numeric_empty___<br />Please input numeric value"/> <span class="red" >Do not include $ or % signs</span></div>
	    	{if $special_error.amount == 1}
	    	<br /><span class="required_class">Please enter valid amount (numeric value)</span>
	    	{/if}
    	</td>
    </tr>
    <tr>
    	<td><b>Special type</b></td>
    	<td>
    		<div class="date"><select name="special_type" >
    			<option value="" >Select special type</option>
    			<option value="price" {if $special_data.type == 'price'}selected{/if} >Price</option>
    			<option value="percentage" {if $special_data.type == 'percentage'}selected{/if} >Percentage</option>
    		</select></div>
    		{if $special_error.type == 1}
    		<br /><span class="required_class">Please select type</span>
    		{/if}
    	</td>
    </tr>
    <tr>
    	<td><b>Available date</b></td>
    	<td>
    		<div class="date">{if $special_data.available_date}
    			{html_select_date prefix="special_available" end_year="+4" year_empty="" month_empty="" day_empty="" time=$special_data.available_date field_order="DMY"}
    		{else}
    			{html_select_date prefix="special_available" end_year="+4" year_empty="" month_empty="" day_empty="" time="---" field_order="DMY"}
    		{/if}</div>
    	</td>
    </tr>
    <tr>
    	<td><b>Expiry date</b></td>
    	<td>
    		<div class="date">{if $special_data.expiry_date}
    			{html_select_date prefix="special_expiry" end_year="+4" year_empty="" month_empty="" day_empty="" time=$special_data.expiry_date field_order="DMY"}
    		{else}
    			{html_select_date prefix="special_expiry" end_year="+4" year_empty="" month_empty="" day_empty="" time="---" field_order="DMY"}
    		{/if}</div>
    	</td>
    </tr>
    </table>
</fieldset>
	</td>
</tr>