<?php

namespace kosssi\MyAlbumsBundle\Controller;

use kosssi\MyAlbumsBundle\Entity\Album;
use kosssi\MyAlbumsBundle\Entity\Image;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Config;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

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
     * @param Album $album
     *
     * @Config\Route("/{id}", name="album_show")
     * @Config\Template()
     * @Config\Security("is_granted('ALBUM_SHOW', album)")
     *
     * @return array
     */
    public function showAction(Album $album)
    {
        $sharedAlbum = $this->getUser() != $album->getCreatedBy();
        $images = $this->get('kosssi_my_albums.repository.image')->getImages($album, $sharedAlbum);

        return array(
            'album' => $album,
            'images' => $images,
            'shared_album' => $sharedAlbum,
        );
    }

    /**
     * Download album
     *
     * @param Album $album
     *
     * @Config\Route("/{id}/download", name="album_download")
     * @Config\Security("is_granted('ALBUM_SHOW', album)")
     *
     * @return Response
     */
public function downloadAction(Album $album)
    {
        $albumDownload = $this->get('kosssi_my_albums.helper.album_download');
        $albumDownload->createArchive($album);

        $response = new Response(file_get_contents($albumDownload->zipPath($album)));
        $d = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $album->getName() . '.zip');
        $response->headers->set('Content-Disposition', $d);

        return $response;
    }

    /**
     * Edit album
     *
     * @param Request $request
     * @param Album   $album
     *
     * @Config\Route("/{id}/edit", name="album_edit")
     * @Config\Template()
     * @Config\Security("is_granted('ALBUM_EDIT', album)")
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction(Request $request, Album $album)
    {
        $form = $this->createForm('album', $album);
        $form->handleRequest($request);

        if ($request->isMethod('POST')) {
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

        $sharedAlbum = $this->getUser() != $album->getCreatedBy();
        $images = $this->get('kosssi_my_albums.repository.image')->getImages($album, $sharedAlbum);

        return [
            'album' => $album,
            'form' => $form->createView(),
            'images' => $images,
            'shared_album' => $sharedAlbum,
        ];
    }

    /**
     * Edit album name
     *
     * @param string $albumName
     *
     * @Config\Route("/new/{albumName}", name="album_new")
     * @Config\Template()
     * @Config\Security("has_role('ROLE_USER')")
     *
     * @return array
     */
    public function newAction($albumName)
    {
        $album = new Album();
        $album->setName($albumName);

        $em = $this->get('doctrine.orm.default_entity_manager');
        $em->persist($album);
        $em->flush();

        return $this->redirect($this->generateUrl('album_edit', array('id' => $album->getId())));
    }

   /**
    * Remove album
    *
    * @param Album   $album
    *
    * @Config\Route("/{id}/delete", name="album_delete")
    * @Config\Template()
    * @Config\Security("is_granted('ALBUM_EDIT', album)")
    *
    * @return \Symfony\Component\HttpFoundation\RedirectResponse
    */
    public function deleteAction(Album $album)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $em->remove($album);
        $em->flush();

        return $this->redirect($this->generateUrl('homepage'));
    }

    /**
     * @param Album   $album
     * @param Boolean $share
     *
     * @Config\Route("/{id}/share", name="album_share", defaults={"share": true})
     * @Config\Route("/{id}/unshare", name="album_unshare", defaults={"share": false})
     * @Config\Template()
     * @Config\Security("is_granted('ALBUM_EDIT', album)")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function shareAction(Album $album, $share)
    {
        $album->setPublic($share);
        foreach ($album->getImages() as $image) {
            $image->setPublic($share);
        }

        $em = $this->get('doctrine.orm.default_entity_manager');
        $em->persist($album);
        $em->flush();

        return $this->redirect($this->generateUrl('album_show', array('id' => $album->getId())));
    }
}
