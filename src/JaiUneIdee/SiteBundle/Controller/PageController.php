<?php

namespace JaiUneIdee\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
// Import new namespaces
use JaiUneIdee\SiteBundle\Entity\Enquiry;
use JaiUneIdee\SiteBundle\Form\EnquiryType;
use JaiUneIdee\SiteBundle\Entity\Message;
use JaiUneIdee\SiteBundle\Form\MessageType;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

class PageController extends Controller
{
    public function indexAction($page = 1, $page_news = 1, $requester = "idee")
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getEntityManager();
        if ((true === $this->get('security.context')->isGranted('ROLE_USER'))&&($request->get("localisation")=="local")){
            $localisation = $this->get('security.context')->getToken()->getUser()->getLocalisation();
            $withLocChildren = true;
        }
        else if($request->get("localisation")=="national"){
            $localisation = $em->getRepository('JaiUneIdeeLocalisationBundle:Localisation')->findOneBy(array("nom"=>"France"));
            $withLocChildren = false;
        }
        else{
            $localisation = $em->getRepository('JaiUneIdeeLocalisationBundle:Localisation')->findOneBy(array("nom"=>"France"));
            $withLocChildren = true;
        }
        $liste_themes = $this->getDoctrine()->getEntityManager()->getRepository('JaiUneIdeeSiteBundle:Theme')->findAll();
        $theme = null;
        if(($request->get("theme")!==null) &&($request->get("theme")!="all")){
            $theme = $this->getDoctrine()->getEntityManager()->getRepository('JaiUneIdeeSiteBundle:Theme')->find($request->get("theme"));
        }
        $withIdeesLues = false;
        if (true === $this->get('security.context')->isGranted('ROLE_USER')){
            $withIdeesLues = true;
        }
        $typeTri = "derniereActivite";
        if($request->get("tri")=="nb_commentaire"){
            $typeTri = "Buzz"; 
        }
        else if($request->get("tri")=="derniereIdee"){
            $typeTri = "derniereIdee"; 
        }
        $options = array(
            'localisation'=> $localisation,
            'theme'=> $theme,
            'withLocChildren'=> $withLocChildren,
            'typeTri'=> $typeTri,
            'limit'=> null,
            'withIdeesLues'=> $withIdeesLues
        );
        $qb = $em->getRepository('JaiUneIdeeSiteBundle:Idee')->getIdeesWithParamQueryBuilder($options);
        
        $adapter = new DoctrineORMAdapter($qb);
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
            foreach($idees as $idee){
                $ideesLues[$idee[0]->getId()] = $em->getRepository('JaiUneIdeeSiteBundle:IdeeLue')->estLue($idee[0],$this->get('security.context')->getToken()->getUser()->getId());
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
        return $this->render('JaiUneIdeeSiteBundle:Page:'.$template, array(
            'idees' => $idees,
            'ideesLues'=>$ideesLues,
            'news' => $news,
            'pager' => $pagerfanta,
            'pager_news' => $pagerfanta_news,
            'page' => $page,
            'page_news' => $page_news,
            'theme_selected'=>($theme!==null)?$theme->getId():null,
            'themes'=>$liste_themes,
            'options_pager'=>$options_pager,
            'options_pager_news'=>$options_pager_news
        ));
    }
    public function ccmAction()
    {
        return $this->render('JaiUneIdeeSiteBundle:Page:ccm.html.twig');
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
                $em = $this->getDoctrine()->getEntityManager();
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
                $this->get('session')->setFlash('notice', 'Votre message a été envoyé aux administrateurs. Merci!');
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