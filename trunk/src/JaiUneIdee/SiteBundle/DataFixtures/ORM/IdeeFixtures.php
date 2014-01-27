<?php

namespace JaiUneIdee\SiteBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use JaiUneIdee\SiteBundle\Entity\Idee;

class IdeeFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    function load(ObjectManager $manager)
    {
    	/*
        $idee1 = new Idee();
        $idee1->setTheme($manager->merge($this->getReference('theme-1')));
        $idee1->setTitle('A day with Symfony2');
        $idee1->setDescription('A day with Symfony2 with more text');
        $idee1->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ut velocity magna. Etiam vehicula nunc non leo hendrerit commodo. Vestibulum vulputate mauris eget erat congue dapibus imperdiet justo scelerisque. Nulla consectetur tempus nisl vitae viverra. Cras el mauris eget erat congue dapibus imperdiet justo scelerisque. Nulla consectetur tempus nisl vitae viverra. Cras elementum molestie vestibulum. Morbi id quam nisl. Praesent hendrerit, orci sed elementum lobortis, justo mauris lacinia libero, non facilisis purus ipsum non mi. Aliquam sollicitudin, augue id vestibulum iaculis, sem lectus convallis nunc, vel scelerisque lorem tortor ac nunc. Donec pharetra eleifend enim vel porta.');
        //$idee1->setCreated(new \DateTime());
        //$idee1->setUpdated($idee1->getCreated());
        $idee1->setTheme($manager->merge($this->getReference('theme-1')));
        $manager->persist($idee1);
        
        $idee2 = new Idee();
        $idee2->setTheme($manager->merge($this->getReference('theme-2')));
        $idee2->setTitle('A 2nd day with Symfony2');
        $idee2->setDescription('A 2nd day with Symfony2 with more text');
        $idee2->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ut velocity magna. Etiam vehicula nunc non leo hendrerit commodo. Vestibulum vulputate mauris eget erat congue dapibus imperdiet justo scelerisque. Nulla consectetur tempus nisl vitae viverra. Cras el mauris eget erat congue dapibus imperdiet justo scelerisque. Nulla consectetur tempus nisl vitae viverra. Cras elementum molestie vestibulum. Morbi id quam nisl. Praesent hendrerit, orci sed elementum lobortis, justo mauris lacinia libero, non facilisis purus ipsum non mi. Aliquam sollicitudin, augue id vestibulum iaculis, sem lectus convallis nunc, vel scelerisque lorem tortor ac nunc. Donec pharetra eleifend enim vel porta.');
        //$idee2->setCreated(new \DateTime());
        //$idee2->setUpdated($idee2->getCreated());
        $manager->persist($idee2);
        
        $manager->flush();
        $this->addReference('idee-1', $idee1);
        $this->addReference('idee-2', $idee2);
        */
    }
    public function getOrder()
    {
        return 4;
    }

}