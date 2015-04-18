<?php

namespace JaiUneIdee\LocalisationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JaiUneIdee\LocalisationBundle\Entity\Localisation
 */
class Localisation
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
     * @var JaiUneIdee\LocalisationBundle\Entity\Localisation
     */
    private $parent;


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
     * Set parent
     *
     * @param JaiUneIdee\LocalisationBundle\Entity\Localisation $parent
     */
    public function setParent(\JaiUneIdee\LocalisationBundle\Entity\Localisation $parent)
    {
        $this->parent = $parent;
    }

    /**
     * Get parent
     *
     * @return JaiUneIdee\LocalisationBundle\Entity\Localisation 
     */
    public function getParent()
    {
        return $this->parent;
    }
    public function __toString(){
    	return $this->nom;
    }
    /**
     * @var int $min
     */
    private $min;

    /**
     * @var int $max
     */
    private $max;


    /**
     * Set min
     *
     * @param int $min
     */
    public function setMin($min)
    {
        $this->min = $min;
    }

    /**
     * Get min
     *
     * @return int 
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * Set max
     *
     * @param int $max
     */
    public function setMax($max)
    {
        $this->max = $max;
    }

    /**
     * Get max
     *
     * @return int 
     */
    public function getMax()
    {
        return $this->max;
    }
    /**
     * @var integer
     */
    private $niveau;


    /**
     * Set niveau
     *
     * @param integer $niveau
     * @return Localisation
     */
    public function setNiveau($niveau)
    {
        $this->niveau = $niveau;
    
        return $this;
    }

    /**
     * Get niveau
     *
     * @return integer 
     */
    public function getNiveau()
    {
        return $this->niveau;
    }
    /**
     * @var integer
     */
    private $population;


    /**
     * Set population
     *
     * @param integer $population
     * @return Localisation
     */
    public function setPopulation($population)
    {
        $this->population = $population;
    
        return $this;
    }

    /**
     * Get population
     *
     * @return integer 
     */
    public function getPopulation()
    {
        return $this->population;
    }

    /**
     * @var string
     */
    private $urlName;


    /**
     * Set urlName
     *
     * @param string $urlName
     * @return Localisation
     */
    public function setUrlName($urlName)
    {
        $this->urlName = $urlName;

        return $this;
    }

    /**
     * Get urlName
     *
     * @return string 
     */
    public function getUrlName()
    {
        return $this->urlName;
    }
    /**
     * @var string
     */
    private $footer;


    /**
     * Set footer
     *
     * @param string $footer
     * @return Localisation
     */
    public function setFooter($footer)
    {
        $this->footer = $footer;

        return $this;
    }

    /**
     * Get footer
     *
     * @return string 
     */
    public function getFooter()
    {
        return $this->footer;
    }
    /**
     * @var string
     */
    private $css;


    /**
     * Set css
     *
     * @param string $css
     * @return Localisation
     */
    public function setCss($css)
    {
        $this->css = $css;

        return $this;
    }

    /**
     * Get css
     *
     * @return string 
     */
    public function getCss()
    {
        return $this->css;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $enfants;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->enfants = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add enfant
     *
     * @param \JaiUneIdee\LocalisationBundle\Entity\Localisation $enfant
     *
     * @return Localisation
     */
    public function addEnfant(\JaiUneIdee\LocalisationBundle\Entity\Localisation $enfant)
    {
        $this->enfants[] = $enfant;

        return $this;
    }

    /**
     * Remove enfant
     *
     * @param \JaiUneIdee\LocalisationBundle\Entity\Localisation $enfant
     */
    public function removeEnfant(\JaiUneIdee\LocalisationBundle\Entity\Localisation $enfant)
    {
        $this->enfants->removeElement($enfant);
    }

    /**
     * Get enfants
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEnfants()
    {
        return $this->enfants;
    }
}
