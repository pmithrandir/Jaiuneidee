<?php

namespace JaiUneIdee\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IdeeLue
 */
class IdeeLue
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \JaiUneIdee\SiteBundle\Entity\Idee
     */
    private $idee;

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
     * Set idee
     *
     * @param \JaiUneIdee\SiteBundle\Entity\Idee $idee
     * @return IdeeLue
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
     * @return IdeeLue
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
