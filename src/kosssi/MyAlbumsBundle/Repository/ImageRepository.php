<?php

namespace kosssi\MyAlbumsBundle\Repository;

use Doctrine\ORM\EntityRepository;
use kosssi\MyAlbumsBundle\Entity\Image;

/**
 * Class ImageRepository
 *
 * @author Simon Constans <kosssi@gmail.com>
 * @method Image findOneById()
 */
class ImageRepository extends EntityRepository
{
    /**
     * @param Image $album
     * @param bool  $sharedAlbum
     *
     * @return array
     */
    public function getImages(Image $album, $sharedAlbum)
    {
        $criteria = [
            'album' => $album,
        ];

        if ($sharedAlbum) {
            $criteria['public'] = true;
        }

        return $this->findBy($criteria);
    }

    /**
     * @return integer
     */
    public function count()
    {
        return $this->createQueryBuilder('id')
            ->select('COUNT(id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
