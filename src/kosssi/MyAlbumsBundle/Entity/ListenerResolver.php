<?php

namespace kosssi\MyAlbumsBundle\Entity;

use Doctrine\ORM\Mapping\DefaultEntityListenerResolver;

class ListenerResolver extends DefaultEntityListenerResolver
{
    public function __construct($container)
    {
        $this->container = $container;
    }

    public function resolve($className)
    {
        $id = null;
        if ($className === 'kosssi\MyAlbumsBundle\Entity\ImageListener') {
            $id = 'kosssi_my_albums.listener.image';
        }

        if (is_null($id)) {
            return new $className();
        } else {
            return $this->container->get($id);
        }
    }
}
