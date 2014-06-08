<?php

namespace kosssi\MyAlbumsBundle\Tests\Uploader\Naming;

use kosssi\MyAlbumsBundle\Uploader\Naming\ImageNamer;
use Phake;

/**
 * Class ImageNamerTest
 *
 * @author Simon Constans <kosssi@gmail.com>
 */
class ImageNamerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test name
     */
    public function testName()
    {
        $username  = "kosssi";
        $extension = "jpg";

        $context = Phake::mock('Symfony\Component\Security\Core\SecurityContextInterface');
        $token   = Phake::mock('Symfony\Component\Security\Core\Authentication\Token\TokenInterface');
        $user    = Phake::mock('FOS\UserBundle\Model\UserInterface');
        $file    = Phake::mock('Oneup\UploaderBundle\Uploader\File\FileInterface');

        Phake::when($context)->getToken()->thenReturn($token);
        Phake::when($token)->getUser()->thenReturn($user);
        Phake::when($user)->getUsername()->thenReturn($username);
        Phake::when($file)->getExtension()->thenReturn($extension);

        $imageNamer = new ImageNamer($context);
        $uniqName1 = $imageNamer->name($file);
        $uniqName2 = $imageNamer->name($file);

        $this->assertNotEquals($uniqName1, $uniqName2);
        $this->assertStringStartsWith("$username/", $uniqName1);
        $this->assertStringStartsWith("$username/", $uniqName2);
        $this->assertStringEndsWith(".$extension", $uniqName1);
        $this->assertStringEndsWith(".$extension", $uniqName2);
    }
}
