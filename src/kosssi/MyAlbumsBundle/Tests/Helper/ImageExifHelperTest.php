<?php

namespace kosssi\MyAlbumsBundle\Tests\Helper;

use kosssi\MyAlbumsBundle\Entity\Image;
use kosssi\MyAlbumsBundle\Helper\ImageExifHelper;

/**
 * Class ImageExifHelperTest
 *
 * @author Simon Constans <kosssi@gmail.com>
 */
class ImageExifHelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Image
     */
    private $image;

    /**
     * @var ImageExifHelper
     */
    private $imageExifHelper;

    public function setUp()
    {
        $this->image = new Image();
        $this->image->setPath(__DIR__ . '/../Fixtures/IMAG0171.jpg');

        $this->imageExifHelper = new ImageExifHelper();
    }

    public function testGetExif()
    {
        $exif = $this->imageExifHelper->getExif($this->image);

        $this->assertInternalType('array', $exif);
    }

    public function testGetDatetime()
    {
        $this->imageExifHelper->setDatetime($this->image);

        $this->assertEquals(new \DateTime('2014:11:10 19:28:44'), $this->image->getExifDatetime());
    }
}
