<?php
namespace Raf\ChassorCoreBundle\Event;

use Orderly\PayPalIpnBundle\Event\PayPalEvent;
use Doctrine\Common\Persistence\ObjectManager;

class PaypalListener {

    private $em;
    private $container;

    public function __construct(ObjectManager $em, $container) {
        $this->em = $em;
        $this->container = $container;
    }

    public function onIPNReceive(PayPalEvent $event) {
        $ipn = $event->getIPN();
        $em = $this->$em;
        
        // recherche de la transaction
        $transaction = $ipn->getIpnData();
        $transaction = $transaction['custom'];
        $transaction = $em->getRepository('ChassorCoreBundle:Transaction')
                          ->find($transaction);
        
        // transaction inconnue
        if ($transaction == null)
        {
            return;
        }
        
        // mise a jour transaction
        switch ($ipn->getOrderStatus())
        {
            case Ipn::REJECTED:
                $transaction->setEtat(Transaction::$ETAT_INVALIDE);
                break;
            case Ipn::PAID:
                $transaction->setEtat(Transaction::$ETAT_VALIDE);
                break;
            default:
                $transaction->setEtat(Transaction::$ETAT_ATTENTE);
                break;
        }
        $em->persist($transaction);
        
        // mise a jour user pour inscription
        if ($transaction->getType() == 1)
        {
            $user = $transaction->getChassor();
            $tran = $this->container->getParameter('transaction');
        
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
            $user->addRole('ROLE_CHASSOR');
            $em->persist($user);
            $em->persist($parrain);
        }
        
        $em->flush();
    }
}