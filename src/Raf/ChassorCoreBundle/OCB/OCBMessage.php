<?php

namespace Raf\ChassorCoreBundle\OCB;

use Raf\ChassorCoreBundle\Entity\Message;
use Raf\ChassorCoreBundle\Entity\Chassor;


class OCBMessage
{
    private $em;
    private $log;
    
    public function __construct($em, $session)
    {
        $this->em  = $em;
        $this->log = $session->getFlashBag();
    }
    
    public function gestionMessages(Chassor $user)
    {
        // Liste des enigmes disponibles
        $messages = $this->em->getRepository('ChassorCoreBundle:Message')
                             ->findByChassor2($this->em, $user);
        foreach ($messages as $m)
        {
            $this->log->add('chassor', $m->getMessage());
            $user->addMessage($m);
        }
        $this->em->flush();
    }
}
 







