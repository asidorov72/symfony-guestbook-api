<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 6.4.2020 г.
 * Time: 12:56
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FeedbackControllerTest extends WebTestCase
{
    public function testListGet()
    {
        $client = static::createClient();

        $client->request('GET', '/feedback');

        $response = $client->getResponse()->getContent();

        $responseArray = json_decode($response, true);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('id', $responseArray[0]);
        $this->assertArrayHasKey('date', $responseArray[0]);
        $this->assertArrayHasKey('author', $responseArray[0]);
        $this->assertArrayHasKey('email', $responseArray[0]);
        $this->assertArrayHasKey('title', $responseArray[0]);
        $this->assertArrayHasKey('message', $responseArray[0]);
    }

    public function testAddSuccessGet()
    {
        $client = static::createClient();

        $pathToFile  = __DIR__ . "/../../tests/testing/json/add_feedback_payload.json";
        $payloadJson = file_get_contents($pathToFile);

        $client->request(
            'POST',
            '/feedback',
            array(),
            array(),
            array('ACCEPT' => 'application/json', 'CONTENT_TYPE' => 'application/json'),
            $payloadJson
        );

        $response      = $client->getResponse()->getContent();
        $responseArray = json_decode($response, true);

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('status', $responseArray);
        $this->assertEquals('Feedback was created!', $responseArray['status']);
    }

    public function testAddUnsuccessEmptyMessageGet()
    {
        $client = static::createClient();

        $pathToFile  = __DIR__ . "/../../tests/testing/json/add_feedback_invalid_payload_empty_msg.json";
        $payloadJson = file_get_contents($pathToFile);

        $client->request(
            'POST',
            '/feedback',
            array(),
            array(),
            array('ACCEPT' => 'application/json', 'CONTENT_TYPE' => 'application/json'),
            $payloadJson
        );

        $response      = $client->getResponse()->getContent();
        $responseArray = json_decode($response, true);

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('errorMessage', $responseArray);

        $strPosInt = strpos($responseArray['errorMessage'], 'Your message must be at least');
        $this->assertNotFalse($strPosInt);
    }

    public function testAddUnsuccessInvalidEmailGet()
    {
        $client = static::createClient();

        $pathToFile  = __DIR__ . "/../../tests/testing/json/add_feedback_invalid_payload_invalid_email.json";
        $payloadJson = file_get_contents($pathToFile);

        $client->request(
            'POST',
            '/feedback',
            array(),
            array(),
            array('ACCEPT' => 'application/json', 'CONTENT_TYPE' => 'application/json'),
            $payloadJson
        );

        $response      = $client->getResponse()->getContent();
        $responseArray = json_decode($response, true);

        $strPosInt = strpos($responseArray['errorMessage'], 'mariq.nedelcheva@dirbg');

        $this->assertNotFalse($strPosInt);
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('errorMessage', $responseArray);
    }
}