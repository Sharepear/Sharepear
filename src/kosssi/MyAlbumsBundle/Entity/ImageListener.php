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
     * @var \Liip\ImagineBundle\Imagine\Cache\CacheManager
     */
    private $cacheManager;

    /**
     * @var \Symfony\Component\Filesystem\Filesystem
     */
    private $fs;

    public function __construct($cacheManager, $fs)
    {
        $this->cacheManager = $cacheManager;
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
        $webRoot = $this->cacheManager->getWebRoot();

        // remove cache
        foreach (['xs', 's', 'm', 'l', 'xl', 'xxl'] as $filter) {
            $path = $this->cacheManager->getBrowserPath($image->getPath(), $filter);
            $this->fs->remove($webRoot . $path);
        }

        $this->fs->remove($webRoot . $image->getPath());
    }
}
