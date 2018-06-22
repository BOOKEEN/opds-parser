<?php

namespace OpdsBundle\Entity;

class Borrow
{
    /**
     * @var string 
     */
    private $identifier;
    
    private $format;
    
    private $protection;
    /**
     *
     * @var \DateTime
     */
    private $unavailableUntil;
    
    function getIdentifier()
    {
        return $this->identifier;
    }

    function getFormat()
    {
        return $this->format;
    }

    function getProtection()
    {
        return $this->protection;
    }

    function getUnavailableUntil()
    {
        return $this->unavailableUntil;
    }

    function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    function setFormat($format)
    {
        $this->format = $format;
    }

    function setProtection($protection)
    {
        $this->protection = $protection;
    }

    function setUnavailableUntil(\DateTime $unavailableUntil)
    {
        $this->unavailableUntil = $unavailableUntil;
    }


}
