<?php

namespace kosssi\MyAlbumsBundle\Tests\Helper;

use kosssi\MyAlbumsBundle\Entity\Image;
use kosssi\MyAlbumsBundle\Helper\ImageRotateHelper;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class ImageRotateHelperTest
 *
 * @author Simon Constans <kosssi@gmail.com>
 */
class ImageRotateHelperTest extends WebTestCase
{
    /**
     * @var ImageRotateHelper
     */
    private $imageRotateHelper;

    /**
     * @var string
     */
    private $imagePath;

    /**
     * @var \Symfony\Component\Filesystem\Filesystem
     */
    private $fs;

    /**
     * @var \Imagine\Gd\Imagine
     */
    private $imagine;

    /**
     * setUp
     */
    public function setUp()
    {
        $client    = static::createClient();
        $container = $client->getContainer();

        $rootDir       = $container->getParameter('kernel.root_dir');
        $this->fs      = $container->get('filesystem');
        $this->imagine = $container->get('liip_imagine');

        $this->imagePath = $rootDir . "/../web/uploads/test/testRotate.jpg";
        $this->fs->copy($rootDir . "/../web/uploads/test/test.jpg", $this->imagePath);

        $this->imageRotateHelper = new ImageRotateHelper($this->imagine);
    }

    /**
     * tearDown
     */
    public function tearDown()
    {
        $this->fs->remove($this->imagePath);
    }

    /**
     * test rotate
     */
    public function testRotate()
    {
        $box = $this->imagine->open($this->imagePath)->getSize();
        $width = $box->getWidth();
        $height = $box->getHeight();

        $orientation = $this->imageRotateHelper->rotate($this->imagePath, 90);

        // test width
        $box = $this->imagine->open($this->imagePath)->getSize();
        $this->assertLessThan(2, $width - $box->getHeight());
        $this->assertEquals($height, $box->getWidth());

        // test orientation
        $this->assertEquals(Image::ORIENTATION_PORTRAIT, $orientation);
        $orientation = $this->imageRotateHelper->rotate($this->imagePath, 90);
        $this->assertEquals(Image::ORIENTATION_LANDSCAPE, $orientation);
    }

    /**
     * test rotateAccordingExif
     */
    public function testRotateAccordingExif()
    {
        $image = $this->imagine->open($this->imagePath);
        $this->assertEquals(Image::ORIENTATION_LANDSCAPE, $this->imageRotateHelper->getOrientation($image));
        $orientation = $this->imageRotateHelper->rotateAccordingExif($this->imagePath);

        $this->assertEquals(Image::ORIENTATION_PORTRAIT, $orientation);
    }
}
