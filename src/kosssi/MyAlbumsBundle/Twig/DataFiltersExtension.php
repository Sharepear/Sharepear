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
     * @var \kosssi\MyAlbumsBundle\LiipImagine\FilterConfig
     */
    private $filterConfig;

    /**
     * @param \Symfony\Component\Filesystem\Filesystem         $cacheManager
     * @param \kosssi\MyAlbumsBundle\LiipImagine\FilterConfig  $filterConfig
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
        $filtersNames = $this->filterConfig->getFiltersNames();

        $dataFilters = '';
        foreach ($filtersNames as $filterName) {
            $cachePath = $this->cacheManager->getBrowserPath($path, $filterName);
            $dataFilters .= " data-$filterName=\"$cachePath\"";
        }

        return $dataFilters;
    }

    public function getFiltersConfiguration()
    {
        $filtersConfig = array();
        $filters = $this->filterConfig->getFilters();

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
