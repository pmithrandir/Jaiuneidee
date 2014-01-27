<?php

namespace JaiUneIdee\UtilisateurBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use JaiUneIdee\UtilisateurBundle\Entity\TendancePolitique;

class TendancePolitiqueFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    function load(ObjectManager $manager)
    {
        $tendancePolitiques = array();
        $tendances = array(
        	"Extrème droite",
        	"Droite polulaire",
        	"Droite libérale",
        	"Droite chrétienne",
        	"Ecologistes de droite",
        	"Centre Droit",
        	"Centre",
        	"Ecologistes",
        	"Centre gauche",
        	"Gauche Libérale",
        	"Ecologistes de gauche",
        	"Gauche socialiste",
        	"Gauche communiste",
        	"Gauche ouvrière",
        	"Royaliste",
		);
		foreach($tendances as $tendance){
			$tendancePolitique = new TendancePolitique();
	        $tendancePolitique->setValue($tendance);
	        $tendancePolitiques[] = $tendancePolitique;
	        $manager->persist($tendancePolitique);
		}
		
        $manager->flush();
        $i=1;
        foreach($tendancePolitiques as $tendance){
        	$this->addReference('tendancePolitique-'.$i, $tendance);
        	$i++;
        }
    }
    public function getOrder()
    {
        return 1;
    }

}