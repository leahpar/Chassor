<?php

namespace Raf\ChassorCoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;

use Raf\ChassorCoreBundle\Entity\Indice;
use Raf\ChassorCoreBundle\Entity\Transaction;
use Raf\ChassorCoreBundle\Entity\Enigme;

/**
 * Chassor
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Raf\ChassorCoreBundle\Entity\ChassorRepository")
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
     * @var boolean
     *
     * @ORM\Column(name="actif", type="boolean")
     */
    private $actif = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="text", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="text", type="string", length=255)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="text")
     */
    private $adresse;
    
    /**
     * @ORM\ManyToMany(targetEntity="Raf\ChassorCoreBundle\Entity\Indice", inversedBy="chassors")
     * @ORM\JoinColumn(nullable=true)
     */
    private $indices;
    
    /**
     * @ORM\OneToMany(targetEntity="Raf\ChassorCoreBundle\Entity\Transaction", mappedBy="chassor")
     * @ORM\JoinColumn(nullable=true)
     */
    private $transactions;
    
    /**
     * @ORM\OneToMany(targetEntity="Raf\ChassorCoreBundle\Entity\ChassorEnigme", mappedBy="chassor")
     * @ORM\JoinColumn(nullable=true)
     */
    private $enigmes;
    
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

    /**
     * Set adresse
     *
     * @param string $adresse
     * @return Chassor
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    
        return $this;
    }

    /**
     * Get adresse
     *
     * @return string 
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set tel
     *
     * @param string $tel
     * @return Chassor
     */
    public function setTel($tel)
    {
        $this->tel = $tel;
    
        return $this;
    }

    /**
     * Get tel
     *
     * @return string 
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Chassor
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    
        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return Chassor
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    
        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->indices = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add indices
     *
     * @param \Raf\ChassorCoreBundle\Entity\Indice $indices
     * @return Chassor
     */
    public function addIndice(\Raf\ChassorCoreBundle\Entity\Indice $indices)
    {
        $this->indices[] = $indices;
    
        return $this;
    }

    /**
     * Remove indices
     *
     * @param \Raf\ChassorCoreBundle\Entity\Indice $indices
     */
    public function removeIndice(\Raf\ChassorCoreBundle\Entity\Indice $indices)
    {
        $this->indices->removeElement($indices);
    }

    /**
     * Get indices
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIndices()
    {
        return $this->indices;
    }

    /**
     * Add enigmes
     *
     * @param \Raf\ChassorCoreBundle\Entity\ChassorEnigme $enigmes
     * @return Chassor
     */
    public function addEnigme(\Raf\ChassorCoreBundle\Entity\ChassorEnigme $enigmes)
    {
        $this->enigmes[] = $enigmes;
    
        return $this;
    }

    /**
     * Remove enigmes
     *
     * @param \Raf\ChassorCoreBundle\Entity\ChassorEnigme $enigmes
     */
    public function removeEnigme(\Raf\ChassorCoreBundle\Entity\ChassorEnigme $enigmes)
    {
        $this->enigmes->removeElement($enigmes);
    }

    /**
     * Get enigmes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEnigmes()
    {
        return $this->enigmes;
    }

    /**
     * Add transactions
     *
     * @param \Raf\ChassorCoreBundle\Entity\transaction $transactions
     * @return Chassor
     */
    public function addTransaction(\Raf\ChassorCoreBundle\Entity\transaction $transactions)
    {
        $this->transactions[] = $transactions;
    
        return $this;
    }

    /**
     * Remove transactions
     *
     * @param \Raf\ChassorCoreBundle\Entity\transaction $transactions
     */
    public function removeTransaction(\Raf\ChassorCoreBundle\Entity\transaction $transactions)
    {
        $this->transactions->removeElement($transactions);
    }

    /**
     * Get transactions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTransactions()
    {
        return $this->transactions;
    }
    
    
    
    
    /**
     * Get compte
     *
     * @return integer
     */
    public function getCompte()
    {
        $cpt = 0;
        foreach($this->transactions as $t)
        {
            if ($t->getEtat() == Transaction::$ETAT_VALIDE)
                $cpt += $t->getMontant();
        }
        return $cpt;
    }
    
    /**
     * Get count enigmes
     *
     * @return integer
     */
    public function getNbEnigmes()
    {
        return count($this->enigmes);
    }
    
    /**
     * Get tentatives enigmes
     *
     * @return integer
     */
    public function getNbTentatives()
    {
        $cpt = 0;
        foreach ($this->enigmes as $e)
        {
            if ($e->getTentative() > 0)
                    $cpt += $e->getTentative();
        }
        return $cpt;
    }
    
    /**
     * Get count enigmes valices
     *
     * @return integer
     */
    public function getNbEnigmesValides()
    {
        $cpt = 0;
        foreach ($this->enigmes as $e)
        {
            if ($e->getValide() == true)
                    $cpt++;
        }
        return $cpt;
    }
    
    /**
     * Get count indices
     *
     * @return integer
     */
    public function getNbIndices()
    {
        return count($this->indices);
    }
    
    
}