OPDS-parser
=====

L'objectif de cette bibliothèque est de parser les flux OPDS tel que http://www.feedbooks.com/catalog.atom

Composer
--------

Pensez à ajouter aux repository
###
    {
        "type": "vcs",
        "url": "ssh://git@intra.bookeen.com:7999/web/opds-parser.git"
    }



Utilisation
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


Il existe 3 fonctions pour parser les flux OPDS :

* parseFile : lit un flux OPDS depuis un fichier
* parseURL : lit un flux OPDS depuis une URL
* parseSearchUrl : parse le flux de type _application/opensearchdescription+xml_ pour connaître les URL de recherche disponibles



Exemple
--------
Exemples de flux :

* http://www.feedbooks.com/catalog.atom
* http://longueuil.pretnumerique.ca/catalog.atom
* https://framabookin.org/b/opds/
