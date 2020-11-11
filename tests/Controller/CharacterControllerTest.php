<?php


namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CharacterControllerTest extends WebTestCase
{
    private $client;
    private $content;

    private static $identifier;

    public function setUp()
    {
        $this->client = static::createClient();
    }



    /**
     * Asserts that a Response is in json
     */
    public function assertJsonResponse()
    {
        $response = $this->client->getResponse();
        $this->content = json_decode($response->getContent(),true,50);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type','application/json'),$response->headers);
    }

    /**
     * Asserts that Response returns 404
     * @param $statusCode
     */
    public function assertError404($statusCode)
    {
        $this->assertEquals(404, $statusCode);
    }

    /**
     * Asserts that 'identifier' is present
     */
    public function assertIdentifier()
    {
        $this->assertArrayHasKey('identifier',$this->content);
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
     * Defines identifier
     */
    public function defineIdentifier()
    {
        self::$identifier = $this->content['identifier'];
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
     * Tests inexisting identifier
     */
    public function testInexistingIdentifier()
    {
        $this->client->request('GET', '/character/display/d6e67912f220523143ec25b972c68a99787error');

        $this->assertError404($this->client->getREsponse()->getStatusCode());
    }



    /**
     * Tests create
     */
    public function testCreate()
    {
        $this->client->request('POST','/character/create');

        $this->assertJsonResponse();
        $this->defineIdentifier();
        $this->assertIdentifier();
    }

    /**
     * Tests display
     */
    public function testDisplay()
    {
        $this->client->request('GET','/character/display/'.self::$identifier);

        $this->assertJsonResponse();
        $this->assertIdentifier();
    }

    /**
     * Tests modify
     */
    public function testModify()
    {
        $this->client->request('PUT','/character/modify/'.self::$identifier);

        $this->assertJsonResponse();
        $this->assertIdentifier();
    }

    /**
     * Tests delete
     */
    public function testDelete()
    {
        $this->client->request('DELETE','/character/delete/'.self::$identifier);

        $this->assertJsonResponse();
    }

}