<?php

namespace OpdsBundle\Exception;

class OpdsParserNoTitleException extends OpdsParserException
{

    public function __construct()
    {
        parent::__construct('The title is missing from the feed.', 0, null);
    }

}
