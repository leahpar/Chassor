<?php

namespace Raf\ChassorCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Raf\ChassorCoreBundle\Entity\Enigme;
use Raf\ChassorCoreBundle\Entity\Chassor;
use Raf\ChassorCoreBundle\Entity\Indice;

# Securite
use JMS\SecurityExtraBundle\Annotation\Secure;


class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ChassorCoreBundle:Default:index.html.twig');
    }
    public function aproposAction()
    {
        return $this->render('ChassorCoreBundle:Default:apropos.html.twig');
    }
    public function jouerAction()
    {
        return $this->render('ChassorCoreBundle:Default:jouer.html.twig');
    }
    public function contactAction()
    {
        return $this->render('ChassorCoreBundle:Default:contact.html.twig');
    }
    public function reglementAction()
    {
        return $this->render('ChassorCoreBundle:Default:reglement.html.twig');
    }
    public function partenairesAction()
    {
        return $this->render('ChassorCoreBundle:Default:partenaires.html.twig');
    }
    public function forumAction()
    {
        return $this->redirect('/forum/index.php');
    }
    /**
     * @Secure(roles="ROLE_CHASSOR")
     */
    public function MessagesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $messages = $em->getRepository('ChassorCoreBundle:Message')
        ->findBy(array('type' => 'histoire'), array('date' => 'asc'));
    
        // affichage
        return $this->render('ChassorCoreBundle:Default:messages.html.twig',
                array(
                        'messages' => $messages
                ));
    
    }
}
