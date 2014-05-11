<?php

namespace kosssi\MyAlbumsBundle\Tests\Helper;

use Imagine\Gmagick\Imagine;
use Imagine\Image\ImageInterface;
use kosssi\MyAlbumsBundle\Helper\ImageOptimiseHelper;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Liip\ImagineBundle\Imagine\Filter\FilterConfiguration;
use Phake;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class ImageOptimiseHelperTest
 *
 * @author Simon Constans <kosssi@gmail.com>
 */
class ImageOptimiseHelperTest extends WebTestCase
{
    /**
     * Test cache generation
     */
    public function testOptimise()
    {
        $client = static::createClient();
        $container = $client->getContainer();
        $rootDir = $container->getParameter('kernel.root_dir');
        $imagePath = $rootDir . '/../web/uploads/test/test.jpg';
        $imageOptimisePath = $rootDir . '/../web/uploads/test/optimise.jpg';

        $imageOptimiseHelper = new ImageOptimiseHelper(
            $rootDir,
            $container->get('liip_imagine'),
            $container->get('liip_imagine.cache.manager'),
            $container->get('liip_imagine.filter.configuration')
        );

        $fs = $container->get('filesystem');
        $fs->copy($imagePath, $imageOptimisePath);
        $imageOptimiseHelper->optimise($imageOptimisePath);

        $this->assertLessThan(filesize($imagePath), filesize($imageOptimisePath));

        $fs->remove($imageOptimisePath);
    }

    /**
     * test optimiseCaches
     */
    public function testOptimiseCaches()
    {
        $rootDir = "";
        $imagine = Phake::mock(Imagine::class);
        $cacheManager = Phake::mock(CacheManager::class);
        $filterConfig = Phake::mock(FilterConfiguration::class);
        $path = "/test.jpg";
        $filterName = "xl";
        $filters = [$filterName => null];
        $imageInterface = Phake::mock(ImageInterface::class);

        Phake::when($filterConfig)->all()->thenReturn($filters);
        Phake::when($cacheManager)->resolve($path, $filterName)->thenReturn("/blabla/media/test/me.jpg");
        Phake::when($imagine)->open(Phake::anyParameters())->thenReturn($imageInterface);

        $imageOptimiseHelper = new ImageOptimiseHelper($rootDir, $imagine, $cacheManager, $filterConfig);
        $imageOptimiseHelper->optimiseCaches($path);

        Phake::verify($cacheManager, Phake::times(1))->resolve($path, $filterName);
        Phake::verify($imagine, Phake::times(1))->open(Phake::anyParameters());
    }
}
