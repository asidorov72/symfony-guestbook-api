<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 6.4.2020 г.
 * Time: 11:25
 */

// tests/Controller/PostControllerTest.php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SystemControllerTest extends WebTestCase
{
    public function testHealthcheckGet()
    {
        $client = static::createClient();

        $client->request('GET', '/healthcheck');

        $this->assertEquals(204, $client->getResponse()->getStatusCode());
    }
}
