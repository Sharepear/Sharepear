<?php

namespace kosssi\MyAlbumsBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 *
 * @author Simon Constans <kosssi@gmail.com>
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var array
     *
     * @ORM\OneToMany(
     *     targetEntity="Image",
     *     mappedBy="user"
     * )
     */
    private $images;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * @param array $images
     *
     * @return $this
     */
    public function setImages($images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * @return array
     */
    public function getImages()
    {
        return $this->images;
    }
}
