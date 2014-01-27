<?php

namespace JaiUneIdee\SiteBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use JaiUneIdee\SiteBundle\Entity\Commentaire;

class CommentaireFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    function load(ObjectManager $manager)
    {
        /*
        $commentaire1 = new Commentaire();
        $commentaire1->setIdee($manager->merge($this->getReference('idee-1')));
        $commentaire1->setTitle('A comment');
        $commentaire1->setDescription('A comment with more text');
        $commentaire1->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ut velocity magna. Etiam vehicula nunc non leo hendrerit commodo. Vestibulum vulputate mauris eget erat congue dapibus imperdiet justo scelerisque. Nulla consectetur tempus nisl vitae viverra. Cras el mauris eget erat congue dapibus imperdiet justo scelerisque. Nulla consectetur tempus nisl vitae viverra. Cras elementum molestie vestibulum. Morbi id quam nisl. Praesent hendrerit, orci sed elementum lobortis, justo mauris lacinia libero, non facilisis purus ipsum non mi. Aliquam sollicitudin, augue id vestibulum iaculis, sem lectus convallis nunc, vel scelerisque lorem tortor ac nunc. Donec pharetra eleifend enim vel porta.');
        //$commentaire1->setCreated(new \DateTime());
        //$commentaire1->setUpdated($commentaire1->getCreated());
        $manager->persist($commentaire1);
        $manager->flush();
        */
    }
    public function getOrder()
    {
        return 5;
    }

}