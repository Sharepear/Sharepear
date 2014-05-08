<?php

namespace kosssi\MyAlbumsBundle\Tests\Controller;

use kosssi\MyAlbumsBundle\Tests\UserWebTestCase;

/**
 * Class AlbumControllerTest
 *
 * @author Simon Constans <kosssi@gmail.com>
 */
class AlbumControllerTest extends UserWebTestCase
{
    /**
     * Test homepage
     */
    public function testHomepageAction()
    {
        $client = static::createConnectedClient();
        $crawler = $client->request('GET', '/');

        $this->assertCount(1, $crawler->filter('html:contains("homepage")'));
    }
}
