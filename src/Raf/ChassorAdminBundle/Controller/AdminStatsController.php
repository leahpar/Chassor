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
                array('id'        => 'ChassorEnigme',
                      'titre'     => 'Chassor par enigme',
                      'xLabel'    => 'Enigme',
                      'yLabel'    => 'Disponibles',
                      'zLabel'    => 'Resolues',
                      'type'      => 'ColumnChart',
                      'dataTable' => $liste
            ));
    }
    
    public function TauxEnigmeAction()
    {
        $liste = $this->get('stats.repository')->findTauxEnigme();
        return $this->render('ChassorAdminBundle:Stats:graph.html.twig',
                array('id'        => 'TauxEnigme',
                      'titre'     => 'Taux de resolution',
                      'xLabel'    => 'Enigme',
                      'yLabel'    => 'Resolution',
                      'type'      => 'ColumnChart',
                      'dataTable' => $liste
            ));
    }
    
    public function ChassorDateAction()
    {
        $liste = $this->get('stats.repository')->findChassorDate();
        return $this->render('ChassorAdminBundle:Stats:graph.html.twig',
                array('id'        => 'ChassorDate',
                      'titre'     => 'Derniere connexion',
                      'xLabel'    => 'Date',
                      'zLabel'    => 'Connexions',
                      'yLabel'    => 'Absents',
                      'type'      => 'ColumnChart',
                      'dataTable' => $liste
            ));
    }
    
    public function TentativeEnigmeAction()
    {
        $liste = $this->get('stats.repository')->findTentativeEnigme();
        return $this->render('ChassorAdminBundle:Stats:graph.html.twig',
                array('id'        => 'TentativeEnigme',
                      'xLabel'    => 'Enigme',
                      'yLabel'    => 'Tentatives',
                      'titre'     => 'Tentatives par enigme',
                      'type'      => 'ColumnChart',
                      'dataTable' => $liste
            ));
    }
    
    public function TentativeChassorAction()
    {
        $liste = $this->get('stats.repository')->findTentativeChassor();
        return $this->render('ChassorAdminBundle:Stats:graph.html.twig',
                array('id'        => 'TentativeChassor',
                      'xLabel'    => 'Chassor',
                      'yLabel'    => 'Tentatives',
                      'titre'     => 'Tentatives par chassor',
                      'type'      => 'ColumnChart',
                      'dataTable' => $liste
            ));
    }
    
    public function TentativeJourAction()
    {
        $liste = $this->get('stats.repository')->findTentativeJour();
        return $this->render('ChassorAdminBundle:Stats:graph.html.twig',
                array('id'        => 'TentativeJour',
                      'titre'     => 'Tentatives par jour',
                      'xLabel'    => 'Date',
                      'yLabel'    => 'Tentatives',
                      'type'      => 'LineChart',
                      'dataTable' => $liste
            ));
    }
    
    public function ProductiviteJourAction()
    {
        $liste = $this->get('stats.repository')->findProductiviteJour();
        return $this->render('ChassorAdminBundle:Stats:graph.html.twig',
                array('id'        => 'ProductiviteJour',
                      'titre'     => 'Productivite par jour',
                      'xLabel'    => 'Date',
                      'yLabel'    => 'Productivite',
                      'type'      => 'LineChart',
                      'dataTable' => $liste
            ));
    }

    public function TentativeHeureAction()
    {
        $liste = $this->get('stats.repository')->findTentativeHeure();
        return $this->render('ChassorAdminBundle:Stats:graph.html.twig',
                array('id'        => 'TentativeHeure',
                      'titre'     => 'Tentatives par heure',
                      'xLabel'    => 'Heure',
                      'yLabel'    => 'Tentatives',
                      'type'      => 'ColumnChart',
                      'dataTable' => $liste
            ));
    }
    
    public function ProductiviteHeureAction()
    {
        $liste = $this->get('stats.repository')->findProductiviteHeure();
        return $this->render('ChassorAdminBundle:Stats:graph.html.twig',
                array('id'        => 'ProductiviteHeure',
                      'titre'     => 'Productivite par heure',
                      'xLabel'    => 'Heure',
                      'yLabel'    => 'Productivite',
                      'type'      => 'ColumnChart',
                      'dataTable' => $liste
            ));
    }
    
    public function ResoluJourAction()
    {
        $liste = $this->get('stats.repository')->findResoluJour();
        return $this->render('ChassorAdminBundle:Stats:graph.html.twig',
                array('id'        => 'ResoluJour',
                      'titre'     => 'Resolues par jour',
                      'xLabel'    => 'Date',
                      'yLabel'    => 'Resolues',
                      'type'      => 'LineChart',
                      'dataTable' => $liste
            ));
    }
    
    public function ResoluHeureAction()
    {
        $liste = $this->get('stats.repository')->findResoluHeure();
        return $this->render('ChassorAdminBundle:Stats:graph.html.twig',
                array('id'        => 'ResoluHeure',
                      'titre'     => 'Resolues par heure',
                      'xLabel'    => 'Heure',
                      'yLabel'    => 'Resolues',
                      'type'      => 'ColumnChart',
                      'dataTable' => $liste
            ));
    }

    public function InscritJourAction()
    {
        $liste = $this->get('stats.repository')->findInscritJour();
        return $this->render('ChassorAdminBundle:Stats:graph.html.twig',
                array('id'        => 'InscritJour',
                      'titre'     => 'Inscrit par jour',
                      'xLabel'    => 'date',
                      'yLabel'    => 'Inscriptions',
                      'type'      => 'ColumnChart',
                      'dataTable' => $liste
            ));
    }

    public function InscritJour2Action()
    {
        $liste = $this->get('stats.repository')->findInscritJour3();
        return $this->render('ChassorAdminBundle:Stats:graph.html.twig',
                array('id'        => 'InscritJour3',
                      'titre'     => 'Inscrit par jour',
                      'xLabel'    => 'date',
                      'yLabel'    => 'Total',
                      'zLabel'    => 'Inscriptions',
                      'type'      => 'ColumnChart',
                      'dataTable' => $liste
            ));
    }

    public function ClassementAction()
    {
        $liste = $this->get('stats.repository')->findClassement();
        return $this->render('ChassorAdminBundle:Stats:graph.html.twig',
                array('id'        => 'Classement',
                      'titre'     => 'Classement',
                      'xLabel'    => 'Chassor',
                      'yLabel'    => 'Enigmes',
                      'zLabel'    => 'Delai',
                      'type'      => 'Table',
                      'dataTable' => $liste
            ));
    }

    public function MasseMonetaireAction()
    {
        $liste = $this->get('stats.repository')->findMasseMonetaire();
        return $this->render('ChassorAdminBundle:Stats:graph.html.twig',
                array('id'        => 'MasseMonetaire',
                      'titre'     => 'Pieces en circulation',
                      'xLabel'    => 'date',
                      'yLabel'    => 'Pieces',
                      'type'      => 'LineChart',
                      'dataTable' => $liste
            ));
    }

    public function PieceChassorAction()
    {
        $monnaie  = $this->get('stats.repository')->findMasseMonetaire();
        $chassors = $this->get('stats.repository')->findInscritJour2(); 
        $liste = array();
        $liste[] = array('x' => '2013-06-01', 'y' => 0);
        $i = 0;
        $c = count($chassors);
        foreach ($monnaie as $m)
        {
            while ($chassors[$i]['x'] != $m['x']
                && $i < $c)
            {
                $i++;
            }
            if ($i >= $c) return null;
            $liste[] = array('x' => $m['x'],
                             'y' => $m['y'] / $chassors[$i]['y']);
        }
        return $this->render('ChassorAdminBundle:Stats:graph.html.twig',
                array('id'        => 'PieceChassor',
                      'titre'     => 'Pieces en circulation',
                      'xLabel'    => 'date',
                      'yLabel'    => 'Pieces',
                      'type'      => 'LineChart',
                      'dataTable' => $liste
            ));
    }



}
