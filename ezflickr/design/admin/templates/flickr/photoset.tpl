<form action={"flickr/action"|ezurl} method="post" enctype="multipart/form-data">
{include uri='design:flickr/head.tpl'}


{def    $item_type=ezpreference( 'flickr_list_limit' )
        $number_of_items=min( $item_type, 3)|choose( 10, 10, 20, 30 )
        $result=fetch('flickr','photoset_photos',hash(   'photoset_id',$photoset.id,
                                                         'limit',$number_of_items,
                                                         'page',$view_parameters.offset|inc()))
        $children=$result.photos
        $children_count=$result.photo_count
        $page=$result.page
        $page_count=$result.pages
        $page_uri=$photoset.url_alias
}

{include uri='design:flickr/list.tpl' list_title="%photoset (%count)"|i18n("flickr/main","",hash("%photoset",$photoset.title,"%count",$children_count))}


{include uri='design:flickr/bottom.tpl'}
</form>