<?php


class eZFlickrPhoto extends eZFlickrObject {

    const TYPE="photo";

    function eZFlickrPhoto($row,$ownerId=false)
    {
        $this->ID=$row["id"];
        $this->Secret=$row["secret"];
        $this->Server=$row["server"];
        $this->Farm=$row["farm"];
        if (array_key_exists("_content",$row["title"])) {
            //photos.getInfo case
            $this->Title=$row["title"]["_content"];
        } else {
            //photoset.getPhotos case
            $this->Title=$row["title"];
        }

        if ($ownerId)
        {
            $this->OwnerId=$ownerId;
        }

        //GETINFO data
        if (isset($row["description"]))
        {
            $this->Description=$row["description"]["_content"];
        }

        if (isset($row["tags"]))
        {
            foreach ($row["tags"]["tag"] as $tag) {
                $this->Tags[]=$tag["_content"];
            }
        }

        if (isset($row["owner"]))
        {
            $this->OwnerId=$row["owner"]["nsid"];
        }

        $this->OriginalSecret=isset($row["originalsecret"])?$row["originalsecret"]:false;
        parent::eZFlickrObject(self::TYPE);
    }

    /**
     * return one photo or false
     *
     * @param string $ID
     * @param string $secret (secret code if available)
     * @return eZFlickrPhoto
     */
    static function fetch($ID,$secret=false)
    {
        //Connection
        try {
            $eZFlickrConnect = eZFlickrConnect::instance();
        } catch (eZFlickrConnectionRequiredException $e){
            return $result;
        }

            //Call method
        $params=array("photo_id"=>$ID);

        $callResult = $eZFlickrConnect->callMethod(eZFlickrConnect::METHOD_PHOTOS_GETINFO,$params);

        if (!isset($callResult["photo"])) {
            return false;
        }

        if ($callResult["photo"]["media"]=="video")
        {
            return new eZFlickrVideo($callResult["photo"]);
        } else {
            return new eZFlickrPhoto($callResult["photo"]);
        }
    }


    static function fetchByPhotoset($photosetID,$limit=false,$page=1)
    {
        $photos = array();
        $result = array(   'photos'        => array(),
                            'photo_count'   => 0,
                            'perpage'       => $limit,
                            'pages'         => 0,
                            'current_page'  => 1);

        //Connection
        try {
            $eZFlickrConnect = eZFlickrConnect::instance();
        } catch (eZFlickrConnectionRequiredException $e){
            return $result;
        }

        //Call method
        $params=array("photoset_id"=>$photosetID,"page"=>$page);
        if ($limit) $params["per_page"]=$limit;
        $params["extras"]="original_format,media";

        $callResult = $eZFlickrConnect->callMethod(eZFlickrConnect::METHOD_PHOTOSETS_GETPHOTOS,$params);

        if (!isset($callResult["photoset"])) {
            throw new eZFlickrException("Error while calling : ".eZFlickrConnect::METHOD_PHOTOSETS_GETLIST);
        }

        //Get result
        foreach ($callResult["photoset"]["photo"] as $row)
        {
            if ($row["media"]=="video")
            {
                $photos[] = new eZFlickrVideo($row);
            } else {
                $photos[] = new eZFlickrPhoto($row,$callResult["photoset"]["owner"]);
            }
        }

        $result = array(   'photos'        => $photos,
                            'photo_count'   => $callResult["photoset"]["total"],
                            'perpage'       => $callResult["photoset"]["perpage"],
                            'pages'         => $callResult["photoset"]["pages"],
                            'current_page'  => $callResult["photoset"]["page"]);

        return $result;
    }


    static function fetchRecent($limit=100,$page=1)
    {
        $photos = array();
        $result = array(    'photos'        => array(),
                            'photo_count'   => 0,
                            'perpage'       => $limit,
                            'pages'         => 0,
                            'current_page'  => 1);

        //Connection
        try {
            $eZFlickrConnect = eZFlickrConnect::instance();
        } catch (eZFlickrConnectionRequiredException $e){
            return $result;
        }

        //Call method
        $params=array("page"=>$page);
        if ($limit) $params["per_page"]=$limit;
        $params["extras"]="original_format,media";
        //Last 2 weeks
        $params["min_date"]=mktime()-(3600*24*14);
        $callResult = $eZFlickrConnect->callMethod(eZFlickrConnect::METHOD_PHOTOS_RECENTLYUPDATED,$params);

        if (!isset($callResult["photos"])) {
            throw new eZFlickrException("Error while calling : ".eZFlickrConnect::METHOD_PHOTOS_RECENTLYUPDATED);
        }

        //Get result
        foreach ($callResult["photos"]["photo"] as $row)
        {
            if ($row["media"]=="video")
            {
                $photos[] = new eZFlickrVideo($row);
            } else {
                $photos[] = new eZFlickrPhoto($row);
            }
        }

        $result = array(   'photos'        => $photos,
                            'photo_count'   => $callResult["photos"]["total"],
                            'perpage'       => $callResult["photos"]["perpage"],
                            'pages'         => $callResult["photos"]["pages"],
                            'current_page'  => $callResult["photos"]["page"]);

        return $result;
    }

    function attributes()
    {
        return array_merge(
                        array(  'name','id','secret','server',
                                'farm','title','url_alias','original_secret',
                                'preview','ezflickr_id','biggest_image_url','sizes',
                                'description','tags','tag_string','medium','owner_id','flickr_url'),
                        parent::attributes()
               );
    }



    function attribute($name)
    {
        switch ($name)
        {
            case "id":
                return $this->ID;
            case "secret":
                return $this->Secret;
            case "original_secret":
                return $this->OriginalSecret;
            case "server":
                return $this->Server;
            case "farm":
                return $this->Farm;
            case "title":
            case "name":
                return $this->Title;
            case "url_alias":
                return "flickr/photo/".$this->ID;
            case "ezflickr_id":
                return $this->type."_".$this->ID;
            case "preview":
                return $this->getPreviewImage();
            case "medium":
                return self::getImageSrc($this->ID,$this->Farm,$this->Server,$this->Secret);
            case "biggest_image_url":
                return $this->getBiggestImageURL();
            case "sizes":
                return $this->getImageSizes();
            case "tags":
                return $this->Tags;
            case "description":
                return $this->Description;
            case "tag_string":
                return implode(",",$this->Tags);
            case "owner_id":
                return $this->OwnerId;
            case "flickr_url":
                return "http://www.flickr.com/photos/".$this->OwnerId."/".$this->ID."/";
            default:
                return parent::attribute($name);
        }

    }

    /**
     * return bigger file we get (original, "b", medium)
     * @return string url
     */
    function getBiggestImageURL() {
        $biggerWidth=0;
        $bigger=false;
        foreach ($this->getImageSizes() as $size)
        {
            if ($size->attribute('width')>$biggerWidth)
            {
                $biggerWidth = $biggerWidth;
                $biggerURL = $size->attribute('source');
            }
        }
        return $biggerURL;
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

    /**
     * Return Image Sizes Array
     *
     * @return array eZFlickrPhotoSize
     */
    function getImageSizes() {
        if (!$this->Sizes)
        {
            $this->Sizes = eZFlickrPhotoSize::fetchByPhotoID($this->ID);
        }

        return $this->Sizes;
    }


    var $ID;
    var $Secret;
    var $OriginalSecret;
    var $Server;
    var $Farm;
    var $Title;
    var $Sizes=false;
    var $Description;
    var $Tags=array();
    var $OwnerId;

}

/*

<photoset id="72157614840512195" primary="3335339224" owner="35994246@N03" ownername="Jérôme Cohonner" page="1" per_page="10" perpage="10" pages="10" total="98">
    <photo id="3335339224" secret="877f5989a9" server="3578" farm="4" title="groupe I 01" isprimary="1" iconserver="3298" iconfarm="4" />
    <photo id="3334503767" secret="b48707cfb3" server="3401" farm="4" title="groupe I 02" isprimary="0" iconserver="3298" iconfarm="4" />
    <photo id="3335122045" secret="d6950fa410" server="3318" farm="4" title="DSCF0012" isprimary="0" iconserver="3298" iconfarm="4" />
    <photo id="3335122635" secret="719a6c28f7" server="3353" farm="4" title="DSCF0015" isprimary="0" iconserver="3298" iconfarm="4" />
    <photo id="3335123167" secret="abb3188dc0" server="3551" farm="4" title="fabrice et guillaume" isprimary="0" iconserver="3298" iconfarm="4" />
    <photo id="3335123605" secret="66ffbd4015" server="3319" farm="4" title="jerome au magnéto" isprimary="0" iconserver="3298" iconfarm="4" />
    <photo id="3335123851" secret="fde56bd640" server="3381" farm="4" title="jerome au magnétobis" isprimary="0" iconserver="3298" iconfarm="4" />
    <photo id="3335124053" secret="a0fcaf8e00" server="3538" farm="4" title="jerome et guillaume" isprimary="0" iconserver="3298" iconfarm="4" />
    <photo id="3335124457" secret="57a5bc547b" server="3319" farm="4" title="Maïwenn face" isprimary="0" iconserver="3298" iconfarm="4" />
    <photo id="3335124681" secret="ac8acaacff" server="3633" farm="4" title="olivier et sylvain" isprimary="0" iconserver="3298" iconfarm="4" />
</photoset>
</rsp>



*/
?>