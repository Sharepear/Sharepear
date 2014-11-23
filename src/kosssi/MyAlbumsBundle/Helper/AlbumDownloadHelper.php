<?php

namespace kosssi\MyAlbumsBundle\Helper;

use kosssi\MyAlbumsBundle\Entity\Image;
use Symfony\Component\HttpKernel\KernelInterface;
use ZipArchive;

/**
 * Class AlbumDownloadHelper
 *
 * @author Simon Constans <kosssi@gmail.com>
 */
class AlbumDownloadHelper
{
    /**
     * @var string
     */
    protected $rootDir;

    /**
     * @param KernelInterface $kernel
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->rootDir = $kernel->getRootDir();
    }

    /**
     * @param Image $album
     *
     * @return string
     */
    public function zipPath(Image $album)
    {
        return $this->rootDir . '/../web/uploads/pictures/' . $album->getUser()->getUsernameCanonical() . '/' . $album->getName() . '.zip';
    }

    /**
     * @param Image $album
     */
    public function createArchive(Image $album)
    {
        $archive = new ZipArchive();
        $archive->open($this->zipPath($album), ZipArchive::CREATE);
        /** @var Image $image */
        foreach ($album->getImages() as $image) {
            $archive->addFile($image->getPath(), $image->getName() . '.' . pathinfo($image->getPath(), PATHINFO_EXTENSION));
        }
        $archive->close();
    }
}
