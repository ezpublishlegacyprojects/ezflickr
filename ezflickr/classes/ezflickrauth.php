<?php


class eZFlickrAuth {

    function eZFlickrAuth($flickAuthArray=array())
    {
        if (isset($flickAuthArray["token"]))
        {
            $this->Token=$flickAuthArray["token"]["_content"];
        }

        if (isset($flickAuthArray["perms"]))
        {
            $this->Perms=$flickAuthArray["perms"]["_content"];
        }
        if (isset($flickAuthArray["user"]))
        {
            $this->UserNSID=$flickAuthArray["user"]["nsid"];
            $this->UserName=$flickAuthArray["user"]["username"];
            $this->UserFullName=$flickAuthArray["user"]["fullname"];
        }

    }

    function attributes()
    {
        return array('token','perms','nsid','username','fullname');
    }

    function hasAttribute($name)
    {
        return in_array($name,$this->attributes());
    }

    function attribute($name)
    {
        switch ($name)
        {
            case "token":
                return $this->Token;
            case "perms":
                return $this->Perms;
            case "nsid":
                return $this->UserNSID;
            case "username":
                return $this->Username;
            case "fullname":
                return $this->UserFullName;
        }
    }


    var $Token;
    var $Perms;
    var $UserName;
    var $UserFullName;
    var $UserNSID;
}


/*
array(2) {
  ["auth"]=>
  array(3) {
    ["token"]=>
    array(1) {
      ["_content"]=>
      string(34) "72157614948088847-7b548e31a1c4f3c9"
    }
    ["perms"]=>
    array(1) {
      ["_content"]=>
      string(4) "read"
    }
    ["user"]=>
    array(3) {
      ["nsid"]=>
      string(12) "35994246@N03"
      ["username"]=>
      string(17) "Jérôme Cohonner"
      ["fullname"]=>
      string(0) ""
    }
  }
  ["stat"]=>
  string(2) "ok"
}
 */
?>