<?php

namespace JaiUneIdee\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use JaiUneIdee\SiteBundle\Entity\Idee;
use JaiUneIdee\SiteBundle\Entity\Commentaire;
use JaiUneIdee\SiteBundle\Form\IdeeType;
use JaiUneIdee\SiteBundle\Form\IdeeLocalisationType;
use JaiUneIdee\SiteBundle\Form\CommentaireType;
use JaiUneIdee\SiteBundle\Entity\Moderation;
use JaiUneIdee\SiteBundle\Entity\ModerationCommentaire;
use JaiUneIdee\SiteBundle\Entity\IdeeLue;
use JaiUneIdee\SiteBundle\Entity\AlerteIdee;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
/**
 * Idee controller.
 */
class IdeeController extends Controller {

    public function showAction($id, $slug, $page = 1) {
        if ($this->getRequest()->isXMLHttpRequest()) {
            return $this->listeCommentaireAction($id, $page);
        } else {
            $em = $this->getDoctrine()->getManager();
            $idee = $this->getIdee($id);
            $moderation = null;
            $alerteIdee = null;
            if (true === $this->get('security.context')->isGranted('ROLE_USER')) {
                $ideeLue = new IdeeLue();
                $ideeLue->setIdee($idee);
                $ideeLue->setUser($this->get('security.context')->getToken()->getUser());
                $em->persist($ideeLue);
                $em->flush();

                //$voteExistant = $em->getRepository('JaiUneIdeeSiteBundle:Vote')->getVotesByIdeeAndUser($idee, $this->get('security.context')->getToken()->getUser());
                $moderation = $em->getRepository('JaiUneIdeeSiteBundle:Moderation')->getModerationByIdeeAndUser($idee, $this->get('security.context')->getToken()->getUser());

                $alerteIdee = $em->getRepository('JaiUneIdeeSiteBundle:AlerteIdee')->getAlerteIdeeByIdeeAndUser($idee, $this->get('security.context')->getToken()->getUser());
            }
            $voteArray = $this->generateVotes($idee);
            return $this->render('JaiUneIdeeSiteBundle:Idee:show.html.twig', array(
                        'idee' => $idee,
                        'votes' => $voteArray["votes"],
                        'voteExistant' => $voteArray["voteExistant"],
                        'moderationExistant' => $moderation,
                        'alerteIdee' => $alerteIdee,
                        'page' => $page,
            ));
        }
    }

    public function votesAction($id, $slug = "") {
        $idee = $this->getIdee($id);
        $voteArray = $this->generateVotes($idee);
        return $this->render('JaiUneIdeeSiteBundle:Idee:votes.html.twig', array(
                    'idee' => $idee,
                    'votes' => $voteArray["votes"],
                    'voteExistant' => $voteArray["voteExistant"],
        ));
    }

    private function generateVotes(Idee $idee) {
        $em = $this->getDoctrine()->getManager();
        $votes = $em->getRepository('JaiUneIdeeSiteBundle:Vote')->getVotesByIdee($idee);
        if (!isset($votes["1"])) {
            $votes["1"] = 0;
        }
        if (!isset($votes["0"])) {
            $votes["0"] = 0;
        }
        if (!isset($votes["-1"])) {
            $votes["-1"] = 0;
        }
        $votes["max"] = max($votes);
        $votes["total"] = $votes["1"] + $votes["-1"] + $votes["0"];
        if ($votes["total"] > 0) {
            $votes["pourcent_1"] = round($votes["1"] * 100 / $votes["total"], 2);
            $votes["pourcent_-1"] = round($votes["-1"] * 100 / $votes["total"], 2);
            $votes["pourcent_0"] = round($votes["0"] * 100 / $votes["total"], 2);
        } else {
            $votes["pourcent_1"] = 0;
            $votes["pourcent_-1"] = 0;
            $votes["pourcent_0"] = 0;
        }
        $voteExistant = null;
        if (true === $this->get('security.context')->isGranted('ROLE_USER')) {
            $voteExistant = $em->getRepository('JaiUneIdeeSiteBundle:Vote')->getVotesByIdeeAndUser($idee, $this->get('security.context')->getToken()->getUser());
        }
        return array("votes" => $votes, "voteExistant" => $voteExistant);
    }

    public function ajouterAction(Request $request) {
      $idee = new Idee();
      return $this->ideeForm($idee, $request,"create");
    }

    public function editAction($id, Request $request) {
        $idee = $this->getIdee($id);
        if($this->get('security.context')->getToken()->getUser() != $idee->getUser()){
            return $this->redirect($this->generateUrl('JaiUneIdeeSiteBundle_idee_show', array(
                                'id' => $idee->getId(),
                                'slug' => $idee->getSlug()))
            );
        }
        return $this->ideeForm($idee, $request,"edit");
    }

    private function ideeForm (Idee $idee, Request $request, $mode = "create") {
        if ($request->getSession()->get("localisation") !== null) {
            $form = $this->createForm(new IdeeLocalisationType(), $idee);
        } else {
            $form = $this->createForm(new IdeeType(), $idee);
        }

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $idee->setUser($this->get('security.context')->getToken()->getUser());
            if ($idee->getTheme()->getIsModerated() == true) {
                $idee->setIsPublished(false);
            }
            if (($request->getSession()->get("localisation") !== null)&&($mode =="create")) {
                $localisation = $em->getRepository('JaiUneIdeeLocalisationBundle:Localisation')->find($request->getSession()->get('localisation_id'));
                $idee->addLocalisation($localisation);
            }
            //$idee->setLastActionAt(new \DateTime());
            $em->persist($idee);
            $em->flush();
            $this->updateES ($idee);
            if($mode == "create"){
                $alerte = $em->getRepository('JaiUneIdeeSiteBundle:AlerteIdee')->getAlerteIdeeByIdeeAndUser($idee, $this->get('security.context')->getToken()->getUser());
                if (!$alerte) {
                    $alerte = new AlerteIdee();
                    $alerte->setIdee($idee);
                    $alerte->setUser($this->get('security.context')->getToken()->getUser());
                    $alerte->setActivated(true);
                    $em->persist($alerte);
                    $em->flush();
                }
            }
            return $this->redirect($this->generateUrl('JaiUneIdeeSiteBundle_idee_show', array(
                                'id' => $idee->getId(),
                                'slug' => $idee->getSlug()))
            );
        }

        $build['form'] = $form->createView();
        $build['mode'] = $mode;
        if($mode == "edit"){
            $build['idee'] = $idee;
        }
        return $this->render('JaiUneIdeeSiteBundle:Idee:create.html.twig', $build);
    }
    public function ajouterCommentaireAction ($idee_id, Request $request){
        $comment = new Commentaire();
        $idee = $this->getIdee($idee_id);
        $comment->setIdee($idee);
        $form = $this->createForm(new CommentaireType(), $comment);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $comment->setUser($this->get('security.context')->getToken()->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();
            $idee->addCommentaire($comment);
            $this->updateES ($idee);
            //récupération de tous les abonnés
            $abonnements = $em->getRepository('JaiUneIdeeSiteBundle:AlerteIdee')->getAbonnesIdee($idee);
            foreach ($abonnements as $abonnement) {
                //on retire l'utilisateur courant
                if ($abonnement->getUser()->getId() != $this->get('security.context')->getToken()->getUser()->getId()) {
                    //on verifie qu'il a lu la dernière version
                    if ($em->getRepository('JaiUneIdeeSiteBundle:IdeeLue')->estLue($idee, $abonnement->getUser())) {
                        //on envoie un email a cette liste d'utilisateur
                        $this->get('jai_une_idee_site.mailer')->alerteIdee($abonnement->getUser(), $idee);
                    }
                }
            }
            $alerte = $em->getRepository('JaiUneIdeeSiteBundle:AlerteIdee')->getAlerteIdeeByIdeeAndUser($idee, $this->get('security.context')->getToken()->getUser());
            if (!$alerte) {
                $alerte = new AlerteIdee();
                $alerte->setIdee($idee);
                $alerte->setUser($this->get('security.context')->getToken()->getUser());
                $alerte->setActivated(true);
                $em->persist($alerte);
                $em->flush();
            }
            //suppression des indicateurs precedents de lecture
            $em->getRepository('JaiUneIdeeSiteBundle:IdeeLue')->RemoveAllLuForIdee($idee);
            return $this->redirect($this->generateUrl('JaiUneIdeeSiteBundle_idee_show', array(
                                'id' => $comment->getIdee()->getId(),
                                'slug' => $comment->getIdee()->getSlug())) .
                            '#comment-' . $comment->getId()
            );
        }
        return $this->render('JaiUneIdeeSiteBundle:Idee:form_comment.html.twig', array(
                    'comment' => $comment,
                    'form' => $form->createView()
        ));
    }
    public function editerCommentaireAction ($commentaire_id, Request $request){
        $em = $this->getDoctrine()->getManager();
        $comment = $em->getRepository('JaiUneIdeeSiteBundle:Commentaire')->find($commentaire_id);
        if (!$comment) {
            throw $this->createNotFoundException("Impossible de trouver le commentaire.");
        }
        if($this->get('security.context')->getToken()->getUser() != $comment->getUser()){
            return $this->redirect($this->generateUrl('JaiUneIdeeSiteBundle_idee_show', array(
                                'id' => $comment->getIdee()->getId(),
                                'slug' => $comment->getIdee()->getSlug())) .
                            '#comment-' . $comment->getId()
            );
        }
        $form = $this->createForm(new CommentaireType(), $comment);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em->persist($comment);
            //$comment->getIdee()->setLastActionAt(new \DateTime());
            $em->persist($comment->getIdee());
            $em->flush();
            return $this->redirect($this->generateUrl('JaiUneIdeeSiteBundle_idee_show', array(
                                'id' => $comment->getIdee()->getId(),
                                'slug' => $comment->getIdee()->getSlug())) .
                            '#comment-' . $comment->getId()
            );
        }
        return $this->render('JaiUneIdeeSiteBundle:Idee:edit_comment.html.twig', array(
                    'comment' => $comment,
                    'form' => $form->createView()
        ));
    }

    /**
     * @return Idee
     */
    protected function getIdee($id) {
        $em = $this->getDoctrine()->getManager();
        //$idee = $em->getRepository('JaiUneIdeeSiteBundle:Idee')->find($id);
        $idee = $em->getRepository('JaiUneIdeeSiteBundle:Idee')->getIdee($id);
        //$idee = $em->getRepository('JaiUneIdeeSiteBundle:Idee')->getIdeeWithVote($id);

        if (!$idee) {
            throw $this->createNotFoundException("Impossible de trouver l'idée.");
        }
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            if ($idee->getIsPublished() == false) {
                if ((false === $this->get('security.context')->isGranted('ROLE_USER')) || ($idee->getUser() != $this->get('security.context')->getToken()->getUser())) {
                    throw $this->createNotFoundException("Idée non publiée.");
                }
            }
            if (($idee->getLife() <= 0) && ($idee->getIsValidatedByAdmin() == false)) {
                throw $this->createNotFoundException('Idée modérée.');
            }
        }
        return $idee;
    }

    public function moderateAction($id) {
        $idee = $this->getIdee($id);
        $em = $this->getDoctrine()->getManager();
        $moderationExistant = $em->getRepository('JaiUneIdeeSiteBundle:Moderation')->getModerationByIdeeAndUser($idee, $this->get('security.context')->getToken()->getUser());
        if (!$moderationExistant) {
            $dommages = $this->get('security.context')->getToken()->getUser()->getDommage()->getValue();
            $idee->setLife($idee->getLife() - $dommages);
            $moderation = new Moderation();
            $moderation->setIdee($idee);
            $moderation->setUser($this->get('security.context')->getToken()->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($moderation);
            $em->flush();
            $this->updateES ($idee);
        }
        return $this->redirect($this->generateUrl('JaiUneIdeeSiteBundle_idee_show', array(
                            'id' => $idee->getId(),
                            'slug' => $idee->getSlug()))
        );
    }

    public function moderateCommentaireAction($id) {
        $em = $this->getDoctrine()->getManager();
        $commentaire = $em->getRepository('JaiUneIdeeSiteBundle:Commentaire')->find($id);
        $moderationCommentaireExistant = $em->getRepository('JaiUneIdeeSiteBundle:ModerationCommentaire')->getModerationByCommentaireAndUser($commentaire, $this->get('security.context')->getToken()->getUser());
        if (!$moderationCommentaireExistant) {
            $dommages = $this->get('security.context')->getToken()->getUser()->getDommage()->getValue();
            $commentaire->setLife($commentaire->getLife() - $dommages);
            $moderation = new ModerationCommentaire();
            $moderation->setCommentaire($commentaire);
            $moderation->setUser($this->get('security.context')->getToken()->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($moderation);
            $em->flush();
            $this->updateES ($commentaire->getIdee());
        }
        return $this->redirect($this->generateUrl('JaiUneIdeeSiteBundle_idee_show', array(
                            'id' => $commentaire->getIdee()->getId(),
                            'slug' => $commentaire->getIdee()->getSlug()))
        );
    }

    public function adminModerateAction($id) {
        if (true === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $idee = $this->getIdee($id);
            $em = $this->getDoctrine()->getManager();
            $idee->setIsRemoved(true);
            $idee->setIsValidatedByAdmin(false);
            $idee->setIsModerated(true);
            $moderationExistantes = $em->getRepository('JaiUneIdeeSiteBundle:Moderation')->getModerationByIdee($idee);
            $this->amelioreDommage($moderationExistantes);
            $em->flush();
            $this->updateES ($idee);
        }
        return $this->redirect($this->generateUrl('JaiUneIdeeSiteBundle_homepage', array()));
    }

    public function adminValidateAction($id) {
        if (true === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $idee = $this->getIdee($id);
            $em = $this->getDoctrine()->getManager();
            $idee->setIsRemoved(false);
            $idee->setIsValidatedByAdmin(true);
            $idee->setIsModerated(true);
            $moderationExistantes = $em->getRepository('JaiUneIdeeSiteBundle:Moderation')->getModerationByIdee($idee);
            $this->diminueDommage($moderationExistantes);
            $em->flush();
            $this->updateES ($idee);
        }
        return $this->redirect($this->generateUrl('JaiUneIdeeSiteBundle_homepage', array()));
    }

    public function adminModerateCommentaireAction($id) {
        if (true === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $em = $this->getDoctrine()->getManager();
            $commentaire = $em->getRepository('JaiUneIdeeSiteBundle:Commentaire')->find($id);
            $commentaire->setIsRemoved(true);
            $commentaire->setIsValidatedByAdmin(false);
            $commentaire->setIsModerated(true);
            $moderationExistantes = $em->getRepository('JaiUneIdeeSiteBundle:ModerationCommentaire')->getModerationByCommentaire($commentaire);
            $this->amelioreDommage($moderationExistantes);
            $em->flush();
            $this->updateES ($commentaire->getIdee());
        }
        return $this->redirect($this->generateUrl('JaiUneIdeeSiteBundle_idee_show', array(
                            'id' => $commentaire->getIdee()->getId(),
                            'slug' => $commentaire->getIdee()->getSlug()))
        );
    }

    public function adminValidateCommentaireAction($id) {
        if (true === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $em = $this->getDoctrine()->getManager();
            $commentaire = $em->getRepository('JaiUneIdeeSiteBundle:Commentaire')->find($id);
            $commentaire->setIsRemoved(false);
            $commentaire->setIsValidatedByAdmin(true);
            $commentaire->setIsModerated(true);
            $moderationExistantes = $em->getRepository('JaiUneIdeeSiteBundle:ModerationCommentaire')->getModerationByCommentaire($commentaire);
            $this->amelioreDommage($moderationExistantes);
            $em->flush();
            
            $this->updateES ($commentaire->getIdee());
        }
        return $this->redirect($this->generateUrl('JaiUneIdeeSiteBundle_idee_show', array(
                            'id' => $commentaire->getIdee()->getId(),
                            'slug' => $commentaire->getIdee()->getSlug()))
        );
    }

    private function amelioreDommage($moderationExistantes) {
        $em = $this->getDoctrine()->getManager();
        foreach ($moderationExistantes as $moderation) {
            $levelCourant = $moderation->getUser()->getDommage()->getLevel();
            $nouveauDommage = $em->getRepository('JaiUneIdeeUtilisateurBundle:Dommage')->getUserNextDommage($levelCourant);
            $moderation->getUser()->setDommage($nouveauDommage);
        }
    }

    private function diminueDommage($moderationExistantes) {
        $em = $this->getDoctrine()->getManager();
        foreach ($moderationExistantes as $moderation) {
            $levelCourant = $moderation->getUser()->getDommage()->getLevel();
            $nouveauDommage = $em->getRepository('JaiUneIdeeUtilisateurBundle:Dommage')->getUserPreviousDommage($levelCourant);
            $moderation->getUser()->setDommage($nouveauDommage);
        }
    }

    public function moderationIdeesAdminAction() {
        $idees = $this->getDoctrine()->getManager()
                        ->getRepository('JaiUneIdeeSiteBundle:Idee')->getIdeesModeration();
        return $this->render('JaiUneIdeeSiteBundle:Idee:moderation_idees_admin.html.twig', array(
                    'idees' => $idees,
        ));
    }

    public function moderationCommentairesAdminAction() {
        $idees = $this->getDoctrine()->getManager()
                        ->getRepository('JaiUneIdeeSiteBundle:Idee')->getCommentairesModeration();
        return $this->render('JaiUneIdeeSiteBundle:Idee:moderation_commentaires_admin.html.twig', array(
                    'idees' => $idees,
        ));
    }

    public function adminPublishAction($id) {
        if (true === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $idee = $this->getIdee($id);
            $em = $this->getDoctrine()->getManager();
            $idee->setIsPublished(true);
            $idee->setIsRemoved(false);
            $em->flush();
            $this->updateES ($idee);
        }
        return $this->redirect($this->generateUrl('JaiUneIdeeSiteBundle_idees_moderation_admin', array()));
    }

    public function adminRemoveAction($id) {
        if (true === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $idee = $this->getIdee($id);
            $em = $this->getDoctrine()->getManager();
            $idee->setIsPublished(false);
            $idee->setIsRemoved(true);
            $em->flush();
            $this->updateES ($idee);
        }
        return $this->redirect($this->generateUrl('JaiUneIdeeSiteBundle_idees_moderation_admin', array()));
    }

    public function countModerationAction() {
        $nb = $this->getDoctrine()->getManager()
                        ->getRepository('JaiUneIdeeSiteBundle:Idee')->countIdeesModeration();
        return new Response($nb);
    }

    public function countModerationCommentaireAction() {
        $nb = $this->getDoctrine()->getManager()
                        ->getRepository('JaiUneIdeeSiteBundle:Idee')->countIdeesModerationCommentaire();
        return new Response($nb);
    }

    public function listeCommentaireAction($idee_id, $page = 1) {
        $em = $this->getDoctrine()->getManager();
        $options['routeName'] = "JaiUneIdeeSiteBundle_idee_show";
        $idee = $this->getIdee($idee_id);
        $options['routeParams'] = Array("id" => $idee_id, "slug" => $idee->getSlug());
        $qb = $em->getRepository('JaiUneIdeeSiteBundle:Commentaire')->getCommentairesQb($idee);

        $adapter = new DoctrineORMAdapter($qb);
        $pagerfanta = new Pagerfanta($adapter);
        try {
            $pagerfanta->setMaxPerPage(10);
            $pagerfanta->setCurrentPage($page);
            $commentaires = $pagerfanta->getCurrentPageResults();
        } catch (\Pagerfanta\Exception\NotValidCurrentPageException $e) {
            throw $this->createNotFoundException("Cette page n'existe pas.");
        }
        $moderationCommentaires = array();
        if (true === $this->get('security.context')->isGranted('ROLE_USER')) {
            foreach ($commentaires as $commentaire) {
                $moderationCommentaires[$commentaire->getId()] = $em->getRepository('JaiUneIdeeSiteBundle:ModerationCommentaire')->getModerationByCommentaireAndUser($commentaire, $this->get('security.context')->getToken()->getUser());
            }
        }
        $commentsAVerifier = array();
        foreach ($commentaires as $comment) {
            if ($comment->getLife() < 200 && $comment->getIsModerated() == false) {
                $commentsAVerifier[] = $comment;
            }
        }
        //$template = $this->getRequest()->isXMLHttpRequest() ? 'listeCommentaires.html.twig' : 'index.html.twig';
        return $this->render('JaiUneIdeeSiteBundle:Idee:comments.html.twig', array(
                    'commentaires' => $commentaires,
                    'pager' => $pagerfanta,
                    'page' => $page,
                    'commentairesAVerifier' => $commentsAVerifier,
                    'moderationCommentairesExistant' => $moderationCommentaires,
                    'options' => $options
        ));
    }

    public function statAction($idee_id) {
        $em = $this->getDoctrine()->getManager();
        $idee = $this->getIdee($idee_id);

        $stats_sexe = $em->getRepository('JaiUneIdeeSiteBundle:Vote')->getStatSexe($idee);
        $stats_age = $em->getRepository('JaiUneIdeeSiteBundle:Vote')->getStatAge($idee);
        $stats_age_data = array(array_values($stats_age['results']['Neutre']), array_values($stats_age['results']['Pour']), array_values($stats_age['results']['Contre']));
        $tabStatsJson = Array();
        $tabStatsJson['pie']['homme']['json'] = json_encode(array_values($stats_sexe['results']['Homme']));
        $tabStatsJson['pie']['homme']['title'] = "Votes masculins (" . $stats_sexe['count']['Homme'] . ")";
        $tabStatsJson['pie']['femme']['json'] = json_encode(array_values($stats_sexe['results']['Femme']));
        $tabStatsJson['pie']['femme']['title'] = "Votes féminins (" . $stats_sexe['count']['Femme'] . ")";
        $tabStatsJson['bar']['age']['json'] = json_encode($stats_age_data);
        $tabStatsJson['bar']['age']['title'] = "Votes par age (" . $stats_age['count']['total'] . ")";

        return $this->render('JaiUneIdeeSiteBundle:Idee:stat.html.twig', array(
                    'tabStatsJson' => $tabStatsJson,
                    'idee' => $idee
        ));
    }
    private function updateES ($idee){
    
        $persister = $this->get('fos_elastica.object_persister.jaiuneidee.idee');
        $persister->insertOne($idee);
}
}
