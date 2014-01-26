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

        $form = $this->createForm('album_name', $album);

        return array(
            'album'  => $album,
            'images' => $images,
            'form'   => $form->createView(),
        );
    }

    /**
     * Edit album name
     *
     * @param Request $request
     * @param Image   $album
     *
     * @Route("/album/name/edit/{id}", name="album_name_edit")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function nameEditAction(Request $request, Image $album)
    {
        $form = $this->createForm('album_name', $album);
        $form->handleRequest($request);

        if ($form->isValid()) {
            /** @var \Doctrine\Common\Persistence\ObjectManager $em */
            $em = $this->getDoctrine()->getManager();
            $em->persist($album);
            $em->flush();
        }

        if ($request->isXmlHttpRequest()) {
            return new Response($album->getName());
        } else {
            return $this->redirect($this->generateUrl('album_show', array('id' => $album->getId())));
        }
    }
}
