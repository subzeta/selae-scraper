<?php

namespace subzeta\SelaeScraper\LaQuiniela;

use subzeta\SelaeScraper\LaQuiniela\Fixture\FixtureCollection;
use subzeta\SelaeScraper\Response as ResponseInterface;

class Response implements ResponseInterface
{
    private $collection;

    public function __construct(array $response)
    {
        $this->collection = $this->build($response);
    }

    public function isSuccessful() : bool
    {
        return !$this->collection->isEmpty();
    }

    public function fixtureCollection() : FixtureCollection
    {
        return $this->collection;
    }

    private function build(array $response) : FixtureCollection
    {
        return FixtureCollection::fromArray($response);
    }
}
