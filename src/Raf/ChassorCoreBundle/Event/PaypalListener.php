<?php
namespace Raf\ChassorCoreBundle\Event;

use Orderly\PayPalIpnBundle\Event\PayPalEvent;
use Doctrine\Common\Persistence\ObjectManager;

class PaypalListener {

    private $em;

    public function __construct(ObjectManager $em) {
        $this->em = $em;
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
        $em->flush();
    }
}