<?php

namespace kosssi\MyAlbumsBundle\EventListener;

use kosssi\MyAlbumsBundle\Entity\Image;
use Oneup\UploaderBundle\Event\PostPersistEvent;

/**
 * Class UploadListener
 *
 * @author Simon Constans <kosssi@gmail.com>
 */
class UploadListener
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @var \kosssi\MyAlbumsBundle\Repository\ImageRepository
     */
    private $imageRepository;

    /**
     * @var \Symfony\Component\Security\Core\SecurityContext
     */
    protected $securityContext;

    /**
     * @param \Doctrine\ORM\EntityManager                       $em
     * @param \kosssi\MyAlbumsBundle\Repository\ImageRepository $imageRepository
     * @param \Symfony\Component\Security\Core\SecurityContext  $securityContext
     */
    public function __construct($em, $imageRepository, $securityContext)
    {
        $this->em = $em;
        $this->imageRepository = $imageRepository;
        $this->securityContext = $securityContext;
    }

    /**
     * @param PostPersistEvent $event
     */
    public function onUpload(PostPersistEvent $event)
    {
        /** @var \Symfony\Component\HttpFoundation\File\File $file */
        $file = $event->getFile();
        $response = $event->getResponse();
        $originalName = $event->getRequest()->files->all()['file']->getClientOriginalName();
        /** @var Image $album */
        $album = $this->imageRepository->findOneById($event->getRequest()->get('album_id'));
        $user = $this->securityContext->getToken()->getUser();

        if (!$album || $album->getUser() == $user) {
            $image = new Image();
            $image->setName(pathinfo($originalName, PATHINFO_FILENAME));
            $image->setPath($file->getRealPath());
            $image->setUser($user);
            $image->setPublic(false);
            $this->em->persist($image);

            if ($album) {
                $image->setAlbum($album);
                $album->addImage($image);
            }

            $this->em->flush();

            $response['image'] = $image->getId();
        }
    }
}
