<?php

namespace JaiUneIdee\UtilisateurBundle\Listener;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use DateTime;
use JaiUneIdee\UtilisateurBundle\Entity\User;

class Activity {

    protected $context;
    protected $em;

    public function __construct(SecurityContext $context, EntityManager $entity_manager) {
        $this->context = $context;
        $this->em = $entity_manager;
    }

    /**
     * On each request we want to update the user's last activity datetime
     *
     * @param \Symfony\Component\HttpKernel\Event\FilterControllerEvent $event
     * @return void
     */
    public function onCoreController(FilterControllerEvent $event) {
        if($this->context->getToken()){
            $user = $this->context->getToken()->getUser();
            if ($user instanceof User) {
                //here we can update the user as necessary
                $user->setLastActivity(new DateTime());

                $this->em->persist($user);
                $this->em->flush($user);
            }
        }
    }

}