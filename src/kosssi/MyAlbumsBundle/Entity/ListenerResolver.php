<?php

namespace kosssi\MyAlbumsBundle\Entity;

use Doctrine\ORM\Mapping\DefaultEntityListenerResolver;

/**
 * Class ListenerResolver
 *
 * @author Simon Constans <kosssi@gmail.com>
 */
class ListenerResolver extends DefaultEntityListenerResolver
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
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
        if ($className === 'kosssi\MyAlbumsBundle\EventListener\ImageListener') {
            $id = 'kosssi_my_albums.listener.image';
        }

        if (is_null($id)) {
            return new $className();
        } else {
            return $this->container->get($id);
        }
    }
}
