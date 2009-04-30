<form name="flickraction" action={"flickr/connect"|ezurl} method="post" enctype="multipart/form-data">
<div class="context-block">

{* DESIGN: Header START *}<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">

<h2 class="context-title">{"Flickr Library"|i18n("flickr/main")}</h2>

{* DESIGN: Subline *}<div class="header-subline"></div>

{* DESIGN: Header END *}</div></div></div></div></div></div>

{* DESIGN: Content START *}<div class="box-ml"><div class="box-mr"><div class="box-content">
<div class="context-toolbar"></div>


<div class="block">
    <div class="ezflickr-header">
        {"Before browsing your Flickr Library you must login. Use the Login button."|i18n("flickr/main")}
        <br/> 
        {"Once connected, use the Refresh button to continue."|i18n("flickr/main")}
	</div>
</div>

{* DESIGN: Content END *}</div></div></div>


{* Button bar for remove and update priorities buttons. *}
<div class="controlbar">

{* DESIGN: Control bar START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-tc"><div class="box-bl"><div class="box-br">

<input class="button" type="submit" name="Login" value="{'Login'|i18n( 'flickr/main' )}" onclick="window.open('{$flikr_url_auth}');return false;"/>
<input class="button" type="submit" name="Refresh" value="{'Refresh'|i18n( 'flickr/main' )}" />


{* DESIGN: Control bar END *}</div></div></div></div></div></div>

</div>

</div>
</form>