<?php

namespace Raf\ChassorAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminChassorController extends Controller
{
    public function listerAction()
    {
        $liste = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('ChassorCoreBundle:Chassor')
                      ->findAll2();
        return $this->render('ChassorAdminBundle:Chassor:lister.html.twig',
                array(
                        'liste' => $liste
                ));
    }
}
