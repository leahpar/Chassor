<?php

namespace Raf\ChassorCoreBundle\OCB;

use Raf\ChassorCoreBundle\Entity\Chassor;
use Raf\ChassorCoreBundle\Entity\Enigme;
use Raf\ChassorCoreBundle\Entity\Indice;
use Raf\ChassorCoreBundle\Entity\ChassorEnigme;
 
class OCBAcces
{
    /**
     * 
     */
    public function controleAccesEnigme($em, $user, $enigme)
    {
        return true;
    }
    
    /**
     *
     */
    public function controleAccesIndice($em, $user, $enigme, $indice)
    {
        return true;
    }
    
    /**
     *
     */
    public function controleCompteIndice($em, $user, $indice)
    {
        return true;
    }
    
    
}
 












