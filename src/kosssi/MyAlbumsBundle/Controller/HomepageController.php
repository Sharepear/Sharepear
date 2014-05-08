<?php

namespace kosssi\MyAlbumsBundle\Controller;

use kosssi\MyAlbumsBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Config;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * The homepage controller.
 */
class HomepageController extends Controller
{
    /**
     * Show homepage
     *
     * @Config\Route("/", name="homepage")
     * @Config\Template("kosssiMyAlbumsBundle:Album:show.html.twig")
     * @Config\Security("has_role('ROLE_USER')")
     *
     * return array
     */
    public function homepageAction()
    {
        $images = $this->get('kosssi_my_albums.repository.image')->findBy(
            array(
                'album' => null,
                'user' => $this->getUser(),
            )
        );

        return array(
            'images' => $images
        );
    }

    /**
     * Show user homepage
     *
     * @param User $user
     *
     * @Config\Route("/{username}", name="user_homepage")
     * @Config\Template("kosssiMyAlbumsBundle:Album:show.html.twig")
     *
     * @return array
     */
    public function userHomepage(User $user)
    {
        $images = $this->get('kosssi_my_albums.repository.image')->findBy(
            array(
                'album' => null,
                'user' => $user,
                'public' => true,
            )
        );

        return array(
            'images' => $images
        );
    }
}
