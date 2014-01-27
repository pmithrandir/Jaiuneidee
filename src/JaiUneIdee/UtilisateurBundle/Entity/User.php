<?php

namespace JaiUneIdee\UtilisateurBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * JaiUneIdee\UtilisateurBundle\Entity\User
 */
class User extends BaseUser
{
    /**
     * @var integer $id
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        $this->setCreatedAt(new \DateTime());
        $this->setLastActivity(new \DateTime());
        $this->setDateDeNaissancePublic(false);
        $this->setTendancePolitiquePublic(false);
        $this->setSexePublic(false);
        $this->setLocalisationPublic(false);
        $this->setNewsletter(true);
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
    
    public function getEnabled()
    {
        return $this->isEnabled();
    }

    /**
     * @var JaiUneIdee\UtilisateurBundle\Entity\Sexe
     */
    private $sexe;

    /**
     * @var JaiUneIdee\UtilisateurBundle\Entity\TendancePolitique
     */
    private $tendance_politique;


    /**
     * Set sexe
     *
     * @param JaiUneIdee\UtilisateurBundle\Entity\Sexe $sexe
     */
    public function setSexe(\JaiUneIdee\UtilisateurBundle\Entity\Sexe $sexe)
    {
        $this->sexe = $sexe;
    }

    /**
     * Get sexe
     *
     * @return JaiUneIdee\UtilisateurBundle\Entity\Sexe 
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set tendance_politique
     *
     * @param JaiUneIdee\UtilisateurBundle\Entity\TendancePolitique $tendancePolitique
     */
    public function setTendancePolitique(\JaiUneIdee\UtilisateurBundle\Entity\TendancePolitique $tendancePolitique)
    {
        $this->tendance_politique = $tendancePolitique;
    }

    /**
     * Get tendance_politique
     *
     * @return JaiUneIdee\UtilisateurBundle\Entity\TendancePolitique 
     */
    public function getTendancePolitique()
    {
        return $this->tendance_politique;
    }
    /**
     * @var JaiUneIdee\UtilisateurBundle\Entity\Dommage
     */
    private $dommage;


    /**
     * Set dommage
     *
     * @param JaiUneIdee\UtilisateurBundle\Entity\Dommage $dommage
     */
    public function setDommage(\JaiUneIdee\UtilisateurBundle\Entity\Dommage $dommage)
    {
        $this->dommage = $dommage;
    }

    /**
     * Get dommage
     *
     * @return JaiUneIdee\UtilisateurBundle\Entity\Dommage 
     */
    public function getDommage()
    {
        return $this->dommage;
    }
    /**
     * @var date $date_de_naissance
     */
    private $date_de_naissance;


    /**
     * Set date_de_naissance
     *
     * @param date $dateDeNaissance
     */
    public function setDateDeNaissance($dateDeNaissance)
    {
        $this->date_de_naissance = $dateDeNaissance;
    }

    /**
     * Get date_de_naissance
     *
     * @return date 
     */
    public function getDateDeNaissance()
    {
        return $this->date_de_naissance;
    }
    /**
     * @var JaiUneIdee\LocalisationBundle\Entity\Localisation
     */
    private $localisation;


    /**
     * Set localisation
     *
     * @param JaiUneIdee\LocalisationBundle\Entity\Localisation $localisation
     */
    public function setLocalisation($localisation)
    {
        if($localisation instanceof ArrayCollection){
        	if($localisation->count()>0){
        		$this->localisation = $localisation->first();
        	}
        }
        elseif ($localisation instanceof \JaiUneIdee\LocalisationBundle\Entity\Localisation){
        	$this->localisation = $localisation;
        }
    }
    /**
     * Get localisation
     *
     * @return JaiUneIdee\LocalisationBundle\Entity\Localisation 
     */
    public function getLocalisation()
    {
        return $this->localisation;
    }
    /**
    * @var \JaiUneIdee\UtilisateurBundle\Entity\Invitation
    */
    private $invitation;


    /**
     * Set invitation
     *
     * @param \JaiUneIdee\UtilisateurBundle\Entity\Invitation $invitation
     * @return User
     */
    public function setInvitation(\JaiUneIdee\UtilisateurBundle\Entity\Invitation $invitation = null)
    {
        $this->invitation = $invitation;
    
        return $this;
    }

    /**
     * Get invitation
     *
     * @return \JaiUneIdee\UtilisateurBundle\Entity\Invitation 
     */
    public function getInvitation()
    {
        return $this->invitation;
    }
    /**
     * @var boolean
     */
    private $approbation_charte;


    /**
     * Set approbation_charte
     *
     * @param boolean $approbationCharte
     * @return User
     */
    public function setApprobationCharte($approbationCharte)
    {
        $this->approbation_charte = $approbationCharte;
    
        return $this;
    }

    /**
     * Get approbation_charte
     *
     * @return boolean 
     */
    public function getApprobationCharte()
    {
        return $this->approbation_charte;
    }
    /**
     * @var boolean
     */
    private $date_de_naissance_public;

    /**
     * @var boolean
     */
    private $sexe_public;

    /**
     * @var boolean
     */
    private $localisation_public;

    /**
     * @var boolean
     */
    private $tendance_politique_public;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    

    /**
     * Set date_de_naissance_public
     *
     * @param boolean $dateDeNaissancePublic
     * @return User
     */
    public function setDateDeNaissancePublic($dateDeNaissancePublic)
    {
        $this->date_de_naissance_public = $dateDeNaissancePublic;
    
        return $this;
    }

    /**
     * Get date_de_naissance_public
     *
     * @return boolean 
     */
    public function getDateDeNaissancePublic()
    {
        return $this->date_de_naissance_public;
    }

    /**
     * Set sexe_public
     *
     * @param boolean $sexePublic
     * @return User
     */
    public function setSexePublic($sexePublic)
    {
        $this->sexe_public = $sexePublic;
    
        return $this;
    }

    /**
     * Get sexe_public
     *
     * @return boolean 
     */
    public function getSexePublic()
    {
        return $this->sexe_public;
    }

    /**
     * Set localisation_public
     *
     * @param boolean $localisationPublic
     * @return User
     */
    public function setLocalisationPublic($localisationPublic)
    {
        $this->localisation_public = $localisationPublic;
    
        return $this;
    }

    /**
     * Get localisation_public
     *
     * @return boolean 
     */
    public function getLocalisationPublic()
    {
        return $this->localisation_public;
    }

    /**
     * Set tendance_politique_public
     *
     * @param boolean $tendancePolitiquePublic
     * @return User
     */
    public function setTendancePolitiquePublic($tendancePolitiquePublic)
    {
        $this->tendance_politique_public = $tendancePolitiquePublic;
    
        return $this;
    }

    /**
     * Get tendance_politique_public
     *
     * @return boolean 
     */
    public function getTendancePolitiquePublic()
    {
        return $this->tendance_politique_public;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $invitations;


    /**
     * Add invitations
     *
     * @param \JaiUneIdee\UtilisateurBundle\Entity\Invitation $invitations
     * @return User
     */
    public function addInvitation(\JaiUneIdee\UtilisateurBundle\Entity\Invitation $invitations)
    {
        $this->invitations[] = $invitations;
    
        return $this;
    }

    /**
     * Remove invitations
     *
     * @param \JaiUneIdee\UtilisateurBundle\Entity\Invitation $invitations
     */
    public function removeInvitation(\JaiUneIdee\UtilisateurBundle\Entity\Invitation $invitations)
    {
        $this->invitations->removeElement($invitations);
    }

    /**
     * Get invitations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInvitations()
    {
        return $this->invitations;
    }
    /**
     * @var \DateTime
     */
    private $created_at;


    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return User
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
     * @var string
     */
    private $avatar;
    private $avatar_changed;

    /**
     * Set avatar
     *
     * @param string $avatar
     * @return User
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
        $this->avatar_changed = true;
        return $this;
    }

    /**
     * Get avatar
     *
     * @return string 
     */
    public function getAvatar()
    {
        return $this->avatar;
    }
    public function getFullAvatarPath() {
        return null === $this->avatar ? null : $this->getUploadRootDir(). $this->avatar;
    }
 
    protected function getUploadRootDir() {
        // the absolute directory path where uploaded documents should be saved
        return $this->getTmpUploadRootDir().$this->getId()."/";
    }
 
    protected function getTmpUploadRootDir() {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__ . '/../../../../web/upload/';
    }
    public function uploadAvatar() {
        // the file property can be empty if the field is not required
        if (($this->avatar_changed!==true)||(null === $this->avatar)) {
            return;
        }
        if($this->id){
            $this->avatar->move($this->getUploadRootDir(), $this->avatar->getClientOriginalName());
        }
        $this->setAvatar($this->avatar->getClientOriginalName());
        $this->avatar_changed = false;
    }
    public function moveImage()
    {
        if (null === $this->avatar) {
            return;
        }
        if(!is_dir($this->getUploadRootDir())){
            mkdir($this->getUploadRootDir());
        }
        copy($this->getTmpUploadRootDir().$this->avatar, $this->getFullAvatarPath());
        unlink($this->getTmpUploadRootDir().$this->avatar);
    }
    public function removeImage()
    {
        if(is_file($this->getFullAvatarPath())){
            unlink($this->getFullAvatarPath());
        }
    }
    /**
     * @var \DateTime
     */
    private $last_activity;


    /**
     * Set last_activity
     *
     * @param \DateTime $lastActivity
     * @return User
     */
    public function setLastActivity($lastActivity)
    {
        $this->last_activity = $lastActivity;
    
        return $this;
    }

    /**
     * Get last_activity
     *
     * @return \DateTime 
     */
    public function getLastActivity()
    {
        return $this->last_activity;
    }
    /**
     * @var boolean
     */
    private $newsletter;


    /**
     * Set newsletter
     *
     * @param boolean $newsletter
     * @return User
     */
    public function setNewsletter($newsletter)
    {
        $this->newsletter = $newsletter;
    
        return $this;
    }

    /**
     * Get newsletter
     *
     * @return boolean 
     */
    public function getNewsletter()
    {
        return $this->newsletter;
    }
}