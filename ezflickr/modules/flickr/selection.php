<?php
//
// ## BEGIN COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
// SOFTWARE NAME: eZ Flickr
// SOFTWARE RELEASE: 0.1.0
// COPYRIGHT NOTICE: Copyright (C) 1999-2009 eZ Systems AS
// SOFTWARE LICENSE: GNU General Public License v2.0
// NOTICE: >
//   This program is free software; you can redistribute it and/or
//   modify it under the terms of version 2.0  of the GNU General
//   Public License as published by the Free Software Foundation.
//
//   This program is distributed in the hope that it will be useful,
//   but WITHOUT ANY WARRANTY; without even the implied warranty of
//   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//   GNU General Public License for more details.
//
//   You should have received a copy of version 2.0 of the GNU General
//   Public License along with this program; if not, write to the Free
//   Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
//   MA 02110-1301, USA.
//
//
// ## END COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
//

include_once( 'kernel/common/template.php' );

$Module = $Params["Module"];
$http = new eZHTTPTool();

/*
 * Action
 */
switch ($Module->currentAction())
{
    case "ImportSelection";
        $redirectURI = "flickr/import";
        //continue to AddToSelection for adding current selection
        $Module->redirectTo($redirectURI);
        return;
    case "RemoveSelected";
        if ($http->hasPostVariable('FlickrRemoveIDArray'))
        {
            $flickrSelectionIDs = $http->postVariable('FlickrRemoveIDArray');
            if (!is_array($flickrSelectionIDs))
            {
                $flickrSelectionIDs=array($flickrSelectionIDs);
            }

            foreach ($flickrSelectionIDs as $ID)
            {
                eZFlickrSelection::removeByID($ID);
            }
        }
        break;
    default:
        //nothing
}

/*
 * List View
 */


$tpl = templateInit();
$tpl->setVariable("view_parameters",$Params["UserParameters"]);

$Result['path']=array(
                        array(    'text' =>  ezi18n( 'flickr/main', 'Flickr Library' ),
                                   'url' => "flickr/home" ),
                        array(    'text' =>  ezi18n( 'flickr/main', 'Selection' ),
                                   'url' => false )
                        );

$Result['content']=$tpl->fetch("design:flickr/selection.tpl");


?>