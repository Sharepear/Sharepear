<?php

namespace kosssi\MyAlbumsBundle\Controller;

use kosssi\MyAlbumsBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Config;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * The homepage controller.
 *
 * @author Simon Constans <kosssi@gmail.com>
 */
class HomepageController extends Controller
{
    /**
     * Show homepage
     *
     * @Config\Route("/", name="homepage")
     * @Config\Template("kosssiMyAlbumsBundle:Homepage:homepage.html.twig")
     *
     * @return array
     */
    public function homepageAction()
    {
        if (null === $this->getUser()) {
            return array();
        }

        $images = $this->get('kosssi_my_albums.repository.image')->findBy(
            array(
                'album' => null,
                'user' => $this->getUser(),
            )
        );

        return $this->render(
            'kosssiMyAlbumsBundle:Album:show.html.twig',
            array(
                'images' => $images,
                'shared_album' => false,
            )
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
    public function userHomepageAction(User $user)
    {
        $images = $this->get('kosssi_my_albums.repository.image')->findBy(
            array(
                'album' => null,
                'user' => $user,
                'public' => true,
            )
        );

        return array(
            'images' => $images,
            'shared_album' => true,
        );
    }
}
