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


$Module = $Params["Module"];
$flickrConnect = eZFlickrConnect::instance(true);

if (!$flickrConnect->connectionRequired()) {
    $Module->redirectToView("home");
    return;
}

include_once( 'kernel/common/template.php' );
$tpl = templateInit();
$tpl->setVariable("view_parameters",$Params["UserParameters"]);
$tpl->setVariable("flikr_url_auth",$flickrConnect->getAuthetificationURL());

$Result['path']=array(
                        array(    'text' =>  ezi18n( 'flickr/main', 'Flickr Library' ),
                                   'url' => false ),
                        array(    'text' =>  ezi18n( 'flickr/main', 'Connection' ),
                                   'url' => false )
                        );

$Result['content']=$tpl->fetch("design:flickr/connect.tpl");



?>