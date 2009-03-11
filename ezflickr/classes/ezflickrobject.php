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

    var $type;
}

?>