<?php

namespace kosssi\MyAlbumsBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use kosssi\MyAlbumsBundle\Entity\Image;

/**
 * Class ImageListener
 *
 * @author Simon Constans <kosssi@gmail.com>
 */
class ImageListener
{
    /**
     * @var \Symfony\Component\Filesystem\Filesystem $fs
     */
    private $fs;

    /**
     * @var \kosssi\MyAlbumsBundle\Helper\ImageCacheHelper
     */
    private $imageCacheHelper;

    /**
     * @var \kosssi\MyAlbumsBundle\Helper\ImageOptimiseHelper
     */
    private $imageOptimiseHelper;

    /**
     * @var \kosssi\MyAlbumsBundle\Helper\ImageRotateHelper
     */
    private $imageRotate;

    /**
     * @param \Symfony\Component\Filesystem\Filesystem          $fs
     * @param \kosssi\MyAlbumsBundle\Helper\ImageCacheHelper    $imageCacheHelper
     * @param \kosssi\MyAlbumsBundle\Helper\ImageOptimiseHelper $imageOptimiseHelper
     * @param \kosssi\MyAlbumsBundle\Helper\ImageRotateHelper   $imageRotate
     */
    public function __construct($fs, $imageCacheHelper, $imageOptimiseHelper, $imageRotate)
    {
        $this->fs = $fs;
        $this->imageCacheHelper = $imageCacheHelper;
        $this->imageOptimiseHelper = $imageOptimiseHelper;
        $this->imageRotate = $imageRotate;
    }

    /**
     * @param Image              $image
     * @param LifecycleEventArgs $event
     */
    public function prePersist(Image $image, LifecycleEventArgs $event)
    {
        unset($event);
        $now = new \Datetime();

        $orientation = $this->imageRotate->rotateAccordingExif($image->getPath());
        $this->imageCacheHelper->generate($image->getWebPath());
        $this->imageOptimiseHelper->optimiseCaches($image->getWebPath());
        $this->imageOptimiseHelper->optimise($image->getPath());

        $image->setCreatedAt($now);
        $image->setUpdatedAt($now);
        $image->setOrientation($orientation);
    }

    /**
     * @param Image              $image
     * @param PreUpdateEventArgs $event
     */
    public function preUpdate(Image $image, PreUpdateEventArgs $event)
    {
        unset($event);
        $image->setUpdatedAt(new \Datetime());
    }

    /**
     * @param Image              $image
     * @param LifecycleEventArgs $event
     */
    public function postRemove(Image $image, LifecycleEventArgs $event)
    {
        unset($event);
        $this->imageCacheHelper->remove($image->getWebPath());
        $this->fs->remove($image->getPath());
    }
}
