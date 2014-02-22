<?php

namespace kosssi\MyAlbumsBundle\Helper;

use kosssi\MyAlbumsBundle\Entity\Image;
use Symfony\Component\HttpFoundation\File\File;

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
     * @var \Liip\ImagineBundle\Imagine\Cache\CacheManager
     */
    private $cacheManager;

    /**
     * @param \Imagine\Gd\Imagine                            $imagine
     * @param \Liip\ImagineBundle\Imagine\Cache\CacheManager $cacheManager
     */
    function __construct($imagine, $cacheManager)
    {
        $this->imagine = $imagine;
        $this->cacheManager = $cacheManager;
    }

    /**
     * @param File $file
     *
     * @return \Imagine\Gd\Image|\Imagine\Image\ImageInterface
     */
    public function rotateAccordingExif(File $file)
    {
        $extension = strtolower($file->getExtension());
        $path = $file->getPathname();
        $image = $this->imagine->open($path);

        //exif only supports jpg in our supported file types
        if ($extension == "jpg" || $extension == "jpeg") {

            //fix photos taken on cameras that have incorrect dimensions
            $exif = exif_read_data($file->getPathName());

            //get the orientation
            $orientation = $exif['Orientation'];

            //determine what orientation the image was taken at
            switch($orientation) {
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
        $image->save($path);

        return $image;
    }

    /**
     * @param Image  $image
     * @param string $rotation
     */
    public function rotate(Image $image, $rotation)
    {
        $webRoot = $this->cacheManager->getWebRoot();
        $picture = $this->imagine->open($webRoot . $image->getPath());
        $picture->rotate($rotation);
        $picture->save($webRoot . $image->getPath());

        // Inverse orientation
        if ($image->getOrientation() == Image::ORIENTATION_LANDSCAPE) {
            $image->setOrientation(Image::ORIENTATION_PORTRAIT);
        } else {
            $image->setOrientation(Image::ORIENTATION_LANDSCAPE);
        }
    }
}
