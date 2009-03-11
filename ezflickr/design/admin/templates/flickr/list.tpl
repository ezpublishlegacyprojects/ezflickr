

<div class="content-view-children">

<!-- Children START -->



<div class="context-block">
<form name="children" method="post" action={'content/action'|ezurl}>

{* DESIGN: Header START *}<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">

<h2 class="context-title">Photosets</h2>

{* DESIGN: Subline *}<div class="header-subline"></div>

{* DESIGN: Header END *}</div></div></div></div></div></div>

{* DESIGN: Content START *}<div class="box-ml"><div class="box-mr"><div class="box-content">

{* If there are children: show list and buttons that belong to the list. *}

{* Items per page and view mode selector. *}
<div class="context-toolbar">
<div class="block">
<div class="left">
    <p>
    {switch match=$number_of_items}
    {case match=20}
        <a href={'/user/preferences/set/flickr_list_limit/1'|ezurl} title="{'Show 10 items per page.'|i18n( 'design/admin/node/view/full' )}">10</a>
        <span class="current">20</span>
        <a href={'/user/preferences/set/flickr_list_limit/3'|ezurl} title="{'Show 50 items per page.'|i18n( 'design/admin/node/view/full' )}">30</a>

        {/case}

        {case match=30}
        <a href={'/user/preferences/set/flickr_list_limit/1'|ezurl} title="{'Show 10 items per page.'|i18n( 'design/admin/node/view/full' )}">10</a>
        <a href={'/user/preferences/set/flickr_list_limit/2'|ezurl} title="{'Show 25 items per page.'|i18n( 'design/admin/node/view/full' )}">20</a>
        <span class="current">30</span>
        {/case}

        {case}
        <span class="current">10</span>
        <a href={'/user/preferences/set/flickr_list_limit/2'|ezurl} title="{'Show 25 items per page.'|i18n( 'design/admin/node/view/full' )}">20</a>
        <a href={'/user/preferences/set/flickr_list_limit/3'|ezurl} title="{'Show 50 items per page.'|i18n( 'design/admin/node/view/full' )}">30</a>
        {/case}

        {/switch}
    </p>
</div>
<div class="right">
	<p>
	{switch match=ezpreference( 'flickr_children_viewmode' )}
	{case match='thumbnail'}
	<a href={'/user/preferences/set/flickr_children_viewmode/list'|ezurl} title="{'Display sub items using a simple list.'|i18n( 'design/admin/node/view/full' )}">{'List'|i18n( 'design/admin/node/view/full' )}</a>
	<span class="current">{'Thumbnail'|i18n( 'design/admin/node/view/full' )}</span>
	{/case}
	
	{case}
	<span class="current">{'List'|i18n( 'design/admin/node/view/full' )}</span>
	<a href={'/user/preferences/set/flickr_children_viewmode/thumbnail'|ezurl} title="{'Display sub items as thumbnails.'|i18n( 'design/admin/node/view/full' )}">{'Thumbnail'|i18n( 'design/admin/node/view/full' )}</a>
	{/case}
	{/switch}
	</p>
</div>

<div class="break"></div>

</div>
</div>

{section show=$children}
	{* Display the actual list of nodes. *}
	{switch match=ezpreference( 'flickr_children_viewmode' )}
		{case match='thumbnail'}
		    {include uri='design:flickr/children_thumbnail.tpl'}
		{/case}
		
		{case}
		    {include uri='design:flickr/children_list.tpl'}
		{/case}
	{/switch}

{* Else: there are no children. *}
{section-else}

	<div class="block">
	    <p>{'The current item does not contain any sub items.'|i18n( 'design/admin/node/view/full' )}</p>
	</div>

{/section}

<div class="context-toolbar">
{include name=navigator
         uri='design:navigator/alphabetical.tpl'
         page_uri=$page_uri
         item_count=$page_count
         view_parameters=$view_parameters
         item_limit=1}
</div>

{* DESIGN: Content END *}</div></div></div>


{* Button bar for remove and update priorities buttons. *}
<div class="controlbar">

{* DESIGN: Control bar START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-tc"><div class="box-bl"><div class="box-br">




{* DESIGN: Control bar END *}</div></div></div></div></div></div>

</div>

</form>

</div>

<!-- Children END -->

</div>
