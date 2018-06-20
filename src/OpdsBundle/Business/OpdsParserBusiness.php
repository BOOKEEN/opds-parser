<?php

namespace OpdsBundle\Business;

use OpdsBundle\Entity\Contributor;
use OpdsBundle\Entity\Feed;
use OpdsBundle\Entity\Link;
use OpdsBundle\Entity\Metadata;
use OpdsBundle\Entity\OpdsMetadata;
use OpdsBundle\Entity\Price;
use OpdsBundle\Entity\Publication;
use OpdsBundle\Entity\Subject;
use OpdsBundle\Exception\OpdsParserNotFoundException;
use OpdsBundle\Exception\OpdsParserNoTitleException;

class OpdsParserBusiness
{
    const ODPS_REF_ACQUISITION = 'http://opds-spec.org/acquisition';
    const ODPS_REF_GROUP = 'http://opds-spec.org/group';
    const ODPS_REF_FACET = 'http://opds-spec.org/facet';
    const ODPS_REF_IMAGE = 'http://opds-spec.org/image';
    const ODPS_REF_THUMBNAIL = 'http://opds-spec.org/image/thumbnail';
                        
    /**
     * 
     * @param string $file file path
     * 
     * @return Feed|Publication
     * @throws OpdsParserNotFoundException
     */
    public function parseFile($file)
    {
        $handle = fopen($file, 'r');
        if (!$handle) {

            throw new OpdsParserNotFoundException();
        }
        $content = fread($handle, filesize($file));
        fclose($handle);

        $xmldata = new \SimpleXMLElement($content);

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
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        if ($headers) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        ob_start();
        curl_exec($ch);
        curl_close($ch);
        $content = ob_get_contents();
        ob_end_clean();

        $xmldata = new \SimpleXMLElement($content);

        return $this->parse($xmldata);
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
     * @return OpdsMetadata
     */
    private function parseOpdsMetadata($xmldata)
    {
        $metadata = new OpdsMetadata();

        if (isset($xmldata->updated)) {
            $metadata->setModified(\DateTime::createFromFormat(\DateTime::ISO8601, $xmldata->updated));
        }

        foreach ($xmldata->children('opensearch', true) as $key => $value) {
            switch ($key) {
                case 'totalResults':
                    $metadata->setNumberOfItem((string) $value); //@TODO pas int ?
                    break;
                case 'itemsPerPage':
                    $metadata->setItemsPerPage((string) $value); //@TODO pas int ?
                    break;
            }
        }
        
        return $metadata;
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
        $feed->setMetadata($this->parseOpdsMetadata($xmldata));

        if (!isset($xmldata->entry)) {

            return $feed;
        }

        foreach ($xmldata->entry as $entry) {
            $isNavigation = true;
            $collectionLink = new Link();

            foreach ($entry->link as $link) {
                if (isset($link['rel'])) {
                    $rel = (string) $link['rel'];
                    // Check is navigation or acquisition.
                    if (strncmp($rel, self::ODPS_REF_ACQUISITION, strlen(self::ODPS_REF_ACQUISITION)) == 0) {
                        $isNavigation = false;
                    }
                    // Check if there is a collection.
                    if (($rel === 'collection') || ($rel == self::ODPS_REF_GROUP)) {
                        $collectionLink->setRel('collection');
                        $collectionLink->setHref($link->href);
                        $collectionLink->setTitle($link->title);
                    }
                }
            }

            if (!$isNavigation) {
                $publication = $this->parseEntry($entry);
                // Checking if this publication need to go into a group or in publications.
                if (isset($collectionLink->href)) {
                    // TODO addPublicationInGroup(feed, publication, collectionLink)
                    //assert(false);
                } else {
                    $feed->publications[] = $publication;
                }
            } else {
                $newLink = new Link();

                if (isset($entry->title)) {
                    $newLink->setTitle((string) $entry->title);
                }
                if (isset($entry->link['rel'])) {
                    $newLink->setRel((string) $entry->link['rel']); // pourquoi un array
                }

                // facetElementCountStr
                foreach ($entry->children('thr', true) as $key => $value) {
                    dump('THR', $key, $value);
                    switch ($key) {
                        case 'count':
                            $newLink->getPropertieList()['numberOfItems'] = (int) $value;
                            //TODO 
                            assert(false);
                            break;
                    }
                }
                $newLink->setTypeLink((string) $entry->link['type']);
                $newLink->setHref((string) $entry->link['href']);
                // Check collection link
                if (!empty($collectionLink->getHref())) {
                    //TODO addNavigationInGroup(feed, newLink, collectionLink)
                   // assert(false);
                } else {
                    $feed->addNavigation($newLink);
                }
            }
        }

        $facetGroupName = null;
        foreach ($xmldata->link as $link) {
            $newLink = new Link();
            $newLink->setHref((string) $link['href']);
            $newLink->setTitle((string) $link['title']);
            $newLink->setTypeLink((string) $link['type']);
            if (isset($entry['rel'])) {
                $newLink->setRel((string) $link['rel']);
            }

            unset($facetGroupName);
            foreach ($link->children('opds', true) as $key => $value) {
                dump('OPDS', $key, $value);
                switch ($key) {
                    case 'facetGroup':
                        $facetGroupName = (string) $value;
                        //TODO 
                        //assert(false);
                        break;
                }
            }
            $facetGroupName = $link['opds:facetGroup'];
            if (isset($facetGroupName) && isset($newLink->getRelList()[self::ODPS_REF_FACET])) {
                foreach ($link->children('thr', true) as $key => $value) {
                    dump('THR', $key, $value);
                    switch ($key) {
                        case 'count':
                            $newLink->getPropertieList()['numberOfItems'] = (int) $value;
                            //TODO 
                            //assert(false);
                            break;
                    }
                }
                //TODO addFacet(feed: feed, to: newLink, named: facetGroupName)
                //assert(false);
            } else {
                $feed->addLink($newLink);
            }
        }

        return $feed;
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

        if (isset($entry->title)) {
            /* if metadata.multilangTitle == nil {
              metadata.multilangTitle = MultilangString()
              }
              metadata.multilangTitle?.singleString = */
            $metadata->setTitle((string) $entry->title);
        }

        if (isset($entry->identifier)) {
            $publication->setIdentifier((string) $entry->identifier);
//            $metadata->setIdentifier((string) $entry->identifier);
        } else if (isset($entry->id)) {
            $publication->setIdentifier((string) $entry->id);
//            $metadata->setIdentifier((string) $entry->id);
        }

        // Extract dcterms data
        foreach ($entry->children('dcterms', true) as $key => $value) {
  //  dump('dcterms', $key, $value);
            switch ($key) {
                case 'language':
                    $metadata->setLanguage((string) $value);
                    //entry["dcterms:language"].all {
                    //metadata.languages = languages.map({ $0.string })
                    break;
                case 'publisher':
                    $contributor = new Contributor();
                    //$contributor.multilangName.singleString = publisher
                    $contributor->setName((string) $value);
                    $metadata->addPublisher($contributor);
                    break;
                case 'extent':
                    $metadata->setExtent((string) $value); // @TODO plusieurs extent : taille & nb pages
                    break;
                case 'identifier': // isbn @TODO add ?
                    $metadata->setIdentifier((string) $value);
                    break;
                case 'source': // isbn @TODO add ?
                    //$metadata->setSource((string) $value);
                    break;
                case 'issued': // date @TODO add ?
                  //  $metadata->setSource((string) $value);
                    break;
            }
        }
        if (isset($entry->updated)) {
            $metadata->setModified(\DateTime::createFromFormat(\DateTime::ISO8601, $entry->updated));
        }
        // Publication date.
        if (isset($entry->published)) {
            $metadata->setPublicationDate((string) $entry->published);
        }
        // Rights.
        if (isset($entry->rights)) {
            $metadata->setRights($entry->rights);
        }
        // TODO SERIES -------------
        // Categories.
        if (count($entry->category)) {
            foreach ($entry->category as $category) {
                $subject = new Subject();
                $subject->setCode((string) $category['term']);
                $subject->setName((string) $category['label']);
                $subject->setScheme((string) $category['scheme']);
                $metadata->addSubject($subject);
            }
        }
        /// Contributors.
        // Author.
        if (count($entry->author)) {
            foreach ($entry->author as $author) {
                $contributor = new Contributor();
                if (isset($author->uri)) {
                    $link = new Link();
                    $link->setHref((string) $author->uri);
                    $contributor->addLink($link);
                }
                //contributor.multilangName.singleString = author["name"].value
                $contributor->setName((string) $author->name);
                $metadata->addAuthor($contributor);
            }
        }
        // Description.
        if (isset($entry->content)) {
            $metadata->setDescription((string) $entry->content);
        } else if (isset($entry->summary)) {
            $metadata->setDescription((string) $entry->summary);
        }

        // Links.
        if (count($entry->link)) {
            foreach ($entry->link as $link) {
                $newLink = new Link();

                $newLink->setHref((string) $link['href']);
                $newLink->setTitle((string) $link['title']);
                $newLink->setTypeLink((string) $link['type']);
                if (isset($link['rel'])) {
                    $newLink->setRel((string) $link['rel']);
                }
                // Indirect acquisition check. (Recursive)
                $indirectAcquisitions = $link['opds:indirectAcquisition'];
                if (isset($indirectAcquisitions)) {
                    //if let indirectAcquisitions = link["opds:indirectAcquisition"].all,
                    //!indirectAcquisitions.isEmpty
                    //newLink.properties.indirectAcquisition = parseIndirectAcquisition(children: indirectAcquisitions)
                    //TODO 
                    //assert(false);
                }
                // Extract opds data
                foreach ($link->children('opds', true) as $key => $value) {
    dump('odps', $key, $value);
                    switch ($key) {
                        case 'price':
                            $price = (string) $value;
                            $att = iterator_to_array($value->attributes());
                            $currency = (string) $att['currencycode'];
                            $newPrice = new Price();
                            $newPrice->setCurrency($currency);
                            $newPrice->setPrice($price);
                            $metadata->setPrice($newPrice);
//                            $newLink->getPropertieList()['price'] = $newPrice;
                            break;
                    }
                }

                if (isset($link['rel'])) {
                    $rel = (string) $link['rel'];
                    if (($rel == 'collection') || ( $rel == self::ODPS_REF_GROUP)) {
                        // nothing to do
                    } elseif (($rel == self::ODPS_REF_IMAGE) || ( $rel == self::ODPS_REF_THUMBNAIL)) {
                        $publication->addImage($newLink);
                    } else {
                        $publication->addLink($newLink);
                    }
                }
            }
        }

        return $publication;
    }

}
