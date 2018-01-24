<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CoreControllerTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function urlProvider()
    {
        yield ['/'];
    }

    public function testLinkToBook()
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/');

        $link = $crawler
            ->filter('a:contains("En savoir plus")')
            ->link()
        ;

        $crawler = $client->click($link);

        $this->assertContains('/ticketing/booking', $crawler->getUri());
    }
}