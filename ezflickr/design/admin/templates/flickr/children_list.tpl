<div class="content-navigation-childlist">
    <table class="list" cellspacing="0">
	    <tr>
	        {* Import column *}
	        <th class="remove"><img src={'toggle-button-16x16.gif'|ezimage} alt="{'Invert selection.'|i18n( 'design/admin/node/view/full' )}" title="{'Invert selection.'|i18n( 'design/admin/node/view/full' )}" onclick="ezjs_toggleCheckboxes( document.flickraction, 'FlickrImportIDArray[]' ); return false;" /></th>
	        {* Name column *}
	        <th class="name">{'Name'|i18n( 'design/admin/node/view/full' )}</th>
	        {* Class type column *}
	        <th class="class">{'Type'|i18n( 'design/admin/node/view/full' )}</th>
	        {* Edit column *}
	        <th class="edit">&nbsp;</th>
	    </tr>
	
	    {foreach $children as $child sequence array( bglight, bgdark ) as $sequence}
	    <tr class="{$sequence}">
	        <td>
	            <input type="checkbox" name="FlickrImportIDArray[]" value="{$child.ezflickr_id}" {if $child.can_import|not()}disabled="disabled"{/if} />
	        </td>
	        {* Name and link *}
	        <td>{flickr_view_gui view=line flobject=$child}</td>
	        {* Class type *}
	        <td class="class">{$child.type|wash()}</td>
	        {* Edit button *}
	        <td>&nbsp;</td>
	    </tr>
	    {/foreach}
	
	</table>
</div>

