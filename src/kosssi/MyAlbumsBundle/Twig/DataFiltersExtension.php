<?php

namespace kosssi\MyAlbumsBundle\Twig;

/**
 * Class DataFiltersExtension
 *
 * @author Simon Constans <kosssi@gmail.com>
 */
class DataFiltersExtension extends \Twig_Extension
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
     * @param \Symfony\Component\Filesystem\Filesystem               $cacheManager
     * @param \Liip\ImagineBundle\Imagine\Filter\FilterConfiguration $filterConfig
     */
    public function __construct($cacheManager, $filterConfig)
    {
        $this->cacheManager = $cacheManager;
        $this->filterConfig = $filterConfig;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('getDataFilters', array($this, 'getDataFilters')),
            new \Twig_SimpleFunction('getFiltersConfiguration', array($this, 'getFiltersConfiguration')),
        );
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public function getDataFilters($path)
    {
        $filters = $this->filterConfig->all();

        $dataFilters = '';
        foreach ($filters as $filterName => $value) {
            $cachePath = $this->cacheManager->getBrowserPath($path, $filterName);
            $dataFilters .= " data-$filterName=\"$cachePath\"";
        }

        return $dataFilters;
    }

    /**
     * @return string
     */
    public function getFiltersConfiguration()
    {
        $filtersConfig = array();
        $filters = $this->filterConfig->all();

        foreach ($filters as $key => $filter) {
            $filtersConfig[] = array('name' => $key, 'value' => $filter['filters']['relative_resize']['widen']);
        }

        return json_encode($filtersConfig);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'data_filters_extension';
    }
}
