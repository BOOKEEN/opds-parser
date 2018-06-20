<?php

namespace OpdsBundle\Entity;

class Metadata
{
    private $source;
    
    /**
     * @var Price
     */
    private $price;
    
    function getSource()
    {
        return $this->source;
    }

    function setSource($source)
    {
        $this->source = $source;
    }
    
    function getPrice()
    {
        return $this->price;
    }

    function setPrice(Price $price)
    {
        $this->price = $price;
    }

    
        
    //-----------
    /**
     *
     * @var Contributor[] 
     */
    private $authorList;

    /**
     * @var string
     */
    private $description;

    /**
     * Taille du fichier
     *
     * @var  string
     */
    private $extent;

    /**
     * @var string
     */
    private $identifier;

    /**
     * @var string
     */
    private $language;

    /**
     *
     * @var \DateTime
     */
    private $modified;

    /**
     * @var string
     */
    private $publicationDate;

    /**
     *
     * @var Contributor[] 
     */
    private $publisherList;

    /**
     * @var string
     */
    private $rights;

    /**
     * @var Subject[]
     */
    private $subjectList = array();

    /**
     * @var string
     */
    private $title;

    /**
     * @return string
     */
    function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    function getExtent()
    {
        return $this->extent;
    }

    /**
     * @return string
     */
    function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @return string
     */
    function getLanguage()
    {
        return $this->language;
    }

    /**
     * @return \DateTime
     */
    function getModified()
    {
        return $this->modified;
    }

    /**
     * @return string
     */
    function getPublicationDate()
    {
        return $this->publicationDate;
    }

    /**
     * @return string
     */
    function getRights()
    {
        return $this->rights;
    }

    /**
     * @return Subject[]
     */
    function getSubjectList()
    {
        return $this->subjectList;
    }

    /**
     * @return string
     */
    function getTitle()
    {
        return $this->title;
    }

    /**
     * @return Contributor[]
     */
    function getPublisherList()
    {
        return $this->publisherList;
    }

    /**
     * @return Contributor[]
     */
    function getAuthorList()
    {
        return $this->authorList;
    }

    /**
     * 
     * @param string $description
     */
    function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * 
     * @param string $extent
     */
    function setExtent($extent)
    {
        $this->extent = $extent;
    }

    /**
     * @param string $identifier
     */
    function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * @param string $language
     */
    function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * @param \DateTime $modified
     */
    function setModified(\DateTime $modified)
    {
        $this->modified = $modified;
    }

    /**
     * @param string $publicationDate
     */
    function setPublicationDate($publicationDate)
    {
        $this->publicationDate = $publicationDate;
    }

    /**
     * @param string $rights
     */
    function setRights($rights)
    {
        $this->rights = $rights;
    }

    /**
     * @param Subject[] $subjectList
     */
    function setSubjectList(array $subjectList)
    {
        $this->subjectList = $subjectList;
    }

    /**
     * 
     * @param string $title
     */
    function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param Contributor[] $publisherList
     */
    function setPublisherList(array $publisherList)
    {
        $this->publisherList = $publisherList;
    }

    /**
     * @param Contributor[] $authorList
     */
    function setAuthorList(array $authorList)
    {
        $this->authorList = $authorList;
    }

    /**
     * @param Contributor $publisher
     */
    function addPublisher(Contributor $publisher)
    {
        $this->publisherList[] = $publisher;
    }

    /**
     * @param Subject $subject
     */
    function addSubject(Subject $subject)
    {
        $this->subjectList[] = $subject;
    }

    /**
     * 
     * @param Contributor $author
     */
    function addAuthor(Contributor $author)
    {
        $this->authorList[] = $author;
    }

}
