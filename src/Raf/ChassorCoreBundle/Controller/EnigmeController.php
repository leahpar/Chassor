<?php

namespace Raf\ChassorCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

# Exceptions
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

# Securite
use JMS\SecurityExtraBundle\Annotation\Secure;

# Chassor
use Raf\ChassorCoreBundle\Entity\Chassor;
use Raf\ChassorCoreBundle\Entity\ChassorEnigme;
use Raf\ChassorCoreBundle\Entity\Enigme;
use Raf\ChassorCoreBundle\Entity\Transaction;

class EnigmeController extends Controller
{
    /**
     * @Secure(roles="ROLE_CHASSOR")
     */   
    public function enigmesAction()
    {
        $user = $this->getUser();
        
        // controle de l'acces a l'enigme
        $enigmes = $this->getDoctrine()
                        ->getManager()
                        ->getRepository('ChassorCoreBundle:ChassorEnigme')
                        ->findByChassor2($user);
        
        return $this->render('ChassorCoreBundle:Enigme:enigmes.html.twig',
            array(
                'enigmes' => $enigmes
            ));
    }
    
    /**
     * @Secure(roles="ROLE_CHASSOR")
     */
    public function enigmeAction(Enigme $enigme)
    {
        // recuperation variables globales
        $user   = $this->getUser();
        $em     = $this->getDoctrine()->getManager();
        $param  = $this->container->getParameter('enigme');
        $ocb_e  = $this->get('ocb.enigme');
        $ocb_a  = $this->get('ocb.acces');
        
        // controle de l'acces a l'enigme
        $chassorEnigme = $ocb_a->controleAccesEnigme2($em, $user, $enigme);
        if ($chassorEnigme == null)
        {
            throw new AccessDeniedHttpException("Vous n'avez pas débloqué cette énigme !");
        }
        
        // gestion date
        $dateCur  = new \DateTime();
        $dateProp = $ocb_e->prochaineProposition($enigme, $chassorEnigme);
    
        // gestion reponse
        $request = $this->get('request');
        if ($request->getMethod() == 'POST')
        {
            if ($dateProp != null) 
            {
                // trop rapide
                $this->get('session')->getFlashBag()->add(
                        'warning',
                        'Trop tôt ! Vous pourrez reproposer une autre solution le '
                        .$dateProp->format('d/m').' à '.$dateProp->format('H:i'));
            }
            else
            {
                // correction reponse
                $reponse = $this->get('request')->request->get('reponse');
                $valide = $ocb_e->reponseValide($enigme, $reponse);
                
                $chassorEnigme->setValide($valide);
                $chassorEnigme->setTentative($chassorEnigme->getTentative() + 1);
                $chassorEnigme->setDate($dateCur);
                $dateProp = $ocb_e->prochaineProposition($enigme, $chassorEnigme);
                $chassorEnigme->setReponse(mysql_real_escape_string($reponse));
                $em->persist($chassorEnigme);
                $em->flush();
                
                if ($valide)
                {
                    // Debloque les nouvelles enigmes
                    $this->deverouillerAction($enigme, $user);
                    
                    // Bonne reponse
                    $this->get('session')->getFlashBag()->add('success', 'Bonne réponse !');
                    
                    // Classement resultat 
                    $enigmes = $em->getRepository('ChassorCoreBundle:ChassorEnigme')
                                  ->findBy(array('enigme' => $enigme));
                    $classement = count($enigmes);
                    
                    if ($classement == $param['gain']['niveau1'])
                    {
                        $gain = $param['gain']['gain1'];
                    }
                    elseif ($classement < $param['gain']['niveau2'])
                    {
                        $gain = $param['gain']['gain2'];
                    }
                    else
                    {
                        $gain = $param['gain']['gain3'];
                    }
                    
                    // Transaction gain pieces
                    $transaction = new Transaction($user);
                    $transaction->setLibelle("Réponse énigme [".$enigme->getCode()."]");
                    $transaction->setMontant($gain);
                    $transaction->setEtat(Transaction::$ETAT_VALIDE);
                    
                    $em->persist($transaction);
                    $em->flush();
                }
                else
                {
                    // mauvaise reponse
                    $this->get('session')->getFlashBag()->add('error', 'Mauvaise réponse...');
                }
            }
        }
        
        return $this->render('ChassorCoreBundle:Enigme:enigme-'.$enigme->getCode().'.html.twig',
            array(
                'enigme'       => $enigme,
                'proposition'  => $chassorEnigme,
                'dateProp'     => $dateProp
            ));
    }
    
    
    /**
     * @Secure(roles="ROLE_CHASSOR")
     */
    public function enigmeImageAction(Enigme $enigme, $image_id)
    {
        $user = $this->getUser();
        
        // controle de l'acces a l'enigme
        $acces = $this->getDoctrine()
                        ->getManager()
                        ->getRepository('ChassorCoreBundle:ChassorEnigme')
                        ->findBy(array('chassor' => $user, 'enigme' => $enigme));
        $reponse = new Response();
        $reponse->headers->add(array('Content-Type' => 'image/jpg'));
        if ($acces == null)
        {
            $image = file_get_contents($this->container->getParameter('kernel.root_dir').'/../web/images/enigmes/403.jpg');
            $reponse->setStatusCode(403);
        }
        elseif (file_exists($this->container->getParameter('kernel.root_dir').'/../web/images/enigmes/'.$enigme->getCode().'-'.$image_id.'.jpg'))
        {
            $image = file_get_contents($this->container->getParameter('kernel.root_dir').'/../web/images/enigmes/'.$enigme->getCode().'-'.$image_id.'.jpg');
            $reponse->setStatusCode(200);
        }
        else
        {
            $image = file_get_contents($this->container->getParameter('kernel.root_dir').'/../web/images/enigmes/404.jpg');
            $reponse->setStatusCode(404);
        }
        $reponse->setContent($image);
        
        return $reponse;
    }
    
    public function deverouillerAction(Enigme $enigme, Chassor $user)
    {
        $em = $this->getDoctrine()->getManager();
        
        $enigmes = $em->getRepository('ChassorCoreBundle:Enigme')
                      ->findBy(array('depend' => $enigme));
        
        foreach ($enigmes as $e)
        {
            $chassorEnigme = new \Raf\ChassorCoreBundle\Entity\ChassorEnigme();
            $chassorEnigme->setChassor($user);
            $chassorEnigme->setEnigme($e);
            $em->persist($chassorEnigme);
            $em->flush();
            $this->get('session')->getFlashBag()->add('info',
                "L'énigme [".$e->getTitre()."] est débloquée !");
        }
    }
    
}






















