
{def    $resultSelection=fetch('flickr','user_selection',hash('limit',4,'offset',0))
        $lastItems=$resultSelection.selection
        
}


{if ezpreference( 'flickr_show_menu_selection' )|ne(2)}
	
	<div class="context-block">
	
	{* DESIGN: Header START *}<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">
	
	<h2 class="context-title">{"Current Selection"|i18n("flickr/main")} {if $lastItems|count()|gt(0)} : {"Last %count items"|i18n("flickr/main","",hash("%count",$lastItems|count()))}{/if}</h2>
	
	{* DESIGN: Subline *}<div class="header-subline"></div>
	
	{* DESIGN: Header END *}</div></div></div></div></div></div>
	
	{* DESIGN: Content START *}<div class="box-ml"><div class="box-mr"><div class="box-content">
	<div class="context-toolbar"></div>
	
	
	
	<div class="content-navigation-childlist">
	<table class="list-thumbnails" cellspacing="0">
	    <tr>
	    {def $flObject=false()}
	    {foreach $lastItems as $child}
	        <td width="25%">
	            {set $flObject=$child.flickr_element}
	            {flickr_view_gui view=thumbnail flobject=$flObject}
	            <div class="controls">
	                <input type="checkbox" name="FlickrRemoveIDArray[]" value="{$child.id}" />
	                <p><a href={$child.url_alias|ezurl}>{$flObject.name|wash()}</a></p>
	            </div>
	        </td>
	        {delimiter modulo=4}
	        </tr><tr>
	        {/delimiter}
	    {/foreach}
	    </tr>
	</table>
	</div>
	
	{* DESIGN: Content END *}</div></div></div>
	
	<div class="controlbar">
	{* DESIGN: Control bar START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-tc"><div class="box-bl"><div class="box-br">
	    <input class="button" type="submit" name="RemoveSelected" value="{'Remove from selection'|i18n( 'flickr/main' )}" />
	    <input class="button" type="submit" name="ImportSelection" value="{'Import current selection'|i18n( 'flickr/main' )}" />
	{* DESIGN: Control bar END *}</div></div></div></div></div></div>
	</div>
	
	</div>
{/if}