<form action={"flickr/action"|ezurl} method="post" enctype="multipart/form-data">
{include uri='design:flickr/head.tpl'}



    <div class="context-block">
    
    {* DESIGN: Header START *}<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">
    
    <h2 class="context-title">{$photo.name}</h2>
    
    {* DESIGN: Subline *}<div class="header-subline"></div>
    
    {* DESIGN: Header END *}</div></div></div></div></div></div>
    
    {* DESIGN: Content START *}<div class="box-ml"><div class="box-mr"><div class="box-content">
    <div class="context-toolbar"></div>
    

    <div id="ezflickr_image">
        <img src="{$photo.medium}"/>
    </div>
    <div id="ezflickr_image_description">
        <p>{"Description:"|i18n("flickr/main")} {$photo.description}</p>
        <p>{"Tags:"|i18n("flickr/main")} {$photo.tag_string}</p>
        <p><a href="{$photo.flickr_url}" target="_blank" title="{"see on Flickr (new window)"|i18n("flickr/main")}">{"see on Flickr"|i18n("flickr/main")}</a></p>
    </div>

    
    {* DESIGN: Content END *}</div></div></div>
    
    <div class="controlbar">
    {* DESIGN: Control bar START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-tc"><div class="box-bl"><div class="box-br">
        <input type="hidden" name="FlickrImportIDArray[]" value="{$photo.ezflickr_id}"/>
        <input class="button" type="submit" name="AddToSelection" value="{'Add current to selection'|i18n( 'flickr/main' )}" />
        <input class="button" type="submit" name="ImportSelected" value="{'Import current'|i18n( 'flickr/main' )}" />
    {* DESIGN: Control bar END *}</div></div></div></div></div></div>
    </div>
    
    </div>


{include uri='design:flickr/bottom.tpl'}
</form>