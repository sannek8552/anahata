{config_load file=templates.ini section="common" scope="global"}

<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key={$googlemap_data.google_key}&amp;q={$location}" type="text/javascript"></script>
<script src="http://www.google.com/uds/api?file=uds.js&amp;v=2" type="text/javascript"></script>
<script src="http://www.google.com/uds/solutions/localsearch/gmlocalsearch.js" type="text/javascript"></script>


{literal}
<style type="text/css">
      @import url("http://www.google.com/uds/css/gsearch.css");
      @import url("http://www.google.com/uds/solutions/localsearch/gmlocalsearch.css");

</style>

<script type="text/javascript">
    var map;
    var gdir;
    var geocoder = new GClientGeocoder();
    var addressMarker;

    var myPano;
    var panoClient;
    var nextPanoId;
    var ltln;

    function initialize()
    {
        
      	if (GBrowserIsCompatible())
      	{
            panoClient = new GStreetviewClient();
            map = new GMap2(document.getElementById("map_canvas"));
            map.setUIToDefault();
            // bind a search control to the map, suppress result list
            map.addControl(new google.maps.LocalSearch(), new GControlPosition(G_ANCHOR_BOTTOM_RIGHT, new GSize(10,20)));
            {/literal}

            {if $street_view}
                showAddress("{$googlemap_data.location|escape}");
                {literal}
                    GEvent.addListener(map, "click", function(overlay,latlng)
                    {
                        panoClient.getNearestPanorama(latlng, showPanoData);

                    });
                {/literal}
            {/if}

            gdir = new GDirections(map, document.getElementById("directions"));
            GEvent.addListener(gdir, "load", onGDirectionsLoad);
            GEvent.addListener(gdir, "error", handleErrors);

            setDirections("{$googlemap_data.location}", "{$googlemap_data.location}", "en_US");
            {literal}
      	}
    }
    function showAddress(address)
    {
        geocoder.getLatLng(
            address,
            function(latlng)
            {
                var fenwayPark = new GLatLng(latlng['y'], latlng['x']);
                var fenwayPOV = {yaw:370.64659986187695,pitch:-20};
                myPano = new GStreetviewPanorama(document.getElementById("pano"));
                myPano.setLocationAndPOV(fenwayPark, fenwayPOV);
                GEvent.addListener(myPano, "error", handleNoFlash);    
            }
        );
    }

    function showPanoData(panoData)
    {
        nextPanoId = panoData.links[0].panoId;
        myPano.setLocationAndPOV(panoData.location.latlng);
    }


    function setDirections(fromAddress, toAddress, locale)
    {
      gdir.load("from: " + fromAddress + " to: " + toAddress,
                { "locale": locale });
    }

    function next()
    {
        panoClient.getPanoramaById(nextPanoId, showPanoData);
    }

    function handleNoFlash(errorCode)
    {
      if (errorCode == 603)
      {
        alert("Please install Flash");
        return;
      }
    }

    function handleErrors()
    {
	   if (gdir.getStatus().code == G_GEO_UNKNOWN_ADDRESS)
	     alert("No corresponding geographic location could be found for one of the specified addresses. This may be due to the fact that the address is relatively new, or it may be incorrect.\nError code: " + gdir.getStatus().code);
	   else if (gdir.getStatus().code == G_GEO_SERVER_ERROR)
	     alert("A geocoding or directions request could not be successfully processed, yet the exact reason for the failure is not known.\n Error code: " + gdir.getStatus().code);

	   else if (gdir.getStatus().code == G_GEO_MISSING_QUERY)
	     alert("The HTTP q parameter was either missing or had no value. For geocoder requests, this means that an empty address was specified as input. For directions requests, this means that no query was specified in the input.\n Error code: " + gdir.getStatus().code);

	//   else if (gdir.getStatus().code == G_UNAVAILABLE_ADDRESS)  <--- Doc bug... this is either not defined, or Doc is wrong
	//     alert("The geocode for the given address or the route for the given directions query cannot be returned due to legal or contractual reasons.\n Error code: " + gdir.getStatus().code);

	   else if (gdir.getStatus().code == G_GEO_BAD_KEY)
	     alert("The given key is either invalid or does not match the domain for which it was given. \n Error code: " + gdir.getStatus().code);

	   else if (gdir.getStatus().code == G_GEO_BAD_REQUEST)
	     alert("A directions request could not be successfully parsed.\n Error code: " + gdir.getStatus().code);

	   else alert("An unknown error occurred.");

	}

	function onGDirectionsLoad()
	{
      // Use this function to access information about the latest load()
      // results.

      // e.g.
      // document.getElementById("getStatus").innerHTML = gdir.getStatus().code;
	  // and yada yada yada...
	}
	window.addEvent('domready',initialize);
</script>
{/literal}
<p>Adjust the map view by clicking in on the map or zooming in or out. </p>
{*<h2>Ph: 1300 368 107</h2>*}
<h2>Location Map</h2>
<div id="map_canvas"></div>
{if $street_view}
<div style="height:20px;"></div>
    <div name="pano"></div>
{/if}

<p>
<noscript>
<b>JavaScript must be enabled in order for you to use Google Maps.</b>
However, it seems JavaScript is either disabled or not supported by your browser.
To view Google Maps, enable JavaScript by changing your browser options, and then
try again.
</noscript>
</p>
<div id="mapdirections">
	<form action="#" onsubmit="setDirections(this.from.value, this.to.value, this.locale.value); return false">
		<div id="mapinput">
			<h2>Get Directions</h2>
			<p><strong>From: </strong><br />
			<input type="text" size="65" id="fromAddress" name="from" value=""/>
			</p>
			<p> <strong>To: </strong><br />
			<input type="text" size="65" id="toAddress" name="to" value="{$googlemap_data.location}" />
			</p>
		</div>
		<p> Language:
			<select id="locale" name="locale">
			<option value="en" selected="selected">English</option>
			<option value="fr">French</option>
			<option value="de">German</option>
			<option value="ja">Japanese</option>
			<option value="es">Spanish</option>
			</select>
		</p>
		<p>
			<input name="submit" type="submit" value="Get Directions!" />
			<br />
		</p>
	</form>
	<table width="425" class="directions">
	<tr>
		<th align="left"> Directions</th>
		<th align="right">Distance</th>
	</tr>
	<tr>
		<td colspan="2" valign="top"><div id="directions" style="width: 425px"></div></td>
	</tr>
	</table>
</div>
</p>
