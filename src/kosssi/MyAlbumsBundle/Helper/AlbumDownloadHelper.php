<?php

namespace kosssi\MyAlbumsBundle\Helper;

use kosssi\MyAlbumsBundle\Entity\Album;
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
     * @param Album $album
     *
     * @return string
     */
    public function zipPath(Album $album)
    {
        return $this->rootDir . '/../web/uploads/pictures/' . $album->getCreatedBy() . '/' . $album->getName() . '.zip';
    }

    /**
     * @param Album $album
     */
    public function createArchive(Album $album)
    {
        $archive = new ZipArchive();
        $archive->open($this->zipPath($album), ZipArchive::CREATE);
        /** @var \kosssi\MyAlbumsBundle\Entity\Image $image */
        foreach ($album->getImages() as $image) {
            $archive->addFile($image->getPath(), $image->getName() . '.' . pathinfo($image->getPath(), PATHINFO_EXTENSION));
        }
        $archive->close();
    }
}
