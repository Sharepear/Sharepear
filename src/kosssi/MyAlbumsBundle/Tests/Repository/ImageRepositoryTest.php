<?php

namespace kosssi\MyAlbumsBundle\Tests\Repository;

use kosssi\MyAlbumsBundle\Entity\Image;
use Phake;

/**
 * Class ImageRepositoryTest
 *
 * @author Simon Constans <kosssi@gmail.com>
 */
class ImageRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test cache generation
     */
    public function testGetImage()
    {
        $em = Phake::mock('Doctrine\ORM\EntityManagerInterface');
        $class = Phake::mock('Doctrine\ORM\Mapping\ClassMetadata');
        $repository = Phake::partialMock('kosssi\MyAlbumsBundle\Repository\ImageRepository', $em, $class);
        Phake::when($repository)->findBy(Phake::anyParameters())->thenReturn(null);
        $album = Phake::mock('kosssi\MyAlbumsBundle\Entity\Image');

        $sharedAlbum = true;
        $repository->getImages($album, $sharedAlbum);
        Phake::verify($repository, Phake::times(1))->findBy(['album' => $album, 'public' => true]);

        $sharedAlbum = false;
        $repository->getImages($album, $sharedAlbum);
        Phake::verify($repository, Phake::times(1))->findBy(['album' => $album]);
    }
}
