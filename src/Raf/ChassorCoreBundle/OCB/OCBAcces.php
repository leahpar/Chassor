<?php

namespace Raf\ChassorCoreBundle\OCB;

use Raf\ChassorCoreBundle\Entity\Chassor;
use Raf\ChassorCoreBundle\Entity\Enigme;
use Raf\ChassorCoreBundle\Entity\Indice;
use Raf\ChassorCoreBundle\Entity\ChassorEnigme;
 
class OCBAcces
{
    private $em;
    
    public function __construct($em)
    {
        $this->em = $em;
    }
    
    /**
     * verifie l'acces a une enigme
     * @return: chassorEnigme si acces ; null sinon
     */
    public function controleAccesEnigme2($user, $enigme)
    {
        $chassorEnigme = $this->em->getRepository('ChassorCoreBundle:ChassorEnigme')
                                  ->findOneBy(array('chassor' => $user, 'enigme' => $enigme));
        return $chassorEnigme;
    }
    
    /**
     * verifie l'acces a une enigme
     * @return: true si acces ; false sinon
     */
    public function controleAccesEnigme($user, $enigme)
    {
        if ($this->controleAccesEnigme2($this->em, $user, $enigme) == null)
        {
            return false;
        }
        else 
        {
            return true;
        }
    }
    
    
}
 












