
{if is_set($hide_selection)|not()}{def $hide_selection=false()}{/if}

<div class="menu-block">
    <ul>
        {def $enableFlickrProfile=ezpreference( 'flickr_show_menu_profile' )|ne(2)}
        <li class="{if $enableFlickrProfile}enabled{else}disabled{/if}">
            <div class="button-bc"><div class="button-tl"><div class="button-tr"><div class="button-br">
                <a  href="/user/preferences/set/flickr_show_menu_profile/{if $enableFlickrProfile}2{else}1{/if}" 
                    title="{if $enableFlickrProfile}{"Hide Flickr profile informations"|i18n("flickr/main")}{else}{"Show Flickr profile informations"|i18n("flickr/main")}{/if}">{"Flickr Menu"|i18n("flickr/main")}</a>
            </div></div></div></div>
        </li>
        {if $hide_selection|not()}
        {def $enableFlickrSelection=ezpreference( 'flickr_show_menu_selection' )|ne(2)}
        <li class="{if $enableFlickrSelection}enabled{else}disabled{/if}">
            <div class="button-bc"><div class="button-tl"><div class="button-tr"><div class="button-br">
                <a  href="/user/preferences/set/flickr_show_menu_selection/{if $enableFlickrSelection}2{else}1{/if}" 
                    title="{if $enableFlickrSelection}{"Hide Flickr current selection"|i18n("flickr/main")}{else}{"Show Flickr current selection"|i18n("flickr/main")}{/if}">{"Selection"|i18n("flickr/main")}</a>
            </div></div></div></div>
        </li>
        {/if}
    <div class="break"></div>
</div>


{if $enableFlickrProfile}
	{def $person=fetch('flickr','current_person')}
	
	<div class="context-block">
	
	{* DESIGN: Header START *}<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">
	
	<h2 class="context-title">{"Flickr Library"|i18n("flickr/main")} : {if $person.realname}{$person.realname|wash()}{else}{$person.username|wash()}{/if} {if $person.is_pro}(pro){/if}</h2>
	
	{* DESIGN: Subline *}<div class="header-subline"></div>
	
	{* DESIGN: Header END *}</div></div></div></div></div></div>
	
	{* DESIGN: Content START *}<div class="box-ml"><div class="box-mr"><div class="box-content">
	<div class="context-toolbar"></div>
	
	
	<div class="block">
	    <div id="ezflickr-header">
	        <img src="{$person.icon}" alt=""/>
			<div id="ezflickr-menu">
				<p>{"You currently have %count elements"|i18n("flickr/main","",hash("%count",$person.photo_count))}</p>
				<ul>
				    <li><a href="{$person.profile_url}" target="_blank" title="{"Your profile on Flickr"|i18n("flickr/main")} {"(new window)"|i18n("flickr/main")}">{"Profile on Flickr"|i18n("flickr/main")}</a></li>
				    <li><a href="{$person.photos_url}" target="_blank" title="{"Your photos on Flickr"|i18n("flickr/main")} {"(new window)"|i18n("flickr/main")}">{"Photos on Flickr"|i18n("flickr/main")}</a></li>
				    <li><a href={"flickr/home"|ezurl()} /main")} >{"Recently updated"|i18n("flickr/main")}</a></li>
				    <li><a href={"flickr/photosets"|ezurl()} /main")} >{"Photosets"|i18n("flickr/main")}</a></li>
				    <li><a href={"flickr/selection"|ezurl()} /main")} >{"Selection"|i18n("flickr/main")}</a></li>
				</ul>
			</div>
		<div class="break"></div>
		</div>
	</div>
	
	
	{* DESIGN: Content END *}</div></div></div>
	
	
	<div class="controlbar">
	{* DESIGN: Control bar START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-tc"><div class="box-bl"><div class="box-br">
	{* DESIGN: Control bar END *}</div></div></div></div></div></div>
	</div>
	
	</div>

{/if}