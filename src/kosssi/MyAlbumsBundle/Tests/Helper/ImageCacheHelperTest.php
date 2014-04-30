<?php

namespace kosssi\MyAlbumsBundle\Tests\Helper;

use kosssi\MyAlbumsBundle\Helper\ImageCacheHelper;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class AlbumControllerTest
 *
 * @author Simon Constans <kosssi@gmail.com>
 */
class ImageCacheHelperTest extends WebTestCase
{
    /**
     * Test cache generation
     */
    public function testCacheGeneration()
    {
        $client = static::createClient();
        $container = $client->getContainer();
        $filterConfig = $container->get('liip_imagine.filter.configuration');

        $imageCacheHelper = new ImageCacheHelper(
            $container->get('liip_imagine.cache.manager'),
            $filterConfig,
            $container->get('liip_imagine.data.manager'),
            $container->get('liip_imagine.filter.manager')
        );

        $path = '/uploads/test/test.jpg';
        $filters = $filterConfig->all();
        $cacheResolver = $container->get('liip_imagine.cache.resolver.default');

        $imageCacheHelper->generate($path);
        foreach ($filters as $filter => $value) {
            $this->assertTrue($cacheResolver->isStored($path, $filter));
        }

        $imageCacheHelper->remove($path);
        foreach ($filters as $filter => $value) {
            $this->assertFalse($cacheResolver->isStored($path, $filter));
        }
    }
}
