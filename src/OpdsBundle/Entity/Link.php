<?php

namespace OpdsBundle\Entity;

class Link
{
    /**
     * @var string
     */
    private $href;

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
    public function getHref()
    {
        return $this->href;
    }

    /**
     * @return string
     */
    public function getRel()
    {
        return $this->rel;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getTypeLink()
    {
        return $this->typeLink;
    }

    /**
     * @param string $href
     */
    public function setHref($href)
    {
        $this->href = $href;
    }

    /**
     * 
     * @param string $rel
     */
    public function setRel($rel)
    {
        $this->rel = $rel;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param string $typeLink
     */
    public function setTypeLink($typeLink)
    {
        $this->typeLink = $typeLink;
    }

}
