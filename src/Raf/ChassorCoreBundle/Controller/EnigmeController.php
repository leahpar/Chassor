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
<<<<<<< HEAD
=======
     * function enigmesAction
     * - Liste les enigmes disponibles pour l'user
     * - Appelle this->deverouillerEnigmesDate pour deverouiller les enigmes sur la date
     * - Cree une notification pour les nouvelles enigmes disponibles
     * 
>>>>>>> 249fc76ea3139440087b0021c0a62d20dcd028ab
     * @Secure(roles="ROLE_CHASSOR")
     */   
    public function enigmesAction()
    {
<<<<<<< HEAD
=======
        // globales
>>>>>>> 249fc76ea3139440087b0021c0a62d20dcd028ab
        $user = $this->getUser();
        $log  = $this->get('session')->getFlashBag();
        $em   = $this->getDoctrine()->getManager();
        
<<<<<<< HEAD
        // debloquage des enigmes (date)
        $this->deverouillerDateAction($user);
=======
        // debloquage des (éventuelles) enigmes sur la date
        $this->deverouillerEnigmesDate($user);
>>>>>>> 249fc76ea3139440087b0021c0a62d20dcd028ab
        
        // Liste des enigmes disponibles
        $enigmes = $em->getRepository('ChassorCoreBundle:ChassorEnigme')
                      ->findByChassor2($user);
        
        // Nouvelles enigmes disponibles
        foreach ($enigmes as $e)
        {
            if ($e->getTentative() < 0)
            {
                $log->add('info', 'Nouvelle énigme disponible : ['.$e->getEnigme()->getCode().'] !');
                $e->setTentative(0);
                $em->persist($e);
            }
        }
        $em->flush();
        
<<<<<<< HEAD
=======
        // affichage
>>>>>>> 249fc76ea3139440087b0021c0a62d20dcd028ab
        return $this->render('ChassorCoreBundle:Enigme:enigmes.html.twig',
            array(
                'enigmes' => $enigmes
            ));
    }
    
    /**
<<<<<<< HEAD
=======
     * function enigmeAction
     * - Affiche une enigme
     *      - Controle d'acces a l'enigme
     * - Gere la proposition de reponse
     *      - Controle delai de reponse
     *      - Correction réposne
     *      - Appelle $this->deverouillerEnigmes pour déverouiller les nouvelles enigmes
     *      - Créé une transaction si bonne réponse
     * 
>>>>>>> 249fc76ea3139440087b0021c0a62d20dcd028ab
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
<<<<<<< HEAD
                $em->flush();
=======
>>>>>>> 249fc76ea3139440087b0021c0a62d20dcd028ab
                
                if ($valide)
                {
                    // Debloque les nouvelles enigmes
<<<<<<< HEAD
                    $this->deverouillerAction($enigme, $user);
=======
                    $this->deverouillerEnigmes($enigme, $user);
>>>>>>> 249fc76ea3139440087b0021c0a62d20dcd028ab
                    
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
<<<<<<< HEAD
                    
                    $em->persist($transaction);
                    $em->flush();
=======
                    $em->persist($transaction);
>>>>>>> 249fc76ea3139440087b0021c0a62d20dcd028ab
                }
                else
                {
                    // mauvaise reponse
                    $this->get('session')->getFlashBag()->add('error', 'Mauvaise réponse...');
                }
            }
<<<<<<< HEAD
        }
        
=======
            $em->flush();
        }
        
        // affichage
>>>>>>> 249fc76ea3139440087b0021c0a62d20dcd028ab
        return $this->render('ChassorCoreBundle:Enigme:enigme-'.$enigme->getCode().'.html.twig',
            array(
                'enigme'       => $enigme,
                'proposition'  => $chassorEnigme,
                'dateProp'     => $dateProp
            ));
    }
    
    
    /**
<<<<<<< HEAD
=======
     * function enigmeImageAction
     * - Gestion de l'affichage des images de l'énigme
     * - Contrôle des l'accès à l'énigme (E404 / E403)
     * 
>>>>>>> 249fc76ea3139440087b0021c0a62d20dcd028ab
     * @Secure(roles="ROLE_CHASSOR")
     */
    public function enigmeImageAction(Enigme $enigme, $image_id)
    {
<<<<<<< HEAD
=======
        // globales
>>>>>>> 249fc76ea3139440087b0021c0a62d20dcd028ab
        $user = $this->getUser();
        
        // controle de l'acces a l'enigme
        $acces = $this->getDoctrine()
                        ->getManager()
                        ->getRepository('ChassorCoreBundle:ChassorEnigme')
                        ->findBy(array('chassor' => $user, 'enigme' => $enigme));
<<<<<<< HEAD
        $reponse = new Response();
        $reponse->headers->add(array('Content-Type' => 'image/jpg'));
=======
        
        // Réponse de type image
        $reponse = new Response();
        $reponse->headers->add(array('Content-Type' => 'image/jpg'));
        
        // Accès interdit
>>>>>>> 249fc76ea3139440087b0021c0a62d20dcd028ab
        if ($acces == null)
        {
            $image = file_get_contents($this->container->getParameter('kernel.root_dir').'/../web/images/enigmes/403.jpg');
            $reponse->setStatusCode(403);
        }
<<<<<<< HEAD
=======
        // Accès autorisé
>>>>>>> 249fc76ea3139440087b0021c0a62d20dcd028ab
        elseif (file_exists($this->container->getParameter('kernel.root_dir').'/../web/images/enigmes/'.$enigme->getCode().'-'.$image_id.'.jpg'))
        {
            $image = file_get_contents($this->container->getParameter('kernel.root_dir').'/../web/images/enigmes/'.$enigme->getCode().'-'.$image_id.'.jpg');
            $reponse->setStatusCode(200);
        }
<<<<<<< HEAD
=======
        // Image inexistante
>>>>>>> 249fc76ea3139440087b0021c0a62d20dcd028ab
        else
        {
            $image = file_get_contents($this->container->getParameter('kernel.root_dir').'/../web/images/enigmes/404.jpg');
            $reponse->setStatusCode(404);
        }
        $reponse->setContent($image);
        
        return $reponse;
    }
    
<<<<<<< HEAD
    public function deverouillerAction(Enigme $enigme, Chassor $user)
    {
        $em = $this->getDoctrine()->getManager();
        
        $enigmes = $em->getRepository('ChassorCoreBundle:Enigme')
                      ->findBy(array('depend' => $enigme));
        
=======
    /**
     * function deverouillerEnigmes
     * - Appelé si bonne réponse sur une énigme
     * - Déverouille les enigmes dépendante de l'enigme en cours
     */
    public function deverouillerEnigmes(Enigme $enigme, Chassor $user)
    {
        // Globales
        $em = $this->getDoctrine()->getManager();
        
        // Selection des enigmes dépendantes
        $enigmes = $em->getRepository('ChassorCoreBundle:Enigme')
                      ->findBy(array('depend' => $enigme));
        
        // Ajout énigme au chassor
>>>>>>> 249fc76ea3139440087b0021c0a62d20dcd028ab
        foreach ($enigmes as $e)
        {
            $chassorEnigme = new ChassorEnigme();
            $chassorEnigme->setChassor($user);
            $chassorEnigme->setEnigme($e);
            $em->persist($chassorEnigme);
            $this->get('session')->getFlashBag()->add('info',
                'L\'énigme ['.$e->getCode().'] est débloquée !');
        }
        $em->flush();
    }
    
<<<<<<< HEAD
    public function deverouillerDateAction(Chassor $user)
    {
        $em = $this->getDoctrine()->getManager();
    
=======
    /**
     * function deverouillerEnigmesDate
     * - Déverrouille les énigmes sur la date pour le chassor
     * - Seulement les énigmes sans dépendance
     */
    public function deverouillerEnigmesDate(Chassor $user)
    {
        // Globales
        $em = $this->getDoctrine()->getManager();
    
        // Sélection des nouvelles enigmes
>>>>>>> 249fc76ea3139440087b0021c0a62d20dcd028ab
        $enigmes = $em->getRepository('ChassorCoreBundle:Enigme')
                      ->findNew($em, $user);
        $date = new \DateTime();
        
<<<<<<< HEAD
=======
        // Ajout énigme au chassor
>>>>>>> 249fc76ea3139440087b0021c0a62d20dcd028ab
        foreach ($enigmes as $e)
        {
            if ($e->getDepend() == null && $e->getDate() <= $date)
            $chassorEnigme = new ChassorEnigme();
            $chassorEnigme->setChassor($user);
            $chassorEnigme->setEnigme($e);
            $em->persist($chassorEnigme);
        }
        $em->flush();
    }
    
}






















