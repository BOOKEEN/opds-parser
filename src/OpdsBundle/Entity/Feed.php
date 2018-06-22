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
    private $updatedAt;

    /**
     * @var Navigation[]
     */
    private $navigationList = array();

    /**
     * @var Pagination
     */
    private $pagination;

    /**
     * @var string
     */
    private $title;
    
    /**
     * @var Link[]
     */
    private $collectionLinkList = array();
    
    /**
     * @var Publication
     */
    private $collectionPublicationList = array();
    
    /**
     *
     * @var Link[]
     */
    private $menuList = array();
    private $sortList = array(); //@TODO
    
    /**
     * Liste de Facet regroupées par nom de group
     *
     * @var array
     */
    private $facetList = array();
    /**
     * @var Publication[]
     */
    private $publicationList = array(); //@TODO
    
    function getCollectionLinkList()
    {
        return $this->collectionLinkList;
    }

    function getCollectionPublicationList()
    {
        return $this->collectionPublicationList;
    }

    function setCollectionLinkList($collectionLinkList)
    {
        $this->collectionLinkList = $collectionLinkList;
    }
    
    function addCollectionLink(Link $link)
    {
        $this->collectionLinkList[] = $link;
    }

    function setCollectionPublicationList($collectionPublicationList)
    {
        $this->collectionPublicationList = $collectionPublicationList;
    }
    
     function addCollectionPublicationList(Publication $publication)
    {
        $this->collectionPublicationList[] = $publication;
    }

        
    function getFacetList()
    {
        return $this->facetList;
    }

    function setFacetList($facetList)
    {
        $this->facetList = $facetList;
    }
    
    function addFacet(Facet $facet, $groupName)
    {
        $this->facetList[$groupName][] = $facet;
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
    
    function addMenu(Link $menu)
    {
        $this->menuList[] = $menu;
    }

    function setSortList($sortList)
    {
        $this->sortList = $sortList;
    }
    
    function addSort(Link $sort)
    {
        $this->sortList[] = $sort;
    }

        
    /**
     * @return Link[]
     */
    function getLinkList()
    {
        return $this->linkList;
    }

    /**
     * @return Pagination
     */
    function getPagination()
    {
        return $this->pagination;
    }

    /**
     * @return \DateTime
     */
    function getUpdatedAt()
    {
        return $this->updatedAt;
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
     * @param Pagination|null $pagination
     */
    function setPagination($pagination)
    {
        $this->pagination = $pagination;
    }

    /**
     * @param \DateTime $updatedAt
     */
    function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
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
