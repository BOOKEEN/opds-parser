<?php

namespace OpdsBundle\Entity;

class Publication
{
    /**
     * @var string
     */
    private $identifier;

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
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param string $identifier
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * @return Link[]
     */
    public function getImageList()
    {
        return $this->imageList;
    }

    /**
     * @param Link[] $imageList
     */
    public function setImageList(array $imageList)
    {
        $this->imageList = $imageList;
    }

    /**
     * @param Link $image
     */
    public function addImage(Link $image)
    {
        $this->imageList[] = $image;
    }

    /**
     * @return Link[]
     */
    public function getLinkList()
    {
        return $this->linkList;
    }

    /**
     * @param Link[] $linkList
     */
    public function setLinkList(array $linkList)
    {
        $this->linkList = $linkList;
    }

    /**
     * @param Link $image
     */
    public function addLink(Link $image)
    {
        $this->linkList[] = $image;
    }

    /**
     * @return Metadata
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param Metadata $metadata
     */
    public function setMetadata(Metadata $metadata)
    {
        $this->metadata = $metadata;
    }

}