<?php

namespace OpdsBundle\Entity;

class Contributor
{
    /**
     * @var Link[]
     */
    private $linkList = array();

    /**
     * @var string
     */
    private $name;

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
     * @param Link $link
     */
    function addLink(Link $link)
    {
        $this->linkList[] = $link;
    }

    /**
     * 
     * @return string
     */
    function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    function setName($name)
    {
        $this->name = $name;
    }

}
