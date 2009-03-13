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

if ($flickrSelectionID && $parentNodeID) {
    /*
     * get flickr selection
     */
    $selection          = eZFlickrSelection::fetch($flickrSelectionID);
    if($selection) {
        $flickrElement = $selection->attribute("flickr_element");
        if ($flickrElement && $flickrElement->attribute('type')==eZFlickrPhoto::TYPE) {
            $result = $flickrElement->createEZObject($parentNodeID);
        }
    }
}

if ($result)
{
    eZFlickrSelection::removeByID($flickrSelectionID);
    echo "ok";
} else {
    echo "ko";
}


eZExecution::cleanExit();
?>