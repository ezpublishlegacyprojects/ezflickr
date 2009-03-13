<form name="flickraction" action={"flickr/selection"|ezurl} method="post" enctype="multipart/form-data">


{def    $item_type=ezpreference( 'flickr_list_limit' )
        $number_of_items=min( $item_type, 3)|choose( 10, 10, 20, 30 )

        $result=fetch('flickr','user_selection',hash(    'limit',$number_of_items,
                                                         'offset',$view_parameters.offset))
        $children=$result.selection
        $children_count=$result.selection_count
        $page_uri="flickr/selection"
}

<div class="content-view-children">

<!-- Children START -->



<div class="context-block">
<form name="children" method="post" action={'content/action'|ezurl}>

{* DESIGN: Header START *}<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">

<h2 class="context-title">{"Current Selection (%count elements)"|i18n("flickr/main","",hash("%count",$children_count))}</h2>

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

<div class="break"></div>

</div>
</div>

{if $children}

	<div class="content-navigation-childlist">
	    <table class="list" cellspacing="0">
	        <tr>
	            {* Import column *}
	            <th class="remove"><img src={'toggle-button-16x16.gif'|ezimage} alt="{'Invert selection.'|i18n( 'design/admin/node/view/full' )}" title="{'Invert selection.'|i18n( 'design/admin/node/view/full' )}" onclick="ezjs_toggleCheckboxes( document.flickraction, 'FlickrRemoveIDArray[]' ); return false;" /></th>
	            {* Name column *}
	            <th>{'Preview'|i18n( 'design/admin/node/view/full' )}</th>
	            <th class="name">{'Name'|i18n( 'design/admin/node/view/full' )}</th>
	            {* Class type column *}
	            <th class="class">{'Type'|i18n( 'design/admin/node/view/full' )}</th>
	        </tr>
	        {def $flObject=false()}
	        {foreach $children as $child sequence array( bglight, bgdark ) as $sequence}
                {set $flObject=$child.flickr_element}
		        {if $flObject}
			        <tr class="{$sequence}">
			            <td>
			                <input type="checkbox" name="FlickrRemoveIDArray[]" value="{$child.id}"  />
			            </td>
			            <td>{flickr_view_gui view=thumbnail flobject=$flObject}</td>
			            {* Name and link *}
			            <td>{flickr_view_gui view=line flobject=$flObject}</td>
			            {* Class type *}
			            <td class="class">{$flObject.type|wash()}</td>
			        </tr>
		        {/if}
	        {/foreach}
	    
	    </table>
	</div>





{* Else: there are no children. *}
{else}

    <div class="block">
        <p>{'The current item does not contain any sub items.'|i18n( 'design/admin/node/view/full' )}</p>
    </div>

{/if}

<div class="context-toolbar">
{include name=navigator
         uri='design:navigator/alphabetical.tpl'
         page_uri=$page_uri
         item_count=$children_count
         view_parameters=$view_parameters
         item_limit=$number_of_items}
</div>

{* DESIGN: Content END *}</div></div></div>


{* Button bar for remove and update priorities buttons. *}
<div class="controlbar">

{* DESIGN: Control bar START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-tc"><div class="box-bl"><div class="box-br">

<input class="button" type="submit" name="RemoveSelected" value="{'Remove from selection'|i18n( 'flickr/main' )}" />
<input class="button" type="submit" name="ImportSelection" value="{'Import current selection'|i18n( 'flickr/main' )}" />


{* DESIGN: Control bar END *}</div></div></div></div></div></div>

</div>

</form>

</div>

<!-- Children END -->

</div>




</form>