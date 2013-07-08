<?php

namespace Raf\ChassorAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Graph
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Raf\ChassorAdminBundle\Entity\GraphRepository")
 */
class Graph
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
     * @var string
     *
     * @ORM\Column(name="xType", type="string", length=255)
     */
    private $xType;

    /**
     * @var string
     *
     * @ORM\Column(name="yType", type="string", length=255)
     */
    private $yType;

    /**
     * @var string
     *
     * @ORM\Column(name="filtre", type="string", length=255, nullable=true)
     */
    private $filtre;

    /**
     * @var boolean
     *
     * @ORM\Column(name="cumul", type="boolean")
     */
    private $cumul;

    /**
     * @var string
     *
     * @ORM\Column(name="format", type="string", length=255)
     */
    private $format;


    /**
     * @ORM\ManyToOne(targetEntity="Raf\ChassorCoreBundle\Entity\Enigme")
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @ORM\JoinColumn(nullable=true)
     */
    private $enigme;

    /**
     * @ORM\ManyToOne(targetEntity="Raf\ChassorCoreBundle\Entity\Chassor")
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @ORM\JoinColumn(nullable=true)
     */
    private $chassor;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

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
     * Set xType
     *
     * @param string $xType
     * @return Graph
     */
    public function setXType($xType)
    {
        $this->xType = $xType;
    
        return $this;
    }

    /**
     * Get xType
     *
     * @return string 
     */
    public function getXType()
    {
        return $this->xType;
    }

    /**
     * Set yType
     *
     * @param string $yType
     * @return Graph
     */
    public function setYType($yType)
    {
        $this->yType = $yType;
    
        return $this;
    }

    /**
     * Get yType
     *
     * @return string 
     */
    public function getYType()
    {
        return $this->yType;
    }

    /**
     * Set filtre
     *
     * @param string $filtre
     * @return Graph
     */
    public function setFiltre($filtre)
    {
        $this->filtre = $filtre;
    
        return $this;
    }

    /**
     * Get filtre
     *
     * @return string 
     */
    public function getFiltre()
    {
        return $this->filtre;
    }

    /**
     * Set cumul
     *
     * @param boolean $cumul
     * @return Graph
     */
    public function setCumul($cumul)
    {
        $this->cumul = $cumul;
    
        return $this;
    }

    /**
     * Get cumul
     *
     * @return boolean 
     */
    public function getCumul()
    {
        return $this->cumul;
    }

    /**
     * Set format
     *
     * @param string $format
     * @return Graph
     */
    public function setFormat($format)
    {
        $this->format = $format;
    
        return $this;
    }

    /**
     * Get format
     *
     * @return string 
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Graph
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
     * Set enigme
     *
     * @param \Raf\ChassorCoreBundle\Entity\Enigme $enigme
     * @return Graph
     */
    public function setEnigme(\Raf\ChassorCoreBundle\Entity\Enigme $enigme = null)
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
     * Set chassor
     *
     * @param \Raf\ChassorCoreBundle\Entity\Chassor $chassor
     * @return Graph
     */
    public function setChassor(\Raf\ChassorCoreBundle\Entity\Chassor $chassor = null)
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
}
