<p>{config_load file=templates.ini section="common" scope="global"} </p>
<h2>Shipping Manager</h2>

{* SHIPPING BY WEIGHT CODE *}
<form name="add_shipping" method="post" action="{#script_url#}{seo_url rm="AdminShipping"}" >
    <fieldset name="information" id="information">
      <legend>Create Shipping Method by Weight</legend>
{if $data.id}
<input type="hidden" name="id" value="{$data.id}" />
{/if}

<table>
        <thead>
        </thead>  
	<tr>
		<td>Weight</td>
		<td><input type="text" name="from_w" value="{$data.from_w}" style="width:63px;" title="string___Please input value" /> - <input type="text" name="to_w" value="{$data.to_w}" title="string___Please input value" style="width:63px;"/></td>
	</tr>
	<tr>
		<td>Name</td>
		<td><input type="text" name="method" value="{$data.method}" title="string___Please input name" /></td>
	</tr>
	<tr>
		<td>Method price (without dollar sign)</td>
		<td><input type="text" name="price" value="{$data.price}" title="numeric___Please input price" /></td>
	</tr>
	<tr>
		<td><input type="submit" name="save" value="Save" class="submit-button" /></td>
	</tr>
</table>
</fieldset>
</form>
<h2>Shipping by Weight</h2>
<div class="table-list">
<table>	
        <thead>
            <tr>

                                    <th scope="col" nowrap>Weight</th>
                                    <th scope="col" nowrap>Name</th>
                                    <th scope="col" nowrap>Price</th>
                                    <th scope="col" nowrap>Functions</th>
                            </tr>
        </thead>   
	{foreach from=$list item=item key=key}
	<tr>
		<td>{$item.from_w} - {$item.to_w}</td>
		<td>{$item.method}</td>
		<td>{$item.price|money}</td>
		<td>
			<a href="{#script_url#}{seo_url rm="AdminShipping" param1="edit" param2=$item.id}" ><img border="0" src="{#img_url#}edit.png" alt="{$L_EDIT}" /></a>
			<a href="{#script_url#}{seo_url rm="AdminShipping" param1="delete" param2=$item.id}" onclick="return confirm('Are you sure?');"><img border="none" src="{#img_url#}cross.png" alt="{$L_DELETE}" /></a>		</td>
	</tr>
    {foreachelse}
	<tr>
		<td colspan="100" align="center">no methods found</td>
	</tr>
	{/foreach}
<tfoot>
            <tr>
                <th scope="row" colspan="4">

                    <span class="page-numbers-results">
                        Results <strong>1 - 1</strong> of 1                    </span>  
                    <span class="page-numbers">
                            &lt;&lt;     
    &lt; 
            [<strong>1</strong>]
         &gt; 
     &gt;&gt; 
                    </span>

                </th>
            </tr>
        </tfoot> 
</table>
</div>

{* END OF SHIPPING BY WEIGHT CODE *}

{* FIXED SHIPPING CODE *}
<a href="#fixed" id="fixed" ></a>
<h2>Fixed Shipping Manager</h2>
<form name="add_fixed_shipping" method="post" action="{#script_url#}{seo_url rm="AdminShipping"}" >
    <fieldset name="information" id="information">
      <legend>Create Fixed Shipping Method</legend>
{if $fixed_data.id}
<input type="hidden" name="id" value="{$fixed_data.id}" />
{/if}

<table>
        <thead>
        </thead>  	
	<tr>
		<td>Name</td>
		<td><input type="text" name="method" value="{$fixed_data.method}" title="string___Please input name" /></td>
	</tr>
	<tr>
		<td>Method price (without dollar sign)</td>
		<td><input type="text" name="price" value="{$fixed_data.price}" title="numeric___Please input price" /></td>
	</tr>
	<tr>
		<td><input type="submit" name="save_fixed" value="Save" class="submit-button" /></td>
	</tr>
</table>
</fieldset>
</form>

<h2>Fixed Shipping Methods</h2>
<div class="table-list">
<table>	
        <thead>
            <tr>          
                <th scope="col" nowrap>Name</th>
                <th scope="col" nowrap>Price</th>
                <th scope="col" nowrap>Functions</th>
            </tr>
        </thead>   
	{foreach from=$fixed_list item=item key=key}
	<tr>
		<td>{$item.method}</td>
		<td>{$item.price|money}</td>
		<td>
			<a href="{#script_url#}{seo_url rm="AdminShipping" param1="fixed_edit" param2=$item.id}#fixed" ><img border="0" src="{#img_url#}edit.png" alt="{$L_EDIT}" /></a>
			<a href="{#script_url#}{seo_url rm="AdminShipping" param1="fixed_delete" param2=$item.id}#fixed" onclick="return confirm('Are you sure?');"><img border="none" src="{#img_url#}cross.png" alt="{$L_DELETE}" /></a>		</td>
	</tr>
    {foreachelse}
	<tr>
		<td colspan="100" align="center">no methods found</td>
	</tr>
	{/foreach}
<tfoot>
            <tr>
                <th scope="row" colspan="4">

                    <span class="page-numbers-results">
                        Results <strong>1 - 1</strong> of 1                    </span>  
                    <span class="page-numbers">
                            &lt;&lt;     
    &lt; 
            [<strong>1</strong>]
         &gt; 
     &gt;&gt; 
                    </span>

                </th>
            </tr>
        </tfoot> 
</table>
</div>
<a href="#" id="item" ></a>
<h2>Shipping by Items</h2>
{* END OF SHIPPING BY WEIGHT CODE *}

{* SHIPPING BY ITEMS CODE *}

<form name="add_shipping" method="post" action="{#script_url#}{seo_url rm="AdminShipping"}" >
    <fieldset name="information" id="information">
      <legend>Create Shipping Method by Items</legend>
{if $item_data.id}
<input type="hidden" name="id" value="{$item_data.id}" />
{/if}
<table>
        <thead>
        </thead>  
	<tr>
		<td>Items</td>
		<td><input type="text" name="from_w" value="{$item_data.from_w}" style="width:63px;" title="string___Please input value" /> - <input type="text" name="to_w" value="{$item_data.to_w}" title="string___Please input value" style="width:63px;"/></td>
	</tr>
	<tr>
		<td>Name</td>
		<td><input type="text" name="method" value="{$item_data.method}" title="string___Please input name" /></td>
	</tr>
	<tr>
		<td>Method price (without dollar sign)</td>
		<td><input type="text" name="price" value="{$item_data.price}" title="numeric___Please input price" /></td>
	</tr>
	<tr>
		<td><input type="submit" name="save_item" value="Save" class="submit-button" /></td>
	</tr>
</table>
</fieldset>
</form>
<div class="table-list">
<table>	
        <thead>
            <tr>

                                    <th scope="col" nowrap>Items</th>
                                    <th scope="col" nowrap>Name</th>
                                    <th scope="col" nowrap>Price</th>
                                    <th scope="col" nowrap>Functions</th>
                            </tr>
        </thead>   
	{foreach from=$item_list item=item key=key}
	<tr>
		<td>{$item.from_w} - {if $item.to_w}{$item.to_w}{else}any{/if}</td>
		<td>{$item.method}</td>
		<td>{if $item.price}{$item.price|money}{else}free{/if}</td>
		<td>
			<a href="{#script_url#}{seo_url rm="AdminShipping" param1="item_edit" param2=$item.id}#item" ><img border="0" src="{#img_url#}edit.png" alt="{$L_EDIT}" /></a>
			<a href="{#script_url#}{seo_url rm="AdminShipping" param1="item_delete" param2=$item.id}#item" onclick="return confirm('Are you sure?');"><img border="none" src="{#img_url#}cross.png" alt="{$L_DELETE}" /></a>		</td>
	</tr>
	{foreachelse}
	<tr>
		<td colspan="100" align="center">no methods found</td>
	</tr>
	{/foreach}
<tfoot>
            <tr>
                <th scope="row" colspan="4">

                    <span class="page-numbers-results">
                        Results <strong>1 - 1</strong> of 1                    </span>  
                    <span class="page-numbers">
                            &lt;&lt;     
    &lt; 
            [<strong>1</strong>]
         &gt; 
     &gt;&gt; 
                    </span>

                </th>
            </tr>
        </tfoot> 
</table>
</div>

{* END OF SHIPPING BY ITEMS CODE *}