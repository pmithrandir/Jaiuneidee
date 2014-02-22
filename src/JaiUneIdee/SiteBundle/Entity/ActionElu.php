<?php

namespace JaiUneIdee\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ActionElu
 */
class ActionElu
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $date_jaime;

    /**
     * @var boolean
     */
    private $jaime;

    /**
     * @var \DateTime
     */
    private $date_jemengage;

    /**
     * @var boolean
     */
    private $jemengage;

    /**
     * @var \DateTime
     */
    private $date_jairealise;

    /**
     * @var boolean
     */
    private $jairealise;

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
        $this->setJaime(false);
        $this->setJemengage(false);
        $this->setJairealise(false);
        $this->setJenaimepas(false);
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
     * Set date_jaime
     *
     * @param \DateTime $dateJaime
     * @return ActionElu
     */
    public function setDateJaime($dateJaime)
    {
        $this->date_jaime = $dateJaime;
    
        return $this;
    }

    /**
     * Get date_jaime
     *
     * @return \DateTime 
     */
    public function getDateJaime()
    {
        return $this->date_jaime;
    }

    /**
     * Set jaime
     *
     * @param boolean $jaime
     * @return ActionElu
     */
    public function setJaime($jaime)
    {
        $this->jaime = $jaime;
    
        return $this;
    }

    /**
     * Get jaime
     *
     * @return boolean 
     */
    public function getJaime()
    {
        return $this->jaime;
    }

    /**
     * Set date_jemengage
     *
     * @param \DateTime $dateJemengage
     * @return ActionElu
     */
    public function setDateJemengage($dateJemengage)
    {
        $this->date_jemengage = $dateJemengage;
    
        return $this;
    }

    /**
     * Get date_jemengage
     *
     * @return \DateTime 
     */
    public function getDateJemengage()
    {
        return $this->date_jemengage;
    }

    /**
     * Set jemengage
     *
     * @param boolean $jemengage
     * @return ActionElu
     */
    public function setJemengage($jemengage)
    {
        $this->jemengage = $jemengage;
    
        return $this;
    }

    /**
     * Get jemengage
     *
     * @return boolean 
     */
    public function getJemengage()
    {
        return $this->jemengage;
    }

    /**
     * Set date_jairealise
     *
     * @param \DateTime $dateJairealise
     * @return ActionElu
     */
    public function setDateJairealise($dateJairealise)
    {
        $this->date_jairealise = $dateJairealise;
    
        return $this;
    }

    /**
     * Get date_jairealise
     *
     * @return \DateTime 
     */
    public function getDateJairealise()
    {
        return $this->date_jairealise;
    }

    /**
     * Set jairealise
     *
     * @param boolean $jairealise
     * @return ActionElu
     */
    public function setJairealise($jairealise)
    {
        $this->jairealise = $jairealise;
    
        return $this;
    }

    /**
     * Get jairealise
     *
     * @return boolean 
     */
    public function getJairealise()
    {
        return $this->jairealise;
    }

    /**
     * Set idee
     *
     * @param \JaiUneIdee\SiteBundle\Entity\Idee $idee
     * @return ActionElu
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
     * @return ActionElu
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
    private $date_jenaimepas;

    /**
     * @var boolean
     */
    private $jenaimepas;


    /**
     * Set date_jenaimepas
     *
     * @param \DateTime $dateJenaimepas
     * @return ActionElu
     */
    public function setDateJenaimepas($dateJenaimepas)
    {
        $this->date_jenaimepas = $dateJenaimepas;
    
        return $this;
    }

    /**
     * Get date_jenaimepas
     *
     * @return \DateTime 
     */
    public function getDateJenaimepas()
    {
        return $this->date_jenaimepas;
    }

    /**
     * Set jenaimepas
     *
     * @param boolean $jenaimepas
     * @return ActionElu
     */
    public function setJenaimepas($jenaimepas)
    {
        $this->jenaimepas = $jenaimepas;
    
        return $this;
    }

    /**
     * Get jenaimepas
     *
     * @return boolean 
     */
    public function getJenaimepas()
    {
        return $this->jenaimepas;
    }
}