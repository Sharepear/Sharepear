<?php

namespace kosssi\MyAlbumsBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class UserRepository
 *
 * @author Simon Constans <kosssi@gmail.com>
 */
class UserRepository extends EntityRepository
{
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
