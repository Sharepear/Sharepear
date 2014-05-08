<?php

namespace kosssi\MyAlbumsBundle\Uploader\Naming;

use kosssi\MyAlbumsBundle\Entity\User;
use Oneup\UploaderBundle\Uploader\File\FileInterface;
use Oneup\UploaderBundle\Uploader\Naming\NamerInterface;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * Class ImageNamer
 *
 * @author Simon Constans <kosssi@gmail.com>
 */
class ImageNamer implements NamerInterface
{
    /**
     * @var \Symfony\Component\Security\Core\SecurityContext
     */
    private $context;

    /**
     * @param SecurityContext $context
     */
    public function __construct(SecurityContext $context)
    {
        $this->context = $context;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->context->getToken()->getUser();
    }

     /**
     * @param FileInterface $file
     *
     * @return string
     */
    public function name(FileInterface $file)
    {
        return sprintf('%s/%s.%s', strtolower($this->getUser()->getUsername()), uniqid(), $file->getExtension());
    }
}
