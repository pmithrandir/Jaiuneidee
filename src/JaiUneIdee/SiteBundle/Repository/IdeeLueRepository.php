<?php

namespace JaiUneIdee\SiteBundle\Repository;

use Doctrine\ORM\EntityRepository;
use JaiUneIdee\SiteBundle\Entity\IdeeLue;

/**
 * IdeeLueRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class IdeeLueRepository extends EntityRepository
{
    public function estLue($idee, $user){
        $qb = $this->createQueryBuilder('il')
                ->where('il.idee = :idee')
                ->andWhere('il.user = :user')
		->setParameter('idee', $idee)
                ->setParameter('user', $user)
                ;
        return $qb->getQuery()->getResult();
    }
    public function sontLues($idees, $user){
        $ids = array();
        foreach($idees as $idee) {
            $ids[] = $idee[0]->getId();
        }
        $qb = $this->createQueryBuilder('il')
                ->andWhere('il.user = :user')
                ->andwhere('il.idee IN (:idees)')
		->setParameter('idees',$ids)
                ->setParameter('user', $user)
                ;
        return $qb->getQuery()->getResult();
    }
    public function RemoveAllLuForIdee($idee){
        $qb = $this->createQueryBuilder('il');
        $qb->delete()
                ->where('il.idee = :idee')
                ->setParameter('idee', $idee)
                ;
        return $qb->getQuery()->getResult();
    }
    
}