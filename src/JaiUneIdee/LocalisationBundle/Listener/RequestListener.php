<?php

namespace JaiUneIdee\LocalisationBundle\Listener;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
class RequestListener {
    protected $em;
    protected $base_site;

    public function __construct(EntityManager $entity_manager, $base_site) {
        $this->em = $entity_manager;
        $this->base_site = $base_site ;
        
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event) {
        /** @var \Symfony\Component\HttpFoundation\Request $request */
        $request = $event->getRequest();
        $host = $request->getHost();
        $localisation = str_replace(".","",str_replace($this->base_site,"",$host));
        
        /** @var \Symfony\Component\HttpFoundation\Session\Session $session */
        $session = $request->getSession();

        //localisation
        //localisation_id
        //
        //site principal
        if ("www" === $localisation){
            if($session->get('localisation') !== null){
                $session->set('localisation', null);
                $session->set('localisation_name', null);
                $session->set('localisation_id', null);
            }
        }
        //site d'une ville
        else if ((null !== $localisation)&&($localisation!= $session->get('localisation'))){
            //trouver le nouveaulocalisation_id
            //si localisation_id trouvé
            
            $localisation_object = $this->em->getRepository('JaiUneIdeeLocalisationBundle:Localisation')->findOneBy(array("urlName"=>strtolower($localisation)));
            if($localisation_object !== null){
                $session->set('localisation', $localisation_object->getUrlName());
                $session->set('localisation_name', $localisation_object->getNom());
                $session->set('localisation_id', $localisation_object->getId());
            }
            else{
                $session->set('localisation', null);
                $session->set('localisation_name', null);
                $session->set('localisation_id', null);
                $url = str_replace($localisation,"www",$request->getSchemeAndHttpHost()).$request->getBaseUrl();
                $event->setResponse(new RedirectResponse($url));
            }
        }
        
    }

}
