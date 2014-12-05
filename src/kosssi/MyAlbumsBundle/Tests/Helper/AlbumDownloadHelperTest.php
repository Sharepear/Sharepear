<?php

namespace kosssi\MyAlbumsBundle\Tests\Helper;

use Doctrine\Common\Collections\ArrayCollection;
use kosssi\MyAlbumsBundle\Helper\AlbumDownloadHelper;
use kosssi\MyAlbumsBundle\Security\Authorization\Voter\ImageShowVoter;
use Phake;

/**
 * Class AlbumDownloadHelperTest
 */
class AlbumDownloadHelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AlbumDownloadHelper
     */
    protected $helper;

    protected $securityContext;
    protected $kernelRootDir;
    protected $album;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->album = Phake::mock('kosssi\MyAlbumsBundle\Entity\Album');

        $this->kernelRootDir = __DIR__ . '/upload';

        $kernel = Phake::mock('Symfony\Component\HttpKernel\KernelInterface');
        Phake::when($kernel)->getRootDir()->thenReturn($this->kernelRootDir);

        $this->securityContext = Phake::mock('Symfony\Component\Security\Core\SecurityContextInterface');

        $this->helper = new AlbumDownloadHelper($kernel, $this->securityContext);
    }

    /**
     * @param string $creator
     * @param string $name
     *
     * @dataProvider provideCreatorAndName
     */
    public function testZipPath($creator, $name)
    {
        Phake::when($this->album)->getCreatedBy()->thenReturn($creator);
        Phake::when($this->album)->getName()->thenReturn($name);

        $this->assertSame(
            $this->kernelRootDir . '/../web/uploads/pictures/' . $creator . '/' .$name . '.zip',
            $this->helper->zipPath($this->album)
        );
    }

    /**
     * @return array
     */
    public function provideCreatorAndName()
    {
        return array(
            array('kosssi', 'foo'),
            array('nicolasThal', 'bar'),
        );
    }

    /**
     * Test archive creation
     */
    public function testCreateArchive()
    {
        $creator = 'kosssi';
        $name = 'bar';
        $image1 = Phake::mock('kosssi\MyAlbumsBundle\Entity\Image');
        Phake::when($image1)->getPath()->thenReturn(__DIR__ . '/upload/path1.png');
        Phake::when($image1)->getName()->thenReturn('name1');
        Phake::when($this->securityContext)->isGranted(ImageShowVoter::IMAGE_SHOW, $image1)->thenReturn(true);
        $image2 = Phake::mock('kosssi\MyAlbumsBundle\Entity\Image');
        Phake::when($this->securityContext)->isGranted(ImageShowVoter::IMAGE_SHOW, $image1)->thenReturn(false);
        $images = new ArrayCollection();
        $images->add($image1);
        $images->add($image2);
        Phake::when($this->album)->getCreatedBy()->thenReturn($creator);
        Phake::when($this->album)->getName()->thenReturn($name);
        Phake::when($this->album)->getImages()->thenReturn($images);

        $generatedFile = $this->kernelRootDir . '/../web/uploads/pictures/' . $creator . '/' .$name . '.zip';
        if (file_exists($generatedFile)) {
            unlink($generatedFile);
        }
        $this->assertFileNotExists($generatedFile);

        $this->helper->createArchive($this->album);

        $this->assertFileExists($generatedFile);
        Phake::verify($image1, Phake::times(2))->getPath();
        Phake::verify($image2, Phake::never())->getPath();
    }
}
