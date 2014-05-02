<?php

namespace JaiUneIdee\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\MinLength;
use Symfony\Component\Validator\Constraints\MaxLength;

/**
 * JaiUneIdee\SiteBundle\Entity\Commentaire
 */
class Commentaire
{
    /**
     * @var integer $id
     */
    private $id;


    /**
     * @var text $content
     */
    private $content;

    /**
     * @var JaiUneIdee\SiteBundle\Entity\Idee
     */
    private $idee;

    /**
     * @var JaiUneIdee\UtilisateurBundle\Entity\User
     */
    private $user;

    public function __construct()
    {
        $this->setLife(500);
        $this->setIsValidatedByAdmin(false);
        $this->setIsRemoved(false);
        $this->setIsModerated(false);
	$this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
    }
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('content', new NotBlank());
        $metadata->addPropertyConstraint('content', new MinLength(20));
        $metadata->addPropertyConstraint('content', new MaxLength(5000));
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
     * Set content
     *
     * @param text $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Get content
     *
     * @return text 
     */
    public function getContent()
    {
        return $this->content;
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
    /**
     * @var boolean $is_validated_by_admin
     */
    private $is_validated_by_admin;

    /**
     * @var integer $life
     */
    private $life;

    /**
     * @var JaiUneIdee\SiteBundle\Entity\ModerationCommentaire
     */
    private $moderations;


    /**
     * Set is_validated_by_admin
     *
     * @param boolean $isValidatedByAdmin
     */
     public function setIs_validated_by_admin($isValidatedByAdmin){
     	$this->setIsValidatedByAdmin($isValidatedByAdmin);
     }
    public function setIsValidatedByAdmin($isValidatedByAdmin)
    {
        $this->is_validated_by_admin = $isValidatedByAdmin;
    }

    /**
     * Get is_validated_by_admin
     *
     * @return boolean 
     */
    public function getIsValidatedByAdmin()
    {
        return $this->is_validated_by_admin;
    }

    /**
     * Set life
     *
     * @param integer $life
     */
    public function setLife($life)
    {
        $this->life = $life;
    }

    /**
     * Get life
     *
     * @return integer 
     */
    public function getLife()
    {
        return $this->life;
    }

    /**
     * Set moderations
     *
     * @param JaiUneIdee\SiteBundle\Entity\ModerationCommentaire $moderations
     */
    public function setModerations(\JaiUneIdee\SiteBundle\Entity\ModerationCommentaire $moderations)
    {
        $this->moderations = $moderations;
    }

    /**
     * Get moderations
     *
     * @return JaiUneIdee\SiteBundle\Entity\ModerationCommentaire 
     */
    public function getModerations()
    {
        return $this->moderations;
    }

    /**
     * @var datetime $created_at
     */
    private $created_at;

    /**
     * @var datetime $updated_at
     */
    private $updated_at;


    /**
     * Set created_at
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    }

    /**
     * Get created_at
     *
     * @return datetime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
    }

    /**
     * Get updated_at
     *
     * @return datetime 
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
    /**
     * 
     */
    public function setUpdatedValue()
    {
       $this->setUpdatedAt(new \DateTime());
    }
    /**
     * @var boolean $is_removed
     */
    private $is_removed;


    /**
     * Set is_removed
     *
     * @param boolean $isRemoved
     */
    public function setIsRemoved($isRemoved)
    {
        $this->is_removed = $isRemoved;
    }
    public function setIs_removed($isRemoved){
     	$this->setIsRemoved($isRemoved);
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
    /**
     * @var boolean
     */
    private $is_moderated;


    /**
     * Set is_moderated
     *
     * @param boolean $isModerated
     * @return Commentaire
     */
    public function setIsModerated($isModerated)
    {
        $this->is_moderated = $isModerated;
    
        return $this;
    }

    /**
     * Get is_moderated
     *
     * @return boolean 
     */
    public function getIsModerated()
    {
        return $this->is_moderated;
    }
}
