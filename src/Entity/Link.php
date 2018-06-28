<?php

namespace OpdsBundle\Entity;

/**
 * @see http://opds-spec.org/specs/opds-catalog-1-1-20110627/ pour les constantes
 */
class Link
{
    const REL_S_ALTERNATE = 'alternate';
    const REL_S_NEXT = 'next';
    const REL_S_SEARCH = 'search';
    const REL_S_SELF = 'self';
    const REL_S_START = 'start';
    const REL_U_ACQUISITION = 'http://opds-spec.org/acquisition';
    const REL_U_ACQUISITION_OPEN_ACCESS = 'http://opds-spec.org/acquisition/open-access';
    const REL_U_ACQUISITION_BORROW = 'http://opds-spec.org/acquisition/borrow';
    const REL_U_ACQUISITION_BUY = 'http://opds-spec.org/acquisition/buy';
    const REL_U_ACQUISITION_SAMPLE = 'http://opds-spec.org/acquisition/sample'; // extrait
    const REL_U_ACQUISITION_SUBSCRIBE = 'http://opds-spec.org/acquisition/subscribe';
    const REL_U_CRAWLABLE = 'http://opds-spec.org/crawlable';
    const REL_U_FACET = 'http://opds-spec.org/facet';
    const REL_U_FEATURE = 'http://opds-spec.org/featured';
    const REL_U_GROUP = 'http://opds-spec.org/group';
    const REL_U_IMAGE = 'http://opds-spec.org/image';
    const REL_U_RECOMMENDED = 'http://opds-spec.org/recommended';
    const REL_U_SHELF = 'http://opds-spec.org/shelf';
    const REL_U_SORT = 'http://opds-spec.org/sort';
    const REL_U_SUBSCRIPTIONS = 'http://opds-spec.org/subscriptions';
    const REL_U_THUMBNAIL = 'http://opds-spec.org/image/thumbnail';

    const TYPE_KIND_NAVIGATION = 'kind=navigation';
    const TYPE_COMPLETE_ATOM_ACQUISITION = 'application/atom+xml;profile=opds-catalog;kind=acquisition';

    const TYPE_ATOM = 'application/atom+xml';
    const TYPE_JSON = 'application/x-suggestions+json';
    const TYPE_SEARCH = 'application/opensearchdescription+xml';
    const TYPE_WEB = 'text/html';
    const TYPE_XML = 'application/x-suggestions+xml';

    /**
     * @var string
     */
    private $href;

    /**
     *
     * @var string
     */
    private $rel;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $typeLink;

    /**
     * @return string
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * @return string
     */
    public function getRel()
    {
        return $this->rel;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getTypeLink()
    {
        return $this->typeLink;
    }

    /**
     * @param string $href
     */
    public function setHref($href)
    {
        $this->href = $href;
    }

    /**
     * 
     * @param string $rel
     */
    public function setRel($rel)
    {
        $this->rel = $rel;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param string $typeLink
     */
    public function setTypeLink($typeLink)
    {
        $this->typeLink = $typeLink;
    }

}