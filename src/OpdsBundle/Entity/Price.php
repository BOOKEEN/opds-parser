<?php

namespace OpdsBundle\Entity;

class Price
{
    /**
     * @var string 
     */
    private $currency;

    /**
     * @var string 
     */
    private $price;
    
    private $format;
    
    function getFormat()
    {
        return $this->format;
    }

    function setFormat($format)
    {
        $this->format = $format;
    }

    
    /**
     * @var array 
     */
//    private $propertieList = array();

    /**
     * @return string
     */
    function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @return string
     */
    function getPrice()
    {
        return $this->price;
    }

    /**
     * @return array
     */
//    function getPropertieList()
//    {
//        return $this->propertieList;
//    }

    /**
     * @param string $currency
     */
    function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * @param string $price
     */
    function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @param array $propertieList
     */
//    function setPropertieList($propertieList)
//    {
//        $this->propertieList = $propertieList;
//    }

}
