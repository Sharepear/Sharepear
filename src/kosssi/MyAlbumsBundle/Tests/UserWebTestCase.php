<?php

namespace kosssi\MyAlbumsBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class UserWebTestCase
 *
 * @author Simon Constans <kosssi@gmail.com>
 */
class UserWebTestCase extends WebTestCase
{
    /**
     * @param array $options
     * @param array $server
     *
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    public static function createConnectedClient(array $options = array(), array $server = array())
    {
        return static::createClient(
            $options,
            array_merge(
                $server,
                [
                    'PHP_AUTH_USER' => 'username',
                    'PHP_AUTH_PW'   => 'pa$$word',
                ]
            )
        );
    }
}
