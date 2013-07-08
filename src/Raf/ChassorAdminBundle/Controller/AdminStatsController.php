<?php

namespace Raf\ChassorAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Raf\ChassorCoreBundle\Entity\Enigme;
use Raf\ChassorCoreBundle\Entity\Chassor;
use Raf\ChassorCoreBundle\Entity\ChassorEnigme;
use Raf\ChassorCoreBundle\Entity\Indice;

class AdminStatsController extends Controller
{
    public function listerAction()
    {
        return $this->render('ChassorAdminBundle:Stats:graph-layout.html.twig');
    }

    public function ChassorEnigmeAction()
    {
        $liste = $this->get('stats.repository')->findChassorEnigme();
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
        $liste = $this->get('stats.repository')->findChassorDate($em);
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
        $liste = $this->get('stats.repository')->findTentativeEnigme($em);
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
        $liste = $this->get('stats.repository')->findTentativeChassor($em);
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
        $liste = $this->get('stats.repository')->findTentativeJour($em);
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
        $liste = $this->get('stats.repository')->findResoluJour($em);
        return $this->render('ChassorAdminBundle:Stats:graph.html.twig',
                array('id'        => '6',
                      'titre'     => 'Resolues par jour',
                      'xLabel'    => 'Date',
                      'yLabel'    => 'Resolues',
                      'type'      => 'LineChart',
                      'dataTable' => $liste
            ));
    }
}

