{config_load file=templates.ini section="common" scope="global"}
<div id="topsMain">
    <h3>Best Sellers</h3>
    <div id="tops">
    {foreach from=$products item=product key=key}
        <div class="product_div">
            <div class="b">
                <a href="{#script_url#}{seo_url rm="Product" param1=$product.id}" >
                    <img src="{#script_url#}{show_image id=$product.id width=width height=height}" alt="{$product.name}" />
                    <div>
                        <p>{$product.name}</p>
                    </div>
                </a>
            </div>
        </div>
    {/foreach}
    </div>
    <div style="clear:both;" ></div>
</div>