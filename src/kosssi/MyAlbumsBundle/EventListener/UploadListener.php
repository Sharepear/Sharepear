<?php

namespace kosssi\MyAlbumsBundle\EventListener;

use kosssi\MyAlbumsBundle\Entity\Image;
use kosssi\MyAlbumsBundle\Entity\Album;
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
     * @var \kosssi\MyAlbumsBundle\Repository\AlbumRepository
     */
    private $albumRepository;

    /**
     * @var \Symfony\Component\Security\Core\SecurityContext
     */
    protected $securityContext;

    /**
     * @param \Doctrine\ORM\EntityManager                       $em
     * @param \kosssi\MyAlbumsBundle\Repository\AlbumRepository $albumRepository
     * @param \Symfony\Component\Security\Core\SecurityContext  $securityContext
     */
    public function __construct($em, $albumRepository, $securityContext)
    {
        $this->em = $em;
        $this->albumRepository = $albumRepository;
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
        /** @var Album $album */
        $album = $this->albumRepository->findOneById($event->getRequest()->get('album_id'));
        $user = $this->securityContext->getToken()->getUser();

        if (!$album || $album->getCreatedBy() == $user) {
            $image = new Image();
            $image->setName(pathinfo($originalName, PATHINFO_FILENAME));
            $image->setPath($file->getRealPath());
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
