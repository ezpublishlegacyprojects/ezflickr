<div class="content-navigation-childlist">
<table class="list-thumbnails" cellspacing="0">
    <tr>
    {foreach $children as $child}
        <td width="25%">
            {flickr_view_gui view=thumbnail flobject=$child}
	        <div class="controls">
	            <input type="checkbox" name="ImportIDArray[]" value="{$child.ezflickr_id}" title="{'Use these checkboxes to select items for removal. Click the "Remove selected" button to remove the selected items.'|i18n( 'design/admin/node/view/full' )|wash()}" />
		        <p><a href={$child.url_alias|ezurl}>{$child.name|wash()}</a></p>
	        </div>
		</td>
		{delimiter modulo=4}
		</tr><tr>
		{/delimiter}
	{/foreach}
    </tr>
</table>
</div>
