<?php

namespace Raf\ChassorCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Raf\ChassorCoreBundle\Entity\Chassor;
use Raf\ChassorCoreBundle\Entity\Transaction;
use Raf\ChassorCoreBundle\Entity\Enigme;
use Raf\ChassorCoreBundle\Entity\Indice;

# Securite
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Response;

class BanqueController extends Controller
{
    /**
     * @Secure(roles="ROLE_CHASSOR")
     */
    public function listerAction()
    {
        $user = $this->getUser();
        
        $transactions = $this->getDoctrine()
                             ->getManager()
                             ->getRepository('ChassorCoreBundle:Transaction')
                             ->findBy(array('chassor' => $user));

        return $this->render('ChassorCoreBundle:Banque:transactions.html.twig',
            array(
                'transactions' => $transactions
            ));
    }
    
    /*
     * @ParamConverter("user",  options={"mapping": {"user":  "id"}})
     * @ParamConverter("trans", options={"mapping": {"trans": "id"}})
     */
    public function retourPaiementAction(Chassor $user, Transaction $trans, $etat)
    {
        $em = $this->getDoctrine()->getManager();
        $transaction = $em->getRepository('ChassorCoreBundle:Transaction')
                          ->findOneBy(array('chassor' => $user, 'id' => $trans->getId()));
        if ($transaction != null)
        {
            $transaction->setEtat($etat);
            $em->persist($transaction);
            $em->flush();
        }
        return new Response("OK", 200);
    }
    
    /**
     * @Secure(roles="ROLE_CHASSOR")
     */
    public function achatPiecesAction()
    {
        // recuperation variables POST
        $type  = $request->request->get('type');
        $promo = $request->request->get('promo');
    
        $user  = $this->getUser();
    
        // recuperation variables globales
        $tran  = $this->container->getParameter('transaction');
        $ppal  = $this->container->getParameter('paypal');
    
        // gestion sandbox paypal
        if ($ppal['islive'])
        {
            $ppal = $ppal['live'];
        }
        else
        {
            $ppal = $ppal['sandbox'];
        }
    
        // code promo
        if ($promo == $tran['code_promo'])
        {
            $type = $type.'X';
        }
    
        // construction transaction
        $transaction = new \Transaction($user);
        $transaction->setLibelle($tran['libelle'][$type]);
        $transaction->setMontant($tran['prix'][$type]);
        $transaction->setEtat(Transaction::$ETAT_ATTENTE);
    
        // construction de l'url
        $url  = $ppal['url'];
        $url .= '?business='.urlencode($ppal['url']);
        $url .= '&item_name='.urlencode($tran['libelle'][$type]);
        $url .= '&amount='.$tran['prix'][$type];
        $url .= '&currency_code=EUR';
        $url .= '&custom='.$transaction->getId();
    
        // on envoie l'user chez paypal
        return $this->redirect($url);
    }
    
    /**
     * @Secure(roles="ROLE_CHASSOR")
     */
    public function achatIndiceAction(Enigme $enigme, Indice $indice)
    {
        // Globales
        $user   = $this->getUser();
        $param  = $this->container->getParameter('indice');
        $em     = $this->getDoctrine()->getManager();
        $ocb    = $this->get('ocb.acces');
        $log    = $this->get('session')->getFlashBag();
    
        // Controle acces enigme
        if ($ocb->controleAccesEnigme($em, $user, $enigme) == false)
        {
            throw new AccessDeniedHttpException("Vous n'avez pas débloqué cette énigme !");
        }
    
        // Controle acces indice (cad indices precedents OK)
        elseif ($ocb->controleAccesIndice($em, $user, $enigme, $indice) == false)
        {
            $log->add(
                    'error',
                    'Il faut d\'abord acheter les indices précédents !');
        }
    
        // Controle compte en banque
        elseif ($ocb->controleCompteIndice($em, $user, $indice) == false)
        {
            $log->add(
                    'error',
                    'Vous n\'avez pas les fonds nécessaire !'
                    .'<a href="">Acheter des pièces</a>');
        }
    
        // Tout est OK
        else
        {
            // construction transaction
            $transaction = new \Transaction($user);
            $transaction->setLibelle('Achat indice (enigme ['.$indice->getEngime()->getCode().']');
            $transaction->setMontant(0 - $param['prix']);
            $transaction->setEtat(Transaction::$ETAT_VALIDE);
    
            // activation indice
            $user->addIndice($indice);
    
            $em->persist($transaction);
            $em->persist($user);
            $em->flush();
    
            $log->add(
                    'success',
                    'L\'indice est maintenant disponible :)');
        }
    
        // Retour a l'envoyeur !
        return $this->redirect(
                $this->generateUrl('enigme', array('code' => $enigme->getCode())));
    }
    
    public function activationAction()
    {
        $user  = $this->getUser();
        $em    = $this->getDoctrine()->getManager();
        $tran  = $this->container->getParameter('transaction');
        
        
        // inscription parrain
        if ($user->getParrain() != null)
        {
            $parrain = $em->getRepository('ChassorCoreBundle:Chassor')
                          ->findParrain($user->getParrain());
            if ($parrain != null)
            {
                // construction transaction
                $transaction = new Transaction($parrain);
                $transaction->setLibelle('Parrainage de '.$user->getUsername());
                $transaction->setMontant($tran['pieces']['parrain']);
                $transaction->setEtat(Transaction::$ETAT_VALIDE);
                $em->persist($transaction);
            }
        }
        
        /* TODO : formulaire + redirection paypal */
        $user->addRole('ROLE_CHASSOR');
        $em->flush();
        
        /* on le deconnecte pour prendre en compte le noueau role */
        return $this->redirect($this->generateUrl('fos_user_security_logout'));
    }
    
}
