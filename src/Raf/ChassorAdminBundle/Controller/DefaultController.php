<?php

namespace Raf\ChassorAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ChassorAdminBundle:Default:index.html.twig', array('name' => $name));
    }
}
