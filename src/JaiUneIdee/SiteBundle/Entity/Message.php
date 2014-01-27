<?php

namespace JaiUneIdee\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 */
class Message
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $sujet;

    /**
     * @var string
     */
    private $message;

    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var \JaiUneIdee\UtilisateurBundle\Entity\User
     */
    private $userFrom;
    
	public function __construct()
    {
	    $this->setCreatedAt(new \DateTime());
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
     * Set sujet
     *
     * @param string $sujet
     * @return Message
     */
    public function setSujet($sujet)
    {
        $this->sujet = $sujet;
    
        return $this;
    }

    /**
     * Get sujet
     *
     * @return string 
     */
    public function getSujet()
    {
        return $this->sujet;
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
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Message
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    
        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set userFrom
     *
     * @param \JaiUneIdee\UtilisateurBundle\Entity\User $userFrom
     * @return Message
     */
    public function setUserFrom(\JaiUneIdee\UtilisateurBundle\Entity\User $userFrom = null)
    {
        $this->userFrom = $userFrom;
    
        return $this;
    }

    /**
     * Get userFrom
     *
     * @return \JaiUneIdee\UtilisateurBundle\Entity\User 
     */
    public function getUserFrom()
    {
        return $this->userFrom;
    }
    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedValue()
    {
        // Add your code here
    }
    /**
     * @var \JaiUneIdee\UtilisateurBundle\Entity\User
     */
    private $userTo;


    /**
     * Set userTo
     *
     * @param \JaiUneIdee\UtilisateurBundle\Entity\User $userTo
     * @return Message
     */
    public function setUserTo(\JaiUneIdee\UtilisateurBundle\Entity\User $userTo = null)
    {
        $this->userTo = $userTo;
    
        return $this;
    }

    /**
     * Get userTo
     *
     * @return \JaiUneIdee\UtilisateurBundle\Entity\User 
     */
    public function getUserTo()
    {
        return $this->userTo;
    }
    /**
     * @var string
     */
    private $nom;

    /**
     * @var string
     */
    private $email;


    /**
     * Set nom
     *
     * @param string $nom
     * @return Message
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
     * Set email
     *
     * @param string $email
     * @return Message
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }
}