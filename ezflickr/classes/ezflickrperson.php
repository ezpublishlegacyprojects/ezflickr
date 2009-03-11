<?php


class eZFlickrPerson extends eZFlickrObject {

    const TYPE="person";

    function eZFlickrPerson($row)
    {
        $this->NSID=$row["nsid"];
        $this->IsAdmin=$row["isadmin"];
        $this->IsPro=$row["ispro"];
        $this->IconServer=$row["iconserver"];
        $this->IconFarm=$row["iconfarm"];
        $this->UserName=$row["username"]["_content"];
        $this->RealName=$row["realname"]["_content"];
        $this->Location=$row["location"]["_content"];
        $this->PhotosUrl=$row["photosurl"]["_content"];
        $this->ProfileUrl=$row["profileurl"]["_content"];
        $this->PhotoCount=$row["photos"]["count"]["_content"];
        parent::eZFlickrObject(self::TYPE);
    }


    static function fetchCurrent() {
        //Connection
        try {
            $eZFlickrConnect = eZFlickrConnect::instance();
        } catch (eZFlickrConnectionRequiredException $e){
            return false;
        }

        $auth = $eZFlickrConnect->getFlickrAuth();

        return self::fetch($auth->attribute('nsid'));
    }

    static function fetch($nsid)
    {
        //Connection
        try {
            $eZFlickrConnect = eZFlickrConnect::instance();
        } catch (eZFlickrConnectionRequiredException $e){
            return false;
        }

        //Call method
        $params=array("user_id"=>$nsid);

        $callResult = $eZFlickrConnect->callMethod(eZFlickrConnect::METHOD_PERSON_GETINFO,$params);

        if (!isset($callResult["person"])) {
            throw new eZFlickrException("Error while calling : ".eZFlickrConnect::METHOD_PERSON_GETINFO);
        }

        //Get result
        return new eZFlickrPerson($callResult["person"]);
    }

    function attributes()
    {
        return array_merge(
                        array('nsid','isadmin','ispro','iconserver','iconfarm','username','realname','location','photosurl','profileurl','photocount'),
                        parent::attributes()
               );
    }


    function attribute($name)
    {
        switch ($name)
        {

            case "nsid":
                return $this->NSID;
            case "isadmin":
                return ($this->IsAdmin==1)?true:false;
            case "ispro":
                return ($this->IsPro==1)?true:false;
            case "iconserver":
                return $this->IconServer;
            case "iconfarm":
                return $this->IconFarm;
            case "username":
                return $this->UserName;
            case "username":
                return $this->UserName;
            case "location":
                return $this->RealName;
            case "photosurl":
                return $this->PhotosUrl;
            case "profileurl":
                return $this->ProfileUrl;
            case "photocount":
                return $this->PhotoCount;
            default:
                return parent::attribute($name);
        }

    }


    /**
     * return preview image src
     *
     * @return string url
     */
    function getPreviewImage()
    {
        return self::getImageSrc($this->ID,$this->Farm,$this->Server,$this->Secret,'s');
    }

    /**
     * retourne d'url d'une iamge
     *
     * @param integer $photo_id
     * @param integer $farm
     * @param integer $server
     * @param string $secret
     * @param string $size
     * s    petit carré 75x75
     * t   miniature, côté le plus long de 100
     * m   petit, côté le plus long de 240
     * -   moyen, côté le plus long de 500 (http://farm{farm-id}.static.flickr.com/{server-id}/{id}_{secret}.jpg)
     * b   grand, côté le plus long de 1024
     * o original
     * @param string $ext extension du fichier (pour original uniquemen)
     * http://farm{farm-id}.static.flickr.com/{server-id}/{id}_{secret|o-secret}_[mstbo].jpg
     */
    static function getImageSrc($photo_id,$farm,$server,$secret,$size=false,$ext="jpg")
    {
        $url = "http://farm".$farm.".static.flickr.com/".$server."/".$photo_id."_".$secret;
        if ($size) $url .= "_".$size;
        return $url.".".$ext;
    }


    var $NSID;
    var $IsAdmin;
    var $IsPro;
    var $IconServer;
    var $IconFarm;
    var $UserName;
    var $RealName;
    var $Location;
    var $PhotosUrl;
    var $ProfileUrl;
    var $PhotoCount;

}

    /*
<person nsid="12037949754@N01" isadmin="0" ispro="0" iconserver="122" iconfarm="1">
    <username>bees</username>
    <realname>Cal Henderson</realname>
        <mbox_sha1sum>eea6cd28e3d0003ab51b0058a684d94980b727ac</mbox_sha1sum>
    <location>Vancouver, Canada</location>
    <photosurl>http://www.flickr.com/photos/bees/</photosurl>
    <profileurl>http://www.flickr.com/people/bees/</profileurl>
    <photos>
        <firstdate>1071510391</firstdate>
        <firstdatetaken>1900-09-02 09:11:24</firstdatetaken>
        <count>449</count>
    </photos>
</person>
     */
?>