<?php

namespace OpdsBundle\Business;

use OpdsBundle\Entity\Borrow;
use OpdsBundle\Entity\Contributor;
use OpdsBundle\Entity\Facet;
use OpdsBundle\Entity\Feed;
use OpdsBundle\Entity\Link;
use OpdsBundle\Entity\Metadata;
use OpdsBundle\Entity\Navigation;
use OpdsBundle\Entity\Pagination;
use OpdsBundle\Entity\Price;
use OpdsBundle\Entity\Publication;
use OpdsBundle\Entity\Search;
use OpdsBundle\Entity\Subject;
use OpdsBundle\Exception\OpdsParserNotFoundException;
use OpdsBundle\Exception\OpdsParserNoTitleException;
use OpdsBundle\Utils\XmlLoaderUtils;

/**
 * @see http://opds-spec.org/specs/opds-catalog-1-1-20110627/ pour les constantes ODPS_REL_* et ODPS_TYPE_*
 */
class OpdsParserBusiness
{
    const ODPS_REL_ALTERNATE = 'alternate';
    const ODPS_REL_ACQUISITION = 'http://opds-spec.org/acquisition';
    const ODPS_REL_ACQUISITION_OPEN_ACCESS = 'http://opds-spec.org/acquisition/open-access';
    const ODPS_REL_ACQUISITION_BORROW = 'http://opds-spec.org/acquisition/borrow';
    const ODPS_REL_ACQUISITION_BUY = 'http://opds-spec.org/acquisition/buy';
    const ODPS_REL_ACQUISITION_SAMPLE = 'http://opds-spec.org/acquisition/sample'; // extrait
    const ODPS_REL_ACQUISITION_SUBSCRIBE = 'http://opds-spec.org/acquisition/subscribe';
    const ODPS_REL_CRAWLABLE = 'http://opds-spec.org/crawlable';
    const ODPS_REL_FACET = 'http://opds-spec.org/facet';
    const ODPS_REL_FEATURE = 'http://opds-spec.org/featured';
    const ODPS_REL_GROUP = 'http://opds-spec.org/group';
    const ODPS_REL_IMAGE = 'http://opds-spec.org/image';
    const ODPS_REL_NEXT = 'next';
    const ODPS_REL_RECOMMENDED = 'http://opds-spec.org/recommended';
    const ODPS_REL_SEARCH = 'search';
    const ODPS_REL_SELF = 'self';
    const ODPS_REL_SHELF = 'http://opds-spec.org/shelf';
    const ODPS_REL_SORT = 'http://opds-spec.org/sort';
    const ODPS_REL_START = 'start';
    const ODPS_REL_SUBSCRIPTIONS = 'http://opds-spec.org/subscriptions';
    const ODPS_REL_THUMBNAIL = 'http://opds-spec.org/image/thumbnail';

    const ODPS_TYPE_KIND_NAVIGATION = 'kind=navigation';
    const ODPS_TYPE_SEARCH = 'application/opensearchdescription+xml';

    /**
     * 
     * @param string $file file path
     * 
     * @return Feed|Publication
     * @throws OpdsParserNotFoundException
     */
    public function parseFile($file)
    {
        $xmldata = XmlLoaderUtils::loadXmlByFile($file);

        return $this->parse($xmldata);
    }

    /**
     * 
     * @param string $url
     * @param type $headers
     *
     * @return Feed|Publication
     */
    public function parseURL($url, $headers = null)
    {
        $xmldata = XmlLoaderUtils::loadXmlByUrl($url, $headers);

        return $this->parse($xmldata);
    }

    /**
     * 
     * @param string $url
     * 
     * @return Search[]
     */
    public function parseSearchUrl($url)
    {
        $xmldata = XmlLoaderUtils::loadXmlByUrl($url);

        return $this->parseSearch($xmldata);
    }
    
    /**
     * 
     * @param \SimpleXMLElement $xmlData
     * 
     * @return Search[]
     */
    private function parseSearch($xmlData)
    {
        $list = array();
        foreach ($xmlData->Url as $value) {
            $search = new Search();
            $search->setTemplate((string) $value['template']);
            $search->setType((string) $value['type']);
            $search->setRel((string) $value['rel']);
            
            $list[$search->getType()] = $search;
        }
        
        return $list;
    }

    /**
     * Parse an OPDS flux.
     * 
     * @param \SimpleXMLElement $xmldata
     * 
     * @return Feed|Publication
     * @throws OpdsParserNoTitleException
     */
    private function parse($xmldata)
    {
        if (!isset($xmldata->title)) {

            throw new OpdsParserNoTitleException();
        }

        if ($xmldata->getName() === 'entry') {

            return $this->parseEntry($xmldata);
        }

        return $this->parseFeed($xmldata);
    }

    /**
     * 
     * @param \SimpleXMLElement $xmldata
     *
     * @return Pagination|null
     */
    private function parsePagination($xmldata)
    {
        $pagination = new Pagination();
        $paginated = false;

        foreach ($xmldata->children('opensearch', true) as $key => $value) {
            switch ($key) {
                case 'totalResults':
                    $pagination->setNumberOfItem((int) $value);
                    $paginated = true;
                    break;
                case 'itemsPerPage':
                    $pagination->setItemsPerPage((int) $value);
                    $paginated = true;
                    break;
            }
        }

        return $paginated ? $pagination : null;
    }

    /**
     * 
     * @param \SimpleXMLElement $xmldata
     *
     * @return Feed
     */
    private function parseFeed($xmldata)
    {
        $feed = new Feed();
        $feed->setTitle((string) $xmldata->title);
        if (isset($xmldata->updated)) {
            $feed->setUpdatedAt(\DateTime::createFromFormat(\DateTime::ISO8601, $xmldata->updated));
        }
        $feed->setPagination($this->parsePagination($xmldata));

        foreach ($xmldata->entry as $entry) {
            $this->parseFeedEntry($entry, $feed);
        }

        foreach ($xmldata->link as $link) {
            $this->parseFeedLink($link, $feed);
        }

        return $feed;
    }

    /**
     * 
     * @param \SimpleXMLElement $xmlLink
     * @param Feed $feed passage par paramètre
     */
    private function parseFeedLink($xmlLink, Feed &$feed)
    {
        $groupName = null;
        $isActive = false;
        foreach ($xmlLink->attributes('opds', true) as $key => $value) {
            switch ($key) {
                case 'facetGroup':
                    $groupName = (string) $value;
                    break;
                case 'activeFacet':
                    $isActive = (string) $value === 'true' ? true : false;
                    break;
            }
        }

        if (empty($groupName)) {
            $link = new Link();
        } else {
            $link = new Facet();
            $link->setIsActiveFacet($isActive);
        }

        $link->setHref((string) $xmlLink['href']);
        $link->setTitle((string) $xmlLink['title']);
        $link->setTypeLink((string) $xmlLink['type']);
        if (isset($xmlLink['rel'])) {
            $link->setRel((string) $xmlLink['rel']);
        }

        if (($link instanceof Facet)) {
            foreach ($xmlLink->attributes('thr', true) as $key => $value) {
                if ($key === 'count') { // total non utilisé dans http://opds-spec.org/specs/opds-catalog-1-1-20110627
                    $link->setNumberOfItems((int) $value);
                }
            }
            $feed->addFacet($link, $groupName);

            return;
        }

        if (strpos($link->getTypeLink(), self::ODPS_TYPE_KIND_NAVIGATION) !== false || strpos($link->getTypeLink(), self::ODPS_TYPE_SEARCH) !== false
          || in_array($link->getRel(), array(self::ODPS_REL_NEXT, self::ODPS_REL_SEARCH, self::ODPS_REL_SELF))
        ) {
            $feed->addMenu($link);
        } else {

            $feed->addLink($link);
        }
    }

    /**
     * 
     * @param \SimpleXMLElement $xmlEntry
     * @param Feed $feed passage par paramètre
     */
    private function parseFeedEntry($xmlEntry, Feed &$feed)
    {
        // liens de navigation
        if (count($xmlEntry->link) === 1 && strpos($xmlEntry->link['rel'], self::ODPS_REL_ACQUISITION) !== 0) {
            $link = new Navigation();

            $link->setTitle((string) $xmlEntry->title);
            $link->setId((string) $xmlEntry->id);
            $link->setUpdatedAt(\DateTime::createFromFormat(\DateTime::ISO8601, $xmlEntry->updated));
            $link->setTypeLink((string) $xmlEntry->link['type']);
            $link->setHref((string) $xmlEntry->link['href']);
            $link->setRel((string) $xmlEntry->link['rel']);

            if (isset($xmlEntry->content)) {
                $link->setContent((string) $xmlEntry->content);
            }

            if (($link->getRel() === 'collection') || ($link->getRel() === self::ODPS_REL_GROUP)) {
                $link->setRel('collection');
                $feed->addCollectionLink($link);
            } else {
                $feed->addNavigation($link);
            }

            return;
        }

        // lien de publication
        $collection = false;
        foreach ($xmlEntry->link as $link) {
            if (isset($link['rel']) && ($link['rel'] === 'collection' || $link['rel'] === self::ODPS_REL_GROUP)) {
                $collection = true;
                $link['rel'] = 'collection';
            }
        }

        $publication = $this->parseEntry($xmlEntry);
        if ($collection) {
            $feed->addCollectionPublicationList($publication);
        } else {
            $feed->addPublication($publication);
        }
    }

    /**
     * 
     * @param \SimpleXMLElement $entry
     * 
     * @return Publication
     */
    private function parseEntry($entry)
    {
        $publication = new Publication();
        $metadata = new Metadata();
        $publication->setMetadata($metadata);

        $metadata->setTitle((string) $entry->title);
        $publication->setIdentifier((string) $entry->id);
        $metadata->setUpdatedAt(\DateTime::createFromFormat(\DateTime::ISO8601, $entry->updated));

        foreach ($entry->children('dcterms', true) as $key => $value) {
            switch ($key) {
                case 'language':
                    $metadata->setLanguage((string) $value);
                    break;
                case 'publisher':
                    $contributor = new Contributor();
                    $contributor->setName((string) $value);
                    $metadata->addPublisher($contributor);
                    break;
                case 'extent':
                    $extent = (string) $value;
                    if (preg_match('/^\d+ [a-zA-Z]o$/', $extent)) {
                        $metadata->setFileSize($extent);
                    } else {
                        $metadata->setNumberPages($extent);
                    }
                    break;
                case 'identifier':
                    $metadata->setIdentifier((string) $value);
                    break;
                case 'source':
                    $metadata->setSource((string) $value);
                    break;
                case 'issued':
                    $metadata->setIssuedAt(\DateTime::createFromFormat('Y-m-d', $value));
                    break;
            }
        }

        if (isset($entry->published)) {
            $metadata->setPublicationDate(\DateTime::createFromFormat(\DateTime::ISO8601, $entry->published));
        }
        if (isset($entry->rights)) {
            $metadata->setRights((string) $entry->rights);
        }

        // TODO SERIES -------------
        if (count($entry->category)) {
            foreach ($entry->category as $category) {
                $subject = new Subject();
                $subject->setCode((string) $category['term']);
                $subject->setName((string) $category['label']);
                $subject->setScheme((string) $category['scheme']);
                $metadata->addSubject($subject);
            }
        }

        if (count($entry->author)) {
            foreach ($entry->author as $author) {
                $contributor = new Contributor();
                if (isset($author->uri)) {
                    $link = new Link();
                    $link->setHref((string) $author->uri);
                    $contributor->addLink($link);
                }
                $contributor->setName((string) $author->name);
                $metadata->addAuthor($contributor);
            }
        }

        if (isset($entry->content)) {
            $metadata->setDescription((string) $entry->content);
        } elseif (isset($entry->summary)) {
            $metadata->setDescription((string) $entry->summary);
        }

        if (count($entry->link)) {
            foreach ($entry->link as $xmlLink) {
                $link = new Link();

                $link->setHref((string) $xmlLink['href']);
                $link->setTitle((string) $xmlLink['title']);
                $link->setTypeLink((string) $xmlLink['type']);
                $link->setRel((string) $xmlLink['rel']);

                if ($link->getRel() === self::ODPS_REL_ACQUISITION_BUY) {
                    $price = new Price();
                    $price->setUrl($link->getHref());

                    foreach ($xmlLink->children('opds', true) as $key => $value) {
                        $attributeList = $value->attributes();

                        if ($key === 'indirectAcquisition') {
                            $price->setFormat((string) $attributeList['type']);
                            continue;
                        }

                        if ($key !== 'price') {
                            continue;
                        }

                        $price->setPrice((string) $value);
                        $price->setCurrency((string) $attributeList['currencycode']);
                    }

                    $metadata->addPrice($price);
                    continue;
                }
                
                if ($link->getRel() == self::ODPS_REL_ACQUISITION_BORROW) {
                    $borrow = new Borrow();
                    $borrow->setIdentifier((string) $xmlLink->identifier);
                    $borrow->setUrl($link->getHref());

                    foreach ($xmlLink->children('opds', true) as $key => $value) {
                        $attributeList = $value->attributes();

                        if ($key === 'unavailable') {
                            $borrow->setUnavailableUntil(\DateTime::createFromFormat(\DateTime::ISO8601, $attributeList['date']));
                            continue;
                        }

                        if ($key !== 'indirectAcquisition') {
                            continue;
                        }

                        if (isset($value->indirectAcquisition)) {
                            $borrow->setProtection((string) $attributeList['type']);
                            $protectionAttList = $value->indirectAcquisition->attributes();
                            $borrow->setFormat((string) $protectionAttList['type']);
                        } else {
                            $borrow->setFormat((string) $attributeList['type']);
                        }
                    }

                    if (empty($borrow->getFormat())) {
                        $borrow->setUrl((string) $xmlLink['href']);
                        $borrow->setProtection((string) $xmlLink['type']);
                    }

                    $metadata->addBorrow($borrow);
                    continue;
                }

                if (!isset($xmlLink['rel'])) {
                    continue;
                }

                $rel = (string) $xmlLink['rel'];
                if (($rel == 'collection') || ( $rel == self::ODPS_REL_GROUP)) {
                    // nothing to do
                } elseif (($rel == self::ODPS_REL_IMAGE) || ( $rel == self::ODPS_REL_THUMBNAIL)) {
                    $publication->addImage($link);
                } else {
                    $publication->addLink($link);
                }
            }
        }

        return $publication;
    }

}