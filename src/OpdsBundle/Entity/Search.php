<?php
namespace OpdsBundle\Entity;

class Search
{
    const TYPE_WEB = 'text/html';
    const TYPE_ATOM = 'application/atom+xml';
    const TYPE_ATOM_ACQUISITION = 'application/atom+xml;profile=opds-catalog;kind=acquisition';
    const TYPE_JSON = 'application/x-suggestions+json';
    const TYPE_XML = 'application/x-suggestions+xml';
    
    private $type;
    private $template;
    private $rel;
    
    function getType()
    {
        return $this->type;
    }

    function getTemplate()
    {
        return $this->template;
    }

    function getRel()
    {
        return $this->rel;
    }

    function setType($type)
    {
        $this->type = $type;
    }

    function setTemplate($template)
    {
        $this->template = $template;
    }

    function setRel($rel)
    {
        $this->rel = $rel;
    }


    
    
}
