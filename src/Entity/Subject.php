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
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getScheme()
    {
        return $this->scheme;
    }

    /**
     * 
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * 
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * 
     * @param string $scheme
     */
    public function setScheme($scheme)
    {
        $this->scheme = $scheme;
    }

}