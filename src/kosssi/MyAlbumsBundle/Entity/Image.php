<?php

namespace kosssi\MyAlbumsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vlabs\MediaBundle\Entity\BaseFile as VlabsFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Image extends VlabsFile
{
    /**
     * @var string $path
     *
     * @ORM\Column(name="path", type="string", length=255)
     * @Assert\Image()
     */
    protected $path;

    /**
     * @ORM\ManyToOne(targetEntity="Album", inversedBy="images")
     * @ORM\JoinColumn(name="album_id", referencedColumnName="id")
     */
    protected $album;

    /**
     * @param mixed $album
     */
    public function setAlbum($album)
    {
        $this->album = $album;
    }

    /**
     * @return mixed
     */
    public function getAlbum()
    {
        return $this->album;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }
}
