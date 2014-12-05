<?php

namespace kosssi\MyAlbumsBundle\Repository;

use Doctrine\ORM\EntityRepository;
use kosssi\MyAlbumsBundle\Entity\Album;
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
     * @param Album $album
     * @param bool  $sharedAlbum
     *
     * @return array
     */
    public function getImages(Album $album, $sharedAlbum)
    {
        $criteria = [
            'album' => $album,
        ];

        if ($sharedAlbum) {
            $criteria['public'] = true;
        }

        return $this->findBy($criteria, array('exifDateTime' => 'ASC', 'createdAt' => 'ASC'));
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
