<?php

namespace JaiUneIdee\SiteBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CommentaireRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommentaireRepository extends EntityRepository
{
	
    public function getCommentaires($idee){
        $qb = $this->getCommentairesQb($idee);
        return $qb->getQuery()->getResult();
    }
    public function getCommentairesQb($idee){
        $qb = $this->createQueryBuilder('c');
        $qb->select('c')
                ->where('c.idee = :idee')
                ->andWhere('c.is_removed=false')
                ->andWhere(
                	$qb->expr()->orX(
		                    $qb->expr()->gt('c.life',0),
		                    $qb->expr()->eq('c.is_validated_by_admin', "true")
		                )
		        )
                ->setParameter("idee",$idee)
                ->orderBy("c.created_at")
                ;
        return $qb;
    }
    public function getLastCommentaire($idee){
		$qb = $this->createQueryBuilder('c');
        $qb->select('c')
                ->where('c.idee = :idee')
                ->andWhere('c.is_removed=false')
                ->andWhere(
                	$qb->expr()->orX(
		                    $qb->expr()->gt('c.life',0),
		                    $qb->expr()->eq('c.is_validated_by_admin', "true")
		                )
		        )
                ->setParameter("idee",$idee)
                ->orderBy("c.created_at", "desc")
                ->setMaxResults(1);
        return $qb->getQuery()->getOneOrNullResult();
    }
    public function count24(){
        $qb = $this->createQueryBuilder('c');
        $qb->select('count(c.id)');
        $qb->andWhere('c.created_at >= :hier');
        $qb->setParameter('hier', new \DateTime('-1 day'));
        return $qb->getQuery()->getSingleScalarResult();
    }
    public function count(){
        $qb = $this->createQueryBuilder('c');
        $qb->select('count(c.id)');
        return $qb->getQuery()->getSingleScalarResult();
    }
}