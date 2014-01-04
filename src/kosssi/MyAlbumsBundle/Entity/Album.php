<?php

namespace kosssi\MyAlbumsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Album
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, name="album_name")
     *
     * @var string $name
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="album")
     * @Assert\Valid()
     *
     * @var ArrayCollection
     */
    private $images;

    public function __constructor()
    {
        $this->images = new ArrayCollection();
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
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
     * @param ArrayCollection $images
     *
     * @return $this
     */
    public function setImages(ArrayCollection $images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param $image
     *
     * @return $this
     */
    public function addImage($image)
    {
        $this->images->add($image);

        return $this;
    }

    /**
     * @param $image
     *
     * @return $this
     */
    public function removeImage($image)
    {
        $this->images->removeElement($image);

        return $this;
    }
}
