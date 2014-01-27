<?php

namespace JaiUneIdee\LocalisationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class LocalisationController extends Controller
{
    public function localisationListAction(){
        $request = $this->getRequest();
    	if (null !== $request->getQueryString()) {
		$param = $request->get('q');
	        $em = $this->getDoctrine()->getEntityManager();
	    	$localisations = $em->getRepository('JaiUneIdeeLocalisationBundle:Localisation')->getListe($param);
		}
    	$response = new Response(json_encode($localisations));
		$response->headers->set('Content-Type', 'application/json');
		return $response;
    }
}
