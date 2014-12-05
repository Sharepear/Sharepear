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
            return array(
                'user_count' => $this->get('kosssi_my_albums.repository.user')->count(),
                'image_count' => $this->get('kosssi_my_albums.repository.image')->count(),
            );
        }

        $albums = $this->get('kosssi_my_albums.repository.album')->findBy(
            array('createdBy' => $this->getUser()->getUsername()),
            array('createdAt' => 'DESC')
        );

        return $this->render(
            'kosssiMyAlbumsBundle:Album:list.html.twig',
            array(
                'albums' => $albums,
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
     * @Config\Template("kosssiMyAlbumsBundle:Album:list.html.twig")
     *
     * @return array
     */
    public function userHomepageAction(User $user)
    {
        $albums = $this->get('kosssi_my_albums.repository.album')->findBy(
            array(
                'createdBy' => $user->getUsername(),
                'public' => true,
            ),
            array(
                'createdAt' => 'ASC'
            )
        );

        return array(
            'albums' => $albums,
            'shared_album' => true,
        );
    }
}
