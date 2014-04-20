<?php

/*
* This file is part of the FOSUserBundle package.
*
* (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace JaiUneIdee\UtilisateurBundle\Listener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
* Doctrine ORM listener updating the canonical fields and the password.
*
* @author Christophe Coevoet <stof@notk.org>
*/
class UserListener implements EventSubscriber
{
    /**
* @var \FOS\UserBundle\Model\UserManagerInterface
*/
    private $userManager;

    /**
* @var ContainerInterface
*/
    private $container;
    /*
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
	*/
    public function getSubscribedEvents()
    {
        return array(
            Events::prePersist,
        );
    }
 	public function prePersist(LifecycleEventArgs $args)
    {
	$entity = $args->getEntity();
        if ($entity instanceof UserInterface) {
            if (null === $this->userManager) {
                //$this->userManager = $this->container->get('fos_user.user_manager');
                $em = $args->getEntityManager();
                $dommage = $em->getRepository('JaiUneIdeeUtilisateurBundle:Dommage')->getUserDefaultDommage();
                $entity->setDommage($dommage);
            }
        }
    }
}
