<?php

namespace JaiUneIdee\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
// Import new namespaces
use JaiUneIdee\SiteBundle\Entity\Enquiry;
use JaiUneIdee\SiteBundle\Form\EnquiryType;
use JaiUneIdee\SiteBundle\Form\IdeeSearchType;
use JaiUneIdee\SiteBundle\Entity\Message;
use JaiUneIdee\SiteBundle\Form\MessageType;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Request;

use JaiUneIdee\SiteBundle\Model\IdeeSearch;

class PageController extends Controller
{
    public function indexAction(Request $request, $page = 1, $page_news = 1, $requester = "idee")
    {
        
        $ideeSearch = new IdeeSearch();
        $ideeSearchForm = $this->createForm(new IdeeSearchType(), $ideeSearch);

        $ideeSearchForm->handleRequest($request);
        $ideeSearch = $ideeSearchForm->getData();
        
        $em = $this->getDoctrine()->getManager();
        if($request->getSession()->get('localisation') !==null){
            $ideeSearch->setLocalisationObject($em->getRepository('JaiUneIdeeLocalisationBundle:Localisation')->find($request->getSession()->get('localisation_id')));
            $ideeSearch->setWithChildrenLoc(true);
        }
        else if(true === $this->get('security.context')->isGranted('ROLE_USER')){
            if ($ideeSearch->getLocalisation()=="toutes"){
                $ideeSearch->setLocalisationObject($em->getRepository('JaiUneIdeeLocalisationBundle:Localisation')->findOneBy(array("nom"=>"France")));
                $ideeSearch->setWithChildrenLoc(true);
            }
            else if($ideeSearch->getLocalisation()=="national"){
                $ideeSearch->setLocalisationObject($em->getRepository('JaiUneIdeeLocalisationBundle:Localisation')->findOneBy(array("nom"=>"France")));
                $ideeSearch->setWithChildrenLoc(false);
            }
            else{
                $ideeSearch->setLocalisationObject($this->get('security.context')->getToken()->getUser()->getLocalisation());
                $ideeSearch->setWithChildrenLoc(true);
            }
        }
        else{
                $ideeSearch->setLocalisationObject($em->getRepository('JaiUneIdeeLocalisationBundle:Localisation')->findOneBy(array("nom"=>"France")));
                $ideeSearch->setWithChildrenLoc(true);
        }
//        $index = $this->get('fos_elastica.index.jaiuneidee');
//        $temp = $index->search("speciale");
//        $temp = $index->search(new Field('body', 'spéciale'));
//        print_r($temp->getResults());
        /** var FOS\ElasticaBundle\Manager\RepositoryManager */
        $repositoryManager = $this->get('fos_elastica.manager.orm');
        /** var FOS\ElasticaBundle\Repository */
//        foreach($idees as $idee){
//            echo $idee."<br />";
//        }
        
        
        $liste_themes = $this->getDoctrine()->getManager()->getRepository('JaiUneIdeeSiteBundle:Theme')->findAll();
        $theme = null;
        if(($request->get("theme")!==null) &&($request->get("theme")!="all")){
            $theme = $this->getDoctrine()->getManager()->getRepository('JaiUneIdeeSiteBundle:Theme')->find($request->get("theme"));
        }
        $withIdeesLues = false;
        if (true === $this->get('security.context')->isGranted('ROLE_USER')){
            $withIdeesLues = true;
        }
        $typeTri = "derniereActivite";
        if($request->get("tri")=="nb_commentaire"){
            $typeTri = "Buzz"; 
        }
        else if($request->get("tri")=="date"){
            $typeTri = "derniereIdee"; 
        }
//        $options = array(
//            'localisation'=> $localisation,
//            'theme'=> $theme,
//            'withLocChildren'=> $withLocChildren,
//            'typeTri'=> $typeTri,
//            'limit'=> null,
//            'withIdeesLues'=> $withIdeesLues
//        );
        
        $repository = $repositoryManager->getRepository('JaiUneIdeeSiteBundle:Idee');
        $results = $repository->search($ideeSearch);
//        $qb = $em->getRepository('JaiUneIdeeSiteBundle:Idee')->getIdeesWithParamQueryBuilder($options);
        
        $adapter = new ArrayAdapter($results);
        //$adapter = new DoctrineORMAdapter($qb);
        $pagerfanta = new Pagerfanta($adapter);
        try {
            $pagerfanta->setMaxPerPage(12);
            $pagerfanta->setCurrentPage($page);
            $idees = $pagerfanta->getCurrentPageResults();
        } catch (\Pagerfanta\Exception\NotValidCurrentPageException $e) {
            throw $this->createNotFoundException("Cette page n'existe pas.");
        }
        $ideesLues = array();     
        if (true === $this->get('security.context')->isGranted('ROLE_USER')){               
            $ideesLuesResult = $em->getRepository('JaiUneIdeeSiteBundle:IdeeLue')->sontLues($idees,$this->get('security.context')->getToken()->getUser()->getId());
            foreach($ideesLuesResult as $ideelue){
                $ideesLues[$ideelue->getIdee()->getId()] = true;
            }
        }
        $votes = array();
        $votesForIdees = $em->getRepository('JaiUneIdeeSiteBundle:Idee')->getVotesByIdees($idees);
        foreach($idees as $idee){
            if(isset($votesForIdees[$idee->getId()])){
                $votes[$idee->getId()] = $votesForIdees[$idee->getId()];
            }
            else{
                $votes[$idee->getId()] = array();
            }
            if(!isset($votes[$idee->getId()]["1"])){
                    $votes[$idee->getId()]["1"] = 0;
            }
            if(!isset($votes[$idee->getId()]["0"])){
                    $votes[$idee->getId()]["0"] = 0;
            }
            if(!isset($votes[$idee->getId()]["-1"])){
                    $votes[$idee->getId()]["-1"] = 0;
            }
            $votes[$idee->getId()]["max"] = max($votes[$idee->getId()]);
            $votes[$idee->getId()]["total"] = $votes[$idee->getId()]["1"] + $votes[$idee->getId()]["-1"] + $votes[$idee->getId()]["0"];
            if($votes[$idee->getId()]["total"]>0){
                    $votes[$idee->getId()]["pourcent_1"] = round($votes[$idee->getId()]["1"]*100/$votes[$idee->getId()]["total"],2);
                    $votes[$idee->getId()]["pourcent_-1"] = round($votes[$idee->getId()]["-1"]*100/$votes[$idee->getId()]["total"],2);
                    $votes[$idee->getId()]["pourcent_0"] = round($votes[$idee->getId()]["0"]*100/$votes[$idee->getId()]["total"],2);
            }
            else{
                    $votes[$idee->getId()]["pourcent_1"] = 0;
                    $votes[$idee->getId()]["pourcent_-1"] = 0;
                    $votes[$idee->getId()]["pourcent_0"] = 0;
            }
        }
        $qb_news = $em->getRepository('JaiUneIdeeSiteBundle:News')->getNewsPublicQb();
        $adapter_news = new DoctrineORMAdapter($qb_news);
        $pagerfanta_news = new Pagerfanta($adapter_news);
        try {
            $pagerfanta_news->setMaxPerPage(3);
            $pagerfanta_news->setCurrentPage($page_news);
            $news = $pagerfanta_news->getCurrentPageResults();
        } catch (\Pagerfanta\Exception\NotValidCurrentPageException $e) {
            throw $this->createNotFoundException("Cette page n'existe pas.");
        }
        $options_pager['routeName'] = $options_pager_news['routeName'] = "JaiUneIdeeSiteBundle_homepage_pagination";
        $options_pager['routeParams'] = Array("page"=>$page, "page_news"=>$page_news, "requester" => "idee");
        $options_pager_news['routeParams'] = Array("page"=>$page, "page_news"=>$page_news, "requester" => "news");
        $options_pager_news['pageParameter'] = '[page_news]';
        if( $this->getRequest()->isXMLHttpRequest()){
            if($requester == "idee"){
                $template = 'listeIdees.html.twig';
            }
            else{
                $template = 'listeNews.html.twig';
            }
        }
        else{
            $template = 'index.html.twig';
        }
        
        $liste_site = $em->getRepository('JaiUneIdeeLocalisationBundle:Localisation')->getListeSousDomaine();
        //echo "Localisation : ".$request->getSession()->get('localisation');
        return $this->render('JaiUneIdeeSiteBundle:Page:'.$template, array(
            'idees' => $idees,
            'ideesLues'=>$ideesLues,
            'votes'=>$votes,
            'news' => $news,
            'pager' => $pagerfanta,
            'pager_news' => $pagerfanta_news,
            'page' => $page,
            'page_news' => $page_news,
            'theme_selected'=>($theme!==null)?$theme->getId():null,
            'themes'=>$liste_themes,
            'options_pager'=>$options_pager,
            'options_pager_news'=>$options_pager_news,
            'liste_site' => $liste_site,
            'ideeSearchForm' => $ideeSearchForm->createView(),
        ));
    }
    public function charteAction()
    {
        return $this->render('JaiUneIdeeSiteBundle:Page:charte.html.twig');
    }
    public function contactAction()
    {
        $enquiry = new Enquiry();
        $form = $this->createForm(new EnquiryType(), $enquiry);
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
                // Perform some action, such as sending an email
                $em = $this->getDoctrine()->getManager();
                $entity  = new Message();
                $param = $this->getRequest()->get("contact");
                $entity->setNom($param["name"]);
                $entity->setEmail($param["email"]);
                if (true === $this->get('security.context')->isGranted('ROLE_USER')) {
                	$entity->setUserFrom($this->get('security.context')->getToken()->getUser());
                }
                $admins = $em->getRepository('JaiUneIdeeUtilisateurBundle:User')->findByUsername("admin");
                $entity->setUserTo($admins[0]);
                $entity->setSujet($param["subject"]);
                $entity->setMessage($param["email"] . " ".$param["name"]." ".$param["body"]);
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                $this->get('jai_une_idee_site.mailer')->sendContactCopy($param["email"],$param["name"], $param["subject"], $param["body"]);
                $this->get('session')->getFlashBag()->add('notice', 'Votre message a été envoyé aux administrateurs. Merci!');
                // Redirect - This is important to prevent users re-posting
                // the form if they refresh the page
                return $this->redirect($this->generateUrl('JaiUneIdeeSiteBundle_contact'));
            }
        }
        return $this->render('JaiUneIdeeSiteBundle:Page:contact.html.twig', array(
            'form' => $form->createView()
        ));
    }
}