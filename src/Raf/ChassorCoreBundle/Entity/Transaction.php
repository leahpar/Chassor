<?php

namespace Raf\ChassorCoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transaction
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Raf\ChassorCoreBundle\Entity\TransactionRepository")
 */
class Transaction
{
    static public $INSCRIPTION   = 500;
    static public $PACK1         = 500;
    static public $PACK2         = 1000;
    static public $PACK3         = 2500;
    static public $PACK4         = 5000;
    static public $PACK5         = 10000;
    
    static public $ETAT_INIT     =  1;
    static public $ETAT_ATTENTE  =  2;
    static public $ETAT_VALIDE   =  0;
    static public $ETAT_INVALIDE = -1;
    
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
     * @ORM\ManyToOne(targetEntity="Raf\ChassorCoreBundle\Entity\Chassor", inversedBy="transactions")
     */
    private $chassor;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    private $libelle;

    /**
     * @var integer
     *
     * @ORM\Column(name="montant", type="integer")
     */
    private $montant;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="etat", type="integer")
     */
    private $etat = 1;


    public function __construct(Chassor $chassor = null)
    {
        $this->chassor = $chassor;
        $this->date    = new \DateTime();
        $this->etat    = Transaction::$ETAT_INIT;
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
     * Set libelle
     *
     * @param string $libelle
     * @return transaction
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    
        return $this;
    }

    /**
     * Get libelle
     *
     * @return string 
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set montant
     *
     * @param float $montant
     * @return transaction
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;
    
        return $this;
    }

    /**
     * Get montant
     *
     * @return float 
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return transaction
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
     * @param \Raf\ChassorCoreBundle\Entity\Chassor $chassor
     * @return Transaction
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

    /**
     * Set etat
     *
     * @param integer $etat
     * @return Transaction
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    
        return $this;
    }

    /**
     * Get etat
     *
     * @return integer 
     */
    public function getEtat()
    {
        return $this->etat;
    }
    
    
    public function getType()
    {
        if (strpos($this->libelle, 'nscription') > 0)
        {
            return 1;
        }
        return 2;
    }
}