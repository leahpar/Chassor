<?php

namespace Raf\ChassorCoreBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ChassorCoreBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
