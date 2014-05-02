<?php

namespace JaiUneIdee\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AlerteIdee
 */
class AlerteIdee
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var boolean
     */
    private $activated;

    /**
     * @var \JaiUneIdee\SiteBundle\Entity\Idee
     */
    private $idee;

    /**
     * @var \JaiUneIdee\UtilisateurBundle\Entity\User
     */
    private $user;


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
     * Set activated
     *
     * @param boolean $activated
     * @return AlerteIdee
     */
    public function setActivated($activated)
    {
        $this->activated = $activated;
    
        return $this;
    }

    /**
     * Get activated
     *
     * @return boolean 
     */
    public function getActivated()
    {
        return $this->activated;
    }

    /**
     * Set idee
     *
     * @param \JaiUneIdee\SiteBundle\Entity\Idee $idee
     * @return AlerteIdee
     */
    public function setIdee(\JaiUneIdee\SiteBundle\Entity\Idee $idee = null)
    {
        $this->idee = $idee;
    
        return $this;
    }

    /**
     * Get idee
     *
     * @return \JaiUneIdee\SiteBundle\Entity\Idee 
     */
    public function getIdee()
    {
        return $this->idee;
    }

    /**
     * Set user
     *
     * @param \JaiUneIdee\UtilisateurBundle\Entity\User $user
     * @return AlerteIdee
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
     * @var \DateTime
     */
    private $created_at;


    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return AlerteIdee
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
