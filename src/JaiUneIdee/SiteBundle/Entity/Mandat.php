<?php

namespace JaiUneIdee\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mandat
 */
class Mandat
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $date_election;

    /**
     * @var \DateTime
     */
    private $date_prise_de_fonction;

    /**
     * @var \JaiUneIdee\LocalisationBundle\Entity\Localisation
     */
    private $localisation;

    /**
     * @var \JaiUneIdee\SiteBundle\Entity\TypeMandat
     */
    private $type_mandat;

    /**
     * @var \JaiUneIdee\UtilisateurBundle\Entity\User
     */
    private $user;


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
     * Set date_election
     *
     * @param \DateTime $dateElection
     * @return Mandat
     */
    public function setDateElection($dateElection)
    {
        $this->date_election = $dateElection;
    
        return $this;
    }

    /**
     * Get date_election
     *
     * @return \DateTime 
     */
    public function getDateElection()
    {
        return $this->date_election;
    }

    /**
     * Set date_prise_de_fonction
     *
     * @param \DateTime $datePriseDeFonction
     * @return Mandat
     */
    public function setDatePriseDeFonction($datePriseDeFonction)
    {
        $this->date_prise_de_fonction = $datePriseDeFonction;
    
        return $this;
    }

    /**
     * Get date_prise_de_fonction
     *
     * @return \DateTime 
     */
    public function getDatePriseDeFonction()
    {
        return $this->date_prise_de_fonction;
    }

    /**
     * Set localisation
     *
     * @param \JaiUneIdee\LocalisationBundle\Entity\Localisation $localisation
     * @return Mandat
     */
    public function setLocalisation(\JaiUneIdee\LocalisationBundle\Entity\Localisation $localisation = null)
    {
        $this->localisation = $localisation;
    
        return $this;
    }

    /**
     * Get localisation
     *
     * @return \JaiUneIdee\LocalisationBundle\Entity\Localisation 
     */
    public function getLocalisation()
    {
        return $this->localisation;
    }

    /**
     * Set type_mandat
     *
     * @param \JaiUneIdee\SiteBundle\Entity\TypeMandat $typeMandat
     * @return Mandat
     */
    public function setTypeMandat(\JaiUneIdee\SiteBundle\Entity\TypeMandat $typeMandat = null)
    {
        $this->type_mandat = $typeMandat;
    
        return $this;
    }

    /**
     * Get type_mandat
     *
     * @return \JaiUneIdee\SiteBundle\Entity\TypeMandat 
     */
    public function getTypeMandat()
    {
        return $this->type_mandat;
    }

    /**
     * Set user
     *
     * @param \JaiUneIdee\UtilisateurBundle\Entity\User $user
     * @return Mandat
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
}