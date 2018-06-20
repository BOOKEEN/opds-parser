<?php

namespace OpdsBundle\Entity;

class Feed
{
    /**
     * @var Link[]
     */
    private $linkList = array();

    /**
     * @var OpdsMetadata
     */
    private $metadata;

    /**
     * @var Link[]
     */
    private $navigationList = array();

    /**
     * @var string
     */
    private $title;

    /**
     * @return Link[]
     */
    function getLinkList()
    {
        return $this->linkList;
    }

    /**
     * @return OpdsMetadata
     */
    function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @return Link[]
     */
    function getNavigationList()
    {
        return $this->navigationList;
    }

    /**
     * @return string
     */
    function getTitle()
    {
        return $this->title;
    }

    /**
     * @param Link[] $linkList
     */
    function setLinkList(array $linkList)
    {
        $this->linkList = $linkList;
    }

    /**
     * @param OpdsMetadata $metadata
     */
    function setMetadata(OpdsMetadata $metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * @param Link[] $navigationList
     */
    function setNavigationList(array $navigationList)
    {
        $this->navigationList = $navigationList;
    }

    /**
     * @param string $title
     */
    function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param Link $link
     */
    function addNavigation(Link $link)
    {
        $this->navigationList[] = $link;
    }

    /**
     * @param Link $link
     */
    function addLink(Link $link)
    {
        $this->linkList[] = $link;
    }

}
