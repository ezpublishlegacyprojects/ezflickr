
<form action={"flickr/import"|ezurl} method="post" enctype="multipart/form-data">


{if $node}

<script type="text/javascript" src={"javascript/yui/2.5.2/build/utilities/utilities.js"|ezdesign}></script>
<script type="text/javascript">
<!--


{literal}
function FlickrImport()
{
{/literal}
    this.url="{concat("flickr/doimport/",$node.node_id)|ezurl(no)}/";
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

{/if}



<div class="context-block">

{* DESIGN: Header START *}<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">

<h2 class="context-title">{"Flickr Import : %count elements"|i18n("flickr/main","",hash("%count",$flickrSelection|count))}</h2>

{* DESIGN: Subline *}<div class="header-subline"></div>

{* DESIGN: Header END *}</div></div></div></div></div></div>

{* DESIGN: Content START *}<div class="box-ml"><div class="box-mr"><div class="box-content">
<div class="context-toolbar"></div>

<div class="block">
    <div id="ezflickr-import">
		{if $node}
		<p>{"New elements will be placed in:"|i18n("flickr/main")} <a href={$node.url_alias|ezurl()}>{$node.name|wash}</a></p>
		{else}
		<p class="error">{"Please select a placement before importing"|i18n("flickr/main")}</p>
		{/if}
        
	    <div id="uploadstatus">
	        <div  id="uploadstatusbar">
	            <img id="uploadstatusbarimage" src={"flickr/loader.gif"|ezimage()} style="width:0px" height="15px" alt=""/>
	        </div>
	        <span id="uploadstatustext">0/{$flickrSelection|count}</span>
	        <span id="uploadstatusfailuretext" class="import-error"></span>
	    </div>
	    <div class="break"></div>
    </div>
</div>

{* DESIGN: Content END *}</div></div></div>


<div class="controlbar">
{* DESIGN: Control bar START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-tc"><div class="box-bl"><div class="box-br">

{if $node}
	<input type="submit" class="button" name="ChooseFlickrImportPlace" value="{"Change placement"|i18n("flickr/main")}"/>
    {if $flickrSelection|count|gt(0)}<input type="button" class="button" value="{"Launch import"|i18n("flickr/main")}" onclick="javascript:flImport.doImport();return false" id="flickrLaunchButton"/>{/if}
{else}
    <input type="submit" class="button" name="ChooseFlickrImportPlace" value="{"Select a placement"|i18n("flickr/main")}"/>
{/if}

{* DESIGN: Control bar END *}</div></div></div></div></div></div>
</div>

</div>

</form>