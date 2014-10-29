<?php

namespace kosssi\MyAlbumsBundle\Helper;

use kosssi\MyAlbumsBundle\Entity\Image;

/**
 * Class ImageRotateHelper
 *
 * @author Simon Constans <kosssi@gmail.com>
 */
class ImageRotateHelper
{
    /**
     * @var \Imagine\Gd\Imagine
     */
    private $imagine;

    /**
     * @param \Imagine\Gd\Imagine $imagine
     */
    public function __construct($imagine)
    {
        $this->imagine = $imagine;
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public function rotateAccordingExif($path)
    {
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $image = $this->imagine->open($path);

        //exif only supports jpg in our supported file types
        if ($extension == "jpg" || $extension == "jpeg") {

            //fix photos taken on cameras that have incorrect dimensions
            $exif = exif_read_data($path);

            if (isset($exif['Orientation'])) {
                //determine what orientation the image was taken at
                switch($exif['Orientation']) {
                    case 2: // horizontal flip
                        $image->flipHorizontally();
                        break;

                    case 3: // 180 rotate left
                        $image->rotate(180);
                        break;

                    case 4: // vertical flip
                        $image->flipVertically();
                        break;

                    case 5: // vertical flip + 90 rotate right
                        $image->flipVertically();
                        $image->rotate(90);
                        break;

                    case 6: // 90 rotate right
                        $image->rotate(90);
                        break;

                    case 7: // horizontal flip + 90 rotate right
                        $image->flipHorizontally();
                        $image->rotate(90);
                        break;

                    case 8: // 90 rotate left
                        $image->rotate(-90);
                        break;
                }
            }
        }
        $image->save($path);

        return $this->getOrientation($image);
    }

    /**
     * @param string  $path
     * @param integer $rotation
     *
     * @return string
     */
    public function rotate($path, $rotation)
    {
        $image = $this->imagine->open($path);
        $image->rotate($rotation);
        $image->save($path);

        return $this->getOrientation($image);
    }

    /**
     * @param \Imagine\Gd\Image|\Imagine\Image\ImageInterface $image
     *
     * @return string
     */
    public function getOrientation($image)
    {
        $size = $image->getSize();

        if ($size->getWidth() > $size->getHeight()) {
            return Image::ORIENTATION_LANDSCAPE;
        } else {
            return Image::ORIENTATION_PORTRAIT;
        }
    }
}
