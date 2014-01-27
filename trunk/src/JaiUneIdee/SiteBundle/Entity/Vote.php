<?php

namespace JaiUneIdee\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JaiUneIdee\SiteBundle\Entity\Vote
 */
class Vote
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var integer $note
     */
    private $note;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
        $this->setIsRemoved(false);
        
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
     * Set note
     *
     * @param integer $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

    /**
     * Get note
     *
     * @return integer 
     */
    public function getNote()
    {
        return $this->note;
    }
    /**
     * @var JaiUneIdee\SiteBundle\Entity\Idee
     */
    private $idee;


    /**
     * Set idee
     *
     * @param JaiUneIdee\SiteBundle\Entity\Idee $idee
     */
    public function setIdee(\JaiUneIdee\SiteBundle\Entity\Idee $idee)
    {
        $this->idee = $idee;
    }

    /**
     * Get idee
     *
     * @return JaiUneIdee\SiteBundle\Entity\Idee 
     */
    public function getIdee()
    {
        return $this->idee;
    }
    /**
     * @var JaiUneIdee\UtilisateurBundle\Entity\User
     */
    private $user;


    /**
     * Set user
     *
     * @param JaiUneIdee\UtilisateurBundle\Entity\User $user
     */
    public function setUser(\JaiUneIdee\UtilisateurBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return JaiUneIdee\UtilisateurBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * @var \DateTime
     */
    private $created_at;


    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Vote
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
     * @var boolean
     */
    private $is_removed;


    /**
     * Set is_removed
     *
     * @param boolean $isRemoved
     * @return Vote
     */
    public function setIsRemoved($isRemoved)
    {
        $this->is_removed = $isRemoved;
    
        return $this;
    }

    /**
     * Get is_removed
     *
     * @return boolean 
     */
    public function getIsRemoved()
    {
        return $this->is_removed;
    }
}