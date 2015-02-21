<?php

namespace JaiUneIdee\SiteBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;
use Doctrine\DBAL\LockMode;

/**
 * IdeeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class IdeeRepository extends EntityRepository {

    public function getIdee($id) {
        $qb = $this->createQueryBuilder('i');
        $qb->select('i', 'c', 't', 'l','ae')
                ->join('i.theme', 't')
                ->join('i.localisations', 'l')
                ->leftJoin('i.commentaires', 'c', Expr\Join::WITH, 'c.is_removed=false AND (c.life > 0 OR c.is_validated_by_admin = true)')
                ->leftJoin('i.actionsElus', 'ae')
                ->where('i.id = :id')
                ->orderBy('c.created_at')
                ->setParameter('id', $id);
        return $qb->getQuery()->getOneOrNullResult();
    }

    /*
      public function getIdee2($id)
      {
      $qb = $this->createQueryBuilder('i');
      $qb->select('i','c')
      ->leftJoin('i.commentaires', 'c', Expr\Join::WITH,'c.is_removed=false AND (c.life > 0 OR c.is_validated_by_admin = true)')
      ->where(
      $qb->expr()->orX(
      $qb->expr()->gt('i.life',0),
      $qb->expr()->eq('i.is_validated_by_admin', "true")
      )
      )
      ->andwhere('i.is_published = true')
      ->andwhere('i.is_removed = false')
      ->andWhere('i.id = :id')
      ->setParameter('id', $id);
      return $qb->getQuery()->getOneOrNullResult();
      } */

    public function getIdeeWithVote($id) {
        $qb = $this->createQueryBuilder('i');
        $qb->select('i', 'c', 'v')
                ->leftJoin('i.commentaires', 'c', Expr\Join::WITH, 'c.is_removed=false AND (c.life > 0 OR c.is_validated_by_admin = true)')
                ->leftJoin('c.votes', 'v', 'WITH', 'c.user_id = v.user_id AND c.idee_id = v.idee_id')
                ->where(
                        $qb->expr()->orX(
                                $qb->expr()->gt('i.life', 0), $qb->expr()->eq('i.is_validated_by_admin', "true")
                        )
                )
                ->andwhere('i.is_published = true')
                ->andwhere('i.is_removed = false')
                ->andWhere('i.id = :id')
                ->setParameter('id', $id);
        return $qb->getQuery()->getOneOrNullResult();
    }

    public function getIdeesByLocalisation($localisation, $limit = null) {
        $qb = $this->createQueryBuilder('i');
        $qb->select('i', 'COUNT(c.id) as nombre')
                ->innerjoin('i.localisations', 'l')
                ->leftJoin('i.commentaires', 'c', Expr\Join::WITH, 'c.is_removed=false AND (c.life > 0 OR c.is_validated_by_admin = true)')
                ->where(
                        $qb->expr()->orX(
                                $qb->expr()->gt('i.life', 0), $qb->expr()->eq('i.is_validated_by_admin', "true")
                        )
                )
                ->andWhere('i.is_published = true')
                ->andwhere('i.is_removed = false')
                ->andWhere('l.min>=:min')
                ->andWhere('l.max<=:max')
                ->setParameter('min', $localisation->getMin())
                ->setParameter('max', $localisation->getMax())
                ->addGroupBy('i')
                ->addOrderBy('i.id', 'DESC')
        ;
        if (false === is_null($limit))
            $qb->setMaxResults($limit);
        return $qb->getQuery()->execute();
    }

    public function getLatestIdeesQb($limit = null, $offset = null) {
        $qb = $this->createQueryBuilder('i');
        $qb->select('i')
                ->where(
                        $qb->expr()->orX(
                                $qb->expr()->gt('i.life', 0), $qb->expr()->eq('i.is_validated_by_admin', "true")
                        )
                )
                ->andWhere('i.is_published = true')
                ->andwhere('i.is_removed = false');
        //->addOrderBy('i.id', 'DESC');
        return $qb;
    }

    public function getLatestIdees($limit = null, $offset = null) {
        $qb = $this->createQueryBuilder('i');
        $qb->select('i', 'COUNT(c.id) as nombre')
                ->leftJoin('i.commentaires', 'c', Expr\Join::WITH, 'c.is_removed=false AND (c.life > 0 OR c.is_validated_by_admin = true)')
                ->where(
                        $qb->expr()->orX(
                                $qb->expr()->gt('i.life', 0), $qb->expr()->eq('i.is_validated_by_admin', "true")
                        )
                )
                ->andWhere('i.is_published = true')
                ->andwhere('i.is_removed = false')
                ->addGroupBy('i')
                ->addOrderBy('i.id', 'DESC')
        ;
        if (false === is_null($limit))
            $qb->setMaxResults($limit);
        if (false === is_null($offset))
            $qb->skip($offset);
        return $qb->getQuery()->execute();
    }

    public function getLatestIdees24h($limit = null) {
        $qb = $this->createQueryBuilder('i');
        $qb->select('i')
                ->where(
                        $qb->expr()->orX(
                                $qb->expr()->gt('i.life', 0), $qb->expr()->eq('i.is_validated_by_admin', "true")
                        )
                )
                ->andWhere('i.is_published = true')
                ->andwhere('i.is_removed = false')
                ->addOrderBy('i.id', 'DESC')
        ;
        $qb->andWhere('i.created_at >= :hier');
        $qb->setParameter('hier', new \DateTime('-1 day'));
        if (false === is_null($limit))
            $qb->setMaxResults($limit);
        return $qb->getQuery()->execute();
    }
    public function getIdeesByUser($user_id) {
        $qb = $this->getLatestIdeesQb();
        $qb->andWhere('i.user = :user_id')
            ->setParameter('user_id', $user_id)
            ->addOrderBy('i.id', 'DESC');
        ;
        return $qb->getQuery()->execute();
    }

    public function getIdeesBuzz($limit = null) {
        $qb = $this->createQueryBuilder('i');
        $qb->select('i', 'COUNT(c.id) as nombre')
                ->leftJoin('i.commentaires', 'c', Expr\Join::WITH, 'c.is_removed=false AND (c.life > 0 OR c.is_validated_by_admin = true)')
                ->where(
                        $qb->expr()->orX(
                                $qb->expr()->gt('i.life', 0), $qb->expr()->eq('i.is_validated_by_admin', "true")
                        )
                )
                ->andWhere('i.is_published = true')
                ->andwhere('i.is_removed = false')
                ->addGroupBy('i')
                ->addOrderBy('nombre', 'DESC')
                ->addOrderBy('i.id', 'DESC')
        ;
        if (false === is_null($limit))
            $qb->setMaxResults($limit);

        return $qb->getQuery()->execute();
    }

    public function getIdeesModeration() {
        $qb = $this->queryModeration();
        $qb->addOrderBy('i.id', 'ASC');
        return $qb->getQuery()->execute();
    }

    public function countIdeesModeration() {
        $qb = $this->queryModeration();
        $qb->select('COUNT(i.id)');
        return $qb->getQuery()->getSingleScalarResult();
    }

    private function queryModeration() {
        $qb = $this->createQueryBuilder('i');
        $qb->where(
                $qb->expr()->orX(
                        $qb->expr()->andX(
                                $qb->expr()->lt('i.life', 500), $qb->expr()->eq('i.is_moderated', "false")
                        ), $qb->expr()->andX(
                                $qb->expr()->eq('i.is_published', "false"), $qb->expr()->eq('i.is_removed', "false")
                        )
                )
        )
        ;
        return $qb;
    }

    public function getCommentairesModeration() {
        $qb = $this->queryModerationCommentaire();
        $qb->addOrderBy('i.id', 'ASC');
        return $qb->getQuery()->execute();
    }

    private function queryModerationCommentaire() {
        $qb = $this->createQueryBuilder('i');
        $qb->select('i')
                ->join('i.commentaires', 'c')
                ->where('c.life <= 200')
                ->andWhere('c.is_moderated = false')
        ;
        return $qb;
    }

    public function countIdeesModerationCommentaire() {
        $qb = $this->queryModerationCommentaire();
        $qb->select('COUNT(c.id)');
        return $qb->getQuery()->getSingleScalarResult();
    }
    /*
     * $options = array(
      'localisation'=> ,
      'withLocChildren'=> ,
      'typeTri'=> ,
      'limit'=> ,
     )
     */
    public function getIdeesWithParam($options) {
        $qb= $this->getIdeesWithParamQueryBuilder($options);
        return $qb->getQuery()->execute();
    }
    public function getIdeesWithParamQueryBuilder($options){
        $localisation = $options['localisation'];
        $withLocChildren = $options['withLocChildren'];
        $theme = null;
        if(isset($options['theme'])){
            $theme = $options['theme'];
        }
        if(isset($options['typeTri'])){
            $typeTri = $options['typeTri'];
        }
        else{
            $typeTri = "derniereIdee";
        }
        if(isset($options['limit'])){
            $limit = $options['limit'];
        }
        else{
            $limit = null;
        }
        $qb = $this->createQueryBuilder('i');
        //$qb->select('i','t', 'COUNT(DISTINCT c.id) as nombre', 'CASE WHEN COUNT(c.id)>0 THEN MAX(c.created_at) ELSE i.updated_at END AS derniere_activite')
        $qb->select('i','t', 'COUNT(DISTINCT c.id) as nombre')
            ->innerjoin('i.localisations', 'l')
            ->innerjoin('i.theme', 't')
            ->leftJoin('i.commentaires', 'c', Expr\Join::WITH, 'c.is_removed=false AND (c.life > 0 OR c.is_validated_by_admin = true)')
            ->addGroupBy('i','t')
            ;
        
        if ($theme !== null) {
            $qb->andWhere('i.theme=:theme')
                ->setParameter('theme', $theme)
            ;
        }
        $qb->andWhere('i.is_published = true')
            ->andwhere('i.is_removed = false')
            ->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->gt('i.life', 0), $qb->expr()->eq('i.is_validated_by_admin', "true")
                )
            )
        ;
        if(($localisation->getParent()==null)&&($withLocChildren === true)){
            
        }
        elseif ($withLocChildren === false) {
            $qb->andWhere('l.id=:loc_id')
                    ->setParameter('loc_id', $localisation->getId())
            ;
        } else {
            $qb->andWhere('l.min>=:min')
                    ->andWhere('l.max<=:max')
                    ->setParameter('min', $localisation->getMin())
                    ->setParameter('max', $localisation->getMax())
            ;
        }
        switch ($typeTri) {
            case "Buzz":
                $qb->addOrderBy('nombre', 'DESC')
                        ->addOrderBy('i.id', 'DESC');
                break;
            case "derniereIdee":
                $qb->addOrderBy('i.id', 'DESC');
                break;
            case "derniereActivite":
                $qb->addOrderBy('i.last_action_at', 'DESC');
                break;
        }
        if (false === is_null($limit)) {
            $qb->setMaxResults($limit);
        }
        return $qb;
    }
    public function getVotesByIdees($idees){
        $ids = array();
        foreach($idees as $idee) {
            $ids[] = $idee[0]->getId();
        }
        $qb = $this->createQueryBuilder('i')
                    ->select('i.id', 'v.note','COUNT(v.id) as nombre')
                    ->innerjoin('i.votes', 'v')
                    ->where('i IN (:idees)')
                    ->andwhere('v.is_removed = false')
                    ->addGroupBy('i, v.note')
                    ->addOrderBy('v.note')
                    ->setParameter('idees', $ids)
                ;
        $result = $qb->getQuery()->getResult();
        $aRetourner = array();
        foreach($result as $value){
        	$aRetourner[$value['id']][$value['note']] = $value['nombre'];
        }
        return $aRetourner;
    }

    public function count24(){
        $qb = $this->createQueryBuilder('i');
        $qb->select('count(i.id)');
        $qb->andWhere('i.created_at >= :hier');
        $qb->setParameter('hier', new \DateTime('-1 day'));
        return $qb->getQuery()->getSingleScalarResult();
    }
    public function count(){
        $qb = $this->createQueryBuilder('i');
        $qb->select('count(i.id)');
        return $qb->getQuery()->getSingleScalarResult();
    }
}