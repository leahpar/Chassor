<?php

namespace Raf\ChassorAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Raf\ChassorCoreBundle\Entity\Message;
use Raf\ChassorCoreBundle\Form\MessageType;

class AdminMessageController extends Controller
{
    public function listerAction()
    {
        $liste = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('ChassorCoreBundle:Message')
                      ->findAll();
       
        return $this->render('ChassorAdminBundle:Message:lister.html.twig',
                array(
                        'liste' => $liste
                ));
    }
    
    public function ajouterAction()
    {
        $message = new Message();
        return $this->formulaireAction($message);
    }
    
    public function modifierAction(Message $message)
    {
        return $this->formulaireAction($message);
    }

    public function formulaireAction(Message $message)
    {
        $form = $this->createForm(new MessageType, $message);
        
        // On récupère la requête
        $request = $this->get('request');
    
        // On vérifie qu'elle est de type POST
        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);
    
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
    
                $em->persist($message);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('success', "Message OK.");
                
                return $this->redirect($this->generateUrl('admin_message_lister'));
            }
        }
    
        return $this->render('ChassorAdminBundle:Message:formulaire.html.twig',
                array(
                        'form' => $form->createView()
                ));
    }
}
