{config_load file=templates.ini section="common" scope="global"}
<div class="content-container">
  <h2>Управление товарами</h2>
  <a href="{#script_url#}{seo_url rm='AdminProduct' param1='add'}" class="submit-button">Добавить новый товар</a>
  <br />  <br />
  <form name="filter_cat" method="post" action="{#script_url#}{seo_url rm="AdminProduct"}" >
    <fieldset name="information" id="information">
    <legend>Фильтр</legend>
    <table>
      <tr>
        <td>
            <select name="category_id" >
                <option value="" >Все категории</option>
                {foreach from=$categories item=item key=key}
                    <option value="{$key}" {if $key == $filters.category_id.cat_id}selected{/if}>{$item}</option>
                {/foreach}
            </select>
        </td>
        <td>
	      	<!--{*<select name="brand_id" >
          		<option value="" >All brands</option>
				{foreach from=$brands item=item key=key}
				<option value="{$item.id}" {if $key == $filters.brand_id.v}selected{/if}>{$item.title}</option>
				{/foreach}
			</select>*}-->
        </td>
       </tr>
       <tr>

       		<td>
        		Не активные:
        		<input type="radio" name="show_inactive" value="0" style="width:20px;" {if $filters.show_inactive.v == 0}checked{/if} />Нет&nbsp;<input type="radio" name="show_inactive" value="1" style="width:20px;" {if $filters.show_inactive.v == 1}checked{/if} />Да&nbsp;<input type="radio" name="show_inactive" value="2" style="width:20px;" {if !$filters.show_inactive}checked{/if} />Все
        	</td>
       </tr>
       <tr>

       		<td>
       			Поиск
       			<input name="search_value" type="text" value="{$filters.search_value.value}" />
       		</td>
       </tr>
       <tr>
	    	<td>
	    		<input type="submit" class="submit-button" name="filter" value="Фильтр" />
	    	</td>
    	</tr>
    </table>
    </fieldset>
  </form>
  <table align="left" width="100%">
    {foreach from=$products item=item key=key}
    <tr>
      <td valign="top">
            <fieldset name="information" id="information">
    			<legend>Товар</legend>
				<div class="table-list">
				<table>
			        <thead>
			            <tr>
                                        <th scope="col" nowrap><b>Категория товара</b></th>
                                        <th scope="col" nowrap><b>Цена</b></th>
                                        <th scope="col" nowrap><b>Новая цена</b></th>
                                        <th scope="col" nowrap><b>Название</b></th>
                                        <th scope="col" nowrap><b>Индекс сортировки</b></th>
                                        <th scope="col" nowrap><b>Вес</b></th>
                                        <th scope="col" nowrap><b>Количество</b></th>
                                        <th scope="col" nowrap><b>Не активный</b></th>
                                        <th scope="col" nowrap><b>Новинка</b></th>
			          </tr>
			        </thead>  
				        <tr>
				            <td valign="top">
				          	{$categories[$item.category_id]}
				            </td>
                                            <td>{$item.price|money} р.</td>
                                            <td>{$item.newprice|money} р.</td>
                                            <td>{$item.name}</td>
				            <td>{$item.order_no}</td>
				            <td>{$item.weight}</td>
				            <td>{$item.quantity}</td>
				            <td>{if $item.inactive == 1}Да{else}Нет{/if}</td>
				            <td>{if $item.featured == 1}Да{else}Нет{/if}</td>
				        </tr>	
    			</table>
    			</div>
                            <div class="table-list">
				<table>
				  {* <!--<tr>
				   <td width="150" height="30" valign="top" nowrap="nowrap"><b>Brand</b></td>
				    <td colspan="3">{$brands[$item.brand_id].title}</td>
				    <td width="20%" align="left"><strong>Subcategory Image</strong></td>
				    <td align="left" colspan="3">{$item.subcategory_picture|checkbox}</td>
                                    <td rowspan="3" align="left">
				    	{if $item.picture} <img src="{#script_url#}{show_image id=$item.id width=width height=height}" alt="img" border="none"/> {else}
				    		<div style="width:180px;"> No image </div>
				    	{/if} 
				    </td>
				  </tr>
                                  <tr>
				    <td valign="top" nowrap="nowrap"><b>House</b></td>
				    <td>{$item.house}</td>
                                    <td valign="top" nowrap="nowrap"><b>Year of release</b></td>
				    <td>{$item.release_year}</td>
                                    <td valign="top" nowrap="nowrap"><b>Gender</b></td>
				    <td>{$item.gender}</td>
                                    <td valign="top" nowrap="nowrap"><b>Michael Edwards' Classification</b></td>
				    <td>
                                        {if !empty($item.fragrance_id)}
                                            {$fragrance_types[$item.m_e_classification].title}
                                        {/if}
                                    </td>
				  </tr>
                                  <tr>
				    <td valign="top" nowrap="nowrap"><b>Top Notes</b></td>
				    <td>{$item.top_notes}</td>
                                    <td valign="top" nowrap="nowrap"><b>Heart Notes Notes</b></td>
				    <td>{$item.heart_notes}</td>
                                    <td valign="top" nowrap="nowrap"><b>Base Notes</b></td>
				    <td>{$item.base_notes}</td>
                                    <td valign="top" nowrap="nowrap"><b>Fragrance Type</b></td>
				    <td>
                                        {if !empty($item.fragrance_id)}
                                            {$fragrance_types[$item.fragrance_id].title}
                                        {/if}
                                    </td>
				  </tr>-->*}
				  <tr>
				    <td valign="top" nowrap="nowrap"><b>Краткое описание</b></td>
				    <td>{$item.description}</td>
                                    <td rowspan="3" align="left">
				    	{if $item.picture1} <img src="{#picture_url#}block_{$item.picture1}" alt="Изображение" border="none"/> {else}
				    		<div style="width:180px;"> Нет главного изображения </div>
				    	{/if}
				    </td>
				    </tr>
				  <tr>
				    <td valign="top" nowrap="nowrap"><b>Полное описание</b></td>
				    <td >{$item.full_description}</td>
				    </tr>
			   	  {*<!--<tr>
				    <td valign="top" nowrap="nowrap"><b>Seo url</b></td>
				    <td >{$item.seo}</td>
				  </tr> -->*}
				  <tr>
				    <td valign="top" nowrap="nowrap"><b>Функции</b></td>
				    <td ><a href="{#script_url#}{seo_url rm='AdminProduct' param1='edit' param2=$item.id}" class="submit-button">Редактировать</a>
                                        <a onclick="return confirm('Вы уверены?');" href="{#script_url#}{seo_url rm='AdminProduct' param1='delete' param2=$item.id}" class="submit-button">Удалить</a>
                                        {*<!--<a href="{#script_url#}{seo_url rm='AdminProduct' param1='copy' param2=$item.id}" onclick="return confirm('Вы уверены?');" class="submit-button">Копировать</a></td>-->*}
				    </tr>
				</table>
				</div>
                       {* <!--
				<div class="table-list">
				<table>
			        <thead>
			            <tr>
				          <th scope="col" nowrap><b>Special amount</b></th>
					      <th scope="col" nowrap><b>Type</b></th>
				          <th scope="col" nowrap><b>Available date</b></th>
				            <th scope="col" nowrap><b>Expiry date</b></th>			              
			          </tr>
			        </thead>  
				        <tr>
				        	{if $specials[$item.id]}
					          	<td valign="top">{$specials[$item.id].amount}</td>
							    <td>{$specials[$item.id].type}</td>
						        <td>
						        	{if $specials[$item.id].available_date}
						        		<span class="{if $specials[$item.id].available_date < $smarty.now}green_date{else}red_date{/if}" >{$specials[$item.id].available_date|date_output:"d.m.Y"}</span>
						        	{else}
						        		without date
						        	{/if}
						        </td>
					            <td>
					            	{if $specials[$item.id].expiry_date}
					            		<span class="{if $specials[$item.id].expiry_date > $smarty.now}green_date{else}red_date{/if}" >{$specials[$item.id].expiry_date|date_output:"d.m.Y"}</span>
					            	{else}
					            		without date
					            	{/if}
					            </td>
					        {else}
					        	<td colspan="6" align="center"> no special set</td>
					        {/if}
				        </tr>	
    			</table>
    			</div>
                        -->*}
    			</fieldset>  
    	</td>
    </tr>
  {foreachelse}
  	<tr>
  		<td colspan="100" align="center">Товары не найдены</td>
  	</tr>
  {/foreach}  
  <tfoot>
    <tr>
      <th colspan="5" align="left" scope="row"> {foreach from=$pages_info.prepared item=item key=key}
        {if $item == $pages_info.current} <b>{$item}</b> {else} <a href="{#script_url#}{seo_url rm='AdminProduct' param1='page' param2=$item}">{$item}</a>
        {/if}
        {/foreach} </th>
    </tr>
  </tfoot>
</table>
</div>
