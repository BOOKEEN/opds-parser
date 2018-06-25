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
     * @param Link $link
     */
    public function addLink(Link $link)
    {
        $this->linkList[] = $link;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

}