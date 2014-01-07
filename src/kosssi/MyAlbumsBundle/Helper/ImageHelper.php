<?php

namespace kosssi\MyAlbumsBundle\Helper;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\RequestStack;

class ImageHelper
{
    /**
     * @var \Imagine\Gd\Imagine
     */
    private $imagine;

    /**
     * @var \Liip\ImagineBundle\Controller\ImagineController
     */
    private $imagineControler;

    /**
     * @var \Sensio\Bundle\FrameworkExtraBundle\Request
     */
    private $request;

    public function __construct($imagine, $imagineControler)
    {
        $this->imagine = $imagine;
        $this->imagineControler = $imagineControler;
    }

    public function setRequest(RequestStack $request_stack)
    {
        $this->request = $request_stack->getCurrentRequest();
    }

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
    }
}
