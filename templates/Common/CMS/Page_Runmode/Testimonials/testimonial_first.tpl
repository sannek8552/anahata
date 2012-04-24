{config_load file=templates.ini section="common" scope="global"}
{literal}
<script type="text/javascript">
    /*setInterval( get_testimonial()
    , '{/literal}{math equation="x * 1000" x = $t_data.timer}{literal}'
);*/
    setTimeout( 'get_testimonial()', '{/literal}{math equation="x * 1000" x = $t_data.timer}{literal}');
    function get_testimonial()
    {
        var params = {};
        params['testimonial_id'] = {/literal}{$t_data.id}{literal};
        var req = new JsHttpRequest();
        req.ir = this;
        req.onreadystatechange = function()
        {
            if (req.readyState == 4)
            {
                document.getElementById('entry_{/literal}{$t_data.id}{literal}').innerHTML = req.responseJS.html;
                setTimeout( 'get_testimonial()', '{/literal}{math equation="x * 1000" x = $t_data.timer}{literal}');
            }
        }
        req.caching = false;
        req.open('POST', ajax_prefix + '?rm=Show_Testimonial', true);
        req.send(params);
    }
</script>
{/literal}
    <div class="content">
            <h1>{$t_data.name|escape}</h1>
            <p>{$t_data.description|escape|nl2br}</p>
            <div id="entry_{$t_data.id}"><p>{$entry.content}</p>
                    <strong>{$entry.name}</strong>
            </div>
            <a href="{#script_url#}{seo_url rm = $t_data.seo_page}">more</a>
    </div>
