<?php

namespace JaiUneIdee\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JaiUneIdee\SiteBundle\Entity\Moderation
 */
class Moderation
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var integer $note
     */
    private $note;

    /**
     * @var JaiUneIdee\SiteBundle\Entity\Idee
     */
    private $idee;

    /**
     * @var JaiUneIdee\UtilisateurBundle\Entity\User
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
}