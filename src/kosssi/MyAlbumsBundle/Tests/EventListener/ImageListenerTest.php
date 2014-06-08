<?php

namespace kosssi\MyAlbumsBundle\Tests\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use kosssi\MyAlbumsBundle\Entity\Image;
use kosssi\MyAlbumsBundle\EventListener\ImageListener;
use kosssi\MyAlbumsBundle\Helper\ImageCacheHelper;
use kosssi\MyAlbumsBundle\Helper\ImageOptimiseHelper;
use kosssi\MyAlbumsBundle\Helper\ImageRotateHelper;
use Phake;

/**
 * Class ImageListenerTest
 *
 * @author Simon Constans <kosssi@gmail.com>
 */
class ImageListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Symfony\Component\Filesystem\Filesystem
     */
    private $fs;

    /**
     * @var ImageCacheHelper
     */
    private $imageCacheHelper;

    /**
     * @var ImageOptimiseHelper
     */
    private $imageOptimiseHelper;

    /**
     * @var ImageRotateHelper
     */
    private $imageRotate;

    /**
     * @var ImageListener
     */
    private $imageListener;

    /**
     * setUp
     */
    public function setUp()
    {
        $this->fs = Phake::mock('Symfony\Component\Filesystem\Filesystem');
        $this->imageCacheHelper = Phake::mock(ImageCacheHelper::class);
        $this->imageOptimiseHelper = Phake::mock(ImageOptimiseHelper::class);
        $this->imageRotate = Phake::mock(ImageRotateHelper::class);
        $this->imageListener = new ImageListener(
            $this->fs, $this->imageCacheHelper, $this->imageOptimiseHelper, $this->imageRotate
        );
    }

    /**
     * test prePersist
     */
    public function testPrePersist()
    {
        $image = Phake::mock(Image::class);
        $event = Phake::mock(LifecycleEventArgs::class);
        $this->imageListener->prePersist($image, $event);

        Phake::verify($image, Phake::times(1))->setCreatedAt(Phake::anyParameters());
        Phake::verify($image, Phake::times(1))->setUpdatedAt(Phake::anyParameters());
        Phake::verify($image, Phake::times(1))->setOrientation(Phake::anyParameters());
    }

    /**
     * test preUpdate
     */
    public function testPreUpdate()
    {
        $image = Phake::mock(Image::class);
        $event = Phake::mock(PreUpdateEventArgs::class);
        $this->imageListener->preUpdate($image, $event);

        Phake::verify($image, Phake::times(1))->setUpdatedAt(Phake::anyParameters());
    }

    /**
     * test postRemove
     */
    public function testPostRemove()
    {
        $image = Phake::mock(Image::class);
        $event = Phake::mock(LifecycleEventArgs::class);
        $this->imageListener->postRemove($image, $event);

        Phake::verify($this->imageCacheHelper, Phake::times(1))->remove(Phake::anyParameters());
        Phake::verify($this->fs, Phake::times(1))->remove(Phake::anyParameters());
    }
}