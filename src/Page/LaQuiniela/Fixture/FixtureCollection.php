<?php

namespace subzeta\SelaeScraper\Page\LaQuiniela\Fixture;

class FixtureCollection
{
    private $fixtures = [];

    public static function fromArray(array $fixtures)
    {
        $collection = new self();

        foreach ($fixtures as $fixture) {
            $collection->fixtures[] = new Fixture(...array_values($fixture));
        }

        return $collection;
    }

    /** @return Fixture[] */
    public function all()
    {
        return $this->fixtures;
    }

    public function isEmpty()
    {
        return empty($this->fixtures);
    }
}
