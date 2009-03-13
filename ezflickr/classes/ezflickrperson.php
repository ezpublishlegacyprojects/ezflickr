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
                        array('nsid','is_admin','is_pro','iconserver','iconfarm','username','realname','location','photos_url','profile_url','photo_count','icon'),
                        parent::attributes()
               );
    }


    function attribute($name)
    {
        switch ($name)
        {

            case "nsid":
                return $this->NSID;
            case "is_admin":
                return ($this->IsAdmin==1)?true:false;
            case "is_pro":
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
            case "photos_url":
                return $this->PhotosUrl;
            case "profile_url":
                return $this->ProfileUrl;
            case "photo_count":
                return $this->PhotoCount;
            case "icon":
                return $this->getIconSrc();
            default:
                return parent::attribute($name);
        }

    }




    /**
     * return person icon URL
     *
     * http://farm{icon-farm}.static.flickr.com/{icon-server}/buddyicons/{nsid}.jpg
     *
     *  sinon, l'url suivant doit être utilisé :
     *  http://www.flickr.com/images/buddyicon.jpg
     */
    function getIconSrc()
    {
        if ($this->IconServer>0) {
            return "http://farm".($this->IconFarm).".static.flickr.com/".($this->IconServer)."/buddyicons/".($this->NSID).".jpg";
        } else {
            return "http://www.flickr.com/images/buddyicon.jpg";
        }
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