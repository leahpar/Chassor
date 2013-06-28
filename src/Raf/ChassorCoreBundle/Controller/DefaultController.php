<?php

namespace Raf\ChassorCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Raf\ChassorCoreBundle\Entity\Enigme;
use Raf\ChassorCoreBundle\Entity\Chassor;
use Raf\ChassorCoreBundle\Entity\Indice;


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
    public function contactAction()
    {
        return $this->render('ChassorCoreBundle:Default:contact.html.twig');
    }
    public function reglementAction()
    {
        return $this->render('ChassorCoreBundle:Default:reglement.html.twig');
    }
    public function PartenairesAction()
    {
        return $this->render('ChassorCoreBundle:Default:partenaires.html.twig');
    }
}
