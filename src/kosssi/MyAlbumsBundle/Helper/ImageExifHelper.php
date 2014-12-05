<?php

namespace kosssi\MyAlbumsBundle\Helper;

use kosssi\MyAlbumsBundle\Entity\Image;

/**
 * Class ImageExifHelper
 *
 * @author Simon Constans <kosssi@gmail.com>
 */
class ImageExifHelper
{
    /**
     * @param Image $image
     *
     * @return array
     */
    public function getExif(Image $image)
    {
        return exif_read_data($image->getPath());
    }

    public function setDateTime(Image $image, $exif = null)
    {
        if (null === $exif) {
            $exif = $this->getExif($image);
        }

        if ($exif['DateTime']) {
            $image->setExifDateTime(new \DateTime($exif['DateTime']));
        } elseif ($exif['DateTimeOriginal']) {
            $image->setExifDateTime(new \DateTime($exif['DateTimeOriginal']));
        } elseif ($exif['DateTimeDigitized']) {
            $image->setExifDateTime(new \DateTime($exif['DateTimeDigitized']));
        }
    }
}
