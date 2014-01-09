<?php

namespace kosssi\MyAlbumsBundle\EntityListener;

use Doctrine\ORM\Mapping\DefaultEntityListenerResolver;

/**
 * Class ListenerResolver
 *
 * @author Simon Constans <kosssi@gmail.com>
 */
class ListenerResolver extends DefaultEntityListenerResolver
{
    /**
     * @param $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * @param string $className
     *
     * @return object
     */
    public function resolve($className)
    {
        $id = null;
        if ($className === 'kosssi\MyAlbumsBundle\EntityListener\ImageListener') {
            $id = 'kosssi_listener_snake_size';
        }

        if (is_null($id)) {
            return new $className();
        } else {
            return $this->container->get($id);
        }
    }
}
