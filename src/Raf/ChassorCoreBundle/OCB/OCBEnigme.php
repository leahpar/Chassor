<?php

namespace Raf\ChassorCoreBundle\OCB;

use Raf\ChassorCoreBundle\Entity\Enigme;
use Raf\ChassorCoreBundle\Entity\ChassorEnigme;
 
class OCBEnigme
{
    /**
     * Verifie la date de prochaine proposition
     * 
     * renvoie null si une proposition peut etre faite
     * renvoie la date de prochaine proposition possible sinon
     */
    public function prochaineProposition(Enigme $enigme, ChassorEnigme $chassorEnigme)
    {
        $dateProp = $chassorEnigme->getDate();
        if ($dateProp != null && $enigme->getDelai() > 0)
        {
            $dateProp->add(new \DateInterval('PT'.$enigme->getDelai().'H'));
        }
        if ($dateProp == null || $dateProp <= new \DateTime())
        {
            return null;
        }
        else
        {
            return $dateProp;
        }
    }
    
    /**
     * Verifie une proposition de reponse
     * 
     * renvoie true  si la proposition est bonne
     * renvoie false si la proposition est fausse
     */
    public function reponseValide(Enigme $enigme, $reponse)
    {
        $correction = explode("|", $enigme->getReponses());
        if (in_array($reponse, explode('|', $enigme->getReponses())))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
 











