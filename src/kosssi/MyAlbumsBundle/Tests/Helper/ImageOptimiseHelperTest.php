<?php

namespace kosssi\MyAlbumsBundle\Tests\Helper;

use kosssi\MyAlbumsBundle\Helper\ImageOptimiseHelper;
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
}
