<?php

namespace kosssi\MyAlbumsBundle\DataFixtures\ORM;

use Hautelook\AliceBundle\Alice\DataFixtureLoader;

/**
 * Fixture loader using Alice bundle
 *
 * @author Simon Constans <kosssi@gmail.com>
 */
class DataLoader extends DataFixtureLoader
{
    /**
     * {@inheritdoc}
     */
    protected function getFixtures()
    {
        return [
            __DIR__ . '/user.yml',
        ];
    }
}
