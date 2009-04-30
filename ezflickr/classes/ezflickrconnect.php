<?php


class eZFlickrConnect {

    //URLS
    const URL_SERVICE                   ="http://www.flickr.com/services/rest/";
    const URL_AUTH                      ="http://www.flickr.com/services/auth/";

    //Flickr Methods Auth
    const METHOD_AUTH_CHECKTOKEN        = "flickr.auth.checkToken";
    const METHOD_AUTH_GETFROB           = "flickr.auth.getFrob";
    const METHOD_AUTH_GETFULLTOKEN      = "flickr.auth.getFullToken";
    const METHOD_AUTH_GETTOKEN          = "flickr.auth.getToken";

    //Flickr Methods Photoset
    const METHOD_PHOTOSETS_GETCONTECT   = "flickr.photosets.getContext";
    const METHOD_PHOTOSETS_GETINFO      = "flickr.photosets.getInfo";
    const METHOD_PHOTOSETS_GETLIST      = "flickr.photosets.getList";
    const METHOD_PHOTOSETS_GETPHOTOS    = "flickr.photosets.getPhotos";

    //Flickr Methods Persons
    const METHOD_PERSON_GETINFO         = "flickr.people.getInfo";

    //Flickr Methods Photos
    const METHOD_PHOTOS_GETINFO         = "flickr.photos.getInfo";
    const METHOD_PHOTOS_GETSIZES         = "flickr.photos.getSizes";
    const METHOD_PHOTOS_GETRECENT       = "flickr.photos.getRecent";
    const METHOD_PHOTOS_RECENTLYUPDATED = "flickr.photos.recentlyUpdated";

    //constant for token prefence (eZPreference)
    const PREF_TOKEN                    = "ezflickr_token";

    /**
     * constructor
     *
     * @param eZModule $Module
     * @return eZFlickrConnect
     */
    function eZFlickrConnect(){
        $this->EZFlickrINI = eZINI::instance( 'ezflickr.ini' );
        $this->APIKey = $this->EZFlickrINI->variable('flickr','APIKey');
        $this->APISecret = $this->EZFlickrINI->variable('flickr','APISecret');
        $this->Module= & $GLOBALS['eZRequestedModule'];
        //Try to connect
        $this->connect();
    }

    /**
     * return current eZFlickConnect instance
     *
     * @param eZModule $Module
     * @return eZFlickrConnect
     */
    static function instance($connectionProcess=false)
    {
        static $instance=false;
        /*if (!$instance && !$Module) {
            throw new eZFlickrException('you need to create instance with $module (eZFlickrConnect($Params[Module])) parameter before using flick functions');
        }
        if ($Module)
        {
            $instance = new eZFlickrConnect($Module);
        }*/
        if (!$instance)
        {
            $instance = new eZFlickrConnect($Module);
        }

        if ($instance->connectionRequired() && !$connectionProcess)
        {
            throw new eZFlickrConnectionRequiredException();
        }

        return $instance;
    }


    /**
     * call a flickr API method
     *
     * @param strong $method method name
     * @param array $params method parameters (without method name, format, api key)
     * @return array
     */
    function callMethod($method,$params=array(),$anonymous=false)
    {
        $returnTab=array();
        if (!$this->connectionRequired || $anonymous)
        {
            $params["method"]=$method;
            $params["format"]="php_serial";
            if (!$anonymous) {
                $params["auth_token"]=$this->getToken();
            }

            $url = $this->getSignedUrl($params);
            $returnValue = file_get_contents($url);
            $returnTab = unserialize($returnValue);
            //Test $returnTab["stat"]=fail -- $returnTab["message"] && code
        }
        return $returnTab;
    }


    /**
     * return a signed URL using API Key and Secret
     *
     * @param array $params request params
     * @param boolean $auth if true the athentification URL will be used instead of service
     * @return string
     */
    function getSignedUrl($params,$auth=false)
    {
        $params["api_key"] = $this->APIKey;
        $params["api_sig"] = $this->signRequest($params);

        $pairs =  array();
        foreach($params as $key => $value){
            $pairs[] = urlencode($key).'='.urlencode($value);
        }

        return ($auth?self::URL_AUTH:self::URL_SERVICE).'?'.implode('&', $pairs);
    }



    /**
     * Sign params string using API secret
     *
     * @param array $params
     * @return sign code
     */
    function signRequest($params){
        ksort($params);
        $qstring = '';
        foreach($params as $key => $value){
            $qstring .= $key . $value;
        }
        return md5($this->APISecret.$qstring);
    }

    /**
     * return authetification token
     *
     */
    function connect()
    {
        $ezhttp = new eZHttpTool();
        if ($ezhttp->hasSessionVariable("ezflickrfrob"))
        {
            //Second part of authetification : we have frob information, we try to get authToken
            $result = $this->callMethod(self::METHOD_AUTH_GETTOKEN,array("frob"=>$ezhttp->sessionVariable("ezflickrfrob")),true);

            //remove frob from session
            $ezhttp->removeSessionVariable("ezflickrfrob");

            if (isset($result["auth"]))
            {
                $this->setFlickrAuth(new eZFlickrAuth($result["auth"]));
            } else {
                //we still don't have the authentification
            }

        }

        //We don't have flick authetification, we test token stored in user preferences
        if (!$this->getFlickrAuth())
        {
            //Try to get token from eZPreference
            $prefToken = eZPreferences::value(eZFlickrConnect::PREF_TOKEN);

            if ($prefToken) {
                $params=array("auth_token"=>$prefToken);
                $result = $this->callMethod(self::METHOD_AUTH_CHECKTOKEN,$params,true);

                if (isset($result["auth"]))
                {
                    $this->setFlickrAuth(new eZFlickrAuth($result["auth"]));
                } else {
                    eZPreferences::setValue(eZFlickrConnect::PREF_TOKEN,false);
                }
            }
        }

        //if we still don't have auth, redirect to flickr connection
        if (!$this->getFlickrAuth())
        {
            //connect user
            if (eZModule::currentModule()!="flickr" || eZModule::currentView()!="connect") {
                $this->Module->redirectTo("flickr/connect");
            }
        } else {
            $this->connectionRequired=false;
        }
    }

    /**
     * return the authentification URL for connection
     *
     * @return string URL
     */
    function getAuthetificationURL()
    {
        //Get a new frob
        $callResult = $this->callMethod(self::METHOD_AUTH_GETFROB,array(),true);

        if (!isset($callResult["frob"])) {
            throw new eZFlickrException();
        }

        $frob = $callResult["frob"]["_content"];
        $ezhttp = new eZHttpTool();
        $ezhttp->setSessionVariable('ezflickrfrob',$frob);
        return $this->getSignedUrl(array('perms'=>'read','frob'=>$frob),true);
    }

    /**
     * return eZFlickrAuth if we have it in class
     * or in session
     *
     * @return mixed eZFlickrAuth or false
     */
    function getFlickrAuth()
    {
        if (!$this->FlickrAuth)
        {
            $http = new eZHttpTool();
            $http->hasSessionVariable("ezflickr_auth");
            $this->FlickrAuth = unserialize($http->sessionVariable("ezflickr_auth"));
        }

        return $this->FlickrAuth;
    }

    /**
     * set eZFlickrAuth in session
     *
     * @param eZFlickrAuth
     */
    function setFlickrAuth(eZFlickrAuth $auth)
    {
        //class
        $this->FlickrAuth = $auth;
        //session
        $http = new eZHttpTool();
        $http->removeSessionVariable("ezflickr_auth");
        $http->setSessionVariable("ezflickr_auth",serialize($auth));
    }

    /**
     * return current logged in nsid
     *
     * @return string
     */
    function userID()
    {
        $auth = $this->getFlickrAuth();
        return $auth->attribute("nsid");
    }

    /**
     * return current logged in nsid
     *
     * @return string
     */
    function getToken()
    {
        $auth = $this->getFlickrAuth();
        return $auth->attribute("token");
    }

    /**
     * return true if we need to connect (redirect will be done)
     * @return boolean
     */
    function connectionRequired() {
        return $this->connectionRequired;
    }

    var $EZFlickrINI;
    var $APIKey;
    var $APISecret;
    var $FlickrAuth=false;
    var $Module;
    var $connectionRequired=true;
}




?>