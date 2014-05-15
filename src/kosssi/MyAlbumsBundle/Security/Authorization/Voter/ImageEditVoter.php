<?php

namespace kosssi\MyAlbumsBundle\Security\Authorization\Voter;

use kosssi\MyAlbumsBundle\Entity\Image;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * Class ImageEditVoter
 *
 * @author Simon Constans <kosssi@gmail.com>
 */
class ImageEditVoter implements VoterInterface
{
    /**
     * @param string $attribute
     *
     * @return bool
     */
    public function supportsAttribute($attribute)
    {
        return 'IMAGE_EDIT' === $attribute;
    }

    /**
     * @param object $class
     *
     * @return bool
     */
    public function supportsClass($class)
    {
        return $class instanceof Image;
    }

    /**
     * @param TokenInterface $token
     * @param Image          $object
     * @param array          $attributes
     *
     * @return int
     */
    function vote(TokenInterface $token, $object, array $attributes)
    {
        foreach ($attributes as $attribute) {
            if ($this->supportsAttribute($attribute) && $this->supportsClass($object)) {
                $user = $token->getUser();

                if ($user == $object->getUser()) {
                    return VoterInterface::ACCESS_GRANTED;
                }
            }
        }

        return VoterInterface::ACCESS_DENIED;
    }
}
