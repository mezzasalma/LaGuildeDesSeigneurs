<?php


namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CharacterControllerTest extends WebTestCase
{
    /**
     * Tests index
     */
    public function testIndex()
    {
        $client = static::createClient();
        $client->request('GET','/character');

        $this->assertJsonResponse($client->getResponse());
    }

    /**
     * Tests display
     */
    public function testDisplay()
    {
        $client = static::createClient();
        $client->request('GET','/character/display/d6e67912f220523143ec25b972c68a997878ddf3');

        $this->assertJsonResponse($client->getResponse());
    }

    /**
     * Asserts that a response is in json
     */
    public function assertJsonResponse($response)
    {
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type','application/json'),$response->headers);
    }
}