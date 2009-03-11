<?php

$FunctionList = array();

$FunctionList['photosets'] = array(     'name' => 'photosets',
                                        'operation_types' => array( 'read' ),
                                        'call_method' => array( 'include_file' => 'extension/ezflickr/modules/flickr/ezflickrfunctioncollection.php',
                                                                'class' => 'eZFlickrFunctionCollection',
                                                                'method' => 'fetchPhotosets' ),
                                        'parameter_type' => 'standard',
                                        'parameters' => array() );

$FunctionList['photoset_photos'] = array(
                                        'name' => 'photoset_photos',
                                        'operation_types' => array( 'read' ),
                                        'call_method' => array( 'include_file' => 'extension/ezflickr/modules/flickr/ezflickrfunctioncollection.php',
                                                                'class' => 'eZFlickrFunctionCollection',
                                                                'method' => 'fetchPhotosetPhotos' ),
                                        'parameter_type' => 'standard',
                                        'parameters' => array(
                                                                array(  'name' => 'photoset_id',
                                                                        'type' => 'string',
                                                                        'required' => true ),
                                                                array(  'name' => 'limit',
                                                                        'type' => 'integer',
                                                                        'required' => false ),
                                                                array(  'name' => 'page',
                                                                        'type' => 'integer',
                                                                        'required' => false )
                                        ));


$FunctionList['person'] = array(
                                        'name' => 'person',
                                        'operation_types' => array( 'read' ),
                                        'call_method' => array( 'include_file' => 'extension/ezflickr/modules/flickr/ezflickrfunctioncollection.php',
                                                                'class' => 'eZFlickrFunctionCollection',
                                                                'method' => 'fetchPerson' ),
                                        'parameter_type' => 'standard',
                                        'parameters' => array(
                                                                array(  'name' => 'nsid',
                                                                        'type' => 'string',
                                                                        'required' => true )
                                        ));

$FunctionList['current_person'] = array(
                                        'name' => 'current_person',
                                        'operation_types' => array( 'read' ),
                                        'call_method' => array( 'include_file' => 'extension/ezflickr/modules/flickr/ezflickrfunctioncollection.php',
                                                                'class' => 'eZFlickrFunctionCollection',
                                                                'method' => 'fetchCurrentPerson' ),
                                        'parameter_type' => 'standard',
                                        'parameters' => array());


?>