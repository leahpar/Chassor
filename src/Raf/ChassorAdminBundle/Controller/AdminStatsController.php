<?php

namespace Raf\ChassorAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Raf\ChassorCoreBundle\Entity\Enigme;
use Raf\ChassorCoreBundle\Entity\Chassor;
use Raf\ChassorCoreBundle\Entity\ChassorEnigme;
use Raf\ChassorCoreBundle\Entity\Indice;

use Raf\ChassorAdminBundle\Entity\Graph;
use Raf\ChassorAdminBundle\Form\GraphType;

class AdminStatsController extends Controller
{
    public function listerAction()
    {
        $graph = new Graph();
        return $this->formulaireAction($graph);

        $liste = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('ChassorCoreBundle:Indice')
                      ->findAll();
       
        return $this->render('ChassorAdminBundle:Indice:lister.html.twig',
                array(
                        'liste' => $liste
                ));
    }
    
    public function formulaireAction(Graph $graph)
    {
        $form = $this->createForm(new GraphType, $graph);
        
        $request = $this->get('request');
    
        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);
    
            if ($form->isValid())
            {
                
                return $this->redirect($this->generateUrl('admin_stats_lister'));
            }
        }
    
        return $this->render('ChassorAdminBundle:Stats:formulaire.html.twig',
                array(
                        'form' => $form->createView()
                ));
    }
}

