<?php

namespace OpdsBundle\Entity;

class Metadata
{
    /**
     * EAN papier
     * @var type 
     */
    private $source;
    
    private $numberPages;
    private $fileSize;
    
    /**
     * @var \DateTime
     */
    private $issuedAt;
    
    /**
     * @var Price[]
     */
    private $priceList;
    
    /**
     *
     * @var Borrow[]
     */
    private $borrowList;
    
    function getIssuedAt()
    {
        return $this->issuedAt;
    }

    function setIssuedAt(\DateTime $issuedAt)
    {
        $this->issuedAt = $issuedAt;
    }

        function getSource()
    {
        return $this->source;
    }

    function setSource($source)
    {
        $this->source = $source;
    }
    
    function getPriceList()
    {
        return $this->priceList;
    }

    function setPriceList(array $priceList)
    {
        $this->priceList = $priceList;
    }
    
    function addPrice(Price $price)
    {
        $this->priceList[] = $price;
    }

    function getBorrowList()
    {
        return $this->borrowList;
    }

    function setBorrowList(array $borrowList)
    {
        $this->borrowList = $borrowList;
    }
    
    function addBorrow(Borrow $borrow)
    {
        $this->borrowList[] = $borrow;
    }

        
    function getNumberPages()
    {
        return $this->numberPages;
    }

    function getFileSize()
    {
        return $this->fileSize;
    }

    function setNumberPages($numberPages)
    {
        $this->numberPages = $numberPages;
    }

    function setFileSize($fileSize)
    {
        $this->fileSize = $fileSize;
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
     * Extent non déterminé
     *
     * @var  string
     */
//    private $extent;

    /**
     * EAN numérique
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
    private $updatedAt;

    /**
     * @var DateTime
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
//    function getExtent()
//    {
//        return $this->extent;
//    }

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
    function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return DateTime
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
//    function setExtent($extent)
//    {
//        $this->extent = $extent;
//    }

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
     * @param \DateTime $updatedAt
     */
    function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @param \DateTime $publicationDate
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
