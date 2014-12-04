<?php

namespace kosssi\MyAlbumsBundle\Security\Authorization\Voter;

use kosssi\MyAlbumsBundle\Entity\Album;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * Class AlbumEditVoter
 *
 * @author Simon Constans <kosssi@gmail.com>
 */
class AlbumEditVoter implements VoterInterface
{
    /**
     * @param string $attribute
     *
     * @return bool
     */
    public function supportsAttribute($attribute)
    {
        return 'ALBUM_EDIT' === $attribute;
    }

    /**
     * @param object $class
     *
     * @return bool
     */
    public function supportsClass($class)
    {
        return $class instanceof Album;
    }

    /**
     * @param TokenInterface $token
     * @param Album          $object
     * @param array          $attributes
     *
     * @return int
     */
    public function vote(TokenInterface $token, $object, array $attributes)
    {
        foreach ($attributes as $attribute) {
            if ($this->supportsAttribute($attribute) && $this->supportsClass($object)) {
                if (is_object($user = $token->getUser()) && $user->getUsername() == $object->getCreatedBy()
                    || $object->isPublic()) {
                    return VoterInterface::ACCESS_GRANTED;
                }
            }
        }

        return VoterInterface::ACCESS_DENIED;
    }
}
