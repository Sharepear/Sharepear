<?php

namespace kosssi\MyAlbumsBundle\LiipImagine;

use Liip\ImagineBundle\Imagine\Filter\FilterConfiguration;

/**
 * Class FilterConfiguration
 *
 * @author Simon Constans <kosssi@gmail.com>
 */
class FilterConfig extends FilterConfiguration
{
    /**
     * return all filters names
     *
     * @return array
     */
    public function getFiltersNames()
    {
        $filtersNames = array();

        foreach ($this->filters as $filterName => $filterValue) {
            $filtersNames[] = $filterName;
        }

        return $filtersNames;
    }
}
