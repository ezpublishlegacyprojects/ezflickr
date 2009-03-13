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
    function fetchPhotosets()
    {
        return array('result'=>eZFlickrPhotoset::fetchAll());
    }

    /**
     * return all photosets
     *
     * @return array of eZFlickrPhotoset
     */
    function fetchPhotosetPhotos($PhotosetID,$limit=false,$page=0)
    {
        return array('result'=>eZFlickrPhoto::fetchByPhotoset($PhotosetID,$limit,$page));
    }

    /**
     * return one ezflickr person
     *
     * @return array of eZFlickrPhotoset
     */
    function fetchPerson($nsid)
    {
        return array('result'=>eZFlickrPerson::fetch($nsid));
    }

    /**
     * return current logged ezflickr person
     *
     * @return array of eZFlickrPhotoset
     */
    function fetchCurrentPerson()
    {
        return array('result'=>eZFlickrPerson::fetchCurrent());
    }


    /**
     * return recent uploads
     *
     * @return array of eZFlickrPhoto or eZFlickrVideo
     */
    function fetchRecentPhotos($limit=100,$page=1)
    {
        return array('result'=>eZFlickrPhoto::fetchRecent($limit,$page));
    }

    /**
     * return user eZFlickrSelection elements
     *
     * @param integer $limit limit by page
     * @param integer $offset offset (eZ Publish way)
     * @return array of eZFlickrSelection
     */
    function fetchUserSelection($limit=10,$offset=0)
    {
        $result = array(    'selection'     => eZFlickrSelection::fetchCurrentUserSelection($limit,$offset),
                            'selection_count'   => eZFlickrSelection::fetchCurrentUserSelectionCount());
        return array('result'=>$result);
    }


}

?>