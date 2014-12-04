<?php

namespace kosssi\MyAlbumsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Album
 *
 * @author Simon Constans <kosssi@gmail.com>
 *
 * @ORM\Entity(repositoryClass="kosssi\MyAlbumsBundle\Repository\AlbumRepository")
 */
class Album
{
    use TimestampableEntity;
    use BlameableEntity;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     *
     * @Assert\NotBlank(groups={"name"})
     */
    private $name;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Image", mappedBy="album", cascade={"remove"})
     *
     * @Assert\Valid()
     */
    private $images;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", options={"default"=false})
     */
    private $public;

    public function __construct()
    {
        $this->public = false;
        $this->images = new ArrayCollection();
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param boolean $public
     *
     * @return $this
     */
    public function setPublic($public)
    {
        $this->public = $public;

        return $this;
    }

    /**
     * @return bool
     */
    public function isPublic()
    {
        return $this->public === true;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $images
     *
     * @return $this
     */
    public function setImages($images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param Image $image
     *
     * @return $this
     */
    public function addImage($image)
    {
        $this->images->add($image);

        return $this;
    }

    /**
     * @param Image $image
     *
     * @return $this
     */
    public function removeImage($image)
    {
        $this->images->removeElement($image);

        return $this;
    }

    /**
     * @return Image
     */
    public function getImage()
    {
        return $this->images->first();
    }
}
