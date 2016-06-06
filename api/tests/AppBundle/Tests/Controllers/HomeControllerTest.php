<?php

namespace AppBundle\Tests\Controllers;

use AppBundle\Tests\WebTestCase as TestCase;

class HomeControllerTest extends TestCase{

    public function testIndex()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/');
        $this->assertTrue($client->getResponse()->isOk());
        $this->assertCount(1, $crawler->filter('<h1>This is your homepage</h1>'));
    }
}