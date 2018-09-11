OPDS-parser
=====
PHP Parser ODPS compliant. This library is intended to parse OPDS feeds.
Feed examples : 

* http://www.feedbooks.com/catalog.atom
* http://longueuil.pretnumerique.ca/catalog.atom
* https://framabookin.org/b/opds/

Step 1: Download the Bundle
--------
Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require bookeenweb/opds-parser
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.


Step 2: Enable the Bundle
--------

    use OpdsBundle\Business\OpdsParserBusiness;
    
    ...

    /**
     * @var OpdsParserBusiness
     */
    private $odpsParser;
    
    public function __construct()
    {
        $this->odpsParser = new OpdsParserBusiness();
        ...
    }
    
Step 2: How to use
--------

* parseFile : read an OPDS feed from a file
* parseURL : read an OPDS feed from an url
* parseSearchUrl : _application/opensearchdescription+xml_ feed parser. Retrieve search urls
