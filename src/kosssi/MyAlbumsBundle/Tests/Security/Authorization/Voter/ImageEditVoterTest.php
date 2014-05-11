<?php

namespace kosssi\MyAlbumsBundle\Tests\Security\Authorization\Voter;

use kosssi\MyAlbumsBundle\Entity\Image;
use kosssi\MyAlbumsBundle\Security\Authorization\Voter\ImageEditVoter;
use Phake;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

/**
 * Class ImageEditVoterTest
 *
 * @author Simon Constans <kosssi@gmail.com>
 */
class ImageEditVoterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TokenInterface
     */
    private $token;

    /**
     * @var Image
     */
    private $object;

    /**
     * @var array
     */
    private $attributes;

    /**
     * @var ImageEditVoter
     */
    private $imageEditVoter;

    /**
     * setUp
     */
    public function setUp()
    {
        $this->token = Phake::mock(TokenInterface::class);
        $this->object = Phake::mock(Image::class);
        $this->attributes = ['IMAGE_EDIT'];
        $this->imageEditVoter = new ImageEditVoter();
    }

    /**
     * Test access denied because no support attribute
     */
    public function testAccessDeniedNoSupportAttribute()
    {
        $this->attributes = ['NOT_IMAGE_EDIT'];

        $this->assertEquals(
            VoterInterface::ACCESS_DENIED,
            $this->imageEditVoter->vote($this->token, $this->object, $this->attributes)
        );
    }

    /**
     * test access denied no support class
     */
    public function testAccessDeniedNoSupportClass()
    {
        $this->object = Phake::mock(TokenInterface::class);

        $this->assertEquals(
            VoterInterface::ACCESS_DENIED,
            $this->imageEditVoter->vote($this->token, $this->object, $this->attributes)
        );
    }

    /**
     * test access denied user not authorized
     */
    public function testAccessDeniedUserNotAuthorized()
    {
        Phake::when($this->token)->getUser()->thenReturn("user1");
        Phake::when($this->object)->getUser()->thenReturn("user2");

        $this->assertEquals(
            VoterInterface::ACCESS_DENIED,
            $this->imageEditVoter->vote($this->token, $this->object, $this->attributes)
        );
    }

    /**
     * test access granted
     */
    public function testAccessGranted()
    {
        Phake::when($this->token)->getUser()->thenReturn("user1");
        Phake::when($this->object)->getUser()->thenReturn("user1");

        $this->assertEquals(
            VoterInterface::ACCESS_GRANTED,
            $this->imageEditVoter->vote($this->token, $this->object, $this->attributes)
        );
    }
}
