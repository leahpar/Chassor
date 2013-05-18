<?php

namespace Raf\ChassorAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminTransactionController extends Controller
{
    public function listerAction()
    {
        $liste = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('ChassorCoreBundle:Transaction')
                      ->findAll();
       
        return $this->render('ChassorAdminBundle:Transaction:lister.html.twig',
                array(
                        'liste' => $liste
                ));
    }
}
