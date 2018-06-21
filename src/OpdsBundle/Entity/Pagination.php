<?php

namespace OpdsBundle\Entity;

class Pagination
{
    /**
     * @var int
     */
    private $itemsPerPage;

    /**
     * @var int
     */
    private $numberOfItem;

    /**
     * @return int
     */
    function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }

    /**
     * @return int
     */
    function getNumberOfItem()
    {
        return $this->numberOfItem;
    }

    /**
     * @param int $itemsPerPage
     */
    function setItemsPerPage($itemsPerPage)
    {
        $this->itemsPerPage = $itemsPerPage;
    }

    /**
     * @param int $numberOfItem
     */
    function setNumberOfItem($numberOfItem)
    {
        $this->numberOfItem = $numberOfItem;
    }

}
