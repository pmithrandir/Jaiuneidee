<?php

namespace JaiUneIdee\UtilisateurBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use JaiUneIdee\UtilisateurBundle\Entity\Invitation;

class InvitationFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    function load(ObjectManager $manager)
    {
        $invitation1 = new Invitation();
        $invitation1->setCode("Iadmin");
        $invitation1->setEmail("admin@jaiuneidee.net");
        $manager->persist($invitation1);
        
        $manager->flush();
        $this->addReference('invitation_admin', $invitation1);
    }
    public function getOrder()
    {
        return 1;
    }

}