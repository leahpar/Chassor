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
    	// globales
    	$user  = $this->getUser();
    	
    	if ($user != null)
    	{
        	$log   = $this->get('session')->getFlashBag();
        	$em    = $this->getDoctrine()->getManager();
        	$ocb_m = $this->get('ocb.message');
        	
        	// affichage messages
        	$ocb_m->gestionMessages($user, $log, $em);
    	}
    	
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
}
