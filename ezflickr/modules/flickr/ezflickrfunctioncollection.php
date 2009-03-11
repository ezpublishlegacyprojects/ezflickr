<?php

class eZFlickrFunctionCollection {

    function eZFlickrFunctionCollection()
    {

    }

    /**
     * return all photosets
     *
     * @return array of eZFlickrPhotoset
     */
    function fetchPhotosets() {
        return array('result'=>eZFlickrPhotoset::fetchAll());
    }

    /**
     * return all photosets
     *
     * @return array of eZFlickrPhotoset
     */
    function fetchPhotosetPhotos($PhotosetID,$limit=false,$page=0) {
        return array('result'=>eZFlickrPhoto::fetchByPhotoset($PhotosetID,$limit,$page));
    }

    /**
     * return one ezflickr person
     *
     * @return array of eZFlickrPhotoset
     */
    function fetchPerson($nsid) {
        return array('result'=>eZFlickrPerson::fetch($nsid));
    }

    /**
     * return current logged ezflickr person
     *
     * @return array of eZFlickrPhotoset
     */
    function fetchCurrentPerson() {
        return array('result'=>eZFlickrPerson::fetchCurrent());
    }

}

?>