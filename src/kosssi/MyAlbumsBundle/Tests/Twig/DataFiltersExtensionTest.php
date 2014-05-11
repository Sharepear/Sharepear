<?php

namespace kosssi\MyAlbumsBundle\Tests\Twig;

use kosssi\MyAlbumsBundle\Twig\DataFiltersExtension;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Liip\ImagineBundle\Imagine\Filter\FilterConfiguration;
use Phake;

/**
 * Class DataFiltersExtensionTest
 *
 * @author Simon Constans <kosssi@gmail.com>
 */
class DataFiltersExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CacheManager
     */
    private $cacheManager;

    /**
     * @var FilterConfiguration
     */
    private $filterConfig;

    /**
     * @var DataFiltersExtension
     */
    private $dataFiltersExtension;

    /**
     * setUp
     */
    public function setUp()
    {
        $this->cacheManager = Phake::mock(CacheManager::class);
        $this->filterConfig = Phake::mock(FilterConfiguration::class);

        $this->dataFiltersExtension = new DataFiltersExtension($this->cacheManager, $this->filterConfig);
    }

    /**
     * Test getFunctions
     */
    public function testGetFunctions()
    {
        $functions = $this->dataFiltersExtension->getFunctions();

        $this->assertCount(2, $functions);
        $this->assertContainsOnlyInstancesOf("Twig_SimpleFunction", $functions);
        $this->assertEquals("getDataFilters", $functions[0]->getName());
        $this->assertEquals("getFiltersConfiguration", $functions[1]->getName());
    }

    /**
     * test getDataFilters
     */
    public function testGetDataFilters()
    {
        $path = "/test";
        $cachePath = "/cache/path";
        $filterName = "xl";

        Phake::when($this->filterConfig)->all()->thenReturn([$filterName => null]);
        Phake::when($this->cacheManager)->getBrowserPath($path, $filterName)->thenReturn($cachePath);

        $dataFilters = $this->dataFiltersExtension->getDataFilters($path);

        $this->assertEquals(" data-$filterName=\"$cachePath\"", $dataFilters);
    }

    /**
     * test getFiltersConfiguration
     */
    public function testGetFiltersConfiguration()
    {
        $filterName = "xl";
        $widen = 120;
        $filterValue = ['filters' => ['relative_resize' => ['widen' => $widen]]];

        Phake::when($this->filterConfig)->all()->thenReturn([$filterName => $filterValue]);

        $filterConfig = $this->dataFiltersExtension->getFiltersConfiguration();

        $this->assertEquals("[{\"name\":\"$filterName\",\"value\":$widen}]", $filterConfig);
    }

    /**
     * test getName
     */
    public function testGetName()
    {
        $this->assertEquals("data_filters_extension", $this->dataFiltersExtension->getName());
    }
}
