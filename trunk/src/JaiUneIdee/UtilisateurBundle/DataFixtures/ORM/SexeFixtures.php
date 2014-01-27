<?php

namespace JaiUneIdee\UtilisateurBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use JaiUneIdee\UtilisateurBundle\Entity\Sexe;

class SexeFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    function load(ObjectManager $manager)
    {
        $sexe1 = new Sexe();
        $sexe1->setValue("Homme");
        $manager->persist($sexe1);
        
        $sexe2 = new Sexe();
        $sexe2->setValue("Femme");
        $manager->persist($sexe2);
        
        $manager->flush();
        $this->addReference('sexe-1', $sexe1);
        $this->addReference('sexe-2', $sexe2);
    }
    public function getOrder()
    {
        return 1;
    }

}