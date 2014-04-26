<?php

namespace kosssi\MyAlbumsBundle\Tests\LiipImagine;

use kosssi\MyAlbumsBundle\LiipImagine\FilterConfig;

/**
 * Class FilterConfigTest
 *
 * @author Simon Constans <kosssi@gmail.com>
 */
class FilterConfigTest extends \PHPUnit_Framework_TestCase
{
    /**
     * test function getFiltersNames with no configuration
     */
    public function testGetFiltersNamesWithEmptyConfig()
    {
        $filterConfig = new FilterConfig(array());
        $filtersNames = $filterConfig->getFiltersNames();

        $this->assertEquals(array(), $filtersNames);
    }

    /**
     * test function getFiltersNames with configuration
     */
    public function testGetFiltersNamesWithConfig()
    {
        $filterConfig = new FilterConfig(array('filterName1' => null, 'filterName2' => null));
        $filtersNames = $filterConfig->getFiltersNames();

        $this->assertEquals(array('filterName1', 'filterName2'), $filtersNames);
    }
}
