<?php

namespace OpdsBundle\Entity;

class OpdsMetadata
{
    /**
     * @var string
     */
    private $itemsPerPage;

    /**
     * @var \DateTime
     */
    private $modified;

    /**
     * @var string
     */
    private $numberOfItem;

    /**
     * @return string
     */
    function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }

    /**
     * @return \DateTime
     */
    function getModified()
    {
        return $this->modified;
    }

    /**
     * @return string
     */
    function getNumberOfItem()
    {
        return $this->numberOfItem;
    }

    /**
     * @param string $itemsPerPage
     */
    function setItemsPerPage($itemsPerPage)
    {
        $this->itemsPerPage = $itemsPerPage;
    }

    /**
     * @param \DateTime $modified
     */
    function setModified(\DateTime $modified)
    {
        $this->modified = $modified;
    }

    /**
     * @param string $numberOfItem
     */
    function setNumberOfItem($numberOfItem)
    {
        $this->numberOfItem = $numberOfItem;
    }

}
