<?php

namespace JaiUneIdee\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
// Import new namespaces
use JaiUneIdee\SiteBundle\Entity\Enquiry;
use JaiUneIdee\SiteBundle\Form\EnquiryType;
use JaiUneIdee\SiteBundle\Form\IdeeSearchType;
use JaiUneIdee\SiteBundle\Entity\Message;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Request;

use JaiUneIdee\SiteBundle\Model\IdeeSearch;

class PageController extends Controller
{
    public function indexAction(Request $request, $type = "")
    {
        $page = ($request->query->get('page')!="")?$request->query->get('page'):1;
        $page_news = ($request->query->get('page_news')!="")?$request->query->get('page_news'):1;
        $ideeSearch = new IdeeSearch();
        $ideeSearchForm = $this->createForm(new IdeeSearchType($this->get('security.context'), ($request->getSession()->get('localisation') !== null)), $ideeSearch);

        $ideeSearchForm->handleRequest($request);
        $ideeSearch = $ideeSearchForm->getData();
        
        $em = $this->getDoctrine()->getManager();
        if($request->getSession()->get('localisation') !==null){
            $ideeSearch->setLocalisationObject($em->getRepository('JaiUneIdeeLocalisationBundle:Localisation')->find($request->getSession()->get('localisation_id')));
            $ideeSearch->setWithChildrenLoc(true);
        }
        else if((true === $this->get('security.context')->isGranted('ROLE_USER'))&&(($ideeSearch->getLocalisation()=="local")||($ideeSearch->getLocalisation()==""))){
            if($this->get('security.context')->getToken()->getUser()->getLocalisationRecherchee()!=null){
                $ideeSearch->setLocalisationObject($this->get('security.context')->getToken()->getUser()->getLocalisationRecherchee());
            }
            else{
                $ideeSearch->setLocalisationObject($this->get('security.context')->getToken()->getUser()->getLocalisation());
            }
            $ideeSearch->setWithChildrenLoc(true);
        }
        else if($ideeSearch->getLocalisation()=="national"){
            $ideeSearch->setLocalisationObject($em->getRepository('JaiUneIdeeLocalisationBundle:Localisation')->findOneBy(array("niveau"=>0)));
            $ideeSearch->setWithChildrenLoc(false);
        }
        else{
            $ideeSearch->setLocalisationObject($em->getRepository('JaiUneIdeeLocalisationBundle:Localisation')->findOneBy(array("niveau"=>0)));
            $ideeSearch->setWithChildrenLoc(true);
        }

        $repositoryManager = $this->get('fos_elastica.manager.orm');
        
        $theme = null;
        if(($request->get("theme")!==null) &&($request->get("theme")!="all")){
            $theme = $this->getDoctrine()->getManager()->getRepository('JaiUneIdeeSiteBundle:Theme')->find($request->get("theme"));
        }
        $withIdeesLues = false;
        if (true === $this->get('security.context')->isGranted('ROLE_USER')){
            $withIdeesLues = true;
        }

        $repository = $repositoryManager->getRepository('JaiUneIdeeSiteBundle:Idee');
//        $results = $repository->searchES($ideeSearch);
//        print_r($results);
//        exit;
//        $index = $this->get('fos_elastica.index.jaiuneidee');
//        $adapter = new ElasticaAdapter($index, $repository->searchQuery($ideeSearch));
        
        //$adapter = new DoctrineORMAdapter($qb);
//        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta = $repository->findRawPaginated($repository->searchQuery($ideeSearch));
        try {
            $pagerfanta->setMaxPerPage(10);
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
            if(isset($votesForIdees[$idee['id']])){
                $votes[$idee['id']] = $votesForIdees[$idee['id']];
            }
            else{
                $votes[$idee['id']] = array();
            }
            if(!isset($votes[$idee['id']]["1"])){
                    $votes[$idee['id']]["1"] = 0;
            }
            if(!isset($votes[$idee['id']]["0"])){
                    $votes[$idee['id']]["0"] = 0;
            }
            if(!isset($votes[$idee['id']]["-1"])){
                    $votes[$idee['id']]["-1"] = 0;
            }
            $votes[$idee['id']]["max"] = max($votes[$idee['id']]);
            $votes[$idee['id']]["total"] = $votes[$idee['id']]["1"] + $votes[$idee['id']]["-1"] + $votes[$idee['id']]["0"];
            if($votes[$idee['id']]["total"]>0){
                    $votes[$idee['id']]["pourcent_1"] = round($votes[$idee['id']]["1"]*100/$votes[$idee['id']]["total"],2);
                    $votes[$idee['id']]["pourcent_-1"] = round($votes[$idee['id']]["-1"]*100/$votes[$idee['id']]["total"],2);
                    $votes[$idee['id']]["pourcent_0"] = round($votes[$idee['id']]["0"]*100/$votes[$idee['id']]["total"],2);
            }
            else{
                    $votes[$idee['id']]["pourcent_1"] = 0;
                    $votes[$idee['id']]["pourcent_-1"] = 0;
                    $votes[$idee['id']]["pourcent_0"] = 0;
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
        $options_pager['routeName'] = $options_pager_news['routeName'] = "JaiUneIdeeSiteBundle_homepage";
        $options_pager['routeParams'] = Array("page"=>$page, "page_news"=>$page_news, "type" => "listeidee");
        $options_pager_news['routeParams'] = Array("page"=>$page, "page_news"=>$page_news, "type" => "listenews");
        $options_pager_news['pageParameter'] = '[page_news]';
        if( $this->getRequest()->isXMLHttpRequest()){
            if($type == "listenews"){
                $template = 'listeNews.html.twig';
            }
            else{
                $template = 'listeIdees.html.twig';
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