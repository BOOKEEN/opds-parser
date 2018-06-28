<?php

namespace OpdsBundle\Entity;

class Feed
{
    /**
     * @var Link[]
     */
    private $linkList = array();

    /**
     * @var Navigation[]
     */
    private $navigationList = array();

    /**
     * @var Link[]
     */
    private $collectionLinkList = array();

    /**
     * @var Publication[]
     */
    private $collectionPublicationList = array();

    /**
     * Liste de Facet regroupées par nom de group
     *
     * @var array
     */
    private $facetList = array();

    /**
     * @var Link[]
     */
    private $menuList = array();

    /**
     * @var Pagination
     */
    private $pagination;

    /**
     * @var Link[]
     */
    private $sortList = array();

    /**
     * @var string
     */
    private $title;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var Publication[]
     */
    private $publicationList = array();

    /**
     * @return Link[]
     */
    public function getCollectionLinkList()
    {
        return $this->collectionLinkList;
    }

    /**
     * @return Publication[]
     */
    public function getCollectionPublicationList()
    {
        return $this->collectionPublicationList;
    }

    /**
     * @param Link[] $collectionLinkList
     */
    public function setCollectionLinkList($collectionLinkList)
    {
        $this->collectionLinkList = $collectionLinkList;
    }

    /**
     * @param Link $link
     */
    public function addCollectionLink(Link $link)
    {
        $this->collectionLinkList[] = $link;
    }

    /**
     * 
     * @param Publication[] $collectionPublicationList
     */
    public function setCollectionPublicationList(array $collectionPublicationList)
    {
        $this->collectionPublicationList = $collectionPublicationList;
    }

    /**
     * @param Publication $publication
     */
    public function addCollectionPublicationList(Publication $publication)
    {
        $this->collectionPublicationList[] = $publication;
    }

    /**
     * @return array
     */
    public function getFacetList()
    {
        return $this->facetList;
    }

    /**
     * @param array $facetList
     */
    public function setFacetList(array $facetList)
    {
        $this->facetList = $facetList;
    }

    /**
     * @param Facet $facet
     * @param string $groupName
     */
    public function addFacet(Facet $facet, $groupName)
    {
        $this->facetList[$groupName][] = $facet;
    }

    /**
     * @return Publication[]
     */
    public function getPublicationList()
    {
        return $this->publicationList;
    }

    /**
     * @param Publication[] $publicationList
     */
    public function setPublicationList(array $publicationList)
    {
        $this->publicationList = $publicationList;
    }

    /**
     * @param Publication $publication
     */
    public function addPublication(Publication $publication)
    {
        $this->publicationList[] = $publication;
    }

    /**
     * @return Link[]
     */
    public function getMenuList()
    {
        return $this->menuList;
    }

    /**
     * @return Link[]
     */
    public function getSortList()
    {
        return $this->sortList;
    }

    /**
     * @param Link[] $menuList
     */
    public function setMenuList(array $menuList)
    {
        $this->menuList = $menuList;
    }

    /**
     * @param Link $menu
     */
    public function addMenu(Link $menu)
    {
        $this->menuList[] = $menu;
    }

    /**
     * @param Link[] $sortList
     */
    public function setSortList(array $sortList)
    {
        $this->sortList = $sortList;
    }

    public function addSort(Link $sort)
    {
        $this->sortList[] = $sort;
    }

    /**
     * @return Link[]
     */
    public function getLinkList()
    {
        return $this->linkList;
    }

    /**
     * @return Pagination
     */
    public function getPagination()
    {
        return $this->pagination;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return Link[]
     */
    public function getNavigationList()
    {
        return $this->navigationList;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param Link[] $linkList
     */
    public function setLinkList(array $linkList)
    {
        $this->linkList = $linkList;
    }

    /**
     * @param Pagination|null $pagination
     */
    public function setPagination($pagination)
    {
        $this->pagination = $pagination;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @param Link[] $navigationList
     */
    public function setNavigationList(array $navigationList)
    {
        $this->navigationList = $navigationList;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param Link $link
     */
    public function addNavigation(Link $link)
    {
        $this->navigationList[] = $link;
    }

    /**
     * @param Link $link
     */
    public function addLink(Link $link)
    {
        $this->linkList[] = $link;
    }

}