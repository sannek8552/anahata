function BodyBlocker()
{
	this.already_in_block = false;
	this.blocker_element = null;
	this.create_block = create_block;
	this.remove_block = remove_block;
	this.class_to_use = 'blocker';
	this.get_blocker_element = get_blocker_element;
	this.loading_img = document.createElement('img');
	this.loading_img.src = images_prefix + 'loading.gif';
	this.loading_img.style.position = 'absolute';
	this.progress_div = null;
	//this.get_blocker_element = get_blocker_element;
function get_blocker_element()
{
	
	if(null == this.blocker_element)
	{
		this.blocker_element = document.createElement('div');
		this.blocker_element.className = this.class_to_use;
		this.blocker_element.style.display = 'none';
		//alert(document.getElementsByTagName('body').length);
		document.getElementsByTagName('body')[0].appendChild(this.blocker_element);
	}
	return this.blocker_element;
}
function create_block()
{
	if(this.already_in_block)
		return false;
    //oBlock = document.getElementById('blocker');
    oBlock = this.get_blocker_element();
    oBlock.style.zIndex = 1000;

    oBlock.style.opacity = 0.6;
    oBlock.style.filter='alpha(opacity=60)';

    oBlock.style.top = '0px';
    oBlock.style.left = '0px';

    var oSize = get_document_size();

    oBlock.style.width = oSize.width + 'px';
    oBlock.style.height = oSize.height + 'px';

    oBlock.style.display = 'block';

    var load_div = document.createElement('div');
    load_div.style.position = 'absolute';
    var arr = getPageSize_mod();
    
    var scroll = getPageScroll();
    
    load_div.style.left = (oSize.width/2) + 'px';//53 + 'px';
    load_div.style.top = (scroll[1] + arr[3]/2) + 'px';//(oSize.height/2) + 'px';//2 + 'px';
    /*this.loading_img.style.left = (oSize.width/2) + 'px';//53 + 'px';
    this.loading_img.style.top = (scroll[1] + arr[3]/2) + 'px';//(oSize.height/2) + 'px';//2 + 'px';*/
        //load_div.style.color = 'red';
    //load_div.style.border = '1px solid red';
    //load_div.style.width =  45 + 'px';
    //load_div.style.height = 16 + 'px';

    //load_div.style.opacity = '0.8';
    //load_div.style.filter='alpha(opacity=80)';
    //load_div.style.backgroundColor = '#fff';
        //load_div.innerHTML = '<span style="font-size:20px">Loading</span>';
   // alert(this.loading_img);
    load_div.appendChild(this.loading_img);
    oBlock.style.zIndex = 9999;
    this.progress_div = document.body.appendChild(load_div);
    //progress_div = document.body.appendChild(this.loading_img);
       // t_out = setTimeout('make_load()',1000);
    
	this.already_in_block = true;
}	
	
/*function make_load()
{

        if(cur_point == 4)
                cur_point = 0;
        var i;
        var str_p = '';
        for(i = 0; i< cur_point;i++)
        {
                str_p = str_p + '. ';
        }
        cur_point++;
        //alert(str_p);
        progress_div.innerHTML = '<span style="font-size:20px">Loading</span> ' + str_p;
        t_out = setTimeout('make_load()',1000);
}*/

function remove_block()
{
	if(this.already_in_block == false)
	{
		return true;
	}
        //oBlock = document.getElementById('blocker');
        oBlock = this.get_blocker_element();
        oBlock.style.display = 'none';
        document.body.removeChild(this.progress_div);
        //clearTimeout(t_out);
	this.already_in_block = false;
}

function get_document_size()
{
	var x,y;
	if (self.innerHeight) // all except Explorer
	{
	        x = self.innerWidth;
	        y = self.innerHeight;
	}
	else if (document.documentElement && document.documentElement.clientHeight)
	        // Explorer 6 Strict Mode
	{
	        x = document.documentElement.clientWidth;
	        y = document.documentElement.clientHeight;
	}
	else if (document.body) // other Explorers
	{
	        x = document.body.clientWidth;
	        y = document.body.clientHeight;
	}
	
	var xx,yy;
	var test1 = document.body.scrollHeight;
	var test2 = document.body.offsetHeight
	if (test1 > test2) // all but Explorer Mac
	{
	        xx = document.body.scrollWidth;
	        yy = document.body.scrollHeight;
	}
	else // Explorer Mac;
	     //would also work in Explorer 6 Strict, Mozilla and Safari
	{
	        xx = document.body.offsetWidth;
	        yy = document.body.offsetHeight;
	}
	
	//alert(document.body.scrollHeight);
	//alert(document.body.offsetHeight);
	
	var oSize = {width:0, height:0};
	oSize.height = ((y > yy) ? y : yy) - 20;
	oSize.width = xx - 20;
	
	return oSize;
}
function getPageSize_mod()
{
        var xScroll, yScroll;

        if (window.innerHeight && window.scrollMaxY) 
        {
                xScroll = document.body.scrollWidth;
                yScroll = window.innerHeight + window.scrollMaxY;
        } 
        else if (document.body.scrollHeight > document.body.offsetHeight)
        { // all but Explorer Mac
                xScroll = document.body.scrollWidth;
                yScroll = document.body.scrollHeight;
        } 
        else 
        { // Explorer Mac...would also work in Explorer 6 Strict, Mozilla and Safari
                xScroll = document.body.offsetWidth;
                yScroll = document.body.offsetHeight;
        }

        var windowWidth, windowHeight;
        if (self.innerHeight) 
        { // all except Explorer
                windowWidth = self.innerWidth;
                windowHeight = self.innerHeight;
        } 
        else if (document.documentElement && document.documentElement.clientHeight) 
        { // Explorer 6 Strict Mode
                windowWidth = document.documentElement.clientWidth;
                windowHeight = document.documentElement.clientHeight;
        } 
        else if (document.body) 
        { // other Explorers
                windowWidth = document.body.clientWidth;
                windowHeight = document.body.clientHeight;
        }

        // for small pages with total height less then height of te viewport
        if(yScroll < windowHeight)
        {
                pageHeight = windowHeight;
        } 
        else 
        {
                pageHeight = yScroll;
        }

        // for small pages with total width less then width of the viewport
        if(xScroll < windowWidth)
        {
                pageWidth = windowWidth;
        } 
        else 
        {
                pageWidth = xScroll;
        }

        arrayPageSize = new Array(pageWidth,pageHeight,windowWidth,windowHeight)
        return arrayPageSize;
}
function getPageScroll()
{
        var yScroll;

        if (self.pageYOffset) 
        {
        	yScroll = self.pageYOffset;
        }
        else if (document.documentElement && document.documentElement.scrollTop)
        {      // Explorer 6 Strict
                yScroll = document.documentElement.scrollTop;
        } 
        else if (document.body) 
        {// all other Explorers
                yScroll = document.body.scrollTop;
        }

        arrayPageScroll = new Array('',yScroll);
        return arrayPageScroll;
}
}
var body_blocker = new BodyBlocker();
