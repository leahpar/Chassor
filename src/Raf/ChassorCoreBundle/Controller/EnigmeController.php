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
use Raf\ChassorCoreBundle\Entity\Indice;

class EnigmeController extends Controller
{
    /**
     * function enigmesAction
     * - Liste les enigmes disponibles pour l'user
     * - Appelle this->deverouillerEnigmesDate pour deverouiller les enigmes sur la date
     * 
     * @Secure(roles="ROLE_CHASSOR")
     */
    public function enigmesAction()
    {
        // globales
        $user  = $this->getUser();
        $log   = $this->get('session')->getFlashBag();
        $em    = $this->getDoctrine()->getManager();
        $ocb_m = $this->get('ocb.message');
        
        // affichage messages
        $ocb_m->gestionMessages($user);
        
        // debloquage des (éventuelles) nouvelles enigmes disponibles
        $this->deverouillerEnigmes($user);
        
        // Liste des enigmes disponibles
        $enigmes = $em->getRepository('ChassorCoreBundle:Enigme')
                      ->findByChassor2($user);
        
        // affichage
        return $this->render('ChassorCoreBundle:Enigme:enigmes.html.twig',
            array(
                'enigmes' => $enigmes
            ));
    }
    
    /**
     * function enigmeAction
     * - Affiche une enigme
     *      - Controle d'acces a l'enigme
     * - Gere la proposition de reponse
     *      - Controle delai de reponse
     *      - Correction réposne
     *      - Créé une transaction si bonne réponse
     * 
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
        $log    = $this->get('session')->getFlashBag();
        
        $classement = 0;
        $gain = 0;
        $reponse = '';
                
        // controle de l'acces a l'enigme
        $chassorEnigme = $ocb_a->controleAccesEnigme2($user, $enigme);
        if ($chassorEnigme == null)
        {
            throw new AccessDeniedHttpException("Vous n'avez pas débloqué cette énigme !");
        }
        
        // visibilité enigme
        if ($chassorEnigme->getTentative() < 0)
        {
            $chassorEnigme->setTentative(0);
        }
        
        // gestion date
        $dateCur  = new \DateTime();
        $dateProp = $ocb_e->prochaineProposition($enigme, $chassorEnigme);
    
        // gestion reponse
        $request = $this->get('request');
        if ($request->getMethod() == 'POST' && !$chassorEnigme->getValide())
        {
            if ($dateProp != null) 
            {
                // trop rapide
                $log->add(
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
                
                if ($valide)
                {
                    // Bonne reponse
                    $log->add('success', 'Bonne réponse !');
                    
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
                }
                else
                {
                    // mauvaise reponse
                    $log->add('error', 'Mauvaise réponse...');
                }
            }
        }
        $em->flush();
        
        // selection indices disponibles
        $indices = $em->getRepository('ChassorCoreBundle:Indice')
                      ->findByChassor2($user, $enigme);
        $dateInd = $ocb_e->prochainAchat($chassorEnigme, 4);
        $dateEni = $ocb_e->prochainAchat($chassorEnigme, 7);

        
        // affichage des prix
        $prixIn = $param['indice']['prix'];
        $prixEn = $param['prix']['difficulte'.$enigme->getDifficulte()];
        
        
        // affichage
        return $this->render('ChassorCoreBundle:EnigmeData:enigme-'.$enigme->getCodeInterne().'.html.twig',
            array(
                'enigme'       => $enigme,
                'indices'      => $indices,
                'proposition'  => $chassorEnigme,
                'dateProp'     => $dateProp,
                'dateInd'      => $dateInd,
                'dateEni'      => $dateEni,
                'prixIndice'   => $prixIn,
                'prixEnigme'   => $prixEn,
                'classement'   => $classement,
                'gain'         => $gain
            ));
    }
    
    
    /**
     * function enigmeImageAction
     * - Gestion de l'affichage des images de l'énigme
     * - Contrôle des l'accès à l'énigme (404 / 403)
     * 
     * @Secure(roles="ROLE_CHASSOR")
     */
    public function enigmeImageAction(Enigme $enigme, $image_id)
    {
                
        // globales
        $user   = $this->getUser();
        $em     = $this->getDoctrine()->getManager();
        $ocb_a  = $this->get('ocb.acces');
        
        // controle de l'acces a l'enigme
        $acces = $ocb_a->controleAccesEnigme2($user, $enigme);
        
        $etat = ($image_id >= '0' && $image_id <= '9') ? 'reponse' : 'enigme';
        
        // Réponse de type image
        $reponse = new Response();
        $reponse->headers->add(array('Content-Type' => 'image/jpg'));
        
        // Accès interdit
        if (($acces == null)
         || ($etat == 'reponse' && !$acces->getValide()))
        {
            $image = file_get_contents($this->container->getParameter('kernel.root_dir').'/../web/bundles/chassorcore/img/error403.png');
            $reponse->setStatusCode(403);
        }
        // Accès autorisé
        elseif (file_exists($this->container->getParameter('kernel.root_dir').'/../web/images/enigmes/'.$enigme->getCodeInterne().'-'.$image_id.'.jpg'))
        {
            $image = file_get_contents($this->container->getParameter('kernel.root_dir').'/../web/images/enigmes/'.$enigme->getCodeInterne().'-'.$image_id.'.jpg');
            $reponse->setStatusCode(200);
        }
        // Image inexistante
        else
        {
            $image = file_get_contents($this->container->getParameter('kernel.root_dir').'/../web/bundles/chassorcore/img/error.png');
            $reponse->setStatusCode(404);
        }
        $reponse->setContent($image);
        
        return $reponse;
    }
    
    /**
     * function deverouillerEnigmes
     * - Déverrouille les énigmes sur la date et bonnes réponses pour le chassor
     */
    public function deverouillerEnigmes(Chassor $user)
    {
        // Globales
        $em = $this->getDoctrine()->getManager();
    
        // Sélection des nouvelles enigmes disponibles
        $date = new \DateTime();
        $enigmes = $em->getRepository('ChassorCoreBundle:Enigme')
                      ->findNewEnigme($em, $user, $date);
        
        // Ajout énigme au chassor
        foreach ($enigmes as $e)
        {
            $chassorEnigme = new ChassorEnigme();
            $chassorEnigme->setChassor($user);
            $chassorEnigme->setEnigme($e);
            $em->persist($chassorEnigme);
        }
        $em->flush();
    }
    
    /**
     * @Secure(roles="ROLE_CHASSOR")
     */
    public function indiceAchatAction(Enigme $enigme, Indice $indice)
    {
        // globales
        $user   = $this->getUser();
        $log    = $this->get('session')->getFlashBag();
        $em     = $this->getDoctrine()->getManager();
        $ocb_a  = $this->get('ocb.acces');
        $prix   = $this->container->getParameter('enigme');
        $prix   = $prix['indice']['prix'];
        
        // controle de l'acces a l'enigme
        if ($ocb_a->controleAccesEnigme($user, $enigme) == false)
        {
            throw new AccessDeniedHttpException("Vous n'avez pas débloqué cette énigme !");
        }
        
        // controle fonds nécessaire
        if ($user->getCompte() < $prix)
        {
            $log->add('error', 'Vous n\'avez pas les fonds nécessaire !');
        }
        else
        {
            $log->add('success', 'Indice disponible');
            
            // Transaction d'achat
            $transaction = new Transaction($user);
            $transaction->setLibelle("Achat indice [".$indice->getEnigme()->getCode()."]");
            $transaction->setMontant(0-$prix);
            $transaction->setEtat(Transaction::$ETAT_VALIDE);
            $em->persist($transaction);
            
            $user->addIndice($indice);
            $em->flush();
        }
        // retour sur l'enigme
        return $this->redirect('../enigme-'.$enigme->getCode());
    }

    /**
     * @Secure(roles="ROLE_CHASSOR")
     */
    public function enigmeAchatAction(Enigme $enigme)
    {
        // globales
        $user   = $this->getUser();
        $log    = $this->get('session')->getFlashBag();
        $em     = $this->getDoctrine()->getManager();
        $ocb_a  = $this->get('ocb.acces');
        $prix   = $this->container->getParameter('enigme');
        $prix   = $prix['prix']['difficulte'.$enigme->getDifficulte()];
        
        // controle de l'acces a l'enigme
        $chassorEnigme = $ocb_a->controleAccesEnigme2($user, $enigme);
        if ($chassorEnigme == null)
        {
            throw new AccessDeniedHttpException("Vous n'avez pas débloqué cette énigme !");
        }
        
        // controle fonds nécessaire
        if ($user->getCompte() < $prix)
        {
            $log->add('error', 'Vous n\'avez pas les fonds nécessaire !');
        }
        else
        {
            $log->add('success', 'Réponse achetée');
            
            // Transaction d'achat
            $transaction = new Transaction($user);
            $transaction->setLibelle("Achat réponse énigme [".$enigme->getCode()."]");
            $transaction->setMontant(0-$prix);
            $transaction->setEtat(Transaction::$ETAT_VALIDE);
            $em->persist($transaction);
            
            // réponse
            $chassorEnigme->setReponse($enigme->getBonneReponse());
            $chassorEnigme->setValide(true);
            $chassorEnigme->setDate(new \DateTime());
            
            $em->persist($chassorEnigme);
            $em->flush();
        }
        // retour sur l'enigme
        return $this->redirect('../enigme-'.$enigme->getCode());
    }
    
    /**
     * @Secure(roles="ROLE_CHASSOR")
     */
    public function enigmeXAction(Enigme $enigme)
    {
        // globales
        $user   = $this->getUser();
        $log    = $this->get('session')->getFlashBag();
        $em     = $this->getDoctrine()->getManager();
        $ocb_a  = $this->get('ocb.acces');
        
        // controle de l'acces a l'enigme
        $chassorEnigme = $ocb_a->controleAccesEnigme2($user, $enigme);
        if ($chassorEnigme == null)
        {
            throw new AccessDeniedHttpException("Vous n'avez pas débloqué cette énigme !");
        }
        
        // gestion reponse
        $request = $this->get('request');
        $valide = false;
        if ($request->getMethod() == 'POST')
        {
            // correction reponse
            $reponse = $this->get('request')->request->get('reponse');
            $valide = $ocb_e->reponseValide($enigme, $reponse);
    
            $chassorEnigme->setValide($valide);
            $chassorEnigme->setTentative($chassorEnigme->getTentative() + 1);
            $chassorEnigme->setDate(new \DateTime());
            $chassorEnigme->setReponse(mysql_real_escape_string($reponse));
            $em->persist($chassorEnigme);
    
            if ($valide)
            {
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
            }
            $em->flush();
        }
        
        return new Response(($valide) ? 'OK' :'KO');
        
    }
    
}























