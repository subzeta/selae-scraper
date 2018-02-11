<?php

namespace subzeta\SelaeScraper;

use Goutte\Client;

abstract class BaseScraper
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    abstract public function scrape();
}
