<?php

namespace OpdsBundle\Entity;

class Feed
{
    /**
     * @var Link[]
     */
    private $linkList = array();

    /**
     * @var \DateTime
     */
    private $modified;

    /**
     * @var Link[]
     */
    private $navigationList = array();

    /**
     * @var SearchInfo
     */
    private $searchInfo;

    /**
     * @var string
     */
    private $title;
    
    private $collectionList = array(); //@TODO
    private $menuList = array(); //@TODO
    private $sortList = array(); //@TODO
    
    private $facetList = array(); //@TODO
    /**
     * @var Publication[]
     */
    private $publicationList = array(); //@TODO
    
    function getFacetList()
    {
        return $this->facetList;
    }

    function setFacetList($facetList)
    {
        $this->facetList = $facetList;
    }

        function getPublicationList()
    {
        return $this->publicationList;
    }

    function setPublicationList(array $PublicationList)
    {
        $this->publicationList = $PublicationList;
    }
    
    function addPublication(Publication $publication)
    {
        $this->publicationList[] = $publication;
    }

        
    function getCollectionList()
    {
        return $this->collectionList;
    }

    function setCollectionList($collectionList)
    {
        $this->collectionList = $collectionList;
    }

    function getMenuList()
    {
        return $this->menuList;
    }

    function getSortList()
    {
        return $this->sortList;
    }

    function setMenuList($menuList)
    {
        $this->menuList = $menuList;
    }

    function setSortList($sortList)
    {
        $this->sortList = $sortList;
    }

        
    /**
     * @return Link[]
     */
    function getLinkList()
    {
        return $this->linkList;
    }

    /**
     * @return SearchInfo
     */
    function getSearchInfo()
    {
        return $this->searchInfo;
    }

    /**
     * @return \DateTime
     */
    function getModified()
    {
        return $this->modified;
    }

    /**
     * @return Link[]
     */
    function getNavigationList()
    {
        return $this->navigationList;
    }

    /**
     * @return string
     */
    function getTitle()
    {
        return $this->title;
    }

    /**
     * @param Link[] $linkList
     */
    function setLinkList(array $linkList)
    {
        $this->linkList = $linkList;
    }

    /**
     * @param SearchInfo|null $searchInfo
     */
    function setSearchInfo($searchInfo)
    {
        $this->searchInfo = $searchInfo;
    }

    /**
     * @param \DateTime $modified
     */
    function setModified(\DateTime $modified)
    {
        $this->modified = $modified;
    }

    /**
     * @param Link[] $navigationList
     */
    function setNavigationList(array $navigationList)
    {
        $this->navigationList = $navigationList;
    }

    /**
     * @param string $title
     */
    function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param Link $link
     */
    function addNavigation(Link $link)
    {
        $this->navigationList[] = $link;
    }

    /**
     * @param Link $link
     */
    function addLink(Link $link)
    {
        $this->linkList[] = $link;
    }

}
