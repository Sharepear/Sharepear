<?php

namespace kosssi\MyAlbumsBundle\Helper;

/**
 * Class ImageOptimiseHelper
 *
 * @author Simon Constans <kosssi@gmail.com>
 */
class ImageOptimiseHelper
{
    /**
     * @var string
     */
    private $webPath;

    /**
     * @var \Imagine\Gd\Imagine
     */
    private $imagine;

    /**
     * @var \Liip\ImagineBundle\Imagine\Filter\FilterConfiguration
     */
    private $filterConfig;

    /**
     * @var \Liip\ImagineBundle\Imagine\Cache\CacheManager
     */
    private $cacheManager;

    /**
     * @param string                                                 $rootDir
     * @param \Imagine\Gd\Imagine                                    $imagine
     * @param \Liip\ImagineBundle\Imagine\Cache\CacheManager         $cacheManager
     * @param \Liip\ImagineBundle\Imagine\Filter\FilterConfiguration $filterConfig
     */
    function __construct($rootDir, $imagine, $cacheManager, $filterConfig)
    {
        $this->imagine = $imagine;
        $this->cacheManager = $cacheManager;
        $this->filterConfig = $filterConfig;
        $this->webPath = $rootDir . '/../web';
    }

    public function optimiseCaches($path)
    {
        $filters = $this->filterConfig->all();

        foreach ($filters as $filter => $value) {
            $cachePath = $this->webPath . '/media' . split('/media', $this->cacheManager->resolve($path, $filter), 2)[1];
            $this->optimise($cachePath);
        }
    }

    /**
     * @param string $path
     */
    public function optimise($path)
    {
        $this->imagine
            ->open($path)
            ->save($path);
    }
}
