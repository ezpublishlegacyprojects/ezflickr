<?php


class eZFlickrSelection extends eZPersistentObject
{
    /**
     * constructor
     *
     * @param array $row database row
     * @return ezFlickrSelection
     */
    function ezFlickrSelection( $row )
    {
        $this->eZPersistentObject( $row );
    }

    static function definition()
    {
        return array( "fields" => array( "id" => array( 'name' => 'ID',
                                                        'datatype' => 'integer',
                                                        'default' => 0,
                                                        'required' => true ),
                                         "flickr_id" => array( 'name' => "FlickrID",
                                                                'datatype' => 'string',
                                                                'default' => '',
                                                                'required' => true),
                                         "user_id" => array( 'name' => "UserID",
                                                              'datatype' => 'integer',
                                                              'default' => 0,
                                                              'required' => true,
                                                              'foreign_class' => 'eZUser',
                                                              'foreign_attribute' => 'contentobject_id',
                                                              'multiplicity' => '1..*'),
                                         ),
                      "keys" => array( "id" ),
                      "function_attributes" => array( "flickr_element" => "flickrElement" ),
                      "increment_key" => "id",
                      "class_name" => "ezFlickrSelection",
                      "sort" => array( "id" => "asc" ),
                      "name" => "ezflickrselection" );

    }

    /**
     * Returns an eZFlickrSelection
     *
     * @param integer $ID
     * @return eZFlickrSelection
     */
    static function fetch($ID)
    {
        return eZPersistentObject::fetchObject( self::definition(), null, array("id"=>$ID));
    }

    /**
     * Returns all selection for current User
     *
     * @return array
     */
    static function fetchCurrentUserSelection($limit=null,$offset=null)
    {
        return eZPersistentObject::fetchObjectList( self::definition(),
                                                    null,
                                                    array("user_id"=>eZUser::currentUserID()),
                                                    null,
                                                    array("limit"=>$limit,"offset"=>$offset));
    }

    /**
     * Returns count of selection for current User
     *
     * @return interger
     */
    static function fetchCurrentUserSelectionCount()
    {
        $userID = eZUser::currentUserID();
        return eZPersistentObject::count( self::definition(),
                                          array("user_id"=>$userID));
    }

    /**
     * Returns flickr element
     *
     * @return eZFlickrElement (eZFlickrPhoto, eZFlickrVideo or eZFlickrPhotoset)
     */
    function flickrElement()
    {
        if (!$this->FlickrElement) {
            list($flickrType,$ID) = explode("_",$this->FlickrID);

            $className = eZFlickrObject::getClassNameForType($flickrType);
            if (!$className) {
                return false;
            }

            //could be changed later to $className::fetch($ID) but PHP > 5.3.0 only
            $this->FlickrElement = call_user_func(array($className, 'fetch'),$ID);
        }

        return $this->FlickrElement;
    }


    /**
     * Remove one flickrObject from selection
     *
     * @param interger Id to remove form selection
     */
    static function removeByID($id)
    {
        $db=eZDB::instance();
        $db->query('delete from ezflickrselection where id='.$id);
    }



    var $ID;
    var $UserID;
    var $FlickrID;
    var $FlickrElement=false;
}

?>