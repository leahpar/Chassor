<?php

namespace Raf\ChassorCoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tentative
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Raf\ChassorCoreBundle\Entity\TentativeRepository")
 */
class Tentative
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="Raf\ChassorCoreBundle\Entity\Chassor", inversedBy="enigmes")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $chassor;

    /**
     * @ORM\ManyToOne(targetEntity="Raf\ChassorCoreBundle\Entity\Enigme", inversedBy="chassorEnigmes")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $enigme;

    /**
     * @var string
     *
     * @ORM\Column(name="reponse", type="string", length=255, nullable=true)
     */
    private $reponse;

    /**
     * @var boolean
     *
     * @ORM\Column(name="valide", type="boolean")
     */
    private $valide;

    /**
     * @var integer
     *
     * @ORM\Column(name="tentative", type="integer")
     */
    private $tentative;

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
     * Set date
     *
     * @param \DateTime $date
     * @return Tentative
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
     * Set chassor
     *
     * @param string $chassor
     * @return Tentative
     */
    public function setChassor($chassor)
    {
        $this->chassor = $chassor;
    
        return $this;
    }

    /**
     * Get chassor
     *
     * @return string 
     */
    public function getChassor()
    {
        return $this->chassor;
    }

    /**
     * Set enigme
     *
     * @param string $enigme
     * @return Tentative
     */
    public function setEnigme($enigme)
    {
        $this->enigme = $enigme;
    
        return $this;
    }

    /**
     * Get enigme
     *
     * @return string 
     */
    public function getEnigme()
    {
        return $this->enigme;
    }

    /**
     * Set reponse
     *
     * @param string $reponse
     * @return Tentative
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
     * Set valide
     *
     * @param boolean $valide
     * @return Tentative
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

    /**
     * Set tentative
     *
     * @param integer $tentative
     * @return Tentative
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
}