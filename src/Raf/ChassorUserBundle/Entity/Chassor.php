<?php

namespace Raf\ChassorUserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;

/**
 * Chassor
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Raf\ChassorUserBundle\Entity\ChassorRepository")
 */
class Chassor extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var float
     *
     * @ORM\Column(name="compte", type="decimal")
     */
    private $compte = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="actif", type="boolean")
     */
    private $actif = 0;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set compte
     *
     * @param float $compte
     * @return Chassor
     */
    public function setCompte($compte)
    {
        $this->compte = $compte;
    
        return $this;
    }

    /**
     * Get compte
     *
     * @return float 
     */
    public function getCompte()
    {
        return $this->compte;
    }

    /**
     * Set actif
     *
     * @param boolean $actif
     * @return Chassor
     */
    public function setActif($actif)
    {
        $this->actif = $actif;
    
        return $this;
    }

    /**
     * Get actif
     *
     * @return boolean 
     */
    public function getActif()
    {
        return $this->actif;
    }
}
