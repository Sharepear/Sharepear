<?php

namespace kosssi\MyAlbumsBundle\Controller;

use kosssi\MyAlbumsBundle\Entity\Image;
use kosssi\MyAlbumsBundle\Form\AlbumType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
     * Show album
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

    /**
     * Edit album
     *
     * @param Request $request
     * @param Image   $album
     *
     * @Route("/album/edit/{id}", name="album_edit")
     *
     * @return string
     */
    public function editAction(Request $request, Image $album)
    {
        $title = '';

        if ($title = $request->get('title')) {
            $album->setName($title);

            // save entity
            $em = $this->getDoctrine()->getManager();
            $em->persist($album);
            $em->flush();
        }

        return new Response($title);
    }
}
