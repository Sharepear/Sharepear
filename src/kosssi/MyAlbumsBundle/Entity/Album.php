<?php

namespace kosssi\MyAlbumsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vlabs\MediaBundle\Annotation\Vlabs;
use Vlabs\MediaBundle\Entity\BaseFile as VlabsFile;

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
     * @ORM\Column(type="string", length=255, name="album_name")
     *
     * @var string $name
     */
    protected $name;

    /**
     * @var VlabsFile
     *
     * @ORM\OneToOne(targetEntity="Image", cascade={"persist", "remove"}, orphanRemoval=true))
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="image", referencedColumnName="id")
     * })
     *
     * @Vlabs\Media(identifier="image_entity", upload_dir="files/images")
     * @Assert\Valid()
     */
    private $image;

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
     * @param \Vlabs\MediaBundle\Entity\BaseFile $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return \Vlabs\MediaBundle\Entity\BaseFile
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
}
