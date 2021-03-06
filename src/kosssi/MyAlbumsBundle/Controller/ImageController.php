<?php

namespace kosssi\MyAlbumsBundle\Controller;

use kosssi\MyAlbumsBundle\Entity\Image;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Config;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Image controller.
 *
 * @author Simon Constans <kosssi@gmail.com>
 * @Config\Route("/image")
 */
class ImageController extends Controller
{
    /**
     * Delete an image.
     *
     * @param Request $request
     * @param Image   $image
     *
     * @Config\Route("/{id}/delete", name="image_delete")
     * @Config\Security("is_granted('IMAGE_EDIT', image)")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function deleteAction(Request $request, Image $image)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($image);
        $em->flush();

        if ($request->isXmlHttpRequest()) {
            return new Response('ok');
        } else {
            if ($album = $image->getAlbum()) {
                return $this->redirect($this->generateUrl('album_edit', array('id' => $album->getId())));
            } else {
                return $this->redirect($this->generateUrl('homepage'));
            }
        }
    }

    /**
     * Rotate an image.
     *
     * @param Request $request
     * @param Image   $image
     * @param integer $rotation
     *
     * @Config\Route("/{id}/rotate/left", name="image_rotation_left", defaults={"rotation" = 90})
     * @Config\Route("/{id}/rotate/right", name="image_rotation_right", defaults={"rotation" = -90})
     * @Config\Security("is_granted('IMAGE_EDIT', image)")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function rotationAction(Request $request, Image $image, $rotation)
    {
        // rotate
        $orientation = $this->get('kosssi_my_albums.helper.image_rotate')->rotate($image->getPath(), $rotation);
        $image->setOrientation($orientation);

        // remove cache
        $this->get('kosssi_my_albums.helper.image_cache')->remove($image->getWebPath());

        // generate new cache
        $this->get('kosssi_my_albums.helper.image_cache')->generate($image->getWebPath());

        // save entity
        $em = $this->getDoctrine()->getManager();
        $em->persist($image);
        $em->flush();

        if ($request->isXmlHttpRequest()) {
            $this->get('templating')->renderResponse('kosssiMyAlbumsBundle:Image/base:image.html.twig', array(
                'image' => $image,
            ));
        } else {
            if ($album = $image->getAlbum()) {
                return $this->redirect($this->generateUrl('album_edit', array('id' => $album->getId())));
            } else {
                return $this->redirect($this->generateUrl('homepage'));
            }
        }
    }


    /**
     * Share an image.
     *
     * @param Request $request
     * @param Image   $image
     * @param boolean $public
     *
     * @Config\Route("/{id}/share", name="image_share", defaults={"public" = true})
     * @Config\Route("/{id}/unshare", name="image_unshare", defaults={"public" = false})
     * @Config\Security("is_granted('IMAGE_EDIT', image)")
     * @Config\Template("kosssiMyAlbumsBundle:Image/base:share.html.twig")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function shareAction(Request $request, Image $image, $public)
    {
        $image->setPublic($public);

        // save entity
        $em = $this->getDoctrine()->getManager();
        $em->persist($image);
        $em->flush();

        if ($request->isXmlHttpRequest()) {
            return [
                'image' => $image,
            ];
        } else {
            if ($album = $image->getAlbum()) {
                return $this->redirect($this->generateUrl('album_edit', array('id' => $album->getId())));
            } else {
                return $this->redirect($this->generateUrl('homepage'));
            }
        }
    }
}
