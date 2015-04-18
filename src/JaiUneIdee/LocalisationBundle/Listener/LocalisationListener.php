<?php

namespace JaiUneIdee\LocalisationBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use JaiUneIdee\LocalisationBundle\Entity\Localisation;
use JaiUneIdee\LocalisationBundle\Repository\LocalisationRepository;

class LocalisationListener
{
    /*
    public function prePersist(Localisation $localisation, LifecycleEventArgs $event)
    {
        $repository = $event->getEntityManager()->getRepository('JaiUneIdeeLocalisationBundle:Localisation');
        if($localisation->getParent()){
            $parent = $localisation->getParent();
            $repository->insertElementProcess($parent->getMin(), $parent->getMax());
            $localisation->setMin($parent->getMax());
            $localisation->setMax($parent->getMax()+1);
            $localisation->setNiveau($parent->getNiveau()+1);
        }
    }
    public function preUpdate(Localisation $localisation, PreUpdateEventArgs  $event)
    {
        if(($localisation->getParent())&&($event->getNewValue("parent")!= $event->getOldValue("parent"))){
            if(($event->getNewValue("parent")->getMin()>=$localisation->getMin())&&($event->getNewValue("parent")->getMax()<=$localisation->getMax())){
                die("Impossible de définir un parent qui est un enfant actuel");
            }
            $repository = $event->getEntityManager()->getRepository('JaiUneIdeeLocalisationBundle:Localisation');
            //Min et Max ne sont pas mis a jour, et donc pas dans les "old value"
            $repository->updateElementProcess($localisation, $event->getOldValue("parent"),$event->getNewValue("parent"), $localisation->getMin(), $localisation->getMax());
            $localisation->setNiveau($localisation->getParent()->getNiveau()+1);
        }
    }
    public function preRemove(Localisation $localisation, LifecycleEventArgs $event)
    {   if(!$localisation->getParent()){
            die("impossible de supprimer la racine");
        }
    }
    public function postRemove(Localisation $localisation, LifecycleEventArgs $event)
    {   
        if($localisation->getParent()){
            $repository = $event->getEntityManager()->getRepository('JaiUneIdeeLocalisationBundle:Localisation');
            $repository->deleteElementProcess($localisation->getMin(), $localisation->getMax(),$localisation->getParent());
        }
    }*/
}