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
 *
 * @Route("/image")
 */
class ImageController extends Controller
{
    /**
     * Deletes a Image entity.
     *
     * @Route("/delete/{id}", name="image_delete")
     */
    public function deleteAction(Image $image)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($image);
        $em->flush();

        if ($album = $image->getAlbum()) {
            return $this->redirect($this->generateUrl('album_show', array('id' => $album->getId())));
        } else {
            return $this->redirect($this->generateUrl('homepage'));
        }
    }

    /**
     * Deletes a Image entity.
     *
     * @Route("/rotate/left/{id}", name="image_rotation_left", defaults={"rotation" = 90})
     * @Route("/rotate/right/{id}", name="image_rotation_right", defaults={"rotation" = -90})
     */
    public function rotationAction(Image $image, $rotation)
    {
        // rotate
        $imagine = $this->get('liip_imagine');
        $webRoot = $this->get('liip_imagine.cache.manager')->getWebRoot();
        $picture = $imagine->open($webRoot . $image->getPath());
        $picture->rotate($rotation);
        $picture->save($webRoot . $image->getPath());

        // remove cache
        $cacheManager = $this->get('liip_imagine.cache.manager');
        $fs = $this->get('filesystem');
        foreach (['xs', 's', 'm', 'l', 'xl', 'xxl'] as $filter) {
            $path = $cacheManager->getBrowserPath($image->getPath(), $filter);
            $fs->remove($webRoot . $path);
        }

        // change orientation
        if ($image->getOrientation() == Image::ORIENTATION_LANDSCAPE) {
            $image->setOrientation(Image::ORIENTATION_PORTRAIT);
        } else {
            $image->setOrientation(Image::ORIENTATION_LANDSCAPE);
        }

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
