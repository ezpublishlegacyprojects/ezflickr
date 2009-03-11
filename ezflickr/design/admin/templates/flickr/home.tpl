

{include uri='design:flickr/head.tpl'}

{def    $item_type=ezpreference( 'flickr_list_limit' )
        $number_of_items=min( $item_type, 3)|choose( 10, 10, 20, 30 )
        $children=fetch('flickr','photosets')}

{include uri='design:flickr/list.tpl'}
