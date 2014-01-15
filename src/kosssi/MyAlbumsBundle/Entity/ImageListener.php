<?php

namespace kosssi\MyAlbumsBundle\Entity;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class ImageListener
{
    public function __construct()
    {
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
}
