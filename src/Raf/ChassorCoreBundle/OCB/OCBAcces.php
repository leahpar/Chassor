<?php

namespace Raf\ChassorCoreBundle\OCB;

use Raf\ChassorCoreBundle\Entity\Chassor;
use Raf\ChassorCoreBundle\Entity\Enigme;
use Raf\ChassorCoreBundle\Entity\Indice;
use Raf\ChassorCoreBundle\Entity\ChassorEnigme;
 
class OCBAcces
{
    /**
     * verifie l'acces a une enigme
     * @return: chassorEnigme si acces ; null sinon
     */
    public function controleAccesEnigme2($em, $user, $enigme)
    {
        $chassorEnigme = $em->getRepository('ChassorCoreBundle:ChassorEnigme')
                            ->findOneBy(array('chassor' => $user, 'enigme' => $enigme));
        return $chassorEnigme;
    }
    
    /**
     * verifie l'acces a une enigme
     * @return: true si acces ; false sinon
     */
    public function controleAccesEnigme($em, $user, $enigme)
    {
        if ($this->controleAccesEnigme2($em, $user, $enigme) == null)
        {
            return false;
        }
        else 
        {
            return true;
        }
    }
    
    /**
     *
     */
    public function controleAccesIndice($em, $user, $enigme, $indice)
    {
        /* TODO : OCB::controleAccesIndice() */
        return true;
    }
    
    /**
     *
     */
    public function controleCompteIndice($em, $user, $indice)
    {
        /* TODO : OCB::controleCompteIndice() */
        return true;
    }
    
    
}
 












