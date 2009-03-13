{def $person=fetch('flickr','current_person')}

<div class="context-block">
<form name="children" method="post" action={'content/action'|ezurl}>

{* DESIGN: Header START *}<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">

<h2 class="context-title">{"Flickr Library"|i18n("flickr/main")} : {if $person.realname}{$person.realname|wash()}{else}{$person.username|wash()}{/if} {if $person.is_pro}(pro){/if}</h2>

{* DESIGN: Subline *}<div class="header-subline"></div>

{* DESIGN: Header END *}</div></div></div></div></div></div>

{* DESIGN: Content START *}<div class="box-ml"><div class="box-mr"><div class="box-content">
<div class="context-toolbar"></div>


<div class="block">
    <div class="ezflickr-header">
        <img src="{$person.icon}" alt=""/>
		<p>{"You currently have %count elements"|i18n("flickr/main","",hash("%count",$person.photo_count))}</p>
		<ul>
		    <li><a href="{$person.profile_url}" target="_blank" title="{"Profile"|i18n("flickr/main")} {"(new window)"|i18n("flickr/main")}">{"Profile"|i18n("flickr/main")}</a></li>
		    <li><a href="{$person.photos_url}" target="_blank" title="{"Photos"|i18n("flickr/main")} {"(new window)"|i18n("flickr/main")}">{"Photos"|i18n("flickr/main")}</a></li>
		</ul>
	</div>
</div>

{* DESIGN: Content END *}</div></div></div>


<div class="controlbar">
{* DESIGN: Control bar START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-tc"><div class="box-bl"><div class="box-br">
{* DESIGN: Control bar END *}</div></div></div></div></div></div>
</div>

</div>