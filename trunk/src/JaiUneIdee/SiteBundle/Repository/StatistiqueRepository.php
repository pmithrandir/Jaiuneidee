<?php

namespace JaiUneIdee\SiteBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * StatistiqueRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class StatistiqueRepository extends EntityRepository
{
    public function getAllStats(){
        $qb = $this->createQueryBuilder('s');
        $qb->orderBy('s.created_at');
        $result = $qb->getQuery()->getResult();
        $aRetourner = Array();
        foreach($result as $value){
            $aRetourner['user_connecté_24'][] = array($value->getCreatedAt()->format('d-F-y'), (int) $value->getNbUtilisateursConnectes24());
            $aRetourner['user_inscrit_24'][] = array($value->getCreatedAt()->format('d-F-y'), (int) $value->getNbInscrits24());
            $aRetourner['idee_24'][] = array($value->getCreatedAt()->format('d-F-y'), (int) $value->getNbIdees24());
            $aRetourner['commentaire_24'][] = array($value->getCreatedAt()->format('d-F-y'), (int) $value->getNbCommentaires24());
            $aRetourner['vote_24'][] = array($value->getCreatedAt()->format('d-F-y'), (int) $value->getNbVotes24());
            $aRetourner['invitation_24'][] = array($value->getCreatedAt()->format('d-F-y'), (int) $value->getNbInvitations24());
            $aRetourner['alerte_24'][] = array($value->getCreatedAt()->format('d-F-y'), (int) $value->getNbAlertes24());
            
            $aRetourner['user_inscrit_total'][] = array($value->getCreatedAt()->format('d-F-y'), (int) $value->getNbInscritsTotal());
            $aRetourner['idee_total'][] = array($value->getCreatedAt()->format('d-F-y'), (int) $value->getNbIdeesTotal());
            $aRetourner['commentaire_total'][] = array($value->getCreatedAt()->format('d-F-y'), (int) $value->getNbCommentairesTotal());
            $aRetourner['vote_total'][] = array($value->getCreatedAt()->format('d-F-y'), (int) $value->getNbVotesTotal());
            $aRetourner['invitation_total'][] = array($value->getCreatedAt()->format('d-F-y'), (int) $value->getNbInvitationsTotal());
            $aRetourner['alerte_total'][] = array($value->getCreatedAt()->format('d-F-y'), (int) $value->getNbAlertesTotal());
            
        }
        return $aRetourner;
    }
}