<?php

namespace JaiUneIdee\UtilisateurBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JaiUneIdee\UtilisateurBundle\Entity\Dommage
 */
class Dommage
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var integer $value
     */
    private $value;


    public function __toString(){
    	return $this->value."";
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
     * Set value
     *
     * @param integer $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Get value
     *
     * @return integer 
     */
    public function getValue()
    {
        return $this->value;
    }
    /**
     * @var integer $level
     */
    private $level;


    /**
     * Set level
     *
     * @param integer $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * Get level
     *
     * @return integer 
     */
    public function getLevel()
    {
        return $this->level;
    }
}