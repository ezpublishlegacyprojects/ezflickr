<div id="content-tree">

{* DESIGN: Header START *}<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">

{section show=ezpreference( 'admin_treemenu' )}
<h4><a class="showhide" href={'/user/preferences/set/admin_treemenu/0'|ezurl} title="Hide media library."><span class="bracket">[</span>-<span class="bracket">]</span></a> {'Media library'|i18n( 'design/admin/parts/media/menu' )}</h4>
{section-else}
<h4><a class="showhide" href={'/user/preferences/set/admin_treemenu/1'|ezurl} title="Show media library."><span class="bracket">[</span>+<span class="bracket">]</span></a> {'Media library'|i18n( 'design/admin/parts/media/menu' )}</h4>
{/section}

{* DESIGN: Header END *}</div></div></div></div></div></div>

{* DESIGN: Content START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-bl"><div class="box-br"><div class="box-content">

{* Treemenu. *}
<div id="contentstructure">
{section show=ezpreference( 'admin_treemenu' )}
    {if ezini('TreeMenu','Dynamic','contentstructuremenu.ini')|eq('enabled')}
        {include uri='design:contentstructuremenu/content_structure_menu_dynamic.tpl' custom_root_node_id=ezini( 'NodeSettings', 'MediaRootNode', 'content.ini')}
    {else}
        {include uri='design:contentstructuremenu/content_structure_menu.tpl' custom_root_node_id=ezini( 'NodeSettings', 'MediaRootNode', 'content.ini')}
    {/if}
{/section}
</div>

{* Trashcan. *}
{section show=ne( $ui_context, 'browse' )}
<div id="trash">
<ul>
    <li><img src={'trash-icon-16x16.gif'|ezimage} width="16" height="16" alt="Trash" />&nbsp;<a href={concat( '/content/trash/', ezini( 'NodeSettings', 'RootNode', 'content.ini' ) )|ezurl} title="{'View and manage the contents of the trash bin.'|i18n( 'design/admin/parts/media/menu' )}">{'Trash'|i18n( 'design/admin/parts/media/menu' )}</a></li>
</ul>
</div>
{/section}



{* DESIGN: Content END *}</div></div></div></div></div></div>

</div>








{if ezpreference( 'admin_flickr_menu' )}
    {* DESIGN: Header START *}<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">
	<h4><a class="showhide" href={'/user/preferences/set/admin_flickr_menu/0'|ezurl} title="{'Hide Flickr library'|i18n( 'design/admin/flickr/menu' )}"><span class="bracket">[</span>-<span class="bracket">]</span></a> {'Flickr library'|i18n( 'design/admin/flickr/menu' )}</h4>
    {* DESIGN: Header END *}</div></div></div></div></div></div>
	
	{* DESIGN: Content START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-bl"><div class="box-br"><div class="box-content">
	<ul>
	    <li><a href={'flickr/home/'|ezurl} title="{'eZFlickr Home'|i18n( 'design/admin/flickr/menu' )}">{'Home'|i18n( 'design/admin/flickr/menu' )}</a></li>
	    <li><a href={'flickr/photosets/'|ezurl} title="{'Flickr Photosets'|i18n( 'design/admin/flickr/menu' )}">{'Photosets'|i18n( 'design/admin/flickr/menu' )}</a></li>
	    {*<li><a href={'flick/home/'|ezurl} title="{''|i18n( 'design/admin/flickr/menu' )}">{''|i18n( 'design/admin/flickr/menu' )}</a></li>
	    <li><a href={'flick/home/'|ezurl} title="{''|i18n( 'design/admin/flickr/menu' )}">{''|i18n( 'design/admin/flickr/menu' )}</a></li>
	    *}
	</ul>
	{* DESIGN: Content END *}</div></div></div></div></div></div>


{else}
    {* DESIGN: Header START *}<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">
    <h4><a class="showhide" href={'/user/preferences/set/admin_flickr_menu/1'|ezurl} title="{'Show Flickr library'|i18n( 'design/admin/flickr/menu' )}"><span class="bracket">[</span>+<span class="bracket">]</span></a> {'Flickr library'|i18n( 'design/admin/flickr/menu' )}</h4>
    {* DESIGN: Header END *}</div></div></div></div></div></div>
{/if}









{* Left menu width control. *}
<div class="widthcontrol">
<p>
{switch match=ezpreference( 'admin_left_menu_width' )}
{case match='medium'}
<a href={'/user/preferences/set/admin_left_menu_width/small/'|ezurl} title="{'Change the left menu width to small size.'|i18n( 'design/admin/parts/media/menu' )}">{'Small'|i18n( 'design/admin/parts/media/menu' )}</a>
<span class="current">{'Medium'|i18n( 'design/admin/parts/media/menu' )}</span>
<a href={'/user/preferences/set/admin_left_menu_width/large/'|ezurl} title="{'Change the left menu width to large size.'|i18n( 'design/admin/parts/media/menu' )}">{'Large'|i18n( 'design/admin/parts/media/menu' )}</a>
{/case}

{case match='large'}
<a href={'/user/preferences/set/admin_left_menu_width/small'|ezurl} title="{'Change the left menu width to small size.'|i18n( 'design/admin/parts/media/menu' )}">{'Small'|i18n( 'design/admin/parts/media/menu' )}</a>
<a href={'/user/preferences/set/admin_left_menu_width/medium'|ezurl} title="{'Change the left menu width to medium size.'|i18n( 'design/admin/parts/media/menu' )}">{'Medium'|i18n( 'design/admin/parts/media/menu' )}</a>
<span class="current">{'Large'|i18n( 'design/admin/parts/media/menu' )}</span>
{/case}

{case}
<span class="current">{'Small'|i18n( 'design/admin/parts/media/menu' )}</span>
<a href={'/user/preferences/set/admin_left_menu_width/medium'|ezurl} title="{'Change the left menu width to medium size.'|i18n( 'design/admin/parts/media/menu' )}">{'Medium'|i18n( 'design/admin/parts/media/menu' )}</a>
<a href={'/user/preferences/set/admin_left_menu_width/large'|ezurl} title="{'Change the left menu width to large size.'|i18n( 'design/admin/parts/media/menu' )}">{'Large'|i18n( 'design/admin/parts/media/menu' )}</a>
{/case}
{/switch}
</p>
</div>



