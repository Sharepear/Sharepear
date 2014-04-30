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
     * @var \Liip\ImagineBundle\Imagine\Cache\CacheManager
     */
    private $cacheManager;

    /**
     * @var \Liip\ImagineBundle\Imagine\Filter\FilterConfiguration
     */
    private $filterConfig;

    /**
     * @var \Liip\ImagineBundle\Imagine\Data\DataManager
     */
    private $dataManager;

    /**
     * @var \Liip\ImagineBundle\Imagine\Filter\FilterManager
     */
    private $filterManager;

    /**
     * @param \Liip\ImagineBundle\Imagine\Cache\CacheManager         $cacheManager               $cacheManager
     * @param \Liip\ImagineBundle\Imagine\Filter\FilterConfiguration $filterConfig
     * @param \Liip\ImagineBundle\Imagine\Data\DataManager           $dataManager
     * @param \Liip\ImagineBundle\Imagine\Filter\FilterManager       $filterManager
     */
    public function __construct($cacheManager, $filterConfig, $dataManager, $filterManager)
    {
        $this->cacheManager = $cacheManager;
        $this->filterConfig = $filterConfig;
        $this->dataManager = $dataManager;
        $this->filterManager = $filterManager;
    }

    /**
     * @param string $path
     */
    public function remove($path)
    {
        $this->cacheManager->remove($path);
    }

    /**
     * @param string $path
     */
    public function generate($path)
    {
        $filters = $this->filterConfig->all();

        foreach ($filters as $filter => $value) {
            if (!$this->cacheManager->isStored($path, $filter)) {
                $binary = $this->dataManager->find($filter, $path);

                $this->cacheManager->store(
                    $this->filterManager->applyFilter($binary, $filter),
                    $path,
                    $filter
                );
            }
        }
    }
}
