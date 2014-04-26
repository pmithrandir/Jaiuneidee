<?php

namespace JaiUneIdee\UtilisateurBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use JaiUneIdee\UtilisateurBundle\Entity\Invitation;
use JaiUneIdee\UtilisateurBundle\Form\InvitationType;

/**
 * Invitation controller.
 *
 */
class InvitationController extends Controller
{
    /**
     * Lists all Invitation entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('JaiUneIdeeUtilisateurBundle:Invitation')->getInvitationsByUser($this->get('security.context')->getToken()->getUser());
        return $this->render('JaiUneIdeeUtilisateurBundle:Invitation:index.html.twig', array(
            'entities' => $entities,
        ));
    }


    /**
     * Displays a form to create a new Invitation entity.
     *
     */
    public function newAction()
    {
        $entity = new Invitation();
        $form   = $this->createForm(new InvitationType(), $entity);

        return $this->render('JaiUneIdeeUtilisateurBundle:Invitation:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new Invitation entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Invitation();
        $form = $this->createForm(new InvitationType(), $entity);
        $form->bind($request);
        $entity->setInviteur($this->get('security.context')->getToken()->getUser());
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
			$sent = $this->get('jai_une_idee_site.mailer')->sendInvitationMessage($entity->getEmail(),$entity->getId(), $entity);
			if($sent>0){
				$entity->setSent(true);
			}
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('notice', 'L\'invitation a été envoyée. Merci!');
            return $this->redirect($this->generateUrl('invitation'));
        }

        return $this->render('JaiUneIdeeUtilisateurBundle:Invitation:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
}
