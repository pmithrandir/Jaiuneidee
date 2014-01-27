<?php

namespace JaiUneIdee\SiteBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use JaiUneIdee\SiteBundle\Entity\Theme;

class ThemeFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    function load(ObjectManager $manager)
    {
        $theme1 = new Theme();
        $theme1->setNom("Logement");
        $theme1->setDescriptif("Tous les idées qui concernent le logement");
        $manager->persist($theme1);
        
        $theme2 = new Theme();
        $theme2->setNom("Aides sociales");
        $theme2->setDescriptif("Tous les idées qui concernent les Aides sociales");
        $manager->persist($theme2);
        
        $theme3 = new Theme();
        $theme3->setNom("Expatriation");
        $theme3->setDescriptif("Tous les idées qui concernent l'expatriation'");
        $manager->persist($theme3);
        
        $theme4 = new Theme();
        $theme4->setNom("Système Politique");
        $theme4->setDescriptif("Tous les idées qui concernent le Système Politique.");
        $manager->persist($theme4);
        
        $theme5 = new Theme();
        $theme5->setNom("Immigration");
        $theme5->setDescriptif("Quelles idées avez-cous dans le domaine de l'immigration'.");
        $theme5->setIsModerated(true);
        $manager->persist($theme5);
        
        $manager->flush();
        $this->addReference('theme-1', $theme1);
        $this->addReference('theme-2', $theme2);
        $this->addReference('theme-3', $theme3);
        $this->addReference('theme-4', $theme4);
        $this->addReference('theme-5', $theme5);
    }
    public function getOrder()
    {
        return 1;
    }

}