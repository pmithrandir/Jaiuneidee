<?php

namespace JaiUneIdee\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JaiUneIdee\SiteBundle\Entity\Theme
 */
class Theme
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $nom
     */
    private $nom;

    /**
     * @var string $descriptif
     */
    private $descriptif;

    public function __construct()
    {
        $this->setIsModerated(false);
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
     * Set nom
     *
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set descriptif
     *
     * @param string $descriptif
     */
    public function setDescriptif($descriptif)
    {
        $this->descriptif = $descriptif;
    }

    /**
     * Get descriptif
     *
     * @return string 
     */
    public function getDescriptif()
    {
        return $this->descriptif;
    }
    public function __toString()
	{
	    return $this->getNom();
	}
    /**
     * @var boolean $is_moderated
     */
    private $is_moderated;


    /**
     * Set is_moderated
     *
     * @param boolean $isModerated
     */
    public function setIsModerated($isModerated)
    {
        $this->is_moderated = $isModerated;
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
     * @var integer
     */
    private $ordre;


    /**
     * Set ordre
     *
     * @param integer $ordre
     * @return Theme
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;
    
        return $this;
    }

    /**
     * Get ordre
     *
     * @return integer 
     */
    public function getOrdre()
    {
        return $this->ordre;
    }
}