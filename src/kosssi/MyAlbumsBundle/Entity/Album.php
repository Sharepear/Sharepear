<?php

namespace kosssi\MyAlbumsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Album
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="album")
     *
     * @var ArrayCollection $images
     */
    protected $images;

    /**
     * @ORM\Column(type="string", length=255, name="album_name")
     *
     * @var string $name
     */
    protected $name;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }
}
