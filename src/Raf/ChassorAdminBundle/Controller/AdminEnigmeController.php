<?php

namespace Raf\ChassorAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Raf\ChassorCoreBundle\Entity\Enigme;
use Raf\ChassorCoreBundle\Form\EnigmeType;

class AdminEnigmeController extends Controller
{
    public function listerAction()
    {
        $liste = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('ChassorCoreBundle:Enigme')
                      ->findAll();
       
        return $this->render('ChassorAdminBundle:Enigme:lister.html.twig',
                array(
                        'liste' => $liste
                ));
    }
    
    public function ajouterAction()
    {
        $enigme = new Enigme();
        return $this->formulaireAction($enigme);
    }
    
    public function modifierAction(Enigme $enigme)
    {
        return $this->formulaireAction($enigme);
    }

    public function supprimerAction(Enigme $enigme)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($enigme);
        $em->flush();
        return $this->redirect($this->generateUrl('admin_enigme_lister'));
    }
    
    public function formulaireAction(Enigme $enigme)
    {
        $form = $this->createForm(new EnigmeType, $enigme);
    
        // On récupère la requête
        $request = $this->get('request');
    
        // On vérifie qu'elle est de type POST
        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);
    
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
    
                $em->persist($enigme);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('success',
                        "Enigme [".$enigme->getCode()."] OK.");
    
                return $this->redirect($this->generateUrl('admin_enigme_lister'));
            }
        }
    
        return $this->render('ChassorAdminBundle:Enigme:formulaire.html.twig',
                array(
                        'form' => $form->createView()
                ));
    }
}
