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
        return $this->render('ChassorAdminBundle:Stats:graph-layout.html.twig');
    }

    public function ChassorEnigmeAction()
    {
        $em = $this->getDoctrine()->getManager();
        $graph = new Graph();
        $liste = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('ChassorAdminBundle:Graph')
                      ->findChassorEnigme($em);
        return $this->render('ChassorAdminBundle:Stats:graph.html.twig',
                array('id'        => '1',
                      'titre'     => 'Chassor par enigme',
                      'xLabel'    => 'Enigme',
                      'yLabel'    => 'Chassors',
                      'type'      => 'ColumnChart',
                      'dataTable' => $liste
            ));
    }
    
    public function ChassorDateAction()
    {
        $em = $this->getDoctrine()->getManager();
        $graph = new Graph();
        $liste = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('ChassorAdminBundle:Graph')
                      ->findChassorDate($em);
        return $this->render('ChassorAdminBundle:Stats:graph.html.twig',
                array('id'        => '2',
                      'titre'     => 'Derniere connexion',
                      'xLabel'    => 'Date',
                      'yLabel'    => 'Connexions',
                      'type'      => 'ColumnChart',
                      'dataTable' => $liste
            ));
    }
    
    public function TentativeEnigmeAction()
    {
        $em = $this->getDoctrine()->getManager();
        $graph = new Graph();
        $liste = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('ChassorAdminBundle:Graph')
                      ->findTentativeEnigme($em);
        return $this->render('ChassorAdminBundle:Stats:graph.html.twig',
                array('id'        => '3',
                      'xLabel'    => 'Enigme',
                      'yLabel'    => 'Tentatives',
                      'titre'     => 'Tentatives par enigme',
                      'type'      => 'ColumnChart',
                      'dataTable' => $liste
            ));
    }
    
    public function TentativeChassorAction()
    {
        $em = $this->getDoctrine()->getManager();
        $graph = new Graph();
        $liste = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('ChassorAdminBundle:Graph')
                      ->findTentativeChassor($em);
        return $this->render('ChassorAdminBundle:Stats:graph.html.twig',
                array('id'        => '4',
                      'xLabel'    => 'Chassor',
                      'yLabel'    => 'Tentatives',
                      'titre'     => 'Tentatives par chassor',
                      'type'      => 'ColumnChart',
                      'dataTable' => $liste
            ));
    }
    
    public function TentativeJourAction()
    {
        $em = $this->getDoctrine()->getManager();
        $graph = new Graph();
        $liste = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('ChassorAdminBundle:Graph')
                      ->findTentativeJour($em);
        return $this->render('ChassorAdminBundle:Stats:graph.html.twig',
                array('id'        => '5',
                      'titre'     => 'Tentatives par jour',
                      'xLabel'    => 'Date',
                      'yLabel'    => 'Tentatives',
                      'type'      => 'LineChart',
                      'dataTable' => $liste
            ));
    }

    public function ResoluJourAction()
    {
        $em = $this->getDoctrine()->getManager();
        $graph = new Graph();
        $liste = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('ChassorAdminBundle:Graph')
                      ->findResoluJour($em);
        return $this->render('ChassorAdminBundle:Stats:graph.html.twig',
                array('id'        => '6',
                      'titre'     => 'Resolues par jour',
                      'xLabel'    => 'Date',
                      'yLabel'    => 'Resolues',
                      'type'      => 'LineChart',
                      'dataTable' => $liste
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

