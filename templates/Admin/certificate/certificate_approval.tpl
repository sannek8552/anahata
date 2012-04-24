{config_load file=templates.ini section="common" scope="global"}
<div class="content-container">
  <h2>Certificate Approval</h2>  
  <form name="filter_cat" method="post" action="{#script_url#}{seo_url rm="CertificateApproval"}" >
    <fieldset name="information" id="information">
    <legend>Filter</legend>
    <table >
       <tr>
       		<td>
       			Status
       			<select name="status" >
       				<option value="" >Any</option>
       				<option value="Not approved" {if $filters.status.v == 'Not approved'}selected{/if} >Unapproved</option>
       				<option value="Approved" {if $filters.status.v == 'Approved'}selected{/if} >Approved</option>
       				<option  value="Outstanding" {if $filters.used && $filters.used.v == 0}selected{/if} >Outstanding</option>
       			</select>
       		</td>
	    	<td>
	    		<input type="submit" class="submit-button" name="filter" value="Filter" />
	    	</td>
    	</tr>
    </table>
    </fieldset>
  </form>
  <table align="left" width="100%">
    
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
			              <th scope="col" nowrap><b>Item Code</b></th>
				          <th scope="col" nowrap><b>Person name</b></th>
				          <th scope="col" nowrap><b>Person email</b></th>
				          <th scope="col" nowrap><b>Date</b></th>
				          <th scope="col" nowrap><b>Status</b></th>
				          <th scope="col" nowrap><b>Used</b></th>
				          <th scope="col" nowrap><b>Function</b></th>
			          </tr>
			        </thead>  
			        {foreach from=$certificates item=item key=key}
				        <tr>				          
						    <td>{$item.price|money} </td>
					        <td>{$item.name}</td>				            
				            <td>{$item.number}</td>
				            <td>{$item.person_name}</td>
				            <td>{$item.person_email}</td>
				            <td>{$item.created|date_output:"d.m.Y"}</td>
				            <td>{$item.status}</td>
				            <td>{if $item.used}Yes{else}No{/if}</td>
				            <td>
				            	{if $item.status == 'Not approved'}				    	
				    				<a href="{#script_url#}{seo_url rm='CertificateApproval' param1='approve' param2=$item.id}" class="submit-button">Approve</a> 
				    			{/if}				    	
				            </td>
				        </tr>	
				      {foreachelse}  
									      <tr>
					  		<td colspan="100" align="center">no certificates found</td>
					  	</tr>
					  {/foreach}
    			</table>
    			</div>				
    			</fieldset>
    	</td>
    </tr>
  
  	
  <tfoot>
    <tr>
      <th colspan="5" align="left" scope="row"> {foreach from=$pages_info.prepared item=item key=key}
        {if $item == $pages_info.current} <b>{$item}</b> {else} <a href="{#script_url#}{seo_url rm='CertificateApproval' param1='page' param2=$item}">{$item}</a>
        {/if}
        {/foreach} </th>
    </tr>
  </tfoot>
</table>
</div>