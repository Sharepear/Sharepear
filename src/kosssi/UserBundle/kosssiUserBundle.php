<?php

namespace kosssi\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class kosssiUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
