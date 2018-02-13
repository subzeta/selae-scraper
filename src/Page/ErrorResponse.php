<?php

namespace subzeta\SelaeScraper\Page;

use subzeta\SelaeScraper\Response as ResponseInterface;

class ErrorResponse implements ResponseInterface
{
    private $errorMessage;

    public function __construct(string $errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }

    public function isSuccessful() : bool
    {
        return false;
    }

    public function errorMessage() : string
    {
        return $this->errorMessage;
    }
}
