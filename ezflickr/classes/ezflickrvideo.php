<?php


class eZFlickrVideo extends eZFlickrPhoto {

    const TYPE="video";

    function eZFlickrVideo($row)
    {
        $this->ID=$row["id"];
        $this->Secret=$row["secret"];
        $this->Server=$row["server"];
        $this->Farm=$row["farm"];
            if (isset($row["title"]["_content"])) {
            //photos.getInfo case
            $this->Title=$row["title"]["_content"];
        } else {
            //photoset.getPhotos case
            $this->Title=$row["title"];
        }
        $this->OriginalSecret=isset($row["originalsecret"])?$row["originalsecret"]:false;
        $this->eZFlickrObject(self::TYPE);
    }


    function attribute($name)
    {
        switch ($name)
        {
            default:
                return parent::attribute($name);
        }

    }

}

?>