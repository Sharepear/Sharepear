<?php

namespace kosssi\MyAlbumsBundle\Tests\Controller;

use kosssi\MyAlbumsBundle\Tests\UserWebTestCase;

/**
 * Class HomepageControllerTest
 *
 * @author Simon Constans <kosssi@gmail.com>
 */
class HomepageControllerTest extends UserWebTestCase
{
    /**
     * test homepage security
     */
    public function testHomepageSecurity()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertCount(0, $crawler->filter('html:contains("homepage")'));
    }

    /**
     * Test homepage
     */
    public function testHomepage()
    {
        $client = static::createConnectedClient();
        $crawler = $client->request('GET', '/');

        $this->assertCount(1, $crawler->filter('html:contains("Homepage")'));
    }

    /**
     * test user homepage
     */
    public function testUserHomepage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/kosssi');

        $this->assertCount(1, $crawler->filter('html:contains("Homepage")'));
    }
}
