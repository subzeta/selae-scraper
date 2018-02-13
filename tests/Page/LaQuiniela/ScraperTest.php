<?php

namespace Tests\Page\LaQuiniela;

use Goutte\Client;
use PHPUnit\Framework\TestCase;
use subzeta\SelaeScraper\Exception\UnexpectedDomException;
use subzeta\SelaeScraper\Page\ErrorResponse;
use subzeta\SelaeScraper\Page\LaQuiniela\Response;
use subzeta\SelaeScraper\Page\LaQuiniela\Fixture\FixtureCollection;
use subzeta\SelaeScraper\Page\LaQuiniela\Scraper;
use Symfony\Component\DomCrawler\Crawler;

class ScraperTest extends TestCase
{
    /** @var Client|\Mockery\Mock */
    private $client;
    /** @var Scraper */
    private $scraper;

    const A_RESPONSE = [
        [
            'Villarreal-Alavés',
            '1-2',
            '2',
        ],
        [
            'Málaga-At. Madrid',
            '0-1',
            '2',
        ],
        [
            'Leganés-Eibar',
            '0-1',
            '2',
        ],
        [
            'Real Madrid-Real Sociedad',
            '5-2',
            '1',
        ],
        [
            'Sevilla-Girona',
            '1-0',
            '1',
        ],
        [
            'Celta-Espanyol',
            '11/02/2018',
            '18:30',
        ],
        [
            'Valencia-Levante',
            '11/02/2018',
            '20:45',
        ],
        [
            'Cádiz-R. Oviedo',
            '2-1',
            '1',
        ],
        [
            'Almería-Osasuna',
            '0-1',
            '2',
        ],
        [
            'Albacete-Gimnàstic',
            '0-1',
            '2',
        ],
        [
            'Huesca-Cultural',
            '11/02/2018',
            '16:00',
        ],
        [
            'Reus-Lorca',
            '11/02/2018',
            '18:00',
        ],
        [
            'Tenerife-Córdoba',
            '11/02/2018',
            '20:00',
        ],
        [
            'Zaragoza-Lugo',
            '11/02/2018',
            '20:30',
        ],
        [
            'Barcelona-Getafe',
            '11/02/2018',
            '16:15',
        ],
    ];

    protected function setUp()
    {
        $this->client = \Mockery::mock(Client::class);

        $this->scraper = new Scraper($this->client);
    }

    protected function tearDown()
    {
        \Mockery::close();
    }

    /** @test */
    public function itShouldReturnTheExpectedResponse()
    {
        $crawler = new Crawler();
        $crawler->addContent(file_get_contents(__DIR__.'/Mock/page.html'), 'html');

        $this->client
            ->shouldReceive('request')
            ->andReturn($crawler);

        $response = $this->scraper->scrape();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertTrue($response->isSuccessful());

        $collection = $response->fixtureCollection();

        $this->assertFalse($collection->isEmpty());
        $this->assertEquals(FixtureCollection::fromArray(self::A_RESPONSE), $collection);
    }

    /** @test */
    public function itShouldThrowAnExpectedExceptionWhenContainerIsntFound()
    {
        $crawler = new Crawler();
        $crawler->addContent(file_get_contents(__DIR__.'/Mock/page_container_not_found.html'), 'html');

        $this->client
            ->shouldReceive('request')
            ->andReturn($crawler);

        $response = $this->scraper->scrape();

        $this->assertInstanceOf(ErrorResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertSame((new UnexpectedDomException())->getMessage(), $response->errorMessage());
    }

    /** @test */
    public function itShouldThrowAnExpectedExceptionWhenContainerExistsButDataCannotBeParsed()
    {
        $crawler = new Crawler();
        $crawler->addContent(file_get_contents(__DIR__.'/Mock/page_unexpected_data.html'), 'html');

        $this->client
            ->shouldReceive('request')
            ->andReturn($crawler);

        $response = $this->scraper->scrape();

        $this->assertInstanceOf(ErrorResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertSame((new UnexpectedDomException())->getMessage(), $response->errorMessage());
    }
}
