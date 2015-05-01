<?php

namespace JaiUneIdee\LocalisationBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use JaiUneIdee\LocalisationBundle\Entity\Localisation;
use JaiUneIdee\SiteBundle\Model\IdeeSearch;
use FOS\ElasticaBundle\Doctrine\RepositoryManager;
use  FOS\ElasticaBundle\Persister\ObjectPersister;
class LocalisationListener
{
    private $elasticSearchManager;
    private $persister;
    public function __construct(RepositoryManager $elasticSearchManager, ObjectPersister $persister){
        $this->elasticSearchManager = $elasticSearchManager;
        $this->persister = $persister;
    }
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
        if(($localisation->getParent())&&(true===$event->hasChangedField("parent"))&&($event->getNewValue("parent")!= $event->getOldValue("parent"))){
            if(($event->getNewValue("parent")->getMin()>=$localisation->getMin())&&($event->getNewValue("parent")->getMax()<=$localisation->getMax())){
                die("Impossible de définir un parent qui est un enfant actuel");
            }
            $repository = $event->getEntityManager()->getRepository('JaiUneIdeeLocalisationBundle:Localisation');
            //Min et Max ne sont pas mis a jour, et donc pas dans les "old value"
            $repository->updateElementProcess($localisation,$event->getNewValue("parent"));
            //récupérer toutes les idées qui ont une certaine localisation à quelque niveau que ce soit
            $ideeSearch = new IdeeSearch();
            $ideeSearch->setLocalisationObject($repository->find($localisation->getId()));
            $ideeSearch->setWithChildrenLoc(true);
            $searchRepository = $this->elasticSearchManager->getRepository('JaiUneIdeeSiteBundle:Idee');
            $results = $searchRepository->searchES($ideeSearch);
            $localisation->setNiveau($localisation->getParent()->getNiveau()+1);
            //les mettre à jour dans elastic search
            foreach ($results as $result){
                $this->persister->insertOne($event->getEntityManager()->getRepository('JaiUneIdeeSiteBundle:Idee')->find($result->getSource()['id']));
            }
        }
    }
    public function preRemove(Localisation $localisation, LifecycleEventArgs $event)
    {   if(!$localisation->getParent()){
            die("impossible de supprimer la racine");
        }
        $repository = $event->getEntityManager()->getRepository('JaiUneIdeeLocalisationBundle:Localisation');
        $repository->preRemoveProcess($localisation, $localisation->getParent());
        //supprimer la localisation des idées
        $idees = $event->getEntityManager()->getRepository('JaiUneIdeeSiteBundle:Idee')->getAllIdeesByLocalisationWithoutChildren($localisation);
        foreach($idees as $idee){
            $idee->addLocalisation($localisation->getParent());
            $idee->removeLocalisation($localisation);
        }
        $users = $event->getEntityManager()->getRepository('JaiUneIdeeUtilisateurBundle:User')->findByLocalisation($localisation);
        foreach($users as $user){
            $user->setLocalisation($localisation->getParent());
        }
    }
    public function postRemove(Localisation $localisation, LifecycleEventArgs $event)
    {   
        if($localisation->getParent()){
            $repository = $event->getEntityManager()->getRepository('JaiUneIdeeLocalisationBundle:Localisation');
            $repository->deleteElementProcess($localisation->getMin(), $localisation->getMax(),$localisation->getParent());
            //recalcule des objet dans Elastic search
            $ideeSearch = new IdeeSearch();
            $ideeSearch->setLocalisationObject($localisation);
            $ideeSearch->setWithChildrenLoc(true);
            $searchRepository = $this->elasticSearchManager->getRepository('JaiUneIdeeSiteBundle:Idee');
            $results = $searchRepository->searchES($ideeSearch);
            //les mettre à jour dans elastic search
            foreach ($results as $result){
                $this->persister->insertOne($event->getEntityManager()->getRepository('JaiUneIdeeSiteBundle:Idee')->find($result->getSource()['id']));
            }
        }
    }
}