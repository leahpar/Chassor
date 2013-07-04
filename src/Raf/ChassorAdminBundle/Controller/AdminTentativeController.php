<?php

namespace Raf\ChassorAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Raf\ChassorCoreBundle\Entity\Enigme;

class AdminTentativeController extends Controller
{
    public function listerAction()
    {
        $liste = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('ChassorCoreBundle:Tentative')
                      ->findBy(array(), array('date' => 'DESC'));
       
        return $this->render('ChassorAdminBundle:Tentative:lister.html.twig',
                array(
                        'liste' => $liste
                ));
    }
    
    public function listerEnigmeAction(Enigme $enigme)
    {
        $liste = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('ChassorCoreBundle:Tentative')
                      ->findBy(array('enigme' => $enigme), array('date' => 'DESC'));
       
        return $this->render('ChassorAdminBundle:Tentative:lister.html.twig',
                array(
                        'liste' => $liste
                ));
    }
}
