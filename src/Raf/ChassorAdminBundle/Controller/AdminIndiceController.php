<?php

namespace Raf\ChassorAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Raf\ChassorCoreBundle\Entity\Enigme;
use Raf\ChassorCoreBundle\Entity\Indice;
use Raf\ChassorCoreBundle\Form\IndiceType;

class AdminIndiceController extends Controller
{
    public function listerAction()
    {
        $liste = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('ChassorCoreBundle:Indice')
                      ->findAll2();
       
        return $this->render('ChassorAdminBundle:Indice:lister.html.twig',
                array(
                        'liste' => $liste
                ));
    }
    
    public function ajouterAction()
    {
        $indice = new Indice();
        return $this->formulaireAction($indice);
    }
    
    public function modifierAction(Indice $indice)
    {
        return $this->formulaireAction($indice);
    }

    public function supprimerAction(Indice $indice)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($indice);
        $em->flush();
        return $this->redirect($this->generateUrl('admin_indice_lister'));
    }
    
    public function formulaireAction(Indice $indice)
    {
        $form = $this->createForm(new IndiceType, $indice);
        
        // On récupère la requête
        $request = $this->get('request');
    
        // On vérifie qu'elle est de type POST
        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);
    
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
    
                $em->persist($indice);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('success',
                        "Indice [".$indice->getEnigme()->getCode()."] OK.");
                
                return $this->redirect($this->generateUrl('admin_indice_lister'));
            }
        }
    
        return $this->render('ChassorAdminBundle:Indice:formulaire.html.twig',
                array(
                        'form' => $form->createView()
                ));
    }
}
