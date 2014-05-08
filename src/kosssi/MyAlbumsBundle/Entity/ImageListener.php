<?php

namespace kosssi\MyAlbumsBundle\Entity;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

/**
 * Class ImageListener
 *
 * @author Simon Constans <kosssi@gmail.com>
 */
class ImageListener
{
    /**
     * @var \kosssi\MyAlbumsBundle\Helper\ImageCacheHelper
     */
    private $imageCacheHelper;

    /**
     * @var \Symfony\Component\Filesystem\Filesystem $fs
     */
    private $fs;

    /**
     * @param \kosssi\MyAlbumsBundle\Helper\ImageCacheHelper $imageCacheHelper
     * @param \Symfony\Component\Filesystem\Filesystem       $fs
     */
    public function __construct($imageCacheHelper, $fs)
    {
        $this->imageCacheHelper = $imageCacheHelper;
        $this->fs = $fs;
    }

    /**
     * @param Image              $image
     * @param LifecycleEventArgs $event
     */
    public function prePersist(Image $image, LifecycleEventArgs $event)
    {
        $now = new \Datetime();

        $image->setCreatedAt($now);
        $image->setUpdatedAt($now);

        $this->imageCacheHelper->generate($image->getWebPath());
    }

    /**
     * @param Image              $image
     * @param PreUpdateEventArgs $event
     */
    public function preUpdate(Image $image, PreUpdateEventArgs $event)
    {
        $now = new \Datetime();

        $image->setUpdatedAt($now);
    }

    /**
     * @param Image              $image
     * @param LifecycleEventArgs $event
     */
    public function postRemove(Image $image, LifecycleEventArgs $event)
    {
        $this->imageCacheHelper->remove($image->getWebPath());
        $this->fs->remove($image->getPath());
    }
}
