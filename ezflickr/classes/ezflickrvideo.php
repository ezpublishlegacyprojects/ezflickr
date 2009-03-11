<?php


class eZFlickrVideo extends eZFlickrObject {

    const TYPE="video";

    function eZFlickrVideo($row)
    {
        $this->ID=$row["id"];
        $this->Primary=$row["primary"];
        $this->Secret=$row["secret"];
        $this->Server=$row["server"];
        $this->Farm=$row["farm"];
        $this->PhotoCount=$row["photos"];
        $this->VideoCount=$row["videos"];
        $this->Title=$row["title"]["_content"];
        $this->Description=$row["description"]["_content"];
        parent::eZFlickrObject(self::TYPE);
    }

    static function fetchAll()
    {
        $result = array();

        //Call method
        $eZFlickrConnect = eZFlickrConnect::instance();
        $callResult = $eZFlickrConnect->callMethod(eZFlickrConnect::METHOD_PHOTOSETS_GETLIST);

        if (!isset($callResult["photosets"])) {
            throw new eZFlickrException("Error while calling : ".eZFlickrConnect::METHOD_PHOTOSETS_GETLIST);
        }

        //Get result
        foreach ($callResult["photosets"]["photoset"] as $row)
        {
            $result[] = new eZFlickrPhotoset($row);
        }

        return $result;
    }

    function attributes()
    {
        return array_merge(
                        array('name','id','primary','secret','server','photo_count','farm','title','description','video_count','url_alias'),
                        parent::attributes()
               );
    }


    function attribute($name)
    {
        switch ($name)
        {
            case "id":
                return $this->ID;
            case "primary":
                return $this->Primary;
            case "secret":
                return $this->Secret;
            case "server":
                return $this->Server;
            case "photo_count":
                return $this->PhotoCount;
            case "video_count":
                return $this->VideoCount;
            case "farm":
                return $this->Farm;
            case "title":
            case "name":
                return $this->Title;
            case "description":
                return $this->Description;
            case "url_alias":
                return "flickr/photoset/".$this->ID;
            case "ezflickr_id":
                return self::TYPE."_".$this->ID;
            default:
                return parent::attribute($name);
        }

    }


    var $ID;
    var $Primary;
    var $Secret;
    var $Server;
    var $PhotoCount;
    var $VideoCount;
    var $Farm;
    var $Title;
    var $Description;

}

/*
<photoset id="5" primary="2483" secret="abcdef"
        server="8" photos="4" farm="1">
        <title>Test</title>
        <description>foo</description>
    </photoset>

["photosets"]=>
  array(2) {
    ["photoset"]=>
    array(2) {
      [0]=>
      array(9) {
        ["id"]=>
        string(17) "72157614925214748"
        ["primary"]=>
        string(10) "3335339092"
        ["secret"]=>
        string(10) "ae54eee0be"
        ["server"]=>
        string(4) "3372"
        ["farm"]=>
        float(4)
        ["photos"]=>
        int(1)
        ["videos"]=>
        string(1) "0"
        ["title"]=>
        array(1) {
          ["_content"]=>
          string(7) "Test"
        }
        ["description"]=>
        array(1) {
          ["_content"]=>
          string(0) ""
        }
      }



*/
?>