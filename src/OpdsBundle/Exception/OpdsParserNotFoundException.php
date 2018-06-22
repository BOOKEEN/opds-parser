<?php

namespace OpdsBundle\Exception;

class OpdsParserNotFoundException extends OpdsParserException
{

    public function __construct()
    {
        parent::__construct('Document is not found', 0, null);
    }

}
