<?php

namespace Raf\ChassorAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Raf\ChassorCoreBundle\Entity\Mail;
use Raf\ChassorCoreBundle\Form\MailType;
use Symfony\Component\BrowserKit\Response;

class AdminmailController extends Controller
{
    public function listerAction()
    {
        $liste = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('ChassorCoreBundle:Mail')
                      ->findAll();
       
        return $this->render('ChassorAdminBundle:Mail:lister.html.twig',
                array(
                        'liste' => $liste
                ));
    }
    
    public function ajouterAction()
    {
        $mail = new Mail();
        return $this->formulaireAction($mail);
    }
    
    public function modifierAction(Mail $mail)
    {
        return $this->formulaireAction($mail);
    }
    
    public function envoyerAction()
    {
        $log    = $this->get('session')->getFlashBag();
        $mailer = $this->get('mailer');
        $err    = false;
        
        $mailId = $this->get('request')->request->get('mail');
        $chassorsId = $this->get('request')->request->get('chassors');
        
        $mail = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('ChassorCoreBundle:Mail')
                      ->findOneById($mailId);
        $chassors = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('ChassorCoreBundle:Chassor')
                      ->findById($chassorsId);
        
        if ($mail == null)
        {
            $log->add('error', 'mail invalide');
            $err = true;
        }
        if (count($chassors) == 0)
        {
            $log->add('error', 'aucun chassor');
            $err = true;
        }
        
        if (!$err)
        { 
            $template = 'ChassorCoreBundle:MailData:'.$mail->getTemplate();
            foreach ($chassors as $chassor)
            {
                $message = \Swift_Message::newInstance();
                $message->setFrom('marc@chassor.com')
                        ->setTo($chassor->getEmail())
                        ->setSubject($mail->getSujet())
                        ->setBody($this->renderView($template, array('chassor' => $chassor)))
                        ->setContentType('text/html');
                $mailer->send($message);
            }
            $log->add('info', 'Mail ['.$mail->getSujet().'] à '.count($chassors).' chassors prêt à partir !');
        }
        return $this->redirect($this->generateUrl('admin_chassor_lister'));
    }

    public function testerAction(Mail $mail)
    {
        $log    = $this->get('session')->getFlashBag();
        $em     = $this->getDoctrine()->getManager();
        $user   = $this->getUser();

        $template = 'ChassorCoreBundle:MailData:'.$mail->getTemplate();
        
        if ($this->get('templating')->exists($template))
        {
            return $this->render($template,
                array('chassor' => $user)
            );
        }
        else
        {
            $log->add('error', 'template inexistant !');
            return $this->redirect($this->generateUrl('admin_mail_lister'));
        }
    }
    
    public function formulaireAction(Mail $mail)
    {
        $form = $this->createForm(new MailType, $mail);
        
        // On récupère la requête
        $request = $this->get('request');
    
        // On vérifie qu'elle est de type POST
        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);
    
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
    
                $em->persist($mail);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('success', "mail OK.");
                
                return $this->redirect($this->generateUrl('admin_mail_lister'));
            }
        }
    
        return $this->render('ChassorAdminBundle:Mail:formulaire.html.twig',
                array(
                        'form' => $form->createView()
                ));
    }
}
