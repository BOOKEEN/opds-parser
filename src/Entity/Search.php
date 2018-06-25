<?php

namespace OpdsBundle\Entity;

class Search
{
    const TYPE_WEB = 'text/html';
    const TYPE_ATOM = 'application/atom+xml';
    const TYPE_ATOM_ACQUISITION = 'application/atom+xml;profile=opds-catalog;kind=acquisition';
    const TYPE_JSON = 'application/x-suggestions+json';
    const TYPE_XML = 'application/x-suggestions+xml';

    /**
     * cf self::TYPE_*
     *
     * @var string 
     */
    private $type;

    /**
     * @var string 
     */
    private $template;

    /**
     * @var string 
     */
    private $rel;

    /**
     * @return string
     */
    public function getRel()
    {
        return $this->rel;
    }

    /**
     * @param string $rel
     */
    public function setRel($rel)
    {
        $this->rel = $rel;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

}