<?php
namespace Raf\ChassorCoreBundle\Event;

use Orderly\PayPalIpnBundle\Event\PayPalEvent;
use Doctrine\Common\Persistence\ObjectManager;

class PaypalListener {

    private $om;

    public function __construct(ObjectManager $om) {
        $this->om = $om;
    }

    public function onIPNReceive(PayPalEvent $event) {
        $ipn = $event->getIPN();
        // do your stuff
        $logger = $this->get('logger');
        $logger->info('Nous avons récupéré le logger');
        $logger->err('Une erreur est survenue');
         
    }
}