<?php

namespace JaiUneIdee\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use JaiUneIdee\SiteBundle\Entity\Idee;
use JaiUneIdee\SiteBundle\Entity\Commentaire;
use JaiUneIdee\SiteBundle\Form\IdeeType;
use JaiUneIdee\SiteBundle\Form\CommentaireType;
use JaiUneIdee\SiteBundle\Entity\Moderation;
use JaiUneIdee\SiteBundle\Entity\ModerationCommentaire;
use JaiUneIdee\SiteBundle\Entity\IdeeLue;
use JaiUneIdee\SiteBundle\Entity\AlerteIdee;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template; 

use Gloomy\PagerBundle\Pager\Wrapper\QueryBuilderWrapper;
use Gloomy\PagerBundle\Pager\Field;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
/**
 * Idee controller.
 */
class IdeeController extends Controller
{
	
    /**
     * @Template()
     */
    public function listAction()
    {
    	
    	$idees = $this->getDoctrine()->getEntityManager()
    			->getRepository('JaiUneIdeeSiteBundle:Idee')->getLatestIdeesQb()
    			->addSelect('t')->leftJoin('i.theme', 't')
    			->addSelect('u')->leftJoin('i.user', 'u')
    			->addSelect('l')->leftJoin('i.localisations', 'l')
            	;
    	$wrapper = new QueryBuilderWrapper($idees);
    	$wrapper
    		->addField(new Field('theme.nom', 'string', 'Thème', 't.id', array('tree' => true)), 'theme')
    		->addField(new Field('user.username', 'string', 'Auteur', 'u.username', array('tree' => true)), 'user')
    		->addField(new Field('localisation.nom', 'string', 'Localisation', 'l.id', array('tree' => true)), 'localisation')
        ;
        $wrapper->setOrderBy(array('updated_at' => 'desc'));
    	$datagrid = $this->get('gloomy.datagrid')->factory($wrapper);
        $datagrid->showOnly(
        	array(
				'title', 
				'description', 
				'created_at', 
				'theme', 
				'user',
				'localisation'
				)
        	);
        
        $themes = $this->getDoctrine()->getEntityManager()->getRepository('JaiUneIdeeSiteBundle:Theme')->findAll();
        $datagrid->getField('theme')->addOption('select_options', $themes);
        $datagrid->getField('created_at')->setProperty('createdAt');
        $datagrid->getField('created_at')->setType('date');
        $datagrid->getField('created_at')->setDateFormat('d/m/Y à H:i:s');
        
        $datagrid->getField('title')->setLabel('Titre');
        $datagrid->getField('created_at')->setLabel('Créé le');
        $datagrid->getField('description')->setLabel('Description');
        $datagrid->getField('localisation')->setLabel('Localisation');
        
        if ($this->getRequest()->getMethod() == 'POST') {
        	$params = $this->getRequest()->request->all();
        	if((isset($params["_gp"]["f"]["v"]["localisation"]))&&($params["_gp"]["f"]["v"]["localisation"]>0)){
        		$localisation = $this->getDoctrine()->getEntityManager()->getRepository('JaiUneIdeeLocalisationBundle:Localisation')->find($params["_gp"]["f"]["v"]["localisation"]);
        		if($localisation){
        			$datagrid->getField('localisation')->addOption('selected_localisation', $localisation->getNom());
        		}
        	}
    	}
        $template = $this->getRequest()->isXMLHttpRequest() ? 'datagrid.html.twig' : 'list.html.twig';
        return $this->render(
            'JaiUneIdeeSiteBundle:Idee:'.$template,
            array(
				'datagrid' => $datagrid,
			)
        );
        
    }
    public function showAction($id, $slug, $page = 1)
    {
        if($this->getRequest()->isXMLHttpRequest()){
            return $this->listeCommentaireAction($id, $page);
        }
        else{ 
            $em = $this->getDoctrine()->getEntityManager();
            $idee = $this->getIdee($id);
            $votes = $em->getRepository('JaiUneIdeeSiteBundle:Vote')->getVotesByIdee($idee);
            if(!isset($votes["1"])){
                    $votes["1"] = 0;
            }
            if(!isset($votes["0"])){
                    $votes["0"] = 0;
            }
            if(!isset($votes["-1"])){
                    $votes["-1"] = 0;
            }
            $votes["max"] = max($votes);
            $votes["total"] = $votes["1"] + $votes["-1"] + $votes["0"];
            if($votes["total"]>0){
                    $votes["pourcent_1"] = round($votes["1"]*100/$votes["total"],2);
                    $votes["pourcent_-1"] = round($votes["-1"]*100/$votes["total"],2);
                    $votes["pourcent_0"] = round($votes["0"]*100/$votes["total"],2);
            }
            else{
                    $votes["pourcent_1"] = 0;
                    $votes["pourcent_-1"] = 0;
                    $votes["pourcent_0"] = 0;
            }
            $voteExistant = null;
            $moderation = null;
            $alerteIdee = null;
            if (true === $this->get('security.context')->isGranted('ROLE_USER')) {
                    $ideeLue = new IdeeLue();
                    $ideeLue->setIdee($idee);
                    $ideeLue->setUser($this->get('security.context')->getToken()->getUser());
                    $em->persist($ideeLue);
                    $em->flush();

                    $voteExistant = $em->getRepository('JaiUneIdeeSiteBundle:Vote')->getVotesByIdeeAndUser($idee, $this->get('security.context')->getToken()->getUser());
                    $moderation = $em->getRepository('JaiUneIdeeSiteBundle:Moderation')->getModerationByIdeeAndUser($idee, $this->get('security.context')->getToken()->getUser());

                    $alerteIdee = $em->getRepository('JaiUneIdeeSiteBundle:AlerteIdee')->getAlerteIdeeByIdeeAndUser($idee, $this->get('security.context')->getToken()->getUser());
            }
            return $this->render('JaiUneIdeeSiteBundle:Idee:show.html.twig', array(
                'idee'      => $idee,
                'votes'		=> $votes,
                'voteExistant' => $voteExistant,
                'moderationExistant'=>$moderation,
                'alerteIdee'=>$alerteIdee,
                'page'=>$page,
            ));
        }
    }
    public function newAction(){
        $idee = new Idee();
        $form   = $this->createForm(new IdeeType(),$idee);
        return $this->render('JaiUneIdeeSiteBundle:Idee:create.html.twig', array(
            'form'   => $form->createView()
        ));
    }
    public function createAction(){
        $em = $this->getDoctrine()->getEntityManager();
        $idee = new Idee();
        $request = $this->getRequest();
        $form   = $this->createForm(new IdeeType(),$idee);
        $form->bind($request);
        if($idee->getTheme()->getIsModerated()==true){
        	$idee->setIsPublished(false);
        }
        $idee->setUser($this->get('security.context')->getToken()->getUser());
        if ($form->isValid()) {
            $em->persist($idee);
            $em->flush();
            $alerte = $em->getRepository('JaiUneIdeeSiteBundle:AlerteIdee')->getAlerteIdeeByIdeeAndUser($idee, $this->get('security.context')->getToken()->getUser());
            if(!$alerte ){
                $alerte = new AlerteIdee();
                $alerte->setIdee($idee);
                $alerte->setUser($this->get('security.context')->getToken()->getUser());
                $alerte->setActivated(true);
                $em->persist($alerte);
                $em->flush();
            }
            return $this->redirect($this->generateUrl('JaiUneIdeeSiteBundle_idee_show', array(
                'id' => $idee->getId() ,
                'slug' => $idee->getSlug()))
            );
        }
        return $this->render('JaiUneIdeeSiteBundle:Idee:create.html.twig', array(
            'form'   => $form->createView()
        ));
    }
    public function newCommentAction($idee_id){
        $idee = $this->getIdee($idee_id);
        $comment = new Commentaire();
        $comment->setIdee($idee);
        $form   = $this->createForm(new CommentaireType(), $comment);
        return $this->render('JaiUneIdeeSiteBundle:Idee:form_comment.html.twig', array(
            'comment' => $comment,
            'form'   => $form->createView()
        ));
    }
    public function createCommentAction($idee_id){
        $idee = $this->getIdee($idee_id);
        $comment = new Commentaire();
        $comment->setIdee($idee);
        $comment->setUser($this->get('security.context')->getToken()->getUser());
        $request = $this->getRequest();
        $form   = $this->createForm(new CommentaireType(), $comment);
        $form->bind($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()
                       ->getEntityManager();
            $em->persist($comment);
            $em->flush();
            //récupération de tous les abonnés
            $abonnements = $em->getRepository('JaiUneIdeeSiteBundle:AlerteIdee')->getAbonnesIdee($idee);
            foreach($abonnements as $abonnement){
                //on retire l'utilisateur courant
                if($abonnement->getUser()->getId() != $this->get('security.context')->getToken()->getUser()->getId()){
                    //on verifie qu'il a lu la dernière version
                    if($em->getRepository('JaiUneIdeeSiteBundle:IdeeLue')->estLue($idee,$abonnement->getUser())){
                        //on envoie un email a cette liste d'utilisateur
                        $this->get('jai_une_idee_site.mailer')->alerteIdee($abonnement->getUser(), $idee);
                    }
                }
            }
            $alerte = $em->getRepository('JaiUneIdeeSiteBundle:AlerteIdee')->getAlerteIdeeByIdeeAndUser($idee, $this->get('security.context')->getToken()->getUser());
            if(!$alerte ){
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
                'id' => $comment->getIdee()->getId() ,
                'slug' => $comment->getIdee()->getSlug())) .
                '#comment-' . $comment->getId()
            );
        }
        
        
        return $this->render('JaiUneIdeeSiteBundle:Idee:create_comment.html.twig', array(
            'comment' => $comment,
            'form'   => $form->createView()
        ));
    }
    
    protected function getIdee($id){
        $em = $this->getDoctrine()->getEntityManager();
		//$idee = $em->getRepository('JaiUneIdeeSiteBundle:Idee')->find($id);
        $idee = $em->getRepository('JaiUneIdeeSiteBundle:Idee')->getIdee($id);
        //$idee = $em->getRepository('JaiUneIdeeSiteBundle:Idee')->getIdeeWithVote($id);
        
        if (!$idee) {
            throw $this->createNotFoundException("Impossible de trouver l'idée.");
        }
        if(false === $this->get('security.context')->isGranted('ROLE_ADMIN')){
            if($idee->getIsPublished()==false){
                if((false === $this->get('security.context')->isGranted('ROLE_USER'))||($idee->getUser() != $this->get('security.context')->getToken()->getUser())){
                    throw $this->createNotFoundException("Idée non publiée.");
                }
            }
            if(($idee->getLife()<=0)&&($idee->getIsValidatedByAdmin()==false)){
                    throw $this->createNotFoundException('Idée modérée.');
            }
        }
        return $idee;
    }
    
    public function moderateAction($id){
    	$idee = $this->getIdee($id);
	    $em = $this->getDoctrine()->getEntityManager();
    	$moderationExistant = $em->getRepository('JaiUneIdeeSiteBundle:Moderation')->getModerationByIdeeAndUser($idee, $this->get('security.context')->getToken()->getUser());
    	if(!$moderationExistant ){
	    	$dommages = $this->get('security.context')->getToken()->getUser()->getDommage()->getValue();
	    	$idee->setLife($idee->getLife()-$dommages);
	    	$moderation = new Moderation();
	    	$moderation->setIdee($idee);
	    	$moderation->setUser($this->get('security.context')->getToken()->getUser());
	        $em = $this->getDoctrine()->getEntityManager();
	        $em->persist($moderation);
	        $em->flush();
    	}
        return $this->redirect($this->generateUrl('JaiUneIdeeSiteBundle_idee_show', array(
                'id' => $idee->getId() ,
                'slug' => $idee->getSlug()))
            );
    }
    public function moderateCommentaireAction($id){
        $em = $this->getDoctrine()->getEntityManager();
        $commentaire = $em->getRepository('JaiUneIdeeSiteBundle:Commentaire')->find($id);
    	$moderationCommentaireExistant = $em->getRepository('JaiUneIdeeSiteBundle:ModerationCommentaire')->getModerationByCommentaireAndUser($commentaire, $this->get('security.context')->getToken()->getUser());
    	if(!$moderationCommentaireExistant ){
	    	$dommages = $this->get('security.context')->getToken()->getUser()->getDommage()->getValue();
	    	$commentaire->setLife($commentaire->getLife()-$dommages);
	    	$moderation = new ModerationCommentaire();
	    	$moderation->setCommentaire($commentaire);
	    	$moderation->setUser($this->get('security.context')->getToken()->getUser());
	        $em = $this->getDoctrine()->getEntityManager();
	        $em->persist($moderation);
	        $em->flush();
    	}
        return $this->redirect($this->generateUrl('JaiUneIdeeSiteBundle_idee_show', array(
                'id' => $commentaire->getIdee()->getId() ,
                'slug' => $commentaire->getIdee()->getSlug()))
            );
    }
    public function adminModerateAction($id){
        if (true === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
        	$idee = $this->getIdee($id);
	    	$em = $this->getDoctrine()->getEntityManager();
        	$idee->setIsRemoved(true);
        	$idee->setIsValidatedByAdmin(false);
        	$idee->setIsModerated(true);
        	$moderationExistantes = $em->getRepository('JaiUneIdeeSiteBundle:Moderation')->getModerationByIdee($idee);
        	$this->amelioreDommage($moderationExistantes);
	        $em->flush();
        }
	    return $this->redirect($this->generateUrl('JaiUneIdeeSiteBundle_homepage', array()));
    }
    public function adminValidateAction($id){
        if (true === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
        	$idee = $this->getIdee($id);
	    	$em = $this->getDoctrine()->getEntityManager();
        	$idee->setIsRemoved(false);
        	$idee->setIsValidatedByAdmin(true);
        	$idee->setIsModerated(true);
        	$moderationExistantes = $em->getRepository('JaiUneIdeeSiteBundle:Moderation')->getModerationByIdee($idee);
        	$this->diminueDommage($moderationExistantes);
	        $em->flush();
        }
	    return $this->redirect($this->generateUrl('JaiUneIdeeSiteBundle_homepage', array()));
    }
    public function adminModerateCommentaireAction($id){
        if (true === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
        	$em = $this->getDoctrine()->getEntityManager();
	        $commentaire = $em->getRepository('JaiUneIdeeSiteBundle:Commentaire')->find($id);
        	$commentaire->setIsRemoved(true);
        	$commentaire->setIsValidatedByAdmin(false);
        	$commentaire->setIsModerated(true);
        	$moderationExistantes = $em->getRepository('JaiUneIdeeSiteBundle:ModerationCommentaire')->getModerationByCommentaire($commentaire);
        	$this->amelioreDommage($moderationExistantes);
	        $em->flush();
        }
	    return $this->redirect($this->generateUrl('JaiUneIdeeSiteBundle_idee_show', array(
                'id' => $commentaire->getIdee()->getId() ,
                'slug' => $commentaire->getIdee()->getSlug()))
	    );
    }
    public function adminValidateCommentaireAction($id){
        if (true === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
        	$em = $this->getDoctrine()->getEntityManager();
	        $commentaire = $em->getRepository('JaiUneIdeeSiteBundle:Commentaire')->find($id);
        	$commentaire->setIsRemoved(false);
        	$commentaire->setIsValidatedByAdmin(true);
        	$commentaire->setIsModerated(true);
        	$moderationExistantes = $em->getRepository('JaiUneIdeeSiteBundle:ModerationCommentaire')->getModerationByCommentaire($commentaire);
        	$this->amelioreDommage($moderationExistantes);
	        $em->flush();
        }
	    return $this->redirect($this->generateUrl('JaiUneIdeeSiteBundle_idee_show', array(
                'id' => $commentaire->getIdee()->getId() ,
                'slug' => $commentaire->getIdee()->getSlug()))
	    );
    }
    private function amelioreDommage($moderationExistantes){
    	$em = $this->getDoctrine()->getEntityManager();
    	foreach($moderationExistantes as $moderation){
    		$levelCourant = $moderation->getUser()->getDommage()->getLevel();
    		$nouveauDommage = $em->getRepository('JaiUneIdeeUtilisateurBundle:Dommage')->getUserNextDommage($levelCourant);
    		$moderation->getUser()->setDommage($nouveauDommage);
    	}
    }
    private function diminueDommage($moderationExistantes){
    	$em = $this->getDoctrine()->getEntityManager();
    	foreach($moderationExistantes as $moderation){
    		$levelCourant = $moderation->getUser()->getDommage()->getLevel();
    		$nouveauDommage = $em->getRepository('JaiUneIdeeUtilisateurBundle:Dommage')->getUserPreviousDommage($levelCourant);
    		$moderation->getUser()->setDommage($nouveauDommage);
    	}
    }
    public function moderationIdeesAdminAction(){
    	$idees = $this->getDoctrine()->getEntityManager()
    			->getRepository('JaiUneIdeeSiteBundle:Idee')->getIdeesModeration();
    	return $this->render('JaiUneIdeeSiteBundle:Idee:moderation_idees_admin.html.twig', array(
            'idees'      => $idees,
        ));
    }
    public function moderationCommentairesAdminAction(){
    	$idees = $this->getDoctrine()->getEntityManager()
    			->getRepository('JaiUneIdeeSiteBundle:Idee')->getCommentairesModeration();
    	return $this->render('JaiUneIdeeSiteBundle:Idee:moderation_commentaires_admin.html.twig', array(
            'idees'      => $idees,
        ));
    }
    public function adminPublishAction($id){
        if (true === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
        	$idee = $this->getIdee($id);
	    	$em = $this->getDoctrine()->getEntityManager();
        	$idee->setIsPublished(true);
        	$idee->setIsRemoved(false);
	        $em->flush();
        }
	    return $this->redirect($this->generateUrl('JaiUneIdeeSiteBundle_idees_moderation_admin', array()));
    }
    public function adminRemoveAction($id){
        if (true === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
        	$idee = $this->getIdee($id);
	    	$em = $this->getDoctrine()->getEntityManager();
        	$idee->setIsPublished(false);
        	$idee->setIsRemoved(true);
	        $em->flush();
        }
	    return $this->redirect($this->generateUrl('JaiUneIdeeSiteBundle_idees_moderation_admin', array()));
    }
    public function countModerationAction(){
    	$nb = $this->getDoctrine()->getEntityManager()
    			->getRepository('JaiUneIdeeSiteBundle:Idee')->countIdeesModeration();
    	return new Response($nb);
    }
    public function countModerationCommentaireAction(){
    	$nb = $this->getDoctrine()->getEntityManager()
    			->getRepository('JaiUneIdeeSiteBundle:Idee')->countIdeesModerationCommentaire();
    	return new Response($nb);
    }
    public function listeCommentaireAction($idee_id, $page = 1)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $options['routeName'] = "JaiUneIdeeSiteBundle_idee_show";
        $idee = $this->getIdee($idee_id);
        $options['routeParams'] = Array("id"=>$idee_id, "slug"=>$idee->getSlug());
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
                foreach($commentaires as $commentaire){
        		$moderationCommentaires[$commentaire->getId()] = $em->getRepository('JaiUneIdeeSiteBundle:ModerationCommentaire')->getModerationByCommentaireAndUser($commentaire, $this->get('security.context')->getToken()->getUser());
        	}
        }
        $commentsAVerifier = array();
        foreach($commentaires as $comment){
        	if ($comment->getLife()<200 && $comment->getIsModerated() == false){
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
            'options'=>$options
        ));
    }
}