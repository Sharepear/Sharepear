<?php

namespace kosssi\ExampleDoctrineEventsBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use kosssi\MyAlbumsBundle\Entity\Image;

class ImageListener
{
    public function __construct()
    {
    }

    /**
     * @param Image              $image
     * @param LifecycleEventArgs $event
     */
    public function preRemove(Image $image, LifecycleEventArgs $event)
    {
        $image->getPath();
    }
}
