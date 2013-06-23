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
        
        $mails = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('ChassorCoreBundle:Mail')
                      ->findAll();
        
        return $this->render('ChassorAdminBundle:Chassor:lister.html.twig',
                array(
                        'liste' => $liste,
                        'mails' => $mails
                ));
    }
}
