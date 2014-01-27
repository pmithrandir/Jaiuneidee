<?php

namespace JaiUneIdee\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JaiUneIdee\SiteBundle\Entity\ModerationCommentaire
 */
class ModerationCommentaire
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var JaiUneIdee\SiteBundle\Entity\Commentaire
     */
    private $commentaire;

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
     * Set commentaire
     *
     * @param JaiUneIdee\SiteBundle\Entity\Commentaire $commentaire
     */
    public function setCommentaire(\JaiUneIdee\SiteBundle\Entity\Commentaire $commentaire)
    {
        $this->commentaire = $commentaire;
    }

    /**
     * Get commentaire
     *
     * @return JaiUneIdee\SiteBundle\Entity\Commentaire 
     */
    public function getCommentaire()
    {
        return $this->commentaire;
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