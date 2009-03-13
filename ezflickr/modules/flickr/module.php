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


$Module = array( 'name' => 'Polyspot' );

$ViewList = array();

/*
 * Connect : for internal use only
 */
$ViewList['connect']    = array(    'script' => 'connect.php',
                                    'default_navigation_part' => 'ezmedianavigationpart' );

/*
 * Home
 */
$ViewList['home']       = array(    'script' => 'home.php',
                                    'default_navigation_part' => 'ezmedianavigationpart' );

/*
 * Photosets
 */
$ViewList['photosets']  = array(    'script' => 'photosets.php',
                                    'default_navigation_part' => 'ezmedianavigationpart' );

$ViewList['photoset']   = array(    'script' => 'photoset.php',
                                    'default_navigation_part' => 'ezmedianavigationpart',
                                    'params' => array("PhotosetID")
                                 );

/*
 * User selection
 */
$ViewList['selection']   = array(    'script' => 'selection.php',
                                     'default_navigation_part' => 'ezmedianavigationpart',
                                     'params' => array(),
                                     'single_post_actions' => array( 'RemoveSelected' => 'RemoveSelected',
                                                                     'ImportSelection' => 'ImportSelection'
                                                                        )
                                 );

/*
 * Import page
 */
$ViewList['import']   = array(       'script' => 'import.php',
                                     'default_navigation_part' => 'ezmedianavigationpart',
                                     'params' => array(),
                                     'ui_context' => 'edit'
                                 );
/*
 * Ajax do Import
 */
$ViewList['doimport']   = array(       'script' => 'doimport.php',
                                       'default_navigation_part' => 'ezmedianavigationpart',
                                       'params' => array('parentNodeID','flickrSelectionID'),
                                       'ui_context' => 'edit'
                                 );


/*
 * Action : add to selection, import...
 * ui_context edit is used to make sure that this URL won't be set as LastAccessURI
 */
$ViewList['action']       = array(      'script' => 'action.php',
                                        'default_navigation_part' => 'ezmedianavigationpart',
                                        'ui_context' => 'edit',
                                        'single_post_actions' => array( 'AddToSelection' => 'AddToSelection',
                                                                        'ImportSelected' => 'ImportSelected'
                                                                        ));



?>