<?php
namespace JaiUneIdee\UtilisateurBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JaiUneIdee\UtilisateurBundle\Form\AvatarType;
use JaiUneIdee\UtilisateurBundle\Entity\User;

/**
 * User controller.
 *
 */
class UserController extends Controller
{
	
	
    public function profileAction($user_id, $username){
    	$em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('JaiUneIdeeUtilisateurBundle:User')->find($user_id);
        $idees = $em->getRepository('JaiUneIdeeSiteBundle:Idee')->getIdeesByUser($user_id);
        if (!$user) {
            throw $this->createNotFoundException("Impossible de trouver l'utilisateur.");
        }
    	return $this->render('JaiUneIdeeUtilisateurBundle:User:profile.html.twig', array(
            'user' => $user,
            'idees' => $idees,
        ));
    }
    public function avatarAction(Request $request){
        $user = $this->get('security.context')->getToken()->getUser();
        $form = $this->createForm(new AvatarType(), $user);
        if ($request->isMethod('POST')) {
            $form->bind($request);
            if($form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
            }
            else{
                $user->setAvatar(null);
            }
        }
    	return $this->render('JaiUneIdeeUtilisateurBundle:User:avatar.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }
    
    public function supprimerAvatarAction(Request $request){
        $user = $this->get('security.context')->getToken()->getUser();
        $form = $this->createForm(new AvatarType(), $user);
        $em = $this->getDoctrine()->getManager();
        $user->removeImage();
        $user->setAvatar(null);
        $em->persist($user);
        $em->flush();
    	return $this->render('JaiUneIdeeUtilisateurBundle:User:avatar.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }
    
}