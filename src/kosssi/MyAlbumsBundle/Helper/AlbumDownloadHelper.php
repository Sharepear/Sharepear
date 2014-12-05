<?php

namespace kosssi\MyAlbumsBundle\Helper;

use kosssi\MyAlbumsBundle\Entity\Album;
use kosssi\MyAlbumsBundle\Security\Authorization\Voter\ImageShowVoter;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
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

    protected $securityContext;

    /**
     * @param KernelInterface          $kernel
     * @param SecurityContextInterface $securityContext
     */
    public function __construct(KernelInterface $kernel, SecurityContextInterface $securityContext)
    {
        $this->rootDir = $kernel->getRootDir();
        $this->securityContext = $securityContext;
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
            if ($this->securityContext->isGranted(ImageShowVoter::IMAGE_SHOW, $image)) {
                $archive->addFile($image->getPath(), $image->getName() . '.' . pathinfo($image->getPath(), PATHINFO_EXTENSION));
            }
        }
        $archive->close();
    }
}
