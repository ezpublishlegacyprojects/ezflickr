<?php


class eZFlickrPhoto extends eZFlickrObject {

    const TYPE="photo";

    function eZFlickrPhoto($row)
    {
        $this->ID=$row["id"];
        $this->Secret=$row["secret"];
        $this->Server=$row["server"];
        $this->Farm=$row["farm"];
        $this->Title=$row["title"];
        $this->OriginalSecret=isset($row["originalsecret"])?$row["originalsecret"]:false;
        parent::eZFlickrObject(self::TYPE);
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
        $params["extras"]="original_format";

        $callResult = $eZFlickrConnect->callMethod(eZFlickrConnect::METHOD_PHOTOSETS_GETPHOTOS,$params);

        if (!isset($callResult["photoset"])) {
            throw new eZFlickrException("Error while calling : ".eZFlickrConnect::METHOD_PHOTOSETS_GETLIST);
        }

        //Get result
        foreach ($callResult["photoset"]["photo"] as $row)
        {
            $photos[] = new eZFlickrPhoto($row);
        }

        $result = array(   'photos'        => $photos,
                            'photo_count'   => $callResult["photoset"]["total"],
                            'perpage'       => $callResult["photoset"]["perpage"],
                            'pages'         => $callResult["photoset"]["pages"],
                            'current_page'  => $callResult["photoset"]["page"]);

        return $result;
    }

    function attributes()
    {
        return array_merge(
                        array('name','id','secret','server','farm','title','url_alias','original_secret','preview'),
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
                return self::TYPE."_".$this->ID;
            case "preview":
                return $this->getPreviewImage();
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


    var $ID;
    var $Secret;
    var $OriginalSecret;
    var $Server;
    var $Farm;
    var $Title;

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