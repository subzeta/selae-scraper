<?php

namespace subzeta\SelaeScraper\Page\LaQuiniela;

use subzeta\SelaeScraper\Page\LaQuiniela\Fixture\FixtureCollection;
use subzeta\SelaeScraper\Page\SuccessfulResponse;

class Response extends SuccessfulResponse
{
    private $collection;

    public function __construct(array $response)
    {
        $this->collection = $this->build($response);
    }

    public function isSuccessful() : bool
    {
        return parent::isSuccessful() && !$this->collection->isEmpty();
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
