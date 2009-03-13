<?php


class eZFlickrPhotoSize extends eZFlickrObject {

    const TYPE="photo_size";

    function eZFlickrPhotoSize($row)
    {
        $this->Label=$row['label'];
        $this->Width=$row['width'];
        $this->Height=$row['height'];
        $this->Source=$row['source'];
        $this->URL=$row['url'];

        parent::eZFlickrObject(self::TYPE);
    }




    static function fetchByPhotoID($photoID)
    {
        $sizes = array();

        //Connection
        try {
            $eZFlickrConnect = eZFlickrConnect::instance();
        } catch (eZFlickrConnectionRequiredException $e){
            return $result;
        }

        //Call method
        $params=array("photo_id"=>$photoID);

        $callResult = $eZFlickrConnect->callMethod(eZFlickrConnect::METHOD_PHOTOS_GETSIZES,$params);

        if (!isset($callResult["sizes"]["size"])) {
            return array();
        }

        //Get result
        foreach ($callResult["sizes"]["size"] as $row)
        {
            $sizes[] = new eZFlickrPhotoSize($row);
        }

        return $sizes;
    }

    function attributes()
    {
        return array_merge(
                        array('label','width','height','source','url'),
                        parent::attributes()
               );
    }


    function attribute($name)
    {
        switch ($name)
        {
            case "label":
                return $this->Label;
            case "width":
                return $this->Width;
            case "height":
                return $this->Height;
            case "source":
                return $this->Source;
            case "url":
                return $this->URL;
            default:
                return parent::attribute($name);
        }

    }


    var $Label;
    var $Width;
    var $Height;
    var $Source;
    var $URL;

}

/*

<sizes>
<size label="Square" width="75" height="75"
      source="http://farm2.static.flickr.com/1103/567229075_2cf8456f01_s.jpg"
      url="http://www.flickr.com/photos/stewart/567229075/sizes/sq/"/>
<size label="Thumbnail" width="100" height="75"
      source="http://farm2.static.flickr.com/1103/567229075_2cf8456f01_t.jpg"
      url="http://www.flickr.com/photos/stewart/567229075/sizes/t/"/>
<size label="Small" width="240" height="180"
      source="http://farm2.static.flickr.com/1103/567229075_2cf8456f01_m.jpg"
      url="http://www.flickr.com/photos/stewart/567229075/sizes/s/"/>
<size label="Medium" width="500" height="375"
      source="http://farm2.static.flickr.com/1103/567229075_2cf8456f01.jpg"
      url="http://www.flickr.com/photos/stewart/567229075/sizes/m/"/>
<size label="Original" width="640" height="480"
      source="http://farm2.static.flickr.com/1103/567229075_6dc09dc6da_o.jpg"
      url="http://www.flickr.com/photos/stewart/567229075/sizes/o/"/>
</sizes>


*/
?>