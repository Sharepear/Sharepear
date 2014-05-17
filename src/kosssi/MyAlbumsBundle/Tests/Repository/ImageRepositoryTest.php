<?php

namespace kosssi\MyAlbumsBundle\Tests\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use kosssi\MyAlbumsBundle\Entity\Image;
use kosssi\MyAlbumsBundle\Repository\ImageRepository;
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
        $em = Phake::mock(EntityManagerInterface::class);
        $class = Phake::mock(ClassMetadata::class);
        $repository = Phake::partialMock(ImageRepository::class, $em, $class);
        Phake::when($repository)->findBy(Phake::anyParameters())->thenReturn(null);
        $album = Phake::mock(Image::class);

        $sharedAlbum = true;
        $repository->getImages($album, $sharedAlbum);
        Phake::verify($repository, Phake::times(1))->findBy(['album' => $album, 'public' => true]);

        $sharedAlbum = false;
        $repository->getImages($album, $sharedAlbum);
        Phake::verify($repository, Phake::times(1))->findBy(['album' => $album]);
    }
}
