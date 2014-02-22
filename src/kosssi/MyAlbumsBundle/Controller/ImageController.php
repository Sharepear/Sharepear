<?php

namespace kosssi\MyAlbumsBundle\Controller;

use kosssi\MyAlbumsBundle\Entity\Image;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Config;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Image controller.
 *
 * @Config\Route("/image")
 */
class ImageController extends Controller
{
    /**
     * Show an image.
     *
     * @param Image $image
     *
     * @Config\Route("/{id}", name="image_show")
     * @Config\template()
     *
     * @return array
     */
    public function showAction(Image $image)
    {
        return array(
            'image' => $image,
        );
    }

    /**
     * Deletes an Image entity.
     *
     * @param Request $request
     * @param Image $image
     *
     * @Config\Route("/{id}/delete", name="image_delete")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Image $image)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($image);
        $em->flush();

        if ($request->isXmlHttpRequest()) {

        } else {
            if ($album = $image->getAlbum()) {
                return $this->redirect($this->generateUrl('album_show', array('id' => $album->getId())));
            } else {
                return $this->redirect($this->generateUrl('homepage'));
            }
        }
    }

    /**
     * Deletes a Image entity.
     *
     * @Config\Route("/{id}/rotate/left", name="image_rotation_left", defaults={"rotation" = 90})
     * @Config\Route("/{id}/rotate/right", name="image_rotation_right", defaults={"rotation" = -90})
     */
    public function rotationAction(Image $image, $rotation)
    {
        // rotate
        $this->get('kosssi_my_albums.helper.image_rotate')->rotate($image, $rotation);

        // remove cache
        $this->get('kosssi_my_albums.helper.image_cache')->removeFilters($image->getPath());

        // save entity
        $em = $this->getDoctrine()->getManager();
        $em->persist($image);
        $em->flush();

        if ($album = $image->getAlbum()) {
            return $this->redirect($this->generateUrl('album_show', array('id' => $album->getId())));
        } else {
            return $this->redirect($this->generateUrl('homepage'));
        }
    }
}
