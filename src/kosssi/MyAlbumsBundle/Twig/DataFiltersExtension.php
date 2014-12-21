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
     * @param \Liip\ImagineBundle\Imagine\Cache\CacheManager         $cacheManager
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
            new \Twig_SimpleFunction('getDataFilters', array($this, 'getDataFilters'), array(
                'is_safe' => array('html')
            )),
            new \Twig_SimpleFunction('getFiltersConfiguration', array($this, 'getFiltersConfiguration'), array(
                'is_safe' => array('html')
            )),
            new \Twig_SimpleFunction('getSources', array($this, 'getSources'), array(
                'is_safe' => array('html')
            )),
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
        if (is_array($filters)) {
            foreach ($filters as $filterName => $value) {
                $cachePath = $this->cacheManager->getBrowserPath($path, $filterName);
                $dataFilters .= " data-$filterName=\"$cachePath\"";
            }
        }

        return $dataFilters;
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public function getSources($path)
    {
        $filters = $this->filterConfig->all();

        $dataFilters = '';
        if (is_array($filters)) {
            foreach ($filters as $filterName => $value) {
                $cachePath = $this->cacheManager->getBrowserPath($path, $filterName);
                $dataFilters .= "<source srcset=\"$cachePath\" media=\"(max-width: " . $value['filters']['relative_resize']['widen'] . "px)\">";
            }
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

        if (is_array($filters)) {
            foreach ($filters as $key => $filter) {
                $filtersConfig[] = array('name' => $key, 'value' => $filter['filters']['relative_resize']['widen']);
            }
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
