<?php

namespace subzeta\SelaeScraper\Page\LaQuiniela;

use subzeta\SelaeScraper\BaseScraper;
use subzeta\SelaeScraper\Page\ErrorResponse;
use subzeta\SelaeScraper\Exception\UnexpectedDomException;
use Symfony\Component\DomCrawler\Crawler;

class Scraper extends BaseScraper
{
    public function scrape()
    {
        try {
            return new Response($this->parse());
        } catch (UnexpectedDomException $e) {
            return new ErrorResponse($e ->getMessage());
        }
    }

    protected function endpoint(): string
    {
        return 'https://www.loteriasyapuestas.es/es/la-quiniela';
    }

    private function parse(): array
    {
        $crawler = $this->client
            ->request('GET', $this->endpoint())
            ->filter('.contedorResultados');

        if ($crawler->count() === 0) {
            throw new UnexpectedDomException();
        }

        $fixtures = [];
        $crawler->filter('.puntosSusp > li')->each(function (Crawler $node) use (&$fixtures){
            $fixtures[] = utf8_decode($node->text());
        });

        $scores = [];
        $crawler->filter('.cuerpoRegionRight > ul')->eq(0)->filter('li')->each(function (Crawler $node) use (&$scores){
            $scores[] = $node->text();
        });

        $results = [];
        $crawler->filter('.cuerpoRegionRight > ul')->eq(1)->filter('li')->each(function (Crawler $node) use (&$results){
            $results[] = $node->text();
        });

        if (count($fixtures) !== 15 || count($scores) !== 15 || count($results) !== 15) {
            throw new UnexpectedDomException();
        }
        $output = [];
        foreach ($fixtures as $k => $fixture) {
            $output[] = [
                'name' => $fixture,
                'score' => $scores[$k],
                'result' => $results[$k],
            ];
        }

        return $output;
    }
}
