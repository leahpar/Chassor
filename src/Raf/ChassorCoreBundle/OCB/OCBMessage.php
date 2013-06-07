<?php

namespace Raf\ChassorCoreBundle\OCB;

use Raf\ChassorCoreBundle\Entity\Message;
use Raf\ChassorCoreBundle\Entity\Chassor;


class OCBMessage
{
    public function gestionMessages(Chassor $user, $log, $em)
    {
        // Liste des enigmes disponibles
        $messages = $em->getRepository('ChassorCoreBundle:Message')
                       ->findByChassor2($em, $user);
        foreach ($messages as $m)
        {
            $log->add('info', $m->getMessage());
            $user->addMessage($m);
        }
        $em->flush();
    }
}
 







