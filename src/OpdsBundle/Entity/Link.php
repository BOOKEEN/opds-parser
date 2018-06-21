<?php

namespace OpdsBundle\Entity;

class Link
{
    /**
     * @var string
     */
    private $href;

    /**
     * @var array
     */
    private $propertieList;

    /**
     *
     * @var string
     */
    private $rel;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $typeLink;

    /**
     * @return string
     */
    function getHref()
    {
        return $this->href;
    }

    /**
     * @return array
     */
    function getPropertieList()
    {
        return $this->propertieList;
    }

    /**
     * @return string
     */
    function getRel()
    {
        return $this->rel;
    }

    /**
     * @return string
     */
    function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    function getTypeLink()
    {
        return $this->typeLink;
    }

    /**
     * @param string $href
     */
    function setHref($href)
    {
        $this->href = $href;
    }

    /**
     * @param array $propertieList
     */
    function setPropertieList(array $propertieList)
    {
        $this->propertieList = $propertieList;
    }

    /**
     * 
     * @param string $rel
     */
    function setRel($rel)
    {
        $this->rel = $rel;
    }

    /**
     * @param string $title
     */
    function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param string $typeLink
     */
    function setTypeLink($typeLink)
    {
        $this->typeLink = $typeLink;
    }
    
}
