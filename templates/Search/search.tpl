{config_load file=templates.ini section="common"}

<!-- Google CSE code begins -->
<link href="http://www.google.com/uds/css/gsearch.css"
        type="text/css" rel="stylesheet"/>
{literal}
<script src="http://www.google.com/cse/api/overlay.js"></script>

<!-- Google CSE Code ends -->
 <style type="text/css">
      @import url(http://www.google.com/uds/css/gsearch.css);
	  .gs-result .gs-title, .gs-result .gs-title * {
color:#000;
text-decoration:underline;
}
.gs-snippet {
	color:#828282;
}
.gs-result a.gs-visibleUrl,
.gs-result .gs-visibleUrl {
  color: #000;
  text-decoration: none;
  visibility:hidden;
}
.gsc-results .gsc-cursor-box .gsc-cursor-current-page {
  color : #000;
  font-weight : bold;
  text-decoration: none;
}
	  .gsc-results .gsc-cursor-box .gsc-trailing-more-results {
display:none;
margin-bottom:0px;
}
input {
	color:#000;
}
input.gsc-input {
	width: 300px;
	background:#FFFFFF;
	color:#000000;
}
.gsc-search-button {
	margin-right: 340px;
	width: 80px;
}
.gsc-branding-img, img.gsc-branding-img {
	margin-right: 250px;
}
.gsc-clear-button {
	margin-left: 100px;
	visibility:hidden;

}
.gsc-results {
	width: 600px;
}
# {
	width: 400px;
}
#searchBar {
	width: 300px;
}
    </style>

<script src="http://www.google.com/uds/api?file=uds.js&v=1.0&key=ABQIAAAAg3_2rNjDSBu97wNS931w3BQ_V0sjMiElBilt1TYl-QzUaAlp0hSoLSfgLgbi71fLXHsFBbdWoauI9w&hl=en" type="text/javascript"></script>
  <script language="Javascript" type="text/javascript">//<![CDATA[

      function OnLoad() {

        // create a search control
        var searchControl = new GSearchControl();

        // create a draw options object so that we
        // can position the search form root
        var options = new GdrawOptions();
        options.setSearchFormRoot(document.getElementById("searchForm"));
		
        
        var searcher_options = new GsearcherOptions();
        searcher_options.setExpandMode(GSearchControl.EXPAND_MODE_OPEN);
        
        //adding restrictions to search
        var siteSearch = new GwebSearch();
        siteSearch.setUserDefinedLabel("scenarhealth.com");
      	siteSearch.setUserDefinedClassSuffix("siteSearch");
      	//siteSearch.setSiteRestriction("scenarhealth.com");
      	siteSearch.setSiteRestriction("scenarhealth.com");
        siteSearch.setLinkTarget(GSearch.LINK_TARGET_SELF); 
        
        // populate with searchers
        searchControl.addSearcher(siteSearch,searcher_options);
        searchControl.setLinkTarget(GSearch.LINK_TARGET_SELF)
        
        siteSearch.setResultSetSize(GSearch.LARGE_RESULTSET);
      	searchControl.setResultSetSize(GSearch.LARGE_RESULTSET);
        //searchControl.addSearcher(new GvideoSearch());
        //searchControl.addSearcher(new GblogSearch());

        
        searchControl.draw(document.getElementById("searchResults"), options);
        
{/literal}
	   {if $search_string}      	
      	searchControl.execute('{$search_string}');
         {/if}
{literal}
        //searchControl.execute("Ferrari Enzo");
      }
      GSearch.setOnLoadCallback(OnLoad);
      
      
	  OnSearchComplete = function(sc, searcher) 
	  {
	      var divtags=document.getElementsByTagName("div");
	      for (i=0; i<divtags.length; i++) 
	      {
	        if (divtags[i].className=='gsc-result-selector gsc-all-results') 
	        {
	          divtags[i].onclick();
	        }
	      }
		} 
      
    //]]>
    </script>

<h1>Search</h1>
  <div id="searchForm">Loading...</div>
<div >
	  <div id="searchResults">Loading...</div>
  </div>
{/literal}