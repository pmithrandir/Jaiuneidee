<?php

namespace JaiUneIdee\SiteBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use JaiUneIdee\SiteBundle\Entity\Vote;

class VoteFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    function load(ObjectManager $manager)
    {
        /*
        $vote = new Vote();
        $vote->setIdee($manager->merge($this->getReference('idee-1')));
        $vote->setNote(1);
        $manager->persist($vote);
        
        $vote = new Vote();
        $vote->setIdee($manager->merge($this->getReference('idee-1')));
        $vote->setNote(1);
        $manager->persist($vote);
        
        $vote = new Vote();
        $vote->setIdee($manager->merge($this->getReference('idee-2')));
        $vote->setNote(-1);
        $manager->persist($vote);
        
        $vote = new Vote();
        $vote->setIdee($manager->merge($this->getReference('idee-2')));
        $vote->setNote(0);
        $manager->persist($vote);
        
        $manager->flush();
        */
    }
    public function getOrder()
    {
        return 5;
    }

}