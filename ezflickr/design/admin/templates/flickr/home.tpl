<form action={"flickr/action"|ezurl} method="post" enctype="multipart/form-data">


{include uri='design:flickr/head.tpl'}

{def    $item_type=ezpreference( 'flickr_list_limit' )
        $number_of_items=min( $item_type, 3)|choose( 10, 10, 20, 30 )
        $children=fetch('flickr','recent_photos',hash('limit',$number_of_items,'offset',$view_paramaters.offset))}

{def    $item_type=ezpreference( 'flickr_list_limit' )
        $number_of_items=min( $item_type, 3)|choose( 10, 10, 20, 30 )
        $result=fetch('flickr','recent_photos',hash(    'limit',$number_of_items,
                                                        'page',$view_parameters.offset|inc()))
        $children=$result.photos
        $children_count=$result.photo_count
        $page=$result.page
        $page_count=$result.pages
        $page_uri="flickr/home"
}
{include uri='design:flickr/list.tpl' list_title="Recently Updates (%count elements)"|i18n("flickr/main","",hash("%count",$children_count))}
</form>