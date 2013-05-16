<?php

namespace Raf\ChassorCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ChassorCoreBundle:Default:index.html.twig');
    }
    public function aproposAction()
    {
        return $this->render('ChassorCoreBundle:Default:apropos.html.twig');
    }
}
