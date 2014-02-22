<?php

namespace kosssi\MyAlbumsBundle\Controller;

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
     *
     * return array
     */
    public function homepageAction()
    {
        $images = $this->get('kosssi_my_albums.repository.image')->findBy(array('album' => null));

        return array(
            'images' => $images
        );
    }
}
