<?php

include_once( 'kernel/common/template.php' );

$Module = $Params["Module"];

$NodeID = 51;

$selections = eZFlickrSelection::fetchCurrentUserSelection();


$tpl = templateInit();
$tpl->setVariable('flickrSelection',$selections);
$tpl->setVariable('location',$NodeID);
$tpl->setVariable("view_parameters",$Params["UserParameters"]);

$Result['path']=array(
                        array(    'text' =>  ezi18n( 'flickr/main', 'Flickr Library' ),
                                   'url' => "flickr/home" ),
                        array(    'text' =>  ezi18n( 'flickr/main', 'Import' ),
                                   'url' => false )
                        );

$Result['content']=$tpl->fetch("design:flickr/import.tpl");

?>