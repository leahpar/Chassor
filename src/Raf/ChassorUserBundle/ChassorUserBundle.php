<?php

namespace Raf\ChassorUserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ChassorUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
