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
     * @var \kosssi\MyAlbumsBundle\Helper\ImageRotateHelper
     */
    private $imageRotate;

    /**
     * @param \Doctrine\ORM\EntityManager                       $em
     * @param \kosssi\MyAlbumsBundle\Repository\ImageRepository $imageRepository
     * @param \kosssi\MyAlbumsBundle\Helper\ImageRotateHelper   $imageRotate
     */
    public function __construct($em, $imageRepository, $imageRotate)
    {
        $this->em = $em;
        $this->imageRepository = $imageRepository;
        $this->imageRotate = $imageRotate;
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

        // rotate
        $imagine = $this->imageRotate->rotateAccordingExif($file);

        $image = new Image();
        $image->setName(pathinfo($originalName, PATHINFO_FILENAME));
        $image->setPath('/uploads/album/' . $file->getFilename());
        $image->setOrientation($this->getOrientation($imagine));
        $this->em->persist($image);

        /** @var Image $album */
        if ($album = $this->imageRepository->findOneById($event->getRequest()->get('album_id'))) {
            $image->setAlbum($album);
            $album->addImage($image);
            $this->em->persist($album);
        }

        $this->em->flush();

        $response['image'] = $image->getId();
    }

    /**
     * @param \Imagine\Gd\Image|\Imagine\Image\ImageInterface $image
     *
     * @return string
     */
    public function getOrientation($image)
    {
        $size = $image->getSize();

        if ($size->getWidth() > $size->getHeight()) {
            return Image::ORIENTATION_LANDSCAPE;
        } else {
            return Image::ORIENTATION_PORTRAIT;
        }
    }
}
