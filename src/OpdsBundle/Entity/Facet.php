<?php

namespace OpdsBundle\Entity;

class Facet extends Link
{
    private $numberOfItems;
    private $isActiveFacet = false;
    private $groupName;

    function getNumberOfItems()
    {
        return $this->numberOfItems;
    }

    function getIsActiveFacet()
    {
        return $this->isActiveFacet;
    }

    function getGroupName()
    {
        return $this->groupName;
    }

    function setNumberOfItems($numberOfItems)
    {
        $this->numberOfItems = $numberOfItems;
    }

    function setIsActiveFacet($isActiveFacet)
    {
        $this->isActiveFacet = $isActiveFacet;
    }

    function setGroupName($groupName)
    {
        $this->groupName = $groupName;
    }

}
