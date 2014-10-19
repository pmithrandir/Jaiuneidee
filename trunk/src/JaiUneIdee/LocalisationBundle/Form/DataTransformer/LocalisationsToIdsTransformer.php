<?php
namespace JaiUneIdee\LocalisationBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\PersistentCollection;


class LocalisationsToIdsTransformer implements DataTransformerInterface
{
	protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function transform($localisations)
    {
        if (null === $localisations) {
            return "";
        }
        else if ($localisations instanceof ArrayCollection) {
            $idsArray = array();
            foreach ($localisations as $localisation) {
                $idsArray[] = $localisation->getId();
            }
            $ids = implode(",", $idsArray);
            return $ids;
        }
        elseif($localisations instanceof \JaiUneIdee\LocalisationBundle\Entity\Localisation){
        	return $localisations->getId();
        }
        else{
        	
            //throw new UnexpectedTypeException($localisations, 'ArrayCollection');
        }
    }

    public function reverseTransform($ids)
    {
        $localisations = new ArrayCollection();

        if ('' === $ids || null === $ids) {
            return $localisations;
        }

        if (!is_string($ids)) {
            throw new UnexpectedTypeException($ids, 'string');
        }
        $idsArray = explode(",", $ids);
        $idsArray = array_filter ($idsArray, 'is_numeric');
        foreach ($idsArray as $id) {
            $localisations->add($this->entityManager->getRepository('JaiUneIdeeLocalisationBundle:Localisation')->find($id));
        }
        return $localisations;
    }
}