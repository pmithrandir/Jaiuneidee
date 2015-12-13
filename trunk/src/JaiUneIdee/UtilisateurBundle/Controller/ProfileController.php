<?php
namespace JaiUneIdee\UtilisateurBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Controller\ProfileController as BaseController;
use JaiUneIdee\LocalisationBundle\Entity\Localisation;
 

class ProfileController extends BaseController
{
    /**
     * Show the user
     */
    public function showAction()
    {
       return parent::showAction();
    }
    
    public function editAction()
    {
        //$response = parent::editAction();
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $form = $this->container->get('fos_user.profile.form');
        $formHandler = $this->container->get('fos_user.profile.form.handler');

        $process = $formHandler->process($user);
        if ($process) {
        	$this->setFlash('fos_user_success', 'profile.flash.updated');
            return new RedirectResponse($this->container->get('router')->generate('JaiUneIdeeSiteBundle_homepage'));
        }
        $reponse =  $this->container->get('templating')->renderResponse(
        	'FOSUserBundle:Profile:edit.html.'.$this->container->getParameter('fos_user.template.engine'),
        	array(
				'form' => $form->createView(), 
				'localisation' => $user->getLocalisation(),
				'localisation_recherchee' => $user->getLocalisationRecherchee(),
			)
        );
        return $reponse;
    }
    
}