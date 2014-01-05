<?php

namespace kosssi\MyAlbumsBundle\Helper;

use Imagine\Gd\Imagine;
use Symfony\Component\HttpFoundation\File\File;

class ImageHelper
{
    /**
     * @var Imagine
     */
    private $imagine;

    public function __construct($imagine)
    {
        $this->imagine = $imagine;
    }

    public function rotateAccordingExif(File $file)
    {
        $extension = strtolower($file->getExtension());
        $path = $file->getPathname();

        //exif only supports jpg in our supported file types
        if ($extension == "jpg" || $extension == "jpeg") {

            //fix photos taken on cameras that have incorrect dimensions
            $exif = exif_read_data($file->getPathName());

            //get the orientation
            $orientation = $exif['Orientation'];

            $image = $this->imagine->open($file->getPathName());

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

            $image->save($path);
        }
    }
}
