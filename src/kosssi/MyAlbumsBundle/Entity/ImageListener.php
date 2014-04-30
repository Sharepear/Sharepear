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
     * @param \kosssi\MyAlbumsBundle\Helper\ImageCacheHelper $imageCacheHelper
     */
    public function __construct($imageCacheHelper)
    {
        $this->imageCacheHelper = $imageCacheHelper;
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
        $this->imageCacheHelper->remove($image->getPath());
    }
}
