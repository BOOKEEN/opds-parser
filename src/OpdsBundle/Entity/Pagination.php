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
    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }

    /**
     * @param int $itemsPerPage
     */
    public function setItemsPerPage($itemsPerPage)
    {
        $this->itemsPerPage = $itemsPerPage;
    }

    /**
     * @return int
     */
    public function getNumberOfItem()
    {
        return $this->numberOfItem;
    }

    /**
     * @param int $numberOfItem
     */
    public function setNumberOfItem($numberOfItem)
    {
        $this->numberOfItem = $numberOfItem;
    }

}
