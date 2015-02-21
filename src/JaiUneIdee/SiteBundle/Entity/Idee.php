<?php

namespace JaiUneIdee\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

/**
 * JaiUneIdee\SiteBundle\Entity\Idee
 */
class Idee
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $slug
     */
    private $slug;

    /**
     * @var string $title
     */
    private $title;

    /**
     * @var string $description
     */
    private $description;

    /**
     * @var text $content
     */
    private $content;

    /**
     * @var JaiUneIdee\SiteBundle\Entity\Vote
     */
    private $votes;

    /**
     * @var JaiUneIdee\SiteBundle\Entity\Commentaire
     */
    private $commentaires;

    /**
     * @var JaiUneIdee\SiteBundle\Entity\Theme
     */
    private $theme;

    /**
     * @var JaiUneIdee\UtilisateurBundle\Entity\User
     */
    private $user;

    /**
     * @var JaiUneIdee\LocalisationBundle\Entity\Localisation
     */
    private $localisations;
    
    public function __construct()
    {
        $this->votes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->commentaires = new \Doctrine\Common\Collections\ArrayCollection();
        $this->localisations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
        $this->setLastActionAt(new \DateTime());
        $this->setIsPublished(true);
        $this->setIsRemoved(false);
        $this->setIsModerated(false);
        $this->setLife(2000);
        $this->setIsValidatedByAdmin(false);
    }
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('title', new NotBlank());
        $metadata->addPropertyConstraint('description', new NotBlank());
        $metadata->addPropertyConstraint('content', new NotBlank());
        $metadata->addPropertyConstraint('theme', new NotBlank());

        $metadata->addPropertyConstraint('title', new Length(array('min'=>8)));
        $metadata->addPropertyConstraint('title', new Length(array('max'=>80)));
        $metadata->addPropertyConstraint('description', new Length(array('min'=>20)));
        $metadata->addPropertyConstraint('description', new Length(array('max'=>110)));
        $metadata->addPropertyConstraint('content', new Length(array('min'=>20)));
        $metadata->addPropertyConstraint('content', new Length(array('max'=>10000)));
        
        $metadata->addPropertyConstraint('title', new NotBlank(array(
            'message' => 'Vous devez entrer un titre'
        )));
        $metadata->addPropertyConstraint('description', new NotBlank(array(
            'message' => 'Une courte description est obligatoire'
        )));
        $metadata->addPropertyConstraint('content', new NotBlank(array(
            'message' => 'Vous devez exprimer votre idée'
        )));
    }
    public function __toString(){
    	return $this->title;
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
     * Set slug
     *
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $this->slugify($slug);
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
        $this->setSlug($this->title);
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
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
    public function getContent($length = null)
    {
        if (false === is_null($length) && $length > 0)
            return substr($this->content, 0, $length)."...";
        else
            return $this->content;
    }

    /**
     * Add votes
     *
     * @param JaiUneIdee\SiteBundle\Entity\Vote $votes
     */
    public function addVote(\JaiUneIdee\SiteBundle\Entity\Vote $votes)
    {
        $this->votes[] = $votes;
    }

    /**
     * Get votes
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getVotes()
    {
        return $this->votes;
    }

    /**
     * Get commentaires
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }

    /**
     * Set theme
     *
     * @param JaiUneIdee\SiteBundle\Entity\Theme $theme
     */
    public function setTheme(\JaiUneIdee\SiteBundle\Entity\Theme $theme)
    {
        $this->theme = $theme;
    }

    /**
     * Get theme
     *
     * @return JaiUneIdee\SiteBundle\Entity\Theme 
     */
    public function getTheme()
    {
        return $this->theme;
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
     * Add localisations
     *
     * @param JaiUneIdee\LocalisationBundle\Entity\Localisation $localisations
     */
    public function addLocalisation(\JaiUneIdee\LocalisationBundle\Entity\Localisation $localisations)
    {
        $this->localisations[] = $localisations;
    }

    /**
     * Get localisations
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getLocalisations()
    {
        return $this->localisations;
    }
    public function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('#[^\\pL\d]+#u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        if (function_exists('iconv'))
        {
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        }

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('#[^-\w]+#', '', $text);

        if (empty($text))
        {
            return 'n-a';
        }

        return $text;
    }

    /**
     * Add commentaires
     *
     * @param JaiUneIdee\SiteBundle\Entity\Commentaire $commentaires
     */
    public function addCommentaire(\JaiUneIdee\SiteBundle\Entity\Commentaire $commentaires)
    {
        $this->commentaires[] = $commentaires;
    }
    /**
     * @var boolean $is_published
     */
    private $is_published;

    /**
     * @var boolean $is_removed
     */
    private $is_removed;


    /**
     * Set is_published
     *
     * @param boolean $isPublished
     */
     public function setIs_Published($isPublished){
     	$this->setIsPublished($isPublished);
     }
    public function setIsPublished($isPublished)
    {
        $this->is_published = $isPublished;
    }

    /**
     * Get is_published
     *
     * @return boolean 
     */
    public function getIsPublished()
    {
        return $this->is_published;
    }

    /**
     * Set is_removed
     *
     * @param boolean $isRemoved
     */
     public function setIs_removed($isPublished){
     	$this->setIsRemoved($isPublished);
     }
    public function setIsRemoved($isRemoved)
    {
        $this->is_removed = $isRemoved;
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
    public function setUpdatedValue()
    {
       $this->setUpdatedAt(new \DateTime());
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
     * @var JaiUneIdee\SiteBundle\Entity\Moderation
     */
    private $moderations;


    /**
     * Add moderations
     *
     * @param JaiUneIdee\SiteBundle\Entity\Moderation $moderations
     */
    public function addModeration(\JaiUneIdee\SiteBundle\Entity\Moderation $moderations)
    {
        $this->moderations[] = $moderations;
    }

    /**
     * Get moderations
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getModerations()
    {
        return $this->moderations;
    }
    /**
     * @var integer $life
     */
    private $life;


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
     * @var boolean $is_validated_by_admin
     */
    private $is_validated_by_admin;


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
     * Remove votes
     *
     * @param \JaiUneIdee\SiteBundle\Entity\Vote $votes
     */
    public function removeVote(\JaiUneIdee\SiteBundle\Entity\Vote $votes)
    {
        $this->votes->removeElement($votes);
    }

    /**
     * Remove moderations
     *
     * @param \JaiUneIdee\SiteBundle\Entity\Moderation $moderations
     */
    public function removeModeration(\JaiUneIdee\SiteBundle\Entity\Moderation $moderations)
    {
        $this->moderations->removeElement($moderations);
    }

    /**
     * Remove commentaires
     *
     * @param \JaiUneIdee\SiteBundle\Entity\Commentaire $commentaires
     */
    public function removeCommentaire(\JaiUneIdee\SiteBundle\Entity\Commentaire $commentaires)
    {
        $this->commentaires->removeElement($commentaires);
    }

    /**
     * Remove localisations
     *
     * @param \JaiUneIdee\LocalisationBundle\Entity\Localisation $localisations
     */
    public function removeLocalisation(\JaiUneIdee\LocalisationBundle\Entity\Localisation $localisations)
    {
        $this->localisations->removeElement($localisations);
    }
    /**
     * @var boolean
     */
    private $is_moderated;


    /**
     * Set is_moderated
     *
     * @param boolean $isModerated
     * @return Idee
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
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $actionsElus;


    /**
     * Add actionsElus
     *
     * @param \JaiUneIdee\SiteBundle\Entity\ActionElu $actionsElus
     * @return Idee
     */
    public function addActionsElu(\JaiUneIdee\SiteBundle\Entity\ActionElu $actionsElus)
    {
        $this->actionsElus[] = $actionsElus;
    
        return $this;
    }

    /**
     * Remove actionsElus
     *
     * @param \JaiUneIdee\SiteBundle\Entity\ActionElu $actionsElus
     */
    public function removeActionsElu(\JaiUneIdee\SiteBundle\Entity\ActionElu $actionsElus)
    {
        $this->actionsElus->removeElement($actionsElus);
    }

    /**
     * Get actionsElus
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getActionsElus()
    {
        return $this->actionsElus;
    }

    /**
     * Add actionsElus
     *
     * @param \JaiUneIdee\SiteBundle\Entity\ActionElu $actionsElus
     * @return Idee
     */
    public function addActionsElus(\JaiUneIdee\SiteBundle\Entity\ActionElu $actionsElus)
    {
        $this->actionsElus[] = $actionsElus;

        return $this;
    }

    /**
     * Remove actionsElus
     *
     * @param \JaiUneIdee\SiteBundle\Entity\ActionElu $actionsElus
     */
    public function removeActionsElus(\JaiUneIdee\SiteBundle\Entity\ActionElu $actionsElus)
    {
        $this->actionsElus->removeElement($actionsElus);
    }
    /**
     * @var \DateTime
     */
    private $last_action_at;


    /**
     * Set last_action_at
     *
     * @param \DateTime $lastActionAt
     * @return Idee
     */
    public function setLastActionAt($lastActionAt)
    {
        $this->last_action_at = $lastActionAt;
        return $this;
    }

    /**
     * Get last_action_at
     *
     * @return \DateTime 
     */
    public function getLastActionAt()
    {
        return $this->last_action_at;
    }
}
