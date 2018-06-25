<?php

namespace OpdsBundle\Entity;

class Metadata
{
    /**
     * @var Contributor[] 
     */
    private $authorList;

    /**
     * @var Borrow[]
     */
    private $borrowList;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $fileSize;

    /**
     * EAN numérique
     *
     * @var string
     */
    private $identifier;

    /**
     * @var \DateTime
     */
    private $issuedAt;

    /**
     * @var string
     */
    private $language;

    /**
     * @var string
     */
    private $numberPages;

    /**
     * @var Price[]
     */
    private $priceList;

    /**
     * @var \DateTime
     */
    private $publicationDate;

    /**
     * @var Contributor[] 
     */
    private $publisherList;

    /**
     * @var string
     */
    private $rights;

    /**
     * EAN papier
     *
     * @var string 
     */
    private $source;

    /**
     * @var Subject[]
     */
    private $subjectList = array();

    /**
     * @var string
     */
    private $title;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @return Contributor[]
     */
    public function getAuthorList()
    {
        return $this->authorList;
    }

    /**
     * @param Contributor[] $authorList
     */
    public function setAuthorList(array $authorList)
    {
        $this->authorList = $authorList;
    }

    /**
     * @param Contributor $author
     */
    public function addAuthor(Contributor $author)
    {
        $this->authorList[] = $author;
    }

    /**
     * @return Borrow[]
     */
    public function getBorrowList()
    {
        return $this->borrowList;
    }

    /**
     * @param Borrow[] $borrowList
     */
    public function setBorrowList(array $borrowList)
    {
        $this->borrowList = $borrowList;
    }

    /**
     * @param Borrow $borrow
     */
    public function addBorrow(Borrow $borrow)
    {
        $this->borrowList[] = $borrow;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getFileSize()
    {
        return $this->fileSize;
    }

    /**
     * 
     * @param string $fileSize
     */
    public function setFileSize($fileSize)
    {
        $this->fileSize = $fileSize;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param string $identifier
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * @return \DateTime
     */
    public function getIssuedAt()
    {
        return $this->issuedAt;
    }

    /**
     * @param \DateTime $issuedAt
     */
    public function setIssuedAt(\DateTime $issuedAt)
    {
        $this->issuedAt = $issuedAt;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * @return string
     */
    public function getNumberPages()
    {
        return $this->numberPages;
    }

    /**
     * @param string $numberPages
     */
    public function setNumberPages($numberPages)
    {
        $this->numberPages = $numberPages;
    }

    /**
     * @return Price[]
     */
    public function getPriceList()
    {
        return $this->priceList;
    }

    /**
     * @param Price[] $priceList
     */
    public function setPriceList(array $priceList)
    {
        $this->priceList = $priceList;
    }

    /**
     * @param Price $price
     */
    public function addPrice(Price $price)
    {
        $this->priceList[] = $price;
    }

    /**
     * @return \DateTime
     */
    public function getPublicationDate()
    {
        return $this->publicationDate;
    }

    /**
     * @param \DateTime $publicationDate
     */
    public function setPublicationDate($publicationDate)
    {
        $this->publicationDate = $publicationDate;
    }

    /**
     * @return Contributor[]
     */
    public function getPublisherList()
    {
        return $this->publisherList;
    }

    /**
     * @param Contributor[] $publisherList
     */
    public function setPublisherList(array $publisherList)
    {
        $this->publisherList = $publisherList;
    }

    /**
     * @param Contributor $publisher
     */
    public function addPublisher(Contributor $publisher)
    {
        $this->publisherList[] = $publisher;
    }

    /**
     * @return string
     */
    public function getRights()
    {
        return $this->rights;
    }

    /**
     * @param string $rights
     */
    public function setRights($rights)
    {
        $this->rights = $rights;
    }

    /**
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param string $source
     */
    public function setSource($source)
    {
        $this->source = $source;
    }

    /**
     * @return Subject[]
     */
    public function getSubjectList()
    {
        return $this->subjectList;
    }

    /**
     * @param Subject[] $subjectList
     */
    public function setSubjectList(array $subjectList)
    {
        $this->subjectList = $subjectList;
    }

    /**
     * @param Subject $subject
     */
    public function addSubject(Subject $subject)
    {
        $this->subjectList[] = $subject;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

}