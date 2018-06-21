<?php

namespace OpdsBundle\Entity;

class Navigation extends Link
{
    private $updatedAt;
    private $id;
    private $content;
    
    function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    function getId()
    {
        return $this->id;
    }

    function getContent()
    {
        return $this->content;
    }

    function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function setContent($content)
    {
        $this->content = $content;
    }


}
