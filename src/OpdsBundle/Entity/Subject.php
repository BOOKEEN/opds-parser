<?php

namespace OpdsBundle\Entity;

class Subject
{
    /**
     * @var string 
     */
    private $code;

    /**
     * @var string 
     */
    private $name;

    /**
     * @var string 
     */
    private $scheme;

    /**
     * @return string
     */
    function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    function getScheme()
    {
        return $this->scheme;
    }

    /**
     * 
     * @param string $code
     */
    function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * 
     * @param string $name
     */
    function setName($name)
    {
        $this->name = $name;
    }

    /**
     * 
     * @param string $scheme
     */
    function setScheme($scheme)
    {
        $this->scheme = $scheme;
    }

}
