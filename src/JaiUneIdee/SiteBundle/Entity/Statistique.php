<?php

namespace JaiUneIdee\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Statistique
 */
class Statistique
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var integer
     */
    private $nb_utilisateurs_connectes_24;

    /**
     * @var integer
     */
    private $nb_inscrits_24;

    /**
     * @var integer
     */
    private $nb_idees_24;

    /**
     * @var integer
     */
    private $nb_commentaires_24;

    /**
     * @var integer
     */
    private $nb_votes_24;

    /**
     * @var integer
     */
    private $nb_invitations_24;

    /**
     * @var integer
     */
    private $nb_inscrits_total;

    /**
     * @var integer
     */
    private $nb_idees_total;

    /**
     * @var integer
     */
    private $nb_votes_total;

    /**
     * @var integer
     */
    private $nb_commentaires_total;

    /**
     * @var integer
     */
    private $nb_invitations_total;


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
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Statistique
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
     * Set nb_utilisateurs_connectes_24
     *
     * @param integer $nbUtilisateursConnectes24
     * @return Statistique
     */
    public function setNbUtilisateursConnectes24($nbUtilisateursConnectes24)
    {
        $this->nb_utilisateurs_connectes_24 = $nbUtilisateursConnectes24;
    
        return $this;
    }

    /**
     * Get nb_utilisateurs_connectes_24
     *
     * @return integer 
     */
    public function getNbUtilisateursConnectes24()
    {
        return $this->nb_utilisateurs_connectes_24;
    }

    /**
     * Set nb_inscrits_24
     *
     * @param integer $nbInscrits24
     * @return Statistique
     */
    public function setNbInscrits24($nbInscrits24)
    {
        $this->nb_inscrits_24 = $nbInscrits24;
    
        return $this;
    }

    /**
     * Get nb_inscrits_24
     *
     * @return integer 
     */
    public function getNbInscrits24()
    {
        return $this->nb_inscrits_24;
    }

    /**
     * Set nb_idees_24
     *
     * @param integer $nbIdees24
     * @return Statistique
     */
    public function setNbIdees24($nbIdees24)
    {
        $this->nb_idees_24 = $nbIdees24;
    
        return $this;
    }

    /**
     * Get nb_idees_24
     *
     * @return integer 
     */
    public function getNbIdees24()
    {
        return $this->nb_idees_24;
    }

    /**
     * Set nb_commentaires_24
     *
     * @param integer $nbCommentaires24
     * @return Statistique
     */
    public function setNbCommentaires24($nbCommentaires24)
    {
        $this->nb_commentaires_24 = $nbCommentaires24;
    
        return $this;
    }

    /**
     * Get nb_commentaires_24
     *
     * @return integer 
     */
    public function getNbCommentaires24()
    {
        return $this->nb_commentaires_24;
    }

    /**
     * Set nb_votes_24
     *
     * @param integer $nbVotes24
     * @return Statistique
     */
    public function setNbVotes24($nbVotes24)
    {
        $this->nb_votes_24 = $nbVotes24;
    
        return $this;
    }

    /**
     * Get nb_votes_24
     *
     * @return integer 
     */
    public function getNbVotes24()
    {
        return $this->nb_votes_24;
    }

    /**
     * Set nb_invitations_24
     *
     * @param integer $nbInvitations24
     * @return Statistique
     */
    public function setNbInvitations24($nbInvitations24)
    {
        $this->nb_invitations_24 = $nbInvitations24;
    
        return $this;
    }

    /**
     * Get nb_invitations_24
     *
     * @return integer 
     */
    public function getNbInvitations24()
    {
        return $this->nb_invitations_24;
    }

    /**
     * Set nb_inscrits_total
     *
     * @param integer $nbInscritsTotal
     * @return Statistique
     */
    public function setNbInscritsTotal($nbInscritsTotal)
    {
        $this->nb_inscrits_total = $nbInscritsTotal;
    
        return $this;
    }

    /**
     * Get nb_inscrits_total
     *
     * @return integer 
     */
    public function getNbInscritsTotal()
    {
        return $this->nb_inscrits_total;
    }

    /**
     * Set nb_idees_total
     *
     * @param integer $nbIdeesTotal
     * @return Statistique
     */
    public function setNbIdeesTotal($nbIdeesTotal)
    {
        $this->nb_idees_total = $nbIdeesTotal;
    
        return $this;
    }

    /**
     * Get nb_idees_total
     *
     * @return integer 
     */
    public function getNbIdeesTotal()
    {
        return $this->nb_idees_total;
    }

    /**
     * Set nb_votes_total
     *
     * @param integer $nbVotesTotal
     * @return Statistique
     */
    public function setNbVotesTotal($nbVotesTotal)
    {
        $this->nb_votes_total = $nbVotesTotal;
    
        return $this;
    }

    /**
     * Get nb_votes_total
     *
     * @return integer 
     */
    public function getNbVotesTotal()
    {
        return $this->nb_votes_total;
    }

    /**
     * Set nb_commentaires_total
     *
     * @param integer $nbCommentairesTotal
     * @return Statistique
     */
    public function setNbCommentairesTotal($nbCommentairesTotal)
    {
        $this->nb_commentaires_total = $nbCommentairesTotal;
    
        return $this;
    }

    /**
     * Get nb_commentaires_total
     *
     * @return integer 
     */
    public function getNbCommentairesTotal()
    {
        return $this->nb_commentaires_total;
    }

    /**
     * Set nb_invitations_total
     *
     * @param integer $nbInvitationsTotal
     * @return Statistique
     */
    public function setNbInvitationsTotal($nbInvitationsTotal)
    {
        $this->nb_invitations_total = $nbInvitationsTotal;
    
        return $this;
    }

    /**
     * Get nb_invitations_total
     *
     * @return integer 
     */
    public function getNbInvitationsTotal()
    {
        return $this->nb_invitations_total;
    }
    /**
     * @var integer
     */
    private $nb_alertes_24;

    /**
     * @var integer
     */
    private $nb_alertes_total;


    /**
     * Set nb_alertes_24
     *
     * @param integer $nbAlertes24
     * @return Statistique
     */
    public function setNbAlertes24($nbAlertes24)
    {
        $this->nb_alertes_24 = $nbAlertes24;
    
        return $this;
    }

    /**
     * Get nb_alertes_24
     *
     * @return integer 
     */
    public function getNbAlertes24()
    {
        return $this->nb_alertes_24;
    }

    /**
     * Set nb_alertes_total
     *
     * @param integer $nbAlertesTotal
     * @return Statistique
     */
    public function setNbAlertesTotal($nbAlertesTotal)
    {
        $this->nb_alertes_total = $nbAlertesTotal;
    
        return $this;
    }

    /**
     * Get nb_alertes_total
     *
     * @return integer 
     */
    public function getNbAlertesTotal()
    {
        return $this->nb_alertes_total;
    }
    /**
     * @var integer
     */
    private $nb_utilisateurs_connectes_week;


    /**
     * Set nb_utilisateurs_connectes_week
     *
     * @param integer $nbUtilisateursConnectesWeek
     * @return Statistique
     */
    public function setNbUtilisateursConnectesWeek($nbUtilisateursConnectesWeek)
    {
        $this->nb_utilisateurs_connectes_week = $nbUtilisateursConnectesWeek;

        return $this;
    }

    /**
     * Get nb_utilisateurs_connectes_week
     *
     * @return integer 
     */
    public function getNbUtilisateursConnectesWeek()
    {
        return $this->nb_utilisateurs_connectes_week;
    }
}
