<?php

namespace kosssi\MyAlbumsBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class AlbumControllerTest
 *
 * @author Simon Constans <kosssi@gmail.com>
 */
class AlbumControllerTest extends WebTestCase
{
    /**
     * Test homepage
     */
    public function testHomepageAction()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertCount(1, $crawler->filter('html:contains("homepage")'));
    }
}
