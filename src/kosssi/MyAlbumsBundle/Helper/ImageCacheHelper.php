<?php

namespace kosssi\MyAlbumsBundle\Helper;

/**
 * Class ImageCacheHelper
 *
 * @author Simon Constans <kosssi@gmail.com>
 */
class ImageCacheHelper
{
    /**
     * @var \Symfony\Component\Filesystem\Filesystem
     */
    private $fs;

    /**
     * @var \Liip\ImagineBundle\Imagine\Cache\CacheManager
     */
    private $cacheManager;

    /**
     * @param \Liip\ImagineBundle\Imagine\Cache\CacheManager $fs
     * @param \Symfony\Component\Filesystem\Filesystem       $cacheManager
     */
    public function __construct($fs, $cacheManager)
    {
        $this->fs = $fs;
        $this->cacheManager = $cacheManager;
    }

    /**
     * @param string $path
     */
    public function remove($path)
    {
        $webRoot = $this->cacheManager->getWebRoot();

        foreach (['xs', 's', 'm', 'l', 'xl', 'xxl'] as $filter) {
            $this->fs->remove($webRoot . $this->cacheManager->getBrowserPath($path, $filter));
        }
    }
}
