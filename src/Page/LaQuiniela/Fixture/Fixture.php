<?php

namespace subzeta\SelaeScraper\Page\LaQuiniela\Fixture;

class Fixture
{
    private $name;
    private $score;
    private $result;

    public function __construct(string $name, string $score, string $result)
    {
        $this->name = $name;
        $this->score = $score;
        $this->result = $result;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function score() : string
    {
        return $this->score;
    }

    public function result() : string
    {
        return $this->result;
    }
}
