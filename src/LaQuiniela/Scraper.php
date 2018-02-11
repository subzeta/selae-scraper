<?php

namespace subzeta\SelaeScraper\LaQuiniela;

use subzeta\SelaeScraper\BaseScraper;
use subzeta\SelaeScraper\Exception\ParseException;
use Symfony\Component\DomCrawler\Crawler;

class Scraper extends BaseScraper
{
    const ENDPOINT = 'https://www.loteriasyapuestas.es/es/la-quiniela';

    public function scrape() : Response
    {
        $crawler = $this->client
            ->request('GET', self::ENDPOINT)
            ->filter('.contedorResultados');

        return new Response($this->parse($crawler));
    }

    private function parse(Crawler $crawler): array
    {
        $fixtures = [];
        $crawler->filter('.puntosSusp > li')->each(function ($node) use (&$fixtures){
            $fixtures[] = utf8_decode($node->text());
        });

        $scores = [];
        $crawler->filter('.cuerpoRegionRight > ul')->eq(0)->filter('li')->each(function ($node) use (&$scores){
            $scores[] = $node->text();
        });

        $results = [];
        $crawler->filter('.cuerpoRegionRight > ul')->eq(1)->filter('li')->each(function ($node) use (&$results){
            $results[] = $node->text();
        });

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
