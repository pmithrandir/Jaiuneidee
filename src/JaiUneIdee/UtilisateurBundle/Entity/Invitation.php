<?php

namespace JaiUneIdee\UtilisateurBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\Email;

/**
 * Invitation
 */
class Invitation
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $email;

    /**
     * @var boolean
     */
    private $sent;

	public function __construct()
    {
        // generate identifier only once, here a 6 characters length code
        $this->setCode(substr(md5(uniqid(rand(), true)), 0, 6));
        $this->setSent(false);
        $this->setCreatedAt(new \DateTime());
    } 
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('email', new Email());
    }
    public function __toString(){
    	return $this->email;
    }
    /**
     * Set id
     *
     * @param string $id
     * @return Invitation
     */
    public function setId($id)
    {
        $this->id = $id;
    
        return $this;
    }
    /**
     * Set id
     *
     * @param string $id
     * @return Invitation
     */
    public function setCode($id)
    {
        $this->id = $id;
    
        return $this;
    }
    /**
     * Get id
     *
     * @return string 
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function getCode()
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Invitation
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

    /**
     * Set sent
     *
     * @param boolean $sent
     * @return Invitation
     */
    public function setSent($sent)
    {
        $this->sent = $sent;
    
        return $this;
    }

    /**
     * Get sent
     *
     * @return boolean 
     */
    public function getSent()
    {
        return $this->sent;
    }
    /**
     * @var \JaiUneIdee\UtilisateurBundle\Entity\User
     */
    private $user;


    /**
     * Set user
     *
     * @param \JaiUneIdee\UtilisateurBundle\Entity\User $user
     * @return Invitation
     */
    public function setUser(\JaiUneIdee\UtilisateurBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \JaiUneIdee\UtilisateurBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * @var \JaiUneIdee\UtilisateurBundle\Entity\User
     */
    private $inviteur;


    /**
     * Set inviteur
     *
     * @param \JaiUneIdee\UtilisateurBundle\Entity\User $inviteur
     * @return Invitation
     */
    public function setInviteur(\JaiUneIdee\UtilisateurBundle\Entity\User $inviteur = null)
    {
        $this->inviteur = $inviteur;
    
        return $this;
    }

    /**
     * Get inviteur
     *
     * @return \JaiUneIdee\UtilisateurBundle\Entity\User 
     */
    public function getInviteur()
    {
        return $this->inviteur;
    }
    /**
     * @var \DateTime
     */
    private $created_at;


    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Invitation
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
}