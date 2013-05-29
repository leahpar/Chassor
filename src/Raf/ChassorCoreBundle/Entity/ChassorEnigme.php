<?php

namespace Raf\ChassorCoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ChassorEnigme
 *
 * @ORM\Table(name="chassor_enigme")
 * @ORM\Entity(repositoryClass="Raf\ChassorCoreBundle\Entity\ChassorEnigmeRepository")
 */
class ChassorEnigme
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Raf\ChassorCoreBundle\Entity\Chassor", inversedBy="enigmes")
     */
    private $chassor;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Raf\ChassorCoreBundle\Entity\Enigme", inversedBy="chassorEnigmes")
     */
    private $enigme;

    /**
     * @var string
     *
     * @ORM\Column(name="reponse", type="string", length=255, nullable=true)
     */
    private $reponse;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="tentative", type="integer")
     */
    private $tentative = -1;

    /**
     * @var boolean
     *
     * @ORM\Column(name="valide", type="boolean")
     */
    private $valide = false;
    
    

    /**
     * Set reponse
     *
     * @param string $reponse
     * @return ChassorEnigme
     */
    public function setReponse($reponse)
    {
        $this->reponse = $reponse;
    
        return $this;
    }

    /**
     * Get reponse
     *
     * @return string 
     */
    public function getReponse()
    {
        return $this->reponse;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return ChassorEnigme
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set tentative
     *
     * @param integer $tentative
     * @return ChassorEnigme
     */
    public function setTentative($tentative)
    {
        $this->tentative = $tentative;
    
        return $this;
    }

    /**
     * Get tentative
     *
     * @return integer 
     */
    public function getTentative()
    {
        return $this->tentative;
    }

    /**
     * Set chassor
     *
     * @param \Raf\ChassorCoreBundle\Entity\Chassor $chassor
     * @return ChassorEnigme
     */
    public function setChassor(\Raf\ChassorCoreBundle\Entity\Chassor $chassor)
    {
        $this->chassor = $chassor;
    
        return $this;
    }

    /**
     * Get chassor
     *
     * @return \Raf\ChassorCoreBundle\Entity\Chassor 
     */
    public function getChassor()
    {
        return $this->chassor;
    }

    /**
     * Set enigme
     *
     * @param \Raf\ChassorCoreBundle\Entity\Enigme $enigme
     * @return ChassorEnigme
     */
    public function setEnigme(\Raf\ChassorCoreBundle\Entity\Enigme $enigme)
    {
        $this->enigme = $enigme;
    
        return $this;
    }

    /**
     * Get enigme
     *
     * @return \Raf\ChassorCoreBundle\Entity\Enigme 
     */
    public function getEnigme()
    {
        return $this->enigme;
    }

    /**
     * Set valide
     *
     * @param boolean $valide
     * @return ChassorEnigme
     */
    public function setValide($valide)
    {
        $this->valide = $valide;
    
        return $this;
    }

    /**
     * Get valide
     *
     * @return boolean 
     */
    public function getValide()
    {
        return $this->valide;
    }
}