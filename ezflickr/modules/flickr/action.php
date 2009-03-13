<?php


$http = eZHTTPTool::instance();
$module = $Params['Module'];

/*
 * Redirect URI
 */
$redirectURI='flickr/home';
if ($http->hasSessionVariable( "LastAccessesURI" )) {
    $redirectURI = $http->sessionVariable( "LastAccessesURI" );
}

/*
 * Action
 */
switch ($module->currentAction())
{
    case "ImportSelected";
        $redirectURI = "flickr/selection";
        //continue to AddToSelection for adding current selection
    case "AddToSelection";


        if ($http->hasPostVariable('FlickrImportIDArray'))
        {
            $flickrIDs = $http->postVariable('FlickrImportIDArray');
            if (!is_array($flickrIDs))
            {
                $flickrIDs=array($flickrIDs);
            }

            $currentUserID = eZUser::currentUserID();


            foreach ($flickrIDs as $flickrID)
            {
                $selection = new eZFlickrSelection();
                $selection->setAttribute('flickr_id',$flickrID);
                $selection->setAttribute('user_id',$currentUserID);
                $selection->store();
            }
        }
        break;
    default:
        //nothing
}

/*
 * Redirect
 */

$module->redirectTo($redirectURI);

?>