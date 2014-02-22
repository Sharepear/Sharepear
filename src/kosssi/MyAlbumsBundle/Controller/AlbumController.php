<?php

namespace kosssi\MyAlbumsBundle\Controller;

use kosssi\MyAlbumsBundle\Entity\Image;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Config;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Album controller.
 *
 * @Config\Route("/album")
 */
class AlbumController extends Controller
{

    /**
     * Show album
     *
     * @param Image $album
     *
     * @Config\Route("/{id}", name="album_show")
     * @Config\Template()
     *
     * @return array
     */
    public function showAction(Image $album)
    {
        $images = $this->get('kosssi_my_albums.repository.image')->findBy(array('album' => $album));
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
     * @Config\Route("/{id}/edit", name="album_name_edit")
     * @Config\Template()
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction(Request $request, Image $album)
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
            return array(
                'album' => $album,
            );
        } else {
            return $this->redirect($this->generateUrl('album_show', array('id' => $album->getId())));
        }
    }
}
