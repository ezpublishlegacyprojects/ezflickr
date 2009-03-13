<?php

/*
 * Ajax doImport
 */

/*
 * Params
 */
$Module = $Params["Module"];

$flickrSelectionID  = $Params["flickrSelectionID"];
$parentNodeID       = $Params["parentNodeID"];
$result = false;

/*
 * get flickr selection
 */
$selection          = eZFlickrSelection::fetch($flickrSelectionID);
if($selection) {
    $flickrElement = $selection->attribute("flickr_element");
    if ($flickrElement && $flickrElement->attribute('type')==eZFlickrPhoto::TYPE) {
        $flickrElement->createEZObject($parentNodeID);
        $result=true;
    }
}

if ($result)
{
    echo "ok";
} else {
    echo "ko";
}


eZExecution::cleanExit();
?>