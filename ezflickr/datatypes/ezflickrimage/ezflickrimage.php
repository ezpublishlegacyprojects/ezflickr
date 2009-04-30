<?php
/*!
 \class   eZFlickrImage ezflickrimage.php
 \brief   Handles the content for ezflickrimage datatype

 \version 1.0
 \date    Samedi 04 Avril 2009 10:25:00
 \author  Administrator User
 */

class eZFlickrImage
{

    function eZFlickrImage()
    {
        $this->IsValid=false;
    }

    function initializeFromeZFlickrPhoto(eZFlickrPhoto $photo)
    {
        $this->IsValid          = true;
        $this->ID               = $photo->attribute("id");
        $this->Secret           = $photo->attribute("secret");
        $this->OriginalSecret   = $photo->attribute("original_secret");
        $this->Title            = $photo->attribute("title");
        $this->Farm             = $photo->attribute("farm");
        $this->Server           = $photo->attribute("server");
        foreach ($photo->attribute("sizes") as $size)
        {
             $this->Sizes[strtolower($size->attribute('label'))]=$size;
        }
    }

    function hasAttribute($name) {
        return in_array($name,$this->attributes());
    }

    function attributes()
    {
        return array('is_valid','name','id','secret','sizes','server','farm','title','original_secret','preview','biggest_image_url');
    }


    function attribute($name)
    {
        switch ($name)
        {
            case "is_valid":
                return $this->IsValid;
            case "id":
                return $this->ID;
            case "secret":
                return $this->Secret;
            case "original_secret":
                return $this->OriginalSecret;
            case "server":
                return $this->Server;
            case "sizes":
                return $this->Sizes;
            case "farm":
                return $this->Farm;
            case "title":
            case "name":
                return $this->Title;
            case "preview":
                return $this->getPreviewImage();
            case "biggest_image_url":
                return $this->getBiggestImageURL();
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
        foreach ($this->Sizes as $size)
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
        return eZFlickrPhoto::getImageSrc($this->ID,$this->Farm,$this->Server,$this->Secret,'s');
    }

    /**
     * Create XML for database
     *
     * @return string xml to store
     */
    function xmlString() {
        $doc = new eZDOMDocument( 'ezflickrimage' );
        $rootNode = $doc->createElement( 'ezflickrimage' );

        $i=0;

        //Create attributes
        $attributeIsValid           = $doc->createAttribute('is_valid');
        $attributeID                = $doc->createAttribute('id');
        $attributeSecret            = $doc->createAttribute('secret');
        $attributeOriginalSecret    = $doc->createAttribute('original_secret');
        $attributeFarm              = $doc->createAttribute('farm');
        $attributeServer            = $doc->createAttribute('server');
        $attributeTitle             = $doc->createAttribute('title');
        //Set attribute content
        $attributeIsValid->setContent($this->IsValid?1:0);
        $attributeID->setContent($this->ID);
        $attributeSecret->setContent($this->Secret);
        $attributeOriginalSecret->setContent($this->OriginalSecret);
        $attributeFarm->setContent($this->Farm);
        $attributeServer->setContent($this->Server);
        $attributeTitle->setContent($this->Title);
        //Append attributes to root node
        $rootNode->appendAttribute($attributeIsValid);
        $rootNode->appendAttribute($attributeID);
        $rootNode->appendAttribute($attributeSecret);
        $rootNode->appendAttribute($attributeOriginalSecret);
        $rootNode->appendAttribute($attributeFarm);
        $rootNode->appendAttribute($attributeServer);
        $rootNode->appendAttribute($attributeTitle);

        $sizesNode= $doc->createElement('sizes');

        $i=0;
        $nodeSize=array();
        $attributeLabel=array();
        $attributeWidth=array();
        $attributeHeight=array();
        $attributeSource=array();
        $attributeURL=array();

        foreach ($this->Sizes as $size)
        {
            //Create size node
            $nodeSize[$i]= $doc->createElement('size');
            //Create siez node attributes
            $attributeLabel[$i]     = $doc->createAttribute('label');
            $attributeWidth[$i]     = $doc->createAttribute('width');
            $attributeHeight[$i]    = $doc->createAttribute('height');
            $attributeSource[$i]    = $doc->createAttribute('source');
            $attributeURL[$i]       = $doc->createAttribute('url');
            //Add content
            $attributeLabel[$i]->setContent(  $size->attribute('label') );
            $attributeWidth[$i]->setContent(  $size->attribute('width') );
            $attributeHeight[$i]->setContent(  $size->attribute('height') );
            $attributeSource[$i]->setContent(  $size->attribute('source') );
            $attributeURL[$i]->setContent(  $size->attribute('url') );
            //Append attibute to size node
            $nodeSize[$i]->appendAttribute($attributeLabel[$i]);
            $nodeSize[$i]->appendAttribute($attributeWidth[$i]);
            $nodeSize[$i]->appendAttribute($attributeHeight[$i]);
            $nodeSize[$i]->appendAttribute($attributeSource[$i]);
            $nodeSize[$i]->appendAttribute($attributeURL[$i]);

            $sizesNode->appendChild($nodeSize[$i]);
            $i++;
        }
        $rootNode->appendChild($sizesNode);

        $doc->setRoot($rootNode);

        $xml = $doc->toString();
        return $xml;
    }

    /**
     * decode from XML string previously stored in database
     *
     * @param string $xml
     */
    function decodeXML($xmlText) {
        $xml = new eZXML();
        $dom =& $xml->domTree( $xmlText);

        if($dom)
        {
            $imageNode =$dom->elementsByName('ezflickrimage' );

            if ($imageNode)
            {
                $imageNodeAttributes = $imageNode[0]->Attributes();

                foreach ($imageNodeAttributes as $attr)
                {
                    switch ($attr->name()) {
                        case 'id' :
                            $this->ID=$attr->content();
                            break;
                        case 'is_valid' :
                            $this->IsValid=$attr->content()==1;
                            break;
                        case 'secret' :
                            $this->Secret=$attr->content();
                            break;
                        case 'server' :
                            $this->Server=$attr->content();
                            break;
                        case 'farm' :
                            $this->Farm=$attr->content();
                            break;
                        case 'title' :
                            $this->Title=$attr->content();
                            break;
                        case 'original_secret' :
                            $this->OriginalSecret=$attr->content();
                            break;
                        default:
                            //nothing
                    }
                }

                $sizeNodes = $dom->elementsByName('size' );

                if ($sizeNodes)
                {
                    foreach ($sizeNodes as $node)
                    {
                        $attributes = $node->Attributes();
                        $sizeRow=array();
                        foreach ($attributes as $attr)
                        {
                            switch ($attr->name()) {
                                case 'label' :
                                    $sizeRow['label']=$attr->content();
                                    break;
                                case 'height' :
                                    $sizeRow['height']=$attr->content();
                                    break;
                                case 'width' :
                                    $sizeRow['width']=$attr->content();
                                    break;
                                case 'source' :
                                    $sizeRow['source']=$attr->content();
                                    break;
                                case 'url' :
                                    $sizeRow['url']=$attr->content();
                                    break;
                                default:
                                    //nothing
                            }
                        }
                        $this->Sizes[strtolower($sizeRow['label'])]=new eZFlickrPhotoSize($sizeRow);
                    }
                }
            }
        }

    }



    var $IsValid=false;
    var $ID;
    var $Secret;
    var $OriginalSecret;
    var $Server;
    var $Farm;
    var $Title;
    var $Sizes=array();
}

?>