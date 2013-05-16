<?php

namespace Raf\ChassorUserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ChassorCoreBundle:Default:index.html.twig');
    }
}
