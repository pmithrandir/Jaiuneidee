<?php

namespace JaiUneIdee\UtilisateurBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use JaiUneIdee\UtilisateurBundle\Entity\Dommage;

class DommageFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    function load(ObjectManager $manager)
    {
        $dommages = array();
        $listes = array(
        	1=>0,
        	2=>1,
        	3=>3,
        	4=>7,
        	5=>12,
        	6=>18,
        	7=>23,
        	8=>26,
        	9=>34,
        	10=>42,
        	11=>50,
        	12=>65,
        	13=>78,
        	14=>85,
        	15=>100,
        	16=>122,
        	17=>150,
        	18=>168,
        	19=>200,
        	20=>225,
        	21=>250,
        	22=>275,
        	23=>300,
        	24=>325,
        	25=>350,
        	26=>375,
        	27=>400,
        	28=>425,
        	29=>450,
        	30=>475,
        	31=>500,
        	32=>600,
        	33=>700,
        	34=>800,
        	35=>900,
        	36=>1000
		);
		foreach($listes as $level=>$dommage){
			$dommageObject = new Dommage();
	        $dommageObject->setLevel($level);
	        $dommageObject->setValue($dommage);
	        $dommages[] = $dommageObject;
	        $manager->persist($dommageObject);
		}
		
        $manager->flush();
        $i=1;
        foreach($dommages as $dommage){
        	$this->addReference('dommage-'.$i, $dommage);
        	$i++;
        }
    }
    public function getOrder()
    {
        return 1;
    }

}