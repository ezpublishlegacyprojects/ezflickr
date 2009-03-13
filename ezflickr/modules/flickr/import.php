<?php

include_once( 'kernel/common/template.php' );

$Module = $Params["Module"];

$NodeID = false;
$http = new eZHTTPTool();


if ( $Module->isCurrentAction( 'FlickrImportPlace' ) )
{
    //Action after browse : get the node id
    $selectedNodeIDArray = eZContentBrowse::result( 'FlickrImportPlace' );
    $NodeID = $selectedNodeIDArray[0];
    $http->setSessionVariable('flickr_import_node_id',$NodeID);

} elseif( $Module->isCurrentAction( 'ChooseFlickrImportPlace' ) ) {

    //Browse to select placement
    eZContentBrowse::browse( array( 'action_name' => 'FlickrImportPlace',
                                    'description_template' => 'design:flickr/browse_place.tpl',
                                    'content' => array(),
                                    'from_page' => '/flickr/import/',
                                    'cancel_page' => '/flickr/import/' ),
                             $Module );
    return;

} elseif ($http->hasSessionVariable('flickr_import_node_id')) {

    //Try with session information
    $NodeID = $http->sessionVariable('flickr_import_node_id');

}

$node = eZContentObjectTreeNode::fetch($NodeID);

$selections = eZFlickrSelection::fetchCurrentUserSelection();


$tpl = templateInit();
$tpl->setVariable('flickrSelection',$selections);
$tpl->setVariable('node',$node);
$tpl->setVariable("view_parameters",$Params["UserParameters"]);

$Result['path']=array(
                        array(    'text' =>  ezi18n( 'flickr/main', 'Flickr Library' ),
                                   'url' => "flickr/home" ),
                        array(    'text' =>  ezi18n( 'flickr/main', 'Import' ),
                                   'url' => false )
                        );

$Result['content']=$tpl->fetch("design:flickr/import.tpl");

?>