<?php

namespace OpdsBundle\Entity;

class Facet extends Link
{
    /**
     * @var int
     */
    private $numberOfItems;

    /**
     * @var bool 
     */
    private $isActiveFacet = false;

    /**
     * @return bool
     */
    public function getIsActiveFacet()
    {
        return $this->isActiveFacet;
    }

    /**
     * @param bool $isActiveFacet
     */
    public function setIsActiveFacet($isActiveFacet)
    {
        $this->isActiveFacet = $isActiveFacet;
    }

    /**
     * @return int
     */
    public function getNumberOfItems()
    {
        return $this->numberOfItems;
    }

    /**
     * @param int $numberOfItems
     */
    public function setNumberOfItems($numberOfItems)
    {
        $this->numberOfItems = $numberOfItems;
    }

}
