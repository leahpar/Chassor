<?php

namespace Raf\ChassorCoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Enigme
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Raf\ChassorCoreBundle\Entity\EnigmeRepository")
 */
class Enigme
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
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="text", nullable=true)
     */
    private $commentaire;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=10)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="reponses", type="string", length=255, nullable=true)
     */
    private $reponses;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="delai", type="integer")
     */
    private $delai = 0;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="difficulte", type="integer")
     */
    private $difficulte = 2;
    
    /**
     * @ORM\ManyToOne(targetEntity="Raf\ChassorCoreBundle\Entity\Enigme")
     * @ORM\JoinColumn(nullable=true)
     */
    private $depend;
    
    /**
     * @ORM\OneToMany(targetEntity="Raf\ChassorCoreBundle\Entity\ChassorEnigme", mappedBy="enigme")
     */
    private $chassorEnigmes;

    
    public function __construct()
    {
        $this->date = new \Datetime('2013-07-01');
    }
    
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
     * Set titre
     *
     * @param string $titre
     * @return Enigme
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    
        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set layout
     *
     * @param string $layout
     * @return Enigme
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
    
        return $this;
    }

    /**
     * Get layout
     *
     * @return string 
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Enigme
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
     * Set code
     *
     * @param string $code
     * @return Enigme
     */
    public function setCode($code)
    {
        $this->code = $code;
    
        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set reponses
     *
     * @param array $reponses
     * @return Enigme
     */
    public function setReponses($reponses)
    {
        $this->reponses = $reponses;
    
        return $this;
    }

    /**
     * Get reponses
     *
     * @return array 
     */
    public function getReponses()
    {
        return $this->reponses;
    }

    /**
     * Set tentative
     *
     * @param integer $tentative
     * @return Enigme
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
     * Set delai
     *
     * @param integer $delai
     * @return Enigme
     */
    public function setDelai($delai)
    {
        $this->delai = $delai;
    
        return $this;
    }

    /**
     * Get delai
     *
     * @return integer 
     */
    public function getDelai()
    {
        return $this->delai;
    }

    /**
     * Set depend
     *
     * @param \Raf\ChassorCoreBundle\Entity\Enigme $depend
     * @return Enigme
     */
    public function setDepend(\Raf\ChassorCoreBundle\Entity\Enigme $depend = null)
    {
        $this->depend = $depend;
    
        return $this;
    }

    /**
     * Get depend
     *
     * @return \Raf\ChassorCoreBundle\Entity\Enigme 
     */
    public function getDepend()
    {
        return $this->depend;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     * @return Enigme
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;
    
        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string 
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set difficulte
     *
     * @param integer $difficulte
     * @return Enigme
     */
    public function setDifficulte($difficulte)
    {
        $this->difficulte = $difficulte;
    
        return $this;
    }

    /**
     * Get difficulte
     *
     * @return integer 
     */
    public function getDifficulte()
    {
        return $this->difficulte;
    }
    
    public function getChassor()
    {
        if (count($this->chassorEnigmes) == 0)
        {
            return null;
        }
        else
        {
            return $this->chassorEnigmes[0];
        }
    }
}