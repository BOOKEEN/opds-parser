<?php

namespace OpdsBundle\Test\Business;

use OpdsBundle\Business\OpdsParserBusiness;
use OpdsBundle\Entity\Borrow;
use OpdsBundle\Entity\Contributor;
use OpdsBundle\Entity\Facet;
use OpdsBundle\Entity\Feed;
use OpdsBundle\Entity\Link;
use OpdsBundle\Entity\Metadata;
use OpdsBundle\Entity\Pagination;
use OpdsBundle\Entity\Price;
use OpdsBundle\Entity\Publication;
use OpdsBundle\Entity\Search;
use OpdsBundle\Entity\Subject;
use OpdsBundle\Exception\OpdsParserNoTitleException;
use PHPUnit\Framework\TestCase;

class OpdsParserBusinessTest extends TestCase
{
    /**
     * @param OpdsParserBusiness $business
     * @param string $method
     *
     * @return \ReflectionMethod
     */
    public function getOpdsParserBusinessPrivate(OpdsParserBusiness $business, $method)
    {
        $parserReflection = new \ReflectionClass($business);

        $parserMethod = $parserReflection->getMethod($method);
        $parserMethod->setAccessible(true);

        return $parserMethod;
    }

    /**
     * test de parseSearch
     */
    public function testParseSearch()
    {
        $business = new OpdsParserBusiness();
        $businessReflection = $this->getOpdsParserBusinessPrivate($business, 'parseSearch');

        $xml = new \SimpleXMLElement(<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<OpenSearchDescription xmlns="http://a9.com/-/spec/opensearch/1.1/">
  <ShortName>Feedbooks</ShortName>
  <Description>Search on Feedbooks</Description>
  <InputEncoding>UTF-8</InputEncoding>
  <OutputEncoding>UTF-8</OutputEncoding>
  <Image type="image/x-icon" width="16" height="16">http://www.feedbooks.com/favicon.ico</Image>
  <Url type="application/atom+xml" template="http://www.feedbooks.com/search.atom?query={searchTerms}"/>
  <Url type="application/x-suggestions+json" rel="suggestions" template="http://www.feedbooks.com/search.json?query={searchTerms}"/>
  <Query role="example" searchTerms="robot" />
</OpenSearchDescription>
XML
        );

        $search1 = new Search();
        $search1->setTemplate('http://www.feedbooks.com/search.atom?query={searchTerms}');
        $search1->setType(Link::TYPE_ATOM);

        $search2 = new Search();
        $search2->setRel('suggestions');
        $search2->setTemplate('http://www.feedbooks.com/search.json?query={searchTerms}');
        $search2->setType(Link::TYPE_JSON);
        
        $list = array(
            Link::TYPE_ATOM => $search1,
            Link::TYPE_JSON => $search2,
        );

        $this->assertEquals($list, $businessReflection->invokeArgs($business, array($xml)), 'Method: parseSearch');
    }

    /**
     * test de parse
     */
    public function testParseException()
    {
        $business = new OpdsParserBusiness();
        $businessReflection = $this->getOpdsParserBusinessPrivate($business, 'parse');

        $emptyXml = new \SimpleXMLElement(<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<OpenSearchDescription xmlns="http://a9.com/-/spec/opensearch/1.1/">
</OpenSearchDescription>
XML
        );

        $this->expectException(OpdsParserNoTitleException::class);
        $businessReflection->invokeArgs($business, array($emptyXml));
    }

    /**
     * test de parsePagination
     *
     * @param \SimpleXMLElement $feed
     * @param Pagination|null $expected
     * 
     * @dataProvider parsePaginationProvider
     */
    public function testParsePagination($feed, $expected)
    {
        $business = new OpdsParserBusiness();
        $businessReflection = $this->getOpdsParserBusinessPrivate($business, 'parsePagination');

        $this->assertEquals($expected, $businessReflection->invokeArgs($business, array($feed)), 'Method: parsePagination');
    }

//    public function testParseFeed()
//    {
//        
//    }

    /**
     * test de parseFeedLink
     *
     * @param \SimpleXMLElement $link
     * @param Feed $expected
     * 
     * @dataProvider parseParseFeedLink
     */
    public function testParseFeedLink($link, $feed, $expected)
    {
        $business = new OpdsParserBusiness();
        $businessReflection = $this->getOpdsParserBusinessPrivate($business, 'parseFeedLink');

        $businessReflection->invokeArgs($business, array($link, &$feed));

        $this->assertEquals($expected, $feed, 'Method: parseFeedLink');
    }

//    public function testParseFeedEntry()
//    {
//        
//    }

    /**
     * test de parseEntry
     * 
     * @param \SimpleXMLElement $entry
     * @param Publication $expected
     * 
     * @dataProvider parseEntryProvider
     */
    public function testParseEntry($entry, $expected)
    {
        $business = new OpdsParserBusiness();
        $businessReflection = $this->getOpdsParserBusinessPrivate($business, 'parseEntry');

        $this->assertEquals($expected, $businessReflection->invokeArgs($business, array($entry)), 'Method: parseEntry');
    }

    /**
     * @return array
     */
    public function parsePaginationProvider()
    {
        $pagination = new Pagination();
        $pagination->setItemsPerPage(50);
        $pagination->setNumberOfItem(6099);

        return array(
            array(
                $this->getFeedbookCategoryFeedXml(),
                $pagination,
            ),
            array(
                new \SimpleXMLElement(<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<feed></feed>
XML
                ),
                null,
            ),
        );
    }

    /**
     * @return array
     */
    public function parseParseFeedLink()
    {
        $facet = new Facet();
        $facet->setHref('/store/top.atom?category=FBFIC027020');
        $facet->setIsActiveFacet(false);
        $facet->setNumberOfItems(794);
        $facet->setRel('http://opds-spec.org/facet');
        $facet->setTitle('Contemporain');
        $facet->setTypeLink('application/atom+xml;profile=opds-catalog;kind=acquisition');

        $feedFacet = new Feed();
        $feedFacet->addFacet($facet, 'Sous catégories');


        $linkMenu = new Link();
        $linkMenu->setHref('http://www.feedbooks.com/catalog.atom');
        $linkMenu->setRel(Link::REL_S_START);
        $linkMenu->setTitle('Accueil');
        $linkMenu->setTypeLink('application/atom+xml;profile=opds-catalog;kind=navigation');

        $feedMenu = new Feed();
        $feedMenu->addMenu($linkMenu);


        $link = new Link();
        $link->setHref('http://www.feedbooks.com/store/recent.atom?category=FBFIC027000');
        $link->setRel('http://opds-spec.org/sort/new');
        $link->setTitle('Nouveautés');
        $link->setTypeLink('application/atom+xml;profile=opds-catalog;kind=acquisition');

        $feedLink = new Feed();
        $feedLink->addLink($link);

        return array(
            array(
                new \SimpleXMLElement(<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<link 
    xmlns:opds="http://opds-spec.org/2010/catalog"
    xmlns:thr="http://purl.org/syndication/thread/1.0"
    type="application/atom+xml;profile=opds-catalog;kind=acquisition" thr:count="794" title="Contemporain" opds:facetGroup="Sous cat&#233;gories" rel="http://opds-spec.org/facet" href="/store/top.atom?category=FBFIC027020"/>
XML
                ),
                new Feed(),
                $feedFacet,
            ),
            array(
                new \SimpleXMLElement(<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<link 
    xmlns:opds="http://opds-spec.org/2010/catalog"
    xmlns:thr="http://purl.org/syndication/thread/1.0"
    type="application/atom+xml;profile=opds-catalog;kind=navigation" title="Accueil" rel="start" href="http://www.feedbooks.com/catalog.atom"/>
XML
                ),
                new Feed(),
                $feedMenu,
            ),
            array(
                new \SimpleXMLElement(<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<link 
    xmlns:opds="http://opds-spec.org/2010/catalog"
    xmlns:thr="http://purl.org/syndication/thread/1.0"
    type="application/atom+xml;profile=opds-catalog;kind=acquisition" title="Nouveaut&#233;s" rel="http://opds-spec.org/sort/new" href="http://www.feedbooks.com/store/recent.atom?category=FBFIC027000"/>
XML
                ),
                new Feed(),
                $feedLink,
            ),
        );
    }

    /**
     * @return array
     */
    public function parseEntryProvider()
    {
        return array(
            $this->getFeedbookEntry(),
            $this->getLongueuilEntry(),
        );
    }

    /**
     * @return array
     */
    public function getFeedbookEntry()
    {
        $publication = new Publication();
        $publication->setIdentifier('http://www.feedbooks.com/item/2707366');

        $image1 = new Link();
        $image1->setHref('http://covers.feedbooks.net/item/2707366.jpg?size=large&t=1522400930');
        $image1->setRel('http://opds-spec.org/image');
        $image1->setTypeLink('image/jpeg');
        $publication->addImage($image1);

        $image2 = new Link();
        $image2->setHref('http://covers.feedbooks.net/item/2707366.jpg?size=large&t=1522400930');
        $image2->setRel('http://opds-spec.org/image/thumbnail');
        $image2->setTypeLink('image/jpeg');
        $publication->addImage($image2);

        $link1 = new Link();
        $link1->setHref('http://www.feedbooks.com/item/2707366');
        $link1->setRel('alternate');
        $link1->setTitle('Voir sur Feedbooks');
        $link1->setTypeLink('text/html');
        $publication->addLink($link1);

        $link2 = new Link();
        $link2->setHref('http://www.feedbooks.com/item/2707366.atom');
        $link2->setRel('self');
        $link2->setTypeLink('application/atom+xml;type=entry;profile=opds-catalog');
        $publication->addLink($link2);

        $link3 = new Link();
        $link3->setHref('http://www.feedbooks.com/item/2707366/preview');
        $link3->setRel('http://opds-spec.org/acquisition/sample');
        $link3->setTypeLink('application/epub+zip');
        $publication->addLink($link3);

        $link4 = new Link();
        $link4->setHref('http://www.feedbooks.com/item/2707366/categories.atom');
        $link4->setRel('related');
        $link4->setTitle('Catégories pour ce livre');
        $link4->setTypeLink('application/atom+xml;profile=opds-catalog;kind=navigation');
        $publication->addLink($link4);

        $link5 = new Link();
        $link5->setHref('http://www.feedbooks.com/store/top.atom?collection=Aventures+et+Passions&lang=fr');
        $link5->setRel('related');
        $link5->setTitle('Dans la même collection');
        $link5->setTypeLink('application/atom+xml;profile=opds-catalog;kind=acquisition');
        $publication->addLink($link5);

        $link = new Link();
        $link->setHref('http://www.feedbooks.com/store/top.atom?lang=fr&amp;publisher=J%27ai+Lu');
        $link->setRel('related');
        $link->setTitle('Du même éditeur');
        $link->setTypeLink('application/atom+xml;profile=opds-catalog;kind=acquisition');
        $publication->addLink($link);

        $metadata = new Metadata();
        $metadata->setTitle('La rançon du désir');
        $metadata->setDescription('ma description 2 ici');
        $metadata->setLanguage('fr');
        $metadata->setFileSize('2 Mo');
        $metadata->setNumberPages('384 pages');
        $metadata->setIdentifier('urn:ISBN:9782290142233');
        $metadata->setSource('urn:ISBN:9782290142264');
        $metadata->setIssuedAt(\DateTime::createFromFormat('Y-m-d', '2018-04-24'));
        $metadata->setPublicationDate(\DateTime::createFromFormat(\DateTime::ISO8601, '2018-03-30T11:08:47Z'));
        $metadata->setUpdatedAt(\DateTime::createFromFormat(\DateTime::ISO8601, '2018-05-08T10:56:59Z'));

        $authorLink = new Link();
        $authorLink->setHref('http://www.feedbooks.com/search?query=contributor%3A%22Penelope+Williamson%22');
        $author = new Contributor();
        $author->setLinkList(array($authorLink));
        $author->setName('Penelope Williamson');
        $metadata->addAuthor($author);

        $price = new Price();
        $price->setCurrency('EUR');
        $price->setFormat('application/epub+zip');
        $price->setPrice('5.99');
        $price->setUrl('https://www.feedbooks.com/item/2707366/buy');
        $metadata->addPrice($price);

        $publisher = new Contributor();
        $publisher->setName('J\'ai Lu');
        $metadata->addPublisher($publisher);

        $subject1 = new Subject();
        $subject1->setCode('FBFIC000000');
        $subject1->setName('Fiction');
        $subject1->setScheme('http://www.feedbooks.com/categories');
        $metadata->addSubject($subject1);

        $subject2 = new Subject();
        $subject2->setCode('FBFIC027000');
        $subject2->setName('Littérature sentimentale');
        $subject2->setScheme('http://www.feedbooks.com/categories');
        $metadata->addSubject($subject2);

        $publication->setMetadata($metadata);

        return array(
            new \SimpleXMLElement(<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<entry
    xmlns:opds="http://opds-spec.org/2010/catalog"
    xmlns:thr="http://purl.org/syndication/thread/1.0"
    xmlns:dcterms="http://purl.org/dc/terms/"
    xmlns:schema="http://schema.org/"
    xmlns="http://www.w3.org/2005/Atom"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
    <title>La ran&#231;on du d&#233;sir</title>
    <id>http://www.feedbooks.com/item/2707366</id>
    <dcterms:identifier xsi:type="dcterms:URI">urn:ISBN:9782290142233</dcterms:identifier>
    <dcterms:source xsi:type="dcterms:URI">urn:ISBN:9782290142264</dcterms:source>
    <author>
        <name>Penelope Williamson</name>
        <uri>http://www.feedbooks.com/search?query=contributor%3A%22Penelope+Williamson%22</uri>
    </author>
    <published>2018-03-30T11:08:47Z</published>
    <updated>2018-05-08T10:56:59Z</updated>
    <dcterms:language>fr</dcterms:language>
    <dcterms:publisher>J'ai Lu</dcterms:publisher>
    <dcterms:issued>2018-04-24</dcterms:issued>
    <summary>ma description ici</summary>
    <dcterms:extent>384 pages</dcterms:extent>
    <dcterms:extent>2 Mo</dcterms:extent>
    <category term="FBFIC000000" scheme="http://www.feedbooks.com/categories" label="Fiction"/>
    <category term="FBFIC027000" scheme="http://www.feedbooks.com/categories" label="Litt&#233;rature sentimentale"/>
    <link type="text/html" title="Voir sur Feedbooks" href="http://www.feedbooks.com/item/2707366" rel="alternate"/>
    <link type="image/jpeg" href="http://covers.feedbooks.net/item/2707366.jpg?size=large&amp;t=1522400930" rel="http://opds-spec.org/image"/>
    <link type="image/jpeg" href="http://covers.feedbooks.net/item/2707366.jpg?size=large&amp;t=1522400930" rel="http://opds-spec.org/image/thumbnail"/>
    <contributor>
        <name>Perrine Dulac</name>
        <uri>http://www.feedbooks.com/search?query=contributor%3A%22Perrine+Dulac%22</uri>
    </contributor>
    <content type="html">ma description 2 ici</content>
    <link type="application/atom+xml;type=entry;profile=opds-catalog" rel="self" href="http://www.feedbooks.com/item/2707366.atom"/>
    <link type="text/html" rel="http://opds-spec.org/acquisition/buy" href="https://www.feedbooks.com/item/2707366/buy">
        <opds:price currencycode="EUR">5.99</opds:price>
        <opds:indirectAcquisition type="application/epub+zip"/>
    </link>
    <link type="application/epub+zip" rel="http://opds-spec.org/acquisition/sample" href="http://www.feedbooks.com/item/2707366/preview"/>
    <link type="application/atom+xml;profile=opds-catalog;kind=navigation" title="Cat&#233;gories pour ce livre" rel="related" href="http://www.feedbooks.com/item/2707366/categories.atom"/>
    <link type="application/atom+xml;profile=opds-catalog;kind=acquisition" title="Dans la m&#234;me collection" rel="related" href="http://www.feedbooks.com/store/top.atom?collection=Aventures+et+Passions&amp;lang=fr"/>
    <link type="application/atom+xml;profile=opds-catalog;kind=acquisition" title="Du m&#234;me &#233;diteur" rel="related" href="http://www.feedbooks.com/store/top.atom?lang=fr&amp;amp;publisher=J%27ai+Lu"/>
</entry>
XML
            ),
            $publication,
        );
    }
    
    /**
     * @return array
     */
    public function getLongueuilEntry()
    {
        $publication = new Publication();
        $publication->setIdentifier('http://longueuil.pretnumerique.ca/resource_entries/5b2a7a6d235794549499fccb.atom');

        $image2 = new Link();
        $image2->setHref('https://assets.entrepotnumerique.com/medias/e6/0d1e615552b236a188ad85238cadb3af11f4a7.jpg?h=-&w=200');
        $image2->setRel('http://opds-spec.org/image/thumbnail');
        $image2->setTypeLink('image/jpeg');
        $publication->addImage($image2);

        $image1 = new Link();
        $image1->setHref('https://assets.entrepotnumerique.com/medias/e6/0d1e615552b236a188ad85238cadb3af11f4a7.jpg?h=-&w=200');
        $image1->setRel('http://opds-spec.org/image');
        $image1->setTypeLink('image/jpeg');
        $publication->addImage($image1);

        $link4 = new Link();
        $link4->setHref('http://longueuil.pretnumerique.ca/resources/5b2a7a6d235794549499fccb');
        $link4->setRel('alternate');
        $link4->setTypeLink('text/html');
        $link4->setTitle('Lire sur longueuil.pretnumerique.ca');
        $publication->addLink($link4);

        $link1 = new Link();
        $link1->setHref('http://longueuil.pretnumerique.ca/resource_entries/5b2a7a6d235794549499fccb.atom');
        $link1->setRel('alternate');
        $link1->setTypeLink('application/atom+xml;type=entry;profile=opds-catalog');
        $publication->addLink($link1);

        $link2 = new Link();
        $link2->setHref('https://assets.entrepotnumerique.com/medias/71/68ed4da0891ca45485315d64069c838205cc92.epub');
        $link2->setRel('http://opds-spec.org/acquisition/sample');
        $link2->setTypeLink('application/epub+zip');
        $publication->addLink($link2);

        $link3 = new Link();
        $link3->setHref('https://assets.entrepotnumerique.com/medias/d3/9dca4f2d9601f3918eead12a1dd70fd7896c09.pdf');
        $link3->setRel('http://opds-spec.org/acquisition/sample');
        $link3->setTypeLink('application/pdf');
        $publication->addLink($link3);

        $metadata = new Metadata();
        $metadata->setTitle('Mégantic');
        $metadata->setDescription('ma description ici');
        $metadata->setLanguage('fr');
        $metadata->setIdentifier('urn:isbn:9782897194246');
        $metadata->setSource('urn:isbn:9782897194222');
        $metadata->setIssuedAt(\DateTime::createFromFormat('Y-m-d', '2018-06-18'));
        $metadata->setPublicationDate(\DateTime::createFromFormat(\DateTime::ISO8601, '2018-06-20T16:01:49Z'));
        $metadata->setUpdatedAt(\DateTime::createFromFormat(\DateTime::ISO8601, '2018-06-20T16:01:49Z'));

        $author = new Contributor();
        $author->setName('Anne-Marie Saint-Cerny');
        $metadata->addAuthor($author);

        $publisher = new Contributor();
        $publisher->setName('Écosociété');
        $metadata->addPublisher($publisher);

        $subject1 = new Subject();
        $subject1->setCode('FBNFC000000');
        $subject1->setName('Documentaires');
        $subject1->setScheme('http://www.feedbooks.com/categories');
        $metadata->addSubject($subject1);

        $subject2 = new Subject();
        $subject2->setCode('social-science');
        $subject2->setName('Sciences humaines et sociales');
        $metadata->addSubject($subject2);

        $borrow1 = new Borrow();
        $borrow1->setFormat('application/epub+zip');
        $borrow1->setIdentifier('9782897194246');
        $borrow1->setProtection('application/vnd.adobe.adept+xml');
        $borrow1->setUnavailableUntil(\DateTime::createFromFormat(\DateTime::ISO8601, '2018-07-11T17:19:54Z'));
        $borrow1->setUrl('http://longueuil.pretnumerique.ca/bookings?medium_id=ENQC69769-9782897194246-epub');
        $metadata->addBorrow($borrow1);
        
        

        $borrow2 = new Borrow();
        $borrow2->setProtection('application/vnd.readium.lcp.license.v1.0+json');
        $borrow2->setIdentifier('9782897194246');
        $borrow2->setUnavailableUntil(\DateTime::createFromFormat(\DateTime::ISO8601, '2018-07-11T17:19:54Z'));
        $borrow2->setUrl('http://longueuil.pretnumerique.ca/v1/mobile_api/loans/ENQC69769-9782897194246-epub.lcpl?at=2018-07-11T17%3A19%3A54Z');
        $metadata->addBorrow($borrow2);
        
        

        $borrow3 = new Borrow();
        $borrow3->setIdentifier('9782897194246');
        $borrow3->setProtection('application/vnd.adobe.adept+xml');
        $borrow3->setUnavailableUntil(\DateTime::createFromFormat(\DateTime::ISO8601, '2018-07-11T17:19:54Z'));
        $borrow3->setUrl('http://longueuil.pretnumerique.ca/v1/mobile_api/loans/ENQC69769-9782897194246-epub.acsm?at=2018-07-11T17%3A19%3A54Z');
        $metadata->addBorrow($borrow3);
        
        $publication->setMetadata($metadata);

        return array(
            new \SimpleXMLElement(<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<entry
    xmlns="http://www.w3.org/2005/Atom" xml:lang="fr"
    xmlns:app="http://www.w3.org/2007/app"
    xmlns:opds="http://opds-spec.org/2010/catalog"
    xmlns:dcterms="http://purl.org/dc/terms/"
    xmlns:thr="http://purl.org/syndication/thread/1.0"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
    <id>http://longueuil.pretnumerique.ca/resource_entries/5b2a7a6d235794549499fccb.atom</id>
    <title>Mégantic</title>
    <summary>ma description ici</summary>
    <link type="text/html" rel="alternate" href="http://longueuil.pretnumerique.ca/resources/5b2a7a6d235794549499fccb" title="Lire sur longueuil.pretnumerique.ca"/>
    <author>
        <name>Anne-Marie Saint-Cerny</name>
    </author>
    <published>2018-06-20T16:01:49Z</published>
    <updated>2018-06-20T16:01:49Z</updated>
    <category scheme="http://www.feedbooks.com/categories" term="FBNFC000000" label="Documentaires"/>
    <category scheme="" term="social-science" label="Sciences humaines et sociales"/>
    <link type="application/atom+xml;type=entry;profile=opds-catalog" rel="alternate" href="http://longueuil.pretnumerique.ca/resource_entries/5b2a7a6d235794549499fccb.atom"/>
    <link rel="http://opds-spec.org/image/thumbnail" href="https://assets.entrepotnumerique.com/medias/e6/0d1e615552b236a188ad85238cadb3af11f4a7.jpg?h=-&amp;w=200" type="image/jpeg"/>
    <link rel="http://opds-spec.org/image" href="https://assets.entrepotnumerique.com/medias/e6/0d1e615552b236a188ad85238cadb3af11f4a7.jpg?h=-&amp;w=200" type="image/jpeg"/>
    <link type="application/epub+zip" rel="http://opds-spec.org/acquisition/sample" href="https://assets.entrepotnumerique.com/medias/71/68ed4da0891ca45485315d64069c838205cc92.epub"/>
    <link type="application/pdf" rel="http://opds-spec.org/acquisition/sample" href="https://assets.entrepotnumerique.com/medias/d3/9dca4f2d9601f3918eead12a1dd70fd7896c09.pdf"/>
    <dcterms:source xsi:type="dcterms:URI">urn:isbn:9782897194222</dcterms:source>
    <dcterms:identifier xsi:type="dcterms:URI">urn:isbn:9782897194246</dcterms:identifier>
    <dcterms:language>fr</dcterms:language>
    <dcterms:publisher>Écosociété</dcterms:publisher>
    <dcterms:issued>2018-06-18</dcterms:issued>
    <link type="text/html" rel="http://opds-spec.org/acquisition/borrow" href="http://longueuil.pretnumerique.ca/bookings?medium_id=ENQC69769-9782897194246-epub">
        <opds:unavailable date="2018-07-11T17:19:54Z"/>
        <opds:indirectAcquisition type="application/vnd.adobe.adept+xml">
            <opds:indirectAcquisition type="application/epub+zip"/></opds:indirectAcquisition>
        <identifier>9782897194246</identifier>
    </link>
    <link type="application/vnd.readium.lcp.license.v1.0+json" rel="http://opds-spec.org/acquisition/borrow" href="http://longueuil.pretnumerique.ca/v1/mobile_api/loans/ENQC69769-9782897194246-epub.lcpl?at=2018-07-11T17%3A19%3A54Z">
        <opds:unavailable date="2018-07-11T17:19:54Z"/>
        <identifier>9782897194246</identifier>
    </link>
    <link type="application/vnd.adobe.adept+xml" rel="http://opds-spec.org/acquisition/borrow" href="http://longueuil.pretnumerique.ca/v1/mobile_api/loans/ENQC69769-9782897194246-epub.acsm?at=2018-07-11T17%3A19%3A54Z">
        <opds:unavailable date="2018-07-11T17:19:54Z"/>
        <identifier>9782897194246</identifier>
    </link>
</entry>
XML
            ),
            $publication,
        );
    }

    /**
     * @return \SimpleXMLElement
     */
    private function getFeedbookCategoryFeedXml()
    {
        return new \SimpleXMLElement(<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<feed
    xmlns:opds="http://opds-spec.org/2010/catalog"
    xmlns:app="http://www.w3.org/2007/app"
    xmlns="http://www.w3.org/2005/Atom"
    xmlns:dcterms="http://purl.org/dc/terms/"
    xmlns:schema="http://schema.org/"
    xmlns:thr="http://purl.org/syndication/thread/1.0"
    xmlns:opensearch="http://a9.com/-/spec/opensearch/1.1/"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xml:lang="fr"
    xmlns:odl="http://opds-spec.org/odl">
    <id>http://www.feedbooks.com/store/top.atom?category=FBFIC027000</id>
    <title>Litt&#233;rature sentimentale</title>
    <updated>2018-06-20T09:04:15Z</updated>
    <icon>http://assets1.feedbooks.net/images/favicon.ico?t=1529393352</icon>
    <author>
        <name>Feedbooks</name>
        <uri>http://www.feedbooks.com</uri>
        <email>support@feedbooks.zendesk.com</email>
    </author>
    <link type="application/atom+xml; profile=opds-catalog; kind=acquisition" title="Meilleures Ventes" rel="self" href="http://www.feedbooks.com/store/top.atom?category=FBFIC027000"/>
    <link type="application/atom+xml;profile=opds-catalog;kind=navigation" title="Accueil" rel="start" href="http://www.feedbooks.com/catalog.atom"/>
    <link type="application/opensearchdescription+xml" title="Rechercher sur Feedbooks" rel="search" href="http://www.feedbooks.com/opensearch.xml"/>
    <link type="application/atom+xml;profile=opds-catalog;kind=acquisition" title="Biblioth&#232;que" rel="http://opds-spec.org/shelf" href="https://www.feedbooks.com/user/bookshelf.atom"/>
    <opensearch:totalResults>6099</opensearch:totalResults>
    <opensearch:itemsPerPage>50</opensearch:itemsPerPage>
    <link type="application/atom+xml;profile=opds-catalog;kind=acquisition" title="Page Suivante" rel="next" href="http://www.feedbooks.com/store/top.atom?category=FBFIC027000&amp;page=2"/>
    <link type="application/atom+xml;profile=opds-catalog;kind=acquisition" title="Nouveaut&#233;s" rel="http://opds-spec.org/sort/new" href="http://www.feedbooks.com/store/recent.atom?category=FBFIC027000"/>
    <link type="application/atom+xml;profile=opds-catalog;kind=acquisition" title="Notre S&#233;lection" rel="http://opds-spec.org/featured" href="http://www.feedbooks.com/store/selection.atom?category=FBFIC027000"/>
    <link type="application/atom+xml;profile=opds-catalog;kind=acquisition" title="Prix Litt&#233;raires" rel="http://opds-spec.org/featured" href="http://www.feedbooks.com/store/awards.atom?category=FBFIC027000"/>
    <link type="application/atom+xml;profile=opds-catalog;kind=acquisition" thr:count="1019" title="Historique" opds:facetGroup="Sous cat&#233;gories" rel="http://opds-spec.org/facet" href="/store/top.atom?category=FBFIC027050"/>
    <link type="application/atom+xml;profile=opds-catalog;kind=acquisition" thr:count="817" title="Bit lit" opds:facetGroup="Sous cat&#233;gories" rel="http://opds-spec.org/facet" href="/store/top.atom?category=FBFIC027120"/>
    <link type="application/atom+xml;profile=opds-catalog;kind=acquisition" thr:count="794" title="Contemporain" opds:facetGroup="Sous cat&#233;gories" rel="http://opds-spec.org/facet" href="/store/top.atom?category=FBFIC027020"/>
    <link type="application/atom+xml;profile=opds-catalog;kind=acquisition" thr:count="594" title="Adulte" opds:facetGroup="Sous cat&#233;gories" rel="http://opds-spec.org/facet" href="/store/top.atom?category=FBFIC027010"/>
    <link type="application/atom+xml;profile=opds-catalog;kind=acquisition" thr:count="305" title="Suspense" opds:facetGroup="Sous cat&#233;gories" rel="http://opds-spec.org/facet" href="/store/top.atom?category=FBFIC027110"/>
    <link type="application/atom+xml;profile=opds-catalog;kind=acquisition" thr:count="115" title="Fantasy" opds:facetGroup="Sous cat&#233;gories" rel="http://opds-spec.org/facet" href="/store/top.atom?category=FBFIC027030"/>
    <link type="application/atom+xml;profile=opds-catalog;kind=acquisition" thr:count="46" title="Nouvelles" opds:facetGroup="Sous cat&#233;gories" rel="http://opds-spec.org/facet" href="/store/top.atom?category=FBFIC027080"/>
    <link type="application/atom+xml;profile=opds-catalog;kind=acquisition" thr:count="23" title="Western" opds:facetGroup="Sous cat&#233;gories" rel="http://opds-spec.org/facet" href="/store/top.atom?category=FBFIC027100"/>
    <link type="application/atom+xml;profile=opds-catalog;kind=acquisition" thr:count="7" title="Voyage temporel" opds:facetGroup="Sous cat&#233;gories" rel="http://opds-spec.org/facet" href="/store/top.atom?category=FBFIC027090"/>
    <link type="application/atom+xml;profile=opds-catalog;kind=acquisition" thr:count="6" title="Gothique" opds:facetGroup="Sous cat&#233;gories" rel="http://opds-spec.org/facet" href="/store/top.atom?category=FBFIC027040"/>
    <link type="application/atom+xml;profile=opds-catalog;kind=acquisition" thr:count="1" title="R&#233;gence" opds:facetGroup="Sous cat&#233;gories" rel="http://opds-spec.org/facet" href="/store/top.atom?category=FBFIC027070"/>
    <link type="application/atom+xml;profile=opds-catalog;kind=acquisition" thr:count="18379" title="Anglais" opds:facetGroup="Langue" rel="http://opds-spec.org/facet" href="/store/top.atom?category=FBFIC027000&amp;lang=en"/>
    <link type="application/atom+xml;profile=opds-catalog;kind=acquisition" thr:count="6087" opds:activeFacet="true" title="Fran&#231;ais" opds:facetGroup="Langue" rel="http://opds-spec.org/facet" href="/store/top.atom?category=FBFIC027000&amp;lang=fr"/>
    <link type="application/atom+xml;profile=opds-catalog;kind=acquisition" thr:count="5123" title="Allemand" opds:facetGroup="Langue" rel="http://opds-spec.org/facet" href="/store/top.atom?category=FBFIC027000&amp;lang=de"/>
    <link type="application/atom+xml;profile=opds-catalog;kind=acquisition" thr:count="8104" title="Espagnol" opds:facetGroup="Langue" rel="http://opds-spec.org/facet" href="/store/top.atom?category=FBFIC027000&amp;lang=es"/>
    <link type="application/atom+xml;profile=opds-catalog;kind=acquisition" thr:count="9491" title="Italien" opds:facetGroup="Langue" rel="http://opds-spec.org/facet" href="/store/top.atom?category=FBFIC027000&amp;lang=it"/>
    <entry>
        <title>La ran&#231;on du d&#233;sir</title>
        <id>http://www.feedbooks.com/item/2707366</id>
        <updated>2018-05-08T10:56:59Z</updated>
        <dcterms:identifier xsi:type="dcterms:URI">urn:ISBN:9782290142233</dcterms:identifier>
        <dcterms:source xsi:type="dcterms:URI">urn:ISBN:9782290142264</dcterms:source>
        <dcterms:language>fr</dcterms:language>
        <dcterms:publisher>J'ai Lu</dcterms:publisher>
        <dcterms:issued>2018-04-24</dcterms:issued>
        <dcterms:extent>384 pages</dcterms:extent>
        <dcterms:extent>2 Mo</dcterms:extent>
        <author>
            <name>Penelope Williamson</name>
            <uri>http://www.feedbooks.com/search?query=contributor%3A%22Penelope+Williamson%22</uri>
        </author>
        <published>2018-03-30T11:08:47Z</published>
        <summary>&#202;tre servante dans une auberge du port de Boston n&#8217;offre gu&#232;re de perspectives d&#8217;avenir. Mais Angie est pauvre et doit trouver un moyen pour survivre. Aussi d&#233;cide-t-elle de saisir sa chance lorsqu&#8217;elle tombe sur une annonce : dans le Maine, un p&#232;...</summary>
        <category term="FBFIC000000" scheme="http://www.feedbooks.com/categories" label="Fiction"/>
        <category term="FBFIC027000" scheme="http://www.feedbooks.com/categories" label="Litt&#233;rature sentimentale"/>
        <category term="FBFIC027050" scheme="http://www.feedbooks.com/categories" label="Historique"/>
        <link type="text/html" title="Voir sur Feedbooks" href="http://www.feedbooks.com/item/2707366" rel="alternate"/>
        <link type="image/jpeg" href="http://covers.feedbooks.net/item/2707366.jpg?size=large&amp;t=1522400930" rel="http://opds-spec.org/image"/>
        <link type="image/jpeg" href="http://covers.feedbooks.net/item/2707366.jpg?size=large&amp;t=1522400930" rel="http://opds-spec.org/image/thumbnail"/>
        <link type="text/html" rel="http://opds-spec.org/acquisition/buy" href="https://www.feedbooks.com/item/2707366/buy">
            <opds:price currencycode="EUR">5.99</opds:price>
            <opds:indirectAcquisition type="application/epub+zip"/>
        </link>
        <link type="application/epub+zip" rel="http://opds-spec.org/acquisition/sample" href="http://www.feedbooks.com/item/2707366/preview"/>
        <link type="application/atom+xml;type=entry;profile=opds-catalog" title="Entr&#233;e compl&#232;te" rel="alternate" href="http://www.feedbooks.com/item/2707366.atom"/>
    </entry>
</feed>
XML
        );
    }

}
