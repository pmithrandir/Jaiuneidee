<?php

namespace JaiUneIdee\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JaiUneIdee\SiteBundle\Entity\Idee;
use JaiUneIdee\SiteBundle\Entity\Vote;
use JaiUneIdee\SiteBundle\Form\VoteType;

/**
 * Vote controller.
 */
class VoteController extends Controller
{
    public function voteAction($idee_id, $note)
    {
        $em = $this->getDoctrine()->getEntityManager();
        if (true === $this->get('security.context')->isGranted('ROLE_USER')) {
	        $user = $this->get('security.context')->getToken()->getUser();
	        $idee = $em->getRepository('JaiUneIdeeSiteBundle:Idee')->find($idee_id);
	        if (!$idee) {
	            throw $this->createNotFoundException('Unable to find Idee.');
	        }
		$voteExistant = $em->getRepository('JaiUneIdeeSiteBundle:Vote')->getVotesByIdeeAndUser($idee, $user);
	    	if(!$voteExistant ){
		    	$vote = new Vote();
		    	$vote->setIdee($idee);
		    	$vote->setUser($user);
		    	switch ($note){
		    		case 1:
		    		case -1:
		    		case 0:
		    			$vote->setNote($note);
		    		break;
		    		default:
		    			throw $this->createNotFoundException('Invalid Value.');
		    		break;
		    	}
		    	
		        $em->persist($vote);
		        $em->flush();
	    	}
	    	else{
	    		throw $this->createNotFoundException('Vous avez déjà voté pour cette idée.');
	    	}
	        return $this->redirect($this->generateUrl('JaiUneIdeeSiteBundle_idee_show', array(
	            'id' => $idee_id ,
	            'slug' => $vote->getIdee()->getSlug()))
	        );
        }
    }
    
    public function cancelVoteAction($idee_id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        if (true === $this->get('security.context')->isGranted('ROLE_USER')) {
            $user = $this->get('security.context')->getToken()->getUser();
            $idee = $em->getRepository('JaiUneIdeeSiteBundle:Idee')->find($idee_id);
            if (!$idee) {
                throw $this->createNotFoundException('Unable to find Idee.');
            }
            $voteExistant = $em->getRepository('JaiUneIdeeSiteBundle:Vote')->getVotesByIdeeAndUser($idee, $user);
            if($voteExistant ){
                $voteExistant->setIsRemoved(true);
                $em->persist($voteExistant);
                $em->flush();
            }
            return $this->redirect($this->generateUrl('JaiUneIdeeSiteBundle_idee_show', array(
            'id' => $idee_id ,
            'slug' => $idee->getSlug()))
        );
        }
       
    }
}
