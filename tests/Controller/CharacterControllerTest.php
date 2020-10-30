<?php


namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CharacterControllerTest extends WebTestCase
{
    private $client;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    /**
     * Tests index
     */
    public function testIndex()
    {
        $this->client->request('GET','/character/index');

        $this->assertJsonResponse();
    }

    /**
     * Tests redirect index
     */
    public function testRedirectIndex()
    {
        $this->client->request('GET','/character');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Tests display
     */
    public function testDisplay()
    {
        $this->client->request('GET','/character/display/d6e67912f220523143ec25b972c68a997878ddf3');

        $this->assertJsonResponse();
    }

    /**
     * Asserts that a response is in json
     */
    public function assertJsonResponse()
    {
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type','application/json'),$response->headers);
    }

    /**
     * Tests bad Identifider
     */
    public function testBadIdentifier()
    {
        $this->client->request('GET','/character/display/badIdentifier');
        $this->assertError404($this->client->getResponse()->getStatusCode());
    }

    /**
     * Asserts that Response returns 404
     */
    public function assertError404($statusCode)
    {
        $this->assertEquals(404, $statusCode);
    }

    /**
     * Tests inexisting identifier
     */
    public function testInexistingIdentifier()
    {
        $this->client->request('GET', '/character/display/d6e67912f220523143ec25b972c68a99787error');
        $this->assertError404($this->client->getREsponse()->getStatusCode());
    }
}