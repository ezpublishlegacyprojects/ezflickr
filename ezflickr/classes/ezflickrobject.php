<?php

class eZFlickrObject {

    function eZFlickrObject($type="")
    {
        $this->type=$type;
    }

    function attributes()
    {
        return array("type","can_import");
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
            case "can_import":
                return $this->canImport();
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
     * returns true if the ezflickrobject is available for import
     * image only currently
     *
     * @return boolean
     */
    function canImport() {
        return $this->type==eZFlickrPhoto::TYPE;
    }

    /**
     * Create eZObject from eZFlickrObject
     *
     * @return boolean created or not
     */
    function createEZObject($location=false)
    {

        if (!$this->canImport() || !$location)
        {
            return false;
        }

        //Test group var, if no group, return false
        $ezflickrINI = eZINI::instance('ezflickr.ini');
        $classIdentifier = $ezflickrINI->variable($this->type.'DefaultClass','Import');
        $availableClasses = $ezflickrINI->variable($this->type.'AvailableClasses','Import');

        //Preference
        $userPreference = eZPreferences::value('flickr_import_class_'.$this->type);
        if ($userPreference)
        {
            $classIdentifier = $userPreference;
        }

        //Ini informations
        $iniGroup = $this->type.'_'.$classIdentifier;
        if (!$ezflickrINI->hasSection($this->type.'_'.$classIdentifier))
        {
            return false;
        }


        //Class
        //mandatory attributes
        $fileAttribute = $ezflickrINI->variable($iniGroup,'FileAttribute');
        $nameAttribute = $ezflickrINI->variable($iniGroup,'NameAttribute');
        //other attributes
        $descriptionAttribute = false;
        if ($ezflickrINI->hasVariable($iniGroup,'DescriptionAttribute')) {
            $descriptionAttribute = $ezflickrINI->variable($iniGroup,'DescriptionAttribute');
        }
        $tagAttribute = false;
        if ($ezflickrINI->hasVariable($iniGroup,'TagAttribute')) {
            $tagAttribute = $ezflickrINI->variable($iniGroup,'TagAttribute');
        }

        //Get the class
        $class = eZContentClass::fetchByIdentifier( $classIdentifier );
        if (!$class)
        {
            return false;
        }

        //Instanciate
        $object = $class->instantiate();
        $dataMap = $object->dataMap();
        $publishVersion = $object->attribute( 'current_version' );

        //Attributes
        $dataMap[$nameAttribute]->fromString($this->attribute('name'));
        $dataMap[$nameAttribute]->store();

        //File attribute
        if ($dataMap[$fileAttribute]->attribute('data_type_string')==eZFlickrImageType::DATA_TYPE_STRING)
        {
            //eZ Flickr Datatype : we don't upload the file
            $eZFlickrImage = new eZFlickrImage();
            $eZFlickrImage->initializeFromeZFlickrPhoto($this);
            $dataMap[$fileAttribute]->setContent($eZFlickrImage);
            $dataMap[$fileAttribute]->store();
        } else {
            //Create a local copy of the file (for import)
            $imageURL = $this->getBiggestImageURL();
            $cacheDir = eZSys::cacheDirectory()."/ezflickr";
            eZDir::mkdir($cacheDir);
            $destFile = $cacheDir."/".basename($imageURL);
            eZFileHandler::copy($imageURL,$destFile);

            $dataMap[$fileAttribute]->fromString($destFile);
            $dataMap[$fileAttribute]->store();

            //remove local copy
            @unlink($destFile);
        }

        /* Not finisehd yet
        //Description attribute
        if ($descriptionAttribute)
        {
            $dataMap[$descriptionAttribute]->fromString($this->attribute('description'));
            $dataMap[$descriptionAttribute]->store();
        }
        //Tag attribute
        if ($tagAttribute)
        {
            $dataMap[$tagAttribute]->fromString($this->attribute('tags'));
            $dataMap[$tagAttribute]->store();
        }
        */

        //Publish
        $object->createNodeAssignment( $location, true );
        $operationResult = eZOperationHandler::execute( 'content', 'publish', array( 'object_id' => $object->attribute( 'id' ),
                                                                                     'version' => $publishVersion ) );

        return true;
    }


    static $flickrClasses=array(    eZFlickrPhoto::TYPE=>"eZFlickrPhoto",
                                    eZFlickrVideo::TYPE=>"eZFlickrVideo",
                                    eZFlickrPhotoset::TYPE=>"eZFlickrPhotoset",
                                    eZFlickrPerson::TYPE=>"eZFlickrPerson");
    var $type;
}

?>