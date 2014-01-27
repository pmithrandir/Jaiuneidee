<?php

namespace JaiUneIdee\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JaiUneIdee\SiteBundle\Entity\Statistique;

/**
 * Vote controller.
 */
class StatistiqueController extends Controller
{
    
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        if (true === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            
            $stats = $em->getRepository('JaiUneIdeeSiteBundle:Statistique')->getAllStats();
            $tabStatsJson = Array();
            $tabStatsJson['user_connecté_24']['json'] = json_encode($stats['user_connecté_24']);
            $tabStatsJson['user_connecté_24']['title'] = "Utilisateurs Connectés dans les dernières 24 heures";
            $tabStatsJson['user_inscrit_24']['json'] = json_encode($stats['user_inscrit_24']);
            $tabStatsJson['user_inscrit_24']['title'] = "Utilisateurs Inscrits dans les dernières 24 heures";
            $tabStatsJson['idee_24']['json'] = json_encode($stats['idee_24']);
            $tabStatsJson['idee_24']['title'] = "Idées crées dans les dernières 24 heures";
            $tabStatsJson['commentaire_24']['json'] = json_encode($stats['commentaire_24']);
            $tabStatsJson['commentaire_24']['title'] = "Commentaires crées dans les dernières 24 heures";
            $tabStatsJson['vote_24']['json'] = json_encode($stats['vote_24']);
            $tabStatsJson['vote_24']['title'] = "Votes créés dans les dernières 24 heures";
            $tabStatsJson['invitation_24']['json'] = json_encode($stats['invitation_24']);
            $tabStatsJson['invitation_24']['title'] = "Invitations envoyées dans les dernières 24 heures";
            $tabStatsJson['alerte_24']['json'] = json_encode($stats['alerte_24']);
            $tabStatsJson['alerte_24']['title'] = "Alertes ajoutées dans les dernières 24 heures";
            
            
            $tabStatsJson['user_inscrit_total']['json'] = json_encode($stats['user_inscrit_total']);
            $tabStatsJson['user_inscrit_total']['title'] = "Utilisateur inscrit";
            $tabStatsJson['idee_total']['json'] = json_encode($stats['idee_total']);
            $tabStatsJson['idee_total']['title'] = "Nb Idées";
            $tabStatsJson['commentaire_total']['json'] = json_encode($stats['commentaire_total']);
            $tabStatsJson['commentaire_total']['title'] = "Nb Commentaires";
            $tabStatsJson['vote_total']['json'] = json_encode($stats['vote_total']);
            $tabStatsJson['vote_total']['title'] = "Nb Votes";
            $tabStatsJson['invitation_total']['json'] = json_encode($stats['invitation_total']);
            $tabStatsJson['invitation_total']['title'] = "Nb Invitations";
            $tabStatsJson['alerte_total']['json'] = json_encode($stats['alerte_total']);
            $tabStatsJson['alerte_total']['title'] = "Nb Alertes";
            return $this->render('JaiUneIdeeSiteBundle:Statistiques:index.html.twig', array(
                'tabStatsJson'=>$tabStatsJson
            ));
        }
       
    }
}
