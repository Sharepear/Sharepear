<?php

namespace kosssi\MyAlbumsBundle\Helper;
use kosssi\MyAlbumsBundle\Entity\Image;

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
     * @var \kosssi\MyAlbumsBundle\LiipImagine\FilterConfig
     */
    private $filterConfig;

    /**
     * @param \Liip\ImagineBundle\Imagine\Cache\CacheManager   $fs
     * @param \Symfony\Component\Filesystem\Filesystem         $cacheManager
     * @param \kosssi\MyAlbumsBundle\LiipImagine\FilterConfig  $filterConfig
     */
    public function __construct($fs, $cacheManager, $filterConfig)
    {
        $this->fs = $fs;
        $this->cacheManager = $cacheManager;
        $this->filterConfig = $filterConfig;
    }

    /**
     * @param string $path
     */
    public function removeFilters($path)
    {
        $webRoot = $this->cacheManager->getWebRoot();
        $filtersNames = $this->filterConfig->getFiltersNames();

        foreach ($filtersNames as $filterName) {
            $this->fs->remove($webRoot . $this->cacheManager->getBrowserPath($path, $filterName));
        }
    }

    /**
     * @param Image $image
     */
    public function removeImage(Image $image)
    {
        $webRoot = $this->cacheManager->getWebRoot();

        $this->removeFilters($image->getPath());
        $this->fs->remove($webRoot . $image->getPath());
    }
}
