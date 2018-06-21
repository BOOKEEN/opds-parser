<?php

namespace OpdsBundle\Command;

use OpdsBundle\Business\OpdsParserBusiness;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends ContainerAwareCommand
{
    /**
     * @var OpdsParserBusiness
     */
    private $odpsParser;
    
    public function __construct(OpdsParserBusiness $odpsParser)
    {
        $this->odpsParser = $odpsParser;
        
        parent::__construct();
    }
    
    
    protected function configure()
    {
        $this
            ->setName('test:test')
            ->setDescription('test')
            ->addArgument('numTest', InputArgument::REQUIRED, 'n° du test')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('--------- BEGIN');
        
        switch ($input->getArgument('numTest')) {
            case 1:
                $url = 'http://www.feedbooks.com/catalog.atom';
                break;
            case 2:
                $url = 'http://www.feedbooks.com/store/categories/FBFIC000000.atom';
                break;
            case 3:
                $url = 'http://www.feedbooks.com/store/top.atom?category=FBFIC027000';
                break;
            case 4:
               // $url = 'http://www.feedbooks.com/item/2707366.atom';
                $url = 'http://www.feedbooks.com/item/988014.atom';
                break;
        }
        
        $r = $this->odpsParser->parseURL($url, array('Accept-Language: fr-fr,fr;'));
//        dump($r);
        
        $output->writeln('END ---------');
    }

}
