<?php

namespace JaiUneIdee\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use JaiUneIdee\SiteBundle\Entity\ActionElu;
use \DateTime;


/**
 * Idee controller.
 */
class EluController extends Controller
{
    public function actionAction($type, $idee_id){
        $em = $this->getDoctrine()->getEntityManager();
        $idee = $em->getRepository('JaiUneIdeeSiteBundle:Idee')->find($idee_id);
	$user = $this->get('security.context')->getToken()->getUser();
        $action = $em->getRepository('JaiUneIdeeSiteBundle:ActionElu')->findOneBy(array('idee' => $idee, 'user' => $user));
        if(!$action ){
                $action = new ActionElu();
                $action->setIdee($idee);
                $action->setUser($user);
        }
        switch ($type){
            case "jaime":
                if (true === $this->get('security.context')->isGranted('ROLE_CANDIDAT')) {
                    $action->setJaime(true);
                    $action->setDateJaime(new DateTime());

                }
                break;
            case "jenaimepas":
                if (true === $this->get('security.context')->isGranted('ROLE_CANDIDAT')) {
                    $action->setJenaimepas(true);
                    $action->setDateJenaimepas(new DateTime());
                }
                break;
            case "jemengage":
                if (true === $this->get('security.context')->isGranted('ROLE_CANDIDAT')) {
                    $action->setJemengage(true);
                    $action->setDateJemengage(new DateTime());
                }
                break;
            case "jairealise";
                if (true === $this->get('security.context')->isGranted('ROLE_ELU')) {
                    $action->setJairealise(true);
                    $action->setDateJairealise(new DateTime());
                }
                break;
        }
        $em->persist($action);
        $em->flush();
	return $this->redirect($this->generateUrl('JaiUneIdeeSiteBundle_idee_show', array(
                'id' => $idee->getId() ,
                'slug' => $idee->getSlug()))
            );
    }
}