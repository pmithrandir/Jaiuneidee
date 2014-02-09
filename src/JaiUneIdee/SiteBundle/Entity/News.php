<?php

namespace JaiUneIdee\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * News
 */
class News
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $content;

    /**
     * @var boolean
     */
    private $is_validated_by_admin;

    /**
     * @var boolean
     */
    private $is_removed;

    /**
     * @var \DateTime
     */
    private $publication_date;

    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var \DateTime
     */
    private $updated_at;


    public function __construct()
    {
        $this->setIsValidatedByAdmin(false);
        $this->setIsRemoved(false);
	$this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
    }
    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedValue()
    {
         $this->setUpdatedAt(new \DateTime());
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
     * @param string $content
     * @return News
     */
    public function setContent($content)
    {
        $this->content = $content;
    
        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set is_validated_by_admin
     *
     * @param boolean $isValidatedByAdmin
     * @return News
     */
    public function setIsValidatedByAdmin($isValidatedByAdmin)
    {
        $this->is_validated_by_admin = $isValidatedByAdmin;
    
        return $this;
    }
    public function setIs_validated_by_admin($isValidatedByAdmin)
    {
        $this->setIsValidatedByAdmin($isValidatedByAdmin);
        return $this;
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
     * Set is_removed
     *
     * @param boolean $isRemoved
     * @return News
     */
    public function setIsRemoved($isRemoved)
    {
        $this->is_removed = $isRemoved;
    
        return $this;
    }
    public function setIs_Removed($isValidatedByAdmin)
    {
        $this->setIsRemoved ($isValidatedByAdmin);
        return $this;
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
     * Set publication_date
     *
     * @param \DateTime $publicationDate
     * @return News
     */
    public function setPublicationDate($publicationDate)
    {
        $this->publication_date = $publicationDate;
    
        return $this;
    }

    /**
     * Get publication_date
     *
     * @return \DateTime 
     */
    public function getPublicationDate()
    {
        return $this->publication_date;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return News
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
     * Set updated_at
     *
     * @param \DateTime $updatedAt
     * @return News
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
    
        return $this;
    }

    /**
     * Get updated_at
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
}