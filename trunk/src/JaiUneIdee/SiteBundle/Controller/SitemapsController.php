<?php
namespace JaiUneIdee\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use\DateTime;
class SitemapsController extends Controller
{

    /**
     * @Template("JaiUneIdeeSiteBundle:Sitemaps:sitemap.xml.twig")
     */
    public function sitemapAction() 
    {
        $em = $this->getDoctrine()->getManager();
        
        $urls = array();
        $hostname = $this->getRequest()->getHost();

        // add some urls homepage
        $pages_fixes = array(
            'JaiUneIdeeSiteBundle_homepage',
            'JaiUneIdeeSiteBundle_charte',
            'JaiUneIdeeSiteBundle_contact',
        );
        foreach($pages_fixes as $route){
            $urls[] = array('loc' => $this->get('router')->generate($route,array(), true), 'changefreq' => 'weekly', 'priority' => '1.0');
       }
        // multi-lang pages
        /*foreach($languages as $lang) {
            $urls[] = array('loc' => $this->get('router')->generate('JaiUneIdeeSiteBundle_contact', array('_locale' => $lang)), 'changefreq' => 'monthly', 'priority' => '0.3');
        }*/
        
        // urls from database
        //$urls[] = array('loc' => $this->get('router')->generate('home_product_overview', array('_locale' => 'en')), 'changefreq' => 'weekly', 'priority' => '0.7');
        // service
        // 
        // 
        // 
        // 
       //select idee, max(c.created_at)
       
       
       
        
        $localisation = $em->getRepository('JaiUneIdeeLocalisationBundle:Localisation')->findOneBy(array("nom"=>"France"));
        $withLocChildren = true;
        $options = array(
            'localisation'=> $localisation,
            'withLocChildren'=> $withLocChildren,
            'typeTri'=> "derniereActivite",
            'limit'=> null
        );
        $idees = $em->getRepository('JaiUneIdeeSiteBundle:Idee')->getIdeesWithParam($options);
        foreach ($idees as $idee) {
            $dt = DateTime::createFromFormat ("Y-m-d H:i:s" , $idee['derniere_activite']);
            $urls[] = array('loc' => $this->get('router')->generate('JaiUneIdeeSiteBundle_idee_show', array('id' => $idee[0]->getId(),'slug' => $idee[0]->getSlug()),true), 'changefreq' => 'daily','lastmod'=>$dt->format(DateTime::W3C),'priority'=>0.5);
        }
        $users = $em->getRepository('JaiUneIdeeUtilisateurBundle:User')->findAll();
        foreach ($users as $user) {
            $urls[] = array('loc' => $this->get('router')->generate('user_profile', array('user_id' => $user->getId(),'username' => $user->getUsername()),true), 'changefreq' => 'weekly','priority'=>0.2);
        }

        return array('urls' => $urls, 'hostname' => $hostname);
    }
}