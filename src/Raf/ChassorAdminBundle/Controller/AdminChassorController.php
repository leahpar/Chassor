<?php

namespace Raf\ChassorAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminChassorController extends Controller
{
    public function listerAction()
    {
        $liste = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('ChassorUserBundle:Chassor')
                      ->findBy(array('enabled' => true));
       
        return $this->render('ChassorAdminBundle:Chassor:lister.html.twig',
                array(
                        'liste' => $liste
                ));
    }
}