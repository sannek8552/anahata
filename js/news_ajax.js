var ind=0; 
function query()
{
	document.getElementById("news_pech").innerHTML = 'Loading...';
	var req = new JsHttpRequest();
	var query = {action: 'news'};
	req.onreadystatechange = function()
	{
		if(4 == req.readyState)
		{
			if('false' == req.responseJS.status)
			{
				alert('here');
				return;
			}
			pechat(req.responseJS.content);
		}
	}
	req.caching = false;
	req.open('post', ajax_prefix + '?rm=feed_load_ajax', true);
	req.send(query);
}
function pechat(rezal)
{	
	document.getElementById("news_pech").innerHTML = rezal;
}
 window.addEvent('domready',function()
                        {
                           query();
                        });
                        