
<script type="text/javascript" src={"javascript/yui/2.5.2/build/utilities/utilities.js"|ezdesign}></script>
<script type="text/javascript">
<!--


{literal}
function FlickrImport()
{
{/literal}
    this.url="{concat("flickr/doimport/",$location)|ezurl(no)}/";
    this.imported=0;
    this.failures=0;
    this.selectionCount={$flickrSelection|count()};
    this.selectionList= [];
    this.failureText="{"Import failures:"|i18n("flickr/main")}";
    this.loaderImage={"flickr/ajax-loader-back.gif"|ezimage()};
    
{foreach $flickrSelection as $selection}

    this.selectionList[this.selectionList.length]="{$selection.id}";{/foreach}

{literal}

    this.finish = function() {
        var backURL = document.getElementById('backURL');
        backURL.style.display="block";
        
        var flickrAjasLoader = document.getElementById('uploadinprogress');
        flickrAjasLoader.style.display = "none";
    }

    this.updateCount = function(){
	    var imgFlickrStatus = document.getElementById('uploadstatusbarimage');
	    var spanFlickrStatusText = document.getElementById('uploadstatustext');
        spanFlickrStatusText.innerHTML = this.imported+"/"+this.selectionCount;
        imgFlickrStatus.style.width = Math.round(this.imported/this.selectionCount*208)+"px";
        
        if (this.failures > 0)
        {
		    var spanFlickrStatusFailureText = document.getElementById('uploadstatusfailuretext');
		    spanFlickrStatusFailureText.innerHTML = this.failureText+" "+this.failures;
        }
        
        if (this.imported==this.selectionCount)
        {
            this.finish();
        }
    }

	this.handleSuccess = function(o){
        flImport.imported++;
        
        if (o.responseText!=="ok")
        {
            flImport.failures++;
        }
        flImport.updateCount();
	}
	
	this.handleFailure = function(o){
        flImport.imported++;
        flImport.failures++;
        flImport.updateCount();
	}


    this.doImport = function() 
    {
        var thisFlickrImport = this;
        var callbacks = {
            success: thisFlickrImport.handleSuccess,
            failure: thisFlickrImport.handleFailure
        }
        
        //hide launch button
        var flickrLaunchButton = document.getElementById('flickrLaunchButton');
        flickrLaunchButton.style.display =  "none";
        var flickrUploadstatusbar = document.getElementById('uploadstatusbar');
        flickrUploadstatusbar.style.background = "url('"+this.loaderImage+"') -5px -1px";
        
        for ( var i = 0; i < this.selectionList.length; i++ )
        {
            var urlImport=this.url+this.selectionList[i];
            var request = YAHOO.util.Connect.asyncRequest('GET', urlImport, callbacks);
        }
    }

}
{/literal}

var flImport = new FlickrImport();

-->
</script>



<div class="context-block">
<form name="children" method="post" action={'content/action'|ezurl}>

{* DESIGN: Header START *}<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">

<h2 class="context-title">{"Flickr Import"|i18n("flickr/main")}</h2>

{* DESIGN: Subline *}<div class="header-subline"></div>

{* DESIGN: Header END *}</div></div></div></div></div></div>

{* DESIGN: Content START *}<div class="box-ml"><div class="box-mr"><div class="box-content">
<div class="context-toolbar"></div>


<div class="block">
    <div id="ezflicr-import">
        <p>{"You have %count selected elements to import"|i18n("flickr/main","",hash("%count",$flickrSelection|count))}</p>
	    <div id="uploadstatus">
	        <div  id="uploadstatusbar">
	            <img id="uploadstatusbarimage" src={"flickr/loader.gif"|ezimage()} style="width:0px" height="15px" alt=""/>
	        </div>
	        <span id="uploadstatustext">0/{$flickrSelection|count}</span>
	        <span id="uploadstatusfailuretext" class="import-error"></span>
	    </div>
	    <div id="uploadcontrols">
	        <input type="button" class="button" value="{"Launch import"|i18n("flickr/main")}" onclick="javascript:flImport.doImport();return false" id="flickrLaunchButton"/>
	        {def $node=fetch('content','node',hash('node_id',$location))}
	        <p id="backURL" style="display:none"><a href={$node.url_alias|ezurl()}>{$node.name|wash()}</a></p>
	    </div>
    </div>
</div>

{* DESIGN: Content END *}</div></div></div>


<div class="controlbar">
{* DESIGN: Control bar START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-tc"><div class="box-bl"><div class="box-br">
{* DESIGN: Control bar END *}</div></div></div></div></div></div>
</div>

</div>