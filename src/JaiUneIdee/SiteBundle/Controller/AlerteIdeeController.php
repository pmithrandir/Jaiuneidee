<?php

namespace JaiUneIdee\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JaiUneIdee\SiteBundle\Entity\AlerteIdee;

/**
 * Vote controller.
 */
class AlerteIdeeController extends Controller
{
    public function activerAction($idee_id)
    {
        $em = $this->getDoctrine()->getManager();
        if (true === $this->get('security.context')->isGranted('ROLE_USER')) {
	        $user = $this->get('security.context')->getToken()->getUser();
	        $idee = $em->getRepository('JaiUneIdeeSiteBundle:Idee')->find($idee_id);
	        if (!$idee) {
	            throw $this->createNotFoundException('Unable to find Idee.');
	        }
		$alerte = $em->getRepository('JaiUneIdeeSiteBundle:AlerteIdee')->getAlerteIdeeByIdeeAndUser($idee, $user);
                
	    	if(!$alerte ){
		    	$alerte = new AlerteIdee();
		    	$alerte->setIdee($idee);
		    	$alerte->setUser($user);
	    	}
		$alerte->setActivated(true);
                $em->persist($alerte);
                $em->flush();
                
	        return $this->redirect($this->generateUrl('JaiUneIdeeSiteBundle_idee_show', array(
	            'id' => $idee_id ,
	            'slug' => $idee->getSlug()))
	        );
        }
    }
    
    public function desactiverAction($idee_id)
    {
        $em = $this->getDoctrine()->getManager();
        if (true === $this->get('security.context')->isGranted('ROLE_USER')) {
	        $user = $this->get('security.context')->getToken()->getUser();
	        $idee = $em->getRepository('JaiUneIdeeSiteBundle:Idee')->find($idee_id);
	        if (!$idee) {
	            throw $this->createNotFoundException('Unable to find Idee.');
	        }
		$alerte = $em->getRepository('JaiUneIdeeSiteBundle:AlerteIdee')->getAlerteIdeeByIdeeAndUser($idee, $user);
		$alerte->setActivated(false);
                $em->persist($alerte);
                $em->flush();
                
	        return $this->redirect($this->generateUrl('JaiUneIdeeSiteBundle_idee_show', array(
	            'id' => $idee_id ,
	            'slug' => $idee->getSlug()))
	        );
        }
       
    }
}
