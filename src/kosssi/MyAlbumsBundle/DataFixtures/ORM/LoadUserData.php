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
        $manager->persist($this->createUser('username', 'pa$$word', 'username@example.org'));
        $manager->persist($this->createUser('kosssi', 'pa$$word', 'kosssi@example.org'));

        $manager->flush();
    }

    /**
     * @param string $username
     * @param string $password
     * @param string $email
     *
     * @return User
     */
    private function createUser($username, $password, $email)
    {
        $user = new User();
        $user->setUsername($username);
        $user->setPlainPassword($password);
        $user->setEmail($email);
        $user->setEnabled(true);

        return $user;
    }
}
