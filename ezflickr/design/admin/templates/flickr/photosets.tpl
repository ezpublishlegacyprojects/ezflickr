<form action={"flickr/action"|ezurl} method="post" enctype="multipart/form-data">
{def    $item_type=ezpreference( 'flickr_list_limit' )
        $number_of_items=min( $item_type, 3)|choose( 10, 10, 20, 30 )
        $children=fetch('flickr','photosets')}

{include uri='design:flickr/list.tpl' list_title="Photosets (%count elements)"|i18n("flickr/main","",hash("%count",$children|count()))}
</form>