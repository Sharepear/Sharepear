<?php

namespace kosssi\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class kosssiUserBundle
 *
 * @author Simon Constans <kosssi@gmail.com>
 */
class kosssiUserBundle extends Bundle
{
    /**
     * @return string
     */
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
