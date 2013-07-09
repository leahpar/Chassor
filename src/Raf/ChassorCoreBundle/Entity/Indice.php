<?php

namespace Raf\ChassorCoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Indice
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Raf\ChassorCoreBundle\Entity\IndiceRepository")
 */
class Indice
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
     * @ORM\ManyToOne(targetEntity="Raf\ChassorCoreBundle\Entity\Enigme")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $enigme;

    /**
     * @var string
     *
     * @ORM\Column(name="indice", type="string", length=255)
     */
    private $indice;
    
    /**
     * @ORM\ManyToMany(targetEntity="Raf\ChassorCoreBundle\Entity\Chassor", mappedBy="indices")
     */
    private $chassors;

    /**
     * @var integer
     *
     * @ORM\Column(name="ordre", type="integer")
     */
    private $ordre = 1;

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
     * Set enigme
     *
     * @param string $enigme
     * @return Indice
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
     * Set indice
     *
     * @param string $indice
     * @return Indice
     */
    public function setIndice($indice)
    {
        $this->indice = $indice;
    
        return $this;
    }

    /**
     * Get indice
     *
     * @return string 
     */
    public function getIndice()
    {
        return $this->indice;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->chassors = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add chassors
     *
     * @param \Raf\ChassorCoreBundle\Entity\Chassor $chassors
     * @return Indice
     */
    public function addChassor(\Raf\ChassorCoreBundle\Entity\Chassor $chassors)
    {
        $this->chassors[] = $chassors;
    
        return $this;
    }

    /**
     * Remove chassors
     *
     * @param \Raf\ChassorCoreBundle\Entity\Chassor $chassors
     */
    public function removeChassor(\Raf\ChassorCoreBundle\Entity\Chassor $chassors)
    {
        $this->chassors->removeElement($chassors);
    }

    /**
     * Get chassors
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChassors()
    {
        return $this->chassors;
    }
    
    /**
     * Get chassor
     *
     * @return Chassor
     */
    public function getChassor()
    {
        return $this->chassors[0];
    }

    /**
     * Set ordre
     *
     * @param integer $ordre
     * @return Indice
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;
    
        return $this;
    }

    /**
     * Get ordre
     *
     * @return integer 
     */
    public function getOrdre()
    {
        return $this->ordre;
    }
}
