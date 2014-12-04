<?php

namespace kosssi\MyAlbumsBundle\Tests\Security\Authorization\Voter;

use Phake;

/**
 * Class VoterHelperTest
 *
 * @author Simon Constans <kosssi@gmail.com>
 */
class AssertVoter extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Symfony\Component\Security\Core\Authentication\Token\TokenInterface
     */
    protected $token;

    /**
     * @var \kosssi\MyAlbumsBundle\Entity\Image|
     */
    protected $object;

    /**
     * @var array
     */
    protected $attributes;

    /**
     * @var \Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
     */
    protected $voter;

    /**
     * setUp
     */
    public function setUp()
    {
        $this->token = Phake::mock('Symfony\Component\Security\Core\Authentication\Token\TokenInterface');
    }

    /**
     * assertVoter
     */
    public function assertVoter($access, $username1 = null, $username2 = null)
    {
        $user = Phake::mock('kosssi\MyAlbumsBundle\Entity\User');
        Phake::when($user)->getUsername()->thenReturn($username1);
        Phake::when($this->token)->getUser()->thenReturn($user);
        Phake::when($this->object)->getCreatedBy()->thenReturn($username2);

        $this->assertEquals(
            $access,
            $this->voter->vote($this->token, $this->object, $this->attributes)
        );
    }
}
