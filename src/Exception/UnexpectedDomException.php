<?php

namespace subzeta\SelaeScraper\Exception;

class UnexpectedDomException extends \Exception
{
    protected $message = 'DOM to parse isn\'t the expected one';
}
