<?php

namespace kosssi\MyAlbumsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use kosssi\MyAlbumsBundle\Entity\User;

/**
 * Class LoadUserData
 *
 * @author Simon Constans <kosssi@gmail.com>
 */
class LoadUserData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('username');
        $user->setPlainPassword('pa$$word');
        $user->setEmail('username@example.org');
        $user->setEnabled(true);

        $manager->persist($user);
        $manager->flush();
    }
}
