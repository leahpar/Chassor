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
     * @ORM\OneToOne(targetEntity="Raf\ChassorCoreBundle\Entity\Enigme")
     * @ORM\JoinColumn(nullable=false)
     */
    private $enigme;

    /**
     * @var string
     *
     * @ORM\Column(name="indice", type="string", length=255)
     */
    private $indice;


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
}