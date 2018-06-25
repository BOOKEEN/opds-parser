<?php

namespace OpdsBundle\Entity;

class Borrow
{
    /**
     * @var string 
     */
    private $identifier;

    /**
     * @var string 
     */
    private $format;

    /**
     * @var string 
     */
    private $protection;

    /**
     * @var string 
     */
    private $url;

    /**
     * @var \DateTime
     */
    private $unavailableUntil;

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @return string
     */
    public function getProtection()
    {
        return $this->protection;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return \DateTime
     */
    public function getUnavailableUntil()
    {
        return $this->unavailableUntil;
    }

    /**
     * @param string $identifier
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * @param string $format
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }

    /**
     * @param string $protection
     */
    public function setProtection($protection)
    {
        $this->protection = $protection;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @param \DateTime $unavailableUntil
     */
    public function setUnavailableUntil(\DateTime $unavailableUntil)
    {
        $this->unavailableUntil = $unavailableUntil;
    }

}