<?php

namespace OpdsBundle\Entity;

class Publication
{
    
    private $identifier;
    
    function getIdentifier()
    {
        return $this->identifier;
    }

    function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

        
    //-----------
    
    
    /**
     * @var Link[]
     */
    private $imageList = array();

    /**
     * @var Link[]
     */
    private $linkList = array();

    /**
     * @var Metadata
     */
    private $metadata;

    /**
     * @return Link[]
     */
    function getImageList()
    {
        return $this->imageList;
    }

    /**
     * @param Link[] $imageList
     */
    function setImageList(array $imageList)
    {
        $this->imageList = $imageList;
    }

    /**
     * @param Link $image
     */
    function addImage(Link $image)
    {
        $this->imageList[] = $image;
    }

    /**
     * @return Link[]
     */
    function getLinkList()
    {
        return $this->linkList;
    }

    /**
     * @param Link[] $linkList
     */
    function setLinkList(array $linkList)
    {
        $this->linkList = $linkList;
    }

    /**
     * @param Link $image
     */
    function addLink(Link $image)
    {
        $this->linkList[] = $image;
    }

    /**
     * @return Metadata
     */
    function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param Metadata $metadata
     */
    function setMetadata(Metadata $metadata)
    {
        $this->metadata = $metadata;
    }

}
