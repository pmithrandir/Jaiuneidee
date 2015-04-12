<?php
namespace JaiUneIdee\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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

        $index = $this->get('fos_elastica.index.jaiuneidee');
        $idees = $index->search();
        foreach ($idees as $idee) {
            $urls[] = array('loc' => $this->get('router')->generate('JaiUneIdeeSiteBundle_idee_show', array('id' => $idee->getId(),'slug' => $idee->getSource()['slug']),true), 'changefreq' => 'daily','lastmod'=>$idee->getSource()['lastAction'],'priority'=>0.5);
        }
        $users = $em->getRepository('JaiUneIdeeUtilisateurBundle:User')->findAll();
        foreach ($users as $user) {
            $urls[] = array('loc' => $this->get('router')->generate('user_profile', array('user_id' => $user->getId(),'username' => $user->getUsername()),true), 'changefreq' => 'weekly','priority'=>0.2);
        }

        return array('urls' => $urls, 'hostname' => $hostname);
    }
}