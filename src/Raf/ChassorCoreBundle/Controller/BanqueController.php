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
    
    /**
     * @Secure(roles="ROLE_USER")
     */
    public function achatPiecesAction($type)
    {
        $user  = $this->getUser();
        $em    = $this->getDoctrine()->getManager();
        $ocb_e = $this->get('ocb.enigme');
        
        
        $a = explode('-', $type);
        $type  = $a[0];
        $promo = (count($a) > 1) ? $a[1] : "";

        // recuperation variables globales
        $tran  = $this->container->getParameter('transaction');
        $ppal  = $this->container->getParameter('paypal');
        
        
        // gestion sandbox paypal
        if ($ppal['islive'])
        {
            $pp_mode = 'live';
        }
        else
        {
            $pp_mode = 'sandbox';
        }
    
        // code promo
        if ($promo == $tran['code_promo'])
        {
            $type = $type.'X';
        }
    
        
        // construction transaction
        $transaction = $ocb_e->creerTransaction($user, $tran['libelle'][$type]);
        $transaction->setLibelle($tran['libelle'][$type]);
        $transaction->setMontant($tran['pieces'][$type]);
        $transaction->setEtat(Transaction::$ETAT_ATTENTE);
        $em->persist($transaction);
        $em->flush();
    
        // construction de l'url
        $url  = $ppal[$pp_mode]['url'];
        $url .= '?business='.urlencode($ppal[$pp_mode]['email']);
        $url .= '&item_name='.urlencode($tran['libelle'][$type]);
        $url .= '&amount='.$tran['prix'][$type];
        $url .= '&currency_code=EUR';
        $url .= '&custom='.$transaction->getId();
        $url .= '&cmd=_xclick';
    
        // on envoie l'user chez paypal

        //return new Response($url);
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
        if ($ocb->controleAccesEnigme($user, $enigme) == false)
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
    
    public function retourPaiementAction()
    {
        return $this->render('ChassorCoreBundle:Banque:retourPaiement.html.twig');
    }
}
