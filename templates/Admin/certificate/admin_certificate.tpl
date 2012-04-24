{config_load file=templates.ini section="common" scope="global"}
<div class="content-container">
  <h2>Certificate Manager</h2>
  <a href="{#script_url#}{seo_url rm="AdminCertificate" param1="add"}" class="submit-button">Add new certificate</a>
  <br />  <br />
  <form name="filter_cat" method="post" action="{#script_url#}{seo_url rm="AdminCertificate"}" >
    <fieldset name="information" id="information">
    <legend>Filter</legend>
    <table >
       <tr>
       		<td>
       			Show certificates with subcategory image
       			<input type="checkbox" name="subcategory_picture" value="1" {if $filters.subcategory_picture}checked{/if} />
       		</td>
       		<td>
        		Inactive:
        		<input type="radio" name="show_inactive" value="0" style="width:20px;" {if $filters.show_inactive.v == 0}checked{/if} />no&nbsp;<input type="radio" name="show_inactive" value="1" style="width:20px;" {if $filters.show_inactive.v == 1}checked{/if} />yes&nbsp;<input type="radio" name="show_inactive" value="2" style="width:20px;" {if !$filters.show_inactive}checked{/if} />both
        	</td>
       </tr>
       <tr>
	    	<td>
	    		<input type="submit" class="submit-button" name="filter" value="Filter" />
	    	</td>
    	</tr>
    </table>
    </fieldset>
  </form>
  <table align="left" width="100%">
    {foreach from=$certificates item=item key=key}
    <tr>
      <td valign="top">
            <fieldset name="information" id="information">
    			<legend>Certificate Details</legend>
				<div class="table-list">
				<table>
			        <thead>
			            <tr>			              
					      <th scope="col" nowrap><b>Price</b></th>
				          <th scope="col" nowrap><b>Name</b></th>
				          <th scope="col" nowrap><b>Order</b></th>
			              <th scope="col" nowrap><b>Item Code</b></th>				          
				          <th scope="col" nowrap><b>Inactive</b></th>				          
			          </tr>
			        </thead>  
				        <tr>				          
						    <td>{$item.price|money} </td>
					        <td>{$item.name}</td>
				            <td>{$item.order_no}</td>
				            <td>{$item.number}</td>				            
				            <td>{if $item.inactive == 1}Yes{else}No{/if}</td>				            
				        </tr>	
    			</table>
    			</div>
				<div class="table-list">
				<table>
				  <tr>				    
				    <td width="20%" align="left"><strong>Subcategory Image</strong></td>
				    <td align="left">{$item.subcategory_picture|checkbox}</td>
				    <td align="left" >
				    	{if $item.picture} 
				    		<img src="{#script_url#}{show_image id=$item.id width=width height=height param1=2}" alt="img" border="none"/> 
				    	{else}
				    		<div style="width:180px;"> No image </div>
				    	{/if} 
				    </td>
				  </tr>
				  <tr>
				    <td valign="top" nowrap="nowrap"><b>Basic description</b></td>
				    <td colspan="3">{$item.description}</td>
				  </tr>
				  <tr>
				    <td valign="top" nowrap="nowrap"><b>Full description</b></td>
				    <td colspan="3">{$item.full_description}</td>
				  </tr>
			   	  <tr>
				    <td valign="top" nowrap="nowrap"><b>Seo url</b></td>
				    <td colspan="3">{$item.seo}</td>
				  </tr> 
				  <tr>
				    <td valign="top" nowrap="nowrap"><b>Functions</b></td>
				    <td colspan="3">
				    	<a href="{#script_url#}{seo_url rm='AdminCertificate' param1='edit' param2=$item.id}" class="submit-button">Edit</a> 
				    	<a onclick="return confirm('Are you sure?');" href="{#script_url#}{seo_url rm='AdminCertificate' param1='delete' param2=$item.id}" class="submit-button">Delete</a>
				    </tr>
				</table>
				</div>
    			</fieldset>
    	</td>
    </tr>
  {/foreach}
  <tfoot>
    <tr>
      <th colspan="5" align="left" scope="row"> {foreach from=$pages_info.prepared item=item key=key}
        {if $item == $pages_info.current} <b>{$item}</b> {else} <a href="{#script_url#}{seo_url rm='AdminCertificate' param1='page' param2=$item}">{$item}</a>
        {/if}
        {/foreach} </th>
    </tr>
  </tfoot>
</table>
</div>