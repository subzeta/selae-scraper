<?php

namespace subzeta\SelaeScraper\Page;

use subzeta\SelaeScraper\Response as ResponseInterface;

class SuccessfulResponse implements ResponseInterface
{
    public function isSuccessful() : bool
    {
        return true;
    }

    public function errorMessage() : string
    {
        return '';
    }
}
