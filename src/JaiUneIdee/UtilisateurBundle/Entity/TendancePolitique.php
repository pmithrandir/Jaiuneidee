<?php

namespace JaiUneIdee\UtilisateurBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JaiUneIdee\UtilisateurBundle\Entity\TendancePolitique
 */
class TendancePolitique
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $value
     */
    private $value;


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
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }
    
    public function __toString(){
    	return $this->getValue();
    }
}