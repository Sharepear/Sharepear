<?php

namespace kosssi\MyAlbumsBundle\Controller;

use kosssi\MyAlbumsBundle\Entity\Image;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use kosssi\MyAlbumsBundle\Entity\Album;
use kosssi\MyAlbumsBundle\Form\AlbumType;

/**
 * Album controller.
 */
class AlbumController extends Controller
{
    /**
     * Show homepage
     *
     * @Route("/", name="homepage")
     * @Template("kosssiMyAlbumsBundle:Album:show.html.twig")
     */
    public function homepageAction()
    {
        $imageRepository = $this->get('kosssi_my_albums.repository.image');
        $images = $imageRepository->findBy(array('album' => null));

        return compact('images');
    }

    /**
     * Show homepage
     *
     * @Route("/album/{id}", name="album_show")
     * @Template()
     */
    public function showAction(Image $album)
    {
        $imageRepository = $this->get('kosssi_my_albums.repository.image');
        $images = $imageRepository->findBy(array('album' => $album));

        return compact('album', 'images');
    }
}
