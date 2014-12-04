<?php

namespace kosssi\MyAlbumsBundle\Security\Authorization\Voter;

use kosssi\MyAlbumsBundle\Entity\Album;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * Class AlbumShowVoter
 *
 * @author Simon Constans <kosssi@gmail.com>
 */
class AlbumShowVoter implements VoterInterface
{
    /**
     * @param string $attribute
     *
     * @return bool
     */
    public function supportsAttribute($attribute)
    {
        return 'ALBUM_SHOW' === $attribute;
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
                if ($token->getUser()->getUsername() == $object->getCreatedBy() || $object->isPublic()) {
                    return VoterInterface::ACCESS_GRANTED;
                }
            }
        }

        return VoterInterface::ACCESS_DENIED;
    }
}
