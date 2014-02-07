<?php

namespace kosssi\MyAlbumsBundle\EventListener;

use Doctrine\ORM\EntityManager;
use kosssi\MyAlbumsBundle\Entity\Image;
use kosssi\MyAlbumsBundle\Helper\ImageHelper;
use kosssi\MyAlbumsBundle\Repository\ImageRepository;
use Oneup\UploaderBundle\Event\PostPersistEvent;

/**
 * Class UploadListener
 *
 * @author Simon Constans <kosssi@gmail.com>
 */
class UploadListener
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var ImageRepository
     */
    private $imageRepository;

    /**
     * @var ImageHelper
     */
    private $imageHelper;

    public function __construct($em, $imageRepository, $imageHelper)
    {
        $this->em = $em;
        $this->imageRepository = $imageRepository;
        $this->imageHelper = $imageHelper;
    }

    public function onUpload(PostPersistEvent $event)
    {
        /** @var \Symfony\Component\HttpFoundation\File\File $file */
        $file = $event->getFile();
        $response = $event->getResponse();
        $originalName = $event->getRequest()->files->all()['file']->getClientOriginalName();

        // rotate
        $imagine = $this->imageHelper->rotateAccordingExif($file);

        $image = new Image();
        $image->setName(pathinfo($originalName, PATHINFO_FILENAME));
        $image->setPath('/uploads/album/' . $file->getFilename());
        $image->setOrientation($this->imageHelper->getOrientation($imagine));
        $this->em->persist($image);

        if ($album = $this->imageRepository->findOneById($event->getRequest()->get('album_id'))) {
            $image->setAlbum($album);
            $album->addImage($image);
            $this->em->persist($album);
        }

        $this->em->flush();

        $response['image'] = "Boom";
    }
}
