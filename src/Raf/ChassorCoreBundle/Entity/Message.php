<?php

namespace Raf\ChassorCoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Raf\ChassorCoreBundle\Entity\MessageRepository")
 */
class Message
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
     * @ORM\Column(name="message", type="text")
     */
    private $message;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
    
    /**
     * @ORM\ManyToMany(targetEntity="Raf\ChassorCoreBundle\Entity\Chassor", mappedBy="messages")
     */
    private $chassors;
    
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
     * Set message
     *
     * @param string $message
     * @return Message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    
        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Message
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
     * Constructor
     */
    public function __construct()
    {
        $this->chassors = new \Doctrine\Common\Collections\ArrayCollection();
        $this->date = new \DateTime();
    }
    
    /**
     * Add chassors
     *
     * @param \Raf\ChassorCoreBundle\Entity\Chassor $chassors
     * @return Message
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
}