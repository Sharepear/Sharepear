<?php

namespace kosssi\MyAlbumsBundle\Uploader\Naming;

use kosssi\MyAlbumsBundle\Entity\User;
use Oneup\UploaderBundle\Uploader\File\FileInterface;
use Oneup\UploaderBundle\Uploader\Naming\NamerInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class ImageNamer
 *
 * @author Simon Constans <kosssi@gmail.com>
 */
class ImageNamer implements NamerInterface
{
    /**
     * @var SecurityContextInterface
     */
    private $context;

    /**
     * @param SecurityContextInterface $context
     */
    public function __construct(SecurityContextInterface $context)
    {
        $this->context = $context;
    }

    /**
     * @return User
     */
    private function getUser()
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
