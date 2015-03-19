<?php

namespace kosssi\MyAlbumsBundle\Tests\Twig;

use kosssi\MyAlbumsBundle\Twig\DataFiltersExtension;
use Phake;

/**
 * Class DataFiltersExtensionTest
 *
 * @author Simon Constans <kosssi@gmail.com>
 */
class DataFiltersExtensionTest extends \PHPUnit_Framework_TestCase
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
     * @var DataFiltersExtension
     */
    private $dataFiltersExtension;

    /**
     * setUp
     */
    public function setUp()
    {
        $this->cacheManager = Phake::mock('Liip\ImagineBundle\Imagine\Cache\CacheManager');
        $this->filterConfig = Phake::mock('Liip\ImagineBundle\Imagine\Filter\FilterConfiguration');

        $this->dataFiltersExtension = new DataFiltersExtension($this->cacheManager, $this->filterConfig);
    }

    /**
     * Test getFunctions
     */
    public function testGetFunctions()
    {
        $functions = $this->dataFiltersExtension->getFunctions();

        $this->assertCount(3, $functions);
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
        $filterName = "landscape_xl";

        Phake::when($this->filterConfig)->all()->thenReturn([$filterName => null]);
        Phake::when($this->cacheManager)->getBrowserPath($path, $filterName)->thenReturn($cachePath);

        $dataFilters = $this->dataFiltersExtension->getDataFilters($path, 'landscape');

        $this->assertEquals(" data-$filterName=\"$cachePath\"", $dataFilters);
    }

    /**
     * test getFiltersConfiguration
     */
    public function testGetFiltersConfiguration()
    {
        $filterName = "landscape_xl";
        $widen = 120;
        $filterValue = ['filters' => ['relative_resize' => ['widen' => $widen]]];

        Phake::when($this->filterConfig)->all()->thenReturn([$filterName => $filterValue]);

        $filterConfig = $this->dataFiltersExtension->getFiltersConfiguration();

        //$this->assertEquals("[{\"name\":\"$filterName\",\"value\":$widen}]", $filterConfig);
        $this->assertEquals("[]", $filterConfig);
    }

    /**
     * test getName
     */
    public function testGetName()
    {
        $this->assertEquals("data_filters_extension", $this->dataFiltersExtension->getName());
    }
}
