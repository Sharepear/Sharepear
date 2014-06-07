<?php

namespace kosssi\MyAlbumsBundle\Controller;

use kosssi\MyAlbumsBundle\Entity\Image;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Config;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Album controller.
 *
 * @author Simon Constans <kosssi@gmail.com>
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
     * @Config\Security("is_granted('IMAGE_SHOW', album)")
     *
     * @return array
     */
    public function showAction(Image $album)
    {
        $sharedAlbum = $this->getUser() != $album->getUser();
        $images = $this->get('kosssi_my_albums.repository.image')->getImages($album, $sharedAlbum);
        $form = $this->createForm('album_name', $album);

        return array(
            'album' => $album,
            'images' => $images,
            'form' => $form->createView(),
            'shared_album' => $sharedAlbum,
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
     * @Config\Security("is_granted('IMAGE_EDIT', album)")
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
