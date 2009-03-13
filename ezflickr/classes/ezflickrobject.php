<?php


class eZFlickrObject {

    function eZFlickrObject($type="")
    {
        $this->type=$type;
    }

    function attributes()
    {
        return array("type");
    }

    function hasAttribute($name) {
        return in_array($name,$this->attributes());
    }

    function attribute($name)
    {
        switch ($name)
        {
            case "type":
                return $this->type;
            default:
                return false;
        }
    }

    /**
     * Return the class for one FlickrType
     * see self::$flickrClasses
     *
     * @param string $type
     * @return string class name
     */
    static function getClassNameForType($type)
    {
        if (isset(self::$flickrClasses[$type]))
        {
            return self::$flickrClasses[$type];
        }
        return false;
    }

    /**
     * Create eZObject from eZFlickrObject
     *
     * @return boolean created or not
     */
    function createEZObject($location=false)
    {
        if (!$location) {
            return false;
        }

        //Test group var, if no group, return false
        $ezflickrINI = eZINI::instance('ezflickr.ini');
        if (!$ezflickrINI->hasSection($this->type)) {
            return false;
        }

        //Class
        $classIdentifier = $ezflickrINI->variable($this->type,'ClassIdentifier');
        //mandatory attributes
        $fileAttribute = $ezflickrINI->variable($this->type,'FileAttribute');
        $nameAttribute = $ezflickrINI->variable($this->type,'NameAttribute');
        //other attributes
/*        if ($ezflickrINI->hasVariable($this->type,'DescriptionAttribute')) {
            $descriptionAttribute = $ezflickrINI->variable($this->type,'DescriptionAttribute');
        }*/


        $class = eZContentClass::fetchByIdentifier( $classIdentifier );

        if (!$class)
        {
            die('oups 3');
            return false;
        }

        //Instanciate
        $object = $class->instantiate();
        $dataMap = $object->dataMap();
        $publishVersion = $object->attribute( 'current_version' );

        //Attributes
        $dataMap[$nameAttribute]->fromString($this->attribute('name'));
        $dataMap[$nameAttribute]->store();

        //Create a local copy of the file (for import)
        $imageURL = $this->getBiggestImageURL();
        $destFile = eZSys::cacheDirectory()."/".basename($imageURL);
        eZFileHandler::copy($imageURL,$destFile);

        $dataMap[$fileAttribute]->fromString($destFile);
        $dataMap[$fileAttribute]->store();

        //remove local copy
        //@unlink($destFile);

        //Publish
        $object->createNodeAssignment( $location, true );
        $operationResult = eZOperationHandler::execute( 'content', 'publish', array( 'object_id' => $object->attribute( 'id' ),
                                                                                     'version' => $publishVersion ) );


    }


    static $flickrClasses=array(    eZFlickrPhoto::TYPE=>"eZFlickrPhoto",
                                    eZFlickrVideo::TYPE=>"eZFlickrVideo",
                                    eZFlickrPhotoset::TYPE=>"eZFlickrPhotoset",
                                    eZFlickrPerson::TYPE=>"eZFlickrPerson");
    var $type;
}

?>