<?php

namespace Raf\ChassorCoreBundle\OCB;

use Raf\ChassorCoreBundle\Entity\Chassor;
use Raf\ChassorCoreBundle\Entity\Enigme;
use Raf\ChassorCoreBundle\Entity\ChassorEnigme;
use Raf\ChassorCoreBundle\Entity\Transaction;
 
class OCBEnigme
{
    private $ocb_chaine;
    private $em;
    
    
    public function __construct($em, $ocb_chaine)
    {
        $this->ocb_chaine = $ocb_chaine;
        $this->em = $em;
    }
    
    /**
     * Verifie la date de prochaine proposition
     * 
     * renvoie null si une proposition peut etre faite
     * renvoie la date de prochaine proposition possible sinon
     */
    public function prochaineProposition(Enigme $enigme, ChassorEnigme $chassorEnigme)
    {
        if ($chassorEnigme->getDate() != null && $enigme->getDelai() > 0)
        {
            $dateProp = clone $chassorEnigme->getDate();
            $dateProp->add(new \DateInterval('PT'.$enigme->getDelai().'H'));
        }
        if ($dateProp == null || $dateProp <= new \DateTime() || $enigme->getDelai() == 0)
        {
            return null;
        }
        else
        {
            return $dateProp;
        }
    }
    
    /**
     * Verifie la date de dispo des indices
     *
     * renvoie null si un indice peut etre fait
     * renvoie la date du prochain indice possible sinon
     */
    public function prochainAchat(ChassorEnigme $chassorEnigme, $delai)
    {
        $dateProp = clone $chassorEnigme->getDateDispo();
        $dateProp->add(new \DateInterval('P'.$delai.'D'));
        if ($dateProp <= new \DateTime())
        {
            return null;
        }
        else
        {
            return $dateProp->add(new \DateInterval('P1D'));
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
        $rep = $this->ocb_chaine->normaliza($reponse);
        $tab = explode('|', $enigme->getReponses());
        foreach ($tab as $r)
        {
            if ($rep == $this->ocb_chaine->normaliza($r)) return true;
        }
        return false;
    }
    
    public function creerTransaction(Chassor $user, $libelle)
    {
        $transaction = $this->em->getRepository('ChassorCoreBundle:Transaction')
                                ->findOneBy(array('chassor' => $user,
                                                  'libelle' => $libelle,
                                                  'etat'    => Transaction::$ETAT_ATTENTE));
        if ($transaction == null)
        {
            $transaction = new Transaction($user);
        }
        return $transaction;
    }
}
 












