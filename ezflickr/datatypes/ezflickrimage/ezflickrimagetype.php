<?php

/*!
  \class   eZFlickrImageType ezflickrimagetype.php
  \ingroup eZDatatype
  \brief   Handles the datatype ezflickrimage. By using ezflickrimage you can ...

  \version 1.0
  \date    Samedi 04 Avril 2009 10:21:00
  \author  Administrator User



*/

class eZFlickrImageType extends eZDataType
{

    const DATA_TYPE_STRING = "ezflickrimage";

    /*!
      Constructor
    */
    function eZFlickrImageType()
    {
        $this->eZDataType( self::DATA_TYPE_STRING, ezi18n("flickr/datatype","Flickr Image") );
    }

    /*!
     Validates input on content object level
     \return eZInputValidator::STATE_ACCEPTED or eZInputValidator::STATE_INVALID if
             the values are accepted or not
    */
    function validateObjectAttributeHTTPInput( $http, $base, $contentObjectAttribute )
    {
        return eZInputValidator::STATE_ACCEPTED;
    }

    /*!
     Fetches all variables from the object
     \return true if fetching of class attributes are successfull, false if not
    */
    function fetchObjectAttributeHTTPInput( $http, $base, $contentObjectAttribute )
    {
        return true;
    }

    /**
     * Store XML content
     **/
    function storeObjectAttribute( &$contentObjectAttribute  )
    {
        $ezFlickrImage =& $contentObjectAttribute->content();
        $contentObjectAttribute->setAttribute( 'data_text', $ezFlickrImage->xmlString() );
    }

    /*!
     Returns the content.
    */
    function objectAttributeContent( $contentObjectAttribute )
    {

        $ezFlickrImage = new eZFlickrImage();
        if ( trim( $contentObjectAttribute->attribute( 'data_text' ) ) !=  ""  )
        {
            $ezFlickrImage->decodeXml( $contentObjectAttribute->attribute( 'data_text' ) );
        }
        return $ezFlickrImage;
    }

    /*!
     Returns the meta data used for storing search indeces.
    */
    function metaData( $contentObjectAttribute )
    {
        $ezFlickrImage =& $contentObjectAttribute->content();
        if ($ezFlickrImage->attribute('is_valid'))
        {
            return $ezFlickrImage->attribute('title');
        }
        return "";
    }

    /*!
     Returns the value as it will be shown if this attribute is used in the object name pattern.
    */
    function title( $contentObjectAttribute, $name = null )
    {
        $ezFlickrImage =& $contentObjectAttribute->content();
        if ($ezFlickrImage->attribute('is_valid'))
        {
            return $ezFlickrImage->attribute('title');
        }
        return "ezflickrimage";
    }

    /*!
     \return true if the datatype can be indexed
    */
    function isIndexable()
    {
        return true;
    }

}

eZDataType::register( eZFlickrImageType::DATA_TYPE_STRING, "eZFlickrImageType" );

?>
